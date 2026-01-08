@extends('layouts.app')

@section('title', 'Paiement KKiaPay - ' . $formation->titre)

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Carte d'information -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5 class="mb-0">
                                <i class="fa fa-graduation-cap me-2"></i>Paiement de votre formation
                            </h5>
                            <a href="{{ route('paiement.annuler', $inscription->id) }}" class="btn btn-sm btn-outline-light">
                                <i class="fa fa-arrow-left me-1"></i>Retour
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h4 class="mb-3">{{ $formation->titre }}</h4>
                                <p class="text-muted mb-2">
                                    <i class="fa fa-user me-2"></i>{{ Auth::user()->name }}
                                </p>
                                <p class="text-muted mb-0">
                                    <i class="fa fa-envelope me-2"></i>{{ Auth::user()->email }}
                                </p>
                            </div>
                            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                                <p class="text-muted mb-1">Montant à payer</p>
                                <h2 class="text-success mb-0">{{ fcfa($montant) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte de paiement KKiaPay -->
                <div class="card shadow-lg border-0">
                    <div class="card-header text-white text-center py-4" style="background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);">
                        <img src="https://media.licdn.com/dms/image/v2/C5616AQGhqUtJMAG_Vg/profile-displaybackgroundimage-shrink_200_800/profile-displaybackgroundimage-shrink_200_800/0/1589537591763?e=2147483647&v=beta&t=eeZe2YGnp8gEnVySBHgSJ0WmFlQdidG-x2iKRM8i0a8" alt="KKiaPay" style="max-height: 60px; border-radius: 8px;" class="mb-2">
                        <h4 class="mb-1">Paiement sécurisé</h4>
                        @if(config('services.kkiapay.sandbox'))
                            <p class="mb-0 small opacity-75">Mode Sandbox (Test)</p>
                        @endif
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info border-0 mb-4">
                            <i class="fa fa-info-circle me-2"></i>
                            <strong>Méthodes de paiement acceptées :</strong> Mobile Money (MTN, Moov), Cartes bancaires (Visa, Mastercard)
                        </div>

                        <!-- Récapitulatif -->
                        <div class="bg-light rounded p-4 mb-4">
                            <h6 class="mb-3">Récapitulatif de votre achat</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Formation :</span>
                                <strong>{{ \Illuminate\Support\Str::limit($formation->titre, 40) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Inscription #:</span>
                                <strong>{{ $inscription->id }}</strong>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 mb-0">Total :</span>
                                <span class="h3 text-success mb-0">{{ fcfa($montant) }}</span>
                            </div>
                        </div>

                        <!-- Informations de paiement -->
                        <div class="alert alert-success border-0 mb-4" id="loadingAlert">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border spinner-border-sm text-success me-3" role="status">
                                    <span class="visually-hidden">Chargement...</span>
                                </div>
                                <div>
                                    <strong>Chargement du paiement KKiaPay...</strong>
                                    <br>
                                    <small>Le widget va s'ouvrir dans quelques secondes</small>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de paiement manuel -->
                        <div class="d-grid gap-2">
                            <button type="button" id="payButton" class="btn btn-success btn-lg" onclick="launchPayment()">
                                <i class="fa fa-lock me-2"></i>Ouvrir le paiement KKiaPay
                            </button>
                            <a href="{{ route('paiement.annuler', $inscription->id) }}" class="btn btn-outline-secondary">
                                <i class="fa fa-times me-1"></i>Annuler le paiement
                            </a>
                        </div>

                        <!-- Sécurité -->
                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="fa fa-shield-alt text-success me-1"></i>
                                Vos paiements sont sécurisés et cryptés par KKiaPay
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Aide -->
                <div class="card mt-3 border-0 bg-light">
                    <div class="card-body text-center py-3">
                        <small class="text-muted">
                            <i class="fa fa-question-circle me-1"></i>
                            Besoin d'aide ? Contactez notre support
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
                        <span class="visually-hidden">Vérification...</span>
                    </div>
                    <h5 class="mb-2">Vérification du paiement</h5>
                    <p class="text-muted mb-0">Veuillez patienter pendant que nous vérifions votre transaction...</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .bg-gradient {
        background: linear-gradient(135deg, #1e88e5 0%, #1565c0 100%);
    }
</style>
@endpush

@push('scripts')
<!-- KKiaPay Widget SDK -->
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
    function launchPayment() {
        openKkiapayWidget({
            amount: {{ $montant }},
            position: "center",
            data: "{{ $inscription->id }}",
            theme: "#1e88e5",
            key: "{{ config('services.kkiapay.public_key') }}",
            sandbox: {{ config('services.kkiapay.sandbox') ? 'true' : 'false' }}
        });
    }

    // Écouter le succès du paiement
    addKkiapayListener('success', function(response) {
        console.log('Paiement réussi:', response);

        // Afficher le modal de traitement
        const processingModal = new bootstrap.Modal(document.getElementById('processingModal'));
        processingModal.show();

        // Rediriger vers le callback avec les paramètres
        setTimeout(function() {
            window.location.href = "{{ route('paiement.kkiapay.callback') }}" +
                "?transaction_id=" + response.transactionId +
                "&inscription_id={{ $inscription->id }}";
        }, 1000);
    });

    // Écouter l'échec du paiement
    addKkiapayListener('failed', function(response) {
        console.error('Paiement échoué:', response);
        alert('Le paiement a échoué. Veuillez réessayer.');
    });

    // Écouter la fermeture du widget
    addKkiapayListener('pending', function(response) {
        console.log('Paiement en attente:', response);
    });

    // Ouvrir automatiquement le widget au chargement de la page
    window.addEventListener('load', function() {
        // Attendre que le SDK KKiaPay soit chargé
        const checkSDK = setInterval(function() {
            if (typeof openKkiapayWidget === 'function') {
                clearInterval(checkSDK);
                // Masquer l'indicateur de chargement
                const loadingAlert = document.getElementById('loadingAlert');
                if (loadingAlert) {
                    loadingAlert.innerHTML = '<div class="d-flex align-items-center"><i class="fa fa-check-circle text-success me-2"></i><span>Ouverture du paiement...</span></div>';
                }
                // Ouvrir le widget après un court délai
                setTimeout(function() {
                    launchPayment();
                }, 500);
            }
        }, 100); // Vérifier toutes les 100ms

        // Timeout de sécurité après 10 secondes
        setTimeout(function() {
            clearInterval(checkSDK);
            const loadingAlert = document.getElementById('loadingAlert');
            if (loadingAlert && typeof openKkiapayWidget !== 'function') {
                loadingAlert.className = 'alert alert-warning border-0 mb-4';
                loadingAlert.innerHTML = '<i class="fa fa-exclamation-triangle me-2"></i>Le widget tarde à se charger. Cliquez sur le bouton ci-dessous pour ouvrir le paiement.';
            }
        }, 10000);
    });
</script>
@endpush
