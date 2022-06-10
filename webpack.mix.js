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

//追加分
mix.styles([
    // 'resources/css/index.css',
    'resources/css/bootstrap.min.css'
    // 'resources/css/common/header.css'
], 'public/css/all.css')
    .scripts([
        'resources/js/bootstrap.js',
        'resources/js/bootstrap.min.js',
        // 'resources/js/jquery.home.js',
        // 'resources/js/jquery.slim.min.js',
        // 'resources/js/popper.min.js',
        // 'resources/js/core/approval.js',
        // 'resources/js/core/runtime.js',
        // 'resources/js/core/vendor.js',
        // 'resources/js/pages/index.js',
        'resources/js/common/approval.js',
        'resources/js/common/request.js',
      'resources/js/common/submit.js',
    ],'public/js/all.js')
    .sourceMaps()
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/common/header.scss', 'public/css/scss.css')
    .sass('resources/sass/common/footer.scss', 'public/css/scss.css')
    .sass('resources/sass/post/post.scss', 'public/css/scss.css')
    .sass('resources/sass/blog/blog.scss', 'public/css/blog/blog.css')
    .sass('resources/sass/user/user.scss', 'public/css/user/user.css')
    .sass('resources/sass/site/landing.scss', 'public/css/site/landing.css')
    .sass('resources/sass/proxy/proxy.scss', 'public/css/proxy/proxy.css')
    .sass('resources/sass/common/base.scss', 'public/css/scss.css')
    .sass('resources/sass/event/index.scss', 'public/css/event/index.css')
    .styles('resources/css/sample/sample.css', 'public/css/sample/sample.css')
    .version()
;

//デフォルト
mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/common/calendar.js', 'public/js/common');

mix.js('resources/js/proxy/proxy.js', 'public/js/proxy/proxy.js').react();
mix.js('resources/js/user/user.js', 'public/js/user/user.js').react();

mix.js('resources/js/sample.js', 'public/js/sample').react()
  .js('resources/js/common/selected_game.js', 'public/js/common/selected_game.js')
  .js('resources/js/duel/duel.js', 'public/js/duel/duel.js')
  .sourceMaps()
  .autoload({
    "jquery": ['$', 'window.jQuery'],
  });




