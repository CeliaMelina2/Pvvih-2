    @extends('layouts.layout')

    @section('content')
    <style>
        :root {
            --main-bg: #fdf5f8;
            --main-accent: #e83e8c;
            --main-accent-light: #fce4ec;
            --main-accent-dark: #c2185b;
            --main-green: #28a745;
            --main-red: #dc3545;
            --main-blue: #3498db;
            --main-yellow: #ffc107;
            --main-gray: #adb5bd;
            --main-white: #fff;
            --main-shadow: 0 4px 24px rgba(232, 62, 140, 0.08);
        }
        body {
            background-color: var(--main-bg);
            font-family: 'Inter', sans-serif;
        }
        .container-fluid {
            background-color: var(--main-bg);
        }
        .rendezvous-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2.5rem;
        }
        .rendezvous-header h1 {
            font-weight: 800;
            color: var(--main-accent-dark);
            letter-spacing: -1px;
            font-size: 2.2rem;
        }
        .rendezvous-header .btn {
            border-radius: 0.75rem;
            font-weight: 600;
            background: var(--main-accent);
            color: #fff;
            border: none;
            box-shadow: 0 2px 8px rgba(232, 62, 140, 0.07);
            transition: background 0.2s, color 0.2s;
        }
        .rendezvous-header .btn:hover {
            background: var(--main-accent-dark);
        }
        .card-modern {
            border: none;
            border-radius: 1.25rem;
            box-shadow: var(--main-shadow);
            background: var(--main-white);
            transition: box-shadow 0.2s, transform 0.2s;
        }
        .card-modern:hover {
            box-shadow: 0 8px 32px rgba(232, 62, 140, 0.15);
            transform: translateY(-2px);
        }
        .section-title {
            font-weight: 700;
            color: var(--main-accent-dark);
            margin-bottom: 1.2rem;
            font-size: 1.3rem;
        }
        .table-modern {
            border-radius: 1rem;
            overflow: hidden;
            background: var(--main-white);
            box-shadow: var(--main-shadow);
        }
        .table-modern th {
            background: var(--main-accent-light);
            color: var(--main-accent-dark);
            border-bottom: 2px solid var(--main-accent);
        }
        .table-modern td {
            vertical-align: middle;
        }
        .badge-status {
            font-size: 0.95rem;
            border-radius: 0.5rem;
            padding: 0.3em 0.8em;
            color: white;
            font-weight: 600;
        }
        .badge-success { background: var(--main-green); }
        .badge-warning { background: var(--main-yellow); }
        .badge-danger { background: var(--main-red); }
        .badge-info { background: var(--main-blue); }
        .activity-feed {
            max-height: 320px;
            overflow-y: auto;
        }
        .activity-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            margin-bottom: 1.2rem;
        }
        .activity-item .icon {
            font-size: 1.5rem;
            color: var(--main-accent);
        }
        .activity-item .desc {
            color: var(--main-accent-dark);
            font-size: 1rem;
        }
        .activity-item .time {
            color: var(--main-gray);
            font-size: 0.85rem;
        }
        @media (max-width: 767px) {
            .rendezvous-header h1 {
                font-size: 1.3rem;
            }
        }
    </style>

    @php
        // Fake rendez-vous
        $rendezVousList = [
            (object)[
                'patient' => (object)['nom' => 'Jean Dupont'],
                'date' => '2025-09-15',
                'heure' => '10:00',
                'type' => 'Consultation',
                'statut' => 'à venir'
            ],
            (object)[
                'patient' => (object)['nom' => 'Marie Durand'],
                'date' => '2025-09-14',
                'heure' => '14:30',
                'type' => 'Suivi',
                'statut' => 'terminé'
            ],
            (object)[
                'patient' => (object)['nom' => 'Paul Martin'],
                'date' => '2025-09-12',
                'heure' => '09:00',
                'type' => 'Consultation',
                'statut' => 'annulé'
            ],
            (object)[
                'patient' => (object)['nom' => 'Sophie Legrand'],
                'date' => '2025-09-16',
                'heure' => '11:00',
                'type' => 'Vaccination',
                'statut' => 'à venir'
            ]
        ];

        // Fake statistiques
        $totalRendezVous = count($rendezVousList);
        $upcomingCount = count(array_filter($rendezVousList, fn($r) => $r->statut === 'à venir'));
        $completedCount = count(array_filter($rendezVousList, fn($r) => $r->statut === 'terminé'));
        $cancelledCount = count(array_filter($rendezVousList, fn($r) => $r->statut === 'annulé'));

        // Fake activité récente
        $recentActivities = [
            (object)['icon' => 'calendar-check', 'description' => 'Rendez-vous terminé avec Jean Dupont', 'created_at' => now()->subDay()],
            (object)['icon' => 'capsule-pill', 'description' => 'Prescription ajoutée pour Marie Durand', 'created_at' => now()->subDays(2)],
            (object)['icon' => 'chat-dots', 'description' => 'Message envoyé à Paul Martin', 'created_at' => now()]
        ];

        // Autres stats
        $avgDuration = 35;
        $cancelRate = 12;
        $satisfaction = 95;
    @endphp

    <div class="container-fluid py-4" style="background:var(--main-bg); min-height:90vh;">
        <div class="rendezvous-header mb-4">
            <h1>Gestion des rendez-vous</h1>
            <a href="#" class="btn"><i class="bi bi-calendar-plus me-2"></i>Ajouter un rendez-vous</a>
        </div>

        <!-- Statistiques rendez-vous -->
        <div class="row g-4 mb-4">
            <div class="col-6 col-md-3">
                <div class="card-modern text-center p-4">
                    <div class="section-title mb-1">Total</div>
                    <div style="font-size:2rem;font-weight:700;">{{ $totalRendezVous ?? '0' }}</div>
                    <div class="text-muted">Rendez-vous</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-modern text-center p-4">
                    <div class="section-title mb-1">À venir</div>
                    <div style="font-size:2rem;font-weight:700;">{{ $upcomingCount ?? '0' }}</div>
                    <div class="text-muted">à venir</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-modern text-center p-4">
                    <div class="section-title mb-1">Terminés</div>
                    <div style="font-size:2rem;font-weight:700;">{{ $completedCount ?? '0' }}</div>
                    <div class="text-muted">effectués</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card-modern text-center p-4">
                    <div class="section-title mb-1">Annulés</div>
                    <div style="font-size:2rem;font-weight:700;">{{ $cancelledCount ?? '0' }}</div>
                    <div class="text-muted">annulés</div>
                </div>
            </div>
        </div>

        <!-- Liste des rendez-vous -->
        <div class="card-modern mb-4">
            <div class="card-header bg-white border-0 pb-0">
                <div class="section-title">Tous les rendez-vous</div>
            </div>
            <div class="card-body p-0">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Heure</th>
                            <th>Type</th>
                            <th>Statut</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($rendezVousList as $rdv)
                        <tr>
                            <td>
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($rdv->patient->nom ?? 'Patient') }}&background=e83e8c&color=fff&size=32" class="rounded-circle me-2" style="width:32px;"> {{ $rdv->patient->nom ?? 'Patient' }}
                            </td>
                            <td>{{ $rdv->date ?? '-' }}</td>
                            <td>{{ $rdv->heure ?? '-' }}</td>
                            <td><span class="badge bg-primary">{{ $rdv->type ?? 'Consultation' }}</span></td>
                            <td>
                                @if($rdv->statut === 'à venir')
                                    <span class="badge-status badge-success">À venir</span>
                                @elseif($rdv->statut === 'terminé')
                                    <span class="badge-status badge-info">Terminé</span>
                                @elseif($rdv->statut === 'annulé')
                                    <span class="badge-status badge-danger">Annulé</span>
                                @else
                                    <span class="badge-status badge-warning">Inconnu</span>
                                @endif
                            </td>
                            <td><a href="#" class="btn btn-sm btn-outline-secondary">Détails</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted">Aucun rendez-vous trouvé</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card-modern p-4 h-100">
                    <div class="section-title mb-3">Activité récente</div>
                    <div class="activity-feed">
                        @forelse($recentActivities as $activity)
                            <div class="activity-item">
                                <span class="icon" style="color: var(--main-accent);"><i class="bi bi-{{ $activity->icon ?? 'info-circle' }}"></i></span>
                                <div>
                                    <div class="desc">{!! $activity->description !!}</div>
                                    <div class="time">{{ $activity->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted">Aucune activité récente</div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-modern p-4 h-100">
                    <div class="section-title mb-3">Statistiques avancées</div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-clock-history me-2" style="color: var(--main-blue);"></i>Durée moyenne consultation</span>
                            <span class="fw-bold">{{ $avgDuration ?? '—' }} min</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-bar-chart-line me-2" style="color: var(--main-green);"></i>Taux d'annulation</span>
                            <span class="fw-bold">{{ $cancelRate ?? '—' }}%</span>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-between">
                            <span><i class="bi bi-emoji-smile me-2" style="color: var(--main-yellow);"></i>Satisfaction patients</span>
                            <span class="fw-bold">{{ $satisfaction ?? '—' }}%</span>
                        </li>
                    </ul>
                </div>
            </div>

<div class="container-fluid py-4" style="background:var(--main-bg); min-height:90vh;">
    <div class="form-header mb-4">
        <h1>Nouveau rendez-vous</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern p-5">
                <form action="" method="POST">
                    @csrf
                    <div class="row g-4 mb-4">
                        <div class="col-md-6">
                            <label for="patient_nom" class="form-label">Nom du patient</label>
                            <input type="text" class="form-control" id="patient_nom" name="patient_nom" required>
                        </div>
                        <div class="col-md-6">
                            <label for="patient_prenom" class="form-label">Prénom du patient</label>
                            <input type="text" class="form-control" id="patient_prenom" name="patient_prenom">
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="heure" class="form-label">Heure</label>
                            <input type="time" class="form-control" id="heure" name="heure" required>
                        </div>
                        <div class="col-md-12">
                            <label for="type" class="form-label">Type de rendez-vous</label>
                            <select class="form-select" id="type" name="type" required>
                                <option selected disabled>Choisir un type...</option>
                                <option>Consultation</option>
                                <option>Suivi</option>
                                <option>Vaccination</option>
                                <option>Examen</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-submit py-3">
                            <i class="bi bi-calendar-plus me-2"></i> Ajouter le rendez-vous
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        </div>

        <div class="text-center text-muted mt-4" style="font-size:0.95rem;">
            &copy; {{ date('Y') }} Pvvih - Rendez-vous Médecin. Design par GitHub Copilot.
        </div>

    </div>
    @endsection
