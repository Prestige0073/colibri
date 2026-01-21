@extends('layouts.app')

@section('title', $catalogue->titre ?? 'Détails du livre')

@section('content')
<!-- En-tête avec breadcrumb -->
<div class="container-fluid bg-primary py-5 mb-5">
    <div class="container py-5">
        <div class="row align-items-center py-4">
            <div class="col-md-12 text-center">
                <h1 class="display-4 text-white mb-3">Détails du Livre</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-white">Accueil</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('catalogue.index') }}" class="text-white">Catalogue</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">{{ $catalogue->titre }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Détails du livre -->
<div class="container py-5">
    <div class="row g-5">
        <!-- Image et badges -->
        <div class="col-lg-5">
            <div class="position-relative">
                <img src="{{ $catalogue->image ? '/' . $catalogue->image : '/img/default-book.jpg' }}"
                     alt="{{ $catalogue->titre }}"
                     class="img-fluid rounded shadow-lg w-100"
                     style="max-height: 600px; object-fit: cover;">

                <!-- Badges -->
                <div class="position-absolute top-0 end-0 m-3">
                    @if($catalogue->type_categorie === 'catalogue')
                        <span class="badge bg-info fs-6 mb-2 d-block">À Découvrir</span>
                    @else
                        <span class="badge bg-success fs-6 mb-2 d-block">À Emprunter</span>
                    @endif

                    @if($catalogue->quantite > 0)
                        <span class="badge bg-success fs-6 d-block">
                            <i class="fas fa-check-circle me-1"></i> Disponible
                        </span>
                    @else
                        <span class="badge bg-danger fs-6 d-block">
                            <i class="fas fa-times-circle me-1"></i> Épuisé
                        </span>
                    @endif
                </div>

            </div>
        </div>

        <!-- Informations du livre -->
        <div class="col-lg-7">
            <div class="h-100 d-flex flex-column">
                <!-- Titre -->
                <h1 class="display-5 fw-bold text-primary mb-3">{{ $catalogue->titre }}</h1>

                <!-- Auteur et catégorie -->
                <div class="mb-4">
                    <p class="text-muted fs-5 mb-2">
                        <i class="fas fa-user text-primary me-2"></i>
                        <strong>Auteur:</strong> {{ $catalogue->auteur ?? 'Auteur inconnu' }}
                    </p>
                    <p class="text-muted fs-5 mb-2">
                        <i class="fas fa-tag text-primary me-2"></i>
                        <strong>Catégorie:</strong> {{ $catalogue->categorie ?? 'Non classé' }}
                    </p>
                </div>

                <!-- Prix -->
                <div class="mb-4">
                    <h2 class="text-primary fw-bold">
                        <i class="fas fa-tag me-2"></i>{{ $catalogue->prix ? number_format($catalogue->prix, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}
                    </h2>
                </div>

                <!-- Résumé -->
                @if($catalogue->resumer)
                <div class="mb-4">
                    <h4 class="fw-bold mb-3">
                        <i class="fas fa-book-open text-primary me-2"></i>Résumé
                    </h4>
                    <div class="text-muted fs-6 lh-lg" style="text-align: justify;">
                        {!! nl2br(strip_tags($catalogue->resumer, '<p><br><strong><em><ul><ol><li>')) !!}
                    </div>
                </div>
                @endif

                <!-- Boutons d'action -->
                <div class="mt-auto">
                    <div class="d-grid gap-3">
                        @if($catalogue->quantite > 0)
                            @if($catalogue->type_categorie === 'catalogue')
                                <a href="#" class="btn btn-primary btn-lg py-3">
                                    <i class="fas fa-shopping-cart me-2"></i>Ajouter au Panier
                                </a>
                            @else
                                <a href="#" class="btn btn-success btn-lg py-3">
                                    <i class="fas fa-book-reader me-2"></i>Emprunter ce Livre
                                </a>
                            @endif
                        @else
                            <button class="btn btn-secondary btn-lg py-3" disabled>
                                <i class="fas fa-exclamation-circle me-2"></i>Actuellement Indisponible
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Livres similaires -->
    @if($livresSimilaires->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="fw-bold mb-4">
                <i class="fas fa-books text-primary me-2"></i>Livres Similaires
            </h3>
        </div>

        @foreach($livresSimilaires as $livre)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0 hover-card">
                <div class="position-relative">
                    <img src="{{ $livre->image ? '/' . $livre->image : '/img/default-book.jpg' }}"
                         class="card-img-top"
                         alt="{{ $livre->titre }}"
                         style="height: 300px; object-fit: cover;">
                    <span class="badge bg-{{ $livre->type_categorie === 'catalogue' ? 'info' : 'success' }} position-absolute top-0 end-0 m-2">
                        {{ $livre->type_categorie === 'catalogue' ? 'À découvrir' : 'À emprunter' }}
                    </span>
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold text-truncate" title="{{ $livre->titre }}">
                        {{ $livre->titre }}
                    </h5>
                    <p class="text-muted small mb-2">
                        <i class="fas fa-user me-1"></i>{{ $livre->auteur ?? 'Auteur inconnu' }}
                    </p>
                    <p class="text-primary fw-bold mb-3">
                        {{ $livre->prix ? number_format($livre->prix, 0, ',', ' ') . ' FCFA' : 'Gratuit' }}
                    </p>
                    <a href="{{ route('catalogue.show', $livre->id) }}" class="btn btn-primary w-100 mt-auto">
                        <i class="fas fa-eye me-2"></i>Voir détails
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<style>
.hover-card {
    transition: all 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
}

.breadcrumb-item a:hover {
    text-decoration: underline;
}

.btn-lg {
    font-size: 1.1rem;
}
</style>
@endsection
