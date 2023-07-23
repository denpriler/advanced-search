import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import inject from "@rollup/plugin-inject";

export default defineConfig({
    plugins: [
        inject({
            $: 'jquery',
        }),
        laravel({
            input: ['resources/sass/app.scss', 'resources/js/dashboard.js', 'resources/sass/workspace.scss'],
            refresh: true,
        }),
    ],
});
