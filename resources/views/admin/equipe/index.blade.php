@extends('admin.layout')

@section('title', 'Gestion de l\'équipe')
@section('subtitle', 'Gérez les membres de votre équipe')

@section('content')
@php
    $activeCount = $membres->where('actif', true)->count();
    $inactiveCount = $membres->where('actif', false)->count();
@endphp

<!-- Page Header -->
<div class="admin-page-header">
    <div class="admin-page-header-content">
        <div class="admin-page-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="admin-page-info">
            <h1>Gestion de l'équipe</h1>
            <p>Gérez les membres de votre équipe</p>
        </div>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.equipe.create') }}" class="btn-admin btn-admin-primary">
            <i class="fas fa-plus"></i> Ajouter un membre
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="admin-stats-row">
    <div class="admin-stat-card admin-stat-primary">
        <div class="admin-stat-icon">
            <i class="fas fa-users"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $membres->total() }}</span>
            <span class="admin-stat-label">Total membres</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-success">
        <div class="admin-stat-icon">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $activeCount }}</span>
            <span class="admin-stat-label">Actifs</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-secondary">
        <div class="admin-stat-icon">
            <i class="fas fa-user-slash"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $inactiveCount }}</span>
            <span class="admin-stat-label">Inactifs</span>
        </div>
    </div>
</div>

<!-- Team Members -->
@if($membres->isEmpty())
    <div class="admin-empty-state">
        <div class="admin-empty-icon">
            <i class="fas fa-users"></i>
        </div>
        <h3>Aucun membre dans l'équipe</h3>
        <p>Commencez à ajouter des membres à votre équipe.</p>
        <a href="{{ route('admin.equipe.create') }}" class="btn-admin btn-admin-primary">
            <i class="fas fa-plus"></i> Ajouter le premier membre
        </a>
    </div>
@else
    <div class="admin-card">
        <div class="admin-card-body p-0">
            <div class="team-grid">
                @foreach($membres as $membre)
                    <div class="team-card {{ !$membre->actif ? 'team-card-inactive' : '' }}">
                        <div class="team-card-header">
                            <div class="team-avatar">
                                @if($membre->photo)
                                    @if(str_starts_with($membre->photo, 'http') || str_starts_with($membre->photo, 'img/'))
                                        <img src="{{ asset($membre->photo) }}" alt="{{ $membre->nom }}">
                                    @else
                                        <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom }}">
                                    @endif
                                @else
                                    <div class="team-avatar-placeholder">
                                        {{ strtoupper(substr($membre->nom, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="team-status">
                                @if($membre->actif)
                                    <span class="admin-badge admin-badge-success">
                                        <i class="fas fa-check"></i> Actif
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-secondary">
                                        <i class="fas fa-times"></i> Inactif
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="team-card-body">
                            <h3 class="team-name">{{ $membre->nom }}</h3>
                            <p class="team-role">{{ $membre->poste }}</p>

                            @if($membre->email)
                                <div class="team-contact">
                                    <a href="mailto:{{ $membre->email }}">
                                        <i class="fas fa-envelope"></i>
                                        {{ $membre->email }}
                                    </a>
                                </div>
                            @endif

                            @if($membre->linkedin || $membre->twitter)
                                <div class="team-social">
                                    @if($membre->linkedin)
                                        <a href="{{ $membre->linkedin }}" target="_blank" class="social-link social-linkedin" title="LinkedIn">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    @endif
                                    @if($membre->twitter)
                                        <a href="{{ $membre->twitter }}" target="_blank" class="social-link social-twitter" title="Twitter">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="team-card-actions">
                            <a href="{{ route('admin.equipe.show', $membre->id) }}"
                               class="btn-admin btn-admin-info btn-admin-sm"
                               title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.equipe.edit', $membre->id) }}"
                               class="btn-admin btn-admin-warning btn-admin-sm"
                               title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                    class="btn-admin btn-admin-danger btn-admin-sm btn-delete-membre"
                                    data-membre-id="{{ $membre->id }}"
                                    data-membre-nom="{{ $membre->nom }}"
                                    title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if($membres->hasPages())
            <div class="admin-card-footer">
                <div class="admin-pagination-wrapper">
                    {{ $membres->links() }}
                </div>
            </div>
        @endif
    </div>
@endif

<!-- Delete Modal -->
<div class="modal fade" id="deleteMembreModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-danger">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Supprimer le membre
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteMembreForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="admin-alert admin-alert-warning mb-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        Cette action est irréversible.
                    </div>
                    <p>Êtes-vous sûr de vouloir supprimer ce membre de l'équipe ?</p>
                    <div class="admin-modal-info-card">
                        <div class="admin-modal-info-item">
                            <i class="fas fa-user"></i>
                            <strong id="deleteMembreNom"></strong>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn-admin btn-admin-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Page Header */
    .admin-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .admin-page-header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .admin-page-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(30, 122, 47, 0.3);
    }

    .admin-page-info h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--admin-gray-900);
    }

    .admin-page-info p {
        font-size: 0.875rem;
        color: var(--admin-gray-500);
        margin: 0;
    }

    /* Stats Row */
    .admin-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .admin-stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .admin-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .admin-stat-card.admin-stat-primary { border-color: var(--admin-primary); }
    .admin-stat-card.admin-stat-success { border-color: #10b981; }
    .admin-stat-card.admin-stat-secondary { border-color: #6b7280; }

    .admin-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .admin-stat-primary .admin-stat-icon { background: rgba(30, 122, 47, 0.1); color: var(--admin-primary); }
    .admin-stat-success .admin-stat-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .admin-stat-secondary .admin-stat-icon { background: rgba(107, 114, 128, 0.1); color: #6b7280; }

    .admin-stat-content {
        display: flex;
        flex-direction: column;
    }

    .admin-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-gray-900);
        line-height: 1.2;
    }

    .admin-stat-label {
        font-size: 0.8rem;
        color: var(--admin-gray-500);
    }

    /* Empty State */
    .admin-empty-state {
        background: white;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .admin-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--admin-gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--admin-gray-400);
    }

    .admin-empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--admin-gray-700);
        margin-bottom: 0.5rem;
    }

    .admin-empty-state p {
        color: var(--admin-gray-500);
        margin-bottom: 1.5rem;
    }

    /* Team Grid */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
        padding: 1.25rem;
    }

    /* Team Card */
    .team-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--admin-gray-200);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .team-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .team-card.team-card-inactive {
        opacity: 0.7;
        background: var(--admin-gray-50);
    }

    .team-card-header {
        position: relative;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .team-avatar {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .team-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .team-avatar-placeholder {
        width: 100%;
        height: 100%;
        background: var(--admin-gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: 700;
        color: var(--admin-gray-500);
    }

    .team-status {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
    }

    .team-card-body {
        padding: 1.25rem;
        text-align: center;
        flex: 1;
    }

    .team-name {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--admin-gray-900);
        margin: 0 0 0.25rem 0;
    }

    .team-role {
        font-size: 0.875rem;
        color: var(--admin-primary);
        font-weight: 500;
        margin: 0 0 0.75rem 0;
    }

    .team-contact {
        margin-bottom: 0.75rem;
    }

    .team-contact a {
        font-size: 0.8rem;
        color: var(--admin-gray-600);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
    }

    .team-contact a:hover {
        color: var(--admin-primary);
    }

    .team-social {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .social-link {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .social-linkedin {
        background: rgba(10, 102, 194, 0.1);
        color: #0a66c2;
    }

    .social-linkedin:hover {
        background: #0a66c2;
        color: white;
    }

    .social-twitter {
        background: rgba(29, 155, 240, 0.1);
        color: #1d9bf0;
    }

    .social-twitter:hover {
        background: #1d9bf0;
        color: white;
    }

    .team-card-actions {
        display: flex;
        gap: 0.375rem;
        padding: 1rem 1.25rem;
        background: var(--admin-gray-50);
        border-top: 1px solid var(--admin-gray-200);
        justify-content: center;
    }

    /* Alert */
    .admin-alert {
        padding: 1rem;
        border-radius: 8px;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-size: 0.875rem;
    }

    .admin-alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #b45309;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    /* Modal */
    .admin-modal .modal-content {
        border: none;
        border-radius: 16px;
        overflow: hidden;
    }

    .admin-modal-header {
        padding: 1rem 1.25rem;
        border: none;
    }

    .admin-modal-header .modal-title {
        color: white;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-modal-header-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
    }

    .admin-modal-info-card {
        background: var(--admin-gray-50);
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
    }

    .admin-modal-info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .admin-modal-info-item i {
        color: var(--admin-primary);
    }

    /* Card Footer */
    .admin-card-footer {
        padding: 1rem 1.25rem;
        background: var(--admin-gray-50);
        border-top: 1px solid var(--admin-gray-200);
    }

    .admin-pagination-wrapper {
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .admin-page-actions {
            width: 100%;
        }

        .admin-page-actions .btn-admin {
            width: 100%;
        }

        .team-grid {
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .admin-stats-row {
            grid-template-columns: 1fr;
        }

        .team-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteMembreModal'));
    const deleteForm = document.getElementById('deleteMembreForm');
    const deleteNom = document.getElementById('deleteMembreNom');

    document.querySelectorAll('.btn-delete-membre').forEach(button => {
        button.addEventListener('click', function() {
            const membreId = this.dataset.membreId;
            const membreNom = this.dataset.membreNom;

            deleteNom.textContent = membreNom;
            deleteForm.action = '/admin/equipe/' + membreId;
            deleteModal.show();
        });
    });
});
</script>
@endpush
