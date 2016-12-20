<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ajaxRequestController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //SearchController.php
    public function Commesse() {
        $term = Input::get('term');

        $results = array();

        $queries = \DB::table('cm_commesse')
                ->join('cm_clienti' , 'cm_clienti.id' , '=' , 'cm_commesse.cliente_id')
                ->where('cm_commesse.id', '>' ,1) //escludo ferie e permessi
                ->where(function ($query) use ($term) {
                    $query
                        ->orWhere('oggetto', 'LIKE', '%' . $term . '%')
                        ->orWhere('protocollo', 'LIKE', '%' . $term . '%')
                        ->orWhere('nome', 'LIKE', '%' . $term . '%');
            })
                ->get();


        foreach ($queries as $query) {
            $results[] = [ 'id' => $query->id, 'value' => $query->protocollo . ' ' . $query->oggetto];
        }
        \Debugbar::info($results);
        return \Response::json($results);
    }

    public function Utenti() {
        $term = Input::get('term');

        $results = array();

        $queries = \DB::table('cm_dipendenti')
                ->where('nome', 'LIKE', '%' . $term . '%')
                ->orWhere('cognome', 'LIKE', '%' . $term . '%')
                ->get();

        foreach ($queries as $query) {
            $results[] = [ 'id' => $query->id, 'value' => $query->nome . ' ' . $query->cognome];
        }
        return \Response::json($results);
    }


}
