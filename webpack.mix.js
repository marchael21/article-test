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
	.js('resources/js/datepicker.js', 'public/js')
	.js('resources/js/datetimepicker.js', 'public/js')
	.js('resources/js/fullcalendar.js', 'public/js')
	.js('resources/js/summernote.js', 'public/js')
	.js('resources/js/chosen.js', 'public/js')
	.extract(['vue'])
	.autoload({
	    jquery: ['$', 'window.jQuery', 'jQuery']
	})
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/datepicker.scss', 'public/css')
   .sass('resources/sass/datetimepicker.scss', 'public/css')
   .sass('resources/sass/fullcalendar.scss', 'public/css')
   .sass('resources/sass/summernote.scss', 'public/css')
   .sass('resources/sass/chosen.scss', 'public/css')
   .sass('resources/sass/toastr.scss', 'public/css');
