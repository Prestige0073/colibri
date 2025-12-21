@extends('layouts.app')

@push('styles')
<style>
    .result-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 10px;
        padding: 2rem;
        margin-bottom: 2rem;
    }
    .result-header.success {
        background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%);
    }
    .result-header.failed {
        background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%);
    }
    .score-circle {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        background: white;
        color: #333;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .question-result {
        border-left: 4px solid #dee2e6;
        transition: all 0.3s;
    }
    .question-result.correct {
        border-left-color: #28a745;
        background-color: #f1f9f3;
    }
    .question-result.incorrect {
        border-left-color: #dc3545;
        background-color: #fdf3f3;
    }
    .correct-answer {
        background-color: #d4edda;
        border-left: 3px solid #28a745;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
    .user-answer {
        background-color: #f8d7da;
        border-left: 3px solid #dc3545;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header de résultat -->
            <div class="result-header {{ $attempt->reussi ? 'success' : 'failed' }} text-center">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="mb-3">
                            @if($attempt->reussi)
                                <i class="fas fa-check-circle me-2"></i>Félicitations !
                            @else
                                <i class="fas fa-times-circle me-2"></i>Quiz non réussi
                            @endif
                        </h1>
                        <h3 class="mb-0">{{ $quiz->titre }}</h3>
                        @if($attempt->reussi)
                            <p class="mb-0 mt-2">Vous avez réussi le quiz avec succès !</p>
                        @else
                            <p class="mb-0 mt-2">Note de passage : {{ $quiz->note_passage }}%</p>
                        @endif
                    </div>
                    <div class="col-md-4">
                        <div class="score-circle mx-auto">
                            {{ number_format($attempt->score, 1) }}%
                        </div>
                        <p class="mt-2 mb-0">{{ $attempt->points_obtenus }} / {{ $attempt->points_total }} points</p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-question-circle fa-2x text-primary mb-2"></i>
                            <h5>{{ $questions->count() }}</h5>
                            <p class="text-muted mb-0">Questions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <h5>{{ collect($questions)->filter(function($q) use ($userAnswers) {
                                $selected = $userAnswers[$q->id] ?? null;
                                return $q->isCorrectAnswer($selected);
                            })->count() }}</h5>
                            <p class="text-muted mb-0">Correctes</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                            <h5>{{ $attempt->getDureeFormatted() }}</h5>
                            <p class="text-muted mb-0">Durée</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                            <h5>{{ $attempt->created_at->format('d/m/Y') }}</h5>
                            <p class="text-muted mb-0">{{ $attempt->created_at->format('H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Détails des questions -->
            @if($quiz->afficher_reponses)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="fas fa-list me-2"></i>Correction détaillée</h5>
                    </div>
                    <div class="card-body">
                        @foreach($questions as $index => $question)
                            @php
                                $userAnswer = $userAnswers[$question->id] ?? null;
                                $isCorrect = $question->isCorrectAnswer($userAnswer);
                                $correctOptionIds = $question->getCorrectOptionIds();
                            @endphp

                            <div class="card question-result {{ $isCorrect ? 'correct' : 'incorrect' }} mb-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <h6>
                                            <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }} me-2">
                                                Q{{ $index + 1 }}
                                            </span>
                                            {{ $question->question }}
                                        </h6>
                                        <div>
                                            @if($isCorrect)
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>+{{ $question->points }} pts
                                                </span>
                                            @else
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-times me-1"></i>0 pt
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Options -->
                                    <div class="options-list mb-3">
                                        @foreach($question->options as $optIndex => $option)
                                            @php
                                                $isUserChoice = false;
                                                if (is_array($userAnswer)) {
                                                    $isUserChoice = in_array($option->id, $userAnswer);
                                                } else {
                                                    $isUserChoice = $userAnswer == $option->id;
                                                }
                                            @endphp

                                            <div class="p-2 mb-1 rounded {{ $option->is_correct ? 'border border-success' : '' }} {{ $isUserChoice && !$option->is_correct ? 'border border-danger' : '' }}">
                                                @if($option->is_correct)
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                @elseif($isUserChoice)
                                                    <i class="fas fa-times-circle text-danger me-2"></i>
                                                @else
                                                    <i class="far fa-circle text-muted me-2"></i>
                                                @endif

                                                <span class="fw-bold me-2">{{ chr(65 + $optIndex) }}.</span>
                                                {{ $option->option_text }}

                                                @if($isUserChoice)
                                                    <span class="badge bg-info ms-2">Votre réponse</span>
                                                @endif
                                                @if($option->is_correct)
                                                    <span class="badge bg-success ms-2">Bonne réponse</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Explication -->
                                    @if($question->explication)
                                        <div class="alert alert-info mb-0">
                                            <strong><i class="fas fa-lightbulb me-2"></i>Explication :</strong>
                                            <p class="mb-0 mt-2">{{ $question->explication }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="d-flex justify-content-between mb-5">
                <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour au quiz
                </a>

                @php
                    $canRetry = $quiz->userCanAttempt(Auth::id());
                @endphp

                @if($canRetry && !$attempt->reussi)
                    <form action="{{ route('quiz.start', $quiz->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-redo me-2"></i>Réessayer
                        </button>
                    </form>
                @elseif($attempt->reussi)
                    <a href="{{ $quiz->formation ? route('formation.show', $quiz->formation->id) : route('index') }}" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Continuer
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
