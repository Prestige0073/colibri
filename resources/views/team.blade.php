@extends('layouts.app')

@section('title', 'Notre équipe | Colibri Littéraire - Membres et partenaires')
@section('meta_description', "Découvrez l'équipe engagée de Colibri Littéraire, ses membres, partenaires et bénévoles au service du livre africain.")
@section('meta_keywords', 'équipe, membres, partenaires, bénévoles, Colibri Littéraire, livre africain, culture, formation, édition, francophonie')

@section('content')
    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Notre Équipe</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Équipe</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Video Start -->
    <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-0">
                <div class="col-lg-11">
                    <div class="h-100 py-5 d-flex align-items-center">
                        <button type="button" class="btn-play" data-bs-toggle="modal"
                            data-src="https://www.youtube.com/embed/DWRcNpR6Kdc" data-bs-target="#videoModal">
                            <span></span>
                        </button>
                        <h3 class="ms-5 mb-0">Ensemble, faisons grandir la communauté littéraire.</h3>
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
                    <h5 class="modal-title" id="exampleModalLabel">Youtube Video</h5>
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


    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Équipe</p>
                <h1 class="display-6 mb-4">Découvrez les membres passionnés de Colibri Littéraire</h1>
            </div>
            <div class="row g-4">
                @forelse($membres as $index => $membre)
                    <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="{{ 0.1 + ($index % 3) * 0.2 }}s">
                        <div class="team-item d-flex h-100 p-4">
                            <div class="team-detail pe-4">
                                @if($membre->photo)
                                    @if(str_starts_with($membre->photo, 'http') || str_starts_with($membre->photo, 'img/'))
                                        <img class="img-fluid mb-4" src="{{ asset($membre->photo) }}" alt="{{ $membre->nom }}">
                                    @else
                                        <img class="img-fluid mb-4" src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom }}">
                                    @endif
                                @else
                                    <img class="img-fluid mb-4" src="{{ asset('img/team-default.jpg') }}" alt="{{ $membre->nom }}">
                                @endif
                                <h3>{{ $membre->nom }}</h3>
                                <span>{{ $membre->poste }}</span>
                                @if($membre->bio)
                                    <p class="mt-3 text-muted small">{{ Str::limit($membre->bio, 100) }}</p>
                                @endif
                            </div>
                            <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                                @if($membre->facebook)
                                    <a class="btn btn-square btn-primary my-2" href="{{ $membre->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if($membre->twitter)
                                    <a class="btn btn-square btn-primary my-2" href="https://twitter.com/{{ ltrim($membre->twitter, '@') }}" target="_blank"><i class="fab fa-x-twitter"></i></a>
                                @endif
                                @if($membre->linkedin)
                                    <a class="btn btn-square btn-primary my-2" href="{{ $membre->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                                @endif
                                @if($membre->email)
                                    <a class="btn btn-square btn-primary my-2" href="mailto:{{ $membre->email }}"><i class="fas fa-envelope"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aucun membre de l'équipe pour le moment</p>
                    </div>
                @endforelse
            </div>

            <!-- Ancienne section - à retirer après vérification
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="{{ asset('img/team-1.jpg') }}" alt="">
                            <h3>Élodie Martin</h3>
                            <span>Fondatrice & Présidente</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="team-item d-flex h-100 p-4">
                        <div class="team-detail pe-4">
                            <img class="img-fluid mb-4" src="{{ asset('img/team-3.jpg') }}" alt="">
                            <h3>Fatima Benali</h3>
                            <span>Bénévole</span>
                        </div>
                        <div class="team-social bg-light d-flex flex-column justify-content-center flex-shrink-0 p-4">
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-x-twitter"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i
                                    class="fab fa-instagram"></i></a>
                            <a class="btn btn-square btn-primary my-2" href="#!"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


@endsection
