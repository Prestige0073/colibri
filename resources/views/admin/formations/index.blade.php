@extends('admin.layout')

@section('title', 'Gestion des Formations')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-0"><i class="fas fa-graduation-cap me-2"></i>Gestion des Formations E-Learning</h1>
                <p class="text-muted mb-0">{{ $formations->total() }} formation(s) au total</p>
            </div>
            <a href="{{ route('admin.formations.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Nouvelle Formation
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
                            <th style="width: 80px;">Image</th>
                            <th>Titre</th>
                            <th style="width: 100px;">Prix</th>
                            <th style="width: 120px;">Niveau</th>
                            <th style="width: 100px;">Modules</th>
                            <th style="width: 100px;">Inscrits</th>
                            <th style="width: 100px;">Statut</th>
                            <th class="text-center" style="width: 200px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($formations as $formation)
                        <tr>
                            <td class="align-middle">#{{ $formation->id }}</td>
                            <td class="align-middle">
                                @if($formation->image)
                                    <img src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="align-middle">
                                <div class="fw-bold">{{ $formation->titre }}</div>
                                <small class="text-muted">{{ Str::limit($formation->description, 50) }}</small>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-success">{{ number_format($formation->prix, 2) }} €</span>
                            </td>
                            <td class="align-middle">
                                <span class="badge bg-{{ $formation->niveau === 'debutant' ? 'info' : ($formation->niveau === 'intermediaire' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($formation->niveau) }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-primary">{{ $formation->modules_count }}</span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-secondary">{{ $formation->inscriptions_count }}</span>
                            </td>
                            <td class="align-middle">
                                @if($formation->active)
                                    <span class="badge bg-success"><i class="fas fa-check me-1"></i>Active</span>
                                @else
                                    <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Inactive</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.formations.show', $formation) }}" class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.formations.edit', $formation) }}" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $formation->id }}" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Supprimer -->
                        <div class="modal fade" id="deleteModal{{ $formation->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title text-white">Supprimer la formation</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Êtes-vous sûr de vouloir supprimer la formation <strong>{{ $formation->titre }}</strong> ?</p>
                                        <div class="alert alert-danger">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            <strong>Attention !</strong> Cette action supprimera également tous les modules associés.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('admin.formations.destroy', $formation) }}" method="POST" style="display: inline;">
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
                            <td colspan="9" class="text-center py-4">
                                <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Aucune formation trouvée</p>
                                <a href="{{ route('admin.formations.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i>Créer la première formation
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($formations->hasPages())
        <div class="card-footer">
            {{ $formations->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
