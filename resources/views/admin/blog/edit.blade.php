@extends('admin.layout')

@section('title', 'Modifier l\'article')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>Modifier l'article
                    </h1>
                    <p class="text-muted mb-0">Modifiez le contenu de votre article</p>
                </div>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.blog.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation-confirm">
                        @csrf
                        @method('PUT')

                        <!-- Titre -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-bold">
                                <i class="fas fa-heading me-2 text-primary"></i>Titre de l'article
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control form-control-lg @error('title') is-invalid @enderror"
                                   id="title"
                                   name="title"
                                   placeholder="Entrez un titre accrocheur..."
                                   value="{{ old('title', $article->title) }}"
                                   data-important="true">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Extrait -->
                        <div class="mb-4">
                            <label for="excerpt" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2 text-primary"></i>Extrait (résumé)
                            </label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                      id="excerpt"
                                      name="excerpt"
                                      rows="3"
                                      placeholder="Bref résumé de l'article (optionnel)...">{{ old('excerpt', $article->excerpt) }}</textarea>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Cet extrait sera affiché dans la liste des articles.</small>
                        </div>

                        <!-- Contenu -->
                        <div class="mb-4">
                            <label for="content" class="form-label fw-bold">
                                <i class="fas fa-file-alt me-2 text-primary"></i>Contenu de l'article
                                <span class="text-danger">*</span>
                            </label>
                            <div id="editor" style="height: 400px; background: white;"></div>
                            <textarea class="form-control @error('content') is-invalid @enderror d-none"
                                      id="content"
                                      name="content"
                                      data-important="true">{{ old('content', $article->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image actuelle -->
                        @if($article->featured_image)
                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-image me-2 text-primary"></i>Image actuelle
                                </label>
                                <div>
                                    <img src="{{ asset($article->featured_image) }}"
                                         alt="{{ $article->title }}"
                                         class="img-thumbnail"
                                         style="max-width: 300px;">
                                </div>
                            </div>
                        @endif

                        <!-- Nouvelle image -->
                        <div class="mb-4">
                            <label for="featured_image" class="form-label fw-bold">
                                <i class="fas fa-image me-2 text-primary"></i>
                                {{ $article->featured_image ? 'Changer l\'image mise en avant' : 'Image mise en avant' }}
                            </label>
                            <input type="file"
                                   class="form-control @error('featured_image') is-invalid @enderror"
                                   id="featured_image"
                                   name="featured_image"
                                   accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formats acceptés: JPEG, PNG, JPG, GIF, WEBP (jusqu'à 512 Mo)</small>
                        </div>

                        <!-- Prévisualisation de la nouvelle image -->
                        <div class="mb-4" id="imagePreview" style="display: none;">
                            <label class="form-label fw-bold">Prévisualisation</label>
                            <div>
                                <img src="" alt="Prévisualisation" class="img-thumbnail" style="max-width: 300px;">
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-toggle-on me-2 text-primary"></i>Statut de publication
                                <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="status"
                                           id="status_draft"
                                           value="draft"
                                           {{ old('status', $article->status) === 'draft' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_draft">
                                        <i class="fas fa-edit text-warning me-1"></i>Brouillon
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="radio"
                                           name="status"
                                           id="status_published"
                                           value="published"
                                           {{ old('status', $article->status) === 'published' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_published">
                                        <i class="fas fa-check-circle text-success me-1"></i>Publié
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Informations supplémentaires -->
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Informations:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Slug: <code>{{ $article->slug }}</code></li>
                                <li>Vues: {{ $article->views }}</li>
                                @if($article->published_at)
                                    <li>Publié le: {{ $article->published_at->format('d/m/Y à H:i') }}</li>
                                @endif
                            </ul>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmation -->
@include('partials.confirmation-modal')
@endsection

@push('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/form-validation.js') }}"></script>
<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<script>
    // Initialiser Quill
    var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                ['bold', 'italic', 'underline', 'strike'],
                [{ 'color': [] }, { 'background': [] }],
                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                [{ 'align': [] }],
                ['link', 'image', 'video'],
                ['blockquote', 'code-block'],
                ['clean']
            ]
        },
        placeholder: 'Rédigez le contenu de votre article ici...'
    });

    // Charger le contenu existant
    var existingContent = document.querySelector('#content').value;
    if (existingContent) {
        quill.root.innerHTML = existingContent;
    }

    // Synchroniser Quill avec le textarea caché
    var form = document.querySelector('form');
    form.addEventListener('submit', function() {
        var content = document.querySelector('#content');
        content.value = quill.root.innerHTML;
    });

    // Prévisualisation de l'image
    document.getElementById('featured_image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                preview.querySelector('img').src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
