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
    .badge-role {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }
    .badge-admin { background: #dc3545; color: white; }
    .badge-aps { background: #007bff; color: white; }
    .badge-patient { background: #28a745; color: white; }
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
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
</style>

<div class="container-fluid dashboard-bg py-4">
    <!-- En-tête -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 text-dark">Gestion des Utilisateurs</h1>
            <p class="text-muted mb-0">Gérez tous les utilisateurs de la plateforme</p>
        </div>
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus me-2"></i>Nouvel Utilisateur
        </button>
    </div>

    <!-- Statistiques -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalUsers }}</div>
            <div class="stat-label">Total Utilisateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $adminCount }}</div>
            <div class="stat-label">Administrateurs</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $apsCount }}</div>
            <div class="stat-label">Professionnels APS</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $patientCount }}</div>
            <div class="stat-label">Patients</div>
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

    <!-- Tableau des utilisateurs -->
    <div class="card card-modern">
        <div class="card-header card-header-modern">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="section-title mb-0">
                    <i class="bi bi-people me-2"></i>Liste des Utilisateurs
                </h5>
                <span class="badge bg-dark">{{ $users->count() }} utilisateurs</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date d'inscription</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                                    </div>
                                    <div>
                                        <strong>{{ $user->prenom }} {{ $user->nom }}</strong>
                                        <br>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>{{ $user->email }}</div>
                                <small class="text-muted">{{ $user->telephone ?? 'Non renseigné' }}</small>
                            </td>
                            <td>
                                <span class="badge-role badge-{{ $user->role_user }}">
                                    {{ $user->role_user }}
                                </span>
                            </td>
                            <td>
                                <small>
                                    {{ $user->created_at->format('d/m/Y') }}<br>
                                    <span class="text-muted">{{ $user->created_at->diffForHumans() }}</span>
                                </small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $user->statut === 'actif' ? 'success' : 'warning' }}">
                                    {{ $user->statut }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <!-- Éditer -->
                                    <button class="btn btn-outline-warning btn-action" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editUserModal{{ $user->id }}"
                                            title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </button>

                                    
                                    <!-- Supprimer -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-action" 
                                                onclick="return confirm('Supprimer cet utilisateur ?')"
                                                title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal d'édition -->
                        <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-warning text-white">
                                        <h5 class="modal-title">Modifier l'utilisateur</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Prénom *</label>
                                                    <input type="text" name="prenom" class="form-control" value="{{ $user->prenom }}" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Nom *</label>
                                                    <input type="text" name="nom" class="form-control" value="{{ $user->nom }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Email *</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Téléphone</label>
                                                    <input type="text" name="telephone" class="form-control" value="{{ $user->telephone }}">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Rôle *</label>
                                                    <select name="role_user" class="form-control" required>
                                                        <option value="admin" {{ $user->role_user == 'admin' ? 'selected' : '' }}>Administrateur</option>
                                                        <option value="aps" {{ $user->role_user == 'aps' ? 'selected' : '' }}>Professionnel APS</option>
                                                        <option value="patient" {{ $user->role_user == 'patient' ? 'selected' : '' }}>Patient</option>
                                                    </select>
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
                            <td colspan="6" class="text-center py-4">
                                <i class="bi bi-people display-4 text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun utilisateur trouvé</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Modal d'ajout -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Nouvel Utilisateur</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Prénom *</label>
                            <input type="text" name="prenom" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nom *</label>
                            <input type="text" name="nom" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Mot de passe *</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Téléphone</label>
                            <input type="text" name="telephone" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Rôle *</label>
                            <select name="role_user" class="form-control" required>
                                <option value="">Sélectionnez un rôle</option>
                                <option value="admin">Administrateur</option>
                                <option value="aps">Professionnel APS</option>
                                <option value="patient">Patient</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-dark">Créer l'utilisateur</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 