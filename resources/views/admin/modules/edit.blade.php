@extends('admin.layout')

@section('title', 'Modifier un Module')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Modifier le Module</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.modules.update', $module) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Formation -->
                        <div class="mb-3">
                            <label for="formation_id" class="form-label">Formation <span class="text-danger">*</span></label>
                            <select class="form-select @error('formation_id') is-invalid @enderror" id="formation_id" name="formation_id" required>
                                <option value="">-- Sélectionner une formation --</option>
                                @foreach($formations as $formation)
                                    <option value="{{ $formation->id }}" {{ old('formation_id', $module->formation_id) == $formation->id ? 'selected' : '' }}>
                                        {{ $formation->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('formation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <!-- Titre -->
                            <div class="col-md-9 mb-3">
                                <label for="titre" class="form-label">Titre du module <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('titre') is-invalid @enderror" id="titre" name="titre" value="{{ old('titre', $module->titre) }}" required>
                                @error('titre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ordre -->
                            <div class="col-md-3 mb-3">
                                <label for="ordre" class="form-label">Ordre <span class="text-danger">*</span></label>
                                <input type="number" min="0" class="form-control @error('ordre') is-invalid @enderror" id="ordre" name="ordre" value="{{ old('ordre', $module->ordre) }}" required>
                                @error('ordre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description', $module->description) }}</textarea>
                            <small class="form-text text-muted">Décrivez le contenu et les objectifs de ce module</small>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Durée -->
                        <div class="mb-3">
                            <label for="duree" class="form-label">Durée estimée</label>
                            <input type="text" class="form-control @error('duree') is-invalid @enderror" id="duree" name="duree" value="{{ old('duree', $module->duree) }}" placeholder="ex: 2 heures">
                            @error('duree')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Active -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="active" name="active" value="1" {{ old('active', $module->active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="active">
                                Module actif (visible pour les utilisateurs)
                            </label>
                        </div>

                        <hr>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">
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
@endsection
