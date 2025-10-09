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
</style>

<div class="container-fluid dashboard-bg py-4">
    <div class="dashboard-header mb-4">
        <h1>Tableau de bord Médecin</h1>
        <div class="profile">
            <img src="https://ui-avatars.com/api/?name={{ urlencode($aps->nom) }}&background=6f42c1&color=fff&size=48" alt="Avatar">
            <div>
                <div class="name">{{ $aps->nom }}</div>
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
                <div class="stat-value">{{ $patientsCount }}</div>
                <div class="trend-up"><i class="bi bi-arrow-up"></i> +3% ce mois</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center">
                <div class="stat-icon"><i class="bi bi-calendar-check text-success"></i></div>
                <div class="stat-label">Rendez-vous à venir</div>
                <div class="stat-value">{{ $upcomingAppointments }}</div>
                <div class="trend-up"><i class="bi bi-arrow-up"></i> +8% semaine</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center">
                <div class="stat-icon"><i class="bi bi-chat-dots-fill text-info"></i></div>
                <div class="stat-label">Messages non lus</div>
                <div class="stat-value">{{ $unreadMessages }}</div>
                <div class="trend-down"><i class="bi bi-arrow-down"></i> -2% semaine</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card-modern text-center">
                <div class="stat-icon"><i class="bi bi-exclamation-triangle-fill text-warning"></i></div>
                <div class="stat-label">Alertes critiques</div>
                <div class="stat-value">{{ $criticalAlerts }}</div>
                <div class="trend-up"><i class="bi bi-arrow-up"></i> +1 aujourd'hui</div>
            </div>
        </div>
    </div>

    <!-- Actions rapides -->
    <div class="row mb-4 quick-actions">
        <div class="col-12 col-md-8">
            <div class="d-flex flex-wrap gap-3">
                <a href="{{ route('aps.patients.create') }}" class="btn btn-primary">
                    <i class="bi bi-person-plus-fill me-2"></i> Nouveau patient
                </a>
                <a href="{{ route('aps.rendezvous.create') }}" class="btn btn-outline">
                    <i class="bi bi-calendar-plus-fill me-2"></i> Nouveau rendez-vous
                </a>
                <a href="{{ route('aps.traitements.create') }}" class="btn btn-outline">
                    <i class="bi bi-capsule-pill me-2"></i> Nouveau traitement
                </a>
                <a href="{{ route('aps.messages.index') }}" class="btn btn-outline">
                    <i class="bi bi-chat-text-fill me-2"></i> Envoyer un message
                </a>
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
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($nextAppointments as $rdv)
                            <tr>
                                <td>
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($rdv->patient->nom) }}&background=6f42c1&color=fff&size=32" 
                                         class="rounded-circle me-2" style="width:32px;">
                                    {{ $rdv->patient->nom }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</td>
                                <td>
                                    <span class="status-badge status-{{ $rdv->statut }}">
                                        {{ $rdv->statut }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('aps.rendezvous.edit', $rdv->id) }}" 
                                           class="btn btn-sm btn-outline-primary">Modifier</a>
                                        @if($rdv->statut == 'en_attente')
                                        <form action="{{ route('aps.rendezvous.confirm', $rdv->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">Confirmer</button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Aucun rendez-vous à venir
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('aps.rendezvous.index') }}" class="text-decoration-none fw-bold text-primary">
                        Voir tous les rendez-vous <i class="bi bi-arrow-right"></i>
                    </a>
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
                        @forelse($recentMessages as $message)
                        <div class="activity-item">
                            <span class="icon"><i class="bi bi-chat-left-text"></i></span>
                            <div>
                                <div class="desc">
                                    <strong>{{ $message->patient->nom }}</strong> : 
                                    {{ Str::limit($message->contenu, 50) }}
                                </div>
                                <div class="time">{{ $message->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-3">
                            Aucun message récent
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('aps.messages.index') }}" class="text-decoration-none fw-bold text-primary">
                        Voir tous les messages <i class="bi bi-arrow-right"></i>
                    </a>
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
                    @forelse($recentActivity as $activity)
                    <div class="activity-item">
                        <span class="icon"><i class="bi bi-calendar-check"></i></span>
                        <div>
                            <div class="desc">
                                Consultation avec {{ $activity->patient->nom }} - 
                                {{ $activity->motif }}
                            </div>
                            <div class="time">{{ \Carbon\Carbon::parse($activity->date_heure)->diffForHumans() }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3">
                        Aucune activité récente
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card-modern p-4 h-100">
                <div class="section-title mb-3">Alertes critiques</div>
                <ul class="list-group list-group-flush">
                    @forelse($criticalPatients as $patient)
                    <li class="list-group-item d-flex align-items-center">
                        <span class="me-2"><i class="bi bi-exclamation-triangle-fill text-warning"></i></span>
                        <div>
                            <div class="fw-bold">{{ $patient->nom }}</div>
                            <div class="text-muted" style="font-size:0.95rem;">
                                {{ $patient->dossierMedical->first()->motif_urgence ?? 'Alerte médicale' }}
                            </div>
                            <div class="time" style="font-size:0.85rem;">
                                Dernière consultation: {{ $patient->updated_at->diffForHumans() }}
                            </div>
                        </div>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted">
                        Aucune alerte critique
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-muted mt-4" style="font-size:0.95rem;">
        &copy; 2025 Pvvih - Tableau de bord Médecin
    </div>
</div>

<!-- Modals pour actions rapides -->
<div class="modal fade" id="quickActionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickActionModalLabel">Action rapide</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="quickActionModalBody">
                <!-- Le contenu sera chargé dynamiquement -->
            </div>
        </div>
    </div>
</div>

<script>
// Script pour les actions rapides
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des actions rapides
    const quickActionModal = new bootstrap.Modal(document.getElementById('quickActionModal'));
    
    // Exemple d'action rapide pour nouveau rendez-vous
    document.querySelectorAll('[data-quick-action]').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.getAttribute('data-quick-action');
            loadQuickAction(action);
        });
    });
    
    function loadQuickAction(action) {
        // Ici vous pouvez charger du contenu dynamique selon l'action
        const modalBody = document.getElementById('quickActionModalBody');
        const modalLabel = document.getElementById('quickActionModalLabel');
        
        switch(action) {
            case 'new-patient':
                modalLabel.textContent = 'Nouveau Patient';
                modalBody.innerHTML = `
                    <form action="{{ route('aps.patients.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nom complet</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" name="telephone" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary">Créer le patient</button>
                    </form>
                `;
                break;
            // Ajouter d'autres cas pour les autres actions
        }
        
        quickActionModal.show();
    }
});
</script>
@endsection