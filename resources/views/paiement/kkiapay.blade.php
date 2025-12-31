@extends('layouts.app')

@section('title', 'Paiement Kkiapay')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-mobile-alt me-2"></i>Paiement via Kkiapay</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>{{ $formation->titre }}</h5>
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
                            <a href="{{ route('paiement.annuler', $inscription->id) }}" class="btn btn-outline-secondary">
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
            // Configuration Kkiapay
            // IMPORTANT: Remplacez 'VOTRE_CLE_PUBLIQUE_KKIAPAY' par votre vraie clé publique
            openKkiapayWidget({
                amount: {{ $montant }},
                position: "center",
                callback: "{{ route('paiement.kkiapay.callback') }}",
                data: "{{ $inscription->id }}",
                theme: "#0d6efd",
                key: "VOTRE_CLE_PUBLIQUE_KKIAPAY", // À remplacer par votre clé publique Kkiapay
                sandbox: true // Mettre false en production
            });

            // Écouter les événements Kkiapay
            addKkiapayListener('success', function(response) {
                console.log('Paiement réussi:', response);
                // Rediriger vers le callback avec les données de transaction
                window.location.href = "{{ route('paiement.kkiapay.callback') }}?transaction_id=" + response.transactionId + "&inscription_id={{ $inscription->id }}";
            });

            addKkiapayListener('failed', function(response) {
                console.log('Paiement échoué:', response);
                alert('Le paiement a échoué. Veuillez réessayer.');
            });
        }
    </script>
@endsection
