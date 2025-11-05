@extends('layouts.app')

@section('title', 'Paiement | Colibri Littéraire')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4 p-4" style="background: linear-gradient(135deg, #fff 60%, #198754 100%);">
                <h2 class="mb-4 text-center text-success"><i class="fa fa-credit-card me-2"></i>Paiement de votre panier</h2>
                <div class="mb-4">
                    <h5 class="mb-3">Récapitulatif de votre commande</h5>
                    <table class="table table-bordered align-middle bg-white rounded">
                        <thead class="table-light">
                            <tr>
                                <th>Livre</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td><strong>{{ $item->catalogue->titre }}</strong><br><small>{{ $item->catalogue->auteur }}</small></td>
                                <td>{{ $item->quantite }}</td>
                                <td>{{ $item->catalogue->prix }} FCFA</td>
                                <td>{{ $item->catalogue->prix * $item->quantite }} FCFA</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total à payer</th>
                                <th class="text-success fs-5">{{ $total }} FCFA</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <form method="POST" action="#" class="mb-3">
                    @csrf
                    <h5 class="mb-3">Choisissez votre moyen de paiement</h5>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="moyen" id="carte" value="carte" checked>
                                <label class="form-check-label" for="carte">
                                    <i class="fa fa-credit-card me-1"></i> Carte bancaire
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="moyen" id="mobile" value="mobile">
                                <label class="form-check-label" for="mobile">
                                    <i class="fa fa-mobile-alt me-1"></i> Paiement mobile (Momo, Orange Money...)
                                </label>
                            </div>
                        </div>
                        <!-- Option 'Payé à la livraison' retirée de ce groupe et placée plus bas dans une section dédiée -->
                    </div>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom sur la carte / Compte mobile</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="form-label">Numéro de carte / Téléphone</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 py-2 fs-5" id="payButton">
                        <i class="fa fa-lock me-2"></i>Payer {{ $total }} FCFA
                    </button>
                    
                </form>

                <!-- 'Payer à la livraison' retiré d'ici pour être présenté comme une section indépendante plus bas -->
                
                <div class="text-center">
                    <a href="{{ route('index') }}" class="btn btn-link text-secondary">Retour au catalogue</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Section indépendante pour Payé à la livraison -->
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            {{-- Use public/css/custom.css for cod styles; keep markup minimal: only a button (no input fields) --}}

            <div class="card shadow-sm border-0 rounded-4 p-4 cod-card" style="background: linear-gradient(135deg, #fff 60%, #198754 100%);">
                <h4 class="mb-3"><i class="fa fa-truck me-2"></i>Payer à la livraison</h4>
                <p class="small">Sélectionnez cette option pour enregistrer votre commande et être contacté(e) pour la livraison. Un agent vous contactera pour les détails.</p>
                <div id="codSection" class="mt-3 text-center">
                    <button type="button" class="btn btn-success w-100" id="codValidate">Payer à la livraison — Enregistrer la commande</button>
                </div>
            </div>
        </div>
    </div>
</div>
@php
    // Prepare a simple array representation of cart items for JavaScript to avoid Blade/PHP parsing issues
    $cartForJs = $cartItems->map(function($it){
        return [
            'catalogue_id' => $it->catalogue_id,
            'titre' => $it->catalogue->titre ?? '',
            'quantite' => $it->quantite,
            'prix' => $it->catalogue->prix ?? 0,
        ];
    })->toArray();
@endphp

@push('scripts')
<script>
    (function(){
        const codBtn = document.getElementById('codValidate');
        if (!codBtn) return;

        // Prepare cart items in a JS array from precomputed Blade variable
        const cartItems = @json($cartForJs);

        const total = {{ $total }};

        function uuidv4() {
            // simple idempotency key
            return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
                return v.toString(16);
            });
        }

        // Guard against double submissions
        let inProgress = false;

        function computeSum(items){
            return items.reduce((s,it) => s + (Number(it.prix||0) * Number(it.quantite||0)), 0);
        }

        codBtn.addEventListener('click', function(){
            if (inProgress) return;

            // basic client-side checks
            if (!Array.isArray(cartItems) || cartItems.length === 0) {
                alert('Votre panier est vide. Ajoutez des articles avant d\'enregistrer une commande.');
                return;
            }

            const clientSum = computeSum(cartItems);
            if (Number(clientSum) !== Number(total)) {
                // prevent accidental mismatch (cart changed quickly)
                alert('Le contenu du panier a changé. Merci de recharger la page et de vérifier votre panier avant de confirmer.');
                return;
            }

            inProgress = true;
            codBtn.disabled = true;
            const originalHtml = codBtn.innerHTML;
            codBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Enregistrement...';

            const payload = {
                items: cartItems,
                total: total,
                idempotency_key: uuidv4(),
                nom: document.getElementById('nom') ? document.getElementById('nom').value : null,
                tel: document.getElementById('numero') ? document.getElementById('numero').value : null,
                adresse: null,
            };

            fetch("{{ route('commande.cod') }}", {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').getAttribute('content') : '{{ csrf_token() }}'
                },
                body: JSON.stringify(payload)
            })
            .then(res => {
                if (!res.ok) {
                    throw new Error('Server responded with status ' + res.status);
                }
                const contentType = res.headers.get('content-type') || '';
                if (contentType.indexOf('application/json') === -1) {
                    return res.text().then(text => { throw new Error('Unexpected response: ' + text); });
                }
                return res.json();
            })
            .then(data => {
                if (data && data.success && data.commande_id) {
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success mt-3';
                    alert.innerHTML = `<strong>${data.message}</strong>`;
                    codBtn.closest('.card').querySelector('.card-body')?.prepend(alert);

                    const container = document.getElementById('codSection');
                    container.innerHTML = `
                        <div class="d-grid gap-2 text-center">
                            <p class="mb-2"><i class="fa fa-receipt text-success me-1"></i>Commande ${data.commande_id}</p>
                            <a href="https://wa.me/${data.contact_phone}?text=${encodeURIComponent('Bonjour, je confirme ma commande #' + data.commande_id)}" target="_blank" class="btn btn-success">WhatsApp</a>
                            <a href="tel:${data.contact_phone}" class="btn btn-outline-success">Appel direct</a>
                            <a href="mailto:${data.contact_email}?subject=${encodeURIComponent('Commande #' + data.commande_id)}" class="btn btn-outline-secondary">Email</a>
                        </div>
                    `;
                } else {
                    const msg = data && data.message ? data.message : 'Erreur lors de l\'enregistrement de la commande. Réessayez.';
                    alert(msg);
                    codBtn.disabled = false;
                    codBtn.innerHTML = originalHtml;
                    inProgress = false;
                }
            })
            .catch(err => {
                console.error('Fetch error:', err);
                // friendlier message for users
                alert('Impossible d\'enregistrer la commande pour le moment (problème réseau ou serveur). Réessayez dans un instant.');
                codBtn.disabled = false;
                codBtn.innerHTML = originalHtml;
                inProgress = false;
            });
        });
    })();
</script>
@endpush
@endsection
