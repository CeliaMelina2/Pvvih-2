<?php

namespace App\Http\Controllers;

use App\Models\Traitement;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TraitementAdminController extends Controller
{
    public function index()
    {
        $traitements = Traitement::with('patient')->latest()->paginate(10);
        $patients = Patient::all();

        $totalTraitements = Traitement::count();
        $actifsCount = Traitement::where('statut', 'actif')->count();
        $terminesCount = Traitement::where('statut', 'terminé')->count();
        $enRetardCount = Traitement::where('date_fin_prevue', '<', Carbon::now())
            ->where('statut', 'actif')
            ->count();

        return view('admin.traitements.index', compact(
            'traitements', 'patients', 'totalTraitements', 
            'actifsCount', 'terminesCount', 'enRetardCount'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nom_medicament' => 'required|string|max:255',
            'posologie' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'required|date|after:date_debut',
            'frequence' => 'required|string|max:255',
        ]);

        Traitement::create([
            'patient_id' => $request->patient_id,
            'nom_medicament' => $request->nom_medicament,
            'posologie' => $request->posologie,
            'date_debut' => $request->date_debut,
            'date_fin_prevue' => $request->date_fin_prevue,
            'frequence' => $request->frequence,
            'instructions' => $request->instructions,
            'statut' => 'actif',
        ]);

        return redirect()->route('admin.traitements.index')->with('success', 'Traitement créé avec succès !');
    }

    public function update(Request $request, Traitement $traitement)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nom_medicament' => 'required|string|max:255',
            'posologie' => 'required|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'required|date|after:date_debut',
            'frequence' => 'required|string|max:255',
            'statut' => 'required|in:actif,terminé,suspendu',
        ]);

        $traitement->update($request->all());

        return redirect()->route('admin.traitements.index')->with('success', 'Traitement modifié avec succès !');
    }

    public function destroy(Traitement $traitement)
    {
        $traitement->delete();
        return redirect()->route('admin.traitements.index')->with('success', 'Traitement supprimé avec succès !');
    }

    public function toggleStatus(Traitement $traitement)
    {
        $traitement->update([
            'statut' => $traitement->statut === 'actif' ? 'terminé' : 'actif'
        ]);

        return redirect()->back()->with('success', 'Statut du traitement mis à jour !');
    }
}