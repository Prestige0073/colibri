@extends('layouts.app')

@section('title', $livre->titre . ' - Lecture')

@section('content')
<style>
    body {
        overflow: hidden;
        margin: 0;
        padding: 0;
    }

    #pdf-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: #2c2c2c;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        z-index: 9999;
    }

    .pdf-header {
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        padding: 12px 20px;
        color: white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pdf-info {
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
        min-width: 200px;
    }

    .pdf-info h1 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #fff;
    }

    .pdf-controls {
        display: flex;
        gap: 8px;
        align-items: center;
        flex-wrap: wrap;
    }

    .pdf-controls button {
        background: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
    }

    .pdf-controls button:hover:not(:disabled) {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }

    .pdf-controls button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .btn-danger {
        background: rgba(220,53,69,0.8) !important;
        border-color: rgba(220,53,69,1) !important;
    }

    .btn-danger:hover:not(:disabled) {
        background: rgba(220,53,69,1) !important;
    }

    #page-info {
        background: rgba(255,255,255,0.1);
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 14px;
        color: white;
        font-weight: 500;
    }

    #canvas-container {
        flex: 1;
        overflow-y: auto;
        overflow-x: auto;
        background: #2c2c2c;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 20px;
        position: relative;
    }

    #pdf-canvas {
        box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        background: white;
        max-width: 100%;
        height: auto;
    }

    .user-badge {
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: rgba(0,0,0,0.85);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        font-size: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        z-index: 10000;
        backdrop-filter: blur(10px);
    }

    .watermark {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-45deg);
        font-size: 80px;
        color: rgba(255, 255, 255, 0.08);
        pointer-events: none;
        z-index: 9998;
        font-weight: bold;
        white-space: nowrap;
        text-transform: uppercase;
        letter-spacing: 10px;
    }

    .screenshot-blocker {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255,0,0,0.9);
        color: white;
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 99999;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        padding: 20px;
    }

    .screenshot-blocker.active {
        display: flex;
    }

    @media (max-width: 768px) {
        .pdf-header {
            padding: 10px 15px;
        }

        .pdf-info h1 {
            font-size: 0.9rem;
        }

        .pdf-controls {
            width: 100%;
            justify-content: center;
        }

        .pdf-controls button {
            padding: 6px 10px;
            font-size: 12px;
        }

        .btn-text {
            display: none;
        }

        .user-badge {
            bottom: 10px;
            right: 10px;
            padding: 6px 12px;
            font-size: 10px;
        }

        .watermark {
            font-size: 40px;
        }
    }

    .loading-spinner {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 10001;
    }

    .loading-spinner .spinner {
        border: 4px solid rgba(255,255,255,0.3);
        border-top: 4px solid white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 0 auto 15px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div id="pdf-container">
    <div class="pdf-header">
        <div class="pdf-info">
            <i class="fa fa-book" style="font-size: 1.5rem; color: #4CAF50;"></i>
            <div>
                <h1>{{ $livre->titre }}</h1>
                @if($livre->auteur)
                    <small style="color: rgba(255,255,255,0.7);">Par {{ $livre->auteur }}</small>
                @endif
            </div>
        </div>
        <div class="pdf-controls">
            <button id="prev-page" disabled>
                <i class="fa fa-chevron-left"></i>
                <span class="btn-text">Précédent</span>
            </button>
            <span id="page-info">Page <span id="page-num">1</span> / <span id="page-count">--</span></span>
            <button id="next-page" disabled>
                <span class="btn-text">Suivant</span>
                <i class="fa fa-chevron-right"></i>
            </button>
            <button id="zoom-out">
                <i class="fa fa-search-minus"></i>
            </button>
            <button id="zoom-in">
                <i class="fa fa-search-plus"></i>
            </button>
            <a href="{{ route('account.bibliotheque') }}" class="btn btn-danger" style="text-decoration: none; display: flex; align-items: center; gap: 6px;">
                <i class="fa fa-times"></i>
                <span class="btn-text">Fermer</span>
            </a>
        </div>
    </div>

    <div id="canvas-container">
        <div class="loading-spinner" id="loading">
            <div class="spinner"></div>
            <p>Chargement du document...</p>
        </div>
        <canvas id="pdf-canvas"></canvas>
    </div>

    <div class="watermark">COLIBRI LITTÉRAIRE</div>

    <div class="user-badge">
        <i class="fa fa-user-circle me-2"></i>
        {{ $user->name }} • {{ now()->format('d/m/Y H:i') }}
    </div>

    <div class="screenshot-blocker" id="screenshot-blocker">
        <div>
            <i class="fa fa-exclamation-triangle fa-3x mb-3"></i>
            <p>CAPTURE D'ÉCRAN DÉTECTÉE</p>
            <p style="font-size: 16px; margin-top: 10px;">Cette action a été enregistrée.</p>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    const pdfUrl = '{{ asset($livre->pdf) }}';
    let pdfDoc = null;
    let pageNum = 1;
    let pageRendering = false;
    let pageNumPending = null;
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    let scale = isMobile ? 1.2 : 1.5;

    const canvas = document.getElementById('pdf-canvas');
    const ctx = canvas.getContext('2d');
    const prevBtn = document.getElementById('prev-page');
    const nextBtn = document.getElementById('next-page');
    const pageNumSpan = document.getElementById('page-num');
    const pageCountSpan = document.getElementById('page-count');
    const zoomInBtn = document.getElementById('zoom-in');
    const zoomOutBtn = document.getElementById('zoom-out');
    const loading = document.getElementById('loading');
    const screenshotBlocker = document.getElementById('screenshot-blocker');

    let screenshotAttempts = 0;

    function renderPage(num) {
        pageRendering = true;
        loading.style.display = 'block';

        pdfDoc.getPage(num).then(page => {
            let viewport = page.getViewport({ scale: scale });

            if (isMobile) {
                const containerWidth = document.getElementById('canvas-container').clientWidth - 20;
                const scaleToFit = containerWidth / viewport.width;
                viewport = page.getViewport({ scale: scaleToFit });
            }

            canvas.height = viewport.height;
            canvas.width = viewport.width;

            const renderContext = {
                canvasContext: ctx,
                viewport: viewport
            };

            const renderTask = page.render(renderContext);

            renderTask.promise.then(() => {
                pageRendering = false;
                loading.style.display = 'none';

                if (pageNumPending !== null) {
                    renderPage(pageNumPending);
                    pageNumPending = null;
                }
            });
        });

        pageNumSpan.textContent = num;
        updateButtons();
    }

    function queueRenderPage(num) {
        if (pageRendering) {
            pageNumPending = num;
        } else {
            renderPage(num);
        }
    }

    function updateButtons() {
        prevBtn.disabled = (pageNum <= 1);
        nextBtn.disabled = (pageNum >= pdfDoc.numPages);
    }

    function showPrevPage() {
        if (pageNum <= 1) return;
        pageNum--;
        queueRenderPage(pageNum);
    }

    function showNextPage() {
        if (pageNum >= pdfDoc.numPages) return;
        pageNum++;
        queueRenderPage(pageNum);
    }

    function zoomIn() {
        scale += 0.25;
        queueRenderPage(pageNum);
    }

    function zoomOut() {
        if (scale > 0.5) {
            scale -= 0.25;
            queueRenderPage(pageNum);
        }
    }

    prevBtn.addEventListener('click', showPrevPage);
    nextBtn.addEventListener('click', showNextPage);
    zoomInBtn.addEventListener('click', zoomIn);
    zoomOutBtn.addEventListener('click', zoomOut);

    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
        pdfDoc = pdf;
        pageCountSpan.textContent = pdf.numPages;
        renderPage(pageNum);
    }).catch(err => {
        loading.innerHTML = '<i class="fa fa-exclamation-triangle fa-3x mb-3"></i><p>Erreur de chargement du PDF</p>';
        console.error('Erreur PDF:', err);
    });

    // Protection contre les captures d'écran
    function showScreenshotBlocker() {
        screenshotAttempts++;
        screenshotBlocker.classList.add('active');

        // Envoyer une notification au serveur (optionnel)
        fetch('/api/log-screenshot-attempt', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                livre_id: {{ $livre->id }},
                user_id: {{ $user->id }},
                timestamp: new Date().toISOString()
            })
        }).catch(err => console.log('Log failed:', err));

        setTimeout(() => {
            screenshotBlocker.classList.remove('active');
        }, 2000);
    }

    // Détection des captures d'écran
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            showScreenshotBlocker();
        }
    });

    window.addEventListener('blur', () => {
        showScreenshotBlocker();
    });

    document.addEventListener('keyup', (e) => {
        if (e.key === 'PrintScreen') {
            showScreenshotBlocker();
        }
    });

    // Protection clavier
    document.addEventListener('keydown', (e) => {
        if (e.ctrlKey && (e.key === 's' || e.key === 'p')) {
            e.preventDefault();
            showScreenshotBlocker();
            return false;
        }
        if (e.key === 'PrintScreen') {
            e.preventDefault();
            showScreenshotBlocker();
            return false;
        }
    });

    // Protection clic droit
    document.addEventListener('contextmenu', (e) => {
        e.preventDefault();
        return false;
    });

    // Protection contre la sélection
    document.addEventListener('selectstart', (e) => {
        if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'TEXTAREA') {
            e.preventDefault();
            return false;
        }
    });

    // Mobile screenshot detection
    if ('onpagehide' in window) {
        window.addEventListener('pagehide', showScreenshotBlocker);
    }
</script>
@endsection
