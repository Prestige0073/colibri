@extends('admin.layout')

@section('title', 'Gestion des Modules')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0"><i class="fas fa-list me-2"></i>Gestion des Modules</h1>
                <p class="text-muted mb-0">{{ $modules->count() }} module(s) au total</p>
            </div>
            <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nouveau Module
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 60px;">Ordre</th>
                            <th>Titre</th>
                            <th>Formation</th>
                            <th style="width: 100px;">Durée</th>
                            <th style="width: 100px;">Contenus</th>
                            <th style="width: 100px;">Statut</th>
                            <th class="text-center" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($modules as $module)
                        <tr>
                            <td class="align-middle">#{{ $module->id }}</td>
                            <td class="align-middle">
                                <span class="badge bg-secondary">{{ $module->ordre }}</span>
                            </td>
                            <td class="align-middle">
                                <div class="fw-bold">{{ $module->titre }}</div>
                                <small class="text-muted">{{ Str::limit($module->description, 50) }}</small>
                            </td>
                            <td class="align-middle">
                                @if($module->formation)
                                    <a href="{{ route('admin.formations.show', $module->formation) }}" class="text-decoration-none">
                                        {{ $module->formation->titre }}
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $module->duree ?? '-' }}
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-primary">{{ $module->contenus->count() }}</span>
                            </td>
                            <td class="align-middle">
                                @if($module->active)
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Actif</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Inactif</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.modules.show', $module) }}" class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.modules.edit', $module) }}" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $module->id }}" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Supprimer -->
                        <div class="modal fade" id="deleteModal{{ $module->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title text-white">Supprimer le module</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Êtes-vous sûr de vouloir supprimer le module <strong>{{ $module->titre }}</strong> ?</p>
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Attention !</strong> Cette action supprimera également tous les contenus associés.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.modules.destroy', $module) }}" method="POST" style="display: inline;">
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
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="fas fa-list fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucun module trouvé</p>
                                <a href="{{ route('admin.modules.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Créer le premier module
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination -->
                @if($modules->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $modules->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
