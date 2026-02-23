@extends('layouts.app')

@section('title', $quiz->titre . ' | Quiz - Colibri Littéraire')
@section('meta_description', $quiz->description ? Str::limit($quiz->description, 150) : 'Testez vos connaissances avec ce quiz')

@push('styles')
<style>
    :root {
        --qz-green: #1e7a2f;
        --qz-green-dark: #155a22;
        --qz-green-light: #e8f5e9;
        --qz-gold: #d4a017;
        --qz-gold-light: #fdf6e3;
        --qz-red: #c0392b;
        --qz-red-light: #fdecea;
        --qz-blue: #2c6fbb;
        --qz-blue-light: #eaf2fb;
        --qz-text: #1a1a2e;
        --qz-muted: #6b7280;
        --qz-border: #e5e7eb;
        --qz-bg: #f5f6f8;
        --qz-card: #ffffff;
        --qz-radius: 14px;
    }

    .qz-page { background: var(--qz-bg); min-height: 100vh; }

    /* ── HERO ── */
    .qz-hero {
        background: linear-gradient(160deg, var(--qz-green) 0%, var(--qz-green-dark) 60%, #0d3b15 100%);
        padding: 2.5rem 0 5rem;
        position: relative;
        overflow: hidden;
    }
    .qz-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Ccircle cx='20' cy='20' r='1.5'/%3E%3C/g%3E%3C/svg%3E");
    }
    .qz-hero .container { position: relative; z-index: 2; }

    .qz-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.75rem;
        font-size: 0.85rem;
        flex-wrap: wrap;
    }
    .qz-breadcrumb a { color: rgba(255,255,255,.7); text-decoration: none; transition: color .2s; }
    .qz-breadcrumb a:hover { color: #fff; }
    .qz-breadcrumb .sep { color: rgba(255,255,255,.35); font-size: .65rem; }
    .qz-breadcrumb .current { color: #fff; font-weight: 600; }

    .qz-hero-inner { max-width: 720px; }

    .qz-badges { display: flex; gap: .6rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
    .qz-badge {
        display: inline-flex; align-items: center; gap: .35rem;
        padding: .35rem .9rem; border-radius: 20px;
        font-size: .78rem; font-weight: 600;
    }
    .qz-badge--type { background: rgba(255,255,255,.12); color: #fff; }
    .qz-badge--formation { background: var(--qz-gold); color: #fff; }
    .qz-badge--passed { background: #27ae60; color: #fff; }

    .qz-hero h1 {
        font-size: 2.25rem; font-weight: 800; color: #fff;
        line-height: 1.2; margin: 0 0 .75rem;
    }
    .qz-hero-desc {
        font-size: 1.05rem; color: rgba(255,255,255,.85);
        line-height: 1.65; margin: 0 0 2rem; max-width: 600px;
    }

    /* Hero inline stats */
    .qz-hero-stats {
        display: flex; gap: 2rem; flex-wrap: wrap;
    }
    .qz-hero-stat {
        display: flex; align-items: center; gap: .65rem;
    }
    .qz-hero-stat-icon {
        width: 44px; height: 44px; border-radius: 12px;
        background: rgba(255,255,255,.12);
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; color: #fff;
    }
    .qz-hero-stat-val { font-size: 1.35rem; font-weight: 800; color: #fff; line-height: 1; }
    .qz-hero-stat-lbl { font-size: .75rem; color: rgba(255,255,255,.7); }

    /* ── MAIN BODY ── */
    .qz-body { margin-top: -2.5rem; position: relative; z-index: 5; padding-bottom: 3rem; }

    .qz-grid {
        display: grid;
        grid-template-columns: 1fr 360px;
        gap: 1.75rem;
        align-items: start;
    }

    /* ── CARD SHARED ── */
    .qz-card {
        background: var(--qz-card);
        border-radius: var(--qz-radius);
        box-shadow: 0 2px 12px rgba(0,0,0,.06);
        overflow: hidden;
    }
    .qz-card + .qz-card { margin-top: 1.25rem; }

    /* ── ALERTS ── */
    .qz-alert {
        border-radius: var(--qz-radius);
        padding: 1rem 1.25rem;
        display: flex; align-items: center; gap: .75rem;
        margin-bottom: 1.25rem;
        font-size: .9rem; font-weight: 500;
    }
    .qz-alert i { font-size: 1.15rem; flex-shrink: 0; }
    .qz-alert--ok { background: var(--qz-green-light); color: #1a6b2a; }
    .qz-alert--err { background: var(--qz-red-light); color: var(--qz-red); }

    /* ── CTA CARD ── */
    .qz-cta-top {
        padding: 1.75rem 2rem;
        background: linear-gradient(135deg, var(--qz-green) 0%, var(--qz-green-dark) 100%);
        text-align: center; position: relative; overflow: hidden;
    }
    .qz-cta-top::before {
        content: '';
        position: absolute; top: -60%; right: -20%;
        width: 260px; height: 260px;
        background: rgba(255,255,255,.06); border-radius: 50%;
    }
    .qz-cta-top h2 { font-size: 1.3rem; font-weight: 700; color: #fff; margin: 0 0 .3rem; position: relative; }
    .qz-cta-top p { color: rgba(255,255,255,.8); font-size: .9rem; margin: 0; position: relative; }

    .qz-cta-body { padding: 1.75rem 2rem; }

    /* Progress bar */
    .qz-progress { margin-bottom: 1.25rem; }
    .qz-progress-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: .5rem; }
    .qz-progress-label { font-size: .85rem; font-weight: 600; color: var(--qz-text); }
    .qz-progress-count { font-size: .8rem; color: var(--qz-muted); }
    .qz-progress-bar { height: 8px; background: #e9ecef; border-radius: 4px; overflow: hidden; }
    .qz-progress-fill {
        height: 100%; border-radius: 4px;
        background: linear-gradient(90deg, var(--qz-blue), #5b9bd5);
        transition: width .4s ease;
    }

    /* Best score */
    .qz-best {
        display: flex; align-items: center; gap: .85rem;
        padding: 1rem 1.15rem; border-radius: 12px;
        background: var(--qz-green-light); border: 1.5px solid #b7e4c7;
        margin-bottom: 1.25rem;
    }
    .qz-best-icon {
        width: 44px; height: 44px; border-radius: 50%;
        background: var(--qz-green); display: flex;
        align-items: center; justify-content: center; flex-shrink: 0;
    }
    .qz-best-icon i { color: #fff; font-size: 1.1rem; }
    .qz-best-lbl { font-size: .8rem; color: #1a6b2a; font-weight: 600; margin: 0 0 .15rem; }
    .qz-best-val { font-size: 1.4rem; font-weight: 800; color: var(--qz-green); line-height: 1; }

    /* CTA button */
    .qz-btn-start {
        width: 100%; padding: 1.1rem 1.5rem;
        background: linear-gradient(135deg, var(--qz-green), var(--qz-green-dark));
        border: none; border-radius: 12px;
        color: #fff; font-size: 1.05rem; font-weight: 700;
        display: flex; align-items: center; justify-content: center; gap: .6rem;
        cursor: pointer; transition: all .25s;
        box-shadow: 0 4px 14px rgba(30,122,47,.25);
    }
    .qz-btn-start:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(30,122,47,.35);
        color: #fff;
    }
    .qz-btn-start:active { transform: translateY(0); }
    .qz-btn-start.is-disabled {
        background: #e0e0e0; color: var(--qz-muted);
        cursor: not-allowed; box-shadow: none;
    }
    .qz-btn-start.is-disabled:hover { transform: none; }

    /* Exhausted warning */
    .qz-exhausted {
        display: flex; align-items: flex-start; gap: .85rem;
        padding: 1rem; border-radius: 12px;
        background: var(--qz-gold-light); border: 1.5px solid #e6c85e;
        margin-top: 1.25rem;
    }
    .qz-exhausted i { color: var(--qz-gold); font-size: 1.3rem; flex-shrink: 0; margin-top: .1rem; }
    .qz-exhausted h4 { font-size: .9rem; font-weight: 600; color: #8a6d0b; margin: 0 0 .2rem; }
    .qz-exhausted p { font-size: .82rem; color: #7a6311; margin: 0; line-height: 1.5; }

    /* ── DETAILS CARD ── */
    .qz-details-hd {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--qz-border);
        display: flex; align-items: center; gap: .65rem;
    }
    .qz-details-hd i { font-size: 1.1rem; color: var(--qz-blue); }
    .qz-details-hd h3 { font-size: 1rem; font-weight: 700; color: var(--qz-text); margin: 0; }

    .qz-details-body { padding: 1.25rem 1.5rem; }

    .qz-detail-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: .7rem 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: .88rem;
    }
    .qz-detail-row:last-child { border-bottom: none; }
    .qz-detail-row .lbl { color: var(--qz-muted); display: flex; align-items: center; gap: .5rem; }
    .qz-detail-row .lbl i { width: 18px; text-align: center; font-size: .9rem; }
    .qz-detail-row .val { font-weight: 700; color: var(--qz-text); }
    .qz-detail-row .val.green { color: var(--qz-green); }

    .qz-setting-tag {
        display: inline-flex; align-items: center; gap: .3rem;
        padding: .25rem .7rem; border-radius: 6px;
        font-size: .78rem; font-weight: 600;
    }
    .qz-setting-tag.on { background: var(--qz-green-light); color: var(--qz-green); }
    .qz-setting-tag.off { background: #f3f4f6; color: var(--qz-muted); }

    /* ── TIPS CARD ── */
    .qz-tips-hd {
        padding: 1rem 1.5rem;
        background: linear-gradient(135deg, var(--qz-gold), #c4930f);
        display: flex; align-items: center; gap: .65rem;
    }
    .qz-tips-hd i { font-size: 1.1rem; color: #fff; }
    .qz-tips-hd h3 { font-size: 1rem; font-weight: 700; color: #fff; margin: 0; }

    .qz-tips-body { padding: 1.25rem 1.5rem; }

    .qz-tip {
        display: flex; align-items: flex-start; gap: .7rem;
        padding: .65rem 0;
        border-bottom: 1px solid #f3f4f6;
    }
    .qz-tip:last-child { border-bottom: none; padding-bottom: 0; }
    .qz-tip-num {
        width: 26px; height: 26px; border-radius: 50%;
        background: var(--qz-gold-light); color: var(--qz-gold);
        display: flex; align-items: center; justify-content: center;
        font-size: .78rem; font-weight: 700; flex-shrink: 0;
    }
    .qz-tip-txt { font-size: .85rem; color: var(--qz-text); line-height: 1.5; }

    /* ── SIDEBAR ── */
    .qz-sidebar { position: sticky; top: 90px; }

    .qz-hist-hd {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #2c3e50, #34495e);
        display: flex; align-items: center; gap: .6rem;
    }
    .qz-hist-hd i { font-size: 1.1rem; color: #fff; }
    .qz-hist-hd h3 { font-size: .95rem; font-weight: 700; color: #fff; margin: 0; }

    .qz-hist-body { padding: 1.25rem; }

    .qz-attempt {
        background: var(--qz-bg); border-radius: 10px;
        padding: .9rem; margin-bottom: .65rem;
        border-left: 3.5px solid; transition: transform .2s;
    }
    .qz-attempt:last-child { margin-bottom: 0; }
    .qz-attempt:hover { transform: translateX(4px); }
    .qz-attempt.ok { border-color: #27ae60; }
    .qz-attempt.ko { border-color: var(--qz-red); }

    .qz-attempt-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: .55rem; }
    .qz-attempt-num { font-weight: 700; font-size: .88rem; color: var(--qz-text); }
    .qz-attempt-pct {
        padding: .25rem .65rem; border-radius: 16px;
        font-size: .78rem; font-weight: 700;
    }
    .qz-attempt-pct.ok { background: #d4efdf; color: #27ae60; }
    .qz-attempt-pct.ko { background: #fdecea; color: var(--qz-red); }

    .qz-attempt-meta { display: flex; flex-direction: column; gap: .25rem; margin-bottom: .65rem; }
    .qz-attempt-meta span { display: flex; align-items: center; gap: .4rem; font-size: .78rem; color: var(--qz-muted); }
    .qz-attempt-meta i { width: 15px; text-align: center; color: var(--qz-blue); }

    .qz-btn-result {
        width: 100%; padding: .55rem .85rem;
        background: transparent; border: 1.5px solid var(--qz-blue);
        border-radius: 8px; color: var(--qz-blue);
        font-size: .78rem; font-weight: 600; text-decoration: none;
        display: flex; align-items: center; justify-content: center; gap: .4rem;
        transition: all .2s;
    }
    .qz-btn-result:hover { background: var(--qz-blue); color: #fff; }

    .qz-hist-empty { text-align: center; padding: 1.75rem 1rem; }
    .qz-hist-empty-ico {
        width: 60px; height: 60px; border-radius: 50%;
        background: var(--qz-bg); display: flex;
        align-items: center; justify-content: center;
        margin: 0 auto .75rem;
    }
    .qz-hist-empty-ico i { font-size: 1.5rem; color: var(--qz-muted); }
    .qz-hist-empty h4 { font-size: .95rem; font-weight: 600; color: var(--qz-text); margin: 0 0 .3rem; }
    .qz-hist-empty p { font-size: .82rem; color: var(--qz-muted); margin: 0; }

    /* ── RESPONSIVE ── */
    @media (max-width: 1199px) {
        .qz-grid { grid-template-columns: 1fr 320px; }
    }
    @media (max-width: 991px) {
        .qz-grid { grid-template-columns: 1fr; }
        .qz-sidebar { position: relative; top: 0; }
        .qz-hero h1 { font-size: 1.85rem; }
    }
    @media (max-width: 767px) {
        .qz-hero { padding: 2rem 0 4rem; }
        .qz-hero h1 { font-size: 1.5rem; }
        .qz-hero-desc { font-size: .95rem; }
        .qz-hero-stats { gap: 1.25rem; }
        .qz-cta-body { padding: 1.25rem; }
        .qz-details-body { padding: 1rem; }
    }
    @media (max-width: 575px) {
        .qz-hero-stats { flex-direction: column; gap: .75rem; }
        .qz-best { flex-direction: column; text-align: center; }
    }
</style>
@endpush

@section('content')
@php
    $attemptsPercentage = $quiz->nombre_tentatives > 0 ? ($attemptsCount / $quiz->nombre_tentatives) * 100 : 0;
    $remainingAttempts = max(0, $quiz->nombre_tentatives - $attemptsCount);
@endphp

<div class="qz-page">
    <!-- Hero -->
    <div class="qz-hero">
        <div class="container">
            <nav class="qz-breadcrumb">
                <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                <i class="fa fa-chevron-right sep"></i>
                @if($quiz->formation)
                    <a href="{{ route('formation.show', $quiz->formation->id) }}">{{ Str::limit($quiz->formation->titre, 30) }}</a>
                    <i class="fa fa-chevron-right sep"></i>
                @endif
                @if($quiz->module)
                    <a href="#">{{ Str::limit($quiz->module->titre, 30) }}</a>
                    <i class="fa fa-chevron-right sep"></i>
                @endif
                <span class="current">Quiz</span>
            </nav>

            <div class="qz-hero-inner">
                <div class="qz-badges">
                    <span class="qz-badge qz-badge--type">
                        <i class="fa fa-clipboard-check"></i> Quiz d'évaluation
                    </span>
                    @if($quiz->formation)
                        <span class="qz-badge qz-badge--formation">
                            <i class="fa fa-graduation-cap"></i> {{ Str::limit($quiz->formation->titre, 25) }}
                        </span>
                    @endif
                    @if($hasPassed)
                        <span class="qz-badge qz-badge--passed">
                            <i class="fa fa-check-circle"></i> Réussi
                        </span>
                    @endif
                </div>

                <h1>{{ $quiz->titre }}</h1>
                @if($quiz->description)
                    <p class="qz-hero-desc">{{ $quiz->description }}</p>
                @else
                    <p class="qz-hero-desc">Testez vos connaissances et obtenez votre certification en répondant à ce quiz.</p>
                @endif

                <div class="qz-hero-stats">
                    <div class="qz-hero-stat">
                        <div class="qz-hero-stat-icon"><i class="fa fa-question-circle"></i></div>
                        <div>
                            <div class="qz-hero-stat-val">{{ $quiz->questions->count() }}</div>
                            <div class="qz-hero-stat-lbl">question{{ $quiz->questions->count() > 1 ? 's' : '' }}</div>
                        </div>
                    </div>
                    <div class="qz-hero-stat">
                        <div class="qz-hero-stat-icon"><i class="fa fa-trophy"></i></div>
                        <div>
                            <div class="qz-hero-stat-val">{{ $quiz->total_points }}</div>
                            <div class="qz-hero-stat-lbl">points</div>
                        </div>
                    </div>
                    @if($quiz->duree_minutes)
                        <div class="qz-hero-stat">
                            <div class="qz-hero-stat-icon"><i class="fa fa-clock"></i></div>
                            <div>
                                <div class="qz-hero-stat-val">{{ $quiz->duree_minutes }}</div>
                                <div class="qz-hero-stat-lbl">minutes</div>
                            </div>
                        </div>
                    @endif
                    <div class="qz-hero-stat">
                        <div class="qz-hero-stat-icon"><i class="fa fa-bullseye"></i></div>
                        <div>
                            <div class="qz-hero-stat-val">{{ $quiz->note_passage }}%</div>
                            <div class="qz-hero-stat-lbl">minimum</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Body -->
    <div class="qz-body">
        <div class="container">
            <!-- Alerts -->
            @if(session('success'))
                <div class="qz-alert qz-alert--ok">
                    <i class="fa fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="qz-alert qz-alert--err">
                    <i class="fa fa-exclamation-circle"></i>
                    {{ session('error') }}
                </div>
            @endif

            <div class="qz-grid">
                <!-- Main -->
                <div>
                    <!-- CTA -->
                    <div class="qz-card">
                        <div class="qz-cta-top">
                            <h2>
                                @if($canAttempt)
                                    @if($attemptsCount > 0)
                                        Prêt pour un nouvel essai ?
                                    @else
                                        Prêt à relever le défi ?
                                    @endif
                                @elseif($hasPassed)
                                    Félicitations, quiz réussi !
                                @else
                                    Tentatives épuisées
                                @endif
                            </h2>
                            <p>
                                @if($canAttempt)
                                    Testez vos connaissances et obtenez votre certification
                                @elseif($hasPassed)
                                    Vous avez validé ce quiz avec succès
                                @else
                                    Vous avez utilisé toutes vos tentatives
                                @endif
                            </p>
                        </div>
                        <div class="qz-cta-body">
                            <!-- Attempt progress -->
                            <div class="qz-progress">
                                <div class="qz-progress-head">
                                    <span class="qz-progress-label">Tentatives utilisées</span>
                                    <span class="qz-progress-count">{{ $attemptsCount }} / {{ $quiz->nombre_tentatives }}</span>
                                </div>
                                <div class="qz-progress-bar">
                                    <div class="qz-progress-fill" style="width: {{ $attemptsPercentage }}%;"></div>
                                </div>
                            </div>

                            @if($bestScore !== null)
                                <div class="qz-best">
                                    <div class="qz-best-icon">
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div>
                                        <div class="qz-best-lbl">Votre meilleur score</div>
                                        <div class="qz-best-val">{{ number_format($bestScore, 1) }}%</div>
                                    </div>
                                </div>
                            @endif

                            @if($canAttempt)
                                <form action="{{ route('quiz.start', $quiz->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="qz-btn-start">
                                        <i class="fa fa-play-circle"></i>
                                        {{ $attemptsCount > 0 ? 'Retenter le quiz' : 'Commencer le quiz' }}
                                    </button>
                                </form>
                            @else
                                <button class="qz-btn-start is-disabled" disabled>
                                    <i class="fa fa-{{ $hasPassed ? 'check-circle' : 'lock' }}"></i>
                                    {{ $hasPassed ? 'Quiz réussi' : 'Aucune tentative disponible' }}
                                </button>
                                @if(!$hasPassed)
                                    <div class="qz-exhausted">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        <div>
                                            <h4>Tentatives épuisées</h4>
                                            <p>Vous avez atteint le nombre maximum de tentatives pour ce quiz. Contactez un administrateur si vous souhaitez réessayer.</p>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Quiz details -->
                    <div class="qz-card">
                        <div class="qz-details-hd">
                            <i class="fa fa-info-circle"></i>
                            <h3>Détails du quiz</h3>
                        </div>
                        <div class="qz-details-body">
                            <div class="qz-detail-row">
                                <span class="lbl"><i class="fa fa-question-circle"></i> Nombre de questions</span>
                                <span class="val">{{ $quiz->questions->count() }}</span>
                            </div>
                            <div class="qz-detail-row">
                                <span class="lbl"><i class="fa fa-trophy"></i> Points totaux</span>
                                <span class="val">{{ $quiz->total_points }} pts</span>
                            </div>
                            <div class="qz-detail-row">
                                <span class="lbl"><i class="fa fa-bullseye"></i> Score minimum requis</span>
                                <span class="val green">{{ $quiz->note_passage }}%</span>
                            </div>
                            <div class="qz-detail-row">
                                <span class="lbl"><i class="fa fa-clock"></i> Durée</span>
                                <span class="val">{{ $quiz->duree_minutes ? $quiz->duree_minutes . ' minutes' : 'Illimitée' }}</span>
                            </div>
                            <div class="qz-detail-row">
                                <span class="lbl"><i class="fa fa-redo"></i> Tentatives restantes</span>
                                <span class="val{{ $remainingAttempts === 0 ? '' : ' green' }}">{{ $remainingAttempts }}</span>
                            </div>
                            <div class="qz-detail-row">
                                <span class="lbl"><i class="fa fa-random"></i> Questions mélangées</span>
                                <span class="qz-setting-tag {{ $quiz->melanger_questions ? 'on' : 'off' }}">
                                    <i class="fa fa-{{ $quiz->melanger_questions ? 'check' : 'times' }}"></i>
                                    {{ $quiz->melanger_questions ? 'Oui' : 'Non' }}
                                </span>
                            </div>
                            <div class="qz-detail-row">
                                <span class="lbl"><i class="fa fa-eye"></i> Réponses affichées</span>
                                <span class="qz-setting-tag {{ $quiz->afficher_reponses ? 'on' : 'off' }}">
                                    <i class="fa fa-{{ $quiz->afficher_reponses ? 'check' : 'times' }}"></i>
                                    {{ $quiz->afficher_reponses ? 'Oui' : 'Non' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="qz-card">
                        <div class="qz-tips-hd">
                            <i class="fa fa-lightbulb"></i>
                            <h3>Conseils pour réussir</h3>
                        </div>
                        <div class="qz-tips-body">
                            <div class="qz-tip">
                                <span class="qz-tip-num">1</span>
                                <span class="qz-tip-txt">Lisez attentivement chaque question avant de répondre</span>
                            </div>
                            <div class="qz-tip">
                                <span class="qz-tip-num">2</span>
                                <span class="qz-tip-txt">Gérez votre temps si le quiz est chronométré</span>
                            </div>
                            <div class="qz-tip">
                                <span class="qz-tip-num">3</span>
                                <span class="qz-tip-txt">Ne laissez aucune question sans réponse</span>
                            </div>
                            <div class="qz-tip">
                                <span class="qz-tip-num">4</span>
                                <span class="qz-tip-txt">Révisez vos réponses avant de soumettre</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div>
                    <div class="qz-sidebar">
                        <div class="qz-card">
                            <div class="qz-hist-hd">
                                <i class="fa fa-history"></i>
                                <h3>Historique des tentatives</h3>
                            </div>
                            <div class="qz-hist-body">
                                @if($previousAttempts->count() > 0)
                                    @foreach($previousAttempts as $index => $attempt)
                                        <div class="qz-attempt {{ $attempt->reussi ? 'ok' : 'ko' }}">
                                            <div class="qz-attempt-top">
                                                <span class="qz-attempt-num">Tentative {{ $attempt->numero_tentative }}</span>
                                                <span class="qz-attempt-pct {{ $attempt->reussi ? 'ok' : 'ko' }}">
                                                    {{ number_format($attempt->score, 1) }}%
                                                </span>
                                            </div>
                                            <div class="qz-attempt-meta">
                                                <span><i class="fa fa-calendar"></i> {{ $attempt->created_at->format('d/m/Y à H:i') }}</span>
                                                <span><i class="fa fa-clock"></i> {{ $attempt->getDureeFormatted() }}</span>
                                            </div>
                                            @if($attempt->fin_at)
                                                <a href="{{ route('quiz.result', [$quiz->id, $attempt->id]) }}" class="qz-btn-result">
                                                    <i class="fa fa-eye"></i> Voir les résultats
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                @else
                                    <div class="qz-hist-empty">
                                        <div class="qz-hist-empty-ico">
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
