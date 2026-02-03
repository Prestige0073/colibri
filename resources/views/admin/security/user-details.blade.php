@extends('admin.layout')

@section('title', 'Détails sécurité - ' . $user->name)

@section('content')
<div class="container-fluid px-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.security.index') }}">Sécurité</a></li>
            <li class="breadcrumb-item active">{{ $user->name }}</li>
        </ol>
    </nav>

    <!-- En-tête utilisateur -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $user->blocked ? 'danger' : 'primary' }} bg-opacity-10 rounded-circle p-3">
                                <i class="fa fa-user fa-2x text-{{ $user->blocked ? 'danger' : 'primary' }}"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                            <small class="text-muted">ID: {{ $user->id }} | Inscrit le {{ $user->created_at->format('d/m/Y') }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    @if($user->blocked)
                        <span class="badge bg-danger fs-6 mb-2">Compte bloqué</span>
                        <form action="{{ route('admin.security.unblock', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" onclick="return confirm('Voulez-vous vraiment débloquer cet utilisateur ?')">
                                <i class="fa fa-unlock me-1"></i>Débloquer le compte
                            </button>
                        </form>
                    @else
                        <span class="badge bg-success fs-6 mb-2">Compte actif</span>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#blockModal">
                            <i class="fa fa-ban me-1"></i>Bloquer le compte
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques de sécurité -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <h3 class="text-warning mb-0">{{ $securityStats['attempts_1h'] ?? 0 }}</h3>
                    <small class="text-muted">Tentatives (1h)</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <h3 class="text-info mb-0">{{ $securityStats['attempts_24h'] ?? 0 }}</h3>
                    <small class="text-muted">Tentatives (24h)</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <h3 class="text-primary mb-0">{{ $securityStats['total_attempts'] ?? 0 }}</h3>
                    <small class="text-muted">Tentatives totales</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    @if($securityStatus['blocked'])
                        <h3 class="text-danger mb-0"><i class="fa fa-lock"></i></h3>
                        <small class="text-muted">
                            @if($securityStatus['permanent'] ?? false)
                                Bloqué permanent
                            @else
                                Bloqué temp. ({{ ceil(($securityStatus['expires_in'] ?? 0) / 60) }} min)
                            @endif
                        </small>
                    @else
                        <h3 class="text-success mb-0"><i class="fa fa-unlock"></i></h3>
                        <small class="text-muted">Non bloqué</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Historique des blocages -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fa fa-history text-danger me-2"></i>Historique des blocages</h5>
                </div>
                <div class="card-body">
                    @if($blocks->count() > 0)
                        <div class="timeline">
                            @foreach($blocks as $block)
                                <div class="card mb-3 {{ $block['unblocked_at'] ? 'border-success' : 'border-danger' }}">
                                    <div class="card-body py-2">
                                        <div class="d-flex justify-content-between">
                                            <strong class="text-{{ $block['unblocked_at'] ? 'success' : 'danger' }}">
                                                {{ $block['unblocked_at'] ? 'Débloqué' : 'Bloqué' }}
                                            </strong>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($block['blocked_at'])->format('d/m/Y') }}</small>
                                        </div>
                                        <p class="mb-1 small">{{ $block['reason'] }}</p>
                                        <small class="text-muted">IP: {{ $block['ip_address'] }}</small>
                                        @if($block['unblocked_at'])
                                            <br><small class="text-success">
                                                Débloqué le {{ \Carbon\Carbon::parse($block['unblocked_at'])->format('d/m/Y') }}
                                                @if($block['unblocked_by'])
                                                    par {{ $block['unblocked_by'] }}
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa fa-check-circle fa-3x mb-3 text-success opacity-50"></i>
                            <p>Aucun historique de blocage</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions rapides -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0"><i class="fa fa-cogs text-primary me-2"></i>Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <form action="{{ route('admin.security.reset-attempts', $user->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-warning w-100" onclick="return confirm('Réinitialiser le compteur de tentatives ?')">
                                <i class="fa fa-redo me-2"></i>Réinitialiser les tentatives
                            </button>
                        </form>

                        @if($user->blocked)
                            <form action="{{ route('admin.security.unblock', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fa fa-unlock me-2"></i>Débloquer l'utilisateur
                                </button>
                            </form>
                        @else
                            <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#blockModal">
                                <i class="fa fa-ban me-2"></i>Bloquer l'utilisateur
                            </button>
                        @endif

                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-outline-primary w-100">
                            <i class="fa fa-user me-2"></i>Voir le profil utilisateur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historique des tentatives -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fa fa-list text-primary me-2"></i>Historique des tentatives</h5>
                    <span class="badge bg-secondary">{{ $attempts->count() }} dernières</span>
                </div>
                <div class="card-body">
                    @if($attempts->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date/Heure</th>
                                        <th>Type</th>
                                        <th>Document</th>
                                        <th>IP</th>
                                        <th>Détails</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($attempts as $attempt)
                                        <tr>
                                            <td>
                                                <small>{{ \Carbon\Carbon::parse($attempt->created_at)->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                @switch($attempt->type)
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
                                                    @case('visibility_hidden')
                                                        <span class="badge bg-secondary">Tab hidden</span>
                                                        @break
                                                    @case('canvas_export_attempt')
                                                        <span class="badge bg-danger">Canvas export</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $attempt->type }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                @if($attempt->document_id)
                                                    <small>
                                                        {{ $attempt->document_type ?? 'Doc' }} #{{ $attempt->document_id }}
                                                    </small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <code class="small">{{ $attempt->ip_address }}</code>
                                            </td>
                                            <td>
                                                @if($attempt->details)
                                                    @php
                                                        $details = is_string($attempt->details) ? json_decode($attempt->details, true) : $attempt->details;
                                                    @endphp
                                                    @if(is_array($details))
                                                        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="<pre class='mb-0 small'>{{ json_encode($details, JSON_PRETTY_PRINT) }}</pre>">
                                                            <i class="fa fa-info-circle"></i>
                                                        </button>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
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

<!-- Modal de blocage -->
<div class="modal fade" id="blockModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.security.block', $user->id) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Bloquer {{ $user->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fa fa-exclamation-triangle me-2"></i>
                        Cette action bloquera définitivement l'accès de l'utilisateur aux documents PDF.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Raison du blocage <span class="text-danger">*</span></label>
                        <textarea name="reason" class="form-control" rows="3" required placeholder="Ex: Tentatives répétées de capture d'écran, violation des CGU..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fa fa-ban me-1"></i>Bloquer définitivement
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Initialiser les popovers
    document.addEventListener('DOMContentLoaded', function() {
        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
    });
</script>
@endpush
