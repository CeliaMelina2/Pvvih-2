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

    body, .dashboard-bg { background: #f6f8fa !important; }
    .dashboard-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2.5rem; }
    .dashboard-header h1 { font-weight:800; color:#4b286d; letter-spacing:-1px; font-size:2.5rem; }
    .dashboard-header .profile { display:flex; align-items:center; gap:1rem; }
    .dashboard-header .profile img { width:48px; height:48px; border-radius:50%; border:2px solid #6f42c1; }
    .dashboard-header .profile .name { font-weight:600; color:#4b286d; }
    .dashboard-header .profile .role { font-size:0.9rem; color:#adb5bd; }

    .card-modern { border:none; border-radius:1.25rem; box-shadow:0 4px 24px rgba(111,66,193,0.08); background:#fff; transition:0.2s; padding:1.5rem; }
    .card-modern:hover { box-shadow:0 8px 32px rgba(111,66,193,0.15); transform:translateY(-2px) scale(1.01); }
    .stat-icon { font-size:2.5rem; margin-bottom:0.5rem; }
    .stat-label { color:#adb5bd; font-size:1rem; margin-bottom:0.25rem; }
    .stat-value { font-size:2.2rem; font-weight:700; color:#4b286d; }
    .trend-up { color:#28a745; font-size:1.1rem; margin-left:0.5rem; }
    .trend-down { color:#e74c3c; font-size:1.1rem; margin-left:0.5rem; }

    .quick-actions .btn { border-radius:0.75rem; font-weight:600; margin-bottom:0.5rem; box-shadow:0 2px 8px rgba(111,66,193,0.07); transition:0.2s; }
    .quick-actions .btn-primary { background:#6f42c1; color:#fff; border:none; }
    .quick-actions .btn-primary:hover { background:#4b286d; }
    .quick-actions .btn-outline { border:1.5px solid #6f42c1; color:#4b286d; background:#e9d8fd; }
    .quick-actions .btn-outline:hover { background:#6f42c1; color:#fff; }

    .section-title { font-weight:700; color:#4b286d; margin-bottom:1.2rem; font-size:1.3rem; }

    .table-modern { border-radius:1rem; overflow:hidden; background:#fff; box-shadow:0 4px 24px rgba(111,66,193,0.08); }
    .table-modern th { background:#e9d8fd; color:#4b286d; border-bottom:2px solid #6f42c1; }
    .table-modern td { vertical-align:middle; }

    .activity-feed { max-height:320px; overflow-y:auto; }
    .activity-item { display:flex; align-items:flex-start; gap:1rem; margin-bottom:1.2rem; }
    .activity-item .icon { font-size:1.5rem; color:#6f42c1; }
    .activity-item .desc { color:#4b286d; font-size:1rem; }
    .activity-item .time { color:#adb5bd; font-size:0.85rem; }
</style>

<div class="container-fluid dashboard-bg py-4">
    <div class="dashboard-header mb-4">
        <h1>Tableau de bord Médecin</h1>
        <div class="profile">
            <img src="https://ui-avatars.com/api/?name=Dr+Médecin&background=6f42c1&color=fff&size=48" alt="Avatar">
            <div>
                <div class="name">Dr. Médecin</div>
                <div class="role">Médecin généraliste</div>
            </div>
        </div>
    </div>

    <!-- Statistiques principales -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="card-modern text-center">
                <div class="stat-icon"><i class="bi bi-people-fill text-primary"></i></div>
                <div class="stat-label">Patients actifs</div>
                <div class="stat-value">152</div>
                <div class="trend-up"><i class="bi bi-arrow-up"></i> +3% ce mois</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center">
                <div class="stat-icon"><i class="bi bi-calendar-check text-success"></i></div>
                <div class="stat-label">Rendez-vous à venir</div>
                <div class="stat-value">12</div>
                <div class="trend-up"><i class="bi bi-arrow-up"></i> +8% semaine</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center">
                <div class="stat-icon"><i class="bi bi-chat-dots-fill text-info"></i></div>
                <div class="stat-label">Messages non lus</div>
                <div class="stat-value">5</div>
                <div class="trend-down"><i class="bi bi-arrow-down"></i> -2% semaine</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center">
                <div class="stat-icon"><i class="bi bi-exclamation-triangle-fill text-warning"></i></div>
                <div class="stat-label">Alertes critiques</div>
                <div class="stat-value">3</div>
                <div class="trend-up"><i class="bi bi-arrow-up"></i> +1 aujourd'hui</div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row mb-4 quick-actions">
        <div class="col-12 col-md-8">
            <div class="d-flex flex-wrap gap-3">
                <a href="#" class="btn btn-primary"><i class="bi bi-person-plus-fill me-2"></i> Nouveau patient</a>
                <a href="#" class="btn btn-outline"><i class="bi bi-calendar-plus-fill me-2"></i> Nouveau rendez-vous</a>
                <a href="#" class="btn btn-outline"><i class="bi bi-capsule-pill me-2"></i> Nouveau traitement</a>
                <a href="#" class="btn btn-outline"><i class="bi bi-chat-text-fill me-2"></i> Envoyer un message</a>
            </div>
        </div>
        <div class="col-12 col-md-4 mt-3 mt-md-0">
            <div class="card-modern p-3">
                <div class="section-title mb-2">Progression des objectifs</div>
                <div class="mb-2">Suivi des consultations mensuelles</div>
                <div class="progress mb-2">
                    <div class="progress-bar" role="progressbar" style="width: 68%"></div>
                </div>
                <div class="text-end text-muted" style="font-size:0.9rem;">68% atteint</div>
            </div>
        </div>
    </div>

    <!-- Section double colonnes -->
    <div class="row g-4 mb-4">
        <!-- Prochains rendez-vous -->
        <div class="col-lg-6">
            <div class="card-modern h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="section-title">Prochains rendez-vous</div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Type</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><img src="https://ui-avatars.com/api/?name=Jean+Dupont&background=6f42c1&color=fff&size=32" class="rounded-circle me-2" style="width:32px;"> Jean Dupont</td>
                                <td>15/09/2025</td>
                                <td>10:00</td>
                                <td><span class="badge bg-primary">Consultation</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-secondary">Détails</a></td>
                            </tr>
                            <tr>
                                <td><img src="https://ui-avatars.com/api/?name=Marie+Durand&background=6f42c1&color=fff&size=32" class="rounded-circle me-2" style="width:32px;"> Marie Durand</td>
                                <td>16/09/2025</td>
                                <td>14:00</td>
                                <td><span class="badge bg-primary">Suivi</span></td>
                                <td><a href="#" class="btn btn-sm btn-outline-secondary">Détails</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="text-decoration-none fw-bold text-primary">Voir tous les rendez-vous <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
        <!-- Messages récents -->
        <div class="col-lg-6">
            <div class="card-modern h-100">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="section-title">Messages récents</div>
                </div>
                <div class="card-body p-0">
                    <div class="activity-feed px-3 pt-3">
                        <div class="activity-item">
                            <span class="icon"><i class="bi bi-chat-left-text"></i></span>
                            <div>
                                <div class="desc"><strong>Jean Dupont</strong> : Bonjour docteur, j’ai une question sur mon traitement.</div>
                                <div class="time">2h ago</div>
                            </div>
                        </div>
                        <div class="activity-item">
                            <span class="icon"><i class="bi bi-chat-left-text"></i></span>
                            <div>
                                <div class="desc"><strong>Marie Durand</strong> : Merci pour le suivi, tout va bien.</div>
                                <div class="time">4h ago</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="text-decoration-none fw-bold text-primary">Voir tous les messages <i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Activité récente et alertes -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card-modern p-4 h-100">
                <div class="section-title mb-3">Activité récente</div>
                <div class="activity-feed">
                    <div class="activity-item">
                        <span class="icon"><i class="bi bi-calendar-check"></i></span>
                        <div>
                            <div class="desc">Consultation terminée avec Jean Dupont</div>
                            <div class="time">Hier</div>
                        </div>
                    </div>
                    <div class="activity-item">
                        <span class="icon"><i class="bi bi-capsule-pill"></i></span>
                        <div>
                            <div class="desc">Traitement ajouté pour Marie Durand</div>
                            <div class="time">2 jours ago</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card-modern p-4 h-100">
                <div class="section-title mb-3">Alertes critiques</div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex align-items-center">
                        <span class="me-2"><i class="bi bi-exclamation-triangle-fill text-warning"></i></span>
                        <div>
                            <div class="fw-bold">Tension élevée</div>
                            <div class="text-muted" style="font-size:0.95rem;">Patient Jean Dupont - 160/100 mmHg</div>
                            <div class="time" style="font-size:0.85rem;">Il y a 1h</div>
                        </div>
                    </li>
                    <li class="list-group-item d-flex align-items-center">
                        <span class="me-2"><i class="bi bi-exclamation-triangle-fill text-warning"></i></span>
                        <div>
                            <div class="fw-bold">Alerte médication</div>
                            <div class="text-muted" style="font-size:0.95rem;">Patient Marie Durand - Dosage oublié</div>
                            <div class="time" style="font-size:0.85rem;">Il y a 2h</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-muted mt-4" style="font-size:0.95rem;">
        &copy; 2025 Pvvih - Tableau de bord Médecin. Design fictif.
    </div>
</div>
@endsection
