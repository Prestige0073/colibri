@extends('layouts.app')

@section('title', $quiz->titre . ' | Quiz - Colibri Littéraire')
@section('meta_description', $quiz->description ? Str::limit($quiz->description, 150) : 'Testez vos connaissances avec ce quiz')

@push('styles')
<style>
    :root {
        --quiz-primary: #1e7a2f;
        --quiz-primary-dark: #155a22;
        --quiz-primary-light: #e8f5e9;
        --quiz-secondary: #f39c12;
        --quiz-success: #2ecc71;
        --quiz-danger: #e74c3c;
        --quiz-info: #3498db;
        --quiz-purple: #9b59b6;
        --quiz-text: #2d3436;
        --quiz-text-muted: #636e72;
        --quiz-bg: #f8f9fa;
        --quiz-card: #ffffff;
        --quiz-radius: 16px;
        --quiz-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --quiz-shadow-hover: 0 12px 40px rgba(0,0,0,0.15);
    }

    .quiz-show-page {
        background: var(--quiz-bg);
        min-height: 100vh;
    }

    /* ============================================
       HERO SECTION
       ============================================ */
    .quiz-hero {
        background: linear-gradient(135deg, var(--quiz-primary) 0%, var(--quiz-primary-dark) 100%);
        padding: 3rem 0 6rem;
        position: relative;
        overflow: hidden;
    }

    .quiz-hero::before {
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
        background: var(--quiz-secondary);
        bottom: -80px;
        left: 5%;
        animation-delay: 2s;
    }

    .hero-shape-3 {
        width: 150px;
        height: 150px;
        background: white;
        top: 50%;
        left: 15%;
        animation-delay: 4s;
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
        flex-wrap: wrap;
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

    .hero-badge.quiz-type {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }

    .hero-badge.formation {
        background: var(--quiz-secondary);
        color: white;
    }

    .hero-badge.certified {
        background: var(--quiz-success);
        color: white;
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
    }

    /* Hero stats circles */
    .hero-stats-row {
        display: flex;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .hero-stat-circle {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .stat-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.5rem;
        border: 3px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s;
    }

    .stat-circle:hover {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.25);
    }

    .stat-circle-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: white;
        line-height: 1;
    }

    .stat-circle-unit {
        font-size: 0.65rem;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-circle-label {
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 500;
    }

    /* Hero illustration */
    .hero-illustration {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .quiz-visual {
        position: relative;
        width: 280px;
        height: 280px;
    }

    .quiz-visual-main {
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        border: 4px solid rgba(255, 255, 255, 0.2);
        position: relative;
    }

    .quiz-visual-main i {
        font-size: 6rem;
        color: white;
        opacity: 0.9;
    }

    .quiz-visual-orbit {
        position: absolute;
        border-radius: 50%;
        border: 2px dashed rgba(255, 255, 255, 0.2);
    }

    .quiz-visual-orbit-1 {
        width: 320px;
        height: 320px;
        top: -20px;
        left: -20px;
        animation: rotate 20s linear infinite;
    }

    .quiz-visual-orbit-2 {
        width: 360px;
        height: 360px;
        top: -40px;
        left: -40px;
        animation: rotate 30s linear infinite reverse;
    }

    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .quiz-visual-float {
        position: absolute;
        background: white;
        border-radius: 12px;
        padding: 0.75rem 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        font-weight: 600;
        animation: floatBadge 3s ease-in-out infinite;
    }

    .quiz-visual-float-1 {
        top: 10%;
        right: -10%;
        color: var(--quiz-success);
    }

    .quiz-visual-float-2 {
        bottom: 10%;
        left: -10%;
        color: var(--quiz-secondary);
        animation-delay: 1.5s;
    }

    @keyframes floatBadge {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* ============================================
       MAIN CONTENT
       ============================================ */
    .quiz-main {
        margin-top: -3rem;
        position: relative;
        z-index: 10;
        padding-bottom: 4rem;
    }

    /* ============================================
       INFO CARDS ROW
       ============================================ */
    .info-cards-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .info-card-item {
        background: var(--quiz-card);
        border-radius: 14px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: var(--quiz-shadow);
        transition: all 0.3s;
        border: 2px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .info-card-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .info-card-item:nth-child(1)::before { background: var(--quiz-purple); }
    .info-card-item:nth-child(2)::before { background: var(--quiz-primary); }
    .info-card-item:nth-child(3)::before { background: var(--quiz-secondary); }
    .info-card-item:nth-child(4)::before { background: var(--quiz-info); }

    .info-card-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--quiz-shadow-hover);
    }

    .info-card-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.25rem;
    }

    .info-card-item:nth-child(1) .info-card-icon {
        background: #f5eef8;
        color: var(--quiz-purple);
    }

    .info-card-item:nth-child(2) .info-card-icon {
        background: var(--quiz-primary-light);
        color: var(--quiz-primary);
    }

    .info-card-item:nth-child(3) .info-card-icon {
        background: #fef5e7;
        color: var(--quiz-secondary);
    }

    .info-card-item:nth-child(4) .info-card-icon {
        background: #e8f4fd;
        color: var(--quiz-info);
    }

    .info-card-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--quiz-text);
        line-height: 1;
        margin-bottom: 0.35rem;
    }

    .info-card-label {
        font-size: 0.85rem;
        color: var(--quiz-text-muted);
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
       MAIN CARD - CTA
       ============================================ */
    .quiz-cta-card {
        background: var(--quiz-card);
        border-radius: var(--quiz-radius);
        box-shadow: var(--quiz-shadow);
        overflow: hidden;
    }

    .cta-header {
        background: linear-gradient(135deg, var(--quiz-primary) 0%, var(--quiz-primary-dark) 100%);
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -30%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-header-content {
        position: relative;
        z-index: 2;
    }

    .cta-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        animation: pulse 2s ease-in-out infinite;
    }

    .cta-icon i {
        font-size: 2.5rem;
        color: white;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 20px rgba(255, 255, 255, 0); }
    }

    .cta-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.5rem;
    }

    .cta-subtitle {
        color: rgba(255, 255, 255, 0.85);
        font-size: 0.95rem;
    }

    .cta-body {
        padding: 2rem;
    }

    /* Progress indicator */
    .attempt-progress {
        margin-bottom: 1.5rem;
    }

    .attempt-progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .attempt-progress-label {
        font-size: 0.9rem;
        color: var(--quiz-text);
        font-weight: 600;
    }

    .attempt-progress-count {
        font-size: 0.85rem;
        color: var(--quiz-text-muted);
    }

    .attempt-progress-bar {
        height: 10px;
        background: #e9ecef;
        border-radius: 5px;
        overflow: hidden;
    }

    .attempt-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--quiz-purple) 0%, #8e44ad 100%);
        border-radius: 5px;
        transition: width 0.5s ease;
    }

    /* Best score */
    .best-score-card {
        background: linear-gradient(135deg, #e8f8f0 0%, #d4efdf 100%);
        border: 2px solid var(--quiz-success);
        border-radius: 14px;
        padding: 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .best-score-icon {
        width: 50px;
        height: 50px;
        background: var(--quiz-success);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .best-score-icon i {
        color: white;
        font-size: 1.25rem;
    }

    .best-score-info h4 {
        font-size: 0.85rem;
        color: #27ae60;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .best-score-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--quiz-success);
        line-height: 1;
    }

    /* CTA Button */
    .btn-start-quiz {
        width: 100%;
        padding: 1.25rem 2rem;
        background: linear-gradient(135deg, var(--quiz-primary) 0%, var(--quiz-primary-dark) 100%);
        border: none;
        border-radius: 14px;
        color: white;
        font-size: 1.1rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-start-quiz:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px rgba(30, 122, 47, 0.4);
        color: white;
    }

    .btn-start-quiz:active {
        transform: translateY(0);
    }

    .btn-start-quiz i {
        font-size: 1.25rem;
    }

    .btn-start-quiz.disabled {
        background: #e9ecef;
        color: var(--quiz-text-muted);
        cursor: not-allowed;
        box-shadow: none;
    }

    .btn-start-quiz.disabled:hover {
        transform: none;
    }

    /* Warning message */
    .attempts-warning {
        background: #fef5e7;
        border: 2px solid var(--quiz-secondary);
        border-radius: 14px;
        padding: 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .attempts-warning i {
        color: var(--quiz-secondary);
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .attempts-warning-text h4 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #d68910;
        margin: 0 0 0.25rem 0;
    }

    .attempts-warning-text p {
        font-size: 0.85rem;
        color: #9a7d0a;
        margin: 0;
    }

    /* CTA features list */
    .cta-features {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #f0f0f0;
    }

    .cta-feature {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.6rem 0;
        font-size: 0.9rem;
        color: var(--quiz-text);
    }

    .cta-feature i {
        color: var(--quiz-success);
        width: 20px;
        text-align: center;
    }

    /* ============================================
       SIDEBAR - ATTEMPTS HISTORY
       ============================================ */
    .sidebar-sticky {
        position: sticky;
        top: 100px;
    }

    .history-card {
        background: var(--quiz-card);
        border-radius: var(--quiz-radius);
        box-shadow: var(--quiz-shadow);
        overflow: hidden;
    }

    .history-header {
        padding: 1.25rem 1.5rem;
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%);
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .history-header i {
        font-size: 1.25rem;
    }

    .history-header h3 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }

    .history-body {
        padding: 1.25rem;
    }

    .attempt-item {
        background: var(--quiz-bg);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-left: 4px solid;
        transition: all 0.3s;
    }

    .attempt-item:last-child {
        margin-bottom: 0;
    }

    .attempt-item:hover {
        transform: translateX(5px);
    }

    .attempt-item.success {
        border-color: var(--quiz-success);
    }

    .attempt-item.failed {
        border-color: var(--quiz-danger);
    }

    .attempt-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .attempt-number {
        font-weight: 700;
        color: var(--quiz-text);
        font-size: 0.95rem;
    }

    .attempt-score {
        padding: 0.35rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .attempt-score.success {
        background: #d4efdf;
        color: var(--quiz-success);
    }

    .attempt-score.failed {
        background: #fadbd8;
        color: var(--quiz-danger);
    }

    .attempt-meta {
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        margin-bottom: 0.75rem;
    }

    .attempt-meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--quiz-text-muted);
    }

    .attempt-meta-item i {
        width: 16px;
        text-align: center;
        color: var(--quiz-purple);
    }

    .btn-view-result {
        width: 100%;
        padding: 0.6rem 1rem;
        background: transparent;
        border: 2px solid var(--quiz-purple);
        border-radius: 8px;
        color: var(--quiz-purple);
        font-size: 0.8rem;
        font-weight: 600;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .btn-view-result:hover {
        background: var(--quiz-purple);
        color: white;
    }

    /* Empty state */
    .history-empty {
        text-align: center;
        padding: 2rem 1rem;
    }

    .history-empty-icon {
        width: 70px;
        height: 70px;
        background: var(--quiz-bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .history-empty-icon i {
        font-size: 1.75rem;
        color: var(--quiz-text-muted);
    }

    .history-empty h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--quiz-text);
        margin: 0 0 0.5rem 0;
    }

    .history-empty p {
        font-size: 0.85rem;
        color: var(--quiz-text-muted);
        margin: 0;
    }

    /* ============================================
       TIPS SECTION
       ============================================ */
    .tips-card {
        background: var(--quiz-card);
        border-radius: var(--quiz-radius);
        box-shadow: var(--quiz-shadow);
        overflow: hidden;
        margin-top: 1.5rem;
    }

    .tips-header {
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, var(--quiz-secondary) 0%, #e67e22 100%);
        color: white;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .tips-header i {
        font-size: 1.25rem;
    }

    .tips-header h3 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }

    .tips-body {
        padding: 1.25rem;
    }

    .tip-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .tip-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .tip-number {
        width: 28px;
        height: 28px;
        background: #fef5e7;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--quiz-secondary);
    }

    .tip-text {
        font-size: 0.85rem;
        color: var(--quiz-text);
        line-height: 1.5;
    }

    /* ============================================
       ALERTS
       ============================================ */
    .quiz-alert {
        border-radius: 14px;
        padding: 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        border: none;
    }

    .quiz-alert.success {
        background: linear-gradient(135deg, #d4efdf 0%, #e8f8f0 100%);
    }

    .quiz-alert.error {
        background: linear-gradient(135deg, #fadbd8 0%, #f5b7b1 100%);
    }

    .quiz-alert-icon {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .quiz-alert.success .quiz-alert-icon {
        background: var(--quiz-success);
    }

    .quiz-alert.error .quiz-alert-icon {
        background: var(--quiz-danger);
    }

    .quiz-alert-icon i {
        color: white;
        font-size: 1.1rem;
    }

    .quiz-alert-content h4 {
        font-size: 1rem;
        font-weight: 600;
        margin: 0 0 0.25rem 0;
    }

    .quiz-alert.success .quiz-alert-content h4 {
        color: #1e8449;
    }

    .quiz-alert.error .quiz-alert-content h4 {
        color: #c0392b;
    }

    .quiz-alert-content p {
        font-size: 0.9rem;
        margin: 0;
    }

    .quiz-alert.success .quiz-alert-content p {
        color: #27ae60;
    }

    .quiz-alert.error .quiz-alert-content p {
        color: #e74c3c;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1199px) {
        .content-grid {
            grid-template-columns: 1fr 340px;
        }

        .info-cards-row {
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

        .info-cards-row {
            grid-template-columns: repeat(4, 1fr);
        }

        .quiz-visual {
            width: 220px;
            height: 220px;
        }

        .quiz-visual-main i {
            font-size: 4rem;
        }

        .quiz-visual-orbit-1 {
            width: 260px;
            height: 260px;
            top: -20px;
            left: -20px;
        }

        .quiz-visual-orbit-2 {
            width: 300px;
            height: 300px;
            top: -40px;
            left: -40px;
        }
    }

    @media (max-width: 767px) {
        .quiz-hero {
            padding: 2.5rem 0 5rem;
        }

        .hero-title {
            font-size: 1.5rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .hero-stats-row {
            gap: 1rem;
        }

        .stat-circle {
            width: 65px;
            height: 65px;
        }

        .stat-circle-value {
            font-size: 1.25rem;
        }

        .hero-illustration {
            margin-top: 2rem;
        }

        .info-cards-row {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .info-card-item {
            padding: 1rem;
        }

        .info-card-value {
            font-size: 1.5rem;
        }

        .cta-header {
            padding: 1.5rem;
        }

        .cta-body {
            padding: 1.5rem;
        }
    }

    @media (max-width: 575px) {
        .hero-badges {
            flex-wrap: wrap;
        }

        .hero-stats-row {
            justify-content: center;
        }

        .quiz-visual {
            width: 180px;
            height: 180px;
        }

        .quiz-visual-main i {
            font-size: 3rem;
        }

        .quiz-visual-float {
            display: none;
        }

        .info-cards-row {
            grid-template-columns: 1fr 1fr;
        }

        .best-score-card {
            flex-direction: column;
            text-align: center;
        }

        .attempt-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }
    }
</style>
@endpush

@section('content')
@php
    $attemptsPercentage = $quiz->nombre_tentatives > 0 ? ($attemptsCount / $quiz->nombre_tentatives) * 100 : 0;
    $hasPassed = $bestScore !== null && $bestScore >= $quiz->note_passage;
@endphp

<div class="quiz-show-page">
    <!-- Hero Section -->
    <div class="quiz-hero">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>

        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 hero-content">
                    <nav class="hero-breadcrumb">
                        <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                        <i class="fa fa-chevron-right"></i>
                        @if($quiz->formation)
                            <a href="{{ route('formation.show', $quiz->formation->id) }}">{{ Str::limit($quiz->formation->titre, 25) }}</a>
                            <i class="fa fa-chevron-right"></i>
                        @endif
                        @if($quiz->module)
                            <a href="#">{{ Str::limit($quiz->module->titre, 25) }}</a>
                            <i class="fa fa-chevron-right"></i>
                        @endif
                        <span>Quiz</span>
                    </nav>

                    <div class="hero-badges">
                        <span class="hero-badge quiz-type">
                            <i class="fa fa-question-circle"></i>
                            Quiz d'évaluation
                        </span>
                        @if($quiz->formation)
                            <span class="hero-badge formation">
                                <i class="fa fa-graduation-cap"></i>
                                {{ Str::limit($quiz->formation->titre, 20) }}
                            </span>
                        @endif
                        @if($hasPassed)
                            <span class="hero-badge certified">
                                <i class="fa fa-check-circle"></i>
                                Réussi
                            </span>
                        @endif
                    </div>

                    <h1 class="hero-title">{{ $quiz->titre }}</h1>
                    @if($quiz->description)
                        <p class="hero-description">{{ $quiz->description }}</p>
                    @else
                        <p class="hero-description">Testez vos connaissances et obtenez votre certification en répondant à ce quiz.</p>
                    @endif

                    <div class="hero-stats-row">
                        <div class="hero-stat-circle">
                            <div class="stat-circle">
                                <span class="stat-circle-value">{{ $quiz->questions->count() }}</span>
                                <span class="stat-circle-unit">Q</span>
                            </div>
                            <span class="stat-circle-label">Questions</span>
                        </div>
                        <div class="hero-stat-circle">
                            <div class="stat-circle">
                                <span class="stat-circle-value">{{ $quiz->total_points }}</span>
                                <span class="stat-circle-unit">pts</span>
                            </div>
                            <span class="stat-circle-label">Points</span>
                        </div>
                        @if($quiz->duree_minutes)
                            <div class="hero-stat-circle">
                                <div class="stat-circle">
                                    <span class="stat-circle-value">{{ $quiz->duree_minutes }}</span>
                                    <span class="stat-circle-unit">min</span>
                                </div>
                                <span class="stat-circle-label">Durée</span>
                            </div>
                        @endif
                        <div class="hero-stat-circle">
                            <div class="stat-circle">
                                <span class="stat-circle-value">{{ $quiz->note_passage }}</span>
                                <span class="stat-circle-unit">%</span>
                            </div>
                            <span class="stat-circle-label">Minimum</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 hero-illustration">
                    <div class="quiz-visual">
                        <div class="quiz-visual-orbit quiz-visual-orbit-1"></div>
                        <div class="quiz-visual-orbit quiz-visual-orbit-2"></div>
                        <div class="quiz-visual-main">
                            <i class="fa fa-brain"></i>
                        </div>
                        <div class="quiz-visual-float quiz-visual-float-1">
                            <i class="fa fa-check-circle"></i>
                            {{ $quiz->questions->count() }} Questions
                        </div>
                        <div class="quiz-visual-float quiz-visual-float-2">
                            <i class="fa fa-trophy"></i>
                            {{ $quiz->total_points }} Points
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="quiz-main">
        <div class="container">
            <!-- Alerts -->
            @if(session('success'))
                <div class="quiz-alert success">
                    <div class="quiz-alert-icon">
                        <i class="fa fa-check"></i>
                    </div>
                    <div class="quiz-alert-content">
                        <h4>Succès!</h4>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="quiz-alert error">
                    <div class="quiz-alert-icon">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="quiz-alert-content">
                        <h4>Erreur</h4>
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <!-- Info Cards Row -->
            <div class="info-cards-row">
                <div class="info-card-item">
                    <div class="info-card-icon">
                        <i class="fa fa-question-circle"></i>
                    </div>
                    <div class="info-card-value">{{ $quiz->questions->count() }}</div>
                    <div class="info-card-label">Question{{ $quiz->questions->count() > 1 ? 's' : '' }}</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-icon">
                        <i class="fa fa-trophy"></i>
                    </div>
                    <div class="info-card-value">{{ $quiz->total_points }}</div>
                    <div class="info-card-label">Points au total</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-icon">
                        <i class="fa fa-clock"></i>
                    </div>
                    <div class="info-card-value">{{ $quiz->duree_minutes ?? '∞' }}</div>
                    <div class="info-card-label">Minutes</div>
                </div>
                <div class="info-card-item">
                    <div class="info-card-icon">
                        <i class="fa fa-redo"></i>
                    </div>
                    <div class="info-card-value">{{ $quiz->nombre_tentatives - $attemptsCount }}</div>
                    <div class="info-card-label">Tentatives restantes</div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Main Column - CTA -->
                <div class="main-column">
                    <div class="quiz-cta-card">
                        <div class="cta-header">
                            <div class="cta-header-content">
                                <div class="cta-icon">
                                    <i class="fa fa-play"></i>
                                </div>
                                <h2 class="cta-title">
                                    @if($canAttempt)
                                        Prêt à relever le défi ?
                                    @elseif($hasPassed)
                                        Félicitations !
                                    @else
                                        Tentatives épuisées
                                    @endif
                                </h2>
                                <p class="cta-subtitle">
                                    @if($canAttempt)
                                        Testez vos connaissances et obtenez votre certification
                                    @elseif($hasPassed)
                                        Vous avez réussi ce quiz avec brio
                                    @else
                                        Vous avez utilisé toutes vos tentatives
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="cta-body">
                            <!-- Attempt progress -->
                            <div class="attempt-progress">
                                <div class="attempt-progress-header">
                                    <span class="attempt-progress-label">Tentatives utilisées</span>
                                    <span class="attempt-progress-count">{{ $attemptsCount }} / {{ $quiz->nombre_tentatives }}</span>
                                </div>
                                <div class="attempt-progress-bar">
                                    <div class="attempt-progress-fill" style="width: {{ $attemptsPercentage }}%;"></div>
                                </div>
                            </div>

                            <!-- Best score -->
                            @if($bestScore !== null)
                                <div class="best-score-card">
                                    <div class="best-score-icon">
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="best-score-info">
                                        <h4>Votre meilleur score</h4>
                                        <span class="best-score-value">{{ number_format($bestScore, 1) }}%</span>
                                    </div>
                                </div>
                            @endif

                            <!-- CTA Button -->
                            @if($canAttempt)
                                <form action="{{ route('quiz.start', $quiz->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-start-quiz">
                                        <i class="fa fa-play-circle"></i>
                                        {{ $attemptsCount > 0 ? 'Retenter le quiz' : 'Commencer le quiz' }}
                                    </button>
                                </form>
                            @else
                                <button class="btn-start-quiz disabled" disabled>
                                    <i class="fa fa-lock"></i>
                                    {{ $hasPassed ? 'Quiz réussi' : 'Aucune tentative disponible' }}
                                </button>

                                @if(!$hasPassed)
                                    <div class="attempts-warning">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        <div class="attempts-warning-text">
                                            <h4>Tentatives épuisées</h4>
                                            <p>Vous avez atteint le nombre maximum de tentatives pour ce quiz. Contactez un administrateur si vous souhaitez réessayer.</p>
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <!-- Features list -->
                            <div class="cta-features">
                                <div class="cta-feature">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Questions à choix multiples</span>
                                </div>
                                <div class="cta-feature">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Résultats instantanés après soumission</span>
                                </div>
                                <div class="cta-feature">
                                    <i class="fa fa-check-circle"></i>
                                    <span>Certificat si vous atteignez {{ $quiz->note_passage }}%</span>
                                </div>
                                @if($quiz->duree_minutes)
                                    <div class="cta-feature">
                                        <i class="fa fa-check-circle"></i>
                                        <span>Chronomètre de {{ $quiz->duree_minutes }} minutes</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="tips-card">
                        <div class="tips-header">
                            <i class="fa fa-lightbulb"></i>
                            <h3>Conseils pour réussir</h3>
                        </div>
                        <div class="tips-body">
                            <div class="tip-item">
                                <span class="tip-number">1</span>
                                <span class="tip-text">Lisez attentivement chaque question avant de répondre</span>
                            </div>
                            <div class="tip-item">
                                <span class="tip-number">2</span>
                                <span class="tip-text">Gérez votre temps si le quiz est chronométré</span>
                            </div>
                            <div class="tip-item">
                                <span class="tip-number">3</span>
                                <span class="tip-text">Ne laissez aucune question sans réponse</span>
                            </div>
                            <div class="tip-item">
                                <span class="tip-number">4</span>
                                <span class="tip-text">Révisez vos réponses avant de soumettre</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="sidebar-column">
                    <div class="sidebar-sticky">
                        <!-- History Card -->
                        <div class="history-card">
                            <div class="history-header">
                                <i class="fa fa-history"></i>
                                <h3>Historique des tentatives</h3>
                            </div>
                            <div class="history-body">
                                @if($previousAttempts->count() > 0)
                                    @foreach($previousAttempts as $index => $attempt)
                                        <div class="attempt-item {{ $attempt->reussi ? 'success' : 'failed' }}">
                                            <div class="attempt-header">
                                                <span class="attempt-number">Tentative {{ $previousAttempts->count() - $index }}</span>
                                                <span class="attempt-score {{ $attempt->reussi ? 'success' : 'failed' }}">
                                                    {{ number_format($attempt->score, 1) }}%
                                                </span>
                                            </div>
                                            <div class="attempt-meta">
                                                <div class="attempt-meta-item">
                                                    <i class="fa fa-calendar"></i>
                                                    <span>{{ $attempt->created_at->format('d/m/Y à H:i') }}</span>
                                                </div>
                                                <div class="attempt-meta-item">
                                                    <i class="fa fa-clock"></i>
                                                    <span>{{ $attempt->getDureeFormatted() }}</span>
                                                </div>
                                            </div>
                                            @if($attempt->fin_at)
                                                <a href="{{ route('quiz.result', [$quiz->id, $attempt->id]) }}" class="btn-view-result">
                                                    <i class="fa fa-eye"></i>
                                                    Voir les résultats
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="history-empty">
                                        <div class="history-empty-icon">
                                            <i class="fa fa-inbox"></i>
                                        </div>
                                        <h4>Aucune tentative</h4>
                                        <p>Vous n'avez pas encore passé ce quiz. Lancez-vous !</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
