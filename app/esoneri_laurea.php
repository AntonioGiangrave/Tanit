<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class esoneri_laurea extends Model
{
    protected $table = 'esoneri_laurea';


    public function _get_esoneri_laurea($utente)
    {
        \Debugbar::info('Esonero laurea');

//    QUESTA PARTE E' UNA MERDA, RIFALLA APPENA PUOI


        foreach ($utente->_esoneri_laurea as $esonero) {
            $esoneri = $esonero->esclusione;
            $esoneri = explode(",", $esoneri);

            \Debugbar::info($esoneri);

            $rf = array();

            if (!empty($esoneri)) {
                foreach ($esoneri as $esonero) {

                    $rf['user_id'] = $utente->id;
                    $rf['corso_id'] = (int)$esonero;
                    $rf['description'] = 'Esonero per laurea ';
                    $rf['esonerato'] = 1;
                    $rf['data_superamento'] = '1900-01-01';

                    DB::insert(
                        'insert into `registro_formazione` (`user_id`, `corso_id`, `description`, `data_superamento`, `esonerato` ) 
values (?, ?, ?, ?, ?) on duplicate key update `data_superamento`="' . $rf["data_superamento"] . '",`description`="' . $rf["description"] . '", `esonerato`=1',
                        array($rf['user_id'], $rf['corso_id'], $rf['description'], $rf['data_superamento'], $rf['esonerato'])
                    );
                }
            }
        }
    }
}
