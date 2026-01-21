/**
 * Système de Recherche Avancée de Catalogues
 * Recherche en temps réel via AJAX avec filtres avancés
 */

class CatalogueSearch {
    constructor() {
        this.searchTimeout = null;
        this.currentPage = 1;
        this.filters = {
            q: '',
            type: 'all',
            categorie: 'all',
            prix_min: '',
            prix_max: '',
            disponible: false,
            sort_by: 'created_at',
            sort_order: 'desc',
            per_page: 12
        };

        this.init();
    }

    init() {
        this.cacheElements();
        this.loadCategories();
        this.loadPriceStats();
        this.bindEvents();
    }

    cacheElements() {
        this.searchInput = document.getElementById('searchInput');
        this.clearSearchBtn = document.getElementById('clearSearch');
        this.searchButton = document.getElementById('searchButton');
        this.toggleFiltersBtn = document.getElementById('toggleFilters');
        this.filtersPanel = document.getElementById('filtersPanel');
        this.filterType = document.getElementById('filterType');
        this.filterCategorie = document.getElementById('filterCategorie');
        this.filterPrixMin = document.getElementById('filterPrixMin');
        this.filterPrixMax = document.getElementById('filterPrixMax');
        this.filterDisponible = document.getElementById('filterDisponible');
        this.filterSortBy = document.getElementById('filterSortBy');
        this.filterSortOrder = document.getElementById('filterSortOrder');
        this.toggleSortOrderBtn = document.getElementById('toggleSortOrder');
        this.applyFiltersBtn = document.getElementById('applyFilters');
        this.resetFiltersBtn = document.getElementById('resetFilters');
        this.resetSearchBtn = document.getElementById('resetSearchBtn');
        this.searchLoader = document.getElementById('searchLoader');
        this.searchResults = document.getElementById('searchResults');
        this.noResults = document.getElementById('noResults');
        this.searchStats = document.getElementById('searchStats');
        this.statsText = document.getElementById('statsText');
        this.searchPagination = document.getElementById('searchPagination');
        this.filterCount = document.querySelector('.filter-count');
    }

    bindEvents() {
        // Recherche en temps réel
        this.searchInput.addEventListener('input', () => {
            this.filters.q = this.searchInput.value.trim();
            this.showClearButton();
            this.debouncedSearch();
        });

        // Bouton rechercher
        this.searchButton.addEventListener('click', () => {
            this.performSearch();
        });

        // Enter pour rechercher
        this.searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                this.performSearch();
            }
        });

        // Effacer la recherche
        this.clearSearchBtn.addEventListener('click', () => {
            this.searchInput.value = '';
            this.filters.q = '';
            this.clearSearchBtn.style.display = 'none';
            this.performSearch();
        });

        // Toggle filtres
        this.toggleFiltersBtn.addEventListener('click', () => {
            this.toggleFilters();
        });

        // Changement de type - recharge les catégories
        this.filterType.addEventListener('change', () => {
            this.filters.type = this.filterType.value;
            this.loadCategories();
            this.updateFilterCount();
        });

        // Autres filtres
        this.filterCategorie.addEventListener('change', () => {
            this.filters.categorie = this.filterCategorie.value;
            this.updateFilterCount();
        });

        this.filterPrixMin.addEventListener('input', () => {
            this.filters.prix_min = this.filterPrixMin.value;
            this.updateFilterCount();
        });

        this.filterPrixMax.addEventListener('input', () => {
            this.filters.prix_max = this.filterPrixMax.value;
            this.updateFilterCount();
        });

        this.filterDisponible.addEventListener('change', () => {
            this.filters.disponible = this.filterDisponible.checked;
            this.updateFilterCount();
        });

        this.filterSortBy.addEventListener('change', () => {
            this.filters.sort_by = this.filterSortBy.value;
        });

        // Toggle ordre de tri
        this.toggleSortOrderBtn.addEventListener('click', () => {
            this.toggleSortOrder();
        });

        // Appliquer filtres
        this.applyFiltersBtn.addEventListener('click', () => {
            this.performSearch();
        });

        // Réinitialiser filtres
        this.resetFiltersBtn.addEventListener('click', () => {
            this.resetFilters();
        });

        // Réinitialiser recherche
        this.resetSearchBtn.addEventListener('click', () => {
            this.resetAll();
        });
    }

    showClearButton() {
        if (this.searchInput.value.trim()) {
            this.clearSearchBtn.style.display = 'block';
        } else {
            this.clearSearchBtn.style.display = 'none';
        }
    }

    debouncedSearch() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(() => {
            this.performSearch();
        }, 500); // Attendre 500ms après la dernière frappe
    }

    toggleFilters() {
        if (this.filtersPanel.style.display === 'none') {
            this.filtersPanel.style.display = 'block';
            this.toggleFiltersBtn.classList.add('active');
        } else {
            this.filtersPanel.style.display = 'none';
            this.toggleFiltersBtn.classList.remove('active');
        }
    }

    toggleSortOrder() {
        const currentOrder = this.filterSortOrder.value;
        const newOrder = currentOrder === 'desc' ? 'asc' : 'desc';
        this.filterSortOrder.value = newOrder;
        this.filters.sort_order = newOrder;

        // Changer l'icône
        const icon = this.toggleSortOrderBtn.querySelector('i');
        if (newOrder === 'asc') {
            icon.className = 'fas fa-sort-amount-up';
        } else {
            icon.className = 'fas fa-sort-amount-down';
        }

        this.performSearch();
    }

    updateFilterCount() {
        let count = 0;

        if (this.filters.type !== 'all') count++;
        if (this.filters.categorie !== 'all') count++;
        if (this.filters.prix_min) count++;
        if (this.filters.prix_max) count++;
        if (this.filters.disponible) count++;

        if (count > 0) {
            this.filterCount.textContent = count;
            this.filterCount.style.display = 'inline-block';
        } else {
            this.filterCount.style.display = 'none';
        }
    }

    resetFilters() {
        this.filterType.value = 'all';
        this.filterCategorie.value = 'all';
        this.filterPrixMin.value = '';
        this.filterPrixMax.value = '';
        this.filterDisponible.checked = false;
        this.filterSortBy.value = 'created_at';
        this.filterSortOrder.value = 'desc';

        this.filters = {
            ...this.filters,
            type: 'all',
            categorie: 'all',
            prix_min: '',
            prix_max: '',
            disponible: false,
            sort_by: 'created_at',
            sort_order: 'desc'
        };

        this.updateFilterCount();
        this.performSearch();
    }

    resetAll() {
        this.searchInput.value = '';
        this.filters.q = '';
        this.clearSearchBtn.style.display = 'none';
        this.resetFilters();
    }

    async loadCategories() {
        try {
            const response = await fetch(`/api/catalogue/categories?type=${this.filters.type}`);
            const data = await response.json();

            if (data.success) {
                this.filterCategorie.innerHTML = '<option value="all">Toutes les catégories</option>';
                data.categories.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat;
                    option.textContent = cat;
                    this.filterCategorie.appendChild(option);
                });
            }
        } catch (error) {
            console.error('Erreur lors du chargement des catégories:', error);
        }
    }

    async loadPriceStats() {
        try {
            const response = await fetch(`/api/catalogue/price-stats?type=${this.filters.type}`);
            const data = await response.json();

            if (data.success && data.stats) {
                this.filterPrixMin.placeholder = `Min: ${data.stats.min} FCFA`;
                this.filterPrixMax.placeholder = `Max: ${data.stats.max} FCFA`;
            }
        } catch (error) {
            console.error('Erreur lors du chargement des stats de prix:', error);
        }
    }

    async performSearch(page = 1) {
        this.currentPage = page;
        this.showLoader();

        const params = new URLSearchParams({
            ...this.filters,
            page: page,
            disponible: this.filters.disponible ? '1' : '0'
        });

        try {
            const response = await fetch(`/api/catalogue/search?${params}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.displayResults(data.data, data.pagination);
            } else {
                this.showError('Une erreur est survenue lors de la recherche');
            }
        } catch (error) {
            console.error('Erreur de recherche:', error);
            this.showError('Erreur de connexion au serveur');
        } finally {
            this.hideLoader();
        }
    }

    displayResults(catalogues, pagination) {
        // Afficher la zone de résultats
        this.searchResults.style.display = 'block';

        if (catalogues.length === 0) {
            this.searchResults.innerHTML = '';
            this.noResults.style.display = 'block';
            this.searchStats.style.display = 'none';
            this.searchPagination.style.display = 'none';
            return;
        }

        this.noResults.style.display = 'none';
        this.searchResults.innerHTML = this.renderCatalogues(catalogues);
        this.displayStats(pagination);
        this.displayPagination(pagination);
    }

    renderCatalogues(catalogues) {
        return `
            <div class="row g-4">
                ${catalogues.map(catalogue => this.renderCatalogueCard(catalogue)).join('')}
            </div>
        `;
    }

    renderCatalogueCard(catalogue) {
        const imageUrl = catalogue.image ? `/` + catalogue.image : '/img/default-book.jpg';
        const disponible = catalogue.quantite > 0;
        const badgeType = catalogue.type_categorie === 'catalogue' ? 'info' : 'success';
        const typeLabel = catalogue.type_categorie === 'catalogue' ? 'À découvrir' : 'À emprunter';

        return `
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm hover-card">
                    <div class="position-relative">
                        <img src="${imageUrl}" class="card-img-top" alt="${catalogue.titre || 'Livre'}" style="height: 300px; object-fit: cover;">
                        <span class="badge bg-${badgeType} position-absolute top-0 end-0 m-2">${typeLabel}</span>
                        ${!disponible ? '<span class="badge bg-danger position-absolute top-0 start-0 m-2">Épuisé</span>' : ''}
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold text-truncate" title="${catalogue.titre || 'Sans titre'}">${catalogue.titre || 'Sans titre'}</h5>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-user me-1"></i>${catalogue.auteur || 'Auteur inconnu'}
                        </p>
                        <p class="text-muted small mb-2">
                            <i class="fas fa-tag me-1"></i>${catalogue.categorie || 'Non classé'}
                        </p>
                        ${catalogue.resumer ? `<p class="card-text small text-muted" style="max-height: 3em; overflow: hidden;">${catalogue.resumer.substring(0, 100)}...</p>` : ''}
                        <div class="mt-auto">
                            <div class="mt-3">
                                <span class="h5 mb-0 text-primary d-block">
                                    <i class="fas fa-tag me-2"></i>${catalogue.prix ? catalogue.prix.toLocaleString() + ' FCFA' : 'Gratuit'}
                                </span>
                            </div>
                            <a href="/catalogue/${catalogue.id}" class="btn btn-primary w-100 mt-2">
                                <i class="fas fa-eye me-2"></i>Voir détails
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    displayStats(pagination) {
        this.statsText.textContent = `${pagination.total} résultat(s) trouvé(s) - Affichage de ${pagination.from || 0} à ${pagination.to || 0}`;
        this.searchStats.style.display = 'block';
    }

    displayPagination(pagination) {
        if (pagination.last_page <= 1) {
            this.searchPagination.style.display = 'none';
            return;
        }

        let paginationHTML = '<nav><ul class="pagination">';

        // Bouton Précédent
        if (pagination.current_page > 1) {
            paginationHTML += `<li class="page-item"><button class="page-link" onclick="catalogueSearch.performSearch(${pagination.current_page - 1})">Précédent</button></li>`;
        }

        // Pages
        for (let i = 1; i <= pagination.last_page; i++) {
            if (i === 1 || i === pagination.last_page || (i >= pagination.current_page - 2 && i <= pagination.current_page + 2)) {
                paginationHTML += `<li class="page-item ${i === pagination.current_page ? 'active' : ''}"><button class="page-link" onclick="catalogueSearch.performSearch(${i})">${i}</button></li>`;
            } else if (i === pagination.current_page - 3 || i === pagination.current_page + 3) {
                paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }

        // Bouton Suivant
        if (pagination.current_page < pagination.last_page) {
            paginationHTML += `<li class="page-item"><button class="page-link" onclick="catalogueSearch.performSearch(${pagination.current_page + 1})">Suivant</button></li>`;
        }

        paginationHTML += '</ul></nav>';
        this.searchPagination.innerHTML = paginationHTML;
        this.searchPagination.style.display = 'flex';

        // Scroll to top des résultats
        this.searchResults.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    showLoader() {
        this.searchLoader.style.display = 'block';
        this.searchResults.style.opacity = '0.5';
    }

    hideLoader() {
        this.searchLoader.style.display = 'none';
        this.searchResults.style.opacity = '1';
    }

    showError(message) {
        this.searchResults.innerHTML = `
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>${message}
            </div>
        `;
    }
}

// Initialiser la recherche au chargement de la page
let catalogueSearch;
document.addEventListener('DOMContentLoaded', () => {
    catalogueSearch = new CatalogueSearch();
});
