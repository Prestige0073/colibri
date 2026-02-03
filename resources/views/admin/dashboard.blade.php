@extends('admin.layout')

@section('title', 'Tableau de bord')
@section('subtitle', 'Vue d\'ensemble de votre plateforme')

@section('content')

<!-- Alertes Accès Expirés -->
@if($empruntsAccesExpire->isNotEmpty())
<div class="alert-banner alert-banner-danger mb-4">
    <div class="alert-banner-icon">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div class="alert-banner-content">
        <h4 class="alert-banner-title">{{ $empruntsAccesExpire->count() }} Accès PDF expiré(s)</h4>
        <p class="alert-banner-text">Des utilisateurs ont dépassé leur période d'accès de 14 jours.</p>
    </div>
    <button class="btn-admin btn-admin-sm" data-bs-toggle="modal" data-bs-target="#expiredAccessModal">
        <i class="fas fa-eye me-1"></i>Voir détails
    </button>
    <button type="button" class="alert-banner-close" data-bs-dismiss="alert">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <!-- Utilisateurs -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="--stat-color: var(--admin-primary); --stat-bg: var(--admin-primary-bg);">
            <div class="stat-card-header">
                <div>
                    <p class="stat-card-label">Total Utilisateurs</p>
                    <h3 class="stat-card-value">{{ number_format($totalUsers) }}</h3>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <div class="stat-card-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+{{ $newUsersThisMonth }} ce mois</span>
            </div>
            <div class="stat-card-footer">
                <button class="btn-admin btn-admin-sm btn-admin-secondary w-100" data-bs-toggle="modal" data-bs-target="#usersModal">
                    <i class="fas fa-eye me-1"></i>Voir détails
                </button>
            </div>
        </div>
    </div>

    <!-- Chiffre d'affaires -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="--stat-color: var(--admin-success); --stat-bg: rgba(16, 185, 129, 0.1);">
            <div class="stat-card-header">
                <div>
                    <p class="stat-card-label">Chiffre d'affaires</p>
                    <h3 class="stat-card-value">{{ fcfa($totalRevenue) }}</h3>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-coins"></i>
                </div>
            </div>
            <div class="stat-card-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>{{ fcfa($revenueThisMonth) }} ce mois</span>
            </div>
            <div class="stat-card-footer">
                <button class="btn-admin btn-admin-sm btn-admin-secondary w-100" data-bs-toggle="modal" data-bs-target="#salesModal">
                    <i class="fas fa-chart-line me-1"></i>Statistiques
                </button>
            </div>
        </div>
    </div>

    <!-- Emprunts -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="--stat-color: var(--admin-warning); --stat-bg: rgba(245, 158, 11, 0.1);">
            <div class="stat-card-header">
                <div>
                    <p class="stat-card-label">Total Emprunts</p>
                    <h3 class="stat-card-value">{{ number_format($totalEmprunts) }}</h3>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
            </div>
            <div class="stat-card-trend {{ $empruntsEnAttente > 0 ? 'down' : 'up' }}">
                <i class="fas fa-clock"></i>
                <span>{{ $empruntsEnAttente }} en attente</span>
            </div>
            <div class="stat-card-footer">
                <button class="btn-admin btn-admin-sm btn-admin-secondary w-100" data-bs-toggle="modal" data-bs-target="#empruntsModal">
                    <i class="fas fa-list me-1"></i>Liste complète
                </button>
            </div>
        </div>
    </div>

    <!-- Catalogue -->
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card" style="--stat-color: var(--admin-info); --stat-bg: rgba(59, 130, 246, 0.1);">
            <div class="stat-card-header">
                <div>
                    <p class="stat-card-label">Livres au catalogue</p>
                    <h3 class="stat-card-value">{{ number_format($totalBooks) }}</h3>
                </div>
                <div class="stat-card-icon">
                    <i class="fas fa-book"></i>
                </div>
            </div>
            <div class="stat-card-trend {{ $outOfStock > 0 ? 'down' : 'up' }}">
                <i class="fas fa-{{ $outOfStock > 0 ? 'exclamation-triangle' : 'check' }}"></i>
                <span>{{ $outOfStock }} en rupture</span>
            </div>
            <div class="stat-card-footer">
                <a href="{{ route('admin.catalogue.index') }}" class="btn-admin btn-admin-sm btn-admin-primary w-100">
                    <i class="fas fa-cog me-1"></i>Gérer
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques -->
<div class="row g-4 mb-4">
    <!-- Graphique Ventes -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-chart-area"></i>
                    Ventes - 6 derniers mois
                </h3>
                <span class="admin-badge admin-badge-success">
                    <i class="fas fa-arrow-up me-1"></i>Tendance
                </span>
            </div>
            <div class="admin-card-body">
                <canvas id="salesChart" height="280"></canvas>
            </div>
        </div>
    </div>

    <!-- Graphique Emprunts -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-chart-bar"></i>
                    Emprunts - 6 derniers mois
                </h3>
                <span class="admin-badge admin-badge-warning">
                    <i class="fas fa-book-reader me-1"></i>Activité
                </span>
            </div>
            <div class="admin-card-body">
                <canvas id="empruntsChart" height="280"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Détails Emprunts -->
<div class="admin-card mb-4">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <i class="fas fa-clipboard-list"></i>
            Statut des Emprunts
        </h3>
    </div>
    <div class="admin-card-body">
        <div class="row g-3">
            <div class="col-6 col-md-3">
                <div class="mini-stat mini-stat-success">
                    <div class="mini-stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="mini-stat-content">
                        <h4>{{ $empruntsEnCours }}</h4>
                        <p>En cours</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mini-stat mini-stat-warning">
                    <div class="mini-stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="mini-stat-content">
                        <h4>{{ $empruntsEnAttente }}</h4>
                        <p>En attente</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mini-stat mini-stat-danger">
                    <div class="mini-stat-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="mini-stat-content">
                        <h4>{{ $empruntsEnRetard }}</h4>
                        <p>En retard</p>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="mini-stat mini-stat-secondary">
                    <div class="mini-stat-icon">
                        <i class="fas fa-undo"></i>
                    </div>
                    <div class="mini-stat-content">
                        <h4>{{ $empruntsRetournes }}</h4>
                        <p>Retournés</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Top Livres -->
<div class="row g-4 mb-4">
    <!-- Top Vendus -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-trophy"></i>
                    Top 5 - Meilleures ventes
                </h3>
            </div>
            <div class="admin-card-body p-0">
                @if($topSellingBooks->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <p>Aucune vente enregistrée</p>
                    </div>
                @else
                    <div class="ranking-list">
                        @foreach($topSellingBooks as $index => $item)
                            <div class="ranking-item">
                                <div class="ranking-position ranking-position-{{ $index + 1 }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="ranking-image">
                                    @if($item->catalogue && $item->catalogue->image)
                                        <img src="{{ asset($item->catalogue->image) }}" alt="{{ $item->catalogue->titre }}">
                                    @else
                                        <div class="ranking-image-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ranking-info">
                                    <h4>{{ Str::limit($item->catalogue->titre ?? 'N/A', 30) }}</h4>
                                    <p>{{ $item->catalogue->auteur ?? 'Auteur inconnu' }}</p>
                                </div>
                                <div class="ranking-value">
                                    <span class="admin-badge admin-badge-success">{{ $item->total_sold }} ventes</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Top Empruntés -->
    <div class="col-lg-6">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-fire"></i>
                    Top 5 - Plus empruntés
                </h3>
            </div>
            <div class="admin-card-body p-0">
                @if($topBorrowedBooks->isEmpty())
                    <div class="empty-state">
                        <i class="fas fa-book-reader"></i>
                        <p>Aucun emprunt enregistré</p>
                    </div>
                @else
                    <div class="ranking-list">
                        @foreach($topBorrowedBooks as $index => $item)
                            <div class="ranking-item">
                                <div class="ranking-position ranking-position-{{ $index + 1 }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="ranking-image">
                                    @if($item->livre && $item->livre->image)
                                        <img src="{{ asset($item->livre->image) }}" alt="{{ $item->livre->titre }}">
                                    @else
                                        <div class="ranking-image-placeholder">
                                            <i class="fas fa-book"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="ranking-info">
                                    <h4>{{ Str::limit($item->livre->titre ?? 'N/A', 30) }}</h4>
                                    <p>{{ $item->livre->auteur ?? 'Auteur inconnu' }}</p>
                                </div>
                                <div class="ranking-value">
                                    <span class="admin-badge admin-badge-warning">{{ $item->total_borrowed }} emprunts</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Activités Récentes -->
<div class="row g-4">
    <!-- Nouveaux Utilisateurs -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-user-plus"></i>
                    Nouveaux inscrits
                </h3>
                <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-sm btn-admin-secondary">
                    Voir tout
                </a>
            </div>
            <div class="admin-card-body p-0">
                <div class="activity-list">
                    @forelse($recentUsers as $user)
                        <div class="activity-item">
                            <div class="activity-avatar">
                                @if($user->avatar)
                                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="activity-avatar-placeholder" style="background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="activity-content">
                                <h4>{{ $user->name }}</h4>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="activity-time">
                                {{ $user->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-sm">
                            <p>Aucun nouvel utilisateur</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Ventes Récentes -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-shopping-cart"></i>
                    Ventes récentes
                </h3>
                <a href="{{ route('admin.commandes.index') }}" class="btn-admin btn-admin-sm btn-admin-secondary">
                    Voir tout
                </a>
            </div>
            <div class="admin-card-body p-0">
                <div class="activity-list">
                    @forelse($recentSales as $sale)
                        <div class="activity-item">
                            <div class="activity-image">
                                @if($sale->catalogue && $sale->catalogue->image)
                                    <img src="{{ asset($sale->catalogue->image) }}" alt="{{ $sale->catalogue->titre }}">
                                @else
                                    <div class="activity-image-placeholder">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="activity-content">
                                <h4>{{ Str::limit($sale->catalogue->titre ?? 'N/A', 25) }}</h4>
                                <p>{{ $sale->user->name ?? 'Client' }} • Qté: {{ $sale->quantite }}</p>
                            </div>
                            <div class="activity-time">
                                {{ $sale->created_at->diffForHumans() }}
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-sm">
                            <p>Aucune vente récente</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Emprunts Récents -->
    <div class="col-lg-4">
        <div class="admin-card h-100">
            <div class="admin-card-header">
                <h3 class="admin-card-title">
                    <i class="fas fa-book-reader"></i>
                    Emprunts récents
                </h3>
                <a href="{{ route('admin.emprunts.index') }}" class="btn-admin btn-admin-sm btn-admin-secondary">
                    Voir tout
                </a>
            </div>
            <div class="admin-card-body p-0">
                <div class="activity-list">
                    @forelse($recentEmprunts as $emprunt)
                        <div class="activity-item">
                            <div class="activity-image">
                                @if($emprunt->livre && $emprunt->livre->image)
                                    <img src="{{ asset($emprunt->livre->image) }}" alt="{{ $emprunt->livre->titre }}">
                                @else
                                    <div class="activity-image-placeholder">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="activity-content">
                                <h4>{{ Str::limit($emprunt->livre->titre ?? 'N/A', 25) }}</h4>
                                <p>{{ $emprunt->user->name ?? 'Utilisateur' }}</p>
                            </div>
                            <div class="activity-badge">
                                @php
                                    $badgeClass = match($emprunt->statut) {
                                        'en_cours' => 'success',
                                        'en_attente' => 'warning',
                                        'en_retard' => 'danger',
                                        'retourne' => 'secondary',
                                        default => 'info'
                                    };
                                @endphp
                                <span class="admin-badge admin-badge-{{ $badgeClass }}">
                                    {{ ucfirst(str_replace('_', ' ', $emprunt->statut)) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state-sm">
                            <p>Aucun emprunt récent</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('admin.dashboard-modals')

@endsection

@push('styles')
<style>
    /* Stat Cards Enhancement */
    .stat-card {
        position: relative;
        overflow: hidden;
    }

    .stat-card-footer {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--admin-gray-200);
    }

    /* Mini Stats */
    .mini-stat {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: var(--radius-md);
        background: var(--admin-gray-100);
        transition: all var(--transition-fast);
    }

    .mini-stat:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .mini-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .mini-stat-success .mini-stat-icon {
        background: rgba(16, 185, 129, 0.1);
        color: var(--admin-success);
    }

    .mini-stat-warning .mini-stat-icon {
        background: rgba(245, 158, 11, 0.1);
        color: var(--admin-warning);
    }

    .mini-stat-danger .mini-stat-icon {
        background: rgba(239, 68, 68, 0.1);
        color: var(--admin-danger);
    }

    .mini-stat-secondary .mini-stat-icon {
        background: rgba(100, 116, 139, 0.1);
        color: var(--admin-gray-600);
    }

    .mini-stat-content h4 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--admin-text);
    }

    .mini-stat-content p {
        font-size: 0.8rem;
        color: var(--admin-text-muted);
        margin: 0;
    }

    /* Alert Banner */
    .alert-banner {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-radius: var(--radius-lg);
        position: relative;
    }

    .alert-banner-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert-banner-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .alert-banner-danger .alert-banner-icon {
        background: var(--admin-danger);
        color: #fff;
    }

    .alert-banner-content {
        flex: 1;
    }

    .alert-banner-title {
        font-size: 1rem;
        font-weight: 700;
        color: #991b1b;
        margin: 0 0 0.25rem;
    }

    .alert-banner-text {
        font-size: 0.875rem;
        color: #b91c1c;
        margin: 0;
    }

    .alert-banner-close {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        background: none;
        border: none;
        color: #b91c1c;
        cursor: pointer;
        padding: 0.25rem;
        opacity: 0.6;
        transition: opacity var(--transition-fast);
    }

    .alert-banner-close:hover {
        opacity: 1;
    }

    /* Ranking List */
    .ranking-list {
        padding: 0;
    }

    .ranking-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--admin-gray-200);
        transition: background var(--transition-fast);
    }

    .ranking-item:last-child {
        border-bottom: none;
    }

    .ranking-item:hover {
        background: var(--admin-gray-100);
    }

    .ranking-position {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-full);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .ranking-position-1 {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: #fff;
    }

    .ranking-position-2 {
        background: linear-gradient(135deg, #9ca3af, #6b7280);
        color: #fff;
    }

    .ranking-position-3 {
        background: linear-gradient(135deg, #d97706, #b45309);
        color: #fff;
    }

    .ranking-position-4,
    .ranking-position-5 {
        background: var(--admin-gray-200);
        color: var(--admin-text-muted);
    }

    .ranking-image {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
    }

    .ranking-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .ranking-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--admin-gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-text-muted);
    }

    .ranking-info {
        flex: 1;
        min-width: 0;
    }

    .ranking-info h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-text);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .ranking-info p {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        margin: 0;
    }

    .ranking-value {
        flex-shrink: 0;
    }

    /* Activity List */
    .activity-list {
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--admin-gray-200);
        transition: background var(--transition-fast);
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-item:hover {
        background: var(--admin-gray-100);
    }

    .activity-avatar,
    .activity-image {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
    }

    .activity-avatar img,
    .activity-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .activity-avatar-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .activity-image-placeholder {
        width: 100%;
        height: 100%;
        background: var(--admin-gray-200);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--admin-text-muted);
    }

    .activity-content {
        flex: 1;
        min-width: 0;
    }

    .activity-content h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-text);
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .activity-content p {
        font-size: 0.75rem;
        color: var(--admin-text-muted);
        margin: 0;
    }

    .activity-time {
        font-size: 0.7rem;
        color: var(--admin-text-light);
        flex-shrink: 0;
    }

    .activity-badge {
        flex-shrink: 0;
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--admin-text-muted);
    }

    .empty-state i {
        font-size: 2.5rem;
        opacity: 0.3;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
    }

    .empty-state-sm {
        padding: 1.5rem;
        text-align: center;
        color: var(--admin-text-muted);
    }

    .empty-state-sm p {
        margin: 0;
        font-size: 0.8rem;
    }

    /* Chart Container */
    #salesChart,
    #empruntsChart {
        max-height: 280px;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart.js Configuration
        Chart.defaults.font.family = 'Inter, sans-serif';
        Chart.defaults.color = '#64748b';

        // Graphique des ventes
        const salesCtx = document.getElementById('salesChart');
        if (salesCtx) {
            new Chart(salesCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($salesByMonth, 'month')) !!},
                    datasets: [{
                        label: 'Ventes',
                        data: {!! json_encode(array_column($salesByMonth, 'count')) !!},
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { size: 13, weight: '600' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e2e8f0' },
                            ticks: { precision: 0, font: { size: 11 } }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
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
                        label: 'Emprunts',
                        data: {!! json_encode(array_column($empruntsByMonth, 'count')) !!},
                        backgroundColor: 'rgba(245, 158, 11, 0.8)',
                        borderColor: '#f59e0b',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            titleFont: { size: 13, weight: '600' },
                            bodyFont: { size: 12 },
                            padding: 12,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 11 } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e2e8f0' },
                            ticks: { precision: 0, font: { size: 11 } }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
