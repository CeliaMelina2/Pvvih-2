@extends('layouts.layout')

@section('content')
<style>
    .profile-header {
        color: #212529;
        font-weight: 700;
        margin-bottom: 2rem;
    }
    .card-profile {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-profile:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }
    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #D01168;
        padding: 3px;
    }
    .profile-badge {
        background-color: #D01168;
        color: white;
        font-weight: 600;
    }
    .info-list li {
        padding: 0.75rem 0;
        border-bottom: 1px solid #e9ecef;
    }
    .info-list li:last-child {
        border-bottom: none;
    }
    .info-label {
        color: #6c757d;
        font-weight: 500;
    }
    .info-value {
        color: #212529;
        font-weight: 600;
    }
    .btn-edit {
        color: #D01168;
        border-color: #D01168;
    }
    .btn-edit:hover {
        background-color: #D01168;
        color: white;
    }
</style>

<div class="container-fluid py-4">
    <h1 class="profile-header">Mon profil</h1>

    <div class="card card-profile p-4 mb-5">
        <div class="d-flex flex-column flex-md-row align-items-center">
            <div class="me-md-4 mb-3 mb-md-0">
                <img src="/images/profile.png" alt="Profil du patient" class="profile-img">
            </div>
            <div class="text-center text-md-start">
                <h4 class="fw-bold mb-1">{{ $patient->nom}}</h4>
                <p class="text-muted mb-2">Patient depuis {{ $patient->created_at }}</p>
                <span class="badge profile-badge">Actif</span>
            </div>
        </div>
        
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card card-profile p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Informations personnelles</h5>
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editInfoModal">
                        <i class="bi bi-pencil-fill me-1"></i> Modifier
                    </button>
                </div>
                <ul class="list-unstyled info-list">
                    <li>
                        <div class="info-label">Nom et Prénom</div>
                        <div class="info-value">{{ $patient->nom }} {{ $patient->prenom }}</div>
                    </li>
                    <li>
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $patient->email }}</div>
                    </li>
                    <li>
                        <div class="info-label">Téléphone</div>
                        <div class="info-value">{{ $patient->telephone }}</div>
                    </li>
                    <li>
                        <div class="info-label">Adresse</div>
                        <div class="info-value">{{ $patient->adresse }}</div>
                    </li>
                    <li>
                        <div class="info-label">Sexe</div>
                        <div class="info-value">{{ $patient->sexe }}</div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card card-profile p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Informations de santé</h5>
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editHealthModal">
                        <i class="bi bi-pencil-fill me-1"></i> Modifier
                    </button>
                </div>
                <ul class="list-unstyled info-list">
                    <li>
                        <div class="info-label">Statut sérologique</div>
                        <div class="info-value text-danger">{{ $patient->statut_serologique }}</div>
                    </li>
                    <li>
                        <div class="info-label">Code TARV</div>
                        <div class="info-value">{{ $patient->codeTARV }}</div>
                    </li>
                    <li>
                        <div class="info-label">Date de diagnostic</div>
                        <div class="info-value">{{ $patient->date_diagnostic }}</div>
                    </li>
                    <li>
                        <div class="info-label">Allergies connues</div>
                          <div class="info-value">Aucune allergie .</div>
                    </li>
                    <li>
                        <div class="info-label">APS assigné</div>
                        <div class="info-value">{{ $patient->codeTARV }}  </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card card-profile p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Sécurité et confidentialité</h5>
                    <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                        <i class="bi bi-lock-fill me-1"></i> Changer le mot de passe
                    </button>
                </div>
                <p class="text-muted mb-0">
                    Protégez votre compte en utilisant un mot de passe fort et unique. Ne le partagez jamais.
                </p>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editInfoModal" tabindex="-1" aria-labelledby="editInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="editInfoModalLabel">Modifier les informations personnelles</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="firstName" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="firstName" value="Prénom">
          </div>
          <div class="mb-3">
            <label for="lastName" class="form-label">Nom</label>
            <input type="text" class="form-control" id="lastName" value="Nom">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Téléphone</label>
            <input type="tel" class="form-control" id="phone" value="237 6 78 90 12 34">
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="address" value="BP 1234, Yaoundé, Cameroun">
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-pink">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="editHealthModal" tabindex="-1" aria-labelledby="editHealthModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="editHealthModalLabel">Modifier les informations de santé</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="allergies" class="form-label">Allergies connues</label>
            <input type="text" class="form-control" id="allergies" value="Pénicilline">
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-pink">Enregistrer les modifications</button>
          </div>
        </form>
      </div>
      <div class="modal-footer text-muted">
        <small>Pour toute modification majeure (statut sérologique, code TARV), veuillez contacter votre APS.</small>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="changePasswordModalLabel">Changer le mot de passe</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Mot de passe actuel</label>
            <input type="password" class="form-control" id="currentPassword" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="newPassword" required>
          </div>
          <div class="mb-3">
            <label for="confirmNewPassword" class="form-label">Confirmer le nouveau mot de passe</label>
            <input type="password" class="form-control" id="confirmNewPassword" required>
          </div>
          <div class="d-grid mt-4">
            <button type="submit" class="btn btn-pink">Changer le mot de passe</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection