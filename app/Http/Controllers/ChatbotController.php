<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatConversation;
use App\Models\ChatMessage;
use App\Models\Patient; // ajout
use Carbon\Carbon; // ajout

class ChatbotController extends Controller
{
    /**
     * Affiche la vue de l'assistant avec les conversations récentes.
     */
    public function view()
    {
        // Charger les conversations de l'utilisateur
        $conversations = ChatConversation::where('user_id', Auth::id())
            ->latest('updated_at')
            ->take(20)
            ->get();
        return view('assistant', compact('conversations'));
    }

    /**
     * Reçoit un message, gère la conversation et retourne la réponse de l'IA.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:1',
            'conversation_id' => 'nullable|integer|exists:chat_conversations,id',
        ]);

        $userId = (int) Auth::id();

        /** @var ChatConversation $conversation */
        $conversation = $this->findOrCreateConversation($request, $userId);
        /** @var ChatMessage $userMessage */
        $userMessage = $this->saveUserMessage($conversation, $userId, (string) $request->string('message'));
        $context = $this->buildContext($userId);

        $payload = [
            'message' => (string) $request->string('message'),
            'user_id' => $userId,
            'conversation_id' => (string) $conversation->id,
            'context' => $context,
        ];

        $answer = $this->callAiService($payload);

        // Enregistrer la réponse IA
        ChatMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => null,
            'is_from_user' => false,
            'message' => $userMessage->message,
            'response' => $answer,
        ]);

        $conversation->touch();

        return response()->json([
            'response' => $answer,
            'conversation_id' => $conversation->id,
        ]);
    }

    /**
     * Trouve ou crée une conversation pour l'utilisateur.
     *
     * @param Request $request
     * @param int $userId
     * @return ChatConversation
     */
    private function findOrCreateConversation(Request $request, int $userId): ChatConversation
    {
        if ($request->filled('conversation_id')) {
            return ChatConversation::where('user_id', $userId)
                ->findOrFail((int) $request->input('conversation_id'));
        }

        return ChatConversation::create([
            'user_id' => $userId,
            'title' => str($request->string('message'))->limit(60),
        ]);
    }

    /**
     * Sauvegarde le message utilisateur en base.
     *
     * @param ChatConversation $conversation
     * @param int $userId
     * @param string $message
     * @return ChatMessage
     */
    private function saveUserMessage(ChatConversation $conversation, int $userId, string $message): ChatMessage
    {
        /** @var ChatMessage $message */
        $message = ChatMessage::create([
            'conversation_id' => $conversation->id,
            'user_id' => $userId,
            'is_from_user' => true,
            'message' => $message,
        ]);
        
        return $message;
    }

    /**
     * Construit le contexte patient à envoyer au service IA.
     *
     * @param int $userId
     * @return array<string, mixed>
     */
    private function buildContext(int $userId): array
    {
        $context = [
            'user_role' => optional(Auth::user())->role,
            'locale' => app()->getLocale(),
        ];

        $patient = Patient::with([
            'rendezvous' => function ($q) {
                $q->where('date_heure', '>=', now())
                  ->orderBy('date_heure', 'asc')
                  ->limit(3);
            },
            'traitements' => function ($q) {
                $q->where(function ($qq) {
                    $qq->whereNull('date_fin_prevue')
                       ->orWhere('date_fin_prevue', '>=', now());
                });
            }
        ])->where('user_id', $userId)->first();

        if (!$patient) {
            return $context;
        }

        $activeTreatments = $patient->traitements->map(function ($t) {
            return [
                'nom' => $t->nom_medicament,
                'posologie' => $t->posologie,
                'frequence' => $t->frequence,
                'date_debut' => $t->date_debut ? Carbon::parse($t->date_debut)->toDateString() : null,
                'date_fin_prevue' => $t->date_fin_prevue ? Carbon::parse($t->date_fin_prevue)->toDateString() : null,
            ];
        })->values();

        $upcomingAppointments = $patient->rendezvous->map(function ($r) {
            return [
                'date_heure' => $r->date_heure ? Carbon::parse($r->date_heure)->isoFormat('LLLL') : null,
                'motif' => $r->motif,
                'statut' => $r->statut,
                'medecin' => $r->medecin_nom,
            ];
        })->values();

        $parts = [];
        if ($patient->statut_serologique) {
            $parts[] = 'Statut sérologique: ' . $patient->statut_serologique;
        }
        if ($patient->codeTARV) {
            $parts[] = 'Code TARV: ' . $patient->codeTARV;
        }
        if ($activeTreatments->count()) {
            $tLines = $activeTreatments->map(function ($t) {
                return sprintf('- %s (%s, %s)', $t['nom'] ?? 'Traitement', $t['posologie'] ?? 'posologie inconnue', $t['frequence'] ?? 'fréquence inconnue');
            })->implode("\n");
            $parts[] = "Traitements actifs:\n" . $tLines;
        }
        if ($upcomingAppointments->count()) {
            $rLines = $upcomingAppointments->map(function ($r) {
                return sprintf('- %s (%s%s%s)',
                    $r['date_heure'] ?? 'Date à confirmer',
                    $r['motif'] ?? 'Motif non précisé',
                    $r['medecin'] ? ', Médecin: '.$r['medecin'] : '',
                    $r['statut'] ? ', Statut: '.$r['statut'] : ''
                );
            })->implode("\n");
            $parts[] = "Prochains rendez-vous:\n" . $rLines;
        }

        $context['patient'] = [
            'id' => $patient->id,
            'statut_serologique' => $patient->statut_serologique,
            'codeTARV' => $patient->codeTARV,
            'traitements_actifs' => $activeTreatments,
            'prochains_rendez_vous' => $upcomingAppointments,
            'summary' => implode("\n", $parts),
        ];

        return $context;
    }

    /**
     * Appelle l'API FastAPI et retourne la réponse texte.
     *
     * @param array<string, mixed> $payload
     * @return string
     */
    private function callAiService(array $payload): string
    {
        try {
            $baseUrl = config('services.ai.base_url');
            $response = Http::timeout(30)->post(rtrim($baseUrl, '/').'/chat', $payload);
            if (!$response->successful()) {
                Log::warning('AI service error', ['status' => $response->status(), 'body' => $response->body()]);
                return 'Le service IA est temporairement indisponible.';
            }
            return (string) data_get($response->json(), 'response');
        } catch (\Throwable $e) {
            Log::error('AI service exception', ['error' => $e->getMessage()]);
            return 'Désolé, je rencontre un problème technique. Veuillez réessayer.';
        }
    }

    public function getConversationMessages($id)
    {
        $conversation = ChatConversation::where('user_id', Auth::id())
            ->findOrFail($id);

        $messages = ChatMessage::where('conversation_id', $conversation->id)
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'conversation' => $conversation,
            'messages' => $messages
        ]);
    }

    public function renameConversation(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|min:1|max:255'
        ]);

        $conversation = ChatConversation::where('user_id', Auth::id())
            ->findOrFail($id);

        $conversation->update([
            'title' => $request->string('title')
        ]);

        return response()->json([
            'success' => true,
            'conversation' => $conversation
        ]);
    }

    public function deleteConversation($id)
    {
        $conversation = ChatConversation::where('user_id', Auth::id())
            ->findOrFail($id);

        // Supprimer les messages associés
        ChatMessage::where('conversation_id', $conversation->id)->delete();
        
        // Supprimer la conversation
        $conversation->delete();

        return response()->json([
            'success' => true
        ]);
    }
}
