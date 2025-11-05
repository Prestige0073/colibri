@extends('admin.layout')
@section('title', 'Connexion Admin')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 rounded-4 p-4">
                <h3 class="fw-bold text-primary mb-3 text-center">Connexion Administrateur</h3>
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control rounded-pill" id="email" name="email" required autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control rounded-pill" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
