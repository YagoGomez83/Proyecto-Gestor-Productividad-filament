// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js' // Solo app.js como entry point
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        rollupOptions: {
            output: {
                entryFileNames: 'assets/[name].js',
                chunkFileNames: 'assets/[name].js',
                assetFileNames: 'assets/[name].[ext]'
            }
        }
    },
    optimizeDeps: {
        include: ['leaflet', 'leaflet.heat', 'chart.js']
    }
});