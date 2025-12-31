@extends('emails.layouts.template')

@section('content')
<h2>🛒 Nouvelle commande reçue</h2>

<p>Bonjour Admin,</p>

<p>Une nouvelle commande vient d'être passée sur la plateforme.</p>

<div class="info-box">
    <h3 style="margin-top: 0;">Informations de la commande</h3>
    <p><strong>Numéro:</strong> #{{ $commande->id }}</p>
    <p><strong>Date:</strong> {{ $commande->created_at->format('d/m/Y à H:i') }}</p>
    <p><strong>Client:</strong> {{ $commande->user->name }} ({{ $commande->user->email }})</p>
    <p><strong>Montant total:</strong> <span style="color: #4caf50; font-size: 18px; font-weight: bold;">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</span></p>
    <p><strong>Statut:</strong> {{ ucfirst($commande->statut) }}</p>
    <p><strong>Méthode de paiement:</strong> {{ $commande->methode_paiement ?? 'Cash on Delivery' }}</p>
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
    <a href="{{ route('admin.commandes.show', $commande->id) }}" class="button">Gérer la commande</a>
</div>

<p style="font-size: 12px; color: #666; margin-top: 30px;">
    Pensez à traiter cette commande rapidement pour garantir la satisfaction du client.
</p>
@endsection
