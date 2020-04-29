const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
    'public/css/white-dashboard.css?v=1.0.0',
    'public/css/theme.css'
], 'public/css/all.css')
.js([
    'resources/js/app.js',  
    'node_modules/jquery/dist/jquery.min.js',
    'node_modules/popper.js/dist/popper.js',
    'node_modules/bootstrap/dist/js/bootstrap.min.js',
    'public/js/plugins/perfect-scrollbar.jquery.min.js',
    'public/js/plugins/bootstrap-notify.js',
    'public/js/theme.js',
    'public/js/white-dashboard.min.js?v=1.0.0',
], 'public/js/all.js')
.browserSync('http://lafil_tracking_system_customer.local');