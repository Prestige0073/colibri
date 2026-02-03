@extends('admin.layout')

@section('title', 'Gestion des Administrateurs')
@section('subtitle', 'Gérer les semi-admins et leurs permissions')

@section('content')
<div class="container-fluid">
    <!-- Header Actions -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="fas fa-user-shield text-primary me-2"></i>Administrateurs</h5>
                    <p class="text-muted mb-0 small">Gérer les accès et permissions</p>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Nouvel Administrateur
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.admins.index') }}" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Rechercher par nom, email, téléphone..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="role" class="form-select">
                        <option value="">Tous les rôles</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                        <option value="suspended" {{ request('status') == 'suspended' ? 'selected' : '' }}>Suspendu</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i>Filtrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Admins Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            @if($admins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Administrateur</th>
                                <th>Rôle</th>
                                <th>Contact</th>
                                <th>Statut</th>
                                <th>Créé par</th>
                                <th>Dernière connexion</th>
                                <th class="text-end pe-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-primary text-white me-3">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-semibold">{{ $admin->name }}</div>
                                                <div class="text-muted small">{{ $admin->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($admin->role)
                                            <span class="badge {{ $admin->role->is_predefined ? 'bg-primary' : 'bg-secondary' }} bg-opacity-10 text-dark border">
                                                <i class="fas fa-{{ $admin->role->is_predefined ? 'tag' : 'user-cog' }} me-1"></i>
                                                {{ $admin->role->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary bg-opacity-10 text-dark border">
                                                <i class="fas fa-ban me-1"></i>Aucun rôle
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="small">
                                            @if($admin->phone)
                                                <i class="fas fa-phone text-muted me-1"></i>{{ $admin->phone }}
                                            @else
                                                <span class="text-muted">Non renseigné</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($admin->status === 'active')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success">
                                                <i class="fas fa-check-circle me-1"></i>Actif
                                            </span>
                                        @elseif($admin->status === 'suspended')
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">
                                                <i class="fas fa-pause-circle me-1"></i>Suspendu
                                            </span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger">
                                                <i class="fas fa-times-circle me-1"></i>Inactif
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($admin->creator)
                                            <div class="small">{{ $admin->creator->name }}</div>
                                        @else
                                            <span class="text-muted small">Système</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($admin->last_login_at)
                                            <div class="small">{{ $admin->last_login_at->diffForHumans() }}</div>
                                            <div class="text-muted" style="font-size: 0.7rem;">{{ $admin->last_login_at->format('d/m/Y H:i') }}</div>
                                        @else
                                            <span class="text-muted small">Jamais connecté</span>
                                        @endif
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.admins.show', $admin) }}" class="btn btn-outline-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-outline-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Supprimer"
                                                onclick="confirmDelete({{ $admin->id }}, '{{ $admin->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <form id="delete-form-{{ $admin->id }}" action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($admins->hasPages())
                    <div class="card-footer bg-white border-top">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted small">
                                Affichage de {{ $admins->firstItem() }} à {{ $admins->lastItem() }} sur {{ $admins->total() }} résultats
                            </div>
                            <div>
                                {{ $admins->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-shield text-muted mb-3" style="font-size: 4rem; opacity: 0.3;"></i>
                    <h5 class="text-muted">Aucun administrateur trouvé</h5>
                    <p class="text-muted">Commencez par créer un nouvel administrateur.</p>
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary mt-3">
                        <i class="fas fa-plus me-1"></i>Créer un administrateur
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 1.1rem;
    }
</style>
@endpush

@push('scripts')
<script>
    function confirmDelete(adminId, adminName) {
        if (confirm(`Êtes-vous sûr de vouloir supprimer l'administrateur "${adminName}" ?\n\nCette action est irréversible.`)) {
            document.getElementById('delete-form-' + adminId).submit();
        }
    }
</script>
@endpush
@endsection
