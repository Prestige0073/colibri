@extends('layouts.app')

@section('title', 'Paiement Kkiapay')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Carte d'information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0"><i class="fa fa-graduation-cap text-primary me-2"></i>Formation</h5>
                            <a href="{{ route('paiement.annuler', $inscription->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left me-1"></i>Retour
                            </a>
                        </div>
                        <h4 class="mb-3">{{ $formation->titre }}</h4>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Montant à payer</span>
                            <h3 class="text-success mb-0">{{ number_format($montant, 0, ',', ' ') }} FCFA</h3>
                        </div>
                    </div>
                </div>

                <!-- Carte de paiement KKiaPay (Simulation) -->
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient text-white text-center py-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <img src="https://kkiapay.me/img/logo.png" alt="KKiaPay" style="height: 40px; filter: brightness(0) invert(1);" class="mb-2">
                        <h4 class="mb-0">Paiement sécurisé</h4>
                        <p class="mb-0 small opacity-75">Mode Simulation</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 mb-4">
                            <i class="fa fa-info-circle me-2"></i>
                            <strong>Mode Simulation :</strong> Ce paiement est une simulation. En production, vous serez redirigé vers la vraie interface KKiaPay.
                        </div>

                        <!-- Récapitulatif -->
                        <div class="bg-light rounded p-3 mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Formation :</span>
                                <strong>{{ \Illuminate\Support\Str::limit($formation->titre, 40) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Utilisateur :</span>
                                <strong>{{ Auth::user()->name }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Email :</span>
                                <strong>{{ Auth::user()->email }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span class="h5 mb-0">Total à payer :</span>
                                <span class="h4 text-success mb-0">{{ number_format($montant, 0, ',', ' ') }} FCFA</span>
                            </div>
                        </div>

                        <!-- Méthodes de paiement simulées -->
                        <div class="mb-4">
                            <h6 class="mb-3">Choisir une méthode de paiement</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="payment-method-card active" onclick="selectPaymentMethod('mobile')">
                                        <i class="fa fa-mobile-alt fa-2x text-primary mb-2"></i>
                                        <div class="fw-bold">Mobile Money</div>
                                        <small class="text-muted">MTN, Moov, Flooz</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="payment-method-card" onclick="selectPaymentMethod('card')">
                                        <i class="fa fa-credit-card fa-2x text-primary mb-2"></i>
                                        <div class="fw-bold">Carte Bancaire</div>
                                        <small class="text-muted">Visa, Mastercard</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Formulaire de simulation -->
                        <form id="paymentForm" action="{{ route('paiement.kkiapay.callback') }}" method="POST">
                            @csrf
                            <input type="hidden" name="inscription_id" value="{{ $inscription->id }}">
                            <input type="hidden" name="transaction_id" id="transaction_id">
                            <input type="hidden" name="payment_method" id="payment_method" value="mobile">

                            <div id="mobileMoneyForm">
                                <div class="mb-3">
                                    <label class="form-label">Numéro de téléphone</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa fa-phone"></i></span>
                                        <input type="tel" class="form-control" id="phone" placeholder="Ex: 61234567" required>
                                    </div>
                                    <small class="text-muted">Entrez un numéro fictif pour la simulation</small>
                                </div>
                            </div>

                            <div id="cardForm" style="display: none;">
                                <div class="mb-3">
                                    <label class="form-label">Numéro de carte</label>
                                    <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Date d'expiration</label>
                                        <input type="text" class="form-control" placeholder="MM/AA" maxlength="5">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">CVV</label>
                                        <input type="text" class="form-control" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>

                            <!-- Bouton de paiement -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="button" id="payButton" class="btn btn-success btn-lg" onclick="simulatePayment()">
                                    <i class="fa fa-lock me-2"></i>Payer {{ number_format($montant, 0, ',', ' ') }} FCFA
                                </button>
                                <a href="{{ route('paiement.annuler', $inscription->id) }}" class="btn btn-outline-secondary">
                                    <i class="fa fa-times me-1"></i>Annuler le paiement
                                </a>
                            </div>
                        </form>

                        <!-- Sécurité -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fa fa-shield-alt text-success me-1"></i>
                                Paiement sécurisé et crypté
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Aide -->
                <div class="card mt-3 border-0 bg-light">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">
                            <i class="fa fa-question-circle me-1"></i>
                            Besoin d'aide ? Contactez-nous sur WhatsApp :
                            <a href="https://wa.me/2290166547808" target="_blank" class="text-decoration-none">
                                <i class="fab fa-whatsapp text-success"></i> +229 01 66 54 78 08
                            </a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de traitement -->
    <div class="modal fade" id="processingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Traitement...</span>
                    </div>
                    <h5 class="mb-2">Traitement du paiement</h5>
                    <p class="text-muted mb-0">Veuillez patienter...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de succès -->
    <div class="modal fade" id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <div class="mb-3">
                        <i class="fa fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h4 class="mb-3">Paiement réussi !</h4>
                    <p class="text-muted">Votre paiement a été validé avec succès.</p>
                    <p class="mb-4">Vous allez être redirigé vers votre formation...</p>
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Redirection...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .payment-method-card {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .payment-method-card:hover {
        border-color: #667eea;
        background-color: #f8f9ff;
        transform: translateY(-2px);
    }

    .payment-method-card.active {
        border-color: #667eea;
        background-color: #f0f2ff;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
    }

    .bg-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-right: none;
    }

    .input-group .form-control {
        border-left: none;
    }

    .input-group .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }
</style>
@endpush

@push('scripts')
<script>
    let selectedMethod = 'mobile';

    function selectPaymentMethod(method) {
        selectedMethod = method;
        document.getElementById('payment_method').value = method;

        // Mettre à jour les cartes
        document.querySelectorAll('.payment-method-card').forEach(card => {
            card.classList.remove('active');
        });
        event.currentTarget.classList.add('active');

        // Afficher le bon formulaire
        if (method === 'mobile') {
            document.getElementById('mobileMoneyForm').style.display = 'block';
            document.getElementById('cardForm').style.display = 'none';
        } else {
            document.getElementById('mobileMoneyForm').style.display = 'none';
            document.getElementById('cardForm').style.display = 'block';
        }
    }

    function simulatePayment() {
        // Validation simple
        if (selectedMethod === 'mobile') {
            const phone = document.getElementById('phone').value;
            if (!phone || phone.length < 8) {
                alert('Veuillez entrer un numéro de téléphone valide');
                return;
            }
        }

        // Générer un ID de transaction simulé
        const transactionId = 'SIM-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9).toUpperCase();
        document.getElementById('transaction_id').value = transactionId;

        // Afficher le modal de traitement
        const processingModal = new bootstrap.Modal(document.getElementById('processingModal'));
        processingModal.show();

        // Simuler un délai de traitement (2 secondes)
        setTimeout(() => {
            processingModal.hide();

            // Afficher le modal de succès
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();

            // Soumettre le formulaire après 2 secondes
            setTimeout(() => {
                document.getElementById('paymentForm').submit();
            }, 2000);
        }, 2000);
    }
</script>
@endpush
