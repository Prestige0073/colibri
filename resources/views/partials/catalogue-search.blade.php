<!-- Système de Recherche Avancée de Catalogues -->
<div class="catalogue-search-container mb-5">
    <!-- Barre de recherche principale -->
    <div class="search-bar-wrapper">
        <div class="search-bar shadow-lg">
            <div class="search-input-group">
                <i class="fas fa-search search-icon"></i>
                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Rechercher par titre, auteur, catégorie..."
                    autocomplete="off">
                <button type="button" id="clearSearch" class="clear-search-btn" style="display: none;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <button type="button" id="toggleFilters" class="filter-toggle-btn">
                <i class="fas fa-sliders-h me-2"></i>
                <span>Filtres</span>
                <span class="filter-count badge bg-primary ms-2" style="display: none;">0</span>
            </button>
            <button type="button" id="searchButton" class="search-btn">
                <i class="fas fa-search me-2"></i>Rechercher
            </button>
        </div>

        <!-- Panel de filtres avancés -->
        <div id="filtersPanel" class="filters-panel shadow-lg" style="display: none;">
            <div class="filters-header">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtres avancés</h5>
                <button type="button" id="resetFilters" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-redo me-1"></i>Réinitialiser
                </button>
            </div>

            <div class="filters-body">
                <div class="row g-3">
                    <!-- Type de catalogue -->
                    <div class="col-md-6">
                        <label class="filter-label">
                            <i class="fas fa-layer-group me-2 text-primary"></i>Type de catalogue
                        </label>
                        <select id="filterType" class="form-select">
                            <option value="all">Tous les types</option>
                            <option value="catalogue">À découvrir</option>
                            <option value="emprunt">À emprunter</option>
                        </select>
                    </div>

                    <!-- Catégorie -->
                    <div class="col-md-6">
                        <label class="filter-label">
                            <i class="fas fa-tags me-2 text-success"></i>Catégorie
                        </label>
                        <select id="filterCategorie" class="form-select">
                            <option value="all">Toutes les catégories</option>
                        </select>
                    </div>

                    <!-- Prix minimum -->
                    <div class="col-md-6">
                        <label class="filter-label">
                            <i class="fas fa-money-bill-wave me-2 text-warning"></i>Prix minimum (FCFA)
                        </label>
                        <input type="number" id="filterPrixMin" class="form-control" placeholder="0" min="0">
                    </div>

                    <!-- Prix maximum -->
                    <div class="col-md-6">
                        <label class="filter-label">
                            <i class="fas fa-money-bill-wave me-2 text-warning"></i>Prix maximum (FCFA)
                        </label>
                        <input type="number" id="filterPrixMax" class="form-control" placeholder="Illimité" min="0">
                    </div>

                    <!-- Disponibilité -->
                    <div class="col-md-6">
                        <div class="form-check form-switch mt-4">
                            <input class="form-check-input" type="checkbox" id="filterDisponible">
                            <label class="form-check-label" for="filterDisponible">
                                <i class="fas fa-check-circle me-2 text-success"></i>Disponible uniquement
                            </label>
                        </div>
                    </div>

                    <!-- Tri -->
                    <div class="col-md-6">
                        <label class="filter-label">
                            <i class="fas fa-sort me-2 text-info"></i>Trier par
                        </label>
                        <div class="input-group">
                            <select id="filterSortBy" class="form-select">
                                <option value="created_at">Date d'ajout</option>
                                <option value="titre">Titre</option>
                                <option value="auteur">Auteur</option>
                                <option value="prix">Prix</option>
                            </select>
                            <button class="btn btn-outline-secondary" type="button" id="toggleSortOrder">
                                <i class="fas fa-sort-amount-down"></i>
                            </button>
                        </div>
                        <input type="hidden" id="filterSortOrder" value="desc">
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="filters-footer">
                    <button type="button" id="applyFilters" class="btn btn-primary w-100">
                        <i class="fas fa-check me-2"></i>Appliquer les filtres
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Indicateur de chargement -->
    <div id="searchLoader" class="search-loader" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
        <p class="mt-2">Recherche en cours...</p>
    </div>

    <!-- Résultats de recherche -->
    <div id="searchResults" class="search-results mt-4" style="display: none;">
        <!-- Les résultats seront injectés ici via AJAX -->
    </div>

    <!-- Message quand aucun résultat -->
    <div id="noResults" class="no-results text-center py-5" style="display: none;">
        <i class="fas fa-search fa-4x text-muted mb-3"></i>
        <h4>Aucun résultat trouvé</h4>
        <p class="text-muted">Essayez de modifier vos critères de recherche</p>
        <button type="button" id="resetSearchBtn" class="btn btn-primary">
            <i class="fas fa-redo me-2"></i>Réinitialiser la recherche
        </button>
    </div>

    <!-- Statistiques de recherche -->
    <div id="searchStats" class="search-stats mt-3" style="display: none;">
        <div class="alert alert-info d-flex align-items-center">
            <i class="fas fa-info-circle me-2"></i>
            <span id="statsText"></span>
        </div>
    </div>

    <!-- Pagination -->
    <div id="searchPagination" class="d-flex justify-content-center mt-4" style="display: none;">
        <!-- La pagination sera injectée ici -->
    </div>
</div>

<style>
.catalogue-search-container {
    position: relative;
}

.search-bar-wrapper {
    position: relative;
    margin-bottom: 2rem;
}

.search-bar {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.search-input-group {
    flex: 1;
    min-width: 300px;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-size: 1.1rem;
}

.search-input {
    width: 100%;
    padding: 0.75rem 3rem 0.75rem 3rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    outline: none;
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.clear-search-btn {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6c757d;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.25rem;
    transition: color 0.3s;
}

.clear-search-btn:hover {
    color: #dc3545;
}

.filter-toggle-btn {
    padding: 0.75rem 1.5rem;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-toggle-btn:hover {
    background: #e9ecef;
    border-color: #0d6efd;
}

.filter-toggle-btn.active {
    background: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.search-btn {
    padding: 0.75rem 2rem;
    background: linear-gradient(135deg, #198754 0%, #146c43 100%);
    color: white;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(25, 135, 84, 0.3);
}

.filters-panel {
    background: white;
    border-radius: 15px;
    margin-top: 1rem;
    overflow: hidden;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.filters-header {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #dee2e6;
}

.filters-body {
    padding: 2rem;
}

.filter-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #495057;
}

.filters-footer {
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 2px solid #e9ecef;
}

.search-loader {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.search-results {
    min-height: 0;
}

.search-results:not([style*="display: none"]) {
    min-height: 200px;
}

.no-results {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.filter-count {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

/* Responsive */
@media (max-width: 768px) {
    .search-bar {
        flex-direction: column;
    }

    .search-input-group {
        width: 100%;
        min-width: auto;
    }

    .filter-toggle-btn,
    .search-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
