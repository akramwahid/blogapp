require('dotenv').config();
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

mix.js('resources/assets/js/app.js', 'public/js')
    .postCss('resources/assets/css/app.css', 'public/css', [
        //
    ])
    .styles([
        'resources/assets/theme/vendor/metisMenu/dist/metisMenu.css',
        'resources/assets/theme/vendor/animate.css/animate.css',
        'resources/assets/theme/vendor/bootstrap/dist/css/bootstrap.css',
        'resources/assets/theme/styles/menu/css/style.css'
    ], 'public/css/style.css');

// mix.webpackConfig({
//     resolve: {
//         alias: {
//             'vue$': 'vue/dist/vue.runtime.esm.js'
//         }
//     }
// });

