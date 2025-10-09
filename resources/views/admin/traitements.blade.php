@extends('layouts.layout')

@section('content')
<style>
    .dashboard-bg { background: #f8f9fa !important; }
    .card-modern { 
        background: white; 
        border-radius: 15px; 
        border: none; 
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        margin-bottom: 1.5rem;
    }
    .card-header-modern {
        background: white;
        border-bottom: 1px solid #e9ecef;
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }
    .section-title {
        font-weight: 700;
        color: #343a40;
        margin: 0;
        font-size: 1.25rem;
    }
    .table-modern {
        border-radius: 10px;
        overflow: hidden;
    }
    .table-modern thead th {
        background: #343a40;
        color: white;
        border: none;
        padding: 1rem;
        font-weight: 600;
    }
    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-color: #f8f9fa;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-actif { background: #28a745; color: white; }
    .badge-termine { background: #6c757d; color: white; }
    .badge-suspendu { background: #ffc107; color: #212529; }
    .patient-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .medicament-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        font-size: 1.2rem;
    }
    .btn-action {
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.8rem;
        margin: 2px;
    }
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-left: 4px solid #343a40;
    }
    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: #343a40;
        margin-bottom: 0.5rem;
    }
    .stat-label {
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }
    .progress-bar-custom {
        height: 6px;
        border-radius: 10px;
        background: #e9ecef;
        overflow: hidden;
        margin-bottom: 5px;
    }
    .progress-fill {
        height: 100%;
        border-radius: 10px;
        background: #28a745;
        transition: width 0.3s ease;
    }
</style>

<div class="container-fluid dashboard-bg py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">Gestion des Traitements</h1>
            <p class="text-muted mb-0">Supervisez tous les traitements des patients</p>
        </div>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addTraitementModal">
            <i class="bi bi-capsule-pill me-2"></i>Nouveau Traitement
        </button>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalTraitements }}</div>
            <div class="stat-label">Total Traitements</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $actifsCount }}</div>
            <div class="stat-label">Traitements Actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $terminesCount }}</div>
            <div class="stat-label">Traitements Terminés</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $enRetardCount }}</div>
            <div class="stat-label">En Retard</div>
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

    <!-- Tableau des traitements -->
    <div class="card card-modern">
        <div class="card-header card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">
                    <i class="bi bi-capsule-pill me-2"></i>Tous les Traitements
                </h5>
                <span class="badge bg-dark">{{ $traitements->count() }} traitements</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Médicament</th>
                            <th>Patient</th>
                            <th>Posologie</th>
                            <th>Période</th>
                            <th>Progression</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($traitements as $traitement)
                        @php
                            $start = \Carbon\Carbon::parse($traitement->date_debut);
                            $end = \Carbon\Carbon::parse($traitement->date_fin_prevue);
                            $today = \Carbon\Carbon::now();
                            $totalDays = $start->diffInDays($end);
                            $daysPassed = $start->diffInDays($today);
                            $progress = $totalDays > 0 ? min(100, max(0, ($daysPassed / $totalDays) * 100)) : 0;
                            $isLate = $today->gt($end) && $traitement->statut === 'actif';
                        @endphp
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="medicament-icon me-3">
                                        <i class="bi bi-capsule"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $traitement->nom_medicament }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $traitement->frequence }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="patient-avatar me-3">
                                        {{ substr($traitement->patient->prenom, 0, 1) }}{{ substr($traitement->patient->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>{{ $traitement->patient->prenom }} {{ $traitement->patient->nom }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $traitement->patient->telephone }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    {{ Str::limit($traitement->posologie, 50) }}
                                    @if($traitement->instructions)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($traitement->instructions, 30) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <small>
                                    <strong>Début:</strong> {{ $start->format('d/m/Y') }}<br>
                                    <strong>Fin:</strong> {{ $end->format('d/m/Y') }}
                                </small>
                            </td>
                            <td style="width: 120px;">
                                @if($traitement->statut === 'actif')
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                                </div>
                                <small class="text-muted">{{ number_format($progress, 0) }}%</small>
                                @else
                                <small class="text-muted">-</small>
                                @endif
                            </td>
                            <td>
                                @if($isLate)
                                    <span class="badge-status bg-danger">En Retard</span>
                                @else
                                    <span class="badge-status badge-{{ $traitement->statut }}">
                                        {{ $traitement->statut }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Basculer statut -->
                                    <form action="{{ route('admin.traitements.toggle-status', $traitement->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $traitement->statut === 'actif' ? 'warning' : 'success' }} btn-action"
                                                title="{{ $traitement->statut === 'actif' ? 'Terminer' : 'Activer' }}">
                                            <i class="bi bi-{{ $traitement->statut === 'actif' ? 'pause' : 'play' }}"></i>
                                        </button>
                                    </form>

                                    <!-- Éditer -->
                                    <button class="btn btn-outline-warning btn-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editTraitementModal{{ $traitement->id }}"
                                            title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    <!-- Supprimer -->
                                    <form action="{{ route('admin.traitements.destroy', $traitement->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-action" 
                                                onclick="return confirm('Supprimer ce traitement ?')"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal d'édition -->
                        <div class="modal fade" id="editTraitementModal{{ $traitement->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title">Modifier le Traitement</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.traitements.update', $traitement->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Patient *</label>
                                                    <select name="patient_id" class="form-control" required>
                                                        @foreach($patients as $patient)
                                                            <option value="{{ $patient->id }}" {{ $traitement->patient_id == $patient->id ? 'selected' : '' }}>
                                                                {{ $patient->prenom }} {{ $patient->nom }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Médicament *</label>
                                                    <input type="text" name="nom_medicament" class="form-control" value="{{ $traitement->nom_medicament }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Posologie *</label>
                                                    <textarea name="posologie" class="form-control" rows="3" required>{{ $traitement->posologie }}</textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Date Début *</label>
                                                    <input type="date" name="date_debut" class="form-control" value="{{ $traitement->date_debut }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Date Fin Prévue *</label>
                                                    <input type="date" name="date_fin_prevue" class="form-control" value="{{ $traitement->date_fin_prevue }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Fréquence *</label>
                                                    <input type="text" name="frequence" class="form-control" value="{{ $traitement->frequence }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Statut *</label>
                                                    <select name="statut" class="form-control" required>
                                                        <option value="actif" {{ $traitement->statut == 'actif' ? 'selected' : '' }}>Actif</option>
                                                        <option value="terminé" {{ $traitement->statut == 'terminé' ? 'selected' : '' }}>Terminé</option>
                                                        <option value="suspendu" {{ $traitement->statut == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
                                                    </select>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Instructions</label>
                                                    <textarea name="instructions" class="form-control" rows="2">{{ $traitement->instructions }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-warning">Mettre à jour</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="bi bi-capsule display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun traitement trouvé</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($traitements->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $traitements->links() }}
    </div>
    @endif
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addTraitementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Nouveau Traitement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.traitements.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Patient *</label>
                            <select name="patient_id" class="form-control" required>
                                <option value="">Sélectionnez un patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">
                                        {{ $patient->prenom }} {{ $patient->nom }} - {{ $patient->telephone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Médicament *</label>
                            <input type="text" name="nom_medicament" class="form-control" placeholder="Nom du médicament" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Posologie *</label>
                            <textarea name="posologie" class="form-control" rows="3" placeholder="Détails de la posologie..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date Début *</label>
                            <input type="date" name="date_debut" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date Fin Prévue *</label>
                            <input type="date" name="date_fin_prevue" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fréquence *</label>
                            <input type="text" name="frequence" class="form-control" placeholder="Ex: 2 fois par jour" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Instructions</label>
                            <textarea name="instructions" class="form-control" rows="2" placeholder="Instructions supplémentaires..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-dark">Créer le traitement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Script pour calculer la date de fin minimum
document.addEventListener('DOMContentLoaded', function() {
    const dateDebutInput = document.querySelector('input[name="date_debut"]');
    const dateFinInput = document.querySelector('input[name="date_fin_prevue"]');
    
    if (dateDebutInput && dateFinInput) {
        dateDebutInput.addEventListener('change', function() {
            dateFinInput.min = this.value;
        });
    }
});
</script>
@endsection