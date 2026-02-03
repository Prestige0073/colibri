@extends('layouts.app')

@section('title', 'Nos Formations | Colibri Littéraire - Développez vos compétences')
@section('meta_description', 'Découvrez nos formations certifiantes gratuites pour les acteurs du livre africain. Développez vos compétences avec des modules spécialisés en édition, écriture et promotion.')
@section('meta_keywords', 'formations, livre africain, édition, écriture, certification, gratuit, modules, apprentissage, compétences, Colibri Littéraire')

@push('styles')
<style>
    :root {
        --formation-primary: #1e7a2f;
        --formation-primary-dark: #155a22;
        --formation-primary-light: #e8f5e9;
        --formation-secondary: #f39c12;
        --formation-accent: #3498db;
        --formation-purple: #9b59b6;
        --formation-text: #2d3436;
        --formation-text-muted: #636e72;
        --formation-bg: #f8faf9;
        --formation-card: #ffffff;
        --formation-radius: 16px;
        --formation-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --formation-shadow-hover: 0 12px 40px rgba(0,0,0,0.15);
    }

    .formations-page {
        background: var(--formation-bg);
        min-height: 100vh;
    }

    /* ============================================
       HERO SECTION
       ============================================ */
    .formations-hero {
        background: linear-gradient(135deg, var(--formation-primary) 0%, var(--formation-primary-dark) 100%);
        padding: 4rem 0 8rem;
        position: relative;
        overflow: hidden;
    }

    .formations-hero::before {
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
        animation-delay: 0s;
    }

    .hero-shape-2 {
        width: 200px;
        height: 200px;
        background: var(--formation-secondary);
        bottom: -50px;
        left: 10%;
        animation-delay: 2s;
    }

    .hero-shape-3 {
        width: 150px;
        height: 150px;
        background: white;
        top: 30%;
        left: -50px;
        animation-delay: 4s;
    }

    @keyframes floatShape {
        0%, 100% { transform: translateY(0) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(5deg); }
    }

    .formations-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .hero-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
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

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        color: white;
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.6s ease;
    }

    .hero-badge i {
        color: var(--formation-secondary);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .formations-hero h1 {
        color: white;
        font-size: 2.75rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        line-height: 1.2;
        animation: fadeInUp 0.6s ease 0.1s both;
    }

    .formations-hero h1 span {
        color: var(--formation-secondary);
    }

    .formations-hero p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.15rem;
        line-height: 1.7;
        margin-bottom: 2rem;
        animation: fadeInUp 0.6s ease 0.2s both;
    }

    /* Hero Stats */
    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
        animation: fadeInUp 0.6s ease 0.3s both;
    }

    .hero-stat {
        text-align: center;
    }

    .hero-stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .hero-stat-label {
        color: rgba(255, 255, 255, 0.8);
        font-size: 0.9rem;
    }

    .hero-stat-divider {
        width: 1px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        align-self: center;
    }

    /* ============================================
       FILTERS SECTION
       ============================================ */
    .filters-section {
        margin-top: -4rem;
        position: relative;
        z-index: 10;
        padding-bottom: 2rem;
    }

    .filters-card {
        background: var(--formation-card);
        border-radius: var(--formation-radius);
        box-shadow: var(--formation-shadow);
        padding: 1.5rem 2rem;
    }

    .filters-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.65rem 1.25rem;
        background: var(--formation-bg);
        border: 2px solid transparent;
        border-radius: 25px;
        color: var(--formation-text-muted);
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s;
    }

    .filter-btn:hover {
        background: var(--formation-primary-light);
        color: var(--formation-primary);
    }

    .filter-btn.active {
        background: var(--formation-primary);
        color: white;
        border-color: var(--formation-primary);
    }

    .filter-btn .count {
        background: rgba(0, 0, 0, 0.1);
        padding: 0.15rem 0.5rem;
        border-radius: 10px;
        font-size: 0.75rem;
    }

    .filter-btn.active .count {
        background: rgba(255, 255, 255, 0.2);
    }

    .search-box {
        position: relative;
        min-width: 280px;
    }

    .search-box input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 2.75rem;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 0.95rem;
        transition: all 0.3s;
    }

    .search-box input:focus {
        outline: none;
        border-color: var(--formation-primary);
        box-shadow: 0 0 0 4px rgba(30, 122, 47, 0.1);
    }

    .search-box i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--formation-text-muted);
    }

    /* View toggle */
    .view-toggle {
        display: flex;
        background: var(--formation-bg);
        border-radius: 10px;
        padding: 0.25rem;
    }

    .view-btn {
        padding: 0.5rem 0.75rem;
        border: none;
        background: transparent;
        border-radius: 8px;
        color: var(--formation-text-muted);
        cursor: pointer;
        transition: all 0.3s;
    }

    .view-btn.active {
        background: var(--formation-primary);
        color: white;
    }

    /* ============================================
       FORMATIONS GRID
       ============================================ */
    .formations-section {
        padding: 2rem 0 5rem;
    }

    .formations-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .formations-grid.list-view {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    /* ============================================
       FORMATION CARD
       ============================================ */
    .formation-card {
        background: var(--formation-card);
        border-radius: var(--formation-radius);
        box-shadow: var(--formation-shadow);
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        display: flex;
        flex-direction: column;
    }

    .formation-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--formation-shadow-hover);
    }

    /* Card image */
    .formation-card-image {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .formation-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s;
    }

    .formation-card:hover .formation-card-image img {
        transform: scale(1.08);
    }

    .formation-card-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 40%, rgba(0, 0, 0, 0.7) 100%);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .formation-card:hover .formation-card-overlay {
        opacity: 1;
    }

    /* Badges on image */
    .formation-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        right: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        z-index: 2;
    }

    .badge-niveau {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        backdrop-filter: blur(10px);
    }

    .badge-niveau.debutant {
        background: rgba(46, 204, 113, 0.9);
        color: white;
    }

    .badge-niveau.intermediaire {
        background: rgba(52, 152, 219, 0.9);
        color: white;
    }

    .badge-niveau.avance {
        background: rgba(155, 89, 182, 0.9);
        color: white;
    }

    .badge-niveau.tous {
        background: rgba(30, 122, 47, 0.9);
        color: white;
    }

    .badge-prix {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.4rem 0.85rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 700;
        backdrop-filter: blur(10px);
    }

    .badge-prix.gratuit {
        background: var(--formation-secondary);
        color: white;
    }

    .badge-prix.payant {
        background: rgba(255, 255, 255, 0.95);
        color: var(--formation-text);
    }

    /* Quick view button */
    .quick-view-btn {
        position: absolute;
        bottom: 1rem;
        left: 50%;
        transform: translateX(-50%) translateY(20px);
        opacity: 0;
        padding: 0.6rem 1.5rem;
        background: white;
        color: var(--formation-primary);
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        z-index: 3;
    }

    .formation-card:hover .quick-view-btn {
        opacity: 1;
        transform: translateX(-50%) translateY(0);
    }

    .quick-view-btn:hover {
        background: var(--formation-primary);
        color: white;
    }

    /* Card body */
    .formation-card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .formation-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--formation-text);
        margin: 0 0 0.75rem 0;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .formation-card-title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s;
    }

    .formation-card-title a:hover {
        color: var(--formation-primary);
    }

    .formation-card-description {
        color: var(--formation-text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Card stats */
    .formation-card-stats {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-top: 1px solid #f0f0f0;
        border-bottom: 1px solid #f0f0f0;
        margin-bottom: 1rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: var(--formation-text-muted);
    }

    .stat-item i {
        color: var(--formation-primary);
        font-size: 0.9rem;
    }

    .stat-item.videos i { color: #e74c3c; }
    .stat-item.pdfs i { color: #3498db; }
    .stat-item.modules i { color: var(--formation-secondary); }

    /* Card footer */
    .formation-card-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .formation-progress {
        flex: 1;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        color: var(--formation-text-muted);
        margin-bottom: 0.35rem;
    }

    .progress-bar-container {
        height: 6px;
        background: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--formation-primary), var(--formation-secondary));
        border-radius: 3px;
        transition: width 0.5s ease;
    }

    .btn-formation {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--formation-primary) 0%, var(--formation-primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .btn-formation:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(30, 122, 47, 0.3);
        color: white;
    }

    .btn-formation i {
        transition: transform 0.3s;
    }

    .btn-formation:hover i {
        transform: translateX(3px);
    }

    /* ============================================
       LIST VIEW CARD
       ============================================ */
    .formations-grid.list-view .formation-card {
        flex-direction: row;
    }

    .formations-grid.list-view .formation-card-image {
        width: 280px;
        min-width: 280px;
        height: auto;
        min-height: 200px;
    }

    .formations-grid.list-view .formation-card-body {
        padding: 1.5rem 2rem;
    }

    .formations-grid.list-view .formation-card-description {
        -webkit-line-clamp: 2;
    }

    .formations-grid.list-view .formation-card-footer {
        margin-top: auto;
    }

    /* ============================================
       EMPTY STATE
       ============================================ */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--formation-card);
        border-radius: var(--formation-radius);
        box-shadow: var(--formation-shadow);
    }

    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: var(--formation-primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
    }

    .empty-state-icon i {
        font-size: 2.5rem;
        color: var(--formation-primary);
    }

    .empty-state h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--formation-text);
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: var(--formation-text-muted);
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    .btn-empty {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.875rem 2rem;
        background: var(--formation-primary);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-empty:hover {
        background: var(--formation-primary-dark);
        color: white;
        transform: translateY(-2px);
    }

    /* ============================================
       CTA SECTION
       ============================================ */
    .cta-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, var(--formation-primary) 0%, var(--formation-primary-dark) 100%);
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 700px;
        margin: 0 auto;
    }

    .cta-content h2 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-content p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.05rem;
        margin-bottom: 2rem;
    }

    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s;
    }

    .btn-cta-primary {
        background: white;
        color: var(--formation-primary);
    }

    .btn-cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        color: var(--formation-primary-dark);
    }

    .btn-cta-secondary {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }

    .btn-cta-secondary:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: translateY(-3px);
    }

    /* ============================================
       PAGINATION
       ============================================ */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination-container .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .pagination-container .page-item .page-link {
        min-width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e9ecef;
        border-radius: 10px;
        color: var(--formation-text);
        font-weight: 500;
        transition: all 0.3s;
    }

    .pagination-container .page-item .page-link:hover {
        background: var(--formation-primary-light);
        border-color: var(--formation-primary);
        color: var(--formation-primary);
    }

    .pagination-container .page-item.active .page-link {
        background: var(--formation-primary);
        border-color: var(--formation-primary);
        color: white;
    }

    .pagination-container .page-item.disabled .page-link {
        background: #f8f9fa;
        color: #adb5bd;
        cursor: not-allowed;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 1199px) {
        .formations-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 991px) {
        .formations-hero h1 {
            font-size: 2.25rem;
        }

        .hero-stats {
            gap: 2rem;
        }

        .filters-row {
            flex-direction: column;
            align-items: stretch;
        }

        .filter-group {
            justify-content: center;
        }

        .search-box {
            min-width: 100%;
        }

        .formations-grid.list-view .formation-card {
            flex-direction: column;
        }

        .formations-grid.list-view .formation-card-image {
            width: 100%;
            min-width: 100%;
            height: 200px;
        }
    }

    @media (max-width: 767px) {
        .formations-hero {
            padding: 3rem 0 6rem;
        }

        .formations-hero h1 {
            font-size: 1.75rem;
        }

        .formations-hero p {
            font-size: 1rem;
        }

        .hero-stats {
            flex-direction: column;
            gap: 1.5rem;
        }

        .hero-stat-divider {
            display: none;
        }

        .filters-card {
            padding: 1.25rem;
        }

        .filter-group {
            flex-wrap: wrap;
            justify-content: flex-start;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
        }

        .formations-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .cta-content h2 {
            font-size: 1.5rem;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .btn-cta {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 575px) {
        .formations-hero {
            padding: 2.5rem 0 5rem;
        }

        .hero-breadcrumb {
            font-size: 0.8rem;
        }

        .formation-card-stats {
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .formation-card-footer {
            flex-direction: column;
            align-items: stretch;
        }

        .btn-formation {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="formations-page">
    <!-- Hero Section -->
    <div class="formations-hero">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>

        <div class="container">
            <div class="formations-hero-content">
                <nav class="hero-breadcrumb">
                    <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                    <i class="fa fa-chevron-right"></i>
                    <span>Formations</span>
                </nav>

                <div class="hero-badge">
                    <i class="fa fa-certificate"></i>
                    <span>Formations certifiantes gratuites</span>
                </div>

                <h1>Développez vos <span>compétences</span> dans le monde du livre africain</h1>
                <p>Des formations professionnelles conçues par des experts pour vous accompagner dans votre parcours. Apprenez à votre rythme et obtenez une certification reconnue.</p>

                @php
                    $totalFormations = $formations->total();
                    $totalModules = 0;
                    $totalVideos = 0;
                    foreach($formations as $f) {
                        $totalModules += $f->modules_count;
                        foreach($f->modules as $m) {
                            foreach($m->contenus as $c) {
                                if($c->type === 'video') $totalVideos++;
                            }
                        }
                    }
                @endphp

                <div class="hero-stats">
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $totalFormations }}</div>
                        <div class="hero-stat-label">Formation{{ $totalFormations > 1 ? 's' : '' }} disponible{{ $totalFormations > 1 ? 's' : '' }}</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">{{ $totalModules }}+</div>
                        <div class="hero-stat-label">Modules de cours</div>
                    </div>
                    <div class="hero-stat-divider"></div>
                    <div class="hero-stat">
                        <div class="hero-stat-number">100%</div>
                        <div class="hero-stat-label">Gratuit & certifiant</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="filters-section">
        <div class="container">
            <div class="filters-card">
                <div class="filters-row">
                    <div class="filter-group">
                        <button class="filter-btn active" data-filter="all">
                            <i class="fa fa-th-large"></i>
                            Toutes
                            <span class="count">{{ $totalFormations }}</span>
                        </button>
                        <button class="filter-btn" data-filter="gratuit">
                            <i class="fa fa-gift"></i>
                            Gratuites
                        </button>
                        <button class="filter-btn" data-filter="debutant">
                            <i class="fa fa-seedling"></i>
                            Débutant
                        </button>
                        <button class="filter-btn" data-filter="intermediaire">
                            <i class="fa fa-signal"></i>
                            Intermédiaire
                        </button>
                        <button class="filter-btn" data-filter="avance">
                            <i class="fa fa-rocket"></i>
                            Avancé
                        </button>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <div class="search-box">
                            <i class="fa fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Rechercher une formation...">
                        </div>
                        <div class="view-toggle d-none d-lg-flex">
                            <button class="view-btn active" data-view="grid" title="Vue grille">
                                <i class="fa fa-th-large"></i>
                            </button>
                            <button class="view-btn" data-view="list" title="Vue liste">
                                <i class="fa fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formations Grid -->
    <div class="formations-section">
        <div class="container">
            @if($formations->count() > 0)
                <div class="formations-grid" id="formationsGrid">
                    @foreach($formations as $formation)
                        @php
                            $totalContenus = 0;
                            $videosCount = 0;
                            $pdfsCount = 0;
                            foreach($formation->modules as $module) {
                                foreach($module->contenus as $contenu) {
                                    $totalContenus++;
                                    if($contenu->type === 'video') {
                                        $videosCount++;
                                    } elseif($contenu->type === 'pdf') {
                                        $pdfsCount++;
                                    }
                                }
                            }

                            // Déterminer le niveau
                            $niveau = strtolower($formation->niveau ?? 'tous');
                            $niveauClass = 'tous';
                            $niveauLabel = 'Tous niveaux';
                            $niveauIcon = 'fa-layer-group';

                            if(stripos($niveau, 'débutant') !== false || stripos($niveau, 'debutant') !== false) {
                                $niveauClass = 'debutant';
                                $niveauLabel = 'Débutant';
                                $niveauIcon = 'fa-seedling';
                            } elseif(stripos($niveau, 'intermédiaire') !== false || stripos($niveau, 'intermediaire') !== false) {
                                $niveauClass = 'intermediaire';
                                $niveauLabel = 'Intermédiaire';
                                $niveauIcon = 'fa-signal';
                            } elseif(stripos($niveau, 'avancé') !== false || stripos($niveau, 'avance') !== false) {
                                $niveauClass = 'avance';
                                $niveauLabel = 'Avancé';
                                $niveauIcon = 'fa-rocket';
                            }

                            // Progression (simulée pour le moment)
                            $progression = 0;
                            if(auth()->check()) {
                                // TODO: Calculer la vraie progression
                            }
                        @endphp

                        <div class="formation-card"
                             data-niveau="{{ $niveauClass }}"
                             data-prix="{{ $formation->prix > 0 ? 'payant' : 'gratuit' }}"
                             data-title="{{ strtolower($formation->titre) }}">

                            <div class="formation-card-image">
                                @if($formation->image)
                                    <img src="{{ asset($formation->image) }}" alt="{{ $formation->titre }}">
                                @else
                                    <img src="{{ asset('img/formation-default.jpg') }}" alt="{{ $formation->titre }}">
                                @endif

                                <div class="formation-card-overlay"></div>

                                <div class="formation-badges">
                                    <span class="badge-niveau {{ $niveauClass }}">
                                        <i class="fa {{ $niveauIcon }}"></i>
                                        {{ $niveauLabel }}
                                    </span>
                                    <span class="badge-prix {{ $formation->prix > 0 ? 'payant' : 'gratuit' }}">
                                        @if($formation->prix > 0)
                                            {{ fcfa($formation->prix) }}
                                        @else
                                            <i class="fa fa-gift"></i> Gratuit
                                        @endif
                                    </span>
                                </div>

                                <a href="{{ route('formation.show', $formation) }}" class="quick-view-btn">
                                    <i class="fa fa-eye me-1"></i> Aperçu rapide
                                </a>
                            </div>

                            <div class="formation-card-body">
                                <h3 class="formation-card-title">
                                    <a href="{{ route('formation.show', $formation) }}">{{ $formation->titre }}</a>
                                </h3>

                                <p class="formation-card-description">
                                    {{ Str::limit($formation->description, 120) }}
                                </p>

                                <div class="formation-card-stats">
                                    <div class="stat-item modules">
                                        <i class="fa fa-book-open"></i>
                                        <span>{{ $formation->modules_count }} module{{ $formation->modules_count > 1 ? 's' : '' }}</span>
                                    </div>
                                    @if($videosCount > 0)
                                        <div class="stat-item videos">
                                            <i class="fa fa-video"></i>
                                            <span>{{ $videosCount }} vidéo{{ $videosCount > 1 ? 's' : '' }}</span>
                                        </div>
                                    @endif
                                    @if($pdfsCount > 0)
                                        <div class="stat-item pdfs">
                                            <i class="fa fa-file-pdf"></i>
                                            <span>{{ $pdfsCount }} PDF</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="formation-card-footer">
                                    @if(auth()->check() && $progression > 0)
                                        <div class="formation-progress">
                                            <div class="progress-label">
                                                <span>Progression</span>
                                                <span>{{ $progression }}%</span>
                                            </div>
                                            <div class="progress-bar-container">
                                                <div class="progress-bar-fill" style="width: {{ $progression }}%"></div>
                                            </div>
                                        </div>
                                    @endif

                                    <a href="{{ route('formation.show', $formation) }}" class="btn-formation">
                                        @if(auth()->check() && $progression > 0)
                                            Continuer
                                        @else
                                            Découvrir
                                        @endif
                                        <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($formations->hasPages())
                    <div class="pagination-container">
                        {{ $formations->links() }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <h3>Aucune formation disponible</h3>
                    <p>Nos formations sont en cours de préparation. Revenez bientôt pour découvrir nos modules de formation.</p>
                    <a href="{{ route('index') }}" class="btn-empty">
                        <i class="fa fa-home"></i>
                        Retour à l'accueil
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    @if($formations->count() > 0)
        <div class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2>Besoin d'aide pour choisir votre formation ?</h2>
                    <p>Notre équipe est là pour vous accompagner dans votre parcours de formation et vous aider à trouver le programme adapté à vos objectifs.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('contact.index') }}" class="btn-cta btn-cta-primary">
                            <i class="fa fa-headset"></i>
                            Nous contacter
                        </a>
                        <a href="{{ route('about.index') }}" class="btn-cta btn-cta-secondary">
                            <i class="fa fa-info-circle"></i>
                            En savoir plus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const formationsGrid = document.getElementById('formationsGrid');
    const filterBtns = document.querySelectorAll('.filter-btn');
    const searchInput = document.getElementById('searchInput');
    const viewBtns = document.querySelectorAll('.view-btn');

    if (!formationsGrid) return;

    const formationCards = formationsGrid.querySelectorAll('.formation-card');

    // Filter functionality
    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            filterFormations(filter, searchInput.value);
        });
    });

    // Search functionality
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
            filterFormations(activeFilter, this.value);
        }, 300);
    });

    function filterFormations(filter, search) {
        const searchTerm = search.toLowerCase().trim();

        formationCards.forEach(card => {
            const niveau = card.dataset.niveau;
            const prix = card.dataset.prix;
            const title = card.dataset.title;

            let showByFilter = false;
            let showBySearch = true;

            // Filter check
            if (filter === 'all') {
                showByFilter = true;
            } else if (filter === 'gratuit') {
                showByFilter = prix === 'gratuit';
            } else {
                showByFilter = niveau === filter;
            }

            // Search check
            if (searchTerm) {
                showBySearch = title.includes(searchTerm);
            }

            // Show/hide with animation
            if (showByFilter && showBySearch) {
                card.style.display = '';
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = '';
                }, 10);
            } else {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.95)';
                setTimeout(() => {
                    card.style.display = 'none';
                }, 300);
            }
        });

        // Check if all hidden
        setTimeout(() => {
            const visibleCards = formationsGrid.querySelectorAll('.formation-card[style*="display: none"]');
            // Could show a "no results" message here
        }, 350);
    }

    // View toggle functionality
    viewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            viewBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const view = this.dataset.view;
            if (view === 'list') {
                formationsGrid.classList.add('list-view');
            } else {
                formationsGrid.classList.remove('list-view');
            }
        });
    });

    // Add hover effect for cards
    formationCards.forEach(card => {
        card.style.transition = 'all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), opacity 0.3s ease';
    });
});
</script>
@endpush
