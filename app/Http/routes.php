<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */



Route::get('/', function() {
    return View::make('cache.home');
});

//Route::get('/home', function() {
//    return View::make('cache.home');
//});


Route::get('/test', function() {

//    $cur = Auth::user();
//    $cur->givePermissionTo('superUser');


    $users = \App\User::all()->take(10);

    return View::make('cache.test')->with('users' , $users);
});



Route::group(array('middleware' => 'auth'), function() {


    Route::get('/home', function() {
        return View::make('cache.home_loggato');
    });


    Route::resource('users', 'usersController');
    Route::resource('usersformazione', 'usersController@formazione');

    Route::resource('societa', 'societaController');
    Route::resource('corsi', 'corsiController');
    Route::resource('mansioni', 'mansioniController');
    Route::resource('ateco', 'atecoController');
    Route::resource('registro_formazione', 'registro_formazioneController');

    //    Route::resource('fad', 'registro_formazioneController');
    //    Route::resource('aule', 'registro_formazioneController');
    Route::resource('aule_sessioni', 'aule_sessioniController');







    Route::resource('loadcorsi', 'corsiController@loadCorsi');



//
//    Route::resource('commesse', 'commesseController');
//    Route::get('userPerCommessa', 'commesseController@userPerCommessa');
//
//
//
//
//    Route::resource('calendario', 'calendarioController');
//    Route::resource('calendario.destroy', 'calendarioController@destroy');
//
//
//    Route::resource('calendar', 'calendarioController@calendar');
//    Route::resource('feriepermessi', 'calendarioController@feriepermessi');
//    Route::resource('approvazione', 'calendarioController@approvazione');
//    Route::resource('rilevazione', 'calendarioController@rilevazione');
//    Route::resource('do_rileva', 'calendarioController@do_rileva');
//
//    Route::resource('google', 'googleController');
//



    //AUTOCOMPLETE
    Route::get('autocomplete/commesse', 'ajaxRequestController@Commesse');


//    Route::get('autocomplete', function() {
//        return View::make('autocomplete');
//    });
});



//    Route::get('/', [
//        'middleware' => 'roles' ,
//        'roles' => 'Users',
//        function() {
//            return View::make('home');
//        }]);
//


Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

