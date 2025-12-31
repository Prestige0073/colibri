@extends('emails.layouts.template')

@section('content')
<h2>🎉 Nouvelle inscription utilisateur</h2>

<p>Bonjour Admin,</p>

<p>Un nouvel utilisateur vient de s'inscrire sur la plateforme Colibri Littéraire.</p>

<div class="info-box">
    <h3 style="margin-top: 0;">Informations de l'utilisateur</h3>
    <p><strong>Nom:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Date d'inscription:</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</p>
    @if($user->telephone)
    <p><strong>Téléphone:</strong> {{ $user->telephone }}</p>
    @endif
</div>

<div style="text-align: center; margin: 30px 0;">
    <a href="{{ route('admin.users.show', $user->id) }}" class="button">Voir le profil utilisateur</a>
</div>

<p style="font-size: 12px; color: #666; margin-top: 30px;">
    Cet email est envoyé automatiquement. Ne pas répondre directement à ce message.
</p>
@endsection
