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
    <div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="owl-carousel header-carousel py-4">
            <div class="container py-0">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-4 text-uppercase mb-3">Rapprocher le livre africain du lecteur</h1>
                            <div class="d-flex">
                                <a class="btn btn-success py-3 px-4 me-3" href="{{ route('contact.index') }}">Faire un
                                    don</a>
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
            <div class="container py-0">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-4 text-uppercase mb-3">Contribuer à dynamiser le marché du livre africain
                            </h1>
                            <p class="fs-5 mb-5"></p>
                            <div class="d-flex mt-4">
                                <a class="btn btn-success py-3 px-4 me-3" href="{{ route('contact.index') }}">Faire un
                                    don</a>
                                <a class="btn btn-secondary py-3 px-4" href="{{ route('register') }}">Nous rejoindre</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="carousel-img">
                            <img class="w-100" src="{{ asset('img/carousel-2.jpg') }}" alt="Image">
                        </div>
                    </div>
                </div>
            </div>
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

    <!-- Section Recherche de Catalogue Start -->
    <div class="container-fluid bg-light py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center mb-5">
                <h5 class="text-primary text-uppercase">Notre Catalogue</h5>
                <h1 class="display-5 mb-0">Recherchez Vos Livres Préférés</h1>
            </div>

            @include('partials.catalogue-search')
        </div>
    </div>
    <!-- Section Recherche de Catalogue End -->

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
                                <a class="btn btn-secondary py-2 px-4" href="#don">Faire un don</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

    <!-- Catalogue Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-success px-3">Catalogue</p>
                <h1 class="display-6 mb-4">Découvrez notre sélection de livres africains</h1>
            </div>

            <style>
                /* Truncate résumé text responsively for catalogue cards - max 3 lines */
                .catalogue-resumer {
                    line-height: 1.2em; /* control line height */
                    max-height: calc(1.2em * 3); /* fallback for non-webkit browsers: 3 lines */
                    overflow: hidden;
                    text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 3; /* number of lines to show (webkit) */
                    word-wrap: break-word;
                    word-break: break-word;
                    hyphens: auto;
                    text-align: justify;
                    flex: 1 1 auto;
                }

                /* Slight adjustment for icon alignment */
                .catalogue-resumer-icon {
                    margin-top: 4px;
                    flex: 0 0 auto;
                }

                /* Ensure still 3 lines on very small screens */
                @media (max-width: 576px) {
                    .catalogue-resumer {
                        -webkit-line-clamp: 3;
                        max-height: calc(1.2em * 3);
                    }
                }
            </style>

            <div class="row g-4">
                @foreach ($Catalogues as $catalogue)
                    @if ($catalogue->type_categorie === 'catalogue')
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="catalogue-item card h-100 border-0 shadow-lg"
                                style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                                <img class="card-img-top" src="{{ $catalogue->image ? asset($catalogue->image) : asset('img/default-book.jpg') }}"
                                    alt="{{ $catalogue->titre ?? 'Livre' }}"
                                    style="border-top-left-radius: 12px; border-top-right-radius: 12px; width:100%; height:240px; object-fit:cover;">
                                <div class="card-body d-flex flex-column justify-content-between"
                                    style="padding: 1.2rem;">
                                    <h5 class="card-title mb-2 d-flex align-items-center"
                                        style="color: #212529; font-weight: 700; font-size: 1.15rem;">
                                        <i class="fa fa-feather-alt"
                                            style="color: #000000ff; margin-right: 0.5em;"></i>{{ $catalogue->titre ?? 'Sans titre' }}
                                    </h5>
                                    <p class="mb-1 d-flex align-items-center" style="color: #607d8b; font-size: 1rem;">
                                        <i class="fa fa-user" style="color: #000000ff; margin-right: 0.4em;"></i>
                                        {{ $catalogue->auteur ?? 'Auteur inconnu' }} &bull; {{ $catalogue->categorie ?? 'Non catégorisé' }}
                                    </p>
                                    <hr style="margin: 0.5rem 0; padding: 0;">
                                    <p class="mb-2 d-flex align-items-start"
                                        style="color: #6d838fff; font-size: 1.05rem;">
                                        <i class="fa fa-star catalogue-resumer-icon" style="color: #FFAC00; margin-right: 0.5em;"></i>
                                        <span class="catalogue-resumer">
                                            {{ Str::limit(strip_tags($catalogue->resumer ?? 'Aucune description disponible'), 300) }}
                                        </span>
                                    </p>
                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <span class="badge"
                                            style="background: #ffe7e7ff; color: #b30000ff; font-size: 1.1rem; padding: 0.25em 0.5em; border-radius: 8px;">
                                            <i class="fa fa-tag me-2" aria-hidden="true"></i>Prix&nbsp;:
                                            {{ $catalogue->prix ?? 0 }}&nbsp;FCFA
                                        </span>
                                        @if (($catalogue->quantite ?? 0) > 0)
                                            <span class="badge"
                                                style="background: #198754; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">En
                                                stock</span>
                                        @else
                                            <span class="badge"
                                                style="background: #e53935; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">Pas
                                                en stock</span>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('panier.ajouter') }}"
                                        onsubmit="return checkStock{{ $catalogue->id }}(event)">
                                        @csrf
                                        <input type="hidden" name="catalogue_id" value="{{ $catalogue->id }}">
                                        <div class="mb-2 d-flex align-items-center">
                                            <label for="quantite-{{ $catalogue->id }}"
                                                class="form-label me-2 mb-0">Quantité :</label>
                                            <div class="input-group" style="width: 90px;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="decrementQuantite{{ $catalogue->id }}()">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="number" min="1" max="{{ $catalogue->quantite ?? 0 }}"
                                                    name="quantite" id="quantite-{{ $catalogue->id }}"
                                                    class="form-control text-center" value="1"
                                                    style="width: 34px; height:28px; padding:0; font-size:1rem;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="incrementQuantite{{ $catalogue->id }}()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <script>
                                            function decrementQuantite{{ $catalogue->id }}() {
                                                var input = document.getElementById('quantite-{{ $catalogue->id }}');
                                                var min = parseInt(input.min);
                                                var val = parseInt(input.value);
                                                if (val > min) input.value = val - 1;
                                            }

                                            function incrementQuantite{{ $catalogue->id }}() {
                                                var input = document.getElementById('quantite-{{ $catalogue->id }}');
                                                var max = parseInt(input.max);
                                                var val = parseInt(input.value);
                                                if (val < max) input.value = val + 1;
                                            }
                                        </script>
                                        <button type="submit" class="btn w-100 catalogue-buy-btn"
                                            style="background: #198754; color: #ffffffff; border-radius: 0; font-weight: 600; font-size: 1.05rem; border: none; transition: background 0.2s;"
                                            @if (($catalogue->quantite ?? 0) == 0) disabled @endif>
                                            <i class="fa fa-shopping-cart me-2"></i>Acheter
                                        </button>
                                    </form>
                                    <script>
                                        function checkStock{{ $catalogue->id }}(e) {
                                            if ({{ $catalogue->quantite ?? 0 }} == 0) {
                                                e.preventDefault();
                                                alert('Ce livre n\'est pas en stock. Veuillez choisir un autre article.');
                                                return false;
                                            }
                                            return true;
                                        }
                                    </script>
                                    <style>
                                        .catalogue-buy-btn:hover {
                                            background: #00a008ff !important;
                                            color: #fff !important;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- Catalogue End -->

    <!-- Features Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="rounded overflow-hidden">
                        <div class="row g-0">
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="text-center bg-success py-5 px-4 h-100">
                                    <i class="fa fa-users fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">10</h1>
                                    <span class="text-white">Membres de l’équipe</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-award fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">0</h1>
                                    <span class="text-white">Prix et distinctions</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-list-check fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">0</h1>
                                    <span class="text-white">Projets réalisés</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="text-center bg-success py-5 px-4 h-100">
                                    <i class="fa fa-comments fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">0</h1>
                                    <span class="text-white">Avis des membres</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-success pe-3">Pourquoi nous choisir ?</p>
                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">Pour la qualité de nos formations, la force de notre
                        réseau et notre engagement pour la littérature africaine. Rejoignez une communauté dynamique et
                        solidaire !</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.4s"><i
                            class="fa fa-check text-success me-2"></i>Formations certifiantes</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.5s"><i
                            class="fa fa-check text-success me-2"></i>Réseau panafricain</p>
                    <p class="text-dark wow fadeIn" data-wow-delay="0.6s"><i
                            class="fa fa-check text-success me-2"></i>Accompagnement personnalisé</p>
                    <div class="d-flex mt-4 wow fadeIn" data-wow-delay="0.7s">
                        <a class="btn btn-success py-3 px-4 me-3" href="#don">Faire un don</a>
                        <a class="btn btn-secondary py-3 px-4" href="#rejoindre">Nous rejoindre</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->

    <!-- Bibliothèque Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-success px-3">Bibliothèque</p>
                <h1 class="display-6 mb-4">Empruntez nos livres</h1>
            </div>

            <style>
                /* Truncate résumé text to at most 3 lines across all viewports */
                .livre-resumer {
                    line-height: 1.2em; /* control line height */
                    max-height: calc(1.2em * 3); /* fallback for non-webkit browsers: 3 lines */
                    overflow: hidden;
                    text-overflow: ellipsis;
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 3; /* number of lines to show (webkit) */
                    word-wrap: break-word;
                    word-break: break-word;
                    hyphens: auto;
                    text-align: justify;
                }

                /* Slight adjustment for icon alignment */
                .livre-resumer-icon {
                    margin-top: 4px;
                    flex: 0 0 auto;
                }
            </style>

            <div class="row g-4">
                @foreach ($Bibliotheques as $livre)
                    @if ($livre->type_categorie === 'emprunt')
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="catalogue-item card h-100 border-0 shadow-lg"
                                style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                                <img class="card-img-top" src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}"
                                    style="width: 100%; height: 280px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <div class="card-body d-flex flex-column justify-content-between"
                                    style="padding: 1.2rem;">
                                    <h5 class="card-title mb-2 d-flex align-items-center"
                                        style="color: #212529; font-weight: 700; font-size: 1.15rem;">
                                        <i class="fa fa-feather-alt"
                                            style="color: #000000ff; margin-right: 0.5em;"></i>{{ $livre->titre }}
                                    </h5>
                                    <p class="mb-1 d-flex align-items-center" style="color: #607d8b; font-size: 1rem;">
                                        <i class="fa fa-user" style="color: #000000ff; margin-right: 0.4em;"></i>
                                        {{ $livre->auteur }} &bull; {{ $livre->categorie }}
                                    </p>
                                    <hr style="margin: 0.5rem 0; padding: 0;">
                                    <p class="mb-2 d-flex" style="color: #6d838fff; font-size: 1.05rem;">
                                        <i class="fa fa-star livre-resumer-icon"
                                            style="color: #FFAC00; margin-right: 0.5em;"></i>
                                        <span class="livre-resumer" style="display:block; text-align: justify; flex:1;">
                                            {{ Str::limit(strip_tags($livre->resumer), 300) }}
                                        </span>
                                    </p>
                                    <div class="mb-3">
                                        <span class="badge"
                                            style="background: #198754; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">
                                            {{ $livre->statut ?? 'Disponible' }}
                                        </span>
                                    </div>
                                    <form method="POST" action="{{ route('bibliotheque.emprunter') }}">
                                        @csrf
                                        <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                        <div class="mb-2 d-flex align-items-center">
                                            <label for="quantite-emprunt-{{ $livre->id }}"
                                                class="form-label me-2 mb-0">Quantité :</label>
                                            <div class="input-group" style="width: 90px;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="decrementQuantiteEmprunt{{ $livre->id }}()">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="number" min="1" max="{{ $livre->quantite }}"
                                                    name="quantite" id="quantite-emprunt-{{ $livre->id }}"
                                                    class="form-control text-center" value="1"
                                                    style="width: 34px; height:28px; padding:0; font-size:1rem;">
                                                <button type="button" class="btn btn-outline-secondary p-1"
                                                    style="width:28px; height:28px;"
                                                    onclick="incrementQuantiteEmprunt{{ $livre->id }}()">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <script>
                                            function decrementQuantiteEmprunt{{ $livre->id }}() {
                                                var input = document.getElementById('quantite-emprunt-{{ $livre->id }}');
                                                var min = parseInt(input.min);
                                                var val = parseInt(input.value);
                                                if (val > min) input.value = val - 1;
                                            }

                                            function incrementQuantiteEmprunt{{ $livre->id }}() {
                                                var input = document.getElementById('quantite-emprunt-{{ $livre->id }}');
                                                var max = parseInt(input.max);
                                                var val = parseInt(input.value);
                                                if (val < max) input.value = val + 1;
                                            }
                                        </script>
                                        <button type="submit" class="btn w-100 catalogue-buy-btn"
                                            style="background: #198754; color: #ffffffff; border-radius: 0; font-weight: 600; font-size: 1.05rem; border: none; transition: background 0.2s;">
                                            <i class="fa fa-book-reader me-2"></i>Emprunter
                                        </button>
                                    </form>
                                    <style>
                                        .catalogue-buy-btn:hover {
                                            background: #00a008ff !important;
                                            color: #fff !important;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <!-- Bibliothèque End -->

    <!-- Testimonials Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                <p class="section-title bg-white text-center text-success px-3">Témoignages</p>
                <h1 class="display-6 mb-4">Ce que nos membres disent de nous</h1>
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
<link rel="stylesheet" href="{{ asset('css/catalogue-search.css') }}">
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
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/catalogue-search.js') }}"></script>
<script>
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
</script>
@endpush
