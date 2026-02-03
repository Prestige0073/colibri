@extends('admin.layout')

@section('title', 'Détails de l\'Administrateur')
@section('subtitle', 'Informations et permissions de l\'administrateur')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Left Column - Info -->
        <div class="col-lg-4">
            <!-- Informations Personnelles -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary bg-opacity-10 border-0">
                    <h5 class="mb-0"><i class="fas fa-user text-primary me-2"></i>Informations Personnelles</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="avatar-circle-large bg-primary text-white mx-auto mb-3">
                            {{ strtoupper(substr($admin->name, 0, 2)) }}
                        </div>
                        <h4 class="mb-1">{{ $admin->name }}</h4>
                        <p class="text-muted">{{ $admin->email }}</p>

                        @if($admin->status === 'active')
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Actif
                            </span>
                        @elseif($admin->status === 'suspended')
                            <span class="badge bg-warning">
                                <i class="fas fa-pause-circle me-1"></i>Suspendu
                            </span>
                        @else
                            <span class="badge bg-danger">
                                <i class="fas fa-times-circle me-1"></i>Inactif
                            </span>
                        @endif
                    </div>

                    <hr>

                    <div class="info-item mb-3">
                        <label class="text-muted small">Téléphone</label>
                        <div class="fw-semibold">
                            @if($admin->phone)
                                <i class="fas fa-phone text-primary me-2"></i>{{ $admin->phone }}
                            @else
                                <span class="text-muted">Non renseigné</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <label class="text-muted small">Rôle</label>
                        <div class="fw-semibold">
                            @if($admin->role)
                                <span class="badge {{ $admin->role->is_predefined ? 'bg-primary' : 'bg-secondary' }} bg-opacity-10 text-dark border">
                                    <i class="fas fa-{{ $admin->role->is_predefined ? 'tag' : 'user-cog' }} me-1"></i>
                                    {{ $admin->role->name }}
                                </span>
                                @if($admin->role->description)
                                    <div class="small text-muted mt-1">{{ $admin->role->description }}</div>
                                @endif
                            @else
                                <span class="text-muted">Aucun rôle</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <label class="text-muted small">Créé par</label>
                        <div class="fw-semibold">
                            @if($admin->creator)
                                <i class="fas fa-user-shield text-primary me-2"></i>{{ $admin->creator->name }}
                            @else
                                <span class="text-muted">Système</span>
                            @endif
                        </div>
                    </div>

                    <div class="info-item mb-3">
                        <label class="text-muted small">Date de création</label>
                        <div class="fw-semibold">
                            <i class="fas fa-calendar text-primary me-2"></i>{{ $admin->created_at->format('d/m/Y H:i') }}
                            <div class="small text-muted">{{ $admin->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <label class="text-muted small">Dernière connexion</label>
                        <div class="fw-semibold">
                            @if($admin->last_login_at)
                                <i class="fas fa-sign-in-alt text-primary me-2"></i>{{ $admin->last_login_at->format('d/m/Y H:i') }}
                                <div class="small text-muted">{{ $admin->last_login_at->diffForHumans() }}</div>
                            @else
                                <span class="text-muted">Jamais connecté</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-top">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.admins.edit', $admin) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-1"></i>Modifier
                        </a>
                        <a href="{{ route('admin.admins.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Permissions & Logs -->
        <div class="col-lg-8">
            <!-- Permissions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-warning bg-opacity-10 border-0">
                    <h5 class="mb-0"><i class="fas fa-key text-warning me-2"></i>Permissions</h5>
                </div>
                <div class="card-body">
                    @if($admin->role && $admin->role->permissions->count() > 0)
                        @php
                            $permissionsByModule = $admin->role->permissions->groupBy('module');
                        @endphp

                        <div class="row">
                            @foreach($permissionsByModule as $module => $permissions)
                                <div class="col-md-6 mb-3">
                                    <div class="permission-module-card p-3 border rounded bg-light">
                                        <h6 class="mb-2 text-primary">
                                            <i class="fas fa-folder me-2"></i>{{ ucfirst($module) }}
                                        </h6>
                                        <div class="d-flex flex-wrap gap-1">
                                            @foreach($permissions as $permission)
                                                @php
                                                    $actionIcons = [
                                                        'view' => 'eye',
                                                        'create' => 'plus',
                                                        'update' => 'edit',
                                                        'delete' => 'trash',
                                                        'manage' => 'cog',
                                                        'export' => 'download',
                                                    ];
                                                    $actionColors = [
                                                        'view' => 'info',
                                                        'create' => 'success',
                                                        'update' => 'warning',
                                                        'delete' => 'danger',
                                                        'manage' => 'primary',
                                                        'export' => 'secondary',
                                                    ];
                                                @endphp
                                                <span class="badge bg-{{ $actionColors[$permission->action] ?? 'secondary' }} bg-opacity-75">
                                                    <i class="fas fa-{{ $actionIcons[$permission->action] ?? 'check' }} me-1"></i>
                                                    {{ ucfirst($permission->action) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Aucune permission n'est attribuée à cet administrateur.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Logs d'Audit -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-info bg-opacity-10 border-0">
                    <h5 class="mb-0"><i class="fas fa-history text-info me-2"></i>Historique des Actions</h5>
                </div>
                <div class="card-body p-0">
                    @if($admin->auditLogs->count() > 0)
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="table-light sticky-top">
                                    <tr>
                                        <th>Date</th>
                                        <th>Action</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($admin->auditLogs->sortByDesc('created_at')->take(50) as $log)
                                        <tr>
                                            <td class="small">
                                                {{ $log->created_at->format('d/m/Y H:i:s') }}
                                                <div class="text-muted" style="font-size: 0.7rem;">{{ $log->created_at->diffForHumans() }}</div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary bg-opacity-10 text-dark">
                                                    {{ $log->action }}
                                                </span>
                                                @if($log->model_type)
                                                    <div class="small text-muted">{{ class_basename($log->model_type) }} #{{ $log->model_id }}</div>
                                                @endif
                                            </td>
                                            <td class="small">
                                                <i class="fas fa-globe text-muted me-1"></i>{{ $log->ip_address }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history text-muted mb-2" style="font-size: 2rem; opacity: 0.3;"></i>
                            <p class="text-muted mb-0">Aucune action enregistrée</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .avatar-circle-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 2.5rem;
    }

    .info-item label {
        display: block;
        margin-bottom: 0.25rem;
        font-weight: 600;
    }

    .permission-module-card {
        transition: all 0.2s;
    }

    .permission-module-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush
@endsection
