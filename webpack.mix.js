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

//デフォルト
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

//追加分
mix.styles([
    // 'resources/css/index.css',
    'resources/css/bootstrap.min.css'
    // 'resources/css/common/header.css'
], 'public/css/all.css')
    .scripts([
        'resources/js/bootstrap.js',
        'resources/js/bootstrap.min.js',
        'resources/js/jquery.home.js',
        'resources/js/jquery.slim.min.js',
        'resources/js/popper.min.js',
        'resources/js/core/approval.js',
        'resources/js/core/runtime.js',
        'resources/js/core/vendor.js',
        'resources/js/pages/index.js',
        'resources/js/common/approval.js',
        'resources/js/common/jquery.js',
    ],'public/js/all.js')
    .sourceMaps()
    .sass('resources/sass/common/header.scss', 'public/css/scss.css')
    .sass('resources/sass/common/footer.scss', 'public/css/scss.css')
    .sass('resources/sass/post/post.scss', 'public/css/scss.css')
    .sass('resources/sass/common/base.scss', 'public/css/scss.css')
    .version()
;


