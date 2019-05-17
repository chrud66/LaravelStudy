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

/*mix.js(['resources/js/app.js',
        'node_modules/google-code-prettify/src/run_prettify.js',
        'node_modules/select2/src/js/jquery.select2.js',
        ], 'public/js')
    */
mix.js(['resources/js/app.js',
        'node_modules/select2/src/js/jquery.select2.js',
        ], 'public/js/alljs.js')

    .js(['resources/js/admin/admin.js'
        ], 'public/js/admin')

    .scripts(['node_modules/fastclick/lib/fastclick.js',
            'node_modules/jquery-tabby/jquery.textarea.js',
            'node_modules/autosize/dist/autosize.js',
            'node_modules/highlightjs/highlight.pack.js',
            'node_modules/marked/lib/marked.js',
            'resources/js/helpers.js',
        ], 'public/js/allscripts.js')

    .sass('resources/sass/app.scss', 'public/css/allsass.css')

    .sass('resources/sass/admin.scss', 'public/css/admin')

    .styles(['resources/vendor/earthsong.css',
        ], 'public/css/allstyles.css')

    .combine(['public/js/alljs.js',
            'public/js/allscripts.js',
        ], 'public/js/app.js')

    .combine(['public/css/allsass.css',
            'public/css/allstyles.css',
        ], 'public/css/app.css')

    .version();
