@extends('layouts.app')

@section('title', 'Paiement Lygos')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0"><i class="fas fa-wallet me-2"></i>Paiement via Lygos</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>{{ $formation->titre }}</h5>
                            <h2 class="text-success">{{ number_format($montant, 0, ',', ' ') }} FCFA</h2>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous allez être redirigé vers Lygos pour effectuer le paiement de manière sécurisée.
                        </div>

                        <form method="POST" action="{{ route('paiement.lygos.process') }}" id="lygosForm">
                            @csrf
                            <input type="hidden" name="inscription_id" value="{{ $inscription->id }}">
                            <input type="hidden" name="amount" value="{{ $montant }}">
                            <input type="hidden" name="formation_id" value="{{ $formation->id }}">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-lock me-2"></i>Payer {{ number_format($montant, 0, ',', ' ') }} FCFA
                                </button>
                                <a href="{{ route('paiement.annuler', $inscription->id) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="alert alert-warning mt-4">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Note:</strong> L'intégration Lygos nécessite une configuration avec vos identifiants API Lygos.
                </div>
            </div>
        </div>
    </div>

    <script>
        // TODO: Intégrer le SDK Lygos selon leur documentation
        // Exemple de redirection vers l'API Lygos
        document.getElementById('lygosForm').addEventListener('submit', function(e) {
            // Pour l'instant, simuler le paiement (à remplacer par l'intégration réelle)
            // e.preventDefault();
            // Rediriger vers l'API Lygos avec les paramètres appropriés
        });
    </script>
@endsection
