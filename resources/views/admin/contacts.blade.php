@extends('admin.layout')

@section('title', 'Messages de contact')

@section('content')
<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-envelope me-2 text-primary"></i>Messages de contact
                    </h1>
                    <p class="text-muted mb-0">Gestion des messages reçus via le formulaire de contact</p>
                </div>
                <div class="d-flex gap-2 align-items-center flex-wrap">
                    @if($unreadCount > 0)
                        <span class="badge bg-danger rounded-pill px-3 py-2">
                            <i class="fas fa-bell me-1"></i>
                            {{ $unreadCount }} non lu{{ $unreadCount > 1 ? 's' : '' }}
                        </span>
                    @endif
                    <span class="badge bg-light text-dark border">
                        <i class="fas fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques rapides -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #dc3545 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Messages non lus</p>
                            <h3 class="mb-0 fw-bold">{{ $unreadCount }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-envelope fa-2x text-danger"></i>
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
                            <p class="text-muted mb-1 small">Messages lus</p>
                            <h3 class="mb-0 fw-bold">{{ $contacts->total() - $unreadCount }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-envelope-open fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #0d6efd !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small">Total des messages</p>
                            <h3 class="mb-0 fw-bold">{{ $contacts->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-inbox fa-2x text-primary"></i>
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

    @if($contacts->isEmpty())
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun message</h5>
                <p class="text-muted mb-0">Les messages des visiteurs apparaîtront ici.</p>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="50">
                                    <i class="fas fa-circle"></i>
                                </th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Sujet</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th width="200">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contacts as $contact)
                                <tr class="{{ !$contact->is_read ? 'table-warning' : '' }}">
                                    <td class="text-center">
                                        @if(!$contact->is_read)
                                            <i class="fas fa-circle text-danger" title="Non lu"></i>
                                        @else
                                            <i class="fas fa-circle text-muted opacity-25" title="Lu"></i>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $contact->name }}</strong>
                                        @if(!$contact->is_read)
                                            <span class="badge bg-danger ms-1">Nouveau</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope me-1"></i>{{ $contact->email }}
                                        </a>
                                    </td>
                                    <td>{{ Str::limit($contact->subject, 30) }}</td>
                                    <td>{{ Str::limit($contact->message, 50) }}</td>
                                    <td>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>{{ $contact->created_at->format('d/m/Y H:i') }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.contacts.show', $contact->id) }}" class="btn btn-sm btn-primary" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <form action="{{ route('admin.contacts.toggleRead', $contact->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ $contact->is_read ? 'btn-warning' : 'btn-success' }}" title="{{ $contact->is_read ? 'Marquer non lu' : 'Marquer lu' }}">
                                                    <i class="fas fa-{{ $contact->is_read ? 'envelope' : 'check' }}"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                {{ $contacts->links() }}
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
