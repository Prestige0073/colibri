@extends('layouts.app')

@section('title', 'Mon panier | Colibri Littéraire')
@section('meta_description', 'Consultez et gérez les articles de votre panier.')

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
        --border-light: #e9ecef;
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.06);
        --shadow-md: 0 4px 20px rgba(0,0,0,0.1);
        --shadow-lg: 0 8px 30px rgba(0,0,0,0.12);
        --radius-sm: 0.5rem;
        --radius-md: 0.75rem;
        --radius-lg: 1rem;
        --radius-xl: 1.25rem;
        --transition: all 0.3s ease;
    }

    body {
        background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
    }

    /* ============================================
       PAGE CONTAINER
       ============================================ */
    .cart-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1.5rem 1rem 3rem;
    }

    /* ============================================
       HEADER
       ============================================ */
    .cart-header {
        margin-bottom: 2rem;
    }

    .cart-header-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .cart-title-group {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .cart-icon-circle {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.25);
    }

    .cart-icon-circle i {
        font-size: 1.5rem;
        color: white;
    }

    .cart-title h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 0.25rem;
    }

    .cart-title p {
        font-size: 0.9rem;
        color: var(--text-muted);
        margin: 0;
    }

    .cart-title .item-count {
        background: var(--primary-green);
        color: white;
        padding: 0.15rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    .continue-shopping {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.6rem 1.25rem;
        background: white;
        color: var(--text-dark);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-md);
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none;
        transition: var(--transition);
    }

    .continue-shopping:hover {
        background: var(--bg-soft);
        color: var(--primary-green);
        border-color: var(--primary-green);
    }

    /* ============================================
       MAIN LAYOUT
       ============================================ */
    .cart-layout {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 1.5rem;
        align-items: start;
    }

    /* ============================================
       CART ITEMS SECTION
       ============================================ */
    .cart-items-section {
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
    }

    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-light);
        background: var(--bg-soft);
    }

    .section-header h2 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-header h2 i {
        color: var(--primary-green);
    }

    .clear-cart-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        background: transparent;
        color: #dc3545;
        border: 1px solid #dc3545;
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .clear-cart-btn:hover {
        background: #dc3545;
        color: white;
    }

    /* ============================================
       CART ITEM CARD
       ============================================ */
    .cart-items-list {
        padding: 0;
    }

    .cart-item {
        display: flex;
        gap: 1.25rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-light);
        transition: var(--transition);
        position: relative;
    }

    .cart-item:last-child {
        border-bottom: none;
    }

    .cart-item:hover {
        background: rgba(30, 122, 47, 0.02);
    }

    .cart-item-image {
        width: 90px;
        height: 120px;
        border-radius: var(--radius-md);
        overflow: hidden;
        flex-shrink: 0;
        background: var(--bg-soft);
        box-shadow: var(--shadow-sm);
    }

    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .cart-item-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, var(--bg-soft) 0%, #e9ecef 100%);
    }

    .cart-item-image-placeholder i {
        font-size: 2rem;
        color: #c1c1c1;
    }

    .cart-item-details {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .cart-item-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .cart-item-info {
        flex: 1;
        min-width: 0;
    }

    .cart-item-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0 0 0.35rem;
        line-height: 1.4;
    }

    .cart-item-title a {
        color: inherit;
        text-decoration: none;
        transition: var(--transition);
    }

    .cart-item-title a:hover {
        color: var(--primary-green);
    }

    .cart-item-author {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin: 0 0 0.5rem;
    }

    .cart-item-author i {
        margin-right: 0.35rem;
        color: var(--primary-green);
    }

    .cart-item-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 0.5rem;
    }

    .cart-item-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        padding: 0.25rem 0.6rem;
        background: var(--bg-soft);
        border-radius: 2rem;
        font-size: 0.7rem;
        color: var(--text-muted);
    }

    .cart-item-badge i {
        color: var(--primary-green);
    }

    .cart-item-badge.in-stock {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }

    .cart-item-badge.low-stock {
        background: rgba(255, 193, 7, 0.15);
        color: #cc8800;
    }

    .cart-item-price {
        text-align: right;
        flex-shrink: 0;
    }

    .cart-item-unit-price {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.25rem;
    }

    .cart-item-total-price {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    /* Actions en bas */
    .cart-item-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px dashed var(--border-light);
    }

    /* Quantity Selector */
    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-selector label {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    .quantity-controls {
        display: flex;
        align-items: center;
        background: var(--bg-soft);
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--border-light);
    }

    .qty-btn {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: transparent;
        border: none;
        color: var(--text-dark);
        cursor: pointer;
        transition: var(--transition);
    }

    .qty-btn:hover:not(:disabled) {
        background: var(--primary-green);
        color: white;
    }

    .qty-btn:disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    .qty-input {
        width: 50px;
        height: 36px;
        text-align: center;
        border: none;
        background: white;
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .qty-input:focus {
        outline: none;
    }

    /* Remove Button */
    .remove-item-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.5rem 0.85rem;
        background: transparent;
        color: #dc3545;
        border: 1px solid transparent;
        border-radius: var(--radius-sm);
        font-size: 0.8rem;
        cursor: pointer;
        transition: var(--transition);
    }

    .remove-item-btn:hover {
        background: rgba(220, 53, 69, 0.1);
        border-color: rgba(220, 53, 69, 0.2);
    }

    /* ============================================
       ORDER SUMMARY SIDEBAR
       ============================================ */
    .order-summary {
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
        overflow: hidden;
        position: sticky;
        top: 20px;
    }

    .summary-header {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        color: white;
    }

    .summary-header h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .summary-body {
        padding: 1.5rem;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0;
        font-size: 0.9rem;
        border-bottom: 1px solid var(--border-light);
    }

    .summary-line:last-child {
        border-bottom: none;
    }

    .summary-line .label {
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .summary-line .label i {
        width: 18px;
        text-align: center;
        color: var(--primary-green);
    }

    .summary-line .value {
        font-weight: 600;
        color: var(--text-dark);
    }

    .summary-line.total {
        margin-top: 0.75rem;
        padding-top: 1rem;
        border-top: 2px solid var(--border-light);
        border-bottom: none;
    }

    .summary-line.total .label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .summary-line.total .value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-green);
    }

    /* Promo Code */
    .promo-section {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px dashed var(--border-light);
    }

    .promo-toggle {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--primary-green);
        cursor: pointer;
        margin-bottom: 0.75rem;
    }

    .promo-toggle i {
        transition: transform 0.3s ease;
    }

    .promo-toggle.active i {
        transform: rotate(180deg);
    }

    .promo-input-group {
        display: none;
        flex-direction: row;
        gap: 0.5rem;
    }

    .promo-input-group.show {
        display: flex;
    }

    .promo-input-group input {
        flex: 1;
        padding: 0.6rem 0.85rem;
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
    }

    .promo-input-group input:focus {
        outline: none;
        border-color: var(--primary-green);
    }

    .promo-input-group button {
        padding: 0.6rem 1rem;
        background: var(--bg-soft);
        border: 1px solid var(--border-light);
        border-radius: var(--radius-sm);
        font-size: 0.85rem;
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .promo-input-group button:hover {
        background: var(--primary-green);
        color: white;
        border-color: var(--primary-green);
    }

    /* Checkout Button */
    .summary-footer {
        padding: 1.5rem;
        background: var(--bg-soft);
    }

    .btn-checkout {
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
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-checkout:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 122, 47, 0.4);
        color: white;
    }

    .btn-checkout:active {
        transform: translateY(0);
    }

    .btn-checkout i {
        font-size: 1.1rem;
    }

    /* Trust Badges */
    .trust-badges {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--border-light);
    }

    .trust-badge {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        text-align: center;
    }

    .trust-badge i {
        font-size: 1.25rem;
        color: var(--primary-green);
    }

    .trust-badge span {
        font-size: 0.65rem;
        color: var(--text-muted);
        line-height: 1.2;
    }

    /* ============================================
       EMPTY CART STATE
       ============================================ */
    .empty-cart {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-md);
    }

    .empty-cart-icon {
        width: 120px;
        height: 120px;
        background: var(--bg-soft);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-cart-icon i {
        font-size: 3rem;
        color: #c1c1c1;
    }

    .empty-cart h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }

    .empty-cart p {
        font-size: 1rem;
        color: var(--text-muted);
        margin-bottom: 2rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .empty-cart-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .btn-explore {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: var(--radius-md);
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-explore:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30, 122, 47, 0.4);
        color: white;
    }

    .empty-cart-suggestions {
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-light);
    }

    .empty-cart-suggestions h3 {
        font-size: 1rem;
        color: var(--text-muted);
        margin-bottom: 1.5rem;
    }

    .suggestion-cards {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .suggestion-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: var(--bg-soft);
        border-radius: var(--radius-md);
        text-decoration: none;
        transition: var(--transition);
    }

    .suggestion-card:hover {
        background: var(--border-light);
        transform: translateY(-2px);
    }

    .suggestion-card i {
        font-size: 1.5rem;
        color: var(--primary-green);
    }

    .suggestion-card span {
        font-size: 0.9rem;
        font-weight: 500;
        color: var(--text-dark);
    }

    /* ============================================
       RECOMMENDED PRODUCTS
       ============================================ */
    .recommendations {
        margin-top: 2.5rem;
    }

    .recommendations-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .recommendations-header h3 {
        font-size: 1.15rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .recommendations-header h3 i {
        color: var(--accent-gold);
    }

    .recommendations-header a {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.75rem;
        background: var(--primary-green);
        color: white;
        font-size: 0.75rem;
        font-weight: 500;
        text-decoration: none;
        border-radius: var(--radius-sm);
        transition: var(--transition);
    }

    .recommendations-header a:hover {
        background: var(--primary-dark);
        color: white;
    }

    .recommendations-header a i {
        font-size: 0.65rem;
    }

    .recommendations-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
    }

    .recommend-card {
        background: white;
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
        position: relative;
    }

    .recommend-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .recommend-card-image {
        height: 140px;
        background: var(--bg-soft);
        overflow: hidden;
        position: relative;
    }

    .recommend-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .recommend-card:hover .recommend-card-image img {
        transform: scale(1.05);
    }

    .recommend-card-body {
        padding: 1rem;
    }

    .recommend-card-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .recommend-card-title a {
        color: inherit;
        text-decoration: none;
    }

    .recommend-card-title a:hover {
        color: var(--primary-green);
    }

    .recommend-card-author {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .recommend-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-top: 0.75rem;
    }

    .recommend-card-price {
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    .recommend-add-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 50%;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 2px 8px rgba(30, 122, 47, 0.3);
    }

    .recommend-add-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(30, 122, 47, 0.4);
    }

    .recommend-add-btn:active {
        transform: scale(0.95);
    }

    .recommend-add-btn i {
        font-size: 0.85rem;
    }

    .recommend-add-btn.added {
        background: #28a745;
    }

    .recommend-add-btn.added i {
        animation: checkPop 0.3s ease;
    }

    @keyframes checkPop {
        0% { transform: scale(0); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1); }
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 991px) {
        .cart-layout {
            grid-template-columns: 1fr;
        }

        .order-summary {
            position: relative;
            top: 0;
            order: -1;
        }

        .recommendations-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .cart-page {
            padding: 1rem 0.75rem 2rem;
        }

        .cart-header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-title h1 {
            font-size: 1.5rem;
        }

        .cart-icon-circle {
            width: 48px;
            height: 48px;
        }

        .cart-icon-circle i {
            font-size: 1.25rem;
        }

        .continue-shopping {
            width: 100%;
            justify-content: center;
        }

        .section-header {
            padding: 1rem 1.25rem;
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .cart-item {
            padding: 1rem 1.25rem;
            gap: 1rem;
        }

        .cart-item-image {
            width: 70px;
            height: 95px;
        }

        .cart-item-top {
            flex-direction: column;
            gap: 0.5rem;
        }

        .cart-item-price {
            text-align: left;
        }

        .cart-item-bottom {
            flex-direction: column;
            gap: 0.75rem;
            align-items: flex-start;
        }

        .quantity-selector {
            width: 100%;
            justify-content: space-between;
        }

        .summary-header,
        .summary-body,
        .summary-footer {
            padding: 1.25rem;
        }

        .summary-line.total .value {
            font-size: 1.35rem;
        }

        .trust-badges {
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .empty-cart {
            padding: 3rem 1.5rem;
        }

        .empty-cart-icon {
            width: 100px;
            height: 100px;
        }

        .empty-cart-icon i {
            font-size: 2.5rem;
        }

        .empty-cart h2 {
            font-size: 1.25rem;
        }

        .suggestion-cards {
            flex-direction: column;
            align-items: center;
        }

        .suggestion-card {
            width: 100%;
            max-width: 280px;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .cart-title-group {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .cart-title h1 {
            font-size: 1.35rem;
        }

        .cart-title p {
            font-size: 0.85rem;
        }

        .section-header h2 {
            font-size: 0.9rem;
        }

        .cart-item {
            padding: 1rem;
            gap: 0.75rem;
        }

        .cart-item-image {
            width: 60px;
            height: 80px;
        }

        .cart-item-title {
            font-size: 0.9rem;
        }

        .cart-item-author {
            font-size: 0.8rem;
        }

        .cart-item-total-price {
            font-size: 1rem;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
        }

        .qty-input {
            width: 45px;
            height: 32px;
            font-size: 0.85rem;
        }

        .btn-checkout {
            padding: 0.9rem 1.25rem;
            font-size: 0.95rem;
        }

        .recommendations-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
        }

        .recommend-card-image {
            height: 120px;
        }

        .recommend-card-body {
            padding: 0.75rem;
        }
    }

    @media (max-width: 375px) {
        .cart-page {
            padding: 0.75rem 0.5rem 1.5rem;
        }

        .cart-icon-circle {
            width: 44px;
            height: 44px;
        }

        .cart-title h1 {
            font-size: 1.2rem;
        }

        .cart-item {
            padding: 0.85rem;
        }

        .cart-item-image {
            width: 55px;
            height: 72px;
        }

        .cart-item-title {
            font-size: 0.85rem;
        }

        .cart-item-meta {
            display: none;
        }

        .summary-header,
        .summary-body,
        .summary-footer {
            padding: 1rem;
        }

        .summary-line {
            font-size: 0.85rem;
        }

        .summary-line.total .value {
            font-size: 1.2rem;
        }

        .btn-checkout {
            padding: 0.85rem 1rem;
            font-size: 0.9rem;
        }

        .trust-badge span {
            font-size: 0.6rem;
        }
    }

    /* Animation pour mise à jour */
    @keyframes pulse-success {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.4);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
        }
    }

    .cart-item.updating {
        opacity: 0.6;
        pointer-events: none;
    }

    .cart-item.updated {
        animation: pulse-success 0.6s ease;
    }
</style>
@endpush

@section('content')
@include('partials.notifications')

<div class="cart-page">
    <!-- Header -->
    <div class="cart-header">
        <div class="cart-header-content">
            <div class="cart-title-group">
                <div class="cart-icon-circle">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="cart-title">
                    <h1>
                        Mon panier
                        @if($items->count() > 0)
                            <span class="item-count">{{ $items->count() }} {{ $items->count() > 1 ? 'articles' : 'article' }}</span>
                        @endif
                    </h1>
                    <p>
                        @if($items->isEmpty())
                            Votre panier est vide
                        @else
                            Finalisez votre commande en toute sécurité
                        @endif
                    </p>
                </div>
            </div>
            <a href="{{ route('catalogue.index') }}" class="continue-shopping">
                <i class="fas fa-arrow-left"></i>
                Continuer mes achats
            </a>
        </div>
    </div>

    @if($items->isEmpty())
        <!-- Empty Cart State -->
        <div class="empty-cart">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-basket"></i>
            </div>
            <h2>Votre panier est vide</h2>
            <p>Parcourez notre catalogue et ajoutez vos livres préférés pour commencer votre commande.</p>

            <div class="empty-cart-actions">
                <a href="{{ route('catalogue.index') }}" class="btn-explore">
                    <i class="fas fa-book-open"></i>
                    Explorer le catalogue
                </a>
            </div>

            <div class="empty-cart-suggestions">
                <h3>Découvrez nos catégories</h3>
                <div class="suggestion-cards">
                    <a href="{{ route('catalogue.index') }}" class="suggestion-card">
                        <i class="fas fa-star"></i>
                        <span>Nouveautés</span>
                    </a>
                    <a href="{{ route('catalogue.index') }}" class="suggestion-card">
                        <i class="fas fa-fire"></i>
                        <span>Meilleures ventes</span>
                    </a>
                    <a href="{{ route('catalogue.index') }}" class="suggestion-card">
                        <i class="fas fa-tags"></i>
                        <span>Promotions</span>
                    </a>
                </div>
            </div>
        </div>
    @else
        @php
            $subtotal = $items->sum(fn($i) => $i->catalogue->prix * $i->quantite);
            $shipping = 0; // Livraison gratuite ou à calculer
            $total = $subtotal + $shipping;
        @endphp

        <div class="cart-layout">
            <!-- Cart Items Section -->
            <div class="cart-items-section">
                <div class="section-header">
                    <h2>
                        <i class="fas fa-book"></i>
                        Vos articles ({{ $items->count() }})
                    </h2>
                </div>

                <div class="cart-items-list">
                    @foreach($items as $item)
                        <div class="cart-item" id="cart-item-{{ $item->id }}">
                            <!-- Image -->
                            <div class="cart-item-image">
                                @if($item->catalogue->image)
                                    <img src="{{ asset($item->catalogue->image) }}" alt="{{ $item->catalogue->titre }}">
                                @else
                                    <div class="cart-item-image-placeholder">
                                        <i class="fas fa-book"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Details -->
                            <div class="cart-item-details">
                                <div class="cart-item-top">
                                    <div class="cart-item-info">
                                        <h3 class="cart-item-title">
                                            <a href="{{ route('catalogue.show', $item->catalogue) }}">{{ $item->catalogue->titre }}</a>
                                        </h3>
                                        @if($item->catalogue->auteur)
                                            <p class="cart-item-author">
                                                <i class="fas fa-pen-fancy"></i>{{ $item->catalogue->auteur }}
                                            </p>
                                        @endif
                                        <div class="cart-item-meta">
                                            @if($item->catalogue->quantite > 5)
                                                <span class="cart-item-badge in-stock">
                                                    <i class="fas fa-check-circle"></i>En stock
                                                </span>
                                            @elseif($item->catalogue->quantite > 0)
                                                <span class="cart-item-badge low-stock">
                                                    <i class="fas fa-exclamation-circle"></i>Stock limité ({{ $item->catalogue->quantite }})
                                                </span>
                                            @endif
                                            @if($item->catalogue->categorie)
                                                <span class="cart-item-badge">
                                                    <i class="fas fa-tag"></i>{{ $item->catalogue->categorie->nom ?? 'Livre' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="cart-item-price">
                                        <div class="cart-item-unit-price">{{ fcfa($item->catalogue->prix) }} / unité</div>
                                        <div class="cart-item-total-price">{{ fcfa($item->catalogue->prix * $item->quantite) }}</div>
                                    </div>
                                </div>

                                <div class="cart-item-bottom">
                                    <!-- Quantity Selector -->
                                    <div class="quantity-selector">
                                        <label>Quantité:</label>
                                        <form method="POST" action="{{ route('panier.modifier', $item->id) }}" class="quantity-form">
                                            @csrf
                                            <div class="quantity-controls">
                                                <button type="button" class="qty-btn qty-minus" {{ $item->quantite <= 1 ? 'disabled' : '' }}>
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <input type="number" name="quantite" value="{{ $item->quantite }}"
                                                       min="1" max="{{ $item->catalogue->quantite }}"
                                                       class="qty-input" data-item-id="{{ $item->id }}"
                                                       data-price="{{ $item->catalogue->prix }}">
                                                <button type="button" class="qty-btn qty-plus" {{ $item->quantite >= $item->catalogue->quantite ? 'disabled' : '' }}>
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>

                                    <!-- Remove Button -->
                                    <form method="POST" action="{{ route('panier.supprimer', $item->id) }}" class="remove-form" id="removeForm-{{ $item->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="remove-item-btn" onclick="confirmRemoveItem({{ $item->id }}, '{{ addslashes($item->catalogue->titre) }}')">
                                            <i class="fas fa-trash"></i>
                                            Retirer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
                <div class="summary-header">
                    <h3>
                        <i class="fas fa-receipt"></i>
                        Récapitulatif
                    </h3>
                </div>

                <div class="summary-body">
                    <div class="summary-line">
                        <span class="label">
                            <i class="fas fa-shopping-bag"></i>
                            Sous-total ({{ $items->count() }} {{ $items->count() > 1 ? 'articles' : 'article' }})
                        </span>
                        <span class="value" id="subtotal">{{ fcfa($subtotal) }}</span>
                    </div>

                    <div class="summary-line total">
                        <span class="label">Total</span>
                        <span class="value" id="total">{{ fcfa($total) }}</span>
                    </div>

                    <!-- Code Promo -->
                    <div class="promo-section">
                        <div class="promo-toggle" onclick="togglePromo()">
                            <i class="fas fa-chevron-down"></i>
                            <span>Ajouter un code promo</span>
                        </div>
                        <div class="promo-input-group" id="promoInputGroup">
                            <input type="text" placeholder="Code promo" id="promoCode">
                            <button type="button" onclick="applyPromo()">Appliquer</button>
                        </div>
                    </div>
                </div>

                <div class="summary-footer">
                    <a href="{{ route('paiement.show') }}" class="btn-checkout">
                        <i class="fas fa-lock"></i>
                        Passer la commande
                        <i class="fas fa-arrow-right"></i>
                    </a>

                    <!-- Trust Badges -->
                    <div class="trust-badges">
                        <div class="trust-badge">
                            <i class="fas fa-shield-alt"></i>
                            <span>Paiement<br>sécurisé</span>
                        </div>
                        <div class="trust-badge">
                            <i class="fas fa-undo"></i>
                            <span>Retour<br>facile</span>
                        </div>
                        <div class="trust-badge">
                            <i class="fas fa-headset"></i>
                            <span>Support<br>24/7</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recommendations -->
        <div class="recommendations">
            <div class="recommendations-header">
                <h3>
                    <i class="fas fa-lightbulb"></i>
                    Vous pourriez aussi aimer
                </h3>
                <a href="{{ route('catalogue.index') }}">
                    <span>Voir le catalogue</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
            <div class="recommendations-grid">
                @php
                    // Récupérer des livres recommandés (à adapter selon votre logique)
                    $recommendations = \App\Models\Catalogue::where('quantite', '>', 0)
                        ->whereNotIn('id', $items->pluck('catalogue_id'))
                        ->inRandomOrder()
                        ->limit(4)
                        ->get();
                @endphp

                @foreach($recommendations as $book)
                    <div class="recommend-card">
                        <div class="recommend-card-image">
                            @if($book->image)
                                <img src="{{ asset($book->image) }}" alt="{{ $book->titre }}">
                            @else
                                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--bg-soft);">
                                    <i class="fas fa-book" style="font-size:2rem;color:#c1c1c1;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="recommend-card-body">
                            <h4 class="recommend-card-title">
                                <a href="{{ route('catalogue.show', $book) }}">{{ $book->titre }}</a>
                            </h4>
                            @if($book->auteur)
                                <p class="recommend-card-author">{{ $book->auteur }}</p>
                            @endif
                            <div class="recommend-card-footer">
                                <div class="recommend-card-price">{{ fcfa($book->prix) }}</div>
                                <form method="POST" action="{{ route('panier.ajouter') }}" class="recommend-add-form">
                                    @csrf
                                    <input type="hidden" name="catalogue_id" value="{{ $book->id }}">
                                    <input type="hidden" name="quantite" value="1">
                                    <button type="submit" class="recommend-add-btn" title="Ajouter au panier">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="removeItemModal" tabindex="-1" aria-labelledby="removeItemModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: var(--radius-lg); overflow: hidden;">
            <div class="modal-body p-0">
                <!-- Header avec icône -->
                <div style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); padding: 2rem; text-align: center;">
                    <div style="width: 70px; height: 70px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                        <i class="fas fa-trash-alt" style="font-size: 1.75rem; color: white;"></i>
                    </div>
                </div>

                <!-- Contenu -->
                <div style="padding: 1.5rem; text-align: center;">
                    <h4 style="font-size: 1.25rem; font-weight: 700; color: #2d3436; margin-bottom: 0.75rem;">Retirer cet article ?</h4>
                    <p style="color: #636e72; font-size: 0.9rem; margin-bottom: 0.5rem;">
                        Vous êtes sur le point de retirer :
                    </p>
                    <p id="removeItemTitle" style="color: #2d3436; font-weight: 600; font-size: 1rem; margin-bottom: 1.5rem; padding: 0.75rem; background: #f8f9fa; border-radius: 0.5rem;"></p>

                    <div style="display: flex; gap: 0.75rem; justify-content: center;">
                        <button type="button" class="btn" data-bs-dismiss="modal" style="padding: 0.75rem 1.5rem; background: #f1f3f4; color: #2d3436; border: none; border-radius: 0.5rem; font-weight: 500; transition: all 0.3s ease;">
                            <i class="fas fa-times me-2"></i>Annuler
                        </button>
                        <button type="button" id="confirmRemoveBtn" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 0.5rem; font-weight: 500; transition: all 0.3s ease; cursor: pointer;">
                            <i class="fas fa-trash me-2"></i>Retirer
                        </button>
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
    // Quantity controls
    document.querySelectorAll('.quantity-controls').forEach(function(control) {
        const minusBtn = control.querySelector('.qty-minus');
        const plusBtn = control.querySelector('.qty-plus');
        const input = control.querySelector('.qty-input');
        const form = control.closest('form');

        if (minusBtn) {
            minusBtn.addEventListener('click', function() {
                let value = parseInt(input.value);
                if (value > 1) {
                    input.value = value - 1;
                    updateQuantity(form, input);
                }
            });
        }

        if (plusBtn) {
            plusBtn.addEventListener('click', function() {
                let value = parseInt(input.value);
                let max = parseInt(input.getAttribute('max'));
                if (value < max) {
                    input.value = value + 1;
                    updateQuantity(form, input);
                }
            });
        }

        input.addEventListener('change', function() {
            updateQuantity(form, input);
        });
    });

    function updateQuantity(form, input) {
        const cartItem = form.closest('.cart-item');
        cartItem.classList.add('updating');

        // Soumettre le formulaire
        form.submit();
    }
});

// Toggle promo code
function togglePromo() {
    const toggle = document.querySelector('.promo-toggle');
    const inputGroup = document.getElementById('promoInputGroup');
    toggle.classList.toggle('active');
    inputGroup.classList.toggle('show');
}

// Apply promo code
function applyPromo() {
    const code = document.getElementById('promoCode').value;
    if (code.trim() === '') {
        alert('Veuillez entrer un code promo');
        return;
    }
    // Ici vous pouvez ajouter la logique AJAX pour vérifier le code promo
    alert('Fonctionnalité bientôt disponible');
}

// Modal de confirmation de suppression
let currentRemoveItemId = null;

function confirmRemoveItem(itemId, itemTitle) {
    currentRemoveItemId = itemId;
    document.getElementById('removeItemTitle').textContent = itemTitle;

    const modal = new bootstrap.Modal(document.getElementById('removeItemModal'));
    modal.show();
}

// Gestionnaire du bouton de confirmation
document.getElementById('confirmRemoveBtn')?.addEventListener('click', function() {
    if (currentRemoveItemId) {
        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Suppression...';

        document.getElementById('removeForm-' + currentRemoveItemId).submit();
    }
});

// Réinitialiser quand la modale se ferme
document.getElementById('removeItemModal')?.addEventListener('hidden.bs.modal', function() {
    currentRemoveItemId = null;
    const btn = document.getElementById('confirmRemoveBtn');
    if (btn) {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-trash me-2"></i>Retirer';
    }
});

// Ajout au panier depuis les recommandations (avec feedback visuel)
document.querySelectorAll('.recommend-add-form').forEach(function(form) {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = form.querySelector('.recommend-add-btn');
        const originalIcon = btn.innerHTML;

        // Animation de chargement
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btn.disabled = true;

        // Soumettre via AJAX
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                // Succès - afficher le check
                btn.classList.add('added');
                btn.innerHTML = '<i class="fas fa-check"></i>';

                // Après 1.5s, recharger la page pour mettre à jour le panier
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Erreur - remettre l'icône originale
                btn.innerHTML = originalIcon;
                btn.disabled = false;
                alert('Erreur lors de l\'ajout au panier');
            }
        })
        .catch(error => {
            btn.innerHTML = originalIcon;
            btn.disabled = false;
            alert('Erreur lors de l\'ajout au panier');
        });
    });
});
</script>
@endpush
