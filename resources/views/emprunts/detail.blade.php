@extends('layouts.app')

@section('title', 'Détails de l\'emprunt - ' . $emprunt->livre->titre)

@section('content')
@include('partials.notifications')

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('account.profil') }}">Mon Profil</a></li>
            <li class="breadcrumb-item"><a href="{{ route('emprunts.mes-emprunts') }}">Mes Emprunts</a></li>
            <li class="breadcrumb-item active" aria-current="page">Détails</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Informations sur le livre -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                @if($emprunt->livre->image)
                    <img src="{{ asset($emprunt->livre->image) }}" class="card-img-top" alt="{{ $emprunt->livre->titre }}" style="max-height: 400px; object-fit: contain;">
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fa fa-book fa-5x"></i>
                    </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $emprunt->livre->titre }}</h5>
                    @if($emprunt->livre->auteur)
                        <p class="text-muted mb-2">
                            <i class="fa fa-user me-1"></i>{{ $emprunt->livre->auteur }}
                        </p>
                    @endif
                    @if($emprunt->livre->editeur)
                        <p class="text-muted mb-2">
                            <i class="fa fa-building me-1"></i>{{ $emprunt->livre->editeur }}
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Détails de l'emprunt -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fa fa-info-circle me-2"></i>Informations de l'emprunt
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Statut -->
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Statut:</div>
                        <div class="col-sm-8">
                            @if($emprunt->statut === 'en_attente')
                                <span class="badge bg-warning text-dark fs-6">
                                    <i class="fa fa-clock me-1"></i>En attente de validation
                                </span>
                            @elseif($emprunt->statut === 'en_cours')
                                <span class="badge bg-success fs-6">
                                    <i class="fa fa-check-circle me-1"></i>En cours
                                </span>
                            @elseif($emprunt->statut === 'en_retard')
                                <span class="badge bg-danger fs-6">
                                    <i class="fa fa-exclamation-triangle me-1"></i>En retard
                                </span>
                            @elseif($emprunt->statut === 'retourne')
                                <span class="badge bg-secondary fs-6">
                                    <i class="fa fa-check-double me-1"></i>Retourné
                                </span>
                            @elseif($emprunt->statut === 'rejete')
                                <span class="badge bg-danger fs-6">
                                    <i class="fa fa-times-circle me-1"></i>Rejeté
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <!-- Date d'emprunt -->
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Date d'emprunt:</div>
                        <div class="col-sm-8">
                            <i class="fa fa-calendar me-1"></i>
                            {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}
                        </div>
                    </div>

                    <!-- Date de retour prévue -->
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Date de retour prévue:</div>
                        <div class="col-sm-8">
                            <i class="fa fa-calendar-check me-1"></i>
                            {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}
                            @php
                                $joursRestants = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($emprunt->date_retour), false);
                            @endphp
                            @if($emprunt->statut === 'en_cours')
                                @if($joursRestants > 0)
                                    <span class="badge bg-info ms-2">{{ $joursRestants }} jour(s) restant(s)</span>
                                @elseif($joursRestants === 0)
                                    <span class="badge bg-warning text-dark ms-2">Retour aujourd'hui</span>
                                @else
                                    <span class="badge bg-danger ms-2">Retard de {{ abs($joursRestants) }} jour(s)</span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Date de validation -->
                    @if($emprunt->valide_le)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Validé le:</div>
                            <div class="col-sm-8">
                                <i class="fa fa-check me-1"></i>
                                {{ \Carbon\Carbon::parse($emprunt->valide_le)->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    @endif

                    <!-- Date de retour effective -->
                    @if($emprunt->statut === 'retourne' && $emprunt->date_retour_effectif)
                        <div class="row mb-3">
                            <div class="col-sm-4 fw-bold">Retourné le:</div>
                            <div class="col-sm-8">
                                <i class="fa fa-undo me-1"></i>
                                {{ \Carbon\Carbon::parse($emprunt->date_retour_effectif)->format('d/m/Y à H:i') }}
                            </div>
                        </div>
                    @endif

                    <!-- Commentaire de rejet -->
                    @if($emprunt->statut === 'rejete' && $emprunt->commentaire_rejet)
                        <hr>
                        <div class="alert alert-danger">
                            <strong><i class="fa fa-info-circle me-2"></i>Raison du rejet:</strong>
                            <p class="mb-0 mt-2">{{ $emprunt->commentaire_rejet }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions disponibles -->
            @if($emprunt->statut === 'en_attente')
                <div class="card shadow-sm border-warning">
                    <div class="card-body">
                        <h6 class="text-warning">
                            <i class="fa fa-hourglass-half me-2"></i>Demande en attente de validation
                        </h6>
                        <p class="text-muted mb-0">
                            Votre demande d'emprunt sera examinée par un administrateur dans les plus brefs délais.
                        </p>
                    </div>
                </div>
            @elseif($emprunt->statut === 'en_cours')
                <div class="card shadow-sm border-success">
                    <div class="card-body">
                        <h6 class="text-success">
                            <i class="fa fa-book-reader me-2"></i>Emprunt en cours
                        </h6>
                        <p class="text-muted">
                            N'oubliez pas de retourner le livre avant le {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}.
                        </p>
                        @if($joursRestants < 3 && $joursRestants >= 0)
                            <div class="alert alert-warning mb-0">
                                <i class="fa fa-exclamation-triangle me-2"></i>
                                <strong>Rappel:</strong> La date de retour approche !
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($emprunt->statut === 'en_retard')
                <div class="card shadow-sm border-danger">
                    <div class="card-body">
                        <h6 class="text-danger">
                            <i class="fa fa-exclamation-triangle me-2"></i>Emprunt en retard
                        </h6>
                        <p class="text-muted mb-0">
                            Merci de retourner le livre au plus vite. Contactez-nous si vous avez besoin d'une prolongation.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Bouton retour -->
            <div class="mt-4">
                <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-outline-primary">
                    <i class="fa fa-arrow-left me-2"></i>Retour à mes emprunts
                </a>
                <a href="{{ route('emprunts.index') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-book me-2"></i>Parcourir la bibliothèque
                </a>
            </div>
        </div>
    </div>

    <!-- Description du livre -->
    @if($emprunt->livre->description)
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fa fa-align-left me-2"></i>Description du livre
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $emprunt->livre->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
