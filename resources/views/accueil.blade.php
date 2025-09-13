<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil PVVIH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffe6f0, #fff);
        }
        .navbar-brand {
            color: #e75480 !important;
            font-weight: bold;
        }
        .carousel-inner img {
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
        }
        .carousel-caption {
            background: rgba(231, 84, 128, 0.5);
            border-radius: 10px;
            padding: 10px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('accueil') }}">
            <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="50" height="50" class="me-2"> Feeling H+
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item"><a class="nav-link" href="{{ route('connexion') }}">Connexion</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('inscription') }}">Inscription</a></li>
                @else
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-danger nav-link" style="border:none;">Déconnexion</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Carrousel -->
<div id="carouselPVVIH" class="carousel slide container mt-4" data-bs-ride="carousel">
    <div class="carousel-inner">

        <!-- Slide 1 -->
        <div class="carousel-item active">
            <div class="row align-items-center">
                <!-- Texte à gauche -->
                <div class="col-md-6 p-4">
                    <h2 class="text-danger fw-bold fs-1">Suivi des patients PVVIH</h2>
                    <p class="text-muted fs-4">Une gestion moderne et efficace.</p>
                </div>
                <!-- Image à droite -->
                <div class="col-md-6">
                    <img src="{{ asset('images/fond2.jpeg') }}" class="d-block w-100 rounded" alt="Image 1">
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="carousel-item">
            <div class="row align-items-center">
                <div class="col-md-6 p-4">
                    <h2 class="text-danger fw-bold fs-1">Collecte des données sécurisée</h2>
                    <p class="text-muted fs-4">Pour un meilleur suivi et une analyse efficace.</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/collect.webp') }}" class="d-block w-100 rounded" alt="Image 2">
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="carousel-item">
            <div class="row align-items-center">
                <div class="col-md-6 p-4">
                    <h2 class="text-danger fw-bold fs-1">Amélioration continue du service</h2>
                    <p class="text-muted fs-4">Grâce à des statistiques fiables et détaillées.</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ asset('images/stat1.webp') }}" class="d-block w-100 rounded" alt="Image 3">
                </div>
            </div>
        </div>

    </div>

    <!-- Boutons navigation -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselPVVIH" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselPVVIH" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>



<!-- Footer -->
<footer class="text-center mt-5 mb-3">
    <p>&copy; 2025 Feeling H+. Tous droits réservés.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
