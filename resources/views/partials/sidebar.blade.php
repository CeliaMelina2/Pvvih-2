
    @php 
        $role = auth()->user()->role;
        $name = auth()->user()->name;
        $email = auth()->user()->email;
    @endphp
    @if($role === 'patient')

        <aside class="d-flex flex-column vh-100 p-3 bg-danger text-white" style="width: 250px;">
            <a href="{{ route('patient.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded">
                <span class="fs-4 fw-bold">Feeling H+</span>
            </a>
            <hr class="border-light">

            <div class="d-flex align-items-center mb-3">
                <img src="/images/profile.png" class="rounded-circle me-2" width="50" height="50" alt="Profil">
                <div>
                    <div class="fw-bold">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</div>
                    <small class="text-white-50">{{ Auth::user()->role_user }}</small>
                </div>
            </div>
            <hr class="border-light">

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
                    <a href="{{ route('patient.dossier_medical') }}" class="nav-link {{ request()->routeIs('patient.dossier_medical') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                        <i class="bi bi-folder2-open me-2"></i> Mon dossier médical
                    </a>
                </li>
                                 <li class="nav-item mb-1">
                    <a href="{{ route('patient.assistant.view') }}" class="nav-link {{ request()->routeIs('patient.assistant.view') ? 'active bg-white text-danger' : 'text-white' }} rounded">
                        <i class="bi bi-person me-2"></i> Assistant VIH
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

    @endif

    @if($role === 'admin')
        <aside class="d-flex flex-column vh-100 p-3 bg-danger text-white" style="width: 250px;">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded">
                <span class="fs-4 fw-bold">Feeling H+</span>
            </a>
            <hr class="border-light">

            <div class="d-flex align-items-center mb-3">
                <img src="/images/profile.png" class="rounded-circle me-2" width="50" height="50" alt="Profil">
                <div>
                    <div class="fw-bold">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</div>
                    <small class="text-white-50">Administrateur</small>
                </div>
            </div>
            <hr class="border-light">

            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-people me-2"></i> Gestion des utilisateurs
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.patients.index') }}" class="nav-link {{ request()->routeIs('admin.patients.*') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-person-vcard me-2"></i> Gestion des patients
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="{{ route('admin.aps.index') }}" class="nav-link {{ request()->routeIs('admin.aps.*') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-heart-pulse me-2"></i> Gestion des APS
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="" class="nav-link {{ request()->routeIs('admin.rendezvous.*') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-calendar-check me-2"></i> Tous les rendez-vous
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="" class="nav-link {{ request()->routeIs('admin.traitements.*') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-capsule me-2"></i> Gestion des traitements
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-chat-dots me-2"></i> Messages système
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="" class="nav-link {{ request()->routeIs('admin.rapports.*') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-graph-up me-2"></i> Rapports & Statistiques
                    </a>
                </li>
                <li class="nav-item mb-1">
                    <a href="" class="nav-link {{ request()->routeIs('admin.parametres') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-gear me-2"></i> Paramètres système
                    </a>
                </li>
            </ul>

            <hr class="border-light">

            <!-- Footer / Settings & Logout -->
            <div class="mt-auto">
                <a href="" class="d-block mb-2 text-white text-decoration-none">
                    <i class="bi bi-person me-2"></i> Mon profil
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                    </button>
                </form>
            </div>
        </aside>
    @endif



@if($role === 'aps')
    <!-- Barre latérale de navigation de l'APS -->
    <aside class="d-flex flex-column vh-100 p-3 bg-danger text-white" style="width: 250px;">
        
        <!-- Logo et nom de l'application -->
        <a href="{{ route('aps.dashboard') }}" class="d-flex align-items-center mb-4 me-md-auto text-white text-decoration-none">
            <img src="{{ asset('images/LOGOV.png') }}" alt="Logo" width="40" height="40" class="me-2 rounded-circle">
            <span class="fs-4 fw-bold">Feeling H+</span>
        </a>
        <hr class="border-light">

        <!-- Informations de l'utilisateur APS -->
        <div class="d-flex align-items-center mb-3">
            <img src="" class="rounded-circle me-3" alt="Avatar">
            <div>
                <div class="fw-bold">Dimitri</div>
                <small class="text-white-50 text-uppercase">aps</small>
            </div>
        </div>
        <hr class="border-light">

        <!-- Menu de navigation -->
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item mb-1">
                <a href="{{ route('aps.dashboard') }}" class="nav-link {{ request()->routeIs('aps.dashboard') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                    <i class="bi bi-speedometer2 me-2"></i> Tableau de bord
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('aps.patients.index') }}" class="nav-link {{ request()->routeIs('aps.patients.index') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                    <i class="bi bi-people-fill me-2"></i> Mes patients
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('aps.rendezvous.index') }}" class="nav-link {{ request()->routeIs('aps.rendezvous.index') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                        <i class="bi bi-calendar-event me-2"></i> Rendez-vous
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('aps.traitements.index') }}" class="nav-link {{ request()->routeIs('aps.traitements.index') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                    <i class="bi bi-capsule-pill me-2"></i> Traitements
                </a>
            </li>
            <li class="nav-item mb-1">
                <a href="{{ route('aps.messages.index') }}" class="nav-link {{ request()->routeIs('aps.messages.index') ? 'active bg-white text-dark' : 'text-white' }} rounded">
                    <i class="bi bi-chat-dots me-2"></i> Messages
                </a>
            </li>
        </ul>

        <hr class="border-light">

        <!-- Paramètres et déconnexion -->
        <div class="mt-auto">
            <a href="{{ route('aps.profil.edit') }}" class="d-block mb-2 text-white-50 text-decoration-none">
                <i class="bi bi-gear me-2"></i> Paramètres du profil
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100 rounded">
                    <i class="bi bi-box-arrow-right me-2"></i> Déconnexion
                </button>
            </form>
        </div>
    </aside>
@endif
