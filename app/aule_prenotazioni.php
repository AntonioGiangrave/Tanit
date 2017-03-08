<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class aule_prenotazioni extends Model
{
    protected $table="aule_prenotazioni";

    public function _sessione()
    {
        return $this->belongsTo('App\aule_sessione' );
    }

    public function _user()
    {
        return $this->belongsTo('App\User');
    }

}
