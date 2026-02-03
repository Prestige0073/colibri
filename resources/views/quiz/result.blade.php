@extends('layouts.app')

@section('title', 'Résultats - ' . $quiz->titre . ' | Colibri Littéraire')

@push('styles')
<style>
    :root {
        --result-primary: #1e7a2f;
        --result-primary-dark: #155a22;
        --result-primary-light: #e8f5e9;
        --result-secondary: #f39c12;
        --result-success: #2ecc71;
        --result-danger: #e74c3c;
        --result-info: #3498db;
        --result-text: #2d3436;
        --result-text-muted: #636e72;
        --result-bg: #f8f9fa;
        --result-card: #ffffff;
        --result-radius: 16px;
        --result-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .quiz-result-page {
        background: var(--result-bg);
        min-height: 100vh;
        padding-bottom: 3rem;
    }

    /* ============================================
       HERO HEADER
       ============================================ */
    .result-hero {
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .result-hero.success {
        background: linear-gradient(135deg, var(--result-primary) 0%, var(--result-primary-dark) 100%);
    }

    .result-hero.failed {
        background: linear-gradient(135deg, var(--result-danger) 0%, #c0392b 100%);
    }

    .result-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 500px;
        height: 500px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .result-hero::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.03);
        border-radius: 50%;
    }

    .result-hero-content {
        position: relative;
        z-index: 2;
    }

    .result-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        margin-bottom: 1.5rem;
    }

    .result-breadcrumb a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: color 0.3s;
    }

    .result-breadcrumb a:hover {
        color: white;
    }

    .result-breadcrumb i {
        font-size: 0.7rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .result-breadcrumb span {
        color: white;
    }

    .result-hero-grid {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 3rem;
        align-items: center;
    }

    /* Status badge */
    .result-status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .result-status-badge.success {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .result-status-badge.failed {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .result-hero-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: white;
        margin: 0 0 0.5rem 0;
        line-height: 1.2;
    }

    .result-hero-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.9);
        margin: 0 0 1rem 0;
    }

    .result-hero-quiz-title {
        font-size: 1rem;
        color: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Score Circle */
    .score-circle-wrapper {
        position: relative;
    }

    .score-circle {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: white;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
    }

    .score-value {
        font-size: 3rem;
        font-weight: 800;
        line-height: 1;
    }

    .score-circle.success .score-value {
        color: var(--result-primary);
    }

    .score-circle.failed .score-value {
        color: var(--result-danger);
    }

    .score-label {
        font-size: 0.85rem;
        color: var(--result-text-muted);
        font-weight: 500;
    }

    .score-points {
        font-size: 0.9rem;
        color: var(--result-text);
        font-weight: 600;
        margin-top: 0.25rem;
    }

    /* Confetti effect for success */
    .confetti-wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 220px;
        height: 220px;
        pointer-events: none;
    }

    .confetti {
        position: absolute;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        animation: confettiFloat 3s ease-in-out infinite;
    }

    .confetti:nth-child(1) { background: var(--result-secondary); top: 0; left: 20%; animation-delay: 0s; }
    .confetti:nth-child(2) { background: var(--result-info); top: 10%; right: 10%; animation-delay: 0.3s; }
    .confetti:nth-child(3) { background: var(--result-primary); bottom: 10%; left: 10%; animation-delay: 0.6s; }
    .confetti:nth-child(4) { background: var(--result-success); bottom: 0; right: 20%; animation-delay: 0.9s; }
    .confetti:nth-child(5) { background: var(--result-danger); top: 30%; left: 0; animation-delay: 1.2s; }
    .confetti:nth-child(6) { background: var(--result-secondary); top: 50%; right: 0; animation-delay: 0.4s; }

    @keyframes confettiFloat {
        0%, 100% { transform: translateY(0) rotate(0deg); opacity: 1; }
        50% { transform: translateY(-15px) rotate(180deg); opacity: 0.7; }
    }

    /* ============================================
       STATS CARDS
       ============================================ */
    .stats-section {
        margin-top: -2rem;
        position: relative;
        z-index: 10;
        margin-bottom: 2rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }

    .stat-card {
        background: var(--result-card);
        border-radius: var(--result-radius);
        box-shadow: var(--result-shadow);
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .stat-card:nth-child(1)::before { background: var(--result-info); }
    .stat-card:nth-child(2)::before { background: var(--result-success); }
    .stat-card:nth-child(3)::before { background: var(--result-secondary); }
    .stat-card:nth-child(4)::before { background: var(--result-primary); }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.25rem;
    }

    .stat-card:nth-child(1) .stat-icon {
        background: #e8f4fc;
        color: var(--result-info);
    }

    .stat-card:nth-child(2) .stat-icon {
        background: #e8f8f0;
        color: var(--result-success);
    }

    .stat-card:nth-child(3) .stat-icon {
        background: #fef5e7;
        color: var(--result-secondary);
    }

    .stat-card:nth-child(4) .stat-icon {
        background: var(--result-primary-light);
        color: var(--result-primary);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--result-text);
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--result-text-muted);
        font-weight: 500;
    }

    /* ============================================
       MAIN CONTENT
       ============================================ */
    .result-main {
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 2rem;
        align-items: start;
    }

    /* ============================================
       CORRECTION SECTION
       ============================================ */
    .correction-section {
        background: var(--result-card);
        border-radius: var(--result-radius);
        box-shadow: var(--result-shadow);
        overflow: hidden;
    }

    .correction-header {
        background: linear-gradient(135deg, var(--result-primary-light) 0%, #c8e6c9 100%);
        padding: 1.25rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 3px solid var(--result-primary);
    }

    .correction-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--result-primary-dark);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 0;
    }

    .correction-title i {
        font-size: 1.25rem;
    }

    .correction-summary {
        display: flex;
        gap: 1rem;
    }

    .summary-badge {
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .summary-badge.correct {
        background: var(--result-success);
        color: white;
    }

    .summary-badge.incorrect {
        background: var(--result-danger);
        color: white;
    }

    .correction-body {
        padding: 1.5rem;
    }

    /* Question Card */
    .question-result-card {
        background: var(--result-bg);
        border-radius: 12px;
        margin-bottom: 1.25rem;
        overflow: hidden;
        border: 2px solid transparent;
        transition: all 0.3s;
    }

    .question-result-card:last-child {
        margin-bottom: 0;
    }

    .question-result-card.correct {
        border-color: var(--result-success);
    }

    .question-result-card.incorrect {
        border-color: var(--result-danger);
    }

    .question-result-header {
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .question-result-card.correct .question-result-header {
        background: linear-gradient(135deg, #e8f8f0 0%, #d4efdf 100%);
    }

    .question-result-card.incorrect .question-result-header {
        background: linear-gradient(135deg, #fdeaea 0%, #f8d7da 100%);
    }

    .question-result-info {
        flex: 1;
    }

    .question-result-number {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .question-number-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        color: white;
    }

    .question-result-card.correct .question-number-badge {
        background: var(--result-success);
    }

    .question-result-card.incorrect .question-number-badge {
        background: var(--result-danger);
    }

    .question-status-text {
        font-size: 0.8rem;
        font-weight: 600;
    }

    .question-result-card.correct .question-status-text {
        color: var(--result-success);
    }

    .question-result-card.incorrect .question-status-text {
        color: var(--result-danger);
    }

    .question-result-text {
        font-size: 1rem;
        font-weight: 600;
        color: var(--result-text);
        line-height: 1.5;
        margin: 0;
    }

    .question-points-badge {
        padding: 0.35rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .question-result-card.correct .question-points-badge {
        background: var(--result-success);
        color: white;
    }

    .question-result-card.incorrect .question-points-badge {
        background: var(--result-danger);
        color: white;
    }

    /* Options */
    .question-options {
        padding: 1rem 1.25rem;
    }

    .result-option {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border-radius: 10px;
        margin-bottom: 0.5rem;
        border: 2px solid #e9ecef;
        background: white;
        transition: all 0.3s;
    }

    .result-option:last-child {
        margin-bottom: 0;
    }

    .result-option.correct-answer {
        border-color: var(--result-success);
        background: #e8f8f0;
    }

    .result-option.user-wrong {
        border-color: var(--result-danger);
        background: #fdeaea;
    }

    .result-option.user-correct {
        border-color: var(--result-success);
        background: #e8f8f0;
    }

    .option-letter {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        flex-shrink: 0;
        background: #f8f9fa;
        color: var(--result-text-muted);
        border: 2px solid #dee2e6;
    }

    .result-option.correct-answer .option-letter,
    .result-option.user-correct .option-letter {
        background: var(--result-success);
        border-color: var(--result-success);
        color: white;
    }

    .result-option.user-wrong .option-letter {
        background: var(--result-danger);
        border-color: var(--result-danger);
        color: white;
    }

    .option-content {
        flex: 1;
    }

    .option-text {
        font-size: 0.95rem;
        color: var(--result-text);
        line-height: 1.4;
    }

    .option-badges {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.35rem;
        flex-wrap: wrap;
    }

    .option-badge {
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .option-badge.correct {
        background: var(--result-success);
        color: white;
    }

    .option-badge.user {
        background: var(--result-info);
        color: white;
    }

    .option-badge.wrong {
        background: var(--result-danger);
        color: white;
    }

    /* Explanation */
    .question-explanation {
        padding: 0 1.25rem 1rem;
    }

    .explanation-box {
        background: linear-gradient(135deg, #e8f4fc 0%, #d4e9f7 100%);
        border: 1px solid var(--result-info);
        border-radius: 10px;
        padding: 1rem;
        display: flex;
        gap: 0.75rem;
    }

    .explanation-icon {
        width: 32px;
        height: 32px;
        background: var(--result-info);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .explanation-icon i {
        color: white;
        font-size: 0.9rem;
    }

    .explanation-content h4 {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--result-info);
        margin: 0 0 0.35rem 0;
    }

    .explanation-content p {
        font-size: 0.9rem;
        color: var(--result-text);
        margin: 0;
        line-height: 1.5;
    }

    /* ============================================
       SIDEBAR
       ============================================ */
    .result-sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    /* Performance Card */
    .performance-card {
        background: var(--result-card);
        border-radius: var(--result-radius);
        box-shadow: var(--result-shadow);
        overflow: hidden;
    }

    .performance-header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, var(--result-primary) 0%, var(--result-primary-dark) 100%);
        color: white;
    }

    .performance-header h3 {
        font-size: 1rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .performance-body {
        padding: 1.25rem;
    }

    .performance-meter {
        margin-bottom: 1.5rem;
    }

    .meter-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.85rem;
        color: var(--result-text);
    }

    .meter-bar {
        height: 12px;
        background: #e9ecef;
        border-radius: 6px;
        overflow: hidden;
    }

    .meter-fill {
        height: 100%;
        border-radius: 6px;
        transition: width 1s ease;
    }

    .meter-fill.success {
        background: linear-gradient(90deg, var(--result-success) 0%, #27ae60 100%);
    }

    .meter-fill.warning {
        background: linear-gradient(90deg, var(--result-secondary) 0%, #e67e22 100%);
    }

    .meter-fill.danger {
        background: linear-gradient(90deg, var(--result-danger) 0%, #c0392b 100%);
    }

    .performance-details {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
        border-bottom: 1px solid #f1f3f5;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-size: 0.85rem;
        color: var(--result-text-muted);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-label i {
        width: 16px;
        text-align: center;
        color: var(--result-primary);
    }

    .detail-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--result-text);
    }

    /* Actions Card */
    .actions-card {
        background: var(--result-card);
        border-radius: var(--result-radius);
        box-shadow: var(--result-shadow);
        padding: 1.5rem;
    }

    .actions-card h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--result-text);
        margin: 0 0 1rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .btn-action {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.85rem 1.25rem;
        border-radius: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-action.primary {
        background: linear-gradient(135deg, var(--result-primary) 0%, var(--result-primary-dark) 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-action.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 122, 47, 0.4);
        color: white;
    }

    .btn-action.secondary {
        background: white;
        color: var(--result-text);
        border: 2px solid #e9ecef;
    }

    .btn-action.secondary:hover {
        border-color: var(--result-primary);
        color: var(--result-primary);
    }

    .btn-action.retry {
        background: linear-gradient(135deg, var(--result-secondary) 0%, #e67e22 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
    }

    .btn-action.retry:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(243, 156, 18, 0.4);
        color: white;
    }

    /* Tips Card */
    .tips-card {
        background: linear-gradient(135deg, #fff8e6 0%, #fef5e7 100%);
        border: 2px solid var(--result-secondary);
        border-radius: var(--result-radius);
        padding: 1.25rem;
    }

    .tips-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .tips-icon {
        width: 40px;
        height: 40px;
        background: var(--result-secondary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .tips-icon i {
        color: white;
        font-size: 1.1rem;
    }

    .tips-header h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--result-text);
        margin: 0;
    }

    .tips-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .tip-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--result-text);
        line-height: 1.5;
    }

    .tip-item i {
        color: var(--result-secondary);
        margin-top: 0.2rem;
    }

    /* ============================================
       NO CORRECTION MESSAGE
       ============================================ */
    .no-correction-message {
        background: var(--result-card);
        border-radius: var(--result-radius);
        box-shadow: var(--result-shadow);
        padding: 3rem 2rem;
        text-align: center;
    }

    .no-correction-icon {
        width: 80px;
        height: 80px;
        background: var(--result-primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .no-correction-icon i {
        font-size: 2rem;
        color: var(--result-primary);
    }

    .no-correction-message h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--result-text);
        margin: 0 0 0.5rem 0;
    }

    .no-correction-message p {
        color: var(--result-text-muted);
        margin: 0;
        font-size: 0.95rem;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1199px) {
        .result-main {
            grid-template-columns: 1fr;
        }

        .result-sidebar {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        .tips-card {
            grid-column: span 2;
        }
    }

    @media (max-width: 991px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 767px) {
        .result-hero {
            padding: 2rem 0;
        }

        .result-hero-grid {
            grid-template-columns: 1fr;
            text-align: center;
            gap: 2rem;
        }

        .result-hero-title {
            font-size: 1.75rem;
        }

        .result-hero-quiz-title {
            justify-content: center;
        }

        .score-circle-wrapper {
            display: flex;
            justify-content: center;
        }

        .score-circle {
            width: 150px;
            height: 150px;
        }

        .score-value {
            font-size: 2.5rem;
        }

        .result-sidebar {
            grid-template-columns: 1fr;
        }

        .tips-card {
            grid-column: span 1;
        }

        .correction-header {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }
    }

    @media (max-width: 575px) {
        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 0.75rem;
        }

        .stat-card {
            padding: 1rem;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            font-size: 1rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .question-result-header {
            flex-direction: column;
        }

        .question-points-badge {
            align-self: flex-start;
        }

        .result-breadcrumb {
            display: none;
        }
    }
</style>
@endpush

@section('content')
@php
    $totalQuestions = $questions->count();
    $correctCount = collect($questions)->filter(function($q) use ($userAnswers) {
        $selected = $userAnswers[$q->id] ?? null;
        return $q->isCorrectAnswer($selected);
    })->count();
    $incorrectCount = $totalQuestions - $correctCount;
    $scorePercentage = $attempt->score;
@endphp

<div class="quiz-result-page">
    <!-- Hero Header -->
    <div class="result-hero {{ $attempt->reussi ? 'success' : 'failed' }}">
        <div class="container">
            <div class="result-hero-content">
                <nav class="result-breadcrumb">
                    <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                    <i class="fa fa-chevron-right"></i>
                    <a href="{{ route('quiz.show', $quiz->id) }}">{{ Str::limit($quiz->titre, 30) }}</a>
                    <i class="fa fa-chevron-right"></i>
                    <span>Résultats</span>
                </nav>

                <div class="result-hero-grid">
                    <div class="result-hero-info">
                        <div class="result-status-badge {{ $attempt->reussi ? 'success' : 'failed' }}">
                            @if($attempt->reussi)
                                <i class="fa fa-check-circle"></i>
                                Quiz réussi
                            @else
                                <i class="fa fa-times-circle"></i>
                                Quiz non réussi
                            @endif
                        </div>

                        <h1 class="result-hero-title">
                            @if($attempt->reussi)
                                Félicitations !
                            @else
                                Continuez vos efforts !
                            @endif
                        </h1>

                        <p class="result-hero-subtitle">
                            @if($attempt->reussi)
                                Vous avez brillamment réussi ce quiz. Votre travail a porté ses fruits !
                            @else
                                Vous n'avez pas atteint la note de passage ({{ $quiz->note_passage }}%). N'abandonnez pas !
                            @endif
                        </p>

                        <div class="result-hero-quiz-title">
                            <i class="fa fa-book-open"></i>
                            {{ $quiz->titre }}
                        </div>
                    </div>

                    <div class="score-circle-wrapper">
                        @if($attempt->reussi)
                            <div class="confetti-wrapper">
                                <div class="confetti"></div>
                                <div class="confetti"></div>
                                <div class="confetti"></div>
                                <div class="confetti"></div>
                                <div class="confetti"></div>
                                <div class="confetti"></div>
                            </div>
                        @endif
                        <div class="score-circle {{ $attempt->reussi ? 'success' : 'failed' }}">
                            <span class="score-value">{{ number_format($attempt->score, 0) }}%</span>
                            <span class="score-label">Score obtenu</span>
                            <span class="score-points">{{ $attempt->points_obtenus }}/{{ $attempt->points_total }} pts</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-question-circle"></i>
                    </div>
                    <div class="stat-value">{{ $totalQuestions }}</div>
                    <div class="stat-label">Questions</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <div class="stat-value">{{ $correctCount }}</div>
                    <div class="stat-label">Correctes</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-clock"></i>
                    </div>
                    <div class="stat-value">{{ $attempt->getDureeFormatted() }}</div>
                    <div class="stat-label">Durée</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-calendar-alt"></i>
                    </div>
                    <div class="stat-value">{{ $attempt->created_at->format('d/m') }}</div>
                    <div class="stat-label">{{ $attempt->created_at->format('H:i') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="result-main">
            <!-- Correction Section -->
            <div class="correction-section-wrapper">
                @if($quiz->afficher_reponses)
                    <div class="correction-section">
                        <div class="correction-header">
                            <h2 class="correction-title">
                                <i class="fa fa-clipboard-list"></i>
                                Correction détaillée
                            </h2>
                            <div class="correction-summary">
                                <span class="summary-badge correct">
                                    <i class="fa fa-check"></i>
                                    {{ $correctCount }} correctes
                                </span>
                                <span class="summary-badge incorrect">
                                    <i class="fa fa-times"></i>
                                    {{ $incorrectCount }} incorrectes
                                </span>
                            </div>
                        </div>

                        <div class="correction-body">
                            @foreach($questions as $index => $question)
                                @php
                                    $userAnswer = $userAnswers[$question->id] ?? null;
                                    $isCorrect = $question->isCorrectAnswer($userAnswer);
                                    $correctOptionIds = $question->getCorrectOptionIds();
                                @endphp

                                <div class="question-result-card {{ $isCorrect ? 'correct' : 'incorrect' }}">
                                    <div class="question-result-header">
                                        <div class="question-result-info">
                                            <div class="question-result-number">
                                                <div class="question-number-badge">{{ $index + 1 }}</div>
                                                <span class="question-status-text">
                                                    {{ $isCorrect ? 'Bonne réponse' : 'Mauvaise réponse' }}
                                                </span>
                                            </div>
                                            <p class="question-result-text">{{ $question->question }}</p>
                                        </div>
                                        <span class="question-points-badge">
                                            @if($isCorrect)
                                                <i class="fa fa-check"></i> +{{ $question->points }} pts
                                            @else
                                                <i class="fa fa-times"></i> 0 pt
                                            @endif
                                        </span>
                                    </div>

                                    <div class="question-options">
                                        @foreach($question->options as $optIndex => $option)
                                            @php
                                                $isUserChoice = false;
                                                if (is_array($userAnswer)) {
                                                    $isUserChoice = in_array($option->id, $userAnswer);
                                                } else {
                                                    $isUserChoice = $userAnswer == $option->id;
                                                }

                                                $optionClass = '';
                                                if ($option->is_correct && $isUserChoice) {
                                                    $optionClass = 'user-correct';
                                                } elseif ($option->is_correct) {
                                                    $optionClass = 'correct-answer';
                                                } elseif ($isUserChoice && !$option->is_correct) {
                                                    $optionClass = 'user-wrong';
                                                }
                                            @endphp

                                            <div class="result-option {{ $optionClass }}">
                                                <div class="option-letter">{{ chr(65 + $optIndex) }}</div>
                                                <div class="option-content">
                                                    <div class="option-text">{{ $option->option_text }}</div>
                                                    @if($option->is_correct || $isUserChoice)
                                                        <div class="option-badges">
                                                            @if($option->is_correct)
                                                                <span class="option-badge correct">
                                                                    <i class="fa fa-check"></i> Bonne réponse
                                                                </span>
                                                            @endif
                                                            @if($isUserChoice)
                                                                <span class="option-badge {{ $option->is_correct ? 'user' : 'wrong' }}">
                                                                    <i class="fa fa-user"></i> Votre choix
                                                                </span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($question->explication)
                                        <div class="question-explanation">
                                            <div class="explanation-box">
                                                <div class="explanation-icon">
                                                    <i class="fa fa-lightbulb"></i>
                                                </div>
                                                <div class="explanation-content">
                                                    <h4>Explication</h4>
                                                    <p>{{ $question->explication }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="no-correction-message">
                        <div class="no-correction-icon">
                            <i class="fa fa-lock"></i>
                        </div>
                        <h3>Correction non disponible</h3>
                        <p>La correction détaillée n'est pas disponible pour ce quiz. Contactez votre formateur pour plus d'informations.</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="result-sidebar">
                <!-- Performance Card -->
                <div class="performance-card">
                    <div class="performance-header">
                        <h3>
                            <i class="fa fa-chart-line"></i>
                            Performance
                        </h3>
                    </div>
                    <div class="performance-body">
                        <div class="performance-meter">
                            <div class="meter-label">
                                <span>Progression</span>
                                <span>{{ number_format($scorePercentage, 0) }}%</span>
                            </div>
                            <div class="meter-bar">
                                <div class="meter-fill {{ $scorePercentage >= 70 ? 'success' : ($scorePercentage >= 50 ? 'warning' : 'danger') }}"
                                     style="width: {{ $scorePercentage }}%;"></div>
                            </div>
                        </div>

                        <div class="performance-details">
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fa fa-bullseye"></i>
                                    Note de passage
                                </span>
                                <span class="detail-value">{{ $quiz->note_passage }}%</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fa fa-trophy"></i>
                                    Points obtenus
                                </span>
                                <span class="detail-value">{{ $attempt->points_obtenus }}/{{ $attempt->points_total }}</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fa fa-percentage"></i>
                                    Taux de réussite
                                </span>
                                <span class="detail-value">{{ number_format(($correctCount / $totalQuestions) * 100, 0) }}%</span>
                            </div>
                            <div class="detail-row">
                                <span class="detail-label">
                                    <i class="fa fa-redo"></i>
                                    Tentative n°
                                </span>
                                <span class="detail-value">{{ $attempt->numero_tentative ?? 1 }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions Card -->
                <div class="actions-card">
                    <h3>
                        <i class="fa fa-hand-pointer"></i>
                        Actions
                    </h3>
                    <div class="action-buttons">
                        @php
                            $canRetry = $quiz->userCanAttempt(Auth::id());
                        @endphp

                        @if($canRetry && !$attempt->reussi)
                            <form action="{{ route('quiz.start', $quiz->id) }}" method="POST" style="display: contents;">
                                @csrf
                                <button type="submit" class="btn-action retry">
                                    <i class="fa fa-redo"></i>
                                    Réessayer le quiz
                                </button>
                            </form>
                        @endif

                        @if($attempt->reussi && $quiz->formation)
                            <a href="{{ route('formation.show', $quiz->formation->id) }}" class="btn-action primary">
                                <i class="fa fa-graduation-cap"></i>
                                Continuer la formation
                            </a>
                        @endif

                        <a href="{{ route('quiz.show', $quiz->id) }}" class="btn-action secondary">
                            <i class="fa fa-arrow-left"></i>
                            Retour au quiz
                        </a>
                    </div>
                </div>

                <!-- Tips Card -->
                @if(!$attempt->reussi)
                    <div class="tips-card">
                        <div class="tips-header">
                            <div class="tips-icon">
                                <i class="fa fa-lightbulb"></i>
                            </div>
                            <h3>Conseils pour réussir</h3>
                        </div>
                        <div class="tips-list">
                            <div class="tip-item">
                                <i class="fa fa-check"></i>
                                <span>Relisez attentivement chaque question avant de répondre</span>
                            </div>
                            <div class="tip-item">
                                <i class="fa fa-check"></i>
                                <span>Révisez les notions des questions incorrectes</span>
                            </div>
                            <div class="tip-item">
                                <i class="fa fa-check"></i>
                                <span>Prenez le temps de bien comprendre les explications</span>
                            </div>
                            <div class="tip-item">
                                <i class="fa fa-check"></i>
                                <span>N'hésitez pas à réessayer, la persévérance paie !</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="tips-card" style="background: linear-gradient(135deg, #e8f8f0 0%, #d4efdf 100%); border-color: var(--result-success);">
                        <div class="tips-header">
                            <div class="tips-icon" style="background: var(--result-success);">
                                <i class="fa fa-star"></i>
                            </div>
                            <h3>Bravo !</h3>
                        </div>
                        <div class="tips-list">
                            <div class="tip-item">
                                <i class="fa fa-trophy" style="color: var(--result-success);"></i>
                                <span>Vous avez démontré une excellente maîtrise du sujet</span>
                            </div>
                            <div class="tip-item">
                                <i class="fa fa-arrow-right" style="color: var(--result-success);"></i>
                                <span>Continuez votre progression avec les autres modules</span>
                            </div>
                            <div class="tip-item">
                                <i class="fa fa-share-alt" style="color: var(--result-success);"></i>
                                <span>Partagez votre réussite avec vos collègues</span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
