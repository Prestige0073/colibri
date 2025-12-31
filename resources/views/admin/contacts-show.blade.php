@extends('admin.layout')

@section('title', 'Message de ' . $contact->name)

@section('content')
<div class="container-fluid py-4">
    <!-- Bouton retour -->
    <div class="mb-4">
        <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Retour à la liste
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Message -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h4 class="mb-1">
                                <i class="fas fa-envelope-open text-primary me-2"></i>{{ $contact->subject }}
                            </h4>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $contact->created_at->format('d/m/Y à H:i') }}
                            </small>
                        </div>
                        <div>
                            @if($contact->is_read)
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle me-1"></i>Lu
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-exclamation-circle me-1"></i>Non lu
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted mb-2">Message:</h6>
                        <div class="p-3 bg-light rounded">
                            <p class="mb-0" style="white-space: pre-line;">{{ $contact->message }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Informations expéditeur -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-user me-2"></i>Informations de l'expéditeur
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="small text-muted mb-1">Nom:</label>
                        <div class="fw-bold">{{ $contact->name }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1">Email:</label>
                        <div>
                            <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                <i class="fas fa-envelope me-1"></i>{{ $contact->email }}
                            </a>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="small text-muted mb-1">Date d'envoi:</label>
                        <div>{{ $contact->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if($contact->is_read && $contact->read_at)
                        <div class="mb-3">
                            <label class="small text-muted mb-1">Lu le:</label>
                            <div>{{ $contact->read_at->format('d/m/Y H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="btn btn-primary">
                            <i class="fas fa-reply me-2"></i>Répondre par email
                        </a>

                        <form action="{{ route('admin.contacts.toggleRead', $contact->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-{{ $contact->is_read ? 'warning' : 'success' }} w-100">
                                <i class="fas fa-{{ $contact->is_read ? 'envelope' : 'check-circle' }} me-2"></i>
                                {{ $contact->is_read ? 'Marquer comme non lu' : 'Marquer comme lu' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>Supprimer le message
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
