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
    if(Auth::check())
        return View::make('cache.home');
    return View::make('cache.intro');
});








//TEST
Route::get('/test', function() {

    $data['sessioni']=\App\aule_sessioni::take(10)->get();

    $pdf = PDF::loadView('aule.pdf.elenco_sessioni', $data);
//    return $pdf->download('invoice.pdf');
    return $pdf->stream();

});
//FINE TEST




Route::resource('new_societa_demo', 'societaController@create_demo');
Route::resource('societa', 'societaController');

Route::get('/attivazione', function() {
    return View::make('users.attivazione');
});
Route::resource('users/attivazione', 'usersController@attivazione');



Route::group(array('middleware' => 'auth'), function() {


    Route::get('/home', function() {

        if(Auth::user()->hasRole('azienda')){
                return redirect('users');
        }
        else
            return View::make('cache.home_loggato');
    });


    Route::resource('users', 'usersController');
    Route::resource('usersControllerindex', 'usersController@index');
    Route::resource('usersformazione', 'usersController@formazione');
    Route::resource('sync_azienda', 'usersController@user_sync');
    Route::resource('pdf_user_libretto_formativo', 'usersController@pdf_libretto_formativo_utente');
    Route::resource('pdf_stato_formazione', 'usersController@pdf_stato_formazione');
//    Route::get('user_classe_rischio/{id}', function($id){
//        $data['datiRecuperati'] = \App\User::find($id);
//        return View::make('users.edit_classe_rischio', $data);
//    });

    Route::resource('importa', 'importController');
    Route::resource('do_import', 'importController@do_import');


    Route::resource('corsi', 'corsiController');
    Route::resource('mansioni', 'mansioniController');
    Route::resource('ateco', 'atecoController');
    Route::resource('registro_formazione', 'registro_formazioneController');
    Route::resource('registro_formazione_index', 'registro_formazioneController@index');
    
    
    
    
    Route::resource('set_data_superamento', 'registro_formazioneController@update');



    Route::resource('fad', 'fadController');
    Route::resource('aule', 'auleController');


    Route::group(['middleware' => ['role:admin' ]], function () {
        Route::resource('aule_sessioni', 'aule_sessioniController');
        Route::resource('aule_sessioni_del_iscrione', 'aule_sessioniController@destroy');
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

    Route::get('/set_ajax_session  ',function (){
        $var = Input::all();

        if (array_key_exists('sessioneaula_step', $var))
            Session::put('sessioneaula_step', $var['sessioneaula_step']);

        if (array_key_exists('sessioneaula_id_fondo', $var))
            Session::put('sessioneaula_id_fondo', $var['sessioneaula_id_fondo']);

        if (array_key_exists('sessioneaula_id_sessione', $var))
            Session::put('sessioneaula_id_sessione', $var['sessioneaula_id_sessione']);

        return 'true';
    });



    Route::resource('loadcorsi', 'corsiController@loadCorsi');

//    L'HO DISATTIVATO PERCHE' E' TROPPO PESANTE DA RICHIAMARE TUTTA LA SOCIETA' ASSIEME, VA IN TIMEOUT. HO AGGIRATO FACENDO LA CHIAMAATA UN UTENTE ALLA VOLTA CON LA CHIAMATA SOTTO
//    Route::get('sync_azienda/{id}',function ($id){
//        $registro_formazione = new \App\registro_formazione();
//        $registro_formazione->sync_azienda($id);
//        return Redirect::back()->with('ok_message','Formazione dipendenti aggiornata');
//    });


    Route::get('sync_utente/{id}', function($id){
        $registro_formazione = new \App\registro_formazione();
        $registro_formazione->sync_utente($id);
        return 'true';
    });


    Route::get('/get_esoneri_laurea/{id}', function($id){
        $esoneri_laurea = \App\esoneri_laurea::where('id_riferimento', $id)->orderBy('classe_laurea')->lists('classe_laurea', 'id');
//            \Debugbar::info($esoneri_laurea->toArray());


        return json_encode($esoneri_laurea);
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

//Route::get('/loginuser', function() {
//    Session::flush();
//
//    $user= \App\User::find(4);
//    Auth::login($user);
//    return View::make('cache.home_loggato');
//});


Route::get('/PbkXLp6WHp0SkRLSCyWabqfqeCTR2TacCeW1DeW6eSgr790ZS4RV0o768jMu', function() {
    Session::flush();
    $user= \App\User::find(1);
    Auth::login($user);
    return View::make('cache.home_loggato');
});


//Route::get('/loginazienda', function() {
//    Session::flush();
//    $user= \App\User::find(5);
//    Auth::login($user);
//
//    return redirect('/users');
//});


//Route::get('/logingestoremultiplo', function() {
//    Session::flush();
//    $user= \App\User::find(3);
//    Auth::login($user);
//
//    return redirect('/users');
//});


/////FINE LOGIN AS