@extends('layouts.layout')

@section('content')
<style>
    /* ... (Gardez les styles existants) ... */
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="appointment-header mb-0">Mes rendez-vous</h1>
        <button class="btn btn-primary-pink" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
            <i class="bi bi-plus-circle me-2"></i> Prendre un rendez-vous
        </button>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-info">{{ $upcomingCount }}</div>
                        <p class="text-muted mb-0">Rendez-vous à venir</p>
                    </div>
                    <i class="bi bi-calendar-check-fill fs-2 text-info"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-success">{{ $pastCount }}</div>
                        <p class="text-muted mb-0">Rendez-vous passés</p>
                    </div>
                    <i class="bi bi-calendar-event-fill fs-2 text-success"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-primary-pink">{{ $assiduite }}%</div>
                        <p class="text-muted mb-0">Taux d'assiduité</p>
                    </div>
                    <i class="bi bi-check-circle-fill fs-2 text-primary-pink"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-stat bg-white h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="stat-value text-danger">{{ $canceledCount }}</div>
                        <p class="text-muted mb-0">Rendez-vous annulés</p>
                    </div>
                    <i class="bi bi-x-circle-fill fs-2 text-danger"></i>
                </div>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-4" id="appointmentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming" aria-selected="true">
                À venir
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="past-tab" data-bs-toggle="tab" data-bs-target="#past" type="button" role="tab" aria-controls="past" aria-selected="false">
                Passés
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
            <div class="row g-4">
                @forelse($upcoming as $rdv)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-appointment p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge rounded-pill text-bg-info">{{ $rdv->statut }}</span>
                            <div class="dropdown">
                                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Modifier</a></li>
                                    <li>
                                        <form action="{{ route('patient.rendezvous.cancel', $rdv->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">Annuler</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-1">Rendez-vous avec {{ $rdv->medecin_nom }}</h5>
                        <p class="text-muted mb-3">{{ $rdv->motif }}</p>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-calendar-event me-2 text-secondary"></i>
                                {{ \Carbon\Carbon::parse($rdv->date_heure)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-clock me-2 text-secondary"></i>
                                {{ \Carbon\Carbon::parse($rdv->date_heure)->isoFormat('HH:mm') }}
                            </li>
                        </ul>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center text-muted">Vous n'avez aucun rendez-vous à venir.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="past" role="tabpanel" aria-labelledby="past-tab">
            <div class="row g-4">
                @forelse($past as $rdv)
                <div class="col-md-6 col-lg-4">
                    <div class="card card-appointment p-4 bg-light text-muted">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge rounded-pill text-bg-success">{{ $rdv->statut }}</span>
                            <div class="dropdown">
                                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-three-dots-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">Voir les détails</a></li>
                                </ul>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-1">Rendez-vous avec {{ $rdv->medecin_nom }}</h5>
                        <p class="mb-3">{{ $rdv->motif }}</p>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-calendar-event me-2"></i>
                                {{ \Carbon\Carbon::parse($rdv->date_heure)->locale('fr')->isoFormat('D MMMM YYYY') }}
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-clock me-2"></i>
                                {{ \Carbon\Carbon::parse($rdv->date_heure)->isoFormat('HH:mm') }}
                            </li>
                        </ul>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <p class="text-center text-muted">Vous n'avez aucun rendez-vous passé.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold" id="newAppointmentModalLabel">Prendre un nouveau rendez-vous</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('patient.rendezvous.store') }}" method="POST">
          @csrf
          <div class="mb-3">
            <label for="medecin_nom" class="form-label">Nom du médecin / APS</label>
            <input type="text" class="form-control" id="medecin_nom" name="medecin_nom" placeholder="Ex: Dr. Ndi" required>
          </div>
          <div class="mb-3">
            <label for="date_heure" class="form-label">Date et heure du rendez-vous</label>
            <input type="datetime-local" class="form-control" id="date_heure" name="date_heure" required>
          </div>
          <div class="mb-3">
            <label for="motif" class="form-label">Motif du rendez-vous</label>
            <textarea class="form-control" id="motif" name="motif" rows="3" placeholder="Ex: Visite de contrôle annuelle" required></textarea>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-primary-pink mt-3">Confirmer le rendez-vous</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection