@extends('layouts.app')
{{-- Page désactivée : le panier n'est plus accessible ici --}}
@section('title', 'Mon panier | Colibri Littéraire')
@section('content')
<div class="container py-5">
    <h1 class="mb-4">Mon panier</h1>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if($items->isEmpty())
        <p>Votre panier est vide.</p>
    @else
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->catalogue->titre }}</strong><br>
                        <small>{{ $item->catalogue->auteur }}</small>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('panier.modifier', $item->id) }}" style="display:inline-block; width: 120px;">
                            @csrf
                            <input type="number" name="quantite" min="1" max="{{ $item->catalogue->quantite }}" value="{{ $item->quantite }}" class="form-control form-control-sm" style="width: 70px; display: inline-block;">
                            <button type="submit" class="btn btn-sm btn-success" style="margin-left: 4px;">
                                <i class="fa fa-sync"></i>
                            </button>
                        </form>
                    </td>
                    <td>{{ $item->catalogue->prix }} FCFA</td>
                    <td>{{ $item->catalogue->prix * $item->quantite }} FCFA</td>
                    <td>
                        <form method="POST" action="{{ route('panier.supprimer', $item->id) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Retirer ce livre du panier ?')">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total général</th>
                    <th>
                        {{ $items->sum(fn($i) => $i->catalogue->prix * $i->quantite) }} FCFA
                    </th>
                </tr>
            </tfoot>
        </table>
    @endif
    <a href="{{ route('index') }}" class="btn btn-secondary mt-3">Retour au catalogue</a>
</div>
@endsection
