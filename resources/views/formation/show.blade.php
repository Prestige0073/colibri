@extends('layouts.app')

@section('title', $formation->titre . ' | Colibri Littéraire')
@section('meta_description', Str::limit($formation->description, 150))
@section('meta_keywords', 'formation, ' . $formation->titre . ', livre africain, certification, apprentissage')

@push('styles')
<style>
    :root {
        --show-primary: #1e7a2f;
        --show-primary-dark: #155a22;
        --show-primary-light: #e8f5e9;
        --show-secondary: #f39c12;
        --show-accent: #3498db;
        --show-purple: #9b59b6;
        --show-red: #e74c3c;
        --show-text: #2d3436;
        --show-text-muted: #636e72;
        --show-bg: #f8faf9;
        --show-card: #ffffff;
        --show-radius: 16px;
        --show-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --show-shadow-hover: 0 12px 40px rgba(0,0,0,0.15);
    }

    .formation-show-page {
        background: var(--show-bg);
        min-height: 100vh;
    }

    /* ============================================
       HERO SECTION
       ============================================ */
    .formation-hero {
        background: linear-gradient(135deg, var(--show-primary) 0%, var(--show-primary-dark) 100%);
        padding: 3rem 0 6rem;
        position: relative;
        overflow: hidden;
    }

    .formation-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    /* Floating shapes */
    .hero-shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.1;
        animation: floatShape 8s ease-in-out infinite;
    }

    .hero-shape-1 {
        width: 300px;
        height: 300px;
        background: white;
        top: -100px;
        right: -50px;
    }

    .hero-shape-2 {
        width: 200px;
        height: 200px;
        background: var(--show-secondary);
        bottom: -80px;
        left: 5%;
        animation-delay: 2s;
    }

    @keyframes floatShape {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }

    .hero-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
    }

    .hero-breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s;
    }

    .hero-breadcrumb a:hover {
        color: white;
    }

    .hero-breadcrumb i {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.7rem;
    }

    .hero-breadcrumb span {
        color: white;
        font-weight: 500;
    }

    .hero-badges {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        padding: 0.4rem 1rem;
        border-radius: 25px;
        font-size: 0.8rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .hero-badge.category {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }

    .hero-badge.level {
        background: var(--show-secondary);
        color: white;
    }

    .hero-badge.free {
        background: #2ecc71;
        color: white;
    }

    .hero-badge.paid {
        background: white;
        color: var(--show-text);
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        line-height: 1.2;
        margin-bottom: 1rem;
        max-width: 700px;
    }

    .hero-description {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        line-height: 1.7;
        max-width: 600px;
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    /* Hero stats */
    .hero-stats {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .hero-stat {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .hero-stat-icon {
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-stat-icon i {
        color: var(--show-secondary);
        font-size: 1rem;
    }

    .hero-stat-text {
        display: flex;
        flex-direction: column;
    }

    .hero-stat-value {
        color: white;
        font-weight: 700;
        font-size: 1.1rem;
        line-height: 1.2;
    }

    .hero-stat-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
    }

    /* Hero image */
    .hero-image-container {
        position: relative;
    }

    .hero-image-wrapper {
        position: relative;
        border-radius: var(--show-radius);
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .hero-image {
        width: 100%;
        height: 320px;
        object-fit: contain;
        background: rgba(255, 255, 255, 0.05);
        padding: 0.5rem;
    }

    .hero-placeholder {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        border-radius: var(--show-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px dashed rgba(255,255,255,0.3);
    }

    .hero-placeholder i {
        font-size: 4rem;
        color: rgba(255,255,255,0.3);
    }

    /* ============================================
       MAIN CONTENT
       ============================================ */
    .formation-main {
        margin-top: -3rem;
        position: relative;
        z-index: 10;
        padding-bottom: 4rem;
    }

    /* ============================================
       FEATURES CARDS
       ============================================ */
    .features-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .feature-card {
        background: var(--show-card);
        border-radius: 14px;
        padding: 1.25rem;
        text-align: center;
        box-shadow: var(--show-shadow);
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .feature-card:hover {
        transform: translateY(-5px);
        border-color: var(--show-primary-light);
    }

    .feature-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.25rem;
    }

    .feature-card:nth-child(1) .feature-icon {
        background: linear-gradient(135deg, var(--show-primary-light) 0%, #c8e6c9 100%);
        color: var(--show-primary);
    }

    .feature-card:nth-child(2) .feature-icon {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        color: var(--show-secondary);
    }

    .feature-card:nth-child(3) .feature-icon {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        color: var(--show-accent);
    }

    .feature-card:nth-child(4) .feature-icon {
        background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%);
        color: var(--show-purple);
    }

    .feature-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--show-text);
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .feature-label {
        font-size: 0.85rem;
        color: var(--show-text-muted);
    }

    /* ============================================
       CONTENT GRID
       ============================================ */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 2rem;
        align-items: start;
    }

    /* ============================================
       LEARNING SECTION
       ============================================ */
    .section-card {
        background: var(--show-card);
        border-radius: var(--show-radius);
        box-shadow: var(--show-shadow);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .section-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-icon {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .section-icon.green {
        background: var(--show-primary-light);
        color: var(--show-primary);
    }

    .section-icon.orange {
        background: #fff3e0;
        color: var(--show-secondary);
    }

    .section-icon.blue {
        background: #e3f2fd;
        color: var(--show-accent);
    }

    .section-icon.purple {
        background: #f3e5f5;
        color: var(--show-purple);
    }

    .section-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--show-text);
        margin: 0;
    }

    .section-body {
        padding: 1.5rem;
    }

    /* Learning items */
    .learning-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .learning-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem;
        background: var(--show-bg);
        border-radius: 12px;
        transition: all 0.3s;
    }

    .learning-item:hover {
        background: var(--show-primary-light);
        transform: translateX(5px);
    }

    .learning-check {
        width: 24px;
        height: 24px;
        background: var(--show-primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .learning-check i {
        color: white;
        font-size: 0.7rem;
    }

    .learning-text {
        font-size: 0.9rem;
        color: var(--show-text);
        line-height: 1.5;
    }

    /* ============================================
       PROGRAM ACCORDION
       ============================================ */
    .program-stats {
        display: flex;
        gap: 1.5rem;
        padding: 0 1.5rem 1rem;
        flex-wrap: wrap;
    }

    .program-stat {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--show-text-muted);
    }

    .program-stat i {
        color: var(--show-primary);
    }

    .modules-accordion {
        padding: 0 1rem 1rem;
    }

    .module-item {
        border: 2px solid #f0f0f0;
        border-radius: 14px;
        margin-bottom: 0.75rem;
        overflow: hidden;
        transition: all 0.3s;
    }

    .module-item:hover {
        border-color: var(--show-primary-light);
    }

    .module-item.active {
        border-color: var(--show-primary);
        box-shadow: 0 5px 20px rgba(30, 122, 47, 0.1);
    }

    .module-header {
        display: flex;
        align-items: center;
        padding: 1rem 1.25rem;
        cursor: pointer;
        gap: 1rem;
        transition: background 0.3s;
    }

    .module-header:hover {
        background: var(--show-bg);
    }

    .module-number {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
        transition: all 0.3s;
    }

    .module-number.default {
        background: linear-gradient(135deg, var(--show-primary) 0%, var(--show-primary-dark) 100%);
        color: white;
    }

    .module-number.locked {
        background: #f0f0f0;
        color: #999;
    }

    .module-number.completed {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        color: white;
    }

    .module-number.in-progress {
        background: linear-gradient(135deg, var(--show-secondary) 0%, #e67e22 100%);
        color: white;
    }

    .module-info {
        flex: 1;
        min-width: 0;
    }

    .module-title {
        font-weight: 600;
        color: var(--show-text);
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
    }

    .module-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: var(--show-text-muted);
    }

    .module-meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .module-toggle {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: var(--show-bg);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--show-text-muted);
        transition: all 0.3s;
    }

    .module-item.active .module-toggle {
        background: var(--show-primary);
        color: white;
        transform: rotate(180deg);
    }

    .module-content {
        background: var(--show-bg);
        padding: 1rem 1.25rem;
        border-top: 1px solid #f0f0f0;
    }

    /* Lessons list */
    .lessons-list {
        background: var(--show-card);
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #f0f0f0;
    }

    .lesson-item {
        display: flex;
        align-items: center;
        padding: 0.85rem 1rem;
        gap: 0.75rem;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }

    .lesson-item:last-child {
        border-bottom: none;
    }

    .lesson-item:hover {
        background: var(--show-bg);
    }

    .lesson-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .lesson-icon.video {
        background: #fee2e2;
        color: #dc2626;
    }

    .lesson-icon.pdf {
        background: #dcfce7;
        color: #16a34a;
    }

    .lesson-icon.text {
        background: #dbeafe;
        color: #2563eb;
    }

    .lesson-icon.quiz {
        background: #fef3c7;
        color: #d97706;
    }

    .lesson-icon.locked {
        background: #f3f4f6;
        color: #9ca3af;
    }

    .lesson-title {
        flex: 1;
        font-size: 0.9rem;
        color: var(--show-text);
    }

    .lesson-duration {
        font-size: 0.8rem;
        color: var(--show-text-muted);
    }

    .lesson-status {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
    }

    .lesson-status.completed {
        background: #dcfce7;
        color: #16a34a;
    }

    /* Module CTA */
    .module-cta {
        margin-top: 0.65rem;
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .btn-module {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-module-primary {
        background: var(--show-primary);
        color: white;
    }

    .btn-module-primary:hover {
        background: var(--show-primary-dark);
        color: white;
        transform: translateY(-2px);
    }

    /* Locked overlay */
    .locked-message {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: #fff8e6;
        border: 1px solid var(--show-secondary);
        border-radius: 12px;
        margin-top: 1rem;
    }

    .locked-message i {
        color: var(--show-secondary);
        font-size: 1.25rem;
    }

    .locked-message span {
        color: #856404;
        font-size: 0.9rem;
    }

    /* ============================================
       SIDEBAR
       ============================================ */
    .sidebar-sticky {
        position: sticky;
        top: 100px;
    }

    /* CTA Card */
    .cta-card {
        background: var(--show-card);
        border-radius: var(--show-radius);
        box-shadow: var(--show-shadow);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .cta-header {
        background: linear-gradient(135deg, var(--show-primary) 0%, var(--show-primary-dark) 100%);
        padding: 1.5rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-price {
        position: relative;
        z-index: 2;
    }

    .cta-price-label {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 0.25rem;
    }

    .cta-price-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        line-height: 1;
    }

    .cta-price-value.free {
        color: var(--show-secondary);
    }

    .cta-body {
        padding: 1.5rem;
    }

    .btn-cta {
        width: 100%;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-cta-primary {
        background: linear-gradient(135deg, var(--show-primary) 0%, var(--show-primary-dark) 100%);
        color: white;
    }

    .btn-cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(30, 122, 47, 0.3);
        color: white;
    }

    .btn-cta-enrolled {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        color: white;
    }

    .btn-cta-enrolled:hover {
        color: white;
    }

    .btn-cta-pending {
        background: linear-gradient(135deg, var(--show-secondary) 0%, #e67e22 100%);
        color: white;
    }

    .cta-guarantee {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 1rem;
        padding: 0.75rem;
        background: var(--show-bg);
        border-radius: 10px;
        font-size: 0.8rem;
        color: var(--show-text-muted);
    }

    .cta-guarantee i {
        color: var(--show-primary);
    }

    /* CTA features */
    .cta-features {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 1px solid #f0f0f0;
    }

    .cta-features-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--show-text-muted);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .cta-feature {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0;
        font-size: 0.9rem;
        color: var(--show-text);
        border-bottom: 1px solid #f8f8f8;
    }

    .cta-feature:last-child {
        border-bottom: none;
    }

    .cta-feature i {
        color: var(--show-primary);
        width: 20px;
        text-align: center;
    }

    /* Progress card */
    .progress-card {
        background: linear-gradient(135deg, #2ecc71 0%, #27ae60 100%);
        border-radius: var(--show-radius);
        padding: 1.5rem;
        color: white;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .progress-card::before {
        content: '';
        position: absolute;
        top: -30%;
        right: -20%;
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
        position: relative;
        z-index: 2;
    }

    .progress-title {
        font-weight: 600;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .progress-percent {
        font-size: 1.75rem;
        font-weight: 800;
    }

    .progress-bar-custom {
        height: 10px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 0.75rem;
    }

    .progress-fill {
        height: 100%;
        background: white;
        border-radius: 5px;
        transition: width 0.5s ease;
    }

    .progress-details {
        font-size: 0.85rem;
        opacity: 0.9;
    }

    /* Info card */
    .info-card {
        background: var(--show-card);
        border-radius: var(--show-radius);
        box-shadow: var(--show-shadow);
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .info-card-header {
        padding: 1rem 1.25rem;
        background: var(--show-bg);
        border-bottom: 1px solid #f0f0f0;
        font-weight: 600;
        font-size: 0.95rem;
        color: var(--show-text);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card-header i {
        color: var(--show-primary);
    }

    .info-card-body {
        padding: 1rem 1.25rem;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0;
        border-bottom: 1px solid #f8f8f8;
        font-size: 0.9rem;
    }

    .info-row:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--show-text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-value {
        font-weight: 600;
        color: var(--show-text);
    }

    /* Social proof */
    .social-proof {
        background: var(--show-bg);
        border-radius: var(--show-radius);
        padding: 1.25rem;
    }

    .social-proof-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0;
    }

    .social-proof-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: var(--show-card);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--show-primary);
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .social-proof-text {
        font-size: 0.85rem;
        color: var(--show-text);
    }

    .social-proof-text strong {
        color: var(--show-primary);
    }

    /* ============================================
       QUIZ SECTION
       ============================================ */
    .quiz-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1.25rem;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 14px;
        margin-bottom: 0.75rem;
        border: 2px solid #f59e0b;
    }

    .quiz-info h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--show-text);
        margin: 0 0 0.35rem 0;
    }

    .quiz-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.8rem;
        color: #92400e;
    }

    .quiz-meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .quiz-badge {
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .quiz-badge.success {
        background: #dcfce7;
        color: #16a34a;
    }

    .btn-quiz {
        padding: 0.6rem 1.25rem;
        background: #f59e0b;
        color: white;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-quiz:hover {
        background: #d97706;
        color: white;
        transform: translateY(-2px);
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1199px) {
        .content-grid {
            grid-template-columns: 1fr 340px;
        }

        .features-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 991px) {
        .hero-title {
            font-size: 2rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
        }

        .learning-grid {
            grid-template-columns: 1fr;
        }

        .features-row {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 767px) {
        .formation-hero {
            padding: 2.5rem 0 5rem;
        }

        .hero-title {
            font-size: 1.5rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .hero-stats {
            gap: 1.25rem;
        }

        .hero-image-container {
            margin-top: 2rem;
        }

        .features-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .feature-card {
            padding: 1rem;
        }

        .feature-icon {
            width: 45px;
            height: 45px;
        }

        .feature-value {
            font-size: 1.25rem;
        }

        .section-header {
            padding: 1rem 1.25rem;
        }

        .section-body {
            padding: 1.25rem;
        }

        .modules-accordion {
            padding: 0 0.75rem 0.75rem;
        }

        .module-header {
            padding: 0.85rem 1rem;
        }

        .module-number {
            width: 36px;
            height: 36px;
            font-size: 0.9rem;
        }

        .cta-price-value {
            font-size: 2rem;
        }
    }

    @media (max-width: 575px) {
        .hero-badges {
            flex-wrap: wrap;
        }

        .hero-stats {
            flex-direction: column;
            gap: 1rem;
        }

        .features-row {
            grid-template-columns: 1fr 1fr;
        }

        .quiz-card {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .quiz-meta {
            justify-content: center;
        }
    }

    /* ============================================
       COMPLETION BANNER
       ============================================ */
    .completion-banner {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 30%, #f093fb 70%, #f5576c 100%);
        border-radius: var(--show-radius);
        padding: 2.5rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(245, 87, 108, 0.25);
    }

    .completion-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.15);
        z-index: 1;
    }

    .completion-banner-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
    }

    .completion-trophy {
        font-size: 3.5rem;
        margin-bottom: 1rem;
        display: inline-block;
        animation: trophyBounce 2s ease-in-out infinite;
    }

    @keyframes trophyBounce {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        25% { transform: translateY(-8px) rotate(-3deg); }
        75% { transform: translateY(-4px) rotate(3deg); }
    }

    .completion-banner h2 {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .completion-banner p {
        font-size: 1rem;
        opacity: 0.95;
        margin-bottom: 1.5rem;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    .completion-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-certificate {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.85rem 1.75rem;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
    }

    .btn-certificate-primary {
        background: white;
        color: #e74c3c;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .btn-certificate-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
        color: #c0392b;
    }

    .btn-certificate-outline {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 2px solid rgba(255,255,255,0.5);
    }

    .btn-certificate-outline:hover {
        background: rgba(255,255,255,0.3);
        color: white;
        transform: translateY(-3px);
    }

    .certificate-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .certificate-status-pending {
        background: rgba(255,255,255,0.25);
        color: white;
        border: 2px solid rgba(255,255,255,0.4);
    }

    .certificate-status-ready {
        background: white;
        color: #27ae60;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    }

    .confetti {
        position: absolute;
        z-index: 1;
        opacity: 0.6;
        font-size: 1.5rem;
        animation: confettiFall 3s linear infinite;
    }

    .confetti:nth-child(1) { left: 5%; animation-delay: 0s; top: -10%; }
    .confetti:nth-child(2) { left: 15%; animation-delay: 0.5s; top: -15%; }
    .confetti:nth-child(3) { left: 30%; animation-delay: 1s; top: -5%; }
    .confetti:nth-child(4) { left: 50%; animation-delay: 0.3s; top: -12%; }
    .confetti:nth-child(5) { left: 70%; animation-delay: 0.8s; top: -8%; }
    .confetti:nth-child(6) { left: 85%; animation-delay: 1.2s; top: -15%; }
    .confetti:nth-child(7) { left: 95%; animation-delay: 0.2s; top: -10%; }

    @keyframes confettiFall {
        0% { transform: translateY(0) rotate(0deg); opacity: 0.8; }
        100% { transform: translateY(400px) rotate(720deg); opacity: 0; }
    }

    @media (max-width: 575px) {
        .completion-banner {
            padding: 1.75rem 1.25rem;
        }
        .completion-banner h2 {
            font-size: 1.3rem;
        }
        .completion-trophy {
            font-size: 2.5rem;
        }
        .btn-certificate {
            padding: 0.7rem 1.25rem;
            font-size: 0.85rem;
        }
    }
</style>
@endpush

@section('content')
@php
    // Calculs globaux
    $totalContenus = 0;
    $videosCount = 0;
    $pdfsCount = 0;
    foreach($formation->modules as $m) {
        foreach($m->contenus as $c) {
            $totalContenus++;
            if($c->type === 'video') $videosCount++;
            elseif($c->type === 'pdf') $pdfsCount++;
        }
    }

    $hasAccess = $inscription && $inscription->paiement_valide;

    // Calcul progression si inscrit
    $overallProgress = 0;
    $completedFormationContenus = 0;
    if ($hasAccess) {
        foreach($formation->modules as $m) {
            $completedFormationContenus += \App\Models\UserModuleProgression::where('user_id', auth()->id())
                ->where('module_id', $m->id)
                ->where('completed', true)
                ->count();
        }
        $overallProgress = $totalContenus > 0 ? round(($completedFormationContenus / $totalContenus) * 100) : 0;
    }

    // Statut certificat
    $isCompleted = $inscription && $inscription->statut === 'termine';
    $certificat = $inscription ? $inscription->certificat : null;
    $certificatDemande = $inscription && $inscription->certificat_demande;
@endphp

<div class="formation-show-page">
    <!-- Hero Section -->
    <div class="formation-hero">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 hero-content">
                    <nav class="hero-breadcrumb">
                        <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                        <i class="fa fa-chevron-right"></i>
                        <a href="{{ route('formation.modules') }}">Formations</a>
                        <i class="fa fa-chevron-right"></i>
                        <span>{{ Str::limit($formation->titre, 30) }}</span>
                    </nav>

                    <div class="hero-badges">
                        @if($formation->categorie)
                            <span class="hero-badge category">
                                <i class="fa fa-folder"></i>
                                {{ $formation->categorie }}
                            </span>
                        @endif
                        @if($formation->niveau)
                            <span class="hero-badge level">
                                <i class="fa fa-layer-group"></i>
                                @php
                                    $niveauLabels = ['debutant' => 'Débutant', 'intermediaire' => 'Intermédiaire', 'avance' => 'Avancé'];
                                @endphp
                                {{ $niveauLabels[$formation->niveau] ?? ucfirst($formation->niveau) }}
                            </span>
                        @endif
                        @if($formation->est_gratuit || $formation->prix == 0)
                            <span class="hero-badge free">
                                <i class="fa fa-gift"></i>
                                Gratuit
                            </span>
                        @else
                            <span class="hero-badge paid">
                                {{ fcfa($formation->prix) }}
                            </span>
                        @endif
                    </div>

                    <h1 class="hero-title">{{ $formation->titre }}</h1>
                    <p class="hero-description">{{ Str::limit($formation->description, 180) }}</p>

                    <div class="hero-stats">
                        <div class="hero-stat">
                            <div class="hero-stat-icon">
                                <i class="fa fa-book-open"></i>
                            </div>
                            <div class="hero-stat-text">
                                <span class="hero-stat-value">{{ $formation->modules->count() }}</span>
                                <span class="hero-stat-label">Module{{ $formation->modules->count() > 1 ? 's' : '' }}</span>
                            </div>
                        </div>
                        @if($totalContenus > 0)
                            <div class="hero-stat">
                                <div class="hero-stat-icon">
                                    <i class="fa fa-play-circle"></i>
                                </div>
                                <div class="hero-stat-text">
                                    <span class="hero-stat-value">{{ $totalContenus }}</span>
                                    <span class="hero-stat-label">Leçon{{ $totalContenus > 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                        @endif
                        <div class="hero-stat">
                            <div class="hero-stat-icon">
                                <i class="fa fa-certificate"></i>
                            </div>
                            <div class="hero-stat-text">
                                <span class="hero-stat-value">Oui</span>
                                <span class="hero-stat-label">Certificat</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 hero-image-container">
                    @if($formation->image)
                        <div class="hero-image-wrapper">
                            <img src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}" class="hero-image">
                        </div>
                    @else
                        <div class="hero-placeholder">
                            <i class="fa fa-graduation-cap"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="formation-main">
        <div class="container">
            <!-- Bannière de félicitations si formation terminée -->
            @if($isCompleted)
                <div class="completion-banner">
                    <span class="confetti">&#127881;</span>
                    <span class="confetti">&#11088;</span>
                    <span class="confetti">&#127882;</span>
                    <span class="confetti">&#127942;</span>
                    <span class="confetti">&#127881;</span>
                    <span class="confetti">&#11088;</span>
                    <span class="confetti">&#127882;</span>

                    <div class="completion-banner-content">
                        <div class="completion-trophy">&#127942;</div>
                        <h2>Formation terminee avec succes !</h2>
                        <p>Vous avez complete tous les modules et reussi tous les quiz. Vous pouvez maintenant obtenir votre certificat.</p>

                        <div class="completion-actions">
                            @if($certificat)
                                {{-- Certificat deja genere --}}
                                <a href="{{ route('admin.certifications.download', $certificat) }}" class="btn-certificate btn-certificate-primary">
                                    <i class="fa fa-download"></i>
                                    Telecharger mon certificat
                                </a>
                            @elseif($certificatDemande)
                                {{-- Demande en cours --}}
                                <div class="certificate-status certificate-status-pending">
                                    <i class="fa fa-hourglass-half"></i>
                                    Demande en cours de traitement...
                                </div>
                            @else
                                {{-- Bouton pour demander le certificat --}}
                                <form method="POST" action="{{ route('formation.demander-certificat', $formation) }}">
                                    @csrf
                                    <button type="submit" class="btn-certificate btn-certificate-primary">
                                        <i class="fa fa-certificate"></i>
                                        Demander mon certificat
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('account.formations') }}" class="btn-certificate btn-certificate-outline">
                                <i class="fa fa-arrow-left"></i>
                                Mes formations
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Features Row -->
            <div class="features-row">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-book-open"></i>
                    </div>
                    <div class="feature-value">{{ $formation->modules->count() }}</div>
                    <div class="feature-label">Module{{ $formation->modules->count() > 1 ? 's' : '' }} de cours</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-video"></i>
                    </div>
                    <div class="feature-value">{{ $videosCount }}</div>
                    <div class="feature-label">Vidéo{{ $videosCount > 1 ? 's' : '' }}</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-file-pdf"></i>
                    </div>
                    <div class="feature-value">{{ $pdfsCount }}</div>
                    <div class="feature-label">Document{{ $pdfsCount > 1 ? 's' : '' }} PDF</div>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fa fa-infinity"></i>
                    </div>
                    <div class="feature-value">∞</div>
                    <div class="feature-label">Accès à vie</div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Main Column -->
                <div class="main-column">
                    <!-- Ce que vous allez apprendre -->
                    <div class="section-card">
                        <div class="section-header">
                            <div class="section-icon green">
                                <i class="fa fa-lightbulb"></i>
                            </div>
                            <h2 class="section-title">Ce que vous allez apprendre</h2>
                        </div>
                        <div class="section-body">
                            <div class="learning-grid">
                                @foreach($formation->modules->take(6) as $module)
                                    <div class="learning-item">
                                        <div class="learning-check">
                                            <i class="fa fa-check"></i>
                                        </div>
                                        <span class="learning-text">{{ Str::limit($module->titre, 60) }}</span>
                                    </div>
                                @endforeach
                                @if($formation->modules->count() > 6)
                                    <div class="learning-item">
                                        <div class="learning-check" style="background: var(--show-secondary);">
                                            <i class="fa fa-plus"></i>
                                        </div>
                                        <span class="learning-text">Et {{ $formation->modules->count() - 6 }} autres modules passionnants...</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if(strlen($formation->description) > 180)
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-icon blue">
                                    <i class="fa fa-info-circle"></i>
                                </div>
                                <h2 class="section-title">À propos de cette formation</h2>
                            </div>
                            <div class="section-body">
                                <p style="color: var(--show-text-muted); line-height: 1.8; margin: 0; text-align: justify;">{{ $formation->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Programme -->
                    <div class="section-card">
                        <div class="section-header">
                            <div class="section-icon orange">
                                <i class="fa fa-list-alt"></i>
                            </div>
                            <h2 class="section-title">Programme de la formation</h2>
                        </div>

                        <div class="program-stats">
                            <div class="program-stat">
                                <i class="fa fa-book"></i>
                                <span>{{ $formation->modules->count() }} module{{ $formation->modules->count() > 1 ? 's' : '' }}</span>
                            </div>
                            <div class="program-stat">
                                <i class="fa fa-file-alt"></i>
                                <span>{{ $totalContenus }} leçon{{ $totalContenus > 1 ? 's' : '' }}</span>
                            </div>
                            @if($formation->duree)
                                <div class="program-stat">
                                    <i class="fa fa-clock"></i>
                                    <span>{{ $formation->duree }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="modules-accordion">
                            @forelse($formation->modules as $index => $module)
                                @php
                                    $moduleCompleted = false;
                                    $moduleProgress = 0;
                                    $moduleContenus = $module->contenus->count();

                                    if ($hasAccess && $moduleContenus > 0) {
                                        $completedContenus = \App\Models\UserModuleProgression::where('user_id', auth()->id())
                                            ->where('module_id', $module->id)
                                            ->where('completed', true)
                                            ->count();
                                        $moduleProgress = round(($completedContenus / $moduleContenus) * 100);
                                        $moduleCompleted = $moduleProgress >= 100;
                                    }

                                    $numberClass = 'default';
                                    if (!$hasAccess) {
                                        $numberClass = 'locked';
                                    } elseif ($moduleCompleted) {
                                        $numberClass = 'completed';
                                    } elseif ($moduleProgress > 0) {
                                        $numberClass = 'in-progress';
                                    }
                                @endphp

                                <div class="module-item {{ $index === 0 ? 'active' : '' }}" data-module="{{ $module->id }}">
                                    <div class="module-header" onclick="toggleModule({{ $module->id }})">
                                        <div class="module-number {{ $numberClass }}">
                                            @if($moduleCompleted)
                                                <i class="fa fa-check"></i>
                                            @elseif(!$hasAccess)
                                                <i class="fa fa-lock"></i>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </div>
                                        <div class="module-info">
                                            <div class="module-title">{{ $module->titre }}</div>
                                            <div class="module-meta">
                                                @if($moduleContenus > 0)
                                                    <span><i class="fa fa-play-circle"></i> {{ $moduleContenus }} leçon{{ $moduleContenus > 1 ? 's' : '' }}</span>
                                                @endif
                                                @if($module->duree)
                                                    <span><i class="fa fa-clock"></i> {{ $module->duree }} min</span>
                                                @endif
                                                @if($hasAccess && $moduleProgress > 0 && $moduleProgress < 100)
                                                    <span style="color: var(--show-secondary);"><i class="fa fa-chart-line"></i> {{ $moduleProgress }}%</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="module-toggle">
                                            <i class="fa fa-chevron-down"></i>
                                        </div>
                                    </div>

                                    <div class="module-content" style="{{ $index === 0 ? '' : 'display: none;' }}">
                                        @if($hasAccess)
                                            @if($module->contenus->count() > 0)
                                                <div class="lessons-list">
                                                    @foreach($module->contenus as $contenu)
                                                        @php
                                                            $contenuCompleted = \App\Models\UserModuleProgression::where('user_id', auth()->id())
                                                                ->where('module_contenu_id', $contenu->id)
                                                                ->where('completed', true)
                                                                ->exists();

                                                            $iconClass = 'text';
                                                            if($contenu->type === 'video') $iconClass = 'video';
                                                            elseif($contenu->type === 'pdf') $iconClass = 'pdf';
                                                        @endphp
                                                        <div class="lesson-item">
                                                            <div class="lesson-icon {{ $iconClass }}">
                                                                @if($contenu->type === 'video')
                                                                    <i class="fa fa-play"></i>
                                                                @elseif($contenu->type === 'pdf')
                                                                    <i class="fa fa-file-pdf"></i>
                                                                @else
                                                                    <i class="fa fa-file-alt"></i>
                                                                @endif
                                                            </div>
                                                            <span class="lesson-title">{{ $contenu->titre }}</span>
                                                            @if($contenu->duree)
                                                                <span class="lesson-duration">{{ $contenu->duree }}</span>
                                                            @endif
                                                            @if($contenuCompleted)
                                                                <div class="lesson-status completed">
                                                                    <i class="fa fa-check"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="module-cta">
                                                <a href="{{ route('formation.module.show', [$formation, $module]) }}" class="btn-module btn-module-primary">
                                                    <i class="fa fa-play"></i>
                                                    {{ $moduleCompleted ? 'Revoir le module' : ($moduleProgress > 0 ? 'Continuer' : 'Commencer') }}
                                                </a>
                                            </div>
                                        @else
                                            <div class="lessons-list">
                                                @foreach($module->contenus->take(3) as $contenu)
                                                    <div class="lesson-item" style="opacity: 0.6;">
                                                        <div class="lesson-icon locked">
                                                            <i class="fa fa-lock"></i>
                                                        </div>
                                                        <span class="lesson-title">{{ Str::limit($contenu->titre, 40) }}</span>
                                                    </div>
                                                @endforeach
                                                @if($module->contenus->count() > 3)
                                                    <div class="lesson-item" style="opacity: 0.5;">
                                                        <div class="lesson-icon locked">
                                                            <i class="fa fa-ellipsis-h"></i>
                                                        </div>
                                                        <span class="lesson-title">+{{ $module->contenus->count() - 3 }} autres leçons</span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="locked-message">
                                                <i class="fa fa-lock"></i>
                                                <span>Inscrivez-vous pour accéder à ce module complet</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 3rem; color: var(--show-text-muted);">
                                    <i class="fa fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                                    <p>Programme en cours de préparation</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Quiz de certification -->
                    @if($formation->quizzes && $formation->quizzes->count() > 0 && $hasAccess)
                        <div class="section-card">
                            <div class="section-header">
                                <div class="section-icon purple">
                                    <i class="fa fa-trophy"></i>
                                </div>
                                <h2 class="section-title">Quiz de certification</h2>
                            </div>
                            <div class="section-body">
                                @foreach($formation->quizzes as $quiz)
                                    @php
                                        $userAttempts = $quiz->attempts()->where('user_id', auth()->id())->count();
                                        $canAttempt = $quiz->userCanAttempt(auth()->id());
                                        $bestScore = $quiz->getUserBestScore(auth()->id());
                                    @endphp
                                    <div class="quiz-card">
                                        <div class="quiz-info">
                                            <h4><i class="fa fa-question-circle me-2"></i>{{ $quiz->titre }}</h4>
                                            <div class="quiz-meta">
                                                <span><i class="fa fa-list"></i> {{ $quiz->questions->count() }} questions</span>
                                                <span><i class="fa fa-star"></i> {{ $quiz->total_points }} pts</span>
                                                @if($quiz->duree_minutes)
                                                    <span><i class="fa fa-clock"></i> {{ $quiz->duree_minutes }} min</span>
                                                @endif
                                            </div>
                                            @if($bestScore !== null)
                                                <span class="quiz-badge {{ $bestScore >= $quiz->note_passage ? 'success' : '' }}" style="margin-top: 0.5rem; display: inline-block;">
                                                    <i class="fa fa-medal me-1"></i>Meilleur: {{ number_format($bestScore, 0) }}%
                                                </span>
                                            @endif
                                        </div>
                                        @if($canAttempt)
                                            <a href="{{ route('quiz.show', $quiz->id) }}" class="btn-quiz">
                                                <i class="fa fa-play me-1"></i>
                                                {{ $userAttempts > 0 ? 'Reprendre' : 'Passer le quiz' }}
                                            </a>
                                        @else
                                            <span class="quiz-badge success">
                                                <i class="fa fa-check me-1"></i>Réussi
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="sidebar-column">
                    <div class="sidebar-sticky">
                        <!-- Progression (si inscrit) -->
                        @if($hasAccess)
                            <div class="progress-card">
                                <div class="progress-header">
                                    <span class="progress-title">
                                        <i class="fa fa-chart-line"></i>
                                        Votre progression
                                    </span>
                                    <span class="progress-percent">{{ $overallProgress }}%</span>
                                </div>
                                <div class="progress-bar-custom">
                                    <div class="progress-fill" style="width: {{ $overallProgress }}%;"></div>
                                </div>
                                <div class="progress-details">
                                    {{ $completedFormationContenus }}/{{ $totalContenus }} leçons terminées
                                    @if($overallProgress >= 100)
                                        <span style="margin-left: 0.5rem;"><i class="fa fa-trophy"></i> Félicitations!</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- CTA Card -->
                        <div class="cta-card">
                            <div class="cta-header">
                                <div class="cta-price">
                                    <div class="cta-price-label">Prix de la formation</div>
                                    <div class="cta-price-value {{ $formation->est_gratuit || $formation->prix == 0 ? 'free' : '' }}">
                                        {{ $formation->est_gratuit || $formation->prix == 0 ? 'Gratuit' : fcfa($formation->prix) }}
                                    </div>
                                </div>
                            </div>

                            <div class="cta-body">
                                @auth
                                    @if($inscription)
                                        @if($inscription->paiement_valide)
                                            <a href="{{ route('account.formations') }}" class="btn-cta btn-cta-enrolled">
                                                <i class="fa fa-play-circle"></i>
                                                Accéder à la formation
                                            </a>
                                            <div class="cta-guarantee">
                                                <i class="fa fa-check-circle"></i>
                                                <span>Vous êtes inscrit à cette formation</span>
                                            </div>
                                        @else
                                            <a href="{{ route('formation.paiement', $formation) }}" class="btn-cta btn-cta-pending">
                                                <i class="fa fa-credit-card"></i>
                                                Finaliser le paiement
                                            </a>
                                            <div class="cta-guarantee" style="background: #fff8e6; color: #856404;">
                                                <i class="fa fa-exclamation-triangle" style="color: var(--show-secondary);"></i>
                                                <span>Paiement en attente de validation</span>
                                            </div>
                                        @endif
                                    @else
                                        <form method="POST" action="{{ route('formation.acheter', $formation) }}">
                                            @csrf
                                            @if($formation->est_gratuit || $formation->prix == 0)
                                                <button type="submit" class="btn-cta btn-cta-primary">
                                                    <i class="fa fa-check-circle"></i>
                                                    Commencer la formation
                                                </button>
                                            @else
                                                <button type="submit" class="btn-cta btn-cta-primary">
                                                    <i class="fa fa-shopping-cart"></i>
                                                    S'inscrire maintenant
                                                </button>
                                            @endif
                                        </form>
                                        <div class="cta-guarantee">
                                            @if($formation->est_gratuit || $formation->prix == 0)
                                                <i class="fa fa-gift"></i>
                                                <span>Formation gratuite - Accès immédiat</span>
                                            @else
                                                <i class="fa fa-shield-alt"></i>
                                                <span>Accès immédiat après paiement</span>
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn-cta btn-cta-primary">
                                        <i class="fa fa-sign-in-alt"></i>
                                        Se connecter pour s'inscrire
                                    </a>
                                    <div class="cta-guarantee">
                                        <i class="fa fa-user-plus"></i>
                                        <span>Créez un compte gratuitement</span>
                                    </div>
                                @endauth

                                <div class="cta-features">
                                    <div class="cta-features-title">Cette formation inclut</div>
                                    <div class="cta-feature">
                                        <i class="fa fa-infinity"></i>
                                        <span>Accès illimité à vie</span>
                                    </div>
                                    <div class="cta-feature">
                                        <i class="fa fa-mobile-alt"></i>
                                        <span>Compatible mobile & desktop</span>
                                    </div>
                                    <div class="cta-feature">
                                        <i class="fa fa-certificate"></i>
                                        <span>Certificat de complétion</span>
                                    </div>
                                    <div class="cta-feature">
                                        <i class="fa fa-headset"></i>
                                        <span>Support disponible</span>
                                    </div>
                                    <div class="cta-feature">
                                        <i class="fa fa-sync-alt"></i>
                                        <span>Mises à jour gratuites</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="info-card">
                            <div class="info-card-header">
                                <i class="fa fa-info-circle"></i>
                                Détails de la formation
                            </div>
                            <div class="info-card-body">
                                <div class="info-row">
                                    <span class="info-label"><i class="fa fa-book"></i> Modules</span>
                                    <span class="info-value">{{ $formation->modules->count() }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label"><i class="fa fa-file-alt"></i> Leçons</span>
                                    <span class="info-value">{{ $totalContenus }}</span>
                                </div>
                                @if($videosCount > 0)
                                    <div class="info-row">
                                        <span class="info-label"><i class="fa fa-video"></i> Vidéos</span>
                                        <span class="info-value">{{ $videosCount }}</span>
                                    </div>
                                @endif
                                @if($pdfsCount > 0)
                                    <div class="info-row">
                                        <span class="info-label"><i class="fa fa-file-pdf"></i> Documents</span>
                                        <span class="info-value">{{ $pdfsCount }}</span>
                                    </div>
                                @endif
                                @if($formation->quizzes && $formation->quizzes->count() > 0)
                                    <div class="info-row">
                                        <span class="info-label"><i class="fa fa-question-circle"></i> Quiz</span>
                                        <span class="info-value">{{ $formation->quizzes->count() }}</span>
                                    </div>
                                @endif
                                @if($formation->duree)
                                    <div class="info-row">
                                        <span class="info-label"><i class="fa fa-clock"></i> Durée</span>
                                        <span class="info-value">{{ $formation->duree }}</span>
                                    </div>
                                @endif
                                <div class="info-row">
                                    <span class="info-label"><i class="fa fa-language"></i> Langue</span>
                                    <span class="info-value">Français</span>
                                </div>
                            </div>
                        </div>

                        <!-- Social Proof -->
                        <div class="social-proof">
                            <div class="social-proof-item">
                                <div class="social-proof-icon">
                                    <i class="fa fa-award"></i>
                                </div>
                                <div class="social-proof-text">
                                    Formation <strong>certifiée</strong> Colibri Littéraire
                                </div>
                            </div>
                            <div class="social-proof-item">
                                <div class="social-proof-icon">
                                    <i class="fa fa-user-graduate"></i>
                                </div>
                                <div class="social-proof-text">
                                    Contenu créé par des <strong>experts</strong>
                                </div>
                            </div>
                            <div class="social-proof-item">
                                <div class="social-proof-icon">
                                    <i class="fa fa-heart"></i>
                                </div>
                                <div class="social-proof-text">
                                    <strong>Satisfaction</strong> garantie
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleModule(moduleId) {
    const moduleItem = document.querySelector(`.module-item[data-module="${moduleId}"]`);
    const moduleContent = moduleItem.querySelector('.module-content');
    const isActive = moduleItem.classList.contains('active');

    // Fermer tous les autres modules
    document.querySelectorAll('.module-item').forEach(item => {
        if (item !== moduleItem) {
            item.classList.remove('active');
            item.querySelector('.module-content').style.display = 'none';
        }
    });

    // Toggle le module actuel
    if (isActive) {
        moduleItem.classList.remove('active');
        moduleContent.style.display = 'none';
    } else {
        moduleItem.classList.add('active');
        moduleContent.style.display = 'block';
    }
}
</script>
@endpush
