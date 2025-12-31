@extends('layouts.app')

@section('title', 'Paiement Lygos')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card shadow">
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">
                            <img src="https://lygos.money/assets/images/logo.png" alt="Lygos" style="max-height: 40px;" onerror="this.innerHTML='<span class=\'text-white\'>Lygos Payment</span>';">
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h5>Commande #{{ $commande->id }}</h5>
                            <h2 class="text-success">{{ number_format($montant, 0, ',', ' ') }} FCFA</h2>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Vous allez être redirigé vers Lygos pour effectuer le paiement de manière sécurisée.
                        </div>

                        <form method="POST" action="{{ route('paiement.catalogue.lygos.process') }}">
                            @csrf
                            <input type="hidden" name="commande_id" value="{{ $commande->id }}">
                            <input type="hidden" name="amount" value="{{ $montant }}">

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-lock me-2"></i>Payer {{ number_format($montant, 0, ',', ' ') }} FCFA
                                </button>
                                <a href="{{ route('panier.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Annuler
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
