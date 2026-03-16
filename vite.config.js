import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/admin.css', // Se houver css específico para o admin
                'resources/js/admin.js'    // Se houver js específico para o admin
            ],
            refresh: true,
        }),
    ],
});
