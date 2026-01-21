@extends('admin.layout')

@section('title', 'Gestion de l\'équipe')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2><i class="fas fa-users me-2"></i>Gestion de l'équipe</h2>
            <p class="text-muted">Gérez les membres de votre équipe</p>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('admin.equipe.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Ajouter un membre
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Photo</th>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Email</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($membres as $membre)
                            <tr>
                                <td>
                                    @if($membre->photo)
                                        @if(str_starts_with($membre->photo, 'http') || str_starts_with($membre->photo, 'img/'))
                                            <img src="{{ asset($membre->photo) }}" alt="{{ $membre->nom }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        @endif
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $membre->nom }}</strong></td>
                                <td>{{ $membre->poste }}</td>
                                <td>{{ $membre->email ?? 'N/A' }}</td>
                                <td>
                                    @if($membre->actif)
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Actif</span>
                                    @else
                                        <span class="badge bg-secondary"><i class="fas fa-times me-1"></i>Inactif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.equipe.show', $membre->id) }}" class="btn btn-sm btn-info" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.equipe.edit', $membre->id) }}" class="btn btn-sm btn-warning" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $membre->id }}, '{{ $membre->nom }}')" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Aucun membre dans l'équipe</p>
                                    <a href="{{ route('admin.equipe.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Ajouter le premier membre
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                
                <!-- Pagination -->
                @if($membres->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $membres->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer <strong id="deleteMemberName"></strong> de l'équipe ?</p>
                    <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i>Cette action est irréversible.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Supprimer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(membreId, membreNom) {
        document.getElementById('deleteMemberName').textContent = membreNom;
        document.getElementById('deleteForm').action = '/admin/equipe/' + membreId;

        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
    }
</script>
@endpush
