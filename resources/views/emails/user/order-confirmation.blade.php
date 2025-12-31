@extends('emails.layouts.template')

@section('content')
<h2>Confirmation de commande #{{ $commande->id }}</h2>

<p>Bonjour {{ $commande->user->name }},</p>

<p>Merci pour votre commande ! Nous avons bien reçu votre demande et nous la traitons actuellement.</p>

<div class="info-box">
    <p><strong>Détails de la commande</strong></p>
    <p>Numéro de commande: <strong>#{{ $commande->id }}</strong></p>
    <p>Date: {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
    <p>Statut: <strong style="color: #667eea;">{{ ucfirst($commande->statut) }}</strong></p>
</div>

<h3>Articles commandés</h3>

<table>
    <thead>
        <tr>
            <th>Livre</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($commande->items as $item)
        <tr>
            <td>{{ $item->catalogue->titre }}</td>
            <td>{{ $item->quantite }}</td>
            <td>{{ number_format($item->prix_unitaire, 0, ',', ' ') }} FCFA</td>
            <td><strong>{{ number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') }} FCFA</strong></td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="info-box" style="background-color: #e8f5e9; border-left-color: #4caf50;">
    <h3 style="margin-top: 0; color: #2e7d32;">Montant total: {{ number_format($commande->total, 0, ',', ' ') }} FCFA</h3>
    <p><strong>Méthode de paiement:</strong> {{ $commande->methode_paiement ?? 'Cash on Delivery' }}</p>
</div>

@if($commande->adresse_livraison)
<h3>Adresse de livraison</h3>
<div class="info-box">
    <p>{{ $commande->adresse_livraison }}</p>
    @if($commande->ville)
    <p>Ville: {{ $commande->ville }}</p>
    @endif
    @if($commande->telephone)
    <p>Téléphone: {{ $commande->telephone }}</p>
    @endif
</div>
@endif

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('commandes.show', $commande->id) }}" class="button">Voir ma commande</a>
</div>

<p>Nous vous tiendrons informé de l'évolution de votre commande par email.</p>

<p>Cordialement,<br>
<strong>L'équipe Colibri Littéraire</strong></p>
@endsection
