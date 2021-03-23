const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
        'resources/css/index.css',
        'resources/css/bootstrap.min.css'
        // 'resources/css/common/header.css'
    ], 'public/css/all.css')
    .scripts([
        'resources/js/bootstrap.js',
        'resources/js/bootstrap.min.js',
        'resources/js/jquery.home.js',
        'resources/js/jquery.slim.min.js',
        'resources/js/popper.min.js',
        'resources/js/core/commons.js',
        'resources/js/core/runtime.js',
        'resources/js/core/vendor.js',
        'resources/js/pages/index.js',
    ],'public/js/all.js')
    .sass('resources/sass/common/header.scss', 'public/css/scss.css');

