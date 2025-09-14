<aside class="d-flex flex-column vh-100 p-3 bg-danger text-white" style="width: 250px;">
    <!-- Logo / Header -->
    <a href="{{ route('patient.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded">
        <span class="fs-4 fw-bold">Feeling H+</span>
    </a>
    <hr class="border-light">

    <!-- User Info -->
    <div class="d-flex align-items-center mb-3">
        <img src="/images/profile.png" class="rounded-circle me-2" width="50" height="50" alt="Profil">
        <div>
            <div class="fw-bold">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</div>
            <small class="text-white-50">{{ Auth::user()->role_user }}</small>
        </div>
    </div>
    <hr class="border-light">

    <!-- Navigation Menu -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item mb-1">
            <a href="{{ route('patient.dashboard') }}" class="nav-link {{ request()->routeIs('patient.dashboard') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('patient.rendezvous') }}" class="nav-link {{ request()->routeIs('patient.rendezvous') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                <i class="bi bi-calendar-check me-2"></i> Mes rendez-vous
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('patient.traitement') }}" class="nav-link {{ request()->routeIs('patient.traitement') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                <i class="bi bi-capsule me-2"></i> Mes traitements
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('patient.dossier_medical') }}" class="nav-link {{ request()->routeIs('patient.dossier') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                <i class="bi bi-folder2-open me-2"></i> Mon dossier médical
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('patient.message') }}" class="nav-link {{ request()->routeIs('patient.message') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                <i class="bi bi-chat-dots me-2"></i> Messages
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('patient.profil') }}" class="nav-link {{ request()->routeIs('patient.profil') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                <i class="bi bi-person me-2"></i> Profil
            </a>
        </li>
    </ul>

    <hr class="border-light">

    <!-- Footer / Settings & Logout -->
    <div class="mt-auto">
        <a href="{{ route('patient.profil') }}" class="d-block mb-2 text-white text-decoration-none">
            <i class="bi bi-gear me-2"></i> Paramètres du compte
        </a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
            </button>
        </form>
    </div>
</aside>
