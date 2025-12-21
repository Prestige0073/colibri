@extends('admin.layout')

@section('title', 'Modifier un Contenu')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier le Contenu</h4>
                    <p class="mb-0 mt-1 small">Module: <strong>{{ $contenu->module->titre }}</strong></p>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contenus.update', $contenu) }}" method="POST" enctype="multipart/form-data" id="contenuForm">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Type de contenu -->
                            <div class="col-md-4 mb-3">
                                <label for="type" class="form-label">Type de contenu <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">-- Sélectionner --</option>
                                    <option value="video" {{ old('type', $contenu->type) === 'video' ? 'selected' : '' }}>Vidéo</option>
                                    <option value="pdf" {{ old('type', $contenu->type) === 'pdf' ? 'selected' : '' }}>PDF</option>
                                    <option value="audio" {{ old('type', $contenu->type) === 'audio' ? 'selected' : '' }}>Audio</option>
                                    <option value="image" {{ old('type', $contenu->type) === 'image' ? 'selected' : '' }}>Image</option>
                                    <option value="texte" {{ old('type', $contenu->type) === 'texte' ? 'selected' : '' }}>Texte</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Titre -->
                            <div class="col-md-6 mb-3">
                                <label for="titre" class="form-label">Titre <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $contenu->titre) }}" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ordre -->
                            <div class="col-md-2 mb-3">
                                <label for="ordre" class="form-label">Ordre <span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control @error('ordre') is-invalid @enderror" id="ordre" name="ordre" value="{{ old('ordre', $contenu->ordre) }}" required>
                                @error('ordre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $contenu->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fichier actuel (si existe) -->
                        @if($contenu->fichier && $contenu->type !== 'texte')
                            <div class="mb-3">
                                <label class="form-label">Fichier actuel</label>
                                <div class="card bg-light">
                                    <div class="card-body py-2">
                                        @if($contenu->type === 'image')
                                            <img src="{{ asset($contenu->fichier) }}" alt="{{ $contenu->titre }}" class="img-thumbnail" style="max-width: 200px;">
                                        @elseif($contenu->type === 'video')
                                            <video controls style="max-width: 400px;">
                                                <source src="{{ asset($contenu->fichier) }}" type="video/mp4">
                                            </video>
                                        @elseif($contenu->type === 'audio')
                                            <audio controls>
                                                <source src="{{ asset($contenu->fichier) }}" type="audio/mpeg">
                                            </audio>
                                        @else
                                            <i class="fas fa-file me-2"></i>{{ basename($contenu->fichier) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Fichier (pour video, pdf, audio, image) -->
                        <div class="mb-3" id="fichier-group">
                            <label for="fichier" class="form-label">{{ $contenu->fichier ? 'Remplacer le fichier' : 'Fichier' }}</label>
                            <input type="file" class="form-control @error('fichier') is-invalid @enderror" id="fichier" name="fichier" accept="">
                            <small class="form-text text-muted" id="fichier-help">Taille maximale: 50 MB. Laissez vide pour conserver le fichier actuel.</small>
                            @error('fichier')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contenu (pour texte) -->
                        <div class="mb-3 d-none" id="contenu-group">
                            <label for="contenu" class="form-label">Contenu texte</label>
                            <textarea class="form-control @error('contenu') is-invalid @enderror" id="contenu" name="contenu" rows="10">{{ old('contenu', $contenu->contenu) }}</textarea>
                            <small class="form-text text-muted">Utilisez le HTML ou le Markdown pour formater le texte</small>
                            @error('contenu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Durée (pour video et audio) -->
                        <div class="mb-3" id="duree-group">
                            <label for="duree" class="form-label">Durée</label>
                            <input type="text" class="form-control @error('duree') is-invalid @enderror" id="duree" name="duree" value="{{ old('duree', $contenu->duree) }}" placeholder="ex: 15 min">
                            <small class="form-text text-muted" id="duree-help">Pour les vidéos/audios, la durée sera recalculée si vous changez le fichier</small>
                            @error('duree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.modules.show', $contenu->module) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Enregistrer les Modifications
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
        } else {
            fichierGroup.classList.remove('d-none');
            contenuGroup.classList.add('d-none');

            // Gestion du champ durée selon le type
            if (type === 'video' || type === 'audio') {
                dureeGroup.classList.remove('d-none');
                dureeInput.removeAttribute('readonly');
                dureeHelp.textContent = 'Pour les vidéos/audios, la durée sera recalculée si vous changez le fichier';
            } else {
                // PDF et Image n'ont pas de durée
                dureeGroup.classList.add('d-none');
            }

            // Configuration des types de fichiers acceptés
            switch(type) {
                case 'video':
                    fichierInput.setAttribute('accept', 'video/*');
                    fichierHelp.innerHTML = 'Formats acceptés: MP4, AVI, MOV, WebM. Taille max: 100MB. <strong>Laissez vide pour conserver le fichier actuel.</strong>';
                    break;
                case 'pdf':
                    fichierInput.setAttribute('accept', '.pdf');
                    fichierHelp.innerHTML = 'Format accepté: PDF. Taille max: 100MB. <strong>Laissez vide pour conserver le fichier actuel.</strong>';
                    break;
                case 'audio':
                    fichierInput.setAttribute('accept', 'audio/*');
                    fichierHelp.innerHTML = 'Formats acceptés: MP3, WAV, OGG. Taille max: 100MB. <strong>Laissez vide pour conserver le fichier actuel.</strong>';
                    break;
                case 'image':
                    fichierInput.setAttribute('accept', 'image/*');
                    fichierHelp.innerHTML = 'Formats acceptés: JPG, PNG, GIF, WebP. Taille max: 100MB. <strong>Laissez vide pour conserver le fichier actuel.</strong>';
                    break;
                default:
                    fichierInput.setAttribute('accept', '');
                    fichierHelp.innerHTML = 'Taille maximale: 100 MB. <strong>Laissez vide pour conserver le fichier actuel.</strong>';
            }
        }
    }

    // Calculer automatiquement la durée pour vidéos et audios lors du changement de fichier
    fichierInput.addEventListener('change', function(e) {
        const type = typeSelect.value;
        const file = e.target.files[0];

        if (!file) {
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
                dureeHelp.textContent = 'Erreur lors du calcul de la durée. Vous pouvez la modifier manuellement.';
                dureeHelp.classList.remove('text-info');
                dureeHelp.classList.add('text-danger');
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
