<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <title>{{ $livre->titre }} - Lecture Sécurisée</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* SYSTÈME DE PROTECTION ANTI-CAPTURE ULTRA-SÉCURISÉ */
        * {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
            -webkit-touch-callout: none !important;
            -webkit-tap-highlight-color: transparent !important;
        }

        @media print {
            html, body { display: none !important; visibility: hidden !important; }
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #0a0a0a;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            -webkit-user-drag: none;
        }

        .protection-overlay {
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 10000;
            pointer-events: none;
            background: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255,0,0,0.001) 10px, rgba(255,0,0,0.001) 20px);
        }

        #pdf-container {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: #0a0a0a;
            display: flex;
            flex-direction: column;
            z-index: 1;
        }

        .pdf-header {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            padding: 12px 20px;
            color: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            z-index: 100;
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
            font-size: 1rem;
            font-weight: 600;
        }

        .security-badge {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            background: rgba(0,255,0,0.2);
            padding: 4px 10px;
            border-radius: 15px;
            color: #00ff00;
        }

        .security-badge.danger {
            background: rgba(255,0,0,0.3);
            color: #ff4444;
            animation: pulse 1s infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .pdf-controls {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .pdf-controls button, .pdf-controls a {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            text-decoration: none;
        }

        .pdf-controls button:hover:not(:disabled), .pdf-controls a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }

        .pdf-controls button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-close-reader {
            background: rgba(220,53,69,0.8) !important;
            border-color: rgba(220,53,69,1) !important;
        }

        #page-info {
            background: rgba(255,255,255,0.1);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
        }

        #canvas-container {
            flex: 1;
            overflow: auto;
            background: #0d1117;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            position: relative;
        }

        .canvas-wrapper {
            position: relative;
            display: inline-block;
        }

        #pdf-canvas {
            box-shadow: 0 10px 40px rgba(0,0,0,0.7);
            background: white;
            max-width: 100%;
            height: auto;
        }

        .watermark-layer {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            pointer-events: none;
            z-index: 100;
            overflow: hidden;
        }

        .watermark-text {
            position: absolute;
            font-size: 12px;
            color: rgba(220, 53, 69, 0.1);
            font-weight: 900;
            transform: rotate(-45deg);
            white-space: nowrap;
            letter-spacing: 2px;
            font-family: monospace;
        }

        .user-watermark {
            position: absolute;
            font-size: 9px;
            color: rgba(0, 100, 200, 0.07);
            font-weight: bold;
            white-space: nowrap;
        }

        .user-badge {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 10px 16px;
            border-radius: 25px;
            font-size: 11px;
            box-shadow: 0 4px 20px rgba(220, 53, 69, 0.4);
            z-index: 999;
            pointer-events: none;
        }

        .screenshot-blocker {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #000;
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999999;
            color: white;
            flex-direction: column;
            gap: 20px;
        }

        .screenshot-blocker.active {
            display: flex !important;
        }

        .screenshot-blocker .icon {
            font-size: 80px;
            color: #dc3545;
            animation: shake 0.5s infinite;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .devtools-blocker {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #000;
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999999;
            color: white;
            flex-direction: column;
            gap: 20px;
        }

        .devtools-blocker.active {
            display: flex !important;
        }

        .loading-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: #0a0a0a;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            flex-direction: column;
            gap: 20px;
        }

        .spinner {
            border: 4px solid rgba(255,255,255,0.1);
            border-top: 4px solid #4CAF50;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .pdf-header { padding: 10px 15px; }
            .pdf-info h1 { font-size: 0.85rem; }
            .pdf-controls button, .pdf-controls a { padding: 6px 10px; font-size: 11px; }
            .btn-text { display: none; }
            .security-badge { font-size: 0.6rem; padding: 3px 6px; }
            .user-badge { bottom: 10px; right: 10px; padding: 6px 12px; font-size: 9px; }
        }
    </style>
</head>
<body>
    <div class="protection-overlay"></div>

    <div class="loading-overlay" id="loading">
        <div class="spinner"></div>
        <div style="color:white;font-size:14px;">Chargement sécurisé...</div>
        <div style="color:#00ff00;font-size:11px;" id="security-check">
            <i class="fas fa-shield-alt"></i> Vérification de sécurité...
        </div>
    </div>

    <div class="screenshot-blocker" id="screenshot-blocker">
        <i class="fas fa-ban icon"></i>
        <h2 style="margin:0;">CAPTURE INTERDITE</h2>
        <p style="margin:0;opacity:0.7;">Les captures d'écran sont strictement interdites</p>
        <div style="font-size:12px;opacity:0.4;">Tentative #<span id="attempt-count">1</span> enregistrée</div>
    </div>

    <div class="devtools-blocker" id="devtools-blocker">
        <i class="fas fa-code" style="font-size:60px;color:#dc3545;"></i>
        <h2 style="margin:0;">ACCÈS REFUSÉ</h2>
        <p style="margin:0;opacity:0.7;">Les outils de développement sont désactivés</p>
    </div>

    <div id="pdf-container">
        <div class="pdf-header">
            <div class="pdf-info">
                <i class="fas fa-book-reader" style="font-size:1.5rem;color:#4CAF50;"></i>
                <div>
                    <h1><i class="fas fa-lock me-2" style="font-size:0.8rem;"></i>{{ $livre->titre }}</h1>
                    @if($livre->auteur)
                        <small style="opacity:0.7;">Par {{ $livre->auteur }}</small>
                    @endif
                </div>
            </div>
            <div class="security-badge" id="security-status">
                <i class="fas fa-shield-alt"></i>
                <span>Protection Active</span>
            </div>
            <div class="pdf-controls">
                <button id="prev-page" disabled title="Page précédente">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <span id="page-info"><span id="page-num">1</span> / <span id="page-count">--</span></span>
                <button id="next-page" disabled title="Page suivante">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <button id="zoom-out" title="Zoom -">
                    <i class="fas fa-search-minus"></i>
                </button>
                <span style="font-size:11px;min-width:40px;text-align:center;" id="zoom-level">100%</span>
                <button id="zoom-in" title="Zoom +">
                    <i class="fas fa-search-plus"></i>
                </button>
                <a href="{{ route('account.bibliotheque') }}" class="btn-close-reader">
                    <i class="fas fa-times"></i>
                    <span class="btn-text">Fermer</span>
                </a>
            </div>
        </div>

        <div id="canvas-container">
            <div class="canvas-wrapper">
                <canvas id="pdf-canvas"></canvas>
                <div class="watermark-layer" id="watermark-layer"></div>
            </div>
        </div>

        <div class="user-badge">
            <i class="fas fa-user me-1"></i>
            {{ $user->name }} | <span id="current-time"></span>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
    (function() {
        'use strict';

        const CONFIG = {
            userId: {{ $user->id }},
            userName: '{{ $user->name }}',
            userEmail: '{{ $user->email }}',
            livreId: {{ $livre->id }},
            sessionId: '{{ session()->getId() }}',
            csrfToken: '{{ csrf_token() }}',
            logEndpoint: '/api/security/log-attempt',
            maxAttempts: 5,
            pdfUrl: '{{ route("bibliotheque.serve-pdf", ["catalogue" => $livre->id, "token" => $token]) }}'
        };

        let state = {
            screenshotAttempts: 0,
            isBlocked: false,
            devToolsOpen: false,
            pageNum: 1,
            scale: 1.5,
            pdfDoc: null,
            pageRendering: false,
            pageNumPending: null
        };

        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        const el = {
            loading: document.getElementById('loading'),
            screenshotBlocker: document.getElementById('screenshot-blocker'),
            devtoolsBlocker: document.getElementById('devtools-blocker'),
            securityStatus: document.getElementById('security-status'),
            securityCheck: document.getElementById('security-check'),
            attemptCount: document.getElementById('attempt-count'),
            canvas: document.getElementById('pdf-canvas'),
            canvasContainer: document.getElementById('canvas-container'),
            watermarkLayer: document.getElementById('watermark-layer'),
            prevBtn: document.getElementById('prev-page'),
            nextBtn: document.getElementById('next-page'),
            zoomInBtn: document.getElementById('zoom-in'),
            zoomOutBtn: document.getElementById('zoom-out'),
            zoomLevel: document.getElementById('zoom-level'),
            pageNum: document.getElementById('page-num'),
            pageCount: document.getElementById('page-count')
        };

        const ctx = el.canvas.getContext('2d');

        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        function logAttempt(type, details = {}) {
            fetch(CONFIG.logEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CONFIG.csrfToken
                },
                body: JSON.stringify({
                    type: type,
                    user_id: CONFIG.userId,
                    user_name: CONFIG.userName,
                    contenu_id: CONFIG.livreId,
                    session_id: CONFIG.sessionId,
                    details: details
                })
            }).catch(() => {});
        }

        function showScreenshotBlocker(reason) {
            if (state.isBlocked) return;
            state.screenshotAttempts++;
            el.attemptCount.textContent = state.screenshotAttempts;
            el.screenshotBlocker.classList.add('active');

            if (navigator.vibrate) navigator.vibrate([100, 50, 100, 50, 200]);

            logAttempt('screenshot_attempt', { reason: reason, attempt: state.screenshotAttempts });
            updateSecurityStatus('danger', 'Capture détectée!');
            clearClipboard();

            setTimeout(() => {
                el.screenshotBlocker.classList.remove('active');
                updateSecurityStatus('normal', 'Protection Active');
            }, 3000);

            if (state.screenshotAttempts >= CONFIG.maxAttempts) {
                blockAccess();
            }
        }

        function blockAccess() {
            state.isBlocked = true;
            logAttempt('access_blocked', { total_attempts: state.screenshotAttempts });
            document.body.innerHTML = `
                <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;background:#000;color:#dc3545;text-align:center;padding:20px;">
                    <i class="fas fa-ban" style="font-size:100px;margin-bottom:30px;"></i>
                    <h1>ACCÈS RÉVOQUÉ</h1>
                    <p style="color:#fff;opacity:0.7;">Trop de tentatives de capture détectées.</p>
                </div>
            `;
        }

        function updateSecurityStatus(level, text) {
            el.securityStatus.className = 'security-badge';
            if (level === 'danger') el.securityStatus.classList.add('danger');
            el.securityStatus.innerHTML = `<i class="fas fa-shield-alt"></i><span>${text}</span>`;
        }

        function clearClipboard() {
            try {
                if (navigator.clipboard) navigator.clipboard.writeText('').catch(() => {});
            } catch(e) {}
        }

        function detectDevTools() {
            const threshold = 160;
            return (window.outerWidth - window.innerWidth > threshold) ||
                   (window.outerHeight - window.innerHeight > threshold);
        }

        setInterval(() => {
            const isOpen = detectDevTools();
            if (isOpen && !state.devToolsOpen) {
                state.devToolsOpen = true;
                el.devtoolsBlocker.classList.add('active');
                logAttempt('devtools_opened');
            } else if (!isOpen && state.devToolsOpen) {
                state.devToolsOpen = false;
                el.devtoolsBlocker.classList.remove('active');
            }
        }, 500);

        document.addEventListener('keydown', function(e) {
            const key = e.key.toLowerCase();
            const code = e.keyCode || e.which;

            if (code === 44 || key === 'printscreen') {
                e.preventDefault();
                showScreenshotBlocker('PrintScreen');
                clearClipboard();
                return false;
            }
            if ((e.metaKey || e.key === 'Meta') && e.shiftKey && key === 's') {
                e.preventDefault();
                showScreenshotBlocker('Snipping Tool');
                return false;
            }
            if ((e.ctrlKey || e.metaKey) && key === 'p') {
                e.preventDefault();
                showScreenshotBlocker('Print');
                return false;
            }
            if ((e.ctrlKey || e.metaKey) && key === 's') {
                e.preventDefault();
                showScreenshotBlocker('Save');
                return false;
            }
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && (key === 'i' || key === 'j' || key === 'c')) {
                e.preventDefault();
                return false;
            }
            if (code === 123 || key === 'f12') {
                e.preventDefault();
                return false;
            }
            if (e.metaKey && e.shiftKey && (key === '3' || key === '4' || key === '5')) {
                e.preventDefault();
                showScreenshotBlocker('Mac Screenshot');
                return false;
            }
        }, true);

        document.addEventListener('keyup', function(e) {
            if (e.keyCode === 44) {
                clearClipboard();
                showScreenshotBlocker('PrintScreen KeyUp');
            }
        }, true);

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                showScreenshotBlocker('visibility_hidden');
                el.canvas.style.filter = 'brightness(0)';
            } else {
                el.canvas.style.filter = 'none';
            }
        });

        let blurTimeout;
        window.addEventListener('blur', function() {
            blurTimeout = setTimeout(() => showScreenshotBlocker('window_blur'), 100);
        });
        window.addEventListener('focus', function() { clearTimeout(blurTimeout); });

        document.addEventListener('contextmenu', e => e.preventDefault());
        document.addEventListener('copy', e => { e.preventDefault(); return false; });
        document.addEventListener('cut', e => e.preventDefault());
        document.addEventListener('dragstart', e => e.preventDefault());

        if (isMobile) {
            state.scale = 1.2;
            let longPressTimer;
            document.addEventListener('touchstart', function(e) {
                longPressTimer = setTimeout(() => {
                    e.preventDefault();
                    if (navigator.vibrate) navigator.vibrate(50);
                }, 500);
            }, { passive: false });
            document.addEventListener('touchend', () => clearTimeout(longPressTimer));
            document.addEventListener('touchmove', () => clearTimeout(longPressTimer));

            if ('onfreeze' in document) {
                document.addEventListener('freeze', () => showScreenshotBlocker('page_freeze'));
            }
            window.addEventListener('pagehide', function(e) {
                if (!e.persisted) showScreenshotBlocker('page_hide');
            });
        }

        setInterval(clearClipboard, 2000);

        function generateWatermarks() {
            el.watermarkLayer.innerHTML = '';
            const w = el.canvas.width, h = el.canvas.height;
            const rows = Math.ceil(h / 100), cols = Math.ceil(w / 250);

            for (let row = 0; row < rows; row++) {
                for (let col = 0; col < cols; col++) {
                    const wm = document.createElement('div');
                    wm.className = 'watermark-text';
                    wm.style.top = (row * 100 + 20) + 'px';
                    wm.style.left = (col * 250 + (row % 2 ? 80 : 0)) + 'px';
                    wm.textContent = 'COLIBRI LITTÉRAIRE';
                    el.watermarkLayer.appendChild(wm);
                }
            }

            const uwmCount = Math.ceil(h / 180);
            const emailPart = CONFIG.userEmail ? CONFIG.userEmail.substring(0, 10) + '...' : CONFIG.userName;
            for (let i = 0; i < uwmCount; i++) {
                const uwm = document.createElement('div');
                uwm.className = 'user-watermark';
                uwm.style.top = (i * 180 + 60) + 'px';
                uwm.style.left = '15px';
                uwm.textContent = `${emailPart} | ${new Date().toLocaleString()}`;
                el.watermarkLayer.appendChild(uwm);
            }
        }

        function renderPage(num) {
            state.pageRendering = true;

            state.pdfDoc.getPage(num).then(page => {
                let viewport = page.getViewport({ scale: state.scale });

                if (isMobile) {
                    const containerWidth = el.canvasContainer.clientWidth - 40;
                    const scaleToFit = containerWidth / viewport.width;
                    viewport = page.getViewport({ scale: Math.min(scaleToFit, state.scale) });
                }

                el.canvas.height = viewport.height;
                el.canvas.width = viewport.width;

                page.render({ canvasContext: ctx, viewport: viewport }).promise.then(() => {
                    state.pageRendering = false;
                    el.loading.style.display = 'none';
                    generateWatermarks();

                    if (state.pageNumPending !== null) {
                        renderPage(state.pageNumPending);
                        state.pageNumPending = null;
                    }
                });

                el.pageNum.textContent = num;
                updateButtons();
            });
        }

        function queueRenderPage(num) {
            if (state.pageRendering) {
                state.pageNumPending = num;
            } else {
                renderPage(num);
            }
        }

        function updateButtons() {
            el.prevBtn.disabled = (state.pageNum <= 1);
            el.nextBtn.disabled = (state.pageNum >= state.pdfDoc.numPages);
        }

        el.prevBtn.addEventListener('click', () => {
            if (state.pageNum <= 1) return;
            state.pageNum--;
            queueRenderPage(state.pageNum);
        });

        el.nextBtn.addEventListener('click', () => {
            if (state.pageNum >= state.pdfDoc.numPages) return;
            state.pageNum++;
            queueRenderPage(state.pageNum);
        });

        el.zoomInBtn.addEventListener('click', () => {
            state.scale += 0.25;
            el.zoomLevel.textContent = Math.round(state.scale * 100) + '%';
            queueRenderPage(state.pageNum);
        });

        el.zoomOutBtn.addEventListener('click', () => {
            if (state.scale > 0.5) {
                state.scale -= 0.25;
                el.zoomLevel.textContent = Math.round(state.scale * 100) + '%';
                queueRenderPage(state.pageNum);
            }
        });

        setInterval(() => {
            document.getElementById('current-time').textContent = new Date().toLocaleTimeString();
        }, 1000);

        function init() {
            el.securityCheck.innerHTML = '<i class="fas fa-check-circle"></i> Sécurité vérifiée';

            // Utiliser l'URL sécurisée avec token
            const pdfUrl = CONFIG.pdfUrl;

            pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
                state.pdfDoc = pdf;
                el.pageCount.textContent = pdf.numPages;
                logAttempt('document_loaded');
                setTimeout(() => renderPage(state.pageNum), 500);
            }).catch(err => {
                console.error('Erreur PDF:', err);
                el.loading.innerHTML = `
                    <div style="color:#dc3545;text-align:center;">
                        <i class="fas fa-exclamation-triangle" style="font-size:50px;margin-bottom:20px;"></i>
                        <p>Erreur de chargement</p>
                        <button onclick="location.reload()" style="padding:10px 20px;background:#dc3545;color:#fff;border:none;border-radius:5px;cursor:pointer;">
                            Réessayer
                        </button>
                    </div>
                `;
            });
        }

        // Désactiver console
        ['log', 'debug', 'info', 'warn', 'error', 'table', 'trace'].forEach(m => { console[m] = () => {}; });

        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(init, 1000);
        });

        if (window.top !== window.self) {
            window.top.location = window.self.location;
        }
    })();
    </script>
</body>
</html>
