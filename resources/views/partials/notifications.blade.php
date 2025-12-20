{{-- Notifications Améliorées --}}
<style>
    .notification-container {
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 9999;
        max-width: 420px;
        width: 100%;
        pointer-events: none;
    }

    .notification-alert {
        pointer-events: auto;
        margin-bottom: 15px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
        border: none;
        padding: 20px 24px;
        animation: slideInRight 0.4s ease-out;
        backdrop-filter: blur(10px);
    }

    .notification-success {
        background: linear-gradient(135deg, #1bc47d 0%, #16a667 100%);
        color: #fff;
    }

    .notification-error {
        background: linear-gradient(135deg, #e53935 0%, #c62828 100%);
        color: #fff;
    }

    .notification-warning {
        background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%);
        color: #fff;
    }

    .notification-info {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        color: #fff;
    }

    .notification-icon {
        font-size: 28px;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .notification-content {
        flex: 1;
    }

    .notification-title {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 4px;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .notification-message {
        font-size: 14px;
        line-height: 1.5;
        opacity: 0.95;
    }

    .notification-close {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #fff;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        flex-shrink: 0;
        margin-left: 12px;
    }

    .notification-close:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .notification-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 0 0 12px 12px;
        animation: progressBar 5s linear;
    }

    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }

    @keyframes progressBar {
        from {
            width: 100%;
        }
        to {
            width: 0%;
        }
    }

    .notification-alert.hiding {
        animation: slideOutRight 0.3s ease-in forwards;
    }

    @media (max-width: 768px) {
        .notification-container {
            top: 70px;
            right: 10px;
            left: 10px;
            max-width: none;
        }

        .notification-alert {
            padding: 16px 18px;
        }

        .notification-icon {
            font-size: 24px;
            margin-right: 12px;
        }

        .notification-title {
            font-size: 14px;
        }

        .notification-message {
            font-size: 13px;
        }
    }
</style>

<div class="notification-container" id="notificationContainer">
    @if (session('success'))
        <div class="notification-alert notification-success" role="alert" data-auto-dismiss="true">
            <div class="d-flex align-items-start">
                <div class="notification-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Succès !</div>
                    <div class="notification-message">{{ session('success') }}</div>
                </div>
                <button type="button" class="notification-close" onclick="dismissNotification(this)">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="notification-progress"></div>
        </div>
    @endif

    @if (session('error'))
        <div class="notification-alert notification-error" role="alert" data-auto-dismiss="true">
            <div class="d-flex align-items-start">
                <div class="notification-icon">
                    <i class="fa fa-exclamation-circle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Erreur !</div>
                    <div class="notification-message">{{ session('error') }}</div>
                </div>
                <button type="button" class="notification-close" onclick="dismissNotification(this)">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="notification-progress"></div>
        </div>
    @endif

    @if (session('warning'))
        <div class="notification-alert notification-warning" role="alert" data-auto-dismiss="true">
            <div class="d-flex align-items-start">
                <div class="notification-icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Attention !</div>
                    <div class="notification-message">{{ session('warning') }}</div>
                </div>
                <button type="button" class="notification-close" onclick="dismissNotification(this)">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="notification-progress"></div>
        </div>
    @endif

    @if (session('info'))
        <div class="notification-alert notification-info" role="alert" data-auto-dismiss="true">
            <div class="d-flex align-items-start">
                <div class="notification-icon">
                    <i class="fa fa-info-circle"></i>
                </div>
                <div class="notification-content">
                    <div class="notification-title">Information</div>
                    <div class="notification-message">{{ session('info') }}</div>
                </div>
                <button type="button" class="notification-close" onclick="dismissNotification(this)">
                    <i class="fa fa-times"></i>
                </button>
            </div>
            <div class="notification-progress"></div>
        </div>
    @endif
</div>

<script>
    function dismissNotification(button) {
        const notification = button.closest('.notification-alert');
        notification.classList.add('hiding');
        setTimeout(() => {
            notification.remove();
        }, 300);
    }

    // Auto-dismiss après 5 secondes
    document.addEventListener('DOMContentLoaded', function() {
        const notifications = document.querySelectorAll('[data-auto-dismiss="true"]');
        notifications.forEach(notification => {
            setTimeout(() => {
                notification.classList.add('hiding');
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        });
    });
</script>
