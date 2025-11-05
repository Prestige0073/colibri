
@extends('layouts.app')

@section('title', 'Réinitialisation du mot de passe')
@section('meta_description', "Réinitialisez votre mot de passe Colibri Littéraire en toute sécurité.")

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-9">
            <div class="card border-0 rounded-4 shadow-lg p-4" style="background: rgba(255,255,255,0.97);">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary mb-2">Réinitialiser le mot de passe</h2>
                    <p class="text-muted">Choisissez un nouveau mot de passe pour accéder à votre compte.</p>
                </div>
                <form method="POST" action="{{ route('password.store') }}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Adresse email</label>
                        <input id="email" type="email" class="form-control rounded-pill @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder="exemple@email.com">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Nouveau mot de passe</label>
                        <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Nouveau mot de passe">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label fw-semibold">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" class="form-control rounded-pill @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Répétez le mot de passe">
                        @error('password_confirmation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Réinitialiser</button>
                </form>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <a href="{{ route('login') }}" class="text-muted">Retour à la connexion</a>
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
.card .btn-primary {
    background: linear-gradient(90deg,#007bff,#00c6a7);
    border: none;
    font-size: 1.15rem;
    box-shadow: 0 2px 8px rgba(0,198,167,0.08);
    transition: background 0.2s;
}
.card .btn-primary:hover {
    background: linear-gradient(90deg,#00c6a7,#007bff);
}
</style>
@endpush
@endsection
