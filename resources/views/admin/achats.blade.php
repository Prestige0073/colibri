@extends('admin.layout')

@section('title', 'Les Achats')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-shopping-bag me-2 text-primary"></i>Les Achats
                    </h1>
                    <p class="text-muted mb-0">Gestion des ventes de livres du catalogue</p>
                </div>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">En préparation</p>
                            <h3 class="mb-0 fw-bold">{{ $commandes->where('statut', 'pending')->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0dcaf0 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">En livraison</p>
                            <h3 class="mb-0 fw-bold">{{ $commandes->where('statut', 'en_livraison')->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-truck fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Livrées</p>
                            <h3 class="mb-0 fw-bold">{{ $commandes->where('statut', 'livre')->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #6f42c1 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Chiffre d'affaires</p>
                            <h3 class="mb-0 fw-bold">{{ number_format($commandes->sum('total'), 0, ',', ' ') }}</h3>
                            <small class="text-muted">FCFA</small>
                        </div>
                        <div class="bg-purple bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-coins fa-2x" style="color: #6f42c1;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Liste des commandes -->
    @if($commandes->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun achat pour le moment</h5>
                <p class="text-muted mb-0">Les achats de livres apparaîtront ici.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">#Commande</th>
                                <th>Client</th>
                                <th>Contact</th>
                                <th>Livres</th>
                                <th>Montant</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th width="150">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commandes as $commande)
                                <tr class="{{ $commande->statut === 'pending' ? 'table-warning' : '' }}">
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            #{{ str_pad($commande->id, 4, '0', STR_PAD_LEFT) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $commande->nom }}</strong>
                                    </td>
                                    <td>
                                        <small>
                                            <i class="fas fa-phone text-muted me-1"></i>{{ $commande->telephone }}<br>
                                            <i class="fas fa-map-marker-alt text-muted me-1"></i>{{ Str::limit($commande->adresse, 30) }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            @foreach($commande->items as $item)
                                                <small>
                                                    <span class="badge bg-light text-dark">{{ $item->quantite }}x</span>
                                                    {{ Str::limit($item->catalogue->titre ?? 'Livre supprimé', 40) }}
                                                </small>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-success">{{ number_format($commande->total, 0, ',', ' ') }} FCFA</strong>
                                    </td>
                                    <td>
                                        @if($commande->statut === 'pending')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>En préparation
                                            </span>
                                        @elseif($commande->statut === 'en_livraison')
                                            <span class="badge bg-info">
                                                <i class="fas fa-truck me-1"></i>En livraison
                                            </span>
                                        @elseif($commande->statut === 'livre')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Livrée
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Annulée
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $commande->created_at->format('d/m/Y') }}
                                            <br>
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $commande->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.commandes.show', $commande->id) }}"
                                               class="btn btn-sm btn-primary"
                                               title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if($commande->statut !== 'livre' && $commande->statut !== 'annule')
                                                <button type="button"
                                                        class="btn btn-sm btn-success"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#statusModal{{ $commande->id }}"
                                                        title="Changer le statut">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal de changement de statut -->
                                @if($commande->statut !== 'livre' && $commande->statut !== 'annule')
                                    <div class="modal fade" id="statusModal{{ $commande->id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $commande->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary text-white">
                                                    <h5 class="modal-title" id="statusModalLabel{{ $commande->id }}">
                                                        <i class="fas fa-exchange-alt me-2"></i>Changer le statut
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-3">Commande <strong>#{{ str_pad($commande->id, 4, '0', STR_PAD_LEFT) }}</strong> - {{ $commande->nom }}</p>

                                                    <form action="{{ route('admin.commandes.updateStatus', $commande->id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')

                                                        <div class="mb-3">
                                                            <label class="form-label">Nouveau statut</label>
                                                            <select name="statut" class="form-select" required>
                                                                <option value="pending" {{ $commande->statut === 'pending' ? 'selected' : '' }}>En préparation</option>
                                                                <option value="en_livraison" {{ $commande->statut === 'en_livraison' ? 'selected' : '' }}>En livraison</option>
                                                                <option value="livre" {{ $commande->statut === 'livre' ? 'selected' : '' }}>Livrée</option>
                                                                <option value="annule">Annulée</option>
                                                            </select>
                                                        </div>

                                                        <div class="d-flex justify-content-end gap-2">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                                <i class="fas fa-times me-2"></i>Annuler
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="fas fa-check me-2"></i>Mettre à jour
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .table-warning {
        background-color: #fff3cd44 !important;
    }

    .table > tbody > tr:hover {
        background-color: #f8f9fa;
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }

    .bg-purple {
        background-color: rgba(111, 66, 193, 0.1);
    }
</style>
@endpush
