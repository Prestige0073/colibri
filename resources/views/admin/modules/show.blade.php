@extends('admin.layout')

@section('title', 'Détails du Module')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>{{ $module->titre }}</h1>
                <p class="text-muted mb-0">
                    Formation: <a href="{{ route('admin.formations.show', $module->formation) }}">{{ $module->formation->titre }}</a>
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Modifier
                </a>
                <a href="{{ route('admin.modules.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations du Module</h5>
                </div>
                <div class="card-body">
                    @if($module->description)
                        <div class="mb-3">
                            <h6 class="text-muted">Description</h6>
                            <p class="mb-0">{{ $module->description }}</p>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Ordre</h6>
                                <span class="badge bg-secondary fs-6">{{ $module->ordre }}</span>
                            </div>
                        </div>
                        @if($module->duree)
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Durée</h6>
                                    <span class="fs-6">{{ $module->duree }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Statut</h6>
                                @if($module->active)
                                    <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>Actif</span>
                                @else
                                    <span class="badge bg-danger fs-6"><i class="fas fa-times me-1"></i>Inactif</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Date de création</h6>
                                <span class="fs-6">{{ $module->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contenus -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Contenus ({{ $module->contenus->count() }})</h5>
                    <a href="{{ route('admin.modules.contenus.create', $module) }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i>Ajouter un Contenu
                    </a>
                </div>
                <div class="card-body p-0">
                    @forelse($module->contenus as $contenu)
                        <div class="border-bottom p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <span class="badge bg-secondary me-2">{{ $contenu->ordre }}</span>

                                        @if($contenu->type === 'video')
                                            <i class="fas fa-video text-danger me-1"></i>
                                        @elseif($contenu->type === 'pdf')
                                            <i class="fas fa-file-pdf text-danger me-1"></i>
                                        @elseif($contenu->type === 'audio')
                                            <i class="fas fa-headphones text-primary me-1"></i>
                                        @elseif($contenu->type === 'image')
                                            <i class="fas fa-image text-success me-1"></i>
                                        @elseif($contenu->type === 'texte')
                                            <i class="fas fa-file-alt text-secondary me-1"></i>
                                        @endif

                                        {{ $contenu->titre }}
                                        <span class="badge bg-info ms-2">{{ ucfirst($contenu->type) }}</span>
                                    </h6>
                                    @if($contenu->description)
                                        <p class="text-muted small mb-2">{{ Str::limit($contenu->description, 100) }}</p>
                                    @endif
                                    <div class="text-muted small">
                                        @if($contenu->fichier)
                                            <i class="fas fa-paperclip me-1"></i>{{ basename($contenu->fichier) }}
                                        @endif
                                        @if($contenu->duree)
                                            <span class="ms-3"><i class="fas fa-clock me-1"></i>{{ $contenu->duree }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.contenus.edit', $contenu) }}" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteContenuModal{{ $contenu->id }}" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Supprimer Contenu -->
                        <div class="modal fade" id="deleteContenuModal{{ $contenu->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title text-white">Supprimer le contenu</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Êtes-vous sûr de vouloir supprimer le contenu <strong>{{ $contenu->titre }}</strong> ?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.contenus.destroy', $contenu) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash me-1"></i>Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun contenu ajouté pour ce module</p>
                            <a href="{{ route('admin.modules.contenus.create', $module) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Créer le premier contenu
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="text-muted mb-0">Contenus</h6>
                            <h3 class="mb-0">{{ $module->contenus->count() }}</h3>
                        </div>
                        <i class="fas fa-file-alt fa-2x text-primary"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="text-muted mb-0">Vidéos</h6>
                            <h3 class="mb-0">{{ $module->contenus->where('type', 'video')->count() }}</h3>
                        </div>
                        <i class="fas fa-video fa-2x text-danger"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="text-muted mb-0">PDFs</h6>
                            <h3 class="mb-0">{{ $module->contenus->where('type', 'pdf')->count() }}</h3>
                        </div>
                        <i class="fas fa-file-pdf fa-2x text-danger"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="text-muted mb-0">Audios</h6>
                            <h3 class="mb-0">{{ $module->contenus->where('type', 'audio')->count() }}</h3>
                        </div>
                        <i class="fas fa-headphones fa-2x text-primary"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Images</h6>
                            <h3 class="mb-0">{{ $module->contenus->where('type', 'image')->count() }}</h3>
                        </div>
                        <i class="fas fa-image fa-2x text-success"></i>
                    </div>
                </div>
            </div>

            <!-- Formation associée -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Formation</h5>
                </div>
                <div class="card-body">
                    @if($module->formation->image)
                        <img src="{{ asset($module->formation->image) }}" alt="{{ $module->formation->titre }}" class="img-fluid rounded mb-3">
                    @endif
                    <h6>{{ $module->formation->titre }}</h6>
                    <p class="small text-muted mb-3">{{ Str::limit($module->formation->description, 100) }}</p>
                    <a href="{{ route('admin.formations.show', $module->formation) }}" class="btn btn-sm btn-primary w-100">
                        <i class="fas fa-eye me-1"></i>Voir la formation
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
