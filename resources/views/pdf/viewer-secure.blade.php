<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <!-- Empêcher le cache -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- DRM et sécurité -->
    <meta name="robots" content="noindex, nofollow, noarchive, nosnippet">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <title>Document Protégé - Colibri Littéraire</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ===============================================
           SYSTÈME DE PROTECTION ANTI-CAPTURE NIVEAU MAXIMAL
           =============================================== */

        /* Désactiver toute sélection */
        * {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
            -webkit-touch-callout: none !important;
            -webkit-tap-highlight-color: transparent !important;
        }

        /* Protection CSS anti-screenshot (technique avancée) */
        html {
            /* Rend le contenu flou lors de capture via certains outils */
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Désactiver le mode impression */
        @media print {
            html, body {
                display: none !important;
                visibility: hidden !important;
            }
        }

        /* Mode picture-in-picture désactivé */
        video::-webkit-media-controls-picture-in-picture-button {
            display: none !important;
        }

        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            background: #1a1a2e;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            /* Empêche le glisser-déposer */
            -webkit-user-drag: none;
            user-drag: none;
        }

        /* Protection contre la capture via extensions */
        .secure-content {
            position: relative;
            z-index: 1;
        }

        /* Overlay de protection invisible */
        .protection-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10000;
            pointer-events: none;
            /* Pattern invisible qui apparaît sur screenshot */
            background: repeating-linear-gradient(
                45deg,
                transparent,
                transparent 10px,
                rgba(255,0,0,0.001) 10px,
                rgba(255,0,0,0.001) 20px
            );
        }

        /* Header sécurisé */
        .pdf-viewer-header {
            background: linear-gradient(135deg, #dc3545 0%, #9b2335 100%);
            color: white;
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
            z-index: 1000;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
        }

        .pdf-info h1 {
            font-size: 1rem;
            margin: 0;
            font-weight: 600;
        }

        .pdf-info small {
            font-size: 0.7rem;
            opacity: 0.8;
        }

        .security-indicator {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.7rem;
            background: rgba(0,255,0,0.2);
            padding: 3px 8px;
            border-radius: 10px;
            color: #00ff00;
        }

        .security-indicator.warning {
            background: rgba(255,165,0,0.2);
            color: #ffa500;
        }

        .security-indicator.danger {
            background: rgba(255,0,0,0.3);
            color: #ff4444;
            animation: pulse-danger 1s infinite;
        }

        @keyframes pulse-danger {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .pdf-controls {
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .pdf-controls button {
            background: rgba(255,255,255,0.15);
            border: 1px solid rgba(255,255,255,0.2);
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
        }

        .pdf-controls button:hover {
            background: rgba(255,255,255,0.25);
        }

        .pdf-controls button:active {
            transform: scale(0.95);
        }

        .btn-close-viewer {
            background: #fff !important;
            color: #dc3545 !important;
            font-weight: bold;
        }

        /* Container du PDF */
        .pdf-canvas-container {
            position: fixed;
            top: 65px;
            left: 0;
            right: 0;
            bottom: 55px;
            background: #0d1117;
            overflow: auto;
            -webkit-overflow-scrolling: touch;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 15px;
        }

        .pdf-canvas-wrapper {
            position: relative;
            display: inline-block;
            max-width: 100%;
        }

        #pdf-canvas {
            display: block;
            box-shadow: 0 10px 40px rgba(0,0,0,0.7);
            background: white;
            max-width: 100%;
            height: auto;
            /* Animation subtile pour perturber les captures */
            animation: subtle-shift 0.1s infinite alternate;
        }

        @keyframes subtle-shift {
            0% { filter: brightness(1); }
            100% { filter: brightness(0.999); }
        }

        /* Couche de watermark dynamique */
        .watermark-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 100;
            overflow: hidden;
        }

        .watermark-text {
            position: absolute;
            font-size: 14px;
            color: rgba(220, 53, 69, 0.12);
            font-weight: 900;
            transform: rotate(-45deg);
            white-space: nowrap;
            letter-spacing: 2px;
            font-family: monospace;
        }

        .watermark-user {
            position: absolute;
            font-size: 10px;
            color: rgba(0, 100, 200, 0.08);
            font-weight: bold;
            white-space: nowrap;
        }

        /* Écran de blocage capture */
        .screenshot-blocker {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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

        .screenshot-blocker .warning-icon {
            font-size: 80px;
            color: #dc3545;
            animation: shake 0.5s infinite;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        /* Footer */
        .pdf-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #ffc107;
            padding: 12px 15px;
            text-align: center;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.5);
            z-index: 1000;
            font-size: 11px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .session-info {
            font-size: 9px;
            color: rgba(255,255,255,0.5);
        }

        /* Badge utilisateur flottant */
        .user-badge-floating {
            position: fixed;
            bottom: 70px;
            right: 15px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            padding: 8px 12px;
            border-radius: 20px;
            font-size: 10px;
            z-index: 999;
            pointer-events: none;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
        }

        /* Loader */
        .pdf-loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #1a1a2e;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            flex-direction: column;
            gap: 20px;
        }

        .loader-spinner {
            width: 60px;
            height: 60px;
            border: 4px solid rgba(255,255,255,0.1);
            border-top: 4px solid #dc3545;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loader-text {
            color: white;
            font-size: 14px;
        }

        .loader-security {
            color: #00ff00;
            font-size: 11px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Écran DevTools détecté */
        .devtools-blocker {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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

        /* Mobile */
        @media (max-width: 768px) {
            .pdf-info h1 {
                font-size: 0.85rem;
            }
            .pdf-controls button {
                padding: 6px 8px;
                font-size: 11px;
            }
            .security-indicator {
                font-size: 0.6rem;
                padding: 2px 5px;
            }
            .btn-text {
                display: none;
            }
            .watermark-text {
                font-size: 10px;
            }
        }

        /* Animation pour perturber screen recording */
        .anti-record-layer {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 50;
            background: transparent;
        }

        /* Canvas de protection (invisible mais détectable en capture) */
        .hidden-protection-canvas {
            position: fixed;
            top: -9999px;
            left: -9999px;
            width: 1px;
            height: 1px;
        }
    </style>
</head>
<body>
    <!-- Overlay de protection invisible -->
    <div class="protection-overlay"></div>

    <!-- Canvas caché pour détection -->
    <canvas class="hidden-protection-canvas" id="detection-canvas"></canvas>

    <!-- Couche anti-enregistrement -->
    <div class="anti-record-layer" id="anti-record-layer"></div>

    <!-- Loader -->
    <div class="pdf-loader" id="pdf-loader">
        <div class="loader-spinner"></div>
        <div class="loader-text">Chargement sécurisé du document...</div>
        <div class="loader-security" id="security-check">
            <i class="fas fa-shield-alt"></i>
            <span>Vérification de sécurité...</span>
        </div>
    </div>

    <!-- Blocker Screenshot -->
    <div class="screenshot-blocker" id="screenshot-blocker">
        <i class="fas fa-ban warning-icon"></i>
        <h2 style="margin:0;">CAPTURE INTERDITE</h2>
        <p style="margin:0;opacity:0.8;">Les captures d'écran sont strictement interdites</p>
        <div style="font-size:12px;opacity:0.5;margin-top:10px;">
            <i class="fas fa-exclamation-triangle"></i>
            Tentative #<span id="attempt-count">1</span> enregistrée
        </div>
        <div style="font-size:11px;opacity:0.4;">
            Session: {{ session()->getId() ?? 'N/A' }}
        </div>
    </div>

    <!-- Blocker DevTools -->
    <div class="devtools-blocker" id="devtools-blocker">
        <i class="fas fa-code" style="font-size:60px;color:#dc3545;"></i>
        <h2 style="margin:0;">ACCÈS REFUSÉ</h2>
        <p style="margin:0;opacity:0.8;">Les outils de développement sont désactivés</p>
        <p style="font-size:12px;opacity:0.5;">Fermez les DevTools pour continuer</p>
    </div>

    <!-- Header -->
    <div class="pdf-viewer-header">
        <div class="pdf-info">
            <h1><i class="fas fa-lock me-2"></i>{{ $contenu->titre ?? 'Document Protégé' }}</h1>
            <small>{{ $formation->titre ?? 'Colibri Littéraire' }}</small>
        </div>
        <div class="security-indicator" id="security-status">
            <i class="fas fa-shield-alt"></i>
            <span>Protection Active</span>
        </div>
        <div class="pdf-controls">
            <button onclick="zoomOut()" title="Zoom -">
                <i class="fas fa-search-minus"></i>
            </button>
            <span id="zoom-level" style="font-size:11px;min-width:45px;text-align:center;">100%</span>
            <button onclick="zoomIn()" title="Zoom +">
                <i class="fas fa-search-plus"></i>
            </button>
            <button onclick="prevPage()" title="Page précédente">
                <i class="fas fa-chevron-left"></i>
            </button>
            <span style="font-size:11px;min-width:50px;text-align:center;">
                <span id="page-num">1</span>/<span id="page-count">-</span>
            </span>
            <button onclick="nextPage()" title="Page suivante">
                <i class="fas fa-chevron-right"></i>
            </button>
            <button class="btn-close-viewer" onclick="closeViewer()">
                <i class="fas fa-times me-1"></i><span class="btn-text">Fermer</span>
            </button>
        </div>
    </div>

    <!-- Container PDF -->
    <div class="pdf-canvas-container" id="canvas-container">
        <div class="pdf-canvas-wrapper">
            <canvas id="pdf-canvas"></canvas>
            <div class="watermark-layer" id="watermark-layer"></div>
        </div>
    </div>

    <!-- Badge utilisateur -->
    <div class="user-badge-floating" id="user-badge">
        <i class="fas fa-user me-1"></i>
        {{ $user->name ?? 'Utilisateur' }} | <span id="current-time"></span>
    </div>

    <!-- Footer -->
    <div class="pdf-footer">
        <div>
            <i class="fas fa-shield-alt me-2"></i>
            Document protégé - Copie, capture et téléchargement strictement interdits
        </div>
        <div class="session-info">
            ID: {{ substr(session()->getId() ?? 'N/A', 0, 8) }}...
            | IP: {{ request()->ip() }}
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    <script>
    (function() {
        'use strict';

        // =====================================================
        // SYSTÈME DE PROTECTION ANTI-CAPTURE NIVEAU MAXIMAL
        // Expert Cybersécurité - Colibri Littéraire
        // =====================================================

        const CONFIG = {
            userId: {{ $user->id ?? 0 }},
            userName: '{{ $user->name ?? "Inconnu" }}',
            userEmail: '{{ $user->email ?? "" }}',
            contenuId: {{ $contenu->id ?? 0 }},
            sessionId: '{{ session()->getId() ?? "unknown" }}',
            csrfToken: '{{ csrf_token() }}',
            logEndpoint: '/api/security/log-attempt',
            maxAttempts: 5,
            blockDuration: 30000,
            pdfUrl: '{{ route("pdf.viewer.serve", ["formation" => $formation->id, "module" => $module->id, "contenu" => $contenu->id, "token" => $token]) }}'
        };

        let state = {
            screenshotAttempts: 0,
            isBlocked: false,
            devToolsOpen: false,
            lastActivity: Date.now(),
            pageNum: 1,
            scale: 1.5,
            pdfDoc: null,
            pageIsRendering: false,
            pageNumIsPending: null
        };

        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent);
        const isAndroid = /Android/i.test(navigator.userAgent);

        // ===== ÉLÉMENTS DOM =====
        const elements = {
            loader: document.getElementById('pdf-loader'),
            screenshotBlocker: document.getElementById('screenshot-blocker'),
            devtoolsBlocker: document.getElementById('devtools-blocker'),
            securityStatus: document.getElementById('security-status'),
            securityCheck: document.getElementById('security-check'),
            attemptCount: document.getElementById('attempt-count'),
            canvas: document.getElementById('pdf-canvas'),
            canvasContainer: document.getElementById('canvas-container'),
            watermarkLayer: document.getElementById('watermark-layer'),
            antiRecordLayer: document.getElementById('anti-record-layer')
        };

        const ctx = elements.canvas.getContext('2d');

        // ===== INITIALISATION PDF.js =====
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

        // ===== FONCTIONS DE SÉCURITÉ =====

        // 1. Logger les tentatives au serveur
        function logSecurityAttempt(type, details = {}) {
            const payload = {
                type: type,
                user_id: CONFIG.userId,
                user_name: CONFIG.userName,
                contenu_id: CONFIG.contenuId,
                session_id: CONFIG.sessionId,
                timestamp: new Date().toISOString(),
                user_agent: navigator.userAgent,
                screen_size: `${screen.width}x${screen.height}`,
                details: details
            };

            fetch(CONFIG.logEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': CONFIG.csrfToken
                },
                body: JSON.stringify(payload)
            }).catch(() => {});

            console.warn(`[SECURITY] ${type}:`, details);
        }

        // 2. Afficher le bloqueur de capture
        function showScreenshotBlocker(reason = 'unknown') {
            if (state.isBlocked) return;

            state.screenshotAttempts++;
            elements.attemptCount.textContent = state.screenshotAttempts;
            elements.screenshotBlocker.classList.add('active');

            // Vibration sur mobile
            if (navigator.vibrate) {
                navigator.vibrate([100, 50, 100, 50, 200]);
            }

            logSecurityAttempt('screenshot_attempt', {
                reason: reason,
                attempt_number: state.screenshotAttempts
            });

            // Mettre à jour l'indicateur
            updateSecurityStatus('danger', 'Capture détectée!');

            // Effacer le presse-papiers
            clearClipboard();

            // Masquer après délai
            setTimeout(() => {
                elements.screenshotBlocker.classList.remove('active');
                updateSecurityStatus('normal', 'Protection Active');
            }, 3000);

            // Bloquer après trop de tentatives
            if (state.screenshotAttempts >= CONFIG.maxAttempts) {
                blockAccess();
            }
        }

        // 3. Bloquer l'accès complet
        function blockAccess() {
            state.isBlocked = true;
            logSecurityAttempt('access_blocked', {
                total_attempts: state.screenshotAttempts
            });

            document.body.innerHTML = `
                <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;background:#000;color:#dc3545;text-align:center;padding:20px;">
                    <i class="fas fa-ban" style="font-size:100px;margin-bottom:30px;"></i>
                    <h1>ACCÈS RÉVOQUÉ</h1>
                    <p style="color:#fff;opacity:0.7;">Trop de tentatives de capture détectées.</p>
                    <p style="color:#ffc107;font-size:14px;">Session: ${CONFIG.sessionId}</p>
                    <p style="color:#fff;opacity:0.5;font-size:12px;">Cette action a été signalée à l'administrateur.</p>
                </div>
            `;
        }

        // 4. Mettre à jour l'indicateur de sécurité
        function updateSecurityStatus(level, text) {
            elements.securityStatus.className = 'security-indicator';
            if (level === 'warning') {
                elements.securityStatus.classList.add('warning');
            } else if (level === 'danger') {
                elements.securityStatus.classList.add('danger');
            }
            elements.securityStatus.innerHTML = `<i class="fas fa-shield-alt"></i><span>${text}</span>`;
        }

        // 5. Effacer le presse-papiers
        function clearClipboard() {
            try {
                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText('').catch(() => {});
                }
                // Méthode alternative
                const ta = document.createElement('textarea');
                ta.value = '';
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                document.body.removeChild(ta);
            } catch(e) {}
        }

        // ===== DÉTECTION DEVTOOLS =====

        function detectDevTools() {
            const threshold = 160;
            const widthThreshold = window.outerWidth - window.innerWidth > threshold;
            const heightThreshold = window.outerHeight - window.innerHeight > threshold;

            // Méthode 1: Différence de taille
            if (widthThreshold || heightThreshold) {
                return true;
            }

            // Méthode 2: Firebug
            if (window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized) {
                return true;
            }

            // Méthode 3: Console timing
            const start = performance.now();
            console.log('%c', '');
            console.clear();
            const end = performance.now();
            if (end - start > 100) {
                return true;
            }

            return false;
        }

        function checkDevTools() {
            const isOpen = detectDevTools();

            if (isOpen && !state.devToolsOpen) {
                state.devToolsOpen = true;
                elements.devtoolsBlocker.classList.add('active');
                logSecurityAttempt('devtools_opened');
            } else if (!isOpen && state.devToolsOpen) {
                state.devToolsOpen = false;
                elements.devtoolsBlocker.classList.remove('active');
            }
        }

        // Vérifier régulièrement
        setInterval(checkDevTools, 500);

        // ===== PROTECTION CLAVIER COMPLÈTE =====

        document.addEventListener('keydown', function(e) {
            const key = e.key.toLowerCase();
            const code = e.keyCode || e.which;

            // PrintScreen (code 44)
            if (code === 44 || key === 'printscreen') {
                e.preventDefault();
                e.stopPropagation();
                showScreenshotBlocker('PrintScreen');
                clearClipboard();
                return false;
            }

            // Windows + Shift + S (Snipping Tool)
            if ((e.metaKey || e.key === 'Meta') && e.shiftKey && key === 's') {
                e.preventDefault();
                showScreenshotBlocker('Windows Snipping Tool');
                return false;
            }

            // Alt + PrintScreen
            if (e.altKey && code === 44) {
                e.preventDefault();
                showScreenshotBlocker('Alt+PrintScreen');
                return false;
            }

            // Ctrl + P (Impression)
            if ((e.ctrlKey || e.metaKey) && key === 'p') {
                e.preventDefault();
                showScreenshotBlocker('Print attempt');
                return false;
            }

            // Ctrl + S (Sauvegarde)
            if ((e.ctrlKey || e.metaKey) && key === 's') {
                e.preventDefault();
                showScreenshotBlocker('Save attempt');
                return false;
            }

            // Ctrl + C (Copie)
            if ((e.ctrlKey || e.metaKey) && key === 'c') {
                e.preventDefault();
                return false;
            }

            // Ctrl + Shift + I / J / C (DevTools)
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && (key === 'i' || key === 'j' || key === 'c')) {
                e.preventDefault();
                return false;
            }

            // F12
            if (code === 123 || key === 'f12') {
                e.preventDefault();
                return false;
            }

            // Ctrl + U (View Source)
            if ((e.ctrlKey || e.metaKey) && key === 'u') {
                e.preventDefault();
                return false;
            }

            // Mac: Cmd + Shift + 3/4/5 (Screenshots)
            if (e.metaKey && e.shiftKey && (key === '3' || key === '4' || key === '5')) {
                e.preventDefault();
                showScreenshotBlocker('Mac Screenshot');
                return false;
            }

            // Windows + G (Xbox Game Bar)
            if (e.metaKey && key === 'g') {
                e.preventDefault();
                showScreenshotBlocker('Xbox Game Bar');
                return false;
            }

            // Windows + Alt + PrintScreen (Xbox recording)
            if (e.metaKey && e.altKey && code === 44) {
                e.preventDefault();
                showScreenshotBlocker('Xbox Recording');
                return false;
            }
        }, true);

        // Capturer keyup aussi pour PrintScreen
        document.addEventListener('keyup', function(e) {
            if (e.keyCode === 44) {
                clearClipboard();
                showScreenshotBlocker('PrintScreen KeyUp');
            }
        }, true);

        // ===== PROTECTION VISIBILITY (Mobile & Desktop) =====

        document.addEventListener('visibilitychange', function() {
            if (document.hidden) {
                showScreenshotBlocker('visibility_hidden');
                // Rendre le contenu noir quand caché
                elements.canvas.style.filter = 'brightness(0)';
            } else {
                elements.canvas.style.filter = 'none';
            }
        });

        // ===== PROTECTION BLUR/FOCUS =====

        let blurTimeout;
        window.addEventListener('blur', function() {
            blurTimeout = setTimeout(() => {
                showScreenshotBlocker('window_blur');
            }, 100);
        });

        window.addEventListener('focus', function() {
            clearTimeout(blurTimeout);
        });

        // ===== PROTECTION MOBILE SPÉCIFIQUE =====

        if (isMobile) {
            state.scale = 1.2;

            // iOS: Détection gestes de capture
            if (isIOS) {
                // iOS 13+ Power + Volume = Screenshot
                window.addEventListener('touchstart', function(e) {
                    if (e.touches.length >= 2) {
                        // Multi-touch peut indiquer screenshot sur certains appareils
                        updateSecurityStatus('warning', 'Multi-touch détecté');
                    }
                }, { passive: true });
            }

            // Android: Détection via media capture
            if (isAndroid) {
                // Certains Android ont un API de détection
                if ('mediaDevices' in navigator) {
                    // Vérifier si l'écran est enregistré
                    navigator.mediaDevices.getDisplayMedia &&
                    navigator.mediaDevices.getDisplayMedia({ video: true })
                        .then(stream => {
                            // Screen sharing détecté!
                            stream.getTracks().forEach(track => track.stop());
                            showScreenshotBlocker('screen_share_detected');
                        })
                        .catch(() => {});
                }
            }

            // Page Lifecycle API (Android Chrome)
            if ('onfreeze' in document) {
                document.addEventListener('freeze', function() {
                    showScreenshotBlocker('page_freeze');
                });
            }

            // pagehide (Safari iOS)
            window.addEventListener('pagehide', function(e) {
                if (!e.persisted) {
                    showScreenshotBlocker('page_hide');
                }
            });

            // Bloquer long press
            let longPressTimer;
            document.addEventListener('touchstart', function(e) {
                longPressTimer = setTimeout(() => {
                    e.preventDefault();
                    if (navigator.vibrate) navigator.vibrate(50);
                }, 500);
            }, { passive: false });

            document.addEventListener('touchend', () => clearTimeout(longPressTimer));
            document.addEventListener('touchmove', () => clearTimeout(longPressTimer));
        }

        // ===== PROTECTION RESIZE (Peut indiquer DevTools) =====

        let lastWidth = window.innerWidth;
        let lastHeight = window.innerHeight;

        window.addEventListener('resize', function() {
            const widthChange = Math.abs(window.innerWidth - lastWidth);
            const heightChange = Math.abs(window.innerHeight - lastHeight);

            // Changement suspect (DevTools qui s'ouvre)
            if (widthChange > 100 || heightChange > 100) {
                updateSecurityStatus('warning', 'Changement de taille');
                checkDevTools();
            }

            lastWidth = window.innerWidth;
            lastHeight = window.innerHeight;
        });

        // ===== PROTECTION CONTEXTMENU =====

        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // ===== PROTECTION DRAG & DROP =====

        document.addEventListener('dragstart', e => e.preventDefault());
        document.addEventListener('drop', e => e.preventDefault());

        // ===== PROTECTION COPIE/COLLER =====

        document.addEventListener('copy', function(e) {
            e.preventDefault();
            if (e.clipboardData) {
                e.clipboardData.setData('text/plain', '');
            }
            return false;
        });

        document.addEventListener('cut', e => e.preventDefault());
        document.addEventListener('paste', e => e.preventDefault());

        // ===== EFFACEMENT PÉRIODIQUE DU PRESSE-PAPIERS =====

        setInterval(clearClipboard, 2000);

        // ===== WATERMARKS DYNAMIQUES =====

        function generateWatermarks() {
            elements.watermarkLayer.innerHTML = '';

            const canvasWidth = elements.canvas.width;
            const canvasHeight = elements.canvas.height;

            // Watermarks "COLIBRI LITTÉRAIRE"
            const numRows = Math.ceil(canvasHeight / 120);
            const numCols = Math.ceil(canvasWidth / 300);

            for (let row = 0; row < numRows; row++) {
                for (let col = 0; col < numCols; col++) {
                    const wm = document.createElement('div');
                    wm.className = 'watermark-text';
                    wm.style.top = (row * 120 + 30) + 'px';
                    wm.style.left = (col * 300 + (row % 2 ? 100 : 0)) + 'px';
                    wm.textContent = 'COLIBRI LITTÉRAIRE';
                    elements.watermarkLayer.appendChild(wm);
                }
            }

            // Watermarks utilisateur (email partiel + timestamp)
            const userWmCount = Math.ceil(canvasHeight / 200);
            const emailPart = CONFIG.userEmail ? CONFIG.userEmail.substring(0, 10) + '...' : CONFIG.userName;

            for (let i = 0; i < userWmCount; i++) {
                const uwm = document.createElement('div');
                uwm.className = 'watermark-user';
                uwm.style.top = (i * 200 + 80) + 'px';
                uwm.style.left = '20px';
                uwm.textContent = `${emailPart} | ${new Date().toLocaleString()}`;
                elements.watermarkLayer.appendChild(uwm);
            }
        }

        // ===== RENDU PDF =====

        function renderPage(num) {
            state.pageIsRendering = true;

            state.pdfDoc.getPage(num).then(page => {
                let viewport = page.getViewport({ scale: state.scale });

                if (isMobile) {
                    const containerWidth = elements.canvasContainer.clientWidth - 30;
                    const scaleToFit = containerWidth / viewport.width;
                    viewport = page.getViewport({ scale: Math.min(scaleToFit, state.scale) });
                }

                elements.canvas.height = viewport.height;
                elements.canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };

                page.render(renderContext).promise.then(() => {
                    state.pageIsRendering = false;
                    elements.loader.style.display = 'none';

                    generateWatermarks();

                    if (state.pageNumIsPending !== null) {
                        renderPage(state.pageNumIsPending);
                        state.pageNumIsPending = null;
                    }
                });

                document.getElementById('page-num').textContent = num;
            });
        }

        function queueRenderPage(num) {
            if (state.pageIsRendering) {
                state.pageNumIsPending = num;
            } else {
                renderPage(num);
            }
        }

        // Fonctions globales pour les boutons
        window.prevPage = function() {
            if (state.pageNum <= 1) return;
            state.pageNum--;
            queueRenderPage(state.pageNum);
        };

        window.nextPage = function() {
            if (state.pageNum >= state.pdfDoc.numPages) return;
            state.pageNum++;
            queueRenderPage(state.pageNum);
        };

        window.zoomIn = function() {
            state.scale += 0.25;
            document.getElementById('zoom-level').textContent = Math.round(state.scale * 100) + '%';
            queueRenderPage(state.pageNum);
        };

        window.zoomOut = function() {
            if (state.scale > 0.5) {
                state.scale -= 0.25;
                document.getElementById('zoom-level').textContent = Math.round(state.scale * 100) + '%';
                queueRenderPage(state.pageNum);
            }
        };

        window.closeViewer = function() {
            logSecurityAttempt('viewer_closed', { time_spent: Date.now() - state.lastActivity });
            window.location.href = '{{ route("formation.module.show", [$formation, $module]) }}';
        };

        // ===== TIMESTAMP EN TEMPS RÉEL =====

        setInterval(() => {
            document.getElementById('current-time').textContent = new Date().toLocaleTimeString();
        }, 1000);

        // ===== CHARGEMENT DU PDF =====

        function initPDF() {
            elements.securityCheck.innerHTML = '<i class="fas fa-check-circle"></i><span>Sécurité vérifiée</span>';

            // Utiliser l'URL sécurisée avec token
            const pdfUrl = CONFIG.pdfUrl;

            pdfjsLib.getDocument(pdfUrl).promise.then(pdfDoc => {
                state.pdfDoc = pdfDoc;
                document.getElementById('page-count').textContent = pdfDoc.numPages;

                setTimeout(() => {
                    renderPage(state.pageNum);
                    logSecurityAttempt('document_loaded');
                }, 500);
            }).catch(err => {
                console.error('Erreur chargement PDF:', err);
                elements.loader.innerHTML = `
                    <div style="color:#dc3545;text-align:center;">
                        <i class="fas fa-exclamation-triangle" style="font-size:50px;margin-bottom:20px;"></i>
                        <p>Erreur de chargement du document</p>
                        <button onclick="location.reload()" style="padding:10px 20px;background:#dc3545;color:#fff;border:none;border-radius:5px;cursor:pointer;">
                            Réessayer
                        </button>
                    </div>
                `;
            });
        }

        // ===== ANTI-CONSOLE DEBUGGING =====

        // Désactiver console en production
        const noop = () => {};
        ['log', 'debug', 'info', 'warn', 'error', 'table', 'trace'].forEach(method => {
            console[method] = noop;
        });

        // Réactiver pour les messages de sécurité
        const securityLog = console.warn.bind(console);
        console.warn = function() {
            if (arguments[0] && arguments[0].includes('[SECURITY]')) {
                securityLog.apply(console, arguments);
            }
        };

        // ===== DÉMARRAGE =====

        document.addEventListener('DOMContentLoaded', function() {
            // Vérification initiale de sécurité
            setTimeout(() => {
                checkDevTools();
                initPDF();
            }, 1000);
        });

        // Empêcher l'accès via iframe
        if (window.top !== window.self) {
            window.top.location = window.self.location;
        }

    })();
    </script>
</body>
</html>
