@extends('layouts.app')

@section('title', 'Paiement PayPal')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0">
                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal" style="max-height: 40px;">
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Commande #{{ $commande->id }}</h5>
                            <h2 class="text-success">{{ number_format($montant, 0, ',', ' ') }} FCFA</h2>
                            <p class="text-muted">≈ {{ number_format($montant / 655.957, 2) }} EUR</p>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous allez être redirigé vers PayPal pour effectuer le paiement de manière sécurisée.
                        </div>

                        <!-- Boutons PayPal -->
                        <div id="paypal-button-container"></div>

                        <div class="text-center mt-3">
                            <a href="{{ route('panier.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PayPal SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&currency=EUR"></script>
    <script>
        const amountInEUR = ({{ $montant }} / 655.957).toFixed(2);

        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        description: 'Commande #{{ $commande->id }}',
                        amount: {
                            value: amountInEUR
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    window.location.href = "{{ route('paiement.catalogue.paypal.callback') }}?transaction_id=" +
                        details.id + "&commande_id={{ $commande->id }}";
                });
            },
            onError: function(err) {
                alert('Une erreur est survenue lors du paiement. Veuillez réessayer.');
            },
            onCancel: function(data) {
                alert('Paiement annulé.');
                window.location.href = "{{ route('panier.index') }}";
            }
        }).render('#paypal-button-container');
    </script>
@endsection
