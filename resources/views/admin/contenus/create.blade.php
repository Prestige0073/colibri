@extends('admin.layout')

@section('title', 'Ajouter un Contenu')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Ajouter un Contenu au Module</h4>
                    <p class="mb-0 mt-1 small">Module: <strong>{{ $module->titre }}</strong></p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.modules.contenus.store', $module) }}" method="POST" enctype="multipart/form-data" id="contenuForm">
                        @csrf

                        <div class="row">
                            <!-- Type de contenu -->
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Type de contenu <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Vidéo</option>
                                    <option value="pdf" {{ old('type') === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="audio" {{ old('type') === 'audio' ? 'selected' : '' }}>Audio</option>
                                    <option value="image" {{ old('type') === 'image' ? 'selected' : '' }}>Image</option>
                                    <option value="texte" {{ old('type') === 'texte' ? 'selected' : '' }}>Texte</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Titre -->
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ordre -->
                            <div class="col-md-2 mb-3">
                                <label for="ordre" class="form-label">Ordre <span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control @error('ordre') is-invalid @enderror" id="ordre" name="ordre" value="{{ old('ordre', $module->contenus->count() + 1) }}" required>
                                @error('ordre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fichier (pour video, pdf, audio, image) -->
                        <div class="mb-3" id="fichier-group">
                            <label for="fichier" class="form-label">Fichier</label>
                            <input type="file" class="form-control @error('fichier') is-invalid @enderror" id="fichier" name="fichier" accept="">
                            <small class="form-text text-muted" id="fichier-help">Taille maximale: 50 MB</small>
                            @error('fichier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contenu (pour texte) -->
                        <div class="mb-3 d-none" id="contenu-group">
                            <label for="contenu" class="form-label">Contenu texte</label>
                            <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="10">{{ old('contenu') }}</textarea>
                            <small class="form-text text-muted">Utilisez le HTML ou le Markdown pour formater le texte</small>
                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Durée (pour video et audio) -->
                        <div class="mb-3" id="duree-group">
                            <label for="duree" class="form-label">Durée</label>
                            <input type="text" class="form-control @error('duree') is-invalid @enderror" id="duree" name="duree" value="{{ old('duree') }}" placeholder="ex: 15 min" readonly>
                            <small class="form-text text-muted" id="duree-help">La durée sera calculée automatiquement après l'upload</small>
                            @error('duree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.modules.show', $module) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Créer le Contenu
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const fichierGroup = document.getElementById('fichier-group');
    const contenuGroup = document.getElementById('contenu-group');
    const dureeGroup = document.getElementById('duree-group');
    const fichierInput = document.getElementById('fichier');
    const fichierHelp = document.getElementById('fichier-help');
    const dureeInput = document.getElementById('duree');
    const dureeHelp = document.getElementById('duree-help');

    function formatDuration(seconds) {
        const hours = Math.floor(seconds / 3600);
        const minutes = Math.floor((seconds % 3600) / 60);
        const secs = Math.floor(seconds % 60);

        if (hours > 0) {
            return `${hours}h ${minutes}min`;
        } else if (minutes > 0) {
            return `${minutes}min ${secs}s`;
        } else {
            return `${secs}s`;
        }
    }

    function updateFormFields() {
        const type = typeSelect.value;

        // Gestion du type texte
        if (type === 'texte') {
            fichierGroup.classList.add('d-none');
            contenuGroup.classList.remove('d-none');
            dureeGroup.classList.add('d-none');
            fichierInput.removeAttribute('required');
            dureeInput.value = '';
        } else {
            fichierGroup.classList.remove('d-none');
            contenuGroup.classList.add('d-none');

            // Gestion du champ durée selon le type
            if (type === 'video' || type === 'audio') {
                dureeGroup.classList.remove('d-none');
                dureeInput.value = '';
                dureeInput.setAttribute('readonly', 'readonly');
                dureeHelp.textContent = 'La durée sera calculée automatiquement après l\'upload';
            } else {
                // PDF et Image n'ont pas de durée
                dureeGroup.classList.add('d-none');
                dureeInput.value = '';
            }

            // Configuration des types de fichiers acceptés
            switch(type) {
                case 'video':
                    fichierInput.setAttribute('accept', 'video/*');
                    fichierHelp.textContent = 'Formats acceptés: MP4, AVI, MOV, WebM. Taille max: 100MB';
                    break;
                case 'pdf':
                    fichierInput.setAttribute('accept', '.pdf');
                    fichierHelp.textContent = 'Format accepté: PDF. Taille max: 100MB';
                    break;
                case 'audio':
                    fichierInput.setAttribute('accept', 'audio/*');
                    fichierHelp.textContent = 'Formats acceptés: MP3, WAV, OGG. Taille max: 100MB';
                    break;
                case 'image':
                    fichierInput.setAttribute('accept', 'image/*');
                    fichierHelp.textContent = 'Formats acceptés: JPG, PNG, GIF, WebP. Taille max: 100MB';
                    break;
                default:
                    fichierInput.setAttribute('accept', '');
                    fichierHelp.textContent = 'Taille maximale: 100 MB';
            }
        }
    }

    // Calculer automatiquement la durée pour vidéos et audios
    fichierInput.addEventListener('change', function(e) {
        const type = typeSelect.value;
        const file = e.target.files[0];

        if (!file) {
            dureeInput.value = '';
            return;
        }

        if (type === 'video' || type === 'audio') {
            dureeHelp.textContent = 'Calcul de la durée en cours...';
            dureeHelp.classList.add('text-info');

            const url = URL.createObjectURL(file);
            const media = document.createElement(type);

            media.addEventListener('loadedmetadata', function() {
                const duration = media.duration;
                dureeInput.value = formatDuration(duration);
                dureeHelp.textContent = 'Durée calculée automatiquement';
                dureeHelp.classList.remove('text-info');
                dureeHelp.classList.add('text-success');
                URL.revokeObjectURL(url);
            });

            media.addEventListener('error', function() {
                dureeHelp.textContent = 'Erreur lors du calcul de la durée. Vous pouvez la saisir manuellement.';
                dureeHelp.classList.remove('text-info');
                dureeHelp.classList.add('text-danger');
                dureeInput.removeAttribute('readonly');
                URL.revokeObjectURL(url);
            });

            media.src = url;
        }
    });

    typeSelect.addEventListener('change', updateFormFields);
    updateFormFields();
});
</script>
@endsection
