@extends('admin.layout')

@section('title', 'Détails du Quiz')

@push('styles')
<style>
    .question-card {
        transition: all 0.3s ease;
        cursor: move;
    }
    .question-card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .correct-option {
        background-color: #d4edda !important;
        border-left: 4px solid #28a745;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1><i class="fas fa-question-circle me-2"></i>{{ $quiz->titre }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.quizzes.index') }}">Quiz</a></li>
                        <li class="breadcrumb-item active">{{ $quiz->titre }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.quizzes.edit', $quiz->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i>Modifier
                </a>
                <a href="{{ route('admin.quizzes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Retour
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informations</h5>
                </div>
                <div class="card-body">
                    @if($quiz->description)
                        <p>{{ $quiz->description }}</p>
                    @endif

                    <dl class="row">
                        <dt class="col-sm-6">Lié à:</dt>
                        <dd class="col-sm-6">
                            @if($quiz->formation)
                                <span class="badge bg-info">{{ $quiz->formation->titre }}</span>
                            @endif
                            @if($quiz->module)
                                <span class="badge bg-secondary">{{ $quiz->module->titre }}</span>
                            @endif
                        </dd>

                        <dt class="col-sm-6">Questions:</dt>
                        <dd class="col-sm-6">{{ $quiz->questions->count() }}</dd>

                        <dt class="col-sm-6">Points total:</dt>
                        <dd class="col-sm-6">{{ $quiz->total_points }}</dd>

                        <dt class="col-sm-6">Durée:</dt>
                        <dd class="col-sm-6">{{ $quiz->duree_minutes ? $quiz->duree_minutes . ' min' : 'Illimitée' }}</dd>

                        <dt class="col-sm-6">Note passage:</dt>
                        <dd class="col-sm-6">{{ $quiz->note_passage }}%</dd>

                        <dt class="col-sm-6">Tentatives:</dt>
                        <dd class="col-sm-6">{{ $quiz->nombre_tentatives }}</dd>

                        <dt class="col-sm-6">Statut:</dt>
                        <dd class="col-sm-6">
                            @if($quiz->active)
                                <span class="badge bg-success">Actif</span>
                            @else
                                <span class="badge bg-secondary">Inactif</span>
                            @endif
                        </dd>
                    </dl>

                    <hr>

                    <h6>Options:</h6>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fas {{ $quiz->afficher_reponses ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                            Afficher les réponses
                        </li>
                        <li>
                            <i class="fas {{ $quiz->melanger_questions ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                            Mélanger les questions
                        </li>
                        <li>
                            <i class="fas {{ $quiz->melanger_options ? 'fa-check text-success' : 'fa-times text-danger' }} me-2"></i>
                            Mélanger les options
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Questions ({{ $quiz->questions->count() }})</h5>
                    <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#questionModal" onclick="resetQuestionForm()">
                        <i class="fas fa-plus me-2"></i>Ajouter une question
                    </button>
                </div>
                <div class="card-body" id="questions-container">
                    @if($quiz->questions->count() > 0)
                        @foreach($quiz->questions as $index => $question)
                            <div class="card question-card mb-3" data-question-id="{{ $question->id }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-2">
                                            <span class="badge bg-primary me-2">Q{{ $index + 1 }}</span>
                                            {{ $question->question }}
                                        </h6>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-warning" onclick="editQuestion({{ $question->id }})" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-danger" onclick="deleteQuestion({{ $question->id }})" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="mb-2">
                                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $question->type)) }}</span>
                                        <span class="badge bg-success">{{ $question->points }} points</span>
                                    </div>

                                    <div class="options-list">
                                        @foreach($question->options as $option)
                                            <div class="p-2 mb-1 rounded {{ $option->is_correct ? 'correct-option' : 'bg-light' }}">
                                                @if($option->is_correct)
                                                    <i class="fas fa-check-circle text-success me-2"></i>
                                                @else
                                                    <i class="far fa-circle text-muted me-2"></i>
                                                @endif
                                                {{ $option->option_text }}
                                            </div>
                                        @endforeach
                                    </div>

                                    @if($question->explication)
                                        <div class="alert alert-info mt-2 mb-0">
                                            <small><strong>Explication:</strong> {{ $question->explication }}</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-5" id="no-questions-message">
                            <i class="fas fa-question-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune question pour ce quiz</h5>
                            <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#questionModal" onclick="resetQuestionForm()">
                                <i class="fas fa-plus me-2"></i>Ajouter la première question
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour ajouter/modifier une question -->
<div class="modal fade" id="questionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="questionModalLabel">Ajouter une question</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="questionForm">
                <div class="modal-body">
                    <input type="hidden" id="question_id" value="">

                    <div class="mb-3">
                        <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="question" name="question" rows="2" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="type" class="form-label">Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="type" name="type" required onchange="updateOptionsCount()">
                                    <option value="qcm">QCM (une seule réponse)</option>
                                    <option value="vrai_faux">Vrai/Faux</option>
                                    <option value="choix_multiple">Choix multiple</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="points" class="form-label">Points <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="points" name="points" min="1" value="1" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Options de réponse <span class="text-danger">*</span></label>
                        <div id="options-container">
                            <!-- Les options seront ajoutées ici dynamiquement -->
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addOption()">
                            <i class="fas fa-plus me-1"></i>Ajouter une option
                        </button>
                    </div>

                    <div class="mb-3">
                        <label for="explication" class="form-label">Explication (optionnel)</label>
                        <textarea class="form-control" id="explication" name="explication" rows="2"></textarea>
                        <small class="text-muted">Explication affichée après la réponse</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
let optionCount = 0;
const quizId = {{ $quiz->id }};
const questionsData = @json($quiz->questions);

// Initialiser avec 2 options par défaut
document.addEventListener('DOMContentLoaded', function() {
    resetQuestionForm();
});

function resetQuestionForm() {
    document.getElementById('questionForm').reset();
    document.getElementById('question_id').value = '';
    document.getElementById('questionModalLabel').textContent = 'Ajouter une question';
    optionCount = 0;
    document.getElementById('options-container').innerHTML = '';

    // Ajouter 2 options par défaut
    addOption();
    addOption();
}

function addOption() {
    optionCount++;
    const container = document.getElementById('options-container');
    const optionDiv = document.createElement('div');
    optionDiv.className = 'input-group mb-2';
    optionDiv.id = `option-${optionCount}`;

    optionDiv.innerHTML = `
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" name="options[${optionCount}][is_correct]" value="1">
        </div>
        <input type="text" class="form-control" name="options[${optionCount}][option_text]" placeholder="Texte de l'option" required>
        <button class="btn btn-outline-danger" type="button" onclick="removeOption(${optionCount})">
            <i class="fas fa-trash"></i>
        </button>
    `;

    container.appendChild(optionDiv);
}

function removeOption(id) {
    const element = document.getElementById(`option-${id}`);
    if (element) {
        element.remove();
    }
}

function updateOptionsCount() {
    const type = document.getElementById('type').value;
    const container = document.getElementById('options-container');

    if (type === 'vrai_faux') {
        // Réinitialiser avec Vrai/Faux
        container.innerHTML = '';
        optionCount = 0;

        optionCount++;
        container.innerHTML += `
            <div class="input-group mb-2" id="option-${optionCount}">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" name="options[${optionCount}][is_correct]" value="1">
                </div>
                <input type="text" class="form-control" name="options[${optionCount}][option_text]" value="Vrai" readonly>
            </div>
        `;

        optionCount++;
        container.innerHTML += `
            <div class="input-group mb-2" id="option-${optionCount}">
                <div class="input-group-text">
                    <input class="form-check-input mt-0" type="checkbox" name="options[${optionCount}][is_correct]" value="1">
                </div>
                <input type="text" class="form-control" name="options[${optionCount}][option_text]" value="Faux" readonly>
            </div>
        `;
    }
}

// Soumettre le formulaire (créer ou modifier)
document.getElementById('questionForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const questionId = document.getElementById('question_id').value;
    const formData = new FormData(this);

    // Construire l'objet de données
    const data = {
        question: formData.get('question'),
        type: formData.get('type'),
        points: formData.get('points'),
        explication: formData.get('explication') || null,
        options: []
    };

    // Récupérer toutes les options
    const optionsContainer = document.getElementById('options-container');
    const optionDivs = optionsContainer.querySelectorAll('.input-group');

    optionDivs.forEach((div, index) => {
        const text = div.querySelector('input[type="text"]').value;
        const isCorrect = div.querySelector('input[type="checkbox"]').checked;

        if (text.trim()) {
            data.options.push({
                option_text: text,
                is_correct: isCorrect
            });
        }
    });

    // Validation
    if (data.options.length < 2) {
        alert('Vous devez ajouter au moins 2 options de réponse.');
        return;
    }

    const correctCount = data.options.filter(opt => opt.is_correct).length;
    if (correctCount === 0) {
        alert('Vous devez marquer au moins une réponse comme correcte.');
        return;
    }

    // Envoyer la requête
    const url = questionId
        ? `/admin/quiz-questions/${questionId}`
        : `/admin/quizzes/${quizId}/questions`;

    const method = questionId ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            // Fermer le modal
            bootstrap.Modal.getInstance(document.getElementById('questionModal')).hide();

            // Recharger la page pour afficher les changements
            location.reload();
        } else {
            alert(result.error || 'Une erreur est survenue.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de l\'enregistrement de la question.');
    });
});

function editQuestion(questionId) {
    const question = questionsData.find(q => q.id === questionId);
    if (!question) return;

    // Remplir le formulaire
    document.getElementById('question_id').value = question.id;
    document.getElementById('question').value = question.question;
    document.getElementById('type').value = question.type;
    document.getElementById('points').value = question.points;
    document.getElementById('explication').value = question.explication || '';
    document.getElementById('questionModalLabel').textContent = 'Modifier la question';

    // Réinitialiser les options
    optionCount = 0;
    const container = document.getElementById('options-container');
    container.innerHTML = '';

    // Ajouter les options existantes
    question.options.forEach((option, index) => {
        optionCount++;
        const optionDiv = document.createElement('div');
        optionDiv.className = 'input-group mb-2';
        optionDiv.id = `option-${optionCount}`;

        optionDiv.innerHTML = `
            <div class="input-group-text">
                <input class="form-check-input mt-0" type="checkbox" name="options[${optionCount}][is_correct]" value="1" ${option.is_correct ? 'checked' : ''}>
            </div>
            <input type="text" class="form-control" name="options[${optionCount}][option_text]" value="${option.option_text}" required ${question.type === 'vrai_faux' ? 'readonly' : ''}>
            ${question.type !== 'vrai_faux' ? `
                <button class="btn btn-outline-danger" type="button" onclick="removeOption(${optionCount})">
                    <i class="fas fa-trash"></i>
                </button>
            ` : ''}
        `;

        container.appendChild(optionDiv);
    });

    // Ouvrir le modal
    new bootstrap.Modal(document.getElementById('questionModal')).show();
}

function deleteQuestion(questionId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette question ?')) {
        return;
    }

    fetch(`/admin/quiz-questions/${questionId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            location.reload();
        } else {
            alert('Erreur lors de la suppression.');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert('Erreur lors de la suppression de la question.');
    });
}
</script>
@endpush

@endsection
