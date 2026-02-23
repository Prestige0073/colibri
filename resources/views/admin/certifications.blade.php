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
                    <p class="text-muted mb-0">Génération manuelle des certificats de formation</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manualGenerateModal">
                        <i class="fas fa-plus me-2"></i>Générer un certificat
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
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Certificats générés</p>
                            <h3 class="mb-0 fw-bold">{{ $certificats->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-file-pdf fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
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

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Validés</p>
                            <h3 class="mb-0 fw-bold">{{ $certificats->where('statut', 'valide')->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
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
                    <p class="text-muted">Cliquez sur "Générer un certificat" pour commencer.</p>
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
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                                 style="width: 35px; height: 35px; font-size: 14px;">
                                                {{ strtoupper(substr($cert->nom_manuel ?? 'NA', 0, 2)) }}
                                            </div>
                                            <div>
                                                <strong>{{ $cert->nom_manuel ?? 'N/A' }}</strong>
                                                @if($cert->email_manuel)
                                                    <br><small class="text-muted"><i class="fas fa-envelope me-1"></i>{{ $cert->email_manuel }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $cert->formation->titre ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-success">{{ $cert->note_obtenue }}/100</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $cert->date_delivrance ? $cert->date_delivrance->format('d/m/Y') : '-' }}
                                        </small>
                                    </td>
                                    <td>
                                        @php
                                            $statutColors = [
                                                'genere' => 'bg-info',
                                                'envoye' => 'bg-success',
                                                'valide' => 'bg-primary',
                                                'annule' => 'bg-danger'
                                            ];
                                            $statutLabels = [
                                                'genere' => 'Généré',
                                                'envoye' => 'Envoyé',
                                                'valide' => 'Validé',
                                                'annule' => 'Annulé'
                                            ];
                                        @endphp
                                        <span class="badge {{ $statutColors[$cert->statut] ?? 'bg-secondary' }}">
                                            {{ $statutLabels[$cert->statut] ?? $cert->statut }}
                                        </span>
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
                                            @if($cert->email_manuel)
                                                <button type="button"
                                                        class="btn btn-sm btn-info"
                                                        onclick="showSendEmailModal({{ $cert->id }}, '{{ $cert->nom_manuel }}', '{{ $cert->email_manuel }}')"
                                                        title="Envoyer par email">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            @endif

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
                                                    onclick="confirmDelete({{ $cert->id }}, '{{ $cert->numero_certificat }}', '{{ $cert->nom_manuel ?? 'N/A' }}')"
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

    <!-- Modal d'envoi par email -->
    <div class="modal fade" id="sendEmailModal" tabindex="-1" aria-labelledby="sendEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="sendEmailModalLabel">
                        <i class="fas fa-paper-plane me-2"></i>Envoyer le certificat par email
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
                        <i class="fas fa-file-pdf me-2"></i>Générer un certificat
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.certifications.generate') }}" method="POST" enctype="multipart/form-data" id="generateForm">
                    @csrf
                    <div class="modal-body">
                        @if($demandesCertificat->isNotEmpty())
                            <div class="alert alert-warning">
                                <i class="fas fa-bell me-2"></i>
                                <strong>{{ $demandesCertificat->count() }} demande(s) en attente.</strong>
                                Sélectionnez un apprenant ci-dessous pour remplir automatiquement le formulaire.
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Aucune demande en attente. Vous pouvez générer un certificat manuellement.
                            </div>
                        @endif

                        <!-- Sélection de l'apprenant -->
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3">
                            <i class="fas fa-user-graduate me-2"></i>Apprenant
                        </h6>

                        <input type="hidden" id="formation_inscription_id" name="formation_inscription_id" value="{{ old('formation_inscription_id') }}">

                        <div class="mb-3">
                            <label for="demande_select" class="form-label">
                                Sélectionner un apprenant <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="demande_select" required>
                                <option value="">-- Choisir un apprenant --</option>
                                @if($demandesCertificat->isNotEmpty())
                                    <optgroup label="Demandes en attente">
                                        @foreach($demandesCertificat as $demande)
                                            <option value="demande_{{ $demande->id }}"
                                                    data-inscription-id="{{ $demande->id }}"
                                                    data-user-name="{{ $demande->user->name }}"
                                                    data-user-email="{{ $demande->user->email }}"
                                                    data-formation-id="{{ $demande->formation_id }}"
                                                    data-formation-titre="{{ $demande->formation->titre }}"
                                                    data-progression="{{ $demande->progression }}"
                                                    {{ old('formation_inscription_id') == $demande->id ? 'selected' : '' }}>
                                                {{ $demande->user->name }} — {{ $demande->formation->titre }}
                                                (demandé le {{ $demande->certificat_demande_at ? $demande->certificat_demande_at->format('d/m/Y') : '-' }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endif
                                <optgroup label="Saisie manuelle">
                                    <option value="manuel">Entrer les informations manuellement</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- Info apprenant (auto-rempli ou manuel) -->
                        <div class="row" id="apprenantInfoRow">
                            <div class="col-md-6 mb-3">
                                <label for="nom_apprenant" class="form-label">
                                    Nom complet <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="nom_apprenant"
                                       name="nom_apprenant"
                                       placeholder="Ex: Jean DUPONT"
                                       value="{{ old('nom_apprenant') }}"
                                       readonly
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email_apprenant" class="form-label">
                                    Email <small class="text-muted">(optionnel)</small>
                                </label>
                                <input type="email"
                                       class="form-control"
                                       id="email_apprenant"
                                       name="email_apprenant"
                                       placeholder="email@exemple.com"
                                       value="{{ old('email_apprenant') }}"
                                       readonly>
                            </div>
                        </div>

                        <!-- Formation et Note -->
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-3">
                            <i class="fas fa-book me-2"></i>Formation et Résultat
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="formation_id" class="form-label">
                                    Formation <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="formation_id" name="formation_id" required>
                                    <option value="">Sélectionner une formation</option>
                                    @foreach($formations as $formation)
                                        <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                                            {{ $formation->titre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="note_obtenue" class="form-label">
                                    Note obtenue <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control"
                                           id="note_obtenue"
                                           name="note_obtenue"
                                           min="0"
                                           max="100"
                                           value="{{ old('note_obtenue', 80) }}"
                                           required>
                                    <span class="input-group-text">/100</span>
                                </div>
                            </div>
                        </div>

                        <!-- Délivrance -->
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-3">
                            <i class="fas fa-map-marker-alt me-2"></i>Lieu et Date de délivrance
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="lieu_delivrance" class="form-label">
                                    Lieu <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="lieu_delivrance"
                                       name="lieu_delivrance"
                                       value="{{ old('lieu_delivrance', 'Cotonou') }}"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_delivrance" class="form-label">
                                    Date <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control"
                                       id="date_delivrance"
                                       name="date_delivrance"
                                       value="{{ old('date_delivrance', now()->format('Y-m-d')) }}"
                                       required>
                            </div>
                        </div>

                        <!-- Signataire -->
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-3">
                            <i class="fas fa-signature me-2"></i>Signataire
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="signataire_nom" class="form-label">
                                    Nom du signataire <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="signataire_nom"
                                       name="signataire_nom"
                                       value="{{ old('signataire_nom', 'SEGNIGBINDE A. Camille') }}"
                                       required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="signataire_titre" class="form-label">
                                    Titre/Fonction <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control"
                                       id="signataire_titre"
                                       name="signataire_titre"
                                       value="{{ old('signataire_titre', 'Directeur Exécutif') }}"
                                       required>
                            </div>
                        </div>

                        <!-- Fichiers à importer (Cachet et Signature) -->
                        <h6 class="fw-bold text-primary border-bottom pb-2 mb-3 mt-3">
                            <i class="fas fa-upload me-2"></i>Cachet et Signature
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cachet" class="form-label">
                                    Cachet officiel <span class="text-danger">*</span>
                                </label>
                                <input type="file"
                                       class="form-control"
                                       id="cachet"
                                       name="cachet"
                                       accept="image/png,image/jpeg,image/jpg"
                                       required>
                                <small class="text-muted">Format: PNG, JPG, JPEG (max 2 Mo) - Fond transparent recommandé</small>
                                <div class="mt-2" id="cachetPreview"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="signature" class="form-label">
                                    Signature <small class="text-muted">(optionnel)</small>
                                </label>
                                <input type="file"
                                       class="form-control"
                                       id="signature"
                                       name="signature"
                                       accept="image/png,image/jpeg,image/jpg">
                                <small class="text-muted">Format: PNG, JPG, JPEG (max 2 Mo) - Fond transparent recommandé</small>
                                <div class="mt-2" id="signaturePreview"></div>
                            </div>
                        </div>

                        <!-- Options -->
                        <div class="form-check mb-3">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="send_email"
                                   id="sendEmailManual"
                                   value="1">
                            <label class="form-check-label" for="sendEmailManual">
                                <i class="fas fa-envelope me-1"></i>Envoyer automatiquement par email
                            </label>
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

    // Fonction pour afficher le modal d'envoi par email
    function showSendEmailModal(certId, studentName, studentEmail) {
        document.getElementById('emailRecipientName').textContent = studentName || 'Non spécifié';
        document.getElementById('emailRecipientEmail').textContent = studentEmail || 'Non spécifié';
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

    // Gestion du select apprenant (auto-remplissage du formulaire)
    function handleDemandeSelect() {
        const select = document.getElementById('demande_select');
        const nomInput = document.getElementById('nom_apprenant');
        const emailInput = document.getElementById('email_apprenant');
        const formationSelect = document.getElementById('formation_id');
        const noteInput = document.getElementById('note_obtenue');
        const inscriptionInput = document.getElementById('formation_inscription_id');

        if (!select) return;

        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const value = this.value;

            if (value === 'manuel') {
                // Saisie manuelle: rendre les champs éditables et vider
                nomInput.readOnly = false;
                emailInput.readOnly = false;
                formationSelect.disabled = false;
                noteInput.readOnly = false;
                nomInput.value = '';
                emailInput.value = '';
                formationSelect.value = '';
                noteInput.value = '80';
                inscriptionInput.value = '';
            } else if (value.startsWith('demande_')) {
                // Demande sélectionnée: auto-remplir et verrouiller
                const userName = selectedOption.getAttribute('data-user-name');
                const userEmail = selectedOption.getAttribute('data-user-email');
                const formationId = selectedOption.getAttribute('data-formation-id');
                const progression = selectedOption.getAttribute('data-progression');
                const inscriptionId = selectedOption.getAttribute('data-inscription-id');

                nomInput.value = userName;
                nomInput.readOnly = true;
                emailInput.value = userEmail;
                emailInput.readOnly = true;
                formationSelect.value = formationId;
                formationSelect.disabled = true;
                noteInput.value = progression || '80';
                noteInput.readOnly = false;
                inscriptionInput.value = inscriptionId;

                // Réactiver le select formation en hidden pour l'envoi du formulaire
                // On crée un input hidden pour envoyer formation_id même si le select est disabled
                let hiddenFormation = document.getElementById('formation_id_hidden');
                if (!hiddenFormation) {
                    hiddenFormation = document.createElement('input');
                    hiddenFormation.type = 'hidden';
                    hiddenFormation.id = 'formation_id_hidden';
                    hiddenFormation.name = 'formation_id';
                    formationSelect.parentNode.appendChild(hiddenFormation);
                }
                hiddenFormation.value = formationId;
            } else {
                // Rien sélectionné: réinitialiser
                nomInput.value = '';
                nomInput.readOnly = true;
                emailInput.value = '';
                emailInput.readOnly = true;
                formationSelect.value = '';
                formationSelect.disabled = false;
                noteInput.value = '80';
                inscriptionInput.value = '';

                // Supprimer le hidden formation_id s'il existe
                const hiddenFormation = document.getElementById('formation_id_hidden');
                if (hiddenFormation) hiddenFormation.remove();
            }
        });
    }

    // Preview des fichiers uploadés et soumission du formulaire
    document.addEventListener('DOMContentLoaded', function() {
        // Initialiser le select apprenant
        handleDemandeSelect();

        // Si une demande était déjà sélectionnée (old values), déclencher le change
        const demandeSelect = document.getElementById('demande_select');
        if (demandeSelect && demandeSelect.value) {
            demandeSelect.dispatchEvent(new Event('change'));
        }

        // Preview des fichiers
        const fileInputs = [
            { input: 'cachet', preview: 'cachetPreview' },
            { input: 'signature', preview: 'signaturePreview' }
        ];

        fileInputs.forEach(function(item) {
            const input = document.getElementById(item.input);
            const preview = document.getElementById(item.preview);

            if (input && preview) {
                input.addEventListener('change', function(e) {
                    preview.innerHTML = '';
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.maxHeight = '60px';
                            img.style.maxWidth = '100px';
                            img.classList.add('border', 'rounded', 'p-1');
                            preview.appendChild(img);
                        };
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }
        });

        // Formulaire de génération - réactiver les champs disabled avant envoi
        const generateForm = document.getElementById('generateForm');
        if (generateForm) {
            generateForm.addEventListener('submit', function(e) {
                // Réactiver le select formation pour que sa valeur soit envoyée
                const formationSelect = document.getElementById('formation_id');
                if (formationSelect.disabled) {
                    formationSelect.disabled = false;
                }
                if (this.checkValidity()) {
                    showLoading();
                }
            });
        }
    });

    // Rouvrir le modal s'il y a des erreurs de validation
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            hideLoading();
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
