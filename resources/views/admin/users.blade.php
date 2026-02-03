@extends('admin.layout')

@section('title', 'Gestion des Utilisateurs')
@section('subtitle', 'Gérez les comptes utilisateurs de la plateforme')

@section('content')

<!-- Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3">
                <div class="page-header-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h1 class="page-title">Utilisateurs</h1>
                    <p class="page-subtitle">{{ count($users) }} utilisateur(s) enregistré(s)</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchUsers" placeholder="Rechercher un utilisateur..." class="search-input">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    @php
        $totalUsers = count($users);
        $activeUsers = $users->where('blocked', false)->count();
        $blockedUsers = $users->where('blocked', true)->count();
        $admins = $users->where('role', 'admin')->count();
    @endphp
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-primary-soft text-primary">
                <i class="fas fa-users"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $totalUsers }}</span>
                <span class="quick-stat-label">Total</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-success-soft text-success">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $activeUsers }}</span>
                <span class="quick-stat-label">Actifs</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-danger-soft text-danger">
                <i class="fas fa-user-slash"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $blockedUsers }}</span>
                <span class="quick-stat-label">Bloqués</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-warning-soft text-warning">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $admins }}</span>
                <span class="quick-stat-label">Admins</span>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="fas fa-list"></i>
            Liste des utilisateurs
        </h3>
        <div class="d-flex gap-2">
            <select id="filterRole" class="form-select form-select-sm" style="width: auto;">
                <option value="">Tous les rôles</option>
                <option value="admin">Admin</option>
                <option value="utilisateur">Utilisateur</option>
            </select>
            <select id="filterStatus" class="form-select form-select-sm" style="width: auto;">
                <option value="">Tous les statuts</option>
                <option value="active">Actifs</option>
                <option value="blocked">Bloqués</option>
            </select>
        </div>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-wrapper">
            <table class="admin-table" id="usersTable">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Utilisateur</th>
                        <th>Contact</th>
                        <th>Rôle</th>
                        <th>Statut</th>
                        <th>Inscrit le</th>
                        <th class="text-center" style="width: 180px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr data-role="{{ $user->role ?? 'utilisateur' }}" data-status="{{ $user->blocked ? 'blocked' : 'active' }}">
                            <td class="text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar" style="background: linear-gradient(135deg, {{ $user->blocked ? '#ef4444, #dc2626' : 'var(--admin-primary), var(--admin-primary-light)' }});">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="user-info">
                                        <h4 class="user-name">{{ $user->name }}</h4>
                                        <p class="user-email">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="contact-info">
                                    @if($user->phone)
                                        <span><i class="fas fa-phone me-1 text-muted"></i>{{ $user->phone }}</span>
                                    @endif
                                    @if($user->address)
                                        <small class="d-block text-muted text-truncate" style="max-width: 150px;" title="{{ $user->address }}">
                                            <i class="fas fa-map-marker-alt me-1"></i>{{ $user->address }}
                                        </small>
                                    @endif
                                    @if(!$user->phone && !$user->address)
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="admin-badge admin-badge-warning">
                                        <i class="fas fa-crown me-1"></i>Admin
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-info">
                                        <i class="fas fa-user me-1"></i>Utilisateur
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($user->blocked)
                                    <span class="admin-badge admin-badge-danger">
                                        <i class="fas fa-ban me-1"></i>Bloqué
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-success">
                                        <i class="fas fa-check me-1"></i>Actif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="date-info">
                                    <span>{{ $user->created_at->format('d/m/Y') }}</span>
                                    <small class="text-muted d-block">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-action btn-action-view" title="Voir le profil" data-bs-toggle="modal" data-bs-target="#userDetailModal{{ $user->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-action {{ $user->blocked ? 'btn-action-success' : 'btn-action-warning' }}" title="{{ $user->blocked ? 'Débloquer' : 'Bloquer' }}" data-bs-toggle="modal" data-bs-target="#blockUserModal{{ $user->id }}">
                                        <i class="fas fa-{{ $user->blocked ? 'unlock' : 'lock' }}"></i>
                                    </button>
                                    <button class="btn-action btn-action-delete" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Détails -->
                                <div class="modal fade" id="userDetailModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));">
                                                <h5 class="modal-title text-white">
                                                    <i class="fas fa-user me-2"></i>Profil utilisateur
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="user-profile-avatar mx-auto mb-3" style="background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                                <h4 class="mb-1">{{ $user->name }}</h4>
                                                <p class="text-muted mb-3">{{ $user->email }}</p>

                                                <div class="user-detail-grid">
                                                    <div class="detail-item">
                                                        <i class="fas fa-phone text-primary"></i>
                                                        <span>{{ $user->phone ?? 'Non renseigné' }}</span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-map-marker-alt text-primary"></i>
                                                        <span>{{ $user->address ?? 'Non renseignée' }}</span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-user-tag text-primary"></i>
                                                        <span>{{ ucfirst($user->role ?? 'Utilisateur') }}</span>
                                                    </div>
                                                    <div class="detail-item">
                                                        <i class="fas fa-calendar text-primary"></i>
                                                        <span>Inscrit le {{ $user->created_at->format('d/m/Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Bloquer/Débloquer -->
                                <div class="modal fade" id="blockUserModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, {{ $user->blocked ? '#10b981, #059669' : '#f59e0b, #d97706' }});">
                                                <h5 class="modal-title text-white">
                                                    <i class="fas fa-{{ $user->blocked ? 'unlock' : 'lock' }} me-2"></i>
                                                    {{ $user->blocked ? 'Débloquer' : 'Bloquer' }} l'utilisateur
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="action-icon {{ $user->blocked ? 'bg-success-soft text-success' : 'bg-warning-soft text-warning' }} mb-3">
                                                    <i class="fas fa-{{ $user->blocked ? 'unlock' : 'lock' }}"></i>
                                                </div>
                                                <p class="mb-1">Êtes-vous sûr de vouloir {{ $user->blocked ? 'débloquer' : 'bloquer' }}</p>
                                                <h5 class="fw-bold">{{ $user->name }}</h5>
                                                @if(!$user->blocked)
                                                    <p class="text-muted small">L'utilisateur ne pourra plus se connecter</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Annuler
                                                </button>
                                                <form action="{{ route('admin.users.toggle-block', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn-admin {{ $user->blocked ? 'btn-admin-success' : 'btn-admin-warning' }}">
                                                        <i class="fas fa-{{ $user->blocked ? 'unlock' : 'lock' }} me-2"></i>
                                                        {{ $user->blocked ? 'Débloquer' : 'Bloquer' }}
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Supprimer -->
                                <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                                <h5 class="modal-title text-white">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>Supprimer l'utilisateur
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="delete-icon mb-3">
                                                    <i class="fas fa-user-times"></i>
                                                </div>
                                                <p class="mb-1">Êtes-vous sûr de vouloir supprimer</p>
                                                <h5 class="fw-bold text-danger">{{ $user->name }}</h5>
                                                <p class="text-muted small">Cette action est irréversible. Toutes les données associées seront perdues.</p>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Annuler
                                                </button>
                                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-admin btn-admin-danger">
                                                        <i class="fas fa-trash me-2"></i>Supprimer
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fas fa-users"></i>
                                    <h4>Aucun utilisateur</h4>
                                    <p>Il n'y a pas encore d'utilisateur inscrit</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Page Header */
    .page-header {
        padding: 1.5rem;
        background: var(--admin-surface);
        border-radius: var(--radius-lg);
        border: 1px solid var(--admin-gray-200);
    }

    .page-header-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 1.5rem;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-text);
        margin: 0;
    }

    .page-subtitle {
        color: var(--admin-text-muted);
        margin: 0;
        font-size: 0.875rem;
    }

    /* Quick Stats */
    .quick-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: var(--admin-surface);
        border-radius: var(--radius-md);
        border: 1px solid var(--admin-gray-200);
    }

    .quick-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
    }

    .quick-stat-content {
        display: flex;
        flex-direction: column;
    }

    .quick-stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--admin-text);
        line-height: 1.2;
    }

    .quick-stat-label {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
    }

    /* Search */
    .search-box {
        position: relative;
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--admin-text-muted);
    }

    .search-input {
        padding: 0.5rem 1rem 0.5rem 2.5rem;
        border: 1px solid var(--admin-gray-300);
        border-radius: var(--radius-full);
        font-size: 0.875rem;
        width: 250px;
        transition: all var(--transition-fast);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--admin-primary);
        width: 300px;
    }

    /* User Cell */
    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }

    .user-avatar {
        width: 42px;
        height: 42px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .user-info {
        min-width: 0;
    }

    .user-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-text);
        margin: 0;
    }

    .user-email {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        margin: 0;
    }

    /* Contact Info */
    .contact-info {
        font-size: 0.8rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.375rem;
        justify-content: center;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all var(--transition-fast);
        font-size: 0.8rem;
    }

    .btn-action-view {
        background: rgba(59, 130, 246, 0.1);
        color: var(--admin-info);
    }

    .btn-action-view:hover {
        background: var(--admin-info);
        color: #fff;
    }

    .btn-action-warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--admin-warning);
    }

    .btn-action-warning:hover {
        background: var(--admin-warning);
        color: #fff;
    }

    .btn-action-success {
        background: rgba(16, 185, 129, 0.1);
        color: var(--admin-success);
    }

    .btn-action-success:hover {
        background: var(--admin-success);
        color: #fff;
    }

    .btn-action-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--admin-danger);
    }

    .btn-action-delete:hover {
        background: var(--admin-danger);
        color: #fff;
    }

    /* Action Icon */
    .action-icon {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 2rem;
    }

    /* Delete Icon */
    .delete-icon {
        width: 80px;
        height: 80px;
        background: rgba(239, 68, 68, 0.1);
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: var(--admin-danger);
        font-size: 2rem;
    }

    /* User Profile Avatar */
    .user-profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 1.5rem;
    }

    /* User Detail Grid */
    .user-detail-grid {
        display: grid;
        gap: 0.75rem;
        text-align: left;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--admin-gray-200);
    }

    .user-detail-grid .detail-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem;
        background: var(--admin-gray-100);
        border-radius: var(--radius-sm);
    }

    .user-detail-grid .detail-item i {
        width: 20px;
        text-align: center;
    }

    /* Date Info */
    .date-info span {
        font-size: 0.8rem;
    }

    /* Empty State */
    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 4rem;
        color: var(--admin-gray-400);
        margin-bottom: 1rem;
    }

    .empty-state h4 {
        font-size: 1.25rem;
        color: var(--admin-text);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--admin-text-muted);
    }

    /* Button Success */
    .btn-admin-success {
        background: linear-gradient(135deg, var(--admin-success), #059669);
        color: #fff;
    }

    .btn-admin-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
        color: #fff;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchUsers');
    const filterRole = document.getElementById('filterRole');
    const filterStatus = document.getElementById('filterStatus');
    const table = document.getElementById('usersTable');
    const rows = table.querySelectorAll('tbody tr');

    function filterTable() {
        const searchQuery = searchInput.value.toLowerCase();
        const roleFilter = filterRole.value;
        const statusFilter = filterStatus.value;

        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            const role = row.dataset.role;
            const status = row.dataset.status;

            const matchesSearch = text.includes(searchQuery);
            const matchesRole = !roleFilter || role === roleFilter;
            const matchesStatus = !statusFilter || status === statusFilter;

            row.style.display = (matchesSearch && matchesRole && matchesStatus) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterRole.addEventListener('change', filterTable);
    filterStatus.addEventListener('change', filterTable);
});
</script>
@endpush
