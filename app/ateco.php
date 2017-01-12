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

//    public function _corsi()
//    {
//        return $this->belongsToMany('App\corsi' , 'ateco_corsi_map', 'ateco_id', 'corso_id');
//    }

    public function _corsi_sicurezza_specifica()
    {
        return $this->belongsToMany('App\corsi' , 'ateco_corsi_sicurezza_specifica', 'ateco_id', 'corso_id');
    }

    public function _corsi_rspp()
    {
        return $this->belongsToMany('App\corsi' , 'ateco_corsi_rspp', 'ateco_id', 'corso_id');
    }


    public function _corsi_aspp()
    {
        return $this->belongsToMany('App\corsi' , 'ateco_corsi_aspp', 'ateco_id', 'corso_id');
    }




}
