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

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form id="editForm" action="{{ route('admin.equipe.update', $membre->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nom" class="form-label">Nom complet <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror" id="nom" name="nom" value="{{ old('nom', $membre->nom) }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="poste" class="form-label">Poste <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('poste') is-invalid @enderror" id="poste" name="poste" value="{{ old('poste', $membre->poste) }}" required>
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

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $membre->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="telephone" class="form-label">Téléphone</label>
                                <input type="text" class="form-control @error('telephone') is-invalid @enderror" id="telephone" name="telephone" value="{{ old('telephone', $membre->telephone) }}">
                                @error('telephone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Réseaux sociaux</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-linkedin"></i></span>
                                        <input type="url" class="form-control @error('linkedin') is-invalid @enderror" name="linkedin" placeholder="URL LinkedIn" value="{{ old('linkedin', $membre->linkedin) }}">
                                    </div>
                                    @error('linkedin')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                        <input type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter" placeholder="@username" value="{{ old('twitter', $membre->twitter) }}">
                                    </div>
                                    @error('twitter')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fab fa-facebook"></i></span>
                                        <input type="url" class="form-control @error('facebook') is-invalid @enderror" name="facebook" placeholder="URL Facebook" value="{{ old('facebook', $membre->facebook) }}">
                                    </div>
                                    @error('facebook')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ordre" class="form-label">Ordre d'affichage</label>
                                <input type="number" class="form-control @error('ordre') is-invalid @enderror" id="ordre" name="ordre" value="{{ old('ordre', $membre->ordre) }}" min="0">
                                <small class="text-muted">Plus le numéro est petit, plus il apparaît en premier</small>
                                @error('ordre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Statut</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="actif" name="actif" {{ old('actif', $membre->actif) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="actif">
                                        Membre actif (visible sur le site)
                                    </label>
                                </div>
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

                    <h6>Ordre d'affichage</h6>
                    <p class="small">Définit l'ordre d'apparition sur la page équipe. Les membres avec un ordre plus petit apparaissent en premier.</p>
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
@endpush
