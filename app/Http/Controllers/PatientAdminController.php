<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientAdminController extends Controller
{
    public function index()
    {
        $patients = Patient::withCount(['traitements', 'rendez_vous'])
            ->latest()
            ->paginate(10);

        $totalPatients = Patient::count();
        $actifsCount = Patient::where('statut', 'actif')->count();
        $inactifsCount = Patient::where('statut', 'inactif')->count();
        $bannisCount = Patient::where('statut', 'banni')->count();
        $avecTraitementCount = Patient::has('traitements')->count();
        $sansTraitementCount = Patient::doesntHave('traitements')->count();

        return view('admin.patients', compact(
            'patients', 
            'totalPatients',
            'actifsCount',
            'inactifsCount', 
            'bannisCount',
            'avecTraitementCount',
            'sansTraitementCount'
        ));
    }

    public function toggleBan(Patient $patient)
    {
        $patient->update([
            'statut' => $patient->statut === 'banni' ? 'actif' : 'banni'
        ]);

        $action = $patient->statut === 'banni' ? 'banni' : 'débanni';
        return redirect()->back()->with('success', "Patient {$action} avec succès !");
    }
}