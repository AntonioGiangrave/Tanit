<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class user_profiles extends Model
{
    protected $table = 'user_profiles';

    protected $fillable = ['data_nascita', 'citta_nascita', 'sesso', 'codicefiscale', 'nazione_residenza' , 'citta_residenza', 'citta_residenza', 'cap_residenza', 'telefono', 'titolo_studio', 'status_id', 'inquadramento', 'ccln', 'mansione_ruolo', 'divisione'];

    public function _users() {
        return $this->belongsTo('App\Users');
    }

}
