@extends('admin.layout')

@section('title', 'Créer un nouvel article')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-plus me-2 text-primary"></i>Créer un nouvel article
                    </h1>
                    <p class="text-muted mb-0">Rédigez et publiez un article pour le blog</p>
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
                    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                   value="{{ old('title') }}"
                                   required>
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
                                      placeholder="Bref résumé de l'article (optionnel)...">{{ old('excerpt') }}</textarea>
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
                                      name="content">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Image mise en avant -->
                        <div class="mb-4">
                            <label for="featured_image" class="form-label fw-bold">
                                <i class="fas fa-image me-2 text-primary"></i>Image mise en avant
                            </label>
                            <input type="file"
                                   class="form-control @error('featured_image') is-invalid @enderror"
                                   id="featured_image"
                                   name="featured_image"
                                   accept="image/*">
                            @error('featured_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formats acceptés: JPEG, PNG, JPG, GIF, WEBP (max 2 Mo)</small>
                        </div>

                        <!-- Prévisualisation de l'image -->
                        <div class="mb-4" id="imagePreview" style="display: none;">
                            <img src="" alt="Prévisualisation" class="img-thumbnail" style="max-width: 300px;">
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
                                           {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}>
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
                                           {{ old('status') === 'published' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status_published">
                                        <i class="fas fa-check-circle text-success me-1"></i>Publié
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('admin.blog.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer l'article
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
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

    // Synchroniser Quill avec le textarea caché
    var form = document.querySelector('form');
    form.addEventListener('submit', function() {
        var content = document.querySelector('#content');
        content.value = quill.root.innerHTML;
    });

    // Si old('content') existe, charger dans Quill
    var oldContent = document.querySelector('#content').value;
    if (oldContent) {
        quill.root.innerHTML = oldContent;
    }

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
