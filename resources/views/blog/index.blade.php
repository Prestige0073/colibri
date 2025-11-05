@extends('layouts.app')

@section('title', 'Blog | Colibri Littéraire')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1>Blog</h1>
            <p class="text-muted">Articles, actualités et ressources du projet Colibri Littéraire.</p>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">Aucun article pour l'instant. Vous pouvez ajouter des posts via l'admin.</div>
            </div>
        </div>
    </div>
@endsection
