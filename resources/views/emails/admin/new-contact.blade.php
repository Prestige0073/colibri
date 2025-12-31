@extends('emails.layouts.template')

@section('content')
<h2>✉️ Nouveau message de contact</h2>

<p>Bonjour Admin,</p>

<p>Un nouveau message a été envoyé via le formulaire de contact.</p>

<div class="info-box">
    <h3 style="margin-top: 0;">Informations de l'expéditeur</h3>
    <p><strong>Nom:</strong> {{ $contact->name }}</p>
    <p><strong>Email:</strong> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
    <p><strong>Date:</strong> {{ $contact->created_at->format('d/m/Y à H:i') }}</p>
</div>

<div class="info-box" style="background-color: #fff3e0; border-left-color: #ff9800;">
    <h3 style="margin-top: 0; color: #e65100;">Sujet</h3>
    <p style="font-size: 16px; font-weight: bold; color: #333;">{{ $contact->subject }}</p>
</div>

<div class="info-box">
    <h3 style="margin-top: 0;">Message</h3>
    <p style="white-space: pre-wrap; line-height: 1.6;">{{ $contact->message }}</p>
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="mailto:{{ $contact->email }}" class="button">Répondre par email</a>
</div>

<p style="font-size: 12px; color: #666; margin-top: 30px;">
    Pour répondre à ce message, cliquez sur le bouton ci-dessus ou envoyez un email directement à {{ $contact->email }}.
</p>
@endsection
