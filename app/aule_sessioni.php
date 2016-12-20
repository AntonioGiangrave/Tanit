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
    
    public function _prenotazioni()
    {
        return $this->belongsToMany('App\User' , 'aule_prenotazioni' , 'id_sessione' , 'id_utente' );
    }
    
}
