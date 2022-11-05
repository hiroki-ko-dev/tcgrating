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
    'resources/css/bootstrap.min.css'
], 'public/css/all.css')
    .scripts([
        // 'resources/js/bootstrap.js',
        'resources/js/bootstrap.min.js',
        'resources/js/common/approval.js',
        'resources/js/common/request.js',
      'resources/js/common/submit.js',
    ],'public/js/all.js')
    .sourceMaps()
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/common/header.scss', 'public/css/scss.css')
    .sass('resources/sass/common/footer.scss', 'public/css/scss.css')
    .sass('resources/sass/post/show.scss', 'public/css/post/show.css')
    .sass('resources/sass/post/index.scss', 'public/css/post/index.css')
    .sass('resources/sass/blog/index.scss', 'public/css/blog/index.css')
    .sass('resources/sass/blog/show.scss', 'public/css/blog/show.css')
    .sass('resources/sass/resume/resume.scss', 'public/css/resume/resume.css')
    .sass('resources/sass/item/index.scss', 'public/css/item/index.css')
    .sass('resources/sass/item/show.scss', 'public/css/item/show.css')
    .sass('resources/sass/item/cart/index.scss', 'public/css/item/cart/index.css')
    .sass('resources/sass/item/transaction/index.scss', 'public/css/item/transaction/index.css')
    .sass('resources/sass/site/landing.scss', 'public/css/site/landing.css')
    .sass('resources/sass/proxy/proxy.scss', 'public/css/proxy/proxy.css')
    .sass('resources/sass/common/base.scss', 'public/css/scss.css')
    .sass('resources/sass/event/index.scss', 'public/css/event/index.css')
    .sass('resources/sass/duel/show.scss', 'public/css/duel/show.css')
    .styles('resources/css/sample/sample.css', 'public/css/sample/sample.css')
    .version()
;

//デフォルト
mix.js('resources/js/app.js', 'public/js')
  .js('resources/js/common/calendar.js', 'public/js/common');

mix.js('resources/js/proxy/proxy.js', 'public/js/proxy/proxy.js').react();
mix.js('resources/js/resume/resume.js', 'public/js/resume/resume.js').react();
// mix.js('resources/js/event/calendar.js', 'public/js/event/calendar.js').react();

mix.js('resources/js/sample.js', 'public/js/sample').react()
  .js('resources/js/common/selected_game.js', 'public/js/common/selected_game.js')
  .js('resources/js/duel/duel.js', 'public/js/duel/duel.js')
  .js('resources/js/item/index.js', 'public/js/item/index.js')
  .js('resources/js/item/cart/index.js', 'public/js/item/cart/index.js')
  .sourceMaps()
  .autoload({
    "jquery": ['$', 'window.jQuery'],
  });

mix.ts('resources/ts/app.tsx', 'public/js/tsx').react();
