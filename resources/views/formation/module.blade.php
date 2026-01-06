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
                                                <small class="text-muted">Cliquez pour visualiser le document de manière sécurisée</small>
                                            </div>
                                        </div>
                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#pdfModal{{ $contenu->id }}">
                                            <i class="fas fa-eye me-2"></i>Voir
                                        </button>
                                    </div>

                                    <!-- Modal Plein écran pour le PDF -->
                                    <div class="modal fade" id="pdfModal{{ $contenu->id }}" tabindex="-1" aria-labelledby="pdfModalLabel{{ $contenu->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-fullscreen">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="pdfModalLabel{{ $contenu->id }}">
                                                        <i class="fas fa-file-pdf me-2"></i>{{ $contenu->titre }} - Document Protégé
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <div class="pdf-viewer-container" id="pdf-viewer-{{ $contenu->id }}">
                                        <div class="pdf-viewer-header bg-danger text-white p-3 rounded-top d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-file-pdf me-2"></i>
                                                <strong>Document PDF Protégé</strong>
                                            </div>
                                            <div class="pdf-controls">
                                                <button class="btn btn-sm btn-light" onclick="zoomOut{{ $contenu->id }}()">
                                                    <i class="fas fa-search-minus"></i>
                                                </button>
                                                <span class="mx-2 text-white" id="zoom-level-{{ $contenu->id }}">100%</span>
                                                <button class="btn btn-sm btn-light" onclick="zoomIn{{ $contenu->id }}()">
                                                    <i class="fas fa-search-plus"></i>
                                                </button>
                                                <button class="btn btn-sm btn-light ms-2" onclick="prevPage{{ $contenu->id }}()">
                                                    <i class="fas fa-chevron-left"></i>
                                                </button>
                                                <span class="mx-2 text-white">
                                                    <span id="page-num-{{ $contenu->id }}">1</span> / <span id="page-count-{{ $contenu->id }}">-</span>
                                                </span>
                                                <button class="btn btn-sm btn-light" onclick="nextPage{{ $contenu->id }}()">
                                                    <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="pdf-canvas-wrapper position-relative" style="background: #525659; min-height: 600px;">
                                            <!-- Loader to avoid flash while PDF renders -->
                                            <div class="pdf-loader d-flex align-items-center justify-content-center" id="pdf-loader-{{ $contenu->id }}" style="position:absolute;inset:0;z-index:20;background:rgba(0,0,0,0.35);">
                                                <div class="text-center text-white">
                                                    <div class="spinner-border text-light" role="status"></div>
                                                    <div class="mt-2">Chargement du document…</div>
                                                </div>
                                            </div>
                                            <canvas id="pdf-canvas-{{ $contenu->id }}" style="display: none; margin: 0 auto;"></canvas>
                                            <div class="watermark-overlay" id="watermark-{{ $contenu->id }}"></div>
                                            <!-- Protection overlay invisible -->
                                            <div class="pdf-protection-layer"></div>
                                        </div>
                                        <div class="alert alert-warning m-3">
                                            <i class="fas fa-shield-alt me-2"></i>
                                            <small>Ce document est protégé. Toute tentative de copie ou téléchargement illégal est interdite et tracée.</small>
                                        </div>
                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
                                    <script>
                                        (function() {
                                            // Configuration PDF.js
                                            pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                                            const pdfUrl{{ $contenu->id }} = '{{ asset($contenu->fichier) }}';
                                            let pdfDoc{{ $contenu->id }} = null;
                                            let pageNum{{ $contenu->id }} = 1;
                                            let pageIsRendering{{ $contenu->id }} = false;
                                            let pageNumIsPending{{ $contenu->id }} = null;
                                            let scale{{ $contenu->id }} = 1.5;
                                            let pdfLoaded{{ $contenu->id }} = false;

                                            const canvas{{ $contenu->id }} = document.getElementById('pdf-canvas-{{ $contenu->id }}');
                                            const ctx{{ $contenu->id }} = canvas{{ $contenu->id }}.getContext('2d');

                                            // Désactiver le menu contextuel sur le canvas
                                            canvas{{ $contenu->id }}.addEventListener('contextmenu', e => e.preventDefault());

                                            // Désactiver la sélection
                                            canvas{{ $contenu->id }}.style.userSelect = 'none';
                                            canvas{{ $contenu->id }}.style.webkitUserSelect = 'none';

                                            // Fonction pour ajouter le filigrane
                                            function addWatermark{{ $contenu->id }}() {
                                                const watermarkDiv = document.getElementById('watermark-{{ $contenu->id }}');
                                                watermarkDiv.innerHTML = '';

                                                @if($inscription)
                                                    const userName = '{{ Auth::user()->name ?? "Utilisateur" }}';
                                                    const userEmail = '{{ Auth::user()->email ?? "" }}';
                                                    const currentDate = new Date().toLocaleString('fr-FR');

                                                    // Créer plusieurs filigranes en diagonale
                                                    for(let i = 0; i < 8; i++) {
                                                        const watermark = document.createElement('div');
                                                        watermark.style.cssText = `
                                                            position: absolute;
                                                            top: ${i * 150}px;
                                                            left: 50%;
                                                            transform: translateX(-50%) rotate(-45deg);
                                                            font-size: 24px;
                                                            color: rgba(255, 0, 0, 0.15);
                                                            font-weight: bold;
                                                            pointer-events: none;
                                                            white-space: nowrap;
                                                            z-index: 10;
                                                            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
                                                        `;
                                                        watermark.textContent = `${userName} - ${userEmail} - ${currentDate}`;
                                                        watermarkDiv.appendChild(watermark);
                                                    }
                                                @endif
                                            }

                                            // Rendu de la page
                                            function renderPage{{ $contenu->id }}(num) {
                                                pageIsRendering{{ $contenu->id }} = true;

                                                pdfDoc{{ $contenu->id }}.getPage(num).then(page => {
                                                    const viewport = page.getViewport({ scale: scale{{ $contenu->id }} });
                                                    canvas{{ $contenu->id }}.height = viewport.height;
                                                    canvas{{ $contenu->id }}.width = viewport.width;

                                                    const renderContext = {
                                                        canvasContext: ctx{{ $contenu->id }},
                                                        viewport: viewport
                                                    };

                                                            page.render(renderContext).promise.then(() => {
                                                                pageIsRendering{{ $contenu->id }} = false;

                                                                // Afficher le canvas et masquer le loader une fois le rendu terminé
                                                                try {
                                                                    const loaderEl = document.getElementById('pdf-loader-{{ $contenu->id }}');
                                                                    const canvasEl = document.getElementById('pdf-canvas-{{ $contenu->id }}');
                                                                    if (canvasEl) {
                                                                        canvasEl.style.display = 'block';
                                                                    }
                                                                    if (loaderEl) {
                                                                        loaderEl.style.display = 'none';
                                                                    }
                                                                } catch (e) {}

                                                                if (pageNumIsPending{{ $contenu->id }} !== null) {
                                                                    renderPage{{ $contenu->id }}(pageNumIsPending{{ $contenu->id }});
                                                                    pageNumIsPending{{ $contenu->id }} = null;
                                                                }

                                                                // Ajouter le filigrane après le rendu
                                                                addWatermark{{ $contenu->id }}();
                                                            });

                                                    // Afficher le numéro de page
                                                    document.getElementById('page-num-{{ $contenu->id }}').textContent = num;
                                                });
                                            }

                                            // Mettre en file d'attente le rendu de la page
                                            function queueRenderPage{{ $contenu->id }}(num) {
                                                if (pageIsRendering{{ $contenu->id }}) {
                                                    pageNumIsPending{{ $contenu->id }} = num;
                                                } else {
                                                    renderPage{{ $contenu->id }}(num);
                                                }
                                            }

                                            // Page précédente
                                            window.prevPage{{ $contenu->id }} = function() {
                                                if (pageNum{{ $contenu->id }} <= 1) {
                                                    return;
                                                }
                                                pageNum{{ $contenu->id }}--;
                                                queueRenderPage{{ $contenu->id }}(pageNum{{ $contenu->id }});
                                            }

                                            // Page suivante
                                            window.nextPage{{ $contenu->id }} = function() {
                                                if (pageNum{{ $contenu->id }} >= pdfDoc{{ $contenu->id }}.numPages) {
                                                    return;
                                                }
                                                pageNum{{ $contenu->id }}++;
                                                queueRenderPage{{ $contenu->id }}(pageNum{{ $contenu->id }});
                                            }

                                            // Zoom in
                                            window.zoomIn{{ $contenu->id }} = function() {
                                                scale{{ $contenu->id }} += 0.25;
                                                document.getElementById('zoom-level-{{ $contenu->id }}').textContent = Math.round(scale{{ $contenu->id }} * 100) + '%';
                                                queueRenderPage{{ $contenu->id }}(pageNum{{ $contenu->id }});
                                            }

                                            // Zoom out
                                            window.zoomOut{{ $contenu->id }} = function() {
                                                if (scale{{ $contenu->id }} > 0.5) {
                                                    scale{{ $contenu->id }} -= 0.25;
                                                    document.getElementById('zoom-level-{{ $contenu->id }}').textContent = Math.round(scale{{ $contenu->id }} * 100) + '%';
                                                    queueRenderPage{{ $contenu->id }}(pageNum{{ $contenu->id }});
                                                }
                                            }

                                            // Fonction pour charger le PDF
                                            function loadPDF{{ $contenu->id }}() {
                                                if (!pdfLoaded{{ $contenu->id }}) {
                                                    pdfLoaded{{ $contenu->id }} = true;
                                                    pdfjsLib.getDocument(pdfUrl{{ $contenu->id }}).promise.then(pdfDoc_ => {
                                                        pdfDoc{{ $contenu->id }} = pdfDoc_;
                                                        document.getElementById('page-count-{{ $contenu->id }}').textContent = pdfDoc{{ $contenu->id }}.numPages;
                                                        renderPage{{ $contenu->id }}(pageNum{{ $contenu->id }});
                                                    }).catch(err => {
                                                        console.error('Erreur lors du chargement du PDF:', err);
                                                        alert('Erreur lors du chargement du document PDF');
                                                        pdfLoaded{{ $contenu->id }} = false;
                                                    });
                                                }
                                            }

                                            // Écouter l'ouverture du modal pour charger le PDF
                                            const pdfModal{{ $contenu->id }} = document.getElementById('pdfModal{{ $contenu->id }}');
                                            pdfModal{{ $contenu->id }}.addEventListener('shown.bs.modal', function () {
                                                loadPDF{{ $contenu->id }}();
                                            });

                                            // Protection avancée contre les captures d'écran et raccourcis
                                            document.addEventListener('keydown', function(e) {
                                                // Bloquer Ctrl+S (Enregistrer)
                                                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                                                    e.preventDefault();
                                                    alert('⛔ Le téléchargement de ce document est désactivé.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+P (Imprimer)
                                                if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                                                    e.preventDefault();
                                                    alert('⛔ L\'impression de ce document est désactivée.');
                                                    return false;
                                                }

                                                // Bloquer Print Screen / Impr écran (toutes les variantes)
                                                if (e.key === 'PrintScreen' || e.keyCode === 44 || e.key === 'Print') {
                                                    e.preventDefault();
                                                    alert('⛔ Les captures d\'écran sont désactivées pour protéger ce contenu.');
                                                    // Effacer le presse-papier
                                                    navigator.clipboard.writeText('');
                                                    return false;
                                                }

                                                // Bloquer Alt+PrintScreen (capture fenêtre active)
                                                if (e.altKey && (e.key === 'PrintScreen' || e.keyCode === 44)) {
                                                    e.preventDefault();
                                                    alert('⛔ Les captures d\'écran sont désactivées pour protéger ce contenu.');
                                                    navigator.clipboard.writeText('');
                                                    return false;
                                                }

                                                // Bloquer Windows+PrintScreen (Windows)
                                                if (e.metaKey && (e.key === 'PrintScreen' || e.keyCode === 44)) {
                                                    e.preventDefault();
                                                    alert('⛔ Les captures d\'écran sont désactivées.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+Shift+S (Capture Firefox)
                                                if (e.ctrlKey && e.shiftKey && e.key === 's') {
                                                    e.preventDefault();
                                                    alert('⛔ Les captures d\'écran sont désactivées.');
                                                    return false;
                                                }

                                                // Bloquer F12, F11 (Outils développeur et plein écran)
                                                if (e.key === 'F12' || e.keyCode === 123) {
                                                    e.preventDefault();
                                                    alert('⛔ Les outils de développement sont désactivés.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+Shift+I (Outils développeur)
                                                if (e.ctrlKey && e.shiftKey && (e.key === 'i' || e.key === 'I')) {
                                                    e.preventDefault();
                                                    alert('⛔ Les outils de développement sont désactivés.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+Shift+J (Console)
                                                if (e.ctrlKey && e.shiftKey && (e.key === 'j' || e.key === 'J')) {
                                                    e.preventDefault();
                                                    alert('⛔ La console est désactivée.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+Shift+C (Inspecteur)
                                                if (e.ctrlKey && e.shiftKey && (e.key === 'c' || e.key === 'C')) {
                                                    e.preventDefault();
                                                    alert('⛔ L\'inspecteur est désactivé.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+U (Voir le code source)
                                                if (e.ctrlKey && (e.key === 'u' || e.key === 'U')) {
                                                    e.preventDefault();
                                                    alert('⛔ L\'affichage du code source est désactivé.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+A (Tout sélectionner)
                                                if (e.ctrlKey && (e.key === 'a' || e.key === 'A')) {
                                                    e.preventDefault();
                                                    return false;
                                                }

                                                // Bloquer Ctrl+C (Copier)
                                                if (e.ctrlKey && (e.key === 'c' || e.key === 'C') && !e.shiftKey) {
                                                    e.preventDefault();
                                                    alert('⛔ La copie est désactivée.');
                                                    return false;
                                                }

                                                // Bloquer Ctrl+V (Coller) - pour éviter certains contournements
                                                if (e.ctrlKey && (e.key === 'v' || e.key === 'V')) {
                                                    e.preventDefault();
                                                    return false;
                                                }

                                                // Bloquer Ctrl+X (Couper)
                                                if (e.ctrlKey && (e.key === 'x' || e.key === 'X')) {
                                                    e.preventDefault();
                                                    return false;
                                                }

                                                // Bloquer Insert (souvent utilisé pour capture)
                                                if (e.key === 'Insert' || e.keyCode === 45) {
                                                    e.preventDefault();
                                                    return false;
                                                }

                                                // Bloquer Windows+Shift+S (Outil capture Windows 10/11)
                                                if (e.metaKey && e.shiftKey && (e.key === 's' || e.key === 'S')) {
                                                    e.preventDefault();
                                                    alert('⛔ L\'outil de capture est désactivé.');
                                                    return false;
                                                }
                                            });

                                            // Bloquer le copier-coller via les événements
                                            document.addEventListener('copy', function(e) {
                                                e.preventDefault();
                                                alert('⛔ La copie est désactivée pour protéger ce contenu.');
                                                return false;
                                            });

                                            document.addEventListener('cut', function(e) {
                                                e.preventDefault();
                                                return false;
                                            });

                                            // Surveillance du presse-papier (effacer en continu)
                                            setInterval(function() {
                                                if (document.hasFocus() && pdfModal{{ $contenu->id }}.classList.contains('show')) {
                                                    try {
                                                        navigator.clipboard.writeText('').catch(() => {});
                                                    } catch(e) {}
                                                }
                                            }, 1000);

                                            // Bloquer la sélection de texte via événements
                                            document.addEventListener('selectstart', function(e) {
                                                if (e.target.closest('#pdfModal{{ $contenu->id }}')) {
                                                    e.preventDefault();
                                                    return false;
                                                }
                                            });

                                            // Détecter le changement de visibilité de la page (possible screenshot externe)
                                            document.addEventListener('visibilitychange', function() {
                                                if (document.hidden && pdfModal{{ $contenu->id }}.classList.contains('show')) {
                                                    console.warn('⚠️ Changement de visibilité détecté - Action suspecte tracée');
                                                }
                                            });

                                            // Bloquer le glisser-déposer
                                            document.addEventListener('dragstart', function(e) {
                                                if (e.target.closest('#pdfModal{{ $contenu->id }}')) {
                                                    e.preventDefault();
                                                    return false;
                                                }
                                            });

                                            // Détecter les outils de développement (tentative de screenshot)
                                            let devtoolsOpen = false;
                                            const detectDevTools = () => {
                                                const threshold = 160;
                                                if (window.outerWidth - window.innerWidth > threshold ||
                                                    window.outerHeight - window.innerHeight > threshold) {
                                                    if (!devtoolsOpen) {
                                                        devtoolsOpen = true;
                                                        console.warn('⚠️ Les outils de développement sont ouverts. Toute tentative de copie est tracée.');
                                                    }
                                                } else {
                                                    devtoolsOpen = false;
                                                }
                                            };

                                            setInterval(detectDevTools, 1000);
                                        })();
                                    </script>

                                    <style>
                                        .pdf-viewer-container {
                                            height: 100%;
                                            display: flex;
                                            flex-direction: column;
                                        }

                                        .pdf-canvas-wrapper {
                                            position: relative;
                                            overflow: auto;
                                            flex: 1;
                                            background: #525659;
                                        }

                                        .watermark-overlay {
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            pointer-events: none;
                                            z-index: 5;
                                        }

                                        .pdf-protection-layer {
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            width: 100%;
                                            height: 100%;
                                            z-index: 15;
                                            cursor: not-allowed;
                                        }

                                        #pdf-canvas-{{ $contenu->id }} {
                                            -webkit-user-select: none;
                                            -moz-user-select: none;
                                            -ms-user-select: none;
                                            user-select: none;
                                            -webkit-touch-callout: none;
                                        }

                                        /* Désactiver le menu contextuel */
                                        .pdf-canvas-wrapper,
                                        .pdf-canvas-wrapper * {
                                            -webkit-user-select: none;
                                            -moz-user-select: none;
                                            -ms-user-select: none;
                                            user-select: none;
                                        }

                                        /* Protection contre les captures d'écran via CSS */
                                        #pdfModal{{ $contenu->id }} {
                                            -webkit-user-select: none;
                                            -moz-user-select: none;
                                            -ms-user-select: none;
                                            user-select: none;
                                            -webkit-touch-callout: none;
                                            -khtml-user-select: none;
                                        }

                                        /* Empêcher le copier-coller */
                                        #pdfModal{{ $contenu->id }} * {
                                            -webkit-user-drag: none;
                                            -khtml-user-drag: none;
                                            -moz-user-drag: none;
                                            -o-user-drag: none;
                                            user-drag: none;
                                        }

                                        /* Message d'avertissement visible en permanence */
                                        @media print {
                                            #pdfModal{{ $contenu->id }} {
                                                display: none !important;
                                            }
                                        }
                                    </style>
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
        // Gestion du bouton "Marquer comme complété"
        const markCompletedButtons = document.querySelectorAll('.mark-completed-btn');

        markCompletedButtons.forEach(button => {
            button.addEventListener('click', function() {
                const contenuId = this.getAttribute('data-contenu-id');

                // Confirmation
                if (!confirm('Êtes-vous sûr d\'avoir terminé ce contenu ?')) {
                    return;
                }

                // Désactiver le bouton pendant la requête
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>En cours...';

                // Envoyer la requête AJAX
                fetch(`/formation/{{ $formation->id }}/module/{{ $module->id }}/contenu/${contenuId}/complete`, {
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
                        // Recharger la page pour afficher les changements
                        location.reload();
                    } else {
                        alert(data.error || 'Une erreur est survenue');
                        this.disabled = false;
                        this.innerHTML = '<i class="fas fa-check-circle me-2"></i>Marquer comme complété';
                    }
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    alert('Une erreur est survenue lors de la sauvegarde');
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-check-circle me-2"></i>Marquer comme complété';
                });
            });
        });
    });
</script>
@endpush

@endsection
