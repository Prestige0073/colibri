@extends('admin.layout')

@section('title', 'Admin - Dashboard')
@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h2 class="fw-bold text-primary">Tableau de bord administrateur</h2>
            <p class="text-muted">Vue d'ensemble des statistiques et accès rapide à la gestion du site.</p>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body py-4">
                    <i class="fa fa-users fa-2x text-success mb-2"></i>
                    <h5 class="fw-bold">Utilisateurs</h5>
                    <div class="fs-3 fw-bold text-primary">12</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body py-4">
                    <i class="fa fa-book fa-2x text-info mb-2"></i>
                    <h5 class="fw-bold">Livres</h5>
                    <div class="fs-3 fw-bold text-primary">8</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body py-4">
                    <i class="fa fa-graduation-cap fa-2x text-warning mb-2"></i>
                    <h5 class="fw-bold">Modules</h5>
                    <div class="fs-3 fw-bold text-primary">5</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow border-0 text-center">
                <div class="card-body py-4">
                    <i class="fa fa-shopping-bag fa-2x text-success mb-2"></i>
                    <h5 class="fw-bold">Achats/Emprunts</h5>
                    <div class="fs-3 fw-bold text-primary">21</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
