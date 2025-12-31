@extends('emails.layouts.template')

@section('content')
<h2>Paiement confirmé !</h2>

<p>Bonjour {{ $inscription->user->name }},</p>

<p>Nous avons le plaisir de vous confirmer que votre paiement a été reçu avec succès.</p>

<div class="info-box" style="background-color: #e8f5e9; border-left-color: #4caf50;">
    <h3 style="margin-top: 0; color: #2e7d32;">Détails du paiement</h3>
    <p><strong>Formation:</strong> {{ $inscription->formation->titre }}</p>
    <p><strong>Montant payé:</strong> <span style="color: #4caf50; font-size: 18px; font-weight: bold;">{{ number_format($inscription->montant_paye, 0, ',', ' ') }} FCFA</span></p>
    <p><strong>Date de paiement:</strong> {{ $inscription->updated_at->format('d/m/Y à H:i') }}</p>
    @if($inscription->reference_paiement)
    <p><strong>Référence:</strong> {{ $inscription->reference_paiement }}</p>
    @endif
</div>

<h3>Accédez maintenant à votre formation</h3>

<p>Vous pouvez maintenant accéder à tous les modules et ressources de la formation <strong>{{ $inscription->formation->titre }}</strong>.</p>

<div class="info-box">
    <h4 style="margin-top: 0;">Ce que vous allez apprendre :</h4>
    <p>{{ $inscription->formation->description }}</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('formation.show', $inscription->formation_id) }}" class="button">Commencer la formation</a>
</div>

<p style="font-size: 12px; color: #666; margin-top: 30px;">
    Si vous avez des questions concernant votre formation, n'hésitez pas à nous contacter.
</p>

<p>Bonne formation,<br>
<strong>L'équipe Colibri Littéraire</strong></p>
@endsection
