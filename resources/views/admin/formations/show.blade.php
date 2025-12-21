@extends('admin.layout')

@section('title', 'Détails de la Formation')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="h3 mb-0"><i class="fas fa-graduation-cap me-2"></i>{{ $formation->titre }}</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.formations.edit', $formation) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Modifier
                </a>
                <a href="{{ route('admin.formations.index') }}" class="btn btn-secondary">
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
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations de la Formation</h5>
                </div>
                <div class="card-body">
                    @if($formation->image)
                        <div class="mb-4">
                            <img src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}" class="img-fluid rounded" style="max-height: 300px; width: 100%; object-fit: cover;">
                        </div>
                    @endif

                    <div class="mb-3">
                        <h6 class="text-muted">Description</h6>
                        <p class="mb-0">{{ $formation->description }}</p>
                    </div>

                    @if($formation->objectifs)
                        <div class="mb-3">
                            <h6 class="text-muted">Objectifs</h6>
                            <p class="mb-0">{{ $formation->objectifs }}</p>
                        </div>
                    @endif

                    @if($formation->prerequis)
                        <div class="mb-3">
                            <h6 class="text-muted">Prérequis</h6>
                            <p class="mb-0">{{ $formation->prerequis }}</p>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Prix</h6>
                                <span class="badge bg-success fs-6">{{ number_format($formation->prix, 2) }} €</span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Niveau</h6>
                                <span class="badge bg-{{ $formation->niveau === 'debutant' ? 'info' : ($formation->niveau === 'intermediaire' ? 'warning' : 'danger') }} fs-6">
                                    {{ ucfirst($formation->niveau) }}
                                </span>
                            </div>
                        </div>
                        @if($formation->duree)
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Durée</h6>
                                    <span class="fs-6">{{ $formation->duree }}</span>
                                </div>
                            </div>
                        @endif
                        @if($formation->categorie)
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <h6 class="text-muted mb-1">Catégorie</h6>
                                    <span class="fs-6">{{ $formation->categorie }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Note minimale certification</h6>
                                <span class="fs-6">{{ $formation->note_minimale_certification }}%</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Statut</h6>
                                @if($formation->active)
                                    <span class="badge bg-success fs-6"><i class="fas fa-check me-1"></i>Active</span>
                                @else
                                    <span class="badge bg-danger fs-6"><i class="fas fa-times me-1"></i>Inactive</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <h6 class="text-muted mb-1">Date de création</h6>
                                <span class="fs-6">{{ $formation->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modules -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Modules ({{ $formation->modules->count() }})</h5>
                    <a href="{{ route('admin.modules.create') }}?formation_id={{ $formation->id }}" class="btn btn-sm btn-light">
                        <i class="fas fa-plus me-1"></i>Ajouter un Module
                    </a>
                </div>
                <div class="card-body p-0">
                    @forelse($formation->modules as $module)
                        <div class="border-bottom p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">
                                        <span class="badge bg-secondary me-2">{{ $module->ordre }}</span>
                                        {{ $module->titre }}
                                        @if(!$module->active)
                                            <span class="badge bg-danger ms-2">Inactif</span>
                                        @endif
                                    </h6>
                                    @if($module->description)
                                        <p class="text-muted small mb-2">{{ Str::limit($module->description, 100) }}</p>
                                    @endif
                                    <div class="text-muted small">
                                        <i class="fas fa-file-alt me-1"></i>{{ $module->contenus->count() }} contenu(s)
                                        @if($module->duree)
                                            <span class="ms-3"><i class="fas fa-clock me-1"></i>{{ $module->duree }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.modules.show', $module) }}" class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <i class="fas fa-list fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun module ajouté pour cette formation</p>
                            <a href="{{ route('admin.modules.create') }}?formation_id={{ $formation->id }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Créer le premier module
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Statistiques et inscriptions -->
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistiques</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="text-muted mb-0">Modules</h6>
                            <h3 class="mb-0">{{ $formation->modules->count() }}</h3>
                        </div>
                        <i class="fas fa-list fa-2x text-primary"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div>
                            <h6 class="text-muted mb-0">Inscrits</h6>
                            <h3 class="mb-0">{{ $formation->inscriptions->count() }}</h3>
                        </div>
                        <i class="fas fa-users fa-2x text-success"></i>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-0">Certificats délivrés</h6>
                            <h3 class="mb-0">{{ $formation->certificats->count() }}</h3>
                        </div>
                        <i class="fas fa-certificate fa-2x text-warning"></i>
                    </div>
                </div>
            </div>

            <!-- Dernières inscriptions -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Dernières Inscriptions</h5>
                </div>
                <div class="card-body p-0">
                    @forelse($formation->inscriptions->take(5) as $inscription)
                        <div class="border-bottom p-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1">{{ $inscription->user->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>{{ $inscription->date_inscription->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $inscription->statut === 'termine' ? 'success' : ($inscription->statut === 'en_cours' ? 'primary' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $inscription->statut)) }}
                                    </span>
                                    <div class="small text-muted mt-1">{{ $inscription->progression }}%</div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Aucune inscription</p>
                        </div>
                    @endforelse
                </div>
                @if($formation->inscriptions->count() > 5)
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-sm btn-link">Voir toutes les inscriptions ({{ $formation->inscriptions->count() }})</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
