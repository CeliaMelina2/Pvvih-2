<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffe6f0, #fff);
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-danger {
            border-radius: 25px;
        }
        .form-control {
            border-radius: 10px;
        }
        .logo {
            max-width: 120px;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card p-4 w-100" style="max-width: 600px;">

        <!-- Logo -->
        <div class="text-center mb-3">
            <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" class="logo mb-2">
            <h2 class="text-danger fw-bold">Inscription Patient</h2>
        </div>

        <!-- Bouton retour -->
        <div class="mb-3">
            <a href="{{ route('inscription') }}" class="btn btn-outline-secondary btn-sm">← Retour</a>
        </div>

        <!-- Formulaire -->
        <form method="POST" action="{{ route('inscription.patient') }}">
            @csrf


            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
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
            <input type="text" name="telephone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Adresse</label>
            <input type="text" name="adresse" class="form-control" required>
        </div>

        <div class="mb-3">
                <label>Statut sérologique</label>
                <select name="statut_serologique" class="form-select" required>
                    <option value="">-- Sélectionnez --</option>
                    <option value="Positif">Positif</option>
                    <option value="Négatif">Négatif</option>
                </select>
        </div>

        <div class="mb-3">
            <label>Date de diagnostic</label>
            <input type="date" name="date_diagnostic" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Code TARV</label>
            <input type="text" name="codeTARV" class="form-control" required>
        </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmer mot de passe</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger w-100">S'inscrire</button>
        </form>

        <!-- Lien connexion -->
        <div class="text-center mt-3">
            <p>Déjà inscrit ? <a href="{{ route('connexion') }}" class="text-danger fw-bold">Se connecter</a></p>
        </div>
    </div>
</div>
</body>
</html>
