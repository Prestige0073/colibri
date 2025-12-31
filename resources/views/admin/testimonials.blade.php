@extends('admin.layout')

@section('title', 'Gestion des Témoignages')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-comment-dots me-2 text-primary"></i>Gestion des Témoignages
                    </h1>
                    <p class="text-muted mb-0">Modérer et gérer les témoignages des utilisateurs</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #ffc107 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">En attente</p>
                            <h3 class="mb-0 fw-bold">{{ $pendingCount }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #198754 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Approuvés</p>
                            <h3 class="mb-0 fw-bold">{{ $approvedCount }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Rejetés</p>
                            <h3 class="mb-0 fw-bold">{{ $rejectedCount }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-times-circle fa-2x text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Liste des témoignages -->
    @if($testimonials->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-comment-dots fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun témoignage</h5>
                <p class="text-muted mb-0">Les témoignages des utilisateurs apparaîtront ici.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="60">Photo</th>
                                <th>Nom</th>
                                <th>Message</th>
                                <th>Note</th>
                                <th>Statut</th>
                                <th>Date</th>
                                <th width="220">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($testimonials as $testimonial)
                                <tr class="{{ $testimonial->status === 'pending' ? 'table-warning' : '' }}">
                                    <td>
                                        @if($testimonial->photo)
                                            <img src="{{ asset('storage/' . $testimonial->photo) }}"
                                                 alt="{{ $testimonial->name }}"
                                                 class="rounded-circle"
                                                 style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                                 style="width: 45px; height: 45px; font-size: 16px;">
                                                {{ $testimonial->initials }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $testimonial->name }}</strong>
                                        @if($testimonial->role)
                                            <br><small class="text-muted">{{ $testimonial->role }}</small>
                                        @endif
                                        @if($testimonial->company)
                                            <br><small class="text-muted">{{ $testimonial->company }}</small>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($testimonial->message, 80) }}</td>
                                    <td>
                                        <div class="text-warning">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-o opacity-25' }}"></i>
                                            @endfor
                                        </div>
                                    </td>
                                    <td>
                                        @if($testimonial->status === 'approved')
                                            <span class="badge bg-success">
                                                <i class="fas fa-check-circle me-1"></i>Approuvé
                                            </span>
                                        @elseif($testimonial->status === 'pending')
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>En attente
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times-circle me-1"></i>Rejeté
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $testimonial->created_at->format('d/m/Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @if($testimonial->status !== 'approved')
                                                <form action="{{ route('admin.testimonials.approve', $testimonial->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-success"
                                                            title="Approuver">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($testimonial->status !== 'pending')
                                                <form action="{{ route('admin.testimonials.pending', $testimonial->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-warning"
                                                            title="Mettre en attente">
                                                        <i class="fas fa-clock"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            @if($testimonial->status !== 'rejected')
                                                <form action="{{ route('admin.testimonials.reject', $testimonial->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                            class="btn btn-sm btn-secondary"
                                                            title="Rejeter">
                                                        <i class="fas fa-ban"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <button type="button"
                                                    class="btn btn-sm btn-danger"
                                                    title="Supprimer"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $testimonial->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal de confirmation de suppression -->
                                <div class="modal fade" id="deleteModal{{ $testimonial->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $testimonial->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $testimonial->id }}">
                                                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmation de suppression
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-3">Êtes-vous sûr de vouloir supprimer ce témoignage ?</p>
                                                <div class="alert alert-warning">
                                                    <strong>Attention :</strong> Cette action est irréversible.
                                                </div>
                                                <div class="card bg-light">
                                                    <div class="card-body">
                                                        <p class="mb-1"><strong>Auteur :</strong> {{ $testimonial->name }}</p>
                                                        <p class="mb-0"><strong>Message :</strong> {{ Str::limit($testimonial->message, 100) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-2"></i>Annuler
                                                </button>
                                                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-trash me-2"></i>Supprimer définitivement
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $testimonials->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .table-warning {
        background-color: #fff3cd44 !important;
    }

    .table > tbody > tr:hover {
        background-color: #f8f9fa;
    }

    .btn-group .btn {
        border-radius: 0;
    }

    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }

    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
</style>
@endpush
