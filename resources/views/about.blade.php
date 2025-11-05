@extends('layouts.app')

@section('title', 'À propos | Colibri Littéraire - Notre mission, valeurs et équipe')
@section('meta_description',
    "Découvrez la mission, les valeurs et l'équipe de Colibri Littéraire, plateforme dédiée à
    la formation et à la promotion du livre africain.")
@section('meta_keywords',
    'à propos, livre africain, équipe, mission, valeurs, formation, Colibri Littéraire, culture,
    édition, francophonie')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">À propos de Colibri Littéraire</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('index') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a class="text-muted" href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">À propos</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


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
                        <h3 class="ms-5 mb-0 text-white">Ensemble, nous construisons un avenir où chaque
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
                        <div class="row g-4 pt-2">
                            <div class="" data-wow-delay="0.4s">
                                <div class="h-100">
                                    <h3>Nos offres</h3>
                                    <p>Pour faire rayonner le livre africain, nous agissons sur deux indicateurs importants
                                        : la
                                        formation continue et la facilitation de la circulation des productions locales à
                                        travers :</p>
                                    <p class="text-dark"><i class="fa fa-check text-success me-2"></i>Formations
                                        spécialisées et certifiantes gratuites</p>
                                    <p class="text-dark"><i class="fa fa-check text-success me-2"></i>Achat et prêt de
                                        livres africains</p>
                                    <p class="text-dark"><i class="fa fa-check text-success me-2"></i>Conseils et
                                        accompagnements personnalisés aux professionnels du livre africain</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-success pe-3">À propos</p>
                    <h1 class="display-6 wow fadeIn" data-wow-delay="0.2s">Ce sont les actions de chaque colibri
                        littéraire qui feront rayonner le livre
                        africain à travers le monde</h1>
                    <p class="mb-4 wow fadeIn" data-wow-delay="0.3s">Colibri Littéraire est une initiative de l’ONG
                        Ecrivains Humanistes du Bénin, avec l’appui
                        technique des Editions Encres Universelles et le soutien de l’Organisation internationale de la
                        Francophonie (OIF) dans le cadre du dispositif "FORCE - Formation et renforcement de
                        compétences en édition".</p>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->

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
                                    <h1 class="display-5 mb-0 text-white" data-toggle="counter-up">500</h1>
                                    <span class="text-white">Membres de l'équipe</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-award fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">70</h1>
                                    <span class="text-white">Award Winning</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                                <div class="text-center bg-secondary py-5 px-4 h-100">
                                    <i class="fa fa-list-check fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 text-white mb-0" data-toggle="counter-up">3000</h1>
                                    <span class="text-white">Total Projects</span>
                                </div>
                            </div>
                            <div class="col-sm-6 wow fadeIn" data-wow-delay="0.7s">
                                <div class="text-center bg-success py-5 px-4 h-100">
                                    <i class="fa fa-comments fa-3x text-white mb-3"></i>
                                    <h1 class="display-5 mb-0 text-white" data-toggle="counter-up">7000</h1>
                                    <span class="text-white">Client's Review</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="section-title bg-white text-start text-success pe-3">Pourquoi Colibri Littéraire ?</p>
                    <h1 class="display-6 mb-4 wow fadeIn" data-wow-delay="0.2s">Pourquoi choisir notre plateforme ?</h1>
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
                        <a class="btn btn-success py-3 px-4 me-3" href="#">Voir les formations</a>
                        <a class="btn btn-secondary py-3 px-4" href="#">Accéder au catalogue</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->

    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mb-5 wow fadeIn" data-wow-delay="0.1s">
                <p class="section-title bg-white text-start text-success pe-3">Équipe</p>
                <h1 class="display-6">Notre équipe</h1>
                <p class="mx-auto" style="max-width:700px">Rencontrez les personnes qui portent Colibri Littéraire — des
                    coordinateurs, éditeurs, libraires et formateurs engagés à promouvoir le livre africain.</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item team-lead text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/camille.png') }}"
                                alt="Camille SEGNIGBINDE">
                        </div>
                        <h5 class="mb-1">Camille SEGNIGBINDE</h5>
                        <p class="text-muted">Coordonnateur - point focal Bénin</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.15s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/catira.png') }}"
                                alt="Catira DODO">
                        </div>
                        <h5 class="mb-1">Catira DODO</h5>
                        <p class="text-muted">Responsable en charge du curricula</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.2s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/prudentienne.jpg') }}"
                                alt="Prudentienne GBAGUIDI">
                        </div>
                        <h5 class="mb-1">Prudentienne GBAGUIDI</h5>
                        <p class="text-muted">Libraire – Formatrice</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.25s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/augustino.jpg') }}"
                                alt="Augustino AGBEMAVO">
                        </div>
                        <h5 class="mb-1">Augustino AGBEMAVO</h5>
                        <p class="text-muted">Libraire - Formateur</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/rodrigue.jpg') }}"
                                alt="Rodrigue ATCHAOUE">
                        </div>
                        <h5 class="mb-1">Rodrigue ATCHAOUE</h5>
                        <p class="text-muted">Éditeur – Formateur - Bénin</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.35s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/adele.png') }}"
                                alt="Adèle KIEMA">
                        </div>
                        <h5 class="mb-1">Adèle KIEMA</h5>
                        <p class="text-muted">Diffuseur – Formatrice – Point focal Niger</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/idrissa.jpg') }}"
                                alt="Idrissa SOW">
                        </div>
                        <h5 class="mb-1">Idrissa SOW</h5>
                        <p class="text-muted">Éditeur – Point focal Sénégal</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.45s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/yawavi.png') }}"
                                alt="Yawavi MBOUKE">
                        </div>
                        <h5 class="mb-1">Yawavi MBOUKE</h5>
                        <p class="text-muted">Libraire – Point focal Togo</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/vivien.png') }}"
                                alt="Vivien Zanou">
                        </div>
                        <h5 class="mb-1">Vivien Zanou</h5>
                        <p class="text-muted">Chargé de la Logistique</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-sm-6 wow fadeIn" data-wow-delay="0.55s">
                    <div class="team-item text-center p-4">
                        <div class="team-img mb-3">
                            <img class="img-fluid rounded-circle" src="{{ asset('img/team/corneille.png') }}"
                                alt="Corneille ANOUMON">
                        </div>
                        <h5 class="mb-1">Corneille ANOUMON</h5>
                        <p class="text-muted">Chargé de la Communication</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->

@endsection
