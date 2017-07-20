<?php

namespace App\Http\Controllers;

use App\corsi;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\registro_formazione;
use DB;
use Auth;
use Session;
use Redirect;
use Mail;
use Input;
use Carbon\Carbon;

class registro_formazioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $societa_selezionate=Input::get('societa');

        if ($societa_selezionate)
            Session::put('societa_selezionate', $societa_selezionate);

        $societa_selezionate = Session::get('societa_selezionate');





        $corsi = registro_formazione::whereNull('data_superamento')->whereNull('sessione_id')->with('_corsi._sessioni' )->groupBy('corso_id');

//        $societa_id=$request->input('societa_id');

        if(Auth::user()->hasRole('azienda')) {


            //elenco per Dropdown sopra
            $societa = \App\societa::orderBy('ragione_sociale')->whereHas('_tutor', function ($query) {
                $query->where('user_id', Auth::user()->id);
            });

            if(empty($societa_selezionate)) {
                $societa_selezionate = array($societa->first()->id);
            }

//            $corsi = $corsi->whereHas('_user', function($query) use($societa_selezionate){
//                $query->whereIn('societa_id',  $societa_selezionate);
//            });


        }


        if(Auth::user()->hasAnyRole(['admin' ])) {

            if(empty($societa_selezionate)) {
                $societa = \App\societa::orderBy('ragione_sociale')->get();
                $societa_selezionate = array($societa->first()->id);
            }

//            $corsi->whereHas('_user', function($query) use($societa_selezionate){
//                $query->whereIn('societa_id', $societa_selezionate);
//            });

            //elenco per Dropdown sopra
            $societa =   \App\societa::orderBy('ragione_sociale')->lists('ragione_sociale', 'id')->toArray();

        }

        $corsi = $corsi->whereHas('_user', function($query) use($societa_selezionate){
            $query->whereIn('societa_id',  $societa_selezionate);
        });

        $corsi = $corsi->select('corso_id' ,DB::raw('count(*) as total'));
        $data['corsi'] = $corsi->get();
        $data['societa'] = $societa;
        $data['societa_selezionate'] = $societa_selezionate;

        return view('registro_formazione.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Debugbar::info(Session()->all());
        \Debugbar::info($_REQUEST);

        $utenti_ids = explode("," , $request->input('id_utenti'));
        $utenti= \App\User::with('societa')->find($utenti_ids);
        $fondo  = \App\fondiprofessionali::findOrfail($_REQUEST['fondo']);
        $sessione = \App\aule_sessioni::find($_REQUEST['id_sessione']);

        foreach ($utenti as $utente){
            //Aggiorno il registro formazione
            DB::table('registro_formazione')
                ->where('user_id', $utente->id)
                ->where('corso_id' ,$sessione->id_corso)
                ->update(['sessione_id' => $sessione->id, 'fondo_id' => $fondo->id]);

//            //Mando la mail a ogni utente
//            Mail::send('emails.conferma_iscrizione_utente', ['user' => $utente->nome, 'sessione' => $sessione], function ($m) use ($utente) {
//                $m->from('info@tanitsrl.it', 'TANIT');
//                $m->to($utente->email, $utente->name);
//                $m->subject('Iscrizione corso formazione');
//            });
        }

        //Mando la mail di riepilogo al tutor.
//        Mail::send('emails.conferma_iscrizione_tutor', ['users' => $utenti, 'sessione' => $sessione, 'fondo' => $fondo], function ($m) use ($utente, $sessione) {
//            $m->from('info@tanitsrl.it', 'TANIT');
//            $m->to($utente->societa->email, $utente->societa->ragione_sociale);
////            $m->to('info@tanit.it', 'Tantit superuser');
//            $m->subject('Nuovi iscritti a '. $sessione->_corso->titolo);
//        });

        $request->session()->forget('sessioneaula_step');
        $request->session()->forget('sessioneaula_id_fondo');
        $request->session()->forget('sessioneaula_id_sessione');


        return Redirect::back()->with('ok_message', 'Nominativi aggiunti correttamente.');
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


        $societa_selezionate=Input::get('societa');

        if ($societa_selezionate)
            Session::put('societa_selezionate', $societa_selezionate);

        $societa_selezionate = Session::get('societa_selezionate');

        if(empty($societa_selezionate)){
            $societa = \App\societa::orderBy('ragione_sociale')->whereHas('_tutor', function($query) {
                $query->where('user_id', Auth::user()->id);
            });

            $societa_selezionate = array($societa->first()->id);
        }

        \Debugbar::info(Session()->all());

        $all_user = \App\User::with('societa', '_mansioni')
            ->whereHas('_registro_formazione', function($query) use($id){
                $query->where('corso_id', $id)->whereNull('data_superamento')->whereNull('sessione_id');
            });

        //Se sono azienda pesco solo le mie societa
        if(Auth::user()->hasAnyRole(['admin'])) {
            $all_user = $all_user->whereIn('societa_id', $societa_selezionate);
        }
        else{
            $all_user = $all_user->whereIn('societa_id', $societa_selezionate);
        }

        $data['utenti']= $all_user ->orderBy('societa_id')->get();
        $data['aziende']= $all_user ->select('societa_id')->distinct()->get();
        $data['mansioni'] = array();

        foreach ($data['utenti'] as $user){
            $data['mansioni'] =  array_merge($data['mansioni'] , $user->_mansioni->pluck('id',  'nome' )->toArray());
        }


        $data['sessioniAula'] = \App\aule_sessioni::where('id_corso', $id)->with('_aula');
        if(Session('sessioneaula_id_fondo'))
            $data['sessioniAula'] = $data['sessioniAula']->whereDate('dal', '>', \Carbon\Carbon::now()->addMonths(2));

        $data['sessioniAula']= $data['sessioniAula']->get();

        $data['fondiprofessionali'] = ['0' => 'Nessun Fondo']+ \App\fondiprofessionali::lists('name','id')->toArray();
        $data['corso'] = \App\corsi::with('_fad')->find($id);

        return view('registro_formazione.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $data_superamento=$_REQUEST['data_superamento'];
        $id_corso =         $_REQUEST['corso_id'];


        if($data_superamento == '')
            $data_superamento = null;


        $corso = \App\corsi::find($id_corso);
        $data_scadenza= null;
        if($corso->scadenza) {
            $data_scadenza =  Carbon::createFromFormat('Y-m-d', $data_superamento, 'Europe/London')->addYear($corso->scadenza)->toDateString();
        }


        DB::table('registro_formazione')
            ->where('user_id', $_REQUEST['user_id'])
            ->where('corso_id' ,$id_corso)
            ->update([
                'data_superamento' => $data_superamento,
                'data_scadenza' => $data_scadenza
            ]);

        return 'true';
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
