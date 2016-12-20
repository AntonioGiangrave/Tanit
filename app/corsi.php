<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class corsi extends Model
{
    protected $table= 'corsi';

    public function _proprietario()
    {
        return $this->belongsTo('App\societa' , 'owner_id', 'id');
    }

    public function _aula()
    {
        return $this->belongsTo('App\aule' , 'aula');
    }


    public function _fad()
    {
        return $this->belongsTo('App\fad' , 'fad');
    }

    public function _sessioni()
    {
        return $this->hasMany('App\aule_sessioni' , 'id_corso' );
    }
    

}
