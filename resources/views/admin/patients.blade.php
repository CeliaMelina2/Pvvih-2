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
    .badge-inactif { background: #6c757d; color: white; }
    .badge-banni { background: #dc3545; color: white; }
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
    .btn-action {
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 0.8rem;
        margin: 2px;
    }
    .info-badge {
        background: #17a2b8;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        margin-left: 5px;
    }
</style>

<div class="container-fluid dashboard-bg py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">Gestion des Patients</h1>
            <p class="text-muted mb-0">Consultation de tous les patients de la plateforme</p>
        </div>
        <div class="text-muted">
            <i class="bi bi-eye me-1"></i> Mode consultation
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalPatients }}</div>
            <div class="stat-label">Total Patients</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $actifsCount }}</div>
            <div class="stat-label">Patients Actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $inactifsCount }}</div>
            <div class="stat-label">Patients Inactifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $bannisCount }}</div>
            <div class="stat-label">Patients Bannis</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $avecTraitementCount }}</div>
            <div class="stat-label">Avec Traitement</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $sansTraitementCount }}</div>
            <div class="stat-label">Sans Traitement</div>
        </div>
    </div>

    <!-- Tableau des patients -->
    <div class="card card-modern">
        <div class="card-header card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">
                    <i class="bi bi-person-vcard me-2"></i>Liste des Patients
                </h5>
                <span class="badge bg-dark">{{ $patients->count() }} patients</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Informations Contact</th>
                            <th>Informations Médicales</th>
                            <th>Activité</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="patient-avatar me-3">
                                        {{ substr($patient->prenom, 0, 1) }}{{ substr($patient->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>{{ $patient->prenom }} {{ $patient->nom }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $patient->id }}</small>
                                        <br>
                                        <small class="text-muted">{{ $patient->sexe }} • {{ \Carbon\Carbon::parse($patient->date_naissance)->age }} ans</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div><i class="bi bi-envelope me-1"></i> {{ $patient->email }}</div>
                                    <div><i class="bi bi-telephone me-1"></i> {{ $patient->telephone ?? 'Non renseigné' }}</div>
                                    @if($patient->adresse)
                                    <div><i class="bi bi-geo-alt me-1"></i> {{ Str::limit($patient->adresse, 30) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    @if($patient->statut_serologique)
                                    <div><strong>Statut:</strong> {{ $patient->statut_serologique }}</div>
                                    @endif
                                    @if($patient->date_diagnostic)
                                    <div><strong>Diagnostic:</strong> {{ date('d/m/Y', strtotime($patient->date_diagnostic)) }}</div>
                                    @endif
                                    @if($patient->codeTARV)
                                    <div><strong>Code TARV:</strong> {{ $patient->codeTARV }}</div>
                                    @endif
                                    <div>
                                        <strong>Traitements:</strong> 
                                        <span class="badge bg-{{ $patient->traitements_count > 0 ? 'success' : 'secondary' }}">
                                            {{ $patient->traitements_count }}
                                        </span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div><strong>Inscrit:</strong> {{ $patient->created_at->format('d/m/Y') }}</div>
                                    <div><strong>Dernière activité:</strong> {{ $patient->updated_at->diffForHumans() }}</div>
                                    <div>
                                        <strong>Rendez-vous:</strong> 
                                        <span class="badge bg-info">{{ $patient->rendez_vous_count }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-status badge-{{ $patient->statut }}">
                                    {{ $patient->statut }}
                                </span>
                                @if($patient->traitements_count > 0)
                                <span class="info-badge">Sous traitement</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Voir détails -->
                                    <button class="btn btn-outline-info btn-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewPatientModal{{ $patient->id }}"
                                            title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Bannir/Débannir -->
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $patient->statut === 'banni' ? 'success' : 'danger' }} btn-action"
                                                title="{{ $patient->statut === 'banni' ? 'Débannir' : 'Bannir' }}"
                                                onclick="return confirm('{{ $patient->statut === 'banni' ? 'Débannir ce patient ?' : 'Bannir ce patient ?' }}')">
                                            <i class="bi bi-{{ $patient->statut === 'banni' ? 'unlock' : 'ban' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de visualisation -->
                        <div class="modal fade" id="viewPatientModal{{ $patient->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Détails du Patient</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Informations Personnelles</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Nom complet:</strong></td>
                                                        <td>{{ $patient->prenom }} {{ $patient->nom }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Sexe:</strong></td>
                                                        <td>{{ $patient->sexe ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Date de naissance:</strong></td>
                                                        <td>{{ $patient->date_naissance ? $patient->date_naissance->format('d/m/Y') : 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Âge:</strong></td>
                                                        <td>{{ $patient->date_naissance ? \Carbon\Carbon::parse($patient->date_naissance)->age . ' ans' : 'Non renseigné' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Contact</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Email:</strong></td>
                                                        <td>{{ $patient->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Téléphone:</strong></td>
                                                        <td>{{ $patient->telephone ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Adresse:</strong></td>
                                                        <td>{{ $patient->adresse ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h6 class="fw-bold">Informations Médicales</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Statut sérologique:</strong></td>
                                                        <td>{{ $patient->statut_serologique ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Date diagnostic:</strong></td>
                                                        <td>{{ $patient->date_diagnostic ? date('d/m/Y', strtotime($patient->date_diagnostic)) : 'Non renseigné' }}
</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Code TARV:</strong></td>
                                                        <td>{{ $patient->codeTARV ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Attestation:</strong></td>
                                                        <td>{{ $patient->attestation ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Statistiques</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Traitements en cours:</strong></td>
                                                        <td><span class="badge bg-success">{{ $patient->traitements_count }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Rendez-vous total:</strong></td>
                                                        <td><span class="badge bg-info">{{ $patient->rendez_vous_count }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Date d'inscription:</strong></td>
                                                        <td>{{ $patient->created_at->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Dernière activité:</strong></td>
                                                        <td>{{ $patient->updated_at->diffForHumans() }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-person-x display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun patient trouvé</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($patients->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $patients->links() }}
    </div>
    @endif
</div>
@endsection