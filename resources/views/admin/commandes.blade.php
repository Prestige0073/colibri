@extends('admin.layout')

@section('title', 'Gestion des commandes')
@section('subtitle', 'Suivi et traitement des commandes clients')

@section('content')
@php
    $allCommandes = $users->flatMap(fn($u) => $u->commandes_active->merge($u->commandes_archives ?? collect()));
    $totalPaid = $allCommandes->where('statut', 'paid')->count() + $allCommandes->where('statut', 'confirmed')->count();
    $totalPending = $allCommandes->where('statut', 'pending')->count();
    $totalEnPreparation = $allCommandes->where('statut', 'en_preparation')->count();
    $totalEnLivraison = $allCommandes->where('statut', 'en_livraison')->count();
    $totalLivre = $allCommandes->whereIn('statut', ['livre', 'livree'])->count();
    $totalRevenue = $allCommandes->where('paiement_valide', true)->sum('total');
@endphp

<!-- Page Header -->
<div class="admin-page-header">
    <div class="admin-page-header-content">
        <div class="admin-page-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="admin-page-info">
            <h1>Gestion des commandes</h1>
            <p>Suivi et traitement des commandes clients</p>
        </div>
    </div>
    <div class="admin-page-actions">
        <span class="admin-badge admin-badge-light">
            <i class="fas fa-calendar me-1"></i>{{ now()->format('d/m/Y') }}
        </span>
    </div>
</div>

<!-- Stats Cards -->
<div class="admin-stats-row">
    <div class="admin-stat-card admin-stat-success">
        <div class="admin-stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $totalPaid }}</span>
            <span class="admin-stat-label">Achats payés</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-warning">
        <div class="admin-stat-icon">
            <i class="fas fa-clock"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $totalPending }}</span>
            <span class="admin-stat-label">COD en attente</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-info">
        <div class="admin-stat-icon">
            <i class="fas fa-box-open"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $totalEnPreparation }}</span>
            <span class="admin-stat-label">En préparation</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-primary">
        <div class="admin-stat-icon">
            <i class="fas fa-truck"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $totalEnLivraison }}</span>
            <span class="admin-stat-label">En livraison</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-success">
        <div class="admin-stat-icon">
            <i class="fas fa-check-double"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ $totalLivre }}</span>
            <span class="admin-stat-label">Livrées</span>
        </div>
    </div>

    <div class="admin-stat-card admin-stat-primary">
        <div class="admin-stat-icon">
            <i class="fas fa-coins"></i>
        </div>
        <div class="admin-stat-content">
            <span class="admin-stat-value">{{ fcfa($totalRevenue) }}</span>
            <span class="admin-stat-label">Revenue totale</span>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="admin-card mb-4">
    <div class="admin-card-body">
        <form method="GET" class="admin-filters-form">
            <div class="admin-filters-row">
                <div class="admin-filter-group">
                    <label class="admin-filter-label">
                        <i class="fas fa-filter"></i> Statut
                    </label>
                    <select name="statut" class="admin-select">
                        <option value="">Tous les statuts</option>
                        <optgroup label="Achats en ligne">
                            <option value="paid" {{ request('statut') === 'paid' ? 'selected' : '' }}>Payé</option>
                        </optgroup>
                        <optgroup label="Commandes livraison">
                            <option value="pending" {{ request('statut') === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="en_preparation" {{ request('statut') === 'en_preparation' ? 'selected' : '' }}>En préparation</option>
                            <option value="en_livraison" {{ request('statut') === 'en_livraison' ? 'selected' : '' }}>En livraison</option>
                            <option value="livre" {{ request('statut') === 'livre' ? 'selected' : '' }}>Livré</option>
                        </optgroup>
                        <optgroup label="Autre">
                            <option value="annule" {{ request('statut') === 'annule' ? 'selected' : '' }}>Annulé</option>
                        </optgroup>
                    </select>
                </div>

                <div class="admin-filter-group">
                    <label class="admin-filter-label">
                        <i class="fas fa-sort"></i> Tri
                    </label>
                    <select name="sort" class="admin-select">
                        <option value="date" {{ request('sort') === 'date' ? 'selected' : '' }}>Date (récent → ancien)</option>
                        <option value="amount" {{ request('sort') === 'amount' ? 'selected' : '' }}>Montant (élevé → bas)</option>
                    </select>
                </div>

                <div class="admin-filter-group admin-filter-actions">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="fas fa-search"></i> Filtrer
                    </button>
                    @if(request()->hasAny(['statut', 'sort']))
                        <a href="{{ route('admin.commandes.index') }}" class="btn-admin btn-admin-secondary">
                            <i class="fas fa-times"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Empty State -->
@if($users->isEmpty())
    <div class="admin-empty-state">
        <div class="admin-empty-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <h3>Aucune commande trouvée</h3>
        <p>Les commandes des clients apparaîtront ici.</p>
    </div>
@else
    <!-- Liste des commandes par utilisateur -->
    <div class="commandes-list">
        @foreach($users as $user)
            @php
                $colors = ['#1e7a2f', '#0ea5e9', '#8b5cf6', '#f59e0b', '#ef4444', '#ec4899', '#06b6d4', '#14b8a6'];
                $userColor = $colors[$user->id % count($colors)];
                $userTotalActive = $user->commandes_active->sum('total');
                $pendingCount = $user->commandes_active->where('statut', 'pending')->count();
                $confirmedCount = $user->commandes_active->where('statut', 'confirmed')->count();
                $enPreparationCount = $user->commandes_active->where('statut', 'en_preparation')->count();
                $enLivraisonCount = $user->commandes_active->where('statut', 'en_livraison')->count();
            @endphp

            <div class="user-order-card" style="--user-color: {{ $userColor }}">
                <!-- User Header -->
                <div class="user-order-header">
                    <div class="user-order-info">
                        <div class="user-order-avatar" style="background: linear-gradient(135deg, {{ $userColor }}, {{ $userColor }}cc);">
                            @if($user->avatar && file_exists(public_path('storage/' . $user->avatar)))
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                            @else
                                {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                            @endif
                        </div>
                        <div class="user-order-details">
                            <div class="user-order-name">
                                {{ $user->name ?? 'Utilisateur' }}
                                <span class="user-order-id">#{{ $user->id }}</span>
                            </div>
                            <div class="user-order-contact">
                                <span><i class="fas fa-envelope"></i> {{ $user->email }}</span>
                                @if($user->phone)
                                    <span><i class="fas fa-phone"></i> {{ $user->phone }}</span>
                                @endif
                            </div>
                            <div class="user-order-badges">
                                <span class="admin-badge admin-badge-light">
                                    <i class="fas fa-shopping-bag"></i> {{ $user->commandes_active->count() }} active(s)
                                </span>
                                @if($user->commandes_archives && $user->commandes_archives->isNotEmpty())
                                    <span class="admin-badge admin-badge-secondary">
                                        <i class="fas fa-archive"></i> {{ $user->commandes_archives->count() }} archivée(s)
                                    </span>
                                @endif
                                @if($userTotalActive > 0)
                                    <span class="admin-badge admin-badge-success">
                                        <i class="fas fa-coins"></i> {{ fcfa($userTotalActive) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="user-order-actions">
                        <!-- Mini stats -->
                        <div class="user-order-mini-stats">
                            @if($pendingCount > 0)
                                <span class="mini-stat mini-stat-warning" title="En préparation">
                                    <i class="fas fa-clock"></i> {{ $pendingCount }}
                                </span>
                            @endif
                            @if($enLivraisonCount > 0)
                                <span class="mini-stat mini-stat-info" title="En livraison">
                                    <i class="fas fa-truck"></i> {{ $enLivraisonCount }}
                                </span>
                            @endif
                        </div>

                        <button class="btn-admin btn-admin-outline toggle-orders-btn"
                                data-bs-toggle="collapse"
                                data-bs-target="#orders-{{ $user->id }}">
                            <i class="fas fa-chevron-down"></i>
                            <span>Voir</span>
                        </button>

                        <!-- Bulk Actions Dropdown -->
                        <div class="dropdown">
                            <button class="btn-admin btn-admin-secondary btn-admin-icon"
                                    data-bs-toggle="dropdown"
                                    title="Actions massives">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-header">Actions massives (commandes COD)</li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="en_preparation">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-box-open text-warning me-2"></i>Mettre en préparation
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="en_livraison">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-truck text-info me-2"></i>Mettre en livraison
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="livre">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-check-double text-success me-2"></i>Marquer comme livré
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('admin.commandes.bulkStatus', $user->id) }}">
                                        @csrf
                                        <input type="hidden" name="statut" value="annule">
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-times-circle text-danger me-2"></i>Annuler
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Orders Content -->
                <div class="collapse" id="orders-{{ $user->id }}">
                    <div class="user-order-content">
                        @if($user->commandes_active->isEmpty())
                            <div class="orders-empty">
                                <i class="fas fa-box-open"></i>
                                <p>Aucune commande active pour cet utilisateur.</p>
                            </div>
                        @else
                            <div class="orders-grid">
                                @foreach($user->commandes_active as $c)
                                    @php
                                        $statusConfig = match($c->statut) {
                                            'paid' => ['class' => 'success', 'icon' => 'fa-check-circle', 'label' => 'Payé'],
                                            'confirmed' => ['class' => 'success', 'icon' => 'fa-check-circle', 'label' => 'Payé'],
                                            'pending' => ['class' => 'warning', 'icon' => 'fa-clock', 'label' => 'En attente'],
                                            'en_preparation' => ['class' => 'info', 'icon' => 'fa-box-open', 'label' => 'En préparation'],
                                            'en_livraison' => ['class' => 'primary', 'icon' => 'fa-truck', 'label' => 'En livraison'],
                                            'livre', 'livree' => ['class' => 'success', 'icon' => 'fa-check-double', 'label' => 'Livré'],
                                            'annule' => ['class' => 'danger', 'icon' => 'fa-times-circle', 'label' => 'Annulé'],
                                            default => ['class' => 'secondary', 'icon' => 'fa-info-circle', 'label' => $c->statut_label ?? $c->statut]
                                        };
                                        $tel = $c->telephone ?? $c->tel ?? $user->phone ?? '';
                                        $email = $c->email ?? $user->email ?? '';
                                        $wa = $tel ? 'https://wa.me/'.preg_replace('/[^0-9+]/','',$tel) : '#';
                                    @endphp

                                    <div class="order-card">
                                        <div class="order-card-header">
                                            <div class="order-card-title">
                                                <i class="fas fa-receipt"></i>
                                                <span>Commande #{{ $c->id }}</span>
                                            </div>
                                            <span class="admin-badge admin-badge-{{ $statusConfig['class'] }}">
                                                <i class="fas {{ $statusConfig['icon'] }}"></i> {{ $statusConfig['label'] }}
                                            </span>
                                        </div>

                                        <div class="order-card-body">
                                            <div class="order-meta">
                                                <div class="order-meta-item">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    <span>{{ $c->created_at->format('d/m/Y H:i') }}</span>
                                                </div>
                                                @if($c->adresse)
                                                    <div class="order-meta-item">
                                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                                        <span>{{ Str::limit($c->adresse, 50) }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="order-items">
                                                <div class="order-items-header">
                                                    <i class="fas fa-box"></i> Articles ({{ $c->items->count() }})
                                                </div>
                                                <ul class="order-items-list">
                                                    @foreach($c->items->take(3) as $it)
                                                        <li>
                                                            <i class="fas fa-book"></i>
                                                            <span class="item-title">{{ Str::limit($it->titre, 35) }}</span>
                                                            <span class="item-qty">x{{ $it->quantite }}</span>
                                                        </li>
                                                    @endforeach
                                                    @if($c->items->count() > 3)
                                                        <li class="more-items">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                            +{{ $c->items->count() - 3 }} autres
                                                        </li>
                                                    @endif
                                                </ul>
                                            </div>

                                            <div class="order-total">
                                                <span class="order-total-label">Total</span>
                                                <span class="order-total-value">{{ fcfa($c->total) }}</span>
                                            </div>
                                        </div>

                                        <div class="order-card-footer">
                                            <a href="{{ route('admin.commandes.show', $c->id) }}" class="btn-admin btn-admin-primary btn-admin-sm">
                                                <i class="fas fa-eye"></i> Détails
                                            </a>

                                            <div class="order-quick-actions">
                                                @if(!empty($tel))
                                                    <a href="{{ $wa }}" target="_blank" class="quick-action quick-action-whatsapp" title="WhatsApp">
                                                        <i class="fab fa-whatsapp"></i>
                                                    </a>
                                                    <a href="tel:{{ $tel }}" class="quick-action quick-action-phone" title="Appeler">
                                                        <i class="fas fa-phone"></i>
                                                    </a>
                                                @endif
                                                @if(!empty($email))
                                                    <a href="mailto:{{ $email }}?subject={{ urlencode('Commande #' . $c->id) }}"
                                                       class="quick-action quick-action-email" title="Email">
                                                        <i class="fas fa-envelope"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Archives Section -->
                        @if($user->commandes_archives && $user->commandes_archives->isNotEmpty())
                            <div class="archives-section">
                                <div class="archives-header">
                                    <h6>
                                        <i class="fas fa-archive"></i>
                                        Commandes archivées ({{ $user->commandes_archives->count() }})
                                    </h6>
                                    <button class="btn-admin btn-admin-outline btn-admin-sm toggle-archives-btn"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#archives-{{ $user->id }}">
                                        <i class="fas fa-chevron-down"></i> Afficher
                                    </button>
                                </div>

                                <div class="collapse" id="archives-{{ $user->id }}">
                                    <div class="archives-grid">
                                        @foreach($user->commandes_archives as $ac)
                                            <div class="archive-card">
                                                <div class="archive-card-header">
                                                    <span class="archive-id">Commande #{{ $ac->id }}</span>
                                                    <span class="admin-badge admin-badge-success">
                                                        <i class="fas fa-check"></i> Livré
                                                    </span>
                                                </div>
                                                <div class="archive-card-body">
                                                    <div class="archive-date">
                                                        <i class="fas fa-calendar"></i> {{ $ac->created_at->format('d/m/Y') }}
                                                    </div>
                                                    <div class="archive-summary">
                                                        {{ $ac->items->count() }} article(s) — <strong>{{ fcfa($ac->total) }}</strong>
                                                    </div>
                                                </div>
                                                <a href="{{ route('admin.commandes.show', $ac->id) }}" class="btn-admin btn-admin-outline btn-admin-sm w-100">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="admin-pagination-wrapper">
            {{ $users->links() }}
        </div>
    @endif
@endif
@endsection

@push('styles')
<style>
    /* Page Header */
    .admin-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .admin-page-header-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .admin-page-icon {
        width: 56px;
        height: 56px;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--admin-primary), var(--admin-primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 4px 12px rgba(30, 122, 47, 0.3);
    }

    .admin-page-info h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: var(--admin-gray-900);
    }

    .admin-page-info p {
        font-size: 0.875rem;
        color: var(--admin-gray-500);
        margin: 0;
    }

    /* Stats Row */
    .admin-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .admin-stat-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border-left: 4px solid;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .admin-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .admin-stat-card.admin-stat-warning { border-color: #f59e0b; }
    .admin-stat-card.admin-stat-info { border-color: #0ea5e9; }
    .admin-stat-card.admin-stat-success { border-color: #10b981; }
    .admin-stat-card.admin-stat-primary { border-color: var(--admin-primary); }

    .admin-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .admin-stat-warning .admin-stat-icon { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .admin-stat-info .admin-stat-icon { background: rgba(14, 165, 233, 0.1); color: #0ea5e9; }
    .admin-stat-success .admin-stat-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
    .admin-stat-primary .admin-stat-icon { background: rgba(30, 122, 47, 0.1); color: var(--admin-primary); }

    .admin-stat-content {
        display: flex;
        flex-direction: column;
    }

    .admin-stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--admin-gray-900);
        line-height: 1.2;
    }

    .admin-stat-label {
        font-size: 0.8rem;
        color: var(--admin-gray-500);
    }

    /* Filters */
    .admin-filters-form {
        width: 100%;
    }

    .admin-filters-row {
        display: flex;
        gap: 1rem;
        align-items: flex-end;
        flex-wrap: wrap;
    }

    .admin-filter-group {
        flex: 1;
        min-width: 180px;
    }

    .admin-filter-group.admin-filter-actions {
        display: flex;
        gap: 0.5rem;
        flex: 0 0 auto;
    }

    .admin-filter-label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--admin-gray-600);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .admin-filter-label i {
        margin-right: 0.25rem;
    }

    .admin-select {
        width: 100%;
        padding: 0.625rem 1rem;
        border: 1px solid var(--admin-gray-300);
        border-radius: 8px;
        font-size: 0.875rem;
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .admin-select:focus {
        outline: none;
        border-color: var(--admin-primary);
        box-shadow: 0 0 0 3px rgba(30, 122, 47, 0.1);
    }

    /* Empty State */
    .admin-empty-state {
        background: white;
        border-radius: 16px;
        padding: 4rem 2rem;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .admin-empty-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: var(--admin-gray-100);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--admin-gray-400);
    }

    .admin-empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--admin-gray-700);
        margin-bottom: 0.5rem;
    }

    .admin-empty-state p {
        color: var(--admin-gray-500);
        margin: 0;
    }

    /* User Order Card */
    .commandes-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .user-order-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border-left: 4px solid var(--user-color, var(--admin-primary));
        transition: box-shadow 0.2s;
    }

    .user-order-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .user-order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .user-order-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    .user-order-avatar {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.25rem;
        flex-shrink: 0;
        overflow: hidden;
    }

    .user-order-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-order-name {
        font-weight: 600;
        font-size: 1.1rem;
        color: var(--admin-gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .user-order-id {
        font-size: 0.75rem;
        font-weight: 500;
        padding: 0.2rem 0.5rem;
        background: var(--admin-gray-100);
        border-radius: 4px;
        color: var(--admin-gray-600);
    }

    .user-order-contact {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: var(--admin-gray-500);
        flex-wrap: wrap;
    }

    .user-order-contact i {
        margin-right: 0.25rem;
    }

    .user-order-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }

    .user-order-actions {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .user-order-mini-stats {
        display: flex;
        gap: 0.5rem;
    }

    .mini-stat {
        padding: 0.35rem 0.6rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .mini-stat-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .mini-stat-info {
        background: rgba(14, 165, 233, 0.1);
        color: #0284c7;
    }

    .toggle-orders-btn {
        min-width: 90px;
    }

    .toggle-orders-btn i {
        transition: transform 0.3s;
    }

    .toggle-orders-btn[aria-expanded="true"] i {
        transform: rotate(180deg);
    }

    /* Orders Content */
    .user-order-content {
        padding: 1.25rem;
        padding-top: 0;
        border-top: 1px solid var(--admin-gray-200);
    }

    .orders-empty {
        text-align: center;
        padding: 2rem;
        color: var(--admin-gray-500);
    }

    .orders-empty i {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        opacity: 0.5;
    }

    .orders-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1rem;
        padding-top: 1rem;
    }

    /* Order Card */
    .order-card {
        background: var(--admin-gray-50);
        border-radius: 12px;
        border: 1px solid var(--admin-gray-200);
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 1rem;
        background: white;
        border-bottom: 1px solid var(--admin-gray-200);
    }

    .order-card-title {
        font-weight: 600;
        color: var(--admin-gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .order-card-title i {
        color: var(--admin-primary);
    }

    .order-card-body {
        padding: 1rem;
    }

    .order-meta {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .order-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--admin-gray-600);
    }

    .order-meta-item i {
        width: 16px;
        text-align: center;
    }

    .order-items {
        background: white;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }

    .order-items-header {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--admin-gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
    }

    .order-items-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .order-items-list li {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.4rem 0;
        font-size: 0.85rem;
        color: var(--admin-gray-700);
    }

    .order-items-list li i {
        color: var(--admin-primary);
        font-size: 0.75rem;
    }

    .order-items-list .item-title {
        flex: 1;
    }

    .order-items-list .item-qty {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.15rem 0.4rem;
        background: var(--admin-gray-100);
        border-radius: 4px;
        color: var(--admin-gray-600);
    }

    .order-items-list .more-items {
        color: var(--admin-gray-500);
        font-style: italic;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 0.75rem;
        border-top: 1px dashed var(--admin-gray-300);
    }

    .order-total-label {
        font-weight: 600;
        color: var(--admin-gray-600);
    }

    .order-total-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--admin-primary);
    }

    .order-card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 1rem;
        background: white;
        border-top: 1px solid var(--admin-gray-200);
    }

    .order-quick-actions {
        display: flex;
        gap: 0.5rem;
    }

    .quick-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
        transition: all 0.2s;
    }

    .quick-action-whatsapp {
        background: rgba(37, 211, 102, 0.1);
        color: #25d366;
    }

    .quick-action-whatsapp:hover {
        background: #25d366;
        color: white;
    }

    .quick-action-phone {
        background: rgba(14, 165, 233, 0.1);
        color: #0ea5e9;
    }

    .quick-action-phone:hover {
        background: #0ea5e9;
        color: white;
    }

    .quick-action-email {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    .quick-action-email:hover {
        background: #6b7280;
        color: white;
    }

    /* Archives Section */
    .archives-section {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid var(--admin-gray-200);
    }

    .archives-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .archives-header h6 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--admin-gray-600);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .toggle-archives-btn i {
        transition: transform 0.3s;
    }

    .toggle-archives-btn[aria-expanded="true"] i {
        transform: rotate(180deg);
    }

    .archives-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 0.75rem;
        padding-top: 0.5rem;
    }

    .archive-card {
        background: var(--admin-gray-100);
        border-radius: 10px;
        padding: 1rem;
        transition: background 0.2s;
    }

    .archive-card:hover {
        background: var(--admin-gray-200);
    }

    .archive-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .archive-id {
        font-weight: 600;
        color: var(--admin-gray-700);
        font-size: 0.875rem;
    }

    .archive-card-body {
        margin-bottom: 0.75rem;
    }

    .archive-date {
        font-size: 0.8rem;
        color: var(--admin-gray-500);
        margin-bottom: 0.25rem;
    }

    .archive-summary {
        font-size: 0.85rem;
        color: var(--admin-gray-600);
    }

    /* Pagination */
    .admin-pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .admin-page-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .admin-stats-row {
            grid-template-columns: repeat(2, 1fr);
        }

        .admin-filters-row {
            flex-direction: column;
        }

        .admin-filter-group {
            min-width: 100%;
        }

        .admin-filter-group.admin-filter-actions {
            flex-direction: row;
            width: 100%;
        }

        .admin-filter-group.admin-filter-actions .btn-admin {
            flex: 1;
        }

        .user-order-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .user-order-actions {
            width: 100%;
            justify-content: flex-end;
            margin-top: 0.5rem;
        }

        .orders-grid {
            grid-template-columns: 1fr;
        }

        .order-card-footer {
            flex-direction: column;
            gap: 0.75rem;
        }

        .order-card-footer .btn-admin {
            width: 100%;
        }

        .order-quick-actions {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .admin-stats-row {
            grid-template-columns: 1fr;
        }

        .user-order-avatar {
            width: 48px;
            height: 48px;
            font-size: 1rem;
        }

        .user-order-name {
            font-size: 1rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle button text update for orders
    document.querySelectorAll('.toggle-orders-btn').forEach(function(btn) {
        var target = document.querySelector(btn.dataset.bsTarget);

        target.addEventListener('show.bs.collapse', function() {
            btn.querySelector('span').textContent = 'Masquer';
        });

        target.addEventListener('hide.bs.collapse', function() {
            btn.querySelector('span').textContent = 'Voir';
        });
    });

    // Toggle button text update for archives
    document.querySelectorAll('.toggle-archives-btn').forEach(function(btn) {
        var target = document.querySelector(btn.dataset.bsTarget);

        target.addEventListener('show.bs.collapse', function() {
            btn.innerHTML = '<i class="fas fa-chevron-up"></i> Masquer';
        });

        target.addEventListener('hide.bs.collapse', function() {
            btn.innerHTML = '<i class="fas fa-chevron-down"></i> Afficher';
        });
    });
});
</script>
@endpush
