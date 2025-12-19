<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enregistrement Admin - Colibri Littéraire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            max-width: 500px;
            width: 100%;
        }
        .register-header {
            background: linear-gradient(135deg, #e53935 0%, #d32f2f 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
        }
        .register-header i {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        .register-body {
            padding: 40px 30px;
        }
        .form-control:focus {
            border-color: #e53935;
            box-shadow: 0 0 0 0.2rem rgba(229, 57, 53, 0.25);
        }
        .btn-register {
            background: linear-gradient(135deg, #e53935 0%, #d32f2f 100%);
            border: none;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.2s;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(229, 57, 53, 0.4);
        }
        .alert {
            border-radius: 10px;
        }
        .security-badge {
            background: linear-gradient(135deg, #ffd600 0%, #ff6f00 100%);
            color: #000;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(255, 214, 0, 0.3);
        }
        .password-strength {
            height: 5px;
            border-radius: 3px;
            margin-top: 5px;
            transition: all 0.3s;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-8">
                <div class="register-card">
                    <div class="register-header">
                        <i class="fas fa-user-shield"></i>
                        <h2 class="mb-0 fw-bold">Enregistrement Administrateur</h2>
                        <p class="mb-0 mt-2 opacity-75">Accès Ultra-Sécurisé</p>
                    </div>

                    <div class="register-body">
                        <!-- Badge de sécurité -->
                        <div class="text-center mb-4">
                            <span class="security-badge">
                                <i class="fas fa-lock me-2"></i>Lien Sécurisé Actif
                            </span>
                        </div>

                        <!-- Messages d'alerte -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Erreur !</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.register.post', $token) }}" id="registerForm">
                            @csrf

                            <!-- Nom -->
                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-user text-danger me-2"></i>Nom Complet
                                </label>
                                <input
                                    type="text"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Ex: Admin Principal"
                                    required
                                    autofocus
                                >
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="fas fa-envelope text-danger me-2"></i>Adresse Email
                                </label>
                                <input
                                    type="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="admin@colibri.com"
                                    required
                                >
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Mot de passe -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="fas fa-lock text-danger me-2"></i>Mot de passe
                                </label>
                                <input
                                    type="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Minimum 8 caractères"
                                    required
                                >
                                <div class="password-strength" id="passwordStrength"></div>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Utilisez au moins 8 caractères avec lettres et chiffres
                                </small>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirmation mot de passe -->
                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="fas fa-lock text-danger me-2"></i>Confirmer le mot de passe
                                </label>
                                <input
                                    type="password"
                                    class="form-control form-control-lg"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Retapez votre mot de passe"
                                    required
                                >
                            </div>

                            <!-- Avertissement de sécurité -->
                            <div class="alert alert-warning border-warning">
                                <i class="fas fa-shield-alt me-2"></i>
                                <strong>Important :</strong> Ce compte aura des privilèges administrateur complets.
                                Gardez vos identifiants en sécurité.
                            </div>

                            <!-- Bouton d'enregistrement -->
                            <button type="submit" class="btn btn-danger btn-register w-100 text-white btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Créer le Compte Admin
                            </button>
                        </form>

                        <hr class="my-4">

                        <!-- Lien retour -->
                        <div class="text-center">
                            <a href="{{ route('admin.login') }}" class="text-decoration-none text-muted">
                                <i class="fas fa-arrow-left me-2"></i>Retour à la connexion
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info de sécurité -->
                <div class="text-center mt-4 text-white">
                    <small class="opacity-75">
                        <i class="fas fa-lock me-1"></i>
                        Cette page est protégée par un token secret. Ne partagez jamais ce lien.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Indicateur de force du mot de passe
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('passwordStrength');

            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            // Couleurs et largeur basées sur la force
            const colors = ['#e53935', '#ff9800', '#ffc107', '#8bc34a', '#4caf50'];
            const widths = ['20%', '40%', '60%', '80%', '100%'];

            strengthBar.style.backgroundColor = colors[strength - 1] || '#e0e0e0';
            strengthBar.style.width = widths[strength - 1] || '0%';
        });

        // Confirmation avant soumission
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir créer ce compte administrateur ?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
