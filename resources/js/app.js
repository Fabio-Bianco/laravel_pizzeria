// Bootstrap base e inizializzazioni front-end del progetto
import './bootstrap';

// Components
import './components/sidebar.js';

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

// Inizializza il sistema di dark mode semplice
initDarkMode();

// NASCONDI DEFINITIVAMENTE IL TESTO "Showing x to y of z results"
hidePaginationText();
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

document.addEventListener('DOMContentLoaded', () => {
initPizzaIngredientQuickCreate();
initStickyHeaderSearch();
if (typeof initCommandPalette === 'function') initCommandPalette();
});

// JAVASCRIPT ADMIN MODERNO

/**
 * Funzioni per la gestione della sidebar mobile
 */
function toggleSidebar() {
    document.querySelector('.sidebar-wrapper').classList.toggle('show');
}

function closeSidebar() {
    document.querySelector('.sidebar-wrapper').classList.remove('show');
}

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
    
    console.log(`� Theme applied: ${theme}`);
}

/**
 * Crea il toggle button per la dark mode in posizione professionale
 */
function createThemeToggle() {
    // Verifica se esiste già
    if (document.getElementById('theme-toggle')) return;
    
    const toggle = document.createElement('button');
    toggle.id = 'theme-toggle';
    toggle.className = 'theme-toggle';
    toggle.setAttribute('aria-label', 'Toggle dark mode');
    toggle.setAttribute('title', 'Cambia tema');
    toggle.innerHTML = `
        <i class="fas fa-sun sun-icon"></i>
        <i class="fas fa-moon moon-icon"></i>
    `;
    
    toggle.addEventListener('click', toggleTheme);
    
    document.body.appendChild(toggle);
    
    console.log('🌙 Theme toggle creato in posizione professionale');
}

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
