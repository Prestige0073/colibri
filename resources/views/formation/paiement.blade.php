@extends('layouts.app')

@section('title', 'Paiement - ' . $formation->titre)

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Résumé de la commande -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Résumé de votre inscription</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                @if($formation->image)
                                    <img src="{{ asset($formation->image) }}" class="img-fluid rounded" alt="{{ $formation->titre }}">
                                @endif
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $formation->titre }}</h4>
                                <p class="text-muted">{{ Str::limit($formation->description, 150) }}</p>
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="mb-1"><strong>Durée:</strong> {{ $formation->duree ?? 'N/A' }}</p>
                                        <p class="mb-1"><strong>Niveau:</strong> {{ $formation->niveau ?? 'Tous niveaux' }}</p>
                                        <p class="mb-1"><strong>Modules:</strong> {{ $formation->modules->count() }}</p>
                                    </div>
                                    <div class="text-end">
                                        <h3 class="text-success mb-0">{{ fcfa($formation->prix ?? 0) }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sélection du moyen de paiement -->
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-credit-card me-2"></i>Choisissez votre moyen de paiement</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('formation.traiter-paiement', $formation) }}" id="paymentForm">
                            @csrf
                            <input type="hidden" name="inscription_id" value="{{ $inscription->id }}">

                            <div class="row g-3 justify-content-center">
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

                            <div class="mt-4 d-flex justify-content-between align-items-center">
                                <a href="{{ route('formation.show', $formation) }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Retour
                                </a>
                                <button type="submit" class="btn btn-success btn-lg" id="submitPayment">
                                    <i class="fas fa-lock me-2"></i>Procéder au paiement
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Informations de sécurité -->
                <div class="alert alert-info mt-4">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Paiement sécurisé</strong> - Vos informations de paiement sont cryptées et sécurisées. Nous ne stockons jamais vos données bancaires.
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

        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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
    </style>

    <script>
        document.getElementById('paymentForm').addEventListener('submit', function(e) {
            const selectedMethod = document.querySelector('input[name="payment_method"]:checked');
            if (!selectedMethod) {
                e.preventDefault();
                alert('Veuillez sélectionner un moyen de paiement');
                return false;
            }
        });
    </script>
@endsection
