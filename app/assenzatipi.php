<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assenzatipi extends Model
{
    protected $table="cm_assenzatipi";

    public function calendario(){
        return $this->hasMany('App\calendario' , 'type');
    }
}
