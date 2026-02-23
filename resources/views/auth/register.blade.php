@extends('layouts.app')

@section('title', 'Inscription | Colibri Littéraire')
@section('meta_description', 'Créez un compte Colibri Littéraire pour accéder à toutes les fonctionnalités et formations.')

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
        max-width: 950px;
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

    .auth-left-panel p {
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

    /* ============================================
       RIGHT PANEL - FORM
       ============================================ */
    .auth-right-panel {
        background: white;
        padding: 2.5rem 2.5rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .auth-form-header {
        margin-bottom: 1.75rem;
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
        margin-bottom: 1.15rem;
    }

    .auth-field label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--auth-text);
        margin-bottom: 0.4rem;
    }

    .auth-field label .auth-optional {
        color: var(--auth-text-muted);
        font-weight: 400;
        font-size: 0.8rem;
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
        padding: 0.75rem 1rem 0.75rem 2.75rem;
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

    .auth-input-wrapper input.is-valid {
        border-color: var(--auth-primary);
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

    .auth-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .auth-pw-help {
        font-size: 0.8rem;
        color: #dc3545;
        margin-top: 0.35rem;
        display: none;
    }

    .auth-pw-help.show {
        display: block;
    }

    .auth-submit {
        width: 100%;
        padding: 0.85rem 1.5rem;
        background: linear-gradient(135deg, var(--auth-primary) 0%, var(--auth-primary-dark) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .auth-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(30,122,47,0.35);
    }

    .auth-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .auth-footer-link {
        text-align: center;
        margin-top: 1.25rem;
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

        .auth-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .auth-hero h1 {
            font-size: 1.5rem;
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
                    <span>Inscription</span>
                </div>
                <h1><i class="fa fa-user-plus me-2"></i>Créer un compte</h1>
                <p>Rejoignez la communauté Colibri Littéraire et accédez à tout un univers littéraire africain.</p>
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
                        <h2>Bienvenue dans l'univers du livre africain</h2>
                        <p>En créant votre compte, vous accédez à un catalogue riche, des formations de qualité et une communauté passionnée.</p>

                        <ul class="auth-features">
                            <li>
                                <i class="fa fa-shopping-cart"></i>
                                <span>Achetez des livres africains en ligne</span>
                            </li>
                            <li>
                                <i class="fa fa-book-reader"></i>
                                <span>Empruntez gratuitement des ouvrages</span>
                            </li>
                            <li>
                                <i class="fa fa-graduation-cap"></i>
                                <span>Accédez aux formations certifiantes</span>
                            </li>
                            <li>
                                <i class="fa fa-users"></i>
                                <span>Rejoignez une communauté engagée</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Right panel - Form -->
                <div class="auth-right-panel">
                    <div class="auth-form-header">
                        <h3>Inscription</h3>
                        <p>Remplissez les informations ci-dessous pour créer votre compte</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" autocomplete="off" id="registerForm">
                        @csrf

                        <div class="auth-field">
                            <label for="name">Nom complet <span class="text-danger">*</span></label>
                            <div class="auth-input-wrapper">
                                <input id="name" type="text" name="name"
                                    class="@error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required autofocus autocomplete="name"
                                    placeholder="Votre nom et prénom">
                                <i class="fa fa-user auth-input-icon"></i>
                            </div>
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-field">
                            <label for="email">Adresse email <span class="text-danger">*</span></label>
                            <div class="auth-input-wrapper">
                                <input id="email" type="email" name="email"
                                    class="@error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autocomplete="username"
                                    placeholder="exemple@email.com">
                                <i class="fa fa-envelope auth-input-icon"></i>
                            </div>
                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-field">
                            <label>Téléphone</label>
                            @php
                                $regPhone = old('phone', '') ?? '';
                                $regParts = preg_match('/^(\+\d{1,4})\s*(.*)$/', $regPhone, $rm) ? [$rm[1], $rm[2]] : ['+229', old('phone_number', '')];
                            @endphp
                            <div id="phone-container-register" style="position: relative;"></div>
                            <input type="hidden" name="phone" id="phone_full_register">
                            @error('phone')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-field">
                            <label for="address">Adresse <span class="auth-optional">(facultatif)</span></label>
                            <div class="auth-input-wrapper">
                                <input id="address" type="text" name="address"
                                    class="@error('address') is-invalid @enderror"
                                    value="{{ old('address') }}" autocomplete="street-address"
                                    placeholder="Votre adresse">
                                <i class="fa fa-map-marker-alt auth-input-icon"></i>
                            </div>
                            @error('address')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-field">
                            <label for="password">Mot de passe <span class="text-danger">*</span></label>
                            <div class="auth-input-wrapper">
                                <input id="password" type="password" name="password"
                                    class="@error('password') is-invalid @enderror"
                                    required autocomplete="new-password"
                                    placeholder="Minimum 8 caractères">
                                <i class="fa fa-lock auth-input-icon"></i>
                                <button type="button" class="auth-toggle-pw" data-target="password" aria-label="Afficher/Masquer le mot de passe">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="auth-field">
                            <label for="password_confirmation">Confirmer le mot de passe <span class="text-danger">*</span></label>
                            <div class="auth-input-wrapper">
                                <input id="password_confirmation" type="password" name="password_confirmation"
                                    required autocomplete="new-password"
                                    placeholder="Retapez votre mot de passe">
                                <i class="fa fa-lock auth-input-icon"></i>
                                <button type="button" class="auth-toggle-pw" data-target="password_confirmation" aria-label="Afficher/Masquer la confirmation">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                            <div id="passwordHelp" class="auth-pw-help">Les mots de passe ne correspondent pas.</div>
                        </div>

                        <input type="hidden" name="role" value="membre">

                        <button type="submit" class="auth-submit" id="submitBtn">
                            <i class="fa fa-user-plus"></i>
                            <span>Créer mon compte</span>
                        </button>
                    </form>

                    <div class="auth-footer-link">
                        Déjà inscrit ? <a href="{{ route('login') }}">Se connecter</a>
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
    var pwd = document.getElementById('password');
    var pwdConfirm = document.getElementById('password_confirmation');
    var submitBtn = document.getElementById('submitBtn');
    var help = document.getElementById('passwordHelp');

    function updateState() {
        if (!pwd || !pwdConfirm) return;
        var match = (pwd.value === pwdConfirm.value && pwd.value.length > 0);
        if (match) {
            if (help) help.classList.remove('show');
            if (submitBtn) submitBtn.disabled = false;
            pwd.classList.remove('is-invalid');
            pwd.classList.add('is-valid');
            pwdConfirm.classList.remove('is-invalid');
            pwdConfirm.classList.add('is-valid');
        } else {
            if (pwd.value.length > 0 && pwdConfirm.value.length > 0) {
                if (help) help.classList.add('show');
                if (submitBtn) submitBtn.disabled = true;
                pwd.classList.add('is-invalid');
                pwdConfirm.classList.add('is-invalid');
                pwd.classList.remove('is-valid');
                pwdConfirm.classList.remove('is-valid');
            } else {
                if (help) help.classList.remove('show');
                if (submitBtn) submitBtn.disabled = false;
                pwd.classList.remove('is-invalid', 'is-valid');
                pwdConfirm.classList.remove('is-invalid', 'is-valid');
            }
        }
    }

    if (pwd) pwd.addEventListener('input', updateState);
    if (pwdConfirm) pwdConfirm.addEventListener('input', updateState);

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

    updateState();
});
</script>
<script src="{{ asset('js/phone-code-selector.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    PhoneCodeSelector.init({
        container: '#phone-container-register',
        hiddenInput: '#phone_full_register',
        defaultCode: @json($regParts[0]),
        defaultNumber: @json($regParts[1]),
        formId: 'registerForm'
    });
});
</script>
@endpush
