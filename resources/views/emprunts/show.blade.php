@extends('layouts.app')

@section('title', $livre->titre . ' - Détails')

@section('content')
<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('emprunts.index') }}">Bibliothèque</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $livre->titre }}</li>
        </ol>
    </nav>

    <!-- Toast notifications -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Image du livre -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                @if($livre->image)
                    <img src="{{ asset($livre->image) }}" class="card-img-top" alt="{{ $livre->titre }}" style="max-height: 500px; object-fit: contain;">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 500px;">
                        <i class="fa fa-book fa-5x"></i>
                    </div>
                @endif
                <div class="card-body text-center">
                    <!-- Disponibilité -->
                    @if($livre->quantite > 0)
                        <span class="badge bg-success fs-6 mb-3">
                            <i class="fa fa-check-circle me-1"></i>{{ $livre->quantite }} exemplaire(s) disponible(s)
                        </span>
                    @else
                        <span class="badge bg-danger fs-6 mb-3">
                            <i class="fa fa-times-circle me-1"></i>Indisponible
                        </span>
                    @endif

                    <!-- Boutons d'action -->
                    @auth
                        @if($dejaEmprunte)
                            <div class="alert alert-warning mb-3">
                                <i class="fa fa-info-circle me-2"></i>Vous avez déjà emprunté ce livre
                            </div>
                            <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-primary w-100">
                                <i class="fa fa-list me-2"></i>Voir Mes Emprunts
                            </a>
                        @else
                            @if($livre->quantite > 0)
                                <form action="{{ route('emprunts.demander') }}" method="POST" class="mb-3">
                                    @csrf
                                    <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                    <button type="submit" class="btn btn-success btn-lg w-100">
                                        <i class="fa fa-hand-holding me-2"></i>Emprunter ce Livre
                                    </button>
                                </form>
                                <small class="text-muted">Durée: 14 jours</small>
                            @else
                                <button class="btn btn-secondary btn-lg w-100" disabled>
                                    <i class="fa fa-ban me-2"></i>Actuellement Indisponible
                                </button>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-warning btn-lg w-100 mb-2">
                            <i class="fa fa-sign-in-alt me-2"></i>Connexion pour Emprunter
                        </a>
                        <small class="text-muted d-block">Créez un compte gratuitement</small>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Détails du livre -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0 text-white">{{ $livre->titre }}</h2>
                </div>
                <div class="card-body">
                    <!-- Informations principales -->
                    <div class="mb-4">
                        <h5 class="text-primary mb-3"><i class="fa fa-info-circle me-2"></i>Informations</h5>
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-bold" style="width: 30%;"><i class="fa fa-user-pen me-2 text-primary"></i>Auteur</td>
                                    <td>{{ $livre->auteur }}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold"><i class="fa fa-tags me-2 text-primary"></i>Catégorie</td>
                                    <td><span class="badge bg-info">{{ $livre->categorie }}</span></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold"><i class="fa fa-book me-2 text-primary"></i>Type</td>
                                    <td><span class="badge bg-secondary">Livre d'Emprunt</span></td>
                                </tr>
                                @if($livre->prix > 0)
                                <tr>
                                    <td class="fw-bold"><i class="fa fa-money-bill-wave me-2 text-primary"></i>Caution</td>
                                    <td>{{ number_format($livre->prix, 0, ',', ' ') }} FCFA</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Résumé -->
                    @if($livre->resumer)
                        <div class="mb-4">
                            <h5 class="text-primary mb-3"><i class="fa fa-align-left me-2"></i>Résumé</h5>
                            <div class="text-justify">
                                {!! nl2br(e($livre->resumer)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Conditions d'emprunt -->
                    <div class="alert alert-info">
                        <h6 class="alert-heading"><i class="fa fa-book-reader me-2"></i>Conditions d'emprunt</h6>
                        <ul class="mb-0">
                            <li>Durée d'emprunt : <strong>14 jours</strong></li>
                            <li>Gratuit pour tous les membres inscrits</li>
                            <li>Un seul exemplaire par utilisateur à la fois</li>
                            <li>Prolongation possible sur demande (si disponible)</li>
                            <li>Retour à effectuer avant la date limite</li>
                        </ul>
                    </div>

                    <!-- Boutons en bas -->
                    <div class="mt-4">
                        <a href="{{ route('emprunts.index') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left me-2"></i>Retour à la bibliothèque
                        </a>

                        @if($livre->pdf)
                            <a href="{{ asset($livre->pdf) }}" target="_blank" class="btn btn-outline-danger">
                                <i class="fa fa-file-pdf me-2"></i>Aperçu PDF
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
