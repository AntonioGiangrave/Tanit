<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class auleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['aule'] = \App\aule::all();
        return view('aule.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data['aule'] = \App\aule::all();

        return view('aule.new', $data);
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
            'descrizione' => 'required',
            'posti' => 'required',
        ], [
            'descriozione.required' => 'Manca la descrizione',
            'posti.required' => 'Indicare il numero di posti. Se fad indica 99999'
        ]);

        $aula = new \App\aule();


        $aula->descrizione= $request->input('descrizione');
        $aula->indirizzo= $request->input('indirizzo');
        $aula->fad= $request->input('fad');
        $aula->posti= $request->input('posti');

        $aula->save();


        $data['aule'] = \App\aule::all();
        return view('aule.index', $data);


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
        $data['datiRecuperati'] = \App\aule::find($id);


        return view('aule.editaula', $data);
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
            'descrizione' => 'required',
            'posti' => 'required',
        ], [
            'descriozione.required' => 'Manca la descrizione',
            'posti.required' => 'Indicare il numero di posti. Se fad indica 99999'
        ]);

        $aula = \App\aule::find($id);


        $aula->descrizione= $request->input('descrizione');
        $aula->indirizzo= $request->input('indirizzo');
        $aula->fad= $request->input('fad');
        $aula->posti= $request->input('posti');

        $aula->save();


        $data['aule'] = \App\aule::all();
        return view('aule.index', $data);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $aula = \App\aule::find($id);

        try {
            $sessioni = \App\aule_sessioni::where('id_aula', $aula->id);
            $sessioni->delete();
            $aula->delete();

        }catch (Exception $e){

            var_dump($e);

            return back()->withErrors('Impossibile cancellare quest\'aula. ');
        }



        return redirect('/aule')->with('ok_message', 'L\'aula è stata eliminata');
    }
}
