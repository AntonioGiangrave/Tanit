<?php

namespace App\Http\Controllers;

use App\registro_formazione;
use Illuminate\Http\Request;

use App\Http\Requests;

class societaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['societa'] = \App\societa::with('ateco' )->orderBy('ragione_sociale')->get();
        
        

        return view('societa.index', $data);
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

        $allinea = new registro_formazione();
        $allinea->sync_azienda($id);

        $data['datiRecuperati'] = \App\societa::with('ateco', '_settori' )->find($id);
        $data['utentiSocieta'] = \App\User::with('_registro_formazione' , '_avanzamento_formazione')->where('societa_id',$id)->orderBy('cognome' , 'asc')->get();

        $data['lista_ateco'] = \App\ateco::lists('codice' , 'id');
        $data['lista_settori'] = \App\settori::lists('settore' , 'id');

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
        ], [
            'ragione_sociale.required' => 'La ragione sociale è obbligatoria!'
            ,'tipo.required' => 'Per favore, anche il tipo'
            ,'piva.required' => 'La partita IVA è obbligatoria'
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
        $soc->fondo_interprofessionale= $request->input('fondo_interprofessionale');
        $soc->fi_dipendenti= $request->input('fi_dipendenti');
        $soc->fi_dirigenti= $request->input('fi_dirigenti');

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
