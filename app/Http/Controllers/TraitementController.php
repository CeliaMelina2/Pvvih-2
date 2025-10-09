<?php

namespace App\Http\Controllers;

use App\Models\Traitement;
use App\Models\Patient;
use Illuminate\Http\Request;

class TraitementController extends Controller
{
   
    public function index()
    {
        $traitements = Traitement::with('patient')->latest()->get();
        $patients = Patient::all();

        return view('aps.traitements', compact('traitements', 'patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nom_medicament' => 'required|string',
            'posologie' => 'required|string',
            'frequence' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'required|date|after_or_equal:date_debut',
        ]);

        Traitement::create([
            'patient_id' => $request->patient_id,
            'nom_medicament' => $request->nom_medicament,
            'posologie' => $request->posologie,
            'frequence' => $request->frequence,
            'date_debut' => $request->date_debut,
            'date_fin_prevue' => $request->date_fin_prevue,
        ]);

        return redirect()->route('aps.traitements.index')->with('success', 'Traitement ajouté avec succès.');
    }

    public function update(Request $request, $id)
    {
        $traitement = Traitement::findOrFail($id);

        $request->validate([
            'nom_medicament' => 'required|string',
            'posologie' => 'required|string',
            'frequence' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'required|date|after_or_equal:date_debut',
        ]);

        $traitement->update($request->all());

        return redirect()->route('aps.traitements.index')->with('success', 'Traitement mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $traitement = Traitement::findOrFail($id);
        $traitement->delete();
        return redirect()->route('aps.traitements.index')->with('success', 'Traitement supprimé avec succès.');
    }

    public function toggleStatus($id)
    {
        $traitement = Traitement::findOrFail($id);
        $traitement->save();

        return redirect()->route('aps.traitements.index')->with('success', 'Statut du traitement mis à jour.');
    }
}
