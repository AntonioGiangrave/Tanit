<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\societa;
use App\User;

use App\registro_formazione;
use Illuminate\Http\Request;

use Session;

use Spatie\Permission\Models\Role;

use Auth;
use DB;
use Input;
use PDF;



class usersController extends Controller {

    //
    public function index(Request $request) {

        $societa_selezionate=Input::get('societa');

        if ($societa_selezionate)
            Session::put('societa_selezionate', $societa_selezionate);

        $societa_selezionate = Session::get('societa_selezionate');


        //Recupero gli utenti della societa
        $data = User::with('_registro_formazione', '_avanzamento_formazione', 'societa.ateco', 'user_profiles', 'roles' , '_mansioni')->orderBy('cognome');

        if(Auth::user()->hasAnyRole(['azienda'])) {

            //Recupero le societa nel caso fossi gestore multiplo
            $societa = \App\societa::orderBy('ragione_sociale')->whereHas('_tutor', function($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();

            if(empty($societa_selezionate))
                $societa_selezionate = array($societa->first()->id);

            //SOLO UTENTI DELLA SOCIETA RICHIESTA O DELLA PRIMA DELLA LISTA
            $data->whereIn('societa_id', $societa_selezionate);

//            Visualizzo solo i dipendenti
            $data = $data->whereHas('roles', function($query) {
                $query->where('name', 'user');
            });
        }

        if(Auth::user()->hasAnyRole(['admin'])) {
            //Recupero le societa nel caso fossi gestore multiplo
            $societa = \App\societa::orderBy('ragione_sociale')->get();

            if(empty($societa_selezionate))
                $societa_selezionate = array($societa->first()->id);

            //SOLO UTENTI DELLA SOCIETA RICHIESTA O DELLA PRIMA DELLA LISTA
            $data->whereIn('societa_id', $societa_selezionate);
        }

        $data= $data->get();

        $societa = $societa->lists('ragione_sociale', 'id');


        return view('users.index', compact('data'))
            ->with('societa', $societa)
            ->with('societa_selezionate', $societa_selezionate);

    }

    public function user_sync(Request $request){

        //verificare questo campo che gli passo, potrebbe essere sbagliato ma cozzava con la schermata users.index
        $societa_id=explode(",",$request->input('sync_societa_id'));

        $data['elencosocieta'] = \App\societa::whereIn('id',$societa_id)->get();


        $data['users'] = User::whereIn('societa_id', $societa_id)->orderBy('cognome');
        $data['users']= $data['users']->get();

        $data['userslist'] = json_encode($data['users']->lists('id'));

        return view('users.user_sync', $data);
    }

    public function edit($id) {
        $data['datiRecuperati'] = User::with('user_profiles' , '_albi_professionali' , '_incarichi_sicurezza' , '_mansioni', '_tutor_societa')->find($id);

        $data['societa'] = Societa::lists('ragione_sociale', 'id');

        $data['roles'] = Role::lists('name' , 'id');

        /******************************************************************
        DA COMPLETARE !!!!!!
         ******************************************************************/
//        $data['status'] = array(
//            1 => 'Disoccupato' ,
//            2 => 'Occupato Senza datore',
//            3 => 'Occupato tempo determinato'
//        );

        $data['status'] = DB::table('status')->lists('nome', 'id');


        $data['lista_albi'] =   \App\albi_professionali::orderBy('nome')->lists('nome' , 'id');
        $data['lista_incarichi_sicurezza'] =  \App\incarichi_sicurezza::where('id','>', '2')->orderBy('ordinamento')->lists('nome' , 'id');
        $data['lista_mansioni'] =  \App\mansioni::orderBy('nome')->lists('nome' , 'id');
        $data['lista_societa'] =  \App\societa::orderBy('ragione_sociale')->lists('ragione_sociale', 'id');
        $data['esoneri_laurea'] = \App\esoneri_laurea::orderBy('classe_laurea')->lists('classe_laurea', 'id');

//        $data['lista_mansioni'] = \App\mansioni::select(DB::raw("CONCAT(nome,' ', classe_rischio) AS nome, id"))->orderBy('nome')->lists('nome', 'id');

        return view('users.edit', $data);
    }

    public function formazione($id){

        $registro_formazione = new registro_formazione();
        $registro_formazione->sync_utente($id);

        $data['datiRecuperati'] = User::with('_registro_formazione', '_avanzamento_formazione', 'user_profiles')->find($id);


        $data['totaleFormazione']=$data['datiRecuperati']->_registro_formazione()->count();
        $data['totaleFormazioneRuolo']=$data['datiRecuperati']->_registro_formazione_ruolo()->count();
        $data['totaleFormazioneSicurezza']=$data['datiRecuperati']->_registro_formazione_sicurezza()->count();


        $data['avanzamentoFormazione']=$data['datiRecuperati']->_avanzamento_formazione()->count();
        $data['avanzamentoSicurezza']=$data['datiRecuperati']->_get_tot_avanzamento_formazione_sicurezza();
        $data['avanzamentoRuolo']=$data['datiRecuperati']->_get_tot_avanzamento_formazione_ruolo();

        return view('users.formazione', $data);

    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'nome' => 'required'
            , 'cognome' => 'required'
            , 'email' => 'required|email'
        ], [
            'nome.required' => 'Il nome è obbligatorio!'
            , 'cognome.required' => 'Per favore, anche il cognome'
            , 'email.required' => 'E l\'email è importante'
            , 'email.email' => 'L\'email non è in formato corretto'
        ]);

        $user = User::find($id);
        $user->nome = $request->input('nome');
        $user->cognome = $request->input('cognome');
        $user->email = $request->input('email');
        $user->bloccato= $request->input('bloccato');
//        $user->referente_id= $request->input('referente_id');
        $user->societa_id= $request->input('societa_id');

        if($request->input('new_password'))
            $user->password =  bcrypt($request->input('new_password'));

        $user->push();

        $save = $user->user_profiles()->update(array(
            'citta_nascita' => $request->input('citta_nascita'),
            'data_nascita' => $request->input('data_nascita'),
            'classe_rischio' => $request->input('classe_rischio'),
            'sesso' => $request->input('sesso'),
            'codicefiscale' => $request->input('codicefiscale'),
            'nazione_residenza' => $request->input('nazione_residenza'),
            'citta_residenza' => $request->input('citta_residenza'),
            'cap_residenza' => $request->input('cap_residenza'),
            'telefono' => $request->input('telefono'),
            'titolo_studio' => $request->input('titolo_studio'),
            'status_id' => $request->input('status_id'),
            'costo_orario_lordo' => $request->input('costo_orario_lordo'),
            'inquadramento' => $request->input('inquadramento'),
            'ccnl' => $request->input('ccnl'),
            'mansione_ruolo' => $request->input('mansione_ruolo'),
            'divisione' => $request->input('divisione'),


        ));

        if($request->get('groups'))
            $user->groups()->sync($request->get('groups'));

        $user->_albi_professionali()->sync( (array) $request->get('_albi_professionali'));

        $user->_incarichi_sicurezza()->sync( (array) $request->get('_incarichi_sicurezza'));

        $user->_mansioni()->sync( (array) $request->get('_mansioni'));

        $user->_tutor_societa()->sync( (array) $request->get('_tutor_societa'));

        if($request->get('_esoneri_laurea'))
            $user->_esoneri_laurea()->sync( (array) $request->get('_esoneri_laurea'));

        $allinea = new registro_formazione();
        $allinea->sync_utente($id);

        return redirect('/users/'.$user->id.'/edit')->with('ok_message', 'Il profilo è stato aggiornato');
    }

    public function create(){


//        $albi_professionali = \App\albi_professionali::lists('nome', 'id')->all();

//        $data['albi_professionali'] = \App\albi_professionali::lists('nome' , 'id');
//        $data['aule'] = \App\aule::lists('descrizione', 'id')->all();
//        $data['fad'] = \App\fad::lists('descrizione', 'id')->all();

        $data['societa'] = \App\societa::lists('ragione_sociale', 'id')->all();

        return view('users.new', $data);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'nome' => 'required',
            'cognome' => 'required',
            'email' => 'required|email',
        ], [
            'nome.required' => 'Il nomeè obbligatorio',
            'cognome.required' => 'Il cognome è obbligatorio',
            'email.required' => 'L\'email è  obbligatoria'
        ]);

        $data = new \App\User;
        $data->nome= $request->input('nome');
        $data->cognome= $request->input('cognome');
        $data->email = $request->input('email')?: null;
        $data->societa_id= $request->input('societa_id') ?: null;

        if($request->input('new_password'))
            $data->password =  bcrypt($request->input('new_password'));


        $data->save();



        $user_profiles= new \App\user_profiles();
        $user_profiles->user_id= $data->id;
        $user_profiles->id= $data->id;
        $user_profiles->save();


        $data->roles()->attach(['role_id' => 1]);


//        $data->_albi_professionali()->sync();



        return redirect('users/'.$data->id.'/edit')->with('ok_message', 'Dati inseriti, ora puoi personalizzare il profilo');
    }

    public function pdf_libretto_formativo_utente($id)
    {


        $utente =  User::with('_registro_formazione')->find($id);


        if(Auth::user()->hasAnyRole(['admin'])) {

        }
        else{
            $societa_che_controllo = Auth::user()->_tutor_societa->lists('id')->all();
            if(!in_array($utente->societa_id, $societa_che_controllo))
                return view('errors.403');
        }


        $data['utente'] = $utente;
        $pdf = PDF::loadView('users.pdf.libretto_formativo_utente', $data);
        return $pdf->stream();
    }


    public function pdf_stato_formazione()
    {

        $societa_selezionate = Session::get('societa_selezionate', null);

        if(!$societa_selezionate)
            return view('errors.403');

        //Recupero le societa nel caso fossi gestore multiplo
        $societa = \App\societa::whereIn('id', $societa_selezionate);

        //Recupero gli utenti della societa
        $userdata = User::with('_registro_formazione', '_avanzamento_formazione', 'societa.ateco', 'user_profiles', 'roles' , '_mansioni');

        //SOLO UTENTI DELLE SOCIETA IN SESSIONE
        $userdata->whereIn('societa_id', $societa_selezionate);

//            Visualizzo solo i dipendenti
        $userdata = $userdata->whereHas('roles', function($query) {
            $query->where('name', 'user');
        });

        $userdata = $userdata->orderBy('societa_id');


        $data['utenti']= $userdata->get();



        $data['lista_societa']= $societa->get();
        $data['societa_selezionate'] = $societa_selezionate;

        $pdf = PDF::loadView('users.pdf.stato_formazione_aziendale', $data);
        return $pdf->stream();


//        return view('users.pdf.stato_formazione_aziendale', $data);
//            ->with('societa', $societa)
//            ->with('societa_selezionate', $societa_selezionate);
    }


    public function attivazione(Request $request)
    {


        $this->validate($request, [
            'attivazione' => 'required'

        ], [
            'attivazione' => 'Inserisci il codice'

        ]);


        $codice = $request->input('attivazione');
        \Debugbar::info($codice);

        $user = \App\User::where('attivazione', $codice)->first();

        \Debugbar::info($user);

        if($user) {
            $user->bloccato = 0;
            $user->attivazione = '';
            $user->save();

            Auth::login($user);
            return redirect('/home')->with('ok_message', 'Puoi iniziare a gestire la tua Azienda!');
        }
        else
            return back()->withErrors('Codice errato');
    }

    public function destroy($ids)
    {
        // delete


            $user = \App\User::find($id);

            $tmp = $user->nome. " " . $user->cognome;
            $societaid = $user->societa_id;


            $user->groups()->detach();
            $user->_albi_professionali()->detach();
            $user->_incarichi_sicurezza()->detach();
            $user->_mansioni()->detach();
            $user->_tutor_societa()->detach();
            $user->_esoneri_laurea()->detach();

            $userprofile = \App\user_profiles::where('user_id', $id)->delete();
            $res = \App\registro_formazione::where('user_id', $id)->delete();

            $user->delete();
            \Debugbar::info("Cancellato " . $tmp);


        // Redirect
        // Session::flash('message', 'Utente cancellato correttamente');
        return redirect('/users?societa_id='.$societaid)->with('ok_message', 'Il profilo è stato eliminato');
    }

    /**

     * Show the application dashboard.

     *

     * @return \Illuminate\Http\Response

     */

    public function deleteAll(Request $request)
    {
        try {
            $ids = $request->ids;
            $ids = explode(",", $ids);


            foreach ($ids as $id) {
                $user = \App\User::find($id);

                $tmp = $user->nome . " " . $user->cognome;
                $societaid = $user->societa_id;


                $user->groups()->detach();
                $user->_albi_professionali()->detach();
                $user->_incarichi_sicurezza()->detach();
                $user->_mansioni()->detach();
                $user->_tutor_societa()->detach();
                $user->_esoneri_laurea()->detach();

                $userprofile = \App\user_profiles::where('user_id', $id)->delete();
                $res = \App\registro_formazione::where('user_id', $id)->delete();

                $user->delete();
                \Debugbar::info("Cancellato " . $tmp);

            }
            return response()->json(['success' => "Utenti cancellati correttamente."]);
        }
        catch (Exception $e )
        {
            return response()->json(['Error' => "Problemi nell'eliminazione"]);
        }
    }



}
