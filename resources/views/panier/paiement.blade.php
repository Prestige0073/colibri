@extends('layouts.app')

@section('title', 'Finaliser ma commande')
@section('meta_description', 'Finalisez votre commande en toute sécurité sur Colibri Littéraire.')

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
        --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
        --radius-sm: 0.5rem;
        --radius-md: 0.75rem;
        --radius-lg: 1rem;
    }

    body {
        background: var(--bg-light);
    }

    /* ============================================
       STEPPER - Indication de progression
       ============================================ */
    .checkout-stepper {
        background: white;
        padding: 1.25rem 0;
        border-bottom: 1px solid #e9ecef;
        margin-bottom: 2rem;
    }

    .stepper-container {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0;
        max-width: 500px;
        margin: 0 auto;
    }

    .step {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .step-number {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .step.completed .step-number {
        background: var(--primary-green);
        color: white;
    }

    .step.active .step-number {
        background: var(--primary-green);
        color: white;
        box-shadow: 0 0 0 4px rgba(30, 122, 47, 0.2);
    }

    .step.pending .step-number {
        background: #e9ecef;
        color: var(--text-muted);
    }

    .step-label {
        font-size: 0.8rem;
        font-weight: 500;
        color: var(--text-muted);
    }

    .step.active .step-label,
    .step.completed .step-label {
        color: var(--text-dark);
    }

    .step-connector {
        width: 60px;
        height: 2px;
        background: #e9ecef;
        margin: 0 0.75rem;
    }

    .step-connector.completed {
        background: var(--primary-green);
    }

    /* ============================================
       LAYOUT PRINCIPAL
       ============================================ */
    .checkout-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 1rem 3rem;
    }

    .checkout-main {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        align-items: start;
    }

    /* ============================================
       SECTION CARD GÉNÉRIQUE
       ============================================ */
    .checkout-card {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .checkout-card-header {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .checkout-card-header i {
        color: var(--primary-green);
        font-size: 1.1rem;
    }

    .checkout-card-header h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .checkout-card-body {
        padding: 1.25rem;
    }

    /* ============================================
       RÉSUMÉ PANIER
       ============================================ */
    .cart-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item-image {
        width: 60px;
        height: 80px;
        border-radius: var(--radius-sm);
        object-fit: cover;
        background: #f5f5f5;
        flex-shrink: 0;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .cart-item-title {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.9rem;
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .cart-item-author {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
    }

    .cart-item-qty {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .cart-item-price {
        font-weight: 700;
        color: var(--primary-green);
        font-size: 0.95rem;
        white-space: nowrap;
    }

    /* ============================================
       MÉTHODES DE PAIEMENT
       ============================================ */
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .payment-method {
        position: relative;
        border: 2px solid #e9ecef;
        border-radius: var(--radius-md);
        padding: 1rem 1.25rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .payment-method:hover {
        border-color: #c9ced1;
        background: #fafafa;
    }

    .payment-method.selected {
        border-color: var(--primary-green);
        background: rgba(30, 122, 47, 0.03);
    }

    .payment-method input[type="radio"] {
        display: none;
    }

    .payment-radio {
        width: 20px;
        height: 20px;
        border: 2px solid #c9ced1;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .payment-method.selected .payment-radio {
        border-color: var(--primary-green);
    }

    .payment-radio::after {
        content: '';
        width: 10px;
        height: 10px;
        background: var(--primary-green);
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.2s ease;
    }

    .payment-method.selected .payment-radio::after {
        transform: scale(1);
    }

    .payment-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .payment-icon.kkiapay { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .payment-icon.kkiapay-logo { background: #4361ee; border-radius: var(--radius-sm); }
    .payment-icon.paypal { background: linear-gradient(135deg, #0070ba 0%, #1546a0 100%); }
    .payment-icon.livraison { background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%); }

    .payment-icon i {
        font-size: 1.25rem;
        color: white;
    }

    .payment-icon img {
        max-width: 36px;
        max-height: 36px;
        object-fit: contain;
    }

    .payment-icon.kkiapay-logo img {
        max-width: 40px;
        max-height: 40px;
        filter: brightness(0) invert(1);
    }

    .payment-details {
        flex: 1;
    }

    .payment-name {
        font-weight: 600;
        color: var(--text-dark);
        font-size: 0.95rem;
        margin-bottom: 0.15rem;
    }

    .payment-desc {
        font-size: 0.8rem;
        color: var(--text-muted);
    }

    .payment-badges {
        display: flex;
        gap: 0.35rem;
        margin-top: 0.5rem;
        flex-wrap: wrap;
    }

    .payment-badge {
        font-size: 0.65rem;
        padding: 0.2rem 0.5rem;
        border-radius: 0.25rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .payment-badge.mtn { background: #ffcc00; color: #333; }
    .payment-badge.moov { background: #0066cc; color: white; }
    .payment-badge.visa { background: #1a1f71; color: white; }
    .payment-badge.world { background: #00457c; color: white; }
    .payment-badge.cod { background: var(--primary-green); color: white; }


    /* ============================================
       FORMULAIRE LIVRAISON
       ============================================ */
    .delivery-form {
        display: none;
        margin-top: 1.25rem;
        padding: 1.25rem;
        background: linear-gradient(135deg, rgba(30, 122, 47, 0.05) 0%, rgba(11, 94, 52, 0.08) 100%);
        border: 2px solid var(--primary-green);
        border-radius: var(--radius-md);
        position: relative;
    }

    .delivery-form.show {
        display: block;
        animation: slideDownBounce 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .delivery-form::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: calc(var(--radius-md) + 2px);
        background: linear-gradient(135deg, var(--primary-green), var(--primary-dark));
        z-index: -1;
        animation: pulseGlow 2s ease-in-out infinite;
    }

    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 15px rgba(30, 122, 47, 0.4); }
        50% { box-shadow: 0 0 25px rgba(30, 122, 47, 0.6); }
    }

    @keyframes slideDownBounce {
        0% { opacity: 0; transform: translateY(-20px) scale(0.95); }
        60% { opacity: 1; transform: translateY(5px) scale(1.02); }
        100% { opacity: 1; transform: translateY(0) scale(1); }
    }

    .delivery-form-alert {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);
        border: 1px solid #ffc107;
        border-radius: var(--radius-sm);
        padding: 0.85rem 1rem;
        margin-bottom: 1.25rem;
    }

    .delivery-form-alert i {
        font-size: 1.25rem;
        color: #cc8800;
        flex-shrink: 0;
    }

    .delivery-form-alert span {
        font-size: 0.85rem;
        font-weight: 500;
        color: #856404;
    }

    .delivery-form.highlight-form {
        animation: highlightPulse 0.5s ease-in-out 3;
    }

    @keyframes highlightPulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            transform: scale(1);
        }
        50% {
            box-shadow: 0 0 20px 5px rgba(220, 53, 69, 0.4);
            transform: scale(1.01);
        }
    }

    .form-floating-custom {
        position: relative;
        margin-bottom: 1rem;
    }

    .form-floating-custom label {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.35rem;
        display: block;
    }

    .form-floating-custom input,
    .form-floating-custom textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #e9ecef;
        border-radius: var(--radius-sm);
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .form-floating-custom input:focus,
    .form-floating-custom textarea:focus {
        outline: none;
        border-color: var(--primary-green);
        box-shadow: 0 0 0 3px rgba(30, 122, 47, 0.1);
    }

    /* ============================================
       SIDEBAR RÉCAPITULATIF
       ============================================ */
    .order-summary {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        position: sticky;
        top: 20px;
    }

    .summary-header {
        padding: 1.25rem;
        border-bottom: 1px solid #e9ecef;
    }

    .summary-header h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
    }

    .summary-body {
        padding: 1.25rem;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        font-size: 0.9rem;
    }

    .summary-line.total {
        border-top: 2px solid #e9ecef;
        margin-top: 0.75rem;
        padding-top: 1rem;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .summary-line.total .amount {
        color: var(--primary-green);
    }

    .summary-footer {
        padding: 1.25rem;
        background: var(--bg-soft);
        border-top: 1px solid #e9ecef;
    }

    .btn-checkout {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-sm);
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 122, 47, 0.3);
    }

    .btn-checkout:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* ============================================
       ÉLÉMENTS DE CONFIANCE
       ============================================ */
    .trust-badges {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #e9ecef;
    }

    .trust-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        padding: 0.5rem;
        background: white;
        border-radius: var(--radius-sm);
        min-width: 65px;
    }

    .trust-badge i {
        font-size: 1.1rem;
        color: var(--primary-green);
    }

    .trust-badge span {
        font-size: 0.65rem;
        color: var(--text-muted);
        text-align: center;
        font-weight: 500;
    }

    .security-note {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 1rem;
        justify-content: center;
    }

    .security-note i {
        color: var(--primary-green);
    }

    /* ============================================
       PANIER VIDE
       ============================================ */
    .empty-cart {
        text-align: center;
        padding: 3rem 2rem;
    }

    .empty-cart i {
        font-size: 4rem;
        color: #ddd;
        margin-bottom: 1rem;
    }

    .empty-cart h4 {
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .empty-cart p {
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */

    /* Empêcher le débordement horizontal */
    html, body {
        overflow-x: hidden;
    }

    .checkout-container,
    .checkout-main,
    .checkout-content,
    .checkout-sidebar,
    .checkout-card,
    .checkout-card-body,
    .payment-methods,
    .delivery-form {
        max-width: 100%;
        box-sizing: border-box;
    }

    @media (max-width: 991px) {
        .checkout-main {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .checkout-sidebar {
            order: -1;
        }

        .order-summary {
            position: relative;
            top: 0;
        }

        .stepper-container {
            max-width: 100%;
        }

        .step-label {
            display: none;
        }

        .step-connector {
            width: 40px;
        }
    }

    @media (max-width: 768px) {
        .checkout-container {
            padding: 0 0.75rem 2rem;
        }

        .checkout-card {
            border-radius: var(--radius-md);
            margin-bottom: 1rem;
        }

        .checkout-card-header {
            padding: 0.85rem 1rem;
        }

        .checkout-card-header h3 {
            font-size: 0.9rem;
        }

        .checkout-card-body {
            padding: 1rem;
        }

        /* Cart items responsive */
        .cart-item {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            gap: 0.75rem;
            padding: 0.75rem 0;
            flex-wrap: nowrap;
        }

        .cart-item-info {
            min-width: 0;
            flex: 1;
            overflow: hidden;
        }

        .cart-item-image {
            width: 50px;
            height: 65px;
            flex-shrink: 0;
        }

        .cart-item-title {
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-author {
            font-size: 0.75rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-price {
            font-size: 0.85rem;
            flex-shrink: 0;
            white-space: nowrap;
        }

        /* Payment methods responsive */
        .payment-method {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 0.75rem;
            gap: 0.65rem;
            flex-wrap: nowrap;
        }

        .payment-radio {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .payment-radio::after {
            width: 8px;
            height: 8px;
        }

        .payment-icon {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
        }

        .payment-icon i {
            font-size: 1rem;
        }

        .payment-details {
            min-width: 0;
            flex: 1;
            overflow: hidden;
        }

        .payment-name {
            font-size: 0.85rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .payment-desc {
            font-size: 0.7rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .payment-badges {
            margin-top: 0.35rem;
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
        }

        .payment-badge {
            font-size: 0.6rem;
            padding: 0.15rem 0.4rem;
        }

        /* Delivery form responsive */
        .delivery-form {
            padding: 1rem;
            margin-top: 1rem;
        }

        .delivery-form-alert {
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .delivery-form-alert i {
            font-size: 1.1rem;
        }

        .delivery-form-alert span {
            font-size: 0.8rem;
        }

        .delivery-form h4 {
            font-size: 0.85rem !important;
        }

        .form-floating-custom label {
            font-size: 0.75rem;
        }

        .form-floating-custom input,
        .form-floating-custom textarea {
            padding: 0.65rem 0.85rem;
            font-size: 0.85rem;
            width: 100%;
            box-sizing: border-box;
        }

        /* Formulaire en colonnes sur tablette */
        .delivery-form .row {
            display: flex;
            flex-wrap: wrap;
            margin-left: -0.5rem;
            margin-right: -0.5rem;
        }

        .delivery-form .row > [class*="col-"] {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            box-sizing: border-box;
        }

        /* Order summary responsive */
        .order-summary {
            border-radius: var(--radius-md);
        }

        .summary-header {
            padding: 1rem;
        }

        .summary-header h3 {
            font-size: 0.9rem;
        }

        .summary-body {
            padding: 1rem;
        }

        .summary-line {
            font-size: 0.85rem;
            padding: 0.4rem 0;
        }

        .summary-line.total {
            font-size: 1rem;
        }

        .summary-footer {
            padding: 1rem;
        }

        .btn-checkout {
            padding: 0.85rem;
            font-size: 0.9rem;
        }

        .trust-badges {
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .trust-badge {
            min-width: 60px;
        }

        .trust-badge i {
            font-size: 1rem;
        }

        .trust-badge span {
            font-size: 0.65rem;
        }

        .security-note {
            font-size: 0.7rem;
        }
    }

    @media (max-width: 576px) {
        .checkout-container {
            padding: 0 0.5rem 1.5rem;
        }

        .checkout-stepper {
            padding: 0.85rem 0;
            margin-bottom: 1rem;
        }

        .step-number {
            width: 26px;
            height: 26px;
            font-size: 0.7rem;
        }

        .step-connector {
            width: 20px;
            margin: 0 0.4rem;
        }

        .checkout-card-header {
            padding: 0.75rem;
        }

        .checkout-card-header i {
            font-size: 0.95rem;
        }

        .checkout-card-header h3 {
            font-size: 0.85rem;
        }

        .checkout-card-body {
            padding: 0.75rem;
        }

        /* Cart items mobile */
        .cart-item {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            flex-wrap: nowrap;
            gap: 0.5rem;
        }

        .cart-item-image {
            width: 45px;
            height: 58px;
            flex-shrink: 0;
        }

        .cart-item-info {
            min-width: 0;
            flex: 1;
            overflow: hidden;
        }

        .cart-item-title {
            font-size: 0.8rem;
            line-height: 1.3;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-author {
            font-size: 0.7rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .cart-item-qty {
            font-size: 0.65rem;
        }

        .cart-item-price {
            font-size: 0.8rem;
            flex-shrink: 0;
            white-space: nowrap;
            align-self: center;
        }

        /* Payment methods mobile */
        .payment-method {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 0.7rem;
            gap: 0.5rem;
            flex-wrap: nowrap;
        }

        .payment-radio {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .payment-radio::after {
            width: 7px;
            height: 7px;
        }

        .payment-icon {
            width: 35px;
            height: 35px;
            flex-shrink: 0;
        }

        .payment-icon i {
            font-size: 0.9rem;
        }

        .payment-icon.kkiapay-logo img {
            max-width: 28px;
            max-height: 28px;
        }

        .payment-details {
            min-width: 0;
            flex: 1;
            overflow: hidden;
        }

        .payment-name {
            font-size: 0.8rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .payment-desc {
            font-size: 0.65rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .payment-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.2rem;
        }

        .payment-badge {
            font-size: 0.55rem;
            padding: 0.1rem 0.3rem;
        }

        /* Delivery form mobile */
        .delivery-form {
            padding: 0.85rem;
            margin-top: 0.85rem;
        }

        .delivery-form::before {
            animation: none;
            box-shadow: 0 0 10px rgba(30, 122, 47, 0.3);
        }

        .delivery-form-alert {
            display: flex;
            flex-direction: row;
            align-items: flex-start;
            padding: 0.65rem;
            margin-bottom: 0.85rem;
            gap: 0.5rem;
        }

        .delivery-form-alert i {
            font-size: 1rem;
            flex-shrink: 0;
            margin-top: 0.1rem;
        }

        .delivery-form-alert span {
            font-size: 0.75rem;
            line-height: 1.3;
        }

        .delivery-form h4 {
            font-size: 0.8rem !important;
            margin-bottom: 0.75rem !important;
        }

        .form-floating-custom {
            margin-bottom: 0.65rem;
        }

        .form-floating-custom label {
            font-size: 0.7rem;
            margin-bottom: 0.25rem;
        }

        .form-floating-custom input,
        .form-floating-custom textarea {
            padding: 0.6rem 0.75rem;
            font-size: 0.8rem;
            width: 100%;
            box-sizing: border-box;
        }

        .form-floating-custom textarea {
            min-height: 60px;
        }

        /* Grille formulaire mobile - colonnes empilées */
        .delivery-form .row {
            display: flex;
            flex-direction: column;
            margin-left: 0;
            margin-right: 0;
        }

        .delivery-form .row > [class*="col-"] {
            padding-left: 0;
            padding-right: 0;
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
        }

        /* Summary mobile */
        .summary-header,
        .summary-body,
        .summary-footer {
            padding: 0.85rem;
        }

        .summary-header h3 {
            font-size: 0.85rem;
        }

        .summary-line {
            font-size: 0.8rem;
        }

        .summary-line.total {
            font-size: 0.95rem;
        }

        .btn-checkout {
            padding: 0.75rem;
            font-size: 0.85rem;
        }

        .trust-badges {
            margin-top: 0.75rem;
            padding-top: 0.75rem;
            gap: 0.5rem;
        }

        .trust-badge {
            min-width: 55px;
            padding: 0.35rem;
        }

        .trust-badge i {
            font-size: 0.9rem;
        }

        .trust-badge span {
            font-size: 0.6rem;
        }

        .security-note {
            font-size: 0.65rem;
            margin-top: 0.75rem;
        }

        /* Modals responsive */
        .modal-dialog {
            margin: 0.5rem;
            max-width: calc(100% - 1rem);
        }

        .modal-content {
            border-radius: var(--radius-md) !important;
        }

        #validationErrorModal .modal-body > div:first-child,
        #livraisonModal .modal-body > div:first-child,
        #loadingModal .modal-body {
            padding: 1.5rem !important;
        }

        #validationErrorModal .modal-body > div:first-child > div,
        #livraisonModal .modal-body > div:first-child > div {
            width: 55px !important;
            height: 55px !important;
        }

        #validationErrorModal .modal-body > div:first-child > div i,
        #livraisonModal .modal-body > div:first-child > div i {
            font-size: 1.5rem !important;
        }

        #validationErrorModal h4,
        #livraisonModal h4 {
            font-size: 1.1rem !important;
        }

        #validationErrorModal .p-4,
        #livraisonModal .p-4 {
            padding: 1rem !important;
        }

        #validationErrorMessage {
            font-size: 0.85rem;
        }
    }

    /* Extra small devices (375px and below) */
    @media (max-width: 375px) {
        .checkout-container {
            padding: 0 0.35rem 1.5rem;
        }

        .checkout-card-header {
            padding: 0.6rem 0.65rem;
        }

        .checkout-card-header h3 {
            font-size: 0.75rem;
        }

        .checkout-card-body {
            padding: 0.65rem;
        }

        /* Cart items extra small */
        .cart-item {
            gap: 0.4rem;
        }

        .cart-item-image {
            width: 40px;
            height: 52px;
        }

        .cart-item-title {
            font-size: 0.75rem;
        }

        .cart-item-author {
            font-size: 0.65rem;
        }

        .cart-item-price {
            font-size: 0.75rem;
        }

        /* Payment methods extra small */
        .payment-method {
            padding: 0.55rem;
            gap: 0.4rem;
        }

        .payment-radio {
            width: 14px;
            height: 14px;
        }

        .payment-radio::after {
            width: 6px;
            height: 6px;
        }

        .payment-icon {
            width: 30px;
            height: 30px;
        }

        .payment-icon i {
            font-size: 0.8rem;
        }

        .payment-icon.kkiapay-logo img {
            max-width: 24px;
            max-height: 24px;
        }

        .payment-name {
            font-size: 0.7rem;
        }

        .payment-desc {
            font-size: 0.6rem;
        }

        .payment-badge {
            font-size: 0.5rem;
            padding: 0.08rem 0.25rem;
        }

        /* Delivery form extra small */
        .delivery-form {
            padding: 0.65rem;
        }

        .delivery-form-alert {
            padding: 0.5rem;
        }

        .delivery-form-alert i {
            font-size: 0.85rem;
        }

        .delivery-form-alert span {
            font-size: 0.7rem;
        }

        .delivery-form h4 {
            font-size: 0.75rem !important;
        }

        .form-floating-custom label {
            font-size: 0.65rem;
        }

        .form-floating-custom input,
        .form-floating-custom textarea {
            padding: 0.5rem 0.6rem;
            font-size: 0.75rem;
        }

        /* Summary extra small */
        .summary-header,
        .summary-body,
        .summary-footer {
            padding: 0.65rem;
        }

        .summary-header h3 {
            font-size: 0.8rem;
        }

        .summary-line {
            font-size: 0.75rem;
        }

        .summary-line.total {
            font-size: 0.85rem;
        }

        .btn-checkout {
            padding: 0.6rem;
            font-size: 0.75rem;
        }

        .trust-badges {
            gap: 0.3rem;
        }

        .trust-badge {
            min-width: 45px;
            padding: 0.25rem;
        }

        .trust-badge i {
            font-size: 0.8rem;
        }

        .trust-badge span {
            font-size: 0.55rem;
        }

        .security-note {
            font-size: 0.6rem;
        }

        /* Modal extra small */
        .modal-dialog {
            margin: 0.25rem;
            max-width: calc(100% - 0.5rem);
        }

        #validationErrorModal .modal-body > div:first-child,
        #livraisonModal .modal-body > div:first-child {
            padding: 1rem !important;
        }

        #validationErrorModal .modal-body > div:first-child > div,
        #livraisonModal .modal-body > div:first-child > div {
            width: 45px !important;
            height: 45px !important;
        }

        #validationErrorModal .modal-body > div:first-child > div i,
        #livraisonModal .modal-body > div:first-child > div i {
            font-size: 1.25rem !important;
        }

        #validationErrorModal h4,
        #livraisonModal h4 {
            font-size: 0.95rem !important;
        }

        #validationErrorMessage {
            font-size: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Stepper de progression -->
<div class="checkout-stepper">
    <div class="stepper-container">
        <div class="step completed">
            <div class="step-number"><i class="fas fa-check" style="font-size: 0.7rem;"></i></div>
            <span class="step-label">Panier</span>
        </div>
        <div class="step-connector completed"></div>
        <div class="step active">
            <div class="step-number">2</div>
            <span class="step-label">Paiement</span>
        </div>
        <div class="step-connector"></div>
        <div class="step pending">
            <div class="step-number">3</div>
            <span class="step-label">Confirmation</span>
        </div>
    </div>
</div>

<div class="checkout-container">
    @if($cartItems->isEmpty())
        <div class="checkout-card">
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h4>Votre panier est vide</h4>
                <p>Découvrez notre catalogue et ajoutez des livres à votre panier.</p>
                <a href="{{ route('catalogue.acheter') }}" class="btn btn-success rounded-2">
                    <i class="fas fa-book me-2"></i>Parcourir le catalogue
                </a>
            </div>
        </div>
    @else
        <form method="POST" action="{{ route('panier.traiter-paiement') }}" id="checkoutForm">
            @csrf
            <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="">

            <div class="checkout-main">
                <!-- Colonne principale -->
                <div class="checkout-content">
                    <!-- Résumé du panier -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>Votre commande ({{ $cartItems->count() }} {{ $cartItems->count() > 1 ? 'articles' : 'article' }})</h3>
                        </div>
                        <div class="checkout-card-body">
                            @foreach($cartItems as $item)
                                <div class="cart-item">
                                    @if($item->catalogue->image)
                                        <img src="{{ asset($item->catalogue->image) }}" alt="{{ $item->catalogue->titre }}" class="cart-item-image">
                                    @else
                                        <div class="cart-item-image d-flex align-items-center justify-content-center">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="cart-item-info">
                                        <div class="cart-item-title">{{ $item->catalogue->titre }}</div>
                                        <div class="cart-item-author">{{ $item->catalogue->auteur }}</div>
                                        <div class="cart-item-qty">Quantité: {{ $item->quantite }}</div>
                                    </div>
                                    <div class="cart-item-price">{{ fcfa($item->catalogue->prix * $item->quantite) }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Méthodes de paiement -->
                    <div class="checkout-card">
                        <div class="checkout-card-header">
                            <i class="fas fa-credit-card"></i>
                            <h3>Choisissez votre mode de paiement</h3>
                        </div>
                        <div class="checkout-card-body">
                            <div class="payment-methods">
                                <!-- Livraison à domicile - Recommandé -->
                                <label class="payment-method" data-method="livraison">
                                    <input type="radio" name="payment_option" value="livraison">
                                    <div class="payment-radio"></div>
                                    <div class="payment-icon livraison">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="payment-details">
                                        <div class="payment-name">Livraison à domicile</div>
                                        <div class="payment-desc">Payez en espèces à la réception</div>
                                        <div class="payment-badges">
                                            <span class="payment-badge cod">CASH</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- Kkiapay -->
                                <label class="payment-method" data-method="kkiapay">
                                    <input type="radio" name="payment_option" value="kkiapay">
                                    <div class="payment-radio"></div>
                                    <div class="payment-icon kkiapay-logo">
                                        <img src="https://cdn.kkiapay.me/assets/kkiapay-logo-short.svg" alt="Kkiapay" onerror="this.onerror=null; this.src=''; this.parentElement.innerHTML='<i class=\'fas fa-mobile-alt\' style=\'color: white; font-size: 1.5rem;\'></i>';">
                                    </div>
                                    <div class="payment-details">
                                        <div class="payment-name">Kkiapay</div>
                                        <div class="payment-desc">Mobile Money & Cartes bancaires</div>
                                        <div class="payment-badges">
                                            <span class="payment-badge mtn">MTN</span>
                                            <span class="payment-badge moov">Moov</span>
                                            <span class="payment-badge visa">Visa</span>
                                        </div>
                                    </div>
                                </label>

                                <!-- PayPal -->
                                <label class="payment-method" data-method="paypal">
                                    <input type="radio" name="payment_option" value="paypal">
                                    <div class="payment-radio"></div>
                                    <div class="payment-icon paypal">
                                        <i class="fab fa-paypal"></i>
                                    </div>
                                    <div class="payment-details">
                                        <div class="payment-name">PayPal</div>
                                        <div class="payment-desc">Paiement international sécurisé</div>
                                        <div class="payment-badges">
                                            <span class="payment-badge world">Mondial</span>
                                        </div>
                                    </div>
                                </label>

                            </div>

                            <!-- Formulaire de livraison -->
                            <div class="delivery-form" id="deliveryForm">
                                <div class="delivery-form-alert">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span>Remplissez les informations ci-dessous pour recevoir votre commande</span>
                                </div>
                                <h4 style="font-size: 0.95rem; font-weight: 600; color: var(--text-dark); margin-bottom: 1rem;">
                                    <i class="fas fa-map-marker-alt me-2 text-success"></i>Adresse de livraison
                                </h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label for="nom">Nom complet *</label>
                                            <input type="text" id="nom" name="nom" value="{{ Auth::user()->name ?? '' }}" placeholder="Votre nom complet">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label for="telephone">Téléphone *</label>
                                            <input type="tel" id="telephone" name="telephone" value="{{ Auth::user()->telephone ?? '' }}" placeholder="Ex: +229 97 00 00 00">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating-custom">
                                    <label for="adresse">Adresse de livraison *</label>
                                    <textarea id="adresse" name="adresse" rows="2" placeholder="Quartier, rue, repère...">{{ Auth::user()->adresse ?? '' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label for="ville">Ville *</label>
                                            <input type="text" id="ville" name="ville" value="{{ Auth::user()->ville ?? 'Cotonou' }}" placeholder="Cotonou">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating-custom">
                                            <label for="instructions">Instructions (optionnel)</label>
                                            <input type="text" id="instructions" name="instructions" placeholder="Ex: Appeler avant livraison">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar récapitulatif -->
                <div class="checkout-sidebar">
                    <div class="order-summary">
                        <div class="summary-header">
                            <h3><i class="fas fa-file-invoice me-2"></i>Récapitulatif</h3>
                        </div>
                        <div class="summary-body">
                            <div class="summary-line">
                                <span><i class="fas fa-shopping-basket me-2" style="color: var(--text-muted); font-size: 0.85rem;"></i>{{ $cartItems->sum('quantite') }} {{ $cartItems->sum('quantite') > 1 ? 'articles' : 'article' }}</span>
                                <span>{{ fcfa($total) }}</span>
                            </div>
                            <div class="summary-line total">
                                <span><i class="fas fa-coins me-2" style="color: var(--primary-green);"></i>Total</span>
                                <span class="amount">{{ fcfa($total) }}</span>
                            </div>
                        </div>
                        <div class="summary-footer">
                            <button type="submit" class="btn-checkout" id="submitBtn" disabled>
                                <i class="fas fa-shopping-cart"></i>
                                <span id="btnText">Sélectionnez un paiement</span>
                            </button>

                            <div class="trust-badges">
                                <div class="trust-badge">
                                    <i class="fas fa-lock"></i>
                                    <span>Sécurisé</span>
                                </div>
                                <div class="trust-badge">
                                    <i class="fas fa-sync-alt"></i>
                                    <span>Retour</span>
                                </div>
                                <div class="trust-badge">
                                    <i class="fas fa-comments"></i>
                                    <span>Support</span>
                                </div>
                            </div>

                            <div class="security-note">
                                <i class="fas fa-shield-alt"></i>
                                <span>Transaction 100% sécurisée</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

<!-- Modal de chargement -->
<div class="modal fade" id="loadingModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0" style="border-radius: var(--radius-lg);">
            <div class="modal-body text-center py-5">
                <div class="spinner-border text-success mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Chargement...</span>
                </div>
                <h6 class="mb-1">Traitement en cours...</h6>
                <p class="text-muted small mb-0">Veuillez patienter</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal d'erreur validation -->
<div class="modal fade" id="validationErrorModal" tabindex="-1" aria-labelledby="validationErrorModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: var(--radius-lg); overflow: hidden;">
            <div class="modal-body text-center p-0">
                <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 2rem;">
                    <div style="width: 70px; height: 70px; background: white; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 2rem; color: #dc3545;" aria-hidden="true"></i>
                    </div>
                    <h4 class="text-white mb-1" id="validationErrorModalLabel">Champs obligatoires</h4>
                    <p class="text-white opacity-75 mb-0">Informations manquantes</p>
                </div>
                <div class="p-4">
                    <p class="text-muted mb-3" id="validationErrorMessage">
                        <i class="fas fa-info-circle text-danger me-2" aria-hidden="true"></i>
                        Veuillez remplir tous les champs obligatoires pour la livraison.
                    </p>
                    <div class="d-grid">
                        <button type="button" class="btn btn-danger rounded-2" data-bs-dismiss="modal" id="validationErrorCloseBtn">
                            <i class="fas fa-edit me-2" aria-hidden="true"></i>Compléter le formulaire
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation livraison -->
<div class="modal fade" id="livraisonModal" tabindex="-1" aria-labelledby="livraisonModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius: var(--radius-lg); overflow: hidden;">
            <div class="modal-body text-center p-0">
                <div style="background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%); padding: 2rem;">
                    <div style="width: 70px; height: 70px; background: white; border-radius: 50%; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-check" style="font-size: 2rem; color: var(--primary-green);" aria-hidden="true"></i>
                    </div>
                    <h4 class="text-white mb-1" id="livraisonModalLabel">Commande confirmée !</h4>
                    <p class="text-white opacity-75 mb-0">Numéro: <strong id="commandeNumber">#-</strong></p>
                </div>
                <div class="p-4">
                    <p class="text-muted mb-3">
                        <i class="fas fa-truck text-success me-2" aria-hidden="true"></i>
                        Vous payerez en espèces à la livraison. Notre équipe vous contactera bientôt.
                    </p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('account.commandes') }}" class="btn btn-success rounded-2">
                            <i class="fas fa-list me-2" aria-hidden="true"></i>Voir mes commandes
                        </a>
                        <a href="{{ route('catalogue.acheter') }}" class="btn btn-outline-secondary rounded-2">
                            <i class="fas fa-shopping-bag me-2" aria-hidden="true"></i>Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    const selectedMethodInput = document.getElementById('selectedPaymentMethod');
    const deliveryForm = document.getElementById('deliveryForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const checkoutForm = document.getElementById('checkoutForm');

    // Sélection des méthodes de paiement
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Retirer la sélection précédente
            paymentMethods.forEach(m => m.classList.remove('selected'));

            // Ajouter la sélection
            this.classList.add('selected');
            this.querySelector('input[type="radio"]').checked = true;

            const selectedMethod = this.dataset.method;
            selectedMethodInput.value = selectedMethod;

            // Afficher/masquer le formulaire de livraison
            if (selectedMethod === 'livraison') {
                deliveryForm.classList.add('show');
                btnText.textContent = 'Commander avec livraison';
            } else {
                deliveryForm.classList.remove('show');
                if (selectedMethod === 'kkiapay') {
                    btnText.textContent = 'Payer avec Kkiapay';
                } else if (selectedMethod === 'paypal') {
                    btnText.textContent = 'Payer avec PayPal';
                }
            }

            // Activer le bouton
            submitBtn.disabled = false;

            // Scroll fluide vers la section appropriee
            setTimeout(function() {
                if (selectedMethod === 'livraison' && deliveryForm) {
                    deliveryForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
                } else {
                    submitBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }, 300);
        });
    });

    // Référence au modal d'erreur (créer une seule instance)
    const validationErrorModalElement = document.getElementById('validationErrorModal');
    let validationErrorModal = null;

    if (validationErrorModalElement) {
        validationErrorModal = new bootstrap.Modal(validationErrorModalElement, {
            focus: true
        });

        // Gérer la fermeture du modal
        validationErrorModalElement.addEventListener('hidden.bs.modal', function() {
            // Retirer le focus du bouton avant de fermer complètement
            document.activeElement.blur();

            // Après fermeture, rediriger vers le formulaire
            if (deliveryForm && deliveryForm.classList.contains('show')) {
                // Scroll vers le formulaire de livraison
                setTimeout(() => {
                    deliveryForm.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    // Ajouter un effet de pulsation temporaire pour attirer l'attention
                    deliveryForm.classList.add('highlight-form');
                    setTimeout(() => {
                        deliveryForm.classList.remove('highlight-form');
                    }, 2000);

                    // Focus sur le premier champ vide
                    setTimeout(() => {
                        const nomField = document.getElementById('nom');
                        const telField = document.getElementById('telephone');
                        const adresseField = document.getElementById('adresse');
                        const villeField = document.getElementById('ville');

                        if (nomField && !nomField.value.trim()) {
                            nomField.focus();
                        } else if (telField && !telField.value.trim()) {
                            telField.focus();
                        } else if (adresseField && !adresseField.value.trim()) {
                            adresseField.focus();
                        } else if (villeField && !villeField.value.trim()) {
                            villeField.focus();
                        }
                    }, 300);
                }, 100);
            }
        });
    }

    // Fonction pour afficher le modal d'erreur
    function showValidationError(message) {
        const messageElement = document.getElementById('validationErrorMessage');
        if (messageElement) {
            messageElement.innerHTML = '<i class="fas fa-info-circle text-danger me-2" aria-hidden="true"></i>' + message;
        }

        if (validationErrorModal) {
            validationErrorModal.show();
        }
    }

    // Soumission du formulaire
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', function(e) {
            const selectedMethod = selectedMethodInput.value;

            if (!selectedMethod) {
                e.preventDefault();
                showValidationError('Veuillez sélectionner un mode de paiement.');
                return false;
            }

            // Pour livraison, traiter en AJAX
            if (selectedMethod === 'livraison') {
                e.preventDefault();

                // Validation des champs requis
                const nom = document.getElementById('nom').value.trim();
                const telephone = document.getElementById('telephone').value.trim();
                const adresse = document.getElementById('adresse').value.trim();
                const ville = document.getElementById('ville').value.trim();

                // Collecter les champs manquants
                let missingFields = [];
                if (!nom) missingFields.push('Nom complet');
                if (!telephone) missingFields.push('Téléphone');
                if (!adresse) missingFields.push('Adresse de livraison');
                if (!ville) missingFields.push('Ville');

                if (missingFields.length > 0) {
                    showValidationError('Veuillez remplir les champs suivants : <strong>' + missingFields.join(', ') + '</strong>');
                    return false;
                }

                // Afficher le modal de chargement
                const loadingModal = new bootstrap.Modal(document.getElementById('loadingModal'));
                loadingModal.show();

                // Préparer les données
                const formData = new FormData(checkoutForm);

                // Envoyer via AJAX
                fetch('{{ route("panier.traiter-paiement") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    loadingModal.hide();

                    if (data.success) {
                        document.getElementById('commandeNumber').textContent = '#' + data.commande_id;
                        const confirmModal = new bootstrap.Modal(document.getElementById('livraisonModal'));
                        confirmModal.show();
                    } else {
                        showValidationError(data.message || 'Une erreur est survenue.');
                    }
                })
                .catch(error => {
                    loadingModal.hide();
                    showValidationError('Une erreur est survenue: ' + error.message);
                });
            }
            // Pour les autres méthodes, soumettre normalement
        });
    }
});
</script>
@endpush
