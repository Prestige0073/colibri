@extends('layouts.app')

@section('title', 'À propos | Colibri Littéraire - Notre mission, valeurs et équipe')
@section('meta_description', "Découvrez la mission, les valeurs et l'équipe de Colibri Littéraire, plateforme dédiée à la formation et à la promotion du livre africain.")
@section('meta_keywords', 'à propos, livre africain, équipe, mission, valeurs, formation, Colibri Littéraire, culture, édition, francophonie')

@push('styles')
<style>
    :root {
        --about-primary: #1e7a2f;
        --about-primary-dark: #155a22;
        --about-primary-light: #e8f5e9;
        --about-secondary: #f39c12;
        --about-accent: #3498db;
        --about-text: #2d3436;
        --about-text-muted: #636e72;
        --about-bg: #f8faf9;
        --about-card: #ffffff;
        --about-radius: 16px;
        --about-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --about-shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
    }

    .about-page {
        background: var(--about-bg);
    }

    /* ============================================
       HERO SECTION
       ============================================ */
    .about-hero {
        background: linear-gradient(135deg, var(--about-primary) 0%, var(--about-primary-dark) 100%);
        padding: 4rem 0 6rem;
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .about-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .about-breadcrumb {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        font-size: 0.9rem;
    }

    .about-breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: color 0.2s;
    }

    .about-breadcrumb a:hover {
        color: white;
    }

    .about-breadcrumb i {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.7rem;
    }

    .about-breadcrumb span {
        color: white;
        font-weight: 500;
    }

    .about-hero h1 {
        color: white;
        font-size: 2.75rem;
        font-weight: 700;
        margin-bottom: 1.25rem;
        line-height: 1.2;
    }

    .about-hero p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.15rem;
        line-height: 1.7;
        margin-bottom: 2rem;
    }

    .hero-video-btn {
        display: inline-flex;
        align-items: center;
        gap: 1rem;
        background: rgba(255, 255, 255, 0.15);
        padding: 0.75rem 1.5rem 0.75rem 0.75rem;
        border-radius: 50px;
        color: white;
        text-decoration: none;
        transition: all 0.3s;
        backdrop-filter: blur(10px);
    }

    .hero-video-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        color: white;
        transform: scale(1.02);
    }

    .hero-video-btn .play-icon {
        width: 50px;
        height: 50px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-video-btn .play-icon i {
        color: var(--about-primary);
        font-size: 1.25rem;
        margin-left: 3px;
    }

    .hero-video-btn span {
        font-weight: 500;
    }

    /* ============================================
       MISSION SECTION
       ============================================ */
    .mission-section {
        padding: 5rem 0;
        margin-top: -3rem;
    }

    .mission-card {
        background: var(--about-card);
        border-radius: var(--about-radius);
        box-shadow: var(--about-shadow);
        padding: 3rem;
        position: relative;
        overflow: hidden;
    }

    .mission-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--about-primary), var(--about-secondary));
    }

    .mission-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
    }

    .mission-image {
        position: relative;
    }

    .mission-image img {
        width: 100%;
        max-width: 350px;
        margin: 0 auto;
        display: block;
        filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.1));
    }

    .mission-badge {
        position: absolute;
        bottom: 20px;
        right: 20px;
        background: linear-gradient(135deg, var(--about-secondary) 0%, #e67e22 100%);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(243, 156, 18, 0.3);
    }

    .mission-badge .number {
        font-size: 2rem;
        font-weight: 700;
        display: block;
        line-height: 1;
    }

    .mission-badge .label {
        font-size: 0.8rem;
        opacity: 0.9;
    }

    .mission-content h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--about-text);
        margin-bottom: 1rem;
    }

    .mission-content h2 span {
        color: var(--about-primary);
    }

    .mission-content > p {
        color: var(--about-text-muted);
        font-size: 1.05rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
    }

    .mission-highlights {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .highlight-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        background: var(--about-primary-light);
        border-radius: 12px;
        transition: all 0.3s;
    }

    .highlight-item:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(30, 122, 47, 0.15);
    }

    .highlight-icon {
        width: 45px;
        height: 45px;
        background: var(--about-primary);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .highlight-icon i {
        color: white;
        font-size: 1.1rem;
    }

    .highlight-text h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--about-text);
        margin: 0 0 0.25rem 0;
    }

    .highlight-text p {
        font-size: 0.9rem;
        color: var(--about-text-muted);
        margin: 0;
        line-height: 1.5;
    }

    /* ============================================
       STATS SECTION
       ============================================ */
    .stats-section {
        padding: 4rem 0;
        background: linear-gradient(135deg, var(--about-primary) 0%, var(--about-primary-dark) 100%);
        position: relative;
        overflow: hidden;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        position: relative;
        z-index: 2;
    }

    .stat-card {
        text-align: center;
        padding: 2rem 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--about-radius);
        backdrop-filter: blur(10px);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        background: rgba(255, 255, 255, 0.15);
    }

    .stat-icon {
        width: 70px;
        height: 70px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .stat-icon i {
        font-size: 1.75rem;
        color: var(--about-primary);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: white;
        line-height: 1;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.95rem;
    }

    /* ============================================
       VALUES SECTION
       ============================================ */
    .values-section {
        padding: 5rem 0;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header .badge-text {
        display: inline-block;
        background: var(--about-primary-light);
        color: var(--about-primary);
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .section-header h2 {
        font-size: 2.25rem;
        font-weight: 700;
        color: var(--about-text);
        margin-bottom: 0.75rem;
    }

    .section-header p {
        color: var(--about-text-muted);
        font-size: 1.05rem;
        max-width: 600px;
        margin: 0 auto;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
    }

    .value-card {
        background: var(--about-card);
        border-radius: var(--about-radius);
        box-shadow: var(--about-shadow);
        padding: 2rem;
        text-align: center;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .value-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--card-color, var(--about-primary));
        transform: scaleX(0);
        transition: transform 0.3s;
    }

    .value-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--about-shadow-hover);
    }

    .value-card:hover::before {
        transform: scaleX(1);
    }

    .value-card:nth-child(1) { --card-color: var(--about-primary); }
    .value-card:nth-child(2) { --card-color: var(--about-secondary); }
    .value-card:nth-child(3) { --card-color: var(--about-accent); }

    .value-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        transition: transform 0.3s;
    }

    .value-card:hover .value-icon {
        transform: scale(1.1);
    }

    .value-card:nth-child(1) .value-icon {
        background: linear-gradient(135deg, var(--about-primary-light) 0%, #c8e6c9 100%);
    }

    .value-card:nth-child(2) .value-icon {
        background: linear-gradient(135deg, #fff8e6 0%, #ffecb3 100%);
    }

    .value-card:nth-child(3) .value-icon {
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    }

    .value-icon i {
        font-size: 2rem;
    }

    .value-card:nth-child(1) .value-icon i { color: var(--about-primary); }
    .value-card:nth-child(2) .value-icon i { color: var(--about-secondary); }
    .value-card:nth-child(3) .value-icon i { color: var(--about-accent); }

    .value-card h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--about-text);
        margin-bottom: 0.75rem;
    }

    .value-card p {
        color: var(--about-text-muted);
        font-size: 0.95rem;
        line-height: 1.6;
        margin: 0;
    }

    /* ============================================
       TEAM SECTION - PYRAMIDAL
       ============================================ */
    .team-section {
        padding: 5rem 0;
        background: linear-gradient(180deg, var(--about-bg) 0%, #eef5f0 100%);
    }

    .team-pyramid {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Level 1 - President (Top of pyramid) */
    .team-level-1 {
        display: flex;
        justify-content: center;
        margin-bottom: 2rem;
    }

    .team-member-president {
        background: linear-gradient(135deg, var(--about-primary) 0%, var(--about-primary-dark) 100%);
        border-radius: 20px;
        padding: 2rem;
        text-align: center;
        width: 280px;
        position: relative;
        box-shadow: 0 15px 40px rgba(30, 122, 47, 0.3);
    }


    .president-photo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        object-fit: cover;
        margin: 1rem auto 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .team-member-president h4 {
        color: white;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0 0 0.25rem 0;
    }

    .team-member-president .role {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.35rem 1rem;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
    }

    .team-member-president .bio {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.85rem;
        line-height: 1.5;
        margin: 0;
    }

    /* Connector lines */
    .pyramid-connector {
        display: flex;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .connector-line {
        width: 2px;
        height: 30px;
        background: linear-gradient(180deg, var(--about-primary) 0%, var(--about-primary-light) 100%);
    }

    .connector-branches {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        margin-bottom: 1rem;
        position: relative;
    }

    .connector-branches::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60%;
        height: 2px;
        background: var(--about-primary-light);
    }

    /* Level 2 - Second row (2-3 members) */
    .team-level-2 {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    /* Level 3 - Third row (more members) */
    .team-level-3 {
        display: flex;
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    /* Regular team member card */
    .team-member-card {
        background: var(--about-card);
        border-radius: var(--about-radius);
        box-shadow: var(--about-shadow);
        padding: 1.5rem;
        text-align: center;
        width: 200px;
        transition: all 0.3s;
        position: relative;
        overflow: hidden;
    }

    .team-member-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--about-primary);
        transform: scaleX(0);
        transition: transform 0.3s;
    }

    .team-member-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--about-shadow-hover);
    }

    .team-member-card:hover::before {
        transform: scaleX(1);
    }

    .member-photo {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--about-primary-light);
        margin-bottom: 1rem;
        transition: all 0.3s;
    }

    .team-member-card:hover .member-photo {
        border-color: var(--about-primary);
        transform: scale(1.05);
    }

    .team-member-card h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--about-text);
        margin: 0 0 0.25rem 0;
    }

    .team-member-card .role {
        display: inline-block;
        background: var(--about-primary-light);
        color: var(--about-primary);
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .team-member-card .bio {
        color: var(--about-text-muted);
        font-size: 0.8rem;
        line-height: 1.4;
        margin-top: 0.75rem;
    }

    /* Level 2 cards slightly larger */
    .team-level-2 .team-member-card {
        width: 220px;
    }

    .team-level-2 .member-photo {
        width: 100px;
        height: 100px;
    }

    /* No team message */
    .no-team-message {
        text-align: center;
        padding: 3rem;
        background: var(--about-card);
        border-radius: var(--about-radius);
        box-shadow: var(--about-shadow);
    }

    .no-team-message i {
        font-size: 3rem;
        color: var(--about-text-muted);
        margin-bottom: 1rem;
    }

    .no-team-message p {
        color: var(--about-text-muted);
        font-size: 1.1rem;
        margin: 0;
    }

    /* ============================================
       CTA SECTION
       ============================================ */
    .cta-section {
        padding: 5rem 0;
    }

    .cta-card {
        background: linear-gradient(135deg, var(--about-primary) 0%, var(--about-primary-dark) 100%);
        border-radius: 24px;
        padding: 4rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
    }

    .cta-card::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .cta-content {
        position: relative;
        z-index: 2;
    }

    .cta-content h2 {
        color: white;
        font-size: 2.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
    }

    .cta-content p {
        color: rgba(255, 255, 255, 0.9);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 2rem;
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
        color: var(--about-primary);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }

    .btn-cta-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        color: var(--about-primary-dark);
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
       VIDEO MODAL
       ============================================ */
    .video-modal .modal-content {
        background: transparent;
        border: none;
    }

    .video-modal .modal-body {
        padding: 0;
    }

    .video-modal .btn-close {
        position: absolute;
        top: -40px;
        right: 0;
        filter: invert(1);
        opacity: 1;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 991px) {
        .mission-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .mission-image {
            order: -1;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .values-grid {
            grid-template-columns: 1fr;
            max-width: 400px;
            margin: 0 auto;
        }

        .team-level-2,
        .team-level-3 {
            gap: 1rem;
        }

        .team-member-card,
        .team-level-2 .team-member-card {
            width: 170px;
        }
    }

    @media (max-width: 767px) {
        .about-hero {
            padding: 3rem 0 5rem;
        }

        .about-hero h1 {
            font-size: 2rem;
        }

        .about-hero p {
            font-size: 1rem;
        }

        .mission-card {
            padding: 2rem;
        }

        .mission-content h2 {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-card {
            padding: 1.5rem 1rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .section-header h2 {
            font-size: 1.75rem;
        }

        .team-member-president {
            width: 100%;
            max-width: 280px;
        }

        .team-member-card,
        .team-level-2 .team-member-card {
            width: calc(50% - 0.5rem);
            min-width: 150px;
        }

        .cta-card {
            padding: 2.5rem 1.5rem;
        }

        .cta-content h2 {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 575px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .team-level-2,
        .team-level-3 {
            flex-direction: column;
            align-items: center;
        }

        .team-member-card,
        .team-level-2 .team-member-card {
            width: 100%;
            max-width: 250px;
        }

        .cta-buttons {
            flex-direction: column;
        }

        .btn-cta {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endpush

@section('content')
<div class="about-page">
    <!-- Hero Section -->
    <div class="about-hero">
        <div class="container">
            <div class="about-hero-content">
                <nav class="about-breadcrumb">
                    <a href="{{ route('index') }}"><i class="fa fa-home"></i></a>
                    <i class="fa fa-chevron-right"></i>
                    <span>À propos</span>
                </nav>

                <h1>Ce sont les actions de chaque colibri littéraire qui feront rayonner le livre africain</h1>
                <p>Colibri Littéraire est une initiative de l'ONG Ecrivains Humanistes du Bénin, avec l'appui technique des Editions Encres Universelles et le soutien de l'Organisation internationale de la Francophonie (OIF).</p>

                <a href="#" class="hero-video-btn" data-bs-toggle="modal" data-bs-target="#videoModal" data-src="https://www.youtube.com/embed/DWRcNpR6Kdc">
                    <span class="play-icon">
                        <i class="fa fa-play"></i>
                    </span>
                    <span>Découvrir notre histoire</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mission Section -->
    <div class="mission-section">
        <div class="container">
            <div class="mission-card">
                <div class="mission-grid">
                    <div class="mission-image">
                        <img src="{{ asset('img/LOGO-COLIBRI-LITTERAIRE.png') }}" alt="Colibri Littéraire">
                    </div>
                    <div class="mission-content">
                        <h2>Notre <span>Mission</span></h2>
                        <p>Pour faire rayonner le livre africain, nous agissons sur deux indicateurs importants : la formation continue et la facilitation de la circulation des productions locales.</p>

                        <div class="mission-highlights">
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fa fa-graduation-cap"></i>
                                </div>
                                <div class="highlight-text">
                                    <h4>Formations certifiantes gratuites</h4>
                                    <p>Des formations spécialisées pour les acteurs du livre africain</p>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fa fa-book-open"></i>
                                </div>
                                <div class="highlight-text">
                                    <h4>Achat et prêt de livres</h4>
                                    <p>Faciliter l'accès aux livres africains pour tous</p>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <div class="highlight-icon">
                                    <i class="fa fa-hands-helping"></i>
                                </div>
                                <div class="highlight-text">
                                    <h4>Accompagnement personnalisé</h4>
                                    <p>Conseils aux professionnels du livre africain</p>
                                </div>
                            </div>
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
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="stat-number" data-toggle="counter-up">{{ $totalMembres ?? 11 }}</div>
                    <div class="stat-label">Membres de l'équipe</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-book"></i>
                    </div>
                    <div class="stat-number" data-toggle="counter-up">{{ \App\Models\Catalogue::count() }}</div>
                    <div class="stat-label">Livres au catalogue</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-graduation-cap"></i>
                    </div>
                    <div class="stat-number" data-toggle="counter-up">{{ \App\Models\Formation::count() }}</div>
                    <div class="stat-label">Formations disponibles</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fa fa-user-graduate"></i>
                    </div>
                    <div class="stat-number" data-toggle="counter-up">{{ \App\Models\User::count() }}</div>
                    <div class="stat-label">Utilisateurs inscrits</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Values Section -->
    <div class="values-section">
        <div class="container">
            <div class="section-header">
                <span class="badge-text">Nos valeurs</span>
                <h2>Ce qui nous guide au quotidien</h2>
                <p>Des principes forts qui orientent toutes nos actions pour la promotion du livre africain</p>
            </div>

            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa fa-heart"></i>
                    </div>
                    <h3>Passion</h3>
                    <p>Un amour profond pour la littérature africaine et la conviction que chaque livre peut changer des vies.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa fa-handshake"></i>
                    </div>
                    <h3>Solidarité</h3>
                    <p>Construire ensemble un écosystème où chaque acteur du livre trouve sa place et peut s'épanouir.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">
                        <i class="fa fa-lightbulb"></i>
                    </div>
                    <h3>Innovation</h3>
                    <p>Utiliser les nouvelles technologies pour démocratiser l'accès au livre africain partout dans le monde.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Team Section - Pyramidal -->
    <div class="team-section">
        <div class="container">
            <div class="section-header">
                <span class="badge-text">Notre équipe</span>
                <h2>Les visages derrière Colibri Littéraire</h2>
                <p>Une équipe passionnée et dévouée à la promotion du livre africain</p>
            </div>

            @php
                // Séparer le président des autres membres
                $president = $membres->first(function($m) {
                    return stripos($m->poste, 'président') !== false || stripos($m->poste, 'directeur général') !== false;
                });

                $autresMembres = $membres->reject(function($m) use ($president) {
                    return $president && $m->id === $president->id;
                });

                // Diviser les autres membres en deux niveaux
                $niveau2 = $autresMembres->take(3);
                $niveau3 = $autresMembres->skip(3);
            @endphp

            @if($president || $autresMembres->count() > 0)
                <div class="team-pyramid">
                    @if($president)
                        <!-- Level 1 - President -->
                        <div class="team-level-1">
                            <div class="team-member-president">
                                <img src="{{ asset($president->photo) }}" alt="{{ $president->nom }}" class="president-photo">
                                <h4>{{ $president->nom }}</h4>
                                <span class="role">{{ $president->poste }}</span>
                                @if($president->bio)
                                    <p class="bio">{{ Str::limit($president->bio, 100) }}</p>
                                @endif
                            </div>
                        </div>

                        @if($autresMembres->count() > 0)
                            <!-- Connector -->
                            <div class="pyramid-connector">
                                <div class="connector-line"></div>
                            </div>
                            <div class="connector-branches"></div>
                        @endif
                    @endif

                    @if($niveau2->count() > 0)
                        <!-- Level 2 -->
                        <div class="team-level-2">
                            @foreach($niveau2 as $membre)
                                <div class="team-member-card">
                                    <img src="{{ asset($membre->photo) }}" alt="{{ $membre->nom }}" class="member-photo">
                                    <h4>{{ $membre->nom }}</h4>
                                    <span class="role">{{ $membre->poste }}</span>
                                    @if($membre->bio)
                                        <p class="bio">{{ Str::limit($membre->bio, 60) }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($niveau3->count() > 0)
                        <!-- Level 3 -->
                        <div class="team-level-3">
                            @foreach($niveau3 as $membre)
                                <div class="team-member-card">
                                    <img src="{{ asset($membre->photo) }}" alt="{{ $membre->nom }}" class="member-photo">
                                    <h4>{{ $membre->nom }}</h4>
                                    <span class="role">{{ $membre->poste }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="no-team-message">
                    <i class="fa fa-users"></i>
                    <p>Aucun membre de l'équipe pour le moment</p>
                </div>
            @endif
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="container">
            <div class="cta-card">
                <div class="cta-content">
                    <h2>Prêt à rejoindre l'aventure ?</h2>
                    <p>Découvrez nos formations certifiantes et notre catalogue de livres africains pour contribuer au rayonnement de la littérature africaine.</p>
                    <div class="cta-buttons">
                        <a href="{{ route('formation.modules') }}" class="btn-cta btn-cta-primary">
                            <i class="fa fa-graduation-cap"></i>
                            Voir les formations
                        </a>
                        <a href="{{ route('catalogue.index') }}" class="btn-cta btn-cta-secondary">
                            <i class="fa fa-book"></i>
                            Accéder au catalogue
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe id="videoFrame" src="" allowfullscreen allow="autoplay"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Video modal handler
    document.addEventListener('DOMContentLoaded', function() {
        const videoModal = document.getElementById('videoModal');
        const videoFrame = document.getElementById('videoFrame');

        if (videoModal) {
            videoModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const videoSrc = button.getAttribute('data-src');
                if (videoSrc) {
                    videoFrame.src = videoSrc + '?autoplay=1';
                }
            });

            videoModal.addEventListener('hide.bs.modal', function() {
                videoFrame.src = '';
            });
        }
    });
</script>
@endpush
