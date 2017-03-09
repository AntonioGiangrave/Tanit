<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class aule_sessioni extends Model
{
    protected $table="aule_sessioni";

    public function _aula()
    {
        return $this->belongsTo('App\aule' , 'id_aula');
    }

    public function _corso()
    {
        return $this->belongsTo('App\corsi' , 'id_corso');
    }

//    public function _prenotazioni()
//    {
//        return $this->belongsToMany('App\User' , 'aule_prenotazioni' , 'id_sessione' , 'id_utente' );
//    }

//    public function _registro_formazione()
//    {
//        return $this->hasMany('App\registro_formazione' , 'sessione_id' );
//    }


    public function _posti_occupati(){

        $occupati = \App\registro_formazione::where('sessione_id', $this->id)->whereNull('data_superamento')->get();
        return $occupati;

    }


    public function scheda_corso()
    {
        $path = public_path() . '/uploads/'.$this->id.'/SCHEDA_CORSO.pdf';
        if(file_exists($path))
            return true;
        return false;
    }



}
