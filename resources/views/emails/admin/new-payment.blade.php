@extends('emails.layouts.template')

@section('content')
<h2>💰 Nouveau paiement reçu</h2>

<p>Bonjour Admin,</p>

<p>Un nouveau paiement vient d'être effectué pour une formation.</p>

<div class="info-box">
    <h3 style="margin-top: 0;">Informations du paiement</h3>
    <p><strong>Formation:</strong> {{ $inscription->formation->titre }}</p>
    <p><strong>Étudiant:</strong> {{ $inscription->user->name }} ({{ $inscription->user->email }})</p>
    <p><strong>Montant:</strong> <span style="color: #4caf50; font-size: 18px; font-weight: bold;">{{ number_format($inscription->montant_paye, 0, ',', ' ') }} FCFA</span></p>
    <p><strong>Date:</strong> {{ $inscription->updated_at->format('d/m/Y à H:i') }}</p>
    @if($inscription->reference_paiement)
    <p><strong>Référence de paiement:</strong> {{ $inscription->reference_paiement }}</p>
    @endif
    <p><strong>Statut:</strong> <span style="color: #4caf50; font-weight: bold;">{{ $inscription->paiement_valide ? 'Validé' : 'En attente' }}</span></p>
</div>

<div class="info-box">
    <h3 style="margin-top: 0;">Informations de l'étudiant</h3>
    <p><strong>Nom:</strong> {{ $inscription->user->name }}</p>
    <p><strong>Email:</strong> {{ $inscription->user->email }}</p>
    @if($inscription->user->phone)
    <p><strong>Téléphone:</strong> {{ $inscription->user->phone }}</p>
    @endif
    <p><strong>Date d'inscription:</strong> {{ $inscription->date_inscription ? \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y à H:i') : 'N/A' }}</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('admin.achats.index') }}" class="button">Voir tous les paiements</a>
</div>

<p style="font-size: 12px; color: #666; margin-top: 30px;">
    Cet email est envoyé automatiquement. Ne pas répondre directement à ce message.
</p>
@endsection
