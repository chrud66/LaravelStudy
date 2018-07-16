let mix = require('laravel-mix');

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

mix.js(['resources/assets/js/app.js',
        'node_modules/google-code-prettify/src/run_prettify.js',
        'node_modules/select2/src/js/jquery.select2.js',
        ], 'public/js')
    .scripts([
        'resources/assets/js/helper.js',
    ], 'public/js/helper.js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .version();
