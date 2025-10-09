<?php

namespace App\Http\Controllers;

use App\Models\Aps;
use App\Models\Patient;

use Illuminate\Http\Request;

class ApsAdminController extends Controller
{
    public function index()
    {
        $apss = Aps::withCount([ 'rendez_vous'])
            ->latest()
            ->paginate(10);

        $totalAps = Aps::count();
        $actifsCount = Aps::where('statut', 'actif')->count();
        $inactifsCount = Aps::where('statut', 'inactif')->count();
        $bannisCount = Aps::where('statut', 'banni')->count();
        $avecPatientsCount = Patient::count();

        return view('admin.aps', compact(
            'apss',
            'totalAps',
            'actifsCount',
            'inactifsCount',
            'bannisCount',
            'avecPatientsCount',
        ));
    }

    public function toggleBan(Aps $aps)
    {
        $aps->update([
            'statut' => $aps->statut === 'banni' ? 'actif' : 'banni'
        ]);

        $action = $aps->statut === 'banni' ? 'banni' : 'débanni';
        return redirect()->back()->with('success', "Professionnel APS {$action} avec succès !");
    }
}