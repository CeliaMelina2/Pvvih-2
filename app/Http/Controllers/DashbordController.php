<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\RendezVous;
use App\Models\Traitement;
use App\Models\Aps;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer l'APS connecté
        $aps = Auth::user()->aps;
        
        if (!$aps) {
            return redirect()->route('login')->with('error', 'Profil APS non trouvé.');
        }

        // Statistiques principales
        $patientsCount = Patient::count();
        $upcomingAppointments = RendezVous::where('date_heure', '>', Carbon::now())
            ->where('statut', '!=', 'annulé')
            ->count();
        $unreadMessages = Message::where('statut', 'non_lu')->count();
        $criticalAlerts = Patient::whereHas('dossierMedical', function($query) {
            $query->where('niveau_urgence', 'critique');
        })->count();

        // Prochains rendez-vous (5 prochains)
        $nextAppointments = RendezVous::with('patient')
            ->where('date_heure', '>', Carbon::now())
            ->where('statut', '!=', 'annulé')
            ->orderBy('date_heure', 'asc')
            ->take(5)
            ->get();

        // Messages récents (5 derniers)
        $recentMessages = Message::with('patient')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Activité récente (rendez-vous des 7 derniers jours)
        $recentActivity = RendezVous::with('patient')
            ->where('date_heure', '>', Carbon::now()->subDays(7))
            ->where('statut', 'terminé')
            ->orderBy('date_heure', 'desc')
            ->take(5)
            ->get();

        // Patients avec alertes critiques
        $criticalPatients = Patient::whereHas('dossierMedical', function($query) {
            $query->where('niveau_urgence', 'critique');
        })
        ->with(['dossierMedical' => function($query) {
            $query->where('niveau_urgence', 'critique')
                  ->orderBy('created_at', 'desc')
                  ->take(1);
        }])
        ->take(5)
        ->get();

        return view('aps.dashboard', compact(
            'aps',
            'patientsCount',
            'upcomingAppointments',
            'unreadMessages',
            'criticalAlerts',
            'nextAppointments',
            'recentMessages',
            'recentActivity',
            'criticalPatients'
        ));
    }

    public function getStats()
    {
        // Statistiques pour les graphiques (optionnel)
        $monthlyAppointments = RendezVous::whereYear('date_heure', Carbon::now()->year)
            ->whereMonth('date_heure', Carbon::now()->month)
            ->count();

        $monthlyPatients = Patient::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->count();

        $appointmentsByStatus = RendezVous::select('statut', \DB::raw('count(*) as count'))
            ->groupBy('statut')
            ->get()
            ->pluck('count', 'statut');

        return response()->json([
            'monthly_appointments' => $monthlyAppointments,
            'monthly_patients' => $monthlyPatients,
            'appointments_by_status' => $appointmentsByStatus,
        ]);
    }
}