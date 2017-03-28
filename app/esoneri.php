<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use DB;

class esoneri extends Model
{
    protected $table= 'esoneri';

    public function _get_esoneri($utente)
    {
        \Debugbar::info('Esonero');
        $esoneri = $this::all()->toArray();
        $corsi_utente = \App\registro_formazione::where('user_id', $utente->id)->whereNotNull('data_superamento')->pluck('corso_id')->toArray();
        $rf = array();
        foreach ($esoneri as $esonero ){
            $requisito = explode(",", $esonero['requisiti']);

            if(empty($risultato = array_diff($requisito, $corsi_utente))){
                $esclusioni = explode(",", $esonero['esclusione'] );


                foreach ($esclusioni as $esclusione) {
                    $rf['user_id'] = $utente->id;
                    $rf['corso_id']= (int)$esclusione;
                    $rf['description'] = 'Esonero per '.$esonero['descrizione'];
                    $rf['esonerato'] = 1;
                    $rf['data_superamento'] = '1900-01-01';

                    DB::insert(
                        'insert into `registro_formazione` (`user_id`, `corso_id`, `description`, `data_superamento`, `esonerato` ) 
values (?, ?, ?, ?, ?) on duplicate key update `data_superamento`="'.$rf["data_superamento"] . '", `description`="'.$rf["description"] . '", `esonerato`=1',
                        array($rf['user_id'], $rf['corso_id'], $rf['description'], $rf['data_superamento'] , $rf['esonerato'])
                    );
                }
            }
        }
    }
}
