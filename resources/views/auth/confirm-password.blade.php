
@extends('layouts.app')

@section('title', 'Confirmation du mot de passe')
@section('meta_description', "Confirmez votre mot de passe pour accéder à cette zone sécurisée de Colibri Littéraire.")

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-9">
            <div class="card border-0 rounded-4 shadow-lg p-4" style="background: rgba(255,255,255,0.97);">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary mb-2">Confirmation requise</h2>
                    <p class="text-muted">Veuillez confirmer votre mot de passe pour continuer.</p>
                </div>
                <form method="POST" action="{{ route('password.confirm') }}" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Mot de passe</label>
                        <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Votre mot de passe">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Confirmer</button>
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
