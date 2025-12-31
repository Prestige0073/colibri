@extends('layouts.app')

@push('styles')
<style>
    .question-card {
        border-left: 4px solid #007bff;
    }
    .option-label {
        cursor: pointer;
        transition: all 0.2s;
        padding: 15px;
        border-radius: 5px;
        border: 2px solid #dee2e6;
    }
    .option-label:hover {
        background-color: #f8f9fa;
        border-color: #007bff;
    }
    .option-input:checked + .option-label {
        background-color: #e7f3ff;
        border-color: #007bff;
        font-weight: 500;
    }
    .option-input {
        position: absolute;
        opacity: 0;
    }
    .timer-warning {
        animation: pulse 1s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .sticky-footer {
        position: sticky;
        bottom: 0;
        background: white;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
        z-index: 100;
    }
</style>
@endpush

@section('content')
<div class="container my-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Header avec timer -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-1">{{ $quiz->titre }}</h4>
                            <p class="mb-0 text-muted">{{ $questions->count() }} questions - {{ $quiz->total_points }} points</p>
                        </div>
                        @if($quiz->duree_minutes)
                            <div class="text-end">
                                <h5 class="mb-0" id="timer">
                                    <i class="fas fa-clock me-2"></i>
                                    <span id="timer-display">{{ $quiz->duree_minutes }}:00</span>
                                </h5>
                                <small class="text-muted">Temps restant</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Formulaire du quiz -->
            <form action="{{ route('quiz.submit', [$quiz->id, $attempt->id]) }}" method="POST" id="quiz-form">
                @csrf

                @foreach($questions as $index => $question)
                    <div class="card shadow-sm question-card mb-4">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="badge bg-primary me-2">Question {{ $index + 1 }}</span>
                                <span class="badge bg-success">{{ $question->points }} point(s)</span>
                                @if($question->type === 'choix_multiple')
                                    <span class="badge bg-info">Plusieurs réponses possibles</span>
                                @endif
                            </div>

                            <h5 class="mb-4">{{ $question->question }}</h5>

                            <div class="options-container">
                                @foreach($question->options as $optIndex => $option)
                                    <div class="mb-2">
                                        @if($question->type === 'choix_multiple')
                                            <input type="checkbox"
                                                   class="option-input"
                                                   name="reponses[{{ $question->id }}][]"
                                                   value="{{ $option->id }}"
                                                   id="option_{{ $question->id }}_{{ $option->id }}">
                                        @else
                                            <input type="radio"
                                                   class="option-input"
                                                   name="reponses[{{ $question->id }}]"
                                                   value="{{ $option->id }}"
                                                   id="option_{{ $question->id }}_{{ $option->id }}">
                                        @endif
                                        <label class="option-label d-block"
                                               for="option_{{ $question->id }}_{{ $option->id }}">
                                            <span class="me-2 fw-bold">{{ chr(65 + $optIndex) }}.</span>
                                            {{ $option->option_text }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Bouton de soumission sticky -->
                <div class="sticky-footer p-3 mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#abandonModal">
                            <i class="fas fa-times me-2"></i>Abandonner
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg" id="submit-btn">
                            <i class="fas fa-check me-2"></i>Soumettre mes réponses
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal d'abandon -->
<div class="modal fade" id="abandonModal" tabindex="-1" aria-labelledby="abandonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title" id="abandonModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmer l'abandon
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Êtes-vous sûr de vouloir abandonner ce quiz ?</p>
                <p class="text-muted mb-0"><small>Vos réponses ne seront pas enregistrées.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-arrow-left me-2"></i>Continuer le quiz
                </button>
                <a href="{{ route('quiz.show', $quiz->id) }}" class="btn btn-danger" id="confirmAbandon">
                    <i class="fas fa-times me-2"></i>Abandonner
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation avant de quitter la page -->
<div class="modal fade" id="confirmLeaveModal" tabindex="-1" aria-labelledby="confirmLeaveModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="confirmLeaveModalLabel">
                    <i class="fas fa-exclamation-circle me-2"></i>Attention !
                </h5>
            </div>
            <div class="modal-body">
                <p class="mb-2">Vous êtes sur le point de quitter cette page.</p>
                <p class="text-muted mb-0"><small>Les modifications que vous avez apportées ne seront peut-être pas enregistrées.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelLeave">
                    <i class="fas fa-arrow-left me-2"></i>Rester sur la page
                </button>
                <button type="button" class="btn btn-danger" id="confirmLeave">
                    <i class="fas fa-sign-out-alt me-2"></i>Quitter
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Timer si durée définie
    @if($quiz->duree_minutes)
        let timeLeft = {{ $quiz->duree_minutes * 60 }}; // en secondes
        const timerDisplay = document.getElementById('timer-display');
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;

            timerDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

            // Avertissement si moins de 2 minutes
            if (timeLeft <= 120 && timeLeft > 0) {
                timerElement.classList.add('text-danger', 'timer-warning');
            }

            // Temps écoulé
            if (timeLeft <= 0) {
                timerDisplay.textContent = '0:00';
                alert('Le temps est écoulé ! Votre quiz sera soumis automatiquement.');
                document.getElementById('quiz-form').submit();
                return;
            }

            timeLeft--;
        }

        // Démarrer le timer
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
    @endif

    // Gestion du modal de confirmation avant de quitter la page
    let allowNavigation = false;
    let pendingNavigationUrl = null;

    // Intercepter les clics sur les liens
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && !allowNavigation && link.id !== 'confirmAbandon') {
            // Ignorer les liens qui ouvrent des modals ou qui sont des ancres
            if (link.getAttribute('data-bs-toggle') || link.getAttribute('href').startsWith('#')) {
                return;
            }

            e.preventDefault();
            pendingNavigationUrl = link.href;
            const modal = new bootstrap.Modal(document.getElementById('confirmLeaveModal'));
            modal.show();
        }
    });

    // Bouton pour rester sur la page
    document.getElementById('cancelLeave').addEventListener('click', function() {
        const modal = bootstrap.Modal.getInstance(document.getElementById('confirmLeaveModal'));
        modal.hide();
        pendingNavigationUrl = null;
    });

    // Bouton pour confirmer le départ
    document.getElementById('confirmLeave').addEventListener('click', function() {
        allowNavigation = true;
        if (pendingNavigationUrl) {
            window.location.href = pendingNavigationUrl;
        }
    });

    // Permettre la navigation après soumission du formulaire
    document.getElementById('quiz-form').addEventListener('submit', function() {
        allowNavigation = true;
    });

    // Permettre la navigation après abandon confirmé
    document.getElementById('confirmAbandon').addEventListener('click', function() {
        allowNavigation = true;
    });

    // Scroll smooth vers les questions
    document.querySelectorAll('.option-label').forEach(label => {
        label.addEventListener('click', function() {
            // Animation visuelle lors de la sélection
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 100);
        });
    });

    // Sauvegarde automatique en localStorage (optionnel)
    const form = document.getElementById('quiz-form');
    const attemptId = {{ $attempt->id }};

    // Charger les réponses sauvegardées
    const savedAnswers = localStorage.getItem(`quiz_attempt_${attemptId}`);
    if (savedAnswers) {
        const answers = JSON.parse(savedAnswers);
        Object.keys(answers).forEach(questionId => {
            const answer = answers[questionId];
            if (Array.isArray(answer)) {
                // Choix multiple
                answer.forEach(optionId => {
                    const checkbox = document.querySelector(`input[name="reponses[${questionId}][]"][value="${optionId}"]`);
                    if (checkbox) checkbox.checked = true;
                });
            } else {
                // QCM ou Vrai/Faux
                const radio = document.querySelector(`input[name="reponses[${questionId}]"][value="${answer}"]`);
                if (radio) radio.checked = true;
            }
        });
    }

    // Sauvegarder les réponses à chaque changement
    form.addEventListener('change', function() {
        const formData = new FormData(form);
        const answers = {};

        for (let [key, value] of formData.entries()) {
            if (key.startsWith('reponses[')) {
                const questionId = key.match(/reponses\[(\d+)\]/)[1];
                if (key.includes('[]')) {
                    // Choix multiple
                    if (!answers[questionId]) answers[questionId] = [];
                    answers[questionId].push(value);
                } else {
                    // QCM ou Vrai/Faux
                    answers[questionId] = value;
                }
            }
        }

        localStorage.setItem(`quiz_attempt_${attemptId}`, JSON.stringify(answers));
    });

    // Nettoyer le localStorage après soumission
    form.addEventListener('submit', function() {
        localStorage.removeItem(`quiz_attempt_${attemptId}`);
    });
</script>
@endpush

@endsection
