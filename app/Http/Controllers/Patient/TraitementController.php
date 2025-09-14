<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Traitement;
use Carbon\Carbon;

class TraitementController extends Controller
{
    /**
     * Affiche la liste des traitements du patient.
     */
    public function index()
    {
        $user = Auth::user();
        $patient = $user->patient;

        if (!$patient) {
            // Gérer le cas où le profil patient n'existe pas.
            return redirect('/')->with('error', 'Votre profil patient n\'a pas été trouvé.');
        }

        // Récupérer tous les traitements du patient, triés par date de début
        $traitements = Traitement::where('patient_id', $patient->id)
                                ->orderBy('date_debut', 'desc')
                                ->get();

        // Assurez-vous que le nom de la vue 'patient.traitements' correspond bien
        // au nom de votre fichier Blade dans le dossier resources/views/patient/
        return view('patient.traitement', compact('traitements'));
    }

    /**
     * Marque un traitement comme pris.
     */
    public function marquerPris($id)
    {
        // On cherche le traitement et on s'assure qu'il appartient bien au patient connecté
        $traitement = Traitement::where('id', $id)
                                ->where('patient_id', Auth::user()->patient->id)
                                ->firstOrFail();
        
        // Ici, on pourrait ajouter une logique pour enregistrer la prise du traitement
        
        return back()->with('success', 'Traitement marqué comme pris !');
    }
}
