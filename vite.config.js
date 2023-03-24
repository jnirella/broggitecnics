import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/landing.css",
                "resources/css/login.css",
                "resources/scss/app.scss",
                "resources/js/app.js",
                "resources/js/menu.js"
            ],
            refresh: true,
        }),
        vue(),
    ],
});
