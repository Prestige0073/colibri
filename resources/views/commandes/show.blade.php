@extends('layouts.app')

@section('title', 'Commande #' . $commande->id)

@section('content')
    @php
        // Configuration des statuts
        $rawStatus = strtolower($commande->statut ?? 'pending');
        $statusLabel = $commande->statut_label ?? ucfirst($rawStatus);
        $isOnlinePayment = $commande->isOnlinePayment();
        $isCOD = $commande->isCOD();

        $statusConfig = [
            // ACHAT EN LIGNE - Terminé
            'paid' => [
                'icon' => 'fa-check-circle',
                'color' => '#27ae60',
                'bg' => 'linear-gradient(135deg, #27ae60 0%, #1e8449 100%)',
                'bgLight' => '#d4edda',
                'label' => 'Payé',
                'step' => 1
            ],
            // COMMANDE COD - Cycle
            'pending' => [
                'icon' => 'fa-clock',
                'color' => '#f39c12',
                'bg' => 'linear-gradient(135deg, #f39c12 0%, #d68910 100%)',
                'bgLight' => '#fff8e6',
                'label' => 'En attente',
                'step' => 1
            ],
            'en_preparation' => [
                'icon' => 'fa-box-open',
                'color' => '#3498db',
                'bg' => 'linear-gradient(135deg, #3498db 0%, #2980b9 100%)',
                'bgLight' => '#e3f2fd',
                'label' => 'En préparation',
                'step' => 2
            ],
            'en_livraison' => [
                'icon' => 'fa-truck',
                'color' => '#9b59b6',
                'bg' => 'linear-gradient(135deg, #9b59b6 0%, #8e44ad 100%)',
                'bgLight' => '#f3e5f5',
                'label' => 'En livraison',
                'step' => 3
            ],
            'livre' => [
                'icon' => 'fa-check-double',
                'color' => '#1e8449',
                'bg' => 'linear-gradient(135deg, #1e8449 0%, #145a32 100%)',
                'bgLight' => '#d5f4e6',
                'label' => 'Livré',
                'step' => 4
            ],
            'livree' => [
                'icon' => 'fa-check-double',
                'color' => '#1e8449',
                'bg' => 'linear-gradient(135deg, #1e8449 0%, #145a32 100%)',
                'bgLight' => '#d5f4e6',
                'label' => 'Livré',
                'step' => 4
            ],
            'annule' => [
                'icon' => 'fa-times-circle',
                'color' => '#e74c3c',
                'bg' => 'linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)',
                'bgLight' => '#fadbd8',
                'label' => 'Annulé',
                'step' => 0
            ],
            // Rétrocompatibilité
            'confirmed' => [
                'icon' => 'fa-check-circle',
                'color' => '#27ae60',
                'bg' => 'linear-gradient(135deg, #27ae60 0%, #1e8449 100%)',
                'bgLight' => '#d4edda',
                'label' => 'Payé',
                'step' => 1
            ],
        ];

        $config = $statusConfig[$rawStatus] ?? $statusConfig['pending'];
        $currentStep = $config['step'];
        $isDelivered = in_array($rawStatus, ['livre', 'livree']);

        // Contact info
        $contactPhone = '2290166547808';
        $contactEmail = 'colibrilitteraire@gmail.com';
    @endphp

    <div class="order-detail-page">
        <!-- Hero Header -->
        <div class="order-hero" style="background: {{ $config['bg'] }}">
            <div class="container">
                <div class="order-hero-content">
                    <nav class="order-breadcrumb">
                        <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                        <i class="fa fa-chevron-right"></i>
                        <a href="{{ route('account.commandes') }}">Mes commandes</a>
                        <i class="fa fa-chevron-right"></i>
                        <span>Commande #{{ $commande->id }}</span>
                    </nav>

                    <div class="order-hero-main">
                        <div class="order-hero-info">
                            <div class="order-hero-badge">
                                <i class="fa {{ $config['icon'] }}"></i>
                            </div>
                            <div class="order-hero-text">
                                <h1>Commande #{{ $commande->id }}</h1>
                                <p>{{ $config['label'] }}</p>
                            </div>
                        </div>

                        <div class="order-hero-meta">
                            <div class="meta-item">
                                <i class="fa fa-calendar-alt"></i>
                                <span>{{ $commande->created_at->format('d/m/Y') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fa fa-clock"></i>
                                <span>{{ $commande->created_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vague décorative -->
            <div class="hero-wave">
                <svg viewBox="0 0 1440 100" preserveAspectRatio="none">
                    <path d="M0,50 C360,100 720,0 1440,50 L1440,100 L0,100 Z" fill="#f8f9fa"/>
                </svg>
            </div>
        </div>

        <div class="container">
            <div class="order-content">
                <!-- Colonne principale -->
                <div class="order-main">
                    <!-- Timeline de suivi -->
                    <div class="order-section order-tracking">
                        <div class="section-header">
                            @if($isOnlinePayment)
                                <h2><i class="fa fa-shopping-bag"></i> Détail de votre achat</h2>
                            @else
                                <h2><i class="fa fa-route"></i> Suivi de votre commande</h2>
                            @endif
                        </div>

                        @if($isOnlinePayment)
                            {{-- ACHAT EN LIGNE: Pas de timeline, juste le statut --}}
                            <div class="online-payment-status">
                                <div class="payment-success-box" style="background: {{ $config['bgLight'] }}; border-left: 4px solid {{ $config['color'] }}; padding: 1.5rem; border-radius: 0.75rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <div style="width: 50px; height: 50px; background: {{ $config['bg'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa {{ $config['icon'] }}" style="color: white; font-size: 1.25rem;"></i>
                                        </div>
                                        <div>
                                            <h4 style="margin: 0 0 0.25rem; font-size: 1.1rem; color: {{ $config['color'] }};">
                                                @if($rawStatus === 'paid' || $rawStatus === 'confirmed')
                                                    Achat terminé
                                                @elseif($rawStatus === 'annule')
                                                    Achat annulé
                                                @else
                                                    {{ $config['label'] }}
                                                @endif
                                            </h4>
                                            <p style="margin: 0; color: #636e72; font-size: 0.9rem;">
                                                @if($rawStatus === 'paid' || $rawStatus === 'confirmed')
                                                    Paiement reçu le {{ $commande->updated_at->format('d/m/Y à H:i') }}. Vos documents sont disponibles dans votre bibliothèque.
                                                @elseif($rawStatus === 'annule')
                                                    Cette commande a été annulée.
                                                @else
                                                    Paiement en cours de traitement.
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    @if(($rawStatus === 'paid' || $rawStatus === 'confirmed') && $commande->reference_paiement)
                                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(0,0,0,0.1); display: flex; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem;">
                                            <span style="font-size: 0.8rem; color: #636e72;">
                                                <i class="fa fa-receipt"></i> Réf: {{ $commande->reference_paiement }}
                                            </span>
                                            <span style="font-size: 0.8rem; color: #636e72;">
                                                <i class="fa fa-credit-card"></i> {{ strtoupper($commande->payment_method ?? 'En ligne') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                @if($rawStatus === 'paid' || $rawStatus === 'confirmed')
                                    <div style="margin-top: 1rem; text-align: center;">
                                        <a href="{{ route('account.bibliotheque') }}" class="btn btn-success btn-sm" style="border-radius: 2rem; padding: 0.5rem 1.5rem;">
                                            <i class="fa fa-book-open"></i> Accéder à ma bibliothèque
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- COMMANDE COD: Timeline de livraison --}}
                            <div class="tracking-timeline">
                                <div class="timeline-step {{ $currentStep >= 1 ? 'completed' : '' }} {{ $currentStep == 1 ? 'active' : '' }}">
                                    <div class="step-indicator">
                                        <div class="step-icon">
                                            <i class="fa fa-clipboard-check"></i>
                                        </div>
                                        <div class="step-line"></div>
                                    </div>
                                    <div class="step-content">
                                        <h4>Commande reçue</h4>
                                        <p>En attente de traitement</p>
                                        @if($currentStep >= 1)
                                            <span class="step-date">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="timeline-step {{ $currentStep >= 2 ? 'completed' : '' }} {{ $currentStep == 2 ? 'active' : '' }}">
                                    <div class="step-indicator">
                                        <div class="step-icon">
                                            <i class="fa fa-box"></i>
                                        </div>
                                        <div class="step-line"></div>
                                    </div>
                                    <div class="step-content">
                                        <h4>En préparation</h4>
                                        <p>Nous préparons vos livres</p>
                                    </div>
                                </div>

                                <div class="timeline-step {{ $currentStep >= 3 ? 'completed' : '' }} {{ $currentStep == 3 ? 'active' : '' }}">
                                    <div class="step-indicator">
                                        <div class="step-icon">
                                            <i class="fa fa-truck"></i>
                                        </div>
                                        <div class="step-line"></div>
                                    </div>
                                    <div class="step-content">
                                        <h4>En livraison</h4>
                                        <p>Votre commande est en route</p>
                                    </div>
                                </div>

                                <div class="timeline-step {{ $currentStep >= 4 ? 'completed' : '' }} {{ $currentStep == 4 ? 'active' : '' }}">
                                    <div class="step-indicator">
                                        <div class="step-icon">
                                            <i class="fa fa-home"></i>
                                        </div>
                                    </div>
                                    <div class="step-content">
                                        <h4>Livré</h4>
                                        <p>Paiement à la réception</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Articles commandés -->
                    <div class="order-section order-items-section">
                        <div class="section-header">
                            <h2><i class="fa fa-book"></i> Articles commandés</h2>
                            <span class="items-count">{{ $commande->items->count() }} article{{ $commande->items->count() > 1 ? 's' : '' }}</span>
                        </div>

                        <div class="order-items-list">
                            @foreach($commande->items as $item)
                                <div class="order-item-card">
                                    <div class="item-image">
                                        @if($item->catalogue && $item->catalogue->couverture)
                                            <img src="{{ asset('storage/' . $item->catalogue->couverture) }}" alt="{{ $item->titre }}">
                                        @else
                                            <div class="item-placeholder">
                                                <i class="fa fa-book"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="item-info">
                                        <h4 class="item-title">{{ $item->titre ?? 'Article' }}</h4>
                                        @if($item->catalogue && $item->catalogue->auteur)
                                            <p class="item-author">
                                                <i class="fa fa-user-edit"></i>
                                                {{ $item->catalogue->auteur }}
                                            </p>
                                        @endif
                                        <div class="item-ref">
                                            <span>Réf: {{ $item->catalogue_id ?? '—' }}</span>
                                        </div>
                                    </div>
                                    <div class="item-quantity">
                                        <span class="qty-badge">x{{ $item->quantite }}</span>
                                    </div>
                                    <div class="item-price">
                                        <span class="price-unit">{{ fcfa($item->prix) }}</span>
                                        <span class="price-total">{{ fcfa($item->prix * $item->quantite) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Aide et contact (version mobile) -->
                    <div class="order-section order-help-mobile">
                        <div class="section-header">
                            <h2><i class="fa fa-headset"></i> Besoin d'aide ?</h2>
                        </div>
                        <div class="help-buttons">
                            <a href="https://wa.me/{{ $contactPhone }}?text={{ urlencode('Bonjour, je souhaite des informations sur ma commande #' . $commande->id) }}"
                               target="_blank"
                               class="help-btn help-btn-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                <span>WhatsApp</span>
                            </a>
                            <a href="tel:+{{ $contactPhone }}" class="help-btn help-btn-phone">
                                <i class="fa fa-phone"></i>
                                <span>Appeler</span>
                            </a>
                            <a href="mailto:{{ $contactEmail }}?subject={{ urlencode('Commande #' . $commande->id) }}"
                               class="help-btn help-btn-email">
                                <i class="fa fa-envelope"></i>
                                <span>Email</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="order-sidebar">
                    <!-- Récapitulatif -->
                    <div class="sidebar-card order-summary-card">
                        <h3><i class="fa fa-receipt"></i> Récapitulatif</h3>

                        <div class="summary-rows">
                            <div class="summary-row">
                                <span>Sous-total</span>
                                <span>{{ fcfa($commande->total) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Livraison</span>
                                <span class="text-success">Gratuite</span>
                            </div>
                        </div>

                        <div class="summary-total">
                            <span>Total</span>
                            <span class="total-value">{{ fcfa($commande->total) }}</span>
                        </div>

                        <div class="payment-status {{ $commande->paiement_valide ? 'paid' : 'pending' }}">
                            @if($commande->paiement_valide)
                                <i class="fa fa-check-circle"></i>
                                <div class="payment-info">
                                    <span class="payment-label">Paiement confirmé</span>
                                    <span class="payment-method">{{ ucfirst($commande->payment_method ?? 'En ligne') }}</span>
                                </div>
                            @else
                                <i class="fa fa-clock"></i>
                                <div class="payment-info">
                                    <span class="payment-label">Paiement en attente</span>
                                    <span class="payment-method">{{ ucfirst($commande->payment_method ?? 'À la livraison') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informations de livraison -->
                    <div class="sidebar-card delivery-card">
                        <h3><i class="fa fa-map-marker-alt"></i> Livraison</h3>

                        <div class="delivery-info">
                            <div class="info-row">
                                <i class="fa fa-user"></i>
                                <span>{{ $commande->nom ?? Auth::user()->name }}</span>
                            </div>
                            @if($commande->telephone)
                                <div class="info-row">
                                    <i class="fa fa-phone"></i>
                                    <span>{{ $commande->telephone }}</span>
                                </div>
                            @endif
                            @if($commande->adresse)
                                <div class="info-row">
                                    @php
                                        $isEmail = strpos($commande->adresse, '@') !== false;
                                    @endphp
                                    <i class="fa {{ $isEmail ? 'fa-envelope' : 'fa-map-marker-alt' }}"></i>
                                    <span>{{ $commande->adresse }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Contact (version desktop) -->
                    <div class="sidebar-card contact-card">
                        <h3><i class="fa fa-headset"></i> Besoin d'aide ?</h3>
                        <p>Notre équipe est disponible pour répondre à toutes vos questions.</p>

                        <div class="contact-buttons">
                            <a href="https://wa.me/{{ $contactPhone }}?text={{ urlencode('Bonjour, je souhaite des informations sur ma commande #' . $commande->id) }}"
                               target="_blank"
                               class="contact-btn contact-btn-whatsapp">
                                <i class="fab fa-whatsapp"></i>
                                WhatsApp
                            </a>
                            <a href="tel:+{{ $contactPhone }}" class="contact-btn contact-btn-phone">
                                <i class="fa fa-phone"></i>
                                Appeler
                            </a>
                            <a href="mailto:{{ $contactEmail }}?subject={{ urlencode('Commande #' . $commande->id) }}"
                               class="contact-btn contact-btn-email">
                                <i class="fa fa-envelope"></i>
                                Email
                            </a>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="sidebar-card actions-card">
                        <a href="{{ route('account.commandes') }}" class="action-btn action-btn-secondary">
                            <i class="fa fa-list"></i>
                            Toutes mes commandes
                        </a>
                        <a href="{{ route('catalogue.index') }}" class="action-btn action-btn-primary">
                            <i class="fa fa-book"></i>
                            Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    :root {
        --detail-primary: #1e7a2f;
        --detail-primary-dark: #155a22;
        --detail-primary-light: #e8f5e9;
        --detail-text: #2d3436;
        --detail-text-muted: #636e72;
        --detail-bg: #f8f9fa;
        --detail-card: #ffffff;
        --detail-border: #e9ecef;
        --detail-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --detail-radius: 16px;
        --detail-radius-sm: 10px;
    }

    .order-detail-page {
        background: var(--detail-bg);
        min-height: 100vh;
        padding-bottom: 4rem;
    }

    /* ============================================
       HERO
       ============================================ */
    .order-hero {
        position: relative;
        padding: 2rem 0 4rem;
        color: white;
    }

    .order-hero-content {
        position: relative;
        z-index: 2;
    }

    .order-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        margin-bottom: 1.5rem;
    }

    .order-breadcrumb a {
        color: rgba(255,255,255,0.7);
        text-decoration: none;
        transition: color 0.2s;
    }

    .order-breadcrumb a:hover {
        color: white;
    }

    .order-breadcrumb i.fa-chevron-right {
        color: rgba(255,255,255,0.4);
        font-size: 0.65rem;
    }

    .order-breadcrumb span {
        color: white;
        font-weight: 500;
    }

    .order-hero-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .order-hero-info {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .order-hero-badge {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        backdrop-filter: blur(10px);
    }

    .order-hero-text h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
    }

    .order-hero-text p {
        margin: 0;
        opacity: 0.9;
        font-size: 1.05rem;
    }

    .order-hero-meta {
        display: flex;
        gap: 1.5rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.15);
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.9rem;
        backdrop-filter: blur(10px);
    }

    .hero-wave {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50px;
        overflow: hidden;
    }

    .hero-wave svg {
        width: 100%;
        height: 100%;
    }

    /* ============================================
       CONTENU PRINCIPAL
       ============================================ */
    .order-content {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        margin-top: -1rem;
    }

    .order-section {
        background: var(--detail-card);
        border-radius: var(--detail-radius);
        box-shadow: var(--detail-shadow);
        padding: 1.75rem;
        margin-bottom: 1.5rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--detail-border);
    }

    .section-header h2 {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--detail-text);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.6rem;
    }

    .section-header h2 i {
        color: var(--detail-primary);
    }

    .items-count {
        background: var(--detail-primary-light);
        color: var(--detail-primary);
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    /* ============================================
       TIMELINE DE SUIVI
       ============================================ */
    .tracking-timeline {
        display: flex;
        justify-content: space-between;
        position: relative;
    }

    .timeline-step {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
    }

    .step-indicator {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        margin-bottom: 1rem;
    }

    .step-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #adb5bd;
        position: relative;
        z-index: 2;
        transition: all 0.3s;
    }

    .timeline-step.completed .step-icon {
        background: var(--detail-primary);
        color: white;
    }

    .timeline-step.active .step-icon {
        background: var(--detail-primary);
        color: white;
        box-shadow: 0 0 0 5px var(--detail-primary-light);
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { box-shadow: 0 0 0 5px var(--detail-primary-light); }
        50% { box-shadow: 0 0 0 10px rgba(30, 122, 47, 0.1); }
    }

    .step-line {
        position: absolute;
        top: 25px;
        left: 50%;
        width: 100%;
        height: 3px;
        background: #e9ecef;
        z-index: 1;
    }

    .timeline-step:last-child .step-line {
        display: none;
    }

    .timeline-step.completed .step-line {
        background: var(--detail-primary);
    }

    .step-content h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--detail-text);
        margin: 0 0 0.25rem;
    }

    .timeline-step:not(.completed):not(.active) .step-content h4 {
        color: #adb5bd;
    }

    .step-content p {
        font-size: 0.8rem;
        color: var(--detail-text-muted);
        margin: 0;
    }

    .step-date {
        display: inline-block;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: var(--detail-primary);
        background: var(--detail-primary-light);
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
    }

    /* ============================================
       ARTICLES
       ============================================ */
    .order-items-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .order-item-card {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: #fafbfc;
        border-radius: var(--detail-radius-sm);
        transition: all 0.2s;
    }

    .order-item-card:hover {
        background: #f0f4f8;
    }

    .item-image {
        width: 70px;
        height: 90px;
        border-radius: 8px;
        overflow: hidden;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-placeholder {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--detail-primary-light) 0%, #c8e6c9 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .item-placeholder i {
        font-size: 1.5rem;
        color: var(--detail-primary);
        opacity: 0.7;
    }

    .item-info {
        flex: 1;
        min-width: 0;
    }

    .item-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--detail-text);
        margin: 0 0 0.35rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .item-author {
        font-size: 0.85rem;
        color: var(--detail-text-muted);
        margin: 0 0 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .item-author i {
        font-size: 0.75rem;
    }

    .item-ref {
        font-size: 0.75rem;
        color: #adb5bd;
    }

    .item-quantity {
        flex-shrink: 0;
    }

    .qty-badge {
        display: inline-block;
        background: var(--detail-primary-light);
        color: var(--detail-primary);
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .item-price {
        text-align: right;
        flex-shrink: 0;
        min-width: 100px;
    }

    .price-unit {
        display: block;
        font-size: 0.8rem;
        color: var(--detail-text-muted);
        text-decoration: line-through;
    }

    .price-total {
        display: block;
        font-size: 1.05rem;
        font-weight: 700;
        color: var(--detail-primary);
    }

    .order-item-card:only-child .price-unit,
    .order-item-card .price-unit {
        text-decoration: none;
    }

    /* ============================================
       SIDEBAR
       ============================================ */
    .sidebar-card {
        background: var(--detail-card);
        border-radius: var(--detail-radius);
        box-shadow: var(--detail-shadow);
        padding: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .sidebar-card h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--detail-text);
        margin: 0 0 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-card h3 i {
        color: var(--detail-primary);
    }

    /* Récapitulatif */
    .summary-rows {
        margin-bottom: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 0.6rem 0;
        font-size: 0.9rem;
        color: var(--detail-text);
        border-bottom: 1px dashed var(--detail-border);
    }

    .summary-row:last-child {
        border-bottom: none;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--detail-primary-light);
        border-radius: var(--detail-radius-sm);
        margin-bottom: 1rem;
    }

    .summary-total span:first-child {
        font-weight: 600;
        color: var(--detail-text);
    }

    .total-value {
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--detail-primary);
    }

    .payment-status {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        border-radius: var(--detail-radius-sm);
    }

    .payment-status.paid {
        background: #d4edda;
        color: #155724;
    }

    .payment-status.pending {
        background: #fff3cd;
        color: #856404;
    }

    .payment-status i {
        font-size: 1.25rem;
    }

    .payment-info {
        display: flex;
        flex-direction: column;
    }

    .payment-label {
        font-weight: 600;
        font-size: 0.9rem;
    }

    .payment-method {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    /* Livraison */
    .delivery-info {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .info-row {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-size: 0.9rem;
        color: var(--detail-text);
    }

    .info-row i {
        color: var(--detail-primary);
        width: 16px;
        text-align: center;
        margin-top: 2px;
    }

    /* Contact */
    .contact-card p {
        font-size: 0.85rem;
        color: var(--detail-text-muted);
        margin-bottom: 1rem;
    }

    .contact-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .contact-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem;
        border-radius: var(--detail-radius-sm);
        font-weight: 500;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .contact-btn-whatsapp {
        background: #25D366;
        color: white;
    }

    .contact-btn-whatsapp:hover {
        background: #1da851;
        color: white;
        transform: translateY(-2px);
    }

    .contact-btn-phone {
        background: var(--detail-primary);
        color: white;
    }

    .contact-btn-phone:hover {
        background: var(--detail-primary-dark);
        color: white;
        transform: translateY(-2px);
    }

    .contact-btn-email {
        background: #6c757d;
        color: white;
    }

    .contact-btn-email:hover {
        background: #545b62;
        color: white;
        transform: translateY(-2px);
    }

    /* Actions */
    .actions-card {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem;
        border-radius: var(--detail-radius-sm);
        font-weight: 600;
        font-size: 0.9rem;
        text-decoration: none;
        transition: all 0.2s;
    }

    .action-btn-primary {
        background: linear-gradient(135deg, var(--detail-primary) 0%, var(--detail-primary-dark) 100%);
        color: white;
    }

    .action-btn-primary:hover {
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .action-btn-secondary {
        background: white;
        color: var(--detail-text);
        border: 1px solid var(--detail-border);
    }

    .action-btn-secondary:hover {
        background: var(--detail-bg);
        color: var(--detail-text);
    }

    /* Mobile help section */
    .order-help-mobile {
        display: none;
    }

    .help-buttons {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
    }

    .help-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem;
        border-radius: var(--detail-radius-sm);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .help-btn i {
        font-size: 1.25rem;
    }

    .help-btn-whatsapp {
        background: #25D366;
        color: white;
    }

    .help-btn-phone {
        background: var(--detail-primary);
        color: white;
    }

    .help-btn-email {
        background: #6c757d;
        color: white;
    }

    .help-btn:hover {
        transform: translateY(-3px);
        color: white;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 991px) {
        .order-content {
            grid-template-columns: 1fr;
        }

        .order-sidebar {
            order: -1;
        }

        .contact-card {
            display: none;
        }

        .order-help-mobile {
            display: block;
        }
    }

    @media (max-width: 767px) {
        .order-hero {
            padding: 1.5rem 0 3rem;
        }

        .order-hero-main {
            flex-direction: column;
            align-items: flex-start;
        }

        .order-hero-badge {
            width: 55px;
            height: 55px;
            font-size: 1.4rem;
        }

        .order-hero-text h1 {
            font-size: 1.5rem;
        }

        .order-hero-meta {
            width: 100%;
            justify-content: flex-start;
        }

        .meta-item {
            font-size: 0.8rem;
            padding: 0.4rem 0.75rem;
        }

        .tracking-timeline {
            flex-direction: column;
            gap: 0;
        }

        .timeline-step {
            flex-direction: row;
            align-items: flex-start;
            text-align: left;
            padding-left: 0;
        }

        .step-indicator {
            flex-direction: column;
            margin-right: 1.25rem;
            margin-bottom: 0;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }

        .step-line {
            position: relative;
            top: auto;
            left: auto;
            width: 3px;
            height: 40px;
            margin: 0.5rem 0;
        }

        .timeline-step:last-child .step-indicator {
            flex-direction: column;
        }

        .step-content {
            padding-bottom: 1.5rem;
        }

        .order-item-card {
            flex-wrap: wrap;
        }

        .item-image {
            width: 60px;
            height: 75px;
        }

        .item-info {
            flex: 1 1 calc(100% - 80px);
        }

        .item-quantity {
            order: 3;
        }

        .item-price {
            order: 4;
            text-align: left;
            flex: 1;
        }

        .help-buttons {
            grid-template-columns: 1fr;
        }

        .help-btn {
            flex-direction: row;
            justify-content: center;
        }
    }

    @media (max-width: 575px) {
        .order-section {
            padding: 1.25rem;
        }

        .sidebar-card {
            padding: 1.25rem;
        }

        .order-hero-badge {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        .order-hero-text h1 {
            font-size: 1.35rem;
        }

        .section-header h2 {
            font-size: 1rem;
        }

        .item-title {
            font-size: 0.9rem;
        }

        .total-value {
            font-size: 1.2rem;
        }
    }
</style>
@endpush
