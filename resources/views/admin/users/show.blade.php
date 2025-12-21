@extends('admin.layout')

@section('title', 'Détails utilisateur')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-1"></i>Retour à la liste
            </a>
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0"><i class="fas fa-user me-2"></i>Détails de l'utilisateur</h1>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Modifier
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if($user->avatar)
                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=120" alt="{{ $user->name }}" class="rounded-circle mb-3">
                    @endif
                    <h4>{{ $user->name }}</h4>
                    <p class="text-muted">{{ $user->email }}</p>

                    <div class="mb-3">
                        @if($user->role === 'admin')
                            <span class="badge bg-danger fs-6"><i class="fas fa-crown me-1"></i>Administrateur</span>
                        @else
                            <span class="badge bg-secondary fs-6">Utilisateur</span>
                        @endif

                        @if($user->blocked)
                            <span class="badge bg-danger fs-6"><i class="fas fa-ban me-1"></i>Bloqué</span>
                        @else
                            <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>Actif</span>
                        @endif
                    </div>

                    <hr>

                    <div class="text-start">
                        <p class="mb-2"><strong>ID:</strong> #{{ $user->id }}</p>
                        <p class="mb-2"><strong>Inscrit le:</strong> {{ $user->created_at->format('d/m/Y à H:i') }}</p>
                        <p class="mb-0"><strong>Dernière mise à jour:</strong> {{ $user->updated_at->format('d/m/Y à H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            @if($user->id !== auth()->id())
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Actions rapides</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST" class="mb-2">
                        @csrf
                        <button type="submit" class="btn btn-{{ $user->blocked ? 'success' : 'warning' }} w-100">
                            <i class="fas fa-{{ $user->blocked ? 'unlock' : 'ban' }} me-1"></i>
                            {{ $user->blocked ? 'Débloquer' : 'Bloquer' }} l'utilisateur
                        </button>
                    </form>

                    <form action="{{ route('admin.users.change-role', $user) }}" method="POST" class="mb-2">
                        @csrf
                        <input type="hidden" name="role" value="{{ $user->role === 'admin' ? 'user' : 'admin' }}">
                        <button type="submit" class="btn btn-info w-100">
                            <i class="fas fa-exchange-alt me-1"></i>
                            Changer en {{ $user->role === 'admin' ? 'Utilisateur' : 'Admin' }}
                        </button>
                    </form>

                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </div>
            </div>
            @endif
        </div>

        <!-- Statistiques et activités -->
        <div class="col-md-8">
            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Total emprunts</p>
                                    <h3 class="mb-0">{{ $stats['total_emprunts'] }}</h3>
                                </div>
                                <div class="bg-primary bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-book fa-2x text-primary"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Emprunts en cours</p>
                                    <h3 class="mb-0">{{ $stats['emprunts_en_cours'] }}</h3>
                                </div>
                                <div class="bg-success bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-book-open fa-2x text-success"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Emprunts en retard</p>
                                    <h3 class="mb-0">{{ $stats['emprunts_en_retard'] }}</h3>
                                </div>
                                <div class="bg-danger bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p class="text-muted mb-1">Total achats</p>
                                    <h3 class="mb-0">{{ $stats['total_achats'] }}</h3>
                                </div>
                                <div class="bg-warning bg-opacity-10 p-3 rounded">
                                    <i class="fas fa-shopping-cart fa-2x text-warning"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Derniers emprunts -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Derniers emprunts</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Livre</th>
                                    <th>Date emprunt</th>
                                    <th>Date retour</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user->emprunts as $emprunt)
                                <tr>
                                    <td>{{ $emprunt->livre->titre ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($emprunt->statut) {
                                                'en_cours' => 'bg-success',
                                                'en_attente' => 'bg-warning',
                                                'en_retard' => 'bg-danger',
                                                'retourne' => 'bg-secondary',
                                                default => 'bg-info'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Aucun emprunt</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supprimer -->
@if($user->id !== auth()->id())
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">Supprimer l'utilisateur</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer définitivement <strong>{{ $user->name }}</strong> ?</p>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Attention !</strong> Cette action est irréversible.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
