// Notification System
class NotificationManager {
    static show(message, type = 'success', duration = 3000) {
        // Hapus notifikasi lama jika ada
        const oldNotification = document.querySelector('.notification-container');
        if (oldNotification) {
            oldNotification.remove();
        }

        // Buat container
        const container = document.createElement('div');
        container.className = 'notification-container';

        // Tentukan tipe notifikasi
        let notificationClass = 'notification-success';
        let icon = '';

        switch(type) {
            case 'success':
                notificationClass = 'notification-success';
                icon = '<i class="fas fa-check-circle notification-icon"></i>';
                break;
            case 'error':
                notificationClass = 'notification-error';
                icon = '<i class="fas fa-times-circle notification-icon"></i>';
                break;
            case 'warning':
                notificationClass = 'notification-warning';
                icon = '<i class="fas fa-exclamation-triangle notification-icon"></i>';
                break;
            case 'info':
                notificationClass = 'notification-info';
                icon = '<i class="fas fa-info-circle notification-icon"></i>';
                break;
            case 'cancel':
                notificationClass = 'notification-cancel';
                icon = '<i class="fas fa-ban notification-icon"></i>';
                break;
            default:
                notificationClass = 'notification-info';
                icon = '<i class="fas fa-bell notification-icon"></i>';
        }

        // Buat notifikasi
        const notification = document.createElement('div');
        notification.className = notificationClass;

        notification.innerHTML = `
            ${icon}
            <div class="notification-message">${message}</div>
            <button class="notification-close" onclick="this.closest('.notification-container').remove()">
                <i class="fas fa-times"></i> Tutup
            </button>
        `;

        container.appendChild(notification);
        document.body.appendChild(container);

        // Auto remove setelah duration
        setTimeout(() => {
            if (container.parentNode) {
                container.classList.add('notification-fade-out');
                setTimeout(() => {
                    if (container.parentNode) {
                        container.remove();
                    }
                }, 500);
            }
        }, duration);
    }

    static success(message, duration = 3000) {
        this.show(message, 'success', duration);
    }

    static error(message, duration = 3000) {
        this.show(message, 'error', duration);
    }

    static warning(message, duration = 3000) {
        this.show(message, 'warning', duration);
    }

    static info(message, duration = 3000) {
        this.show(message, 'info', duration);
    }

    static cancel(message, duration = 3000) {
        this.show(message, 'cancel', duration);
    }
}

// Global functions untuk kemudahan
function showSuccessNotification(message) {
    NotificationManager.success(message);
}

function showErrorNotification(message) {
    NotificationManager.error(message);
}

function showWarningNotification(message) {
    NotificationManager.warning(message);
}

function showInfoNotification(message) {
    NotificationManager.info(message);
}

function showCancelNotification(message) {
    NotificationManager.cancel(message);
}
