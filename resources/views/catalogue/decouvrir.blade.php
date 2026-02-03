@extends('layouts.app')

@section('title', 'Découvrir les livres')
@section('meta_description',
    'Explorez le catalogue Colibri Littéraire et découvrez les livres africains à lire,
    partager et soutenir.')

@section('content')
    @include('partials.notifications')

    <style>
        :root {
            --primary-green: #1e7a2f;
            --primary-dark: #0b5e34;
            --accent-gold: #d4a853;
            --accent-orange: #e67e22;
            --text-dark: #2c3e50;
            --text-muted: #6c7a89;
            --bg-cream: #faf8f5;
            --bg-light: #f8f9fa;
            --shadow-soft: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-hover: 0 12px 35px rgba(30,122,47,0.15);
            --radius-lg: 16px;
            --radius-md: 12px;
            --radius-sm: 8px;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Hero Section */
        .catalogue-hero {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            padding: 3rem 0 2.5rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .catalogue-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 60%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
            pointer-events: none;
        }

        .catalogue-hero h1 {
            color: white;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .catalogue-hero p {
            color: rgba(255,255,255,0.85);
            font-size: 1.05rem;
            margin-bottom: 1.5rem;
        }

        /* Stats badges */
        .hero-stats {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .stat-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 0.6rem 1rem;
            border-radius: var(--radius-sm);
            color: white;
            font-size: 0.9rem;
        }

        .stat-badge i {
            color: var(--accent-gold);
        }

        .stat-badge strong {
            color: var(--accent-gold);
            font-size: 1.1rem;
        }

        /* Search Section Enhanced */
        .search-section {
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
            padding: 1.5rem;
            margin-top: -2rem;
            position: relative;
            z-index: 10;
            margin-bottom: 2rem;
        }

        /* Filter chips */
        .filter-chips {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #eee;
        }

        .filter-chip {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.9rem;
            background: var(--bg-light);
            border: 2px solid transparent;
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition);
        }

        .filter-chip:hover {
            background: rgba(30,122,47,0.08);
            color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .filter-chip.active {
            background: var(--primary-green);
            color: white;
            border-color: var(--primary-green);
        }

        .filter-chip i {
            font-size: 0.8rem;
        }

        .filter-chip:focus {
            outline: none;
        }

        /* Loading state */
        .products-grid.loading {
            opacity: 0.5;
            pointer-events: none;
        }

        /* Results header */
        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .results-count {
            font-size: 1rem;
            color: var(--text-muted);
        }

        .results-count strong {
            color: var(--primary-green);
            font-weight: 700;
        }

        .sort-dropdown {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .sort-dropdown select {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: var(--radius-sm);
            font-size: 0.9rem;
            color: var(--text-dark);
            background: white;
            cursor: pointer;
        }

        /* Product Grid */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* Product Card Modern */
        .product-card {
            background: white;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-soft);
            transition: var(--transition);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-hover);
        }

        /* Image container */
        .product-image {
            position: relative;
            height: 220px;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8ecef 100%);
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.08);
        }

        /* Status badges */
        .product-badges {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            right: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            z-index: 2;
        }

        .badge-stock {
            padding: 0.35rem 0.7rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .badge-stock.in-stock {
            background: linear-gradient(135deg, #27ae60, #1e8449);
            color: white;
            box-shadow: 0 2px 8px rgba(39,174,96,0.35);
        }

        .badge-stock.out-of-stock {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        .badge-category {
            padding: 0.35rem 0.7rem;
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(4px);
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        /* Quick view overlay */
        .product-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1rem;
            background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
            opacity: 0;
            transform: translateY(100%);
            transition: var(--transition);
        }

        .product-card:hover .product-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-quick-view {
            width: 100%;
            padding: 0.6rem;
            background: white;
            color: var(--primary-green);
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-quick-view:hover {
            background: var(--primary-green);
            color: white;
        }

        /* Product content */
        .product-content {
            padding: 1.25rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-author {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.9rem;
            color: var(--text-muted);
            margin-bottom: 0.75rem;
        }

        .product-author i {
            color: var(--accent-gold);
            font-size: 0.8rem;
        }

        .product-description {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            flex: 1;
        }

        /* Price section */
        .product-price-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid #f0f0f0;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 800;
            color: var(--primary-green);
        }

        .product-price small {
            font-size: 0.7rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        .product-stock-info {
            font-size: 0.8rem;
            color: var(--text-muted);
        }

        .product-stock-info.low-stock {
            color: var(--accent-orange);
            font-weight: 600;
        }

        /* Add to cart section */
        .product-actions {
            margin-top: auto;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .quantity-selector label {
            font-size: 0.85rem;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            border: 1px solid #e0e0e0;
            border-radius: var(--radius-sm);
            overflow: hidden;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-light);
            border: none;
            color: var(--text-dark);
            cursor: pointer;
            transition: var(--transition);
        }

        .qty-btn:hover {
            background: var(--primary-green);
            color: white;
        }

        .qty-input {
            width: 40px;
            height: 32px;
            border: none;
            text-align: center;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .qty-input:focus {
            outline: none;
        }

        /* Buy button */
        .btn-add-cart {
            width: 100%;
            padding: 0.85rem 1rem;
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: var(--radius-md);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .btn-add-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-add-cart:hover::before {
            left: 100%;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(30,122,47,0.35);
        }

        .btn-add-cart:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-add-cart:disabled::before {
            display: none;
        }

        .btn-add-cart.adding {
            pointer-events: none;
        }

        .btn-add-cart.added {
            background: linear-gradient(135deg, #27ae60 0%, #1e8449 100%);
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-soft);
        }

        .empty-state i {
            font-size: 4rem;
            color: #ddd;
            margin-bottom: 1.5rem;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            color: var(--text-dark);
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Pagination enhanced */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        /* Trust badges */
        .trust-section {
            margin-top: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, var(--bg-cream) 0%, white 100%);
            border-radius: var(--radius-lg);
        }

        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 3rem;
            flex-wrap: wrap;
        }

        .trust-badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .trust-badge i {
            font-size: 2rem;
            color: var(--primary-green);
            margin-bottom: 0.75rem;
        }

        .trust-badge span {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .catalogue-hero {
                padding: 2rem 0 1.5rem;
            }

            .catalogue-hero h1 {
                font-size: 1.6rem;
            }

            .hero-stats {
                gap: 0.75rem;
            }

            .stat-badge {
                padding: 0.5rem 0.75rem;
                font-size: 0.8rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1rem;
            }

            .filter-chips {
                justify-content: flex-start;
            }

            .trust-badges {
                gap: 1.5rem;
            }
        }

        /* Animation keyframes */
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .product-card {
            animation: slideIn 0.5s ease forwards;
        }

        .product-card:nth-child(1) { animation-delay: 0.05s; }
        .product-card:nth-child(2) { animation-delay: 0.1s; }
        .product-card:nth-child(3) { animation-delay: 0.15s; }
        .product-card:nth-child(4) { animation-delay: 0.2s; }
        .product-card:nth-child(5) { animation-delay: 0.25s; }
        .product-card:nth-child(6) { animation-delay: 0.3s; }
    </style>

    <!-- Hero Section -->
    <section class="catalogue-hero">
        <div class="container">
            <h1><i class="fa fa-book-open me-2"></i>Notre Catalogue</h1>
            <p>Explorez notre collection de livres africains soigneusement sélectionnés</p>
            <div class="hero-stats">
                <div class="stat-badge">
                    <i class="fa fa-books"></i>
                    <span><strong>{{ $catalogues->total() }}</strong> livres disponibles</span>
                </div>
                <div class="stat-badge">
                    <i class="fa fa-shipping-fast"></i>
                    <span>Livraison rapide</span>
                </div>
                <div class="stat-badge">
                    <i class="fa fa-shield-alt"></i>
                    <span>Paiement sécurisé</span>
                </div>
            </div>
        </div>
    </section>

    <div class="container">
        <!-- Search Section -->
        <div class="search-section">
            @include('partials.catalogue-search')

            <!-- Filter Chips - Catégories dynamiques depuis la base de données -->
            @php
                $categories = \App\Models\Catalogue::where('type_categorie', 'catalogue')
                    ->whereNotNull('categorie')
                    ->where('categorie', '!=', '')
                    ->distinct()
                    ->pluck('categorie')
                    ->sort();
                $currentCategory = request('categorie');
                $totalBooks = \App\Models\Catalogue::where('type_categorie', 'catalogue')->count();
            @endphp
            @if($categories->isNotEmpty())
            <div class="filter-chips">
                <button type="button" class="filter-chip {{ !$currentCategory ? 'active' : '' }}" data-category="">
                    <i class="fa fa-th"></i> Tous ({{ $totalBooks }})
                </button>
                @foreach($categories as $categorie)
                    @php
                        $count = \App\Models\Catalogue::where('type_categorie', 'catalogue')
                            ->where('categorie', $categorie)
                            ->count();
                    @endphp
                    <button type="button" class="filter-chip {{ $currentCategory === $categorie ? 'active' : '' }}" data-category="{{ $categorie }}">
                        <i class="fa fa-bookmark"></i> {{ $categorie }} ({{ $count }})
                    </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Results Header -->
        <div class="results-header">
            <div class="results-count">
                <strong>{{ $catalogues->total() }}</strong> livre(s) trouvé(s)
                @if(request('search'))
                    <span style="color: var(--text-muted); font-size: 0.9rem;">pour "<strong style="color: var(--accent-orange);">{{ request('search') }}</strong>"</span>
                @endif
                @if($currentCategory)
                    <span style="color: var(--text-muted); font-size: 0.9rem;">dans <strong style="color: var(--primary-green);">{{ $currentCategory }}</strong></span>
                @endif
                @if(request('prix_min') || request('prix_max'))
                    <span style="color: var(--text-muted); font-size: 0.9rem;">
                        | Prix:
                        @if(request('prix_min')) <strong>{{ number_format(request('prix_min'), 0, ',', ' ') }}+</strong> @endif
                        @if(request('prix_min') && request('prix_max')) - @endif
                        @if(request('prix_max')) <strong>{{ number_format(request('prix_max'), 0, ',', ' ') }}</strong> @endif
                        FCFA
                    </span>
                @endif
                @if(request('disponible') === 'true')
                    <span class="badge bg-success ms-2" style="font-size: 0.75rem;"><i class="fa fa-check me-1"></i>Disponibles</span>
                @endif
            </div>
            @if(request('search') || $currentCategory || request('prix_min') || request('prix_max') || request('disponible'))
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.href='{{ route('catalogue.index') }}'">
                    <i class="fa fa-times me-1"></i>Effacer les filtres
                </button>
            @endif
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            @forelse ($catalogues ?? [] as $catalogue)
                @if ($catalogue->type_categorie === 'catalogue')
                    <div class="product-card" data-category="{{ Str::slug($catalogue->categorie ?? '') }}">
                        <!-- Image Section -->
                        <div class="product-image">
                            <img src="{{ $catalogue->image ? asset($catalogue->image) : asset('img/default-book.jpg') }}"
                                 alt="{{ $catalogue->titre ?? 'Livre' }}"
                                 loading="lazy">

                            <!-- Badges -->
                            <div class="product-badges">
                                @if (($catalogue->quantite ?? 0) > 0)
                                    <span class="badge-stock in-stock">
                                        <i class="fa fa-check me-1"></i>En stock
                                    </span>
                                @else
                                    <span class="badge-stock out-of-stock">
                                        <i class="fa fa-times me-1"></i>Épuisé
                                    </span>
                                @endif

                                @if($catalogue->categorie)
                                    <span class="badge-category">{{ $catalogue->categorie }}</span>
                                @endif
                            </div>

                            <!-- Quick view overlay -->
                            <div class="product-overlay">
                                <button class="btn-quick-view" data-bs-toggle="modal" data-bs-target="#resumeModal{{ $catalogue->id }}">
                                    <i class="fa fa-eye me-1"></i>Aperçu rapide
                                </button>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="product-content">
                            <h3 class="product-title">{{ $catalogue->titre ?? 'Sans titre' }}</h3>

                            <div class="product-author">
                                <i class="fa fa-pen-fancy"></i>
                                <span>{{ $catalogue->auteur ?? 'Auteur inconnu' }}</span>
                            </div>

                            <p class="product-description">
                                {{ Str::limit(strip_tags($catalogue->resumer ?? 'Aucune description disponible'), 80) }}
                            </p>

                            <!-- Price Section -->
                            <div class="product-price-section">
                                <div class="product-price">
                                    {{ $catalogue->prix ? fcfa($catalogue->prix) : '0 FCFA' }}
                                </div>
                                @if (($catalogue->quantite ?? 0) > 0 && ($catalogue->quantite ?? 0) <= 5)
                                    <span class="product-stock-info low-stock">
                                        <i class="fa fa-exclamation-triangle me-1"></i>Plus que {{ $catalogue->quantite }}!
                                    </span>
                                @elseif (($catalogue->quantite ?? 0) > 5)
                                    <span class="product-stock-info">
                                        <i class="fa fa-box me-1"></i>{{ $catalogue->quantite }} en stock
                                    </span>
                                @endif
                            </div>

                            <!-- Add to Cart -->
                            <div class="product-actions">
                                <form method="POST" action="{{ route('panier.ajouter') }}" class="add-to-cart-form">
                                    @csrf
                                    <input type="hidden" name="catalogue_id" value="{{ $catalogue->id }}">

                                    <div class="quantity-selector">
                                        <label>Qté :</label>
                                        <div class="quantity-controls">
                                            <button type="button" class="qty-btn qty-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="number" name="quantite" class="qty-input" value="1"
                                                   min="1" max="{{ $catalogue->quantite ?? 0 }}">
                                            <button type="button" class="qty-btn qty-plus" data-max="{{ $catalogue->quantite ?? 0 }}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn-add-cart"
                                            @if (($catalogue->quantite ?? 0) == 0) disabled @endif>
                                        <i class="fa fa-shopping-cart"></i>
                                        <span class="btn-text">{{ ($catalogue->quantite ?? 0) == 0 ? 'Indisponible' : 'Ajouter au panier' }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal résumé -->
                    <div class="modal fade" id="resumeModal{{ $catalogue->id }}" tabindex="-1"
                         aria-labelledby="resumeModalLabel{{ $catalogue->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content" style="border-radius: var(--radius-lg); overflow: hidden;">
                                <div class="modal-header" style="background: var(--primary-green); border: none;">
                                    <h5 class="modal-title" id="resumeModalLabel{{ $catalogue->id }}" style="color: white !important;">
                                        <i class="fa fa-book-open me-2" style="color: white;"></i>{{ $catalogue->titre ?? 'Sans titre' }}
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body" style="padding: 2rem;">
                                    <div class="row">
                                        <div class="col-md-4 mb-3 mb-md-0">
                                            <img src="{{ $catalogue->image ? asset($catalogue->image) : asset('img/default-book.jpg') }}"
                                                 alt="{{ $catalogue->titre }}"
                                                 class="img-fluid rounded" style="box-shadow: var(--shadow-soft);">
                                        </div>
                                        <div class="col-md-8">
                                            <p class="mb-2"><strong><i class="fa fa-user text-white me-2" style="background: var(--primary-green); padding: 0.3rem; border-radius: 50%;"></i>Auteur :</strong> <span style="color: var(--text-dark);">{{ $catalogue->auteur ?? 'Inconnu' }}</span></p>
                                            <p class="mb-2"><strong><i class="fa fa-tag text-white me-2" style="background: var(--accent-gold); padding: 0.3rem; border-radius: 50%;"></i>Catégorie :</strong> <span style="color: var(--text-dark);">{{ $catalogue->categorie ?? 'Non catégorisé' }}</span></p>
                                            <p class="mb-3"><strong><i class="fa fa-money-bill text-white me-2" style="background: #27ae60; padding: 0.3rem; border-radius: 50%;"></i>Prix :</strong> <span style="color: var(--primary-green); font-weight: 700; font-size: 1.2rem;">{{ $catalogue->prix ? fcfa($catalogue->prix) : 'Gratuit' }}</span></p>
                                            <hr>
                                            <h6 class="mb-2"><i class="fa fa-align-left text-success me-2"></i>Résumé</h6>
                                            <p style="line-height: 1.7; color: var(--text-muted);">{{ trim(strip_tags($catalogue->resumer ?? 'Aucune description disponible')) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border: none; padding: 1rem 2rem;">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                    @if (($catalogue->quantite ?? 0) > 0)
                                        <form method="POST" action="{{ route('panier.ajouter') }}" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="catalogue_id" value="{{ $catalogue->id }}">
                                            <input type="hidden" name="quantite" value="1">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fa fa-shopping-cart me-1"></i>Ajouter au panier
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fa fa-book-open"></i>
                        <h3>Aucun livre disponible</h3>
                        <p>Notre catalogue est en cours de mise à jour. Revenez bientôt pour découvrir nos nouveautés!</p>
                        <a href="{{ route('index') }}" class="btn btn-success">
                            <i class="fa fa-home me-1"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($catalogues->hasPages())
            <div class="pagination-wrapper">
                {{ $catalogues->links() }}
            </div>
        @endif

        <!-- Trust Section -->
        <div class="trust-section">
            <div class="trust-badges">
                <div class="trust-badge">
                    <i class="fa fa-truck"></i>
                    <span>Livraison dans tout le Bénin</span>
                </div>
                <div class="trust-badge">
                    <i class="fa fa-lock"></i>
                    <span>Paiement 100% sécurisé</span>
                </div>
                <div class="trust-badge">
                    <i class="fa fa-headset"></i>
                    <span>Support client réactif</span>
                </div>
                <div class="trust-badge">
                    <i class="fa fa-medal"></i>
                    <span>Livres authentiques garantis</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ======= VARIABLES GLOBALES =======
            const baseUrl = '{{ route("catalogue.index") }}';
            let currentFilters = {
                search: '',
                categorie: '{{ request("categorie", "") }}',
                prix_min: '',
                prix_max: '',
                disponible: false,
                sort_by: 'created_at',
                sort_order: 'desc'
            };

            // ======= ELEMENTS DOM =======
            const searchInput = document.getElementById('searchInput');
            const searchButton = document.getElementById('searchButton');
            const clearSearch = document.getElementById('clearSearch');
            const toggleFilters = document.getElementById('toggleFilters');
            const filtersPanel = document.getElementById('filtersPanel');
            const resetFilters = document.getElementById('resetFilters');
            const applyFilters = document.getElementById('applyFilters');
            const filterCategorie = document.getElementById('filterCategorie');
            const filterPrixMin = document.getElementById('filterPrixMin');
            const filterPrixMax = document.getElementById('filterPrixMax');
            const filterDisponible = document.getElementById('filterDisponible');
            const filterSortBy = document.getElementById('filterSortBy');
            const filterSortOrder = document.getElementById('filterSortOrder');
            const toggleSortOrder = document.getElementById('toggleSortOrder');
            const filterCount = document.querySelector('.filter-count');
            const productsGrid = document.querySelector('.products-grid');
            const resultsCount = document.querySelector('.results-count');
            const paginationWrapper = document.querySelector('.pagination-wrapper');

            // ======= FONCTIONS UTILITAIRES =======

            // Debounce function pour la recherche instantanée
            let searchTimeout = null;
            function debounce(func, delay) {
                return function(...args) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => func.apply(this, args), delay);
                };
            }

            // Construire l'URL avec les filtres
            function buildFilterUrl() {
                let url = new URL(baseUrl, window.location.origin);

                if (currentFilters.search) url.searchParams.set('search', currentFilters.search);
                if (currentFilters.categorie) url.searchParams.set('categorie', currentFilters.categorie);
                if (currentFilters.prix_min) url.searchParams.set('prix_min', currentFilters.prix_min);
                if (currentFilters.prix_max) url.searchParams.set('prix_max', currentFilters.prix_max);
                if (currentFilters.disponible) url.searchParams.set('disponible', 'true');
                if (currentFilters.sort_by !== 'created_at') url.searchParams.set('sort_by', currentFilters.sort_by);
                if (currentFilters.sort_order !== 'desc') url.searchParams.set('sort_order', currentFilters.sort_order);

                return url.toString();
            }

            // Compter les filtres actifs
            function countActiveFilters() {
                let count = 0;
                if (currentFilters.prix_min) count++;
                if (currentFilters.prix_max) count++;
                if (currentFilters.disponible) count++;
                if (currentFilters.sort_by !== 'created_at') count++;
                return count;
            }

            // Mettre à jour le badge de compteur de filtres
            function updateFilterCount() {
                const count = countActiveFilters();
                if (filterCount) {
                    if (count > 0) {
                        filterCount.textContent = count;
                        filterCount.style.display = 'inline';
                    } else {
                        filterCount.style.display = 'none';
                    }
                }
            }

            // Afficher le loader (version légère pour recherche instantanée)
            function showLoader(lightVersion = false) {
                if (productsGrid) {
                    productsGrid.style.opacity = '0.5';
                    productsGrid.style.pointerEvents = 'none';

                    // Version légère : juste opacité réduite
                    // Version complète : afficher le spinner
                    if (!lightVersion) {
                        productsGrid.innerHTML = '<div class="col-12 text-center py-5"><i class="fa fa-spinner fa-spin fa-2x text-success"></i><p class="mt-3 text-muted">Recherche en cours...</p></div>';
                    }
                }
            }

            // Cacher le loader
            function hideLoader() {
                if (productsGrid) {
                    productsGrid.style.opacity = '1';
                    productsGrid.style.pointerEvents = 'auto';
                }
            }

            // Contrôleur pour annuler les requêtes en cours
            let currentFetchController = null;

            // Exécuter la recherche AJAX
            function performSearch(isInstant = false) {
                const url = buildFilterUrl();

                // Annuler la requête précédente si elle existe
                if (currentFetchController) {
                    currentFetchController.abort();
                }
                currentFetchController = new AbortController();

                // Loader léger pour recherche instantanée, complet sinon
                showLoader(isInstant);
                window.history.pushState({}, '', url);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    signal: currentFetchController.signal
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Mettre à jour la grille des produits
                    const newGrid = doc.querySelector('.products-grid');
                    if (newGrid && productsGrid) {
                        productsGrid.innerHTML = newGrid.innerHTML;
                        hideLoader();
                    }

                    // Mettre à jour le compteur de résultats
                    const newCount = doc.querySelector('.results-count');
                    if (newCount && resultsCount) {
                        resultsCount.innerHTML = newCount.innerHTML;
                    }

                    // Mettre à jour le header des résultats (pour le bouton effacer filtres)
                    const newResultsHeader = doc.querySelector('.results-header');
                    const currentResultsHeader = document.querySelector('.results-header');
                    if (newResultsHeader && currentResultsHeader) {
                        currentResultsHeader.innerHTML = newResultsHeader.innerHTML;
                    }

                    // Mettre à jour la pagination
                    const newPagination = doc.querySelector('.pagination-wrapper');
                    if (paginationWrapper && newPagination) {
                        paginationWrapper.innerHTML = newPagination.innerHTML;
                    } else if (paginationWrapper && !newPagination) {
                        paginationWrapper.innerHTML = '';
                    }

                    // Réinitialiser les écouteurs d'événements
                    initQuantityControls();
                    initAddToCartForms();
                    initQuickViewButtons();
                    initPaginationLinks();

                    // Retirer l'indicateur de recherche en cours
                    if (searchInput) {
                        searchInput.classList.remove('searching');
                    }

                    currentFetchController = null;
                })
                .catch(error => {
                    // Ignorer les erreurs d'annulation (AbortError)
                    if (error.name === 'AbortError') {
                        return;
                    }
                    console.error('Erreur:', error);
                    if (productsGrid) {
                        hideLoader();
                        productsGrid.innerHTML = '<div class="col-12 text-center py-5"><p class="text-danger"><i class="fa fa-exclamation-triangle me-2"></i>Erreur lors de la recherche. Veuillez réessayer.</p></div>';
                    }
                });
            }

            // ======= RECHERCHE TEXTUELLE INSTANTANEE =======

            // Recherche instantanée avec debounce (300ms de délai)
            const instantSearch = debounce(function() {
                currentFilters.search = searchInput ? searchInput.value.trim() : '';
                performSearch(true); // true = recherche instantanée (loader léger)
            }, 300);

            // Bouton de recherche (recherche immédiate)
            if (searchButton) {
                searchButton.addEventListener('click', function() {
                    clearTimeout(searchTimeout); // Annuler le debounce en cours
                    currentFilters.search = searchInput ? searchInput.value.trim() : '';
                    performSearch();
                });
            }

            // Recherche instantanée au fur et à mesure de la frappe
            if (searchInput) {
                // Recherche instantanée sur chaque caractère tapé
                searchInput.addEventListener('input', function() {
                    // Afficher/masquer le bouton effacer
                    if (clearSearch) {
                        clearSearch.style.display = this.value.length > 0 ? 'block' : 'none';
                    }

                    // Ajouter l'indicateur de recherche en cours
                    this.classList.add('searching');

                    // Déclencher la recherche instantanée avec debounce
                    instantSearch();
                });

                // Recherche immédiate sur Enter (sans attendre le debounce)
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout); // Annuler le debounce en cours
                        currentFilters.search = this.value.trim();
                        performSearch();
                    }
                });
            }

            // Effacer la recherche
            if (clearSearch) {
                clearSearch.addEventListener('click', function() {
                    if (searchInput) {
                        clearTimeout(searchTimeout); // Annuler le debounce en cours
                        searchInput.value = '';
                        this.style.display = 'none';
                        currentFilters.search = '';
                        performSearch();
                    }
                });
            }

            // ======= PANEL DE FILTRES =======

            // Toggle panel filtres
            if (toggleFilters) {
                toggleFilters.addEventListener('click', function() {
                    if (filtersPanel) {
                        const isVisible = filtersPanel.style.display !== 'none';
                        filtersPanel.style.display = isVisible ? 'none' : 'block';
                        this.classList.toggle('active', !isVisible);
                    }
                });
            }

            // Peupler les catégories dans le dropdown
            if (filterCategorie) {
                @php
                    $allCategories = \App\Models\Catalogue::where('type_categorie', 'catalogue')
                        ->whereNotNull('categorie')
                        ->where('categorie', '!=', '')
                        ->distinct()
                        ->pluck('categorie')
                        ->sort();
                @endphp
                @foreach($allCategories as $cat)
                    const opt{{ $loop->index }} = document.createElement('option');
                    opt{{ $loop->index }}.value = '{{ $cat }}';
                    opt{{ $loop->index }}.textContent = '{{ $cat }}';
                    filterCategorie.appendChild(opt{{ $loop->index }});
                @endforeach
            }

            // Réinitialiser les filtres
            if (resetFilters) {
                resetFilters.addEventListener('click', function() {
                    if (filterCategorie) filterCategorie.value = 'all';
                    if (filterPrixMin) filterPrixMin.value = '';
                    if (filterPrixMax) filterPrixMax.value = '';
                    if (filterDisponible) filterDisponible.checked = false;
                    if (filterSortBy) filterSortBy.value = 'created_at';
                    if (filterSortOrder) filterSortOrder.value = 'desc';
                    if (toggleSortOrder) {
                        toggleSortOrder.querySelector('i').className = 'fas fa-sort-amount-down';
                    }

                    currentFilters = {
                        search: searchInput ? searchInput.value.trim() : '',
                        categorie: '',
                        prix_min: '',
                        prix_max: '',
                        disponible: false,
                        sort_by: 'created_at',
                        sort_order: 'desc'
                    };

                    updateFilterCount();

                    // Réinitialiser les chips de catégorie
                    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                    const allChip = document.querySelector('.filter-chip[data-category=""]');
                    if (allChip) allChip.classList.add('active');
                });
            }

            // Appliquer les filtres
            if (applyFilters) {
                applyFilters.addEventListener('click', function() {
                    // Récupérer les valeurs des filtres
                    if (filterCategorie && filterCategorie.value !== 'all') {
                        currentFilters.categorie = filterCategorie.value;
                    } else {
                        currentFilters.categorie = '';
                    }

                    currentFilters.prix_min = filterPrixMin ? filterPrixMin.value : '';
                    currentFilters.prix_max = filterPrixMax ? filterPrixMax.value : '';
                    currentFilters.disponible = filterDisponible ? filterDisponible.checked : false;
                    currentFilters.sort_by = filterSortBy ? filterSortBy.value : 'created_at';
                    currentFilters.sort_order = filterSortOrder ? filterSortOrder.value : 'desc';

                    // Synchroniser les chips de catégorie
                    document.querySelectorAll('.filter-chip').forEach(c => {
                        c.classList.remove('active');
                        if (c.dataset.category === currentFilters.categorie) {
                            c.classList.add('active');
                        }
                    });

                    updateFilterCount();
                    performSearch();

                    // Fermer le panel
                    if (filtersPanel) filtersPanel.style.display = 'none';
                    if (toggleFilters) toggleFilters.classList.remove('active');
                });
            }

            // Toggle ordre de tri
            if (toggleSortOrder) {
                toggleSortOrder.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (filterSortOrder) {
                        if (filterSortOrder.value === 'desc') {
                            filterSortOrder.value = 'asc';
                            icon.className = 'fas fa-sort-amount-up';
                        } else {
                            filterSortOrder.value = 'desc';
                            icon.className = 'fas fa-sort-amount-down';
                        }
                    }
                });
            }

            // ======= FILTER CHIPS (CATEGORIES) =======

            document.querySelectorAll('.filter-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    const category = this.dataset.category;

                    // Mettre à jour l'état actif
                    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    // Mettre à jour les filtres
                    currentFilters.categorie = category;

                    // Synchroniser avec le dropdown si ouvert
                    if (filterCategorie) {
                        filterCategorie.value = category || 'all';
                    }

                    performSearch();
                });
            });

            // ======= CONTROLES DE QUANTITE =======

            function initQuantityControls() {
                document.querySelectorAll('.qty-minus').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.qty-input');
                        const min = parseInt(input.min) || 1;
                        let val = parseInt(input.value) || 1;
                        if (val > min) input.value = val - 1;
                    });
                });

                document.querySelectorAll('.qty-plus').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const input = this.parentElement.querySelector('.qty-input');
                        const max = parseInt(this.dataset.max) || 99;
                        let val = parseInt(input.value) || 1;
                        if (val < max) input.value = val + 1;
                    });
                });
            }

            // ======= ANIMATION AJOUT AU PANIER =======

            function initAddToCartForms() {
                document.querySelectorAll('.add-to-cart-form').forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const btn = this.querySelector('.btn-add-cart');
                        const btnText = btn.querySelector('.btn-text');

                        btn.classList.add('adding');
                        btnText.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Ajout...';
                    });
                });
            }

            // ======= BOUTONS APERCU RAPIDE =======

            function initQuickViewButtons() {
                document.querySelectorAll('.btn-quick-view').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const modalId = this.getAttribute('data-bs-target');
                        const modal = document.querySelector(modalId);
                        if (modal) {
                            const bsModal = new bootstrap.Modal(modal);
                            bsModal.show();
                        }
                    });
                });
            }

            // ======= PAGINATION AJAX =======

            function initPaginationLinks() {
                const paginationLinks = document.querySelectorAll('.pagination-wrapper a');
                paginationLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');

                        showLoader();
                        window.history.pushState({}, '', url);

                        fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            const newGrid = doc.querySelector('.products-grid');
                            if (newGrid && productsGrid) {
                                productsGrid.innerHTML = newGrid.innerHTML;
                                productsGrid.style.opacity = '1';
                            }

                            const newCount = doc.querySelector('.results-count');
                            if (newCount && resultsCount) {
                                resultsCount.innerHTML = newCount.innerHTML;
                            }

                            const newPagination = doc.querySelector('.pagination-wrapper');
                            if (paginationWrapper && newPagination) {
                                paginationWrapper.innerHTML = newPagination.innerHTML;
                            }

                            initQuantityControls();
                            initAddToCartForms();
                            initQuickViewButtons();
                            initPaginationLinks();

                            // Scroll vers le haut de la grille
                            productsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        })
                        .catch(error => {
                            console.error('Erreur:', error);
                            productsGrid.style.opacity = '1';
                        });
                    });
                });
            }

            // ======= GESTION HISTORIQUE NAVIGATEUR =======

            window.addEventListener('popstate', function() {
                location.reload();
            });

            // ======= INITIALISATION =======

            initQuantityControls();
            initAddToCartForms();
            initQuickViewButtons();
            initPaginationLinks();
            updateFilterCount();

            // Initialiser l'état du champ de recherche depuis l'URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search') && searchInput) {
                searchInput.value = urlParams.get('search');
                currentFilters.search = urlParams.get('search');
                if (clearSearch) clearSearch.style.display = 'block';
            }
        });
    </script>
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/catalogue-search.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/catalogue-search.js') }}"></script>
@endpush
