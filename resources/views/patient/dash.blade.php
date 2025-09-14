@extends('layouts.layout')

@section('content')
<style>
    /* ... (Gardez les styles existants) ... */
</style>

<div class="container-fluid py-4">
    <h1 class="dashboard-header">Tableau de bord patient</h1>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card card-dashboard p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="card-icon fs-4 rounded-3 me-3">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Prochain rendez-vous</h5>
                        {{-- Vérification si un prochain rendez-vous existe --}}
                        @if($prochainRendezVous)
                            <small class="text-muted">{{ \Carbon\Carbon::parse($prochainRendezVous->date_heure)->locale('fr')->isoFormat('dddd D MMM. à HH:mm') }}</small>
                        @else
                            <small class="text-muted">Aucun rendez-vous à venir</small>
                        @endif
                    </div>
                </div>
                @if($prochainRendezVous)
                    <p class="text-muted mb-0">{{ $prochainRendezVous->medecin_nom }}</p>
                @else
                    <p class="text-muted mb-0">Rien de prévu pour le moment.</p>
                @endif
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-dashboard p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="card-icon fs-4 rounded-3 me-3">
                        <i class="bi bi-capsule-pill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Traitements actifs</h5>
                        <small class="text-muted">{{ $traitements->count() }} médicaments</small>
                    </div>
                </div>
                @if($traitements->isNotEmpty())
                    <p class="text-muted mb-0">Suivez vos prises dans la section "Mes traitements".</p>
                @else
                    <p class="text-muted mb-0">Aucun traitement en cours.</p>
                @endif
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-dashboard p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="card-icon fs-4 rounded-3 me-3">
                        <i class="bi bi-person-fill-gear"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Mon Accompagnateur</h5>
                        <small class="text-muted">APS en charge</small>
                    </div>
                </div>
                {{-- Affichage de l'APS, si un APS est assigné --}}
                @if(Auth::user()->patient->aps)
                    <p class="text-muted mb-0">{{ Auth::user()->patient->aps->nom }} {{ Auth::user()->patient->aps->prenom }}</p>
                @else
                    <p class="text-muted mb-0">Non assigné pour le moment.</p>
                @endif
                <a href="{{ route('patient.messages') }}" class="mt-2 fw-bold text-decoration-none text-info">
                    Envoyer un message <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    </div>
@endsection