<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Traitement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'sexe' => 'required|string',
            'telephone' => 'required|string',
            'adresse' => 'nullable|string',
            'statut_serologique' => 'nullable|string',
            'attestation' => 'nullable|string',
            'date_diagnostic' => 'nullable|date',
            'codeTARV' => 'nullable|string',
        ]);

        Patient::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'password' => Hash::make($request->nom),
            'sexe' => $request->sexe,
            'telephone' => $request->telephone,
            'adresse' => $request->adresse,
            'statut_serologique' => $request->statut_serologique,
            'attestation' => $request->attestation,
            'date_diagnostic' => $request->date_diagnostic,
            'codeTARV' => $request->codeTARV,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('aps.patients.index')->with('success', 'Patient ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|string',
            'telephone' => 'required|string',
            'adresse' => 'nullable|string',
            'statut_serologique' => 'nullable|string',
            'attestation' => 'nullable|string',
            'date_diagnostic' => 'nullable|date',
            'codeTARV' => 'nullable|string',
        ]);

        $data = $request->all();
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $patient->update($data);

        return redirect()->route('aps.patients.index')->with('success', 'Patient mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('aps.patients.index')->with('success', 'Patient supprimé avec succès.');
    }

    public function assignTraitement(Request $request, $id)
    {
        $request->validate([
            'nom_medicament' => 'required|string',
            'posologie' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date',
            'frequence' => 'required|string',
        ]);

        Traitement::create([
            'patient_id' => $id,
            'nom_medicament' => $request->nom_medicament,
            'posologie' => $request->posologie,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'frequence' => $request->frequence,
        ]);

        return redirect()->route('aps.patients.index')->with('success', 'Traitement assigné avec succès.');
    }
}
