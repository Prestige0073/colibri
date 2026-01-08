@extends('layouts.app')

@section('title', $module->titre . ' - ' . $formation->titre)

@push('styles')
<style>
    .module-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
    }
    .contenu-card {
        border-left: 4px solid #667eea;
        transition: all 0.3s;
    }
    .contenu-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transform: translateY(-2px);
    }
    .contenu-type-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
    }
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        overflow: hidden;
        border-radius: 8px;
    }
    .video-container iframe,
    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 0;
    }
</style>
@endpush

@section('content')
<!-- En-tête du module -->
<div class="module-header">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white-50 mb-3">
                <li class="breadcrumb-item"><a href="{{ route('index') }}" class="text-white">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ route('formation.show', $formation) }}" class="text-white">{{ $formation->titre }}</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ $module->titre }}</li>
            </ol>
        </nav>
        <h1 class="mb-2">{{ $module->titre }}</h1>
        @if($module->description)
            <p class="lead mb-0">{{ $module->description }}</p>
        @endif
        <div class="mt-3">
            <span class="badge bg-light text-dark me-2">
                <i class="fas fa-clock me-1"></i>{{ $module->duree ?? 'Durée non définie' }}
            </span>
            <span class="badge bg-light text-dark">
                <i class="fas fa-list me-1"></i>{{ $module->contenus->count() }} contenu(s)
            </span>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <!-- Contenus du module -->
        <div class="col-lg-8">
            @if($module->contenus->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Aucun contenu n'a encore été ajouté à ce module.
                </div>
            @else
                @foreach($module->contenus as $index => $contenu)
                    @php
                        // Vérifier si le contenu est complété
                        $isCompleted = $userProgressions->has($contenu->id) && $userProgressions[$contenu->id]->completed;

                        // Vérifier si le contenu est déverrouillé
                        $isUnlocked = false;
                        if ($index === 0) {
                            // Le premier contenu est toujours déverrouillé
                            $isUnlocked = true;
                        } else {
                            // Vérifier si le contenu précédent est complété
                            $previousContenu = $module->contenus[$index - 1];
                            $isUnlocked = $userProgressions->has($previousContenu->id) && $userProgressions[$previousContenu->id]->completed;
                        }
                    @endphp

                    <div class="card contenu-card shadow-sm mb-4 @if(!$isUnlocked) locked-content @endif" id="contenu-{{ $contenu->id }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge contenu-type-badge
                                        @if($contenu->type === 'video') bg-danger
                                        @elseif($contenu->type === 'texte') bg-primary
                                        @elseif($contenu->type === 'pdf') bg-success
                                        @elseif($contenu->type === 'quiz') bg-warning text-dark
                                        @else bg-secondary
                                        @endif me-2">
                                        <i class="fas
                                            @if($contenu->type === 'video') fa-video
                                            @elseif($contenu->type === 'texte') fa-file-alt
                                            @elseif($contenu->type === 'pdf') fa-file-pdf
                                            @elseif($contenu->type === 'quiz') fa-question-circle
                                            @else fa-file
                                            @endif me-1"></i>
                                        {{ ucfirst($contenu->type) }}
                                    </span>
                                    @if($contenu->duree)
                                        <span class="badge bg-light text-dark">{{ $contenu->duree }}</span>
                                    @endif
                                    @if($isCompleted)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Complété
                                        </span>
                                    @endif
                                    @if(!$isUnlocked)
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-lock me-1"></i>Verrouillé
                                        </span>
                                    @endif
                                </div>
                                <span class="text-muted">#{{ $index + 1 }}</span>
                            </div>

                            <h4 class="mb-3">{{ $contenu->titre }}</h4>

                            @if($contenu->description)
                                <p class="text-muted mb-3">{{ $contenu->description }}</p>
                            @endif

                            @if(!$isUnlocked)
                                <div class="alert alert-warning">
                                    <i class="fas fa-lock me-2"></i>
                                    Ce contenu sera déverrouillé après avoir complété le contenu précédent.
                                </div>
                            @else

                            <!-- Affichage selon le type de contenu -->
                            @if($contenu->type === 'video')
                                @if($contenu->fichier)
                                    <div class="video-section mb-4">
                                        <!-- Lecteur vidéo intégré -->
                                        <div class="video-player-wrapper" style="background: #000; border-radius: 8px; overflow: hidden;">
                                            @if(str_contains($contenu->fichier, 'youtube.com') || str_contains($contenu->fichier, 'youtu.be'))
                                                <iframe id="videoPlayer{{ $contenu->id }}"
                                                        src="{{ $contenu->fichier }}?enablejsapi=1"
                                                        allowfullscreen
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        style="width: 100%; height: 500px; border: 0;">
                                                </iframe>
                                            @else
                                                <video id="videoPlayer{{ $contenu->id }}"
                                                       controls
                                                       controlsList="nodownload"
                                                       style="width: 100%; height: auto; background: #000;"
                                                       oncontextmenu="return false;">
                                                    <source src="{{ asset($contenu->fichier) }}" type="video/mp4">
                                                    Votre navigateur ne supporte pas la lecture de vidéos.
                                                </video>
                                            @endif
                                        </div>

                                        <!-- Barre de progression personnalisée -->
                                        <div class="mt-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted">Progression de visionnage</span>
                                                <span class="badge bg-primary" id="watchProgress{{ $contenu->id }}">
                                                    {{ $userProgressions->has($contenu->id) ? number_format($userProgressions[$contenu->id]->video_watch_percentage, 1) : '0.0' }}%
                                                </span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar" role="progressbar"
                                                     id="watchProgressBar{{ $contenu->id }}"
                                                     style="width: {{ $userProgressions->has($contenu->id) ? $userProgressions[$contenu->id]->video_watch_percentage : 0 }}%"
                                                     aria-valuenow="{{ $userProgressions->has($contenu->id) ? $userProgressions[$contenu->id]->video_watch_percentage : 0 }}"
                                                     aria-valuemin="0"
                                                     aria-valuemax="100">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Système de transcription -->
                                        @if($contenu->transcription)
                                            <div class="transcription-section mt-4">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h6 class="mb-0">
                                                            <i class="fas fa-closed-captioning me-2"></i>Transcription de la vidéo
                                                        </h6>
                                                    </div>
                                                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                                                        <div class="transcription-content">
                                                            {!! nl2br(e($contenu->transcription)) !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    <script>
                                        (function() {
                                            const video = document.getElementById('videoPlayer{{ $contenu->id }}');
                                            const contenuId = {{ $contenu->id }};
                                            let updateInterval;

                                            if (video && video.tagName === 'VIDEO') {
                                                // Pour les vidéos locales
                                                video.addEventListener('timeupdate', function() {
                                                    const percentage = (video.currentTime / video.duration) * 100;
                                                    updateVideoProgress{{ $contenu->id }}(percentage);
                                                });

                                                // Protection contre le téléchargement
                                                video.addEventListener('contextmenu', function(e) {
                                                    e.preventDefault();
                                                    alert('⛔ Le téléchargement de cette vidéo est désactivé.');
                                                    return false;
                                                });

                                                video.style.userSelect = 'none';
                                                video.style.webkitUserSelect = 'none';

                                                video.addEventListener('dragstart', function(e) {
                                                    e.preventDefault();
                                                    return false;
                                                });
                                            }

                                            function updateVideoProgress{{ $contenu->id }}(percentage) {
                                                // Mettre à jour l'affichage
                                                const progressBar = document.getElementById('watchProgressBar{{ $contenu->id }}');
                                                const progressBadge = document.getElementById('watchProgress{{ $contenu->id }}');

                                                if (progressBar && progressBadge) {
                                                    progressBar.style.width = percentage + '%';
                                                    progressBar.setAttribute('aria-valuenow', percentage);
                                                    progressBadge.textContent = percentage.toFixed(1) + '%';
                                                }

                                                // Envoyer au serveur toutes les 5 secondes
                                                clearTimeout(updateInterval);
                                                updateInterval = setTimeout(() => {
                                                    fetch(`/formation/{{ $formation->id }}/module/{{ $module->id }}/contenu/${contenuId}/update-video-progress`, {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                            'Accept': 'application/json'
                                                        },
                                                        body: JSON.stringify({ percentage: percentage })
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.can_complete && percentage >= 95) {
                                                            // Activer le bouton "Marquer comme complété"
                                                            const completeBtn = document.querySelector(`.mark-completed-btn[data-contenu-id="${contenuId}"]`);
                                                            if (completeBtn) {
                                                                completeBtn.disabled = false;
                                                                completeBtn.classList.remove('btn-secondary');
                                                                completeBtn.classList.add('btn-success');
                                                                completeBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Marquer comme complété';
                                                            }
                                                        }
                                                    });
                                                }, 5000);
                                            }
                                        })();
                                    </script>
                                @endif

                            @elseif($contenu->type === 'texte')
                                @if($contenu->contenu)
                                    <div class="content-text border-start border-4 border-primary ps-3 py-2">
                                        {!! nl2br(e($contenu->contenu)) !!}
                                    </div>
                                @endif

                            @elseif($contenu->type === 'pdf')
                                @if($contenu->fichier)
                                    <!-- Aperçu PDF avec bouton View -->
                                    <div class="d-flex align-items-center justify-content-between bg-light p-3 rounded mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-file-pdf fa-3x text-danger me-3"></i>
                                            <div>
                                                <h6 class="mb-0">Document PDF Protégé</h6>
                                                <small class="text-muted">Ouvre dans un visualiseur sécurisé en plein écran</small>
                                            </div>
                                        </div>
                                        <a href="{{ route('pdf.viewer.show', [$formation, $module, $contenu]) }}"
                                           class="btn btn-danger">
                                            <i class="fas fa-eye me-2"></i>Voir le PDF
                                        </a>
                                    </div>
                                @endif

                            @elseif($contenu->type === 'quiz')
                                <div class="alert alert-warning">
                                    <i class="fas fa-question-circle me-2"></i>
                                    Un quiz est disponible pour ce contenu.
                                </div>

                            @else
                                @if($contenu->fichier)
                                    <a href="{{ asset($contenu->fichier) }}" target="_blank" class="btn btn-primary">
                                        <i class="fas fa-download me-2"></i>Télécharger la ressource
                                    </a>
                                @endif
                                @if($contenu->contenu)
                                    <div class="mt-3">
                                        {!! nl2br(e($contenu->contenu)) !!}
                                    </div>
                                @endif
                            @endif

                            @if(!$isCompleted && $inscription)
                                @php
                                    $canComplete = true;
                                    $buttonClass = 'btn-success';
                                    $buttonText = 'Marquer comme complété';

                                    if ($contenu->type === 'video') {
                                        $watchPercentage = $userProgressions->has($contenu->id) ? $userProgressions[$contenu->id]->video_watch_percentage : 0;
                                        $canComplete = $watchPercentage >= 95;

                                        if (!$canComplete) {
                                            $buttonClass = 'btn-secondary';
                                            $buttonText = 'Regardez au moins 95% de la vidéo';
                                        }
                                    }
                                @endphp
                                <div class="mt-3">
                                    <button class="btn {{ $buttonClass }} mark-completed-btn"
                                            data-contenu-id="{{ $contenu->id }}"
                                            data-contenu-titre="{{ $contenu->titre }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmCompleteModal"
                                            {{ !$canComplete ? 'disabled' : '' }}>
                                        <i class="fas fa-check-circle me-2"></i>{{ $buttonText }}
                                    </button>
                                    @if($contenu->type === 'video' && !$canComplete)
                                        <small class="d-block text-muted mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Vous devez regarder au moins 95% de la vidéo pour continuer
                                        </small>
                                    @endif
                                </div>
                            @endif
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Quizzes du module -->
            @if($module->quizzes->isNotEmpty())
                @php
                    // Vérifier si tous les contenus du module sont complétés
                    $allContenusCompleted = true;
                    foreach($module->contenus as $contenu) {
                        if (!$userProgressions->has($contenu->id) || !$userProgressions[$contenu->id]->completed) {
                            $allContenusCompleted = false;
                            break;
                        }
                    }
                @endphp

                <div class="card shadow-sm mb-4 @if(!$allContenusCompleted) locked-content @endif" style="border-left: 4px solid #ffc107;">
                    <div class="card-header bg-warning bg-opacity-10">
                        <h5 class="mb-0">
                            <i class="fas fa-clipboard-check me-2"></i>Quiz du module
                            @if(!$allContenusCompleted)
                                <span class="badge bg-secondary float-end">
                                    <i class="fas fa-lock me-1"></i>Verrouillé
                                </span>
                            @endif
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(!$allContenusCompleted)
                            <div class="alert alert-warning">
                                <i class="fas fa-lock me-2"></i>
                                Vous devez compléter tous les contenus de ce module avant d'accéder aux quiz.
                            </div>
                        @endif

                        @foreach($module->quizzes as $quiz)
                            <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $quiz->titre }}</h6>
                                    @if($quiz->description)
                                        <p class="text-muted mb-1 small">{{ $quiz->description }}</p>
                                    @endif
                                    <div>
                                        <span class="badge bg-info text-dark me-1">{{ $quiz->questions()->count() }} questions</span>
                                        <span class="badge bg-success me-1">{{ $quiz->total_points }} points</span>
                                        @if($quiz->duree_minutes)
                                            <span class="badge bg-secondary">{{ $quiz->duree_minutes }} min</span>
                                        @endif
                                    </div>
                                </div>
                                @if($allContenusCompleted)
                                    @if($inscription && $inscription->paiement_valide)
                                        <a href="{{ route('quiz.show', $quiz) }}" class="btn btn-warning">
                                            <i class="fas fa-play me-2"></i>Commencer
                                        </a>
                                    @else
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#paiementRequiredModal">
                                            <i class="fas fa-play me-2"></i>Commencer
                                        </button>
                                    @endif
                                @else
                                    <button class="btn btn-secondary" disabled>
                                        <i class="fas fa-lock me-2"></i>Verrouillé
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Informations de la formation -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-graduation-cap me-2"></i>Formation
                    </h6>
                </div>
                <div class="card-body">
                    <h6>{{ $formation->titre }}</h6>
                    @if($inscription)
                        <div class="alert alert-success alert-sm mt-3 mb-0">
                            <i class="fas fa-check-circle me-2"></i>
                            <small>Vous êtes inscrit à cette formation</small>
                        </div>
                        @if($inscription->progression !== null)
                            <div class="mt-3">
                                <small class="text-muted d-block mb-1">Progression</small>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                         style="width: {{ $inscription->progression }}%;"
                                         aria-valuenow="{{ $inscription->progression }}"
                                         aria-valuemin="0"
                                         aria-valuemax="100">
                                        {{ $inscription->progression }}%
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="alert alert-warning alert-sm mt-3 mb-0">
                            <small><i class="fas fa-exclamation-triangle me-2"></i>Inscrivez-vous pour accéder à tous les contenus</small>
                        </div>
                        <a href="{{ route('formation.show', $formation) }}" class="btn btn-primary btn-sm w-100 mt-2">
                            S'inscrire maintenant
                        </a>
                    @endif
                </div>
            </div>

            <!-- Navigation entre modules -->
            @if($formation->modules->count() > 1)
                <div class="card shadow-sm">
                    <div class="card-header bg-secondary text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-list me-2"></i>Autres modules
                        </h6>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($formation->modules as $otherModule)
                            <a href="{{ route('formation.module.show', [$formation, $otherModule]) }}"
                               class="list-group-item list-group-item-action {{ $otherModule->id === $module->id ? 'active' : '' }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-0">{{ $otherModule->titre }}</h6>
                                        <small class="text-muted">{{ $otherModule->duree }}</small>
                                    </div>
                                    @if($otherModule->id === $module->id)
                                        <i class="fas fa-play-circle"></i>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal de confirmation pour marquer comme complété -->
<div class="modal fade" id="confirmCompleteModal" tabindex="-1" aria-labelledby="confirmCompleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="confirmCompleteModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Confirmer la complétion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-3">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <h5 class="mb-3">Marquer comme complété</h5>
                    <p class="text-muted mb-2">
                        Êtes-vous sûr d'avoir terminé ce contenu ?
                    </p>
                    <p class="mb-0">
                        <strong id="modal-contenu-titre"></strong>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Annuler
                </button>
                <button type="button" class="btn btn-success rounded-pill" id="confirmCompleteBtn">
                    <i class="fas fa-check-circle me-2"></i>Oui, j'ai terminé
                </button>
            </div>
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
                        Pour accéder aux quiz et à l'ensemble du contenu de cette formation, vous devez d'abord finaliser votre inscription et effectuer le paiement.
                    </p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <small><strong>Formation:</strong> {{ $formation->titre }}</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Fermer
                </button>
                <a href="{{ route('formation.show', $formation) }}" class="btn btn-warning">
                    <i class="fas fa-shopping-cart me-2"></i>Procéder au paiement
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .locked-content {
        opacity: 0.6;
        position: relative;
    }

    .locked-content::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(128, 128, 128, 0.1);
        z-index: 1;
        pointer-events: none;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du modal de confirmation "Marquer comme complété"
        const confirmCompleteModal = document.getElementById('confirmCompleteModal');
        const confirmCompleteBtn = document.getElementById('confirmCompleteBtn');
        const modalTitre = document.getElementById('modal-contenu-titre');
        let currentContenuId = null;
        let currentButton = null;

        // Quand le modal s'ouvre, récupérer l'ID du contenu et le titre
        if (confirmCompleteModal) {
            confirmCompleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                currentButton = button;
                currentContenuId = button.getAttribute('data-contenu-id');
                const contenuTitre = button.getAttribute('data-contenu-titre');

                modalTitre.textContent = contenuTitre;
            });
        }

        // Quand l'utilisateur confirme
        if (confirmCompleteBtn) {
            confirmCompleteBtn.addEventListener('click', function() {
                if (!currentContenuId || !currentButton) return;

                // Désactiver le bouton de confirmation
                confirmCompleteBtn.disabled = true;
                confirmCompleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>En cours...';

                // Envoyer la requête AJAX
                fetch(`/formation/{{ $formation->id }}/module/{{ $module->id }}/contenu/${currentContenuId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Fermer le modal
                        const modal = bootstrap.Modal.getInstance(confirmCompleteModal);
                        modal.hide();

                        // Recharger la page pour afficher les changements
                        location.reload();
                    } else {
                        // Réactiver le bouton et afficher l'erreur
                        confirmCompleteBtn.disabled = false;
                        confirmCompleteBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Oui, j\'ai terminé';
                        alert(data.error || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    confirmCompleteBtn.disabled = false;
                    confirmCompleteBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Oui, j\'ai terminé';
                    alert('Une erreur est survenue lors de la sauvegarde');
                });
            });
        }

        // Réinitialiser le bouton quand le modal se ferme
        if (confirmCompleteModal) {
            confirmCompleteModal.addEventListener('hidden.bs.modal', function() {
                confirmCompleteBtn.disabled = false;
                confirmCompleteBtn.innerHTML = '<i class="fas fa-check-circle me-2"></i>Oui, j\'ai terminé';
                currentContenuId = null;
                currentButton = null;
            });
        }
    });
</script>
@endpush

@endsection
