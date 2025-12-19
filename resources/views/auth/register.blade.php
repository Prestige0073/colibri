@extends('layouts.app')

@section('title', 'Inscription')
@section('meta_description', 'Créez un compte Colibri Littéraire pour accéder à toutes les fonctionnalités et
    formations.')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-9">
                <div class="card border-0 rounded-4 shadow-lg p-4" style="background: rgba(255,255,255,0.97);">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold text-success mb-2">Inscription</h2>
                        <p class="text-muted">Rejoignez la communauté Colibri Littéraire et accédez à votre espace personnel.
                        </p>
                    </div>
                    <form method="POST" action="{{ route('register') }}" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Nom complet</label>
                            <input id="name" type="text"
                                class="form-control rounded-pill @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autofocus autocomplete="name"
                                placeholder="Votre nom et prénom">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Adresse email</label>
                            <input id="email" type="email"
                                class="form-control rounded-pill @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="username"
                                placeholder="exemple@email.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Téléphone</label>
                            <input id="phone" type="text"
                                class="form-control rounded-pill @error('phone') is-invalid @enderror" name="phone"
                                value="{{ old('phone') }}" autocomplete="tel" placeholder="Votre numéro de téléphone">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Adresse</label>
                            <input id="address" type="text"
                                class="form-control rounded-pill @error('address') is-invalid @enderror" name="address"
                                value="{{ old('address') }}" autocomplete="street-address"
                                placeholder="Votre adresse (facultatif)">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password" class="form-label fw-semibold">Mot de passe</label>
                            <div class="input-group">
                                <input id="password" type="password"
                                    class="form-control rounded-pill @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="new-password" placeholder="Mot de passe">
                                <span class="input-group-text bg-white border-0" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);z-index:3;cursor:pointer;">
                                    <a href="#" id="togglePassword" role="button" tabindex="0" aria-label="Afficher/Masquer le mot de passe" class="text-muted" style="text-decoration:none;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <div class="input-group">
                                <input type="password" class="form-control rounded-pill" id="password_confirmation"
                                    name="password_confirmation" required>
                                <span class="input-group-text bg-white border-0"
                                    style="position:absolute;right:12px;top:50%;transform:translateY(-50%);z-index:3;cursor:pointer;">
                                    <a href="#" id="togglePasswordConfirm" role="button" tabindex="0" aria-label="Afficher/Masquer la confirmation du mot de passe" class="text-muted"
                                        style="text-decoration:none;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                </span>
                            </div>
                            <div id="passwordHelp" class="form-text text-danger mt-1" style="display:none;">Les mots de
                                passe ne correspondent pas.</div>
                        </div>
                        <input type="hidden" name="role" value="membre">
                        <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold">S'inscrire</button>
                    </form>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <a href="{{ route('login') }}" class="text-muted">Déjà inscrit ? <span
                                class="text-success fw-semibold">Se connecter</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <style>
            .card input.form-control {
                font-size: 1.08rem;
                padding: 0.7rem 1.2rem;
                border: 1.5px solid #e0e0e0;
                box-shadow: 0 2px 8px rgba(0, 123, 255, 0.04);
                transition: border-color 0.2s;
            }

            .card input.form-control:focus {
                border-color: #007bff;
                box-shadow: 0 4px 16px rgba(0, 123, 255, 0.10);
            }

            .card label.form-label {
                color: #007bff;
            }

            .card .btn-success {
                background: linear-gradient(90deg, #007bff, #00c6a7);
                border: none;
                font-size: 1.15rem;
                box-shadow: 0 2px 8px rgba(0, 198, 167, 0.08);
                transition: background 0.2s;
            }

            .card .btn-success:hover {
                background: linear-gradient(90deg, #00c6a7, #007bff);
            }
        </style>
    @endpush
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var pwd = document.getElementById('password');
            var pwdConfirm = document.getElementById('password_confirmation');
            var toggle = document.getElementById('togglePassword');
            var toggleConfirm = document.getElementById('togglePasswordConfirm');
            var submitBtn = document.querySelector('button[type="submit"]');
            var help = document.getElementById('passwordHelp');

            function updateState() {
                if (!pwd || !pwdConfirm) return;
                var match = (pwd.value === pwdConfirm.value && pwd.value.length > 0);
                if (match) {
                    // match
                    if (help) { help.style.display = 'none'; help.classList.remove('text-danger'); }
                    if (submitBtn) submitBtn.disabled = false;
                    pwd.classList.remove('is-invalid'); pwd.classList.add('is-valid');
                    pwdConfirm.classList.remove('is-invalid'); pwdConfirm.classList.add('is-valid');
                } else {
                    if (help) { help.style.display = 'block'; help.classList.add('text-danger'); }
                    if (submitBtn) submitBtn.disabled = true;
                    // show invalid only if something entered
                    if (pwd.value.length > 0 || pwdConfirm.value.length > 0) {
                        pwd.classList.add('is-invalid'); pwdConfirm.classList.add('is-invalid');
                        pwd.classList.remove('is-valid'); pwdConfirm.classList.remove('is-valid');
                    } else {
                        pwd.classList.remove('is-invalid'); pwdConfirm.classList.remove('is-invalid');
                        pwd.classList.remove('is-valid'); pwdConfirm.classList.remove('is-valid');
                    }
                }
            }

            if (pwd) pwd.addEventListener('input', updateState);
            if (pwdConfirm) pwdConfirm.addEventListener('input', updateState);

            function bindToggle(toggleEl, inputEl) {
                if (!toggleEl || !inputEl) return;
                var icon = toggleEl.querySelector('i');
                var toggleFn = function(e) {
                    if (e) e.preventDefault();
                    if (inputEl.type === 'password') {
                        inputEl.type = 'text';
                        if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
                    } else {
                        inputEl.type = 'password';
                        if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
                    }
                };
                toggleEl.addEventListener('click', toggleFn);
                // keyboard accessibility (Enter / Space)
                toggleEl.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        toggleFn();
                    }
                });
            }

            bindToggle(toggle, pwd);
            bindToggle(toggleConfirm, pwdConfirm);

            // initial state
            updateState();
        });
    </script>
@endpush