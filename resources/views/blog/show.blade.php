@extends('layouts.app')

@section('title', $article->title . ' | Blog Colibri Littéraire')
@section('meta_description', $article->excerpt ?? Str::limit(strip_tags($article->content), 160))
@section('meta_keywords', 'blog, article, Colibri Littéraire, littérature africaine')

@section('content')
@include('partials.notifications')

    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-4">
            <h1 class="display-5 animated slideInDown">{{ $article->title }}</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('index') }}">Accueil</a></li>
                    <li class="breadcrumb-item"><a class="text-muted" href="{{ route('blog.index') }}">Blog</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($article->title, 50) }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <!-- Article Section Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Article principal -->
                <div class="col-lg-8">
                    <article class="card border-0 shadow-sm mb-4">
                        <!-- Image mise en avant -->
                        @if($article->featured_image)
                            <div class="position-relative overflow-hidden" style="max-height: 500px;">
                                <img src="{{ asset($article->featured_image) }}"
                                     alt="{{ $article->title ?? 'Article' }}"
                                     class="w-100"
                                     style="object-fit: cover;">
                            </div>
                        @endif

                        <div class="card-body p-4 p-md-5">
                            <!-- Meta informations -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                <div class="d-flex align-items-center mb-2 mb-md-0">
                                    @if($article->author)
                                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2"
                                             style="width: 40px; height: 40px; font-size: 18px;">
                                            {{ strtoupper(substr($article->author->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $article->author->name }}</div>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $article->published_at->format('d F Y') }}
                                            </small>
                                        </div>
                                    @endif
                                </div>
                                <div class="text-muted">
                                    <small>
                                        <i class="fas fa-eye me-1"></i>
                                        {{ $article->views }} vue{{ $article->views > 1 ? 's' : '' }}
                                    </small>
                                </div>
                            </div>

                            <!-- Extrait si présent -->
                            @if($article->excerpt)
                                <div class="alert alert-light border-start border-success border-4 mb-4">
                                    <p class="mb-0 fw-bold text-muted">{{ $article->excerpt }}</p>
                                </div>
                            @endif

                            <!-- Contenu de l'article -->
                            <div class="article-content mb-4">
                                {!! $article->content !!}
                            </div>

                            <!-- Boutons de partage social -->
                            <div class="card bg-light border-0 mt-5">
                                <div class="card-body">
                                    <h5 class="mb-3">
                                        <i class="fas fa-share-alt me-2 text-success"></i>Partager cet article
                                    </h5>
                                    <div class="d-flex flex-wrap gap-2">
                                        <!-- WhatsApp -->
                                        <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . route('blog.show', $article->slug)) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-success"
                                           title="Partager sur WhatsApp">
                                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                        </a>

                                        <!-- Facebook -->
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $article->slug)) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-primary"
                                           title="Partager sur Facebook">
                                            <i class="fab fa-facebook-f me-2"></i>Facebook
                                        </a>

                                        <!-- X (Twitter) -->
                                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(route('blog.show', $article->slug)) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-dark"
                                           title="Partager sur X">
                                            <i class="fab fa-x-twitter me-2"></i>X (Twitter)
                                        </a>

                                        <!-- LinkedIn -->
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('blog.show', $article->slug)) }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-info text-white"
                                           title="Partager sur LinkedIn">
                                            <i class="fab fa-linkedin-in me-2"></i>LinkedIn
                                        </a>

                                        <!-- Copier le lien -->
                                        <button type="button"
                                                class="btn btn-outline-secondary"
                                                onclick="copyArticleLink()"
                                                title="Copier le lien">
                                            <i class="fas fa-link me-2"></i>Copier le lien
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>

                    <!-- Articles similaires -->
                    @if($relatedArticles->isNotEmpty())
                        <div class="mt-5">
                            <h3 class="mb-4">
                                <i class="fas fa-newspaper me-2 text-success"></i>Articles similaires
                            </h3>
                            <div class="row g-4">
                                @foreach($relatedArticles as $related)
                                    <div class="col-md-4">
                                        <div class="card h-100 border-0 shadow-sm article-card">
                                            @if($related->featured_image)
                                                <div class="position-relative overflow-hidden" style="height: 150px;">
                                                    <img src="{{ asset($related->featured_image) }}"
                                                         alt="{{ $related->title }}"
                                                         class="w-100 h-100"
                                                         style="object-fit: cover;">
                                                </div>
                                            @else
                                                <div class="bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 150px;">
                                                    <i class="fas fa-newspaper fa-2x text-success opacity-25"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h6 class="card-title mb-2">
                                                    <a href="{{ route('blog.show', $related->slug) }}"
                                                       class="text-dark text-decoration-none stretched-link">
                                                        {{ Str::limit($related->title, 60) }}
                                                    </a>
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $related->published_at->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Retour à la liste -->
                    <div class="mt-4">
                        <a href="{{ route('blog.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-arrow-left me-2"></i>Retour aux articles
                        </a>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- À propos de l'auteur -->
                    @if($article->author)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body">
                                <h5 class="mb-3">
                                    <i class="fas fa-user me-2 text-success"></i>À propos de l'auteur
                                </h5>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3"
                                         style="width: 50px; height: 50px; font-size: 24px;">
                                        {{ strtoupper(substr($article->author->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $article->author->name }}</div>
                                        <small class="text-muted">Auteur</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Informations -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">
                                <i class="fas fa-info-circle me-2 text-success"></i>Informations
                            </h5>
                            <div class="mb-2">
                                <i class="fas fa-calendar text-muted me-2"></i>
                                <small>Publié le {{ $article->published_at->format('d/m/Y à H:i') }}</small>
                            </div>
                            <div class="mb-2">
                                <i class="fas fa-clock text-muted me-2"></i>
                                <small>Lecture: {{ ceil(str_word_count(strip_tags($article->content)) / 200) }} min</small>
                            </div>
                            <div>
                                <i class="fas fa-eye text-muted me-2"></i>
                                <small>{{ $article->views }} vue{{ $article->views > 1 ? 's' : '' }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Appel à l'action -->
                    <div class="card border-0 shadow-sm bg-success text-white">
                        <div class="card-body text-center">
                            <h5 class="text-white mb-3">Rejoignez-nous</h5>
                            <p class="mb-3">Découvrez notre catalogue de livres africains et nos formations.</p>
                            <a href="{{ route('catalogue.index') }}" class="btn btn-light w-100 mb-2">
                                <i class="fas fa-book me-2"></i>Voir le catalogue
                            </a>
                            <a href="{{ route('formation.modules') }}" class="btn btn-outline-light w-100">
                                <i class="fas fa-graduation-cap me-2"></i>Nos formations
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Article Section End -->
@endsection

@push('styles')
<style>
    .article-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #333;
    }

    .article-content h1,
    .article-content h2,
    .article-content h3,
    .article-content h4,
    .article-content h5,
    .article-content h6 {
        margin-top: 1.5rem;
        margin-bottom: 1rem;
        color: #198754;
    }

    .article-content p {
        margin-bottom: 1rem;
    }

    .article-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1.5rem 0;
    }

    .article-content ul,
    .article-content ol {
        margin-bottom: 1rem;
        padding-left: 2rem;
    }

    .article-content blockquote {
        border-left: 4px solid #198754;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #666;
    }

    .article-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .stretched-link:hover {
        color: #198754 !important;
    }
</style>
@endpush

@push('scripts')
<script>
    function copyArticleLink() {
        const url = '{{ route("blog.show", $article->slug) }}';

        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                showToast('Lien copié dans le presse-papiers !');
            }, function() {
                showToast('Impossible de copier le lien.');
            });
        } else {
            // Fallback pour les navigateurs anciens
            const textarea = document.createElement('textarea');
            textarea.value = url;
            textarea.style.position = 'fixed';
            textarea.style.opacity = '0';
            document.body.appendChild(textarea);
            textarea.select();
            try {
                document.execCommand('copy');
                showToast('Lien copié dans le presse-papiers !');
            } catch (err) {
                showToast('Impossible de copier le lien.');
            }
            document.body.removeChild(textarea);
        }
    }

    function showToast(message) {
        const toastId = 'copy-toast';
        let toast = document.getElementById(toastId);

        if (!toast) {
            toast = document.createElement('div');
            toast.id = toastId;
            toast.style.position = 'fixed';
            toast.style.bottom = '20px';
            toast.style.right = '20px';
            toast.style.background = 'rgba(0, 0, 0, 0.8)';
            toast.style.color = 'white';
            toast.style.padding = '12px 20px';
            toast.style.borderRadius = '6px';
            toast.style.zIndex = '9999';
            toast.style.transition = 'opacity 0.3s';
            document.body.appendChild(toast);
        }

        toast.textContent = message;
        toast.style.opacity = '1';

        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 2000);
    }
</script>
@endpush
