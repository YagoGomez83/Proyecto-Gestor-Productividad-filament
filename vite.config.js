// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true, // Esto es principalmente para desarrollo
        }),
    ],
    // No es estrictamente necesario definir 'build.manifest' aquí,
    // el plugin de Laravel lo establece en true por defecto.
    // Dejaremos la 'base' por ahora, ya que es útil.
    base: '/build/',
    // Las secciones 'optimizeDeps' y 'server' solo afectan al servidor de desarrollo (npm run dev)
    // y no al proceso de 'build' para producción.
});