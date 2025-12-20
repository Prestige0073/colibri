@extends('layouts.app')

@section('title', $livre->titre . ' - Détails')

@section('content')
@include('partials.notifications')

<div class="container py-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('emprunts.index') }}">Bibliothèque</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $livre->titre }}</li>
        </ol>
    </nav>

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
                        @if($enAttente)
                            <div class="alert alert-warning mb-3">
                                <i class="fa fa-clock me-2"></i>Votre demande d'emprunt est en attente de validation
                            </div>
                            <button class="btn btn-warning btn-lg w-100 mb-2" disabled>
                                <i class="fa fa-hourglass-half me-2"></i>En attente de validation
                            </button>
                            <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-outline-primary w-100">
                                <i class="fa fa-list me-2"></i>Voir Mes Emprunts
                            </a>
                        @elseif($dejaEmprunte)
                            @php
                                // Récupérer l'emprunt actif pour vérifier s'il est validé
                                $empruntActif = \App\Models\Emprunt::where('user_id', auth()->id())
                                    ->where('livre_id', $livre->id)
                                    ->whereIn('statut', ['en_cours', 'en_retard'])
                                    ->first();
                            @endphp

                            @if($empruntActif && $empruntActif->valide_le)
                                <div class="alert alert-success mb-3">
                                    <i class="fa fa-check-circle me-2"></i>Vous avez emprunté ce livre (validé)
                                    @if($empruntActif->access_expires_at)
                                        <div class="mt-2">
                                            <strong>Temps d'accès restant:</strong>
                                            <div class="countdown-timer badge bg-info text-dark d-inline-block" data-expires="{{ $empruntActif->access_expires_at->toIso8601String() }}">
                                                <i class="fa fa-clock me-1"></i>
                                                <span class="countdown-text">Calcul...</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if($livre->pdf)
                                    @if($empruntActif->access_expires_at && now()->greaterThan($empruntActif->access_expires_at))
                                        <button class="btn btn-secondary btn-lg w-100 mb-2" disabled>
                                            <i class="fa fa-lock me-2"></i>Accès expiré
                                        </button>
                                    @else
                                        <a href="{{ route('secure-pdf.view', $livre->id) }}" class="btn btn-success btn-lg w-100 mb-2">
                                            <i class="fa fa-book-reader me-2"></i>Lire le PDF
                                        </a>
                                    @endif
                                @endif

                                <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-outline-primary w-100">
                                    <i class="fa fa-list me-2"></i>Voir Mes Emprunts
                                </a>
                            @else
                                <div class="alert alert-info mb-3">
                                    <i class="fa fa-info-circle me-2"></i>Vous avez emprunté ce livre
                                </div>
                                <a href="{{ route('emprunts.mes-emprunts') }}" class="btn btn-primary w-100">
                                    <i class="fa fa-list me-2"></i>Voir Mes Emprunts
                                </a>
                            @endif
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Countdown timer function
        function updateCountdowns() {
            const timers = document.querySelectorAll('.countdown-timer');
            const now = new Date();

            timers.forEach(timer => {
                const expiresAt = new Date(timer.getAttribute('data-expires'));
                const textElement = timer.querySelector('.countdown-text');

                const diff = expiresAt - now;

                if (diff <= 0) {
                    textElement.textContent = 'Expiré';
                    timer.classList.remove('bg-info', 'bg-warning');
                    timer.classList.add('bg-danger', 'text-white');

                    // Reload page to update UI when expired
                    setTimeout(() => location.reload(), 2000);
                } else {
                    const hours = Math.floor(diff / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    textElement.textContent = `${hours}h ${minutes}m ${seconds}s`;

                    // Change color based on remaining time
                    if (hours < 1) {
                        timer.classList.remove('bg-info');
                        timer.classList.add('bg-danger', 'text-white');
                    } else if (hours < 2) {
                        timer.classList.remove('bg-info');
                        timer.classList.add('bg-warning');
                    }
                }
            });
        }

        // Update immediately
        updateCountdowns();

        // Update every second
        setInterval(updateCountdowns, 1000);
    });
</script>
@endpush

@endsection
