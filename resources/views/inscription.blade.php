<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choix d'inscription</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #ffe6f0, #fff);
        }
        .card {
            border-radius: 15px;
            transition: transform 0.3s;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }
        .card img {
            width: 100%;
            height: 400px; /* proche du A5 en vertical */
            object-fit: cover;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5 text-center">
    <h2 class="mb-4 text-danger">Choisissez votre type d'inscription</h2>

    <div class="d-flex justify-content-center gap-5">

        <!-- Patient -->
        <div class="card card-choice">
            <img src="{{ asset('images/2222.jpeg') }}" alt="Patient" class="img-fluid">
            <div class="card-body">
                <h5 class="card-title">Patient</h5>
                <a href="{{ route('inscription.patient') }}" class="btn btn-danger w-100">S'inscrire</a>
            </div>
        </div>

        <!-- APS -->
        <div class="card card-choice">
            <img src="{{ asset('images/fond3.webp') }}" alt="APS" class="img-fluid">
            <div class="card-body">
                <h5 class="card-title">APS</h5>
                <a href="{{ route('inscription.aps') }}" class="btn btn-danger w-100">S'inscrire</a>
            </div>
        </div>

    </div>
</div>

</body>
</html>
