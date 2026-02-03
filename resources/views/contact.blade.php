@extends('layouts.app')

@section('title', 'Contact | Colibri Littéraire - Nous contacter')
@section('meta_description', "Contactez Colibri Littéraire pour toute demande d'information, partenariat ou suggestion. Formulaire de contact et coordonnées.")
@section('meta_keywords', 'contact, formulaire, informations, partenariat, Colibri Littéraire, livre africain, culture, édition, francophonie')

@push('styles')
<style>
    :root {
        --contact-primary: #1e7a2f;
        --contact-primary-dark: #155a22;
        --contact-primary-light: #e8f5e9;
        --contact-secondary: #f39c12;
        --contact-text: #2d3436;
        --contact-text-muted: #636e72;
        --contact-bg: #f8faf9;
        --contact-card: #ffffff;
        --contact-border: #e9ecef;
        --contact-radius: 16px;
        --contact-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --contact-shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
    }

    .contact-page {
        background: var(--contact-bg);
        min-height: 100vh;
    }

    /* ============================================
       HERO SECTION
       ============================================ */
    .contact-hero {
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
        padding: 3rem 0 4rem;
        position: relative;
        overflow: hidden;
    }

    .contact-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: patternMove 30s linear infinite;
    }

    @keyframes patternMove {
        0% { background-position: 0 0; }
        100% { background-position: 60px 60px; }
    }

    .contact-hero-content {
        position: relative;
        z-index: 2;
    }

    .contact-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .contact-breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s;
    }

    .contact-breadcrumb a:hover {
        color: white;
    }

    .contact-breadcrumb i {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.7rem;
    }

    .contact-breadcrumb span {
        color: white;
        font-weight: 500;
    }

    .contact-hero-main {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2rem;
    }

    .contact-hero-text h1 {
        color: white;
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .contact-hero-text h1 i {
        font-size: 2rem;
    }

    .contact-hero-text p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        margin: 0;
        max-width: 500px;
    }

    .contact-hero-stats {
        display: flex;
        gap: 2rem;
    }

    .hero-stat {
        text-align: center;
        padding: 1rem 1.5rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .hero-stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: white;
        display: block;
    }

    .hero-stat-label {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* ============================================
       MAIN CONTENT
       ============================================ */
    .contact-main {
        padding: 3rem 0 4rem;
        margin-top: -2rem;
    }

    .contact-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 2rem;
    }

    /* ============================================
       LEFT COLUMN - INFO CARDS
       ============================================ */
    .contact-info-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Quick Contact Cards */
    .quick-contact-card {
        background: var(--contact-card);
        border-radius: var(--contact-radius);
        box-shadow: var(--contact-shadow);
        padding: 1.5rem;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .quick-contact-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--contact-shadow-hover);
        border-color: var(--contact-primary-light);
    }

    .quick-contact-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .quick-contact-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }

    .quick-contact-icon.phone {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
        color: white;
    }

    .quick-contact-icon.whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);
        color: white;
    }

    .quick-contact-icon.email {
        background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
        color: white;
    }

    .quick-contact-icon.location {
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
        color: white;
    }

    .quick-contact-title {
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--contact-text);
        margin: 0;
    }

    .quick-contact-subtitle {
        font-size: 0.85rem;
        color: var(--contact-text-muted);
        margin: 0;
    }

    .quick-contact-body {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .contact-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.2s;
    }

    .contact-row:hover {
        background: var(--contact-primary-light);
    }

    .contact-row-info {
        display: flex;
        flex-direction: column;
    }

    .contact-row-label {
        font-size: 0.75rem;
        color: var(--contact-text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .contact-row-value {
        font-weight: 600;
        color: var(--contact-text);
        font-size: 0.95rem;
    }

    .contact-row-actions {
        display: flex;
        gap: 0.5rem;
    }

    .contact-action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .contact-action-btn.call {
        background: var(--contact-primary);
        color: white;
    }

    .contact-action-btn.call:hover {
        background: var(--contact-primary-dark);
        transform: scale(1.1);
    }

    .contact-action-btn.copy {
        background: #e9ecef;
        color: var(--contact-text-muted);
    }

    .contact-action-btn.copy:hover {
        background: #dee2e6;
        color: var(--contact-text);
    }

    .contact-action-btn.whatsapp {
        background: #25D366;
        color: white;
    }

    .contact-action-btn.whatsapp:hover {
        background: #128C7E;
        transform: scale(1.1);
    }

    .contact-action-btn.email-btn {
        background: #e74c3c;
        color: white;
    }

    .contact-action-btn.email-btn:hover {
        background: #c0392b;
        transform: scale(1.1);
    }

    /* Response Time Badge */
    .response-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.35rem 0.75rem;
        background: var(--contact-primary-light);
        color: var(--contact-primary);
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .response-badge i {
        font-size: 0.7rem;
    }

    /* Map Card */
    .map-card {
        background: var(--contact-card);
        border-radius: var(--contact-radius);
        box-shadow: var(--contact-shadow);
        overflow: hidden;
    }

    .map-card-header {
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .map-card-header i {
        font-size: 1.25rem;
    }

    .map-card-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
    }

    .map-container {
        height: 200px;
    }

    .map-container iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    .map-address {
        padding: 1rem 1.5rem;
        background: #f8f9fa;
        font-size: 0.9rem;
        color: var(--contact-text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .map-address i {
        color: var(--contact-primary);
    }

    /* ============================================
       RIGHT COLUMN - FORM
       ============================================ */
    .contact-form-section {
        background: var(--contact-card);
        border-radius: var(--contact-radius);
        box-shadow: var(--contact-shadow);
        overflow: hidden;
    }

    .form-header {
        padding: 1.75rem 2rem;
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .form-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-header-icon {
        width: 55px;
        height: 55px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .form-header-text h2 {
        font-size: 1.35rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
    }

    .form-header-text p {
        font-size: 0.9rem;
        opacity: 0.9;
        margin: 0;
    }

    .form-body {
        padding: 2rem;
    }

    /* Subject Selector */
    .subject-selector {
        margin-bottom: 1.5rem;
    }

    .subject-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--contact-text);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .subject-label i {
        color: var(--contact-primary);
    }

    .subject-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
    }

    .subject-option {
        position: relative;
    }

    .subject-option input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .subject-option label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
        color: var(--contact-text-muted);
    }

    .subject-option label i {
        font-size: 1rem;
    }

    .subject-option input:checked + label {
        background: var(--contact-primary-light);
        border-color: var(--contact-primary);
        color: var(--contact-primary);
        font-weight: 600;
    }

    .subject-option label:hover {
        border-color: var(--contact-primary);
        background: var(--contact-primary-light);
    }

    /* Form Groups */
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-group label {
        font-weight: 600;
        font-size: 0.9rem;
        color: var(--contact-text);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-group label i {
        color: var(--contact-primary);
        font-size: 0.85rem;
    }

    .form-group label .required {
        color: #e74c3c;
        font-size: 0.8rem;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: #fafbfc;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--contact-primary);
        box-shadow: 0 0 0 4px var(--contact-primary-light);
        background: white;
    }

    .form-control::placeholder {
        color: #adb5bd;
    }

    .form-control.is-invalid {
        border-color: #e74c3c;
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 0.8rem;
        margin-top: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    textarea.form-control {
        min-height: 150px;
        resize: vertical;
    }

    /* Character Counter */
    .char-counter {
        text-align: right;
        font-size: 0.75rem;
        color: var(--contact-text-muted);
        margin-top: 0.35rem;
    }

    .char-counter.warning {
        color: var(--contact-secondary);
    }

    .char-counter.danger {
        color: #e74c3c;
    }

    /* Submit Button */
    .form-submit {
        margin-top: 1.5rem;
    }

    .btn-submit {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 122, 47, 0.4);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit i {
        font-size: 1.1rem;
        transition: transform 0.3s;
    }

    .btn-submit:hover i {
        transform: translateX(5px);
    }

    .btn-submit.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .btn-submit.loading .btn-text {
        display: none;
    }

    .btn-submit .spinner {
        display: none;
    }

    .btn-submit.loading .spinner {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Form Footer */
    .form-footer {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid #e9ecef;
        text-align: center;
    }

    .form-footer p {
        color: var(--contact-text-muted);
        font-size: 0.85rem;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .form-footer i {
        color: var(--contact-primary);
    }

    /* ============================================
       FAQ SECTION
       ============================================ */
    .faq-section {
        margin-top: 3rem;
    }

    .faq-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .faq-header h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--contact-text);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .faq-header h2 i {
        color: var(--contact-primary);
    }

    .faq-header p {
        color: var(--contact-text-muted);
        font-size: 1rem;
        margin: 0;
    }

    .faq-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .faq-card {
        background: var(--contact-card);
        border-radius: var(--contact-radius);
        box-shadow: var(--contact-shadow);
        padding: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .faq-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--contact-shadow-hover);
    }

    .faq-question {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        font-weight: 600;
        color: var(--contact-text);
        margin-bottom: 0.75rem;
    }

    .faq-question i {
        color: var(--contact-primary);
        margin-top: 0.1rem;
    }

    .faq-answer {
        color: var(--contact-text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        padding-left: 1.75rem;
    }

    /* ============================================
       TOAST NOTIFICATION
       ============================================ */
    .toast-notification {
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: var(--contact-text);
        color: white;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        z-index: 9999;
        transform: translateY(100px);
        opacity: 0;
        transition: all 0.3s ease;
    }

    .toast-notification.show {
        transform: translateY(0);
        opacity: 1;
    }

    .toast-notification.success {
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
    }

    .toast-notification i {
        font-size: 1.25rem;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 991px) {
        .contact-grid {
            grid-template-columns: 1fr;
        }

        .contact-hero-main {
            flex-direction: column;
            text-align: center;
        }

        .contact-hero-text p {
            margin: 0 auto;
        }

        .contact-hero-stats {
            justify-content: center;
        }

        .faq-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 767px) {
        .contact-hero {
            padding: 2rem 0 3rem;
        }

        .contact-hero-text h1 {
            font-size: 1.75rem;
        }

        .contact-hero-text h1 i {
            font-size: 1.5rem;
        }

        .contact-hero-text p {
            font-size: 0.95rem;
        }

        .contact-hero-stats {
            flex-wrap: wrap;
            gap: 1rem;
        }

        .hero-stat {
            padding: 0.75rem 1rem;
        }

        .hero-stat-value {
            font-size: 1.25rem;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .subject-options {
            grid-template-columns: 1fr;
        }

        .contact-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .contact-row-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .form-header {
            padding: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }
    }

    @media (max-width: 575px) {
        .contact-main {
            padding: 2rem 0 3rem;
        }

        .quick-contact-header {
            flex-direction: column;
            text-align: center;
        }

        .faq-header h2 {
            font-size: 1.35rem;
        }
    }

    /* Success Alert */
    .alert-success-custom {
        background: linear-gradient(135deg, var(--contact-primary-light) 0%, #d4edda 100%);
        border: none;
        border-left: 4px solid var(--contact-primary);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .alert-success-custom i {
        font-size: 1.5rem;
        color: var(--contact-primary);
    }

    .alert-success-custom .alert-content h4 {
        color: var(--contact-primary-dark);
        font-weight: 700;
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
    }

    .alert-success-custom .alert-content p {
        color: var(--contact-text);
        margin: 0;
        font-size: 0.9rem;
    }

    /* ============================================
       VALIDATION MODAL
       ============================================ */
    .validation-modal {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
    }

    .validation-modal-header {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        padding: 2rem;
        display: flex;
        justify-content: center;
    }

    .validation-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: iconPulse 2s ease-in-out infinite;
    }

    .validation-icon i {
        font-size: 2.5rem;
        color: white;
    }

    @keyframes iconPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .validation-modal-body {
        padding: 2rem;
        text-align: center;
    }

    .validation-modal-body h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--contact-text);
        margin: 0 0 0.75rem 0;
    }

    .validation-modal-body > p {
        color: var(--contact-text-muted);
        font-size: 1rem;
        margin: 0 0 1.5rem 0;
    }

    .validation-info {
        background: #fff8e6;
        border: 1px solid #f39c12;
        border-radius: 12px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        text-align: left;
    }

    .validation-info i {
        color: #f39c12;
        font-size: 1.1rem;
        margin-top: 0.1rem;
    }

    .validation-info span {
        color: #856404;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .validation-modal-footer {
        padding: 0 2rem 2rem;
    }

    .btn-validation-close {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
    }

    .btn-validation-close:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
    }

    .btn-validation-close i {
        font-size: 1.1rem;
    }

    /* ============================================
       SUCCESS MODAL
       ============================================ */
    .success-modal-contact {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
    }

    .success-modal-header {
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
        padding: 2.5rem 2rem;
        display: flex;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .success-modal-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .success-icon-wrapper {
        position: relative;
        z-index: 2;
    }

    .success-icon {
        width: 90px;
        height: 90px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        animation: successBounce 0.6s ease;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .success-icon i {
        font-size: 2.5rem;
        color: var(--contact-primary);
    }

    @keyframes successBounce {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    .success-confetti {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }

    .success-confetti span {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        animation: confettiPop 0.8s ease forwards;
    }

    .success-confetti span:nth-child(1) { background: #f39c12; animation-delay: 0.1s; }
    .success-confetti span:nth-child(2) { background: #e74c3c; animation-delay: 0.2s; }
    .success-confetti span:nth-child(3) { background: #3498db; animation-delay: 0.15s; }
    .success-confetti span:nth-child(4) { background: #9b59b6; animation-delay: 0.25s; }
    .success-confetti span:nth-child(5) { background: #1abc9c; animation-delay: 0.3s; }

    @keyframes confettiPop {
        0% { transform: translate(0, 0) scale(0); opacity: 1; }
        100% { transform: translate(var(--x, 50px), var(--y, -50px)) scale(1); opacity: 0; }
    }

    .success-confetti span:nth-child(1) { --x: -60px; --y: -40px; }
    .success-confetti span:nth-child(2) { --x: 60px; --y: -50px; }
    .success-confetti span:nth-child(3) { --x: -40px; --y: 30px; }
    .success-confetti span:nth-child(4) { --x: 50px; --y: 40px; }
    .success-confetti span:nth-child(5) { --x: 0px; --y: -70px; }

    .success-modal-body {
        padding: 2rem;
        text-align: center;
    }

    .success-modal-body h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--contact-text);
        margin: 0 0 0.75rem 0;
    }

    .success-modal-body > p {
        color: var(--contact-text-muted);
        font-size: 1rem;
        margin: 0 0 1.5rem 0;
        line-height: 1.6;
    }

    .success-info {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .success-info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--contact-primary-light);
        padding: 0.6rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        color: var(--contact-primary-dark);
        font-weight: 500;
    }

    .success-info-item i {
        color: var(--contact-primary);
    }

    .success-modal-footer {
        padding: 0 2rem 2rem;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-success-close {
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--contact-primary) 0%, var(--contact-primary-dark) 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-success-close:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 122, 47, 0.4);
    }

    .btn-success-home {
        width: 100%;
        padding: 0.875rem 2rem;
        background: transparent;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        color: var(--contact-text-muted);
        font-weight: 500;
        font-size: 0.95rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-success-home:hover {
        border-color: var(--contact-primary);
        color: var(--contact-primary);
        background: var(--contact-primary-light);
    }
</style>
@endpush

@section('content')
<div class="contact-page">
    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="container">
            <div class="contact-hero-content">
                <nav class="contact-breadcrumb">
                    <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                    <i class="fa fa-chevron-right"></i>
                    <span>Contact</span>
                </nav>

                <div class="contact-hero-main">
                    <div class="contact-hero-text">
                        <h1>
                            <i class="fa fa-paper-plane"></i>
                            Contactez-nous
                        </h1>
                        <p>Une question ? Une suggestion ? Nous sommes là pour vous aider et répondre à toutes vos demandes.</p>
                    </div>

                    <div class="contact-hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-value">< 24h</span>
                            <span class="hero-stat-label">Réponse email</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-value">2</span>
                            <span class="hero-stat-label">Pays couverts</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-value">98%</span>
                            <span class="hero-stat-label">Satisfaction</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="contact-main">
        <div class="container">
            {{-- Success modal will be shown via JavaScript if session has success --}}

            <div class="contact-grid">
                <!-- Left Column - Contact Info -->
                <div class="contact-info-section">
                    <!-- Phone Card -->
                    <div class="quick-contact-card">
                        <div class="quick-contact-header">
                            <div class="quick-contact-icon phone">
                                <i class="fa fa-phone-alt"></i>
                            </div>
                            <div>
                                <h3 class="quick-contact-title">Appelez-nous</h3>
                                <p class="quick-contact-subtitle">Disponible du lundi au vendredi</p>
                            </div>
                        </div>
                        <div class="quick-contact-body">
                            <div class="contact-row">
                                <div class="contact-row-info">
                                    <span class="contact-row-label">France</span>
                                    <span class="contact-row-value" id="phone-fr">+33 7 46 52 61 63</span>
                                </div>
                                <div class="contact-row-actions">
                                    <a href="tel:+33746526163" class="contact-action-btn call" title="Appeler">
                                        <i class="fa fa-phone"></i>
                                    </a>
                                    <button class="contact-action-btn copy" onclick="copyToClipboard('phone-fr')" title="Copier">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="contact-row">
                                <div class="contact-row-info">
                                    <span class="contact-row-label">Bénin</span>
                                    <span class="contact-row-value" id="phone-bj">+229 01 66 54 78 08</span>
                                </div>
                                <div class="contact-row-actions">
                                    <a href="tel:+2290166547808" class="contact-action-btn call" title="Appeler">
                                        <i class="fa fa-phone"></i>
                                    </a>
                                    <button class="contact-action-btn copy" onclick="copyToClipboard('phone-bj')" title="Copier">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="response-badge">
                                <i class="fa fa-clock"></i>
                                9h - 18h (heure locale)
                            </div>
                        </div>
                    </div>

                    <!-- WhatsApp Card -->
                    <div class="quick-contact-card">
                        <div class="quick-contact-header">
                            <div class="quick-contact-icon whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <h3 class="quick-contact-title">WhatsApp</h3>
                                <p class="quick-contact-subtitle">Réponse rapide garantie</p>
                            </div>
                        </div>
                        <div class="quick-contact-body">
                            <div class="contact-row">
                                <div class="contact-row-info">
                                    <span class="contact-row-label">France</span>
                                    <span class="contact-row-value">Démarrer une conversation</span>
                                </div>
                                <div class="contact-row-actions">
                                    <a href="https://wa.me/33746526163" target="_blank" rel="noopener" class="contact-action-btn whatsapp" title="WhatsApp France">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="contact-row">
                                <div class="contact-row-info">
                                    <span class="contact-row-label">Bénin</span>
                                    <span class="contact-row-value">Démarrer une conversation</span>
                                </div>
                                <div class="contact-row-actions">
                                    <a href="https://wa.me/2290166547808" target="_blank" rel="noopener" class="contact-action-btn whatsapp" title="WhatsApp Bénin">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="response-badge">
                                <i class="fa fa-bolt"></i>
                                Réponse sous 2h en moyenne
                            </div>
                        </div>
                    </div>

                    <!-- Email Card -->
                    <div class="quick-contact-card">
                        <div class="quick-contact-header">
                            <div class="quick-contact-icon email">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div>
                                <h3 class="quick-contact-title">Email</h3>
                                <p class="quick-contact-subtitle">Pour les demandes détaillées</p>
                            </div>
                        </div>
                        <div class="quick-contact-body">
                            <div class="contact-row">
                                <div class="contact-row-info">
                                    <span class="contact-row-label">Email principal</span>
                                    <span class="contact-row-value" id="email">colibrilitteraire@gmail.com</span>
                                </div>
                                <div class="contact-row-actions">
                                    <a href="mailto:colibrilitteraire@gmail.com" class="contact-action-btn email-btn" title="Envoyer un email">
                                        <i class="fa fa-paper-plane"></i>
                                    </a>
                                    <button class="contact-action-btn copy" onclick="copyToClipboard('email')" title="Copier">
                                        <i class="fa fa-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="response-badge">
                                <i class="fa fa-check"></i>
                                Réponse sous 24h
                            </div>
                        </div>
                    </div>

                    <!-- Map Card -->
                    <div class="map-card">
                        <div class="map-card-header">
                            <i class="fa fa-map-marker-alt"></i>
                            <h3>Notre localisation</h3>
                        </div>
                        <div class="map-container">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.726027964635!2d2.420964314800964!3d6.370292995404027!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x102354f7e2e2e2e3%3A0x2e2e2e2e2e2e2e2e!2sCotonou%2C%20B%C3%A9nin!5e0!3m2!1sfr!2sbj!4v1603794290143!5m2!1sfr!2sbj"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <div class="map-address">
                            <i class="fa fa-location-dot"></i>
                            Cotonou, Bénin
                        </div>
                    </div>
                </div>

                <!-- Right Column - Form -->
                <div class="contact-form-section">
                    <div class="form-header">
                        <div class="form-header-content">
                            <div class="form-header-icon">
                                <i class="fa fa-edit"></i>
                            </div>
                            <div class="form-header-text">
                                <h2>Envoyez-nous un message</h2>
                                <p>Nous vous répondrons dans les plus brefs délais</p>
                            </div>
                        </div>
                    </div>

                    <div class="form-body">
                        <form method="POST" action="{{ route('contact.store') }}" id="contactForm">
                            @csrf

                            <!-- Subject Selector -->
                            <div class="subject-selector">
                                <label class="subject-label">
                                    <i class="fa fa-tag"></i>
                                    Sujet de votre message
                                </label>
                                <div class="subject-options">
                                    <div class="subject-option">
                                        <input type="radio" id="subject-info" name="subject" value="Demande d'information" {{ old('subject') == "Demande d'information" ? 'checked' : '' }}>
                                        <label for="subject-info">
                                            <i class="fa fa-info-circle"></i>
                                            Information
                                        </label>
                                    </div>
                                    <div class="subject-option">
                                        <input type="radio" id="subject-order" name="subject" value="Question sur une commande" {{ old('subject') == "Question sur une commande" ? 'checked' : '' }}>
                                        <label for="subject-order">
                                            <i class="fa fa-shopping-bag"></i>
                                            Commande
                                        </label>
                                    </div>
                                    <div class="subject-option">
                                        <input type="radio" id="subject-partner" name="subject" value="Partenariat" {{ old('subject') == "Partenariat" ? 'checked' : '' }}>
                                        <label for="subject-partner">
                                            <i class="fa fa-handshake"></i>
                                            Partenariat
                                        </label>
                                    </div>
                                    <div class="subject-option">
                                        <input type="radio" id="subject-other" name="subject" value="Autre" {{ old('subject', 'Autre') == "Autre" ? 'checked' : '' }}>
                                        <label for="subject-other">
                                            <i class="fa fa-ellipsis-h"></i>
                                            Autre
                                        </label>
                                    </div>
                                </div>
                                @error('subject')
                                    <div class="invalid-feedback d-block">
                                        <i class="fa fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Name & Email -->
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fa fa-user"></i>
                                        Votre nom
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        id="name"
                                        name="name"
                                        value="{{ old('name', Auth::user()->name ?? '') }}"
                                        placeholder="Ex: Jean Dupont"
                                        required
                                    >
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fa fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label for="email">
                                        <i class="fa fa-envelope"></i>
                                        Votre email
                                        <span class="required">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        id="email-input"
                                        name="email"
                                        value="{{ old('email', Auth::user()->email ?? '') }}"
                                        placeholder="Ex: jean@exemple.com"
                                        required
                                    >
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fa fa-exclamation-circle"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="form-group">
                                <label for="message">
                                    <i class="fa fa-comment-alt"></i>
                                    Votre message
                                    <span class="required">*</span>
                                </label>
                                <textarea
                                    class="form-control @error('message') is-invalid @enderror"
                                    id="message"
                                    name="message"
                                    rows="5"
                                    placeholder="Décrivez votre demande en détail..."
                                    required
                                    maxlength="2000"
                                >{{ old('message') }}</textarea>
                                <div class="char-counter">
                                    <span id="charCount">0</span>/2000 caractères
                                </div>
                                @error('message')
                                    <div class="invalid-feedback">
                                        <i class="fa fa-exclamation-circle"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <div class="form-submit">
                                <button type="submit" class="btn-submit" id="submitBtn">
                                    <span class="btn-text">
                                        Envoyer mon message
                                        <i class="fa fa-arrow-right"></i>
                                    </span>
                                    <span class="spinner">
                                        <i class="fa fa-spinner fa-spin"></i>
                                        Envoi en cours...
                                    </span>
                                </button>
                            </div>

                            <div class="form-footer">
                                <p>
                                    <i class="fa fa-shield-alt"></i>
                                    Vos données sont sécurisées et ne seront jamais partagées
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="faq-section">
                <div class="faq-header">
                    <h2>
                        <i class="fa fa-question-circle"></i>
                        Questions fréquentes
                    </h2>
                    <p>Trouvez rapidement les réponses à vos questions</p>
                </div>

                <div class="faq-grid">
                    <div class="faq-card">
                        <div class="faq-question">
                            <i class="fa fa-truck"></i>
                            <span>Quels sont les délais de livraison ?</span>
                        </div>
                        <p class="faq-answer">
                            Les délais varient selon votre localisation. En général, comptez 3-5 jours ouvrés pour le Bénin et 7-14 jours pour l'international.
                        </p>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question">
                            <i class="fa fa-credit-card"></i>
                            <span>Quels modes de paiement acceptez-vous ?</span>
                        </div>
                        <p class="faq-answer">
                            Nous acceptons les paiements via Mobile Money, cartes bancaires, et le paiement à la livraison pour certaines zones.
                        </p>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question">
                            <i class="fa fa-undo"></i>
                            <span>Puis-je retourner un article ?</span>
                        </div>
                        <p class="faq-answer">
                            Oui, vous disposez de 14 jours après réception pour retourner un article en parfait état. Contactez-nous pour la procédure.
                        </p>
                    </div>

                    <div class="faq-card">
                        <div class="faq-question">
                            <i class="fa fa-book"></i>
                            <span>Comment commander un livre non disponible ?</span>
                        </div>
                        <p class="faq-answer">
                            Utilisez notre formulaire de contact ou WhatsApp pour nous faire part de votre demande. Nous ferons notre possible pour vous l'obtenir.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div class="toast-notification" id="toastNotification">
    <i class="fa fa-check-circle"></i>
    <span id="toastMessage">Copié dans le presse-papier !</span>
</div>

<!-- Modal Validation -->
<div class="modal fade" id="validationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content validation-modal">
            <div class="validation-modal-header">
                <div class="validation-icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="validation-modal-body">
                <h3>Message trop court</h3>
                <p id="validationMessage">Le message doit contenir au moins 10 caractères.</p>
                <div class="validation-info">
                    <i class="fa fa-info-circle"></i>
                    <span>Veuillez détailler votre demande pour que nous puissions mieux vous aider.</span>
                </div>
            </div>
            <div class="validation-modal-footer">
                <button type="button" class="btn-validation-close" data-bs-dismiss="modal">
                    <i class="fa fa-edit"></i>
                    Modifier mon message
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Succès -->
@if(session('success'))
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content success-modal-contact">
            <div class="success-modal-header">
                <div class="success-icon-wrapper">
                    <div class="success-icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="success-confetti">
                        <span></span><span></span><span></span><span></span><span></span>
                    </div>
                </div>
            </div>
            <div class="success-modal-body">
                <h3>Message envoyé avec succès !</h3>
                <p>{{ session('success') }}</p>
                <div class="success-info">
                    <div class="success-info-item">
                        <i class="fa fa-clock"></i>
                        <span>Réponse sous 24h</span>
                    </div>
                    <div class="success-info-item">
                        <i class="fa fa-envelope"></i>
                        <span>Vérifiez vos emails</span>
                    </div>
                </div>
            </div>
            <div class="success-modal-footer">
                <button type="button" class="btn-success-close" data-bs-dismiss="modal">
                    <i class="fa fa-thumbs-up"></i>
                    Compris, merci !
                </button>
                <a href="{{ route('index') }}" class="btn-success-home">
                    <i class="fa fa-home"></i>
                    Retour à l'accueil
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Copy to clipboard function
    function copyToClipboard(elementId) {
        const text = document.getElementById(elementId).innerText.trim();

        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showToast('Copié : ' + text);
            }).catch(() => {
                fallbackCopy(text);
            });
        } else {
            fallbackCopy(text);
        }
    }

    function fallbackCopy(text) {
        const textarea = document.createElement('textarea');
        textarea.value = text;
        textarea.style.position = 'fixed';
        textarea.style.opacity = '0';
        document.body.appendChild(textarea);
        textarea.select();
        try {
            document.execCommand('copy');
            showToast('Copié : ' + text);
        } catch (e) {
            showToast('Impossible de copier');
        }
        document.body.removeChild(textarea);
    }

    function showToast(message) {
        const toast = document.getElementById('toastNotification');
        const toastMessage = document.getElementById('toastMessage');

        toastMessage.textContent = message;
        toast.classList.add('show', 'success');

        setTimeout(() => {
            toast.classList.remove('show', 'success');
        }, 3000);
    }

    // Character counter for textarea
    const messageTextarea = document.getElementById('message');
    const charCount = document.getElementById('charCount');

    if (messageTextarea && charCount) {
        // Initial count
        charCount.textContent = messageTextarea.value.length;

        messageTextarea.addEventListener('input', function() {
            const count = this.value.length;
            charCount.textContent = count;

            const counter = charCount.parentElement;
            counter.classList.remove('warning', 'danger');

            if (count >= 1800) {
                counter.classList.add('danger');
            } else if (count >= 1500) {
                counter.classList.add('warning');
            }
        });
    }

    // Form submission with validation
    const contactForm = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');
    const validationModal = new bootstrap.Modal(document.getElementById('validationModal'));

    if (contactForm && submitBtn) {
        contactForm.addEventListener('submit', function(e) {
            const message = document.getElementById('message').value.trim();
            const minLength = 10;

            if (message.length < minLength) {
                e.preventDefault();

                // Update modal message with current count
                const remaining = minLength - message.length;
                document.getElementById('validationMessage').innerHTML =
                    `Le message doit contenir au moins <strong>${minLength} caractères</strong>.<br>` +
                    `<span style="color: #e74c3c;">Il manque encore ${remaining} caractère${remaining > 1 ? 's' : ''}.</span>`;

                validationModal.show();

                // Focus on textarea when modal closes
                document.getElementById('validationModal').addEventListener('hidden.bs.modal', function() {
                    document.getElementById('message').focus();
                }, { once: true });

                return false;
            }

            submitBtn.classList.add('loading');
        });
    }

    // Show success modal if present
    document.addEventListener('DOMContentLoaded', function() {
        const successModalEl = document.getElementById('successModal');
        if (successModalEl) {
            const successModal = new bootstrap.Modal(successModalEl);
            successModal.show();
        }
    });
</script>
@endpush
