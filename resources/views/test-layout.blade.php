@extends('layouts.app')

@section('title', 'Test Layout')

@section('content')
<div class="container py-5">
    <div class="alert alert-success">
        <h1>Test du Layout</h1>
        <p>Si vous voyez le menu de navigation (Accueil, Apprendre, Catalogue, etc.) en haut de cette page, alors le layout fonctionne correctement.</p>
        <p>Si vous ne voyez PAS le menu, alors il y a un problème avec le fichier layouts/app.blade.php</p>
    </div>
</div>
@endsection
