@extends('layouts.layout')

@section('content')
<style>
    :root {
        --primary-color: #ea66a8ff;
        --primary-light: #a3b4f8;
        --primary-dark: #d85a8fff;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #f63baeff;
        --gray-color: #6b7280;
        --light-bg: #fcf8faff;
        --card-shadow: 0 10px 25px rgba(0,0,0,0.05);
        --card-hover: 0 20px 40px rgba(0,0,0,0.1);
    }

    body {
        background: var(--light-bg);
        font-family: 'Inter', sans-serif;
    }

    .dashboard-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        color: white;
        box-shadow: var(--card-shadow);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-left: 4px solid var(--primary-color);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover);
    }

    .stat-card.total { border-left-color: var(--primary-color); }
    .stat-card.a-venir { border-left-color: var(--info-color); }
    .stat-card.termines { border-left-color: var(--success-color); }
    .stat-card.annules { border-left-color: var(--danger-color); }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--gray-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .card-modern {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
    }

    .card-modern:hover {
        box-shadow: var(--card-hover);
    }

    .card-header-modern {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem 2rem;
    }

    .section-title {
        font-weight: 700;
        color: #1f2937;
        margin: 0;
        font-size: 1.25rem;
    }

    .btn-modern {
        border-radius: 12px;
        padding: 12px 24px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .table-modern {
        margin: 0;
        border-radius: 15px;
        overflow: hidden;
    }

    .table-modern thead th {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        padding: 1.2rem 1rem;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .table-modern tbody td {
        padding: 1.2rem 1rem;
        vertical-align: middle;
        border-color: #f1f5f9;
    }

    .table-modern tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge-status {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .badge-en_attente { background: #fef3c7; color: #d97706; }
    .badge-confirme { background: #d1fae5; color: #065f46; }
    .badge-termine { background: #dbeafe; color: #1e40af; }
    .badge-annule { background: #fee2e2; color: #dc2626; }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-action {
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 0.8rem;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-action:hover {
        transform: translateY(-2px);
    }

    .modal-modern .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: var(--card-hover);
    }

    .modal-modern .modal-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        border: none;
    }

    .form-control-modern {
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .patient-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .status-select {
        border-radius: 10px;
        padding: 6px 12px;
        border: 2px solid #e5e7eb;
        background: white;
        font-size: 0.8rem;
        font-weight: 600;
    }
</style>

<div class="container-fluid py-4">
    <!-- En-tête du tableau de bord -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2">Gestion des Rendez-vous</h1>
                <p class="mb-0 opacity-75">Gérez tous les rendez-vous des patients en un seul endroit</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-light btn-modern fw-bold" data-bs-toggle="modal" data-bs-target="#addRendezVousModal">
                    <i class="bi bi-calendar-plus me-2"></i>Nouveau Rendez-vous
                </button>
            </div>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-number text-primary">{{ $stats['total'] }}</div>
            <div class="stat-label">Total Rendez-vous</div>
        </div>
        <div class="stat-card a-venir">
            <div class="stat-number text-info">{{ $stats['a_venir'] }}</div>
            <div class="stat-label">À Venir</div>
        </div>
        <div class="stat-card termines">
            <div class="stat-number text-success">{{ $stats['termines'] }}</div>
            <div class="stat-label">Terminés</div>
        </div>
        <div class="stat-card annules">
            <div class="stat-number text-danger">{{ $stats['annules'] }}</div>
            <div class="stat-label">Annulés</div>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tableau des rendez-vous -->
    <div class="card card-modern">
        <div class="card-header card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">
                    <i class="bi bi-calendar-week me-2"></i>Tous les Rendez-vous
                </h5>
                <span class="badge bg-primary">{{ $rendezvous->count() }} rendez-vous</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>APS</th>
                            <th>Date & Heure</th>
                            <th>Type</th>
                            <th>Durée</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rendezvous as $rdv)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="patient-avatar me-3">
                                        {{ substr($rdv->patient->prenom, 0, 1) }}{{ substr($rdv->patient->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>{{ $rdv->patient->prenom }} {{ $rdv->patient->nom }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $rdv->patient->telephone }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <strong>{{ $rdv->aps->nom ?? 'N/A' }}</strong>
                            </td>
                            <td>
                                <strong>{{ \Carbon\Carbon::parse($rdv->date_heure)->format('d/m/Y') }}</strong>
                                <br>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark">{{ $rdv->type_rendezvous }}</span>
                            </td>
                            <td>
                                <span class="fw-bold">{{ $rdv->duree }} min</span>
                            </td>
                            <td>
                                <span class="badge-status badge-{{ str_replace('é', 'e', $rdv->statut) }}">
                                    {{ $rdv->statut }}
                                </span>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <!-- Modifier le statut -->
                                    <select class="status-select" onchange="updateStatus({{ $rdv->id }}, this.value)">
                                        <option value="en_attente" {{ $rdv->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                        <option value="confirmé" {{ $rdv->statut == 'confirmé' ? 'selected' : '' }}>Confirmé</option>
                                        <option value="terminé" {{ $rdv->statut == 'terminé' ? 'selected' : '' }}>Terminé</option>
                                        <option value="annulé" {{ $rdv->statut == 'annulé' ? 'selected' : '' }}>Annulé</option>
                                    </select>

                                    <!-- Éditer -->
                                    <button class="btn btn-warning btn-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editRendezVousModal{{ $rdv->id }}"
                                            title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Supprimer -->
                                    <form action="{{ route('aps.rendezvous.destroy', $rdv->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action" 
                                                onclick="return confirm('Supprimer ce rendez-vous ?')"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal d'édition -->
                        <div class="modal fade modal-modern" id="editRendezVousModal{{ $rdv->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier le Rendez-vous</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('aps.rendezvous.update', $rdv->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Patient *</label>
                                                    <select name="patient_id" class="form-control form-control-modern" required>
                                                        @foreach($patients as $patient)
                                                            <option value="{{ $patient->id }}" {{ $rdv->patient_id == $patient->id ? 'selected' : '' }}>
                                                                {{ $patient->prenom }} {{ $patient->nom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">APS *</label>
                                                    <select name="aps_id" class="form-control form-control-modern" required>
                                                        @foreach($apss as $aps)
                                                            <option value="{{ $aps->id }}" {{ $rdv->aps_id == $aps->id ? 'selected' : '' }}>
                                                                {{ $aps->nom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Date *</label>
                                                    <input type="date" name="date_heure" class="form-control form-control-modern" 
                                                           value="{{ \Carbon\Carbon::parse($rdv->date_heure)->format('Y-m-d') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Heure *</label>
                                                    <input type="time" name="heure" class="form-control form-control-modern" 
                                                           value="{{ \Carbon\Carbon::parse($rdv->date_heure)->format('H:i') }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Type *</label>
                                                    <select name="type_rendezvous" class="form-control form-control-modern" required>
                                                        <option value="Consultation" {{ $rdv->type_rendezvous == 'Consultation' ? 'selected' : '' }}>Consultation</option>
                                                        <option value="Suivi" {{ $rdv->type_rendezvous == 'Suivi' ? 'selected' : '' }}>Suivi</option>
                                                        <option value="Vaccination" {{ $rdv->type_rendezvous == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                                        <option value="Examen" {{ $rdv->type_rendezvous == 'Examen' ? 'selected' : '' }}>Examen</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Durée (minutes) *</label>
                                                    <input type="number" name="duree" class="form-control form-control-modern" 
                                                           value="{{ $rdv->duree }}" min="5" max="240" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Motif *</label>
                                                    <textarea name="motif" class="form-control form-control-modern" rows="3" required>{{ $rdv->motif }}</textarea>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Statut *</label>
                                                    <select name="statut" class="form-control form-control-modern" required>
                                                        <option value="en_attente" {{ $rdv->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
                                                        <option value="confirmé" {{ $rdv->statut == 'confirmé' ? 'selected' : '' }}>Confirmé</option>
                                                        <option value="terminé" {{ $rdv->statut == 'terminé' ? 'selected' : '' }}>Terminé</option>
                                                        <option value="annulé" {{ $rdv->statut == 'annulé' ? 'selected' : '' }}>Annulé</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary-modern btn-modern">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-calendar-x display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun rendez-vous trouvé</h5>
                                <p class="text-muted">Commencez par créer votre premier rendez-vous</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade modal-modern" id="addRendezVousModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nouveau Rendez-vous</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('aps.rendezvous.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Patient *</label>
                            <select name="patient_id" class="form-control form-control-modern" required>
                                <option value="">Sélectionnez un patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->prenom }} {{ $patient->nom }} - {{ $patient->telephone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">APS *</label>
                            <select name="aps_id" class="form-control form-control-modern" required>
                                <option value="">Sélectionnez un APS</option>
                                @foreach($apss as $aps)
                                    <option value="{{ $aps->id }}">{{ $aps->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date *</label>
                            <input type="date" name="date_heure" class="form-control form-control-modern" 
                                   min="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Heure *</label>
                            <input type="time" name="heure" class="form-control form-control-modern" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Type de rendez-vous *</label>
                            <select name="type_rendezvous" class="form-control form-control-modern" required>
                                <option value="">Sélectionnez un type</option>
                                <option value="Consultation">Consultation</option>
                                <option value="Suivi">Suivi</option>
                                <option value="Vaccination">Vaccination</option>
                                <option value="Examen">Examen</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Durée (minutes) *</label>
                            <input type="number" name="duree" class="form-control form-control-modern" 
                                   value="30" min="5" max="240" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Motif *</label>
                            <textarea name="motif" class="form-control form-control-modern" rows="3" 
                                      placeholder="Décrivez le motif de la consultation..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary-modern btn-modern">
                        <i class="bi bi-calendar-plus me-2"></i>Créer le Rendez-vous
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateStatus(rendezvousId, newStatus) {
    if (confirm('Êtes-vous sûr de vouloir modifier le statut de ce rendez-vous ?')) {
        fetch(`/rendezvous/${rendezvousId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ statut: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

// Combiner date et heure pour l'envoi au serveur
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const dateInput = this.querySelector('input[name="date_heure"]');
            const timeInput = this.querySelector('input[name="heure"]');
            
            if (dateInput && timeInput) {
                const dateTime = `${dateInput.value} ${timeInput.value}:00`;
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'date_heure';
                hiddenInput.value = dateTime;
                this.appendChild(hiddenInput);
            }
        });
    });
});
</script>
@endsection