<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Inscription APS</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
  <style>
    body {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(to bottom, #ffe6f0, #fff);
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      max-width: 750px;
      width: 100%;
    }
    .btn-danger {
      background-color: #e75480;
      border: none;
    }
    .btn-danger:hover {
      background-color: #c7436e;
    }
    .logo {
      width: 90px;
      display: block;
      margin: 0 auto 15px auto;
    }
    h2 {
      color: #e75480;
      font-weight: 700;
    }
    .input-group-text {
      background-color: #f8d7da;
      color: #e75480;
      border: none;
    }
    .form-control, .form-select {
      border-left: none;
    }
  </style>
</head>
<body>
  <div class="container px-3">
    <div class="card p-4 mx-auto">
      <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" class="logo">
      <h2 class="text-center mb-4">Inscription APS</h2>

      <!-- Bouton retour -->
      <div class="mb-3">
        <a href="{{ route('inscription') }}" class="btn btn-outline-secondary btn-sm">
          <i class="bi bi-arrow-left"></i> Retour
        </a>
      </div>

      <form method="POST" action="{{ route('inscription.aps') }}" enctype="multipart/form-data">
        @csrf

        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="nom" class="form-control" placeholder="Nom" required>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
              <select name="sexe" class="form-select" required>
                <option value="">Sexe</option>
                <option value="Homme">Homme</option>
                <option value="Femme">Femme</option>
              </select>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone"></i></span>
              <input type="tel" name="telephone" class="form-control" placeholder="Téléphone" required>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
            <input type="text" name="adresse" class="form-control" placeholder="Adresse" required>
          </div>
        </div>

        <div class="mb-3">
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
            <input type="file" name="attestation" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-envelope"></i></span>
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-telephone-plus"></i></span>
              <input type="tel" name="telephone_alt" class="form-control" placeholder="Téléphone secondaire">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock"></i></span>
              <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
              <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer mot de passe" required>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-danger w-100">
          <i class="bi bi-person-check"></i> S'inscrire
        </button>

        <!-- raccourci connexion -->
        <div class="text-center mt-3">
          <p>Déjà inscrit ? 
            <a href="{{ route('connexion') }}" class="text-danger fw-bold">
              <i class="bi bi-box-arrow-in-right"></i> Se connecter
            </a>
          </p>
        </div>
      </form>
    </div>
  </div>
</body>
</html>
