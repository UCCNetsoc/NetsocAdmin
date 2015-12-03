var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
    mix.scriptsIn("resources/assets/js", "public/js/app.js");
});

require('laravel-elixir-browser-sync');
 
elixir(function(mix) {
	mix.browserSync([
	    'public/**/*',
	    'resources/views/**/*'
		], {
		proxy: 'netsocadmin.dev',
		reloadDelay: 500
	});
});