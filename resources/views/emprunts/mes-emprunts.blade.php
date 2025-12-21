@extends('layouts.app')

@section('title', 'Mes Emprunts')

@section('content')
    @include('partials.notifications')

    <!-- Hero similaire au catalogue -->
    <header class="hero-section text-white py-5" style="background: linear-gradient(135deg,#16a34a,#059669);">
        <div class="container">
            <div class="d-md-flex align-items-center gap-4">
                <div class="flex-grow-1">
                    <h1 class="h2 fw-bold mb-2 d-flex align-items-center gap-3">
                        <span
                            class="hero-icon bg-white text-success rounded-circle d-inline-flex align-items-center justify-content-center"
                            style="width:48px;height:48px;">
                            <i class="fas fa-list-check"></i>
                        </span>
                        Mes Emprunts
                    </h1>
                    <p class="lead text-white-75 mb-3">Consultez vos emprunts en cours, les retards et votre historique.</p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('emprunts.index') }}" class="btn btn-light btn-lg shadow-sm"
                            aria-label="Retour à la bibliothèque">
                            <i class="fas fa-arrow-left me-2 text-success"></i>Retour à la bibliothèque
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container py-5" role="main">

        <!-- Section 1: Demandes en attente de validation -->
        @if ($empruntsEnAttente->isNotEmpty())
        <section class="mb-5">
            <div class="section-header warning mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-clock text-warning"></i>
                <h3 class="mb-0">Demandes en attente de validation ({{ $empruntsEnAttente->count() }})</h3>
            </div>

            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Ces demandes sont en attente de validation par un administrateur. Vous pourrez lire les PDFs une fois validées.
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($empruntsEnAttente as $emprunt)
                <article class="col">
                    <div class="card h-100 book-card border-warning" tabindex="0">
                        <div class="book-image-wrapper position-relative"
                            style="height:240px; overflow:hidden; background:linear-gradient(135deg,#f5f7fa,#c3cfe2);">
                            <!-- Badge en attente -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-clock me-1"></i>En attente
                                </span>
                            </div>

                            @if ($emprunt->livre && $emprunt->livre->image)
                            <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}"
                                class="card-img-top" loading="lazy"
                                style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h3 class="h6 mb-1">{{ $emprunt->livre->titre ?? 'N/A' }}</h3>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user-pen me-1 text-warning"></i>{{ $emprunt->livre->auteur ?? 'N/A' }}
                            </p>

                            <div class="text-muted small mb-3">
                                <div><strong>Demandé le:</strong> {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</div>
                                <div><strong>Retour prévu:</strong> {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</div>
                            </div>

                            <div class="mt-auto d-grid gap-2">
                                <button class="btn btn-warning btn-sm" disabled>
                                    <i class="fas fa-hourglass-half me-1"></i>En attente de validation
                                </button>
                                <a href="{{ route('emprunts.show', $emprunt->livre->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-info-circle me-1"></i>Détails
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Section 2: Emprunts validés et en cours -->
        <section class="mb-5">
            <div class="section-header active mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-book-open text-success"></i>
                <h3 class="mb-0">Emprunts en cours ({{ $empruntsActifs->count() }})</h3>
            </div>

            @if ($empruntsActifs->isEmpty())
            <div class="empty-state text-center py-5 bg-white rounded-3 shadow-sm">
                <i class="fas fa-book-open fa-4x text-muted mb-3" aria-hidden="true"></i>
                <h3 class="h5 text-muted">Aucun emprunt validé en cours</h3>
                <p class="text-muted">Explorez la bibliothèque pour emprunter des livres.</p>
                <a href="{{ route('emprunts.index') }}" class="btn btn-success mt-3">Parcourir la bibliothèque</a>
            </div>
            @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($empruntsActifs as $emprunt)
                <article class="col">
                    <div class="card h-100 book-card border-success" tabindex="0">
                        <div class="book-image-wrapper position-relative"
                            style="height:240px; overflow:hidden; background:linear-gradient(135deg,#f5f7fa,#c3cfe2);">
                            <!-- Badge validé -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Validé
                                </span>
                            </div>

                            @if ($emprunt->livre && $emprunt->livre->image)
                            <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}"
                                class="card-img-top" loading="lazy"
                                style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h3 class="h6 mb-1">{{ $emprunt->livre->titre ?? 'N/A' }}</h3>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user-pen me-1 text-success"></i>{{ $emprunt->livre->auteur ?? 'N/A' }}
                            </p>

                            <div class="text-muted small mb-3">
                                <div><strong>Emprunté:</strong> {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</div>
                                <div><strong>Retour prévu:</strong> {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</div>
                                @if($emprunt->access_expires_at)
                                    <div class="mt-2">
                                        <strong>Temps d'accès restant:</strong>
                                        <div class="countdown-timer badge bg-success text-white" data-expires="{{ $emprunt->access_expires_at->toIso8601String() }}">
                                            <i class="fas fa-clock me-1"></i>
                                            <span class="countdown-text">Calcul...</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto d-grid gap-2">
                                @if($emprunt->livre && $emprunt->livre->pdf)
                                    @if($emprunt->access_expires_at && now()->greaterThan($emprunt->access_expires_at))
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-lock me-1"></i>Accès expiré
                                        </button>
                                    @else
                                        <a href="{{ route('secure-pdf.view', $emprunt->livre->id) }}" class="btn btn-success btn-sm">
                                            <i class="fas fa-book-reader me-1"></i>Lire le PDF
                                        </a>
                                    @endif
                                @endif
                                <a href="{{ route('emprunts.show', $emprunt->livre->id) }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-info-circle me-1"></i>Détails
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
            @endif
        </section>

        <!-- Section 3: Emprunts en retard -->
        @if ($empruntsRetard->isNotEmpty())
        <section class="mb-5">
            <div class="section-header danger mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-exclamation-triangle text-danger"></i>
                <h3 class="mb-0">Emprunts en retard ({{ $empruntsRetard->count() }})</h3>
            </div>

            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Ces emprunts sont en retard. Veuillez contacter l'administration pour régulariser votre situation.
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($empruntsRetard as $emprunt)
                <article class="col">
                    <div class="card h-100 book-card border-danger" tabindex="0">
                        <div class="book-image-wrapper position-relative"
                            style="height:240px; overflow:hidden; background:linear-gradient(135deg,#f5f7fa,#c3cfe2);">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-danger">
                                    <i class="fas fa-exclamation-circle me-1"></i>En retard
                                </span>
                            </div>

                            @if ($emprunt->livre && $emprunt->livre->image)
                            <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}"
                                class="card-img-top" loading="lazy"
                                style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h3 class="h6 mb-1">{{ $emprunt->livre->titre ?? 'N/A' }}</h3>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user-pen me-1 text-danger"></i>{{ $emprunt->livre->auteur ?? 'N/A' }}
                            </p>

                            <div class="text-muted small mb-3">
                                <div><strong>Emprunté:</strong> {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</div>
                                <div class="text-danger"><strong>Devait être retourné le:</strong> {{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</div>
                                @if($emprunt->access_expires_at)
                                    <div class="mt-2">
                                        <strong>Temps d'accès restant:</strong>
                                        <div class="countdown-timer badge bg-warning text-dark" data-expires="{{ $emprunt->access_expires_at->toIso8601String() }}">
                                            <i class="fas fa-clock me-1"></i>
                                            <span class="countdown-text">Calcul...</span>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-auto d-grid gap-2">
                                @if($emprunt->livre && $emprunt->livre->pdf)
                                    @if($emprunt->access_expires_at && now()->greaterThan($emprunt->access_expires_at))
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-lock me-1"></i>Accès expiré
                                        </button>
                                    @else
                                        <a href="{{ route('secure-pdf.view', $emprunt->livre->id) }}" class="btn btn-danger btn-sm">
                                            <i class="fas fa-book-reader me-1"></i>Lire le PDF
                                        </a>
                                    @endif
                                @endif
                                <a href="{{ route('emprunts.show', $emprunt->livre->id) }}" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-info-circle me-1"></i>Détails
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Section 4: Historique des emprunts retournés -->
        @if ($empruntsHistorique->isNotEmpty())
        <section class="mb-5">
            <div class="section-header mb-3 d-flex align-items-center gap-2">
                <i class="fas fa-history text-secondary"></i>
                <h3 class="mb-0">Historique ({{ $empruntsHistorique->count() }})</h3>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
                @foreach ($empruntsHistorique as $emprunt)
                <article class="col">
                    <div class="card h-100 book-card border-secondary" tabindex="0">
                        <div class="book-image-wrapper position-relative"
                            style="height:240px; overflow:hidden; background:linear-gradient(135deg,#f5f7fa,#c3cfe2); opacity: 0.7;">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge bg-secondary">
                                    <i class="fas fa-check me-1"></i>Retourné
                                </span>
                            </div>

                            @if ($emprunt->livre && $emprunt->livre->image)
                            <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}"
                                class="card-img-top" loading="lazy"
                                style="width:100%;height:100%;object-fit:cover;display:block;">
                            @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="fas fa-book fa-3x text-muted"></i>
                            </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h3 class="h6 mb-1">{{ $emprunt->livre->titre ?? 'N/A' }}</h3>
                            <p class="text-muted small mb-2">
                                <i class="fas fa-user-pen me-1"></i>{{ $emprunt->livre->auteur ?? 'N/A' }}
                            </p>

                            <div class="text-muted small mb-3">
                                <div><strong>Emprunté:</strong> {{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</div>
                                <div><strong>Retourné:</strong> {{ $emprunt->date_retour ? \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') : 'N/A' }}</div>
                            </div>

                            <div class="mt-auto d-grid">
                                <a href="{{ route('emprunts.show', $emprunt->livre->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-info-circle me-1"></i>Détails
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
                @endforeach
            </div>
        </section>
        @endif

    </main>

    @push('styles')
        <style>
            .hero-section {
                background: linear-gradient(135deg, #4f46e5, #8b5cf6);
            }

            .hero-icon {
                width: 48px;
                height: 48px
            }

            .text-white-75 {
                color: rgba(255, 255, 255, 0.9);
            }

            .book-image-wrapper {
                height: 240px;
            }

            .book-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            }

            .info-box h5 {
                font-weight: 700
            }

            @media (max-width:768px) {
                .book-image-wrapper {
                    height: 180px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-hide toasts
                setTimeout(function() {
                    document.querySelectorAll('.alert').forEach(a => {
                        try {
                            new bootstrap.Alert(a).close();
                        } catch (e) {}
                    });
                }, 5000);

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

                            // Ne recharger qu'une seule fois en utilisant sessionStorage
                            if (!sessionStorage.getItem('countdown_reload_' + timer.getAttribute('data-expires'))) {
                                sessionStorage.setItem('countdown_reload_' + timer.getAttribute('data-expires'), 'true');
                                setTimeout(() => location.reload(), 2000);
                            }
                        } else {
                            const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                            // Format d'affichage selon le temps restant
                            if (days > 0) {
                                textElement.textContent = `${days}j ${hours}h ${minutes}m ${seconds}s`;
                            } else {
                                textElement.textContent = `${hours}h ${minutes}m ${seconds}s`;
                            }

                            // Change color based on remaining time
                            if (days === 0 && hours < 1) {
                                timer.classList.remove('bg-info', 'bg-warning');
                                timer.classList.add('bg-danger', 'text-white');
                            } else if (days === 0 && hours < 24) {
                                timer.classList.remove('bg-info', 'bg-danger');
                                timer.classList.add('bg-warning', 'text-dark');
                            } else if (days < 2) {
                                timer.classList.remove('bg-info', 'bg-danger');
                                timer.classList.add('bg-warning', 'text-dark');
                            } else {
                                timer.classList.remove('bg-warning', 'bg-danger');
                                timer.classList.add('bg-success', 'text-white');
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
