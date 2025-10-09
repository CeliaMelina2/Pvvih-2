@extends('layouts.layout')

@section('content')
<style>
    .card-medical-record {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    
    .card-medical-record:hover {
        transform: translateY(-2px);
    }
    
    .bg-pink-lightest {
        background-color: #fff5f7;
    }
    
    .text-pink-dark {
        color: #be185d;
    }
    
    .status-badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.375rem;
    }
    
    .status-en_attente { background-color: #fff3cd; color: #856404; }
    .status-confirme { background-color: #d1ecf1; color: #0c5460; }
    .status-refuse { background-color: #f8d7da; color: #721c24; }
    .status-annule { background-color: #e2e3e5; color: #383d41; }
    
    .transfert-card {
        border-left: 4px solid #e91e63;
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="appointment-header mb-0">Mon dossier médical</h1>
        <button class="btn btn-primary-pink" data-bs-toggle="modal" data-bs-target="#newAppointmentModal">
            <i class="bi bi-plus-circle me-2"></i> Demande de Transfert
        </button>
    </div>

    <!-- Statistiques du patient -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-3">
            <div class="card card-medical-record p-4 h-100 bg-pink-lightest text-center">
                <i class="bi bi-heart-pulse fs-1 text-pink mb-2"></i>
                <h5 class="fw-bold mb-0">Statut sérologique</h5>
                <p class="text-pink-dark fw-bold fs-4">{{ $patientInfo->statut_serologique ?? 'Non renseigné' }}</p>
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
                <p class="text-secondary fs-6">{{ $patientInfo->allergies ?? 'Aucune allergie connue' }}</p>
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

    <!-- Demandes de transfert -->
    <div class="card card-medical-record p-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Mes demandes de transfert</h4>
            <span class="badge bg-primary-pink">{{ $transferts->count() }} demande(s)</span>
        </div>
        
        @if($transferts->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Date demandée</th>
                        <th scope="col">Centre</th>
                        <th scope="col">APS</th>
                        <th scope="col">Motif</th>
                        <th scope="col">Dossier</th>
                        <th scope="col">Statut</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transferts as $transfert)
                    <tr class="transfert-card">
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($transfert->date_heure)->locale('fr')->isoFormat('DD/MM/YYYY') }}</strong>
                            <br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($transfert->date_heure)->locale('fr')->isoFormat('HH:mm') }}</small>
                        </td>
                        <td>{{ $transfert->centre->nom ?? 'N/A' }}</td>
                        <td>{{ $transfert->aps->nom ?? 'N/A' }}</td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 200px;" 
                                  title="{{ $transfert->motif }}">
                                {{ $transfert->motif }}
                            </span>
                        </td>
                        <td>
                            @if($transfert->dossier)
                                <a href="{{ asset('storage/' . $transfert->dossier) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-file-earmark-pdf"></i> Voir
                                </a>
                            @else
                                <span class="text-muted">Aucun fichier</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'en_attente' => 'status-en_attente',
                                    'confirme' => 'status-confirme', 
                                    'refuse' => 'status-refuse',
                                    'annule' => 'status-annule'
                                ][$transfert->statut] ?? 'status-en_attente';
                                
                                $statusText = [
                                    'en_attente' => 'En attente',
                                    'confirme' => 'Confirmé',
                                    'refuse' => 'Refusé',
                                    'annule' => 'Annulé'
                                ][$transfert->statut] ?? $transfert->statut;
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                {{ $statusText }}
                            </span>
                        </td>
                        <td>
                            @if($transfert->statut == 'en_attente')
                                <form action="{{ route('patient.transfert.cancel', $transfert->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Êtes-vous sûr de vouloir annuler ce transfert ?')">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-x-circle"></i> Annuler
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
            <p class="text-muted">Aucune demande de transfert pour le moment.</p>
        </div>
        @endif
    </div>

    <!-- Historique des bilans de santé -->
    <div class="card card-medical-record p-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Historique des bilans de santé</h4>
            <a href="#" class="btn btn-sm btn-outline-secondary">Voir tout</a>
        </div>
        
        @if($bilans->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Date</th>
                        <th scope="col">Médecin / APS</th>
                        <th scope="col">Motif de la consultation</th>
                        <th scope="col">Diagnostic</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bilans as $bilan)
                    <tr>
                        <td>
                            <strong>{{ \Carbon\Carbon::parse($bilan->date_consultation)->locale('fr')->isoFormat('DD/MM/YYYY') }}</strong>
                        </td>
                        <td>{{ $bilan->medecin_aps_nom ?? 'Non spécifié' }}</td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                {{ $bilan->motif_consultation }}
                            </span>
                        </td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                {{ $bilan->diagnostic ?? 'Non spécifié' }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary-pink" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#bilanModal{{ $bilan->id }}">
                                <i class="bi bi-file-earmark-text"></i> Détails
                            </button>
                            
                            <!-- Modal pour les détails du bilan -->
                            <div class="modal fade" id="bilanModal{{ $bilan->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Détails du bilan - {{ \Carbon\Carbon::parse($bilan->date_consultation)->locale('fr')->isoFormat('DD MMMM YYYY') }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Informations de consultation</h6>
                                                    <p><strong>Médecin/APS:</strong> {{ $bilan->medecin_aps_nom }}</p>
                                                    <p><strong>Motif:</strong> {{ $bilan->motif_consultation }}</p>
                                                    <p><strong>Diagnostic:</strong> {{ $bilan->diagnostic ?? 'Non spécifié' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Traitement prescrit</h6>
                                                    <p>{{ $bilan->traitement_prescrit ?? 'Aucun traitement spécifié' }}</p>
                                                    
                                                    @if($bilan->observations)
                                                    <h6 class="mt-3">Observations</h6>
                                                    <p>{{ $bilan->observations }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-4">
            <i class="bi bi-clipboard-x fs-1 text-muted mb-3"></i>
            <p class="text-muted">Aucun bilan de santé enregistré.</p>
        </div>
        @endif
    </div>
</div>

<!-- Modal pour nouvelle demande de transfert -->
<div class="modal fade" id="newAppointmentModal" tabindex="-1" aria-labelledby="newAppointmentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="newAppointmentModalLabel">Demande de Transfert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="modal-body">
                <form action="{{ route('patient.transfert.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="centre_id" class="form-label">Centre sollicité</label>
                        <select name="centre_id" id="centre_id" class="form-control" required>
                            <option value="" disabled selected>Sélectionnez un Centre</option>
                            @foreach($centres as $centre)
                                <option value="{{ $centre->id }}" {{ old('centre_id') == $centre->id ? 'selected' : '' }}>
                                    {{ $centre->nom }} - {{ $centre->ville }}
                                </option>
                            @endforeach
                        </select>
                        @error('centre_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="aps_id" class="form-label">APS sollicité</label>
                        <select name="aps_id" id="aps_id" class="form-control" required>
                            <option value="" disabled selected>Sélectionnez un APS</option>
                            @foreach($apss as $aps)
                                <option value="{{ $aps->id }}" {{ old('aps_id') == $aps->id ? 'selected' : '' }}>
                                    {{ $aps->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('aps_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="date_heure" class="form-label">Date et heure du Transfert</label>
                        <input type="datetime-local" class="form-control" id="date_heure" name="date_heure" 
                            value="{{ old('date_heure') }}" min="{{ now()->format('Y-m-d\TH:i') }}" required>
                        @error('date_heure')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="motif" class="form-label">Motif du Transfert</label>
                        <textarea class="form-control" id="motif" name="motif" rows="3" 
                                placeholder="Ex: Bilan spécialisé, consultation d'expert..." required>{{ old('motif') }}</textarea>
                        @error('motif')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="dossier" class="form-label">Dossier médical (PDF)</label>
                        <input type="file" class="form-control" id="dossier" name="dossier" accept=".pdf" required>
                        <div class="form-text">Format accepté : PDF (max 10MB)</div>
                        @error('dossier')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary-pink mt-3">Confirmer le transfert</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection