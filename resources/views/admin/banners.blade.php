@extends('admin.layout')

@section('title', 'Gestion des Bannières')
@section('subtitle', $banners->count() . ' bannière(s)')

@section('content')

<!-- Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3">
                <div class="page-header-icon">
                    <i class="fas fa-images"></i>
                </div>
                <div>
                    <h1 class="page-title">Bannières du carousel</h1>
                    <p class="page-subtitle">Gérez les images de la bannière d'accueil (800 x 800 px)</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                <button class="btn-admin btn-admin-primary" data-bs-toggle="collapse" data-bs-target="#addBannerForm">
                    <i class="fas fa-plus me-2"></i>Ajouter une bannière
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-primary-soft text-primary">
                <i class="fas fa-images"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $banners->count() }}</span>
                <span class="quick-stat-label">Total bannières</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-success-soft text-success">
                <i class="fas fa-eye"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $banners->where('actif', true)->count() }}</span>
                <span class="quick-stat-label">Actives</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-warning-soft text-warning">
                <i class="fas fa-eye-slash"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $banners->where('actif', false)->count() }}</span>
                <span class="quick-stat-label">Inactives</span>
            </div>
        </div>
    </div>
</div>

<!-- Formulaire ajout -->
<div class="collapse mb-4" id="addBannerForm">
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <i class="fas fa-plus-circle"></i>
                <span>Ajouter une bannière</span>
            </h3>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Titre de la bannière <span class="text-danger">*</span></label>
                        <input type="text" name="titre" class="form-control" placeholder="Ex: Rapprocher le livre africain du lecteur" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Image <span class="text-danger">*</span> <small class="text-muted">(sera redimensionnée en 800x800)</small></label>
                        <input type="file" name="image" class="form-control" accept="image/*" required onchange="previewNewBanner(this)">
                    </div>
                    <div class="col-12">
                        <div id="newBannerPreview" style="display:none;" class="mb-3">
                            <img id="newBannerImg" src="" alt="Aperçu" style="max-height:200px; border-radius:12px; border:2px solid #e9ecef;">
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn-admin btn-admin-primary">
                            <i class="fas fa-save me-2"></i>Enregistrer
                        </button>
                        <button type="button" class="btn-admin btn-admin-outline ms-2" data-bs-toggle="collapse" data-bs-target="#addBannerForm">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Liste des bannières -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="fas fa-list"></i>
            <span>Bannières du carousel</span>
        </h3>
    </div>
    <div class="admin-card-body">
        @if($banners->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-images fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucune bannière</h5>
                <p class="text-muted">Ajoutez des images pour le carousel de la page d'accueil.</p>
            </div>
        @else
            <div class="row g-4" id="bannersGrid">
                @foreach($banners as $banner)
                    <div class="col-md-6 col-lg-4" data-id="{{ $banner->id }}">
                        <div class="banner-card {{ !$banner->actif ? 'banner-inactive' : '' }}">
                            <div class="banner-card-img">
                                <img src="{{ asset($banner->image) }}" alt="{{ $banner->titre }}">
                                <div class="banner-card-overlay">
                                    <span class="banner-order-badge">#{{ $banner->ordre }}</span>
                                    @if(!$banner->actif)
                                        <span class="badge bg-warning text-dark">Inactive</span>
                                    @else
                                        <span class="badge bg-success">Active</span>
                                    @endif
                                </div>
                            </div>
                            <div class="banner-card-body">
                                <h6 class="banner-card-title" title="{{ $banner->titre }}">{{ Str::limit($banner->titre, 50) }}</h6>
                                <div class="banner-card-actions">
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editBanner{{ $banner->id }}" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form method="POST" action="{{ route('admin.banners.destroy', $banner->id) }}" onsubmit="return confirm('Supprimer cette bannière ?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Modifier -->
                    <div class="modal fade" id="editBanner{{ $banner->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('admin.banners.update', $banner->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Modifier la bannière</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center mb-3">
                                            <img src="{{ asset($banner->image) }}" alt="{{ $banner->titre }}" style="max-height:200px; border-radius:12px;" id="editPreview{{ $banner->id }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Titre</label>
                                            <input type="text" name="titre" class="form-control" value="{{ $banner->titre }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Nouvelle image <small class="text-muted">(laisser vide pour garder l'actuelle)</small></label>
                                            <input type="file" name="image" class="form-control" accept="image/*" onchange="previewEditBanner(this, {{ $banner->id }})">
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="actif" id="actif{{ $banner->id }}" {{ $banner->actif ? 'checked' : '' }}>
                                            <label class="form-check-label" for="actif{{ $banner->id }}">Bannière active (visible sur le site)</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    .banner-card {
        border: 2px solid #e9ecef;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s;
        background: white;
    }

    .banner-card:hover {
        border-color: var(--bs-primary);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }

    .banner-inactive {
        opacity: 0.6;
    }

    .banner-inactive:hover {
        opacity: 0.9;
    }

    .banner-card-img {
        position: relative;
        aspect-ratio: 1;
        overflow: hidden;
    }

    .banner-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .banner-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 0.75rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .banner-order-badge {
        background: rgba(0,0,0,0.6);
        color: white;
        padding: 0.3rem 0.6rem;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .banner-card-body {
        padding: 1rem;
    }

    .banner-card-title {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        color: #2d3436;
    }

    .banner-card-actions {
        display: flex;
        gap: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
function previewNewBanner(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('newBannerImg').src = e.target.result;
            document.getElementById('newBannerPreview').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function previewEditBanner(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('editPreview' + id).src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
