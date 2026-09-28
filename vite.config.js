import tailwindcss from '@tailwindcss/vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import { defineConfig, lazyPlugins } from 'vite-plus';

// import { defineConfig } from 'vite';
// import laravel from 'laravel-vite-plugin';

// import { defineConfig } from 'vite';
// import laravel, { refreshPaths } from 'laravel-vite-plugin';


export default defineConfig({
    plugins: lazyPlugins(() => [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
            // refresh: [
            //     ...refreshPaths,
            //     'app/Livewire/**',
            //     'resources/views/**',
            // ],
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],

                }),
            ],
        }),
        // livewire({
        //     refresh: ['resources/views/**/*.blade.php'],
        // }),
        tailwindcss(),
    ]),
    server: {
        cors: true,
        watch: {
            ignored: [
                '**/.agents/**',
                '**/.claude/**',
                '**/.cursor/**',
                '**/.junie/**',
                '**/storage/framework/views/**',
                '**/vendor/**',
            ],
        },
        // Define o host local para o seu domínio do Herd
        host: 'idea-lucas.test',
        hmr: {
            host: 'idea-lucas.test',
        },
    },
});


