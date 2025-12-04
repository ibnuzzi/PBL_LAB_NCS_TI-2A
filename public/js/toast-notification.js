/**
 * ============================================================================
 * TOAST NOTIFICATION SYSTEM - JavaScript Functionality
 * ============================================================================
 * A beautiful, professional toast notification library with smooth animations
 * and customizable options
 */

const Toast = {
    // Default configuration
    defaultConfig: {
        type: 'success', // success, error, warning, info
        title: '',
        message: '',
        duration: 5000, // milliseconds
        position: 'top-right', // top-right, top-left, bottom-right, bottom-left
        closeButton: true,
        progressBar: true,
        sound: false
    },

    // Container element
    container: null,

    /**
     * Initialize toast container
     */
    init() {
        if (!this.container) {
            this.container = document.createElement('div');
            this.container.className = 'toast-container';
            document.body.appendChild(this.container);
        }
    },

    /**
     * Show a toast notification
     * @param {Object} options - Configuration options
     */
    show(options) {
        // Initialize container if not exists
        this.init();

        // Merge with default config
        const config = { ...this.defaultConfig, ...options };

        // Create toast element
        const toast = this.createToast(config);

        // Add to container
        this.container.appendChild(toast);

        // Trigger show animation
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);

        // Auto remove after duration
        if (config.duration > 0) {
            setTimeout(() => {
                this.remove(toast);
            }, config.duration);
        }

        // Play sound if enabled
        if (config.sound) {
            this.playSound(config.type);
        }

        return toast;
    },

    /**
     * Create toast element
     * @param {Object} config - Toast configuration
     * @returns {HTMLElement} Toast element
     */
    createToast(config) {
        const toast = document.createElement('div');
        toast.className = `toast toast-${config.type}`;

        // Icon based on type
        const iconMap = {
            success: '<i class="fas fa-check-circle"></i>',
            error: '<i class="fas fa-times-circle"></i>',
            warning: '<i class="fas fa-exclamation-triangle"></i>',
            info: '<i class="fas fa-info-circle"></i>'
        };

        // Build HTML
        toast.innerHTML = `
            <div class="toast-icon">
                ${iconMap[config.type] || iconMap.info}
            </div>
            <div class="toast-content">
                ${config.title ? `<div class="toast-title">${config.title}</div>` : ''}
                ${config.message ? `<div class="toast-message">${config.message}</div>` : ''}
            </div>
            ${config.closeButton ? `
                <button class="toast-close" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            ` : ''}
        `;

        // Add close button event
        if (config.closeButton) {
            const closeBtn = toast.querySelector('.toast-close');
            closeBtn.addEventListener('click', () => {
                this.remove(toast);
            });
        }

        return toast;
    },

    /**
     * Remove toast with animation
     * @param {HTMLElement} toast - Toast element to remove
     */
    remove(toast) {
        toast.classList.remove('show');
        toast.classList.add('hide');

        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 400);
    },

    /**
     * Play notification sound
     * @param {string} type - Notification type
     */
    playSound(type) {
        // You can add custom sounds here
        // For now, using system beep
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();

        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);

        // Different frequencies for different types
        const frequencies = {
            success: 800,
            error: 400,
            warning: 600,
            info: 700
        };

        oscillator.frequency.value = frequencies[type] || 700;
        oscillator.type = 'sine';

        gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.1);
    },

    /**
     * Shorthand methods for different toast types
     */
    success(title, message, duration = 5000) {
        return this.show({
            type: 'success',
            title: title,
            message: message,
            duration: duration
        });
    },

    error(title, message, duration = 5000) {
        return this.show({
            type: 'error',
            title: title,
            message: message,
            duration: duration
        });
    },

    warning(title, message, duration = 5000) {
        return this.show({
            type: 'warning',
            title: title,
            message: message,
            duration: duration
        });
    },

    info(title, message, duration = 5000) {
        return this.show({
            type: 'info',
            title: title,
            message: message,
            duration: duration
        });
    },

    /**
     * Clear all toasts
     */
    clearAll() {
        if (this.container) {
            while (this.container.firstChild) {
                this.container.removeChild(this.container.firstChild);
            }
        }
    }
};

// Make Toast available globally
window.Toast = Toast;

// Auto-initialize on DOM ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        Toast.init();
    });
} else {
    Toast.init();
}
