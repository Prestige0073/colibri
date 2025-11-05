@extends('admin.layout')
@section('title', 'Admin - Événements')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4" style="color:#1976d2;">Gestion des événements</h2>
    <div class="card shadow-lg border-0 rounded-4" style="background: #e3f0ff; box-shadow: 0 2px 16px 0 rgba(33,150,243,0.10);">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="background:#fff;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
            <tr>
                <td>1</td>
                <td>Atelier Lecture</td>
                <td>20/09/2025</td>
                <td>Abidjan</td>
                <td>
                    <button class="btn btn-sm btn-primary rounded-pill shadow-sm" style="background: linear-gradient(90deg,#1976d2 60%,#42a5f5 100%); border: none;">Modifier</button>
                    <button class="btn btn-sm btn-danger rounded-pill shadow-sm" style="background: linear-gradient(90deg,#e53935 60%,#ff7043 100%); border: none;">Supprimer</button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Conférence Écriture</td>
                <td>25/09/2025</td>
                <td>Bouaké</td>
                <td>
                    <button class="btn btn-sm btn-primary">Modifier</button>
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td>Salon du Livre</td>
                <td>30/09/2025</td>
                <td>Yamoussoukro</td>
                <td>
                    <button class="btn btn-sm btn-primary">Modifier</button>
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                </td>
            </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
