@extends('layouts.layout')

@section('content')
<style>
    /* ... (Gardez les styles existants) ... */
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="treatment-header mb-0">Mes traitements</h1>
        <button class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addTreatmentModal">
            <i class="bi bi-plus-circle me-2"></i> Ajouter un traitement
        </button>
    </div>

    <div class="row g-4 mb-5">
        {{-- Les statistiques restent statiques pour la démo, car elles nécessitent une logique complexe --}}
        <div class="col-md-6 col-lg-3">
            <div class="card card-treatment text-center p-4">
                <i class="bi bi-capsule-pill text-pink fs-1 mb-2"></i>
                <h4 class="fw-bold mb-0">{{ $traitements->count() }}</h4>
                <p class="text-muted">Traitements actifs</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-treatment text-center p-4">
                <i class="bi bi-check-circle text-success fs-1 mb-2"></i>
                <h4 class="fw-bold mb-0">3/4</h4>
                <p class="text-muted">Doses prises aujourd'hui</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-treatment text-center p-4">
                <i class="bi bi-x-circle text-danger fs-1 mb-2"></i>
                <h4 class="fw-bold mb-0">1</h4>
                <p class="text-muted">Dose manquée cette semaine</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-treatment text-center p-4">
                <i class="bi bi-clock-history text-warning fs-1 mb-2"></i>
                <h4 class="fw-bold mb-0">95%</h4>
                <p class="text-muted">Fidélité au traitement</p>
            </div>
        </div>
    </div>

    <div class="card card-treatment p-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Traitements actifs</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Médicament</th>
                        <th scope="col">Posologie</th>
                        <th scope="col">Fréquence</th>
                        <th scope="col">Début du traitement</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($traitements as $traitement)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-capsule fs-4 text-pink me-2"></i>
                                <div>
                                    <h6 class="fw-bold mb-0">{{ $traitement->nom_medicament }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>{{ $traitement->posologie }}</td>
                        <td>{{ $traitement->frequence ?? 'Non spécifiée' }}</td>
                        <td>{{ \Carbon\Carbon::parse($traitement->date_debut)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
                        <td>
                            <form action="{{ route('patient.traitements.marquer_pris', $traitement->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-pink btn-sm me-2">
                                    <i class="bi bi-check-lg"></i> Marquer pris
                                </button>
                            </form>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-info-circle"></i> Détails
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Vous n'avez aucun traitement actif.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection