<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class atecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['ateco'] = \App\ateco::orderBy('codice')->get();

        return view('ateco.index', $data);
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
        $data['datiRecuperati'] = \App\ateco::with('_corsi_sicurezza_specifica', '_corsi_rspp', '_corsi_aspp')->find($id);
        $data['lista_corsi'] = \App\corsi::where('tipo', 'S')->orderBy('titolo')->lists('titolo' , 'id');


\Debugbar::info($data['datiRecuperati']->_corsi_aspp->lists('id')->toArray());


        return view('ateco.edit', $data);
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
            'codice' => 'required',
            'descrizione' => 'required'

        ], [
            'codice.required' => 'Il codice è obbligatorio',
            'descrizione.required' => 'La descrizione è obbligatoria'
        ]);

        $data = \App\ateco::find($id);
        $data->codice= $request->input('codice');
        $data->descrizione = $request->input('descrizione');

        $data->save();


        \Debugbar::info((array) $request->get('_corsi'));

        $data->_corsi_sicurezza_specifica()->sync( (array) $request->get('_corsi_sicurezza_specifica'));
        $data->_corsi_rspp()->sync( (array) $request->get('_corsi_rspp'));
        $data->_corsi_aspp()->sync( (array) $request->get('_corsi_aspp'));


        return redirect('ateco/')->with('ok_message', 'Dati aggiornati');
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
