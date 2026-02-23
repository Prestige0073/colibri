@extends('layouts.app')

@section('title', 'Connexion | Colibri Littéraire')
@section('meta_description', 'Connectez-vous à votre compte Colibri Littéraire pour accéder à toutes les fonctionnalités.')

@push('styles')
<style>
    :root {
        --auth-primary: #1e7a2f;
        --auth-primary-dark: #155a22;
        --auth-primary-light: #e8f5e9;
        --auth-accent: #d4a853;
        --auth-text: #2d3436;
        --auth-text-muted: #636e72;
        --auth-bg: #f8faf9;
        --auth-radius: 16px;
        --auth-shadow: 0 4px 20px rgba(0,0,0,0.08);
        --auth-shadow-hover: 0 8px 30px rgba(0,0,0,0.12);
    }

    .auth-page {
        background: var(--auth-bg);
        min-height: 100vh;
    }

    /* ============================================
       HERO SECTION
       ============================================ */
    .auth-hero {
        background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-dark) 100%);
        padding: 2.5rem 0 3.5rem;
        position: relative;
        overflow: hidden;
    }

    .auth-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        animation: authPatternMove 30s linear infinite;
    }

    @keyframes authPatternMove {
        0% { background-position: 0 0; }
        100% { background-position: 60px 60px; }
    }

    .auth-hero-content {
        position: relative;
        z-index: 2;
    }

    .auth-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .auth-breadcrumb a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: color 0.2s;
    }

    .auth-breadcrumb a:hover { color: white; }

    .auth-breadcrumb i {
        color: rgba(255,255,255,0.5);
        font-size: 0.7rem;
    }

    .auth-breadcrumb span {
        color: white;
        font-weight: 500;
    }

    .auth-hero h1 {
        color: white;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .auth-hero p {
        color: rgba(255,255,255,0.85);
        font-size: 1.05rem;
        margin: 0;
    }

    /* ============================================
       MAIN SECTION
       ============================================ */
    .auth-main {
        padding: 3rem 0 4rem;
        margin-top: -2rem;
        position: relative;
        z-index: 3;
    }

    .auth-container {
        display: grid;
        grid-template-columns: 1fr 1.2fr;
        gap: 0;
        border-radius: var(--auth-radius);
        overflow: hidden;
        box-shadow: var(--auth-shadow-hover);
        max-width: 850px;
        margin: 0 auto;
    }

    /* ============================================
       LEFT PANEL - VISUAL
       ============================================ */
    .auth-left-panel {
        background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-dark) 100%);
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .auth-left-panel::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 60%);
        pointer-events: none;
    }

    .auth-left-content {
        position: relative;
        z-index: 2;
    }

    .auth-left-icon {
        width: 70px;
        height: 70px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1.5rem;
        backdrop-filter: blur(10px);
    }

    .auth-left-icon i {
        font-size: 1.8rem;
        color: white;
    }

    .auth-left-panel h2 {
        color: white;
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.3;
    }

    .auth-left-panel > .auth-left-content > p {
        color: rgba(255,255,255,0.85);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 2rem;
    }

    .auth-features {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .auth-features li {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: rgba(255,255,255,0.9);
        font-size: 0.9rem;
        margin-bottom: 0.85rem;
        padding: 0.5rem 0.75rem;
        background: rgba(255,255,255,0.08);
        border-radius: 10px;
        transition: background 0.2s;
    }

    .auth-features li:hover {
        background: rgba(255,255,255,0.14);
    }

    .auth-features li i {
        color: var(--auth-accent);
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .auth-register-cta {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255,255,255,0.15);
        text-align: center;
    }

    .auth-register-cta p {
        color: rgba(255,255,255,0.75);
        font-size: 0.85rem;
        margin-bottom: 0.75rem;
    }

    .auth-register-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.7rem 1.5rem;
        background: rgba(255,255,255,0.15);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s;
    }

    .auth-register-btn:hover {
        background: rgba(255,255,255,0.25);
        color: white;
        transform: translateY(-2px);
    }

    /* ============================================
       RIGHT PANEL - FORM
       ============================================ */
    .auth-right-panel {
        background: white;
        padding: 3rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-form-header {
        margin-bottom: 2rem;
    }

    .auth-form-header h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--auth-text);
        margin-bottom: 0.4rem;
    }

    .auth-form-header p {
        color: var(--auth-text-muted);
        font-size: 0.9rem;
        margin: 0;
    }

    /* Form fields */
    .auth-field {
        margin-bottom: 1.25rem;
    }

    .auth-field label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--auth-text);
        margin-bottom: 0.4rem;
    }

    .auth-input-wrapper {
        position: relative;
    }

    .auth-input-wrapper i.auth-input-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #b0b8c1;
        font-size: 0.9rem;
        transition: color 0.2s;
        pointer-events: none;
    }

    .auth-input-wrapper input {
        width: 100%;
        padding: 0.85rem 1rem 0.85rem 2.75rem;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        font-size: 0.95rem;
        color: var(--auth-text);
        transition: all 0.2s;
        background: #fafbfc;
    }

    .auth-input-wrapper input:focus {
        outline: none;
        border-color: var(--auth-primary);
        background: white;
        box-shadow: 0 0 0 4px rgba(30,122,47,0.08);
    }

    .auth-input-wrapper input:focus + i.auth-input-icon,
    .auth-input-wrapper input:focus ~ i.auth-input-icon {
        color: var(--auth-primary);
    }

    .auth-input-wrapper input.is-invalid {
        border-color: #dc3545;
    }

    .auth-toggle-pw {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #b0b8c1;
        cursor: pointer;
        padding: 0.25rem;
        font-size: 0.95rem;
        transition: color 0.2s;
        z-index: 3;
    }

    .auth-toggle-pw:hover {
        color: var(--auth-primary);
    }

    .auth-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .auth-remember {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .auth-remember input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--auth-primary);
        cursor: pointer;
    }

    .auth-remember span {
        font-size: 0.9rem;
        color: var(--auth-text-muted);
    }

    .auth-forgot {
        font-size: 0.9rem;
        color: var(--auth-primary);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s;
    }

    .auth-forgot:hover {
        color: var(--auth-primary-dark);
        text-decoration: underline;
    }

    .auth-submit {
        width: 100%;
        padding: 0.9rem 1.5rem;
        background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30,122,47,0.35);
    }

    .auth-footer-link {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
        color: var(--auth-text-muted);
    }

    .auth-footer-link a {
        color: var(--auth-primary);
        font-weight: 600;
        text-decoration: none;
        transition: color 0.2s;
    }

    .auth-footer-link a:hover {
        color: var(--auth-primary-dark);
        text-decoration: underline;
    }

    .invalid-feedback {
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }

    /* ============================================
       RESPONSIVE
       ============================================ */
    @media (max-width: 768px) {
        .auth-container {
            grid-template-columns: 1fr;
        }

        .auth-left-panel {
            padding: 2rem 1.5rem;
        }

        .auth-left-panel h2 {
            font-size: 1.3rem;
        }

        .auth-right-panel {
            padding: 2rem 1.5rem;
        }

        .auth-hero h1 {
            font-size: 1.5rem;
        }

        .auth-options {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="auth-page">
    <!-- Hero -->
    <div class="auth-hero">
        <div class="container">
            <div class="auth-hero-content">
                <div class="auth-breadcrumb">
                    <a href="{{ route('index') }}"><i class="fa fa-home"></i> Accueil</a>
                    <i class="fa fa-chevron-right"></i>
                    <span>Connexion</span>
                </div>
                <h1><i class="fa fa-sign-in-alt me-2"></i>Connexion</h1>
                <p>Accédez à votre espace personnel et profitez de la plateforme Colibri Littéraire.</p>
            </div>
        </div>
    </div>

    <!-- Main -->
    <div class="auth-main">
        <div class="container">
            @include('partials.notifications')

            <div class="auth-container">
                <!-- Left panel -->
                <div class="auth-left-panel">
                    <div class="auth-left-content">
                        <div class="auth-left-icon">
                            <i class="fa fa-book-open"></i>
                        </div>
                        <h2>Retrouvez votre espace littéraire</h2>
                        <p>Connectez-vous pour accéder à votre catalogue, vos emprunts et vos formations en cours.</p>

                        <ul class="auth-features">
                            <li>
                                <i class="fa fa-shopping-bag"></i>
                                <span>Suivez vos commandes en cours</span>
                            </li>
                            <li>
                                <i class="fa fa-book-reader"></i>
                                <span>Gérez vos emprunts de livres</span>
                            </li>
                            <li>
                                <i class="fa fa-graduation-cap"></i>
                                <span>Continuez vos formations</span>
                            </li>
                            <li>
                                <i class="fa fa-heart"></i>
                                <span>Retrouvez vos favoris</span>
                            </li>
                        </ul>

                        <div class="auth-register-cta">
                            <p>Pas encore membre ?</p>
                            <a href="{{ route('register') }}" class="auth-register-btn">
                                <i class="fa fa-user-plus"></i>
                                <span>Créer un compte</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right panel - Form -->
                <div class="auth-right-panel">
                    <div class="auth-form-header">
                        <h3>Bon retour parmi nous</h3>
                        <p>Entrez vos identifiants pour accéder à votre compte</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="auth-field">
                            <label for="email">Adresse email</label>
                            <div class="auth-input-wrapper">
                                <input id="email" type="email" name="email"
                                    class="@error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autofocus
                                    placeholder="exemple@email.com">
                                <i class="fa fa-envelope auth-input-icon"></i>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-field">
                            <label for="password">Mot de passe</label>
                            <div class="auth-input-wrapper">
                                <input id="password" type="password" name="password"
                                    class="@error('password') is-invalid @enderror"
                                    required placeholder="Votre mot de passe">
                                <i class="fa fa-lock auth-input-icon"></i>
                                <button type="button" class="auth-toggle-pw" data-target="password" aria-label="Afficher/Masquer le mot de passe">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-options">
                            <label class="auth-remember">
                                <input type="checkbox" name="remember" id="remember_me">
                                <span>Se souvenir de moi</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="auth-forgot">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </div>

                        <button type="submit" class="auth-submit">
                            <i class="fa fa-sign-in-alt"></i>
                            <span>Se connecter</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle password visibility
    document.querySelectorAll('.auth-toggle-pw').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var input = document.getElementById(targetId);
            var icon = this.querySelector('i');
            if (!input || !icon) return;

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
});
</script>
@endpush
