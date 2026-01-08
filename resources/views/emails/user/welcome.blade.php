@extends('emails.layouts.template')

@section('content')
<h2>Bienvenue {{ $user->name }} !</h2>

<p>Nous sommes ravis de vous accueillir sur <strong>Colibri Littéraire</strong>, votre plateforme dédiée à la promotion de la lecture et de la littérature africaine.</p>

<div class="info-box">
    <p><strong>Votre compte a été créé avec succès !</strong></p>
    <p>Email: {{ $user->email }}</p>
    <p>Date d'inscription: {{ now()->format('d/m/Y') }}</p>
</div>

<h3>Que pouvez-vous faire maintenant ?</h3>

<ul>
    <li><strong>Explorer notre catalogue</strong> - Découvrez une sélection variée de livres africains</li>
    <li><strong>S'inscrire aux formations</strong> - Participez à nos formations en ligne</li>
    <li><strong>Emprunter des livres</strong> - Accédez à notre bibliothèque numérique</li>
    <li><strong>Obtenir des certificats</strong> - Complétez nos formations et recevez vos certifications</li>
</ul>

<div style="text-align: center; margin: 30px 0;">
    <a href="https://colibri-litteraire.com" class="button">Commencer l'exploration</a>
</div>

<p>Si vous avez des questions, n'hésitez pas à nous contacter à tout moment.</p>

<p>À très bientôt,<br>
<strong>L'équipe Colibri Littéraire</strong></p>
@endsection
