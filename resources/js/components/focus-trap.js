/**
 * Sistema di gestione Focus Trap per modali accessibili
 * Implementa WCAG 2.1 AAA per navigazione da tastiera
 */

class FocusTrapManager {
    constructor() {
        this.currentTrap = null;
        this.init();
    }

    init() {
        // Gestione globale modali Bootstrap
        document.addEventListener('shown.bs.modal', (e) => {
            this.enableTrap(e.target);
        });

        document.addEventListener('hidden.bs.modal', (e) => {
            this.disableTrap();
        });

        // Gestione ESC globale
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.currentTrap) {
                this.handleEscape();
            }
        });
    }

    enableTrap(modalElement) {
        if (!modalElement) return;

        // Trova tutti gli elementi focusabili nella modale
        const focusableSelectors = [
            'button:not([disabled])',
            '[href]:not([disabled])',
            'input:not([disabled])',
            'select:not([disabled])',
            'textarea:not([disabled])',
            '[tabindex]:not([tabindex="-1"]):not([disabled])',
            '[contenteditable]:not([disabled])'
        ].join(', ');

        const focusableElements = modalElement.querySelectorAll(focusableSelectors);
        
        if (focusableElements.length === 0) return;

        this.currentTrap = {
            modal: modalElement,
            focusableElements: Array.from(focusableElements),
            firstElement: focusableElements[0],
            lastElement: focusableElements[focusableElements.length - 1]
        };

        // Focus sul primo elemento
        setTimeout(() => {
            this.currentTrap.firstElement.focus();
        }, 100);

        // Trap del focus
        modalElement.addEventListener('keydown', this.handleTabKey.bind(this));
    }

    handleTabKey(e) {
        if (!this.currentTrap || e.key !== 'Tab') return;

        const { firstElement, lastElement } = this.currentTrap;
        const activeElement = document.activeElement;

        if (e.shiftKey) {
            // SHIFT + TAB (indietro)
            if (activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } else {
            // TAB (avanti)
            if (activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }

    handleEscape() {
        if (!this.currentTrap) return;

        // Chiudi la modale
        const closeButton = this.currentTrap.modal.querySelector('[data-bs-dismiss="modal"]');
        if (closeButton) {
            closeButton.click();
        }
    }

    disableTrap() {
        if (this.currentTrap) {
            this.currentTrap.modal.removeEventListener('keydown', this.handleTabKey.bind(this));
            this.currentTrap = null;
        }
    }
}

// Inizializza il sistema quando il DOM è pronto
document.addEventListener('DOMContentLoaded', () => {
    new FocusTrapManager();
    
    // Annuncia le modali agli screen reader
    document.addEventListener('shown.bs.modal', (e) => {
        const modal = e.target;
        const title = modal.querySelector('.modal-title');
        
        if (title) {
            // Crea annuncio per screen reader
            const announcement = document.createElement('div');
            announcement.setAttribute('aria-live', 'polite');
            announcement.setAttribute('aria-atomic', 'true');
            announcement.className = 'visually-hidden';
            announcement.textContent = `Finestra aperta: ${title.textContent}. Premi ESC per chiudere.`;
            
            document.body.appendChild(announcement);
            
            // Rimuovi dopo l'annuncio
            setTimeout(() => {
                document.body.removeChild(announcement);
            }, 1000);
        }
    });
});

export default FocusTrapManager;