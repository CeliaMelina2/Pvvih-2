@extends('layouts.layout')

@section('content')
<style>
    /* Styles personnalisés pour le tableau de bord */
    .dashboard-header {
        color: #212529;
        font-weight: 700;
        margin-bottom: 2rem;
    }
    .card-dashboard {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-dashboard:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }
    .card-icon {
        background-color: #D01168;
        color: white;
        padding: 1rem;
        border-radius: 0.75rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .card-icon-light {
        background-color: rgba(208, 17, 104, 0.1);
        color: #D01168;
    }
    .progress-bar-pink {
        background-color: #D01168;
    }
</style>

<div class="container-fluid py-4">
    <h1 class="dashboard-header">Tableau de bord patient</h1>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card card-dashboard p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="card-icon fs-4 rounded-3 me-3">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Prochain rendez-vous</h5>
                        <small class="text-muted">Lundi 16 sept. à 10h00</small>
                    </div>
                </div>
                <p class="text-muted mb-0">Hôpital Central de Yaoundé avec Dr. Ndi</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-dashboard p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="card-icon fs-4 rounded-3 me-3">
                        <i class="bi bi-capsule-pill"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Prochain traitement</h5>
                        <small class="text-muted">A prendre à 20h00</small>
                    </div>
                </div>
                <p class="text-muted mb-0">Doliprane 1000 mg</p>
                <div class="progress mt-3" style="height: 5px;">
                    <div class="progress-bar progress-bar-pink" role="progressbar" style="width: 75%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card card-dashboard p-4 h-100">
                <div class="d-flex align-items-center mb-3">
                    <div class="card-icon fs-4 rounded-3 me-3">
                        <i class="bi bi-person-fill-gear"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 fw-bold">Mon Accompagnateur</h5>
                        <small class="text-muted">APS en charge</small>
                    </div>
                </div>
                <p class="text-muted mb-0">M. Jean-Marc Dupont</p>
                <a href="#" class="mt-2 fw-bold text-decoration-none text-info">
                    Envoyer un message <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">Suivi de mon traitement</h3>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card card-dashboard p-4 h-100 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-calendar-check-fill fs-2 text-primary-pink"></i>
                            <h4 class="mt-3 mb-0 fw-bold text-primary-pink">90 jours</h4>
                            <p class="text-muted">Durée totale</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-dashboard p-4 h-100 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-calendar-x-fill fs-2 text-danger"></i>
                            <h4 class="mt-3 mb-0 fw-bold text-danger">2 jours</h4>
                            <p class="text-muted">Manqués</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-dashboard p-4 h-100 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-clock-history fs-2 text-warning"></i>
                            <h4 class="mt-3 mb-0 fw-bold text-warning">15 jours</h4>
                            <p class="text-muted">Restants</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card card-dashboard p-4 h-100 text-center">
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-award-fill fs-2 text-success"></i>
                            <h4 class="mt-3 mb-0 fw-bold text-success">85%</h4>
                            <p class="text-muted">Fidélité au traitement</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="card card-dashboard p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Mes rendez-vous</h4>
                    <a href="{{ route('patient.rendezvous') }}" class="btn btn-sm btn-outline-secondary">Voir tout</a>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-event fs-5 me-3 text-secondary"></i>
                            <div>
                                <div class="fw-bold">Visite de contrôle</div>
                                <small class="text-muted">16 septembre 2025, 10:00</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill text-bg-info">Confirmé</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-event fs-5 me-3 text-secondary"></i>
                            <div>
                                <div class="fw-bold">Rendez-vous Psychologique</div>
                                <small class="text-muted">20 octobre 2025, 15:00</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill text-bg-warning">En attente</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-dashboard p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">Mes traitements</h4>
                    <a href="{{ route('patient.traitement') }}" class="btn btn-sm btn-outline-secondary">Voir tout</a>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-capsule fs-5 me-3 text-secondary"></i>
                            <div>
                                <div class="fw-bold">Zidovudine</div>
                                <small class="text-muted">2 comprimés, matin et soir</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill text-bg-success">Actif</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-capsule fs-5 me-3 text-secondary"></i>
                            <div>
                                <div class="fw-bold">Lamivudine</div>
                                <small class="text-muted">1 comprimé, le matin</small>
                            </div>
                        </div>
                        <span class="badge rounded-pill text-bg-success">Actif</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
@endsection