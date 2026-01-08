<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <title>{{ $contenu->titre }} - Document Protégé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #2c3e50;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .pdf-viewer-header {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            z-index: 1000;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .pdf-info h1 {
            font-size: 1.1rem;
            margin: 0;
            font-weight: 600;
        }

        .pdf-info small {
            font-size: 0.7rem;
            opacity: 0.9;
            display: block;
        }

        .pdf-controls {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .pdf-controls button {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .pdf-controls button:active {
            background: rgba(255,255,255,0.4);
        }

        .pdf-controls .btn-close-viewer {
            background: #fff;
            color: #dc3545;
            font-weight: bold;
        }

        .pdf-canvas-container {
            position: fixed;
            top: 60px;
            left: 0;
            right: 0;
            bottom: 50px;
            background: #525659;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 10px;
        }

        .pdf-canvas-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }

        #pdf-canvas {
            display: block;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            background: white;
            max-width: 100%;
            height: auto;
        }

        .watermark-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 100;
        }

        .watermark-text {
            position: absolute;
            font-size: 60px;
            color: rgba(220, 53, 69, 0.08);
            font-weight: 900;
            transform: rotate(-45deg);
            white-space: nowrap;
            letter-spacing: 5px;
        }

        .screenshot-blocker {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.95);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            color: white;
            flex-direction: column;
            gap: 20px;
        }

        .screenshot-blocker.active {
            display: flex;
        }

        .pdf-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #1a252f;
            color: #ffc107;
            padding: 10px 15px;
            text-align: center;
            box-shadow: 0 -2px 10px rgba(0,0,0,0.3);
            z-index: 1000;
            font-size: 11px;
        }

        .user-badge {
            position: fixed;
            bottom: 60px;
            right: 15px;
            background: rgba(220, 53, 69, 0.15);
            color: rgba(255, 255, 255, 0.6);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 10px;
            z-index: 999;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .pdf-info h1 {
                font-size: 0.9rem;
            }
            .pdf-info small {
                font-size: 0.65rem;
            }
            .pdf-controls button {
                padding: 6px 10px;
                font-size: 12px;
            }
            .pdf-controls span {
                font-size: 11px;
            }
            .btn-text {
                display: none;
            }
        }

        .pdf-loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .spinner {
            border: 4px solid rgba(255,255,255,0.1);
            border-top: 4px solid #dc3545;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <!-- Loader -->
    <div class="pdf-loader" id="pdf-loader">
        <div class="text-center text-white">
            <div class="spinner mb-3"></div>
            <div>Chargement sécurisé...</div>
        </div>
    </div>

    <!-- Screenshot Blocker -->
    <div class="screenshot-blocker" id="screenshot-blocker">
        <i class="fas fa-shield-alt fa-5x text-danger"></i>
        <h2>⛔ CAPTURE DÉTECTÉE</h2>
        <p>Les captures d'écran sont strictement interdites</p>
        <p style="font-size: 14px; opacity: 0.7;">Cette action a été enregistrée</p>
    </div>

    <!-- Header -->
    <div class="pdf-viewer-header">
        <div class="pdf-info">
            <h1><i class="fas fa-file-pdf me-2"></i>{{ $contenu->titre }}</h1>
            <small>{{ $formation->titre }}</small>
        </div>
        <div class="pdf-controls">
            <button onclick="zoomOut()" title="Zoom arrière">
                <i class="fas fa-search-minus"></i>
            </button>
            <span id="zoom-level">100%</span>
            <button onclick="zoomIn()" title="Zoom avant">
                <i class="fas fa-search-plus"></i>
            </button>
            <span class="mx-1">|</span>
            <button onclick="prevPage()" title="Page précédente">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span><span id="page-num">1</span>/<span id="page-count">-</span></span>
            <button onclick="nextPage()" title="Page suivante">
                <i class="fas fa-chevron-right"></i>
            </button>
            <span class="mx-1">|</span>
            <button class="btn-close-viewer" onclick="closeViewer()">
                <i class="fas fa-times me-1"></i><span class="btn-text">Fermer</span>
            </button>
        </div>
    </div>

    <!-- Canvas Container -->
    <div class="pdf-canvas-container" id="canvas-container">
        <div class="pdf-canvas-wrapper">
            <canvas id="pdf-canvas"></canvas>
            <div class="watermark-layer" id="watermark-layer"></div>
        </div>
    </div>

    <!-- User Badge -->
    <div class="user-badge" id="user-badge">
        {{ $user->name ?? 'Utilisateur' }} - <span id="current-time"></span>
    </div>

    <!-- Footer -->
    <div class="pdf-footer">
        <i class="fas fa-shield-alt me-2"></i>
        Document protégé - Copie, capture et téléchargement interdits
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        const pdfUrl = '{{ asset($contenu->fichier) }}';
        let pdfDoc = null;
        let pageNum = 1;
        let pageIsRendering = false;
        let pageNumIsPending = null;
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        let scale = isMobile ? 1.2 : 1.5;

        const canvas = document.getElementById('pdf-canvas');
        const ctx = canvas.getContext('2d');

        // Mise à jour du timestamp
        setInterval(() => {
            document.getElementById('current-time').textContent = new Date().toLocaleTimeString();
        }, 1000);

        // Ajouter watermarks
        function addWatermarks() {
            const layer = document.getElementById('watermark-layer');
            layer.innerHTML = '';

            const canvasHeight = canvas.height;
            const numWatermarks = Math.ceil(canvasHeight / 150);

            for(let i = 0; i < numWatermarks; i++) {
                const wm = document.createElement('div');
                wm.className = 'watermark-text';
                wm.style.top = (i * 150) + 'px';
                wm.style.left = '50%';
                wm.style.transform = 'translate(-50%, 0) rotate(-45deg)';
                wm.textContent = 'COLIBRI LITTÉRAIRE';
                layer.appendChild(wm);
            }
        }

        // Rendu de page
        function renderPage(num) {
            pageIsRendering = true;

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

                page.render(renderContext).promise.then(() => {
                    pageIsRendering = false;
                    document.getElementById('pdf-loader').style.display = 'none';

                    addWatermarks();

                    if (pageNumIsPending !== null) {
                        renderPage(pageNumIsPending);
                        pageNumIsPending = null;
                    }
                });

                document.getElementById('page-num').textContent = num;
            });
        }

        function queueRenderPage(num) {
            if (pageIsRendering) {
                pageNumIsPending = num;
            } else {
                renderPage(num);
            }
        }

        function prevPage() {
            if (pageNum <= 1) return;
            pageNum--;
            queueRenderPage(pageNum);
        }

        function nextPage() {
            if (pageNum >= pdfDoc.numPages) return;
            pageNum++;
            queueRenderPage(pageNum);
        }

        function zoomIn() {
            scale += 0.25;
            document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
            queueRenderPage(pageNum);
        }

        function zoomOut() {
            if (scale > 0.5) {
                scale -= 0.25;
                document.getElementById('zoom-level').textContent = Math.round(scale * 100) + '%';
                queueRenderPage(pageNum);
            }
        }

        function closeViewer() {
            window.location.href = '{{ route("formation.module.show", [$formation, $module]) }}';
        }

        // Charger le PDF
        pdfjsLib.getDocument(pdfUrl).promise.then(pdfDoc_ => {
            pdfDoc = pdfDoc_;
            document.getElementById('page-count').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        }).catch(err => {
            console.error('Erreur chargement PDF:', err);
            alert('Erreur lors du chargement du document PDF');
        });

        // ===== PROTECTIONS ANTI-SCREENSHOT =====

        let screenshotAttempts = 0;
        const screenshotBlocker = document.getElementById('screenshot-blocker');

        function showScreenshotBlocker() {
            screenshotAttempts++;
            screenshotBlocker.classList.add('active');

            // Envoyer log au serveur (optionnel)
            fetch('/api/log-screenshot-attempt', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    user_id: {{ $user->id ?? 0 }},
                    contenu_id: {{ $contenu->id }},
                    timestamp: new Date().toISOString()
                })
            }).catch(() => {});

            setTimeout(() => {
                screenshotBlocker.classList.remove('active');
            }, 2000);
        }

        // 1. Bloquer PrintScreen et touches système
        document.addEventListener('keydown', function(e) {
            // PrintScreen
            if (e.key === 'PrintScreen' || e.keyCode === 44) {
                e.preventDefault();
                showScreenshotBlocker();
                navigator.clipboard.writeText('').catch(() => {});
                return false;
            }

            // Ctrl+P (Imprimer)
            if ((e.ctrlKey || e.metaKey) && e.key === 'p') {
                e.preventDefault();
                alert('⛔ L\'impression est désactivée');
                return false;
            }

            // Ctrl+S (Sauvegarder)
            if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                e.preventDefault();
                alert('⛔ Le téléchargement est désactivé');
                return false;
            }

            // Windows + Shift + S (Outil capture Windows)
            if (e.metaKey && e.shiftKey && e.key === 's') {
                e.preventDefault();
                showScreenshotBlocker();
                return false;
            }

            // F12 et DevTools
            if (e.key === 'F12' || (e.ctrlKey && e.shiftKey && (e.key === 'i' || e.key === 'I'))) {
                e.preventDefault();
                return false;
            }
        });

        // 2. Détecter visibilitychange (screenshot mobile)
        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Page cachée = possible screenshot mobile
                showScreenshotBlocker();
            }
        });

        // 3. Bloquer clic droit et long press
        document.addEventListener('contextmenu', e => e.preventDefault());

        let longPressTimer;
        document.addEventListener('touchstart', function(e) {
            if (e.target.id === 'pdf-canvas' || e.target.closest('.pdf-canvas-wrapper')) {
                longPressTimer = setTimeout(() => {
                    if (navigator.vibrate) navigator.vibrate(50);
                }, 500);
            }
        }, { passive: true });

        document.addEventListener('touchend', () => clearTimeout(longPressTimer));
        document.addEventListener('touchmove', () => clearTimeout(longPressTimer));

        // 4. Bloquer copie
        document.addEventListener('copy', e => {
            e.preventDefault();
            return false;
        });

        // 5. Détecter blur (perte de focus = screenshot externe possible)
        window.addEventListener('blur', function() {
            showScreenshotBlocker();
        });

        // 6. Protection mobile spécifique iOS/Android
        if (isMobile) {
            // Page Lifecycle API (Android)
            if ('onfreeze' in document) {
                document.addEventListener('freeze', showScreenshotBlocker);
            }

            // pagehide (iOS)
            window.addEventListener('pagehide', function(e) {
                if (!e.persisted) {
                    showScreenshotBlocker();
                }
            });
        }

        // 7. Effacer clipboard régulièrement
        setInterval(() => {
            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText('').catch(() => {});
                }
            } catch(e) {}
        }, 1000);

        // Log console
        console.log('🛡️ PDF Viewer sécurisé chargé');
        console.log('- Détection screenshot: ACTIVE');
        console.log('- Protection clavier: ACTIVE');
        console.log('- Protection mobile: ' + (isMobile ? 'ACTIVE' : 'N/A'));
        console.log('- Utilisateur: {{ $user->name ?? "Inconnu" }}');
    </script>
</body>
</html>
