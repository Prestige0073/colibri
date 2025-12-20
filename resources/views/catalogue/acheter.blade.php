@extends('layouts.app')

@section('title', 'Acheter / Prêter un livre')
@section('meta_description', "Procédez à l'achat ou au prêt d'un livre africain via le catalogue Colibri Littéraire.")

@section('content')
    @php
        // Récupérer les livres empruntables depuis le catalogue
        $livresEmpruntables = \App\Models\Catalogue::where('type_categorie', 'emprunt')
            ->orderByDesc('created_at')
            ->orderBy('titre')
            ->get();
    @endphp

    @include('partials.notifications')

    <!-- Livres empruntables -->
    @if($livresEmpruntables && $livresEmpruntables->count() > 0)
        <div class="container mt-4 mb-5">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h3 class="mb-0"><i class="fa fa-book-reader me-2 text-primary"></i>Livres disponibles à l'emprunt</h3>
                <a href="{{ route('emprunts.index') }}" class="btn btn-primary">
                    <i class="fa fa-books me-2"></i>Voir toute la bibliothèque
                </a>
            </div>

            <div class="row g-4">
                @foreach($livresEmpruntables->take(6) as $index => $livre)
                    <div class="col-xl-4 col-lg-6 col-md-6" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="emprunt-card card h-100 border-0 shadow-sm">
                            <div class="row g-0 h-100">
                                <!-- Image du livre -->
                                <div class="col-4">
                                    <div class="emprunt-image-wrapper">
                                        @if($livre->image)
                                            <img src="{{ asset($livre->image) }}" alt="{{ $livre->titre }}" class="emprunt-image">
                                        @else
                                            <div class="emprunt-placeholder">
                                                <i class="fa fa-book fa-2x text-muted"></i>
                                            </div>
                                        @endif

                                        <!-- Badge nouveau si ajouté récemment -->
                                        @if($livre->created_at && $livre->created_at->gt(now()->subDays(7)))
                                            <span class="badge-nouveau-emprunt">
                                                <i class="fa fa-star me-1"></i>Nouveau
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Infos du livre -->
                                <div class="col-8">
                                    <div class="card-body d-flex flex-column h-100 p-3">
                                        <h6 class="card-title fw-bold mb-2" title="{{ $livre->titre }}">
                                            {{ Str::limit($livre->titre, 45) }}
                                        </h6>

                                        <p class="text-muted small mb-2">
                                            <i class="fa fa-user me-1"></i>{{ Str::limit($livre->auteur, 30) }}
                                        </p>

                                        <div class="mb-2">
                                            <span class="badge bg-info-subtle text-info border border-info">
                                                <i class="fa fa-tag me-1"></i>{{ $livre->categorie }}
                                            </span>
                                        </div>

                                        <div class="mb-2">
                                            @if($livre->quantite > 0)
                                                <span class="badge bg-success">
                                                    <i class="fa fa-check-circle me-1"></i>{{ $livre->quantite }} disponible(s)
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fa fa-times-circle me-1"></i>Épuisé
                                                </span>
                                            @endif
                                        </div>

                                        <div class="mt-auto d-flex gap-2">
                                            <a href="{{ route('emprunts.show', $livre->id) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                                <i class="fa fa-eye me-1"></i>Détails
                                            </a>

                                            @auth
                                                @if($livre->quantite > 0)
                                                    <form action="{{ route('emprunts.demander') }}" method="POST" class="flex-fill">
                                                        @csrf
                                                        <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                                        <button type="submit" class="btn btn-sm btn-success w-100">
                                                            <i class="fa fa-hand-holding me-1"></i>Emprunter
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-sm btn-secondary flex-fill" disabled>
                                                        <i class="fa fa-ban me-1"></i>Indisponible
                                                    </button>
                                                @endif
                                            @else
                                                <a href="{{ route('login') }}" class="btn btn-sm btn-warning flex-fill">
                                                    <i class="fa fa-sign-in-alt me-1"></i>Connexion
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($livresEmpruntables->count() > 6)
                <div class="text-center mt-4">
                    <a href="{{ route('emprunts.index') }}" class="btn btn-lg btn-primary">
                        <i class="fa fa-books me-2"></i>Voir tous les {{ $livresEmpruntables->count() }} livres empruntables
                    </a>
                </div>
            @endif
        </div>
    @endif

    <!-- Catalogue Vente Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mx-auto wow fadeIn" data-wow-delay="0.1s" style="max-width: 500px;">
                <p class="section-title bg-white text-center text-primary px-3">Catalogue</p>
                <h1 class="display-6 mb-4">Achetez nos livres africains</h1>
            </div>
            <div class="row g-4">
                @foreach ($livres as $livre)
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeIn" data-wow-delay="0.1s">
                        <div class="catalogue-item card h-100 border-0 shadow-lg"
                            style="background: transparent; backdrop-filter: blur(6px); border-top-left-radius: 12px; border-top-right-radius: 12px; border-bottom-left-radius: 0; border-bottom-right-radius: 0;">
                            <img class="card-img-top" src="{{ asset('img/' . $livre->image) }}" alt="{{ $livre->titre }}"
                                style="border-top-left-radius: 12px; border-top-right-radius: 12px; height: 300px; object-fit: cover;">
                            <div class="card-body d-flex flex-column justify-content-between"
                                style="padding: 1.2rem;">
                                <h5 class="card-title mb-2 d-flex align-items-center"
                                    style="color: #212529; font-weight: 700; font-size: 1.15rem;">
                                    <i class="fa fa-book"
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
                                        style="background: #1976d2; color: #fff; font-size: 1rem; padding: 0.4em 0.8em; border-radius: 8px; font-weight: 600;">
                                        Prix: {{ number_format($livre->prix, 0, ',', ' ') }} FCFA
                                    </span>
                                    <span class="badge ms-2"
                                        style="background: #198754; color: #fff; font-size: 0.8rem; padding: 0.25em 0.5em; border-radius: 8px;">
                                        Stock: {{ $livre->quantite }}
                                    </span>
                                </div>
                                <form method="POST" action="{{ route('panier.ajouter') }}" class="ajax-add-to-cart" data-livre-id="{{ $livre->id }}">
                                    @csrf
                                    <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                    <div class="mb-2 d-flex align-items-center">
                                        <label for="qty_{{ $livre->id }}"
                                            class="form-label me-2 mb-0">Quantité :</label>
                                        <div class="input-group" style="width: 90px;">
                                            <button type="button" class="btn btn-outline-secondary p-1"
                                                style="width:28px; height:28px;"
                                                onclick="changeQty({{ $livre->id }}, -1)">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="number" min="1" max="{{ $livre->quantite }}"
                                                name="quantite" id="qty_{{ $livre->id }}"
                                                class="form-control text-center" value="1"
                                                style="width: 34px; height:28px; padding:0; font-size:1rem;">
                                            <button type="button" class="btn btn-outline-secondary p-1"
                                                style="width:28px; height:28px;"
                                                onclick="changeQty({{ $livre->id }}, 1)">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn w-100 catalogue-buy-btn" id="btn-{{ $livre->id }}"
                                        style="background: #1976d2; color: #ffffffff; border-radius: 0; font-weight: 600; font-size: 1.05rem; border: none; transition: background 0.2s;">
                                        <i class="fa fa-shopping-cart me-2"></i><span class="btn-text">Acheter</span>
                                    </button>
                                </form>
                                <style>
                                    .catalogue-buy-btn:hover {
                                        background: #1565c0 !important;
                                        color: #fff !important;
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($livres->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $livres->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Catalogue Vente End -->

    <script>
        function changeQty(id, delta) {
            var input = document.getElementById('qty_' + id);
            if (!input) return;

            var min = parseInt(input.min);
            var max = parseInt(input.max);
            var val = parseInt(input.value);
            var newVal = val + delta;

            if (newVal >= min && newVal <= max) {
                input.value = newVal;
            }
        }

        // AJAX pour ajouter au panier
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.ajax-add-to-cart');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const livreId = this.dataset.livreId;
                    const button = document.getElementById('btn-' + livreId);
                    const buttonText = button.querySelector('.btn-text');
                    const formData = new FormData(this);

                    // Désactiver le bouton et changer le texte
                    button.disabled = true;
                    const originalText = buttonText.innerHTML;
                    buttonText.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Ajout...';
                    button.style.background = '#6c757d';

                    // Envoi AJAX
                    fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Animation de succès
                            button.style.background = '#198754';
                            buttonText.innerHTML = '<i class="fa fa-check me-2"></i>Ajouté !';

                            // Afficher notification de succès
                            showNotification('success', data.message || 'Article ajouté au panier avec succès !');

                            // Réinitialiser après 2 secondes
                            setTimeout(() => {
                                button.disabled = false;
                                buttonText.innerHTML = originalText;
                                button.style.background = '#1976d2';
                            }, 2000);
                        } else {
                            // Erreur
                            button.style.background = '#dc3545';
                            buttonText.innerHTML = '<i class="fa fa-times me-2"></i>Erreur';
                            showNotification('error', data.message || 'Une erreur est survenue');

                            setTimeout(() => {
                                button.disabled = false;
                                buttonText.innerHTML = originalText;
                                button.style.background = '#1976d2';
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        button.style.background = '#dc3545';
                        buttonText.innerHTML = '<i class="fa fa-times me-2"></i>Erreur';
                        showNotification('error', 'Erreur de connexion au serveur');

                        setTimeout(() => {
                            button.disabled = false;
                            buttonText.innerHTML = originalText;
                            button.style.background = '#1976d2';
                        }, 2000);
                    });
                });
            });
        });

        // Fonction pour afficher une notification
        function showNotification(type, message) {
            const container = document.getElementById('notificationContainer');
            if (!container) return;

            const iconMap = {
                'success': 'fa-check-circle',
                'error': 'fa-exclamation-circle',
                'warning': 'fa-exclamation-triangle',
                'info': 'fa-info-circle'
            };

            const titleMap = {
                'success': 'Succès !',
                'error': 'Erreur !',
                'warning': 'Attention !',
                'info': 'Information'
            };

            const notification = document.createElement('div');
            notification.className = `notification-alert notification-${type}`;
            notification.setAttribute('role', 'alert');
            notification.setAttribute('data-auto-dismiss', 'true');

            notification.innerHTML = `
                <div class="d-flex align-items-start">
                    <div class="notification-icon">
                        <i class="fa ${iconMap[type]}"></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">${titleMap[type]}</div>
                        <div class="notification-message">${message}</div>
                    </div>
                    <button type="button" class="notification-close" onclick="dismissNotification(this)">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <div class="notification-progress"></div>
            `;

            container.appendChild(notification);

            // Auto-dismiss après 5 secondes
            setTimeout(() => {
                notification.classList.add('hiding');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        }

        function dismissNotification(button) {
            const notification = button.closest('.notification-alert');
            notification.classList.add('hiding');
            setTimeout(() => {
                notification.remove();
            }, 300);
        }
    </script>

    <style>
        /* Styles pour les cartes d'emprunt */
        .emprunt-card {
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            animation: fadeIn 0.6s ease-out both;
        }

        .emprunt-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .emprunt-image-wrapper {
            position: relative;
            height: 100%;
            min-height: 200px;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .emprunt-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .emprunt-card:hover .emprunt-image {
            transform: scale(1.1);
        }

        .emprunt-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }

        .badge-nouveau-emprunt {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            z-index: 2;
            box-shadow: 0 2px 10px rgba(245, 87, 108, 0.4);
        }

        .emprunt-card .card-title {
            font-size: 0.95rem;
            color: #2d3748;
            line-height: 1.4;
        }

        .emprunt-card .badge {
            font-size: 0.75rem;
            padding: 0.35em 0.65em;
        }

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

        /* Responsive */
        @media (max-width: 768px) {
            .emprunt-image-wrapper {
                min-height: 150px;
            }

            .emprunt-card .card-body {
                padding: 0.75rem !important;
            }

            .emprunt-card .card-title {
                font-size: 0.875rem;
            }
        }
    </style>
@endsection
