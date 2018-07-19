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

/*mix.js(['resources/assets/js/app.js',
        'node_modules/google-code-prettify/src/run_prettify.js',
        'node_modules/select2/src/js/jquery.select2.js',
        ], 'public/js')
    */
mix.js(['resources/assets/js/app.js',
        'node_modules/select2/src/js/jquery.select2.js',
        ], 'public/js/alljs.js')

    .scripts(['node_modules/fastclick/lib/fastclick.js',
            'node_modules/jquery-tabby/jquery.textarea.js',
            'node_modules/autosize/dist/autosize.js',
            'node_modules/highlightjs/highlight.pack.js',
            'node_modules/marked/lib/marked.js',
            'resources/assets/js/helpers.js',
        ], 'public/js/allscripts.js')

    .sass('resources/assets/sass/app.scss', 'public/css/allsass.css')

    .styles(['resources/assets/vendor/earthsong.css',
        ], 'public/css/allstyles.css')

    .combine(['public/js/alljs.js',
            'public/js/allscripts.js',
        ], 'public/js/app.js')

    .combine(['public/css/allsass.css',
            'public/css/allstyles.css',
        ], 'public/css/app.css')

    .version();
