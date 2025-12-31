@extends('layouts.app')

@section('title', $formation->titre)
@section('meta_description', Str::limit($formation->description, 150))

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    @if($formation->image)
                        <img src="{{ asset($formation->image) }}" class="card-img-top" alt="{{ $formation->titre }}">
                    @endif
                    <div class="card-body">
                        <h2 class="card-title">{{ $formation->titre }}</h2>
                        <p class="card-text">{{ $formation->description }}</p>
                        <p><strong>Durée :</strong> {{ $formation->duree ?? 'N/A' }}</p>
                        <p><strong>Niveau :</strong> {{ $formation->niveau ?? 'Tous niveaux' }}</p>
                        <p><strong>Prix :</strong> {{ number_format($formation->prix ?? 0, 2, ',', ' ') }}€</p>

                        <form method="POST" action="{{ route('formation.acheter', $formation) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Acheter / S'inscrire</button>
                        </form>
                    </div>
                </div>

                <!-- Modules Section -->
                <h3 class="mt-4 mb-3"><i class="fas fa-book me-2"></i>Modules ({{ $formation->modules->count() }})</h3>
                <div class="list-group mb-4">
                    @forelse($formation->modules as $module)
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <h5 class="mb-2">{{ $module->titre }}</h5>

                                    @if($inscription && $inscription->paiement_valide)
                                        <p class="mb-2 text-muted">{{ $module->description ?? '' }}</p>
                                        <div class="d-flex gap-3 align-items-center">
                                            @if($module->duree)
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>{{ $module->duree }}
                                                </small>
                                            @endif
                                            @if($module->contenus && $module->contenus->count() > 0)
                                                <small class="text-muted">
                                                    <i class="fas fa-file-alt me-1"></i>{{ $module->contenus->count() }} contenu(s)
                                                </small>
                                            @endif
                                            @if($module->quizzes && $module->quizzes->count() > 0)
                                                <small class="text-success">
                                                    <i class="fas fa-question-circle me-1"></i>{{ $module->quizzes->count() }} quiz
                                                </small>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-warning mt-2 mb-2">
                                            <i class="fas fa-lock me-2"></i>
                                            <small>Inscrivez-vous et payez pour voir les détails de ce module</small>
                                        </div>
                                    @endif
                                </div>
                                @if($inscription && $inscription->paiement_valide)
                                    <a href="{{ route('formation.module.show', [$formation, $module]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Voir
                                    </a>
                                @else
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paiementRequiredModal">
                                        <i class="fas fa-eye me-1"></i>Voir
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>Aucun module pour cette formation.
                        </div>
                    @endforelse
                </div>

                <!-- Quiz Section -->
                @if($formation->quizzes && $formation->quizzes->count() > 0)
                    <h3 class="mt-5 mb-3"><i class="fas fa-question-circle me-2"></i>Quiz de la formation ({{ $formation->quizzes->count() }})</h3>
                    <div class="row">
                        @foreach($formation->quizzes as $quiz)
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">{{ $quiz->titre }}</h5>
                                            @if($quiz->active)
                                                <span class="badge bg-success">Actif</span>
                                            @else
                                                <span class="badge bg-secondary">Inactif</span>
                                            @endif
                                        </div>

                                        @if($inscription && $inscription->paiement_valide)
                                            @if($quiz->description)
                                                <p class="card-text text-muted small">{{ Str::limit($quiz->description, 100) }}</p>
                                            @endif

                                            <div class="row g-2 mt-2 mb-3">
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="fas fa-question text-primary me-2"></i>
                                                        <span>{{ $quiz->questions->count() }} questions</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="fas fa-star text-warning me-2"></i>
                                                        <span>{{ $quiz->total_points }} points</span>
                                                    </div>
                                                </div>
                                                @if($quiz->duree_minutes)
                                                    <div class="col-6">
                                                        <div class="d-flex align-items-center text-muted small">
                                                            <i class="fas fa-clock text-info me-2"></i>
                                                            <span>{{ $quiz->duree_minutes }} min</span>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center text-muted small">
                                                        <i class="fas fa-check-circle text-success me-2"></i>
                                                        <span>{{ $quiz->note_passage }}% requis</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="alert alert-warning mt-3 mb-3">
                                                <i class="fas fa-lock me-2"></i>
                                                <small>Inscrivez-vous et payez pour voir les détails de ce quiz</small>
                                            </div>
                                        @endif

                                        @auth
                                            @php
                                                $userAttempts = $quiz->attempts()->where('user_id', auth()->id())->count();
                                                $canAttempt = $quiz->userCanAttempt(auth()->id());
                                                $bestScore = $quiz->getUserBestScore(auth()->id());
                                            @endphp

                                            @if($bestScore !== null)
                                                <div class="alert alert-sm {{ $bestScore >= $quiz->note_passage ? 'alert-success' : 'alert-warning' }} py-2 mb-2">
                                                    <small>
                                                        <i class="fas fa-trophy me-1"></i>
                                                        Meilleur score: {{ number_format($bestScore, 1) }}%
                                                    </small>
                                                </div>
                                            @endif

                                            @if($canAttempt)
                                                @if($inscription && $inscription->paiement_valide)
                                                    <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-primary btn-sm w-100">
                                                        <i class="fas fa-play me-1"></i>
                                                        {{ $userAttempts > 0 ? 'Reprendre le quiz' : 'Commencer le quiz' }}
                                                    </a>
                                                @else
                                                    <button class="btn btn-primary btn-sm w-100" data-bs-toggle="modal" data-bs-target="#paiementRequiredModal">
                                                        <i class="fas fa-play me-1"></i>
                                                        {{ $userAttempts > 0 ? 'Reprendre le quiz' : 'Commencer le quiz' }}
                                                    </button>
                                                @endif
                                            @else
                                                <button class="btn btn-secondary btn-sm w-100" disabled>
                                                    <i class="fas fa-ban me-1"></i>Tentatives épuisées ({{ $userAttempts }}/{{ $quiz->nombre_tentatives }})
                                                </button>
                                            @endif
                                        @else
                                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="fas fa-sign-in-alt me-1"></i>Connectez-vous pour passer le quiz
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <!-- Sidebar: informations rapides -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <i class="fas fa-book text-primary me-2"></i>
                                <strong>Modules</strong>
                            </div>
                            <span class="badge bg-primary">{{ $formation->modules->count() }}</span>
                        </div>

                        @if($formation->quizzes && $formation->quizzes->count() > 0)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <i class="fas fa-question-circle text-success me-2"></i>
                                    <strong>Quiz</strong>
                                </div>
                                <span class="badge bg-success">{{ $formation->quizzes->count() }}</span>
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <i class="fas fa-clock text-info me-2"></i>
                                <strong>Durée</strong>
                            </div>
                            <span>{{ $formation->duree ?? 'N/A' }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <div>
                                <i class="fas fa-signal text-warning me-2"></i>
                                <strong>Niveau</strong>
                            </div>
                            <span>{{ $formation->niveau ?? 'Tous niveaux' }}</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-tag text-danger me-2"></i>
                                <strong>Prix</strong>
                            </div>
                            <span class="text-success fw-bold">{{ number_format($formation->prix ?? 0, 2, ',', ' ') }}€</span>
                        </div>
                    </div>
                </div>

                @auth
                    @if($formation->quizzes && $formation->quizzes->count() > 0)
                        <div class="card shadow-sm">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Votre progression</h6>
                            </div>
                            <div class="card-body">
                                @php
                                    $totalQuizzes = $formation->quizzes->count();
                                    $completedQuizzes = 0;
                                    foreach($formation->quizzes as $quiz) {
                                        $attempts = $quiz->attempts()->where('user_id', auth()->id())->where('reussi', true)->count();
                                        if ($attempts > 0) {
                                            $completedQuizzes++;
                                        }
                                    }
                                    $progressPercentage = $totalQuizzes > 0 ? ($completedQuizzes / $totalQuizzes) * 100 : 0;
                                @endphp

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small class="text-muted">Quiz réussis</small>
                                        <small class="text-muted">{{ $completedQuizzes }}/{{ $totalQuizzes }}</small>
                                    </div>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" role="progressbar"
                                             style="width: {{ $progressPercentage }}%;"
                                             aria-valuenow="{{ $progressPercentage }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100">
                                            {{ number_format($progressPercentage, 0) }}%
                                        </div>
                                    </div>
                                </div>

                                @if($progressPercentage == 100)
                                    <div class="alert alert-success py-2 mb-0">
                                        <i class="fas fa-trophy me-2"></i>
                                        <small>Félicitations! Tous les quiz sont réussis!</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Modal pour informer que le paiement est requis -->
    <div class="modal fade" id="paiementRequiredModal" tabindex="-1" aria-labelledby="paiementRequiredModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="paiementRequiredModalLabel">
                        <i class="fas fa-lock me-2"></i>Paiement requis
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-3">
                        <i class="fas fa-credit-card fa-4x text-warning mb-3"></i>
                        <h5 class="mb-3">Inscription et paiement requis</h5>
                        <p class="text-muted mb-4">
                            Pour accéder aux modules, quiz et à l'ensemble du contenu de cette formation, vous devez d'abord finaliser votre inscription et effectuer le paiement.
                        </p>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <small><strong>Formation:</strong> {{ $formation->titre }}</small><br>
                            <small><strong>Prix:</strong> {{ number_format($formation->prix ?? 0, 2, ',', ' ') }}€</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Fermer
                    </button>
                    <form method="POST" action="{{ route('formation.acheter', $formation) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-shopping-cart me-2"></i>Procéder au paiement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
