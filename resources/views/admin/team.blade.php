@extends('admin.layout')
@section('title', 'Admin - Équipe')
@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-sync-alt fa-spin fa-3x text-primary mb-4"></i>
                    <h2 class="mb-3">Redirection en cours...</h2>
                    <p class="text-muted mb-4">Vous allez être redirigé vers la nouvelle interface de gestion d'équipe.</p>
                    <a href="{{ route('admin.equipe.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-users me-2"></i>Accéder à la gestion d'équipe
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Redirection automatique après 2 secondes
    setTimeout(function() {
        window.location.href = "{{ route('admin.equipe.index') }}";
    }, 2000);
</script>

<!-- Ancien contenu désactivé
<div class="container-fluid py-4">
    <h2 class="mb-4"><i class="fa fa-users-cog me-2"></i>Gestion de l'équipe (exemple statique)</h2>
    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle border border-primary-subtle table-transition">
                    <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Poste</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Jean Dupont</td>
                            <td>Administrateur</td>
                            <td>jean.dupont@email.com</td>
                            <td>
                                <button class="btn btn-sm btn-gradient-blue me-1"><i class="fa fa-edit"></i> Modifier</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Fatou Koné</td>
                            <td>Formatrice</td>
                            <td>fatou.kone@email.com</td>
                            <td>
                                <button class="btn btn-sm btn-gradient-blue me-1"><i class="fa fa-edit"></i> Modifier</button>
                                <button class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Supprimer</button>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Yao Kouassi</td>
                            <td>Responsable pédagogique</td>
                            <td>yao.kouassi@email.com</td>
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
