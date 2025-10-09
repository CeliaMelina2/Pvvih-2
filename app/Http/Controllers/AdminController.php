<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Patient;
use App\Models\Aps;
use App\Models\RendezVous;
use App\Models\Traitement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_patients' => Patient::count(),
            'total_aps' => Aps::count(),
            'total_rendezvous' => RendezVous::count(),
            'total_traitements' => Traitement::count(),
            'rendezvous_today' => RendezVous::whereDate('date_heure', today())->count(),
        ];

        $recentUsers = User::latest()->take(5)->get();
        $recentRendezVous = RendezVous::with(['patient', 'aps'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentRendezVous'));
    }

    public function parametres()
    {
        return view('admin.parametres');
    }

    public function profil()
    {
        $user = Auth::user();
        return view('admin.profil', compact('user'));
    }
}