<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class societa extends Model {

    //
    protected $table = 'cm_societa';
    protected $fillable = ['tipo',
        'ragione_sociale',
        'ateco_id',
        'settore_id',
        'descrizione_attivita',
        'n_dipendenti',
        'piva',
        'cod_fiscale',
        'email',
        'pec',
        'indirizzo_sede_legale',
        'telefono',
        'cellulare',
        'citta',
        'cap',
        'regione',
        'sito',
        'ref_aziendale',
        'so_indirizzo',
        'so_citta',
        'so_cap',
        'fondo_id',
        'fi_dipendenti',
        'fi_dirigenti',
        'demo' ];

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
