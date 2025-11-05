@extends('admin.layout')
@section('title', 'Admin - Utilisateurs')
@section('content')
    <div class="container-fluid py-4">
        <!-- Toast notification -->
        <div aria-live="polite" aria-atomic="true"
            style="position: fixed; top: 1.5rem; right: 1.5rem; min-width: 320px; z-index: 1080; pointer-events: none;">
            @if (session('success'))
                <div id="toast-success"
                    class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                    role="alert" aria-live="assertive" aria-atomic="true"
                    style="pointer-events:auto; background:#1bc47d; color:#fff; font-weight:500;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fermer"></button>
                    </div>
                </div>
            @endif
            @if (session('error'))
                <div id="toast-error"
                    class="toast align-items-center border-0 shadow-lg show animate__animated animate__slideInDown"
                    role="alert" aria-live="assertive" aria-atomic="true"
                    style="pointer-events:auto; background:#e53935; color:#fff; font-weight:500;">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Fermer"></button>
                    </div>
                </div>
            @endif
        </div>
        <h2 class="fw-bold mb-4" style="color:#1976d2;">Gestion des utilisateurs</h2>
        <div class="card shadow-lg border-0 rounded-4"
            style="background: #e3f0ff; box-shadow: 0 2px 16px 0 rgba(33,150,243,0.10);">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered" style="background:#fff;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Adresse</th>
                                <th>Rôle</th>
                                <th>Blocage</th>
                                <th>Suppression</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ ucfirst($user->role) }}</td>
                                    <td>
                                        <!-- Bouton Bloquer/Débloquer -->
                                        <button type="button" class="btn btn-sm btn-warning rounded-pill shadow-sm"
                                            data-bs-toggle="modal" data-bs-target="#blockUserModal{{ $user->id }}">
                                            {{ $user->blocked ? 'Débloquer' : 'Bloquer' }}
                                        </button>
                                        <!-- Modal de confirmation Bloquer/Débloquer -->
                                        <div class="modal fade" id="blockUserModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="blockUserModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="blockUserModalLabel{{ $user->id }}">
                                                            Confirmation
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir
                                                        {{ $user->blocked ? 'débloquer' : 'bloquer' }} l'utilisateur
                                                        <strong>{{ $user->name }}</strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                        <form action="{{ route('admin.users.toggle-block', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning">
                                                                Oui, {{ $user->blocked ? 'débloquer' : 'bloquer' }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- Bouton Supprimer avec confirmation -->
                                        <button type="button" class="btn btn-sm btn-danger rounded-pill shadow-sm"
                                            data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                            Supprimer
                                        </button>
                                        <!-- Modal de confirmation Suppression -->
                                        <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1"
                                            aria-labelledby="deleteUserModalLabel{{ $user->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deleteUserModalLabel{{ $user->id }}">
                                                            Confirmation de suppression
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Fermer"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Êtes-vous sûr de vouloir supprimer l'utilisateur
                                                        <strong>{{ $user->name }}</strong> ?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annuler</button>
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">
                                                                Oui, supprimer
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endpush

@push('scripts')
    <script>
        // Toast auto-dismiss
        document.addEventListener('DOMContentLoaded', function() {
            var toastSuccess = document.getElementById('toast-success');
            var toastError = document.getElementById('toast-error');
            // Utilise l'API Bootstrap Toast si disponible
            if (window.bootstrap && window.bootstrap.Toast) {
                if (toastSuccess) {
                    var bsToast = new bootstrap.Toast(toastSuccess, {
                        delay: 5000
                    });
                    bsToast.show();
                    toastSuccess.addEventListener('hidden.bs.toast', function() {
                        toastSuccess.remove();
                    });
                }
                if (toastError) {
                    var bsToast2 = new bootstrap.Toast(toastError, {
                        delay: 5000
                    });
                    bsToast2.show();
                    toastError.addEventListener('hidden.bs.toast', function() {
                        toastError.remove();
                    });
                }
            } else {
                // Fallback animation si Bootstrap Toast n'est pas chargé
                if (toastSuccess) {
                    setTimeout(function() {
                        toastSuccess.classList.remove('animate__slideInDown');
                        toastSuccess.classList.add('animate__slideOutUp');
                        setTimeout(function() {
                            toastSuccess.remove();
                        }, 1000);
                    }, 5000);
                }
                if (toastError) {
                    setTimeout(function() {
                        toastError.classList.remove('animate__slideInDown');
                        toastError.classList.add('animate__slideOutUp');
                        setTimeout(function() {
                            toastError.remove();
                        }, 1000);
                    }, 5000);
                }
            }
        });
    </script>
@endpush
