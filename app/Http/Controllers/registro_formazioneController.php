<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\registro_formazione;
use DB;
use Auth;
use Session;
use Redirect;


class registro_formazioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $corsi = registro_formazione::whereNull('data_superamento')->whereNull('sessione_id')->with('_corsi._sessioni' )->groupBy('corso_id');


        if(Auth::user()->hasRole('azienda')) {
            $societa_id=Auth::user()->societa_id;
            $corsi = $corsi->whereHas('_user', function($query) use($societa_id){
                $query->where('societa_id', '=' , $societa_id);
            });
        }

        if(Auth::user()->hasAnyRole(['admin', 'gestoremultiplo', 'superuser'])) {
            $societa_id=$request->input('societa_id');
            if($societa = \App\societa::find($societa_id))
                $corsi->whereHas('_user', function($query) use($societa_id){
                    $query->where('societa_id', $societa_id);
                });
        }

        $corsi = $corsi->select('corso_id' ,DB::raw('count(*) as total'));
        $data['corsi'] = $corsi->get();

        //Recupero le societa nel caso fossi gestore multiplo
        $societa =  [''=>'Tutte le società'] + \App\societa::orderBy('ragione_sociale')->lists('ragione_sociale', 'id')->toArray();

        return view('registro_formazione.index', $data)->with('societa', $societa)->with('societa_id', $societa_id);
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
        //

        $utenti= explode(",",$request->input('id_utenti'));

        $fondo = ($_REQUEST['fondo'] == 0) ? null : $_REQUEST['fondo'];

        foreach ($utenti as $utente){
            
            DB::table('registro_formazione')
                ->where('user_id', $utente)
                ->where('corso_id' ,$_REQUEST['id_corso'])
                ->update(['sessione_id' => $_REQUEST['id_sessione'], 'fondo_id' => $fondo]);

        }

//        \Debugbar::log($_REQUEST);

        return Redirect::back();
//        return view('registro_formazione.index' );

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

//        $session_list =$data['sessioniAula']->pluck('id')->toArray();
        $all_user = \App\User::with('societa')
            ->whereHas('_registro_formazione', function($query) use($id){
                $query->where('corso_id', $id)->whereNull('data_superamento')->whereNull('sessione_id');
            });
//            ->whereNotIn('id' , function($query) use($id , $session_list){
//                $query->select('id_utente');
//                $query->from('aule_prenotazioni');
//                $query->whereIn('id_sessione', $session_list );
//            });


        $data['utenti']= $all_user ->orderBy('societa_id')->get();
        $data['aziende']= $all_user ->select('societa_id')->distinct()->get();



        $data['sessioniAula'] = \App\aule_sessioni::where('id_corso', $id)->with('_aula');
        if(Session('sessioneaula.id_fondo'))
            $data['sessioniAula'] = $data['sessioniAula']->whereDate('dal', '>', \Carbon\Carbon::now()->addMonths(2));
        
        
        
        $data['sessioniAula']= $data['sessioniAula']->get();



        $data['fondiprofessionali'] = ['0' => 'Nessun Fondo']+ \App\fondiprofessionali::lists('name','id')->toArray();
        $data['corso'] = \App\corsi::find($id);

        \Debugbar::log(Session('sessioneaula'));

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
        if($data_superamento == '')
            $data_superamento = null;

        \Debugbar::info($data_superamento);


        DB::table('registro_formazione')
            ->where('user_id', $_REQUEST['user_id'])
            ->where('corso_id' ,$_REQUEST['corso_id'])
            ->update(['data_superamento' => $data_superamento ]);

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
