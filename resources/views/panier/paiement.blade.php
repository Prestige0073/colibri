@extends('layouts.app')

@section('title', 'Paiement')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Résumé du panier -->
            <div class="col-lg-8">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Résumé de votre commande</h5>
                    </div>
                    <div class="card-body">
                        @if($cartItems->isEmpty())
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>Votre panier est vide.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Livre</th>
                                            <th>Prix unitaire</th>
                                            <th>Quantité</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td>
                                                    <strong>{{ $item->catalogue->titre }}</strong><br>
                                                    <small class="text-muted">{{ $item->catalogue->auteur }}</small>
                                                </td>
                                                <td>{{ fcfa($item->catalogue->prix) }}</td>
                                                <td>{{ $item->quantite }}</td>
                                                <td><strong>{{ fcfa($item->catalogue->prix * $item->quantite) }}</strong></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-light">
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td><strong class="text-success fs-5">{{ fcfa($total) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Choix du mode de paiement en ligne -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Paiement en ligne</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('panier.traiter-paiement') }}" id="onlinePaymentForm">
                            @csrf
                            <div class="row g-3 justify-content-center">
                                <!-- Mode Test -->
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="payment_method" id="test_online" value="test" required>
                                    <label class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" for="test_online">
                                        <div class="mb-3">
                                            <i class="fa fa-flask fa-3x text-warning"></i>
                                        </div>
                                        <h5 class="mb-2">Mode Test</h5>
                                        <small class="text-muted text-center">Paiement fictif pour tester</small>
                                        <div class="mt-2">
                                            <span class="badge bg-warning text-dark">SIMULATION</span>
                                            <span class="badge bg-info">GRATUIT</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- Kkiapay -->
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="payment_method" id="kkiapay" value="kkiapay" required>
                                    <label class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" for="kkiapay">
                                        <div class="mb-3">
                                            <img src="https://media.licdn.com/dms/image/v2/C5616AQGhqUtJMAG_Vg/profile-displaybackgroundimage-shrink_200_800/profile-displaybackgroundimage-shrink_200_800/0/1589537591763?e=2147483647&v=beta&t=eeZe2YGnp8gEnVySBHgSJ0WmFlQdidG-x2iKRM8i0a8" alt="Kkiapay" style="max-width: 120px; height: auto; border-radius: 8px;">
                                        </div>
                                        <h5 class="mb-2">Kkiapay</h5>
                                        <small class="text-muted text-center">Mobile Money, Cartes</small>
                                        <div class="mt-2">
                                            <span class="badge bg-warning text-dark">MTN</span>
                                            <span class="badge bg-info">Moov</span>
                                        </div>
                                    </label>
                                </div>

                                <!-- PayPal -->
                                <div class="col-md-4">
                                    <input type="radio" class="btn-check" name="payment_method" id="paypal" value="paypal" required>
                                    <label class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4" for="paypal">
                                        <div class="mb-3">
                                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal" style="max-width: 120px; height: auto;" onerror="this.onerror=null; this.parentElement.innerHTML='<div style=\'background: linear-gradient(135deg, #0070ba 0%, #1546a0 100%); padding: 15px 30px; border-radius: 10px;\'><h2 style=\'color: white; margin: 0; font-weight: 700; font-size: 1.5rem;\'>PayPal</h2></div>';">
                                        </div>
                                        <h5 class="mb-2">PayPal</h5>
                                        <small class="text-muted text-center">Paiement international</small>
                                        <div class="mt-2">
                                            <span class="badge bg-info">Mondial</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-lock me-2"></i>Payer maintenant
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Bouton Livraison à domicile EN BAS -->
                <div class="card shadow-sm border-warning">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="fas fa-truck me-2"></i>Ou choisissez la livraison à domicile</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Paiement à la livraison</strong> - Vous payerez en espèces lors de la réception de vos livres.
                        </p>
                        <button type="button" class="btn btn-warning btn-lg w-100" id="livraisonBtn">
                            <i class="fas fa-shipping-fast me-2"></i>Commander avec livraison à domicile
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar récapitulatif -->
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-dark text-white">
                        <h6 class="mb-0"><i class="fas fa-receipt me-2"></i>Récapitulatif</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Sous-total</span>
                            <span>{{ fcfa($total) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span class="text-success">{{ fcfa($total) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de chargement -->
    <div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Chargement...</span>
                    </div>
                    <h5>Traitement de votre commande...</h5>
                    <p class="text-muted mb-0">Veuillez patienter</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmation pour livraison -->
    <div class="modal fade" id="livraisonModal" tabindex="-1" aria-labelledby="livraisonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="livraisonModalLabel">
                        <i class="fas fa-check-circle me-2"></i>Commande enregistrée !
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-4">
                        <i class="fas fa-truck fa-4x text-success mb-3"></i>
                        <h4 class="mb-3">Votre commande a été enregistrée avec succès !</h4>
                        <p class="text-muted mb-3">
                            Numéro de commande: <strong id="commandeNumber">#-</strong>
                        </p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous payerez à la réception de vos livres. Notre équipe vous contactera bientôt pour confirmer la livraison.
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2">
                        <a href="{{ route('account.commandes') }}" class="btn btn-success">
                            <i class="fas fa-list me-2"></i>Voir mes commandes
                        </a>
                        <a href="{{ route('catalogue.acheter') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-shopping-bag me-2"></i>Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .btn-check:checked + label {
            border-width: 3px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
        }

        label[for="kkiapay"],
        label[for="paypal"] {
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 280px;
        }

        label[for="kkiapay"]:hover,
        label[for="paypal"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-outline-primary:hover,
        .btn-outline-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion du formulaire de paiement en ligne (normal)
            const onlineForm = document.getElementById('onlinePaymentForm');
            if (onlineForm) {
                onlineForm.addEventListener('submit', function(e) {
                    const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
                    if (!selectedMethod) {
                        e.preventDefault();
                        alert('Veuillez sélectionner un mode de paiement');
                        return false;
                    }
                });
            }

            // Gestion du bouton Livraison à domicile
            const livraisonBtn = document.getElementById('livraisonBtn');
            if (livraisonBtn) {
                livraisonBtn.addEventListener('click', function() {
                    console.log('Bouton livraison cliqué');

                    // Afficher le modal de chargement
                    const loadingModalEl = document.getElementById('loadingModal');
                    if (!loadingModalEl) {
                        console.error('Modal de chargement introuvable');
                        alert('Erreur: Modal de chargement introuvable');
                        return;
                    }

                    const loadingModal = new bootstrap.Modal(loadingModalEl);
                    loadingModal.show();

                    // Préparer les données
                    const formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('payment_method', 'livraison');

                    console.log('Envoi de la requête AJAX...');

                    // Envoyer via AJAX
                    fetch('{{ route("panier.traiter-paiement") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('Réponse reçue, status:', response.status);

                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Erreur serveur');
                            });
                        }

                        return response.json();
                    })
                    .then(data => {
                        console.log('Données reçues:', data);

                        // Fermer le modal de chargement
                        loadingModal.hide();

                        if (data.success) {
                            console.log('Commande créée avec succès, ID:', data.commande_id);

                            // Mettre à jour le numéro de commande dans le modal
                            const commandeNumberEl = document.getElementById('commandeNumber');
                            if (commandeNumberEl) {
                                commandeNumberEl.textContent = '#' + data.commande_id;
                            }

                            // Afficher le modal de confirmation
                            const confirmModalEl = document.getElementById('livraisonModal');
                            if (confirmModalEl) {
                                const confirmModal = new bootstrap.Modal(confirmModalEl);
                                confirmModal.show();
                            } else {
                                console.error('Modal de confirmation introuvable');
                                alert('Commande créée avec succès ! Numéro: #' + data.commande_id);
                                window.location.href = data.redirect_url;
                            }
                        } else {
                            // Afficher l'erreur
                            console.error('Erreur dans la réponse:', data.message);
                            alert(data.message || 'Une erreur est survenue lors de l\'enregistrement de votre commande.');
                        }
                    })
                    .catch(error => {
                        console.error('Erreur catch:', error);
                        loadingModal.hide();
                        alert('Une erreur est survenue: ' + error.message);
                    });
                });
            }
        });
    </script>
@endsection
