<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription APS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #ffe6f0, #fff);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn-danger {
            background-color: #e75480;
            border: none;
        }
        .btn-danger:hover {
            background-color: #c7436e;
        }
        .logo {
            width: 100px;
            display: block;
            margin: 0 auto 20px auto;
        }
        h2 {
            color: #e75480;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="card p-4 mx-auto" style="max-width: 650px;">
        <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" class="logo">
        <h2 class="text-center mb-4">Inscription APS</h2>

         <!-- Bouton retour -->
    <div class="mb-3">
        <a href="{{ route('inscription') }}" class="btn btn-outline-secondary btn-sm">← Retour</a>
    </div>

        <form method="POST" action="{{ route('inscription.aps') }}" enctype="multipart/form-data">
            @csrf


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Nom</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Prénom</label>
                    <input type="text" name="prenom" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Sexe</label>
                <select name="sexe" class="form-select" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="Homme">Homme</option>
                    <option value="Femme">Femme</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Téléphone</label>
                <input type="tel" name="telephone" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Adresse</label>
                <input type="text" name="adresse" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Attestation de fonction (PDF/Image)</label>
                <input type="file" name="attestation" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirmer mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger w-100">S'inscrire</button>

            <!-- raccourci connexion -->
            <div class="text-center mt-3">
                <p>Déjà inscrit ? <a href="{{ route('connexion') }}" class="text-danger fw-bold">Se connecter</a></p>
            </div>
        </form>
    </div>
</div>
</body>
</html>
