@extends('admin.layout')

@section('title', 'Créer un Quiz')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1><i class="fas fa-plus-circle me-2"></i>Créer un Quiz</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quiz</a></li>
                <li class="breadcrumb-item active">Créer</li>
            </ol>
        </nav>
    </div>

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Erreurs de validation:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.quizzes.store') }}" method="POST">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations générales</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="titre" class="form-label">Titre du quiz <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('titre') is-invalid @enderror"
                                   id="titre" name="titre" value="{{ old('titre') }}" required>
                            @error('titre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="formation_id" class="form-label">Formation associée</label>
                            <select class="form-select @error('formation_id') is-invalid @enderror"
                                    id="formation_id" name="formation_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($formations as $formation)
                                    <option value="{{ $formation->id }}" {{ old('formation_id') == $formation->id ? 'selected' : '' }}>
                                        {{ $formation->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('formation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="module_id" class="form-label">Module associé</label>
                            <select class="form-select @error('module_id') is-invalid @enderror"
                                    id="module_id" name="module_id">
                                <option value="">-- Sélectionner --</option>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" {{ old('module_id') == $module->id ? 'selected' : '' }}>
                                        {{ $module->titre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('module_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Vous devez lier le quiz à une formation OU un module
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-cog me-2"></i>Paramètres du quiz</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="duree_minutes" class="form-label">Durée (minutes)</label>
                            <input type="number" class="form-control @error('duree_minutes') is-invalid @enderror"
                                   id="duree_minutes" name="duree_minutes" value="{{ old('duree_minutes') }}" min="1">
                            <small class="form-text text-muted">Laisser vide pour aucune limite</small>
                            @error('duree_minutes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="note_passage" class="form-label">Note de passage (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('note_passage') is-invalid @enderror"
                                   id="note_passage" name="note_passage" value="{{ old('note_passage', 50) }}" min="0" max="100" required>
                            @error('note_passage')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="nombre_tentatives" class="form-label">Nombre de tentatives <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('nombre_tentatives') is-invalid @enderror"
                                   id="nombre_tentatives" name="nombre_tentatives" value="{{ old('nombre_tentatives', 3) }}" min="1" max="10" required>
                            @error('nombre_tentatives')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="active" name="active" value="1" {{ old('active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="active">
                                    Quiz actif
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="afficher_reponses" name="afficher_reponses" value="1" {{ old('afficher_reponses', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="afficher_reponses">
                                Afficher les bonnes réponses après soumission
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="melanger_questions" name="melanger_questions" value="1" {{ old('melanger_questions') ? 'checked' : '' }}>
                            <label class="form-check-label" for="melanger_questions">
                                Mélanger l'ordre des questions
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="melanger_options" name="melanger_options" value="1" {{ old('melanger_options') ? 'checked' : '' }}>
                            <label class="form-check-label" for="melanger_options">
                                Mélanger l'ordre des options de réponse
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>Créer le Quiz
            </button>
        </div>
    </form>
</div>
@endsection
