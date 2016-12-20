<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class incarichi_sicurezza extends Model
{
    protected $table= 'incarichi_sicurezza';

    public function User()
    {
        return $this->belongsToMany('App\User' , 'incarichi_sicurezza_map' ,  'user_id', 'incarico_id' );
    }
}
