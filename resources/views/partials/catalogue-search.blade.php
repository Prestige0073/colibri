<!-- Système de Recherche Avancée de Catalogues -->
<div class="catalogue-search-container">
    <!-- Barre de recherche principale -->
    <div class="search-bar-wrapper">
        <div class="search-bar">
            <div class="search-input-group">
                <i class="fa fa-search search-icon"></i>
                <input
                    type="text"
                    id="searchInput"
                    class="search-input"
                    placeholder="Rechercher par titre, auteur, catégorie..."
                    autocomplete="off">
                <button type="button" id="clearSearch" class="clear-search-btn" style="display: none;">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <button type="button" id="toggleFilters" class="filter-toggle-btn">
                <i class="fa fa-sliders-h"></i>
                <span>Filtres</span>
                <span class="filter-count" style="display: none;">0</span>
            </button>
            <button type="button" id="searchButton" class="search-btn">
                <i class="fa fa-search"></i>
                <span>Rechercher</span>
            </button>
        </div>

        <!-- Panel de filtres avancés -->
        <div id="filtersPanel" class="filters-panel" style="display: none;">
            <div class="filters-header">
                <h5><i class="fa fa-filter"></i>Filtres avancés</h5>
                <button type="button" id="resetFilters" class="reset-filters-btn">
                    <i class="fa fa-redo"></i>Réinitialiser
                </button>
            </div>

            <div class="filters-body">
                <div class="filters-grid">
                    <!-- Catégorie -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa fa-tags"></i>Catégorie
                        </label>
                        <select id="filterCategorie" class="filter-select">
                            <option value="all">Toutes les catégories</option>
                        </select>
                    </div>

                    <!-- Prix minimum -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa fa-money-bill-wave"></i>Prix minimum
                        </label>
                        <div class="price-input-wrapper">
                            <input type="number" id="filterPrixMin" class="filter-input" placeholder="0" min="0">
                            <span class="price-suffix">FCFA</span>
                        </div>
                    </div>

                    <!-- Prix maximum -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa fa-money-bill-wave"></i>Prix maximum
                        </label>
                        <div class="price-input-wrapper">
                            <input type="number" id="filterPrixMax" class="filter-input" placeholder="Illimité" min="0">
                            <span class="price-suffix">FCFA</span>
                        </div>
                    </div>

                    <!-- Tri -->
                    <div class="filter-group">
                        <label class="filter-label">
                            <i class="fa fa-sort"></i>Trier par
                        </label>
                        <div class="sort-group">
                            <select id="filterSortBy" class="filter-select">
                                <option value="created_at">Date d'ajout</option>
                                <option value="titre">Titre</option>
                                <option value="auteur">Auteur</option>
                                <option value="prix">Prix</option>
                            </select>
                            <button class="sort-order-btn" type="button" id="toggleSortOrder" title="Ordre de tri">
                                <i class="fa fa-sort-amount-down"></i>
                            </button>
                        </div>
                        <input type="hidden" id="filterSortOrder" value="desc">
                    </div>

                    <!-- Disponibilité -->
                    <div class="filter-group filter-group-switch">
                        <label class="switch-label">
                            <span class="switch-wrapper">
                                <input type="checkbox" id="filterDisponible">
                                <span class="switch-slider"></span>
                            </span>
                            <span class="switch-text">
                                <i class="fa fa-check-circle"></i>Disponible uniquement
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Bouton d'action -->
                <div class="filters-footer">
                    <button type="button" id="applyFilters" class="apply-filters-btn">
                        <i class="fa fa-check"></i>Appliquer les filtres
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ============================================
   CATALOGUE SEARCH - Styles harmonisés
   ============================================ */

.catalogue-search-container {
    position: relative;
}

.search-bar-wrapper {
    position: relative;
}

/* Barre de recherche principale */
.search-bar {
    display: flex;
    gap: 0.75rem;
    align-items: center;
    flex-wrap: wrap;
}

.search-input-group {
    flex: 1;
    min-width: 250px;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    font-size: 0.95rem;
}

.search-input {
    width: 100%;
    padding: 0.85rem 2.5rem 0.85rem 2.75rem;
    border: 2px solid #e8e8e8;
    border-radius: var(--radius-md);
    font-size: 0.95rem;
    background: white;
    color: var(--text-dark);
    transition: var(--transition);
}

.search-input::placeholder {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(30,122,47,0.1);
}

.search-input.searching {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'%3E%3Cstyle%3E.spinner%7Banimation:rotate 1s linear infinite;transform-origin:center%7D@keyframes rotate%7Bfrom%7Btransform:rotate(0)%7Dto%7Btransform:rotate(360deg)%7D%7D%3C/style%3E%3Ccircle class='spinner' cx='12' cy='12' r='8' fill='none' stroke='%231e7a2f' stroke-width='2' stroke-dasharray='40 20'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 2.5rem center;
    background-size: 20px;
}

.clear-search-btn {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    font-size: 1rem;
    cursor: pointer;
    padding: 0.25rem;
    transition: var(--transition);
    border-radius: 50%;
    width: 28px;
    height: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.clear-search-btn:hover {
    color: #dc3545;
    background: rgba(220,53,69,0.1);
}

/* Bouton Filtres */
.filter-toggle-btn {
    padding: 0.85rem 1.25rem;
    background: var(--bg-light);
    border: 2px solid #e8e8e8;
    border-radius: var(--radius-md);
    font-weight: 500;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-dark);
}

.filter-toggle-btn i {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.filter-toggle-btn:hover {
    background: rgba(30,122,47,0.05);
    border-color: var(--primary-green);
}

.filter-toggle-btn:hover i {
    color: var(--primary-green);
}

.filter-toggle-btn.active {
    background: var(--primary-green);
    color: white;
    border-color: var(--primary-green);
}

.filter-toggle-btn.active i {
    color: white;
}

.filter-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 20px;
    height: 20px;
    padding: 0 6px;
    background: var(--accent-orange);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    border-radius: 10px;
}

.filter-toggle-btn.active .filter-count {
    background: white;
    color: var(--primary-green);
}

/* Bouton Rechercher */
.search-btn {
    padding: 0.85rem 1.5rem;
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.search-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30,122,47,0.3);
}

.search-btn:active {
    transform: translateY(0);
}

/* Panel de filtres */
.filters-panel {
    background: white;
    border-radius: var(--radius-md);
    margin-top: 1rem;
    overflow: hidden;
    box-shadow: var(--shadow-soft);
    animation: slideDown 0.3s ease;
    border: 1px solid #e8e8e8;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.filters-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, var(--bg-light) 0%, #f0f0f0 100%);
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #e8e8e8;
}

.filters-header h5 {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text-dark);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filters-header h5 i {
    color: var(--primary-green);
}

.reset-filters-btn {
    padding: 0.4rem 0.75rem;
    background: white;
    border: 1px solid #ddd;
    border-radius: var(--radius-sm);
    font-size: 0.8rem;
    color: var(--text-muted);
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.reset-filters-btn:hover {
    background: #f8f8f8;
    color: var(--text-dark);
    border-color: #ccc;
}

.filters-body {
    padding: 1.25rem;
}

.filters-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    font-weight: 500;
    color: var(--text-dark);
}

.filter-label i {
    color: var(--primary-green);
    font-size: 0.8rem;
}

.filter-select,
.filter-input {
    padding: 0.65rem 0.85rem;
    border: 2px solid #e8e8e8;
    border-radius: var(--radius-sm);
    font-size: 0.9rem;
    color: var(--text-dark);
    background: white;
    transition: var(--transition);
    width: 100%;
}

.filter-select:focus,
.filter-input:focus {
    outline: none;
    border-color: var(--primary-green);
    box-shadow: 0 0 0 3px rgba(30,122,47,0.1);
}

.price-input-wrapper {
    position: relative;
}

.price-input-wrapper .filter-input {
    padding-right: 3.5rem;
}

.price-suffix {
    position: absolute;
    right: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 500;
}

/* Groupe tri */
.sort-group {
    display: flex;
    gap: 0.5rem;
}

.sort-group .filter-select {
    flex: 1;
}

.sort-order-btn {
    padding: 0.65rem 0.85rem;
    border: 2px solid #e8e8e8;
    border-radius: var(--radius-sm);
    background: white;
    color: var(--text-muted);
    cursor: pointer;
    transition: var(--transition);
}

.sort-order-btn:hover {
    border-color: var(--primary-green);
    color: var(--primary-green);
    background: rgba(30,122,47,0.05);
}

/* Switch personnalisé */
.filter-group-switch {
    justify-content: center;
    padding-top: 0.5rem;
}

.switch-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    cursor: pointer;
}

.switch-wrapper {
    position: relative;
    width: 44px;
    height: 24px;
}

.switch-wrapper input {
    opacity: 0;
    width: 0;
    height: 0;
}

.switch-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.3s;
    border-radius: 24px;
}

.switch-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.3s;
    border-radius: 50%;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.switch-wrapper input:checked + .switch-slider {
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
}

.switch-wrapper input:checked + .switch-slider:before {
    transform: translateX(20px);
}

.switch-text {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    font-size: 0.85rem;
    color: var(--text-dark);
}

.switch-text i {
    color: var(--primary-green);
    font-size: 0.85rem;
}

/* Footer filtres */
.filters-footer {
    margin-top: 1.25rem;
    padding-top: 1.25rem;
    border-top: 1px solid #e8e8e8;
}

.apply-filters-btn {
    width: 100%;
    padding: 0.85rem 1.5rem;
    background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
    color: white;
    border: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.apply-filters-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30,122,47,0.3);
}

.apply-filters-btn:active {
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .search-bar {
        flex-direction: column;
        gap: 0.5rem;
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

    .filters-grid {
        grid-template-columns: 1fr;
    }

    .filter-group-switch {
        padding-top: 0;
    }
}

@media (max-width: 576px) {
    .search-input {
        padding: 0.75rem 2.25rem 0.75rem 2.5rem;
        font-size: 0.9rem;
    }

    .filter-toggle-btn,
    .search-btn {
        padding: 0.75rem 1rem;
        font-size: 0.85rem;
    }

    .filters-body {
        padding: 1rem;
    }

    .filters-header {
        padding: 0.85rem 1rem;
    }
}
</style>
