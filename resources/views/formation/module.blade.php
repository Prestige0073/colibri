@extends('layouts.app')

@section('title', $module->titre . ' - ' . $formation->titre)

@push('styles')
<style>
    /* Layout principal */
    .learning-container {
        display: flex;
        min-height: calc(100vh - 80px);
    }

    /* Sidebar de navigation */
    .learning-sidebar {
        width: 280px;
        background: #fff;
        border-right: 1px solid #e9ecef;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        flex-shrink: 0;
        z-index: 100;
    }

    .learning-sidebar.collapsed {
        width: 0;
        overflow: hidden;
    }

    .sidebar-header {
        background: linear-gradient(135deg, #1e7a2f 0%, #0b5e34 100%);
        color: white;
        padding: 1rem;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .sidebar-progress {
        padding: 0.75rem 1rem;
        background: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
    }

    .progress-ring-container {
        width: 50px;
        height: 50px;
        position: relative;
    }

    .progress-ring {
        width: 100%;
        height: 100%;
    }

    .progress-ring-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 0.7rem;
        font-weight: 700;
    }

    .module-nav {
        padding: 0.5rem 0;
    }

    .module-nav-item {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
        font-size: 0.85rem;
    }

    .module-nav-item:hover {
        background: #f8f9fa;
    }

    .module-nav-item.active {
        background: linear-gradient(90deg, rgba(30, 122, 47, 0.1) 0%, transparent 100%);
        border-left-color: #1e7a2f;
    }

    .module-nav-item.completed {
        opacity: 0.8;
    }

    .module-nav-item.locked {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .nav-item-icon {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.5rem;
        flex-shrink: 0;
        font-size: 0.65rem;
    }

    .nav-item-icon.video { background: rgba(220, 53, 69, 0.1); color: #dc3545; }
    .nav-item-icon.pdf { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .nav-item-icon.texte { background: rgba(0, 123, 255, 0.1); color: #007bff; }
    .nav-item-icon.quiz { background: rgba(255, 193, 7, 0.1); color: #ffc107; }
    .nav-item-icon.completed { background: #28a745; color: white; }
    .nav-item-icon.locked { background: #e9ecef; color: #6c757d; }

    .nav-item-content {
        flex-grow: 1;
        min-width: 0;
    }

    .nav-item-title {
        font-size: 0.8rem;
        font-weight: 500;
        margin-bottom: 0.15rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .nav-item-meta {
        font-size: 0.65rem;
        color: #6c757d;
    }

    /* Contenu principal */
    .learning-content {
        flex-grow: 1;
        padding: 1.5rem;
        max-width: 100%;
        overflow-x: hidden;
    }

    .toggle-sidebar-btn {
        position: fixed;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        z-index: 1000;
        background: #1e7a2f;
        color: white;
        border: none;
        padding: 0.75rem 0.4rem;
        border-radius: 0 0.5rem 0.5rem 0;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .toggle-sidebar-btn:hover {
        background: #0b5e34;
    }

    /* Module header */
    .content-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }

    .content-header h1 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #333;
    }

    /* Contenu cards */
    .contenu-card {
        border-radius: 0.75rem;
        border: none;
        box-shadow: 0 2px 12px rgba(0,0,0,0.06);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .contenu-card:hover {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }

    .contenu-card.locked-content {
        opacity: 0.6;
        filter: grayscale(50%);
    }

    .contenu-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        padding: 1rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .contenu-type-icon {
        width: 35px;
        height: 35px;
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 0.85rem;
    }

    .contenu-type-icon.video { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; }
    .contenu-type-icon.pdf { background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); color: white; }
    .contenu-type-icon.texte { background: linear-gradient(135deg, #007bff 0%, #0056b3 100%); color: white; }
    .contenu-type-icon.quiz { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #333; }

    .contenu-card-body {
        padding: 1rem;
    }

    /* Video player */
    .video-player-container {
        background: #000;
        border-radius: 0.5rem;
        overflow: hidden;
        margin-bottom: 0.75rem;
    }

    .video-player-container video,
    .video-player-container iframe {
        width: 100%;
        aspect-ratio: 16/9;
        border: none;
    }

    .video-progress-bar {
        height: 5px;
        background: #e9ecef;
        border-radius: 3px;
        overflow: hidden;
        margin-top: 0.75rem;
    }

    .video-progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #1e7a2f 0%, #0b5e34 100%);
        transition: width 0.3s ease;
    }

    /* Completion button */
    .completion-section {
        background: linear-gradient(135deg, #f8f9fa 0%, #fff 100%);
        padding: 1rem;
        border-radius: 0.5rem;
        margin-top: 1rem;
        border: 2px dashed #e9ecef;
    }

    .completion-section.ready {
        border-color: #28a745;
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.05) 0%, #fff 100%);
    }

    .btn-complete {
        background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }

    .btn-complete:hover:not(:disabled) {
        background: #1e7a2f;
    }

    .btn-complete:disabled {
        background: #6c757d;
        cursor: not-allowed;
    }

    /* Quiz section */
    .quiz-section {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.1) 0%, #fff 100%);
        border-radius: 0.75rem;
        padding: 1rem;
        border: 2px solid #ffc107;
    }

    /* Modules navigation at bottom */
    .modules-nav-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 0.75rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .nav-module-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 0.375rem;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 0.85rem;
    }

    .nav-module-btn.prev {
        background: #e9ecef;
        color: #333;
    }

    .nav-module-btn.next {
        background: linear-gradient(135deg, #1e7a2f 0%, #0b5e34 100%);
        color: white;
    }

    .nav-module-btn:hover {
        opacity: 0.9;
    }

    /* Success animation */
    .success-checkmark {
        animation: checkmark-bounce 0.5s ease;
    }

    @keyframes checkmark-bounce {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }

    /* Mobile responsive */
    @media (max-width: 991px) {
        .learning-sidebar {
            position: fixed;
            left: -280px;
            transition: left 0.3s ease;
            box-shadow: 5px 0 20px rgba(0,0,0,0.15);
            width: 280px;
        }

        .learning-sidebar.show {
            left: 0;
        }

        .learning-content {
            padding: 0.75rem;
        }

        .toggle-sidebar-btn {
            display: block;
        }

        .content-header h1 {
            font-size: 1rem;
        }

        .contenu-card-header {
            padding: 0.75rem;
        }

        .contenu-card-header h5 {
            font-size: 0.9rem;
        }

        .contenu-card-body {
            padding: 0.75rem;
        }

        .completion-section {
            padding: 0.75rem;
        }

        .btn-complete {
            padding: 0.4rem 0.75rem;
            font-size: 0.8rem;
        }

        .modules-nav-footer {
            padding: 0.75rem;
        }

        .nav-module-btn {
            padding: 0.4rem 0.75rem;
            font-size: 0.75rem;
        }

        .quiz-section {
            padding: 0.75rem;
        }
    }

    @media (min-width: 992px) {
        .toggle-sidebar-btn {
            display: none;
        }
    }
</style>
@endpush

@section('content')
@php
    // Calculer la progression du module
    $totalContenus = $module->contenus->count();
    $completedContenus = $userProgressions->where('completed', true)->count();
    $moduleProgress = $totalContenus > 0 ? round(($completedContenus / $totalContenus) * 100) : 0;

    // Calculer la progression globale de la formation
    $totalFormationContenus = 0;
    $completedFormationContenus = 0;
    foreach ($formation->modules as $m) {
        $totalFormationContenus += $m->contenus->count();
        if ($m->id === $module->id) {
            $completedFormationContenus += $completedContenus;
        } else {
            $completedFormationContenus += \App\Models\UserModuleProgression::where('user_id', Auth::id())
                ->where('module_id', $m->id)
                ->where('completed', true)
                ->count();
        }
    }
    $formationProgress = $totalFormationContenus > 0 ? round(($completedFormationContenus / $totalFormationContenus) * 100) : 0;
@endphp

<div class="learning-container">
    <!-- Toggle sidebar button (mobile) -->
    <button class="toggle-sidebar-btn" id="toggleSidebar">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside class="learning-sidebar" id="learningSidebar">
        <!-- Header -->
        <div class="sidebar-header">
            <a href="{{ route('formation.show', $formation) }}" class="text-decoration-none d-flex align-items-center mb-2" style="color: #fff;">
                <i class="fas fa-arrow-left me-2"></i>
                <span class="small">Retour à la formation</span>
            </a>
            <h5 class="mb-0 fw-bold text-white">{{ Str::limit($formation->titre, 30) }}</h5>
        </div>

        <!-- Progression globale -->
        <div class="sidebar-progress">
            <div class="d-flex align-items-center gap-3">
                <div class="progress-ring-container">
                    <svg class="progress-ring" viewBox="0 0 36 36">
                        <path class="progress-ring-bg"
                              stroke="#e9ecef"
                              stroke-width="3.5"
                              fill="none"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        <path class="progress-ring-circle"
                              stroke="{{ $formationProgress >= 100 ? '#28a745' : '#1e7a2f' }}"
                              stroke-width="3.5"
                              stroke-linecap="round"
                              fill="none"
                              stroke-dasharray="{{ $formationProgress }}, 100"
                              style="transform: rotate(-90deg); transform-origin: center;"
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                    </svg>
                    <span class="progress-ring-text">{{ $formationProgress }}%</span>
                </div>
                <div>
                    <div class="fw-bold">Progression globale</div>
                    <div class="small text-muted">{{ $completedFormationContenus }}/{{ $totalFormationContenus }} contenus</div>
                </div>
            </div>
        </div>

        <!-- Navigation des modules -->
        <div class="module-nav">
            @foreach($allModules as $navModuleIndex => $navModule)
                @php
                    $isCurrentModule = $navModule->id === $module->id;

                    // Calculer la progression du module
                    $navModuleContenus = $navModule->contenus->count();
                    $navModuleCompleted = 0;
                    if ($isCurrentModule) {
                        $navModuleCompleted = $completedContenus;
                    } else {
                        $navModuleCompleted = \App\Models\UserModuleProgression::where('user_id', Auth::id())
                            ->where('module_id', $navModule->id)
                            ->where('completed', true)
                            ->count();
                    }
                    $navModuleProgress = $navModuleContenus > 0 ? round(($navModuleCompleted / $navModuleContenus) * 100) : 0;

                    // Vérifier si le module est accessible
                    $isAccessible = $navModuleIndex === 0 || $navModuleIndex <= $moduleIndex;
                @endphp

                <div class="module-nav-section mb-3">
                    <div class="px-3 py-2 d-flex align-items-center justify-content-between bg-light">
                        <span class="fw-bold small text-uppercase text-muted">Module {{ $navModuleIndex + 1 }}</span>
                        @if($navModuleProgress >= 100)
                            <span class="badge bg-success">Terminé</span>
                        @elseif($navModuleProgress > 0)
                            <span class="badge bg-primary">{{ $navModuleProgress }}%</span>
                        @endif
                    </div>

                    @if($isCurrentModule)
                        @foreach($navModule->contenus as $navIndex => $navContenu)
                            @php
                                $navIsCompleted = $userProgressions->has($navContenu->id) && $userProgressions[$navContenu->id]->completed;
                                $navIsUnlocked = $navIndex === 0 || ($userProgressions->has($navModule->contenus[$navIndex - 1]->id) && $userProgressions[$navModule->contenus[$navIndex - 1]->id]->completed);
                            @endphp
                            <a href="#contenu-{{ $navContenu->id }}"
                               class="module-nav-item text-decoration-none {{ $navIsCompleted ? 'completed' : '' }} {{ !$navIsUnlocked ? 'locked' : '' }}"
                               data-contenu-id="{{ $navContenu->id }}">
                                <div class="nav-item-icon {{ $navIsCompleted ? 'completed' : ($navIsUnlocked ? $navContenu->type : 'locked') }}">
                                    @if($navIsCompleted)
                                        <i class="fas fa-check"></i>
                                    @elseif(!$navIsUnlocked)
                                        <i class="fas fa-lock"></i>
                                    @elseif($navContenu->type === 'video')
                                        <i class="fas fa-play"></i>
                                    @elseif($navContenu->type === 'pdf')
                                        <i class="fas fa-file-pdf"></i>
                                    @elseif($navContenu->type === 'texte')
                                        <i class="fas fa-file-alt"></i>
                                    @else
                                        <i class="fas fa-file"></i>
                                    @endif
                                </div>
                                <div class="nav-item-content">
                                    <div class="nav-item-title text-dark">{{ $navContenu->titre }}</div>
                                    <div class="nav-item-meta">
                                        {{ ucfirst($navContenu->type) }}
                                        @if($navContenu->duree)
                                            - {{ $navContenu->duree }}
                                        @endif
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <a href="{{ $isAccessible ? route('formation.module.show', [$formation, $navModule]) : '#' }}"
                           class="module-nav-item text-decoration-none {{ !$isAccessible ? 'locked' : '' }}">
                            <div class="nav-item-icon {{ $navModuleProgress >= 100 ? 'completed' : (!$isAccessible ? 'locked' : 'texte') }}">
                                @if($navModuleProgress >= 100)
                                    <i class="fas fa-check"></i>
                                @elseif(!$isAccessible)
                                    <i class="fas fa-lock"></i>
                                @else
                                    <i class="fas fa-book"></i>
                                @endif
                            </div>
                            <div class="nav-item-content">
                                <div class="nav-item-title text-dark">{{ $navModule->titre }}</div>
                                <div class="nav-item-meta">{{ $navModuleContenus }} contenus</div>
                            </div>
                        </a>
                    @endif
                </div>
            @endforeach

            <!-- Quiz section in sidebar -->
            @if($module->quizzes->isNotEmpty())
                <div class="module-nav-section mb-3">
                    <div class="px-3 py-2 bg-warning bg-opacity-10">
                        <span class="fw-bold small text-uppercase text-warning">Quiz du module</span>
                    </div>
                    @php
                        $allContenusCompleted = $completedContenus >= $totalContenus;
                    @endphp
                    @foreach($module->quizzes as $quiz)
                        <div class="module-nav-item {{ !$allContenusCompleted ? 'locked' : '' }}">
                            <div class="nav-item-icon {{ $allContenusCompleted ? 'quiz' : 'locked' }}">
                                <i class="fas fa-{{ $allContenusCompleted ? 'question' : 'lock' }}"></i>
                            </div>
                            <div class="nav-item-content">
                                <div class="nav-item-title">{{ $quiz->titre }}</div>
                                <div class="nav-item-meta">{{ $quiz->questions()->count() }} questions</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </aside>

    <!-- Main Content -->
    <main class="learning-content">
        <!-- Header du contenu -->
        <div class="content-header">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('account.formations') }}">Mes formations</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('formation.show', $formation) }}">{{ Str::limit($formation->titre, 25) }}</a></li>
                            <li class="breadcrumb-item active">{{ Str::limit($module->titre, 25) }}</li>
                        </ol>
                    </nav>
                    <h1>{{ $module->titre }}</h1>
                    @if($module->description)
                        <p class="text-muted mb-0" style="text-align: justify;">{{ $module->description }}</p>
                    @endif
                </div>
                <div class="text-end">
                    <div class="mb-2">
                        <span class="badge bg-primary me-1">Module {{ $moduleIndex + 1 }}/{{ $allModules->count() }}</span>
                        <span class="badge bg-success">{{ $moduleProgress }}% terminé</span>
                    </div>
                    <div class="progress" style="width: 200px; height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $moduleProgress }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenus du module -->
        @if($module->contenus->isEmpty())
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                Aucun contenu n'a encore été ajouté à ce module.
            </div>
        @else
            @foreach($module->contenus as $index => $contenu)
                @php
                    $isCompleted = $userProgressions->has($contenu->id) && $userProgressions[$contenu->id]->completed;
                    $isUnlocked = $index === 0 || ($userProgressions->has($module->contenus[$index - 1]->id) && $userProgressions[$module->contenus[$index - 1]->id]->completed);
                @endphp

                <div class="card contenu-card @if(!$isUnlocked) locked-content @endif" id="contenu-{{ $contenu->id }}">
                    <div class="contenu-card-header">
                        <div class="d-flex align-items-center">
                            <div class="contenu-type-icon {{ $contenu->type }}">
                                @if($contenu->type === 'video')
                                    <i class="fas fa-play"></i>
                                @elseif($contenu->type === 'pdf')
                                    <i class="fas fa-file-pdf"></i>
                                @elseif($contenu->type === 'texte')
                                    <i class="fas fa-file-alt"></i>
                                @else
                                    <i class="fas fa-file"></i>
                                @endif
                            </div>
                            <div>
                                <h5 class="mb-0">{{ $contenu->titre }}</h5>
                                <div class="small text-muted">
                                    {{ ucfirst($contenu->type) }}
                                    @if($contenu->duree)
                                        - {{ $contenu->duree }}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            <span class="badge bg-light text-dark me-2">#{{ $index + 1 }}</span>
                            @if($isCompleted)
                                <span class="badge bg-success success-checkmark">
                                    <i class="fas fa-check-circle me-1"></i>Terminé
                                </span>
                            @elseif(!$isUnlocked)
                                <span class="badge bg-secondary">
                                    <i class="fas fa-lock me-1"></i>Verrouillé
                                </span>
                            @else
                                <span class="badge bg-primary">
                                    <i class="fas fa-play-circle me-1"></i>En cours
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="contenu-card-body">
                        @if($contenu->description)
                            <p class="text-muted mb-4" style="text-align: justify;">{{ $contenu->description }}</p>
                        @endif

                        @if(!$isUnlocked)
                            <div class="alert alert-warning d-flex align-items-center">
                                <i class="fas fa-lock fa-2x me-3"></i>
                                <div>
                                    <strong>Contenu verrouillé</strong><br>
                                    <span class="small">Terminez le contenu précédent pour débloquer celui-ci.</span>
                                </div>
                            </div>
                        @else
                            <!-- Affichage selon le type de contenu -->
                            @if($contenu->type === 'video' && $contenu->fichier)
                                <div class="video-player-container mb-3">
                                    @if(str_contains($contenu->fichier, 'youtube.com') || str_contains($contenu->fichier, 'youtu.be'))
                                        <iframe id="videoPlayer{{ $contenu->id }}"
                                                src="{{ $contenu->fichier }}?enablejsapi=1"
                                                allowfullscreen
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                        </iframe>
                                    @else
                                        <video id="videoPlayer{{ $contenu->id }}"
                                               controls
                                               controlsList="nodownload"
                                               oncontextmenu="return false;">
                                            <source src="{{ asset($contenu->fichier) }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la lecture de vidéos.
                                        </video>
                                    @endif
                                </div>

                                <!-- Barre de progression vidéo -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="small text-muted">Progression de visionnage</span>
                                    <span class="badge bg-primary" id="watchProgress{{ $contenu->id }}">
                                        {{ $userProgressions->has($contenu->id) ? number_format($userProgressions[$contenu->id]->video_watch_percentage, 0) : '0' }}%
                                    </span>
                                </div>
                                <div class="video-progress-bar">
                                    <div class="video-progress-fill" id="watchProgressBar{{ $contenu->id }}"
                                         style="width: {{ $userProgressions->has($contenu->id) ? $userProgressions[$contenu->id]->video_watch_percentage : 0 }}%">
                                    </div>
                                </div>

                                @if($contenu->transcription)
                                    <div class="mt-4">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#transcription{{ $contenu->id }}">
                                            <i class="fas fa-closed-captioning me-2"></i>Voir la transcription
                                        </button>
                                        <div class="collapse mt-3" id="transcription{{ $contenu->id }}">
                                            <div class="card card-body bg-light" style="max-height: 300px; overflow-y: auto;">
                                                {!! nl2br(e($contenu->transcription)) !!}
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <script>
                                    (function() {
                                        const video = document.getElementById('videoPlayer{{ $contenu->id }}');
                                        const contenuId = {{ $contenu->id }};
                                        let updateInterval;

                                        if (video && video.tagName === 'VIDEO') {
                                            video.addEventListener('timeupdate', function() {
                                                const percentage = (video.currentTime / video.duration) * 100;
                                                updateVideoProgress{{ $contenu->id }}(percentage);
                                            });

                                            video.addEventListener('contextmenu', e => e.preventDefault());
                                        }

                                        function updateVideoProgress{{ $contenu->id }}(percentage) {
                                            const progressBar = document.getElementById('watchProgressBar{{ $contenu->id }}');
                                            const progressBadge = document.getElementById('watchProgress{{ $contenu->id }}');

                                            if (progressBar) progressBar.style.width = percentage + '%';
                                            if (progressBadge) progressBadge.textContent = Math.round(percentage) + '%';

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
                                                        const completeBtn = document.querySelector(`.mark-completed-btn[data-contenu-id="${contenuId}"]`);
                                                        if (completeBtn) {
                                                            completeBtn.disabled = false;
                                                            completeBtn.classList.remove('btn-secondary');
                                                            completeBtn.classList.add('btn-complete');
                                                        }
                                                    }
                                                });
                                            }, 5000);
                                        }
                                    })();
                                </script>

                            @elseif($contenu->type === 'texte' && $contenu->contenu)
                                <div class="border-start border-4 border-primary ps-4 py-2 bg-light rounded">
                                    {!! nl2br(e($contenu->contenu)) !!}
                                </div>

                            @elseif($contenu->type === 'pdf' && $contenu->fichier)
                                <div class="d-flex align-items-center justify-content-between bg-light p-4 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-file-pdf fa-3x text-danger me-3"></i>
                                        <div>
                                            <h6 class="mb-0">Document PDF Protégé</h6>
                                            <small class="text-muted">Ouvre dans un visualiseur sécurisé</small>
                                        </div>
                                    </div>
                                    <a href="{{ route('pdf.viewer.show', [$formation, $module, $contenu]) }}"
                                       class="btn btn-danger btn-lg rounded-2">
                                        <i class="fas fa-eye me-2"></i>Voir le PDF
                                    </a>
                                </div>

                            @else
                                @if($contenu->fichier)
                                    <a href="{{ asset($contenu->fichier) }}" target="_blank" class="btn btn-primary">
                                        <i class="fas fa-download me-2"></i>Télécharger la ressource
                                    </a>
                                @endif
                                @if($contenu->contenu)
                                    <div class="mt-3">{!! nl2br(e($contenu->contenu)) !!}</div>
                                @endif
                            @endif

                            <!-- Bouton de complétion -->
                            @if(!$isCompleted && $inscription)
                                @php
                                    $canComplete = true;
                                    $watchPercentage = 0;
                                    if ($contenu->type === 'video') {
                                        $watchPercentage = $userProgressions->has($contenu->id) ? $userProgressions[$contenu->id]->video_watch_percentage : 0;
                                        $canComplete = $watchPercentage >= 95;
                                    }
                                @endphp

                                <div class="completion-section {{ $canComplete ? 'ready' : '' }}">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                        <div>
                                            @if($contenu->type === 'video' && !$canComplete)
                                                <div class="d-flex align-items-center text-warning">
                                                    <i class="fas fa-clock fa-2x me-3"></i>
                                                    <div>
                                                        <strong>Regardez la vidéo jusqu'à la fin</strong><br>
                                                        <span class="small">Progression requise: 95% (actuellement {{ number_format($watchPercentage, 0) }}%)</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center text-success">
                                                    <i class="fas fa-check-circle fa-2x me-3"></i>
                                                    <div>
                                                        <strong>Prêt à continuer?</strong><br>
                                                        <span class="small">Marquez ce contenu comme terminé pour débloquer la suite</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <button class="btn btn-complete text-white mark-completed-btn"
                                                data-contenu-id="{{ $contenu->id }}"
                                                data-contenu-titre="{{ $contenu->titre }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#confirmCompleteModal"
                                                {{ !$canComplete ? 'disabled' : '' }}>
                                            <i class="fas fa-check-circle me-2"></i>
                                            Marquer comme terminé
                                        </button>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Section Quiz -->
        @if($module->quizzes->isNotEmpty())
            @php
                $allContenusCompleted = $completedContenus >= $totalContenus;
            @endphp

            <div class="quiz-section @if(!$allContenusCompleted) locked-content @endif">
                <div class="d-flex align-items-center mb-3">
                    <div class="contenu-type-icon quiz me-3">
                        <i class="fas fa-clipboard-check"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Quiz du module</h4>
                        @if(!$allContenusCompleted)
                            <span class="text-muted small">Terminez tous les contenus pour accéder au quiz</span>
                        @endif
                    </div>
                </div>

                @if(!$allContenusCompleted)
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-lock me-2"></i>
                        Terminez tous les contenus de ce module pour débloquer le quiz.
                        <strong>({{ $completedContenus }}/{{ $totalContenus }} terminés)</strong>
                    </div>
                @else
                    @foreach($module->quizzes as $quiz)
                        <div class="d-flex justify-content-between align-items-center p-3 bg-white rounded mb-2">
                            <div>
                                <h6 class="mb-1">{{ $quiz->titre }}</h6>
                                <div class="small text-muted">
                                    <span class="me-3"><i class="fas fa-question-circle me-1"></i>{{ $quiz->questions()->count() }} questions</span>
                                    <span class="me-3"><i class="fas fa-star me-1"></i>{{ $quiz->total_points }} points</span>
                                    @if($quiz->duree_minutes)
                                        <span><i class="fas fa-clock me-1"></i>{{ $quiz->duree_minutes }} min</span>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('quiz.show', $quiz) }}" class="btn btn-warning rounded-2">
                                <i class="fas fa-play me-2"></i>Commencer le quiz
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        @endif

        <!-- Navigation entre modules -->
        <div class="modules-nav-footer">
            @if($moduleIndex > 0)
                <a href="{{ route('formation.module.show', [$formation, $allModules[$moduleIndex - 1]]) }}" class="nav-module-btn prev">
                    <i class="fas fa-arrow-left"></i>
                    <div>
                        <span class="small text-muted d-block">Module précédent</span>
                        <span class="fw-bold">{{ Str::limit($allModules[$moduleIndex - 1]->titre, 20) }}</span>
                    </div>
                </a>
            @else
                <div></div>
            @endif

            @if($moduleIndex < $allModules->count() - 1)
                @php
                    $nextModuleAccessible = $moduleProgress >= 100;
                @endphp
                @if($nextModuleAccessible)
                    <a href="{{ route('formation.module.show', [$formation, $allModules[$moduleIndex + 1]]) }}" class="nav-module-btn next">
                        <div class="text-end">
                            <span class="small opacity-75 d-block">Module suivant</span>
                            <span class="fw-bold">{{ Str::limit($allModules[$moduleIndex + 1]->titre, 20) }}</span>
                        </div>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                @else
                    <button class="nav-module-btn next opacity-50" disabled title="Terminez ce module pour continuer">
                        <div class="text-end">
                            <span class="small opacity-75 d-block">Module suivant</span>
                            <span class="fw-bold">{{ Str::limit($allModules[$moduleIndex + 1]->titre, 20) }}</span>
                        </div>
                        <i class="fas fa-lock"></i>
                    </button>
                @endif
            @else
                @php
                    $allQuizzesPassed = true;
                    $moduleQuizzes = \App\Models\Quiz::where('module_id', $module->id)->where('active', true)->get();
                    foreach ($moduleQuizzes as $mq) {
                        if (!$mq->userHasPassed(auth()->id())) {
                            $allQuizzesPassed = false;
                            break;
                        }
                    }
                    $formationCompleted = $moduleProgress >= 100 && $allQuizzesPassed;
                @endphp
                @if($formationCompleted)
                    <a href="{{ route('formation.show', $formation) }}" class="nav-module-btn next" style="background: linear-gradient(135deg, #f6d365, #fda085); color: white; padding: 0.75rem 1.5rem;">
                        <div class="text-end">
                            <span class="small opacity-75 d-block">Formation terminee !</span>
                            <span class="fw-bold">Voir mon resultat</span>
                        </div>
                        <i class="fas fa-trophy" style="font-size: 1.25rem;"></i>
                    </a>
                @else
                    <a href="{{ route('formation.show', $formation) }}" class="nav-module-btn next">
                        <div class="text-end">
                            <span class="small opacity-75 d-block">Termine !</span>
                            <span class="fw-bold">Retour a la formation</span>
                        </div>
                        <i class="fas fa-flag-checkered"></i>
                    </a>
                @endif
            @endif
        </div>
    </main>
</div>

<!-- Modal de confirmation -->
<div class="modal fade" id="confirmCompleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white border-0">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Confirmer la complétion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-trophy fa-4x text-warning mb-3"></i>
                <h5 class="mb-2">Excellent travail!</h5>
                <p class="text-muted mb-0" id="modal-contenu-titre"></p>
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-secondary rounded-2 px-4" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success rounded-2 px-4" id="confirmCompleteBtn">
                    <i class="fas fa-check me-2"></i>Confirmer
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal paiement requis -->
<div class="modal fade" id="paiementRequiredModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-dark">
                <h5 class="modal-title"><i class="fas fa-lock me-2"></i>Paiement requis</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-credit-card fa-4x text-warning mb-3"></i>
                <h5 class="mb-2">Finalisez votre inscription</h5>
                <p class="text-muted">Pour accéder à ce contenu, vous devez finaliser le paiement de votre inscription.</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                <a href="{{ route('formation.show', $formation) }}" class="btn btn-warning">
                    <i class="fas fa-shopping-cart me-2"></i>Procéder au paiement
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar mobile
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('learningSidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        // Fermer le sidebar en cliquant à l'extérieur
        document.addEventListener('click', function(e) {
            if (window.innerWidth < 992 && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)) {
                sidebar.classList.remove('show');
            }
        });
    }

    // Scroll smooth vers les contenus
    document.querySelectorAll('.module-nav-item[data-contenu-id]').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const contenuId = this.dataset.contenuId;
            const element = document.getElementById('contenu-' + contenuId);
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'start' });
                if (window.innerWidth < 992) {
                    sidebar.classList.remove('show');
                }
            }
        });
    });

    // Gestion du modal de confirmation
    const confirmCompleteModal = document.getElementById('confirmCompleteModal');
    const confirmCompleteBtn = document.getElementById('confirmCompleteBtn');
    const modalTitre = document.getElementById('modal-contenu-titre');
    let currentContenuId = null;

    if (confirmCompleteModal) {
        confirmCompleteModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            currentContenuId = button.getAttribute('data-contenu-id');
            const contenuTitre = button.getAttribute('data-contenu-titre');
            modalTitre.textContent = 'Vous avez terminé: ' + contenuTitre;
        });
    }

    if (confirmCompleteBtn) {
        confirmCompleteBtn.addEventListener('click', function() {
            if (!currentContenuId) return;

            confirmCompleteBtn.disabled = true;
            confirmCompleteBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>En cours...';

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
                    const modal = bootstrap.Modal.getInstance(confirmCompleteModal);
                    modal.hide();
                    location.reload();
                } else {
                    confirmCompleteBtn.disabled = false;
                    confirmCompleteBtn.innerHTML = '<i class="fas fa-check me-2"></i>Confirmer';
                    alert(data.error || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                confirmCompleteBtn.disabled = false;
                confirmCompleteBtn.innerHTML = '<i class="fas fa-check me-2"></i>Confirmer';
                alert('Une erreur est survenue');
            });
        });
    }

    if (confirmCompleteModal) {
        confirmCompleteModal.addEventListener('hidden.bs.modal', function() {
            confirmCompleteBtn.disabled = false;
            confirmCompleteBtn.innerHTML = '<i class="fas fa-check me-2"></i>Confirmer';
            currentContenuId = null;
        });
    }
});
</script>
@endpush
