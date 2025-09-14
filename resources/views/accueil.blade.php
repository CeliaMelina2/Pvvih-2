<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Accueil - Feeling H+</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    :root {
      --primary-pink: #D01168; /* Rose foncé */
      --secondary-gray: #f8f9fa; /* Blanc cassé pour les sections */
      --dark-gray: #212529;
    }
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .navbar {
      background-color: rgba(255, 255, 255, 0.9) !important;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      border-radius: 12px;
      margin: 10px 20px;
      left: 0;
      right: 0;
      position: fixed;
      z-index: 1050;
    }
    .navbar-brand .logo-text {
      color: var(--primary-pink);
      font-weight: 800;
    }
    .btn-primary-custom {
      background: linear-gradient(90deg, #FF69B4, var(--primary-pink));
      border: none;
      color: white;
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 12px;
      box-shadow: 0 4px 15px rgba(208, 17, 104, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .btn-primary-custom:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(208, 17, 104, 0.5);
    }
    .btn-outline-custom {
      border: 2px solid var(--primary-pink);
      color: var(--primary-pink);
      font-weight: 600;
      padding: 12px 24px;
      border-radius: 12px;
      transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
    }
    .btn-outline-custom:hover {
      background-color: var(--primary-pink);
      color: white;
      transform: translateY(-2px);
    }
    .hero-section {
      padding-top: 150px;
      padding-bottom: 80px;
      position: relative;
      overflow: hidden;
      background-color: var(--secondary-gray);
    }
    .hero-title {
      font-size: 3rem;
      font-weight: 700;
      line-height: 1.2;
    }
    .hero-title .text-primary-pink {
      color: var(--primary-pink);
    }
    .hero-subtitle {
      font-size: 1.5rem;
      font-weight: 400;
      color: #6c757d;
    }
    .feature-card {
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
      border-radius: 12px;
      background-color: white;
    }
    .feature-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    .feature-icon-wrapper {
      background-color: rgba(208, 17, 104, 0.1);
      display: inline-flex;
      padding: 1rem;
      border-radius: 10px;
    }
    .testimonial-card {
      border: none;
      border-radius: 12px;
      background-color: white;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .testimonial-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    .footer-section {
      background-color: var(--dark-gray);
      color: white;
      padding-top: 4rem;
      padding-bottom: 2rem;
    }
    .footer-link a {
      color: #adb5bd;
      transition: color 0.2s ease;
      text-decoration: none;
    }
    .footer-link a:hover {
      color: var(--primary-pink);
    }
    .social-icon {
        font-size: 1.5rem;
        transition: color 0.2s ease;
    }
    .social-icon:hover {
        color: var(--primary-pink) !important;
    }
    .footer-heading {
        color: white;
        font-weight: 600;
        margin-bottom: 1rem;
    }
  </style>
</head>
<body class="bg-white">

<nav class="navbar navbar-expand-lg navbar-light shadow-sm">
  <div class="container-fluid mx-md-5">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="40" class="me-2">
      <span class="logo-text">Feeling H+</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 fw-bold">
        <li class="nav-item"><a class="nav-link" href="#presentation">Présentation</a></li>
        <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="#temoignages">Témoignages</a></li>
        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
      </ul>
      <div class="d-flex ms-lg-3 gap-2">
          <a href="{{ route('connexion') }}" class="btn btn-outline-custom">Connexion</a>
          <a href="{{ route('inscription') }}" class="btn btn-primary-custom">Inscription</a>
      </div>
    </div>
  </div>
</nav>

<section id="hero" class="hero-section">
  <div class="container position-relative z-index-2">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0 animate__animated animate__fadeInLeft">
        <h1 class="hero-title mb-3">
          Votre santé, notre <span class="text-primary-pink">priorité.</span>
        </h1>
        <h2 class="hero-subtitle mb-4">
          La solution de suivi médical intelligente pour un avenir plus sain.
        </h2>
        <p class="lead text-muted mb-4">
          Feeling H+ est une plateforme dédiée au suivi médical des patients PVVIH et des Accompagnateurs Psycho-Sociaux (APS). Nous offrons un accompagnement sécurisé, fiable et accessible pour une meilleure gestion de la santé.
        </p>
        <div class="d-flex gap-3 mt-4">
          <a href="{{ route('inscription') }}" class="btn btn-primary-custom">Rejoignez-nous</a>
          <a href="#services" class="btn btn-outline-custom">Découvrir les services</a>
        </div>
      </div>
      <div class="col-lg-6 position-relative text-center animate__animated animate__fadeInRight">
        <div id="carouselPVVIH" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner rounded-3 shadow-lg">
            <div class="carousel-item active">
              <img src="{{ asset('images/fond2.jpeg') }}" class="d-block w-100" alt="Suivi médical intelligent">
              <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                <h5>Suivi médical intelligent</h5>
              </div>
            </div>
            <div class="carousel-item">
              <img src="{{ asset('images/collect.webp') }}" class="d-block w-100" alt="Collecte sécurisée">
              <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                <h5>Collecte sécurisée</h5>
              </div>
            </div>
            <div class="carousel-item">
              <img src="{{ asset('images/stat1.webp') }}" class="d-block w-100" alt="Statistiques médicales">
              <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2">
                <h5>Statistiques médicales</h5>
              </div>
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselPVVIH" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselPVVIH" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="presentation-services" class="py-5 bg-white">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0 animate__animated animate__fadeInLeft">
        <h2 class="fw-bold mb-3 text-primary-pink">
          Une plateforme conçue pour vous.
        </h2>
        <p class="lead text-muted">
          Feeling H+ est plus qu'une simple application. C'est un écosystème de santé intelligent qui connecte les patients, les soignants et les professionnels pour un suivi plus efficace et une meilleure qualité de vie.
        </p>
        <div class="d-flex align-items-center mb-3">
          <i class="bi bi-person-fill-check fs-2 text-primary-pink me-3"></i>
          <div>
            <h5 class="fw-bold mb-0">Pour les patients</h5>
            <p class="text-muted mb-0">Suivi personnalisé, rappels de médicaments, et accès à vos données en toute sécurité.</p>
          </div>
        </div>
        <div class="d-flex align-items-center mb-3">
          <i class="bi bi-clipboard-data-fill fs-2 text-primary-pink me-3"></i>
          <div>
            <h5 class="fw-bold mb-0">Pour les professionnels</h5>
            <p class="text-muted mb-0">Gestion de dossier, statistiques en temps réel, et communication simplifiée.</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 animate__animated animate__fadeInRight">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="card feature-card text-center p-4 h-100">
              <div class="card-body">
                <i class="bi bi-heart-pulse-fill fs-1 text-primary-pink mb-3"></i>
                <h5 class="fw-bold">Suivi Médical</h5>
                <p class="text-muted">Un suivi personnalisé pour chaque patient.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card feature-card text-center p-4 h-100">
              <div class="card-body">
                <i class="bi bi-shield-lock-fill fs-1 text-primary-pink mb-3"></i>
                <h5 class="fw-bold">Sécurité</h5>
                <p class="text-muted">Protection totale des données médicales sensibles.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card feature-card text-center p-4 h-100">
              <div class="card-body">
                <i class="bi bi-bar-chart-line-fill fs-1 text-primary-pink mb-3"></i>
                <h5 class="fw-bold">Statistiques</h5>
                <p class="text-muted">Des analyses fiables pour améliorer le service.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card feature-card text-center p-4 h-100">
              <div class="card-body">
                <i class="bi bi-headset fs-1 text-primary-pink mb-3"></i>
                <h5 class="fw-bold">Support 24/7</h5>
                <p class="text-muted">Notre équipe est toujours là pour vous aider.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="temoignages" class="py-5 bg-secondary-gray">
  <div class="container">
    <h2 class="text-center fw-bold mb-5 text-dark-gray">Ce qu'ils disent de nous</h2>
    <div class="row g-4">
      <div class="col-md-6 animate__animated animate__fadeInUp">
        <div class="p-4 rounded shadow-sm h-100 testimonial-card">
          <i class="bi bi-quote fs-3 text-muted"></i>
          <p class="fst-italic">"Feeling H+ a transformé ma routine de suivi médical. Je me sens plus en contrôle de ma santé et mieux accompagné au quotidien. Un outil indispensable."</p>
          <div class="d-flex align-items-center mt-3">
            <div class="p-2 bg-primary-pink rounded-circle me-3"><i class="bi bi-person-fill text-white"></i></div>
            <div class="fw-bold text-primary-pink">Patient</div>
          </div>
        </div>
      </div>
      <div class="col-md-6 animate__animated animate__fadeInUp animate__delay-1s">
        <div class="p-4 rounded shadow-sm h-100 testimonial-card">
          <i class="bi bi-quote fs-3 text-muted"></i>
          <p class="fst-italic">"Grâce à cette plateforme, la gestion des dossiers et le suivi de mes patients sont devenus incroyablement simples et efficaces. Cela facilite grandement mon travail d'accompagnement psychosocial."</p>
          <div class="d-flex align-items-center mt-3">
            <div class="p-2 bg-primary-pink rounded-circle me-3"><i class="bi bi-people-fill text-white"></i></div>
            <div class="fw-bold text-primary-pink">Accompagnateur APS</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="contact" class="py-5 bg-white">
  <div class="container text-center animate__animated animate__fadeInUp">
    <h2 class="fw-bold mb-4 text-primary-pink">Rejoignez-nous</h2>
    <p class="text-muted mb-4">Abonnez-vous à notre newsletter pour recevoir les dernières nouvelles et mises à jour.</p>
    <form class="d-flex flex-column flex-sm-row justify-content-center gap-3">
      <input type="email" class="form-control form-control-lg rounded-pill" placeholder="Votre adresse email" required>
      <button type="submit" class="btn btn-primary-custom rounded-pill">S'abonner</button>
    </form>
  </div>
</section>

<footer class="footer-section">
  <div class="container">
    <div class="row py-5">
      <div class="col-lg-4 mb-4 mb-lg-0">
        <a class="navbar-brand d-flex align-items-center mb-3" href="#">
          <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="40" class="me-2">
          <span class="logo-text text-white">Feeling H+</span>
        </a>
        <p class="text-white-50">Feeling H+ est votre partenaire de santé numérique, offrant des solutions innovantes pour les patients et les professionnels du secteur.</p>
        <div class="d-flex mt-4 gap-3">
            <a href="#" class="text-white-50"><i class="bi bi-twitter social-icon"></i></a>
            <a href="#" class="text-white-50"><i class="bi bi-facebook social-icon"></i></a>
            <a href="#" class="text-white-50"><i class="bi bi-instagram social-icon"></i></a>
            <a href="#" class="text-white-50"><i class="bi bi-linkedin social-icon"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
        <h5 class="footer-heading">Services</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="footer-link">Suivi médical</a></li>
          <li class="mb-2"><a href="#" class="footer-link">Sécurité</a></li>
          <li class="mb-2"><a href="#" class="footer-link">Statistiques</a></li>
          <li class="mb-2"><a href="#" class="footer-link">Support</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-4 mb-4 mb-md-0">
        <h5 class="footer-heading">À Propos</h5>
        <ul class="list-unstyled">
          <li class="mb-2"><a href="#" class="footer-link">Notre mission</a></li>
          <li class="mb-2"><a href="#" class="footer-link">Équipe</a></li>
          <li class="mb-2"><a href="#" class="footer-link">Témoignages</a></li>
          <li class="mb-2"><a href="#" class="footer-link">Carrières</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-4">
        <h5 class="footer-heading">Contact</h5>
        <ul class="list-unstyled text-white-50">
          <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>123 Rue de la Santé, Ville</li>
          <li class="mb-2"><i class="bi bi-envelope me-2"></i>info@feelinghplus.com</li>
          <li class="mb-2"><i class="bi bi-phone me-2"></i>+123 456 7890</li>
        </ul>
      </div>
    </div>
    <hr class="border-white-50 my-4">
    <div class="row">
        <div class="col-12 text-center text-white-50">
            <p class="mb-0">&copy; 2025 Feeling H+. Tous droits réservés. <a href="#" class="text-white-50">Mentions légales</a> | <a href="#" class="text-white-50">Politique de confidentialité</a></p>
        </div>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>