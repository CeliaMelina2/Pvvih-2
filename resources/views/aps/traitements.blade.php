@extends('layouts.layout')

@section('content')
<style>
    :root {
        --main-bg: #f6f8fa;
        --main-accent: #6f42c1;
        --main-accent-light: #e9d8fd;
        --main-accent-dark: #4b286d;
        --main-green: #28a745;
        --main-red: #e74c3c;
        --main-blue: #3498db;
        --main-yellow: #ffc107;
        --main-gray: #adb5bd;
        --main-white: #fff;
        --main-shadow: 0 4px 24px rgba(111,66,193,0.08);
    }
    .treatments-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2.5rem;
    }
    .treatments-header h1 {
        font-weight: 800;
        color: var(--main-accent-dark);
        letter-spacing: -1px;
        font-size: 2.2rem;
    }
    .treatments-header .btn {
        border-radius: 0.75rem;
        font-weight: 600;
        background: var(--main-accent);
        color: #fff;
        border: none;
        box-shadow: 0 2px 8px rgba(111,66,193,0.07);
        transition: background 0.2s, color 0.2s;
    }
    .treatments-header .btn:hover {
        background: var(--main-accent-dark);
    }
    .card-modern {
        border: none;
        border-radius: 1.25rem;
        box-shadow: var(--main-shadow);
        background: var(--main-white);
        transition: box-shadow 0.2s, transform 0.2s;
        height: 100%;
    }
    .card-modern:hover {
        box-shadow: 0 8px 32px rgba(111,66,193,0.15);
        transform: translateY(-2px);
    }
    .section-title {
        font-weight: 700;
        color: var(--main-accent-dark);
        margin-bottom: 1.2rem;
        font-size: 1.3rem;
    }
    .badge-status {
        font-size: 0.9rem;
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
    }
    .badge-active { background: var(--main-green); color: #fff; }
    .badge-completed { background: var(--main-blue); color: #fff; }
    .badge-pending { background: var(--main-yellow); color: #fff; }
    .badge-stopped { background: var(--main-red); color: #fff; }
    .timeline {
        position: relative;
        padding-left: 2rem;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
        border-left: 2px solid var(--main-accent-light);
        padding-left: 1.5rem;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 0;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: var(--main-accent);
    }
    .timeline-item:last-child {
        border-left: none;
    }
</style>

<div class="container-fluid py-4" style="background:var(--main-bg); min-height:90vh;">
    <div class="treatments-header mb-4">
        <h1>Gestion des traitements</h1>
        <a href="#" class="btn"><i class="bi bi-plus-circle me-2"></i>Nouveau traitement</a>
    </div>

    <!-- Statistiques traitements -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Total</div>
                <div style="font-size:2rem;font-weight:700;">248</div>
                <div class="text-muted">Traitements</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">En cours</div>
                <div style="font-size:2rem;font-weight:700;">156</div>
                <div class="text-muted">Actifs</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Complétés</div>
                <div style="font-size:2rem;font-weight:700;">85</div>
                <div class="text-muted">Terminés</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Taux d'adhésion</div>
                <div style="font-size:2rem;font-weight:700;">92%</div>
                <div class="text-muted">Moyenne</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Liste des traitements à gauche -->
        <div class="col-lg-6">
            <div class="card-modern p-4">
                <div class="section-title">Liste des traitements</div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Médicament</th>
                                <th>Durée</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $fakeTreatments = [
                                    ['patient' => 'Jean Dupont', 'medicament' => 'Traitement A', 'duree' => '3 mois', 'statut' => 'active'],
                                    ['patient' => 'Marie Durand', 'medicament' => 'Traitement B', 'duree' => '6 mois', 'statut' => 'pending'],
                                    ['patient' => 'Paul Martin', 'medicament' => 'Traitement C', 'duree' => '1 mois', 'statut' => 'completed'],
                                    ['patient' => 'Sophie Legrand', 'medicament' => 'Traitement D', 'duree' => '2 mois', 'statut' => 'active'],
                                ];
                            @endphp

                            @foreach($fakeTreatments as $treatment)
                            <tr>
                                <td>
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($treatment['patient']) }}&background=6f42c1&color=fff&size=32" 
                                         class="rounded-circle me-2" style="width:32px;">
                                    {{ $treatment['patient'] }}
                                </td>
                                <td>{{ $treatment['medicament'] }}</td>
                                <td>{{ $treatment['duree'] }}</td>
                                <td>
                                    @if($treatment['statut'] === 'active')
                                        <span class="badge-status badge-active">En cours</span>
                                    @elseif($treatment['statut'] === 'completed')
                                        <span class="badge-status badge-completed">Terminé</span>
                                    @elseif($treatment['statut'] === 'pending')
                                        <span class="badge-status badge-pending">En attente</span>
                                    @else
                                        <span class="badge-status badge-stopped">Arrêté</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-three-dots"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Détails du traitement à droite -->
        <div class="col-lg-6">
            <div class="card-modern p-4">
                <div class="section-title">Détails du traitement</div>
                @php
                    $selectedTreatment = [
                        'patient' => 'Jean Dupont',
                        'medicament' => 'Traitement A',
                        'duree' => '3 mois',
                        'debut' => '2025-08-01',
                        'fin' => '2025-11-01',
                        'posologie' => '2 comprimés matin et soir',
                        'notes' => 'Bien toléré, pas d\'effets secondaires notables',
                        'dosage' => '500mg',
                        'voie' => 'Orale',
                        'repas' => 'Pendant les repas'
                    ];
                @endphp

                <div class="d-flex align-items-center mb-4">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedTreatment['patient']) }}&background=6f42c1&color=fff&size=48" 
                         class="rounded-circle me-3" style="width:48px;">
                    <div>
                        <h5 class="mb-1">{{ $selectedTreatment['patient'] }}</h5>
                        <p class="mb-0 text-muted">{{ $selectedTreatment['medicament'] }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Informations générales</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Début:</strong> {{ $selectedTreatment['debut'] }}</li>
                            <li class="list-group-item"><strong>Fin:</strong> {{ $selectedTreatment['fin'] }}</li>
                            <li class="list-group-item"><strong>Durée:</strong> {{ $selectedTreatment['duree'] }}</li>
                            <li class="list-group-item"><strong>Dosage:</strong> {{ $selectedTreatment['dosage'] }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Posologie</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Prise:</strong> {{ $selectedTreatment['posologie'] }}</li>
                            <li class="list-group-item"><strong>Voie:</strong> {{ $selectedTreatment['voie'] }}</li>
                            <li class="list-group-item"><strong>Repas:</strong> {{ $selectedTreatment['repas'] }}</li>
                            <li class="list-group-item"><strong>Notes:</strong> {{ $selectedTreatment['notes'] }}</li>
                        </ul>
                    </div>
                </div>

                <div class="section-title">Historique du traitement</div>
                <div class="timeline">
                    <div class="timeline-item">
                        <strong>14 Sept 2025</strong>
                        <p class="mb-0">Contrôle de routine - Traitement bien suivi</p>
                        <small class="text-muted">Dr. Martinez</small>
                    </div>
                    <div class="timeline-item">
                        <strong>01 Sept 2025</strong>
                        <p class="mb-0">Ajustement de la posologie</p>
                        <small class="text-muted">Dr. Martinez</small>
                    </div>
                    <div class="timeline-item">
                        <strong>15 Août 2025</strong>
                        <p class="mb-0">Début du traitement</p>
                        <small class="text-muted">Dr. Martinez</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection