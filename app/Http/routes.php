<?php


use Spatie\Permission\Models\Role;

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



//TEST
Route::get('/test', function() {
    $role=Role::where('name', 'admin')->first();
    $role->givePermissionTo('edit-societa');
    \Debugbar::info($role);
//    return View::make('cache.test');
});
//FINE TEST






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

    Route::resource('fad', 'fadController');
    Route::resource('aule', 'auleController');


    Route::group(['middleware' => ['role:admin']], function () {
//
        Route::resource('aule_sessioni', 'aule_sessioniController');
    });





    Route::resource('loadcorsi', 'corsiController@loadCorsi');


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




/////LOGIN AS

Route::get('/loginuser', function() {
    $user= \App\User::find(4);
    Auth::login($user);
    return View::make('cache.home_loggato');
});


Route::get('/loginadmin', function() {
    $user= \App\User::find(1);
    Auth::login($user);
    return View::make('cache.home_loggato');
});


Route::get('/loginazienda', function() {
    $user= \App\User::find(5);
    Auth::login($user);
    return View::make('cache.home_loggato');
});


Route::get('/logingestoremultiplo', function() {
    $user= \App\User::find(3);
    Auth::login($user);
    return View::make('cache.home_loggato');
});

Route::get('/loginsuperuser', function() {
    $user= \App\User::find(2);
    Auth::login($user);
    return View::make('cache.home_loggato');
});







/////FINE LOGIN AS