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
    .aps-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #17a2b8;
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
    .specialite-badge {
        background: #6f42c1;
        color: white;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        margin-right: 5px;
    }
</style>

<div class="container-fluid dashboard-bg py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">Gestion des Professionnels APS</h1>
            <p class="text-muted mb-0">Consultation de tous les professionnels de santé</p>
        </div>
        <div class="text-muted">
            <i class="bi bi-eye me-1"></i> Mode consultation
        </div>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalAps }}</div>
            <div class="stat-label">Total APS</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $actifsCount }}</div>
            <div class="stat-label">APS Actifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $inactifsCount }}</div>
            <div class="stat-label">APS Inactifs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $bannisCount }}</div>
            <div class="stat-label">APS Bannis</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $avecPatientsCount }}</div>
            <div class="stat-label">Avec Patients</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"></div>
            <div class="stat-label">Sans Patients</div>
        </div>
    </div>

    <!-- Tableau des APS -->
    <div class="card card-modern">
        <div class="card-header card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">
                    <i class="bi bi-heart-pulse me-2"></i>Liste des Professionnels APS
                </h5>
                <span class="badge bg-dark">{{ $apss->count() }} professionnels</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Professionnel</th>
                            <th>Spécialité & Contact</th>
                            <th>Activité & Statistiques</th>
                            <th>Patients</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($apss as $aps)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="aps-avatar me-3">
                                        {{ substr($aps->prenom, 0, 1) }}{{ substr($aps->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>Dr. {{ $aps->prenom }} {{ $aps->nom }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $aps->id }}</small>
                                        <br>
                                        <small class="text-muted">Membre depuis {{ $aps->created_at->format('m/Y') }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div><i class="bi bi-envelope me-1"></i> {{ $aps->email }}</div>
                                    <div><i class="bi bi-telephone me-1"></i> {{ $aps->telephone ?? 'Non renseigné' }}</div>
                                    @if($aps->specialite)
                                    <div>
                                        <i class="bi bi-star me-1"></i> 
                                        <span class="specialite-badge">{{ $aps->specialite }}</span>
                                    </div>
                                    @endif
                                    @if($aps->adresse_cabinet)
                                    <div><i class="bi bi-geo-alt me-1"></i> {{ Str::limit($aps->adresse_cabinet, 25) }}</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <div><strong>Rendez-vous ce mois:</strong> {{ $aps->rendez_vous_count }}</div>
                                    <div><strong>Traitements prescrits:</strong> {{ $aps->traitements_count }}</div>
                                    <div><strong>Dernière activité:</strong> {{ $aps->updated_at->diffForHumans() }}</div>
                                    <div><strong>Inscrit le:</strong> {{ $aps->created_at->format('d/m/Y') }}</div>
                                </div>
                            </td>
                            <td>
                                <div class="text-center">
                                    <div class="stat-number" style="font-size: 1.5rem;">{{ $aps->patients_count }}</div>
                                    <div class="stat-label">Patients</div>
                                    @if($aps->patients_count > 0)
                                    <small class="text-success">
                                        <i class="bi bi-arrow-up"></i> Actif
                                    </small>
                                    @else
                                    <small class="text-muted">
                                        Aucun patient
                                    </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge-status badge-{{ $aps->statut }}">
                                    {{ $aps->statut }}
                                </span>
                                @if($aps->patients_count > 0)
                                <span class="badge bg-success mt-1">Avec patients</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Voir détails -->
                                    <button class="btn btn-outline-info btn-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewApsModal{{ $aps->id }}"
                                            title="Voir détails">
                                        <i class="bi bi-eye"></i>
                                    </button>

                                    <!-- Bannir/Débannir -->
                                    <form action="" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-{{ $aps->statut === 'banni' ? 'success' : 'danger' }} btn-action"
                                                title="{{ $aps->statut === 'banni' ? 'Débannir' : 'Bannir' }}"
                                                onclick="return confirm('{{ $aps->statut === 'banni' ? 'Débannir ce professionnel ?' : 'Bannir ce professionnel ?' }}')">
                                            <i class="bi bi-{{ $aps->statut === 'banni' ? 'unlock' : 'ban' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal de visualisation -->
                        <div class="modal fade" id="viewApsModal{{ $aps->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title">Détails du Professionnel APS</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Informations Professionnelles</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Nom complet:</strong></td>
                                                        <td>Dr. {{ $aps->prenom }} {{ $aps->nom }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Spécialité:</strong></td>
                                                        <td>{{ $aps->specialite ?? 'Non spécifiée' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Numéro RPPS:</strong></td>
                                                        <td>{{ $aps->numero_rpps ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Années expérience:</strong></td>
                                                        <td>{{ $aps->annees_experience ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Contact & Localisation</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Email:</strong></td>
                                                        <td>{{ $aps->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Téléphone:</strong></td>
                                                        <td>{{ $aps->telephone ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Adresse cabinet:</strong></td>
                                                        <td>{{ $aps->adresse_cabinet ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Ville:</strong></td>
                                                        <td>{{ $aps->ville ?? 'Non renseigné' }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Statistiques d'Activité</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Patients suivis:</strong></td>
                                                        <td><span class="badge bg-primary">{{ $aps->patients_count }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Rendez-vous total:</strong></td>
                                                        <td><span class="badge bg-info">{{ $aps->rendez_vous_count }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Traitements prescrits:</strong></td>
                                                        <td><span class="badge bg-success">{{ $aps->traitements_count }}</span></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Date d'inscription:</strong></td>
                                                        <td>{{ $aps->created_at->format('d/m/Y H:i') }}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold">Informations Complémentaires</h6>
                                                <table class="table table-sm">
                                                    <tr>
                                                        <td><strong>Statut:</strong></td>
                                                        <td>
                                                            <span class="badge-status badge-{{ $aps->statut }}">
                                                                {{ $aps->statut }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Dernière connexion:</strong></td>
                                                        <td>{{ $aps->updated_at->diffForHumans() }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email vérifié:</strong></td>
                                                        <td>
                                                            @if($aps->email_verified_at)
                                                                <span class="badge bg-success">Oui</span>
                                                            @else
                                                                <span class="badge bg-warning">Non</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                        @if($aps->description)
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h6 class="fw-bold">Description/Spécialisation</h6>
                                                <div class="border rounded p-3 bg-light">
                                                    {{ $aps->description }}
                                                </div>
                                            </div>
                                        </div>
                                        @endif
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
                                <h5 class="text-muted">Aucun professionnel APS trouvé</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($apss->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $apss->links() }}
    </div>
    @endif
</div>
@endsection