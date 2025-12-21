@extends('admin.layout')

@section('title', 'Gestion des utilisateurs')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0"><i class="fas fa-users me-2"></i>Gestion des utilisateurs</h1>
                <p class="text-muted mb-0">{{ $users->total() }} utilisateur(s) au total</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nouvel utilisateur
            </a>
        </div>
    </div>

    <!-- Filtres et recherche -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <!-- Recherche -->
                <div class="col-md-4">
                    <label for="search" class="form-label">Rechercher</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="search" name="search" value="{{ request('search') }}" placeholder="Nom ou email...">
                    </div>
                </div>

                <!-- Filtre par rôle -->
                <div class="col-md-3">
                    <label for="role" class="form-label">Rôle</label>
                    <select class="form-select" id="role" name="role">
                        <option value="">Tous les rôles</option>
                        <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Utilisateur</option>
                    </select>
                </div>

                <!-- Filtre par statut -->
                <div class="col-md-3">
                    <label for="status" class="form-label">Statut</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>Bloqué</option>
                    </select>
                </div>

                <!-- Boutons -->
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-filter me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 200px;">Utilisateur</th>
                            <th style="width: 200px;">Email</th>
                            <th style="width: 120px;">Rôle</th>
                            <th style="width: 100px;">Statut</th>
                            <th style="width: 150px;">Statistiques</th>
                            <th style="width: 100px;">Inscrit le</th>
                            <th class="text-center" style="width: 70px;">Voir</th>
                            <th class="text-center" style="width: 70px;">Modifier</th>
                            <th class="text-center" style="width: 70px;">Bloquer</th>
                            <th class="text-center" style="width: 70px;">Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td class="align-middle">#{{ $user->id }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    @if($user->avatar)
                                        <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=40" alt="{{ $user->name }}" class="rounded-circle me-2">
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ $user->name }}</div>
                                        @if($user->id === auth()->id())
                                            <span class="badge bg-info text-white small">Vous</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">
                                @if($user->role === 'admin')
                                    <span class="badge bg-danger"><i class="fas fa-crown me-1"></i>Admin</span>
                                @else
                                    <span class="badge bg-secondary">Utilisateur</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                @if($user->blocked)
                                    <span class="badge bg-danger"><i class="fas fa-ban me-1"></i>Bloqué</span>
                                @else
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Actif</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                <small class="text-muted">
                                    <i class="fas fa-book me-1"></i>{{ $user->emprunts_count }} emprunts<br>
                                    <i class="fas fa-shopping-cart me-1"></i>{{ $user->cart_items_count }} achats
                                </small>
                            </td>
                            <td class="align-middle">
                                <small>{{ $user->created_at->format('d/m/Y') }}</small>
                            </td>

                            <!-- Bouton Voir -->
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>

                            <!-- Bouton Modifier -->
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>

                            <!-- Bouton Bloquer/Débloquer -->
                            <td class="align-middle text-center">
                                @if($user->id !== auth()->id())
                                    <button type="button" class="btn btn-sm {{ $user->blocked ? 'btn-success' : 'btn-secondary' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#toggleBlockModal{{ $user->id }}"
                                            title="{{ $user->blocked ? 'Débloquer' : 'Bloquer' }}">
                                        <i class="fas fa-{{ $user->blocked ? 'unlock' : 'ban' }}"></i>
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <!-- Bouton Supprimer -->
                            <td class="align-middle text-center">
                                @if($user->id !== auth()->id())
                                    <button type="button" class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $user->id }}"
                                            title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>

                        <!-- Modal Bloquer/Débloquer -->
                        @if($user->id !== auth()->id())
                        <div class="modal fade" id="toggleBlockModal{{ $user->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">
                                            {{ $user->blocked ? 'Débloquer' : 'Bloquer' }} l'utilisateur
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Êtes-vous sûr de vouloir {{ $user->blocked ? 'débloquer' : 'bloquer' }} <strong>{{ $user->name }}</strong> ?</p>
                                        @if(!$user->blocked)
                                            <div class="alert alert-warning">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                L'utilisateur ne pourra plus se connecter à son compte.
                                            </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.users.toggle-block', $user) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-{{ $user->blocked ? 'success' : 'warning' }}">
                                                <i class="fas fa-{{ $user->blocked ? 'unlock' : 'ban' }} me-1"></i>
                                                {{ $user->blocked ? 'Débloquer' : 'Bloquer' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Supprimer -->
                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1">
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
                                            <strong>Attention !</strong> Cette action est irréversible. Toutes les données de l'utilisateur seront supprimées.
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

                        @empty
                        <tr>
                            <td colspan="11" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun utilisateur trouvé</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
        <div class="card-footer">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
