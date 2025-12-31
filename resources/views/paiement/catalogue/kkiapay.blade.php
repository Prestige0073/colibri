@extends('layouts.app')

@section('title', 'Paiement Kkiapay')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <img src="https://kkiapay.me/img/logo-light.png" alt="Kkiapay" style="max-height: 40px;">
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Commande #{{ $commande->id }}</h5>
                            <h2 class="text-success">{{ number_format($montant, 0, ',', ' ') }} FCFA</h2>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous allez être redirigé vers Kkiapay pour effectuer le paiement de manière sécurisée.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="button" class="btn btn-primary btn-lg" onclick="openKkiapayWidget()">
                                <i class="fas fa-lock me-2"></i>Payer {{ number_format($montant, 0, ',', ' ') }} FCFA
                            </button>
                            <a href="{{ route('panier.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kkiapay SDK -->
    <script src="https://cdn.kkiapay.me/k.js"></script>
    <script>
        function openKkiapayWidget() {
            openKkiapayWidget({
                amount: {{ $montant }},
                position: "center",
                callback: "{{ route('paiement.catalogue.kkiapay.callback') }}",
                data: "{{ $commande->id }}",
                theme: "#0d6efd",
                key: "VOTRE_CLE_PUBLIQUE_KKIAPAY",
                sandbox: true
            });

            addKkiapayListener('success', function(response) {
                window.location.href = "{{ route('paiement.catalogue.kkiapay.callback') }}?transaction_id=" + response.transactionId + "&commande_id={{ $commande->id }}";
            });

            addKkiapayListener('failed', function(response) {
                alert('Le paiement a échoué. Veuillez réessayer.');
            });
        }
    </script>
@endsection
