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
            
        return view('aps.traitements', compact(
            'traitements',
            'totalTraitements',
            'traitementsActifs',
            'traitementsCompletes',
            'tauxAdherence'
        ));
    }

    public function create()
    {
        $patients = Patient::where('aps_id', Auth::id())->get();
        return view('aps.traitements.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nom_medicament' => 'required|string|max:255',
            'posologie' => 'required|string',
            'duree' => 'required|integer|min:1',
            'date_debut' => 'required|date',
            'instructions' => 'nullable|string'
        ]);

        $traitement = new Traitement($validated);
        $traitement->statut = 'active';
        $traitement->date_fin = Carbon::parse($validated['date_debut'])->addDays($validated['duree']);
        $traitement->save();

        return redirect()->route('aps.traitements.index')
            ->with('success', 'Traitement créé avec succès');
    }

    public function edit(Traitement $traitement)
    {
        $this->authorize('update', $traitement);
        $patients = Patient::where('aps_id', Auth::id())->get();
        return view('aps.traitements.edit', compact('traitement', 'patients'));
    }

    public function update(Request $request, Traitement $traitement)
    {
        $this->authorize('update', $traitement);
        
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'nom_medicament' => 'required|string|max:255',
            'posologie' => 'required|string',
            'duree' => 'required|integer|min:1',
            'date_debut' => 'required|date',
            'instructions' => 'nullable|string',
            'statut' => 'required|in:active,completed,stopped'
        ]);

        $traitement->fill($validated);
        $traitement->date_fin = Carbon::parse($validated['date_debut'])->addDays($validated['duree']);
        $traitement->save();

        return redirect()->route('aps.traitements.index')
            ->with('success', 'Traitement mis à jour avec succès');
    }

    public function destroy(Traitement $traitement)
    {
        $this->authorize('delete', $traitement);
        $traitement->delete();
        
        return redirect()->route('aps.traitements.index')
            ->with('success', 'Traitement supprimé avec succès');
    }
}