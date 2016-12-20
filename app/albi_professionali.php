<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class albi_professionali extends Model
{
    protected $table= 'albi_professionali';

    public function User()
    {
        return $this->belongsToMany('App\User' , 'albi_professionali_user_map' ,  'user_id', 'albo_id' );
    }
}
