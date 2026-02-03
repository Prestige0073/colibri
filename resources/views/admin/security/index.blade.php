@extends('admin.layout')

@section('title', 'Tableau de bord Sécurité')

@section('content')
<div class="container-fluid px-4">
    <!-- Statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning bg-opacity-10 rounded-3 p-3">
                            <i class="fa fa-exclamation-triangle text-warning fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['total_attempts_24h'] }}</h3>
                            <small class="text-muted">Tentatives (24h)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-info bg-opacity-10 rounded-3 p-3">
                            <i class="fa fa-chart-line text-info fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['total_attempts_7d'] }}</h3>
                            <small class="text-muted">Tentatives (7j)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger bg-opacity-10 rounded-3 p-3">
                            <i class="fa fa-user-lock text-danger fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['blocked_users'] }}</h3>
                            <small class="text-muted">Utilisateurs bloqués</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-secondary bg-opacity-10 rounded-3 p-3">
                            <i class="fa fa-clock text-secondary fa-2x"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h3 class="mb-0 fw-bold">{{ $stats['temp_blocked_today'] }}</h3>
                            <small class="text-muted">Blocages temp. (24h)</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Types d'événements -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fa fa-chart-pie text-primary me-2"></i>Types d'événements (24h)</h5>
                </div>
                <div class="card-body">
                    @if($eventTypes->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Type</th>
                                        <th class="text-end">Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($eventTypes as $event)
                                        <tr>
                                            <td>
                                                @switch($event->type)
                                                    @case('screenshot_attempt')
                                                        <span class="badge bg-danger">Capture d'écran</span>
                                                        @break
                                                    @case('devtools_opened')
                                                        <span class="badge bg-warning text-dark">DevTools</span>
                                                        @break
                                                    @case('print_attempt')
                                                        <span class="badge bg-info">Impression</span>
                                                        @break
                                                    @case('recording_attempt')
                                                        <span class="badge bg-danger">Enregistrement</span>
                                                        @break
                                                    @case('extension_detected')
                                                        <span class="badge bg-warning text-dark">Extension</span>
                                                        @break
                                                    @case('visibility_hidden')
                                                        <span class="badge bg-secondary">Onglet caché</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $event->type }}</span>
                                                @endswitch
                                            </td>
                                            <td class="text-end fw-bold">{{ $event->count }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-shield-alt fa-3x mb-3 opacity-50"></i>
                            <p>Aucun événement enregistré</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top offenders -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fa fa-user-secret text-danger me-2"></i>Utilisateurs suspects (24h)</h5>
                </div>
                <div class="card-body">
                    @if($topOffenders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th class="text-center">Tentatives</th>
                                        <th class="text-center">Statut</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topOffenders as $offender)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.security.user-details', $offender['user_id']) }}" class="text-decoration-none">
                                                    {{ $offender['user_name'] }}
                                                </a>
                                                <br><small class="text-muted">{{ $offender['user_email'] }}</small>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge {{ $offender['attempts'] >= 10 ? 'bg-danger' : ($offender['attempts'] >= 5 ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                                    {{ $offender['attempts'] }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($offender['blocked'])
                                                    <span class="badge bg-danger">Bloqué</span>
                                                @else
                                                    <span class="badge bg-success">Actif</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                @if($offender['blocked'])
                                                    <form action="{{ route('admin.security.unblock', $offender['user_id']) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Débloquer">
                                                            <i class="fa fa-unlock"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#blockModal{{ $offender['user_id'] }}" title="Bloquer">
                                                        <i class="fa fa-ban"></i>
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.security.user-details', $offender['user_id']) }}" class="btn btn-sm btn-outline-primary" title="Détails">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>

                                        <!-- Modal de blocage -->
                                        <div class="modal fade" id="blockModal{{ $offender['user_id'] }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.security.block', $offender['user_id']) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Bloquer {{ $offender['user_name'] }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label class="form-label">Raison du blocage</label>
                                                                <textarea name="reason" class="form-control" rows="3" required placeholder="Ex: Tentatives répétées de capture d'écran"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                            <button type="submit" class="btn btn-danger">Bloquer l'utilisateur</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-user-check fa-3x mb-3 opacity-50"></i>
                            <p>Aucune activité suspecte</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Utilisateurs bloqués -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-user-lock text-danger me-2"></i>Utilisateurs bloqués</h5>
                    <span class="badge bg-danger">{{ $blockedUsers->count() }}</span>
                </div>
                <div class="card-body">
                    @if($blockedUsers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Utilisateur</th>
                                        <th>Email</th>
                                        <th>Raison</th>
                                        <th>Bloqué le</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($blockedUsers as $blocked)
                                        <tr>
                                            <td>
                                                <a href="{{ route('admin.security.user-details', $blocked['id']) }}" class="text-decoration-none fw-bold">
                                                    {{ $blocked['name'] }}
                                                </a>
                                            </td>
                                            <td>{{ $blocked['email'] }}</td>
                                            <td>
                                                <span class="text-muted" title="{{ $blocked['reason'] }}">
                                                    {{ Str::limit($blocked['reason'], 40) }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ \Carbon\Carbon::parse($blocked['blocked_at'])->format('d/m/Y') }}</small>
                                            </td>
                                            <td class="text-end">
                                                <form action="{{ route('admin.security.unblock', $blocked['id']) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Voulez-vous vraiment débloquer cet utilisateur ?')">
                                                        <i class="fa fa-unlock me-1"></i>Débloquer
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.security.user-details', $blocked['id']) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-eye me-1"></i>Détails
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                            <p>Aucun utilisateur bloqué</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières tentatives -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fa fa-history text-primary me-2"></i>Dernières tentatives</h5>
                </div>
                <div class="card-body">
                    @if($recentAttempts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Utilisateur</th>
                                        <th>Document</th>
                                        <th>IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentAttempts as $attempt)
                                        <tr>
                                            <td>
                                                <small>{{ \Carbon\Carbon::parse($attempt['created_at'])->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                @switch($attempt['type'])
                                                    @case('screenshot_attempt')
                                                        <span class="badge bg-danger">Capture</span>
                                                        @break
                                                    @case('devtools_opened')
                                                        <span class="badge bg-warning text-dark">DevTools</span>
                                                        @break
                                                    @case('print_attempt')
                                                        <span class="badge bg-info">Print</span>
                                                        @break
                                                    @case('recording_attempt')
                                                        <span class="badge bg-danger">Record</span>
                                                        @break
                                                    @case('extension_detected')
                                                        <span class="badge bg-warning text-dark">Extension</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ Str::limit($attempt['type'], 15) }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($attempt['user_id'])
                                                    <a href="{{ route('admin.security.user-details', $attempt['user_id']) }}" class="text-decoration-none">
                                                        {{ $attempt['user_name'] }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">Anonyme</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($attempt['document_id'])
                                                    <span class="badge bg-light text-dark">{{ $attempt['document_id'] }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <code class="small">{{ $attempt['ip_address'] }}</code>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-shield-alt fa-3x mb-3 opacity-50"></i>
                            <p>Aucune tentative enregistrée</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
