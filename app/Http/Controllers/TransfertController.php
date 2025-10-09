<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Transfert;
use App\Models\Patient;
use App\Models\Centre;
use App\Models\Aps;
use App\Models\DossierMedical;
use Carbon\Carbon;

class TransfertController extends Controller
{

    public function index()
    {
        $patient = Auth::user()->patient;
        $apss = Aps::all();
        $centres = Centre::all();

        $patientInfo = Patient::with('aps')->findOrFail($patient->id);

        $bilans = DossierMedical::where('patient_id', $patient->id)
                                ->orderBy('date_consultation', 'desc')
                                ->get();

        $transferts = Transfert::with(['centres', 'aps'])
                            ->where('patient_id', $patient->id)
                            ->orderBy('created_at', 'desc')
                            ->get();

        return view('patient.dossier', compact(
            'patientInfo', 
            'apss', 
            'centres', 
            'bilans',
            'transferts'
        ));   
    }

    public function store(Request $request)
    {
        \Log::info('Données reçues:', $request->all());
        
        $request->validate([
            'aps_id' => 'required|integer|exists:aps,id', 
            'centre_id' => 'required|integer|exists:centres,id',
            'date_heure' => 'required|date|after:now',
            'motif' => 'required|string|max:500',
            'dossier' => 'required|file|mimes:pdf|max:10240', 
        ]);

        try {
            if ($request->hasFile('dossier')) {
                $dossierFile = $request->file('dossier');
                $dossierPath = $dossierFile->store('transferts/dossiers', 'public');
            }

            $transfert = Transfert::create([
                'patient_id' => Auth::user()->patient->id,
                'aps_id' => $request->aps_id,
                'centre_id' => $request->centre_id,
                'date_heure' => $request->date_heure,
                'motif' => $request->motif,
                'dossier' => $dossierPath, 
                'statut' => 'en_attente',
            ]);

            \Log::info('Transfert créé:', $transfert->toArray());

            return redirect()->route('patient.dossier_medical')->with('success', 'Transfert demandé avec succès !');
        } catch (\Exception $e) {
            \Log::error('Erreur création transfert:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erreur lors de la création du transfert: ' . $e->getMessage())->withInput();
        }
    }

    public function cancel($id)
    {
        $transfert = Transfert::where('id', $id) 
            ->where('patient_id', Auth::user()->patient->id)
            ->firstOrFail();

        $transfert->update(['statut' => 'refuse']);

        return redirect()
            ->route('patient.dossier_medical') 
            ->with('success', 'Transfert annulé avec succès.');
    }

}