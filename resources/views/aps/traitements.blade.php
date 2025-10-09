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
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-hover);
    }

    .stat-card.total { border-left-color: var(--primary-color); }
    .stat-card.en-cours { border-left-color: var(--info-color); }
    .stat-card.termines { border-left-color: var(--success-color); }
    .stat-card.en-retard { border-left-color: var(--danger-color); }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .stat-label {
        color: var(--gray-color);
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 1rem;
        opacity: 0.8;
    }

    .card-modern {
        background: white;
        border-radius: 20px;
        border: none;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .card-modern:hover {
        box-shadow: var(--card-hover);
    }

    .card-header-modern {
        background: white;
        border-bottom: 1px solid #e5e7eb;
        border-radius: 20px 20px 0 0 !important;
        padding: 1.5rem 2rem;
        position: relative;
    }

    .card-header-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
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
        box-shadow: 0 10px 20px rgba(234, 102, 168, 0.3);
    }

    .table-modern {
        margin: 0;
        border-radius: 15px;
        overflow: hidden;
        border: none;
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

    .badge-en-cours { background: #dbeafe; color: #1e40af; }
    .badge-termine { background: #d1fae5; color: #065f46; }
    .badge-en-retard { background: #fee2e2; color: #dc2626; }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: center;
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

    .medicament-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-dark);
        font-size: 1.2rem;
    }

    .progress-bar-custom {
        height: 8px;
        border-radius: 10px;
        background: #e5e7eb;
        overflow: hidden;
        margin-bottom: 5px;
    }

    .progress-fill {
        height: 100%;
        border-radius: 10px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        transition: width 0.3s ease;
    }

    .form-control-modern {
        border-radius: 12px;
        border: 2px solid #e5e7eb;
        padding: 12px 16px;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(234, 102, 142, 0.1);
    }

    .treatment-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        box-shadow: var(--card-shadow);
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .treatment-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-hover);
    }

    .treatment-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .treatment-patient {
        font-weight: 600;
        color: #c2034cff;
    }

    .treatment-medicament {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary-dark);
        margin-bottom: 0.5rem;
    }

    .treatment-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-label {
        font-size: 0.8rem;
        color: var(--gray-color);
        text-transform: uppercase;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-weight: 600;
        color: #c9005eff;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: var(--gray-color);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
</style>

<div class="container-fluid py-4">
    <!-- En-tête du tableau de bord -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-6 fw-bold mb-2">Gestion des Traitements</h1>
                <p class="mb-0 opacity-75">Suivez et gérez tous les traitements des patients</p>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-light btn-modern fw-bold" data-bs-toggle="modal" data-bs-target="#addTraitementModal">
                    <i class="bi bi-capsule-pill me-2"></i>Nouveau Traitement
                </button>
            </div>
        </div>
    </div>

    @php
        $totalTraitements = $traitements->count();
        $traitementsEnCours = $traitements->where('statut', 'En cours')->count();
        $traitementsTermines = $traitements->where('statut', 'Terminé')->count();
        $traitementsEnRetard = $traitements->filter(function($t) {
            return $t->statut === 'En cours' && \Carbon\Carbon::parse($t->date_fin_prevue)->isPast();
        })->count();
    @endphp

    <!-- Cartes de statistiques -->
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon text-primary">
                <i class="bi bi-capsule-pill"></i>
            </div>
            <div class="stat-number">{{ $totalTraitements }}</div>
            <div class="stat-label">Total Traitements</div>
        </div>
        
        <div class="stat-card en-cours">
            <div class="stat-icon text-info">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-number">{{ $traitementsEnCours }}</div>
            <div class="stat-label">En Cours</div>
        </div>
        
        <div class="stat-card termines">
            <div class="stat-icon text-success">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-number">{{ $traitementsTermines }}</div>
            <div class="stat-label">Terminés</div>
        </div>
        
        <div class="stat-card en-retard">
            <div class="stat-icon text-danger">
                <i class="bi bi-exclamation-triangle"></i>
            </div>
            <div class="stat-number">{{ $traitementsEnRetard }}</div>
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

    <!-- Vue en cartes -->
    <div class="card card-modern">
        <div class="card-header card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">
                    <i class="bi bi-capsule me-2"></i>Tous les Traitements
                </h5>
                <div class="btn-group">
                    <button class="btn btn-outline-primary btn-sm active" onclick="showCardView()">
                        <i class="bi bi-grid"></i> Cartes
                    </button>
                    <button class="btn btn-outline-primary btn-sm" onclick="showTableView()">
                        <i class="bi bi-list"></i> Tableau
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Vue Cartes -->
            <div id="cardView">
                <div class="row">
                    @forelse($traitements as $traitement)
                    @php
                        $start = \Carbon\Carbon::parse($traitement->date_debut);
                        $end = \Carbon\Carbon::parse($traitement->date_fin_prevue);
                        $today = \Carbon\Carbon::now();
                        $totalDays = $start->diffInDays($end);
                        $daysPassed = $start->diffInDays($today);
                        $progress = $totalDays > 0 ? min(100, max(0, ($daysPassed / $totalDays) * 100)) : 0;
                        $isLate = $today->gt($end) && $traitement->statut === 'En cours';
                    @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                        <div class="treatment-card">
                            <div class="treatment-header">
                                <div class="d-flex align-items-center">
                                    <div class="medicament-icon me-3">
                                        <i class="bi bi-capsule"></i>
                                    </div>
                                    <div>
                                        <div class="treatment-medicament">{{ $traitement->nom_medicament }}</div>
                                        <div class="treatment-patient">
                                            <i class="bi bi-person me-1"></i>
                                            {{ $traitement->patient->prenom }} {{ $traitement->patient->nom }}
                                        </div>
                                    </div>
                                </div>
                                <span class="badge-status badge-{{ str_replace(' ', '-', strtolower($traitement->statut)) }} {{ $isLate ? 'badge-en-retard' : '' }}">
                                    {{ $isLate ? 'En Retard' : $traitement->statut }}
                                </span>
                            </div>

                            <div class="treatment-details">
                                <div class="detail-item">
                                    <span class="detail-label">Posologie</span>
                                    <span class="detail-value">{{ Str::limit($traitement->posologie, 30) }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Fréquence</span>
                                    <span class="detail-value">{{ $traitement->frequence }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Début</span>
                                    <span class="detail-value">{{ $start->format('d/m/Y') }}</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Fin prévue</span>
                                    <span class="detail-value">{{ $end->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            @if($traitement->statut === 'En cours')
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Progression</small>
                                    <small class="text-muted">{{ number_format($progress, 0) }}%</small>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            @endif

                            <div class="action-buttons">
                                <form action="{{ route('aps.traitements.toggle-status', $traitement->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $traitement->statut == 'En cours' ? 'btn-warning' : 'btn-success' }} btn-action">
                                        <i class="bi bi-arrow-repeat me-1"></i>
                                        {{ $traitement->statut == 'En cours' ? 'Terminer' : 'Reprendre' }}
                                    </button>
                                </form>

                                <button class="btn btn-sm btn-outline-warning btn-action" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editTraitementModal{{ $traitement->id }}">
                                    <i class="bi bi-pencil"></i>
                                </button>

                                <form action="{{ route('aps.traitements.destroy', $traitement->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger btn-action" 
                                            onclick="return confirm('Supprimer ce traitement ?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal d'édition pour chaque traitement -->
                    <div class="modal fade" id="editTraitementModal{{ $traitement->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-warning text-white">
                                    <h5 class="modal-title">Modifier le Traitement</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('aps.traitements.update', $traitement->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Patient *</label>
                                                <select name="patient_id" class="form-control form-control-modern" required>
                                                    @foreach($patients as $patient)
                                                        <option value="{{ $patient->id }}" {{ $traitement->patient_id == $patient->id ? 'selected' : '' }}>
                                                            {{ $patient->prenom }} {{ $patient->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Médicament *</label>
                                                <input type="text" name="nom_medicament" class="form-control form-control-modern" value="{{ $traitement->nom_medicament }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label">Posologie *</label>
                                                <textarea name="posologie" class="form-control form-control-modern" rows="3" required>{{ $traitement->posologie }}</textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Fréquence *</label>
                                                <input type="text" name="frequence" class="form-control form-control-modern" value="{{ $traitement->frequence }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Date Début *</label>
                                                <input type="date" name="date_debut" class="form-control form-control-modern" value="{{ $traitement->date_debut }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Date Fin Prévue *</label>
                                                <input type="date" name="date_fin_prevue" class="form-control form-control-modern" value="{{ $traitement->date_fin_prevue }}" required>
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
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="bi bi-capsule"></i>
                            <h5>Aucun traitement trouvé</h5>
                            <p>Commencez par créer votre premier traitement</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Vue Tableau (cachée par défaut) -->
            <div id="tableView" style="display: none;">
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Médicament</th>
                                <th>Posologie</th>
                                <th>Fréquence</th>
                                <th>Période</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($traitements as $traitement)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="patient-avatar me-3">
                                            {{ substr($traitement->patient->prenom, 0, 1) }}{{ substr($traitement->patient->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <strong>{{ $traitement->patient->prenom }} {{ $traitement->patient->nom }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="medicament-icon me-3">
                                            <i class="bi bi-capsule"></i>
                                        </div>
                                        <div>
                                            <strong>{{ $traitement->nom_medicament }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Str::limit($traitement->posologie, 50) }}</td>
                                <td>{{ $traitement->frequence }}</td>
                                <td>
                                    <small>
                                        <strong>Début:</strong> {{ \Carbon\Carbon::parse($traitement->date_debut)->format('d/m/Y') }}<br>
                                        <strong>Fin:</strong> {{ \Carbon\Carbon::parse($traitement->date_fin_prevue)->format('d/m/Y') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge-status badge-{{ str_replace(' ', '-', strtolower($traitement->statut)) }}">
                                        {{ $traitement->statut }}
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <form action="{{ route('aps.traitements.toggle-status', $traitement->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $traitement->statut == 'En cours' ? 'btn-warning' : 'btn-success' }} btn-action">
                                                {{ $traitement->statut == 'En cours' ? 'Terminer' : 'Reprendre' }}
                                            </button>
                                        </form>

                                        <button class="btn btn-sm btn-outline-warning btn-action" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editTraitementModal{{ $traitement->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form action="{{ route('aps.traitements.destroy', $traitement->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger btn-action">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addTraitementModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Nouveau Traitement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('aps.traitements.store') }}" method="POST">
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
                            <label class="form-label">Médicament *</label>
                            <input type="text" name="nom_medicament" class="form-control form-control-modern" placeholder="Nom du médicament" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Posologie *</label>
                            <textarea name="posologie" class="form-control form-control-modern" rows="3" placeholder="Détails de la posologie..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Fréquence *</label>
                            <input type="text" name="frequence" class="form-control form-control-modern" placeholder="Ex: 2 fois par jour" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date Début *</label>
                            <input type="date" name="date_debut" class="form-control form-control-modern" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date Fin Prévue *</label>
                            <input type="date" name="date_fin_prevue" class="form-control form-control-modern" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary-modern btn-modern">
                        <i class="bi bi-capsule-pill me-2"></i>Créer le Traitement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showCardView() {
    document.getElementById('cardView').style.display = 'block';
    document.getElementById('tableView').style.display = 'none';
    document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
}

function showTableView() {
    document.getElementById('cardView').style.display = 'none';
    document.getElementById('tableView').style.display = 'block';
    document.querySelectorAll('.btn-group .btn').forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
}

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