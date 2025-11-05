
@extends('layouts.app')

@section('title', 'Connexion')
@section('meta_description', 'Connectez-vous à votre compte Colibri Littéraire pour accéder à toutes les fonctionnalités.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-9">
            <div class="card border-0 rounded-4 shadow-lg p-4" style="background: rgba(255,255,255,0.97);">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success mb-2">Connexion</h2>
                    <p class="text-muted">Accédez à votre espace personnel et profitez de la plateforme.</p>
                </div>
                @if(session('status'))
                    <div class="alert alert-success mb-3">{{ session('status') }}</div>
                @endif
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Adresse email</label>
                        <input type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="exemple@email.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Mot de passe</label>
                        <input type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Mot de passe">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                    </div>
                    <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold">Se connecter</button>
                </form>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted">Mot de passe oublié ?</a>
                    @endif
                    <span class="text-muted">Pas encore de compte ? <a href="{{ route('register') }}" class="text-success fw-semibold">S'inscrire</a></span>
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
    box-shadow: 0 2px 8px rgba(0,123,255,0.04);
    transition: border-color 0.2s;
}
.card input.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 4px 16px rgba(0,123,255,0.10);
}
.card label.form-label {
    color: #007bff;
}
.card .btn-success {
    background: linear-gradient(90deg,#007bff,#00c6a7);
    border: none;
    font-size: 1.15rem;
    box-shadow: 0 2px 8px rgba(0,198,167,0.08);
    transition: background 0.2s;
}
.card .btn-success:hover {
    background: linear-gradient(90deg,#00c6a7,#007bff);
}
</style>
@endpush
@endsection
