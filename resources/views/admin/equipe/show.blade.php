@extends('admin.layout')

@section('title', 'Détails du membre')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2><i class="fas fa-user me-2"></i>Détails du membre</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.equipe.index') }}">Équipe</a></li>
                    <li class="breadcrumb-item active">{{ $membre->nom }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @if($membre->photo)
                        @if(str_starts_with($membre->photo, 'http') || str_starts_with($membre->photo, 'img/'))
                            <img src="{{ asset($membre->photo) }}" alt="{{ $membre->nom }}" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                        @else
                            <img src="{{ asset('storage/' . $membre->photo) }}" alt="{{ $membre->nom }}" class="img-fluid rounded-circle mb-3" style="width: 200px; height: 200px; object-fit: cover;">
                        @endif
                    @else
                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                            <i class="fas fa-user fa-5x text-white"></i>
                        </div>
                    @endif

                    <h3 class="mb-2">{{ $membre->nom }}</h3>
                    <p class="text-muted mb-3">{{ $membre->poste }}</p>

                    <div class="d-flex justify-content-center gap-2 mb-3">
                        @if($membre->actif)
                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Actif</span>
                        @else
                            <span class="badge bg-secondary"><i class="fas fa-times me-1"></i>Inactif</span>
                        @endif
                    </div>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.equipe.edit', $membre->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Modifier
                        </a>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $membre->id }}, '{{ $membre->nom }}')">
                            <i class="fas fa-trash me-2"></i>Supprimer
                        </button>
                        <a href="{{ route('admin.equipe.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations générales</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong><i class="fas fa-envelope me-2 text-primary"></i>Email :</strong>
                        @if($membre->email)
                            <a href="mailto:{{ $membre->email }}">{{ $membre->email }}</a>
                        @else
                            <span class="text-muted">Non renseigné</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <strong><i class="fas fa-align-left me-2 text-primary"></i>Biographie :</strong>
                        <p class="mt-2">{{ $membre->bio ?? 'Aucune biographie' }}</p>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Informations système</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong><i class="fas fa-calendar-plus me-2 text-success"></i>Créé le :</strong><br>
                            {{ $membre->created_at->format('d/m/Y à H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong><i class="fas fa-calendar-check me-2 text-warning"></i>Dernière modification :</strong><br>
                            {{ $membre->updated_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>
                </div>
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
