<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class mansioniController extends Controller
{


    public function __construct()
    {
//        $this->middleware('groups');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['mansioni'] = \App\mansioni::with('_settore')->orderBy('nome')->get();

        return view('mansioni.index', $data);
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
        $this->validate($request, [
            'nome' => 'required'

        ], [
            'nome.required' => 'Il nome è obbligatorio'
        ]);

        $data = new \App\mansioni;
        $data->nome= $request->input('titolo');
        $data->settore_id = $request->input('settore_id');

        $data->save();

        $data->_corsi()->sync( (array) $request->get('_corsi'));

        return redirect('mansioni/')->with('ok_message', 'Dati inseriti');
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
        $data['datiRecuperati'] = \App\mansioni::with('_corsi', '_settore')->find($id);
        $data['lista_corsi'] = \App\corsi::where('tipo','R')->orderBy('titolo')->lists('titolo' , 'id');
        $data['lista_settori'] = \App\settori::lists('settore' , 'id');
        return view('mansioni.edit', $data);
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
            'nome' => 'required'

        ], [
            'nome.required' => 'Il nome è obbligatorio'
        ]);

        $data = \App\mansioni::find($id);
        $data->nome= $request->input('nome');
        $data->settore_id = $request->input('settore_id');

        $data->save();


        \Debugbar::info((array) $request->get('_corsi'));

        $data->_corsi()->sync( (array) $request->get('_corsi'));


        return redirect('mansioni/')->with('ok_message', 'Dati inseriti');
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
