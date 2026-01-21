@extends('admin.layout')

@section('title', 'Créer une Formation')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-plus me-2"></i>Créer une Nouvelle Formation</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.formations.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation-confirm">
                        @csrf

                        <div class="row">
                            <!-- Titre -->
                            <div class="col-md-8 mb-3">
                                <label for="titre" class="form-label">Titre de la formation <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre') }}" data-important="true">
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Prix -->
                            <div class="col-md-4 mb-3">
                                <label for="prix" class="form-label">Prix (FCFA) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" min="0" class="form-control @error('prix') is-invalid @enderror" id="prix" name="prix" value="{{ old('prix', 0) }}" data-important="true">
                                @error('prix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4" data-important="true">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Objectifs -->
                        <div class="mb-3">
                            <label for="objectifs" class="form-label">Objectifs de la formation</label>
                            <textarea class="form-control @error('objectifs') is-invalid @enderror" id="objectifs" name="objectifs" rows="3">{{ old('objectifs') }}</textarea>
                            <small class="form-text text-muted">Décrivez ce que les apprenants vont acquérir</small>
                            @error('objectifs')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Niveau -->
                            <div class="col-md-4 mb-3">
                                <label for="niveau" class="form-label">Niveau <span class="text-danger">*</span></label>
                                <select class="form-select @error('niveau') is-invalid @enderror" id="niveau" name="niveau" data-important="true">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="debutant" {{ old('niveau') === 'debutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="intermediaire" {{ old('niveau') === 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="avance" {{ old('niveau') === 'avance' ? 'selected' : '' }}>Avancé</option>
                                </select>
                                @error('niveau')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Durée -->
                            <div class="col-md-4 mb-3">
                                <label for="duree" class="form-label">Durée estimée</label>
                                <input type="text" class="form-control @error('duree') is-invalid @enderror" id="duree" name="duree" value="{{ old('duree') }}" placeholder="ex: 10 heures">
                                @error('duree')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Catégorie -->
                            <div class="col-md-4 mb-3">
                                <label for="categorie" class="form-label">Catégorie</label>
                                <input type="text" class="form-control @error('categorie') is-invalid @enderror" id="categorie" name="categorie" value="{{ old('categorie') }}" placeholder="ex: Développement Web">
                                @error('categorie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Prérequis -->
                        <div class="mb-3">
                            <label for="prerequis" class="form-label">Prérequis</label>
                            <textarea class="form-control @error('prerequis') is-invalid @enderror" id="prerequis" name="prerequis" rows="2">{{ old('prerequis') }}</textarea>
                            <small class="form-text text-muted">Connaissances nécessaires avant de suivre cette formation</small>
                            @error('prerequis')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Note minimale certification -->
                            <div class="col-md-6 mb-3">
                                <label for="note_minimale_certification" class="form-label">Note minimale pour certification (%)</label>
                                <input type="number" min="0" max="100" class="form-control @error('note_minimale_certification') is-invalid @enderror" id="note_minimale_certification" name="note_minimale_certification" value="{{ old('note_minimale_certification', 70) }}">
                                @error('note_minimale_certification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image -->
                            <div class="col-md-6 mb-3">
                                <label for="image" class="form-label">Image de couverture</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                <small class="form-text text-muted">Format: JPG, PNG (max 2MB)</small>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Active -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">
                                Formation active (visible pour les utilisateurs)
                            </label>
                        </div>

                        <hr>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.formations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Créer la Formation
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

@push('scripts')
<script src="{{ asset('js/form-validation.js') }}"></script>
@endpush
