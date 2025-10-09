<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Traitement;
use App\Models\Patient;
use Carbon\Carbon;

class TraitementApsController extends Controller
{
    public function index()
    {
        $aps = Auth::user();
        $patients = Patient::where('aps_id', $aps->id)->get();
        $traitements = Traitement::with(['patient'])
            ->whereHas('patient', function($query) use ($aps) {
                $query->where('aps_id', $aps->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiques
        $totalTraitements = $traitements->count();
        $traitementsActifs = $traitements->where('statut', 'active')->count();
        $traitementsCompletes = $traitements->where('statut', 'completed')->count();
        $tauxAdherence = $traitements->count() > 0 
            ? round(($traitementsActifs + $traitementsCompletes) / $totalTraitements * 100) 
            : 0;
            
        return view('aps.dashboard', compact(
            'patients',
            'traitements',
            'totalTraitements',
            'traitementsActifs',
            'traitementsCompletes',
            'tauxAdherence'
        ));
    }

    // Duplicate methods removed. Only one set of create, store, edit, update, destroy should remain.

    public function create()
    {
        $aps = Auth::user()->aps;
        $patients = Patient::where('aps_id', $aps->id)->get();
        return view('aps.traitements.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicament' => 'required|string|max:255',
            'posologie' => 'required|string|max:500',
            'duree' => 'required|string|max:100',
            'instructions' => 'nullable|string',
        ]);

        Traitement::create($request->all());

        return redirect()->route('aps.traitements.index')
            ->with('success', 'Traitement créé avec succès');
    }

    public function edit(Traitement $traitement)
    {
        $aps = Auth::user()->aps;
        $patients = Patient::where('aps_id', $aps->id)->get();
        return view('aps.traitements.edit', compact('traitement', 'patients'));
    }

    public function update(Request $request, Traitement $traitement)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'medicament' => 'required|string|max:255',
            'posologie' => 'required|string|max:500',
            'duree' => 'required|string|max:100',
            'instructions' => 'nullable|string',
        ]);

        $traitement->update($request->all());

        return redirect()->route('aps.traitements.index')
            ->with('success', 'Traitement mis à jour avec succès');
    }

    public function destroy(Traitement $traitement)
    {
        $traitement->delete();
        return redirect()->route('aps.traitements.index')
            ->with('success', 'Traitement supprimé avec succès');
    }
}