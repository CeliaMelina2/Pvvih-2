<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\DossierMedical;

class DossierMedicalController extends Controller
{
    /**
     * Affiche la page du dossier médical.
     */
    public function index()
    {
        $patient = Auth::user()->patient;

        // Informations de base du patient
        $patientInfo = Patient::with('aps')->findOrFail($patient->id);

        // Historique des bilans et consultations
        $bilans = DossierMedical::where('patient_id', $patient->id)
                                ->orderBy('date_consultation', 'desc')
                                ->get();

        // Pour la démonstration, les informations de santé sont directement tirées du modèle Patient
        return view('patient.dossier', compact('patientInfo', 'bilans'));
    }
}