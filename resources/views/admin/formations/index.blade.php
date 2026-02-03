@extends('admin.layout')

@section('title', 'Gestion des Formations')
@section('subtitle', 'Gérez vos formations e-learning')

@section('content')

<!-- Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3">
                <div class="page-header-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="page-title">Formations E-Learning</h1>
                    <p class="page-subtitle">{{ $formations->total() }} formation(s) disponible(s)</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                <a href="{{ route('admin.formations.create') }}" class="btn-admin btn-admin-primary">
                    <i class="fas fa-plus me-2"></i>Nouvelle Formation
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    @php
        $totalFormations = $formations->total();
        $activeFormations = $formations->where('active', true)->count();
        $totalInscrits = $formations->sum('inscriptions_count');
        $totalModules = $formations->sum('modules_count');
    @endphp
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-primary-soft text-primary">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $totalFormations }}</span>
                <span class="quick-stat-label">Formations</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-success-soft text-success">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $activeFormations }}</span>
                <span class="quick-stat-label">Actives</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-info-soft text-info">
                <i class="fas fa-users"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $totalInscrits }}</span>
                <span class="quick-stat-label">Inscrits</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-warning-soft text-warning">
                <i class="fas fa-cubes"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $totalModules }}</span>
                <span class="quick-stat-label">Modules</span>
            </div>
        </div>
    </div>
</div>

<!-- Table -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="fas fa-list"></i>
            Liste des formations
        </h3>
        <div class="search-box">
            <i class="fas fa-search"></i>
            <input type="text" id="searchFormations" placeholder="Rechercher..." class="search-input">
        </div>
    </div>
    <div class="admin-card-body p-0">
        <div class="admin-table-wrapper">
            <table class="admin-table" id="formationsTable">
                <thead>
                    <tr>
                        <th style="width: 70px;">Image</th>
                        <th>Formation</th>
                        <th>Prix</th>
                        <th>Niveau</th>
                        <th class="text-center">Modules</th>
                        <th class="text-center">Inscrits</th>
                        <th>Statut</th>
                        <th class="text-center" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formations as $formation)
                        <tr>
                            <td>
                                <div class="table-image">
                                    @if($formation->image)
                                        <img src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}">
                                    @else
                                        <div class="table-image-placeholder">
                                            <i class="fas fa-graduation-cap"></i>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="formation-info">
                                    <h4 class="formation-title">{{ $formation->titre }}</h4>
                                    <p class="formation-desc">{{ Str::limit($formation->description, 60) }}</p>
                                </div>
                            </td>
                            <td>
                                @if($formation->est_gratuit || $formation->prix == 0)
                                    <span class="price-tag price-free">Gratuit</span>
                                @else
                                    <span class="price-tag">{{ fcfa($formation->prix) }}</span>
                                @endif
                            </td>
                            <td>
                                @php
                                    $levelColors = [
                                        'debutant' => 'info',
                                        'intermediaire' => 'warning',
                                        'avance' => 'danger'
                                    ];
                                    $levelColor = $levelColors[$formation->niveau] ?? 'secondary';
                                @endphp
                                <span class="admin-badge admin-badge-{{ $levelColor }}">
                                    {{ ucfirst($formation->niveau) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="stat-pill stat-pill-primary">
                                    <i class="fas fa-cubes me-1"></i>{{ $formation->modules_count }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="stat-pill stat-pill-info">
                                    <i class="fas fa-users me-1"></i>{{ $formation->inscriptions_count }}
                                </span>
                            </td>
                            <td>
                                @if($formation->active)
                                    <span class="admin-badge admin-badge-success">
                                        <i class="fas fa-check-circle me-1"></i>Active
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-danger">
                                        <i class="fas fa-times-circle me-1"></i>Inactive
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.formations.show', $formation) }}" class="btn-action btn-action-view" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.formations.edit', $formation) }}" class="btn-action btn-action-edit" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn-action btn-action-delete" title="Supprimer" data-bs-toggle="modal" data-bs-target="#deleteFormationModal{{ $formation->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Modal Supprimer -->
                                <div class="modal fade" id="deleteFormationModal{{ $formation->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                                                <h5 class="modal-title text-white">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>Supprimer la formation
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-center py-4">
                                                <div class="delete-icon mb-3">
                                                    <i class="fas fa-graduation-cap"></i>
                                                </div>
                                                <p class="mb-1">Êtes-vous sûr de vouloir supprimer</p>
                                                <h5 class="fw-bold text-danger">{{ $formation->titre }}</h5>
                                                <div class="alert alert-warning mt-3 text-start">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                                    <strong>Attention !</strong> Cette action supprimera également tous les modules associés ({{ $formation->modules_count }}).
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Annuler
                                                </button>
                                                <form action="{{ route('admin.formations.destroy', $formation) }}" method="POST" style="display: inline;">
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
                            <td colspan="8">
                                <div class="empty-state">
                                    <i class="fas fa-graduation-cap"></i>
                                    <h4>Aucune formation</h4>
                                    <p>Commencez par créer votre première formation</p>
                                    <a href="{{ route('admin.formations.create') }}" class="btn-admin btn-admin-primary">
                                        <i class="fas fa-plus me-2"></i>Créer une formation
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($formations->hasPages())
        <div class="admin-card-footer">
            <div class="pagination-wrapper">
                {{ $formations->links() }}
            </div>
        </div>
    @endif
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
        width: 200px;
        transition: all var(--transition-fast);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--admin-primary);
        width: 250px;
    }

    /* Table Image */
    .table-image {
        width: 60px;
        height: 60px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
    }

    .table-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .table-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--admin-gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-text-muted);
        font-size: 1.25rem;
    }

    /* Formation Info */
    .formation-info {
        min-width: 0;
    }

    .formation-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-text);
        margin: 0 0 0.25rem;
    }

    .formation-desc {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        margin: 0;
        line-height: 1.4;
    }

    /* Price Tag */
    .price-tag {
        font-weight: 600;
        color: var(--admin-success);
        font-size: 0.875rem;
    }

    .price-free {
        color: var(--admin-info);
        background: rgba(59, 130, 246, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: var(--radius-sm);
    }

    /* Stat Pill */
    .stat-pill {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.625rem;
        border-radius: var(--radius-full);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .stat-pill-primary {
        background: rgba(var(--admin-primary-rgb), 0.1);
        color: var(--admin-primary);
    }

    .stat-pill-info {
        background: rgba(59, 130, 246, 0.1);
        color: var(--admin-info);
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
        text-decoration: none;
    }

    .btn-action-view {
        background: rgba(59, 130, 246, 0.1);
        color: var(--admin-info);
    }

    .btn-action-view:hover {
        background: var(--admin-info);
        color: #fff;
    }

    .btn-action-edit {
        background: rgba(245, 158, 11, 0.1);
        color: var(--admin-warning);
    }

    .btn-action-edit:hover {
        background: var(--admin-warning);
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
        margin-bottom: 1.5rem;
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchFormations');
    const table = document.getElementById('formationsTable');
    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        rows.forEach(function(row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
});
</script>
@endpush
