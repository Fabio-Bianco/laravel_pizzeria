import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { resolve } from 'path';

export default defineConfig({
    server: {
        host: '127.0.0.1',
        port: 5173,
        hmr: {
            host: '127.0.0.1',
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    
    // 🚀 OTTIMIZZAZIONI PRESTAZIONI
    build: {
        // Minificazione avanzata
        minify: 'terser',
        terserOptions: {
            compress: {
                drop_console: true, // Rimuovi console.log in produzione
                drop_debugger: true,
                pure_funcs: ['console.log', 'console.info', 'console.debug']
            }
        },
        
        // Code splitting intelligente
        rollupOptions: {
            output: {
                manualChunks: {
                    // Vendor chunk separato per librerie
                    vendor: ['bootstrap', 'choices.js'],
                    // Utils chunk per utilities
                    utils: ['alpinejs']
                }
            }
        },
        
        // Compressione asset
        cssCodeSplit: true,
        cssMinify: true,
        
        // Chunk size ottimale
        chunkSizeWarningLimit: 1000,
        
        // Asset inlining per file piccoli
        assetsInlineLimit: 4096,
        
        // Output directory ottimizzato
        outDir: 'public/build',
        assetsDir: 'assets',
        
        // Source maps solo in dev
        sourcemap: false
    },
    
    // Ottimizzazione CSS
    css: {
        devSourcemap: true,
        preprocessorOptions: {
            css: {
                charset: false // Rimuove @charset per CSS più leggero
            }
        }
    },
    
    // Risoluzione alias per import più veloci
    resolve: {
        alias: {
            '@': resolve(__dirname, 'resources'),
            '@css': resolve(__dirname, 'resources/css'),
            '@js': resolve(__dirname, 'resources/js'),
            '@components': resolve(__dirname, 'resources/js/components')
        }
    },
    
    // Ottimizzazione dependencies
    optimizeDeps: {
        include: [
            'bootstrap',
            'choices.js',
            'alpinejs'
        ],
        exclude: []
    },
    
    // Performance hints
    esbuild: {
        // Tree-shaking più aggressivo
        treeShaking: true,
        // Rimozione commenti
        legalComments: 'none'
    }
});
