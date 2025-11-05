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
                            <h1 class="display-5 text-uppercase mb-3">Rapprocher le livre africain du lecteur grâce à une diffusion et une
                                distribution solidaire</h1>
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
                            <h1 class="display-6 text-uppercase mb-3">Professionnaliser les acteurs du livre | Favoriser une bonne circulation
                                des productions locales | Contribuer à accroître les chiffres</h1>
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

    <!-- Toast notification -->
    <div aria-live="polite" aria-atomic="true" class="toast-container-custom">
        @if (session('success'))
            <div id="toast-success"
                class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                role="alert" aria-live="assertive" aria-atomic="true"
                style="pointer-events:auto; background:#1bc47d; color:#fff; font-weight:500;">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Fermer"></button>
                </div>
            </div>
        @endif
        @if (session('error'))
            <div id="toast-error"
                class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                role="alert" aria-live="assertive" aria-atomic="true"
                style="pointer-events:auto; background:#e53935; color:#fff; font-weight:500;">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Fermer"></button>
                </div>
            </div>
        @endif
    </div>

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
                                <p class="text-dark"><i class="fa fa-check text-success me-2"></i>Favoriser la création et
                                    la diffusion.</p>
                                <p class="text-dark mb-0"><i class="fa fa-check text-success me-2"></i>Faire rayonner la
                                    culture africaine.</p>
                            </div>
                        </div>
                        <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                            <div class="h-100 bg-success p-4 text-center">
                                <p class="fs-5 text-white">Grâce à vos dons, le livre africain voyage loin à travers
                                    le monde et l’écrivain africain peut vivre dignement de
                                    son art. </p>
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
            <div class="row g-4">
                @foreach ($Catalogues as $catalogue)
                    @if ($catalogue->type_categorie === 'catalogue')
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="catalogue-item card h-100 border-0 shadow-lg"
                                style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                                <img class="card-img-top" src="{{ asset($catalogue->image) }}"
                                    alt="{{ $catalogue->titre }}"
                                    style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                                <div class="card-body d-flex flex-column justify-content-between"
                                    style="padding: 1.2rem;">
                                    <h5 class="card-title mb-2 d-flex align-items-center"
                                        style="color: #212529; font-weight: 700; font-size: 1.15rem;">
                                        <i class="fa fa-feather-alt"
                                            style="color: #000000ff; margin-right: 0.5em;"></i>{{ $catalogue->titre }}
                                    </h5>
                                    <p class="mb-1 d-flex align-items-center" style="color: #607d8b; font-size: 1rem;">
                                        <i class="fa fa-user" style="color: #000000ff; margin-right: 0.4em;"></i>
                                        {{ $catalogue->auteur }} &bull; {{ $catalogue->categorie }}
                                    </p>
                                    <hr style="margin: 0.5rem 0; padding: 0;">
                                    <p class="mb-2 d-flex align-items-center"
                                        style="color: #6d838fff; font-size: 1.05rem;">
                                        <i class="fa fa-star" style="color: #FFAC00; margin-right: 0.5em;"></i>
                                        <span style="text-align: justify; display: block;">
                                            {{ Str::limit(strip_tags($catalogue->resumer), 100) }}
                                        </span>
                                    </p>
                                    <div class="mb-3 d-flex justify-content-between align-items-center">
                                        <span class="badge"
                                            style="background: #ffe7e7ff; color: #b30000ff; font-size: 1.1rem; padding: 0.25em 0.5em; border-radius: 8px;">
                                            <i class="fa fa-tag me-2" aria-hidden="true"></i>Prix&nbsp;:
                                            {{ $catalogue->prix }}&nbsp;FCFA
                                        </span>
                                        @if ($catalogue->quantite > 0)
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
                                                <input type="number" min="1" max="{{ $catalogue->quantite }}"
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
                                            @if ($catalogue->quantite == 0) disabled @endif>
                                            <i class="fa fa-shopping-cart me-2"></i>Acheter
                                        </button>
                                    </form>
                                    <script>
                                        function checkStock{{ $catalogue->id }}(e) {
                                            if ({{ $catalogue->quantite }} == 0) {
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
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">500</h1>
                                    <span class="text-white">Membres de l’équipe</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-award fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">70</h1>
                                    <span class="text-white">Prix et distinctions</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-list-check fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">3000</h1>
                                    <span class="text-white">Projets réalisés</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="text-center bg-success py-5 px-4 h-100">
                                    <i class="fa fa-comments fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">7000</h1>
                                    <span class="text-white">Avis des membres</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-success pe-3">Pourquoi nous ?</p>
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">Pourquoi choisir Colibri Littéraire ?</h1>
                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">Pour la qualité de nos formations, la force de notre
                        réseau et notre engagement pour la culture africaine. Rejoignez une communauté dynamique et
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
                <h1 class="display-6 mb-4">Empruntez nos livres africains pour la lecture</h1>
            </div>
            <div class="row g-4">
                @foreach ($Bibliotheques as $livre)
                    @if ($livre->type_categorie === 'emprunt')
                        <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                            <div class="catalogue-item card h-100 border-0 shadow-lg"
                                style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                                <img class="card-img-top" src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}"
                                    style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
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
                                    <p class="mb-2 d-flex align-items-center"
                                        style="color: #6d838fff; font-size: 1.05rem;">
                                        <i class="fa fa-star" style="color: #FFAC00; margin-right: 0.5em;"></i>
                                        <span style="text-align: justify; display: block;">
                                            {{ Str::limit(strip_tags($livre->resumer), 100) }}
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

    <!-- Newsletter Start -->
    <div class="container-fluid bg-success py-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-6 text-white mb-4">Subscribe the Newsletter</h1>
                    <h1 class="display-6 text-white mb-4">Abonnez-vous à la newsletter</h1>
                    <div class="position-relative w-100 mb-2">
                        <input class="form-control border-0 w-100 ps-4 pe-5" type="text" placeholder="Votre email"
                            style="height: 60px;">
                        <button type="button"
                            class="btn btn-lg-square shadow-none position-absolute top-0 end-0 mt-2 me-2"><i
                                class="fa fa-paper-plane text-success fs-4"></i></button>
                    </div>
                    <p class="mb-0 text-white">Recevez nos actualités, nouvelles formations et offres spéciales sur le
                        livre
                        africain.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter End -->

@endsection
