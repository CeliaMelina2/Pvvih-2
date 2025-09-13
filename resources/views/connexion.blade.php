<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion PVVIH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width: 500px;">

    <!-- Logo centré -->
    <div class="text-center mb-4">
        <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="80" class="mb-2">
        <h2 class="text-danger">Connexion</h2>
    </div>

    <!-- Formulaire -->
    <div class="card shadow p-4">
        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <form method="POST" action="{{ route('connexion.submit') }}">
            @csrf
            <input type="email" name="email" placeholder="Email" required class="form-control mb-2">
            <input type="password" name="password" placeholder="Mot de passe" required class="form-control mb-2">
            <button type="submit" class="btn btn-danger w-100">Se connecter</button>
        </form>

        <!-- Lien vers inscription -->
        <div class="mt-3 text-center">
            <p>Pas encore inscrit ?
                <a href="{{ route('inscription') }}" class="text-danger">Créer un compte</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
