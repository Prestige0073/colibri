@extends('layouts.app')

@section('title', 'Paiement PayPal')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fab fa-paypal me-2"></i>Paiement via PayPal</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>{{ $formation->titre }}</h5>
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
                            <a href="{{ route('paiement.annuler', $inscription->id) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Note:</strong> L'intégration PayPal nécessite une configuration avec votre Client ID PayPal.
                </div>
            </div>
        </div>
    </div>

    <!-- PayPal SDK -->
    <!-- IMPORTANT: Remplacez 'YOUR_CLIENT_ID' par votre Client ID PayPal -->
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_CLIENT_ID&currency=EUR"></script>
    <script>
        // Convertir FCFA en EUR (taux approximatif: 1 EUR = 655.957 FCFA)
        const amountInEUR = ({{ $montant }} / 655.957).toFixed(2);

        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        description: '{{ $formation->titre }}',
                        amount: {
                            value: amountInEUR
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    console.log('Transaction complétée par ' + details.payer.name.given_name);

                    // Rediriger vers le callback avec l'ID de transaction
                    window.location.href = "{{ route('paiement.paypal.callback') }}?transaction_id=" +
                        details.id + "&inscription_id={{ $inscription->id }}";
                });
            },
            onError: function(err) {
                console.error('Erreur PayPal:', err);
                alert('Une erreur est survenue lors du paiement. Veuillez réessayer.');
            },
            onCancel: function(data) {
                alert('Paiement annulé.');
                window.location.href = "{{ route('paiement.annuler', $inscription->id) }}";
            }
        }).render('#paypal-button-container');
    </script>
@endsection
