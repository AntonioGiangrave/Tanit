<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class calendario extends Model
{
    //
    protected $table="cm_calendario";

    public function commessa(){
        return $this->belongsTo('App\commesse' , 'commessa_id');
    }

    public function tipoassenza(){
        return $this->belongsTo('App\assenzatipi' , 'type');
    }


    public function user(){
        return $this->belongsTo('App\User' , 'dipendenti_id');
    }


    public function creditoRecuperi($id =  null)
    {
        $query = "
        SELECT tutti.* ,
          (RecuperiPOS - IFNULL(RecuperiNEG,0)) as credito,
          cm.oggetto
        FROM
          (
          SELECT
            c.dipendenti_id,
            c.commessa_id,
            (SELECT SUM(n_ore) FROM cm_calendario as pp WHERE type  = 4 and pp.commessa_id = c.commessa_id and pp.dipendenti_id = c.dipendenti_id) as RecuperiPOS,
            (SELECT SUM(n_ore) FROM cm_calendario as pp WHERE type  = 5 and pp.commessa_id = c.commessa_id and pp.dipendenti_id = c.dipendenti_id) as RecuperiNEG
          FROM
          cm_calendario as c ";

        if($id)
        $query.=" WHERE c.dipendenti_id = $id ";

        $query.="
          GROUP BY  dipendenti_id , commessa_id
          ) as tutti
          
          LEFT JOIN cm_commesse as cm on tutti.commessa_id = cm.id
          WHERE  (RecuperiPOS - IFNULL(RecuperiNEG,0)) > 0
          ";

        $crediti = DB::select($query);

        \Debugbar::info($query);
        \Debugbar::info($crediti);
        return($crediti);
        

    }
}
