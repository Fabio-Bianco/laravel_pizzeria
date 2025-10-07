/**
 * 🚀 LAZY LOADING INTELLIGENTE PER IMMAGINI
 * Migliora le prestazioni riducendo il caricamento iniziale
 */

/**
 * Inizializza il lazy loading per tutte le immagini
 */
export function initLazyLoading() {
    // Controlla se il browser supporta l'Intersection Observer
    if ('IntersectionObserver' in window) {
        initIntersectionObserver();
    } else {
        // Fallback per browser non supportati
        loadAllImages();
    }
}

/**
 * Usa Intersection Observer per il lazy loading moderno
 */
function initIntersectionObserver() {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                loadImage(img);
                observer.unobserve(img);
            }
        });
    }, {
        // Carica l'immagine quando è a 100px dalla viewport
        rootMargin: '100px 0px',
        threshold: 0.01
    });

    // Osserva tutte le immagini con data-src
    document.querySelectorAll('img[data-src]').forEach(img => {
        imageObserver.observe(img);
    });
}

/**
 * Carica una singola immagine
 */
function loadImage(img) {
    // Mostra skeleton loader
    img.classList.add('loading');
    
    // Crea nuova immagine per preload
    const imageLoader = new Image();
    
    imageLoader.onload = function() {
        // Sostituisci src e rimuovi data-src
        img.src = img.dataset.src;
        img.removeAttribute('data-src');
        
        // Rimuovi skeleton e aggiungi classe loaded
        img.classList.remove('loading');
        img.classList.add('loaded');
        
        // Fade in elegante
        img.style.opacity = '1';
    };
    
    imageLoader.onerror = function() {
        // Gestisci errori di caricamento
        img.classList.remove('loading');
        img.classList.add('error');
        img.alt = 'Immagine non disponibile';
    };
    
    // Inizia il caricamento
    imageLoader.src = img.dataset.src;
}

/**
 * Fallback: carica tutte le immagini immediatamente
 */
function loadAllImages() {
    document.querySelectorAll('img[data-src]').forEach(img => {
        loadImage(img);
    });
}

/**
 * 🚀 COMPRESSIONE IMMAGINI AUTOMATICA
 * Ottimizza le immagini in base alla dimensione del viewport
 */
export function optimizeImageSizes() {
    const images = document.querySelectorAll('img[data-sizes]');
    
    images.forEach(img => {
        const sizes = JSON.parse(img.dataset.sizes);
        const devicePixelRatio = window.devicePixelRatio || 1;
        const viewportWidth = window.innerWidth * devicePixelRatio;
        
        // Scegli la dimensione appropriata
        let optimalSrc = sizes.small; // default
        
        if (viewportWidth >= 1200) {
            optimalSrc = sizes.large || sizes.medium || sizes.small;
        } else if (viewportWidth >= 768) {
            optimalSrc = sizes.medium || sizes.small;
        }
        
        // Applica la src ottimale
        if (img.dataset.src) {
            img.dataset.src = optimalSrc;
        } else {
            img.src = optimalSrc;
        }
    });
}

/**
 * 🚀 PRELOAD IMMAGINI CRITICHE
 * Preload per immagini above-the-fold
 */
export function preloadCriticalImages() {
    const criticalImages = document.querySelectorAll('img[data-critical]');
    
    criticalImages.forEach(img => {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = img.src || img.dataset.src;
        document.head.appendChild(link);
    });
}

// CSS per skeleton loading e transizioni
const lazyLoadingCSS = `
    img[data-src] {
        background-color: #f0f0f0;
        background-image: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    img.loading {
        animation: loading 1.5s infinite;
    }
    
    img.loaded {
        animation: none;
        background: none;
    }
    
    img.error {
        background-color: #fee;
        color: #c33;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
    }
    
    @keyframes loading {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    
    /* Dark mode skeleton */
    [data-theme="dark"] img[data-src] {
        background-color: #2d3748;
        background-image: linear-gradient(90deg, #2d3748 25%, #4a5568 50%, #2d3748 75%);
    }
`;

// Inietta CSS nel documento
if (!document.getElementById('lazy-loading-styles')) {
    const style = document.createElement('style');
    style.id = 'lazy-loading-styles';
    style.textContent = lazyLoadingCSS;
    document.head.appendChild(style);
}