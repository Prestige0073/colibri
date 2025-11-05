@extends('layouts.app')

@section('title', 'Emprunts')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Bibliothèque — Emprunts</h1>

    <div class="row">
        <div class="col-md-8">
            <h4>Livres disponibles à l'emprunt</h4>
            @if($livres->isEmpty())
                <p class="text-muted">Aucun livre disponible pour emprunt.</p>
            @else
                <div class="list-group">
                    @foreach($livres as $livre)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong>{{ $livre->titre }}</strong>
                                <div class="small text-muted">{{ $livre->auteur ?? '' }}</div>
                            </div>
                            <div>
                                <form method="POST" action="{{ route('bibliotheque.emprunter') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="livre_id" value="{{ $livre->id }}">
                                    <button class="btn btn-primary">Emprunter</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-4">
            <h4>Mes emprunts</h4>
            @if($emprunts->isEmpty())
                <p class="text-muted">Vous n'avez pas d'emprunt en cours.</p>
            @else
                <ul class="list-group">
                    @foreach($emprunts as $e)
                        <li class="list-group-item">
                            <strong>{{ $e->livre->titre ?? '—' }}</strong>
                            <div class="small text-muted">Demandé le {{ optional($e->date_emprunt)->format('d/m/Y') }}</div>
                            <div class="mt-1">Statut : <span class="badge bg-secondary">{{ $e->statut }}</span></div>
                            <form action="{{ route('emprunts.destroy', $e->id) }}" method="POST" class="mt-2">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
