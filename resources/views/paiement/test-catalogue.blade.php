@extends('layouts.app')

@section('title', 'Paiement TEST - Commande')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-warning border-3">
                <div class="card-header bg-warning text-dark text-center py-3">
                    <h3 class="mb-0">
                        <i class="fa fa-flask me-2"></i>MODE TEST / SIMULATION
                    </h3>
                    <small class="d-block mt-2">Ce paiement est fictif et ne sera pas réellement facturé</small>
                </div>

                <div class="card-body p-4">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>
                        <strong>Mode Test activé</strong><br>
                        Ce moyen de paiement est conçu pour tester les fonctionnalités sans effectuer de vrai paiement.
                        Utilisez-le pour vérifier que tout fonctionne correctement.
                    </div>

                    <h4 class="text-success mb-4">
                        <i class="fa fa-shopping-cart me-2"></i>Commande #{{ $commande->id }}
                    </h4>

                    <div class="mb-4">
                        <h5 class="mb-3">Articles de la commande</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Livre</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-end">Prix unitaire</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($commande->items && $commande->items->count() > 0)
                                        @foreach($commande->items as $item)
                                        <tr>
                                            <td>
                                                <strong>{{ $item->titre }}</strong>
                                                @if($item->auteur)
                                                    <br><small class="text-muted">{{ $item->auteur }}</small>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $item->quantite }}</td>
                                            <td class="text-end">{{ number_format($item->prix, 0, ',', ' ') }} FCFA</td>
                                            <td class="text-end"><strong>{{ number_format($item->prix * $item->quantite, 0, ',', ' ') }} FCFA</strong></td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Aucun article dans cette commande</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="table-success">
                                        <th colspan="3" class="text-end">Total à payer</th>
                                        <th class="text-end fs-5">{{ number_format($montant, 0, ',', ' ') }} FCFA</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('paiement.test.catalogue.validate', $commande->id) }}" id="testPaymentForm">
                        @csrf

                        <div class="alert alert-warning border-warning">
                            <h5><i class="fa fa-exclamation-triangle me-2"></i>Simulation de paiement</h5>
                            <p class="mb-2">En cliquant sur "Simuler le paiement", vous allez:</p>
                            <ul class="mb-0">
                                <li>Valider instantanément la commande</li>
                                <li>Confirmer tous les articles</li>
                                <li>Vider automatiquement le panier</li>
                                <li>Recevoir un email de confirmation</li>
                                <li>Obtenir une référence de commande TEST</li>
                            </ul>
                        </div>

                        <div class="bg-light p-4 rounded mb-4">
                            <h5 class="mb-3"><i class="fa fa-check-circle text-success me-2"></i>Informations de simulation</h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Montant à simuler</label>
                                    <input type="text" class="form-control" value="{{ number_format($montant, 0, ',', ' ') }} FCFA" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Statut de simulation</label>
                                    <input type="text" class="form-control bg-success text-white" value="✓ SUCCÈS GARANTI" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nombre d'articles</label>
                                    <input type="text" class="form-control" value="{{ $commande->items ? $commande->items->count() : 0 }} article(s)" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Référence qui sera générée</label>
                                    <input type="text" class="form-control" value="TEST-XXXXXXXX" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-3">
                            <button type="submit" class="btn btn-warning btn-lg py-3">
                                <i class="fa fa-flask me-2"></i>
                                <strong>SIMULER LE PAIEMENT DE {{ number_format($montant, 0, ',', ' ') }} FCFA</strong>
                            </button>

                            <a href="{{ route('panier.index') }}" class="btn btn-outline-secondary">
                                <i class="fa fa-arrow-left me-2"></i>Retour au panier
                            </a>
                        </div>
                    </form>
                </div>

                <div class="card-footer bg-light text-muted text-center">
                    <small>
                        <i class="fa fa-info-circle me-1"></i>
                        Ce mode est uniquement destiné aux tests. Aucun paiement réel ne sera effectué.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('testPaymentForm').addEventListener('submit', function(e) {
    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Simulation en cours...';
});
</script>
@endpush
@endsection
