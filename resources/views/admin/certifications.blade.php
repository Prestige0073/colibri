@extends('admin.layout')
@section('title', 'Admin - Certifications')
@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4"><i class="fa fa-award me-2"></i>Gestion des certifications (exemple statique)</h2>
    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle border border-primary-subtle table-transition">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Utilisateur</th>
                            <th>Certification</th>
                            <th>Date d'obtention</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Jean Dupont</td>
                            <td>Lecture Rapide - Niveau 1</td>
                            <td>15/09/2025</td>
                            <td>
                                <button class="btn btn-sm btn-gradient-blue me-1"><i class="fa fa-edit"></i> Modifier</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Fatou Koné</td>
                            <td>Écriture Créative - Avancé</td>
                            <td>10/09/2025</td>
                            <td>
                                <button class="btn btn-sm btn-gradient-blue me-1"><i class="fa fa-edit"></i> Modifier</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Yao Kouassi</td>
                            <td>Analyse Littéraire - Expert</td>
                            <td>08/09/2025</td>
                            <td>
                                <button class="btn btn-sm btn-gradient-blue me-1"><i class="fa fa-edit"></i> Modifier</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
.btn-gradient-blue {
    background: linear-gradient(90deg, #1976d2 60%, #42a5f5 100%);
    color: #fff;
    border: none;
    box-shadow: 0 2px 8px 0 rgba(33,150,243,0.10);
    transition: background 0.2s, color 0.2s, box-shadow 0.2s;
}
.btn-gradient-blue:hover {
    background: #2196f3;
    color: #fff;
    box-shadow: 0 4px 16px 0 rgba(33,150,243,0.13);
}
</style>
@endpush
@endsection
