@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header -->
            <div class="mb-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('index') }}">Accueil</a></li>
                        @if($quiz->formation)
                            <li class="breadcrumb-item"><a href="{{ route('formation.show', $quiz->formation->id) }}">{{ $quiz->formation->titre }}</a></li>
                        @endif
                        @if($quiz->module)
                            <li class="breadcrumb-item">{{ $quiz->module->titre }}</li>
                        @endif
                        <li class="breadcrumb-item active">{{ $quiz->titre }}</li>
                    </ol>
                </nav>

                <h1 class="display-4 mb-3">{{ $quiz->titre }}</h1>
                @if($quiz->description)
                    <p class="lead text-muted">{{ $quiz->description }}</p>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Informations du quiz -->
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations sur le quiz</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-primary">
                                            <i class="fas fa-question-circle fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Questions</h6>
                                            <p class="mb-0 text-muted">{{ $quiz->questions->count() }} questions</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-success">
                                            <i class="fas fa-trophy fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Points</h6>
                                            <p class="mb-0 text-muted">{{ $quiz->total_points }} points au total</p>
                                        </div>
                                    </div>
                                </div>

                                @if($quiz->duree_minutes)
                                    <div class="col-sm-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3 text-warning">
                                                <i class="fas fa-clock fa-2x"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Durée</h6>
                                                <p class="mb-0 text-muted">{{ $quiz->duree_minutes }} minutes</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-info">
                                            <i class="fas fa-check-circle fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Note de passage</h6>
                                            <p class="mb-0 text-muted">{{ $quiz->note_passage }}%</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="me-3 text-secondary">
                                            <i class="fas fa-redo fa-2x"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">Tentatives</h6>
                                            <p class="mb-0 text-muted">{{ $attemptsCount }} / {{ $quiz->nombre_tentatives }} utilisées</p>
                                        </div>
                                    </div>
                                </div>

                                @if($bestScore !== null)
                                    <div class="col-sm-6 mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="me-3 text-success">
                                                <i class="fas fa-star fa-2x"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">Meilleur score</h6>
                                                <p class="mb-0 text-muted">{{ number_format($bestScore, 2) }}%</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if($canAttempt)
                                <hr>
                                <div class="text-center">
                                    <form action="{{ route('quiz.start', $quiz->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-play me-2"></i>Commencer le Quiz
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="alert alert-warning mt-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    Vous avez atteint le nombre maximum de tentatives pour ce quiz.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Historique des tentatives -->
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="fas fa-history me-2"></i>Vos tentatives</h5>
                        </div>
                        <div class="card-body">
                            @if($previousAttempts->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($previousAttempts as $index => $attempt)
                                        <div class="list-group-item px-0">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <strong>Tentative {{ $previousAttempts->count() - $index }}</strong>
                                                <span class="badge {{ $attempt->reussi ? 'bg-success' : 'bg-danger' }}">
                                                    {{ number_format($attempt->score, 2) }}%
                                                </span>
                                            </div>
                                            <div class="small text-muted">
                                                <i class="fas fa-calendar me-1"></i>{{ $attempt->created_at->format('d/m/Y H:i') }}
                                            </div>
                                            <div class="small text-muted">
                                                <i class="fas fa-clock me-1"></i>{{ $attempt->getDureeFormatted() }}
                                            </div>
                                            @if($attempt->fin_at)
                                                <a href="{{ route('quiz.result', [$quiz->id, $attempt->id]) }}" class="btn btn-sm btn-outline-primary mt-2">
                                                    Voir les résultats
                                                </a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted text-center mb-0">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    Aucune tentative pour l'instant
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
