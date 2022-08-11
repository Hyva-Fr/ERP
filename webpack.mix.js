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
    .js('resources/js/dimmers/script.js', 'public/js/dimmers.js')
    .js('resources/js/widgets/index.js', 'public/js/widgets.js')
    .copyDirectory('vendor/tinymce/tinymce', 'public/js/tinymce')
    .postCss('resources/css/app.css', 'public/css', [
        //
    ])
    .postCss('resources/css/dimmers/index.css', 'public/css/dimmers.css', [
        //
    ])
    .postCss('resources/css/widgets/index.css', 'public/css/widgets.css', [
        //
    ]);

if (mix.inProduction()) {
    mix.version();
}
