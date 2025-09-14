<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Feeling H+</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-pink: #D01168;
            --secondary-light: #f8f9fa;
        }
        body {
            background-color: var(--secondary-light);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            background-color: white;
            animation: fadeIn 0.8s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo-container {
            margin-bottom: 2rem;
        }
        .logo {
            width: 90px;
            height: 90px;
            object-fit: cover;
        }
        .title {
            font-weight: 700;
            color: var(--primary-pink);
            margin-top: 1rem;
        }
        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 0.25rem rgba(208, 17, 104, 0.25);
        }
        .btn-primary-custom {
            background-color: var(--primary-pink);
            border: none;
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }
        .btn-primary-custom:hover {
            background-color: #A00B52;
            transform: translateY(-2px);
        }
        .text-link {
            color: var(--primary-pink);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .text-link:hover {
            color: #A00B52;
            text-decoration: underline;
        }
        .alert-custom {
            border-radius: 0.5rem;
            background-color: rgba(208, 17, 104, 0.1);
            color: #8a0e44;
            border: 1px solid rgba(208, 17, 104, 0.2);
        }
    </style>
</head>
<body>

<div class="login-card text-center">
    <div class="logo-container">
        <img src="{{ asset('images/LOGOV.png') }}" alt="Logo Feeling H+" class="logo">
        <h2 class="title">Se connecter</h2>
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger alert-custom">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('connexion.submit') }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Adresse email" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
        </div>
        <button type="submit" class="btn btn-primary-custom w-100 mt-3">
            Se connecter
        </button>
    </form>

    <div class="mt-4">
        <p class="text-muted mb-1">
            Pas encore inscrit ?
        </p>
        <a href="{{ route('inscription') }}" class="text-link">Créer un compte</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>