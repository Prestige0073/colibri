@extends('admin.layout')

@section('title', 'Gestion du Blog')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-newspaper me-2 text-primary"></i>Gestion du Blog
                    </h1>
                    <p class="text-muted mb-0">Gérer les articles et publications du blog</p>
                </div>
                <div>
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nouvel article
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Articles publiés</p>
                            <h3 class="mb-0 fw-bold">{{ $publishedCount }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Brouillons</p>
                            <h3 class="mb-0 fw-bold">{{ $draftCount }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-edit fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total des articles</p>
                            <h3 class="mb-0 fw-bold">{{ $articles->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-newspaper fa-2x text-primary"></i>
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

    <!-- Liste des articles -->
    @if($articles->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun article</h5>
                <p class="text-muted mb-3">Commencez à créer des articles pour votre blog.</p>
                <a href="{{ route('admin.blog.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Créer le premier article
                </a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="80">Image</th>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Statut</th>
                                <th>Vues</th>
                                <th>Date</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($articles as $article)
                                <tr class="{{ $article->status === 'draft' ? 'table-warning' : '' }}">
                                    <td>
                                        @if($article->featured_image)
                                            <img src="{{ asset('storage/' . $article->featured_image) }}"
                                                 alt="{{ $article->title }}"
                                                 class="rounded"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 60px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($article->title, 50) }}</strong>
                                        @if($article->status === 'draft')
                                            <span class="badge bg-warning ms-1">Brouillon</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $article->author ? $article->author->name : 'Inconnu' }}
                                        </small>
                                    </td>
                                    <td>
                                        @if($article->status === 'published')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Publié
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-edit me-1"></i>Brouillon
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i>{{ $article->views }}
                                        </small>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            @if($article->published_at)
                                                <i class="fas fa-calendar me-1"></i>{{ $article->published_at->format('d/m/Y') }}
                                            @else
                                                <i class="fas fa-clock me-1"></i>{{ $article->created_at->format('d/m/Y') }}
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('blog.show', $article->slug) }}"
                                               class="btn btn-sm btn-info"
                                               title="Voir"
                                               target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.blog.edit', $article->id) }}"
                                               class="btn btn-sm btn-primary"
                                               title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.blog.toggleStatus', $article->id) }}"
                                                  method="POST"
                                                  class="d-inline">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-sm {{ $article->status === 'published' ? 'btn-warning' : 'btn-success' }}"
                                                        title="{{ $article->status === 'published' ? 'Mettre en brouillon' : 'Publier' }}">
                                                    <i class="fas fa-{{ $article->status === 'published' ? 'eye-slash' : 'check' }}"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.blog.destroy', $article->id) }}"
                                                  method="POST"
                                                  class="d-inline"
                                                  onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $articles->links() }}
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
</style>
@endpush
