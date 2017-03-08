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


        //Recupero gli utenti della societa
        $data = User::with('_registro_formazione', '_avanzamento_formazione', 'societa.ateco', 'user_profiles')->orderBy('cognome');

        if(Auth::user()->hasRole('azienda')) {
            $societa_id=Auth::user()->societa_id;
            $data->where('societa_id', $societa_id);
        }

        if(Auth::user()->hasAnyRole(['admin', 'gestoremultiplo', 'superuser'])) {
            $societa_id=$request->input('societa_id');
            if($societa = \App\societa::find($societa_id))
                $data->where('societa_id', $societa->id);
            else $data->where('societa_id', 1);
        }

        $data= $data->get();

        //Recupero le societa nel caso fossi gestore multiplo
        $societa = \App\societa::orderBy('ragione_sociale')->lists('ragione_sociale', 'id');

        return view('users.index', compact('data'))->with('societa', $societa)->with('societa_id', $societa_id);
    }

    public function edit($id) {
        $data['datiRecuperati'] = User::with('user_profiles' , '_albi_professionali' , '_incarichi_sicurezza' , '_mansioni')->find($id);

        $data['societa'] = Societa::lists('ragione_sociale', 'id');

//        $data['usergroups'] = $usergroups->getTree();
        $data['roles'] = Role::lists('name' , 'id');

        \Debugbar::info($data['roles']);

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
//        $data['lista_mansioni'] = \App\mansioni::select(DB::raw("CONCAT(nome,' ', classe_rischio) AS nome, id"))->orderBy('nome')->lists('nome', 'id');


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

//    public function classe_rischio($id){
//
//        $datiRecuperati = \App\User::find($id);
//        return view('users.edit_classe_rischio', $datiRecuperati);
//
//    }

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

//        $user->groups()->sync($request->get('groups'));

        $user->_albi_professionali()->sync( (array) $request->get('_albi_professionali'));

        $user->_incarichi_sicurezza()->sync( (array) $request->get('_incarichi_sicurezza'));

        $user->_mansioni()->sync( (array) $request->get('_mansioni'));

        $allinea = new registro_formazione();
        $allinea->sync_utente($id);

        return redirect('/users/'.$user->id.'/edit')->with('ok_message', 'Il profilo è stato aggiornato');
    }

}
