@extends('layouts.app')

@section('title', $quiz->titre . ' | Passer le Quiz - Colibri Littéraire')

@push('styles')
<style>
    :root {
        --take-primary: #1e7a2f;
        --take-primary-dark: #155a22;
        --take-primary-light: #e8f5e9;
        --take-secondary: #f39c12;
        --take-success: #2ecc71;
        --take-danger: #e74c3c;
        --take-info: #3498db;
        --take-purple: #9b59b6;
        --take-text: #2d3436;
        --take-text-muted: #636e72;
        --take-bg: #f8f9fa;
        --take-card: #ffffff;
        --take-radius: 16px;
        --take-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }

    .quiz-take-page {
        background: var(--take-bg);
        min-height: 100vh;
        padding-bottom: 2rem;
    }

    /* ============================================
       HEADER COMPACT (non-sticky)
       ============================================ */
    .quiz-header-compact {
        background: linear-gradient(135deg, var(--take-primary) 0%, var(--take-primary-dark) 100%);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .quiz-header-content {
        padding: 0.75rem 0;
    }

    .quiz-header-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .quiz-header-left {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .quiz-back-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.15);
        border: none;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .quiz-back-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: scale(1.05);
    }

    .quiz-header-info h1 {
        font-size: 1rem;
        font-weight: 700;
        color: white;
        margin: 0;
        line-height: 1.3;
    }

    .quiz-header-meta {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.8rem;
        color: rgba(255, 255, 255, 0.85);
    }

    .quiz-header-meta span {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Timer compact */
    .quiz-timer {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 10px;
        padding: 0.5rem 1rem;
    }

    .quiz-timer-label {
        display: none;
    }

    .quiz-timer-value {
        font-size: 1.1rem;
        font-weight: 800;
        color: white;
        font-family: 'Courier New', monospace;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .quiz-timer-value i {
        font-size: 0.9rem;
    }

    .quiz-timer.warning {
        background: rgba(243, 156, 18, 0.9);
        animation: timerPulse 1s ease-in-out infinite;
    }

    .quiz-timer.danger {
        background: rgba(231, 76, 60, 0.9);
        animation: timerPulse 0.5s ease-in-out infinite;
    }

    @keyframes timerPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
    }

    /* Progress bar inline */
    .quiz-progress-inline {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(0, 0, 0, 0.15);
        padding: 0.4rem 0.75rem;
        border-radius: 8px;
    }

    .quiz-progress-bar {
        width: 80px;
        height: 6px;
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
        overflow: hidden;
    }

    .quiz-progress-fill {
        height: 100%;
        background: var(--take-secondary);
        border-radius: 3px;
        transition: width 0.5s ease;
    }

    .quiz-progress-text {
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        white-space: nowrap;
    }

    /* ============================================
       QUESTIONS NAVIGATION (horizontal compact)
       ============================================ */
    .questions-nav-horizontal {
        background: var(--take-card);
        border-radius: 12px;
        box-shadow: var(--take-shadow);
        padding: 0.75rem 1rem;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        overflow-x: auto;
        scrollbar-width: thin;
    }

    .questions-nav-horizontal::-webkit-scrollbar {
        height: 4px;
    }

    .questions-nav-horizontal::-webkit-scrollbar-thumb {
        background: var(--take-primary-light);
        border-radius: 2px;
    }

    .questions-nav-title {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--take-text-muted);
        font-weight: 600;
        white-space: nowrap;
    }

    .questions-nav-grid {
        display: flex;
        gap: 0.35rem;
        flex-wrap: nowrap;
    }

    .question-nav-item {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: 2px solid #e9ecef;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--take-text-muted);
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        flex-shrink: 0;
    }

    .question-nav-item:hover {
        border-color: var(--take-primary);
        color: var(--take-primary);
    }

    .question-nav-item.answered {
        background: var(--take-primary);
        border-color: var(--take-primary);
        color: white;
    }

    .question-nav-item.current {
        border-color: var(--take-secondary);
        box-shadow: 0 0 0 2px rgba(243, 156, 18, 0.3);
    }

    /* ============================================
       QUESTION CARDS
       ============================================ */
    .question-card {
        background: var(--take-card);
        border-radius: var(--take-radius);
        box-shadow: var(--take-shadow);
        margin-bottom: 1.25rem;
        overflow: hidden;
        transition: all 0.3s;
        scroll-margin-top: 20px;
    }

    .question-card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .question-header {
        background: linear-gradient(135deg, var(--take-primary-light) 0%, #c8e6c9 100%);
        padding: 0.75rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid var(--take-primary);
    }

    .question-number {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .question-number-badge {
        width: 36px;
        height: 36px;
        background: var(--take-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.95rem;
        color: white;
    }

    .question-number-text {
        font-size: 0.8rem;
        color: var(--take-primary-dark);
        font-weight: 600;
    }

    .question-badges {
        display: flex;
        gap: 0.4rem;
    }

    .question-badge {
        padding: 0.3rem 0.65rem;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .question-badge.points {
        background: var(--take-secondary);
        color: white;
    }

    .question-badge.multiple {
        background: var(--take-purple);
        color: white;
    }

    .question-body {
        padding: 1.25rem;
    }

    .question-text {
        font-size: 1.05rem;
        font-weight: 600;
        color: var(--take-text);
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    /* Options */
    .options-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .option-wrapper {
        position: relative;
    }

    .option-input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .option-label {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .option-label:hover {
        border-color: var(--take-primary-light);
        background: var(--take-primary-light);
    }

    .option-indicator {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        background: #f8f9fa;
        border: 2px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.8rem;
        color: var(--take-text-muted);
        flex-shrink: 0;
        transition: all 0.3s;
    }

    .option-text {
        flex: 1;
        font-size: 0.95rem;
        color: var(--take-text);
        line-height: 1.4;
    }

    .option-check {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.3s;
    }

    .option-check i {
        font-size: 0.7rem;
        color: transparent;
        transition: all 0.3s;
    }

    /* Selected state */
    .option-input:checked + .option-label {
        border-color: var(--take-primary);
        background: var(--take-primary-light);
    }

    .option-input:checked + .option-label .option-indicator {
        background: var(--take-primary);
        border-color: var(--take-primary);
        color: white;
    }

    .option-input:checked + .option-label .option-check {
        background: var(--take-primary);
        border-color: var(--take-primary);
    }

    .option-input:checked + .option-label .option-check i {
        color: white;
    }

    /* Click animation */
    .option-label.clicked {
        transform: scale(0.98);
    }

    /* ============================================
       FOOTER COMPACT (non-sticky)
       ============================================ */
    .quiz-footer-compact {
        background: var(--take-card);
        box-shadow: 0 -2px 15px rgba(0, 0, 0, 0.08);
        padding: 1rem 0;
        margin-top: 1.5rem;
        border-radius: var(--take-radius) var(--take-radius) 0 0;
    }

    .quiz-footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .quiz-footer-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .footer-stat {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.85rem;
    }

    .footer-stat-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
    }

    .footer-stat-icon.answered {
        background: var(--take-primary-light);
        color: var(--take-primary);
    }

    .footer-stat-icon.remaining {
        background: #fef5e7;
        color: var(--take-secondary);
    }

    .footer-stat-text {
        color: var(--take-text-muted);
        font-size: 0.8rem;
    }

    .footer-stat-text strong {
        color: var(--take-text);
    }

    .quiz-footer-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-abandon {
        padding: 0.65rem 1rem;
        border-radius: 10px;
        font-size: 0.85rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        border: 2px solid #e9ecef;
        background: white;
        color: var(--take-text-muted);
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-abandon:hover {
        border-color: var(--take-danger);
        color: var(--take-danger);
        background: #fef2f2;
    }

    .btn-submit-quiz {
        padding: 0.65rem 1.5rem;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        border: none;
        background: linear-gradient(135deg, var(--take-primary) 0%, var(--take-primary-dark) 100%);
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
    }

    .btn-submit-quiz:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 122, 47, 0.4);
    }

    .btn-submit-quiz:active {
        transform: translateY(0);
    }

    .btn-submit-quiz i {
        font-size: 0.95rem;
    }

    /* ============================================
       MODALS
       ============================================ */
    .quiz-modal {
        border: none;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 25px 80px rgba(0, 0, 0, 0.2);
    }

    .quiz-modal-header {
        padding: 2rem;
        display: flex;
        justify-content: center;
    }

    .quiz-modal-header.warning {
        background: linear-gradient(135deg, var(--take-secondary) 0%, #e67e22 100%);
    }

    .quiz-modal-header.danger {
        background: linear-gradient(135deg, var(--take-danger) 0%, #c0392b 100%);
    }

    .modal-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .quiz-modal-body {
        padding: 2rem;
        text-align: center;
    }

    .quiz-modal-body h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--take-text);
        margin: 0 0 0.75rem 0;
    }

    .quiz-modal-body p {
        color: var(--take-text-muted);
        font-size: 1rem;
        margin: 0;
        line-height: 1.6;
    }

    .modal-warning-box {
        background: #fef5e7;
        border: 1px solid var(--take-secondary);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.25rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        text-align: left;
    }

    .modal-warning-box i {
        color: var(--take-secondary);
        font-size: 1.1rem;
        margin-top: 0.1rem;
    }

    .modal-warning-box span {
        color: #9a7d0a;
        font-size: 0.9rem;
    }

    .quiz-modal-footer {
        padding: 0 2rem 2rem;
        display: flex;
        gap: 0.75rem;
    }

    .btn-modal-cancel {
        flex: 1;
        padding: 1rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        border: 2px solid #e9ecef;
        background: white;
        color: var(--take-text);
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-modal-cancel:hover {
        border-color: var(--take-primary);
        color: var(--take-primary);
    }

    .btn-modal-confirm {
        flex: 1;
        padding: 1rem;
        border-radius: 12px;
        font-size: 0.95rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-modal-confirm.danger {
        background: linear-gradient(135deg, var(--take-danger) 0%, #c0392b 100%);
        color: white;
    }

    .btn-modal-confirm.danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(231, 76, 60, 0.4);
        color: white;
    }

    /* Time Up Modal */
    .quiz-modal-header.time-up {
        background: linear-gradient(135deg, var(--take-info) 0%, #2980b9 100%);
    }

    .modal-warning-box.time-up-box {
        background: #e8f4fc;
        border-color: var(--take-info);
    }

    .modal-warning-box.time-up-box i {
        color: var(--take-info);
    }

    .modal-warning-box.time-up-box span {
        color: #1a5276;
    }

    .btn-modal-confirm.success {
        background: linear-gradient(135deg, var(--take-primary) 0%, var(--take-primary-dark) 100%);
        color: white;
    }

    .btn-modal-confirm.success:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(30, 122, 47, 0.4);
        color: white;
    }

    .quiz-modal-footer.single {
        justify-content: center;
    }

    .quiz-modal-footer.single .btn-modal-confirm {
        flex: none;
        min-width: 200px;
    }

    /* ============================================
       LAYOUT
       ============================================ */
    .quiz-main-content {
        padding-top: 1.25rem;
        padding-bottom: 2rem;
    }

    .quiz-layout {
        display: flex;
        flex-direction: column;
        gap: 0;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 767px) {
        .quiz-header-main {
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .quiz-header-left {
            flex: 1;
            min-width: 200px;
        }

        .quiz-header-info h1 {
            font-size: 0.9rem;
        }

        .quiz-header-meta {
            font-size: 0.7rem;
            gap: 0.5rem;
        }

        .quiz-timer {
            padding: 0.4rem 0.75rem;
        }

        .quiz-timer-value {
            font-size: 0.95rem;
        }

        .quiz-progress-inline {
            display: none;
        }

        .question-header {
            flex-direction: column;
            gap: 0.5rem;
            text-align: center;
            padding: 0.6rem 0.75rem;
        }

        .question-number {
            flex-direction: row;
            justify-content: center;
        }

        .question-body {
            padding: 1rem;
        }

        .question-text {
            font-size: 0.95rem;
        }

        .quiz-footer-content {
            flex-direction: column;
            gap: 0.75rem;
        }

        .quiz-footer-info {
            justify-content: center;
        }

        .quiz-footer-actions {
            width: 100%;
        }

        .btn-abandon, .btn-submit-quiz {
            flex: 1;
            justify-content: center;
        }

        .option-label {
            padding: 0.6rem 0.75rem;
        }

        .option-indicator {
            width: 26px;
            height: 26px;
            font-size: 0.75rem;
        }

        .option-text {
            font-size: 0.9rem;
        }

        .option-check {
            width: 20px;
            height: 20px;
        }

        .questions-nav-horizontal {
            padding: 0.5rem 0.75rem;
        }

        .question-nav-item {
            width: 28px;
            height: 28px;
            font-size: 0.7rem;
        }
    }

    @media (max-width: 575px) {
        .quiz-header-content {
            padding: 0.5rem 0;
        }

        .quiz-header-info h1 {
            font-size: 0.85rem;
        }

        .quiz-back-btn {
            width: 32px;
            height: 32px;
        }

        .quiz-modal-footer {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
@php
    $totalQuestions = $questions->count();
@endphp

<div class="quiz-take-page">
    <!-- Header Compact (non-sticky) -->
    <div class="quiz-header-compact">
        <div class="container">
            <div class="quiz-header-content">
                <div class="quiz-header-main">
                    <div class="quiz-header-left">
                        <button type="button" class="quiz-back-btn" data-bs-toggle="modal" data-bs-target="#abandonModal">
                            <i class="fa fa-arrow-left"></i>
                        </button>
                        <div class="quiz-header-info">
                            <h1>{{ Str::limit($quiz->titre, 50) }}</h1>
                            <div class="quiz-header-meta">
                                <span><i class="fa fa-question-circle"></i> {{ $totalQuestions }} Q</span>
                                <span><i class="fa fa-trophy"></i> {{ $quiz->total_points }} pts</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress inline -->
                    <div class="quiz-progress-inline">
                        <div class="quiz-progress-bar">
                            <div class="quiz-progress-fill" id="progress-fill" style="width: 0%;"></div>
                        </div>
                        <div class="quiz-progress-text">
                            <span id="answered-count">0</span>/{{ $totalQuestions }}
                        </div>
                    </div>

                    @if($quiz->duree_minutes)
                        <div class="quiz-timer" id="quiz-timer">
                            <span class="quiz-timer-value">
                                <i class="fa fa-clock"></i>
                                <span id="timer-display">{{ $quiz->duree_minutes }}:00</span>
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="quiz-main-content">
        <div class="container">
            <form action="{{ route('quiz.submit', [$quiz->id, $attempt->id]) }}" method="POST" id="quiz-form">
                @csrf

                <div class="quiz-layout">
                    <!-- Navigation horizontale compacte -->
                    <div class="questions-nav-horizontal">
                        <div class="questions-nav-title">Questions:</div>
                        <div class="questions-nav-grid">
                            @foreach($questions as $index => $question)
                                <a href="#question-{{ $question->id }}"
                                   class="question-nav-item"
                                   data-question="{{ $question->id }}"
                                   id="nav-{{ $question->id }}">
                                    {{ $index + 1 }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Questions -->
                    <div class="questions-container">
                        @foreach($questions as $index => $question)
                            <div class="question-card" id="question-{{ $question->id }}" data-question-id="{{ $question->id }}">
                                <div class="question-header">
                                    <div class="question-number">
                                        <div class="question-number-badge">{{ $index + 1 }}</div>
                                        <div class="question-number-text">Question {{ $index + 1 }} sur {{ $totalQuestions }}</div>
                                    </div>
                                    <div class="question-badges">
                                        <span class="question-badge points">
                                            <i class="fa fa-star"></i>
                                            {{ $question->points }} pt{{ $question->points > 1 ? 's' : '' }}
                                        </span>
                                        @if($question->type === 'choix_multiple')
                                            <span class="question-badge multiple">
                                                <i class="fa fa-check-double"></i>
                                                Multiple
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="question-body">
                                    <div class="question-text">{{ $question->question }}</div>

                                    <div class="options-list">
                                        @foreach($question->options as $optIndex => $option)
                                            <div class="option-wrapper">
                                                @if($question->type === 'choix_multiple')
                                                    <input type="checkbox"
                                                           class="option-input"
                                                           name="reponses[{{ $question->id }}][]"
                                                           value="{{ $option->id }}"
                                                           id="option_{{ $question->id }}_{{ $option->id }}"
                                                           data-question="{{ $question->id }}">
                                                @else
                                                    <input type="radio"
                                                           class="option-input"
                                                           name="reponses[{{ $question->id }}]"
                                                           value="{{ $option->id }}"
                                                           id="option_{{ $question->id }}_{{ $option->id }}"
                                                           data-question="{{ $question->id }}">
                                                @endif
                                                <label class="option-label" for="option_{{ $question->id }}_{{ $option->id }}">
                                                    <div class="option-indicator">{{ chr(65 + $optIndex) }}</div>
                                                    <div class="option-text">{{ $option->option_text }}</div>
                                                    <div class="option-check">
                                                        <i class="fa fa-check"></i>
                                                    </div>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Footer Compact (dans le flow) -->
                    <div class="quiz-footer-compact">
                        <div class="quiz-footer-content">
                            <div class="quiz-footer-info">
                                <div class="footer-stat">
                                    <div class="footer-stat-icon answered">
                                        <i class="fa fa-check"></i>
                                    </div>
                                    <div class="footer-stat-text">
                                        <strong id="footer-answered">0</strong> répondue(s)
                                    </div>
                                </div>
                                <div class="footer-stat">
                                    <div class="footer-stat-icon remaining">
                                        <i class="fa fa-hourglass-half"></i>
                                    </div>
                                    <div class="footer-stat-text">
                                        <strong id="footer-remaining">{{ $totalQuestions }}</strong> restante(s)
                                    </div>
                                </div>
                            </div>

                            <div class="quiz-footer-actions">
                                <button type="button" class="btn-abandon" data-bs-toggle="modal" data-bs-target="#abandonModal">
                                    <i class="fa fa-times"></i>
                                    Abandonner
                                </button>
                                <button type="submit" form="quiz-form" class="btn-submit-quiz" id="submit-btn">
                                    <i class="fa fa-paper-plane"></i>
                                    Soumettre
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal d'abandon -->
<div class="modal fade" id="abandonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content quiz-modal">
            <div class="quiz-modal-header warning">
                <div class="modal-icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
            </div>
            <div class="quiz-modal-body">
                <h3>Abandonner le quiz ?</h3>
                <p>Êtes-vous sûr de vouloir abandonner ce quiz maintenant ?</p>
                <div class="modal-warning-box">
                    <i class="fa fa-info-circle"></i>
                    <span>Vos réponses ne seront pas enregistrées et cette tentative sera perdue.</span>
                </div>
            </div>
            <div class="quiz-modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">
                    <i class="fa fa-arrow-left"></i>
                    Continuer
                </button>
                <a href="{{ route('quiz.show', $quiz->id) }}" class="btn-modal-confirm danger" id="confirmAbandon">
                    <i class="fa fa-times"></i>
                    Abandonner
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation avant de quitter la page -->
<div class="modal fade" id="confirmLeaveModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content quiz-modal">
            <div class="quiz-modal-header danger">
                <div class="modal-icon">
                    <i class="fa fa-exclamation-circle"></i>
                </div>
            </div>
            <div class="quiz-modal-body">
                <h3>Attention !</h3>
                <p>Vous êtes sur le point de quitter cette page.</p>
                <div class="modal-warning-box">
                    <i class="fa fa-info-circle"></i>
                    <span>Les modifications que vous avez apportées ne seront peut-être pas enregistrées.</span>
                </div>
            </div>
            <div class="quiz-modal-footer">
                <button type="button" class="btn-modal-cancel" id="cancelLeave">
                    <i class="fa fa-arrow-left"></i>
                    Rester
                </button>
                <button type="button" class="btn-modal-confirm danger" id="confirmLeave">
                    <i class="fa fa-sign-out-alt"></i>
                    Quitter
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal temps écoulé -->
<div class="modal fade" id="timeUpModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content quiz-modal">
            <div class="quiz-modal-header time-up">
                <div class="modal-icon">
                    <i class="fa fa-hourglass-end"></i>
                </div>
            </div>
            <div class="quiz-modal-body">
                <h3>Temps écoulé !</h3>
                <p>Le temps imparti pour ce quiz est terminé.</p>
                <div class="modal-warning-box time-up-box">
                    <i class="fa fa-info-circle"></i>
                    <span>Vos réponses vont être soumises automatiquement. Bonne chance !</span>
                </div>
            </div>
            <div class="quiz-modal-footer single">
                <button type="button" class="btn-modal-confirm success" id="confirmTimeUp">
                    <i class="fa fa-paper-plane"></i>
                    Soumettre mes réponses
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const totalQuestions = {{ $totalQuestions }};
    const attemptId = {{ $attempt->id }};
    const form = document.getElementById('quiz-form');

    // Elements
    const progressFill = document.getElementById('progress-fill');
    const answeredCount = document.getElementById('answered-count');
    const footerAnswered = document.getElementById('footer-answered');
    const footerRemaining = document.getElementById('footer-remaining');

    // Track answered questions
    function updateProgress() {
        const answeredQuestions = new Set();

        document.querySelectorAll('.option-input:checked').forEach(input => {
            answeredQuestions.add(input.dataset.question);
        });

        const count = answeredQuestions.size;
        const percentage = (count / totalQuestions) * 100;

        // Update progress bar
        progressFill.style.width = percentage + '%';
        answeredCount.textContent = count;
        footerAnswered.textContent = count;
        footerRemaining.textContent = totalQuestions - count;

        // Update navigation items
        document.querySelectorAll('.question-nav-item').forEach(item => {
            const questionId = item.dataset.question;
            if (answeredQuestions.has(questionId)) {
                item.classList.add('answered');
            } else {
                item.classList.remove('answered');
            }
        });
    }

    // Option click animation
    document.querySelectorAll('.option-label').forEach(label => {
        label.addEventListener('click', function() {
            this.classList.add('clicked');
            setTimeout(() => {
                this.classList.remove('clicked');
            }, 150);
        });
    });

    // Listen for changes
    document.querySelectorAll('.option-input').forEach(input => {
        input.addEventListener('change', updateProgress);
    });

    // Smooth scroll for navigation
    document.querySelectorAll('.question-nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Timer
    @if($quiz->duree_minutes)
        let timeLeft = {{ $quiz->duree_minutes * 60 }};
        const timerDisplay = document.getElementById('timer-display');
        const timerElement = document.getElementById('quiz-timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            // Warning at 5 minutes
            if (timeLeft <= 300 && timeLeft > 120) {
                timerElement.classList.add('warning');
                timerElement.classList.remove('danger');
            }

            // Danger at 2 minutes
            if (timeLeft <= 120 && timeLeft > 0) {
                timerElement.classList.add('danger');
                timerElement.classList.remove('warning');
            }

            // Time's up
            if (timeLeft <= 0) {
                timerDisplay.textContent = '0:00';
                clearInterval(timerInterval);
                // Show time up modal
                const timeUpModal = new bootstrap.Modal(document.getElementById('timeUpModal'));
                timeUpModal.show();
                return;
            }

            timeLeft--;
        }

        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
    @endif

    // Prevent accidental navigation
    let allowNavigation = false;
    let pendingNavigationUrl = null;

    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && !allowNavigation && link.id !== 'confirmAbandon') {
            if (link.getAttribute('data-bs-toggle') ||
                (link.getAttribute('href') && link.getAttribute('href').startsWith('#'))) {
                return;
            }

            e.preventDefault();
            pendingNavigationUrl = link.href;
            const modal = new bootstrap.Modal(document.getElementById('confirmLeaveModal'));
            modal.show();
        }
    });

    document.getElementById('cancelLeave').addEventListener('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmLeaveModal'));
        modal.hide();
        pendingNavigationUrl = null;
    });

    document.getElementById('confirmLeave').addEventListener('click', function() {
        allowNavigation = true;
        if (pendingNavigationUrl) {
            window.location.href = pendingNavigationUrl;
        }
    });

    form.addEventListener('submit', function() {
        allowNavigation = true;
    });

    document.getElementById('confirmAbandon').addEventListener('click', function() {
        allowNavigation = true;
    });

    // Time up modal submit
    document.getElementById('confirmTimeUp').addEventListener('click', function() {
        allowNavigation = true;
        form.submit();
    });

    // LocalStorage save/restore
    const savedAnswers = localStorage.getItem(`quiz_attempt_${attemptId}`);
    if (savedAnswers) {
        const answers = JSON.parse(savedAnswers);
        Object.keys(answers).forEach(questionId => {
            const answer = answers[questionId];
            if (Array.isArray(answer)) {
                answer.forEach(optionId => {
                    const checkbox = document.querySelector(`input[name="reponses[${questionId}][]"][value="${optionId}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            } else {
                const radio = document.querySelector(`input[name="reponses[${questionId}]"][value="${answer}"]`);
                if (radio) radio.checked = true;
            }
        });
        updateProgress();
    }

    form.addEventListener('change', function() {
        const formData = new FormData(form);
        const answers = {};

        for (let [key, value] of formData.entries()) {
            if (key.startsWith('reponses[')) {
                const questionId = key.match(/reponses\[(\d+)\]/)[1];
                if (key.includes('[]')) {
                    if (!answers[questionId]) answers[questionId] = [];
                    answers[questionId].push(value);
                } else {
                    answers[questionId] = value;
                }
            }
        }

        localStorage.setItem(`quiz_attempt_${attemptId}`, JSON.stringify(answers));
    });

    form.addEventListener('submit', function() {
        localStorage.removeItem(`quiz_attempt_${attemptId}`);
    });

    // Initial progress update
    updateProgress();
});
</script>
@endpush
