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
// IMPORTANTE: Delay per assicurarsi che la sidebar sia completamente renderizzata
setTimeout(() => {
    // 🚀 INIZIALIZZAZIONE MENU SIDEBAR TOGGLE
    console.log('🎯 Inizializzazione sidebar menu toggles...');

    // Trova tutti gli header clickabili della sidebar
    const sidebarHeaders = document.querySelectorAll('.nav-section-header[data-bs-target]');
    console.log(`📋 Trovati ${sidebarHeaders.length} header menu nella sidebar`);

    if (sidebarHeaders.length === 0) {
        console.warn('⚠️ Nessun header menu trovato! Verifica selettori CSS.');
        // Debug: stampa tutti gli elementi che potrebbero essere header
        const allHeaders = document.querySelectorAll('.nav-section-header');
        console.log('Debug - Header trovati senza data-bs-target:', allHeaders.length);
        allHeaders.forEach((h, i) => {
            console.log(`Header ${i}:`, h.outerHTML.substring(0, 100));
        });
    }

    sidebarHeaders.forEach(function(header, index) {
        console.log(`🔧 Configurando header ${index + 1}: ${header.getAttribute('data-bs-target')}`);
        
        // Rimuovi eventuali listener precedenti per evitare duplicati
        const newHeader = header.cloneNode(true);
        header.parentNode.replaceChild(newHeader, header);
        
        newHeader.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-bs-target');
            const target = document.querySelector(targetId);
            const icon = this.querySelector('.transition-icon');
            
            console.log(`🔄 Toggle cliccato: ${targetId}`);
            
            if (!target) {
                console.error(`❌ Target non trovato: ${targetId}`);
                return;
            }
            
            const isCurrentlyOpen = target.classList.contains('show');
            console.log(`📊 Stato attuale: ${isCurrentlyOpen ? 'APERTO' : 'CHIUSO'}`);
            
            if (isCurrentlyOpen) {
                // CHIUDI
                target.classList.remove('show');
                this.setAttribute('aria-expanded', 'false');
                if (icon) {
                    icon.style.transform = 'rotate(0deg)';
                    icon.style.transition = 'transform 0.3s ease';
                }
                console.log(`📁 ✅ Menu CHIUSO: ${targetId}`);
            } else {
                // APRI
                target.classList.add('show');
                this.setAttribute('aria-expanded', 'true');
                if (icon) {
                    icon.style.transform = 'rotate(180deg)';
                    icon.style.transition = 'transform 0.3s ease';
                }
                console.log(`📂 ✅ Menu APERTO: ${targetId}`);
            }
        });
        
        // Imposta stato iniziale corretto
        const targetId = newHeader.getAttribute('data-bs-target');
        const target = document.querySelector(targetId);
        const icon = newHeader.querySelector('.transition-icon');
        
        if (target && icon) {
            const isExpanded = target.classList.contains('show');
            newHeader.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
            icon.style.transform = isExpanded ? 'rotate(180deg)' : 'rotate(0deg)';
            icon.style.transition = 'transform 0.3s ease';
            console.log(`🎨 Stato iniziale ${targetId}: ${isExpanded ? 'APERTO' : 'CHIUSO'}`);
        }
    });

    console.log('✅ Sidebar menu toggles inizializzati completamente!');
}, 500); // Delay di 500ms per assicurarsi che tutto sia caricato

// Attiva Choices.js per ogni select con data-choices
document.querySelectorAll('select[data-choices]')?.forEach((el) => {
const isMultiple = el.multiple;
const instance = new Choices(el, {
removeItemButton: isMultiple,
searchEnabled: true,
shouldSort: false,
itemSelectText: '',
position: 'bottom',
placeholder: true,
placeholderValue: el.getAttribute('placeholder') || '',
});
el._choices = instance;
});

// Intercetta i form che richiedono conferma (data-confirm)
document.querySelectorAll('form[data-confirm]')?.forEach((form) => {
form.addEventListener('submit', (e) => {
const msg = form.getAttribute('data-confirm') || 'Sei sicuro?';
if (!window.confirm(msg)) {
e.preventDefault();
}
});
});

// Inizializza solo la logica dark mode, senza creare il vecchio toggle flottante
initDarkMode = function() {
    // Solo logica, nessun tasto aggiunto
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const isDarkMode = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
    applyTheme(isDarkMode ? 'dark' : 'light');
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem('theme')) {
            applyTheme(e.matches ? 'dark' : 'light');
        }
    });
}

// TEMPORANEAMENTE DISABILITATO - CAUSAVA PROBLEMI
// hidePaginationText();
});

/**
 * Nasconde tutti i testi di paginazione "Showing x to y of z results"
 */
function hidePaginationText() {
    // Funzione per nascondere elementi
    function hideShowingTexts() {
        // Seleziona tutti i paragrafi e div che potrebbero contenere il testo
        const elements = document.querySelectorAll('p, div, span');
        
        elements.forEach(el => {
            const text = el.textContent?.toLowerCase() || '';
            if (text.includes('showing') && text.includes('results')) {
                el.style.display = 'none';
                console.log('🚫 Nascosto testo paginazione:', el.textContent);
            }
        });
        
        // Nascondi elementi con classi specifiche
        const classesToHide = [
            '.pagination-info',
            '.showing-results', 
            '[class*="showing"]',
            '[class*="results"]'
        ];
        
        classesToHide.forEach(selector => {
            document.querySelectorAll(selector).forEach(el => {
                el.style.display = 'none';
            });
        });
    }
    
    // Esegui immediatamente
    hideShowingTexts();
    
    // Esegui dopo un ritardo per elementi caricati dinamicamente
    setTimeout(hideShowingTexts, 500);
    setTimeout(hideShowingTexts, 1000);
    
    // Observer per cambiamenti DOM
    const observer = new MutationObserver(() => {
        hideShowingTexts();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    console.log('🎯 Sistema anti-"Showing results" attivato');
}

// Moduli specifici delle feature
import { initPizzaIngredientQuickCreate } from './features/pizzas';
import { initStickyHeaderSearch } from './features/stickyHeader';
import { initCommandPalette } from './features/commandPalette';
import './features/appetizers';
import './features/beverages';
import './features/desserts';
import './components/focus-trap';
import './components/delete-confirmation';

document.addEventListener('DOMContentLoaded', () => {
initPizzaIngredientQuickCreate();
initStickyHeaderSearch();
if (typeof initCommandPalette === 'function') initCommandPalette();
});

// JAVASCRIPT ADMIN MODERNO

/**
 * Funzioni per la gestione della sidebar mobile con accessibilità migliorata
 */
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar-wrapper');
    const toggleButton = document.querySelector('.mobile-toggle');
    const isExpanded = sidebar.classList.contains('show');
    
    // Toggle classe e ARIA state
    sidebar.classList.toggle('show');
    
    if (toggleButton) {
        toggleButton.setAttribute('aria-expanded', (!isExpanded).toString());
    }
    
    // Focus management per accessibilità
    if (!isExpanded) {
        // Quando apriamo la sidebar, focalizziamo il primo link
        const firstLink = sidebar.querySelector('a, button');
        if (firstLink) {
            firstLink.focus();
        }
    } else {
        // Quando chiudiamo, torniamo al toggle button
        if (toggleButton) {
            toggleButton.focus();
        }
    }
}

function closeSidebar() {
    const sidebar = document.querySelector('.sidebar-wrapper');
    const toggleButton = document.querySelector('.mobile-toggle');
    
    sidebar.classList.remove('show');
    
    if (toggleButton) {
        toggleButton.setAttribute('aria-expanded', 'false');
        toggleButton.focus(); // Riporta focus al toggle
    }
}

// Keyboard navigation per sidebar
document.addEventListener('keydown', function(e) {
    const sidebar = document.querySelector('.sidebar-wrapper');
    const isOpen = sidebar && sidebar.classList.contains('show');
    
    // ESC per chiudere sidebar
    if (e.key === 'Escape' && isOpen) {
        closeSidebar();
        e.preventDefault();
    }
    
    // Trap focus nella sidebar quando aperta su mobile
    if (isOpen && window.innerWidth <= 768) {
        trapFocus(sidebar, e);
    }
});

// Focus trap utility per accessibilità
function trapFocus(container, event) {
    const focusableElements = container.querySelectorAll(
        'a[href], button:not([disabled]), textarea:not([disabled]), input[type="text"]:not([disabled]), input[type="radio"]:not([disabled]), input[type="checkbox"]:not([disabled]), select:not([disabled])'
    );
    
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];
    
    if (event.key === 'Tab') {
        if (event.shiftKey) {
            if (document.activeElement === firstElement) {
                lastElement.focus();
                event.preventDefault();
            }
        } else {
            if (document.activeElement === lastElement) {
                firstElement.focus();
                event.preventDefault();
            }
        }
    }
}

// Esponi le funzioni globalmente per onclick
window.toggleSidebar = toggleSidebar;
window.closeSidebar = closeSidebar;

// Debug globale per sidebar
window.debugSidebar = function() {
    console.log('🔍 DEBUG SIDEBAR COMPLETO:');
    console.log('Headers found:', document.querySelectorAll('.nav-section-header[data-bs-target]').length);
    console.log('Targets found:', document.querySelectorAll('.nav-section-content').length);
    console.log('Collapse classes:', document.querySelectorAll('.collapse').length);
    
    // Stampa ogni header trovato
    const headers = document.querySelectorAll('.nav-section-header[data-bs-target]');
    headers.forEach((h, i) => {
        const target = h.getAttribute('data-bs-target');
        const targetEl = document.querySelector(target);
        console.log(`Header ${i}: ${target} -> Target exists: ${!!targetEl}`);
        if (targetEl) {
            console.log(`  - Has 'show' class: ${targetEl.classList.contains('show')}`);
            console.log(`  - Aria-expanded: ${h.getAttribute('aria-expanded')}`);
        }
    });
};

// Test automatico al caricamento
setTimeout(() => {
    console.log('🧪 Auto-test sidebar dopo 2 secondi...');
    window.debugSidebar();
}, 2000);

/**
 * =========================================
 * 🌙 DARK MODE SEMPLICE E ACCESSIBILE
 * =========================================
 * Sistema minimalista per dark mode con:
 * - Contrasti ottimali per accessibilità
 * - Persistenza in localStorage
 * - Toggle elegante e intuitivo
 */

/**
 * Inizializza il sistema di dark mode
 */
function initDarkMode() {
    // Recupera preferenza salvata o rileva sistema
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    const isDarkMode = savedTheme === 'dark' || (!savedTheme && systemPrefersDark);
    
    // Applica tema iniziale
    applyTheme(isDarkMode ? 'dark' : 'light');
    
    // Crea toggle button
    createThemeToggle();
    
    // Ascolta cambiamenti sistema
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        if (!localStorage.getItem('theme')) {
            applyTheme(e.matches ? 'dark' : 'light');
        }
    });
}

/**
 * Applica il tema specificato
 */
function applyTheme(theme) {
    if (theme === 'dark') {
        document.documentElement.setAttribute('data-theme', 'dark');
    } else {
        document.documentElement.removeAttribute('data-theme');
    }
    
    // Salva preferenza
    localStorage.setItem('theme', theme);
    
    console.log(`🌙 Theme applied: ${theme}`);
}

/**
 * Crea il toggle button per la dark mode in posizione professionale
 */


/**
 * Toggle tra light e dark mode
 */
function toggleTheme() {
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    applyTheme(isDark ? 'light' : 'dark');
}

// Esporta le funzioni globalmente
window.toggleSidebar = toggleSidebar;
window.closeSidebar = closeSidebar;
window.toggleTheme = toggleTheme;
window.applyTheme = applyTheme;
window.initDarkMode = initDarkMode;