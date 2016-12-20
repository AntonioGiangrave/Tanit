<?php

namespace App;



use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

use DB;

class commesse extends Model
{
    //
    protected $table= 'cm_commesse';


    public function clienti(){
        return $this->belongsTo('App\clienti' , 'cliente_id');
    }

    public function calendario(){

        return $this->hasMany('App\calendario' , 'commessa_id');
    }

//    public function lista(){
//        $search =   Input::get('search');
//        return \App\commesse::with('Clienti')
//                ->orWhere('oggetto','like', '%'.$search.'%')
//                ->orWhere('protocollo','like', '%'.$search.'%')
//                ->with('clienti')
//                ->paginate(15);
//    }

    public function lista(){

        $data = \App\calendario::
        select('*', DB::raw('SUM(n_ore) as tot'))
            ->with('commessa');

        if(Input::has("search"))
        {

            $data->whereHas('commessa', function ($q) {

                $q->orWhere('oggetto', 'like', '%' . Input::get('search') . '%');
                $q->orWhere('protocollo', 'like', '%' . Input::get('search') . '%');

            });
        }

        if(Input::has("from"))
            $data->Where('giorno', '>', Input::get('from'));


        if(Input::has("to"))
            $data->Where('giorno', '<',  Input::get('to'));

        $query= $data->orderBy('commessa_id', 'desc')
            ->groupBy('commessa_id')
            ->paginate(15);



        \Debugbar::info($query);

        return $query;
    }







}
