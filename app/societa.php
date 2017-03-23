<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class societa extends Model {

    //
    protected $table = 'cm_societa';


    public function dipendenti()
    {
        return $this->hasMany('App\User');
    }


    public function user()
    {
        return $this->hasMany('App\User');
    }


    public function ateco()
    {
        return $this->belongsTo('App\ateco');
    }

    public function _settori()
    {
        return $this->belongsTo('App\settori');
    }

    public function _tutor()
    {
        return $this->belongsToMany('\App\User', 'user_societa_map'  , 'societa_id', 'user_id' );
    }



}
