@extends('layouts.app')

@section('title', 'Blog | Colibri Littéraire - Articles et actualités')
@section('meta_description', 'Découvrez les articles, actualités et ressources du projet Colibri Littéraire. Restez informés de nos dernières publications.')
@section('meta_keywords', 'blog, articles, actualités, Colibri Littéraire, littérature africaine, culture, ressources')

@section('content')
@include('partials.notifications')

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-3 animated slideInDown">Blog</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('index') }}">Accueil</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Blog</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Blog Section Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <p class="section-title bg-white text-center text-success px-3">Blog & Actualités</p>
                <h1 class="display-6 mb-4">Articles et ressources</h1>
                <p class="text-muted">Découvrez nos dernières publications, actualités et ressources autour de la littérature africaine.</p>
            </div>

            @if($articles->isEmpty())
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center py-5">
                                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Aucun article pour l'instant</h5>
                                <p class="text-muted mb-0">Les articles seront bientôt disponibles. Revenez nous voir!</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($articles as $article)
                        <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ 0.1 + ($loop->index * 0.1) }}s">
                            <div class="card h-100 border-0 shadow-sm overflow-hidden article-card">
                                @if($article->featured_image)
                                    <div class="position-relative overflow-hidden" style="height: 250px;">
                                        <img src="{{ asset($article->featured_image) }}"
                                             alt="{{ $article->title ?? 'Article' }}"
                                             class="w-100 h-100"
                                             style="object-fit: cover; transition: transform 0.3s ease;">
                                    </div>
                                @else
                                    <div class="position-relative bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <i class="fas fa-newspaper fa-4x text-success opacity-25"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $article->published_at->format('d/m/Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i>
                                            {{ $article->views }} vue{{ $article->views > 1 ? 's' : '' }}
                                        </small>
                                    </div>
                                    <h5 class="card-title mb-3">
                                        <a href="{{ route('blog.show', $article->slug) }}"
                                           class="text-dark text-decoration-none stretched-link">
                                            {{ $article->title ?? 'Sans titre' }}
                                        </a>
                                    </h5>
                                    @if($article->excerpt)
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit($article->excerpt, 120) }}
                                        </p>
                                    @else
                                        <p class="card-text text-muted mb-3">
                                            {{ Str::limit(strip_tags($article->content ?? ''), 120) }}
                                        </p>
                                    @endif
                                    <div class="mt-auto">
                                        @if($article->author)
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2"
                                                     style="width: 30px; height: 30px; font-size: 14px;">
                                                    {{ strtoupper(substr($article->author->name, 0, 1)) }}
                                                </div>
                                                <small class="text-muted">Par {{ $article->author->name }}</small>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($articles->hasPages())
                    <div class="row mt-5">
                        <div class="col-12 d-flex justify-content-center">
                            {{ $articles->links() }}
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
    <!-- Blog Section End -->
@endsection

@push('styles')
<style>
    .article-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    }

    .article-card:hover img {
        transform: scale(1.05);
    }

    .stretched-link:hover {
        color: #198754 !important;
    }
</style>
@endpush
