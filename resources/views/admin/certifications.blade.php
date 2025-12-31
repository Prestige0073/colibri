@extends('admin.layout')

@section('title', 'Certifications')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-award me-2 text-warning"></i>Certifications
                    </h1>
                    <p class="text-muted mb-0">Liste des admis et génération des certificats</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manualGenerateModal">
                        <i class="fas fa-plus me-2"></i>Générer manuellement
                    </button>
                    <button type="button" class="btn btn-warning" onclick="viderCaches()">
                        <i class="fas fa-sync-alt me-2"></i>Vider les caches
                    </button>
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Formations terminées</p>
                            <h3 class="mb-0 fw-bold">{{ $inscriptions->where('progression', 100)->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Certificats générés</p>
                            <h3 class="mb-0 fw-bold">{{ $certificats->count() }}</h3>
                            <small class="text-muted">
                                <i class="fas fa-robot me-1"></i>{{ $certificats->whereNull('nom_manuel')->count() }} auto /
                                <i class="fas fa-pencil-alt me-1"></i>{{ $certificats->whereNotNull('nom_manuel')->count() }} manuels
                            </small>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-file-pdf fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0dcaf0 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Envoyés par email</p>
                            <h3 class="mb-0 fw-bold">{{ $certificats->where('envoye_email', true)->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-envelope fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">En attente</p>
                            <h3 class="mb-0 fw-bold">{{ $inscriptions->where('progression', 100)->count() - $certificats->count() }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <strong><i class="fas fa-exclamation-triangle me-2"></i>Erreurs de validation:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Liste de tous les certificats générés -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-certificate me-2 text-success"></i>
                Tous les certificats générés
            </h5>
        </div>
        <div class="card-body">
            @if($certificats->isEmpty())
                <div class="text-center py-4">
                    <i class="fas fa-certificate fa-3x text-muted mb-3"></i>
                    <p class="text-muted mb-0">Aucun certificat généré pour le moment.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>N° Certificat</th>
                                <th>Apprenant</th>
                                <th>Formation</th>
                                <th>Note</th>
                                <th>Date de délivrance</th>
                                <th>Type</th>
                                <th>Statut</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($certificats as $cert)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $cert->numero_certificat }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($cert->nom_manuel)
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                     style="width: 35px; height: 35px; font-size: 14px;">
                                                    {{ strtoupper(substr($cert->nom_manuel, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <strong>{{ $cert->nom_manuel }}</strong>
                                                    <br><small class="text-muted"><i class="fas fa-pencil-alt me-1"></i>Saisie manuelle</small>
                                                </div>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                     style="width: 35px; height: 35px; font-size: 14px;">
                                                    {{ $cert->user ? strtoupper(substr($cert->user->name, 0, 2)) : 'NA' }}
                                                </div>
                                                <div>
                                                    <strong>{{ $cert->user->name ?? 'N/A' }}</strong>
                                                    @if($cert->user)
                                                        <br><small class="text-muted"><i class="fas fa-envelope me-1"></i>{{ $cert->user->email }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $cert->formation->titre ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $cert->note_obtenue }}/100</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $cert->date_delivrance->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($cert->nom_manuel)
                                            <span class="badge bg-warning text-dark">
                                                <i class="fas fa-pencil-alt me-1"></i>Manuel
                                            </span>
                                        @else
                                            <span class="badge bg-info">
                                                <i class="fas fa-robot me-1"></i>Automatique
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($cert->envoye_email)
                                            <span class="badge bg-success">
                                                <i class="fas fa-paper-plane me-1"></i>Envoyé
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-clock me-1"></i>Non envoyé
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Bouton Télécharger -->
                                            <button type="button"
                                                    class="btn btn-sm btn-primary"
                                                    onclick="confirmDownload({{ $cert->id }}, '{{ $cert->numero_certificat }}')"
                                                    title="Télécharger le PDF">
                                                <i class="fas fa-download"></i>
                                            </button>

                                            <!-- Bouton Envoyer par email -->
                                            <button type="button"
                                                    class="btn btn-sm btn-info"
                                                    onclick="showSendEmailModal({{ $cert->id }}, '{{ $cert->nom_manuel ?? ($cert->user->name ?? '') }}', '{{ $cert->user->email ?? '' }}')"
                                                    title="Envoyer par email">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>

                                            <!-- Bouton Changer le statut -->
                                            <button type="button"
                                                    class="btn btn-sm btn-warning"
                                                    onclick="showChangeStatusModal({{ $cert->id }}, '{{ $cert->statut }}', '{{ $cert->numero_certificat }}')"
                                                    title="Changer le statut">
                                                <i class="fas fa-exchange-alt"></i>
                                            </button>

                                            <!-- Bouton Supprimer -->
                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="confirmDelete({{ $cert->id }}, '{{ $cert->numero_certificat }}', '{{ $cert->nom_manuel ?? ($cert->user->name ?? 'N/A') }}')"
                                                    title="Supprimer le certificat">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Liste des candidats admis -->
    @if($inscriptions->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-award fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune formation terminée</h5>
                <p class="text-muted mb-0">Les apprenants ayant terminé leurs formations apparaîtront ici.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-graduation-cap me-2 text-primary"></i>
                    Liste des admis aux formations
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">#</th>
                                <th>Apprenant</th>
                                <th>Email</th>
                                <th>Formation</th>
                                <th>Progression</th>
                                <th>Note</th>
                                <th>Date fin</th>
                                <th>Certificat</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($inscriptions as $inscription)
                                @php
                                    $certificat = $inscription->certificat;
                                @endphp
                                <tr class="{{ $inscription->progression == 100 && !$certificat ? 'table-warning' : '' }}">
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            {{ $loop->iteration }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 35px; height: 35px; font-size: 14px;">
                                                {{ strtoupper(substr($inscription->user->name, 0, 2)) }}
                                            </div>
                                            <strong>{{ $inscription->user->name }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-envelope me-1"></i>{{ $inscription->user->email }}
                                        </small>
                                    </td>
                                    <td>{{ $inscription->formation->titre ?? 'N/A' }}</td>
                                    <td>
                                        <div class="progress" style="height: 25px;">
                                            <div class="progress-bar {{ $inscription->progression == 100 ? 'bg-success' : 'bg-info' }}"
                                                 role="progressbar"
                                                 style="width: {{ $inscription->progression }}%">
                                                {{ $inscription->progression }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($certificat)
                                            <span class="badge bg-success">{{ $certificat->note_obtenue }}/100</span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $inscription->date_fin ? $inscription->date_fin->format('d/m/Y') : 'En cours' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($certificat)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Généré
                                            </span>
                                            @if($certificat->envoye_email)
                                                <br><small class="text-muted">
                                                    <i class="fas fa-paper-plane me-1"></i>Envoyé
                                                </small>
                                            @endif
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if(!$certificat && $inscription->progression == 100)
                                                <button type="button"
                                                        class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#generateModal{{ $inscription->id }}"
                                                        title="Générer le certificat">
                                                    <i class="fas fa-file-pdf"></i>
                                                </button>
                                            @endif

                                            @if($certificat)
                                                <a href="{{ route('admin.certifications.download', $certificat->id) }}"
                                                   class="btn btn-sm btn-primary"
                                                   title="Télécharger le PDF">
                                                    <i class="fas fa-download"></i>
                                                </a>

                                                @if(!$certificat->envoye_email)
                                                    <form action="{{ route('admin.certifications.send-email', $certificat->id) }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        <button type="submit"
                                                                class="btn btn-sm btn-info"
                                                                title="Envoyer par email">
                                                            <i class="fas fa-paper-plane"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal de génération de certificat -->
                                @if(!$certificat && $inscription->progression == 100)
                                    <div class="modal fade" id="generateModal{{ $inscription->id }}" tabindex="-1" aria-labelledby="generateModalLabel{{ $inscription->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title" id="generateModalLabel{{ $inscription->id }}">
                                                        <i class="fas fa-award me-2"></i>Générer un certificat
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.certifications.generate', $inscription->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Un certificat sera généré pour <strong>{{ $inscription->user->name }}</strong>
                                                            ayant complété la formation <strong>{{ $inscription->formation->titre ?? 'N/A' }}</strong>.
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="note{{ $inscription->id }}" class="form-label">
                                                                Note obtenue <span class="text-danger">*</span>
                                                            </label>
                                                            <input type="number"
                                                                   class="form-control"
                                                                   id="note{{ $inscription->id }}"
                                                                   name="note_obtenue"
                                                                   min="0"
                                                                   max="100"
                                                                   value="80"
                                                                   required>
                                                            <small class="text-muted">Note sur 100</small>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input"
                                                                   type="checkbox"
                                                                   name="send_email"
                                                                   id="sendEmail{{ $inscription->id }}"
                                                                   checked>
                                                            <label class="form-check-label" for="sendEmail{{ $inscription->id }}">
                                                                Envoyer automatiquement par email
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-2"></i>Annuler
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fas fa-file-pdf me-2"></i>Générer le certificat
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

    <!-- Modal de confirmation de téléchargement -->
    <div class="modal fade" id="downloadModal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="downloadModalLabel">
                        <i class="fas fa-download me-2"></i>Confirmer le téléchargement
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Vous êtes sur le point de télécharger le certificat suivant.
                    </div>
                    <p><strong>Numéro de certificat :</strong> <span id="downloadCertNumber"></span></p>
                    <p class="text-muted mb-0">Le fichier PDF sera téléchargé sur votre ordinateur.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <a id="downloadConfirmBtn" href="#" class="btn btn-primary">
                        <i class="fas fa-download me-2"></i>Télécharger
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de changement de statut -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="changeStatusModalLabel">
                        <i class="fas fa-exchange-alt me-2"></i>Changer le statut du certificat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="changeStatusForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Modification du statut du certificat <strong id="statusCertNumber"></strong>
                        </div>
                        <div class="mb-3">
                            <label for="nouveau_statut" class="form-label">
                                Nouveau statut <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="nouveau_statut" name="statut" required>
                                <option value="genere">Généré</option>
                                <option value="envoye">Envoyé</option>
                                <option value="valide">Validé</option>
                                <option value="annule">Annulé</option>
                            </select>
                        </div>
                        <p class="text-muted small mb-0">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            Le changement de statut sera immédiat.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-check me-2"></i>Modifier le statut
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal d'envoi par email amélioré -->
    <div class="modal fade" id="sendEmailModalNew" tabindex="-1" aria-labelledby="sendEmailModalNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="sendEmailModalNewLabel">
                        <i class="fas fa-paper-plane me-2"></i>Envoyer le certificat par email
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sendEmailFormNew" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Envoi du certificat par email
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Destinataire</label>
                            <p class="mb-0"><strong id="emailRecipientNameNew"></strong></p>
                        </div>

                        <div class="mb-3">
                            <label for="recipient_email" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   class="form-control"
                                   id="recipient_email"
                                   name="recipient_email"
                                   placeholder="email@example.com"
                                   required>
                            <small class="text-muted">Modifiez l'email si nécessaire</small>
                        </div>

                        <div class="mb-3">
                            <label for="email_message" class="form-label">Message personnalisé (optionnel)</label>
                            <textarea class="form-control"
                                      id="email_message"
                                      name="message"
                                      rows="3"
                                      placeholder="Ajouter un message personnalisé..."></textarea>
                        </div>

                        <p class="text-muted mb-0">
                            <i class="fas fa-file-pdf me-1"></i>
                            Le certificat sera envoyé en pièce jointe au format PDF.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation d'envoi par email -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="sendEmailModalLabel">
                        <i class="fas fa-paper-plane me-2"></i>Confirmer l'envoi par email
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="sendEmailForm" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous êtes sur le point d'envoyer le certificat par email.
                        </div>
                        <p><strong>Destinataire :</strong> <span id="emailRecipientName"></span></p>
                        <p><strong>Email :</strong> <span id="emailRecipientEmail"></span></p>
                        <p class="text-muted mb-0">Le certificat sera envoyé en pièce jointe au format PDF.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-info">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Attention !</strong> Cette action est irréversible.
                        </div>
                        <p>Vous êtes sur le point de supprimer le certificat suivant :</p>
                        <ul>
                            <li><strong>Numéro :</strong> <span id="deleteCertNumber"></span></li>
                            <li><strong>Apprenant :</strong> <span id="deleteCertStudent"></span></li>
                        </ul>
                        <p class="text-danger mb-0">
                            <i class="fas fa-info-circle me-1"></i>
                            Le fichier PDF sera également supprimé du serveur.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Supprimer définitivement
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de génération manuelle de certificat -->
    <div class="modal fade" id="manualGenerateModal" tabindex="-1" aria-labelledby="manualGenerateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="manualGenerateModalLabel">
                        <i class="fas fa-file-pdf me-2"></i>Générer un certificat manuellement
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.certifications.generate-manual') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <strong>Erreurs:</strong>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Remplissez les informations ci-dessous pour générer un certificat personnalisé.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                    Apprenant <span class="text-danger">*</span>
                                </label>
                                <div class="mb-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="apprenant_type" id="apprenantExistant" value="existant" checked onchange="toggleApprenantInput()">
                                        <label class="form-check-label" for="apprenantExistant">
                                            Apprenant existant
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="apprenant_type" id="apprenantManuel" value="manuel" onchange="toggleApprenantInput()">
                                        <label class="form-check-label" for="apprenantManuel">
                                            Saisir manuellement
                                        </label>
                                    </div>
                                </div>

                                <select class="form-select" id="user_id" name="user_id">
                                    <option value="">Sélectionner un apprenant</option>
                                    @php
                                        $users = \App\Models\User::where('role', 'user')->orderBy('name')->get();
                                    @endphp
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>

                                <input type="text"
                                       class="form-control mt-2"
                                       id="nom_manuel"
                                       name="nom_manuel"
                                       placeholder="Nom complet de l'apprenant"
                                       style="display: none;">

                                <input type="email"
                                       class="form-control mt-2"
                                       id="email_manuel"
                                       name="email_manuel"
                                       placeholder="Email de l'apprenant"
                                       style="display: none;">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="formation_id" class="form-label">
                                    Formation <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="formation_id" name="formation_id" required>
                                    <option value="">Sélectionner une formation</option>
                                    @php
                                        $formations = \App\Models\Formation::orderBy('titre')->get();
                                    @endphp
                                    @foreach($formations as $formation)
                                        <option value="{{ $formation->id }}">{{ $formation->titre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="note_obtenue_manual" class="form-label">
                                    Note obtenue <span class="text-danger">*</span>
                                </label>
                                <input type="number"
                                       class="form-control"
                                       id="note_obtenue_manual"
                                       name="note_obtenue"
                                       min="0"
                                       max="100"
                                       value="80"
                                       required>
                                <small class="text-muted">Note sur 100</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_delivrance" class="form-label">
                                    Date de délivrance <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control"
                                       id="date_delivrance"
                                       name="date_delivrance"
                                       value="{{ now()->format('Y-m-d') }}"
                                       required>
                            </div>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="send_email"
                                   id="sendEmailManual"
                                   value="1"
                                   checked>
                            <label class="form-check-label" for="sendEmailManual">
                                Envoyer automatiquement par email
                            </label>
                        </div>

                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Note :</strong> Si l'apprenant n'a pas d'inscription active pour cette formation,
                            une inscription sera créée automatiquement avec une progression de 100%.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-file-pdf me-2"></i>Générer le certificat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Overlay de chargement animé -->
    <div id="loadingOverlay" class="loading-overlay" style="display: none;">
        <div class="loading-content">
            <div class="loading-spinner">
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-ring"></div>
                <div class="spinner-icon">
                    <i class="fas fa-certificate"></i>
                </div>
            </div>
            <h4 class="loading-text mt-4">Génération du certificat en cours...</h4>
            <p class="loading-subtext">Veuillez patienter quelques instants</p>
            <div class="loading-progress">
                <div class="progress-bar"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleApprenantInput() {
        const type = document.querySelector('input[name="apprenant_type"]:checked').value;
        const userSelect = document.getElementById('user_id');
        const nomManuel = document.getElementById('nom_manuel');
        const emailManuel = document.getElementById('email_manuel');

        if (type === 'existant') {
            userSelect.style.display = 'block';
            userSelect.required = true;
            nomManuel.style.display = 'none';
            nomManuel.required = false;
            nomManuel.value = '';
            emailManuel.style.display = 'none';
            emailManuel.required = false;
            emailManuel.value = '';
        } else {
            userSelect.style.display = 'none';
            userSelect.required = false;
            userSelect.value = '';
            nomManuel.style.display = 'block';
            nomManuel.required = true;
            emailManuel.style.display = 'block';
            emailManuel.required = true;
        }
    }

    // Fonction pour confirmer le téléchargement
    function confirmDownload(certId, certNumber) {
        document.getElementById('downloadCertNumber').textContent = certNumber;
        document.getElementById('downloadConfirmBtn').href = '/admin/certifications/' + certId + '/download';

        var downloadModal = new bootstrap.Modal(document.getElementById('downloadModal'));
        downloadModal.show();
    }

    // Fonction pour afficher le modal de changement de statut
    function showChangeStatusModal(certId, currentStatus, certNumber) {
        document.getElementById('statusCertNumber').textContent = certNumber;
        document.getElementById('nouveau_statut').value = currentStatus;
        document.getElementById('changeStatusForm').action = '/admin/certifications/' + certId + '/change-status';

        var statusModal = new bootstrap.Modal(document.getElementById('changeStatusModal'));
        statusModal.show();
    }

    // Fonction pour afficher le modal d'envoi par email amélioré
    function showSendEmailModal(certId, studentName, studentEmail) {
        document.getElementById('emailRecipientNameNew').textContent = studentName || 'Non spécifié';
        document.getElementById('recipient_email').value = studentEmail || '';
        document.getElementById('sendEmailFormNew').action = '/admin/certifications/' + certId + '/send-email-custom';

        var emailModal = new bootstrap.Modal(document.getElementById('sendEmailModalNew'));
        emailModal.show();
    }

    // Fonction pour confirmer l'envoi par email (ancien modal)
    function confirmSendEmail(certId, userName, userEmail) {
        document.getElementById('emailRecipientName').textContent = userName;
        document.getElementById('emailRecipientEmail').textContent = userEmail;
        document.getElementById('sendEmailForm').action = '/admin/certifications/' + certId + '/send-email';

        var emailModal = new bootstrap.Modal(document.getElementById('sendEmailModal'));
        emailModal.show();
    }

    // Fonction pour confirmer la suppression
    function confirmDelete(certId, certNumber, studentName) {
        document.getElementById('deleteCertNumber').textContent = certNumber;
        document.getElementById('deleteCertStudent').textContent = studentName;
        document.getElementById('deleteForm').action = '/admin/certifications/' + certId;

        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }

    function viderCaches() {
        if (confirm('Voulez-vous vraiment vider tous les caches ? Cela inclut le cache de Laravel, les vues, les routes et les configurations.')) {
            // Créer un formulaire pour envoyer la requête
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("admin.certifications.clear-cache") }}';

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            document.body.appendChild(form);
            form.submit();
        }
    }

    // Fonction pour afficher le loading overlay
    function showLoading() {
        document.getElementById('loadingOverlay').style.display = 'flex';
    }

    // Fonction pour masquer le loading overlay
    function hideLoading() {
        document.getElementById('loadingOverlay').style.display = 'none';
    }

    // Intercepter la soumission des formulaires de génération de certificat
    document.addEventListener('DOMContentLoaded', function() {
        // Formulaire de génération manuelle
        const manualForm = document.querySelector('#manualGenerateModal form');
        if (manualForm) {
            manualForm.addEventListener('submit', function(e) {
                // Vérifier que le formulaire est valide avant d'afficher le loading
                if (this.checkValidity()) {
                    showLoading();
                }
            });
        }

        // Tous les formulaires de génération automatique
        const generateForms = document.querySelectorAll('form[action*="generate"]');
        generateForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (this.checkValidity()) {
                    showLoading();
                }
            });
        });
    });

    // Rouvrir le modal s'il y a des erreurs de validation
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            hideLoading(); // Masquer le loading en cas d'erreur
            var modal = new bootstrap.Modal(document.getElementById('manualGenerateModal'));
            modal.show();
        });
    @endif
</script>
@endpush

@push('styles')
<style>
    .table-warning {
        background-color: #fff3cd44 !important;
    }

    .table > tbody > tr:hover {
        background-color: #f8f9fa;
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    .progress {
        border-radius: 0.5rem;
        box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
    }

    .progress-bar {
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Loading Overlay Styles */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.85);
        backdrop-filter: blur(5px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-content {
        text-align: center;
        color: white;
    }

    .loading-spinner {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }

    .spinner-ring {
        position: absolute;
        width: 100%;
        height: 100%;
        border: 4px solid transparent;
        border-top-color: #198754;
        border-radius: 50%;
        animation: spin 1.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) infinite;
    }

    .spinner-ring:nth-child(2) {
        border-top-color: #ffc107;
        animation-delay: 0.2s;
        width: 85%;
        height: 85%;
        top: 7.5%;
        left: 7.5%;
    }

    .spinner-ring:nth-child(3) {
        border-top-color: #1976d2;
        animation-delay: 0.4s;
        width: 70%;
        height: 70%;
        top: 15%;
        left: 15%;
    }

    .spinner-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2.5rem;
        color: #ffc107;
        animation: pulse 1.5s ease-in-out infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.1);
            opacity: 0.8;
        }
    }

    .loading-text {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #fff;
        animation: fadeInOut 2s ease-in-out infinite;
    }

    .loading-subtext {
        font-size: 1rem;
        color: #ccc;
        margin-bottom: 1.5rem;
    }

    .loading-progress {
        width: 300px;
        height: 4px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
        margin: 0 auto;
        overflow: hidden;
    }

    .loading-progress .progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #198754, #ffc107, #1976d2);
        background-size: 200% 100%;
        animation: progressMove 1.5s linear infinite;
        border-radius: 2px;
    }

    @keyframes progressMove {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    @keyframes fadeInOut {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.6;
        }
    }
</style>
@endpush
