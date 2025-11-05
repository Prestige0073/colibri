@extends('admin.layout')
@section('title', 'Admin - Contacts')
@section('content')
<div class="container-fluid py-4">
    <h2 class="fw-bold mb-4" style="color:#1976d2;">Gestion des contacts</h2>
    <div class="card shadow border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" style="background:#fff;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jean Dupont</td>
                        <td>jean.dupont@email.com</td>
                        <td>Bonjour, j'aimerais en savoir plus sur vos modules.</td>
                        <td>15/09/2025</td>
                        <td>
                            <button class="btn btn-sm btn-info">Voir</button>
                            <button class="btn btn-sm btn-danger rounded-pill shadow-sm" style="background: linear-gradient(90deg,#e53935 60%,#ff7043 100%); border: none;">Supprimer</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Fatou Koné</td>
                        <td>fatou.kone@email.com</td>
                        <td>Merci pour votre réponse rapide !</td>
                        <td>10/09/2025</td>
                        <td>
                            <button class="btn btn-sm btn-info">Voir</button>
                            <button class="btn btn-sm btn-danger rounded-pill shadow-sm" style="background: linear-gradient(90deg,#e53935 60%,#ff7043 100%); border: none;">Supprimer</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Yao Kouassi</td>
                        <td>yao.kouassi@email.com</td>
                        <td>Je souhaite m'inscrire à la prochaine session.</td>
                        <td>08/09/2025</td>
                        <td>
                            <button class="btn btn-sm btn-info">Voir</button>
                            <button class="btn btn-sm btn-danger rounded-pill shadow-sm" style="background: linear-gradient(90deg,#e53935 60%,#ff7043 100%); border: none;">Supprimer</button>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
