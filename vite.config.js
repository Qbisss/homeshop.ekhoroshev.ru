import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/main.css',
                'resources/css/admin.css',
                'resources/js/admin.js',
                'resources/js/main.js',
                'resources/css/jquery.toast.min.css',
                'resources/js/jquery.toast.min.js'
            ],
            refresh: true,
        }),
    ],
});
