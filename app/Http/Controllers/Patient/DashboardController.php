<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\RendezVous;
use App\Models\Traitement;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Vérifier si l'utilisateur a un profil patient
        $patient = $user->patient;

        if (!$patient) {
            // Gérer le cas où le profil patient n'existe pas.
            return redirect('/')->with('error', 'Votre profil patient n\'a pas été trouvé. Veuillez contacter le support.');
        }
        
        // Données pour le tableau de bord
        $prochainRendezVous = RendezVous::where('patient_id', $patient->id)
            ->where('date_heure', '>', Carbon::now())
            ->orderBy('date_heure', 'asc')
            ->first();

        $traitements = Traitement::where('patient_id', $patient->id)->get();

        // Calcul des doses manquées et de la fidélité
        $dosesManquees = 0; // Logique complexe à implémenter
        $fidelite = 95; // Valeur statique pour l'exemple

        return view('patient.dashboard', compact('prochainRendezVous', 'traitements', 'dosesManquees', 'fidelite'));
    }
}