@extends('layouts.layout')

@section('content')
<style>
    .card-stat {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1.5rem;
        transition: transform 0.2s;
    }
    
    .card-stat:hover {
        transform: translateY(-2px);
    }
    
    .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    
    .card-appointment {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border-left: 4px solid #e91e63;
    }
    
    .card-appointment:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        transform: translateY(-2px);
    }
    
    .card-appointment.bg-light {
        border-left: 4px solid #6c757d;
        opacity: 0.9;
    }
    
    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.375rem;
    }
    
    .status-en_attente { background-color: #fff3cd; color: #856404; }
    .status-confirme { background-color: #d1ecf1; color: #0c5460; }
    .status-annule { background-color: #f8d7da; color: #721c24; }
    .status-effectue { background-color: #d4edda; color: #155724; }
    
    .nav-tabs .nav-link {
        color: #6c757d;
        font-weight: 500;
        border: none;
        padding: 0.75rem 1.5rem;
    }
    
    .nav-tabs .nav-link.active {
        color: #e91e63;
        border-bottom: 3px solid #e91e63;
        background: transparent;
    }
    
    .appointment-header {
        color: #2c3e50;
        font-weight: 700;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="appointment-header mb-0">Mes rendez-vous</h1>
        <button class="btn btn-primary-pink" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
            <i class="bi bi-plus-circle me-2"></i> Prendre un rendez-vous
        </button>
    </div>

    <!-- Statistiques -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-info">{{ $upcomingCount }}</div>
                        <p class="text-muted mb-0">Rendez-vous à venir</p>
                    </div>
                    <i class="bi bi-calendar-check-fill fs-2 text-info"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-success">{{ $pastCount }}</div>
                        <p class="text-muted mb-0">Rendez-vous passés</p>
                    </div>
                    <i class="bi bi-calendar-event-fill fs-2 text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-primary-pink">{{ $assiduite }}%</div>
                        <p class="text-muted mb-0">Taux d'assiduité</p>
                    </div>
                    <i class="bi bi-check-circle-fill fs-2 text-primary-pink"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-danger">{{ $canceledCount }}</div>
                        <p class="text-muted mb-0">Rendez-vous annulés</p>
                    </div>
                    <i class="bi bi-x-circle-fill fs-2 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs mb-4" id="appointmentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="true">
                À venir ({{ $upcoming->count() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab" aria-controls="past" aria-selected="false">
                Passés ({{ $past->count() }})
            </button>
        </li>
    </ul>

    <!-- Contenu des tabs -->
    <div class="tab-content">
        <!-- Tab À venir -->
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <div class="row g-4">
                @forelse($upcoming as $rdv)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-appointment p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            @php
                                $statusClass = [
                                    'en_attente' => 'status-en_attente',
                                    'confirme' => 'status-confirme',
                                    'annule' => 'status-annule'
                                ][$rdv->statut] ?? 'status-en_attente';
                                
                                $statusText = [
                                    'en_attente' => 'En attente',
                                    'confirme' => 'Confirmé',
                                    'annule' => 'Annulé'
                                ][$rdv->statut] ?? $rdv->statut;
                            @endphp
                            <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                            <div class="dropdown">
                                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    @if($rdv->statut == 'en_attente')
                                    <li>
                                        <form action="{{ route('patient.rendezvous.cancel', $rdv->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce rendez-vous ?')">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="bi bi-x-circle me-2"></i>Annuler
                                            </button>
                                        </form>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-info-circle me-2"></i>Détails
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <h5 class="fw-bold mb-2">Rendez-vous avec Dr. {{ $rdv->aps->nom ?? 'Non spécifié' }}</h5>
                        <p class="text-muted mb-3">
                            <i class="bi bi-chat-dots me-1"></i>
                            {{ Str::limit($rdv->motif, 80) }}
                        </p>
                        
                        <div class="appointment-details">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-event me-3 text-primary-pink"></i>
                                <div>
                                    <small class="text-muted">Date</small>
                                    <div class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($rdv->date_heure)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock me-3 text-primary-pink"></i>
                                <div>
                                    <small class="text-muted">Heure</small>
                                    <div class="fw-semibold">
                                        {{ \Carbon\Carbon::parse($rdv->date_heure)->isoFormat('HH:mm') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person me-3 text-primary-pink"></i>
                                <div>
                                    <small class="text-muted">Médecin</small>
                                    <div class="fw-semibold">Dr. {{ $rdv->aps->nom ?? 'Tchet' }}</div>
                                </div>
                            </div>
                        </div>
                        
                        @if($rdv->statut == 'en_attente')
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-warning">
                                <i class="bi bi-clock-history me-1"></i>
                                En attente de confirmation
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun rendez-vous à venir</h5>
                        <p class="text-muted">Prenez votre premier rendez-vous en cliquant sur le bouton ci-dessus.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Passés -->
        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
            <div class="row g-4">
                @forelse($past as $rdv)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-appointment p-4 h-100 bg-light">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="status-badge status-effectue">Effectué</span>
                            <div class="dropdown">
                                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <i class="bi bi-file-earmark-text me-2"></i>Voir le compte-rendu
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        
                        <h5 class="fw-bold mb-2 text-dark">Consultation avec Dr. {{ $rdv->aps->nom ?? 'Non spécifié' }}</h5>
                        <p class="mb-3 text-dark">
                            <i class="bi bi-chat-dots me-1"></i>
                            {{ Str::limit($rdv->motif, 80) }}
                        </p>
                        
                        <div class="appointment-details">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-calendar-event me-3 text-secondary"></i>
                                <div>
                                    <small class="text-muted">Date</small>
                                    <div class="fw-semibold text-dark">
                                        {{ \Carbon\Carbon::parse($rdv->date_heure)->locale('fr')->isoFormat('DD/MM/YYYY') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-clock me-3 text-secondary"></i>
                                <div>
                                    <small class="text-muted">Heure</small>
                                    <div class="fw-semibold text-dark">
                                        {{ \Carbon\Carbon::parse($rdv->date_heure)->isoFormat('HH:mm') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-person me-3 text-secondary"></i>
                                <div>
                                    <small class="text-muted">Médecin</small>
                                    <div class="fw-semibold text-dark">Dr. {{ $rdv->aps->nom ?? 'Dr Tchet' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-check fs-1 text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun rendez-vous passé</h5>
                        <p class="text-muted">Vos rendez-vous passés apparaîtront ici.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="newAppointmentModalLabel">Prendre un nouveau rendez-vous</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger m-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success m-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger m-3">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="modal-body">
                <form action="{{ route('patient.rendezvous.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="aps_id" class="form-label fw-semibold">Médecin / APS</label>
                        <select name="aps_id" id="aps_id" class="form-control" required>
                            <option value="" disabled selected>Sélectionnez un médecin</option>
                            @foreach($apss as $aps)
                                <option value="{{ $aps->id }}" {{ old('aps_id') == $aps->id ? 'selected' : '' }}>
                                    Dr. {{ $aps->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('aps_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_heure" class="form-label fw-semibold">Date et heure du rendez-vous</label>
                        <input type="datetime-local" class="form-control" id="date_heure" name="date_heure" 
                            value="{{ old('date_heure') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                        @error('date_heure')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="motif" class="form-label fw-semibold">Motif de la consultation</label>
                        <textarea class="form-control" id="motif" name="motif" rows="3" 
                                placeholder="Décrivez brièvement le motif de votre consultation..." required>{{ old('motif') }}</textarea>
                        @error('motif')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary-pink">
                            <i class="bi bi-calendar-check me-2"></i>Confirmer le rendez-vous
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection