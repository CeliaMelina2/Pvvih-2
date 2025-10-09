@extends('layouts.layout')

@section('content')
<style>
    .dashboard-bg { background: #f8f9fa !important; }
    .stat-card { 
        background: white; 
        border-radius: 15px; 
        padding: 1.5rem; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-left: 4px solid #343a40;
    }
    .stat-number { 
        font-size: 2.5rem; 
        font-weight: 700; 
        color: #343a40; 
    }
    .stat-label { 
        color: #6c757d; 
        font-size: 0.9rem; 
        text-transform: uppercase; 
        font-weight: 600; 
    }
    .stat-icon { 
        font-size: 2rem; 
        color: #343a40; 
        margin-bottom: 1rem; 
    }
</style>

<div class="container-fluid dashboard-bg py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-dark">Tableau de bord Administrateur</h1>
        <div class="text-muted">Bienvenue, {{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-number">{{ $stats['total_users'] }}</div>
                <div class="stat-label">Utilisateurs</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-person-vcard"></i>
                </div>
                <div class="stat-number">{{ $stats['total_patients'] }}</div>
                <div class="stat-label">Patients</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-heart-pulse"></i>
                </div>
                <div class="stat-number">{{ $stats['total_aps'] }}</div>
                <div class="stat-label">APS</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-number">{{ $stats['total_rendezvous'] }}</div>
                <div class="stat-label">Rendez-vous</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-capsule-pill"></i>
                </div>
                <div class="stat-number">{{ $stats['total_traitements'] }}</div>
                <div class="stat-label">Traitements</div>
            </div>
        </div>
        <div class="col-xl-2 col-md-4 col-6">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-calendar-day"></i>
                </div>
                <div class="stat-number">{{ $stats['rendezvous_today'] }}</div>
                <div class="stat-label">Aujourd'hui</div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="row g-4">
        <!-- Utilisateurs récents -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>Utilisateurs récents</h5>
                </div>
                <div class="card-body">
                    @forelse($recentUsers as $user)
                    <div class="d-flex align-items-center mb-3 p-2 border rounded">
                        <img src="/images/profile.png" class="rounded-circle me-3" width="40" height="40" alt="Profil">
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $user->prenom }} {{ $user->nom }}</div>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                        <span class="badge bg-secondary">{{ $user->role_user }}</span>
                    </div>
                    @empty
                    <p class="text-muted text-center mb-0">Aucun utilisateur récent</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Rendez-vous récents -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Rendez-vous récents</h5>
                </div>
                <div class="card-body">
                    @forelse($recentRendezVous as $rdv)
                    <div class="d-flex justify-content-between align-items-center mb-3 p-2 border rounded">
                        <div>
                            <div class="fw-bold">{{ $rdv->patient->prenom }} {{ $rdv->patient->nom }}</div>
                            <small class="text-muted">
                                {{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y H:i') }}
                            </small>
                        </div>
                        <span class="badge bg-info">{{ $rdv->statut }}</span>
                    </div>
                    @empty
                    <p class="text-muted text-center mb-0">Aucun rendez-vous récent</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection