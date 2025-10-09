<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Traitement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::with('traitements')->get();
        return view('aps.patients', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
        ]);

        try {
            Patient::create($request->all());
            return redirect()->route('patients.index')->with('success', 'Patient créé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la création du patient.');
        }
    }

    public function show($id)
    {
        $patient = Patient::with('traitements')->findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $id,
            'telephone' => 'required|string|max:20',
            'date_naissance' => 'required|date',
        ]);

        try {
            $patient->update($request->all());
            return redirect()->route('patients.index')->with('success', 'Patient modifié avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la modification du patient.');
        }
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            $patient->delete();
            return redirect()->route('patients.index')->with('success', 'Patient supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du patient.');
        }
    }

    public function storeTraitement(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicament' => 'required|string|max:255',
            'posologie' => 'required|string',
            'duree' => 'required|string|max:255',
        ]);

        try {
            Traitement::create($request->all());
            return redirect()->route('patients.index')->with('success', 'Traitement assigné avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de l\'assignation du traitement.');
        }
    }

    public function destroyTraitement($id)
    {
        try {
            $traitement = Traitement::findOrFail($id);
            $traitement->delete();
            return redirect()->back()->with('success', 'Traitement supprimé avec succès.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erreur lors de la suppression du traitement.');
        }
    }
}