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

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/assets/core/common.js', 'public/js')
   .js('resources/js/assets/core/runtime.js', 'public/js')
   .js('resources/js/assets/core/vendor.js', 'public/js')
   .js('resources/js/assets/pages/index.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .postCss('resources/css/assets/index.css', 'public/css', [
        //
    ]);;
