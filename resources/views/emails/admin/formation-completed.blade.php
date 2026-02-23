@extends('emails.layouts.template')

@section('content')
<h2>🎓 Formation terminée - Certificat à générer</h2>

<p>Bonjour Admin,</p>

<p>Un apprenant vient de <strong>terminer une formation</strong> et est éligible à la génération d'un certificat.</p>

<div class="info-box">
    <h3 style="margin-top: 0;">Informations de l'apprenant</h3>
    <p><strong>Nom:</strong> {{ $inscription->user->name }}</p>
    <p><strong>Email:</strong> {{ $inscription->user->email }}</p>
    @if($inscription->user->phone)
    <p><strong>Téléphone:</strong> {{ $inscription->user->phone }}</p>
    @endif
</div>

<div class="info-box">
    <h3 style="margin-top: 0;">Informations de la formation</h3>
    <p><strong>Formation:</strong> {{ $inscription->formation->titre }}</p>
    <p><strong>Progression:</strong> <span style="color: #4caf50; font-size: 18px; font-weight: bold;">100%</span></p>
    @if($bestScore !== null)
    <p><strong>Meilleure note au quiz:</strong> <span style="color: #2196f3; font-size: 18px; font-weight: bold;">{{ number_format($bestScore, 1) }}%</span></p>
    @endif
    <p><strong>Date d'inscription:</strong> {{ $inscription->date_inscription ? \Carbon\Carbon::parse($inscription->date_inscription)->format('d/m/Y') : 'N/A' }}</p>
    <p><strong>Date de fin:</strong> {{ now()->format('d/m/Y à H:i') }}</p>
</div>

<div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 4px;">
    <p style="margin: 0; color: #856404;">
        <strong>⚠️ Action requise:</strong> Veuillez générer le certificat pour cet apprenant depuis l'espace administration.
    </p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('admin.certifications.index') }}" class="button">Générer le certificat</a>
</div>

<p style="font-size: 12px; color: #666; margin-top: 30px;">
    Cet email est envoyé automatiquement lorsqu'un apprenant termine tous les modules et quiz d'une formation.
</p>
@endsection
