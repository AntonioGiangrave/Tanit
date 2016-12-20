<?php

namespace App\Http\Controllers;

use App\commesse;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\calendario;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Mail;
use Spatie\GoogleCalendar\Event;

class calendarioController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        //
        $data['mostUsed'] = calendario::take(5)
            ->where('dipendenti_id',  Auth::user()->id)
            ->where('commessa_id', ">" ,  1)
            ->with('commessa')
            ->orderBy('giorno', 'desc')
            ->distinct()
            ->get();


        Debugbar($data['mostUsed']);

        return view('calendario.create', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //

        return $this->index();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // 
        \Debugbar::info('store');

        $this->validate($request, [
            'dipendenti_id' => 'required'
            , 'commessa_id' => 'required'
            , 'n_ore' => 'required'
            , 'giorno' => 'required'
        ], [
            'dipendenti_id.required' => 'dipendenti_id me lo devi dire'
            , 'commessa_id.required' => 'Se non mi dici per cosa è la commessa è inutile'
            , 'n_ore.required' => 'Inserisci il numero di ore'
            , 'giorno.required' => 'Insrisci il giorno'
        ]);

        $calendario = new \App\calendario();

        $calendario->dipendenti_id = $request->input('dipendenti_id');
        $calendario->commessa_id = $request->input('commessa_id');
        $calendario->n_ore = $request->input('n_ore');


        $giorno = $request->input('giorno');
        $ora = $request->input('dalle_ore');

        $calendario->giorno = Carbon::createFromFormat('Y-m-d H', $giorno.' '. $ora );

        $calendario->type= $request->input('type');


        //        1 Ferie**
        //        2 Permesso**
        //        3 Straordinario **
        //        4 Recupero+
        //        5 Recupero- **

        $da_approvare= \App\assenzatipi::lists('da_approvare', 'id')->toArray();


        if($da_approvare[$calendario->type])
            $calendario->approvato = 0;
        else
            $calendario->approvato = 1 ;

        \Debugbar::info($calendario->approvato, "approvato?");


        try {
            $calendario->save();
        } catch (Exception $e) {
            \Debugbar::addException($e);
        }


        if(!$calendario->approvato)
        {
            $referente = User::where('id', Auth::user()->referente_id)->first();

            \Debugbar::info($referente->email);

            Mail::send('emails.approvazione', ['user' => $referente->nome], function ($m) use ($referente) {
                $m->from('office@ggallery.it', 'G A P');
                $m->to($referente->email, $referente->name)->subject('Richiesto intervento');
//                $m->to('antonio@gallerygroup.it', $referente->name)->subject('Richiesto intervento');
            });
        }

        return redirect('calendario')->with('ok_message', 'Ok commessa aggiunta correttamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $cal = calendario::find($id);
        $cal->approvato= 1;

        //prima di salvare l'evento lo carico su google
        $event = new Event;
        $event->name = $cal->user->nome." ".$cal->user->cognome  ." - ". $cal->commessa->oggetto ." " . $cal->type;

        $event->startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $cal->giorno, 'Europe/London');
        $event->endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $cal->giorno, 'Europe/London')->addHours($cal->n_ore);

        $return = $event->save();

        $cal->google_calendar_id = $return->googleEvent->id;
        $cal->save();

        Mail::send('emails.approvato', ['user' => $cal->user->nome], function ($m) use ($cal) {
            $m->from('office@ggallery.it', 'G A P');
            $m->to($cal->user->email, $cal->user->nome)->subject('Richiesta approvata');
        });

        return redirect('approvazione');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {


        calendario::destroy($id);
//        return redirect('calendar')->with('giorno', '2015-12-05')->with('ok_message', 'Eliminata');
        $_REQUEST['giorno'] = '2015-12-05';
        return redirect('calendar')->with($_REQUEST);

    }


    public function calendar(Request $request) {

        \Debugbar::info($request['giorno']);

        if ($request['giorno'])
            $data = $request['giorno'];
        else
            $data = Carbon::today()->toDateString();


        $fromDate = Carbon::createFromFormat('Y-m-d', $data)->startOfWeek()->toDateString(); // or ->format(..)
        $tillDate = Carbon::createFromFormat('Y-m-d', $data)->startOfWeek()->addDays(6)->toDateString();

        \Debugbar::info($fromDate);
        \Debugbar::info($tillDate);


        for ($i = 0; $i < 6; $i++) {
            $tillDate = Carbon::createFromFormat('Y-m-d', $data)->startOfWeek()->addDays($i)->toDateString();

            $d = Carbon::createFromFormat('Y-m-d', $data)->startOfWeek()->addDays($i)->formatLocalized('%A %d/%m/%y');

            $settimana[$d] = calendario::where('dipendenti_id', \Auth()->user()->id)
                ->wheredate('giorno','=', $tillDate)
                ->with('commessa')
                ->get();


            $totore[$d] = calendario::where('dipendenti_id', \Auth()->user()->id)
                ->wheredate('giorno','=', $tillDate)
                ->with('commessa')
                ->sum('n_ore');
        }



        return view('calendario.calendar', compact('settimana'), compact('totore'));
    }


    public function feriepermessi() {
        //
        $crediti = new calendario();
        $data['crediti'] = $crediti->creditoRecuperi(Auth::user()->id);

        return view('calendario.feriepermessi', $data);
    }


    public function approvazione() {
        //

        $data['approvazioni'] = calendario::where('approvato' , 0)->get();

        \Debugbar::info($data['approvazioni']);

        return view('calendario.approvazione', $data);
    }


    public function rilevazione() {
        $data['rilevazione'] = calendario::whereNull('rilevato')
            ->where('approvato' , 1)
            ->where('commessa_id' , 1)
            ->whereIn('type' , [1,2,3,6])
            ->orderBy('dipendenti_id')
            ->get();

        return view('calendario.rilevazione', $data);
    }

    public function do_rileva() {

        $today = \Carbon\Carbon::today();
        $cal = calendario::whereNull('rilevato')
            ->where('approvato' , 1)
            ->where('commessa_id' , 1)
            ->whereIn('type' , [1,2,3,6])
            ->update(['rilevato' => $today]);


        return redirect('home');

    }

}
