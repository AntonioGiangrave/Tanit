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
    protected $fillable = ['name', 'nome', 'cognome', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    
    public function societa() {

        return $this->belongsTo('App\societa');
    }

    public function user_profiles() {

        return $this->belongsTo('App\user_profiles' , 'id' , 'id');
    }

//    public function groups()
//    {
//        return $this->belongsToMany('\App\Usergroups' , 'user_group' , 'user_id', 'group_id' );
//    }

    public function commesse()
    {
        return $this->belongsToMany('\App\commesse' , 'cm_calendario', 'dipendenti_id' , 'commessa_id');
    }

    public function _albi_professionali()
    {
        return $this->belongsToMany('App\albi_professionali' , 'albi_professionali_user_map' ,  'user_id', 'albo_id' );
    }

    public function _incarichi_sicurezza()
    {
        return $this->belongsToMany('App\incarichi_sicurezza' , 'incarichi_sicurezza_map' ,  'user_id', 'incarico_id' );
    }

    public function _mansioni()
    {
        return $this->belongsToMany('App\mansioni' , 'mansioni_user_map' ,  'user_id', 'mansione_id' );
    }

//    public function _prenotazioni()
//    {
//        return $this->belongsToMany('App\aule_sessioni' , 'aule_prenotazioni' ,  'id_utente' );
//    }


    public function _registro_formazione()
    {
        return $this->hasMany('App\registro_formazione');
    }

    public function _avanzamento_formazione()
    {
        return $this->_registro_formazione()->whereNotNull('data_superamento');
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
        $tot = $this->_avanzamento_formazione()->whereHas('_corsi' , function($q){
            $q->where('tipo','S');
        })->count();
        return $tot;
    }

    public function getFullName()
    {
        return $this->cognome. " " . $this->nome;
    }

//    public function hasAnyGroups($groups)
//    {
//        if(is_array($groups))
//        {
//            foreach ($groups as $group) {
//                if($this->hasGroup($group))
//                    return true;
//            }
//        }
//        else
//        {
//            if($this->hasGroup($groups))
//                return true;
//        }
//        return false;
//    }
//
//    public function hasGroup($group)
//    {
//        $chk = $this->groups()->where('name', $group)->first();
//        \Debugbar::info($chk);
//        if($chk){
//            return true;
//        }
//        return false;
//    }




}
