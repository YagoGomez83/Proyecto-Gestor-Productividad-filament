import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    server: {
        host: "0.0.0.0", // Permitir acceso desde Docker
        port: 5173, // Asegurar que use el puerto correcto
        strictPort: true,
        hmr: {
            host: "localhost", // O usa tu IP en la red local
        },
    },
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
});
