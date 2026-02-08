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
                                <form method="POST" action="{{ route('panier.ajouter') }}" class="home-ajax-cart-form">
                                    @csrf
                                    <input type="hidden" name="catalogue_id" value="{{ $catalogue->id }}">
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit" class="btn btn-primary btn-lg py-3 w-100">
                                        <i class="fas fa-shopping-cart me-2"></i>Ajouter au Panier
                                    </button>
                                </form>
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

/* ============================================
   TOAST MODAL AJOUT AU PANIER
   ============================================ */
:root {
    --home-primary-green: #1e7a2f;
    --home-primary-dark: #0b5e34;
}

.home-cart-toast-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.6);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    backdrop-filter: blur(4px);
}

.home-cart-toast-overlay.show {
    opacity: 1;
    visibility: visible;
}

.home-cart-toast-content {
    background: white;
    border-radius: 20px;
    padding: 2.5rem 3rem;
    text-align: center;
    max-width: 450px;
    width: 90%;
    box-shadow: 0 25px 80px rgba(0, 0, 0, 0.3);
    transform: scale(0.8) translateY(20px);
    transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
}

.home-cart-toast-overlay.show .home-cart-toast-content {
    transform: scale(1) translateY(0);
}

.home-cart-toast-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--home-primary-green) 0%, var(--home-primary-dark) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 10px 30px rgba(30, 122, 47, 0.4);
    animation: pulseSuccess 0.6s ease;
}

.home-cart-toast-icon i {
    font-size: 2.5rem;
    color: white;
}

@keyframes pulseSuccess {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); opacity: 1; }
}

.home-cart-toast-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2d3436;
    margin-bottom: 0.5rem;
}

.home-cart-toast-message {
    font-size: 1rem;
    color: #636e72;
    margin-bottom: 1.75rem;
}

.home-cart-toast-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.home-cart-toast-btn {
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    border: none;
}

.home-cart-toast-continue {
    background: #f1f3f4;
    color: #2d3436;
}

.home-cart-toast-continue:hover {
    background: #e2e6ea;
    color: #2d3436;
}

.home-cart-toast-cart {
    background: linear-gradient(135deg, var(--home-primary-green) 0%, var(--home-primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(30, 122, 47, 0.35);
}

.home-cart-toast-cart:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 122, 47, 0.45);
}

.home-btn-added-success {
    background: linear-gradient(135deg, #28a745 0%, #218838 100%) !important;
    color: white !important;
    border: none !important;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    animation: successBounce 0.5s ease;
    cursor: default;
}

@keyframes successBounce {
    0% { transform: scale(1); }
    30% { transform: scale(1.1); }
    50% { transform: scale(0.95); }
    100% { transform: scale(1); }
}

@keyframes checkPop {
    0% { transform: scale(0) rotate(-45deg); }
    50% { transform: scale(1.3) rotate(0deg); }
    100% { transform: scale(1) rotate(0deg); }
}

.home-btn-added-success i {
    font-size: 1.1rem;
    animation: checkPop 0.4s ease;
}

.home-btn-error {
    background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
    color: white !important;
    border: none !important;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1.1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    width: 100%;
    box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
    cursor: default;
}

.home-cart-toast-icon-warning {
    background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%) !important;
    box-shadow: 0 10px 30px rgba(243, 156, 18, 0.4) !important;
}

.home-cart-toast-login {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    color: white;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.35);
}

.home-cart-toast-login:hover {
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.45);
}

@media (max-width: 576px) {
    .home-cart-toast-content {
        padding: 2rem 1.5rem;
    }

    .home-cart-toast-icon {
        width: 65px;
        height: 65px;
    }

    .home-cart-toast-icon i {
        font-size: 2rem;
    }

    .home-cart-toast-title {
        font-size: 1.25rem;
    }

    .home-cart-toast-actions {
        flex-direction: column;
    }

    .home-cart-toast-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.home-ajax-cart-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const btn = form.querySelector('button[type="submit"]');
            const originalContent = btn.innerHTML;
            const originalClasses = btn.className;

            btn.disabled = true;
            btn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Ajout...';

            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (response.ok) {
                    btn.innerHTML = '<i class="fa fa-check-circle me-2"></i>Ajouté au panier !';
                    btn.className = 'home-btn-added-success';

                    updateCartCount();
                    showCartToast('Livre ajouté au panier avec succès !');

                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.className = originalClasses;
                        btn.disabled = false;
                    }, 2500);
                } else if (response.status === 401) {
                    showLoginRequiredToast();
                    btn.innerHTML = originalContent;
                    btn.className = originalClasses;
                    btn.disabled = false;
                } else {
                    response.json().then(data => {
                        showErrorToast(data.message || 'Une erreur est survenue.');
                    }).catch(() => {
                        showErrorToast('Une erreur est survenue.');
                    });
                    btn.innerHTML = '<i class="fa fa-times me-2"></i>Erreur';
                    btn.className = 'home-btn-error';

                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.className = originalClasses;
                        btn.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                btn.innerHTML = '<i class="fa fa-times me-2"></i>Erreur';
                btn.className = 'home-btn-error';

                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.className = originalClasses;
                    btn.disabled = false;
                }, 2000);
            });
        });
    });

    function updateCartCount() {
        fetch('{{ route("panier.count") }}', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const cartBadges = document.querySelectorAll('.cart-count-badge, .navbar .badge');
            cartBadges.forEach(badge => {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-flex';
                }
            });
        })
        .catch(error => console.log('Impossible de mettre à jour le compteur'));
    }

    function showCartToast(message) {
        let existingToast = document.getElementById('homeCartToastCenter');
        if (existingToast) existingToast.remove();

        const toastContainer = document.createElement('div');
        toastContainer.id = 'homeCartToastCenter';
        toastContainer.innerHTML = `
            <div class="home-cart-toast-overlay">
                <div class="home-cart-toast-content">
                    <div class="home-cart-toast-icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <h3 class="home-cart-toast-title">Ajouté au panier !</h3>
                    <p class="home-cart-toast-message">${message}</p>
                    <div class="home-cart-toast-actions">
                        <button type="button" class="home-cart-toast-btn home-cart-toast-continue" onclick="this.closest('#homeCartToastCenter').remove()">
                            <i class="fa fa-arrow-left me-2"></i>Continuer mes achats
                        </button>
                        <a href="{{ route('panier.index') }}" class="home-cart-toast-btn home-cart-toast-cart">
                            <i class="fa fa-shopping-cart me-2"></i>Voir le panier
                        </a>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(toastContainer);

        setTimeout(() => {
            toastContainer.querySelector('.home-cart-toast-overlay').classList.add('show');
        }, 10);

        setTimeout(() => {
            const overlay = toastContainer.querySelector('.home-cart-toast-overlay');
            if (overlay) {
                overlay.classList.remove('show');
                setTimeout(() => toastContainer.remove(), 300);
            }
        }, 4000);
    }

    function showLoginRequiredToast() {
        let existingToast = document.getElementById('homeCartToastCenter');
        if (existingToast) existingToast.remove();

        const toastContainer = document.createElement('div');
        toastContainer.id = 'homeCartToastCenter';
        toastContainer.innerHTML = `
            <div class="home-cart-toast-overlay">
                <div class="home-cart-toast-content">
                    <div class="home-cart-toast-icon home-cart-toast-icon-warning">
                        <i class="fa fa-user-lock"></i>
                    </div>
                    <h3 class="home-cart-toast-title">Connexion requise</h3>
                    <p class="home-cart-toast-message">Veuillez vous connecter pour ajouter des articles à votre panier.</p>
                    <div class="home-cart-toast-actions">
                        <button type="button" class="home-cart-toast-btn home-cart-toast-continue" onclick="this.closest('#homeCartToastCenter').remove()">
                            <i class="fa fa-times me-2"></i>Fermer
                        </button>
                        <a href="{{ route('login') }}" class="home-cart-toast-btn home-cart-toast-login">
                            <i class="fa fa-sign-in-alt me-2"></i>Se connecter
                        </a>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(toastContainer);

        setTimeout(() => {
            toastContainer.querySelector('.home-cart-toast-overlay').classList.add('show');
        }, 10);
    }

    function showErrorToast(message) {
        let existingToast = document.getElementById('homeCartToastCenter');
        if (existingToast) existingToast.remove();

        const toastContainer = document.createElement('div');
        toastContainer.id = 'homeCartToastCenter';
        toastContainer.innerHTML = `
            <div class="home-cart-toast-overlay">
                <div class="home-cart-toast-content">
                    <div class="home-cart-toast-icon" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); box-shadow: 0 10px 30px rgba(220, 53, 69, 0.4);">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="home-cart-toast-title">Erreur</h3>
                    <p class="home-cart-toast-message">${message}</p>
                    <div class="home-cart-toast-actions">
                        <button type="button" class="home-cart-toast-btn home-cart-toast-continue" onclick="this.closest('#homeCartToastCenter').remove()">
                            <i class="fa fa-times me-2"></i>Fermer
                        </button>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(toastContainer);

        setTimeout(() => {
            toastContainer.querySelector('.home-cart-toast-overlay').classList.add('show');
        }, 10);

        setTimeout(() => {
            const overlay = toastContainer.querySelector('.home-cart-toast-overlay');
            if (overlay) {
                overlay.classList.remove('show');
                setTimeout(() => toastContainer.remove(), 300);
            }
        }, 4000);
    }
});
</script>
@endsection
