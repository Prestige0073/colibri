
@extends('layouts.app')

@section('title', 'Vérification de l\'email')
@section('meta_description', "Vérifiez votre adresse email pour activer votre compte Colibri Littéraire.")

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-9">
            <div class="card border-0 rounded-4 shadow-lg p-4" style="background: rgba(255,255,255,0.97);">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary mb-2">Vérification de l'email</h2>
                    <p class="text-muted">Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer.<br>Si vous n'avez pas reçu l'email, vous pouvez en demander un nouveau.</p>
                </div>
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success mb-3">
                        Un nouveau lien de vérification a été envoyé à votre adresse email.
                    </div>
                @endif
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 mt-4">
                    <form method="POST" action="{{ route('verification.send') }}" class="w-100 w-md-auto">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold">Renvoyer l'email</button>
                    </form>
                    <form method="POST" action="{{ route('logout') }}" class="w-100 w-md-auto">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted w-100">Se déconnecter</button>
                    </form>
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
