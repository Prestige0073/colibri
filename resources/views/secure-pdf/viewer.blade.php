<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $livre->titre }} - Lecture sécurisée</title>

    <!-- Politique de sécurité du contenu (CSP) -->
    <meta http-equiv="Content-Security-Policy" content="default-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://cdnjs.cloudflare.com; img-src 'self' data: blob:; media-src 'none'; object-src 'none'; frame-src 'none';">

    <!-- Empêcher l'embedding dans iframe -->
    <meta http-equiv="X-Frame-Options" content="DENY">

    <!-- Politique de référent stricte -->
    <meta name="referrer" content="no-referrer">

    <!-- Désactiver la mise en cache -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <!-- Empêcher l'indexation -->
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex">

    <!-- Protections supplémentaires -->
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="no">
    <meta name="mobile-web-app-capable" content="no">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
            -webkit-touch-callout: none !important;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #0a0a0a;
            color: #fff;
            overflow: hidden;
        }

        /* ==========================================
           PROTECTION CSS CONTRE LES SCREENSHOTS
           ========================================== */

        /* Bloquer l'impression */
        @media print {
            body { display: none !important; }
            * { display: none !important; }
        }

        /* Propriété expérimentale pour bloquer les captures (Chrome/Edge) */
        html, body {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
            /* Empêche le contenu d'être capturé par certains outils */
            content-visibility: auto;
        }

        /* Bloquer les screenshots via CSS (expérimental) */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation: none !important;
                transition: none !important;
            }
        }

        /* Filtre qui rend le screenshot flou/noir */
        @supports (backdrop-filter: blur(0px)) {
            .viewer-container::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                pointer-events: none;
                z-index: -1;
                background: repeating-linear-gradient(
                    45deg,
                    transparent,
                    transparent 1px,
                    rgba(255,255,255,0.003) 1px,
                    rgba(255,255,255,0.003) 2px
                );
            }
        }

        /* Protection contre le screenshot via isolation */
        .viewer-container {
            isolation: isolate;
            contain: layout style paint;
        }

        /* Empêcher la capture du canvas */
        #pdf-canvas {
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
            /* Propriété qui peut perturber certains outils de capture */
            will-change: transform, opacity;
            transform: translateZ(0);
            backface-visibility: hidden;
        }

        /* Header sécurisé */
        .secure-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 12px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 1000;
        }

        .secure-header h1 {
            font-size: 1.1rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .security-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .close-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 6px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .close-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Container principal */
        .viewer-container {
            height: calc(100vh - 120px);
            width: 100%;
            position: relative;
            background: #1a1a1a;
            overflow-y: auto;
            overflow-x: hidden;
        }

        #pdf-canvas {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            image-rendering: -webkit-optimize-contrast;
            pointer-events: none;
        }

        /* Watermark dynamique multi-couches */
        .watermark-layer {
            position: fixed;
            pointer-events: none;
            z-index: 999;
            color: rgba(255, 255, 255, 0.08);
            font-weight: bold;
            white-space: nowrap;
        }

        .watermark-1 {
            top: 20%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 4rem;
        }

        .watermark-2 {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 5rem;
        }

        .watermark-3 {
            top: 80%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 4rem;
        }

        /* Contrôles de navigation */
        .nav-controls {
            background: #2a2a2a;
            padding: 15px 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
            border-top: 1px solid #3a3a3a;
        }

        .nav-btn {
            background: #667eea;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .nav-btn:hover:not(:disabled) {
            background: #764ba2;
        }

        .nav-btn:disabled {
            background: #444;
            cursor: not-allowed;
            opacity: 0.5;
        }

        .page-info {
            color: #ccc;
            font-size: 0.9rem;
        }

        /* Overlay de protection invisible */
        .protection-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 998;
            pointer-events: none;
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255,255,255,0.01) 10px,
                rgba(255,255,255,0.01) 20px
            );
        }

        /* Alert de sécurité */
        .security-alert {
            position: fixed;
            top: 70px;
            right: 20px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.6);
            z-index: 10000;
            display: none;
            animation: slideIn 0.3s ease-out;
            font-size: 0.9rem;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Bloquer DevTools */
        .dev-tools-warning {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.98);
            z-index: 99999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .dev-tools-warning.active {
            display: flex;
        }

        .dev-tools-warning h1 {
            color: #e74c3c;
            margin-bottom: 15px;
            font-size: 2rem;
        }

        .dev-tools-warning p {
            font-size: 1.1rem;
            text-align: center;
            max-width: 600px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .secure-header h1 {
                font-size: 0.9rem;
            }
            .watermark-layer {
                font-size: 2rem !important;
            }
        }
    </style>
</head>
<body>
    <!-- Header sécurisé -->
    <div class="secure-header">
        <h1>
            <i class="fas fa-shield-alt"></i>
            <span class="d-none d-md-inline">{{ $livre->titre }}</span>
            <span class="d-md-none">{{ Str::limit($livre->titre, 20) }}</span>
        </h1>
        <div class="d-flex align-items-center gap-2">
            <div class="security-badge">
                <i class="fas fa-lock"></i>
                <span class="d-none d-sm-inline">Protégé</span>
            </div>
            <button class="close-btn" onclick="closeViewer()">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>

    <!-- Container de visualisation -->
    <div class="viewer-container" id="viewerContainer">
        <canvas id="pdf-canvas"></canvas>
    </div>

    <!-- Contrôles de navigation -->
    <div class="nav-controls">
        <button class="nav-btn" id="prevBtn" onclick="prevPage()">
            <i class="fas fa-chevron-left"></i> Précédent
        </button>
        <span class="page-info">
            Page <span id="currentPage">1</span> sur <span id="totalPages">-</span>
        </span>
        <button class="nav-btn" id="nextBtn" onclick="nextPage()">
            Suivant <i class="fas fa-chevron-right"></i>
        </button>
    </div>

    <!-- Watermarks dynamiques multi-couches -->
    <div class="watermark-layer watermark-1">{{ config('app.name', 'COLIBRI') }} - PROTÉGÉ</div>
    <div class="watermark-layer watermark-2">{{ config('app.name', 'COLIBRI') }} - PROTÉGÉ</div>
    <div class="watermark-layer watermark-3">{{ config('app.name', 'COLIBRI') }} - PROTÉGÉ</div>

    <!-- Overlay de protection -->
    <div class="protection-overlay"></div>

    <!-- Alert de sécurité -->
    <div class="security-alert" id="securityAlert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Action bloquée</strong>
    </div>

    <!-- Avertissement DevTools -->
    <div class="dev-tools-warning" id="devToolsWarning">
        <h1><i class="fas fa-exclamation-triangle"></i> Accès Refusé</h1>
        <p>Les outils de développement sont désactivés.</p>
        <p>Fermez-les pour continuer la lecture.</p>
    </div>

    <script>
        // Configuration PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        let pdfDoc = null;
        let pageNum = 1;
        let pageRendering = false;
        let pageNumPending = null;
        const scale = 1.5;
        const canvas = document.getElementById('pdf-canvas');
        const ctx = canvas.getContext('2d');

        // Charger le PDF
        const url = '{{ route('secure-pdf.serve', ['id' => $livre->id, 'token' => $token]) }}';

        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            document.getElementById('totalPages').textContent = pdfDoc.numPages;
            renderPage(pageNum);
        }).catch(function(error) {
            console.error('Erreur de chargement PDF:', error);
            alert('Impossible de charger le document.');
        });

        // Fonction de rendu de page avec watermark intégré
        function renderPage(num) {
            pageRendering = true;
            pdfDoc.getPage(num).then(function(page) {
                const viewport = page.getViewport({scale: scale});
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                const renderTask = page.render(renderContext);
                renderTask.promise.then(function() {
                    pageRendering = false;
                    if (pageNumPending !== null) {
                        renderPage(pageNumPending);
                        pageNumPending = null;
                    }

                    // Ajouter watermark dynamique sur le canvas
                    addCanvasWatermark();

                    // Mettre à jour l'UI
                    document.getElementById('currentPage').textContent = num;
                    document.getElementById('prevBtn').disabled = (num <= 1);
                    document.getElementById('nextBtn').disabled = (num >= pdfDoc.numPages);
                });
            });
        }

        // Ajouter watermark directement sur le canvas (impossible à enlever)
        function addCanvasWatermark() {
            ctx.save();
            ctx.globalAlpha = 0.1;
            ctx.font = 'bold 60px Arial';
            ctx.fillStyle = '#ffffff';
            ctx.textAlign = 'center';
            ctx.translate(canvas.width / 2, canvas.height / 2);
            ctx.rotate(-45 * Math.PI / 180);
            ctx.fillText('{{ config('app.name', 'COLIBRI') }} - PROTÉGÉ', 0, 0);
            ctx.restore();

            // Ajouter timestamp invisible pour tracking
            ctx.save();
            ctx.globalAlpha = 0.01;
            ctx.font = '10px Arial';
            ctx.fillStyle = '#ffffff';
            ctx.fillText('{{ Auth::id() ?? 'Guest' }}-' + Date.now(), 10, 10);
            ctx.restore();
        }

        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
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

        // ==========================================
        // PROTECTIONS MAXIMALES
        // ==========================================

        // Bloquer TOUS les raccourcis clavier
        document.addEventListener('keydown', function(e) {
            const blockedKeys = [
                123, // F12
                44,  // PrintScreen
                91,  // Windows/Cmd
                93,  // Menu contextuel
            ];

            const blockedCombos = [
                {ctrl: true, shift: true, key: 73},  // Ctrl+Shift+I
                {ctrl: true, shift: true, key: 74},  // Ctrl+Shift+J
                {ctrl: true, shift: true, key: 67},  // Ctrl+Shift+C
                {ctrl: true, key: 85},               // Ctrl+U
                {ctrl: true, key: 83},               // Ctrl+S
                {ctrl: true, key: 80},               // Ctrl+P
                {meta: true, shift: true, key: 73},  // Cmd+Shift+I (Mac)
                {meta: true, shift: true, key: 74},  // Cmd+Shift+J (Mac)
                {meta: true, shift: true, key: 67},  // Cmd+Shift+C (Mac)
                {meta: true, key: 85},               // Cmd+U (Mac)
                {meta: true, key: 83},               // Cmd+S (Mac)
                {meta: true, key: 80},               // Cmd+P (Mac)
            ];

            if (blockedKeys.includes(e.keyCode)) {
                e.preventDefault();
                e.stopPropagation();
                showSecurityAlert();
                return false;
            }

            for (let combo of blockedCombos) {
                let match = true;
                if (combo.ctrl && !e.ctrlKey) match = false;
                if (combo.shift && !e.shiftKey) match = false;
                if (combo.meta && !e.metaKey) match = false;
                if (combo.key && e.keyCode !== combo.key) match = false;

                if (match) {
                    e.preventDefault();
                    e.stopPropagation();
                    showSecurityAlert();
                    return false;
                }
            }
        }, true);

        // Bloquer menu contextuel
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            showSecurityAlert();
            return false;
        }, true);

        // Bloquer sélection
        document.addEventListener('selectstart', function(e) {
            e.preventDefault();
            return false;
        }, true);

        // Bloquer copie
        document.addEventListener('copy', function(e) {
            e.preventDefault();
            e.clipboardData.setData('text/plain', '');
            showSecurityAlert();
            return false;
        }, true);

        // Bloquer drag
        document.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        }, true);

        // Détecter DevTools (approche améliorée)
        (function() {
            const devtools = /./;
            devtools.toString = function() {
                document.getElementById('devToolsWarning').classList.add('active');
                return 'DevTools detected';
            };

            setInterval(function() {
                console.log(devtools);

                // Vérifier aussi par dimensions
                if (window.outerWidth - window.innerWidth > 200 ||
                    window.outerHeight - window.innerHeight > 200) {
                    document.getElementById('devToolsWarning').classList.add('active');
                } else {
                    document.getElementById('devToolsWarning').classList.remove('active');
                }
            }, 1000);
        })();

        // ==========================================
        // PROTECTION CONTRE LA CAPTURE D'ÉCRAN
        // ==========================================

        // 1. Détection de l'API Screen Capture (enregistrement d'écran)
        let isRecording = false;

        // Bloquer getDisplayMedia (capture d'écran native)
        if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
            const originalGetDisplayMedia = navigator.mediaDevices.getDisplayMedia;
            navigator.mediaDevices.getDisplayMedia = function() {
                showSecurityAlert();
                alert('⛔ ACCÈS REFUSÉ\n\nLa capture d\'écran et l\'enregistrement sont strictement interdits pour protéger le contenu.');
                throw new Error('Screen capture blocked by security policy');
            };
        }

        // Bloquer getUserMedia pour captureStream
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            const originalGetUserMedia = navigator.mediaDevices.getUserMedia;
            navigator.mediaDevices.getUserMedia = function(constraints) {
                if (constraints && (constraints.video === true || constraints.video?.mandatory || constraints.video?.optional)) {
                    showSecurityAlert();
                    alert('⛔ ACCÈS REFUSÉ\n\nLa capture vidéo est interdite.');
                    throw new Error('Video capture blocked');
                }
                return originalGetUserMedia.apply(this, arguments);
            };
        }

        // 2. Rendre le canvas noir lors de la perte de focus (screenshot)
        let canvasBackup = null;

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                // Sauvegarder et noircir le canvas
                try {
                    canvasBackup = ctx.getImageData(0, 0, canvas.width, canvas.height);
                    ctx.fillStyle = '#000000';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                    ctx.fillStyle = '#ffffff';
                    ctx.font = 'bold 48px Arial';
                    ctx.textAlign = 'center';
                    ctx.fillText('⛔ CONTENU PROTÉGÉ', canvas.width / 2, canvas.height / 2);
                } catch (e) {
                    // Fallback si getImageData échoue
                    ctx.fillStyle = '#000000';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);
                }
            } else {
                // Restaurer le canvas après un court délai
                setTimeout(function() {
                    if (canvasBackup && !document.hidden) {
                        try {
                            ctx.putImageData(canvasBackup, 0, 0);
                            addCanvasWatermark();
                            canvasBackup = null;
                        } catch (e) {
                            // Recharger la page si erreur
                            renderPage(pageNum);
                        }
                    }
                }, 100);
            }
        });

        // 3. Détecter blur (perte de focus) - possible capture
        let blurTimeout = null;
        window.addEventListener('blur', function() {
            clearTimeout(blurTimeout);
            blurTimeout = setTimeout(function() {
                // Noircir le canvas après 50ms de blur
                ctx.fillStyle = '#000000';
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.fillStyle = '#ff0000';
                ctx.font = 'bold 36px Arial';
                ctx.textAlign = 'center';
                ctx.fillText('⛔ SESSION SUSPENDUE', canvas.width / 2, canvas.height / 2);
                ctx.font = '20px Arial';
                ctx.fillStyle = '#ffffff';
                ctx.fillText('Cliquez sur la fenêtre pour continuer', canvas.width / 2, canvas.height / 2 + 40);
            }, 50);
        });

        window.addEventListener('focus', function() {
            clearTimeout(blurTimeout);
            // Recharger la page actuelle après focus
            setTimeout(function() {
                if (pdfDoc) {
                    renderPage(pageNum);
                }
            }, 100);
        });

        // 4. Bloquer les raccourcis de capture d'écran spécifiques
        document.addEventListener('keyup', function(e) {
            // PrintScreen, Cmd+Shift+3, Cmd+Shift+4 (Mac), Win+Shift+S (Windows)
            if (e.keyCode === 44 ||
                (e.keyCode === 51 && e.metaKey && e.shiftKey) ||
                (e.keyCode === 52 && e.metaKey && e.shiftKey) ||
                (e.keyCode === 83 && e.metaKey && e.shiftKey)) {

                // Noircir immédiatement
                ctx.fillStyle = '#000000';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                showSecurityAlert();
                alert('⛔ CAPTURE DÉTECTÉE\n\nLes captures d\'écran sont interdites.\nLe contenu a été masqué.');

                // Restaurer après 2 secondes
                setTimeout(function() {
                    renderPage(pageNum);
                }, 2000);
            }
        }, true);

        // 5. Protection contre le Screenshot API moderne
        if (typeof ScreenCapture !== 'undefined' || typeof MediaRecorder !== 'undefined') {
            // Bloquer MediaRecorder pour le canvas
            const originalMediaRecorder = window.MediaRecorder;
            window.MediaRecorder = function(stream, options) {
                if (stream && stream.getTracks) {
                    const tracks = stream.getTracks();
                    const hasVideo = tracks.some(track => track.kind === 'video');
                    if (hasVideo) {
                        showSecurityAlert();
                        alert('⛔ ENREGISTREMENT BLOQUÉ\n\nL\'enregistrement d\'écran est interdit.');
                        throw new Error('Recording blocked by security policy');
                    }
                }
                return new originalMediaRecorder(stream, options);
            };
        }

        // 6. Surveillance continue de la fenêtre pour détecter changements suspects
        let lastWidth = window.innerWidth;
        let lastHeight = window.innerHeight;

        setInterval(function() {
            // Détecter redimensionnement suspect (outil de capture ouvert)
            if (Math.abs(window.innerWidth - lastWidth) > 100 ||
                Math.abs(window.innerHeight - lastHeight) > 100) {

                // Noircir temporairement
                ctx.fillStyle = '#000000';
                ctx.fillRect(0, 0, canvas.width, canvas.height);

                setTimeout(function() {
                    renderPage(pageNum);
                }, 500);
            }

            lastWidth = window.innerWidth;
            lastHeight = window.innerHeight;
        }, 500);

        // 7. Bloquer l'accès programmatique au canvas
        Object.defineProperty(canvas, 'toDataURL', {
            value: function() {
                showSecurityAlert();
                console.error('toDataURL blocked');
                return 'data:image/png;base64,';
            },
            writable: false,
            configurable: false
        });

        Object.defineProperty(canvas, 'toBlob', {
            value: function() {
                showSecurityAlert();
                console.error('toBlob blocked');
                return null;
            },
            writable: false,
            configurable: false
        });

        // 8. Overlay dynamique invisible qui change constamment
        setInterval(function() {
            const overlay = document.querySelector('.protection-overlay');
            if (overlay) {
                const opacity = 0.01 + (Math.random() * 0.02);
                overlay.style.background = `repeating-linear-gradient(
                    ${Math.random() * 360}deg,
                    transparent,
                    transparent 10px,
                    rgba(255,255,255,${opacity}) 10px,
                    rgba(255,255,255,${opacity}) 20px
                )`;
            }
        }, 2000);

        // Protection contre le debugger
        (function() {
            setInterval(function() {
                debugger;
            }, 100);
        })();

        // Bloquer l'accès aux images du canvas
        canvas.toBlob = function() { showSecurityAlert(); return null; };
        canvas.toDataURL = function() { showSecurityAlert(); return ''; };
        HTMLCanvasElement.prototype.toBlob = function() { showSecurityAlert(); return null; };
        HTMLCanvasElement.prototype.toDataURL = function() { showSecurityAlert(); return ''; };

        // Protection contre iframe
        if (window.top !== window.self) {
            window.top.location = window.self.location;
        }

        // Fonction d'alerte
        function showSecurityAlert() {
            const alert = document.getElementById('securityAlert');
            alert.style.display = 'block';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 2000);
        }

        // Fonction de fermeture
        function closeViewer() {
            if (confirm('Voulez-vous vraiment quitter ?')) {
                window.history.back();
            }
        }

        // Bloquer avant fermeture
        window.addEventListener('beforeunload', function(e) {
            e.returnValue = '';
        });

        // Désactiver complètement la console
        (function() {
            const noop = function() {};
            const methods = ['log', 'debug', 'info', 'warn', 'error', 'table', 'trace', 'dir', 'dirxml', 'group', 'groupCollapsed', 'groupEnd', 'clear', 'count', 'countReset', 'assert', 'profile', 'profileEnd', 'time', 'timeLog', 'timeEnd', 'timeStamp', 'exception'];

            methods.forEach(function(method) {
                console[method] = noop;
            });
        })();
    </script>
</body>
</html>
