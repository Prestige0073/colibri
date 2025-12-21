@extends('admin.layout')

@section('title', 'Gestion des Quiz')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-question-circle me-2"></i>Quiz & QCM</h1>
        <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Créer un Quiz
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($quizzes->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Titre</th>
                                <th>Lié à</th>
                                <th>Questions</th>
                                <th>Note de passage</th>
                                <th>Tentatives</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quizzes as $quiz)
                                <tr>
                                    <td>
                                        <strong>{{ $quiz->titre }}</strong>
                                        @if($quiz->description)
                                            <br><small class="text-muted">{{ Str::limit($quiz->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($quiz->formation)
                                            <span class="badge bg-info">
                                                <i class="fas fa-graduation-cap me-1"></i>{{ $quiz->formation->titre }}
                                            </span>
                                        @endif
                                        @if($quiz->module)
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-book me-1"></i>{{ $quiz->module->titre }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $quiz->questions->count() }} question(s)</span>
                                        @if($quiz->questions->count() > 0)
                                            <br><small class="text-muted">{{ $quiz->total_points }} points</small>
                                        @endif
                                    </td>
                                    <td>{{ $quiz->note_passage }}%</td>
                                    <td>{{ $quiz->nombre_tentatives }}</td>
                                    <td>
                                        @if($quiz->active)
                                            <span class="badge bg-success">Actif</span>
                                        @else
                                            <span class="badge bg-secondary">Inactif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.quizzes.show', $quiz->id) }}" class="btn btn-sm btn-info" title="Voir">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-sm btn-warning" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.quizzes.destroy', $quiz->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce quiz ?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Supprimer">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $quizzes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-question-circle fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Aucun quiz disponible</h4>
                    <p class="text-muted">Créez votre premier quiz pour tester vos apprenants.</p>
                    <a href="{{ route('admin.quizzes.create') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus me-2"></i>Créer un Quiz
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
