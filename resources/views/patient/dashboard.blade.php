<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Patient</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: #dc3545;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 0;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        .content {
            padding: 20px;
        }
        .card {
            border-radius: 15px;
        }
    </style>
</head>
<body>
<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar p-3">
        <h4 class="text-center mb-4">Mon Espace</h4>
        <a href="#">🏠 Tableau de bord</a>
        <a href="#">📋 Mes infos</a>
        <a href="#">📅 Rendez-vous</a>
        <a href="#">💊 Médicaments</a>
        <a href="#">📩 Messages</a>
        <a href="{{ route('logout') }}">🚪 Déconnexion</a>
    </div>

    <!-- Contenu principal -->
    <div class="content flex-grow-1">
        <h2 class="mb-4">Bienvenue, {{ Auth::user()->name ?? 'Patient' }} 👋</h2>

        <div class="row g-4">
            <!-- Infos personnelles -->
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <h5>Mes Informations</h5>
                    <p><strong>ID Patient :</strong> {{ Auth::user()->id ?? '' }}</p>
                    <p><strong>Email :</strong> {{ Auth::user()->email ?? '' }}</p>
                    <p><strong>Statut sérologique :</strong> Positif</p>
                    <p><strong>Code TARV :</strong> TARV12345</p>
                </div>
            </div>

            <!-- Rendez-vous -->
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <h5>Prochains Rendez-vous</h5>
                    <ul>
                        <li>10/09/2025 - Consultation</li>
                        <li>20/09/2025 - Suivi biologique</li>
                    </ul>
                    <a href="#" class="btn btn-danger btn-sm">Voir tous</a>
                </div>
            </div>

            <!-- Médicaments -->
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <h5>Mes Médicaments</h5>
                    <p>ARV - 2 comprimés/jour</p>
                    <p>Prochain rappel : 18h00</p>
                </div>
            </div>

            <!-- Messages -->
            <div class="col-md-6">
                <div class="card p-3 shadow-sm">
                    <h5>Messages</h5>
                    <p><strong>APS:</strong> N’oubliez pas votre prochain contrôle.</p>
                    <a href="#" class="btn btn-outline-danger btn-sm">Lire plus</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
