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

mix.js('resources/js/app.js', 'public/js')
   	.sass('resources/sass/app.scss', 'public/css')
   	.sass('resources/sass/toastr.scss', 'public/css');

mix.copyDirectory('node_modules/jquery-validation/dist', 'public/node_modules/jquery-validation/dist');

// Backend
mix.js('resources/js/backend/app.js', 'public/js/backend')
	.sass('resources/sass/backend/app.scss', 'public/css/backend');
mix.scripts(['resources/js/backend/my-dt-func.js'], 'public/js/backend/my-dt-func.js');

// Admin Lte
mix.copyDirectory('node_modules/admin-lte/dist', 'public/node_modules/admin-lte/dist');
mix.copyDirectory('node_modules/admin-lte/plugins', 'public/node_modules/admin-lte/plugins');

if (mix.inProduction()) {
    mix.version();
}