<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Spatie\Permission\Traits\HasRoles;



class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    use HasRoles;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'nome', 'cognome', 'email', 'password' , 'societa_id', ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];


    public function societa() {

        return $this->belongsTo('App\societa');
    }


    public function _tutor_societa()
    {
        return $this->belongsToMany('\App\societa', 'user_societa_map'  );
    }


    public function user_profiles() {

        return $this->hasOne('App\user_profiles' , 'id' , 'id');
    }

    public function groups()
    {
//        return $this->belongsToMany('\App\Usergroups' , 'user_group' , 'user_id', 'group_id' );
        return $this->roles();

    }

    public function commesse()
    {
        return $this->belongsToMany('\App\commesse' , 'cm_calendario', 'dipendenti_id' , 'commessa_id');
    }

    public function aule_prenotazioni(){
        return $this->belongsToMany('\App\aule_prenotazioni' , 'aule_prenotazioni', 'id_utente' );
    }

    public function _albi_professionali()
    {
        return $this->belongsToMany('App\albi_professionali' , 'albi_professionali_user_map' ,  'user_id', 'albo_id' );
    }

    public function _esoneri_laurea()
    {
        return $this->belongsToMany('App\esoneri_laurea', 'esoneri_laurea_user_map', 'user_id', 'esonero_laurea_id'  );
    }

    public function _incarichi_sicurezza()
    {
        return $this->belongsToMany('App\incarichi_sicurezza' , 'incarichi_sicurezza_map' ,  'user_id', 'incarico_id' );
    }

    public function _mansioni()
    {
        return $this->belongsToMany('App\mansioni' , 'mansioni_user_map' ,  'user_id', 'mansione_id' );
    }

    public function _registro_formazione()
    {
        return $this->hasMany('App\registro_formazione');
    }

    public function _avanzamento_formazione()
    {
        return $this->hasMany('App\registro_formazione')->whereNotNull('data_superamento');
    }

    public function _raggiungimento_eqf()
    {
        $query = $this->_registro_formazione()->where('eqf', 1);

        $tot =  $query->count();
        $done = $query->whereNotNull('data_superamento')->count();

        if($tot>0 && $done == $tot)
            return true;
        else
            return false;



    }


    public function _registro_formazione_ruolo(){
        $tot = $this->_registro_formazione()->whereHas('_corsi' , function($q){
            $q->where('tipo','R');
        });
        return $tot;
    }

    public function _registro_formazione_sicurezza(){
        $tot = $this->_registro_formazione()->whereHas('_corsi' , function($q){
            $q->where('tipo','S');
        });
        return $tot;
    }



    public function _get_tot_avanzamento_formazione_ruolo()
    {
        $tot = $this->_avanzamento_formazione()->whereHas('_corsi' , function($q){
            $q->where('tipo','R');
        })->count();
        return $tot;
    }

    public function _get_tot_avanzamento_formazione_sicurezza()
    {
        $tot = $this->_avanzamento_formazione()->whereHas('_corsi', function ($q) {
            $q->where('tipo', 'S');
        })->count();
        return $tot;
    }



    public function _get_percentuale_formazione($percent = true)
    {
        $ret = 0;
//        Faccio questo panigirico sennò mi da errore di divisione per zero
        
        if($this->_registro_formazione()->count() > 0)
            $ret = $this->_avanzamento_formazione()->count() / $this->_registro_formazione()->count()*100; 
        else
            $ret = 0;
        
        
        $ret= (int)$ret;
        return ($percent) ? $ret."%" : $ret; 
    }

    public function _get_classe_rischio(){
        try {

            if (!$this->user_profiles->classe_rischio) {
                $this->user_profiles->classe_rischio = $this->_set_classe_rischio();
                $this->save();
            }

            return $this->user_profiles->classe_rischio;
        }catch (Exception $e){

            \Debugbar::log($e);
        }

    }

    public function _set_classe_rischio(){
        \Debugbar::log('set classe rischio');
//        DA OTTIMIZZARE vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv

        $classe_rischio_ateco = $this->societa->ateco->classe_rischio;

        $classe_rischio_utente = null;

        foreach ($this->_mansioni as $mansione) {
            if ($mansione->classe_rischio == null) {
                $classe_rischio_utente = null;
                break;
            } elseif ($mansione->classe_rischio >= $classe_rischio_utente) {
                $classe_rischio_utente = $mansione->classe_rischio;
            }
        }

        if ($classe_rischio_utente)
            $classe_rischio_riferimento = $classe_rischio_utente;
        else
            $classe_rischio_riferimento = $classe_rischio_ateco;


//  DA OTTIMIZZARE ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

        return $classe_rischio_riferimento;
    }

    public function getFullName()
    {
        return $this->cognome. " " . $this->nome;
    }





}
