@extends('layouts.app')

@section('title', 'Emprunter un livre')
@section('meta_description', "Empruntez des livres africains via le catalogue Colibri Littéraire. Bibliothèque numérique accessible à tous.")

@section('content')
    @include('partials.notifications')

    <style>
        :root {
            --primary-green: #1e7a2f;
            --primary-dark: #0b5e34;
            --accent-gold: #d4a853;
            --accent-orange: #e67e22;
            --accent-blue: #3498db;
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
            background: linear-gradient(135deg, var(--accent-blue) 0%, #2980b9 100%);
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
            background: rgba(52,152,219,0.08);
            color: var(--accent-blue);
            border-color: var(--accent-blue);
        }

        .filter-chip.active {
            background: var(--accent-blue);
            color: white;
            border-color: var(--accent-blue);
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
            color: var(--accent-blue);
            font-weight: 700;
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

        .badge-new {
            position: absolute;
            top: 0.75rem;
            right: 0.75rem;
            padding: 0.35rem 0.7rem;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 2px 10px rgba(245, 87, 108, 0.4);
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
            color: var(--accent-blue);
            border: none;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-quick-view:hover {
            background: var(--accent-blue);
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

        /* Stock section */
        .product-stock-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 0.75rem;
            border-top: 1px solid #f0f0f0;
            margin-bottom: 1rem;
        }

        .product-stock-badge {
            font-size: 0.85rem;
            font-weight: 600;
        }

        .product-stock-badge.available {
            color: #27ae60;
        }

        .product-stock-badge.low-stock {
            color: var(--accent-orange);
        }

        .product-stock-badge.unavailable {
            color: #e74c3c;
        }

        .product-duration {
            font-size: 0.8rem;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Borrow button */
        .product-actions {
            margin-top: auto;
        }

        .btn-borrow {
            width: 100%;
            padding: 0.85rem 1rem;
            background: linear-gradient(135deg, var(--accent-blue) 0%, #2980b9 100%);
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

        .btn-borrow::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: 0.5s;
        }

        .btn-borrow:hover::before {
            left: 100%;
        }

        .btn-borrow:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52,152,219,0.35);
        }

        .btn-borrow:disabled {
            background: #bdc3c7;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-borrow:disabled::before {
            display: none;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--accent-gold) 0%, #c89530 100%);
        }

        .btn-login:hover {
            box-shadow: 0 6px 20px rgba(212,168,83,0.35);
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
            color: var(--accent-blue);
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
            <h1><i class="fa fa-book-reader me-2"></i>Bibliothèque d'Emprunts</h1>
            <p>Empruntez des livres africains et profitez de notre collection unique</p>
            <div class="hero-stats">
                <div class="stat-badge">
                    <i class="fa fa-books"></i>
                    <span><strong>{{ $emprunts->total() }}</strong> livres disponibles</span>
                </div>
                <div class="stat-badge">
                    <i class="fa fa-clock"></i>
                    <span>14 jours de prêt</span>
                </div>
                <div class="stat-badge">
                    <i class="fa fa-redo"></i>
                    <span>Renouvellement possible</span>
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
                $categories = \App\Models\Catalogue::where('type_categorie', 'emprunt')
                    ->whereNotNull('categorie')
                    ->where('categorie', '!=', '')
                    ->distinct()
                    ->pluck('categorie')
                    ->sort();
                $currentCategory = request('categorie');
                $totalBooks = \App\Models\Catalogue::where('type_categorie', 'emprunt')->count();
            @endphp
            @if($categories->isNotEmpty())
            <div class="filter-chips">
                <button type="button" class="filter-chip {{ !$currentCategory ? 'active' : '' }}" data-category="">
                    <i class="fa fa-th"></i> Tous ({{ $totalBooks }})
                </button>
                @foreach($categories as $categorie)
                    @php
                        $count = \App\Models\Catalogue::where('type_categorie', 'emprunt')
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
                <strong>{{ $emprunts->total() }}</strong> livre(s) trouvé(s)
                @if(request('search'))
                    <span style="color: var(--text-muted); font-size: 0.9rem;">pour "<strong style="color: var(--accent-orange);">{{ request('search') }}</strong>"</span>
                @endif
                @if($currentCategory)
                    <span style="color: var(--text-muted); font-size: 0.9rem;">dans <strong style="color: var(--accent-blue);">{{ $currentCategory }}</strong></span>
                @endif
                @if(request('disponible') === 'true')
                    <span class="badge bg-success ms-2" style="font-size: 0.75rem;"><i class="fa fa-check me-1"></i>Disponibles</span>
                @endif
            </div>
            @if(request('search') || $currentCategory || request('disponible'))
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.location.href='{{ route('catalogue.acheter') }}'">
                    <i class="fa fa-times me-1"></i>Effacer les filtres
                </button>
            @endif
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            @forelse ($emprunts ?? [] as $livre)
                <div class="product-card" data-category="{{ Str::slug($livre->categorie ?? '') }}">
                    <!-- Image Section -->
                    <div class="product-image">
                        <img src="{{ $livre->image ? asset($livre->image) : asset('img/default-book.jpg') }}"
                             alt="{{ $livre->titre ?? 'Livre' }}"
                             loading="lazy">

                        <!-- Badges -->
                        <div class="product-badges">
                            @if (($livre->quantite ?? 0) > 0)
                                <span class="badge-stock in-stock">
                                    <i class="fa fa-check me-1"></i>Disponible
                                </span>
                            @else
                                <span class="badge-stock out-of-stock">
                                    <i class="fa fa-times me-1"></i>Épuisé
                                </span>
                            @endif

                            @if($livre->categorie)
                                <span class="badge-category">{{ $livre->categorie }}</span>
                            @endif
                        </div>

                        <!-- Badge nouveau si ajouté récemment -->
                        @if($livre->created_at && $livre->created_at->gt(now()->subDays(7)))
                            <span class="badge-new">
                                <i class="fa fa-star me-1"></i>Nouveau
                            </span>
                        @endif

                        <!-- Quick view overlay -->
                        <div class="product-overlay">
                            <button class="btn-quick-view" data-bs-toggle="modal" data-bs-target="#resumeModal{{ $livre->id }}">
                                <i class="fa fa-eye me-1"></i>Aperçu rapide
                            </button>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="product-content">
                        <h3 class="product-title">{{ $livre->titre ?? 'Sans titre' }}</h3>

                        <div class="product-author">
                            <i class="fa fa-pen-fancy"></i>
                            <span>{{ $livre->auteur ?? 'Auteur inconnu' }}</span>
                        </div>

                        <p class="product-description">
                            {{ Str::limit(strip_tags($livre->resumer ?? 'Aucune description disponible'), 80) }}
                        </p>

                        <!-- Stock Section -->
                        <div class="product-stock-section">
                            @if (($livre->quantite ?? 0) > 5)
                                <span class="product-stock-badge available">
                                    <i class="fa fa-box me-1"></i>{{ $livre->quantite }} exemplaire(s)
                                </span>
                            @elseif (($livre->quantite ?? 0) > 0)
                                <span class="product-stock-badge low-stock">
                                    <i class="fa fa-exclamation-triangle me-1"></i>Plus que {{ $livre->quantite }}!
                                </span>
                            @else
                                <span class="product-stock-badge unavailable">
                                    <i class="fa fa-times-circle me-1"></i>Indisponible
                                </span>
                            @endif

                            <span class="product-duration">
                                <i class="fa fa-calendar-alt"></i>
                                14 jours
                            </span>
                        </div>

                        <!-- Borrow button -->
                        <div class="product-actions">
                            @auth
                                @if(($livre->quantite ?? 0) > 0)
                                    <form action="{{ route('emprunts.demander') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                        <button type="submit" class="btn-borrow">
                                            <i class="fa fa-hand-holding"></i>
                                            <span>Emprunter ce livre</span>
                                        </button>
                                    </form>
                                @else
                                    <button class="btn-borrow" disabled>
                                        <i class="fa fa-ban"></i>
                                        <span>Indisponible</span>
                                    </button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn-borrow btn-login">
                                    <i class="fa fa-sign-in-alt"></i>
                                    <span>Connexion requise</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Modal résumé -->
                <div class="modal fade" id="resumeModal{{ $livre->id }}" tabindex="-1"
                     aria-labelledby="resumeModalLabel{{ $livre->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="border-radius: var(--radius-lg); overflow: hidden;">
                            <div class="modal-header" style="background: var(--accent-blue); border: none;">
                                <h5 class="modal-title" id="resumeModalLabel{{ $livre->id }}" style="color: white !important;">
                                    <i class="fa fa-book-open me-2" style="color: white;"></i>{{ $livre->titre ?? 'Sans titre' }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                            </div>
                            <div class="modal-body" style="padding: 2rem;">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <img src="{{ $livre->image ? asset($livre->image) : asset('img/default-book.jpg') }}"
                                             alt="{{ $livre->titre }}"
                                             class="img-fluid rounded" style="box-shadow: var(--shadow-soft);">
                                    </div>
                                    <div class="col-md-8">
                                        <p class="mb-2"><strong><i class="fa fa-user text-white me-2" style="background: var(--accent-blue); padding: 0.3rem; border-radius: 50%;"></i>Auteur :</strong> <span style="color: var(--text-dark);">{{ $livre->auteur ?? 'Inconnu' }}</span></p>
                                        <p class="mb-2"><strong><i class="fa fa-tag text-white me-2" style="background: var(--accent-gold); padding: 0.3rem; border-radius: 50%;"></i>Catégorie :</strong> <span style="color: var(--text-dark);">{{ $livre->categorie ?? 'Non catégorisé' }}</span></p>
                                        <p class="mb-2"><strong><i class="fa fa-box text-white me-2" style="background: #27ae60; padding: 0.3rem; border-radius: 50%;"></i>Disponibilité :</strong>
                                            @if(($livre->quantite ?? 0) > 0)
                                                <span style="color: #27ae60; font-weight: 600;">{{ $livre->quantite }} exemplaire(s) disponible(s)</span>
                                            @else
                                                <span style="color: #e74c3c; font-weight: 600;">Épuisé</span>
                                            @endif
                                        </p>
                                        <p class="mb-3"><strong><i class="fa fa-clock text-white me-2" style="background: var(--accent-blue); padding: 0.3rem; border-radius: 50%;"></i>Durée d'emprunt :</strong> <span style="color: var(--text-dark);">14 jours (renouvelable)</span></p>
                                        <hr>
                                        <h6 class="mb-2"><i class="fa fa-align-left text-primary me-2"></i>Résumé</h6>
                                        <p style="line-height: 1.7; color: var(--text-muted);">{{ trim(strip_tags($livre->resumer ?? 'Aucune description disponible')) }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border: none; padding: 1rem 2rem;">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Fermer</button>
                                @auth
                                    @if (($livre->quantite ?? 0) > 0)
                                        <form method="POST" action="{{ route('emprunts.demander') }}" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-hand-holding me-1"></i>Emprunter ce livre
                                            </button>
                                        </form>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-warning">
                                        <i class="fa fa-sign-in-alt me-1"></i>Connexion requise
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fa fa-book-open"></i>
                        <h3>Aucun livre disponible</h3>
                        <p>Notre bibliothèque est en cours de mise à jour. Revenez bientôt pour découvrir de nouveaux livres à emprunter!</p>
                        <a href="{{ route('index') }}" class="btn btn-primary">
                            <i class="fa fa-home me-1"></i>Retour à l'accueil
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($emprunts->hasPages())
            <div class="pagination-wrapper">
                {{ $emprunts->links() }}
            </div>
        @endif

        <!-- Trust Section -->
        <div class="trust-section">
            <div class="trust-badges">
                <div class="trust-badge">
                    <i class="fa fa-book-reader"></i>
                    <span>Emprunt facile et gratuit</span>
                </div>
                <div class="trust-badge">
                    <i class="fa fa-calendar-check"></i>
                    <span>14 jours de prêt</span>
                </div>
                <div class="trust-badge">
                    <i class="fa fa-redo-alt"></i>
                    <span>Renouvellement possible</span>
                </div>
                <div class="trust-badge">
                    <i class="fa fa-headset"></i>
                    <span>Support client réactif</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // ======= VARIABLES GLOBALES =======
            const baseUrl = '{{ route("catalogue.acheter") }}';
            let currentFilters = {
                search: '',
                categorie: '{{ request("categorie", "") }}',
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
                if (currentFilters.disponible) url.searchParams.set('disponible', 'true');
                if (currentFilters.sort_by !== 'created_at') url.searchParams.set('sort_by', currentFilters.sort_by);
                if (currentFilters.sort_order !== 'desc') url.searchParams.set('sort_order', currentFilters.sort_order);

                return url.toString();
            }

            // Compter les filtres actifs
            function countActiveFilters() {
                let count = 0;
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

                    if (!lightVersion) {
                        productsGrid.innerHTML = '<div class="col-12 text-center py-5"><i class="fa fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-3 text-muted">Recherche en cours...</p></div>';
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

                    // Mettre à jour le header des résultats
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
                    initQuickViewButtons();
                    initPaginationLinks();

                    // Retirer l'indicateur de recherche en cours
                    if (searchInput) {
                        searchInput.classList.remove('searching');
                    }

                    currentFetchController = null;
                })
                .catch(error => {
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

            const instantSearch = debounce(function() {
                currentFilters.search = searchInput ? searchInput.value.trim() : '';
                performSearch(true);
            }, 300);

            if (searchButton) {
                searchButton.addEventListener('click', function() {
                    clearTimeout(searchTimeout);
                    currentFilters.search = searchInput ? searchInput.value.trim() : '';
                    performSearch();
                });
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    if (clearSearch) {
                        clearSearch.style.display = this.value.length > 0 ? 'block' : 'none';
                    }
                    this.classList.add('searching');
                    instantSearch();
                });

                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(searchTimeout);
                        currentFilters.search = this.value.trim();
                        performSearch();
                    }
                });
            }

            if (clearSearch) {
                clearSearch.addEventListener('click', function() {
                    if (searchInput) {
                        clearTimeout(searchTimeout);
                        searchInput.value = '';
                        this.style.display = 'none';
                        currentFilters.search = '';
                        performSearch();
                    }
                });
            }

            // ======= PANEL DE FILTRES =======

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
                    $allCategories = \App\Models\Catalogue::where('type_categorie', 'emprunt')
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

            if (resetFilters) {
                resetFilters.addEventListener('click', function() {
                    if (filterCategorie) filterCategorie.value = 'all';
                    if (filterDisponible) filterDisponible.checked = false;
                    if (filterSortBy) filterSortBy.value = 'created_at';
                    if (filterSortOrder) filterSortOrder.value = 'desc';
                    if (toggleSortOrder) {
                        toggleSortOrder.querySelector('i').className = 'fas fa-sort-amount-down';
                    }

                    currentFilters = {
                        search: searchInput ? searchInput.value.trim() : '',
                        categorie: '',
                        disponible: false,
                        sort_by: 'created_at',
                        sort_order: 'desc'
                    };

                    updateFilterCount();

                    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                    const allChip = document.querySelector('.filter-chip[data-category=""]');
                    if (allChip) allChip.classList.add('active');
                });
            }

            if (applyFilters) {
                applyFilters.addEventListener('click', function() {
                    if (filterCategorie && filterCategorie.value !== 'all') {
                        currentFilters.categorie = filterCategorie.value;
                    } else {
                        currentFilters.categorie = '';
                    }

                    currentFilters.disponible = filterDisponible ? filterDisponible.checked : false;
                    currentFilters.sort_by = filterSortBy ? filterSortBy.value : 'created_at';
                    currentFilters.sort_order = filterSortOrder ? filterSortOrder.value : 'desc';

                    document.querySelectorAll('.filter-chip').forEach(c => {
                        c.classList.remove('active');
                        if (c.dataset.category === currentFilters.categorie) {
                            c.classList.add('active');
                        }
                    });

                    updateFilterCount();
                    performSearch();

                    if (filtersPanel) filtersPanel.style.display = 'none';
                    if (toggleFilters) toggleFilters.classList.remove('active');
                });
            }

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

                    document.querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
                    this.classList.add('active');

                    currentFilters.categorie = category;

                    if (filterCategorie) {
                        filterCategorie.value = category || 'all';
                    }

                    performSearch();
                });
            });

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

                            initQuickViewButtons();
                            initPaginationLinks();

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

            initQuickViewButtons();
            initPaginationLinks();
            updateFilterCount();

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
