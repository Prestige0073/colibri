@extends('layouts.app')

@section('title', 'Accueil | Colibri Littéraire - Plateforme du livre africain, formations et catalogue')
@section('meta_description',
    'Colibri Littéraire : découvrez la plateforme dédiée à la formation, à la promotion et à la
    diffusion du livre africain. Formations, catalogue, communauté et événements littéraires.')
@section('meta_keywords',
    'livre africain, formation, édition, catalogue, Bénin, francophonie, Colibri Littéraire,
    culture, lecture, formation métiers du livre, événements littéraires, communauté littéraire')

@section('content')
    <!-- Carousel Start -->
    @php
        $banners = \App\Models\Banner::actif()->orderBy('ordre')->get();
    @endphp
    <div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="owl-carousel header-carousel py-4">
            @forelse($banners as $banner)
                <div class="container py-0">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="carousel-text">
                                <h1 class="display-4 text-uppercase mb-3">{{ $banner->titre }}</h1>
                                <div class="d-flex mt-4">
                                    <a class="btn btn-success py-3 px-4 me-3" href="{{ route('donation.index') }}">Faire un don</a>
                                    <a class="btn btn-secondary py-3 px-4" href="{{ route('register') }}">Nous rejoindre</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="carousel-img">
                                <img class="w-100" src="{{ asset($banner->image) }}" alt="{{ $banner->titre }}">
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Fallback si aucune bannière en base --}}
                <div class="container py-0">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-6">
                            <div class="carousel-text">
                                <h1 class="display-4 text-uppercase mb-3">Rapprocher le livre africain du lecteur</h1>
                                <div class="d-flex mt-4">
                                    <a class="btn btn-success py-3 px-4 me-3" href="{{ route('donation.index') }}">Faire un don</a>
                                    <a class="btn btn-secondary py-3 px-4" href="{{ route('register') }}">Nous rejoindre</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="carousel-img">
                                <img class="w-100" src="{{ asset('img/carousel-1.jpg') }}" alt="Image">
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <!-- Carousel End -->

    @include('partials.notifications')

    <!-- Video Start -->
    <div class="container-fluid bg-success mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-11">
                    <div class="h-100 py-5 d-flex align-items-center">
                        <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                        <h3 class="ms-5 text-white mb-0">Ensemble, nous construisons un avenir où chaque
                            passionné du livre peut accéder facilement au livre
                            africain et chaque acteur, se former aux métiers du
                            secteur</h3>
                    </div>
                </div>
                <div class="d-none d-lg-block col-lg-1">
                    <div class="h-100 w-100 bg-secondary d-flex align-items-center justify-content-center">
                        <span class="text-white" style="transform: rotate(-90deg);">Faire défiler</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video End -->

    <!-- Video Modal Start -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Vidéo Youtube</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- 16:9 aspect ratio -->
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="" id="video" allowfullscreen
                            allowscriptaccess="always" allow="autoplay"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Video Modal End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.2s">
                    <div class="">
                        <img class="img-fluid w-100" src="{{ asset('img/LOGO-COLIBRI-LITTERAIRE.png') }}" alt="Image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-success pe-3">À propos</p>
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">Rejoignez la communauté Colibri Littéraire
                    </h1>
                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">Colibri Littéraire est une plateforme de diffusion
                        solidaire des œuvres littéraires africaines et de
                        renforcement des capacités, en continu, des acteurs de
                        la chaine du livre.</p>
                    <div class="row g-4 pt-2">
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                            <div class="h-100">
                                <h3>Notre Vision</h3>
                                <p>Soutenir les efforts de chaque maillon de la chaine du livre africain en assurant la
                                    formation
                                    continue des professionnels et en facilitant la circulation des productions locales</p>
                            </div>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="h-100 bg-success p-4 text-center">
                                <p class="fs-5 text-white">Grâce à vos dons, le livre africain voyage loin à travers
                                    le monde. </p>
                                <a class="btn btn-secondary py-2 px-4" href="{{ route('donation.index') }}">Faire un don</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Catalogue Start -->
    <div class="container-fluid py-5 home-catalogue-section">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-success px-3">Catalogue</p>
                <h1 class="display-6 mb-2">Découvrez notre sélection de livres africains</h1>
                <p class="text-muted mb-4">Livres à acheter pour enrichir votre bibliothèque personnelle</p>
            </div>

            <!-- Grille des produits moderne -->
            <div class="home-products-grid">
                @foreach ($Catalogues as $catalogue)
                    @if ($catalogue->type_categorie === 'catalogue')
                        <div class="home-product-card wow fadeIn" data-wow-delay="0.1s">
                            <!-- Image Section -->
                            <div class="home-product-image">
                                <img src="{{ $catalogue->image ? asset($catalogue->image) : asset('img/default-book.jpg') }}"
                                     alt="{{ $catalogue->titre ?? 'Livre' }}"
                                     loading="lazy">

                                <!-- Badges -->
                                <div class="home-product-badges">
                                    @if (($catalogue->quantite ?? 0) > 0)
                                        <span class="home-badge-stock in-stock">
                                            <i class="fa fa-check me-1"></i>En stock
                                        </span>
                                    @else
                                        <span class="home-badge-stock out-of-stock">
                                            <i class="fa fa-times me-1"></i>Épuisé
                                        </span>
                                    @endif

                                    @if($catalogue->categorie)
                                        <span class="home-badge-category">{{ $catalogue->categorie }}</span>
                                    @endif
                                </div>

                                <!-- Badge nouveau -->
                                @if($catalogue->created_at && $catalogue->created_at->gt(now()->subDays(7)))
                                    <span class="home-badge-new">
                                        <i class="fa fa-star me-1"></i>Nouveau
                                    </span>
                                @endif

                                <!-- Overlay aperçu rapide -->
                                <div class="home-product-overlay">
                                    <button type="button" class="home-quick-view-btn" data-bs-toggle="modal" data-bs-target="#homeCatalogueModal{{ $catalogue->id }}">
                                        <i class="fa fa-eye me-2"></i>Aperçu rapide
                                    </button>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="home-product-content">
                                <h3 class="home-product-title">
                                    <i class="fa fa-book home-title-icon"></i>
                                    {{ $catalogue->titre ?? 'Sans titre' }}
                                </h3>

                                <div class="home-product-author">
                                    <i class="fa fa-pen-fancy"></i>
                                    <span>{{ $catalogue->auteur ?? 'Auteur inconnu' }}</span>
                                </div>

                                @if($catalogue->categorie)
                                <div class="home-product-category-info">
                                    <i class="fa fa-tag"></i>
                                    <span>{{ $catalogue->categorie }}</span>
                                </div>
                                @endif

                                <p class="home-product-description">
                                    <i class="fa fa-align-left home-desc-icon"></i>
                                    {{ Str::limit(strip_tags($catalogue->resumer ?? 'Aucune description disponible'), 80) }}
                                </p>

                                <!-- Prix -->
                                <div class="home-product-price-section">
                                    <span class="home-product-price">
                                        <i class="fa fa-coins home-price-icon"></i>
                                        {{ number_format($catalogue->prix ?? 0, 0, ',', ' ') }} FCFA
                                    </span>
                                    @if (($catalogue->quantite ?? 0) > 0 && ($catalogue->quantite ?? 0) <= 5)
                                        <span class="home-stock-warning">
                                            <i class="fa fa-exclamation-triangle"></i> Plus que {{ $catalogue->quantite }}!
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="home-product-actions">
                                    <form method="POST" action="{{ route('panier.ajouter') }}" class="home-add-form home-ajax-cart-form">
                                        @csrf
                                        <input type="hidden" name="catalogue_id" value="{{ $catalogue->id }}">
                                        <input type="hidden" name="quantite" value="1">
                                        <button type="submit" class="home-btn-buy" @if(($catalogue->quantite ?? 0) == 0) disabled @endif>
                                            <i class="fa fa-shopping-cart"></i>
                                            <span>Ajouter au panier</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Bouton voir plus -->
            <div class="text-center mt-4 wow fadeIn" data-wow-delay="0.3s">
                <a href="{{ route('catalogue.index') }}" class="btn btn-success btn-lg px-5">
                    <i class="fa fa-book me-2"></i>Voir tout le catalogue
                    <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modals Catalogue - Aperçu rapide -->
    @foreach ($Catalogues as $catalogue)
        @if ($catalogue->type_categorie === 'catalogue')
            <div class="modal fade" id="homeCatalogueModal{{ $catalogue->id }}" tabindex="-1" aria-labelledby="homeCatalogueModalLabel{{ $catalogue->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content home-modal-content">
                        <div class="modal-header home-modal-header">
                            <h5 class="modal-title" id="homeCatalogueModalLabel{{ $catalogue->id }}">
                                <i class="fa fa-book me-2"></i>{{ $catalogue->titre ?? 'Sans titre' }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <img src="{{ $catalogue->image ? asset($catalogue->image) : asset('img/default-book.jpg') }}"
                                         alt="{{ $catalogue->titre }}"
                                         class="img-fluid rounded home-modal-image">
                                </div>
                                <div class="col-md-8">
                                    <div class="home-modal-info">
                                        <p class="home-modal-author">
                                            <i class="fa fa-pen-fancy me-2 text-warning"></i>
                                            <strong>Auteur:</strong> {{ $catalogue->auteur ?? 'Inconnu' }}
                                        </p>
                                        <p class="home-modal-category">
                                            <i class="fa fa-tag me-2 text-info"></i>
                                            <strong>Catégorie:</strong> {{ $catalogue->categorie ?? 'Non classé' }}
                                        </p>
                                        <p class="home-modal-price">
                                            <i class="fa fa-money-bill me-2 text-success"></i>
                                            <strong>Prix:</strong>
                                            <span class="badge bg-success fs-6">{{ number_format($catalogue->prix ?? 0, 0, ',', ' ') }} FCFA</span>
                                        </p>
                                    </div>
                                    <hr>
                                    <h6><i class="fa fa-align-left me-2"></i>Résumé</h6>
                                    <div class="home-modal-resume">
                                        {!! $catalogue->resumer ?? 'Aucune description disponible pour ce livre.' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa fa-times me-2"></i>Fermer
                            </button>
                            <a href="{{ route('catalogue.show', $catalogue->id) }}" class="btn btn-outline-success">
                                <i class="fa fa-info-circle me-2"></i>Voir détails
                            </a>
                            @if(($catalogue->quantite ?? 0) > 0)
                                <form method="POST" action="{{ route('panier.ajouter') }}" class="d-inline home-ajax-cart-form">
                                    @csrf
                                    <input type="hidden" name="catalogue_id" value="{{ $catalogue->id }}">
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-shopping-cart me-2"></i>Ajouter au panier
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <!-- Catalogue End -->

    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <a href="{{ route('equipe.index') }}" class="text-decoration-none d-block">
                                    <div class="text-center bg-success py-5 px-4 h-100 stat-box-link">
                                        <i class="fa fa-users fa-3x text-white mb-3"></i>
                                        <h1 class="display-5 mb-0 text-white" data-toggle="counter-up">{{ $totalMembres ?? 11 }}</h1>
                                        <span class="text-white">Membres de l'équipe</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <a href="{{ route('catalogue.index') }}" class="text-decoration-none d-block">
                                    <div class="text-center bg-secondary py-5 px-4 h-100 stat-box-link">
                                        <i class="fa fa-book fa-3x text-white mb-3"></i>
                                        <h1 class="display-5 text-white mb-0" data-toggle="counter-up">{{ $totalLivres ?? 0 }}</h1>
                                        <span class="text-white">Livres au catalogue</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <a href="{{ route('formation.modules') }}" class="text-decoration-none d-block">
                                    <div class="text-center bg-secondary py-5 px-4 h-100 stat-box-link">
                                        <i class="fa fa-graduation-cap fa-3x text-white mb-3"></i>
                                        <h1 class="display-5 text-white mb-0" data-toggle="counter-up">{{ $totalFormations ?? 0 }}</h1>
                                        <span class="text-white">Formations disponibles</span>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <a href="{{ route('account.profil') }}" class="text-decoration-none d-block">
                                    <div class="text-center bg-success py-5 px-4 h-100 stat-box-link">
                                        <i class="fa fa-user-graduate fa-3x text-white mb-3"></i>
                                        <h1 class="display-5 mb-0 text-white" data-toggle="counter-up">{{ $totalUtilisateurs ?? 0 }}</h1>
                                        <span class="text-white">Utilisateurs inscrits</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">Pourquoi choisir notre plateforme ?</h1>
                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">Des formations certifiantes, un catalogue riche de
                        livres africains, un accompagnement personnalisé, et une vision engagée pour la démocratisation de
                        la culture du livre.</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.4s"><i
                            class="fa fa-check text-success me-2"></i>Formations et certifications reconnues</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.5s"><i
                            class="fa fa-check text-success me-2"></i>Accès à des livres africains et béninois</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.6s"><i
                            class="fa fa-check text-success me-2"></i>Accompagnement et évolution professionnelle</p>
                    <div class="d-flex mt-4 wow fadeIn" data-wow-delay="0.7s">
                        <a class="btn btn-success py-3 px-4 me-3" href="{{ route('formation.modules') }}">Voir les formations</a>
                        <a class="btn btn-secondary py-3 px-4" href="{{ route('catalogue.index') }}">Accéder au catalogue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->

    <!-- Bibliothèque Start -->
    <div class="container-fluid py-5 home-bibliotheque-section">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-primary px-3">Bibliothèque</p>
                <h1 class="display-6 mb-2">Empruntez nos livres</h1>
                <p class="text-muted mb-4">Accédez gratuitement à notre collection - 14 jours de prêt</p>
            </div>

            <!-- Grille des emprunts moderne -->
            <div class="home-products-grid home-emprunts-grid">
                @foreach ($Bibliotheques as $livre)
                    @if ($livre->type_categorie === 'emprunt')
                        <div class="home-product-card home-emprunt-card wow fadeIn" data-wow-delay="0.1s">
                            <!-- Image Section -->
                            <div class="home-product-image">
                                <img src="{{ $livre->image ? asset($livre->image) : asset('img/default-book.jpg') }}"
                                     alt="{{ $livre->titre ?? 'Livre' }}"
                                     loading="lazy">

                                <!-- Badges -->
                                <div class="home-product-badges">
                                    @if (($livre->quantite ?? 0) > 0)
                                        <span class="home-badge-stock in-stock emprunt-stock">
                                            <i class="fa fa-check me-1"></i>Disponible
                                        </span>
                                    @else
                                        <span class="home-badge-stock out-of-stock">
                                            <i class="fa fa-times me-1"></i>Épuisé
                                        </span>
                                    @endif

                                    @if($livre->categorie)
                                        <span class="home-badge-category">{{ $livre->categorie }}</span>
                                    @endif
                                </div>

                                <!-- Badge nouveau -->
                                @if($livre->created_at && $livre->created_at->gt(now()->subDays(7)))
                                    <span class="home-badge-new emprunt-new">
                                        <i class="fa fa-star me-1"></i>Nouveau
                                    </span>
                                @endif

                                <!-- Overlay aperçu rapide -->
                                <div class="home-product-overlay home-emprunt-overlay">
                                    <button type="button" class="home-quick-view-btn home-emprunt-quick-btn" data-bs-toggle="modal" data-bs-target="#homeEmpruntModal{{ $livre->id }}">
                                        <i class="fa fa-eye me-2"></i>Aperçu rapide
                                    </button>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="home-product-content">
                                <h3 class="home-product-title">
                                    <i class="fa fa-book-reader home-title-icon home-title-icon-blue"></i>
                                    {{ $livre->titre ?? 'Sans titre' }}
                                </h3>

                                <div class="home-product-author">
                                    <i class="fa fa-pen-fancy"></i>
                                    <span>{{ $livre->auteur ?? 'Auteur inconnu' }}</span>
                                </div>

                                @if($livre->categorie)
                                <div class="home-product-category-info home-category-blue">
                                    <i class="fa fa-tag"></i>
                                    <span>{{ $livre->categorie }}</span>
                                </div>
                                @endif

                                <p class="home-product-description">
                                    <i class="fa fa-align-left home-desc-icon"></i>
                                    {{ Str::limit(strip_tags($livre->resumer ?? 'Aucune description disponible'), 80) }}
                                </p>

                                <!-- Info emprunt -->
                                <div class="home-emprunt-info">
                                    <span class="home-emprunt-duration">
                                        <i class="fa fa-clock"></i> 14 jours
                                    </span>
                                    @if (($livre->quantite ?? 0) > 0)
                                        <span class="home-emprunt-stock">
                                            <i class="fa fa-box"></i> {{ $livre->quantite }} dispo.
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="home-product-actions">
                                    @auth
                                        @if(($livre->quantite ?? 0) > 0)
                                            <form method="POST" action="{{ route('emprunts.demander') }}" class="home-add-form">
                                                @csrf
                                                <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                                <button type="submit" class="home-btn-borrow">
                                                    <i class="fa fa-hand-holding"></i>
                                                    <span>Emprunter</span>
                                                </button>
                                            </form>
                                        @else
                                            <button class="home-btn-borrow" disabled>
                                                <i class="fa fa-ban"></i>
                                                <span>Indisponible</span>
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="home-btn-borrow home-btn-login">
                                            <i class="fa fa-sign-in-alt"></i>
                                            <span>Connexion requise</span>
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Bouton voir plus -->
            <div class="text-center mt-4 wow fadeIn" data-wow-delay="0.3s">
                <a href="{{ route('catalogue.acheter') }}" class="btn btn-primary btn-lg px-5">
                    <i class="fa fa-book-reader me-2"></i>Voir tous les emprunts
                    <i class="fa fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Modals Emprunts - Aperçu rapide -->
    @foreach ($Bibliotheques as $livre)
        @if ($livre->type_categorie === 'emprunt')
            <div class="modal fade" id="homeEmpruntModal{{ $livre->id }}" tabindex="-1" aria-labelledby="homeEmpruntModalLabel{{ $livre->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content home-modal-content home-emprunt-modal">
                        <div class="modal-header home-modal-header home-emprunt-modal-header">
                            <h5 class="modal-title" id="homeEmpruntModalLabel{{ $livre->id }}">
                                <i class="fa fa-book-reader me-2"></i>{{ $livre->titre ?? 'Sans titre' }}
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <img src="{{ $livre->image ? asset($livre->image) : asset('img/default-book.jpg') }}"
                                         alt="{{ $livre->titre }}"
                                         class="img-fluid rounded home-modal-image">
                                </div>
                                <div class="col-md-8">
                                    <div class="home-modal-info">
                                        <p class="home-modal-author">
                                            <i class="fa fa-pen-fancy me-2 text-warning"></i>
                                            <strong>Auteur:</strong> {{ $livre->auteur ?? 'Inconnu' }}
                                        </p>
                                        <p class="home-modal-category">
                                            <i class="fa fa-tag me-2 text-info"></i>
                                            <strong>Catégorie:</strong> {{ $livre->categorie ?? 'Non classé' }}
                                        </p>
                                        <p class="home-modal-duration">
                                            <i class="fa fa-clock me-2 text-primary"></i>
                                            <strong>Durée d'emprunt:</strong>
                                            <span class="badge bg-primary">14 jours</span>
                                        </p>
                                    </div>
                                    <hr>
                                    <h6><i class="fa fa-align-left me-2"></i>Résumé</h6>
                                    <div class="home-modal-resume">
                                        {!! $livre->resumer ?? 'Aucune description disponible pour ce livre.' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fa fa-times me-2"></i>Fermer
                            </button>
                            <a href="{{ route('catalogue.show', $livre->id) }}" class="btn btn-outline-primary">
                                <i class="fa fa-info-circle me-2"></i>Voir détails
                            </a>
                            @auth
                                @if(($livre->quantite ?? 0) > 0)
                                    <form method="POST" action="{{ route('emprunts.demander') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-hand-holding me-2"></i>Emprunter ce livre
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-warning">
                                    <i class="fa fa-sign-in-alt me-2"></i>Connexion requise
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    <!-- Bibliothèque End -->

    <!-- Testimonials Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-success px-3">Témoignages</p>
                <h1 class="display-6 mb-4">Ce que disent nos membres de nous</h1>
            </div>

            @php
                $testimonials = \App\Models\Testimonial::approved()->latest('approved_at')->limit(6)->get();
            @endphp

            @if($testimonials->isEmpty())
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-comment-dots fa-4x text-muted mb-3"></i>
                        <h5 class="text-muted">Aucun témoignage pour le moment</h5>
                        <p class="text-muted mb-3">Soyez le premier à partager votre expérience !</p>
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#testimonialModal">
                            <i class="fas fa-star me-2"></i>Laisser un témoignage
                        </button>
                    </div>
                </div>
            @else
                <div class="row g-4 mb-4">
                    @foreach($testimonials as $testimonial)
                        <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.{{ $loop->iteration }}s">
                            <div class="card h-100 border-0 shadow-sm testimonial-card">
                                <div class="card-body d-flex flex-column">
                                    <!-- Étoiles en haut -->
                                    <div class="text-warning mb-3">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : ' opacity-25' }}"></i>
                                        @endfor
                                    </div>

                                    <!-- Message -->
                                    <p class="mb-4 flex-grow-1" style="font-style: italic; color: #555;">
                                        "{{ $testimonial->message }}"
                                    </p>

                                    <!-- Profil en bas -->
                                    <div class="d-flex align-items-center mt-auto">
                                        @if($testimonial->photo)
                                            <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                                 alt="{{ $testimonial->name }}"
                                                 class="rounded-circle me-3"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                                 style="width: 50px; height: 50px; font-size: 18px;">
                                                {{ $testimonial->initials }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $testimonial->name }}</div>
                                            @if($testimonial->role)
                                                <small class="text-muted">{{ $testimonial->role }}</small>
                                            @endif
                                            @if($testimonial->company)
                                                <br><small class="text-muted">{{ $testimonial->company }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Bouton pour ajouter un témoignage -->
                <div class="text-center mt-4 wow fadeIn" data-wow-delay="0.5s">
                    <button type="button" class="btn btn-success btn-lg" data-bs-toggle="modal" data-bs-target="#testimonialModal">
                        <i class="fas fa-star me-2"></i>Partager votre expérience
                    </button>
                </div>
            @endif
        </div>
    </div>
    <!-- Testimonials End -->

    <!-- Partner (OIF) Start -->
    <div class="container-fluid py-4 bg-light">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 col-md-3 d-flex justify-content-center justify-content-md-start mb-3 mb-md-0">
                    <img src="{{ asset('img/Logo_OIF.png') }}" alt="OIF" class="img-fluid"
                        style="max-height:80px;">
                </div>
                <div class="col-12 col-md-9 text-center text-md-start">
                    <p class="section-title bg-white text-start text-success pe-3">Partenaire</p>
                    <h4 class="mb-1">Organisation Internationale de la Francophonie (OIF)</h4>
                    <p class="mb-0">Soutient ce projet dans le cadre du dispositif <strong>FORCE</strong>.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Partner (OIF) End -->

    <!-- Modal Témoignage -->
    <div class="modal fade" id="testimonialModal" tabindex="-1" aria-labelledby="testimonialModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="testimonialModalLabel">
                        <i class="fas fa-comment-dots me-2"></i>Partagez votre témoignage
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data" id="testimonialForm">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <!-- Nom (obligatoire) -->
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    Nom complet <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', Auth::check() ? Auth::user()->name : '') }}"
                                       required
                                       placeholder="Votre nom complet">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email (optionnel) -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}"
                                       placeholder="votre@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Fonction (optionnel) -->
                            <div class="col-md-6">
                                <label for="role" class="form-label">Fonction</label>
                                <input type="text"
                                       class="form-control @error('role') is-invalid @enderror"
                                       id="role"
                                       name="role"
                                       value="{{ old('role') }}"
                                       placeholder="Ex: Écrivain, Éditeur, Lecteur...">
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Organisation (optionnel) -->
                            <div class="col-md-6">
                                <label for="company" class="form-label">Organisation</label>
                                <input type="text"
                                       class="form-control @error('company') is-invalid @enderror"
                                       id="company"
                                       name="company"
                                       value="{{ old('company') }}"
                                       placeholder="Nom de votre organisation">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Note (obligatoire) -->
                            <div class="col-12">
                                <label class="form-label">
                                    Votre évaluation <span class="text-danger">*</span>
                                </label>
                                <div class="rating-input">
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio"
                                               name="rating"
                                               value="{{ $i }}"
                                               id="star{{ $i }}"
                                               {{ old('rating') == $i ? 'checked' : ($i == 5 && !old('rating') ? 'checked' : '') }}>
                                        <label for="star{{ $i }}" class="star">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    @endfor
                                </div>
                                @error('rating')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Message (obligatoire) -->
                            <div class="col-12">
                                <label for="message" class="form-label">
                                    Votre témoignage <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('message') is-invalid @enderror"
                                          id="message"
                                          name="message"
                                          rows="4"
                                          required
                                          minlength="10"
                                          maxlength="500"
                                          placeholder="Partagez votre expérience avec Colibri Littéraire... (10-500 caractères)">{{ old('message') }}</textarea>
                                <small class="text-muted">
                                    <span id="charCount">0</span>/500 caractères
                                </small>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Photo (optionnel) -->
                            <div class="col-12">
                                <label for="photo" class="form-label">Photo de profil (optionnel)</label>
                                <input type="file"
                                       class="form-control @error('photo') is-invalid @enderror"
                                       id="photo"
                                       name="photo"
                                       accept="image/jpeg,image/png,image/jpg">
                                <small class="text-muted">Format: JPG, PNG (max 1 Mo)</small>
                                @error('photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Note d'information -->
                            <div class="col-12">
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Votre témoignage sera publié après validation par notre équipe.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-2"></i>Envoyer mon témoignage
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    /* Stat boxes cliquables */
    .stat-box-link {
        transition: transform 0.3s ease, filter 0.3s ease;
        cursor: pointer;
    }

    .stat-box-link:hover {
        transform: scale(1.05);
        filter: brightness(1.15);
    }

    /* ============================================
       HOME PAGE - MODERN PRODUCT CARDS
       ============================================ */

    /* Variables CSS */
    :root {
        --home-primary-green: #1e7a2f;
        --home-primary-dark: #0b5e34;
        --home-accent-gold: #d4a853;
        --home-accent-orange: #e67e22;
        --home-accent-blue: #3498db;
        --home-text-dark: #2c3e50;
        --home-text-muted: #6c7a89;
        --home-bg-cream: #faf8f5;
        --home-shadow-soft: 0 4px 20px rgba(0,0,0,0.08);
        --home-shadow-hover: 0 12px 35px rgba(30,122,47,0.15);
        --home-radius-lg: 16px;
        --home-radius-md: 12px;
        --home-radius-sm: 8px;
        --home-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Product Grid */
    .home-products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    /* Product Card */
    .home-product-card {
        background: white;
        border-radius: var(--home-radius-lg);
        overflow: hidden;
        box-shadow: var(--home-shadow-soft);
        transition: var(--home-transition);
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .home-product-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--home-shadow-hover);
    }

    /* Image container */
    .home-product-image {
        position: relative;
        height: 200px;
        overflow: hidden;
        background: linear-gradient(135deg, #f5f7fa 0%, #e8ecef 100%);
    }

    .home-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .home-product-card:hover .home-product-image img {
        transform: scale(1.08);
    }

    /* Overlay aperçu rapide */
    .home-product-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(30, 122, 47, 0.95), rgba(30, 122, 47, 0.7));
        padding: 1.5rem;
        transform: translateY(100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .home-product-card:hover .home-product-overlay {
        transform: translateY(0);
    }

    .home-quick-view-btn {
        background: white;
        color: var(--home-primary-green);
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 30px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .home-quick-view-btn:hover {
        background: var(--home-primary-dark);
        color: white;
        transform: scale(1.05);
    }

    /* Overlay bleu pour emprunts */
    .home-emprunt-overlay {
        background: linear-gradient(to top, rgba(52, 152, 219, 0.95), rgba(52, 152, 219, 0.7));
    }

    .home-emprunt-quick-btn {
        color: var(--home-accent-blue);
    }

    .home-emprunt-quick-btn:hover {
        background: #2980b9;
        color: white;
    }

    /* Badges */
    .home-product-badges {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        right: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        z-index: 2;
    }

    .home-badge-stock {
        padding: 0.35rem 0.7rem;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .home-badge-stock.in-stock {
        background: linear-gradient(135deg, #27ae60, #1e8449);
        color: white;
        box-shadow: 0 2px 8px rgba(39,174,96,0.35);
    }

    .home-badge-stock.out-of-stock {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
        color: white;
    }

    .home-badge-category {
        padding: 0.35rem 0.7rem;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(4px);
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--home-text-dark);
    }

    .home-badge-new {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        padding: 0.35rem 0.7rem;
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border-radius: 20px;
        font-size: 0.65rem;
        font-weight: 600;
        z-index: 2;
        box-shadow: 0 2px 10px rgba(245, 87, 108, 0.4);
    }

    /* Product content */
    .home-product-content {
        padding: 1.25rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .home-product-title {
        font-size: 1rem;
        font-weight: 700;
        color: var(--home-text-dark);
        margin-bottom: 0.5rem;
        line-height: 1.4;
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .home-product-title span,
    .home-product-title:not(:has(i)) {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .home-title-icon {
        color: var(--home-primary-green);
        font-size: 0.9rem;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .home-title-icon-blue {
        color: var(--home-accent-blue);
    }

    .home-product-author {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
        color: var(--home-text-muted);
        margin-bottom: 0.5rem;
    }

    .home-product-author i {
        color: var(--home-accent-gold);
        font-size: 0.75rem;
    }

    .home-product-category-info {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.8rem;
        color: var(--home-primary-green);
        margin-bottom: 0.75rem;
        font-weight: 500;
    }

    .home-product-category-info i {
        font-size: 0.7rem;
    }

    .home-category-blue {
        color: var(--home-accent-blue);
    }

    .home-product-description {
        font-size: 0.8rem;
        color: var(--home-text-muted);
        line-height: 1.5;
        margin-bottom: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.4rem;
        flex: 1;
    }

    .home-desc-icon {
        color: #bdc3c7;
        font-size: 0.7rem;
        flex-shrink: 0;
        margin-top: 3px;
    }

    .home-price-icon {
        color: var(--home-accent-gold);
        margin-right: 0.25rem;
    }

    /* Price section */
    .home-product-price-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f0f0;
        margin-bottom: 1rem;
    }

    .home-product-price {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--home-primary-green);
    }

    .home-stock-warning {
        font-size: 0.75rem;
        color: var(--home-accent-orange);
        font-weight: 600;
    }

    /* Buy button */
    .home-product-actions {
        margin-top: auto;
    }

    .home-btn-buy {
        width: 100%;
        padding: 0.85rem 1rem;
        background: linear-gradient(135deg, var(--home-primary-green) 0%, var(--home-primary-dark) 100%);
        color: white;
        border: none;
        border-radius: var(--home-radius-md);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: var(--home-transition);
        position: relative;
        overflow: hidden;
    }

    .home-btn-buy::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: 0.5s;
    }

    .home-btn-buy:hover::before {
        left: 100%;
    }

    .home-btn-buy:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30,122,47,0.35);
        color: white;
    }

    .home-btn-buy:disabled {
        background: #bdc3c7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ============================================
       EMPRUNTS SECTION (Blue theme)
       ============================================ */
    .home-bibliotheque-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }

    .home-emprunt-card .home-badge-stock.emprunt-stock {
        background: linear-gradient(135deg, var(--home-accent-blue), #2980b9);
    }

    .home-emprunt-card .home-badge-new.emprunt-new {
        background: linear-gradient(135deg, #a18cd1 0%, #fbc2eb 100%);
    }

    .home-emprunt-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px solid #f0f0f0;
        margin-bottom: 1rem;
        font-size: 0.8rem;
        color: var(--home-text-muted);
    }

    .home-emprunt-duration,
    .home-emprunt-stock {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .home-emprunt-duration i {
        color: var(--home-accent-blue);
    }

    .home-emprunt-stock i {
        color: #27ae60;
    }

    .home-btn-borrow {
        width: 100%;
        padding: 0.85rem 1rem;
        background: linear-gradient(135deg, var(--home-accent-blue) 0%, #2980b9 100%);
        color: white;
        border: none;
        border-radius: var(--home-radius-md);
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: var(--home-transition);
        text-decoration: none;
    }

    .home-btn-borrow:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52,152,219,0.35);
        color: white;
    }

    .home-btn-borrow:disabled {
        background: #bdc3c7;
        cursor: not-allowed;
        transform: none;
    }

    .home-btn-borrow.home-btn-login {
        background: linear-gradient(135deg, var(--home-accent-gold) 0%, #c89530 100%);
    }

    .home-btn-borrow.home-btn-login:hover {
        box-shadow: 0 6px 20px rgba(212,168,83,0.35);
    }

    /* ============================================
       HOME PAGE - MODALS STYLES
       ============================================ */
    .home-modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    }

    .home-modal-header {
        background: linear-gradient(135deg, var(--home-primary-green) 0%, var(--home-primary-dark) 100%);
        color: white;
        padding: 1.25rem 1.5rem;
        border: none;
    }

    .home-modal-header .modal-title {
        font-weight: 700;
        font-size: 1.2rem;
    }

    .home-emprunt-modal-header {
        background: linear-gradient(135deg, var(--home-accent-blue) 0%, #2980b9 100%);
    }

    .home-modal-image {
        width: 100%;
        max-height: 300px;
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .home-modal-info p {
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .home-modal-resume {
        font-size: 0.9rem;
        line-height: 1.7;
        color: #333 !important;
        max-height: 150px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }

    .home-modal-resume p,
    .home-modal-resume span,
    .home-modal-resume div,
    .home-modal-resume * {
        color: #333 !important;
        background: transparent !important;
    }

    .home-modal-resume::-webkit-scrollbar {
        width: 4px;
    }

    .home-modal-resume::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }

    .home-modal-resume::-webkit-scrollbar-thumb {
        background: var(--home-primary-green);
        border-radius: 4px;
    }

    .home-emprunt-modal .home-modal-resume::-webkit-scrollbar-thumb {
        background: var(--home-accent-blue);
    }

    .modal-footer {
        border-top: 1px solid #eee;
        padding: 1rem 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .home-products-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 1rem;
        }

        .home-product-image {
            height: 180px;
        }

        .home-product-content {
            padding: 1rem;
        }

        .home-product-title {
            font-size: 0.95rem;
        }

        .home-product-price {
            font-size: 1rem;
        }
    }

    /* Animation */
    @keyframes homeSlideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .home-product-card {
        animation: homeSlideIn 0.5s ease forwards;
    }

    /* ============================================
       Search Home Box
       ============================================ */
    .search-home-box {
        background: white;
        padding: 1.5rem 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .search-input-wrapper {
        position: relative;
    }

    .search-input-wrapper .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c7a89;
        font-size: 1rem;
    }

    .search-input-home {
        padding: 0.85rem 1rem 0.85rem 2.75rem;
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .search-input-home:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.1);
        outline: none;
    }

    .search-link-btn {
        padding: 0.85rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .search-link-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .search-link-btn.btn-success {
        background: linear-gradient(135deg, #198754 0%, #0b5e34 100%);
        border: none;
    }

    .search-link-btn.btn-primary {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        border: none;
    }

    @media (max-width: 768px) {
        .search-home-box {
            padding: 1rem 1.25rem;
        }

        .search-input-wrapper {
            width: 100%;
            max-width: 100% !important;
            margin-bottom: 0.75rem;
        }

        .search-buttons {
            width: 100%;
            justify-content: center;
        }

        .search-link-btn {
            flex: 1;
            padding: 0.75rem 1rem;
            font-size: 0.9rem;
        }
    }
</style>
<style>
    /* Testimonial Cards */
    .testimonial-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }

    /* Rating Input Stars */
    .rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 5px;
        font-size: 2rem;
    }

    .rating-input input[type="radio"] {
        display: none;
    }

    .rating-input label.star {
        cursor: pointer;
        color: #ddd;
        transition: color 0.2s;
    }

    .rating-input input[type="radio"]:checked ~ label.star,
    .rating-input label.star:hover,
    .rating-input label.star:hover ~ label.star {
        color: #ffc107;
    }

    .rating-input input[type="radio"]:checked ~ label.star {
        color: #ffc107;
    }

    /* ============================================
       TOAST NOTIFICATION - CENTREE
       ============================================ */
    .home-cart-toast-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.6);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 99999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        backdrop-filter: blur(4px);
    }

    .home-cart-toast-overlay.show {
        opacity: 1;
        visibility: visible;
    }

    .home-cart-toast-content {
        background: white;
        border-radius: 20px;
        padding: 2.5rem 3rem;
        text-align: center;
        max-width: 450px;
        width: 90%;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
        transform: scale(0.8) translateY(20px);
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .home-cart-toast-overlay.show .home-cart-toast-content {
        transform: scale(1) translateY(0);
    }

    .home-cart-toast-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--home-primary-green) 0%, var(--home-primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 30px rgba(30, 122, 47, 0.4);
        animation: pulseSuccess 0.6s ease;
    }

    .home-cart-toast-icon i {
        font-size: 2.5rem;
        color: white;
    }

    @keyframes pulseSuccess {
        0% { transform: scale(0); opacity: 0; }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); opacity: 1; }
    }

    .home-cart-toast-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3436;
        margin-bottom: 0.5rem;
    }

    .home-cart-toast-message {
        font-size: 1rem;
        color: #636e72;
        margin-bottom: 1.75rem;
    }

    .home-cart-toast-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .home-cart-toast-btn {
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        border: none;
    }

    .home-cart-toast-continue {
        background: #f1f3f4;
        color: #2d3436;
    }

    .home-cart-toast-continue:hover {
        background: #e2e6ea;
        color: #2d3436;
    }

    .home-cart-toast-cart {
        background: linear-gradient(135deg, var(--home-primary-green) 0%, var(--home-primary-dark) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.35);
    }

    .home-cart-toast-cart:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 122, 47, 0.45);
    }

    /* ============================================
       BOUTON AJOUTE - SUCCES
       ============================================ */
    .home-btn-added-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;
        color: white !important;
        border: none !important;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        animation: successBounce 0.5s ease;
        cursor: default;
    }

    .home-btn-added-success i {
        font-size: 1.1rem;
        animation: checkPop 0.4s ease;
    }

    @keyframes successBounce {
        0% { transform: scale(1); }
        30% { transform: scale(1.1); }
        50% { transform: scale(0.95); }
        100% { transform: scale(1); }
    }

    @keyframes checkPop {
        0% { transform: scale(0) rotate(-45deg); }
        50% { transform: scale(1.3) rotate(0deg); }
        100% { transform: scale(1) rotate(0deg); }
    }

    .home-btn-error {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        color: white !important;
        border: none !important;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        cursor: default;
    }

    /* Toast connexion requise */
    .home-cart-toast-icon-warning {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%) !important;
        box-shadow: 0 10px 30px rgba(243, 156, 18, 0.4) !important;
    }

    .home-cart-toast-login {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.35);
    }

    .home-cart-toast-login:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(52, 152, 219, 0.45);
    }

    @media (max-width: 576px) {
        .home-cart-toast-content {
            padding: 2rem 1.5rem;
        }

        .home-cart-toast-icon {
            width: 65px;
            height: 65px;
        }

        .home-cart-toast-icon i {
            font-size: 2rem;
        }

        .home-cart-toast-title {
            font-size: 1.25rem;
        }

        .home-cart-toast-actions {
            flex-direction: column;
        }

        .home-cart-toast-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Recherche sur la page d'accueil - redirection vers catalogue ou emprunts
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('homeSearchInput');
        const catalogueBtn = document.getElementById('searchCatalogueBtn');
        const empruntsBtn = document.getElementById('searchEmpruntsBtn');

        // Vérifier si les éléments existent avant d'ajouter les événements
        if (!searchInput || !catalogueBtn || !empruntsBtn) {
            return; // Sortir si les éléments n'existent pas
        }

        // Mettre à jour les liens avec le terme de recherche
        function updateSearchLinks() {
            const searchTerm = searchInput.value.trim();
            const catalogueUrl = '{{ route("catalogue.index") }}';
            const empruntsUrl = '{{ route("catalogue.acheter") }}';

            if (searchTerm) {
                catalogueBtn.href = catalogueUrl + '?search=' + encodeURIComponent(searchTerm);
                empruntsBtn.href = empruntsUrl + '?search=' + encodeURIComponent(searchTerm);
            } else {
                catalogueBtn.href = catalogueUrl;
                empruntsBtn.href = empruntsUrl;
            }
        }

        // Mettre à jour les liens à chaque frappe
        searchInput.addEventListener('input', updateSearchLinks);

        // Permettre la recherche avec Enter (rediriger vers le catalogue par défaut)
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                updateSearchLinks();
                window.location.href = catalogueBtn.href;
            }
        });
    });

    // Compteur de caractères pour le message
    document.addEventListener('DOMContentLoaded', function() {
        const messageTextarea = document.getElementById('message');
        const charCount = document.getElementById('charCount');

        if (messageTextarea && charCount) {
            // Initialiser le compteur
            charCount.textContent = messageTextarea.value.length;

            // Mettre à jour lors de la saisie
            messageTextarea.addEventListener('input', function() {
                charCount.textContent = this.value.length;

                // Changer la couleur selon la progression
                if (this.value.length < 10) {
                    charCount.style.color = '#dc3545';
                } else if (this.value.length > 450) {
                    charCount.style.color = '#ffc107';
                } else {
                    charCount.style.color = '#198754';
                }
            });
        }

        // Si des erreurs de validation, rouvrir le modal
        @if($errors->any() && (old('name') || old('message')))
            var testimonialModal = new bootstrap.Modal(document.getElementById('testimonialModal'));
            testimonialModal.show();
        @endif
    });

    // ======= AJAX AJOUT AU PANIER =======
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner tous les formulaires d'ajout au panier
        document.querySelectorAll('.home-ajax-cart-form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const btn = form.querySelector('button[type="submit"]');
                const originalContent = btn.innerHTML;
                const originalClasses = btn.className;

                // Animation de chargement
                btn.disabled = true;
                btn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Ajout...';

                // Envoi AJAX
                fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Succès - afficher confirmation avec animation
                        btn.innerHTML = '<i class="fa fa-check-circle me-2"></i>Ajouté au panier !';
                        btn.className = 'home-btn-added-success';

                        // Mettre à jour le compteur du panier dans la navbar
                        updateCartCount();

                        // Afficher une notification toast au centre
                        showCartToast('Livre ajouté au panier avec succès !');

                        // Réinitialiser le bouton après 2.5 secondes
                        setTimeout(() => {
                            btn.innerHTML = originalContent;
                            btn.className = originalClasses;
                            btn.disabled = false;

                            // Fermer le modal si ouvert
                            const modal = btn.closest('.modal');
                            if (modal) {
                                const bsModal = bootstrap.Modal.getInstance(modal);
                                if (bsModal) {
                                    bsModal.hide();
                                }
                            }
                        }, 2500);
                    } else if (response.status === 401) {
                        // Non authentifié - demander de se connecter
                        showLoginRequiredToast();
                        btn.innerHTML = originalContent;
                        btn.className = originalClasses;
                        btn.disabled = false;
                    } else {
                        // Autre erreur
                        btn.innerHTML = '<i class="fa fa-times me-2"></i>Erreur';
                        btn.className = 'home-btn-error';

                        setTimeout(() => {
                            btn.innerHTML = originalContent;
                            btn.className = originalClasses;
                            btn.disabled = false;
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    btn.innerHTML = '<i class="fa fa-times me-2"></i>Erreur';
                    btn.className = 'home-btn-error';

                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.className = originalClasses;
                        btn.disabled = false;
                    }, 2000);
                });
            });
        });

        // Fonction pour mettre à jour le compteur du panier
        function updateCartCount() {
            fetch('{{ route("panier.count") }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                const cartBadges = document.querySelectorAll('.cart-count-badge, .navbar .badge');
                cartBadges.forEach(badge => {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'inline-flex';
                    }
                });
            })
            .catch(error => console.log('Impossible de mettre à jour le compteur'));
        }

        // Fonction pour afficher une notification toast au centre
        function showCartToast(message) {
            // Supprimer l'ancien toast s'il existe
            let existingToast = document.getElementById('homeCartToastCenter');
            if (existingToast) {
                existingToast.remove();
            }

            // Créer le nouveau toast centré
            const toastContainer = document.createElement('div');
            toastContainer.id = 'homeCartToastCenter';
            toastContainer.innerHTML = `
                <div class="home-cart-toast-overlay">
                    <div class="home-cart-toast-content">
                        <div class="home-cart-toast-icon">
                            <i class="fa fa-check"></i>
                        </div>
                        <h3 class="home-cart-toast-title">Ajouté au panier !</h3>
                        <p class="home-cart-toast-message">${message}</p>
                        <div class="home-cart-toast-actions">
                            <button type="button" class="home-cart-toast-btn home-cart-toast-continue" onclick="this.closest('#homeCartToastCenter').remove()">
                                <i class="fa fa-arrow-left me-2"></i>Continuer mes achats
                            </button>
                            <a href="{{ route('panier.index') }}" class="home-cart-toast-btn home-cart-toast-cart">
                                <i class="fa fa-shopping-cart me-2"></i>Voir le panier
                            </a>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(toastContainer);

            // Animation d'entrée
            setTimeout(() => {
                toastContainer.querySelector('.home-cart-toast-overlay').classList.add('show');
            }, 10);

            // Fermer automatiquement après 4 secondes
            setTimeout(() => {
                const overlay = toastContainer.querySelector('.home-cart-toast-overlay');
                if (overlay) {
                    overlay.classList.remove('show');
                    setTimeout(() => toastContainer.remove(), 300);
                }
            }, 4000);
        }

        // Fonction pour afficher une notification de connexion requise
        function showLoginRequiredToast() {
            // Supprimer l'ancien toast s'il existe
            let existingToast = document.getElementById('homeCartToastCenter');
            if (existingToast) {
                existingToast.remove();
            }

            // Créer le toast de connexion requise
            const toastContainer = document.createElement('div');
            toastContainer.id = 'homeCartToastCenter';
            toastContainer.innerHTML = `
                <div class="home-cart-toast-overlay">
                    <div class="home-cart-toast-content">
                        <div class="home-cart-toast-icon home-cart-toast-icon-warning">
                            <i class="fa fa-user-lock"></i>
                        </div>
                        <h3 class="home-cart-toast-title">Connexion requise</h3>
                        <p class="home-cart-toast-message">Veuillez vous connecter pour ajouter des articles à votre panier.</p>
                        <div class="home-cart-toast-actions">
                            <button type="button" class="home-cart-toast-btn home-cart-toast-continue" onclick="this.closest('#homeCartToastCenter').remove()">
                                <i class="fa fa-times me-2"></i>Fermer
                            </button>
                            <a href="{{ route('login') }}" class="home-cart-toast-btn home-cart-toast-login">
                                <i class="fa fa-sign-in-alt me-2"></i>Se connecter
                            </a>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(toastContainer);

            // Animation d'entrée
            setTimeout(() => {
                toastContainer.querySelector('.home-cart-toast-overlay').classList.add('show');
            }, 10);

            // Ne pas fermer automatiquement - laisser l'utilisateur décider
        }
    });
</script>
@endpush
