import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/admin-dashboard.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/sb-admin-2.css',
                'resources/vendor/fontawesome-free/css/all.min.css',
                'resources/vendor/jquery/jquery.min.js',
                'resources/vendor/bootstrap/js/bootstrap.bundle.min.js',
                'resources/vendor/jquery-easing/jquery.easing.min.js',
                'resources/js/sb-admin-2.min.js',
                'resources/vendor/chart.js/Chart.min.js',
                'resources/js/demo/chart-area-demo.js',
                'resources/js/demo/chart-pie-demo.js',
            ],
            refresh: true,

            //for me using docker sail
            server: {//allow container-based access, like this:
                host: '0.0.0.0',
                port: 5173,
                hmr: {
                    host: 'localhost',
                },
            },
        }),
    ],
});
