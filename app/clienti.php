<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class clienti extends Model
{
    //
    protected $table="cm_clienti";
    
    public function commesse(){
        return $this->hasMany('App\commesse');
    }
    
}
