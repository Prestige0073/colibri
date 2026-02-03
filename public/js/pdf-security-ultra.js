/**
 * SYSTÈME DE PROTECTION PDF ULTRA-SÉCURISÉ
 * Colibri Littéraire - Expert Cybersécurité
 *
 * Protections incluses:
 * - Blocage capture d'écran (PrintScreen, Snipping Tool, Mac Screenshots)
 * - Détection DevTools
 * - Détection extensions de capture
 * - Watermark forensique invisible
 * - Obscurcissement pendant blur
 * - Blocage automatique côté serveur
 * - Protection contre enregistrement vidéo
 */

class PDFSecurityUltra {
    constructor(config) {
        this.config = {
            userId: config.userId || 0,
            userName: config.userName || 'Unknown',
            userEmail: config.userEmail || '',
            documentId: config.documentId || 0,
            documentType: config.documentType || 'catalogue',
            sessionId: config.sessionId || '',
            csrfToken: config.csrfToken || '',
            logEndpoint: config.logEndpoint || '/api/security/log-attempt',
            statusEndpoint: config.statusEndpoint || '/api/security/check-status',
            maxAttempts: config.maxAttempts || 5,
            pdfUrl: config.pdfUrl || '',
            canvasId: config.canvasId || 'pdf-canvas',
            onBlocked: config.onBlocked || null,
            onWarning: config.onWarning || null,
        };

        this.state = {
            attempts: 0,
            isBlocked: false,
            isPermanentlyBlocked: false,
            devToolsOpen: false,
            lastActivity: Date.now(),
            extensionDetected: false,
            recordingDetected: false,
        };

        this.elements = {};
        this.forensicId = this.generateForensicId();

        this.init();
    }

    init() {
        // Vérifier le statut de blocage au démarrage
        this.checkBlockStatus();

        // Initialiser toutes les protections
        this.initKeyboardProtection();
        this.initVisibilityProtection();
        this.initDevToolsDetection();
        this.initExtensionDetection();
        this.initCanvasProtection();
        this.initRecordingDetection();
        this.initClipboardProtection();
        this.initContextMenuProtection();
        this.initMobileProtection();
        this.initForensicWatermark();

        // Vérification périodique du statut
        setInterval(() => this.checkBlockStatus(), 30000);

        console.log('%c⚠️ DOCUMENT PROTÉGÉ', 'color: red; font-size: 20px; font-weight: bold;');
        console.log('%cToute tentative de capture est enregistrée et tracée.', 'color: orange;');
    }

    // ==================== PROTECTION CLAVIER ====================
    initKeyboardProtection() {
        const blockedKeys = [
            { code: 44, name: 'PrintScreen' },
            { key: 'printscreen', name: 'PrintScreen' },
        ];

        document.addEventListener('keydown', (e) => {
            const key = e.key?.toLowerCase();
            const code = e.keyCode || e.which;

            // PrintScreen
            if (code === 44 || key === 'printscreen') {
                e.preventDefault();
                this.onScreenshotAttempt('PrintScreen');
                return false;
            }

            // Windows Snipping Tool (Win+Shift+S)
            if ((e.metaKey || e.key === 'Meta') && e.shiftKey && key === 's') {
                e.preventDefault();
                this.onScreenshotAttempt('Snipping Tool');
                return false;
            }

            // Ctrl+P (Print)
            if ((e.ctrlKey || e.metaKey) && key === 'p') {
                e.preventDefault();
                this.onScreenshotAttempt('Print');
                return false;
            }

            // Ctrl+S (Save)
            if ((e.ctrlKey || e.metaKey) && key === 's') {
                e.preventDefault();
                this.onScreenshotAttempt('Save');
                return false;
            }

            // DevTools shortcuts
            if ((e.ctrlKey || e.metaKey) && e.shiftKey && ['i', 'j', 'c'].includes(key)) {
                e.preventDefault();
                this.onDevToolsAttempt();
                return false;
            }

            // F12
            if (code === 123 || key === 'f12') {
                e.preventDefault();
                this.onDevToolsAttempt();
                return false;
            }

            // Mac Screenshots (Cmd+Shift+3/4/5)
            if (e.metaKey && e.shiftKey && ['3', '4', '5'].includes(key)) {
                e.preventDefault();
                this.onScreenshotAttempt('Mac Screenshot');
                return false;
            }

            // Windows Game Bar (Win+G)
            if (e.metaKey && key === 'g') {
                e.preventDefault();
                this.onRecordingAttempt('Xbox Game Bar');
                return false;
            }

            // Alt+PrintScreen
            if (e.altKey && code === 44) {
                e.preventDefault();
                this.onScreenshotAttempt('Alt+PrintScreen');
                return false;
            }
        }, true);

        document.addEventListener('keyup', (e) => {
            if (e.keyCode === 44) {
                this.clearClipboard();
                this.onScreenshotAttempt('PrintScreen KeyUp');
            }
        }, true);
    }

    // ==================== PROTECTION VISIBILITÉ ====================
    initVisibilityProtection() {
        let blurTimeout;
        const canvas = document.getElementById(this.config.canvasId);

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                this.onScreenshotAttempt('Tab Switch');
                this.obscureCanvas(true);
            } else {
                setTimeout(() => this.obscureCanvas(false), 500);
            }
        });

        window.addEventListener('blur', () => {
            blurTimeout = setTimeout(() => {
                this.onScreenshotAttempt('Window Blur');
                this.obscureCanvas(true);
            }, 100);
        });

        window.addEventListener('focus', () => {
            clearTimeout(blurTimeout);
            setTimeout(() => this.obscureCanvas(false), 300);
        });
    }

    obscureCanvas(obscure) {
        const canvas = document.getElementById(this.config.canvasId);
        if (canvas) {
            if (obscure) {
                canvas.style.filter = 'brightness(0) blur(50px)';
                canvas.style.transition = 'filter 0.1s';
            } else {
                canvas.style.filter = 'none';
            }
        }
    }

    // ==================== DÉTECTION DEVTOOLS ====================
    initDevToolsDetection() {
        const threshold = 160;

        const check = () => {
            const widthDiff = window.outerWidth - window.innerWidth > threshold;
            const heightDiff = window.outerHeight - window.innerHeight > threshold;

            if ((widthDiff || heightDiff) && !this.state.devToolsOpen) {
                this.state.devToolsOpen = true;
                this.onDevToolsAttempt();
                this.showBlocker('devtools');
            } else if (!widthDiff && !heightDiff && this.state.devToolsOpen) {
                this.state.devToolsOpen = false;
                this.hideBlocker('devtools');
            }
        };

        setInterval(check, 500);

        // Détection via debugger
        const detectDebugger = () => {
            const start = performance.now();
            debugger;
            const end = performance.now();
            if (end - start > 100) {
                this.onDevToolsAttempt();
            }
        };

        // Exécuter occasionnellement pour ne pas affecter les performances
        setInterval(detectDebugger, 5000);
    }

    // ==================== DÉTECTION EXTENSIONS ====================
    initExtensionDetection() {
        // Détecter les extensions de capture d'écran connues
        const knownExtensions = [
            'chrome-extension://',
            'moz-extension://',
        ];

        // Vérifier les requêtes réseau suspectes
        if (window.PerformanceObserver) {
            const observer = new PerformanceObserver((list) => {
                for (const entry of list.getEntries()) {
                    if (knownExtensions.some(ext => entry.name.includes(ext))) {
                        this.state.extensionDetected = true;
                        this.logAttempt('extension_detected', { url: entry.name });
                    }
                }
            });
            observer.observe({ entryTypes: ['resource'] });
        }

        // Détecter les modifications du DOM par des extensions
        const observer = new MutationObserver((mutations) => {
            for (const mutation of mutations) {
                for (const node of mutation.addedNodes) {
                    if (node.nodeType === 1) {
                        const suspicious = ['screenshot', 'capture', 'screen-', 'snap'];
                        const nodeId = (node.id || '').toLowerCase();
                        const nodeClass = (node.className || '').toLowerCase();

                        if (suspicious.some(s => nodeId.includes(s) || nodeClass.includes(s))) {
                            this.onScreenshotAttempt('Extension DOM Injection');
                        }
                    }
                }
            }
        });

        observer.observe(document.body, { childList: true, subtree: true });
    }

    // ==================== PROTECTION CANVAS ====================
    initCanvasProtection() {
        const canvas = document.getElementById(this.config.canvasId);
        if (!canvas) return;

        // Empêcher toDataURL et getImageData
        const originalToDataURL = HTMLCanvasElement.prototype.toDataURL;
        const originalGetImageData = CanvasRenderingContext2D.prototype.getImageData;
        const self = this;

        HTMLCanvasElement.prototype.toDataURL = function() {
            self.onScreenshotAttempt('Canvas toDataURL');
            return 'data:image/png;base64,';
        };

        CanvasRenderingContext2D.prototype.getImageData = function() {
            self.onScreenshotAttempt('Canvas getImageData');
            return new ImageData(1, 1);
        };

        // Empêcher le glisser-déposer
        canvas.addEventListener('dragstart', (e) => e.preventDefault());
    }

    // ==================== DÉTECTION ENREGISTREMENT ====================
    initRecordingDetection() {
        // Détecter MediaRecorder
        if (window.MediaRecorder) {
            const originalStart = MediaRecorder.prototype.start;
            const self = this;

            MediaRecorder.prototype.start = function() {
                self.onRecordingAttempt('MediaRecorder');
                return;
            };
        }

        // Détecter getDisplayMedia (partage d'écran)
        if (navigator.mediaDevices && navigator.mediaDevices.getDisplayMedia) {
            const original = navigator.mediaDevices.getDisplayMedia;
            const self = this;

            navigator.mediaDevices.getDisplayMedia = function() {
                self.onRecordingAttempt('Screen Share');
                return Promise.reject(new Error('Screen capture blocked'));
            };
        }
    }

    // ==================== PROTECTION PRESSE-PAPIERS ====================
    initClipboardProtection() {
        document.addEventListener('copy', (e) => {
            e.preventDefault();
            this.logAttempt('copy_attempt');
            return false;
        });

        document.addEventListener('cut', (e) => {
            e.preventDefault();
            return false;
        });

        // Nettoyer le presse-papiers périodiquement
        setInterval(() => this.clearClipboard(), 2000);
    }

    clearClipboard() {
        try {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText('').catch(() => {});
            }
        } catch (e) {}
    }

    // ==================== PROTECTION MENU CONTEXTUEL ====================
    initContextMenuProtection() {
        document.addEventListener('contextmenu', (e) => {
            e.preventDefault();
            return false;
        });
    }

    // ==================== PROTECTION MOBILE ====================
    initMobileProtection() {
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);

        if (!isMobile) return;

        // Bloquer la pression longue
        let longPressTimer;
        document.addEventListener('touchstart', (e) => {
            longPressTimer = setTimeout(() => {
                e.preventDefault();
                if (navigator.vibrate) navigator.vibrate(50);
            }, 500);
        }, { passive: false });

        document.addEventListener('touchend', () => clearTimeout(longPressTimer));
        document.addEventListener('touchmove', () => clearTimeout(longPressTimer));

        // Détecter les événements iOS spécifiques
        if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
            document.addEventListener('gesturestart', (e) => e.preventDefault());
            document.addEventListener('gesturechange', (e) => e.preventDefault());
        }

        // Détecter page freeze (capture en cours sur certains appareils)
        if ('onfreeze' in document) {
            document.addEventListener('freeze', () => {
                this.onScreenshotAttempt('Page Freeze');
            });
        }

        window.addEventListener('pagehide', (e) => {
            if (!e.persisted) {
                this.onScreenshotAttempt('Page Hide');
            }
        });
    }

    // ==================== WATERMARK FORENSIQUE ====================
    initForensicWatermark() {
        // Créer un watermark invisible mais traçable
        this.addInvisibleWatermark();

        // Ajouter des micro-variations au canvas
        setInterval(() => this.addMicroVariations(), 10000);
    }

    addInvisibleWatermark() {
        const canvas = document.getElementById(this.config.canvasId);
        if (!canvas) return;

        // Ajouter un watermark invisible dans les bits de poids faible
        const ctx = canvas.getContext('2d');
        if (!ctx) return;

        try {
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;

            // Encoder l'ID forensique dans les bits de poids faible
            const forensicBytes = this.stringToBytes(this.forensicId);

            for (let i = 0; i < forensicBytes.length && i * 4 < data.length; i++) {
                // Modifier le bit de poids faible du canal alpha
                data[i * 4 + 3] = (data[i * 4 + 3] & 0xFE) | (forensicBytes[i] & 0x01);
            }

            ctx.putImageData(imageData, 0, 0);
        } catch (e) {
            // Ignorer les erreurs CORS
        }
    }

    addMicroVariations() {
        // Ajouter des micro-variations temporelles uniques
        const overlay = document.getElementById('forensic-overlay');
        if (overlay) {
            const timestamp = Date.now().toString(36);
            overlay.dataset.t = timestamp;
        }
    }

    generateForensicId() {
        return btoa(JSON.stringify({
            u: this.config.userId,
            d: this.config.documentId,
            t: Date.now(),
            s: this.config.sessionId.substring(0, 8),
        }));
    }

    stringToBytes(str) {
        const bytes = [];
        for (let i = 0; i < str.length; i++) {
            bytes.push(str.charCodeAt(i));
        }
        return bytes;
    }

    // ==================== HANDLERS D'ÉVÉNEMENTS ====================
    onScreenshotAttempt(method) {
        if (this.state.isBlocked) return;

        this.state.attempts++;
        this.showBlocker('screenshot');
        this.clearClipboard();

        if (navigator.vibrate) {
            navigator.vibrate([100, 50, 100, 50, 200]);
        }

        this.logAttempt('screenshot_attempt', {
            method: method,
            attempt: this.state.attempts
        });

        setTimeout(() => this.hideBlocker('screenshot'), 3000);

        if (this.state.attempts >= this.config.maxAttempts) {
            this.blockAccess('Trop de tentatives de capture');
        } else if (this.config.onWarning && this.state.attempts >= 3) {
            this.config.onWarning(this.state.attempts, this.config.maxAttempts);
        }
    }

    onDevToolsAttempt() {
        this.logAttempt('devtools_opened');
        this.showBlocker('devtools');
    }

    onRecordingAttempt(method) {
        this.state.recordingDetected = true;
        this.logAttempt('recording_attempt', { method: method });
        this.showBlocker('recording');

        setTimeout(() => {
            this.blockAccess('Tentative d\'enregistrement détectée');
        }, 1000);
    }

    // ==================== BLOCAGE ====================
    blockAccess(reason) {
        this.state.isBlocked = true;

        this.logAttempt('access_blocked', {
            reason: reason,
            total_attempts: this.state.attempts
        });

        if (this.config.onBlocked) {
            this.config.onBlocked(reason, this.state.isPermanentlyBlocked);
        } else {
            document.body.innerHTML = `
                <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;height:100vh;background:#000;color:#dc3545;text-align:center;padding:20px;font-family:sans-serif;">
                    <i class="fas fa-ban" style="font-size:100px;margin-bottom:30px;"></i>
                    <h1 style="margin:0 0 20px;">ACCÈS RÉVOQUÉ</h1>
                    <p style="color:#fff;opacity:0.7;max-width:400px;">${reason}</p>
                    <p style="color:#666;font-size:12px;margin-top:30px;">
                        Votre activité a été enregistrée.<br>
                        ID de session: ${this.config.sessionId.substring(0, 8)}...
                    </p>
                </div>
            `;
        }
    }

    async checkBlockStatus() {
        try {
            const response = await fetch(`${this.config.statusEndpoint}?user_id=${this.config.userId}`);
            const data = await response.json();

            if (data.blocked) {
                this.state.isBlocked = true;
                this.state.isPermanentlyBlocked = data.permanent;
                this.blockAccess(data.message || 'Accès bloqué');
            }
        } catch (e) {
            // Ignorer les erreurs réseau
        }
    }

    // ==================== LOGGING ====================
    async logAttempt(type, details = {}) {
        try {
            const response = await fetch(this.config.logEndpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.config.csrfToken,
                },
                body: JSON.stringify({
                    type: type,
                    user_id: this.config.userId,
                    user_name: this.config.userName,
                    contenu_id: this.config.documentId,
                    document_type: this.config.documentType,
                    session_id: this.config.sessionId,
                    user_agent: navigator.userAgent,
                    screen_size: `${screen.width}x${screen.height}`,
                    details: {
                        ...details,
                        forensic_id: this.forensicId,
                    },
                }),
            });

            const result = await response.json();

            if (result.blocked) {
                this.state.isBlocked = true;
                this.state.isPermanentlyBlocked = result.permanent;
                this.blockAccess(result.message);
            }
        } catch (e) {
            console.error('Security log failed:', e);
        }
    }

    // ==================== UI HELPERS ====================
    showBlocker(type) {
        const blocker = document.getElementById(`${type}-blocker`);
        if (blocker) {
            blocker.classList.add('active');
        }
    }

    hideBlocker(type) {
        const blocker = document.getElementById(`${type}-blocker`);
        if (blocker) {
            blocker.classList.remove('active');
        }
    }
}

// Export pour utilisation globale
window.PDFSecurityUltra = PDFSecurityUltra;
