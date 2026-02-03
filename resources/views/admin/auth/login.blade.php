<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Colibri Littéraire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #1e7a2f;
            --admin-primary-dark: #155a22;
            --admin-primary-light: #e8f5e9;
            --admin-accent: #2d8a3e;
            --admin-text: #2d3436;
            --admin-text-muted: #636e72;
        }

        * {
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--admin-primary-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 2rem 0;
            box-sizing: border-box;
        }

        /* Fond animé */
        .bg-pattern {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            background:
                linear-gradient(135deg, var(--admin-primary-dark) 0%, var(--admin-primary) 50%, #2d8a3e 100%);
        }

        .bg-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            animation: patternMove 20s linear infinite;
        }

        @keyframes patternMove {
            0% { background-position: 0 0; }
            100% { background-position: 60px 60px; }
        }

        /* Cercles décoratifs */
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .shape-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
            animation: float 8s ease-in-out infinite;
        }

        .shape-2 {
            width: 300px;
            height: 300px;
            bottom: -50px;
            left: -50px;
            animation: float 10s ease-in-out infinite reverse;
        }

        .shape-3 {
            width: 200px;
            height: 200px;
            top: 50%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Conteneur principal */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            padding: 20px;
            margin: auto;
        }

        /* Logo / Brand */
        .brand-section {
            text-align: center;
            margin-bottom: 2rem;
        }

        .brand-logo {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            animation: logoEntrance 0.6s ease;
            padding: 10px;
            overflow: hidden;
        }

        @keyframes logoEntrance {
            from { transform: scale(0) rotate(-180deg); opacity: 0; }
            to { transform: scale(1) rotate(0deg); opacity: 1; }
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-title {
            color: white;
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .brand-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        /* Carte de connexion */
        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            animation: cardEntrance 0.5s ease 0.2s both;
        }

        @keyframes cardEntrance {
            from { transform: translateY(30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .login-header {
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-accent) 100%);
            padding: 2rem 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 60%);
        }

        .login-header-content {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
        }

        .header-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .header-text h2 {
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        .header-text p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.85rem;
            margin: 0;
        }

        /* Corps du formulaire */
        .login-body {
            padding: 2.5rem;
        }

        /* Alertes */
        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-success {
            background: var(--admin-primary-light);
            color: var(--admin-primary-dark);
        }

        .alert i {
            font-size: 1.1rem;
            margin-top: 2px;
        }

        .alert .btn-close {
            margin-left: auto;
            padding: 0.5rem;
        }

        /* Champs de formulaire */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--admin-text);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-label i {
            color: var(--admin-primary);
            font-size: 0.85rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            height: 54px;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 0 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 4px var(--admin-primary-light);
            background: white;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--admin-text-muted);
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.2s;
        }

        .password-toggle:hover {
            color: var(--admin-primary);
        }

        .invalid-feedback {
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        /* Checkbox */
        .form-check {
            margin-bottom: 1.5rem;
        }

        .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            margin-right: 0.5rem;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--admin-primary);
            border-color: var(--admin-primary);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 4px var(--admin-primary-light);
        }

        .form-check-label {
            cursor: pointer;
            color: var(--admin-text-muted);
            font-size: 0.9rem;
        }

        /* Bouton de connexion */
        .btn-login {
            width: 100%;
            height: 54px;
            background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-accent) 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.3px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(30, 122, 47, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(30, 122, 47, 0.4);
            background: linear-gradient(135deg, var(--admin-primary-dark) 0%, var(--admin-primary) 100%);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .btn-login i {
            font-size: 1.1rem;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 1.75rem 0;
            color: var(--admin-text-muted);
            font-size: 0.85rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e9ecef;
        }

        .divider span {
            padding: 0 1rem;
        }

        /* Lien retour */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--admin-text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            padding: 0.75rem;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .back-link:hover {
            background: #f8f9fa;
            color: var(--admin-primary);
        }

        .back-link i {
            transition: transform 0.2s;
        }

        .back-link:hover i {
            transform: translateX(-3px);
        }

        /* Footer info */
        .footer-info {
            text-align: center;
            margin-top: 1.5rem;
            animation: fadeIn 0.5s ease 0.4s both;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .footer-info p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .footer-info i {
            font-size: 1rem;
        }

        /* Large screens */
        @media (min-width: 992px) {
            body {
                padding: 3rem 0;
            }

            .login-container {
                max-width: 440px;
            }

            .brand-logo {
                width: 110px;
                height: 110px;
            }
        }

        /* Responsive - Tablets */
        @media (max-width: 768px) {
            body {
                padding: 1.5rem 0;
            }

            .brand-logo {
                width: 90px;
                height: 90px;
            }
        }

        /* Responsive - Mobile */
        @media (max-width: 576px) {
            body {
                padding: 1rem 0;
            }

            .login-container {
                padding: 15px;
            }

            .brand-logo {
                width: 80px;
                height: 80px;
            }

            .brand-title {
                font-size: 1.5rem;
            }

            .login-header {
                padding: 1.5rem;
            }

            .login-body {
                padding: 1.75rem;
            }

            .header-icon {
                width: 45px;
                height: 45px;
            }

            .header-text h2 {
                font-size: 1.1rem;
            }

            .form-control {
                height: 50px;
            }

            .btn-login {
                height: 50px;
            }
        }

        /* Animation de chargement pour le bouton */
        .btn-login.loading {
            pointer-events: none;
            opacity: 0.8;
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        .btn-login .spinner {
            display: none;
        }

        .btn-login.loading .spinner {
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Fond -->
    <div class="bg-pattern"></div>
    <div class="floating-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
    </div>

    <div class="login-container">
        <!-- Brand -->
        <div class="brand-section">
            <div class="brand-logo">
                <img src="{{ asset('img/LOGO-COLIBRI-LITTERAIRE.png') }}" alt="Colibri Littéraire">
            </div>
            <h1 class="brand-title">Colibri Littéraire</h1>
            <p class="brand-subtitle">Portail d'Administration</p>
        </div>

        <!-- Carte de connexion -->
        <div class="login-card">
            <div class="login-header">
                <div class="login-header-content">
                    <div class="header-icon">
                        <i class="fas fa-shield-halved"></i>
                    </div>
                    <div class="header-text">
                        <h2>Espace Sécurisé</h2>
                        <p>Connectez-vous pour accéder au tableau de bord</p>
                    </div>
                </div>
            </div>

            <div class="login-body">
                <!-- Alertes -->
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>{{ session('error') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
                    </div>
                @endif

                <!-- Formulaire -->
                <form method="POST" action="{{ route('admin.login.post') }}" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope"></i>
                            Adresse Email
                        </label>
                        <div class="input-wrapper">
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="admin@colibrilitteraire.com"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>
                            Mot de passe
                        </label>
                        <div class="input-wrapper">
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                placeholder="Entrez votre mot de passe"
                                required
                            >
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Se souvenir de moi sur cet appareil
                        </label>
                    </div>

                    <button type="submit" class="btn btn-login" id="submitBtn">
                        <span class="btn-text">
                            <i class="fas fa-sign-in-alt"></i>
                            Se Connecter
                        </span>
                        <span class="spinner">
                            <i class="fas fa-spinner fa-spin"></i>
                            Connexion...
                        </span>
                    </button>
                </form>

                <div class="divider">
                    <span>ou</span>
                </div>

                <a href="{{ route('index') }}" class="back-link">
                    <i class="fas fa-arrow-left"></i>
                    Retour au site principal
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer-info">
            <p>
                <i class="fas fa-lock"></i>
                Accès réservé aux administrateurs autorisés
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Loading state on form submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
        });
    </script>
</body>
</html>
