import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // 1. Import Tailwind disini

export default defineConfig({
    plugins: [
        tailwindcss(), // 2. Pasang plugin Tailwind di atas Laravel Plugin
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});