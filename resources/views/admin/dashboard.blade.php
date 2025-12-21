@extends('admin.layout')

@section('title', 'Tableau de bord')

@section('content')
@include('partials.notifications')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0"><i class="fas fa-tachometer-alt me-2 text-primary"></i>Tableau de bord</h1>
                    <p class="text-muted mb-0">Vue d'ensemble de la plateforme Colibri Littéraire</p>
                </div>
                <div class="text-muted">
                    <i class="fas fa-calendar me-2"></i>{{ now()->format('d/m/Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes Accès Expirés -->
    @if($empruntsAccesExpire->isNotEmpty())
    @php
        // Créer une clé unique basée sur les IDs des emprunts expirés
        $expiredIds = $empruntsAccesExpire->pluck('id')->sort()->join('-');
        $adminAlertKey = 'admin_expired_alert_dismissed_' . $expiredIds;
    @endphp
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" id="admin-expired-access-alert" data-alert-key="{{ $adminAlertKey }}" style="display: none;">
                <div class="d-flex align-items-start">
                    <div class="me-3">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-2">
                            <i class="fas fa-clock me-2"></i>{{ $empruntsAccesExpire->count() }} Accès PDF expiré(s)
                        </h5>
                        <p class="mb-2">Les utilisateurs suivants ont dépassé leur période d'accès de 14 jours et ne peuvent plus consulter les PDFs :</p>
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0">
                                <thead>
                                    <tr class="border-bottom">
                                        <th>Utilisateur</th>
                                        <th>Livre</th>
                                        <th>Expiré depuis</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($empruntsAccesExpire->take(5) as $emprunt)
                                        <tr class="border-bottom">
                                            <td>
                                                <strong>{{ $emprunt->user->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $emprunt->user->email ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <strong>{{ $emprunt->livre->titre ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $emprunt->livre->auteur ?? 'N/A' }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">
                                                    {{ $emprunt->access_expires_at->diffForHumans() }}
                                                </span>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.emprunts.renew-access', $emprunt->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Prolonger l'accès de 14 jours">
                                                        <i class="fas fa-redo me-1"></i>Prolonger 14j
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($empruntsAccesExpire->count() > 5)
                            <div class="mt-3">
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#expiredAccessModal">
                                    <i class="fas fa-list me-1"></i>Voir tous les {{ $empruntsAccesExpire->count() }} accès expirés
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    @endif

    <!-- Cartes de statistiques principales -->
    <div class="row g-4 mb-4">
        <!-- Utilisateurs -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card stat-card-primary">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Utilisateurs</p>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h2>
                            <p class="mb-0 small text-success mt-2">
                                <i class="fas fa-arrow-up me-1"></i>
                                +{{ $newUsersThisMonth }} ce mois
                            </p>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-primary w-100 mt-3" data-bs-toggle="modal" data-bs-target="#usersModal">
                        <i class="fas fa-eye me-1"></i>Voir détails
                    </button>
                </div>
            </div>
        </div>

        <!-- Ventes -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card stat-card-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Chiffre d'affaires</p>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalRevenue, 0, ',', ' ') }} FCFA</h2>
                            <p class="mb-0 small text-success mt-2">
                                <i class="fas fa-arrow-up me-1"></i>
                                {{ number_format($revenueThisMonth, 0, ',', ' ') }} FCFA ce mois
                            </p>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-success w-100 mt-3" data-bs-toggle="modal" data-bs-target="#salesModal">
                        <i class="fas fa-eye me-1"></i>Voir détails
                    </button>
                </div>
            </div>
        </div>

        <!-- Emprunts -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card stat-card-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Emprunts</p>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalEmprunts) }}</h2>
                            <p class="mb-0 small text-warning mt-2">
                                <i class="fas fa-clock me-1"></i>
                                {{ $empruntsEnAttente }} en attente
                            </p>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-book-reader fa-2x"></i>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-warning w-100 mt-3" data-bs-toggle="modal" data-bs-target="#empruntsModal">
                        <i class="fas fa-eye me-1"></i>Voir détails
                    </button>
                </div>
            </div>
        </div>

        <!-- Catalogue -->
        <div class="col-md-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100 stat-card stat-card-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">Total Livres</p>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalBooks) }}</h2>
                            <p class="mb-0 small text-danger mt-2">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                {{ $outOfStock }} en rupture
                            </p>
                        </div>
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.catalogue.index') }}" class="btn btn-sm btn-outline-info w-100 mt-3">
                        <i class="fas fa-eye me-1"></i>Gérer catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et statistiques détaillées -->
    <div class="row g-4 mb-4">
        <!-- Graphique Ventes -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-chart-line me-2 text-success"></i>Ventes - 6 derniers mois</h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="250"></canvas>
                </div>
            </div>
        </div>

        <!-- Graphique Emprunts -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-chart-bar me-2 text-warning"></i>Emprunts - 6 derniers mois</h5>
                </div>
                <div class="card-body">
                    <canvas id="empruntsChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques détaillées Emprunts -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-clipboard-list me-2 text-primary"></i>Détails des Emprunts</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <div class="p-3 bg-success bg-opacity-10 rounded">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x text-success me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-bold">{{ $empruntsEnCours }}</h4>
                                        <small class="text-muted">En cours</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-warning bg-opacity-10 rounded">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-clock fa-2x text-warning me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-bold">{{ $empruntsEnAttente }}</h4>
                                        <small class="text-muted">En attente</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-danger bg-opacity-10 rounded">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle fa-2x text-danger me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-bold">{{ $empruntsEnRetard }}</h4>
                                        <small class="text-muted">En retard</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 bg-secondary bg-opacity-10 rounded">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check fa-2x text-secondary me-3"></i>
                                    <div>
                                        <h4 class="mb-0 fw-bold">{{ $empruntsRetournes }}</h4>
                                        <small class="text-muted">Retournés</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top livres et activités récentes -->
    <div class="row g-4 mb-4">
        <!-- Top Livres Vendus -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-star me-2 text-success"></i>Top 5 Livres Vendus</h5>
                </div>
                <div class="card-body">
                    @if($topSellingBooks->isEmpty())
                        <p class="text-muted text-center py-4">Aucune vente pour le moment</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($topSellingBooks as $index => $item)
                                <div class="list-group-item px-0 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 fw-bold text-primary">#{{ $index + 1 }}</div>
                                        @if($item->catalogue && $item->catalogue->image)
                                            <img src="{{ asset($item->catalogue->image) }}" alt="{{ $item->catalogue->titre }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary bg-opacity-10 rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $item->catalogue->titre ?? 'N/A' }}</h6>
                                            <small class="text-muted">{{ $item->catalogue->auteur ?? 'N/A' }}</small>
                                        </div>
                                        <span class="badge bg-success">{{ $item->total_sold }} ventes</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Livres Empruntés -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0"><i class="fas fa-star me-2 text-warning"></i>Top 5 Livres Empruntés</h5>
                </div>
                <div class="card-body">
                    @if($topBorrowedBooks->isEmpty())
                        <p class="text-muted text-center py-4">Aucun emprunt pour le moment</p>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($topBorrowedBooks as $index => $item)
                                <div class="list-group-item px-0 border-0">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 fw-bold text-warning">#{{ $index + 1 }}</div>
                                        @if($item->livre && $item->livre->image)
                                            <img src="{{ asset($item->livre->image) }}" alt="{{ $item->livre->titre }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="bg-secondary bg-opacity-10 rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $item->livre->titre ?? 'N/A' }}</h6>
                                            <small class="text-muted">{{ $item->livre->auteur ?? 'N/A' }}</small>
                                        </div>
                                        <span class="badge bg-warning text-dark">{{ $item->total_borrowed }} emprunts</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Activités récentes -->
    <div class="row g-4">
        <!-- Utilisateurs récents -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0"><i class="fas fa-user-plus me-2 text-primary"></i>Nouveaux Utilisateurs</h6>
                </div>
                <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                    @foreach($recentUsers as $user)
                        <div class="d-flex align-items-center p-2 border-bottom">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=007bff&color=fff&size=35" alt="{{ $user->name }}" class="rounded-circle me-2">
                            @endif
                            <div class="flex-grow-1">
                                <small class="d-block fw-bold">{{ $user->name }}</small>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Ventes récentes -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0"><i class="fas fa-shopping-cart me-2 text-success"></i>Ventes Récentes</h6>
                </div>
                <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                    @foreach($recentSales as $sale)
                        <div class="d-flex align-items-center p-2 border-bottom">
                            @if($sale->catalogue && $sale->catalogue->image)
                                <img src="{{ asset($sale->catalogue->image) }}" alt="{{ $sale->catalogue->titre }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <small class="d-block fw-bold">{{ $sale->catalogue->titre ?? 'N/A' }}</small>
                                <small class="text-muted">{{ $sale->user->name ?? 'N/A' }} • Qté: {{ $sale->quantite }}</small>
                            </div>
                            <small class="text-muted">{{ $sale->created_at->diffForHumans() }}</small>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Emprunts récents -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h6 class="mb-0"><i class="fas fa-book-reader me-2 text-warning"></i>Emprunts Récents</h6>
                </div>
                <div class="card-body p-2" style="max-height: 400px; overflow-y: auto;">
                    @foreach($recentEmprunts as $emprunt)
                        <div class="d-flex align-items-center p-2 border-bottom">
                            @if($emprunt->livre && $emprunt->livre->image)
                                <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-book text-muted"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <small class="d-block fw-bold">{{ $emprunt->livre->titre ?? 'N/A' }}</small>
                                <small class="text-muted">{{ $emprunt->user->name ?? 'N/A' }}</small>
                            </div>
                            @php
                                $badgeClass = match($emprunt->statut) {
                                    'en_cours' => 'bg-success',
                                    'en_attente' => 'bg-warning',
                                    'en_retard' => 'bg-danger',
                                    'retourne' => 'bg-secondary',
                                    default => 'bg-info'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }} text-white">{{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Utilisateurs -->
<div class="modal fade" id="usersModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white"><i class="fas fa-users me-2"></i>Liste complète des utilisateurs</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th>Inscrit le</th>
                            </tr>
                        </thead>
                        <tbody id="usersTableBody">
                            @foreach($recentUsers as $user)
                                <tr>
                                    <td>#{{ $user->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($user->avatar)
                                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=007bff&color=fff&size=30" alt="{{ $user->name }}" class="rounded-circle me-2">
                                            @endif
                                            {{ $user->name }}
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td><span class="badge bg-info">{{ $user->role ?? 'utilisateur' }}</span></td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ventes -->
<div class="modal fade" id="salesModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white"><i class="fas fa-shopping-cart me-2"></i>Liste complète des ventes</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Livre</th>
                                <th>Client</th>
                                <th>Quantité</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody id="salesTableBody">
                            @foreach($recentSales as $sale)
                                <tr>
                                    <td>#{{ $sale->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($sale->catalogue && $sale->catalogue->image)
                                                <img src="{{ asset($sale->catalogue->image) }}" alt="{{ $sale->catalogue->titre }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-10 rounded me-2" style="width: 40px; height: 40px;"></div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $sale->catalogue->titre ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $sale->catalogue->auteur ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $sale->user->name ?? 'N/A' }}</td>
                                    <td>{{ $sale->quantite }}</td>
                                    <td>{{ number_format($sale->catalogue->prix ?? 0, 0, ',', ' ') }} FCFA</td>
                                    <td class="fw-bold">{{ number_format(($sale->catalogue->prix ?? 0) * $sale->quantite, 0, ',', ' ') }} FCFA</td>
                                    <td>{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Emprunts -->
<div class="modal fade" id="empruntsModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-book-reader me-2"></i>Liste complète des emprunts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Livre</th>
                                <th>Utilisateur</th>
                                <th>Date emprunt</th>
                                <th>Date retour</th>
                                <th>Statut</th>
                                <th>Validé par</th>
                                <th>Accès expire</th>
                            </tr>
                        </thead>
                        <tbody id="empruntsTableBody">
                            @foreach($recentEmprunts as $emprunt)
                                <tr>
                                    <td>#{{ $emprunt->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($emprunt->livre && $emprunt->livre->image)
                                                <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-10 rounded me-2" style="width: 40px; height: 40px;"></div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $emprunt->livre->titre ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $emprunt->livre->auteur ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $emprunt->user->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_emprunt)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($emprunt->date_retour)->format('d/m/Y') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($emprunt->statut) {
                                                'en_cours' => 'bg-success',
                                                'en_attente' => 'bg-warning',
                                                'en_retard' => 'bg-danger',
                                                'retourne' => 'bg-secondary',
                                                default => 'bg-info'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} text-white">{{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}</span>
                                    </td>
                                    <td>
                                        @if($emprunt->valide_le)
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            {{ $emprunt->validateur->name ?? 'Admin' }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($emprunt->access_expires_at)
                                            @if(now()->greaterThan($emprunt->access_expires_at))
                                                <span class="badge bg-danger">Expiré</span>
                                            @else
                                                <span class="text-success">{{ $emprunt->access_expires_at->diffForHumans() }}</span>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Accès Expirés -->
<div class="modal fade" id="expiredAccessModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">
                    <i class="fas fa-exclamation-triangle me-2"></i>Tous les accès PDF expirés ({{ $empruntsAccesExpire->count() }})
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Ces utilisateurs ont dépassé leur période d'accès de 14 jours. Vous pouvez prolonger leur accès ou les contacter.
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Utilisateur</th>
                                <th>Livre</th>
                                <th>Validé le</th>
                                <th>Expiré le</th>
                                <th>Depuis</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($empruntsAccesExpire as $emprunt)
                                <tr>
                                    <td>#{{ $emprunt->id }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($emprunt->user->avatar)
                                                <img src="{{ asset($emprunt->user->avatar) }}" alt="{{ $emprunt->user->name }}" class="rounded-circle me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($emprunt->user->name ?? 'User') }}&background=dc3545&color=fff&size=30" alt="{{ $emprunt->user->name }}" class="rounded-circle me-2">
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $emprunt->user->name ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $emprunt->user->email ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($emprunt->livre && $emprunt->livre->image)
                                                <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-secondary bg-opacity-10 rounded me-2" style="width: 40px; height: 40px;"></div>
                                            @endif
                                            <div>
                                                <div class="fw-bold">{{ $emprunt->livre->titre ?? 'N/A' }}</div>
                                                <small class="text-muted">{{ $emprunt->livre->auteur ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $emprunt->valide_le ? $emprunt->valide_le->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>{{ $emprunt->access_expires_at ? $emprunt->access_expires_at->format('d/m/Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $emprunt->access_expires_at->diffForHumans() }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $badgeClass = match($emprunt->statut) {
                                                'en_cours' => 'bg-success',
                                                'en_retard' => 'bg-danger',
                                                default => 'bg-info'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }} text-white">{{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}</span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.emprunts.renew-access', $emprunt->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Prolonger l'accès de 14 jours">
                                                <i class="fas fa-redo me-1"></i>+14j
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15) !important;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-header {
        padding: 1rem 1.25rem;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'alerte d'accès expiré avec persistance
        const expiredAlert = document.getElementById('admin-expired-access-alert');
        if (expiredAlert) {
            const alertKey = expiredAlert.getAttribute('data-alert-key');

            // Vérifier si l'alerte a déjà été fermée
            if (localStorage.getItem(alertKey)) {
                expiredAlert.remove();
            } else {
                // Afficher l'alerte si elle n'a pas été fermée
                expiredAlert.style.display = 'block';

                // Sauvegarder la fermeture lorsque l'utilisateur ferme manuellement l'alerte
                expiredAlert.addEventListener('close.bs.alert', function() {
                    localStorage.setItem(alertKey, 'true');
                });

                // Auto-fermeture après 15 secondes
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(expiredAlert);
                    bsAlert.close();
                    // Sauvegarder aussi lors de la fermeture automatique
                    localStorage.setItem(alertKey, 'true');
                }, 15000);
            }
        }

        // Graphique des ventes
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($salesByMonth, 'month')) !!},
                    datasets: [{
                        label: 'Nombre de ventes',
                        data: {!! json_encode(array_column($salesByMonth, 'count')) !!},
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        // Graphique des emprunts
        const empruntsCtx = document.getElementById('empruntsChart');
        if (empruntsCtx) {
            new Chart(empruntsCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_column($empruntsByMonth, 'month')) !!},
                    datasets: [{
                        label: 'Nombre d\'emprunts',
                        data: {!! json_encode(array_column($empruntsByMonth, 'count')) !!},
                        backgroundColor: 'rgba(234, 179, 8, 0.7)',
                        borderColor: 'rgb(234, 179, 8)',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
