@extends('admin.layout')

@section('title', 'Gestion du Blog')
@section('subtitle', 'Gérer les articles et publications du blog')

@section('content')
<!-- Page Header -->
<div class="admin-page-header">
    <div class="admin-page-header-content">
        <div class="admin-page-icon">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="admin-page-info">
            <h1>Gestion du Blog</h1>
            <p>Gérer les articles et publications du blog</p>
        </div>
    </div>
    <div class="admin-page-actions">
        <a href="{{ route('admin.blog.create') }}" class="btn-admin btn-admin-primary">
            <i class="fas fa-plus"></i> Nouvel article
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="admin-stats-row">
    <div class="admin-stat-card admin-stat-success">
        <div class="admin-stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $publishedCount }}</span>
            <span class="admin-stat-label">Publiés</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-warning">
        <div class="admin-stat-icon">
            <i class="fas fa-edit"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $draftCount }}</span>
            <span class="admin-stat-label">Brouillons</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-primary">
        <div class="admin-stat-icon">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $articles->total() }}</span>
            <span class="admin-stat-label">Total articles</span>
        </div>
    </div>
</div>

<!-- Articles List -->
@if($articles->isEmpty())
    <div class="admin-empty-state">
        <div class="admin-empty-icon">
            <i class="fas fa-newspaper"></i>
        </div>
        <h3>Aucun article</h3>
        <p>Commencez à créer des articles pour votre blog.</p>
        <a href="{{ route('admin.blog.create') }}" class="btn-admin btn-admin-primary">
            <i class="fas fa-plus"></i> Créer le premier article
        </a>
    </div>
@else
    <div class="admin-card">
        <div class="admin-card-body p-0">
            <div class="articles-grid">
                @foreach($articles as $article)
                    <div class="article-card {{ $article->status === 'draft' ? 'article-draft' : '' }}">
                        <div class="article-image">
                            @if($article->featured_image)
                                <img src="{{ asset($article->featured_image) }}" alt="{{ $article->title }}">
                            @else
                                <div class="article-image-placeholder">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="article-status">
                                @if($article->status === 'published')
                                    <span class="admin-badge admin-badge-success">
                                        <i class="fas fa-check"></i> Publié
                                    </span>
                                @else
                                    <span class="admin-badge admin-badge-warning">
                                        <i class="fas fa-edit"></i> Brouillon
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="article-content">
                            <h3 class="article-title">{{ Str::limit($article->title, 60) }}</h3>

                            <div class="article-meta">
                                <span class="article-meta-item">
                                    <i class="fas fa-user"></i>
                                    {{ $article->author ? $article->author->name : 'Inconnu' }}
                                </span>
                                <span class="article-meta-item">
                                    <i class="fas fa-eye"></i>
                                    {{ $article->views }} vues
                                </span>
                                <span class="article-meta-item">
                                    <i class="fas fa-calendar"></i>
                                    @if($article->published_at)
                                        {{ $article->published_at->format('d/m/Y') }}
                                    @else
                                        {{ $article->created_at->format('d/m/Y') }}
                                    @endif
                                </span>
                            </div>

                            @if($article->excerpt)
                                <p class="article-excerpt">{{ Str::limit($article->excerpt, 100) }}</p>
                            @endif
                        </div>

                        <div class="article-actions">
                            @if($article->slug)
                                <a href="{{ route('blog.show', $article->slug) }}"
                                   class="btn-admin btn-admin-info btn-admin-sm"
                                   title="Voir"
                                   target="_blank">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif

                            <a href="{{ route('admin.blog.edit', $article->id) }}"
                               class="btn-admin btn-admin-primary btn-admin-sm"
                               title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('admin.blog.toggleStatus', $article->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="btn-admin btn-admin-{{ $article->status === 'published' ? 'warning' : 'success' }} btn-admin-sm"
                                        title="{{ $article->status === 'published' ? 'Mettre en brouillon' : 'Publier' }}">
                                    <i class="fas fa-{{ $article->status === 'published' ? 'eye-slash' : 'check' }}"></i>
                                </button>
                            </form>

                            <button type="button"
                                    class="btn-admin btn-admin-danger btn-admin-sm btn-delete-article"
                                    data-article-id="{{ $article->id }}"
                                    data-article-title="{{ $article->title }}"
                                    data-delete-url="{{ route('admin.blog.destroy', $article->id) }}"
                                    title="Supprimer">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        @if($articles->hasPages())
            <div class="admin-card-footer">
                <div class="admin-pagination-wrapper">
                    {{ $articles->links() }}
                </div>
            </div>
        @endif
    </div>
@endif

<!-- Delete Modal -->
<div class="modal fade" id="deleteArticleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content admin-modal">
            <div class="modal-header admin-modal-header admin-modal-header-danger">
                <h5 class="modal-title">
                    <i class="fas fa-trash"></i> Supprimer l'article
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="admin-alert admin-alert-warning mb-3">
                    <i class="fas fa-exclamation-triangle"></i>
                    Cette action est irréversible.
                </div>
                <p>Êtes-vous sûr de vouloir supprimer cet article ?</p>
                <div class="admin-modal-info-card">
                    <div class="admin-modal-info-item">
                        <i class="fas fa-newspaper"></i>
                        <strong id="deleteArticleTitle"></strong>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-admin btn-admin-secondary" data-bs-dismiss="modal">Annuler</button>
                <form id="deleteArticleForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-admin btn-admin-danger">
                        <i class="fas fa-trash"></i> Supprimer
                    </button>
                </form>
            </div>
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

    .admin-stat-card.admin-stat-success { border-color: #10b981; }
    .admin-stat-card.admin-stat-warning { border-color: #f59e0b; }
    .admin-stat-card.admin-stat-primary { border-color: var(--admin-primary); }

    .admin-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .admin-stat-success .admin-stat-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .admin-stat-warning .admin-stat-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .admin-stat-primary .admin-stat-icon { background: rgba(30, 122, 47, 0.1); color: var(--admin-primary); }

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

    /* Articles Grid */
    .articles-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 1.25rem;
        padding: 1.25rem;
    }

    /* Article Card */
    .article-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid var(--admin-gray-200);
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        flex-direction: column;
    }

    .article-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .article-card.article-draft {
        border-color: #f59e0b;
        background: linear-gradient(180deg, rgba(245, 158, 11, 0.03) 0%, white 100%);
    }

    .article-image {
        position: relative;
        height: 180px;
        overflow: hidden;
        background: var(--admin-gray-100);
    }

    .article-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }

    .article-card:hover .article-image img {
        transform: scale(1.05);
    }

    .article-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        color: var(--admin-gray-300);
    }

    .article-status {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
    }

    .article-content {
        padding: 1.25rem;
        flex: 1;
    }

    .article-title {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--admin-gray-900);
        margin: 0 0 0.75rem 0;
        line-height: 1.4;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .article-meta-item {
        font-size: 0.75rem;
        color: var(--admin-gray-500);
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .article-excerpt {
        font-size: 0.85rem;
        color: var(--admin-gray-600);
        line-height: 1.5;
        margin: 0;
    }

    .article-actions {
        display: flex;
        gap: 0.375rem;
        padding: 1rem 1.25rem;
        background: var(--admin-gray-50);
        border-top: 1px solid var(--admin-gray-200);
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

        .articles-grid {
            grid-template-columns: 1fr;
            padding: 1rem;
        }

        .article-image {
            height: 160px;
        }
    }

    @media (max-width: 576px) {
        .admin-stats-row {
            grid-template-columns: 1fr;
        }

        .article-actions {
            flex-wrap: wrap;
        }

        .article-actions .btn-admin {
            flex: 1;
            min-width: calc(50% - 0.5rem);
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteArticleModal'));
    const deleteForm = document.getElementById('deleteArticleForm');
    const deleteTitle = document.getElementById('deleteArticleTitle');

    document.querySelectorAll('.btn-delete-article').forEach(button => {
        button.addEventListener('click', function() {
            const articleTitle = this.dataset.articleTitle;
            const deleteUrl = this.dataset.deleteUrl;

            deleteTitle.textContent = articleTitle;
            deleteForm.action = deleteUrl;
            deleteModal.show();
        });
    });
});
</script>
@endpush
