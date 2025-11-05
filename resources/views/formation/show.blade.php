@extends('layouts.app')

@section('title', $formation->titre)
@section('meta_description', Str::limit($formation->description, 150))

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    @if($formation->image)
                        <img src="{{ asset($formation->image) }}" class="card-img-top" alt="{{ $formation->titre }}">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $formation->titre }}</h2>
                        <p class="card-text">{{ $formation->description }}</p>
                        <p><strong>Durée :</strong> {{ $formation->duree ?? 'N/A' }}</p>
                        <p><strong>Niveau :</strong> {{ $formation->niveau ?? 'Tous niveaux' }}</p>
                        <p><strong>Prix :</strong> {{ number_format($formation->prix ?? 0, 2, ',', ' ') }}€</p>

                        <form method="POST" action="{{ route('formation.acheter', $formation) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Acheter / S'inscrire</button>
                        </form>
                    </div>
                </div>

                <h3>Modules ({{ $formation->modules->count() }})</h3>
                <div class="list-group">
                    @forelse($formation->modules as $module)
                        <div class="list-group-item">
                            <h5>{{ $module->titre }}</h5>
                            <p>{{ $module->description ?? '' }}</p>
                            <small>Durée : {{ $module->duree ?? 'N/A' }}</small>
                            <a href="#" class="btn btn-primary btn-sm float-end">Voir le module</a>
                        </div>
                    @empty
                        <p>Aucun module pour cette formation.</p>
                    @endforelse
                </div>
            </div>
            <div class="col-md-4">
                <!-- Sidebar: informations rapides -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Informations</h5>
                        <p>Modules : {{ $formation->modules->count() }}</p>
                        <p>Prix : {{ number_format($formation->prix ?? 0, 2, ',', ' ') }}€</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
