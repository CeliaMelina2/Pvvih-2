<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use Carbon\Carbon;

class RendezVousController extends Controller
{
    public function index()
    {
        $patient = Auth::user()->patient;

        // Statistiques des rendez-vous
        $upcomingCount = RendezVous::where('patient_id', $patient->id)
            ->where('date_heure', '>', Carbon::now())
            ->count();
        $pastCount = RendezVous::where('patient_id', $patient->id)
            ->where('date_heure', '<', Carbon::now())
            ->count();
        $canceledCount = RendezVous::where('patient_id', $patient->id)
            ->where('statut', 'Annulé')
            ->count();
        $assiduite = ($pastCount > 0) ? round(($pastCount / ($pastCount + $canceledCount)) * 100) : 100;

        // Liste des rendez-vous
        $upcoming = RendezVous::where('patient_id', $patient->id)
            ->where('date_heure', '>', Carbon::now())
            ->orderBy('date_heure', 'asc')
            ->get();
        $past = RendezVous::where('patient_id', $patient->id)
            ->where('date_heure', '<', Carbon::now())
            ->orderBy('date_heure', 'desc')
            ->get();

        return view('patient.rendezvous', compact('upcomingCount', 'pastCount', 'canceledCount', 'assiduite', 'upcoming', 'past'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'medecin_nom' => 'required|string',
            'date_heure' => 'required|date',
            'motif' => 'required|string',
        ]);

        RendezVous::create([
            'patient_id' => Auth::user()->patient->id,
            'medecin_nom' => $request->medecin_nom,
            'date_heure' => $request->date_heure,
            'motif' => $request->motif,
            'statut' => 'En attente',
        ]);

        return redirect()->route('patient.rendezvous')->with('success', 'Rendez-vous demandé avec succès !');
    }

    public function cancel($id)
    {
        $rendezvous = RendezVous::where('id', $id)->where('patient_id', Auth::user()->patient->id)->firstOrFail();
        $rendezvous->statut = 'Annulé';
        $rendezvous->save();

        return redirect()->route('patient.rendezvous')->with('success', 'Rendez-vous annulé avec succès.');
    }
}