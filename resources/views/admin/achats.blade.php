@extends('admin.layout')
@section('title', 'Admin - Emprunts')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4" style="color:#1976d2;">Gestion des emprunts</h2>
    <div class="card shadow-lg border-0 rounded-4" style="background: #e3f0ff; box-shadow: 0 2px 16px 0 rgba(33,150,243,0.10);">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="background:#fff;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Utilisateur</th>
                            <th>Livre</th>
                            <th>Type</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Jean Dupont</td>
                            <td>Le Colibri Bleu</td>
                            <td>Achat</td>
                            <td>12/09/2025</td>
                            <td>
                                <button class="btn btn-sm btn-primary rounded-pill shadow-sm" style="background: linear-gradient(90deg,#1976d2 60%,#42a5f5 100%); border: none;">Modifier</button>
                                <button class="btn btn-sm btn-danger rounded-pill shadow-sm" style="background: linear-gradient(90deg,#e53935 60%,#ff7043 100%); border: none;">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Fatou Koné</td>
                            <td>Voyage en Afrique</td>
                            <td>Emprunt</td>
                            <td>10/09/2025</td>
                            <td>
                                <button class="btn btn-sm btn-primary">Modifier</button>
                                <button class="btn btn-sm btn-danger">Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Yao Kouassi</td>
                            <td>Contes du Baobab</td>
                            <td>Achat</td>
                            <td>08/09/2025</td>
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
