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

    $data['sessioni']=\App\aule_sessioni::take(10)->get();

    $pdf = PDF::loadView('aule.pdf.elenco_sessioni', $data);
//    return $pdf->download('invoice.pdf');
    return $pdf->stream();

});
//FINE TEST






Route::group(array('middleware' => 'auth'), function() {


    Route::get('/home', function() {
        return View::make('cache.home_loggato');
    });


    Route::resource('users', 'usersController');
    Route::resource('usersformazione', 'usersController@formazione');
//    Route::get('user_classe_rischio/{id}', function($id){
//        $data['datiRecuperati'] = \App\User::find($id);
//        return View::make('users.edit_classe_rischio', $data);
//    });

    Route::resource('societa', 'societaController');
    Route::resource('corsi', 'corsiController');
    Route::resource('mansioni', 'mansioniController');
    Route::resource('ateco', 'atecoController');
    Route::resource('registro_formazione', 'registro_formazioneController');
    Route::resource('set_data_superamento', 'registro_formazioneController@update');



    Route::resource('fad', 'fadController');
    Route::resource('aule', 'auleController');


    Route::group(['middleware' => ['role:superuser' ]], function () {
        Route::resource('aule_sessioni', 'aule_sessioniController');
        
        //pdf riepilog info sessione e registro.
        Route::resource('aule_sessioni_pdf', 'aule_sessioniController@pdf_sessione');
//        Route::resource('aule_sessioni_uploadpdf', 'aule_sessioniController@pdf_sessione');

        Route::post('aule_sessioni_uploadpdf', function(){
            $files = Input::file('pdf');
            $id = Input::get('id');
            $name = Input::get('name');
            foreach($files as $file) {
                $destinationPath = public_path() .'/uploads/'.$id.'/';
//                $filename = $file->getClientOriginalName();
                $filename = 'SCHEDA CORSO '.$name.'.pdf';
                $file->move($destinationPath, $filename);
            }
            return Redirect::back();
        });

        
        
    });
    
    Route::get('/set_ajax_session/',function (){
        $var = Input::all();

//        \Debugbar::log(Session::all());
        \Debugbar::log($var);

        foreach ($var['data_session'] as $key => $val) {
            Session::put($key, $val);
        }

        return 'true';
    });



    Route::resource('loadcorsi', 'corsiController@loadCorsi');

    Route::get('sync_azienda/{id}',function ($id){
        $registro_formazione = new \App\registro_formazione();
        $registro_formazione->sync_azienda($id);
        return Redirect::back()->with('ok_message','Formazione dipendenti aggiornata');
    });








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