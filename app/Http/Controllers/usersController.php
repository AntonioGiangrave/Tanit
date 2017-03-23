<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\societa;
use App\User;

use App\registro_formazione;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;

use Auth;
use DB;


class usersController extends Controller {

    //
    public function index(Request $request) {

        $societa_id=$request->input('societa_id');

        //Recupero gli utenti della societa
        $data = User::with('_registro_formazione', '_avanzamento_formazione', 'societa.ateco', 'user_profiles', 'roles' , '_mansioni')->orderBy('cognome');


        if(Auth::user()->hasAnyRole(['azienda'])) {

            //Recupero le societa nel caso fossi gestore multiplo
            $societa = \App\societa::orderBy('ragione_sociale')->whereHas('_tutor', function($query) {
                $query->where('user_id', Auth::user()->id);
            })->get();

            \Debugbar::info($societa);

            if(!$societa_id)
                $societa_id = $societa->first()->id;

            //SOLO UTENTI DELLA SOCIETA RICHIESTA O DELLA PRIMA DELLA LISTA
            $data->where('societa_id', $societa_id);

//            Visualizzo solo i dipendenti
            $data = $data->whereHas('roles', function($query) {
                $query->where('name', 'user');
            });
        }

        if(Auth::user()->hasAnyRole(['admin', 'superuser'])) {
            //Recupero le societa nel caso fossi gestore multiplo
            $societa = \App\societa::orderBy('ragione_sociale')->get();

            if(!$societa_id)
                $societa_id = $societa->first()->id;

            //SOLO UTENTI DELLA SOCIETA RICHIESTA O DELLA PRIMA DELLA LISTA
            $data->where('societa_id', $societa_id);

        }

        $data= $data->get();

        $societa = $societa->lists('ragione_sociale', 'id');


        return view('users.index', compact('data'))->with('societa', $societa)->with('societa_id', $societa_id);
    }

    public function user_sync(Request $request){

        //verificare questo campo che gli passo, potrebbe essere sbagliato ma cozzava con la schermata users.index
        $societa_id=$request->input('sync_societa_id');

        $data['societa'] = \App\societa::find($societa_id);

        $data['users'] = User::where('societa_id', $societa_id)->orderBy('cognome');
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
        $data['status'] = array(
            1 => 'Disoccupato' ,
            2 => 'Occupato Senza datore',
            3 => 'Occupato tempo determinato'
        );

        $data['lista_albi'] =   \App\albi_professionali::orderBy('nome')->lists('nome' , 'id');
        $data['lista_incarichi_sicurezza'] =  \App\incarichi_sicurezza::where('id','>', '2')->orderBy('ordinamento')->lists('nome' , 'id');
        $data['lista_mansioni'] =  \App\mansioni::orderBy('nome')->lists('nome' , 'id');
        $data['lista_societa'] =  \App\societa::orderBy('ragione_sociale')->lists('ragione_sociale', 'id');
//        $data['lista_mansioni'] = \App\mansioni::select(DB::raw("CONCAT(nome,' ', classe_rischio) AS nome, id"))->orderBy('nome')->lists('nome', 'id');


        \Debugbar::info($data['datiRecuperati']->_tutor_societa->toArray());

        return view('users.edit', $data);
    }

    public function formazione($id){

        $registro_formazione = new registro_formazione();
        $registro_formazione->sync_utente($id);

        $data['datiRecuperati'] = User::with('_registro_formazione', '_avanzamento_formazione', 'user_profiles')->find($id);

        $data['totaleFormazione']=$data['datiRecuperati']->_registro_formazione->count();
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
        $user->referente_id= $request->input('referente_id');
        $user->societa_id= $request->input('societa_id');

        $user->user_profiles->classe_rischio = $request->input('classe_rischio');

        $user->push();

        $user->groups()->sync($request->get('groups'));

        $user->_albi_professionali()->sync( (array) $request->get('_albi_professionali'));

        $user->_incarichi_sicurezza()->sync( (array) $request->get('_incarichi_sicurezza'));

        $user->_mansioni()->sync( (array) $request->get('_mansioni'));

        $user->_tutor_societa()->sync( (array) $request->get('_tutor_societa'));

        $allinea = new registro_formazione();
        $allinea->sync_utente($id);

        return redirect('/users/'.$user->id.'/edit')->with('ok_message', 'Il profilo è stato aggiornato');
    }

}
