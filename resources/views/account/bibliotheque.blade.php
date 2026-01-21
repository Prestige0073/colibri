@extends('layouts.app')

@section('title', 'Ma Bibliothèque')
@section('meta_description', 'Accédez à tous vos livres achetés sur Colibri Littéraire.')

@section('content')
    @include('partials.notifications')

    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h1 class="display-5 fw-bold text-success mb-2">
                            <i class="fa fa-book me-3"></i>Ma Bibliothèque
                        </h1>
                        <p class="text-muted mb-0">Tous vos livres achetés disponibles en lecture sécurisée</p>
                    </div>
                    <a href="{{ route('account.profil') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="fa fa-arrow-left me-2"></i>Retour au profil
                    </a>
                </div>
            </div>
        </div>

        @if($livresAchetes->isEmpty())
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm text-center py-5">
                        <div class="card-body">
                            <i class="fa fa-book-open fa-5x text-muted mb-4"></i>
                            <h3 class="text-muted mb-3">Votre bibliothèque est vide</h3>
                            <p class="text-muted mb-4">Vous n'avez pas encore acheté de livres.</p>
                            <a href="{{ route('catalogue.decouvrir') }}" class="btn btn-success rounded-pill px-4">
                                <i class="fa fa-shopping-cart me-2"></i>Découvrir le catalogue
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row mb-3">
                <div class="col-12">
                    <div class="alert alert-info border-0 shadow-sm">
                        <i class="fa fa-info-circle me-2"></i>
                        <strong>{{ $livresAchetes->count() }}</strong> livre(s) dans votre bibliothèque
                    </div>
                </div>
            </div>

            <div class="row g-4">
                @foreach($livresAchetes as $livre)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 border-0 shadow-sm hover-lift transition-smooth">
                            @if($livre->image)
                                <img src="{{ asset($livre->image) }}"
                                     class="card-img-top"
                                     alt="{{ $livre->titre }}"
                                     style="height: 300px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-gradient d-flex align-items-center justify-content-center"
                                     style="height: 300px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    <i class="fa fa-book fa-5x text-white opacity-50"></i>
                                </div>
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark mb-2">{{ $livre->titre }}</h5>

                                @if($livre->auteur)
                                    <p class="text-muted small mb-2">
                                        <i class="fa fa-user me-1"></i>{{ $livre->auteur }}
                                    </p>
                                @endif

                                @if($livre->categorie)
                                    <span class="badge bg-success mb-3">{{ $livre->categorie }}</span>
                                @endif

                                @if($livre->resumer)
                                    <p class="card-text text-muted small mb-3" style="flex-grow: 1;">
                                        {{ Str::limit(strip_tags($livre->resumer), 120) }}
                                    </p>
                                @endif

                                <div class="mt-auto">
                                    @if($livre->pdf)
                                        <a href="{{ route('bibliotheque.lire', $livre->id) }}"
                                           class="btn btn-success w-100 rounded-pill">
                                            <i class="fa fa-book-open me-2"></i>Lire maintenant
                                        </a>
                                    @else
                                        <button class="btn btn-secondary w-100 rounded-pill" disabled>
                                            <i class="fa fa-exclamation-circle me-2"></i>PDF indisponible
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer bg-light border-0 text-center">
                                <small class="text-success">
                                    <i class="fa fa-check-circle me-1"></i>Acheté et disponible à vie
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
        }

        .transition-smooth {
            transition: all 0.3s ease;
        }
    </style>
@endsection
