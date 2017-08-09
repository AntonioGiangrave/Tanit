<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use PDF;
use DB;
class aule_sessioniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['sessioni'] = \App\aule_sessioni::with('_corso', '_aula' )->orderBy('dal', 'asc')->get();
        return view('aule.aule_sessioni', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $aule = \App\aule::lists('descrizione', 'id');
        $corsi = \App\corsi::orderBy('titolo')->lists('titolo', 'id');

        return view('aule.aule_sessioni_create')
            ->with('aule', $aule)
            ->with('corsi', $corsi);
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
            'descrizione' => 'required'

        ], [
            'descrizione.required' => 'La descrizione è obbligatoria'
        ]);

        $data = new \App\aule_sessioni();
        $data->descrizione= $request->input('descrizione');
        $data->id_corso= $request->input('id_corso');
        $data->id_aula = $request->input('id_aula');
        $data->dal= $request->input('dal') ;
        $data->al= $request->input('al') ;
        $data->orario_dalle= $request->input('orario_dalle');
        $data->orario_alle= $request->input('orario_alle');
        $data->giorni= $request->input('giorni');



        $data->save();

        return redirect('aule_sessioni/'.$data->id.'/edit')->with('ok_message', 'Dati inseriti');
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
        $data['datiRecuperati'] = \App\aule_sessioni::with('_aula', '_corso'  )->find($id);
        $data['aule'] = \App\aule::lists('descrizione' , 'id');
        $data['corsi'] = \App\corsi::lists('titolo', 'id')->all();
        

        return view('aule.aule_sessioni_edit', $data);
    }



    public function pdf_sessione($id)
    {
        $data['sessione'] = \App\aule_sessioni::with('_aula', '_corso'  )->find($id);

        $pdf = PDF::loadView('aule.pdf.riepilogo', $data);

        return $pdf->stream();
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
            'descrizione' => 'required'

        ], [
            'descrizione.required' => 'Il titolo è obbligatorio'
        ]);

        $data =  \App\aule_sessioni::find($id);
        $data->descrizione= $request->input('descrizione');
        $data->id_corso= $request->input('id_corso');
        $data->id_aula = $request->input('id_aula');
        $data->dal= $request->input('dal') ;
        $data->al= $request->input('al') ;
        $data->orario_dalle= $request->input('orario_dalle');
        $data->orario_alle= $request->input('orario_alle');
        $data->giorni= $request->input('giorni');



        $data->save();

        return redirect('aule_sessioni/'.$data->id.'/edit')->with('ok_message', 'Dati aggiornati');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //


        $id_utente = $request->input('id_utente');
        $id_sessione = $request->input('id_sessione');



        DB::table('registro_formazione')
            ->where('user_id', $id_utente)
            ->where('sessione_id' ,$id_sessione)
            ->update([
                'sessione_id' => null

            ]);


//        var_dump($id_sessione);
//        var_dump($id_utente);



        return redirect('aule_sessioni/'.$id_sessione.'/edit')->with('ok_message', 'Dati aggiornati');
    }
}
