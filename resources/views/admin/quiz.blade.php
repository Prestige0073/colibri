@extends('admin.layout')
@section('title', 'Admin - Quiz & Certifications')
@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4"><i class="fa fa-question-circle me-2"></i>Gestion des quiz & certifications (exemple statique)</h2>
    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle border border-primary-subtle table-transition">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nom du quiz</th>
                            <th>Module</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Quiz Lecture Rapide</td>
                            <td>Lecture Rapide</td>
                            <td><span class="badge bg-gradient bg-primary">Actif</span></td>
                            <td>
                                <button class="btn btn-sm btn-gradient-blue me-1"><i class="fa fa-edit"></i> Modifier</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Quiz Écriture</td>
                            <td>Écriture Créative</td>
                            <td><span class="badge bg-secondary">Inactif</span></td>
                            <td>
                                <button class="btn btn-sm btn-gradient-blue me-1"><i class="fa fa-edit"></i> Modifier</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Quiz Analyse</td>
                            <td>Analyse Littéraire</td>
                            <td><span class="badge bg-gradient bg-primary">Actif</span></td>
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
