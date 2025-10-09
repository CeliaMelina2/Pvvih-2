@extends('layouts.layout')

@section('content')
<style>
    .stats-card {
        border-radius: 15px;
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .stats-card.secondary {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .stats-card.success {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .stats-card.warning {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }
    .card-modern {
        border: none;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        transition: transform 0.3s ease;
    }
    .card-modern:hover {
        transform: translateY(-2px);
    }
    .form-control-modern {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }
    .form-control-modern:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .btn-modern {
        border-radius: 10px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .badge-treatment {
        border-radius: 8px;
        font-size: 0.75rem;
        padding: 6px 10px;
    }
    .action-btn {
        border-radius: 8px;
        padding: 6px 12px;
        margin: 2px;
    }
    .table-modern {
        border-radius: 10px;
        overflow: hidden;
    }
    .table-modern thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 15px;
        font-weight: 600;
    }
    .table-modern tbody td {
        padding: 15px;
        vertical-align: middle;
        border-color: #f8f9fa;
    }
    .table-modern tbody tr:hover {
        background-color: #f8f9ff;
    }
    .section-title {
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 1.5rem;
        position: relative;
    }
    .section-title:after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 50px;
        height: 3px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 2px;
    }
</style>

<div class="container-fluid py-4">
    <!-- En-tête avec titre -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1" style="color: #2c3e50; font-weight: 700;">Gestion des Patients</h1>
            <p class="text-muted mb-0">Gérez vos patients et leurs traitements en toute simplicité</p>
        </div>
    </div>

    <!-- Cartes de statistiques modernes -->
    <div class="row mb-5">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">Total Patients</div>
                            <div class="h2 font-weight-bold mb-0">{{ $patients->count() }}</div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-people-fill text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card secondary shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">Avec Traitement</div>
                            <div class="h2 font-weight-bold mb-0">
                                {{ $patients->filter(fn($p) => $p->traitements->count() > 0)->count() }}
                            </div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-capsule-pill text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card success shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">Traitements Actifs</div>
                            <div class="h2 font-weight-bold mb-0">
                                {{ $patients->sum(fn($p) => $p->traitements->count()) }}
                            </div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-prescription2 text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card warning shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small mb-1">Nouveaux/Mois</div>
                            <div class="h2 font-weight-bold mb-0">0</div>
                        </div>
                        <div class="icon-circle bg-white bg-opacity-25 rounded-circle p-3">
                            <i class="bi bi-graph-up-arrow text-white fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div class="flex-grow-1">{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div>
                    <strong>Veuillez corriger les erreurs suivantes :</strong>
                    <ul class="mb-0 mt-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Formulaire d'ajout patient -->
        <div class="col-lg-4 mb-4">
            <div class="card card-modern">
                <div class="card-header bg-transparent border-0 pt-4 pb-3">
                    <h4 class="section-title mb-0">Nouveau Patient</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('aps.patients.store') }}">
                        @csrf
                        
                        <!-- Informations personnelles -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-person-vcard me-2"></i>Informations Personnelles</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Nom *</label>
                                    <input type="text" name="nom" class="form-control form-control-modern" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Prénom *</label>
                                    <input type="text" name="prenom" class="form-control form-control-modern" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Sexe *</label>
                                    <select name="sexe" class="form-control form-control-modern" required>
                                        <option value="">Sélectionnez le sexe</option>
                                        <option value="Masculin">Masculin</option>
                                        <option value="Féminin">Féminin</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Date de Naissance *</label>
                                    <input type="date" name="date_naissance" class="form-control form-control-modern" required>
                                </div>
                            </div>
                        </div>

                        <!-- Informations de contact -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-telephone me-2"></i>Contact</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Téléphone *</label>
                                    <input type="text" name="telephone" class="form-control form-control-modern" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" name="email" class="form-control form-control-modern">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Adresse</label>
                                    <textarea name="adresse" class="form-control form-control-modern" rows="2" placeholder="Adresse complète"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Informations médicales -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3"><i class="bi bi-heart-pulse me-2"></i>Informations Médicales</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Statut Sérologique</label>
                                    <input type="text" name="statut_serologique" class="form-control form-control-modern" placeholder="Statut sérologique">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Date de Diagnostic</label>
                                    <input type="date" name="date_diagnostic" class="form-control form-control-modern">
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Code TARV</label>
                                    <input type="text" name="codeTARV" class="form-control form-control-modern" placeholder="Code traitement">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-modern w-100">
                            <i class="bi bi-person-plus-fill me-2"></i>Créer le Patient
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Liste des patients -->
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header bg-transparent border-0 pt-4 pb-3">
                    <h4 class="section-title mb-0">Liste des Patients</h4>
                </div>
                <div class="card-body">
                    @if($patients->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-modern table-hover">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Contact</th>
                                        <th>Âge</th>
                                        <th>Traitements</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($patients as $patient)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary text-white rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    {{ substr($patient->prenom, 0, 1) }}{{ substr($patient->nom, 0, 1) }}
                                                </div>
                                                <div>
                                                    <strong class="d-block">{{ $patient->prenom }} {{ $patient->nom }}</strong>
                                                    <small class="text-muted">{{ $patient->sexe }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div><small class="text-primary">{{ $patient->telephone }}</small></div>
                                            @if($patient->email)
                                                <div><small>{{ $patient->email }}</small></div>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $age = $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->age : 'N/A';
                                            @endphp
                                            <span class="fw-semibold">{{ $age }} ans</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                @forelse($patient->traitements as $traitement)
                                                    <span class="badge badge-treatment bg-info text-dark" 
                                                          data-bs-toggle="tooltip" 
                                                          title="{{ $traitement->posologie }}">
                                                        {{ $traitement->nom_medicament }}
                                                    </span>
                                                @empty
                                                    <span class="text-muted small">Aucun traitement</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-1">
                                                <!-- Bouton Ajouter Traitement -->
                                                <button class="btn btn-success btn-sm action-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#addTraitementModal{{ $patient->id }}"
                                                        title="Ajouter traitement">
                                                    <i class="bi bi-plus-lg"></i>
                                                </button>

                                                <!-- Bouton Éditer Patient -->
                                                <button class="btn btn-warning btn-sm action-btn" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editPatientModal{{ $patient->id }}"
                                                        title="Modifier patient">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Bouton Supprimer Patient -->
                                                <form method="POST" action="{{ route('aps.patients.destroy', $patient->id) }}" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm action-btn" 
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce patient ?')"
                                                            title="Supprimer patient">
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
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-people display-1 text-muted opacity-50"></i>
                            <h5 class="text-muted mt-3">Aucun patient enregistré</h5>
                            <p class="text-muted">Commencez par ajouter votre premier patient</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals pour l'ajout de traitement -->
@foreach($patients as $patient)
<div class="modal fade" id="addTraitementModal{{ $patient->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-capsule-pill me-2"></i>
                    Nouveau Traitement - {{ $patient->prenom }} {{ $patient->nom }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('aps.patients.traitement', $patient->id) }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Médicament *</label>
                            <input type="text" name="nom_medicament" class="form-control form-control-modern" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Fréquence *</label>
                            <input type="text" name="frequence" class="form-control form-control-modern" placeholder="Ex: 2 fois par jour" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Posologie *</label>
                            <textarea name="posologie" class="form-control form-control-modern" rows="3" placeholder="Détails de la posologie..." required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date Début *</label>
                            <input type="date" name="date_debut" class="form-control form-control-modern" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date Fin *</label>
                            <input type="date" name="date_fin" class="form-control form-control-modern" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success btn-modern">
                        <i class="bi bi-check-lg me-2"></i>Assigner le Traitement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<script>
// Initialiser les tooltips
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>
@endsection