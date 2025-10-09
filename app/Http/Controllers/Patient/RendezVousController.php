<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use App\Models\Patient;

use App\Models\Aps;
use Carbon\Carbon;

class RendezVousController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;

        $apss = Aps::all();
        $upcomingCount = RendezVous::where('patient_id', $patient->id)
            ->where('date_heure', '>', Carbon::now())->count();

        $pastCount = RendezVous::where('patient_id', $patient->id)
            ->where('date_heure', '<', Carbon::now())->count();

        $canceledCount = RendezVous::where('patient_id', $patient->id)
            ->where('statut', 'Annulé')->count();

        $assiduite = ($pastCount + $canceledCount > 0)
            ? round(($pastCount / ($pastCount + $canceledCount)) * 100)
            : 100;

        $upcoming = RendezVous::with('aps')
            ->where('patient_id', $patient->id)
            ->where('date_heure', '>', Carbon::now())
            ->orderBy('date_heure', 'asc')
            ->get();

        $past = RendezVous::with('aps')
            ->where('patient_id', $patient->id)
            ->where('date_heure', '<', Carbon::now())
            ->orderBy('date_heure', 'desc')
            ->get();

        return view('patient.rendezvous', compact(
            'upcomingCount', 'pastCount', 'canceledCount', 'assiduite', 'upcoming', 'past', 'apss'
        ));
    }
        public function indexaps()
    {
        $rendezvous = RendezVous::with(['patient', 'aps'])
            ->orderBy('date_heure', 'desc')
            ->get();

        $stats = [
            'total' => $rendezvous->count(),
            'a_venir' => $rendezvous->where('date_heure', '>', Carbon::now())->where('statut', '!=', 'annulé')->count(),
            'termines' => $rendezvous->where('date_heure', '<', Carbon::now())->where('statut', 'terminé')->count(),
            'annules' => $rendezvous->where('statut', 'annulé')->count(),
            'en_attente' => $rendezvous->where('statut', 'en_attente')->count(),
        ];

        $patients = Patient::all();
        $apss = Aps::all();

        return view('aps.rendez_vous', compact('rendezvous', 'stats', 'patients', 'apss'));
    }


    public function store(Request $request)
    {
        \Log::info('Données reçues:', $request->all());
        \Log::info('Patient ID:', ['patient_id' => Auth::user()->patient->id]);
        
        $request->validate([
            'aps_id' => 'required|integer|exists:aps,id',
            'date_heure' => 'required|date|after:now',
            'motif' => 'required|string|max:500',
        ]);

        try {
            $rendezvous = RendezVous::create([
                'patient_id' => Auth::user()->patient->id,
                'aps_id' => $request->aps_id,
                'date_heure' => $request->date_heure,
                'motif' => $request->motif,
                'statut' => 'en_attente',
            ]);

            \Log::info('Rendez-vous créé:', $rendezvous->toArray());

            return redirect()->route('patient.rendezvous')->with('success', 'Rendez-vous demandé avec succès !');
        } catch (\Exception $e) {
            \Log::error('Erreur création rendez-vous:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erreur lors de la création du rendez-vous: ' . $e->getMessage())->withInput();
        }
    }
    public function storeaps(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'aps_id' => 'required|exists:aps,id',
            'date_heure' => 'required|date|after:now',
            'motif' => 'required|string|max:500',
            'type_rendezvous' => 'required|string|max:255',
            'duree' => 'required|integer|min:5|max:240',
        ]);

        RendezVous::create([
            'patient_id' => $request->patient_id,
            'aps_id' => $request->aps_id,
            'date_heure' => $request->date_heure,
            'motif' => $request->motif,
            'type_rendezvous' => $request->type_rendezvous,
            'duree' => $request->duree,
            'statut' => 'confirmé',
        ]);

        return redirect()->route('rendezvous.index')->with('success', 'Rendez-vous créé avec succès !');
    }

        public function update(Request $request, $id)
    {
        $rendezvous = RendezVous::findOrFail($id);

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'aps_id' => 'required|exists:aps,id',
            'date_heure' => 'required|date',
            'motif' => 'required|string|max:500',
            'type_rendezvous' => 'required|string|max:255',
            'duree' => 'required|integer|min:5|max:240',
            'statut' => 'required|in:en_attente,confirmé,terminé,annulé',
        ]);

        $rendezvous->update($request->all());

        return redirect()->route('aps.rendezvous.index')->with('success', 'Rendez-vous modifié avec succès !');
    }
    public function cancel($id)
    {
        $rendezvous = RendezVous::where('id', $id)
            ->where('patient_id', Auth::user()->patient->id)
            ->firstOrFail();

        $rendezvous->update(['statut' => 'Annulé']);

        return redirect()
            ->route('patient.rendezvous')
            ->with('success', 'Rendez-vous annulé avec succès.');
    }

        public function destroy($id)
    {
        $rendezvous = RendezVous::findOrFail($id);
        $rendezvous->delete();

        return redirect()->route('aps.rendezvous.index')->with('success', 'Rendez-vous supprimé avec succès !');
    }
        public function updateStatus(Request $request, $id)
    {
        $rendezvous = RendezVous::findOrFail($id);

        $request->validate([
            'statut' => 'required|in:en_attente,confirmé,terminé,annulé'
        ]);

        $rendezvous->update(['statut' => $request->statut]);

        return redirect()->route('aps.rendezvous.index')->with('success', 'Statut du rendez-vous mis à jour !');
    }
}

