var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.less('app.less');
    mix.sass('bootstrap.scss');


    mix.copy('bower_components/bootstrap/dist/fonts', 'httpdocs/assets/fonts');
    mix.copy('bower_components/font-awesome/fonts', 'httpdocs/assets/fonts');
    mix.styles([
        'bower_components/bootstrap/dist/css/bootstrap.css',
        'bower_components/fontawesome/css/font-awesome.css',
        'resources/css/sb-admin-2.css',
        'resources/css/timeline.css',

        'resources/css/general.css',
        'resources/css/calendar.css',

        'resources/css/animate.css',
        'resources/css/icomoon.css',

        'resources/css/owl.carousel.min.css',
        'resources/css/owl.theme.default.min.css',
        'resources/css/style.css',

        //DATE PICKER
        'resources/css/jquery-ui.css',



    ], 'httpdocs/assets/stylesheets/styles.css', './');
    mix.scripts([
        'bower_components/jquery/dist/jquery.js',
        'bower_components/bootstrap/dist/js/bootstrap.js',
        // 'bower_components/Chart.js/Chart.js',
        'bower_components/metisMenu/dist/metisMenu.js',
        'resources/js/sb-admin-2.js',
        //'resources/js/frontend.js',

        'resources/js/main.js',
        // 'resources/js/modernizr-2.6.2.min.js',
        'resources/js/modernizr.js',
        'resources/js/owl.carousel.min.js',
        'resources/js/respond.min.js',
        'resources/js/jquery.easing.1.3.js',
        'resources/js/listgroup.js',


        //DATE PICKER
        'resources/js/jquery-ui.js',



        // 'resources/js/bootstrap.js',


    ], 'httpdocs/assets/scripts/frontend.js', './');
});
