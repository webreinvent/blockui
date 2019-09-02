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

mod_blockui= "Modules/Blockui/Resources/views";
mix.sass('resources/sass/app.scss', 'public/css')
    .combine([
        mod_blockui+'/vendor/nprogress/nprogress.css',
        mod_blockui+'/vendor/alertify/alertify.css',
    ], 'public/css/blockui-vendor.css')
    .combine([
        mod_blockui+'/vendor/nprogress/nprogress.js',
        mod_blockui+'/vendor/alertify/alertify.js',
    ], 'public/js/blockui-vendor.js')
    .js(mod_blockui+'/frontend/theme-v1/assets/js/blockui.js', 'public/js')
    .sass(mod_blockui+'/frontend/theme-v1/assets/sass/blockui.scss', 'public/css')
    .version();
