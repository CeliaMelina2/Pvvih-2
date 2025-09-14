@extends('layouts.layout')

@section('content')
<style>
    /* ... (Gardez les styles existants) ... */
</style>

<div class="container-fluid py-4">
    <h1 class="medical-record-header">Mon dossier médical</h1>

    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card card-medical-record p-4 h-100 bg-pink-lightest text-center">
                <i class="bi bi-heart-pulse fs-1 text-pink mb-2"></i>
                <h5 class="fw-bold mb-0">Statut sérologique</h5>
                <p class="text-pink-dark fw-bold fs-4">{{ $patientInfo->statut_serologique }}</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-medical-record p-4 h-100 text-center">
                <i class="bi bi-journal-text fs-1 text-info mb-2"></i>
                <h5 class="fw-bold mb-0">Code TARV</h5>
                <p class="text-secondary fw-bold fs-4">{{ $patientInfo->code_tarv ?? 'Non renseigné' }}</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-medical-record p-4 h-100 text-center">
                <i class="bi bi-bandaid fs-1 text-danger mb-2"></i>
                <h5 class="fw-bold mb-0">Allergies connues</h5>
                <p class="text-secondary fs-6">{{ $patientInfo->allergies ?? 'Aucune' }}</p>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card card-medical-record p-4 h-100 text-center">
                <i class="bi bi-telephone-inbound fs-1 text-success mb-2"></i>
                <h5 class="fw-bold mb-0">Contact d'urgence</h5>
                <p class="text-secondary fs-6 mb-0">{{ $patientInfo->contact_urgence_nom ?? 'Non renseigné' }}</p>
                <p class="text-muted fs-6">{{ $patientInfo->contact_urgence_tel ?? '' }}</p>
            </div>
        </div>
    </div>

    <div class="card card-medical-record p-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Historique des bilans de santé</h4>
            <a href="#" class="btn btn-sm btn-outline-secondary">Voir tout</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Médecin / APS</th>
                        <th scope="col">Motif de la consultation</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bilans as $bilan)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($bilan->date_consultation)->locale('fr')->isoFormat('D MMMM YYYY') }}</td>
                        <td>{{ $bilan->medecin_aps_nom }}</td>
                        <td>{{ $bilan->motif_consultation }}</td>
                        <td>
                            <button class="btn btn-sm btn-primary-pink">
                                <i class="bi bi-file-earmark-text"></i> Rapport
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Aucun bilan de santé enregistré.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    </div>
@endsection