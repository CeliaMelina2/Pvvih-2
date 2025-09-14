@extends('layouts.layout')

@section('content')
<style>
    :root {
        --primary-pink: #d1206f;
        --primary-purple: #811d73;
        --pink-lightest: #fdf2f7;
        --pink-light: #fbeaf1;
        --dark-blue: #010a43;
        --secondary-text: #6c757d;
        --success-green: #28a745;
        --info-blue: #17a2b8;
        --warning-yellow: #ffc107;
    }

    .dashboard-header h1 {
        font-weight: 700;
        color: var(--dark-blue);
        letter-spacing: -1px;
    }

    /* Styles pour les nouvelles cartes et badges */
    .card-modern {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        background-color: #fff;
    }
    
    .card-modern .section-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary-purple);
        text-transform: uppercase;
    }

    .card-modern .stat-value {
        font-size: 2.5rem;
        font-weight: bold;
        color: var(--dark-blue);
    }
    
    .badge-status {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 0.5rem;
        text-transform: uppercase;
        color: white;
    }
    .badge-status.badge-success { background-color: var(--success-green); }
    .badge-status.badge-danger { background-color: #dc3545; }
    .badge-status.badge-warning { background-color: var(--warning-yellow); }
    .badge-status.badge-info { background-color: var(--info-blue); }

    /* Styles pour la table */
    .table-modern thead th {
        background-color: var(--pink-lightest);
        color: var(--primary-purple);
        border-bottom: 2px solid var(--primary-pink);
        font-weight: 600;
        padding: 1rem;
    }
    .table-modern tbody tr td {
        vertical-align: middle;
    }
    .table-modern tbody tr:hover {
        background-color: var(--pink-lightest);
    }
    
    /* Styles pour le fil d'activité */
    .activity-feed .activity-item {
        display: flex;
        align-items: flex-start;
        padding: 1rem;
        border: 1px solid var(--pink-light);
        border-radius: 1rem;
        flex: 0 0 auto;
        min-width: 250px;
        transition: transform 0.3s ease;
    }
    .activity-feed .activity-item:hover {
        transform: translateY(-3px);
    }
    .activity-feed .activity-item .icon {
        background-color: var(--pink-light);
        color: var(--primary-purple);
        padding: 0.75rem;
        border-radius: 50%;
        margin-right: 1rem;
        font-size: 1.25rem;
    }
    .activity-feed .activity-item .desc {
        font-weight: 600;
        color: var(--dark-blue);
        margin-bottom: 0.2rem;
    }
    .activity-feed .activity-item .time {
        font-size: 0.8rem;
        color: var(--secondary-text);
    }
    
    .btn-primary-pink {
        background-color: var(--primary-pink);
        border-color: var(--primary-pink);
        color: #fff;
    }
    .btn-primary-pink:hover {
        background-color: #b81a5f;
        border-color: #b81a5f;
    }
    .btn-outline-primary {
        color: var(--primary-pink);
        border-color: var(--primary-pink);
    }
    .btn-outline-primary:hover {
        background-color: var(--primary-pink);
        color: #fff;
    }
    .btn-primary-add {
        background-color: var(--primary-pink);
        color: white;
    }
    .btn-primary-add:hover {
        background-color: var(--primary-purple);
        color: white;
    }
</style>

<div class="container-fluid py-4" style="background:var(--main-bg); min-height:90vh;">
    <div class="patients-header mb-4 d-flex justify-content-between align-items-center">
        <h1>Gestion des patients</h1>
        <a href="{{ route('aps.patients') }}" class="btn btn-primary-add rounded-pill px-4">
            <i class="bi bi-person-plus me-2"></i>Ajouter un patient
        </a>
    </div>

    <!-- Statistiques patients -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Total</div>
                <div class="stat-value">125</div>
                <div class="text-muted">Patients</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Actifs</div>
                <div class="stat-value">102</div>
                <div class="text-muted">Actifs</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Nouveaux</div>
                <div class="stat-value">12</div>
                <div class="text-muted">Ce mois</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center p-4">
                <div class="section-title mb-1">Dossiers incomplets</div>
                <div class="stat-value">11</div>
                <div class="text-muted">À compléter</div>
            </div>
        </div>
    </div>

    <!-- Nouvelle disposition : liste patients à gauche, dossier médical à droite -->
    <div class="row g-4">
        <!-- Liste des patients -->
        <div class="col-lg-6">
            <div class="card-modern mb-4 h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="section-title">Tous les patients</div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Âge</th>
                                <th>Téléphone</th>
                                <th>Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $fakePatients = [
                                    ['nom'=>'Jean Dupont','age'=>34,'sexe'=>'M','telephone'=>'+237 650123456','statut'=>'actif'],
                                    ['nom'=>'Marie Durand','age'=>28,'sexe'=>'F','telephone'=>'+237 699654321','statut'=>'inactif'],
                                    ['nom'=>'Paul Martin','age'=>45,'sexe'=>'M','telephone'=>'+237 677987654','statut'=>'incomplet'],
                                    ['nom'=>'Sophie Legrand','age'=>39,'sexe'=>'F','telephone'=>'+237 690112233','statut'=>'actif'],
                                    ['nom'=>'Lucie Bernard','age'=>22,'sexe'=>'F','telephone'=>'+237 675334455','statut'=>'actif'],
                                ];
                            @endphp
                            @foreach($fakePatients as $patient)
                            <tr>
                                <td>
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($patient['nom']) }}&background=d1206f&color=fff&size=32" class="rounded-circle me-2" style="width:32px;"> {{ $patient['nom'] }}
                                </td>
                                <td>{{ $patient['age'] }}</td>
                                <td>{{ $patient['telephone'] }}</td>
                                <td>
                                    @if($patient['statut'] === 'actif')
                                        <span class="badge-status badge-success">Actif</span>
                                    @elseif($patient['statut'] === 'inactif')
                                        <span class="badge-status badge-danger">Inactif</span>
                                    @elseif($patient['statut'] === 'incomplet')
                                        <span class="badge-status badge-warning">Incomplet</span>
                                    @else
                                        <span class="badge-status badge-info">Inconnu</span>
                                    @endif
                                </td>
                                <td><a href="#" class="btn btn-sm btn-outline-secondary">Dossier</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Dossier médical du patient sélectionné (exemple à droite) -->
        <div class="col-lg-6">
            <div class="card-modern p-4 h-100 mb-4">
                <div class="section-title mb-3">Dossier médical</div>
                @php
                    $selectedPatient = [
                        'nom' => 'Jean Dupont',
                        'age' => 34,
                        'sexe' => 'M',
                        'telephone' => '+237 650123456',
                        'adresse' => 'Yaoundé, Cameroun',
                        'email' => 'jean.dupont@email.com',
                        'antecedents' => 'Aucun',
                        'allergies' => 'Pénicilline',
                        'poids' => '78 kg',
                        'taille' => '1,80 m',
                        'groupesanguin' => 'O+',
                        'notes' => 'Patient en bonne santé générale.'
                    ];
                @endphp
                <div class="d-flex align-items-center mb-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedPatient['nom']) }}&background=d1206f&color=fff&size=48" class="rounded-circle me-3" style="width:48px;">
                    <div>
                        <div class="fw-bold" style="font-size:1.2rem;">{{ $selectedPatient['nom'] }}</div>
                        <div class="text-muted">{{ $selectedPatient['age'] }} ans &bull; {{ $selectedPatient['sexe'] }} &bull; {{ $selectedPatient['groupesanguin'] }}</div>
                    </div>
                </div>
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Téléphone :</strong> <span>{{ $selectedPatient['telephone'] }}</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Email :</strong> <span>{{ $selectedPatient['email'] }}</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Adresse :</strong> <span>{{ $selectedPatient['adresse'] }}</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Antécédents :</strong> <span>{{ $selectedPatient['antecedents'] }}</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Allergies :</strong> <span>{{ $selectedPatient['allergies'] }}</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Poids :</strong> <span>{{ $selectedPatient['poids'] }}</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Taille :</strong> <span>{{ $selectedPatient['taille'] }}</span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><strong>Notes :</strong> <span>{{ $selectedPatient['notes'] }}</span></li>
                </ul>
                <div class="text-end">
                    <a href="#" class="btn btn-outline-primary">Modifier le dossier</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Activité récente et Statistiques avancées -->
    <div class="row g-4 mt-2">
        <div class="col-lg-6">
            <div class="card-modern p-4 h-100">
                <div class="section-title mb-3">Statistiques avancées</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-person-check me-2 text-pink"></i>Taux d'adhésion</span>
                        <span class="fw-bold">88%</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-person-plus me-2 text-pink"></i>Nouveaux ce mois</span>
                        <span class="fw-bold">12</span>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-between">
                        <span><i class="bi bi-emoji-smile me-2 text-pink"></i>Satisfaction patients</span>
                        <span class="fw-bold">94%</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card-modern p-4 h-100">
                <div class="section-title mb-3">Activité récente</div>
                @php
                    $fakeActivities = [
                        ['icon'=>'calendar-check','description'=>'Consultation terminée avec Jean Dupont','time'=>'Hier'],
                        ['icon'=>'capsule-pill','description'=>'Prescription ajoutée pour Marie Durand','time'=>'2 jours'],
                        ['icon'=>'chat-dots','description'=>'Réponse envoyée à Paul Martin','time'=>'Aujourd\'hui'],
                    ];
                @endphp
                <div class="activity-feed d-flex flex-row flex-nowrap overflow-auto">
                    @foreach($fakeActivities as $activity)
                        <div class="activity-item me-4">
                            <span class="icon"><i class="bi bi-{{ $activity['icon'] }}"></i></span>
                            <div>
                                <div class="desc">{!! $activity['description'] !!}</div>
                                <div class="time">{{ $activity['time'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="text-center text-muted mt-4" style="font-size:0.95rem;">
        &copy; 2025 Pvvih - Patients Médecin. Design fictif.
    </div>
</div>
@endsection
