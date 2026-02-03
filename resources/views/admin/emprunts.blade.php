@extends('admin.layout')
@section('title', 'Gestion des Emprunts')
@section('subtitle', 'Gérez les livres empruntables et suivez les emprunts')

@section('content')
@php
    $totalLivres = $livresEmpruntables->count();
    $totalEmprunts = $emprunts->total();
    $empruntsEnCours = $emprunts->where('statut', 'en_cours')->count();
    $empruntsEnRetard = $emprunts->where('statut', 'en_retard')->count();
@endphp

<!-- Page Header -->
<div class="admin-page-header">
    <div class="admin-page-header-content">
        <div class="admin-page-icon">
            <i class="fas fa-book-reader"></i>
        </div>
        <div class="admin-page-info">
            <h1>Gestion des Emprunts</h1>
            <p>Gérez les livres empruntables et suivez les emprunts</p>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="admin-stats-row">
    <div class="admin-stat-card admin-stat-primary">
        <div class="admin-stat-icon">
            <i class="fas fa-book"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $totalLivres }}</span>
            <span class="admin-stat-label">Livres disponibles</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-warning">
        <div class="admin-stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $demandesEnAttente->count() }}</span>
            <span class="admin-stat-label">En attente</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-info">
        <div class="admin-stat-icon">
            <i class="fas fa-sync-alt"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $empruntsEnCours }}</span>
            <span class="admin-stat-label">En cours</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-danger">
        <div class="admin-stat-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $empruntsEnRetard }}</span>
            <span class="admin-stat-label">En retard</span>
        </div>
    </div>
</div>

<!-- Section: Demandes en attente -->
@if($demandesEnAttente->isNotEmpty())
<div class="admin-card admin-card-warning mb-4">
    <div class="admin-card-header">
        <div class="admin-card-title">
            <i class="fas fa-clock"></i>
            Demandes en attente de validation ({{ $demandesEnAttente->count() }})
        </div>
    </div>
    <div class="admin-card-body">
        <div class="admin-alert admin-alert-info mb-3">
            <i class="fas fa-info-circle"></i>
            Ces demandes d'emprunt nécessitent votre validation avant que les utilisateurs puissent accéder aux PDFs.
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Utilisateur</th>
                        <th>Livre</th>
                        <th>Date demande</th>
                        <th>Retour prévu</th>
                        <th>Stock</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandesEnAttente as $demande)
                        <tr>
                            <td><span class="admin-id">#{{ $demande->id }}</span></td>
                            <td>
                                <div class="admin-user-cell">
                                    <div class="admin-user-avatar-sm">
                                        {{ strtoupper(substr($demande->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="admin-user-info">
                                        <span class="admin-user-name">{{ $demande->user->name ?? 'Utilisateur inconnu' }}</span>
                                        <span class="admin-user-email">{{ $demande->user->email ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="admin-book-cell">
                                    @if($demande->livre && $demande->livre->image)
                                        <img src="{{ asset($demande->livre->image) }}" alt="{{ $demande->livre->titre }}" class="admin-book-thumb">
                                    @else
                                        <div class="admin-book-thumb-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                    <div class="admin-book-info">
                                        <span class="admin-book-title">{{ $demande->livre->titre ?? 'Livre supprimé' }}</span>
                                        <span class="admin-book-author">{{ $demande->livre->auteur ?? '' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="admin-date">{{ \Carbon\Carbon::parse($demande->date_emprunt)->format('d/m/Y') }}</span>
                                <span class="admin-date-relative">{{ \Carbon\Carbon::parse($demande->created_at)->diffForHumans() }}</span>
                            </td>
                            <td>
                                <span class="admin-date">{{ \Carbon\Carbon::parse($demande->date_retour)->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                @if($demande->livre)
                                    <span class="admin-badge admin-badge-{{ $demande->livre->quantite > 0 ? 'success' : 'danger' }}">
                                        {{ $demande->livre->quantite }} dispo.
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="admin-action-buttons">
                                    @if($demande->livre && $demande->livre->quantite > 0)
                                        <button type="button" class="btn-admin btn-admin-success btn-admin-sm btn-valider-demande"
                                                data-demande-id="{{ $demande->id }}"
                                                data-user-name="{{ $demande->user->name ?? 'Inconnu' }}"
                                                data-user-email="{{ $demande->user->email ?? '' }}"
                                                data-livre-titre="{{ $demande->livre->titre ?? 'Inconnu' }}"
                                                data-livre-auteur="{{ $demande->livre->auteur ?? '' }}"
                                                title="Valider">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    @endif
                                    <button type="button" class="btn-admin btn-admin-warning btn-admin-sm btn-rejeter-demande"
                                            data-demande-id="{{ $demande->id }}"
                                            data-user-name="{{ $demande->user->name ?? 'Inconnu' }}"
                                            data-user-email="{{ $demande->user->email ?? '' }}"
                                            data-livre-titre="{{ $demande->livre->titre ?? 'Inconnu' }}"
                                            data-livre-auteur="{{ $demande->livre->auteur ?? '' }}"
                                            title="Rejeter">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>

                                <!-- Hidden forms -->
                                <form id="form-valider-demande-{{ $demande->id }}" action="{{ route('admin.emprunts.valider', $demande) }}" method="POST" style="display:none;">
                                    @csrf
                                </form>
                                <form id="form-rejeter-demande-{{ $demande->id }}" action="{{ route('admin.emprunts.rejeter', $demande) }}" method="POST" style="display:none;">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- Section: Livres empruntables -->
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <div class="admin-card-title">
            <i class="fas fa-book"></i>
            Livres disponibles à l'emprunt ({{ $livresEmpruntables->count() }})
        </div>
        <button class="btn-admin btn-admin-primary btn-admin-sm" data-bs-toggle="collapse" data-bs-target="#addBookForm">
            <i class="fas fa-plus"></i> Ajouter un livre
        </button>
    </div>

    <!-- Add Book Form (Collapsible) -->
    <div class="collapse" id="addBookForm">
        <div class="admin-card-body admin-form-section">
            <form method="POST" action="{{ route('admin.emprunts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="admin-form-grid">
                    <div class="admin-form-group">
                        <label class="admin-label">Titre</label>
                        <input type="text" class="admin-input @error('titre') is-invalid @enderror" name="titre" value="{{ old('titre') }}" required>
                        @error('titre')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Auteur</label>
                        <input type="text" class="admin-input @error('auteur') is-invalid @enderror" name="auteur" value="{{ old('auteur') }}" required>
                        @error('auteur')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Catégorie</label>
                        <select class="admin-select @error('categorie') is-invalid @enderror" name="categorie" required>
                            <option value="">Choisir...</option>
                            @foreach(['Roman', 'Nouvelle', 'Essai', 'Jeunesse', 'Poésie', 'Théâtre', 'Biographie', 'Conte', 'Documentaire', 'Autre'] as $cat)
                                <option value="{{ $cat }}" {{ old('categorie') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('categorie')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Prix (FCFA)</label>
                        <input type="number" class="admin-input @error('prix') is-invalid @enderror" name="prix" value="{{ old('prix', 0) }}" min="0">
                        @error('prix')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Quantité</label>
                        <input type="number" class="admin-input @error('quantite') is-invalid @enderror" name="quantite" value="{{ old('quantite', 1) }}" min="0">
                        @error('quantite')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="admin-form-group admin-form-group-full">
                        <label class="admin-label">Résumé</label>
                        <textarea class="admin-textarea @error('resumer') is-invalid @enderror" name="resumer" rows="3">{{ old('resumer') }}</textarea>
                        @error('resumer')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Image de couverture</label>
                        <input type="file" class="admin-input-file @error('image') is-invalid @enderror" name="image" accept="image/*">
                        @error('image')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Fichier PDF</label>
                        <input type="file" class="admin-input-file @error('pdf') is-invalid @enderror" name="pdf" accept="application/pdf">
                        @error('pdf')<span class="admin-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin btn-admin-success">
                        <i class="fas fa-plus"></i> Ajouter le livre
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-card-body">
        @if($livresEmpruntables->isEmpty())
            <div class="admin-empty-state admin-empty-state-sm">
                <i class="fas fa-book"></i>
                <p>Aucun livre empruntable enregistré.</p>
            </div>
        @else
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Image</th>
                            <th>Titre</th>
                            <th>Auteur</th>
                            <th>Catégorie</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Statut</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($livresEmpruntables as $livre)
                            <tr>
                                <td>
                                    @if($livre->image)
                                        <img src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}" class="admin-book-thumb">
                                    @else
                                        <div class="admin-book-thumb-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $livre->titre }}</strong></td>
                                <td>{{ $livre->auteur }}</td>
                                <td><span class="admin-badge admin-badge-info">{{ $livre->categorie }}</span></td>
                                <td>{{ fcfa($livre->prix) }}</td>
                                <td>
                                    <span class="admin-badge admin-badge-{{ $livre->quantite > 0 ? 'success' : 'danger' }}">
                                        {{ $livre->quantite }}
                                    </span>
                                </td>
                                <td>
                                    @if($livre->quantite > 0)
                                        <span class="admin-badge admin-badge-success">Disponible</span>
                                    @else
                                        <span class="admin-badge admin-badge-danger">Épuisé</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="admin-action-buttons">
                                        <button type="button" class="btn-admin btn-admin-warning btn-admin-sm btn-edit-livre"
                                                data-livre-id="{{ $livre->id }}"
                                                data-livre-titre="{{ $livre->titre }}"
                                                data-livre-auteur="{{ $livre->auteur }}"
                                                data-livre-categorie="{{ $livre->categorie }}"
                                                data-livre-prix="{{ $livre->prix }}"
                                                data-livre-quantite="{{ $livre->quantite }}"
                                                data-livre-resumer="{{ $livre->resumer ?? '' }}"
                                                data-livre-image="{{ $livre->image ? asset($livre->image) : '' }}"
                                                data-livre-has-pdf="{{ $livre->pdf ? 'oui' : 'non' }}"
                                                data-update-url="{{ route('admin.emprunts.updateLivre', $livre->id) }}"
                                                title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn-admin btn-admin-danger btn-admin-sm btn-delete-livre"
                                                data-livre-id="{{ $livre->id }}"
                                                data-livre-titre="{{ $livre->titre }}"
                                                data-delete-url="{{ route('admin.emprunts.destroyLivre', $livre->id) }}"
                                                title="Supprimer">
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

<!-- Section: Emprunts enregistrés -->
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <div class="admin-card-title">
            <i class="fas fa-list"></i>
            Emprunts enregistrés ({{ $emprunts->total() }})
        </div>
        <button class="btn-admin btn-admin-warning btn-admin-sm" data-bs-toggle="collapse" data-bs-target="#createEmpruntForm">
            <i class="fas fa-plus"></i> Créer un emprunt
        </button>
    </div>

    <!-- Create Emprunt Form (Collapsible) -->
    <div class="collapse" id="createEmpruntForm">
        <div class="admin-card-body admin-form-section">
            <form method="POST" action="{{ route('admin.emprunts.addBooks') }}">
                @csrf
                <div class="admin-form-grid admin-form-grid-4">
                    <div class="admin-form-group">
                        <label class="admin-label">Utilisateur</label>
                        <select class="admin-select" name="user_id" required>
                            <option value="">Sélectionner...</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Livre</label>
                        <select class="admin-select" name="livre_id" required>
                            <option value="">Sélectionner...</option>
                            @foreach($livresEmpruntables as $livre)
                                <option value="{{ $livre->id }}">{{ $livre->titre }} (Stock: {{ $livre->quantite }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Date d'emprunt</label>
                        <input type="date" class="admin-input" name="date_emprunt" value="{{ now()->toDateString() }}" required>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-label">Date de retour</label>
                        <input type="date" class="admin-input" name="date_retour" value="{{ now()->addDays(14)->toDateString() }}">
                    </div>
                </div>
                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin btn-admin-warning">
                        <i class="fas fa-plus"></i> Créer l'emprunt
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="admin-card-body">
        @if($emprunts->isEmpty())
            <div class="admin-empty-state admin-empty-state-sm">
                <i class="fas fa-book-reader"></i>
                <p>Aucun emprunt enregistré.</p>
            </div>
        @else
            <div class="admin-table-wrapper">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Utilisateur</th>
                            <th>Livre</th>
                            <th>Emprunt</th>
                            <th>Retour</th>
                            <th>Statut</th>
                            <th>Validé</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($emprunts as $emprunt)
                            @php
                                $statusConfig = match($emprunt->statut) {
                                    'en_cours' => ['class' => 'warning', 'label' => 'En cours'],
                                    'retourne' => ['class' => 'success', 'label' => 'Retourné'],
                                    'en_retard' => ['class' => 'danger', 'label' => 'En retard'],
                                    default => ['class' => 'secondary', 'label' => $emprunt->statut]
                                };
                            @endphp
                            <tr>
                                <td><span class="admin-id">#{{ $emprunt->id }}</span></td>
                                <td>
                                    <div class="admin-user-cell">
                                        <div class="admin-user-avatar-sm">
                                            {{ strtoupper(substr($emprunt->user->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="admin-user-info">
                                            <span class="admin-user-name">{{ $emprunt->user->name ?? 'Inconnu' }}</span>
                                            <span class="admin-user-email">{{ $emprunt->user->email ?? '' }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="admin-book-info-simple">
                                        <span class="admin-book-title">{{ $emprunt->livre->titre ?? 'Livre supprimé' }}</span>
                                        <span class="admin-book-author">{{ $emprunt->livre->auteur ?? '' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="admin-date">{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</span>
                                </td>
                                <td>
                                    @if($emprunt->date_retour)
                                        <span class="admin-date">{{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="admin-badge admin-badge-{{ $statusConfig['class'] }}">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($emprunt->valide_le)
                                        <span class="admin-badge admin-badge-success">
                                            <i class="fas fa-check"></i> Oui
                                        </span>
                                    @else
                                        <span class="admin-badge admin-badge-warning">
                                            <i class="fas fa-clock"></i> Non
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="admin-action-buttons">
                                        @if(!$emprunt->valide_le && $emprunt->statut !== 'retourne')
                                            @if($emprunt->livre && $emprunt->livre->quantite > 0)
                                                <button type="button" class="btn-admin btn-admin-success btn-admin-sm btn-valider-emprunt"
                                                        data-emprunt-id="{{ $emprunt->id }}"
                                                        data-user-name="{{ $emprunt->user->name ?? 'Inconnu' }}"
                                                        data-livre-titre="{{ $emprunt->livre->titre ?? 'Inconnu' }}"
                                                        title="Valider">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        @endif
                                        @if($emprunt->statut !== 'retourne')
                                            <button type="button" class="btn-admin btn-admin-info btn-admin-sm btn-retourner-emprunt"
                                                    data-emprunt-id="{{ $emprunt->id }}"
                                                    title="Retourner">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif
                                        <button type="button" class="btn-admin btn-admin-danger btn-admin-sm btn-supprimer-emprunt"
                                                data-emprunt-id="{{ $emprunt->id }}"
                                                data-user-name="{{ $emprunt->user->name ?? 'Inconnu' }}"
                                                data-livre-titre="{{ $emprunt->livre->titre ?? 'Inconnu' }}"
                                                data-delete-url="{{ route('admin.emprunts.destroy', $emprunt) }}"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Hidden forms -->
                                    <form id="form-valider-{{ $emprunt->id }}" action="{{ route('admin.emprunts.valider', $emprunt) }}" method="POST" style="display:none;">
                                        @csrf
                                    </form>
                                    <form id="form-retourner-{{ $emprunt->id }}" action="{{ route('admin.emprunts.updateStatus', $emprunt) }}" method="POST" style="display:none;">
                                        @csrf
                                        <input type="hidden" name="statut" value="retourne">
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($emprunts->hasPages())
                <div class="admin-pagination-wrapper">
                    {{ $emprunts->links() }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Modal: Valider demande/emprunt -->
<div class="modal fade" id="validerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-success">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle"></i> Confirmer la validation
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-alert admin-alert-info mb-3">
                    <i class="fas fa-info-circle"></i>
                    <div>
                        <strong>Cette action va :</strong>
                        <ul class="mb-0 mt-1">
                            <li>Valider la demande d'emprunt</li>
                            <li>Décrémenter le stock du livre</li>
                            <li>Permettre à l'utilisateur d'accéder au PDF</li>
                        </ul>
                    </div>
                </div>
                <div id="validerModalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="validerForm" method="POST">
                    @csrf
                    <button type="submit" class="btn-admin btn-admin-success">
                        <i class="fas fa-check"></i> Valider
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Rejeter demande -->
<div class="modal fade" id="rejeterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-warning">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Confirmer le rejet
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-alert admin-alert-warning mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    Cette action va supprimer définitivement la demande d'emprunt.
                </div>
                <div id="rejeterModalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="rejeterForm" method="POST">
                    @csrf
                    <button type="submit" class="btn-admin btn-admin-warning">
                        <i class="fas fa-ban"></i> Rejeter
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Supprimer emprunt -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-danger">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Confirmer la suppression
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cet emprunt ?</p>
                <div id="deleteModalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Modifier livre -->
<div class="modal fade" id="editLivreModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-warning">
                <h5 class="modal-title" id="editLivreModalLabel">
                    <i class="fas fa-edit"></i> Modifier le livre
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editLivreForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="admin-form-grid">
                        <div class="admin-form-group">
                            <label class="admin-label">Titre</label>
                            <input type="text" class="admin-input" id="edit_titre" name="titre" required>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Auteur</label>
                            <input type="text" class="admin-input" id="edit_auteur" name="auteur" required>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Catégorie</label>
                            <input type="text" class="admin-input" id="edit_categorie" name="categorie">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Prix (FCFA)</label>
                            <input type="number" class="admin-input" id="edit_prix" name="prix" min="0">
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Stock</label>
                            <input type="number" class="admin-input" id="edit_quantite" name="quantite" min="0">
                        </div>
                        <div class="admin-form-group admin-form-group-full">
                            <label class="admin-label">Résumé</label>
                            <textarea class="admin-textarea" id="edit_resumer" name="resumer" rows="3"></textarea>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">Image (optionnel)</label>
                            <input type="file" class="admin-input-file" id="edit_image" name="image" accept="image/*">
                            <small class="admin-hint" id="current_image_info"></small>
                        </div>
                        <div class="admin-form-group">
                            <label class="admin-label">PDF (optionnel)</label>
                            <input type="file" class="admin-input-file" id="edit_pdf" name="pdf" accept="application/pdf">
                            <small class="admin-hint" id="current_pdf_info"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-admin btn-admin-warning">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Supprimer livre -->
<div class="modal fade" id="deleteLivreModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-danger">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Supprimer le livre
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-alert admin-alert-warning mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    Cette action est irréversible.
                </div>
                <p>Êtes-vous sûr de vouloir supprimer ce livre ?</p>
                <div id="deleteLivreModalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteLivreForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Page Header */
    .admin-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .admin-page-header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .admin-page-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(30, 122, 47, 0.3);
    }

    .admin-page-info h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--admin-gray-900);
    }

    .admin-page-info p {
        font-size: 0.875rem;
        color: var(--admin-gray-500);
        margin: 0;
    }

    /* Stats Row */
    .admin-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .admin-stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .admin-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .admin-stat-card.admin-stat-primary { border-color: var(--admin-primary); }
    .admin-stat-card.admin-stat-warning { border-color: #f59e0b; }
    .admin-stat-card.admin-stat-info { border-color: #0ea5e9; }
    .admin-stat-card.admin-stat-danger { border-color: #ef4444; }

    .admin-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .admin-stat-primary .admin-stat-icon { background: rgba(30, 122, 47, 0.1); color: var(--admin-primary); }
    .admin-stat-warning .admin-stat-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .admin-stat-info .admin-stat-icon { background: rgba(14, 165, 233, 0.1); color: #0ea5e9; }
    .admin-stat-danger .admin-stat-icon { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    .admin-stat-content {
        display: flex;
        flex-direction: column;
    }

    .admin-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-gray-900);
        line-height: 1.2;
    }

    .admin-stat-label {
        font-size: 0.8rem;
        color: var(--admin-gray-500);
    }

    /* Card Variants */
    .admin-card-warning {
        border-left: 4px solid #f59e0b;
    }

    .admin-card-warning .admin-card-header {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(245, 158, 11, 0.05));
    }

    .admin-card-warning .admin-card-title i {
        color: #f59e0b;
    }

    /* Alert */
    .admin-alert {
        padding: 1rem;
        border-radius: 8px;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .admin-alert i {
        margin-top: 0.125rem;
    }

    .admin-alert-info {
        background: rgba(14, 165, 233, 0.1);
        color: #0369a1;
        border: 1px solid rgba(14, 165, 233, 0.2);
    }

    .admin-alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #b45309;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    /* Table Cell Styles */
    .admin-id {
        font-family: monospace;
        font-size: 0.8rem;
        color: var(--admin-gray-500);
        background: var(--admin-gray-100);
        padding: 0.2rem 0.5rem;
        border-radius: 4px;
    }

    .admin-user-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .admin-user-avatar-sm {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .admin-user-info {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .admin-user-name {
        font-weight: 600;
        color: var(--admin-gray-900);
        font-size: 0.875rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .admin-user-email {
        font-size: 0.75rem;
        color: var(--admin-gray-500);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .admin-book-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .admin-book-thumb {
        width: 40px;
        height: 56px;
        object-fit: cover;
        border-radius: 4px;
        flex-shrink: 0;
    }

    .admin-book-thumb-placeholder {
        width: 40px;
        height: 56px;
        background: var(--admin-gray-200);
        border-radius: 4px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-gray-400);
        flex-shrink: 0;
    }

    .admin-book-info,
    .admin-book-info-simple {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .admin-book-title {
        font-weight: 600;
        color: var(--admin-gray-900);
        font-size: 0.875rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .admin-book-author {
        font-size: 0.75rem;
        color: var(--admin-gray-500);
    }

    .admin-date {
        display: block;
        font-size: 0.875rem;
        color: var(--admin-gray-700);
    }

    .admin-date-relative {
        display: block;
        font-size: 0.75rem;
        color: var(--admin-gray-500);
    }

    /* Action Buttons */
    .admin-action-buttons {
        display: flex;
        gap: 0.375rem;
        justify-content: center;
    }

    /* Form Styles */
    .admin-form-section {
        background: var(--admin-gray-50);
        border-top: 1px solid var(--admin-gray-200);
        border-bottom: 1px solid var(--admin-gray-200);
    }

    .admin-form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .admin-form-grid-4 {
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
    }

    .admin-form-group {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }

    .admin-form-group-full {
        grid-column: 1 / -1;
    }

    .admin-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--admin-gray-700);
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .admin-input,
    .admin-select,
    .admin-textarea {
        padding: 0.625rem 0.875rem;
        border: 1px solid var(--admin-gray-300);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        background: white;
    }

    .admin-input:focus,
    .admin-select:focus,
    .admin-textarea:focus {
        outline: none;
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(30, 122, 47, 0.1);
    }

    .admin-input-file {
        padding: 0.5rem;
        border: 1px dashed var(--admin-gray-300);
        border-radius: 8px;
        font-size: 0.875rem;
        background: white;
    }

    .admin-textarea {
        resize: vertical;
        min-height: 80px;
    }

    .admin-error {
        font-size: 0.75rem;
        color: #ef4444;
    }

    .admin-hint {
        font-size: 0.75rem;
        color: var(--admin-gray-500);
    }

    .admin-form-actions {
        margin-top: 1rem;
        display: flex;
        justify-content: flex-end;
        gap: 0.5rem;
    }

    /* Empty State Small */
    .admin-empty-state-sm {
        padding: 2rem;
        text-align: center;
        color: var(--admin-gray-500);
    }

    .admin-empty-state-sm i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        opacity: 0.5;
    }

    .admin-empty-state-sm p {
        margin: 0;
    }

    /* Modal Styles */
    .admin-modal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .admin-modal-header {
        padding: 1rem 1.25rem;
        border: none;
    }

    .admin-modal-header .modal-title {
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-modal-header-success {
        background: linear-gradient(135deg, #10b981, #059669);
    }

    .admin-modal-header-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .admin-modal-header-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    /* Modal Content Cards */
    .admin-modal-info-card {
        background: var(--admin-gray-50);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
    }

    .admin-modal-info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--admin-gray-200);
    }

    .admin-modal-info-item:last-child {
        border-bottom: none;
    }

    .admin-modal-info-item i {
        width: 20px;
        color: var(--admin-primary);
    }

    /* Pagination */
    .admin-pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 1.5rem;
        padding-top: 1rem;
        border-top: 1px solid var(--admin-gray-200);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .admin-form-grid {
            grid-template-columns: 1fr;
        }

        .admin-action-buttons {
            flex-direction: column;
        }

        .admin-user-cell {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .admin-user-avatar-sm {
            display: none;
        }

        .admin-book-cell {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }

        .admin-book-thumb,
        .admin-book-thumb-placeholder {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .admin-stats-row {
            grid-template-columns: 1fr;
        }

        .admin-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .admin-card-header .btn-admin {
            width: 100%;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Modal instances
    const validerModal = new bootstrap.Modal(document.getElementById('validerModal'));
    const rejeterModal = new bootstrap.Modal(document.getElementById('rejeterModal'));
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const editLivreModal = new bootstrap.Modal(document.getElementById('editLivreModal'));
    const deleteLivreModal = new bootstrap.Modal(document.getElementById('deleteLivreModal'));

    // Valider demande buttons
    document.querySelectorAll('.btn-valider-demande').forEach(btn => {
        btn.addEventListener('click', function() {
            const demandeId = this.dataset.demandeId;
            const userName = this.dataset.userName;
            const userEmail = this.dataset.userEmail;
            const livreTitre = this.dataset.livreTitre;
            const livreAuteur = this.dataset.livreAuteur;

            document.getElementById('validerModalContent').innerHTML = `
                <div class="admin-modal-info-card">
                    <div class="admin-modal-info-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <strong>${userName}</strong><br>
                            <small class="text-muted">${userEmail}</small>
                        </div>
                    </div>
                    <div class="admin-modal-info-item">
                        <i class="fas fa-book"></i>
                        <div>
                            <strong>${livreTitre}</strong><br>
                            <small class="text-muted">${livreAuteur}</small>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('validerForm').action = document.getElementById('form-valider-demande-' + demandeId).action;
            validerModal.show();
        });
    });

    // Rejeter demande buttons
    document.querySelectorAll('.btn-rejeter-demande').forEach(btn => {
        btn.addEventListener('click', function() {
            const demandeId = this.dataset.demandeId;
            const userName = this.dataset.userName;
            const userEmail = this.dataset.userEmail;
            const livreTitre = this.dataset.livreTitre;
            const livreAuteur = this.dataset.livreAuteur;

            document.getElementById('rejeterModalContent').innerHTML = `
                <div class="admin-modal-info-card">
                    <div class="admin-modal-info-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <strong>${userName}</strong><br>
                            <small class="text-muted">${userEmail}</small>
                        </div>
                    </div>
                    <div class="admin-modal-info-item">
                        <i class="fas fa-book"></i>
                        <div>
                            <strong>${livreTitre}</strong><br>
                            <small class="text-muted">${livreAuteur}</small>
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('rejeterForm').action = document.getElementById('form-rejeter-demande-' + demandeId).action;
            rejeterModal.show();
        });
    });

    // Valider emprunt buttons
    document.querySelectorAll('.btn-valider-emprunt').forEach(btn => {
        btn.addEventListener('click', function() {
            const empruntId = this.dataset.empruntId;
            const userName = this.dataset.userName;
            const livreTitre = this.dataset.livreTitre;

            document.getElementById('validerModalContent').innerHTML = `
                <div class="admin-modal-info-card">
                    <div class="admin-modal-info-item">
                        <i class="fas fa-user"></i>
                        <strong>${userName}</strong>
                    </div>
                    <div class="admin-modal-info-item">
                        <i class="fas fa-book"></i>
                        <strong>${livreTitre}</strong>
                    </div>
                </div>
            `;

            document.getElementById('validerForm').action = document.getElementById('form-valider-' + empruntId).action;
            validerModal.show();
        });
    });

    // Retourner emprunt buttons
    document.querySelectorAll('.btn-retourner-emprunt').forEach(btn => {
        btn.addEventListener('click', function() {
            const empruntId = this.dataset.empruntId;
            if (confirm('Marquer cet emprunt comme retourné ?')) {
                document.getElementById('form-retourner-' + empruntId).submit();
            }
        });
    });

    // Supprimer emprunt buttons
    document.querySelectorAll('.btn-supprimer-emprunt').forEach(btn => {
        btn.addEventListener('click', function() {
            const userName = this.dataset.userName;
            const livreTitre = this.dataset.livreTitre;
            const deleteUrl = this.dataset.deleteUrl;

            document.getElementById('deleteModalContent').innerHTML = `
                <div class="admin-modal-info-card">
                    <div class="admin-modal-info-item">
                        <i class="fas fa-user"></i>
                        <strong>${userName}</strong>
                    </div>
                    <div class="admin-modal-info-item">
                        <i class="fas fa-book"></i>
                        <strong>${livreTitre}</strong>
                    </div>
                </div>
            `;

            document.getElementById('deleteForm').action = deleteUrl;
            deleteModal.show();
        });
    });

    // Edit livre buttons
    document.querySelectorAll('.btn-edit-livre').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('edit_titre').value = this.dataset.livreTitre;
            document.getElementById('edit_auteur').value = this.dataset.livreAuteur;
            document.getElementById('edit_categorie').value = this.dataset.livreCategorie;
            document.getElementById('edit_prix').value = this.dataset.livrePrix;
            document.getElementById('edit_quantite').value = this.dataset.livreQuantite;
            document.getElementById('edit_resumer').value = this.dataset.livreResumer;

            document.getElementById('editLivreModalLabel').innerHTML = '<i class="fas fa-edit"></i> Modifier: ' + this.dataset.livreTitre;

            if (this.dataset.livreImage) {
                document.getElementById('current_image_info').innerHTML = 'Image actuelle: <img src="' + this.dataset.livreImage + '" style="height: 30px; border-radius: 4px;">';
            } else {
                document.getElementById('current_image_info').textContent = '';
            }

            document.getElementById('current_pdf_info').textContent = this.dataset.livreHasPdf === 'oui' ? 'PDF actuel disponible' : '';

            document.getElementById('editLivreForm').action = this.dataset.updateUrl;
            editLivreModal.show();
        });
    });

    // Delete livre buttons
    document.querySelectorAll('.btn-delete-livre').forEach(btn => {
        btn.addEventListener('click', function() {
            const livreTitre = this.dataset.livreTitre;
            const deleteUrl = this.dataset.deleteUrl;

            document.getElementById('deleteLivreModalContent').innerHTML = `
                <div class="admin-modal-info-card">
                    <div class="admin-modal-info-item">
                        <i class="fas fa-book"></i>
                        <strong>${livreTitre}</strong>
                    </div>
                </div>
            `;

            document.getElementById('deleteLivreForm').action = deleteUrl;
            deleteLivreModal.show();
        });
    });
});
</script>
@endpush
