@extends('layouts.app')

@section('title', 'Bibliothèque d\'Emprunts')

@section('content')
    @include('partials.notifications')


    <div class="container py-5" id="catalogue">

        <!-- Hero Section Moderne (centré) avec HR décoratif -->
        <div class="hero-section-modern position-relative overflow-hidden">
            <div class="container position-relative h-100">
                <div class="row justify-content-center align-items-center min-vh-50">
                    <div class="col-lg-8 col-md-10 text-center">
                        <h1 class="hero-title mb-4 animate-fade-in-delay">
                            Découvrez la Littérature<br>
                            <span class="text-gradient">Africaine</span>
                        </h1>
                        <!-- Decorative HR -->
                        <div class="d-flex align-items-center justify-content-center my-4">
                            <div
                                style="flex:1;max-width:45%;height:6px;border-radius:6px;
                background: linear-gradient(90deg, rgba(16,185,129,0.95), rgba(34,197,94,0.95));
                box-shadow:0 4px 10px rgba(16,185,129,0.08);">
                            </div>

                            <div class="mx-3 bg-white rounded-circle d-flex align-items-center justify-content-center"
                                style="width:56px;height:56px;box-shadow:0 6px 18px rgba(0,0,0,0.08);">
                                <i class="fas fa-book-open text-primary" aria-hidden="true"></i>
                                <span class="visually-hidden">Séparateur</span>
                            </div>

                            <div
                                style="flex:1;max-width:45%;height:6px;border-radius:6px;
                background: linear-gradient(90deg, rgba(34,197,94,0.95), rgba(6,159,125,0.95));
                box-shadow:0 4px 10px rgba(16,185,129,0.08);">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catalogue de livres -->
        @if ($livres->isEmpty())
            <div class="empty-state text-center py-5">
                <i class="fas fa-book-open fa-5x text-muted mb-4"></i>
                <h3 class="text-muted">Aucun livre disponible</h3>
                <p class="text-muted">Revenez bientôt pour découvrir de nouveaux titres !</p>
            </div>
        @else
            <div class="row g-4 mb-5">
                @foreach ($livres as $index => $livre)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="book-card" style="animation-delay: {{ $index * 0.1 }}s;">
                            <!-- Badge Nouveau (si ajouté dans les 7 derniers jours) -->
                            @if ($livre->created_at && $livre->created_at->gt(now()->subDays(7)))
                                <div class="badge-nouveau">
                                    <i class="fas fa-star me-1"></i>Nouveau
                                </div>
                            @endif

                            <!-- Image du livre (zone à taille fixe comme dans le catalogue) -->
                            <div class="book-image-wrapper fixed-image-area"
                                style="height:280px; min-height:280px; max-height:280px; overflow:hidden;">
                                @if ($livre->image)
                                    <img src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}" class="book-image"
                                        loading="lazy" style="width:100%; height:100%; object-fit:cover; display:block;">
                                @else
                                    <div class="book-placeholder">
                                        <i class="fas fa-book fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <!-- Overlay avec actions rapides -->
                                <div class="book-overlay">
                                    <a href="{{ route('emprunts.show', $livre->id) }}" class="btn btn-light btn-sm mb-2">
                                        <i class="fas fa-eye me-1"></i>Détails
                                    </a>
                                    @auth
                                        @if ($livre->quantite > 0)
                                            <form action="{{ route('emprunts.demander') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-hand-holding me-1"></i>Emprunter
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>
                            </div>

                            <!-- Informations du livre -->
                            <div class="book-info">
                                <h5 class="book-title" title="{{ $livre->titre }}">{{ Str::limit($livre->titre, 40) }}</h5>
                                <p class="book-author mb-2">
                                    <i class="fas fa-user-pen me-1 text-primary"></i>
                                    {{ Str::limit($livre->auteur, 25) }}
                                </p>

                                <div class="book-meta mb-3">
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-tag me-1"></i>{{ $livre->categorie }}
                                    </span>
                                    <span class="badge {{ $livre->quantite > 0 ? 'bg-success' : 'bg-danger' }}">
                                        <i class="fas {{ $livre->quantite > 0 ? 'fa-check' : 'fa-times' }} me-1"></i>
                                        {{ $livre->quantite }} dispo
                                    </span>
                                </div>

                                <div class="book-actions d-grid gap-2">
                                    <a href="{{ route('emprunts.show', $livre->id) }}"
                                        class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-info-circle me-1"></i>Voir les détails
                                    </a>

                                    @auth
                                        @if ($livre->quantite > 0)
                                            <form action="{{ route('emprunts.demander') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    <i class="fas fa-hand-holding me-1"></i>Emprunter maintenant
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                                <i class="fas fa-ban me-1"></i>Indisponible
                                            </button>
                                        @endif
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-warning btn-sm w-100">
                                            <i class="fas fa-sign-in-alt me-1"></i>Se connecter
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination moderne -->
            <div class="d-flex justify-content-center mt-5">
                {{ $livres->links() }}
            </div>
        @endif

    </div>

    @push('styles')
        <style>
            /* Hero Section */
            .hero-section {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                position: relative;
                overflow: hidden;
            }

            .hero-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
                opacity: 0.5;
            }

            /* Animations */
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes float {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-20px);
                }
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in {
                animation: fadeIn 0.6s ease-out;
            }

            .animate-fade-in-delay {
                animation: fadeIn 0.6s ease-out 0.2s both;
            }

            .animate-fade-in-delay-2 {
                animation: fadeIn 0.6s ease-out 0.4s both;
            }

            .animate-float {
                animation: float 3s ease-in-out infinite;
            }

            .animate-slide-down {
                animation: slideDown 0.4s ease-out;
            }

            /* Stats Cards */
            .stat-card {
                border-radius: 15px;
                padding: 25px;
                display: flex;
                align-items: center;
                gap: 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .stat-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            }

            .stat-icon {
                font-size: 2.5rem;
                opacity: 0.8;
            }

            .stat-content h3 {
                font-size: 2rem;
                font-weight: 700;
            }

            /* Book Cards */
            .book-card {
                background: white;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                transition: all 0.3s ease;
                height: 100%;
                display: flex;
                flex-direction: column;
                position: relative;
                animation: fadeIn 0.6s ease-out both;
            }

            .book-card:hover {
                transform: translateY(-10px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            }

            .badge-nouveau {
                position: absolute;
                top: 10px;
                right: 10px;
                background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
                color: white;
                padding: 5px 12px;
                border-radius: 20px;
                font-size: 0.75rem;
                font-weight: 600;
                z-index: 2;
                box-shadow: 0 2px 10px rgba(245, 87, 108, 0.4);
            }

            .book-image-wrapper {
                position: relative;
                height: 280px;
                overflow: hidden;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            }

            .book-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                transition: transform 0.4s ease;
            }

            .book-card:hover .book-image {
                transform: scale(1.1);
            }

            .book-placeholder {
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .book-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.8);
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                opacity: 0;
                transition: opacity 0.3s ease;
            }

            .book-card:hover .book-overlay {
                opacity: 1;
            }

            .book-info {
                padding: 20px;
                flex-grow: 1;
                display: flex;
                flex-direction: column;
            }

            .book-title {
                font-weight: 700;
                color: #2d3748;
                margin-bottom: 8px;
                font-size: 1.1rem;
                line-height: 1.4;
                min-height: 2.8em;
            }

            .book-author {
                color: #718096;
                font-size: 0.9rem;
            }

            .book-meta {
                display: flex;
                gap: 8px;
                flex-wrap: wrap;
            }

            .book-actions {
                margin-top: auto;
            }

            /* Info Box */
            .info-box {
                background: linear-gradient(135deg, #667eea15 0%, #764ba215 100%);
                border-radius: 20px;
                padding: 40px;
            }

            .info-item {
                text-align: center;
                padding: 20px;
            }

            .info-item h5 {
                font-weight: 700;
                color: #2d3748;
                margin-bottom: 10px;
            }

            /* Empty State */
            .empty-state {
                background: white;
                border-radius: 15px;
                padding: 60px 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            }

            /* Responsive */
            @media (max-width: 768px) {
                .hero-section {
                    padding: 30px 0 !important;
                }

                .display-4 {
                    font-size: 2rem;
                }

                .stat-card {
                    padding: 20px;
                }

                .stat-icon {
                    font-size: 2rem;
                }

                .stat-content h3 {
                    font-size: 1.5rem;
                }

                .book-image-wrapper {
                    height: 220px;
                }

                .info-box {
                    padding: 30px 20px;
                }
            }

            @media (max-width: 576px) {
                .book-card {
                    margin-bottom: 20px;
                }

                .book-title {
                    font-size: 1rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Auto-hide alerts after 5 seconds
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.alert');
                    alerts.forEach(alert => {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    });
                }, 5000);
            });
        </script>
    @endpush
@endsection
