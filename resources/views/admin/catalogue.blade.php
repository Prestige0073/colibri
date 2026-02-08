@extends('admin.layout')

@section('title', 'Gestion du Catalogue')
@section('subtitle', '{{ $catalogues->total() }} livre(s) au catalogue')

@section('content')

<!-- Header avec stats rapides -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3">
                <div class="page-header-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <h1 class="page-title">Catalogue des livres</h1>
                    <p class="page-subtitle">{{ $catalogues->total() }} livre(s) enregistré(s)</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                <button class="btn-admin btn-admin-primary" data-bs-toggle="collapse" data-bs-target="#addBookForm">
                    <i class="fas fa-plus me-2"></i>Ajouter un livre
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    @php
        $totalBooks = $catalogues->total();
        $inStock = $catalogues->where('quantite', '>', 0)->count();
        $outOfStock = $catalogues->where('quantite', 0)->count();
    @endphp
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-primary-soft text-primary">
                <i class="fas fa-book"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $totalBooks }}</span>
                <span class="quick-stat-label">Total livres</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-success-soft text-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $inStock }}</span>
                <span class="quick-stat-label">En stock</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-danger-soft text-danger">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $outOfStock }}</span>
                <span class="quick-stat-label">Épuisés</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-info-soft text-info">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $catalogues->whereNotNull('pdf')->count() }}</span>
                <span class="quick-stat-label">Avec PDF</span>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire d'ajout (collapsible) -->
<div class="collapse mb-4" id="addBookForm">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-plus-circle"></i>
                <span id="formTitle">Ajouter un nouveau livre</span>
            </h3>
            <button class="btn-admin btn-admin-sm btn-admin-secondary" data-bs-toggle="collapse" data-bs-target="#addBookForm">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="admin-card-body">
            <form id="catalogueForm" method="POST" enctype="multipart/form-data" action="{{ route('admin.catalogue.store') }}">
                @csrf
                <input type="hidden" id="catalogue_id" name="catalogue_id" value="">

                <div class="row g-4">
                    <!-- Infos principales -->
                    <div class="col-md-6">
                        <div class="form-section">
                            <h4 class="form-section-title"><i class="fas fa-info-circle me-2"></i>Informations générales</h4>

                            <div class="admin-form-group">
                                <label class="admin-form-label">
                                    <i class="fas fa-heading"></i>Titre du livre <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="admin-form-control" id="titre" name="titre" placeholder="Ex: Les Soleils des Indépendances" required>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label">
                                            <i class="fas fa-user-edit"></i>Auteur <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="admin-form-control" id="auteur" name="auteur" placeholder="Ex: Ahmadou Kourouma" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label">
                                            <i class="fas fa-tag"></i>Catégorie <span class="text-danger">*</span>
                                        </label>
                                        <select class="admin-form-control" id="categorie" name="categorie" required>
                                            <option value="">Sélectionner...</option>
                                            <option value="Roman">Roman</option>
                                            <option value="Nouvelle">Nouvelle</option>
                                            <option value="Essai">Essai</option>
                                            <option value="Jeunesse">Jeunesse</option>
                                            <option value="Poésie">Poésie</option>
                                            <option value="Théâtre">Théâtre</option>
                                            <option value="Biographie">Biographie</option>
                                            <option value="Conte">Conte</option>
                                            <option value="Documentaire">Documentaire</option>
                                            <option value="Autre">Autre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label">
                                            <i class="fas fa-coins"></i>Prix (FCFA) <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="admin-form-control" id="prix" name="prix" placeholder="5000" min="0" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="admin-form-group">
                                        <label class="admin-form-label">
                                            <i class="fas fa-boxes"></i>Quantité en stock
                                        </label>
                                        <input type="number" class="admin-form-control" id="quantite" name="quantite" placeholder="10" min="0" value="0">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fichiers -->
                    <div class="col-md-6">
                        <div class="form-section">
                            <h4 class="form-section-title"><i class="fas fa-cloud-upload-alt me-2"></i>Fichiers & Médias</h4>

                            <div class="admin-form-group">
                                <label class="admin-form-label">
                                    <i class="fas fa-image"></i>Image de couverture
                                </label>
                                <div class="file-upload-wrapper">
                                    <input type="file" class="file-upload-input" id="image" name="image" accept="image/*">
                                    <div class="file-upload-content">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Glissez une image ou cliquez pour sélectionner</span>
                                        <small>PNG, JPG, WEBP (max 2MB)</small>
                                    </div>
                                    <div class="file-upload-preview" id="imagePreview"></div>
                                </div>
                            </div>

                            <div class="admin-form-group">
                                <label class="admin-form-label">
                                    <i class="fas fa-file-alt"></i>Type de contenu numérique
                                </label>
                                <select class="admin-form-control" id="type_contenu" name="type_contenu" onchange="toggleContentFields()">
                                    <option value="">Livre physique uniquement</option>
                                    <option value="pdf">PDF (livre numérique)</option>
                                    <option value="audio">Audio (livre audio)</option>
                                </select>
                            </div>

                            <div id="pdf_field" class="admin-form-group" style="display:none;">
                                <label class="admin-form-label">
                                    <i class="fas fa-file-pdf text-danger"></i>Fichier PDF
                                </label>
                                <input type="file" class="admin-form-control" id="pdf" name="pdf" accept=".pdf,application/pdf">
                            </div>

                            <div id="audio_field" class="admin-form-group" style="display:none;">
                                <label class="admin-form-label">
                                    <i class="fas fa-headphones text-info"></i>Fichier Audio
                                </label>
                                <input type="file" class="admin-form-control" id="audio" name="audio" accept="audio/*">
                                <small class="text-muted">Formats: MP3, WAV, OGG, M4A</small>
                            </div>
                        </div>
                    </div>

                    <!-- Résumé -->
                    <div class="col-12">
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <i class="fas fa-align-left"></i>Résumé du livre
                            </label>
                            <textarea class="admin-form-control" id="resumer-catalogue-editor" name="resumer" rows="4" placeholder="Description et résumé du livre..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-admin btn-admin-secondary" id="catalogueCancelEdit" style="display:none;">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn-admin btn-admin-primary" id="catalogueSubmitBtn">
                        <i class="fas fa-save me-2"></i><span id="catalogueSubmitText">Enregistrer le livre</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Table des livres -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="fas fa-list"></i>
            Liste des livres
        </h3>
        <div class="d-flex gap-2 align-items-center">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchCatalogue" placeholder="Rechercher..." class="search-input">
            </div>
        </div>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-wrapper">
            <table class="admin-table" id="catalogueTable">
                <thead>
                    <tr>
                        <th style="width: 60px;">Image</th>
                        <th>Livre</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Stock</th>
                        <th>Statut</th>
                        <th>Fichiers</th>
                        <th class="text-center" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($catalogues as $cat)
                        <tr class="catalogue-row"
                            data-id="{{ $cat->id }}"
                            data-titre="{{ $cat->titre ?? '' }}"
                            data-auteur="{{ $cat->auteur ?? '' }}"
                            data-categorie="{{ $cat->categorie ?? '' }}"
                            data-prix="{{ $cat->prix ?? 0 }}"
                            data-prix-formatted="{{ $cat->prix ? fcfa($cat->prix) : 'Gratuit' }}"
                            data-quantite="{{ $cat->quantite ?? 0 }}"
                            data-image="{{ $cat->image ? asset($cat->image) : '' }}"
                            data-pdf="{{ $cat->pdf ? asset($cat->pdf) : '' }}"
                            data-resumer="{{ strip_tags($cat->resumer ?? '') }}">
                            <td>
                                <div class="table-image">
                                    @if($cat->image)
                                        <img src="{{ asset($cat->image) }}" alt="{{ $cat->titre }}">
                                    @else
                                        <div class="table-image-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="table-book-info">
                                    <h4 class="book-title">{{ $cat->titre ?? '-' }}</h4>
                                    <p class="book-author">{{ $cat->auteur ?? '-' }}</p>
                                </div>
                            </td>
                            <td>
                                <span class="admin-badge admin-badge-info">{{ $cat->categorie ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="price-tag">{{ $cat->prix ? fcfa($cat->prix) : 'Gratuit' }}</span>
                            </td>
                            <td>
                                <span class="stock-value {{ ($cat->quantite ?? 0) == 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $cat->quantite ?? 0 }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $q = $cat->quantite ?? 0;
                                @endphp
                                @if($q == 0)
                                    <span class="admin-badge admin-badge-danger pulse-badge">
                                        <i class="fas fa-times-circle me-1"></i>Épuisé
                                    </span>
                                @elseif($q <= 5)
                                    <span class="admin-badge admin-badge-warning">
                                        <i class="fas fa-exclamation-circle me-1"></i>Stock bas
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-success">
                                        <i class="fas fa-check-circle me-1"></i>Disponible
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="file-icons">
                                    @if($cat->pdf)
                                        <a href="{{ asset($cat->pdf) }}" target="_blank" class="file-icon file-icon-pdf" title="Voir PDF">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    @if($cat->audio)
                                        <a href="{{ asset($cat->audio) }}" target="_blank" class="file-icon file-icon-audio" title="Écouter">
                                            <i class="fas fa-headphones"></i>
                                        </a>
                                    @endif
                                    @if(!$cat->pdf && !$cat->audio)
                                        <span class="text-muted small">—</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action btn-action-view" title="Voir détails" onclick="showBookDetails(this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action btn-action-edit btn-edit-catalogue" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-action btn-action-delete" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteCatalogueModal{{ $cat->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal de suppression -->
                                <div class="modal fade" id="deleteCatalogueModal{{ $cat->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                                <h5 class="modal-title text-white">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="delete-icon mb-3">
                                                    <i class="fas fa-book"></i>
                                                </div>
                                                <p class="mb-1">Êtes-vous sûr de vouloir supprimer</p>
                                                <h5 class="fw-bold text-danger">{{ $cat->titre }}</h5>
                                                <p class="text-muted small">Cette action est irréversible</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Annuler
                                                </button>
                                                <form method="POST" action="{{ route('admin.catalogue.destroy', $cat->id) }}" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-admin btn-admin-danger">
                                                        <i class="fas fa-trash me-2"></i>Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-book-open"></i>
                                    <h4>Aucun livre dans le catalogue</h4>
                                    <p>Commencez par ajouter votre premier livre</p>
                                    <button class="btn-admin btn-admin-primary" data-bs-toggle="collapse" data-bs-target="#addBookForm">
                                        <i class="fas fa-plus me-2"></i>Ajouter un livre
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($catalogues->hasPages())
        <div class="admin-card-footer">
            <div class="pagination-wrapper">
                {{ $catalogues->links() }}
            </div>
        </div>
    @endif
</div>

<!-- Modal détails livre -->
<div class="modal fade" id="bookDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));">
                <h5 class="modal-title text-white">
                    <i class="fas fa-book-open me-2"></i>Détails du livre
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-4">
                    <div class="col-md-4 text-center">
                        <div class="book-detail-image">
                            <img id="modalImage" src="" alt="" class="img-fluid rounded">
                        </div>
                        <div id="modalPdfLink" class="mt-3"></div>
                    </div>
                    <div class="col-md-8">
                        <h3 id="modalTitre" class="mb-2"></h3>
                        <p class="text-muted mb-4">Par <strong id="modalAuteur"></strong></p>

                        <div class="book-detail-grid">
                            <div class="detail-item">
                                <span class="detail-label">Catégorie</span>
                                <span class="detail-value" id="modalCategorie"></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Prix</span>
                                <span class="detail-value text-success fw-bold" id="modalPrix"></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Stock</span>
                                <span class="detail-value" id="modalQuantite"></span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Statut</span>
                                <span id="modalStatut"></span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="text-muted mb-2">Résumé</h6>
                            <p id="modalResumer" class="text-justify"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.confirmation-modal')

@endsection

@push('styles')
<style>
    /* Page Header */
    .page-header {
        padding: 1.5rem;
        background: var(--admin-surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--admin-gray-200);
    }

    .page-header-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5rem;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-text);
        margin: 0;
    }

    .page-subtitle {
        color: var(--admin-text-muted);
        margin: 0;
        font-size: 0.875rem;
    }

    /* Quick Stats */
    .quick-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: var(--admin-surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--admin-gray-200);
    }

    .quick-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }

    .quick-stat-content {
        display: flex;
        flex-direction: column;
    }

    .quick-stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--admin-text);
        line-height: 1.2;
    }

    .quick-stat-label {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
    }

    /* Form Sections */
    .form-section {
        background: var(--admin-gray-100);
        padding: 1.25rem;
        border-radius: var(--radius-md);
        height: 100%;
    }

    .form-section-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-text);
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--admin-gray-300);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--admin-gray-200);
    }

    /* File Upload */
    .file-upload-wrapper {
        position: relative;
        border: 2px dashed var(--admin-gray-300);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        text-align: center;
        transition: all var(--transition-fast);
        cursor: pointer;
    }

    .file-upload-wrapper:hover {
        border-color: var(--admin-primary);
        background: var(--admin-primary-bg);
    }

    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        color: var(--admin-text-muted);
    }

    .file-upload-content i {
        font-size: 2rem;
        color: var(--admin-primary);
    }

    .file-upload-content small {
        font-size: 0.75rem;
    }

    /* Search Box */
    .search-box {
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--admin-text-muted);
    }

    .search-input {
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border: 1px solid var(--admin-gray-300);
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        width: 200px;
        transition: all var(--transition-fast);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--admin-primary);
        width: 250px;
    }

    /* Table Styles */
    .table-image {
        width: 50px;
        height: 50px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
    }

    .table-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .table-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--admin-gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-text-muted);
    }

    .table-book-info {
        min-width: 0;
    }

    .book-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-text);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    .book-author {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        margin: 0;
    }

    .price-tag {
        font-weight: 600;
        color: var(--admin-success);
    }

    .stock-value {
        font-weight: 700;
        font-size: 1rem;
    }

    .pulse-badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    /* File Icons */
    .file-icons {
        display: flex;
        gap: 0.5rem;
    }

    .file-icon {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all var(--transition-fast);
    }

    .file-icon-pdf {
        background: rgba(239, 68, 68, 0.1);
        color: var(--admin-danger);
    }

    .file-icon-pdf:hover {
        background: var(--admin-danger);
        color: #fff;
    }

    .file-icon-audio {
        background: rgba(59, 130, 246, 0.1);
        color: var(--admin-info);
    }

    .file-icon-audio:hover {
        background: var(--admin-info);
        color: #fff;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.375rem;
        justify-content: center;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-fast);
        font-size: 0.8rem;
    }

    .btn-action-view {
        background: rgba(59, 130, 246, 0.1);
        color: var(--admin-info);
    }

    .btn-action-view:hover {
        background: var(--admin-info);
        color: #fff;
    }

    .btn-action-edit {
        background: rgba(245, 158, 11, 0.1);
        color: var(--admin-warning);
    }

    .btn-action-edit:hover {
        background: var(--admin-warning);
        color: #fff;
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--admin-danger);
    }

    .btn-action-delete:hover {
        background: var(--admin-danger);
        color: #fff;
    }

    /* Delete Modal Icon */
    .delete-icon {
        width: 80px;
        height: 80px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: var(--admin-danger);
        font-size: 2rem;
    }

    /* Book Detail Modal */
    .book-detail-image img {
        max-height: 250px;
        object-fit: cover;
        box-shadow: var(--shadow-lg);
    }

    .book-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .detail-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-text);
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--admin-gray-400);
        margin-bottom: 1rem;
    }

    .empty-state h4 {
        font-size: 1.25rem;
        color: var(--admin-text);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--admin-text-muted);
        margin-bottom: 1.5rem;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script src="{{ asset('js/form-validation.js') }}"></script>
<script>
(function(){
    let catalogueEditorInstance = null;
    let editMode = false;
    let editId = null;
    const form = document.getElementById('catalogueForm');
    const submitBtn = document.getElementById('catalogueSubmitBtn');
    const submitText = document.getElementById('catalogueSubmitText');
    const cancelEditBtn = document.getElementById('catalogueCancelEdit');
    const formTitle = document.getElementById('formTitle');
    const textarea = document.getElementById('resumer-catalogue-editor');
    const addBookCollapse = document.getElementById('addBookForm');

    // Initialize CKEditor
    if (textarea) {
        ClassicEditor.create(textarea, {
            toolbar: ['undo', 'redo', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'link'],
            language: 'fr'
        }).then(editor => catalogueEditorInstance = editor).catch(() => {});
    }

    // Form default action
    form.action = "{{ route('admin.catalogue.store') }}";

    // Form submit handler
    form.addEventListener('submit', function(e) {
        if (catalogueEditorInstance && textarea) {
            textarea.value = catalogueEditorInstance.getData();
        }

        if (editMode && editId) {
            form.action = `/admin/catalogue/${editId}`;
            let methodInput = form.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PATCH';
        }
    });

    // Cancel edit
    cancelEditBtn.addEventListener('click', function() {
        resetForm();
    });

    function resetForm() {
        editMode = false;
        editId = null;
        form.reset();
        form.action = "{{ route('admin.catalogue.store') }}";
        let methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        if (catalogueEditorInstance) catalogueEditorInstance.setData('');
        formTitle.textContent = 'Ajouter un nouveau livre';
        submitText.textContent = 'Enregistrer le livre';
        submitBtn.classList.remove('btn-admin-warning');
        submitBtn.classList.add('btn-admin-primary');
        cancelEditBtn.style.display = 'none';
    }

    // Edit button handler
    document.querySelectorAll('.btn-edit-catalogue').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const row = this.closest('tr');
            if (!row) return;

            editMode = true;
            editId = row.dataset.id;
            document.getElementById('catalogue_id').value = editId;
            document.getElementById('titre').value = row.dataset.titre || '';
            document.getElementById('auteur').value = row.dataset.auteur || '';
            document.getElementById('categorie').value = row.dataset.categorie || '';
            document.getElementById('prix').value = row.dataset.prix || '';
            document.getElementById('quantite').value = row.dataset.quantite || '';
            if (catalogueEditorInstance) catalogueEditorInstance.setData(row.dataset.resumer || '');

            formTitle.textContent = 'Modifier le livre';
            submitText.textContent = 'Mettre à jour';
            submitBtn.classList.remove('btn-admin-primary');
            submitBtn.classList.add('btn-admin-warning');
            cancelEditBtn.style.display = '';

            // Open the form
            const collapse = bootstrap.Collapse.getOrCreateInstance(addBookCollapse);
            collapse.show();

            // Scroll to form
            setTimeout(() => {
                addBookCollapse.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        });
    });

    // Search functionality
    const searchInput = document.getElementById('searchCatalogue');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            document.querySelectorAll('#catalogueTable tbody tr').forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }

    // Image preview
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `<img src="${e.target.result}" style="max-height: 100px; border-radius: 8px;">`;
                };
                reader.readAsDataURL(file);
            }
        });
    }
})();

// Toggle content fields
function toggleContentFields() {
    const typeContenu = document.getElementById('type_contenu').value;
    const pdfField = document.getElementById('pdf_field');
    const audioField = document.getElementById('audio_field');

    if (typeContenu === 'pdf') {
        pdfField.style.display = '';
        audioField.style.display = 'none';
        document.getElementById('audio').value = '';
    } else if (typeContenu === 'audio') {
        pdfField.style.display = 'none';
        audioField.style.display = '';
        document.getElementById('pdf').value = '';
    } else {
        pdfField.style.display = 'none';
        audioField.style.display = 'none';
        document.getElementById('pdf').value = '';
    }
}

// Show book details modal
function showBookDetails(btn) {
    const row = btn.closest('tr');
    if (!row) return;

    document.getElementById('modalTitre').textContent = row.dataset.titre || '';
    document.getElementById('modalAuteur').textContent = row.dataset.auteur || '';
    document.getElementById('modalCategorie').textContent = row.dataset.categorie || '';
    document.getElementById('modalPrix').textContent = row.dataset.prixFormatted || '';
    document.getElementById('modalQuantite').textContent = row.dataset.quantite || '0';
    document.getElementById('modalResumer').textContent = row.dataset.resumer || 'Aucun résumé disponible';

    const img = document.getElementById('modalImage');
    if (row.dataset.image) {
        img.src = row.dataset.image;
        img.style.display = '';
    } else {
        img.style.display = 'none';
    }

    const q = parseInt(row.dataset.quantite);
    let statusHtml = '';
    if (q === 0) {
        statusHtml = '<span class="admin-badge admin-badge-danger">Épuisé</span>';
    } else if (q <= 5) {
        statusHtml = '<span class="admin-badge admin-badge-warning">Stock bas</span>';
    } else {
        statusHtml = '<span class="admin-badge admin-badge-success">Disponible</span>';
    }
    document.getElementById('modalStatut').innerHTML = statusHtml;

    const pdfLink = document.getElementById('modalPdfLink');
    if (row.dataset.pdf) {
        pdfLink.innerHTML = `<a href="${row.dataset.pdf}" target="_blank" class="btn-admin btn-admin-sm btn-admin-danger"><i class="fas fa-file-pdf me-2"></i>Voir le PDF</a>`;
    } else {
        pdfLink.innerHTML = '';
    }

    const modal = new bootstrap.Modal(document.getElementById('bookDetailModal'));
    modal.show();
}

// Initialize on load
document.addEventListener('DOMContentLoaded', function() {
    toggleContentFields();
});
</script>
@endpush
