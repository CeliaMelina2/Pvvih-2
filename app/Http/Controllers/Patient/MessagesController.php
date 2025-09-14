<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;

class MessagesController extends Controller
{
    /**
     * Affiche la liste des discussions et le contenu d'une discussion.
     */
    public function index()
    {
        $user = Auth::user();

        // Récupérer les ID des contacts avec qui le patient a échangé
        $contactsIds = Message::where('sender_id', $user->id)
                                ->orWhere('receiver_id', $user->id)
                                ->pluck('sender_id', 'receiver_id')
                                ->flatten()
                                ->unique()
                                ->filter(function ($id) use ($user) {
                                    return $id !== $user->id;
                                });
        
        // Charger les contacts
        $contacts = User::whereIn('id', $contactsIds)->get();

        // Récupérer les messages pour un contact par défaut (le premier de la liste)
        $selectedContact = $contacts->first();
        $messages = collect();

        if ($selectedContact) {
            $messages = Message::where(function ($query) use ($user, $selectedContact) {
                                    $query->where('sender_id', $user->id)
                                          ->where('receiver_id', $selectedContact->id);
                                })
                                ->orWhere(function ($query) use ($user, $selectedContact) {
                                    $query->where('sender_id', $selectedContact->id)
                                          ->where('receiver_id', $user->id);
                                })
                                ->orderBy('created_at', 'asc')
                                ->get();
        }

        return view('patient.message', compact('contacts', 'selectedContact', 'messages'));
    }

    /**
     * Enregistre un nouveau message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'contenu' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'contenu' => $request->contenu,
        ]);

        return back()->with('success', 'Message envoyé avec succès !');
    }
}