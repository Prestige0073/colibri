@extends('layouts.app')

@section('title', 'Paiement sécurisé - Commande #' . $commande->id)
@section('meta_description', 'Finalisez votre paiement en toute sécurité avec Kkiapay.')

@push('styles')
<style>
    :root {
        --primary-green: #1e7a2f;
        --primary-dark: #0b5e34;
        --accent-gold: #f5a623;
        --text-dark: #2d3436;
        --text-muted: #636e72;
        --bg-light: #f8f9fa;
        --bg-soft: #f1f3f4;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.12);
        --shadow-lg: 0 8px 30px rgba(0,0,0,0.15);
        --radius-sm: 0.5rem;
        --radius-md: 0.75rem;
        --radius-lg: 1rem;
        --radius-xl: 1.25rem;
    }

    body {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
    }

    /* ============================================
       CONTENEUR PRINCIPAL
       ============================================ */
    .payment-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    /* ============================================
       HEADER DE CONFIANCE
       ============================================ */
    .trust-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .trust-header-icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .trust-header-icon i {
        font-size: 1.75rem;
        color: white;
    }

    .trust-header h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .trust-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        margin: 0;
    }

    .trust-badges-row {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        margin-top: 1rem;
        flex-wrap: wrap;
    }

    .trust-badge-item {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .trust-badge-item i {
        color: var(--primary-green);
    }

    /* ============================================
       LAYOUT PRINCIPAL
       ============================================ */
    .payment-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 1.5rem;
        align-items: start;
    }

    /* ============================================
       CARTE PRINCIPALE
       ============================================ */
    .payment-card {
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .payment-card-header {
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        padding: 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .payment-card-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        animation: shimmer 3s infinite linear;
    }

    @keyframes shimmer {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .kkiapay-logo-container {
        position: relative;
        z-index: 1;
    }

    .kkiapay-logo {
        width: 60px;
        height: 60px;
        background: white;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .kkiapay-logo img {
        max-width: 45px;
        max-height: 45px;
    }

    .kkiapay-logo i {
        font-size: 1.75rem;
        color: var(--primary-green);
    }

    .payment-card-header h2 {
        color: white;
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 0.25rem;
        position: relative;
        z-index: 1;
    }

    .payment-card-header .subtitle {
        color: rgba(255,255,255,0.8);
        font-size: 0.85rem;
        position: relative;
        z-index: 1;
    }

    @if(config('services.kkiapay.sandbox'))
    .sandbox-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        background: rgba(255,193,7,0.2);
        color: #ffc107;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
        margin-top: 0.75rem;
        position: relative;
        z-index: 1;
    }
    @endif

    .payment-card-body {
        padding: 1.5rem;
    }

    /* ============================================
       MÉTHODES DE PAIEMENT ACCEPTÉES
       ============================================ */
    .payment-methods-accepted {
        display: flex;
        justify-content: center;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--bg-soft);
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
    }

    .method-chip {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 0.85rem;
        background: white;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        box-shadow: var(--shadow-sm);
    }

    .method-chip.mtn {
        color: #333;
    }

    .method-chip.mtn::before {
        content: '';
        width: 18px;
        height: 18px;
        background: #ffcc00;
        border-radius: 50%;
    }

    .method-chip.moov {
        color: #0066cc;
    }

    .method-chip.moov::before {
        content: '';
        width: 18px;
        height: 18px;
        background: #0066cc;
        border-radius: 50%;
    }

    .method-chip.visa {
        color: #1a1f71;
    }

    .method-chip.visa i {
        font-size: 1.25rem;
    }

    .method-chip.mastercard {
        color: #eb001b;
    }

    .method-chip.mastercard i {
        font-size: 1.25rem;
    }

    /* ============================================
       STATUT DE CHARGEMENT
       ============================================ */
    .loading-status {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, rgba(30, 122, 47, 0.08) 0%, rgba(11, 94, 52, 0.05) 100%);
        border: 1px solid rgba(30, 122, 47, 0.2);
        border-radius: var(--radius-md);
        margin-bottom: 1.5rem;
    }

    .loading-status.success {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(40, 167, 69, 0.05) 100%);
        border-color: rgba(40, 167, 69, 0.3);
    }

    .loading-status.warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, rgba(255, 193, 7, 0.05) 100%);
        border-color: rgba(255, 193, 7, 0.3);
    }

    .loading-spinner {
        width: 36px;
        height: 36px;
        border: 3px solid var(--bg-soft);
        border-top-color: var(--primary-green);
        border-radius: 50%;
        animation: spin 1s linear infinite;
        flex-shrink: 0;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .loading-status-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .loading-status-icon.success {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .loading-status-icon.warning {
        background: rgba(255, 193, 7, 0.15);
        color: #cc8800;
    }

    .loading-status-text h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 0.15rem;
    }

    .loading-status-text p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* ============================================
       BOUTONS D'ACTION
       ============================================ */
    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-pay {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-pay:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 122, 47, 0.4);
    }

    .btn-pay:active {
        transform: translateY(0);
    }

    .btn-pay i {
        font-size: 1.1rem;
    }

    .btn-pay .amount {
        background: rgba(255,255,255,0.2);
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.85rem;
    }

    .btn-cancel {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.75rem 1rem;
        background: transparent;
        color: var(--text-muted);
        border: 1px solid #e9ecef;
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-cancel:hover {
        background: var(--bg-soft);
        color: var(--text-dark);
        border-color: #d1d5db;
    }

    /* ============================================
       SÉCURITÉ
       ============================================ */
    .security-footer {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid #e9ecef;
    }

    .security-footer i {
        color: var(--primary-green);
    }

    .security-footer span {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* ============================================
       SIDEBAR RÉCAPITULATIF
       ============================================ */
    .order-summary-card {
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        position: sticky;
        top: 20px;
    }

    .summary-header {
        padding: 1.25rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .summary-header i {
        color: var(--primary-green);
        font-size: 1.1rem;
    }

    .summary-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .summary-body {
        padding: 1.25rem;
    }

    /* Items de commande */
    .order-items {
        max-height: 250px;
        overflow-y: auto;
        margin-bottom: 1rem;
        padding-right: 0.5rem;
    }

    .order-items::-webkit-scrollbar {
        width: 4px;
    }

    .order-items::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 2px;
    }

    .order-items::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 2px;
    }

    .order-item {
        display: flex;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .order-item:last-child {
        border-bottom: none;
    }

    .order-item-image {
        width: 50px;
        height: 65px;
        background: var(--bg-soft);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .order-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .order-item-image i {
        color: var(--text-muted);
        font-size: 1.25rem;
    }

    .order-item-info {
        flex: 1;
        min-width: 0;
    }

    .order-item-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.15rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .order-item-qty {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .order-item-price {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--primary-green);
        white-space: nowrap;
    }

    /* Ligne récap */
    .summary-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        font-size: 0.85rem;
    }

    .summary-line.total {
        border-top: 2px solid #e9ecef;
        margin-top: 0.5rem;
        padding-top: 1rem;
    }

    .summary-line.total .label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .summary-line.total .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    /* Info commande */
    .order-info {
        background: var(--bg-soft);
        border-radius: var(--radius-md);
        padding: 1rem;
        margin-top: 1rem;
    }

    .order-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.35rem 0;
        font-size: 0.8rem;
    }

    .order-info-item .label {
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .order-info-item .label i {
        width: 16px;
        text-align: center;
        color: var(--primary-green);
    }

    .order-info-item .value {
        font-weight: 500;
        color: var(--text-dark);
    }

    /* ============================================
       GARANTIES
       ============================================ */
    .guarantees {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        padding: 1.25rem;
        background: var(--bg-soft);
        border-radius: 0 0 var(--radius-xl) var(--radius-xl);
    }

    .guarantee-item {
        text-align: center;
    }

    .guarantee-item i {
        font-size: 1.25rem;
        color: var(--primary-green);
        margin-bottom: 0.35rem;
        display: block;
    }

    .guarantee-item span {
        font-size: 0.65rem;
        color: var(--text-muted);
        line-height: 1.3;
        display: block;
    }

    /* ============================================
       AIDE
       ============================================ */
    .help-section {
        text-align: center;
        margin-top: 1.5rem;
        padding: 1rem;
        background: white;
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-sm);
    }

    .help-section p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .help-section a {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 500;
    }

    .help-section a:hover {
        text-decoration: underline;
    }

    /* ============================================
       MODAL DE TRAITEMENT
       ============================================ */
    .processing-modal .modal-content {
        border: none;
        border-radius: var(--radius-xl);
        overflow: hidden;
    }

    .processing-modal .modal-body {
        padding: 3rem 2rem;
        text-align: center;
    }

    .processing-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        position: relative;
    }

    .processing-icon .spinner {
        width: 80px;
        height: 80px;
        border: 4px solid var(--bg-soft);
        border-top-color: var(--primary-green);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .processing-icon i {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 2rem;
        color: var(--primary-green);
    }

    .processing-modal h4 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .processing-modal p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    .processing-steps {
        margin-top: 1.5rem;
        text-align: left;
        max-width: 250px;
        margin-left: auto;
        margin-right: auto;
    }

    .processing-step {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.5rem 0;
        font-size: 0.85rem;
        color: var(--text-muted);
    }

    .processing-step.active {
        color: var(--primary-green);
        font-weight: 500;
    }

    .processing-step.done {
        color: #28a745;
    }

    .processing-step i {
        width: 20px;
        text-align: center;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 991px) {
        .payment-layout {
            grid-template-columns: 1fr;
        }

        .order-summary-card {
            order: -1;
            position: relative;
            top: 0;
        }

        .guarantees {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .payment-page {
            padding: 1rem 0.75rem 2rem;
        }

        .trust-header h1 {
            font-size: 1.25rem;
        }

        .trust-badges-row {
            gap: 1rem;
        }

        .payment-card-header {
            padding: 1.25rem 1rem;
        }

        .payment-card-header h2 {
            font-size: 1.1rem;
        }

        .payment-card-body {
            padding: 1.25rem;
        }

        .payment-methods-accepted {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .method-chip {
            padding: 0.4rem 0.7rem;
            font-size: 0.7rem;
        }

        .btn-pay {
            padding: 0.9rem 1.25rem;
            font-size: 0.95rem;
        }

        .summary-line.total .value {
            font-size: 1.35rem;
        }

        .order-items {
            max-height: 180px;
        }
    }

    @media (max-width: 576px) {
        .trust-header-icon {
            width: 60px;
            height: 60px;
        }

        .trust-header-icon i {
            font-size: 1.5rem;
        }

        .trust-header h1 {
            font-size: 1.15rem;
        }

        .trust-badges-row {
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }

        .payment-card-header {
            padding: 1rem;
        }

        .kkiapay-logo {
            width: 50px;
            height: 50px;
        }

        .kkiapay-logo img {
            max-width: 35px;
            max-height: 35px;
        }

        .payment-card-header h2 {
            font-size: 1rem;
        }

        .payment-card-body {
            padding: 1rem;
        }

        .payment-methods-accepted {
            padding: 0.75rem;
        }

        .loading-status {
            flex-direction: column;
            text-align: center;
            gap: 0.75rem;
        }

        .btn-pay {
            flex-direction: column;
            gap: 0.5rem;
            padding: 1rem;
        }

        .btn-pay .amount {
            width: 100%;
        }

        .summary-header {
            padding: 1rem;
        }

        .summary-body {
            padding: 1rem;
        }

        .order-item-image {
            width: 45px;
            height: 58px;
        }

        .order-item-title {
            font-size: 0.8rem;
        }

        .guarantees {
            padding: 1rem;
            gap: 0.5rem;
        }

        .guarantee-item i {
            font-size: 1.1rem;
        }

        .guarantee-item span {
            font-size: 0.6rem;
        }
    }

    @media (max-width: 375px) {
        .payment-page {
            padding: 0.75rem 0.5rem 1.5rem;
        }

        .trust-header {
            margin-bottom: 1.25rem;
        }

        .trust-header-icon {
            width: 50px;
            height: 50px;
        }

        .trust-header h1 {
            font-size: 1rem;
        }

        .payment-card-body,
        .summary-header,
        .summary-body {
            padding: 0.85rem;
        }

        .method-chip {
            padding: 0.35rem 0.6rem;
            font-size: 0.65rem;
        }

        .btn-pay {
            padding: 0.85rem;
            font-size: 0.9rem;
        }

        .summary-line.total .value {
            font-size: 1.2rem;
        }
    }
</style>
@endpush

@section('content')
<div class="payment-page">
    <!-- Header de confiance -->
    <div class="trust-header">
        <div class="trust-header-icon">
            <i class="fas fa-lock"></i>
        </div>
        <h1>Finalisez votre paiement</h1>
        <p>Transaction 100% sécurisée et cryptée</p>
        <div class="trust-badges-row">
            <div class="trust-badge-item">
                <i class="fas fa-shield-alt"></i>
                <span>Paiement sécurisé SSL</span>
            </div>
            <div class="trust-badge-item">
                <i class="fas fa-check-circle"></i>
                <span>Certifié Kkiapay</span>
            </div>
            <div class="trust-badge-item">
                <i class="fas fa-headset"></i>
                <span>Support 24/7</span>
            </div>
        </div>
    </div>

    <div class="payment-layout">
        <!-- Colonne principale -->
        <div class="payment-main">
            <div class="payment-card">
                <!-- Header Kkiapay -->
                <div class="payment-card-header">
                    <div class="kkiapay-logo-container">
                        <div class="kkiapay-logo">
                            <img src="https://cdn.kkiapay.me/assets/kkiapay-logo-short.svg" alt="Kkiapay" onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-mobile-alt\'></i>';">
                        </div>
                        <h2>Paiement via Kkiapay</h2>
                        <p class="subtitle">Mobile Money & Cartes bancaires</p>
                        @if(config('services.kkiapay.sandbox'))
                            <div class="sandbox-badge">
                                <i class="fas fa-flask"></i>
                                Mode Test
                            </div>
                        @endif
                    </div>
                </div>

                <div class="payment-card-body">
                    <!-- Méthodes acceptées -->
                    <div class="payment-methods-accepted">
                        <div class="method-chip mtn">
                            MTN Money
                        </div>
                        <div class="method-chip moov">
                            Moov Money
                        </div>
                        <div class="method-chip visa">
                            <i class="fab fa-cc-visa"></i>
                            Visa
                        </div>
                        <div class="method-chip mastercard">
                            <i class="fab fa-cc-mastercard"></i>
                            Mastercard
                        </div>
                    </div>

                    <!-- Statut de chargement -->
                    <div class="loading-status" id="loadingStatus">
                        <div class="loading-spinner" id="loadingSpinner"></div>
                        <div class="loading-status-text">
                            <h4 id="loadingTitle">Préparation du paiement...</h4>
                            <p id="loadingMessage">Le module de paiement se charge</p>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="action-buttons">
                        <button type="button" id="payButton" class="btn-pay" onclick="launchPayment()">
                            <i class="fas fa-credit-card"></i>
                            <span>Payer maintenant</span>
                            <span class="amount">{{ fcfa($montant) }}</span>
                        </button>
                        <a href="{{ route('panier.index') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left"></i>
                            Retour au panier
                        </a>
                    </div>

                    <!-- Sécurité -->
                    <div class="security-footer">
                        <i class="fas fa-lock"></i>
                        <span>Vos données de paiement sont protégées par un cryptage SSL 256 bits</span>
                    </div>
                </div>
            </div>

            <!-- Section aide -->
            <div class="help-section">
                <p>
                    <i class="fas fa-question-circle me-1"></i>
                    Besoin d'aide ? <a href="{{ route('contact.index') }}">Contactez notre support</a>
                </p>
            </div>
        </div>

        <!-- Sidebar récapitulatif -->
        <div class="order-summary-sidebar">
            <div class="order-summary-card">
                <div class="summary-header">
                    <i class="fas fa-shopping-bag"></i>
                    <h3>Récapitulatif</h3>
                </div>

                <div class="summary-body">
                    <!-- Articles -->
                    <div class="order-items">
                        @if($commande->items && $commande->items->count() > 0)
                            @foreach($commande->items as $item)
                                <div class="order-item">
                                    <div class="order-item-image">
                                        @if($item->catalogue && $item->catalogue->image)
                                            <img src="{{ asset($item->catalogue->image) }}" alt="{{ $item->titre }}">
                                        @else
                                            <i class="fas fa-book"></i>
                                        @endif
                                    </div>
                                    <div class="order-item-info">
                                        <div class="order-item-title">{{ $item->titre }}</div>
                                        <div class="order-item-qty">Quantité: {{ $item->quantite }}</div>
                                    </div>
                                    <div class="order-item-price">{{ fcfa($item->prix * $item->quantite) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="order-item">
                                <div class="order-item-image">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                                <div class="order-item-info">
                                    <div class="order-item-title">Commande #{{ $commande->id }}</div>
                                    <div class="order-item-qty">Articles de votre panier</div>
                                </div>
                                <div class="order-item-price">{{ fcfa($montant) }}</div>
                            </div>
                        @endif
                    </div>

                    <!-- Total -->
                    <div class="summary-line total">
                        <span class="label">Total à payer</span>
                        <span class="value">{{ fcfa($montant) }}</span>
                    </div>

                    <!-- Info commande -->
                    <div class="order-info">
                        <div class="order-info-item">
                            <span class="label"><i class="fas fa-hashtag"></i>Commande</span>
                            <span class="value">#{{ $commande->id }}</span>
                        </div>
                        <div class="order-info-item">
                            <span class="label"><i class="fas fa-user"></i>Client</span>
                            <span class="value">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="order-info-item">
                            <span class="label"><i class="fas fa-envelope"></i>Email</span>
                            <span class="value">{{ Str::limit(Auth::user()->email, 20) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Garanties -->
                <div class="guarantees">
                    <div class="guarantee-item">
                        <i class="fas fa-truck"></i>
                        <span>Livraison rapide</span>
                    </div>
                    <div class="guarantee-item">
                        <i class="fas fa-undo"></i>
                        <span>Retour facile</span>
                    </div>
                    <div class="guarantee-item">
                        <i class="fas fa-headset"></i>
                        <span>Support réactif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de traitement -->
<div class="modal fade processing-modal" id="processingModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="processing-icon">
                    <div class="spinner"></div>
                    <i class="fas fa-check"></i>
                </div>
                <h4 id="processingTitle">Vérification en cours...</h4>
                <p id="processingMessage">Nous confirmons votre paiement auprès de Kkiapay</p>
                <div class="processing-steps">
                    <div class="processing-step done" id="step1">
                        <i class="fas fa-check-circle"></i>
                        <span>Paiement reçu</span>
                    </div>
                    <div class="processing-step active" id="step2">
                        <i class="fas fa-spinner fa-spin"></i>
                        <span>Vérification en cours</span>
                    </div>
                    <div class="processing-step" id="step3">
                        <i class="fas fa-circle"></i>
                        <span>Confirmation finale</span>
                    </div>
                </div>
                <div id="manualRedirectBtn" style="display: none; margin-top: 1.5rem;">
                    <button class="btn btn-success btn-sm" onclick="manualRedirect()">
                        <i class="fas fa-arrow-right"></i>
                        Accéder à ma commande
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- KKiaPay Widget SDK -->
<script src="https://cdn.kkiapay.me/k.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadingStatus = document.getElementById('loadingStatus');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const loadingTitle = document.getElementById('loadingTitle');
    const loadingMessage = document.getElementById('loadingMessage');
    const payButton = document.getElementById('payButton');

    // Vérifier le chargement du SDK
    const checkSDK = setInterval(function() {
        if (typeof openKkiapayWidget === 'function') {
            clearInterval(checkSDK);

            // Mettre à jour le statut
            loadingStatus.classList.add('success');
            loadingSpinner.outerHTML = '<div class="loading-status-icon success"><i class="fas fa-check"></i></div>';
            loadingTitle.textContent = 'Prêt pour le paiement';
            loadingMessage.textContent = 'Cliquez sur le bouton pour procéder';

            // Ouvrir automatiquement après un court délai
            setTimeout(function() {
                launchPayment();
            }, 800);
        }
    }, 100);

    // Timeout de sécurité
    setTimeout(function() {
        clearInterval(checkSDK);
        if (typeof openKkiapayWidget !== 'function') {
            loadingStatus.classList.add('warning');
            loadingSpinner.outerHTML = '<div class="loading-status-icon warning"><i class="fas fa-exclamation-triangle"></i></div>';
            loadingTitle.textContent = 'Chargement lent';
            loadingMessage.textContent = 'Cliquez sur le bouton pour réessayer';
        }
    }, 10000);
});

function launchPayment() {
    if (typeof openKkiapayWidget !== 'function') {
        alert('Le module de paiement n\'est pas encore chargé. Veuillez patienter ou rafraîchir la page.');
        return;
    }

    openKkiapayWidget({
        amount: {{ $montant }},
        position: "center",
        data: "{{ $commande->id }}",
        theme: "#1e7a2f",
        key: "{{ config('services.kkiapay.public_key') }}",
        sandbox: {{ config('services.kkiapay.sandbox') ? 'true' : 'false' }}
    });
}

// Variable globale pour stocker l'URL de callback
let redirectUrl = null;

// Fonction de redirection manuelle
function manualRedirect() {
    if (redirectUrl) {
        console.log('Redirection manuelle vers:', redirectUrl);
        window.location.href = redirectUrl;
    }
}

// Écouter le succès du paiement
addKkiapayListener('success', function(response) {
    console.log('🎉 KKiaPay SUCCESS Event captured!', response);
    console.log('Transaction ID:', response.transactionId);
    console.log('Commande ID:', {{ $commande->id }});

    // Afficher le modal de traitement
    const processingModal = new bootstrap.Modal(document.getElementById('processingModal'));
    processingModal.show();

    // Animation des étapes
    setTimeout(function() {
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step2').classList.add('done');
        document.getElementById('step2').querySelector('i').className = 'fas fa-check-circle';

        document.getElementById('step3').classList.add('active');
        document.getElementById('step3').querySelector('i').className = 'fas fa-spinner fa-spin';
    }, 1500);

    // Construire l'URL de callback
    redirectUrl = "{{ route('paiement.catalogue.kkiapay.callback') }}" +
        "?transaction_id=" + encodeURIComponent(response.transactionId) +
        "&commande_id={{ $commande->id }}";

    console.log('Redirection vers callback:', redirectUrl);

    // Rediriger vers le callback
    setTimeout(function() {
        console.log('Tentative de redirection automatique...');
        window.location.href = redirectUrl;
    }, 2500);

    // Afficher le bouton de redirection manuelle après 5 secondes
    setTimeout(function() {
        const manualBtn = document.getElementById('manualRedirectBtn');
        const title = document.getElementById('processingTitle');
        const message = document.getElementById('processingMessage');

        if (manualBtn && window.location.href.includes('kkiapay')) {
            // Si on est toujours sur la page, montrer le bouton
            title.textContent = 'Paiement réussi !';
            message.textContent = 'Cliquez sur le bouton ci-dessous pour continuer';
            manualBtn.style.display = 'block';
        }
    }, 5000);
});

// Écouter TOUS les événements pour debug
console.log('🔍 KKiaPay Listeners installés pour la commande #{{ $commande->id }}');

// Écouter l'échec du paiement
addKkiapayListener('failed', function(response) {
    console.error('❌ KKiaPay FAILED Event:', response);

    // Traduire les messages d'erreur KKiaPay
    let errorMessage = 'Le paiement a échoué. Veuillez réessayer.';

    if (response && response.reason) {
        const reason = response.reason.message || response.reason;

        if (reason.includes('invalid_number') || reason === 'invalid_number_') {
            errorMessage = 'Le numéro de téléphone saisi est invalide. Veuillez vérifier le format (ex: 229 XX XX XX XX pour le Bénin).';
        } else if (reason.includes('insufficient_funds') || reason.includes('insufficient')) {
            errorMessage = 'Solde insuffisant sur votre compte. Veuillez recharger et réessayer.';
        } else if (reason.includes('timeout') || reason.includes('expired')) {
            errorMessage = 'La transaction a expiré. Veuillez réessayer.';
        } else if (reason.includes('cancelled') || reason.includes('canceled')) {
            errorMessage = 'La transaction a été annulée.';
        } else if (reason.includes('network') || reason.includes('connection')) {
            errorMessage = 'Erreur de connexion. Vérifiez votre connexion internet et réessayez.';
        } else if (reason.includes('refused') || reason.includes('rejected')) {
            errorMessage = 'La transaction a été refusée par votre opérateur. Contactez votre service client.';
        } else {
            errorMessage = 'Erreur de paiement: ' + reason + '. Veuillez réessayer.';
        }
    }

    // Afficher l'alerte
    alert(errorMessage);
});

// Écouter la fermeture du widget
addKkiapayListener('pending', function(response) {
    console.log('⏳ KKiaPay PENDING Event:', response);
});

// Debug: log quand le widget est fermé sans succès
window.addEventListener('message', function(event) {
    // KKiaPay peut envoyer des messages window.postMessage
    if (event.data && event.data.type) {
        console.log('📨 Message reçu de KKiaPay:', event.data);
    }
});
</script>
@endpush
