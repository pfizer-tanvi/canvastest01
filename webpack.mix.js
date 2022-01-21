
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

mix.scripts([
  'resources/js/vendor/jquery-migrate.js',
  'resources/js/vendor/jquery-ui.js',
  'resources/js/security/jquery.sessionTimeout.js',
  'resources/js/security/session_timeout.js',
  'resources/js/security/clickjack.js',
], 'public/js/security.js');


mix.js('resources/js/app.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css', {
    implementation: require('node-sass')
  }).sourceMaps();

mix.copyDirectory('resources/images', 'public/images').vue();


if (mix.inProduction()) {
  mix.version();
}
