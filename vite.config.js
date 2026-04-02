import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/admin.css',
                'resources/js/admin.js', 
                'resources/css/home.css', 
                'resources/js/home.js',
                'resources/js/navbar.js' 
            ],
            refresh: true,
        }),
    ],
});
