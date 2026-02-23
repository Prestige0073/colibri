@extends('admin.layout')

@section('title', 'Gestion des Dons')
@section('subtitle', $totalDonations . ' don(s) enregistré(s)')

@section('content')

<!-- Header -->
<div class="page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="d-flex align-items-center gap-3">
                <div class="page-header-icon">
                    <i class="fas fa-hand-holding-heart"></i>
                </div>
                <div>
                    <h1 class="page-title">Suivi des dons</h1>
                    <p class="page-subtitle">{{ $totalDonations }} don(s) reçu(s) au total</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex gap-2 justify-content-md-end mt-3 mt-md-0">
                <a href="{{ route('donation.index') }}" target="_blank" class="btn-admin btn-admin-outline">
                    <i class="fas fa-external-link-alt me-2"></i>Page de dons
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Stats -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-success-soft text-success">
                <i class="fas fa-coins"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ number_format($totalAmount, 0, ',', ' ') }}</span>
                <span class="quick-stat-label">FCFA Total collecté</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-primary-soft text-primary">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $completedCount }}</span>
                <span class="quick-stat-label">Dons réussis</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-warning-soft text-warning">
                <i class="fas fa-clock"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ $pendingCount }}</span>
                <span class="quick-stat-label">En attente</span>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="quick-stat">
            <div class="quick-stat-icon bg-info-soft text-info">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="quick-stat-content">
                <span class="quick-stat-value">{{ number_format($monthAmount, 0, ',', ' ') }}</span>
                <span class="quick-stat-label">FCFA Ce mois</span>
            </div>
        </div>
    </div>
</div>

<!-- Filtres et recherche -->
<div class="admin-card mb-4">
    <div class="admin-card-body">
        <form method="GET" action="{{ route('admin.donations.index') }}" class="row g-3 align-items-end">
            <div class="col-md-5">
                <label class="form-label fw-semibold">Rechercher</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Nom, email, transaction..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Statut</label>
                <select name="status" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Réussi</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Échoué</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="fas fa-filter me-1"></i>Filtrer
                    </button>
                    <a href="{{ route('admin.donations.index') }}" class="btn-admin btn-admin-outline">
                        <i class="fas fa-times me-1"></i>Réinitialiser
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tableau des dons -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="fas fa-list"></i>
            <span>Liste des dons</span>
        </h3>
    </div>
    <div class="admin-card-body">
        @if($donations->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-hand-holding-heart fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Aucun don enregistré</h5>
                <p class="text-muted">Les dons effectués via la page de dons apparaîtront ici.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Donateur</th>
                            <th>Montant</th>
                            <th>Méthode</th>
                            <th>Transaction</th>
                            <th>Statut</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donations as $donation)
                            <tr>
                                <td><strong>#{{ $donation->id }}</strong></td>
                                <td>
                                    <div>
                                        <strong>{{ $donation->donor_name ?? 'Anonyme' }}</strong>
                                        @if($donation->donor_email)
                                            <br><small class="text-muted">{{ $donation->donor_email }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="fw-bold text-success">{{ number_format($donation->amount, 0, ',', ' ') }} FCFA</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        <i class="fas fa-mobile-alt me-1"></i>{{ ucfirst($donation->payment_method) }}
                                    </span>
                                </td>
                                <td>
                                    @if($donation->transaction_id)
                                        <code class="small">{{ Str::limit($donation->transaction_id, 15) }}</code>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($donation->status === 'completed')
                                        <span class="badge bg-success"><i class="fas fa-check me-1"></i>Réussi</span>
                                    @elseif($donation->status === 'pending')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>En attente</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Échoué</span>
                                    @endif
                                </td>
                                <td>
                                    <span title="{{ $donation->created_at->format('d/m/Y H:i') }}">
                                        {{ $donation->created_at->format('d/m/Y') }}
                                        <br><small class="text-muted">{{ $donation->created_at->format('H:i') }}</small>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="showDonation({{ $donation->id }})" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <form method="POST" action="{{ route('admin.donations.destroy', $donation->id) }}" onsubmit="return confirm('Supprimer ce don ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
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

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-3">
                {{ $donations->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal détails don -->
<div class="modal fade" id="donationDetailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-hand-holding-heart me-2"></i>Détails du don</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="donationDetailContent">
                    <div class="text-center py-3">
                        <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showDonation(id) {
    var modal = new bootstrap.Modal(document.getElementById('donationDetailModal'));
    var content = document.getElementById('donationDetailContent');
    content.innerHTML = '<div class="text-center py-3"><i class="fas fa-spinner fa-spin fa-2x text-muted"></i></div>';
    modal.show();

    fetch("{{ url('admin/donations') }}/" + id, {
        headers: { 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(function(d) {
        var statusBadge = '';
        if (d.status === 'completed') {
            statusBadge = '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Réussi</span>';
        } else if (d.status === 'pending') {
            statusBadge = '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i>En attente</span>';
        } else {
            statusBadge = '<span class="badge bg-danger"><i class="fas fa-times me-1"></i>Échoué</span>';
        }

        var date = new Date(d.created_at);
        var dateStr = date.toLocaleDateString('fr-FR') + ' à ' + date.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'});

        content.innerHTML = `
            <table class="table table-borderless mb-0">
                <tr>
                    <td class="fw-semibold text-muted" style="width:40%"><i class="fas fa-user me-2"></i>Donateur</td>
                    <td>${d.donor_name || '<em class="text-muted">Anonyme</em>'}</td>
                </tr>
                <tr>
                    <td class="fw-semibold text-muted"><i class="fas fa-envelope me-2"></i>Email</td>
                    <td>${d.donor_email || '<em class="text-muted">Non renseigné</em>'}</td>
                </tr>
                <tr>
                    <td class="fw-semibold text-muted"><i class="fas fa-coins me-2"></i>Montant</td>
                    <td><strong class="text-success fs-5">${new Intl.NumberFormat('fr-FR').format(d.amount)} FCFA</strong></td>
                </tr>
                <tr>
                    <td class="fw-semibold text-muted"><i class="fas fa-mobile-alt me-2"></i>Méthode</td>
                    <td>${d.payment_method ? d.payment_method.charAt(0).toUpperCase() + d.payment_method.slice(1) : '-'}</td>
                </tr>
                <tr>
                    <td class="fw-semibold text-muted"><i class="fas fa-receipt me-2"></i>Transaction</td>
                    <td><code>${d.transaction_id || '-'}</code></td>
                </tr>
                <tr>
                    <td class="fw-semibold text-muted"><i class="fas fa-info-circle me-2"></i>Statut</td>
                    <td>${statusBadge}</td>
                </tr>
                <tr>
                    <td class="fw-semibold text-muted"><i class="fas fa-calendar me-2"></i>Date</td>
                    <td>${dateStr}</td>
                </tr>
                ${d.notes ? '<tr><td class="fw-semibold text-muted"><i class="fas fa-sticky-note me-2"></i>Notes</td><td>' + d.notes + '</td></tr>' : ''}
            </table>
        `;
    })
    .catch(function() {
        content.innerHTML = '<div class="text-center text-danger py-3"><i class="fas fa-exclamation-triangle me-2"></i>Erreur de chargement</div>';
    });
}
</script>
@endpush
