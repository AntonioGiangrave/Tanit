<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ateco extends Model
{
    protected $table="ateco";


    public function societa()
    {
        return $this->hasMany('App\societa');
    }

    public function _corsi()
    {
        return $this->belongsToMany('App\corsi' , 'ateco_corsi_map', 'ateco_id', 'corso_id');
    }


}
