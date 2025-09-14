<style>
    :root {
        --primary-pink: #D01168;
        --secondary-light: #f8f9fa;
        --dark-gray: #212529;
    }

    .topbar {
        background-color: white;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 1020;
    }

    /* Style du logo et titre */
    .topbar-brand {
        display: flex;
        align-items: center;
    }

    .topbar-brand .logo-icon {
        color: var(--primary-pink);
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }

    .topbar-brand .brand-text {
        color: var(--dark-gray);
        font-weight: 600;
        font-size: 1.25rem;
    }

    /* Style de la barre de recherche */
    .search-bar .form-control {
        border-radius: 2rem;
        background-color: var(--secondary-light);
        border: none;
        padding: 0.5rem 1rem;
        padding-left: 2.5rem;
        transition: background-color 0.3s ease;
    }

    .search-bar .form-control:focus {
        background-color: white;
        box-shadow: 0 0 0 0.25rem rgba(208, 17, 104, 0.1);
    }

    .search-bar .input-group-text {
        background-color: transparent;
        border: none;
        color: var(--primary-pink);
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }

    /* Style des icônes de la topbar */
    .topbar-icons .btn {
        color: var(--dark-gray);
        font-size: 1.25rem;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: background-color 0.3s ease, color 0.3s ease;
        position: relative;
    }

    .topbar-icons .btn:hover {
        background-color: var(--secondary-light);
        color: var(--primary-pink);
    }
    
    .topbar-icons .badge {
        position: absolute;
        top: 5px;
        right: 5px;
        font-size: 0.6rem;
        padding: 0.3em 0.5em;
        border-radius: 50%;
        background-color: var(--primary-pink);
    }

    /* Style du menu de profil */
    .profile-dropdown .profile-img {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid transparent;
        transition: border-color 0.3s ease;
    }

    .profile-dropdown:hover .profile-img {
        border-color: var(--primary-pink);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        border-radius: 0.75rem;
        animation: slideIn 0.3s ease-out;
    }

    .dropdown-item {
        padding: 0.75rem 1.5rem;
        transition: background-color 0.3s ease;
    }

    .dropdown-item:active, .dropdown-item:hover {
        background-color: var(--secondary-light);
        color: var(--primary-pink) !important;
    }
    
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<nav class="topbar d-flex flex-grow-1">
    <div class="topbar-brand d-none d-md-flex">
        <i class="bi bi-hospital logo-icon"></i>
        <span class="brand-text">Tableau de bord</span>
    </div>

    <div class="search-bar d-flex justify-content-center flex-grow-1 mx-4">
        <div class="input-group" style="max-width: 500px;">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" placeholder="Rechercher...">
        </div>
    </div>

    <div class="topbar-icons d-flex align-items-center gap-3">
        <a href="#" class="btn btn-sm btn-icon position-relative">
            <i class="bi bi-bell"></i>
            <span class="badge text-bg-danger">3</span>
        </a>
        
        <a href="#" class="btn btn-sm btn-icon position-relative">
            <i class="bi bi-envelope"></i>
            <span class="badge text-bg-danger">5</span>
        </a>
        
        <div class="dropdown profile-dropdown">
            <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="/images/profile.png" alt="mdo" class="profile-img">
            </a>
            <ul class="dropdown-menu text-small shadow dropdown-menu-end">
                <li>
                    <h6 class="dropdown-header">
                        {{ Auth::user()->nom }} {{ Auth::user()->prenom }}
                    </h6>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('patient.dossier_medical') }}">Mon dossier</a></li>
                <li><a class="dropdown-item" href="{{ route('patient.profil') }}">Paramètres</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">Déconnexion</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>