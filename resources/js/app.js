// Bootstrap base e inizializzazioni front-end del progetto
import './bootstrap';

// Alpine.js (se in uso per piccoli comportamenti reattivi)
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Esponi Bootstrap JS globalmente (per gestire modali, dropdown, ecc.)
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

// Inizializza Choices.js per i select con ricerca
import Choices from 'choices.js';

document.addEventListener('DOMContentLoaded', () => {
	// Attiva Choices.js per ogni select con data-choices
	document.querySelectorAll('select[data-choices]')?.forEach((el) => {
		const isMultiple = el.multiple;
		// eslint-disable-next-line no-new
		const instance = new Choices(el, {
			removeItemButton: isMultiple, // mostra la X per rimuovere elementi quando multiplo
			searchEnabled: true,          // abilita la ricerca
			shouldSort: false,            // preserva l'ordine dati
			itemSelectText: '',           // niente testo "Premi per selezionare"
			position: 'bottom',           // dropdown sotto l'input
			placeholder: true,
			placeholderValue: el.getAttribute('placeholder') || '',
		});
		// Salva l'istanza su un campo privato per riuso (es. aggiunte dinamiche)
		// eslint-disable-next-line no-underscore-dangle
		el._choices = instance;
	});

		// Intercetta i form che richiedono conferma (data-confirm)
		document.querySelectorAll('form[data-confirm]')?.forEach((form) => {
			form.addEventListener('submit', (e) => {
				const msg = form.getAttribute('data-confirm') || 'Sei sicuro?';
				// eslint-disable-next-line no-alert
				if (!window.confirm(msg)) {
					e.preventDefault();
				}
			});
		});
});

// Moduli specifici delle feature
// Gestione pagina Pizza: modal "Nuovo ingrediente" + aggiornamento select ingredienti
import { initPizzaIngredientQuickCreate } from './features/pizzas';
import { initStickyHeaderSearch } from './features/stickyHeader';
import { initCommandPalette } from './features/commandPalette';
document.addEventListener('DOMContentLoaded', () => {
	initPizzaIngredientQuickCreate();
	initStickyHeaderSearch();
	if (typeof initCommandPalette === 'function') initCommandPalette();
	// FAB reveal/idle behavior
	const fab = document.querySelector('.x-fab-group');
	if (fab) {
		let idleTimer;
		const setReveal = () => fab.classList.add('x-fab-reveal');
		const setIdle = () => fab.classList.add('x-fab-idle');
		const unsetIdle = () => fab.classList.remove('x-fab-idle');

		// Reveals on first paint
		requestAnimationFrame(setReveal);

		const onActive = () => {
			unsetIdle();
			clearTimeout(idleTimer);
			idleTimer = setTimeout(setIdle, 1500);
		};

		window.addEventListener('scroll', onActive, { passive: true });
		window.addEventListener('pointermove', onActive, { passive: true });
		window.addEventListener('keydown', onActive);

		// Start idle timer if page is long (scrollable)
		if (document.documentElement.scrollHeight > window.innerHeight + 100) {
			idleTimer = setTimeout(setIdle, 1500);
		}
	}
});

// =========================================
// JAVASCRIPT ADMIN MODERNO
// =========================================

/**
 * Funzioni per la gestione della sidebar mobile
 */
function toggleSidebar() {
    document.querySelector('.sidebar-wrapper').classList.toggle('show');
}

function closeSidebar() {
    document.querySelector('.sidebar-wrapper').classList.remove('show');
}

// Esponi le funzioni globalmente per onclick
window.toggleSidebar = toggleSidebar;
window.closeSidebar = closeSidebar;

/**
 * Inizializzazione dell'applicazione admin
 */
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide flash messages
    initAutoHideAlerts();
    
    // Enhanced form validation feedback
    initFormValidation();
    
    // Auto-expand sidebar sections with active links
    initSidebarAutoExpand();
    
    // Handle collapse icon rotation (se presente Bootstrap)
    initBootstrapCollapseHandlers();
});

/**
 * Gestione automatica degli alert con auto-dismiss
 */
function initAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'all 0.3s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

/**
 * Validazione form migliorata con feedback visivo
 */
function initFormValidation() {
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
}

/**
 * Auto-espansione delle sezioni della sidebar con link attivi
 */
function initSidebarAutoExpand() {
    const activeLinks = document.querySelectorAll('.sidebar .nav-link.active');
    activeLinks.forEach(link => {
        const section = link.closest('.nav-section');
        if (section) {
            const collapse = section.querySelector('.collapse');
            const header = section.querySelector('.nav-section-header');
            if (collapse && header) {
                collapse.classList.add('show');
                header.setAttribute('aria-expanded', 'true');
            }
        }
    });
}

/**
 * Gestione degli eventi Bootstrap collapse (se presente)
 */
function initBootstrapCollapseHandlers() {
    const collapseHeaders = document.querySelectorAll('.nav-section-header[data-bs-toggle="collapse"]');
    collapseHeaders.forEach(header => {
        const targetId = header.getAttribute('data-bs-target');
        const target = document.querySelector(targetId);
        
        if (target) {
            target.addEventListener('show.bs.collapse', function() {
                header.setAttribute('aria-expanded', 'true');
            });
            
            target.addEventListener('hide.bs.collapse', function() {
                header.setAttribute('aria-expanded', 'false');
            });
        }
    });
}

/**
 * Utility functions
 */

/**
 * Mostra un toast di notifica
 */
function showToast(message, type = 'info') {
    // Implementazione per future notifiche toast
    console.log(`Toast ${type}:`, message);
}

/**
 * Conferma un'azione con modal
 */
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

/**
 * Debounce function per ottimizzare eventi
 */
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Esporta le funzioni globalmente per compatibilità
window.toggleSidebar = toggleSidebar;
window.closeSidebar = closeSidebar;
window.showToast = showToast;
window.confirmAction = confirmAction;
