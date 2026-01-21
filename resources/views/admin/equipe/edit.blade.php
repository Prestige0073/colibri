@extends('admin.layout')

@section('title', 'Modifier un membre')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-user-edit me-2"></i>Modifier un membre de l'équipe</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.equipe.index') }}">Équipe</a></li>
                    <li class="breadcrumb-item active">Modifier {{ $membre->nom }}</li>
                </ol>
            </nav>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <h5><i class="fas fa-exclamation-triangle me-2"></i>Erreurs de validation</h5>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="editForm" action="{{ route('admin.equipe.update', $membre->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation-confirm">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $membre->nom) }}" data-important="true">
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="poste" class="form-label">Poste <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('poste') is-invalid @enderror" id="poste" name="poste" value="{{ old('poste', $membre->poste) }}" data-important="true">
                                @error('poste')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Biographie</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $membre->bio) }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            @if($membre->photo)
                                <div class="mb-2">
                                    <p class="small text-muted">Photo actuelle:</p>
                                    @if(str_starts_with($membre->photo, 'http') || str_starts_with($membre->photo, 'img/'))
                                        <img src="{{ asset($membre->photo) }}" alt="{{ $membre->nom }}" class="img-thumbnail" style="max-width: 200px;">
                                    @else
                                        <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom }}" class="img-thumbnail" style="max-width: 200px;">
                                    @endif
                                </div>
                            @endif
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                            <small class="text-muted">Laissez vide pour conserver la photo actuelle. Format acceptés : JPG, PNG, GIF (Max: 2MB)</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $membre->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Statut</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="actif" name="actif" {{ old('actif', $membre->actif) ? 'checked' : '' }}>
                                <label class="form-check-label" for="actif">
                                    Membre actif (visible sur le site)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.equipe.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Retour
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body">
                    <p class="small"><strong>Créé le :</strong> {{ $membre->created_at->format('d/m/Y à H:i') }}</p>
                    <p class="small"><strong>Dernière modification :</strong> {{ $membre->updated_at->format('d/m/Y à H:i') }}</p>

                    <hr>

                    <h6>Statut du membre</h6>
                    <p class="small">Activez ou désactivez la visibilité du membre sur le site public.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('editForm');

        form.addEventListener('submit', function(e) {
            console.log('Form submit event triggered');

            // Valider les champs requis
            const nom = document.getElementById('nom').value.trim();
            const poste = document.getElementById('poste').value.trim();

            if (!nom || !poste) {
                e.preventDefault();
                alert('Veuillez remplir les champs obligatoires (Nom et Poste)');
                return false;
            }

            console.log('Form validation passed, submitting...');
        });
    });
</script>
<script src="{{ asset('js/form-validation.js') }}"></script>
@endpush

<!-- Modal de confirmation -->
@include('partials.confirmation-modal')
