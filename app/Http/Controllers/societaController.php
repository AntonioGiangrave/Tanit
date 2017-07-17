<?php

namespace App\Http\Controllers;

use App\registro_formazione;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\societa;
use Auth;
use Mail;


class societaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['societa'] = societa::with('ateco' );

        if(Auth::user()->hasAnyRole(['admin'])) {

        }
        else{
            $data['societa'] = $data['societa']->whereHas('_tutor', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });
        }

        $data['societa']->orderBy('ragione_sociale');

        $data['societa'] = $data['societa']->get();


        return view('societa.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['lista_ateco'] =   \App\ateco::lists('codice' , 'id');
        $data['lista_settori'] = \App\settori::lists('settore' , 'id');
        $data['lista_fondi'] = \App\fondiprofessionali::lists('name' , 'id');

        return view('societa.new', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_demo()
    {

        $data['lista_ateco'] =   \App\ateco::lists('codice' , 'id');
        $data['lista_settori'] = \App\settori::lists('settore' , 'id');
        $data['lista_fondi'] = \App\fondiprofessionali::lists('name' , 'id');

        return view('societa.new_demo', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        {
            $this->validate($request, [
                'ragione_sociale' => 'required',
                'email' => 'required|email',
            ], [
                'ragione_sociale.required' => 'La ragione sociale è obbligatoria',
                'email.required' => 'L\'email è  obbligatoria'
            ]);

            $societa = new \App\societa;

            $societa->ragione_sociale= $request->input('ragione_sociale');
            $societa->ateco_id= $request->input('ateco_id');
            $societa->descrizione_attivita = $request->input('descrizione_attivita');
            $societa->ref_aziendale= $request->input('ref_aziendale');
            $societa->n_dipendenti= $request->input('n_dipendenti');
            $societa->piva= $request->input('piva');
            $societa->cod_fiscale= $request->input('cod_fiscale');
            $societa->email= $request->input('email');
            $societa->pec= $request->input('pec');
            $societa->indirizzo_sede_legale= $request->input('indirizzo_sede_legale');
            $societa->telefono= $request->input('telefono');
            $societa->cellulare= $request->input('cellulare');
            $societa->cap= $request->input('cap');
            $societa->regione= $request->input('regione');
            $societa->sito= $request->input('sito');
            $societa->fondo_id= $request->input('fondo_id');

            if($request->input('demo')==1)
                $societa->demo= 1;

            $societa->save();


//            CREO L'UTENTE TUTOR DELL'AZIENDA
            $tutor= new \App\User;
            $tutor->name= '['.$societa->ragione_sociale.']';
            $tutor->nome = 'Tutor'. '['.$societa->ragione_sociale.']';
            $tutor->cognome = 'Tutor' . '['.$societa->ragione_sociale.']';
            $tutor->email=$societa->email;
            $tutor->societa_id=$societa->id;
            $tutor->password = bcrypt($societa->piva);
            $tutor->attivazione = uniqid();
            
            $tutor->bloccato = 1;

            //Mando la mail di attivazione
            Mail::send('emails.attivazione_soc', ['tutor' => $tutor, 'societa' => $societa], function ($m) use ($tutor) {
                $m->from('info@tanitsrl.it', 'TANIT');
                $m->to($tutor->email, $tutor->nome);
                $m->subject('Attivazione account');
            });


            $tutor->save();

//            CREO L'ANAGRAFICA
            $user_profiles= new \App\user_profiles();
            $user_profiles->user_id= $tutor->id;
            $user_profiles->id= $tutor->id;
            $user_profiles->save();

//            GLI ASSEGNO AI GRUPPI AZIENDA E DEMO OPZIONALE
            $tutor->roles()->attach(['role_id' => 3]); //AZIENDA
            if($request->input('demo')==1)
                $tutor->roles()->attach(['role_id' => 4]); //DEMO

//            GLI ASSEGNO COME TUTOR DELL'AZIENDA DEMO
            $tutor->_tutor_societa()->attach(['societa_id' => $societa->id]);


//            CREO UTENTI DEMO
            if($request->input('demo')==1){
                $nomi = ['Mario', 'Stefano', 'Martina', 'Francesca', 'Angelo', 'Paolo', 'Martina', 'Mattia', 'Massimo'];
                $cognomi = ['Rossi', 'Picasso', 'Cafiero', 'Bianchi', 'Resato', 'Stagnari', 'Ressotti', 'Lombardi', 'Cersoli' ];

                for ($i = 0; $i<=3 ; $i++){
                    $user_demo= new \App\User;
                    $user_demo->nome = $nomi[array_rand($nomi)];
                    $user_demo->cognome = $cognomi[array_rand($cognomi)];
                    $user_demo->name = $user_demo->nome.".".$user_demo->cognome;
                    $email = strtolower(substr($user_demo->nome, 0 , 1).".".$user_demo->nome."@test.".$societa->ragione_sociale.".it");
//                    $user_demo->email=preg_replace("/[^A-Za-z0-9?!]/",'',$email);
                    $user_demo->email = filter_var($email, FILTER_SANITIZE_EMAIL);

                    $user_demo->societa_id=$societa->id;
                    $user_demo->password = bcrypt($user_demo->email);
                    $user_demo->save();


                    $user_demo_profiles= new \App\user_profiles();
                    $user_demo_profiles->user_id= $user_demo->id;
                    $user_demo_profiles->id= $user_demo->id;
                    $user_demo_profiles->save();

//                    GRUPPO USER
                    $user_demo->roles()->attach(['role_id' => 1]);


                }
//NON lo faccio accedere perchè prima deve attivare
//                Auth::login($tutor);
            }

            return redirect('attivazione');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

//        $allinea = new registro_formazione();
//        $allinea->sync_azienda($id);

        $data['datiRecuperati'] = \App\societa::with('ateco', '_settori' )->find($id);

        $data['utentiSocieta'] = \App\User::with('_registro_formazione' , '_avanzamento_formazione' )->where('societa_id',$id)->orderBy('cognome' , 'asc')->get();

        $data['lista_ateco'] =   \App\ateco::lists('codice' , 'id');
        $data['lista_settori'] = \App\settori::lists('settore' , 'id');
        $data['lista_fondi'] = \App\fondiprofessionali::lists('name' , 'id');

        return view('societa.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'ragione_sociale' => 'required'
            ,'tipo' => 'required'
            ,'piva' => 'required'
            ,'ateco_id' => 'required'
        ], [
            'ragione_sociale.required' => 'La ragione sociale è obbligatoria!'
            ,'tipo.required' => 'Per favore, anche il tipo'
            ,'piva.required' => 'La partita IVA è obbligatoria'
            ,'ateco_id.required' => 'L\'ateco è Obbligatorio'
//            ,'email.email' => 'L\'email non è in formato corretto'
        ]);

        $soc = \App\societa::find($id);
        $soc->ragione_sociale = $request->input('ragione_sociale');
        $soc->tipo = $request->input('tipo');
        $soc->descrizione_attivita = $request->input('descrizione_attivita');
        $soc->indirizzo_sede_legale= $request->input('indirizzo_sede_legale');
        $soc->n_dipendenti= $request->input('n_dipendenti');

        $soc->piva= $request->input('piva');
        $soc->cod_fiscale= $request->input('cod_fiscale');
        $soc->telefono= $request->input('telefono');
        $soc->cellulare= $request->input('cellulare');
        $soc->email= $request->input('email');
        $soc->citta= $request->input('citta');
        $soc->cap= $request->input('cap');
        $soc->regione= $request->input('regione');
        $soc->sito= $request->input('sito');
        $soc->ref_aziendale= $request->input('ref_aziendale');
        $soc->ateco_id= $request->input('ateco_id');
        $soc->settore_id= $request->input('settore_id');
        $soc->so_indirizzo= $request->input('so_indirizzo');
        $soc->so_citta= $request->input('so_citta');
        $soc->so_cap= $request->input('so_cap');

        $soc->fondo_id= $request->input('fondo_id');
//        $soc->fondo_interprofessionale= $request->input('fondo_interprofessionale');
//        $soc->fi_dipendenti= $request->input('fi_dipendenti');
//        $soc->fi_dirigenti= $request->input('fi_dirigenti');

        $soc->save();

        return redirect('societa/'.$soc->id.'/edit')->with('ok_message', 'Dati aggiornati');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
