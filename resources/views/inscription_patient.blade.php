<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription APS - Feeling H+</title>
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
        }
        .register-container {
            padding: 2rem 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .register-card {
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
        .logo {
            width: 90px;
            height: 90px;
        }
        .title {
            font-weight: 700;
            color: var(--primary-pink);
            margin-top: 1rem;
        }
        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
            padding: 0.75rem 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-pink);
            box-shadow: 0 0 0 0.25rem rgba(208, 17, 104, 0.25);
        }
        .input-group-text {
            background-color: white;
            border: 1px solid #dee2e6;
            border-right: none;
            border-radius: 0.5rem 0 0 0.5rem;
            color: var(--primary-pink);
        }
        .input-group .form-control {
            border-left: none;
            border-radius: 0 0.5rem 0.5rem 0;
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
        .btn-back {
            color: #6c757d;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        .btn-back:hover {
            color: #212529;
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
        @media (max-width: 767.98px) {
            .register-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
<div class="container register-container">
    <div class="row justify-content-center w-100">
        <div class="col-md-9 col-lg-8">
            <div class="register-card">

                <div class="text-center mb-4">
                    <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" class="logo mb-2">
                    <h2 class="title">Inscription Patient</h2>
                </div>

                <div class="mb-3">
                    <a href="{{ route('inscription') }}" class="btn-back">
                        <i class="bi bi-arrow-left me-1"></i> Retour
                    </a>
                </div>

                <form method="POST" action="{{ route('inscription.patient') }}" enctype="multipart/form-data">
                    @csrf


                    <!-- Bloc pour afficher les erreurs -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="row g-3">
                        <!-- Colonne gauche -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez votre nom" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="prenom" class="form-label">Prénom</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" name="prenom" id="prenom" class="form-control" placeholder="Entrez votre prénom" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="sexe" class="form-label">Sexe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                                    <select name="sexe" id="sexe" class="form-select" required>
                                        <option value="">-- Sélectionnez --</option>
                                        <option value="Homme">Homme</option>
                                        <option value="Femme">Femme</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="telephone" id="telephone" class="form-control" placeholder="Entrez votre téléphone" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" name="adresse" id="adresse" class="form-control" placeholder="Entrez votre adresse" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="statut_serologique" class="form-label">Statut sérologique</label>
                                <input type="text" name="statut_serologique" id="statut_serologique" class="form-control" value="{{ old('statut_serologique') }}" required>
                            </div>

                        </div>

                        <!-- Colonne droite -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="attestation" class="form-label">Attestation de fonction</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-file-earmark-text"></i></span>
                                    <input type="file" name="attestation" id="attestation" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Entrez votre email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Créez un mot de passe" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirmez votre mot de passe" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="date_diagnostic" class="form-label">Date du diagnostic</label>
                                <input type="date" name="date_diagnostic" id="date_diagnostic" class="form-control" value="{{ old('date_diagnostic') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="codeTARV" class="form-label">Code TARV</label>
                                <input type="text" name="codeTARV" id="codeTARV" class="form-control" value="{{ old('codeTARV') }}" required>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary-custom w-100 mt-4">
                        <i class="bi bi-person-check me-1"></i> S'inscrire
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0">
                        Déjà inscrit ?
                        <a href="{{ route('connexion') }}" class="text-link fw-bold">Se connecter</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
