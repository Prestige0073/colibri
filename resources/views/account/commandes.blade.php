@extends('layouts.app')

@section('title', 'Mes commandes')

@section('content')
    @php
        $paidCommandeId = session('paid_commande_id') ?? request('payment_success');
        $paidCommande = $paidCommandeId ? $commandes->firstWhere('id', (int)$paidCommandeId) : null;

        // Séparer les commandes
        $delivered = $commandes->filter(fn($c) => in_array(strtolower($c->statut ?? ''), ['livre', 'livree']));
        $active = $commandes->filter(fn($c) => !in_array(strtolower($c->statut ?? ''), ['livre', 'livree']));

        // Statistiques
        $totalCommandes = $commandes->count();
        $totalDepense = $commandes->where('paiement_valide', true)->sum('total');
        $commandesEnCours = $active->count();
    @endphp

    <div class="orders-page">
        <!-- Hero Header -->
        <div class="orders-hero">
            <div class="container">
                <div class="orders-hero-content">
                    <div class="orders-hero-text">
                        <nav class="orders-breadcrumb">
                            <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                            <i class="fa fa-chevron-right"></i>
                            <a href="{{ route('account.profil') }}">Mon compte</a>
                            <i class="fa fa-chevron-right"></i>
                            <span>Mes commandes</span>
                        </nav>
                        <h1 class="orders-title">
                            <i class="fa fa-shopping-bag"></i>
                            Mes Commandes
                        </h1>
                        <p class="orders-subtitle">Suivez vos achats et gérez vos livraisons en toute simplicité</p>
                    </div>
                    <a href="{{ route('account.profil') }}" class="orders-back-btn">
                        <i class="fa fa-arrow-left"></i>
                        <span>Retour au profil</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="container">
            <!-- Statistiques rapides -->
            @if($totalCommandes > 0)
            <div class="orders-stats">
                <div class="stat-card">
                    <div class="stat-icon stat-icon-total">
                        <i class="fa fa-receipt"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ $totalCommandes }}</span>
                        <span class="stat-label">Commande{{ $totalCommandes > 1 ? 's' : '' }} totale{{ $totalCommandes > 1 ? 's' : '' }}</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-progress">
                        <i class="fa fa-truck"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ $commandesEnCours }}</span>
                        <span class="stat-label">En cours</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-delivered">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ $delivered->count() }}</span>
                        <span class="stat-label">Livrée{{ $delivered->count() > 1 ? 's' : '' }}</span>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon stat-icon-money">
                        <i class="fa fa-coins"></i>
                    </div>
                    <div class="stat-info">
                        <span class="stat-value">{{ number_format($totalDepense, 0, ',', ' ') }}</span>
                        <span class="stat-label">FCFA dépensés</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- Contenu principal -->
            <div class="orders-content">
                @if ($commandes->isEmpty())
                    <!-- État vide -->
                    <div class="orders-empty">
                        <div class="empty-illustration">
                            <div class="empty-icon">
                                <i class="fa fa-box-open"></i>
                            </div>
                            <div class="empty-circles">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <h2>Aucune commande pour le moment</h2>
                        <p>Vous n'avez pas encore passé de commande.<br>Découvrez notre collection de livres africains !</p>
                        <a href="{{ route('catalogue.index') }}" class="empty-cta">
                            <i class="fa fa-book me-2"></i>Explorer le catalogue
                            <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                @else
                    <!-- Navigation onglets -->
                    <div class="orders-tabs">
                        <button class="orders-tab active" data-tab="active">
                            <i class="fa fa-clock"></i>
                            <span>En cours</span>
                            @if($active->count() > 0)
                                <span class="tab-badge">{{ $active->count() }}</span>
                            @endif
                        </button>
                        <button class="orders-tab" data-tab="delivered">
                            <i class="fa fa-check-circle"></i>
                            <span>Livrées</span>
                            @if($delivered->count() > 0)
                                <span class="tab-badge tab-badge-success">{{ $delivered->count() }}</span>
                            @endif
                        </button>
                        <button class="orders-tab" data-tab="all">
                            <i class="fa fa-list"></i>
                            <span>Toutes</span>
                        </button>
                    </div>

                    <!-- Liste des commandes en cours -->
                    <div class="orders-tab-content active" id="tab-active">
                        @if($active->isEmpty())
                            <div class="tab-empty">
                                <i class="fa fa-check-double"></i>
                                <p>Toutes vos commandes ont été livrées !</p>
                            </div>
                        @else
                            <div class="orders-list">
                                @foreach ($active as $c)
                                    @include('account.partials.order-card', ['order' => $c, 'isRecentlyPaid' => $paidCommandeId && $c->id == $paidCommandeId])
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Liste des commandes livrées -->
                    <div class="orders-tab-content" id="tab-delivered">
                        @if($delivered->isEmpty())
                            <div class="tab-empty">
                                <i class="fa fa-truck"></i>
                                <p>Aucune commande livrée pour le moment</p>
                            </div>
                        @else
                            <div class="orders-list">
                                @foreach ($delivered as $c)
                                    @include('account.partials.order-card', ['order' => $c, 'isRecentlyPaid' => false])
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Toutes les commandes -->
                    <div class="orders-tab-content" id="tab-all">
                        <div class="orders-list">
                            @foreach ($commandes as $c)
                                @include('account.partials.order-card', ['order' => $c, 'isRecentlyPaid' => $paidCommandeId && $c->id == $paidCommandeId])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- Modal: Paiement réussi -->
    @if($paidCommande)
        <div class="modal fade" id="paymentSuccessModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content success-modal">
                    <div class="success-modal-header">
                        <div class="success-animation">
                            <div class="success-circle">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="success-ring"></div>
                        </div>
                        <h2>Paiement réussi !</h2>
                        <p>Merci pour votre achat</p>
                    </div>

                    <div class="success-modal-body">
                        <div class="order-summary-card">
                            <div class="summary-header">
                                <span class="order-number">Commande #{{ $paidCommande->id }}</span>
                                <span class="order-date">{{ $paidCommande->created_at->format('d/m/Y') }}</span>
                            </div>

                            <div class="summary-items">
                                @foreach($paidCommande->items as $item)
                                    <div class="summary-item">
                                        <div class="item-info">
                                            <i class="fa fa-book"></i>
                                            <span>{{ \Illuminate\Support\Str::limit($item->titre ?? 'Article', 35) }}</span>
                                        </div>
                                        <div class="item-details">
                                            <span class="item-qty">x{{ $item->quantite }}</span>
                                            <span class="item-price">{{ fcfa($item->prix * $item->quantite) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="summary-total">
                                <span>Total payé</span>
                                <span class="total-amount">{{ fcfa($paidCommande->total) }}</span>
                            </div>
                        </div>

                        <div class="next-steps">
                            <h4><i class="fa fa-info-circle"></i> Prochaines étapes</h4>
                            <ul>
                                <li><i class="fa fa-envelope"></i> Email de confirmation envoyé</li>
                                <li><i class="fa fa-box"></i> Préparation de votre commande</li>
                                <li><i class="fa fa-truck"></i> Livraison sous 2-5 jours</li>
                            </ul>
                        </div>
                    </div>

                    <div class="success-modal-footer">
                        <a href="{{ route('commandes.show', $paidCommande->id) }}" class="success-btn success-btn-primary">
                            <i class="fa fa-eye"></i>
                            Voir ma commande
                        </a>
                        <button type="button" class="success-btn success-btn-secondary" data-bs-dismiss="modal">
                            <i class="fa fa-times"></i>
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
<style>
    :root {
        --orders-primary: #1e7a2f;
        --orders-primary-dark: #155a22;
        --orders-primary-light: #e8f5e9;
        --orders-secondary: #3498db;
        --orders-warning: #f39c12;
        --orders-danger: #e74c3c;
        --orders-success: #27ae60;
        --orders-text: #2d3436;
        --orders-text-muted: #636e72;
        --orders-bg: #f8f9fa;
        --orders-card: #ffffff;
        --orders-border: #e9ecef;
        --orders-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --orders-radius: 16px;
        --orders-radius-sm: 10px;
    }

    .orders-page {
        background: var(--orders-bg);
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    /* ============================================
       HERO HEADER
       ============================================ */
    .orders-hero {
        background: linear-gradient(135deg, var(--orders-primary) 0%, var(--orders-primary-dark) 100%);
        padding: 2.5rem 0;
        margin-bottom: 2rem;
    }

    .orders-hero-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .orders-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }

    .orders-breadcrumb a {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: color 0.2s;
    }

    .orders-breadcrumb a:hover {
        color: white;
    }

    .orders-breadcrumb i {
        color: rgba(255,255,255,0.5);
        font-size: 0.7rem;
    }

    .orders-breadcrumb span {
        color: white;
        font-weight: 500;
    }

    .orders-title {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .orders-title i {
        font-size: 1.75rem;
        opacity: 0.9;
    }

    .orders-subtitle {
        color: rgba(255,255,255,0.85);
        margin: 0;
        font-size: 1rem;
    }

    .orders-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        background: rgba(255,255,255,0.15);
        color: white;
        border-radius: var(--orders-radius-sm);
        text-decoration: none;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s;
        backdrop-filter: blur(10px);
    }

    .orders-back-btn:hover {
        background: rgba(255,255,255,0.25);
        color: white;
        transform: translateX(-3px);
    }

    /* ============================================
       STATISTIQUES
       ============================================ */
    .orders-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--orders-card);
        border-radius: var(--orders-radius);
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        box-shadow: var(--orders-shadow);
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.12);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .stat-icon-total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .stat-icon-progress {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }

    .stat-icon-delivered {
        background: linear-gradient(135deg, var(--orders-success) 0%, #1e8449 100%);
        color: white;
    }

    .stat-icon-money {
        background: linear-gradient(135deg, #f39c12 0%, #d68910 100%);
        color: white;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--orders-text);
        line-height: 1.2;
    }

    .stat-label {
        font-size: 0.8rem;
        color: var(--orders-text-muted);
    }

    /* ============================================
       ONGLETS
       ============================================ */
    .orders-tabs {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        background: var(--orders-card);
        padding: 0.5rem;
        border-radius: var(--orders-radius);
        box-shadow: var(--orders-shadow);
    }

    .orders-tab {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1rem;
        background: transparent;
        border: none;
        border-radius: var(--orders-radius-sm);
        color: var(--orders-text-muted);
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .orders-tab:hover {
        background: var(--orders-primary-light);
        color: var(--orders-primary);
    }

    .orders-tab.active {
        background: var(--orders-primary);
        color: white;
    }

    .orders-tab i {
        font-size: 1rem;
    }

    .tab-badge {
        background: rgba(0,0,0,0.15);
        padding: 0.15rem 0.5rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .orders-tab.active .tab-badge {
        background: rgba(255,255,255,0.25);
    }

    .tab-badge-success {
        background: var(--orders-success) !important;
        color: white;
    }

    .orders-tab-content {
        display: none;
    }

    .orders-tab-content.active {
        display: block;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tab-empty {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--orders-card);
        border-radius: var(--orders-radius);
        box-shadow: var(--orders-shadow);
    }

    .tab-empty i {
        font-size: 3rem;
        color: var(--orders-success);
        margin-bottom: 1rem;
    }

    .tab-empty p {
        color: var(--orders-text-muted);
        font-size: 1.1rem;
        margin: 0;
    }

    /* ============================================
       LISTE DES COMMANDES
       ============================================ */
    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    /* ============================================
       ÉTAT VIDE
       ============================================ */
    .orders-empty {
        text-align: center;
        padding: 5rem 2rem;
        background: var(--orders-card);
        border-radius: var(--orders-radius);
        box-shadow: var(--orders-shadow);
    }

    .empty-illustration {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 2rem;
    }

    .empty-icon {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--orders-primary-light) 0%, #c8e6c9 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon i {
        font-size: 3.5rem;
        color: var(--orders-primary);
    }

    .empty-circles {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
    }

    .empty-circles span {
        position: absolute;
        border: 2px dashed var(--orders-primary);
        border-radius: 50%;
        opacity: 0.3;
    }

    .empty-circles span:nth-child(1) {
        width: 140%;
        height: 140%;
        top: -20%;
        left: -20%;
        animation: pulse-ring 2s infinite;
    }

    .empty-circles span:nth-child(2) {
        width: 160%;
        height: 160%;
        top: -30%;
        left: -30%;
        animation: pulse-ring 2s infinite 0.5s;
    }

    .empty-circles span:nth-child(3) {
        width: 180%;
        height: 180%;
        top: -40%;
        left: -40%;
        animation: pulse-ring 2s infinite 1s;
    }

    @keyframes pulse-ring {
        0% { transform: scale(0.9); opacity: 0.3; }
        50% { transform: scale(1); opacity: 0.1; }
        100% { transform: scale(0.9); opacity: 0.3; }
    }

    .orders-empty h2 {
        color: var(--orders-text);
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
    }

    .orders-empty p {
        color: var(--orders-text-muted);
        font-size: 1rem;
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .empty-cta {
        display: inline-flex;
        align-items: center;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--orders-primary) 0%, var(--orders-primary-dark) 100%);
        color: white;
        border-radius: var(--orders-radius);
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .empty-cta:hover {
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(30, 122, 47, 0.4);
    }

    /* ============================================
       MODAL SUCCÈS
       ============================================ */
    .success-modal {
        border: none;
        border-radius: var(--orders-radius);
        overflow: hidden;
    }

    .success-modal-header {
        background: linear-gradient(135deg, var(--orders-success) 0%, #1e8449 100%);
        padding: 2.5rem 2rem;
        text-align: center;
        color: white;
    }

    .success-animation {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
    }

    .success-circle {
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: scaleIn 0.5s ease;
    }

    .success-circle i {
        font-size: 2.5rem;
        animation: checkIn 0.5s ease 0.3s both;
    }

    .success-ring {
        position: absolute;
        top: -10px;
        left: -10px;
        right: -10px;
        bottom: -10px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 50%;
        animation: ringPulse 1.5s ease infinite;
    }

    @keyframes scaleIn {
        from { transform: scale(0); }
        to { transform: scale(1); }
    }

    @keyframes checkIn {
        from { opacity: 0; transform: scale(0); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes ringPulse {
        0% { transform: scale(1); opacity: 1; }
        100% { transform: scale(1.3); opacity: 0; }
    }

    .success-modal-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .success-modal-header p {
        opacity: 0.9;
        margin: 0;
    }

    .success-modal-body {
        padding: 2rem;
    }

    .order-summary-card {
        background: var(--orders-bg);
        border-radius: var(--orders-radius-sm);
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px dashed var(--orders-border);
    }

    .order-number {
        font-weight: 700;
        color: var(--orders-primary);
    }

    .order-date {
        color: var(--orders-text-muted);
        font-size: 0.85rem;
    }

    .summary-items {
        margin-bottom: 1rem;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
    }

    .item-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--orders-text);
        font-size: 0.9rem;
    }

    .item-info i {
        color: var(--orders-text-muted);
    }

    .item-details {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .item-qty {
        background: var(--orders-primary-light);
        color: var(--orders-primary);
        padding: 0.15rem 0.5rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .item-price {
        font-weight: 600;
        color: var(--orders-text);
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 2px solid var(--orders-primary);
        font-weight: 700;
    }

    .total-amount {
        font-size: 1.25rem;
        color: var(--orders-primary);
    }

    .next-steps {
        background: #e3f2fd;
        border-radius: var(--orders-radius-sm);
        padding: 1.25rem;
    }

    .next-steps h4 {
        color: var(--orders-secondary);
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .next-steps ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .next-steps li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.4rem 0;
        color: var(--orders-text);
        font-size: 0.9rem;
    }

    .next-steps li i {
        color: var(--orders-secondary);
        width: 20px;
    }

    .success-modal-footer {
        padding: 1.5rem 2rem;
        background: var(--orders-bg);
        display: flex;
        gap: 0.75rem;
    }

    .success-btn {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.25rem;
        border-radius: var(--orders-radius-sm);
        font-weight: 600;
        font-size: 0.95rem;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .success-btn-primary {
        background: linear-gradient(135deg, var(--orders-primary) 0%, var(--orders-primary-dark) 100%);
        color: white;
    }

    .success-btn-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .success-btn-secondary {
        background: white;
        color: var(--orders-text);
        border: 1px solid var(--orders-border);
    }

    .success-btn-secondary:hover {
        background: var(--orders-bg);
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 991px) {
        .orders-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .orders-hero {
            padding: 2rem 0;
        }

        .orders-hero-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .orders-title {
            font-size: 1.5rem;
        }

        .orders-back-btn {
            width: 100%;
            justify-content: center;
        }

        .orders-tabs {
            flex-direction: column;
        }

        .orders-tab {
            justify-content: flex-start;
        }

        .success-modal-footer {
            flex-direction: column;
        }
    }

    @media (max-width: 575px) {
        .orders-stats {
            grid-template-columns: 1fr;
        }

        .stat-card {
            padding: 1rem;
        }

        .orders-empty {
            padding: 3rem 1.5rem;
        }

        .empty-illustration {
            width: 100px;
            height: 100px;
        }

        .empty-icon i {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des onglets
    const tabs = document.querySelectorAll('.orders-tab');
    const contents = document.querySelectorAll('.orders-tab-content');

    tabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const tabId = this.dataset.tab;

            // Retirer active de tous les onglets
            tabs.forEach(t => t.classList.remove('active'));
            contents.forEach(c => c.classList.remove('active'));

            // Activer l'onglet cliqué
            this.classList.add('active');
            document.getElementById('tab-' + tabId).classList.add('active');
        });
    });

    // Modal de succès de paiement
    const successModal = document.getElementById('paymentSuccessModal');
    if (successModal) {
        const modal = new bootstrap.Modal(successModal);
        modal.show();

        // Nettoyer l'URL
        if (window.history.replaceState) {
            const url = new URL(window.location.href);
            url.searchParams.delete('payment_success');
            window.history.replaceState({}, document.title, url.pathname + url.search);
        }
    }
});
</script>
@endpush
