<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class corsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['corsi'] = \App\corsi::orderBy('titolo')->with('_proprietario', '_aula', '_fad')->get();

        return view('corsi.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

//        $albi_professionali = \App\albi_professionali::lists('nome', 'id')->all();

        $data['albi_professionali'] = \App\albi_professionali::lists('nome' , 'id');
        $data['aule'] = \App\aule::lists('descrizione', 'id')->all();
        $data['fad'] = \App\fad::lists('descrizione', 'id')->all();

        return view('corsi.new', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'titolo' => 'required'

        ], [
            'titolo.required' => 'Il titolo è obbligatorio'
        ]);

        $data = new \App\corsi;
        $data->titolo = $request->input('titolo');
        $data->durata = $request->input('durata');
        $data->aula = $request->input('aula')?: null;
        $data->fad= $request->input('fad') ?: null;
        $data->cfp= $request->input('info_cfp') ;
        $data->validita= $request->input('validita');
        $data->programma= $request->input('programma');



        $data->save();

        return redirect('corsi/'.$data->id.'/edit')->with('ok_message', 'Dati inseriti');
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
        $data['datiRecuperati'] = \App\corsi::with('_proprietario', '_aula')->find($id);
        $data['albi_professionali'] = \App\albi_professionali::lists('nome' , 'id');
        $data['aule'] = \App\aule::lists('descrizione', 'id')->all();
        $data['fad'] = \App\fad::lists('descrizione', 'id')->all();
        return view('corsi.edit', $data);
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
            'titolo' => 'required'

        ], [
            'titolo.required' => 'Il titolo è obbligatorio'
        ]);

        $data = \App\corsi::find($id);
        $data->titolo = $request->input('titolo');
        $data->durata = $request->input('durata');
        $data->aula = $request->input('aula')?: null;
        $data->fad= $request->input('fad') ?: null;
        $data->cfp= $request->input('info_cfp');
        $data->validita= $request->input('validita');
        $data->programma= $request->input('programma');
        $data->tipo= $request->input('tipo');

        $data->save();

        return redirect('corsi/'.$data->id.'/edit')->with('ok_message', 'Dati aggiornati');
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

    public function loadCorsi(){

        ini_set('max_execution_time', 900); //300 seconds = 5 minutes
        $items = DB::table('_trasposter')->get();
        $table = 'ateco_corsi_aspp';
        $campo1 = 'ateco_id';
        $campo2 = 'corso_id';

        foreach ($items as $corsi)
        {
            $corsi = (array)$corsi;
            $id = array_shift($corsi);
            echo "<pre>";
            foreach ($corsi as $corso){
                if((int)$corso && (int)$id) {
                    DB::insert('INSERT IGNORE INTO ' . $table . ' ( '.$campo1.' , '.$campo2.') values (' . $id . '  , ' . $corso . ')');
                    echo "+";
                }
                else
                    echo "-";
            }
            echo "</pre>";
        }
    }
}