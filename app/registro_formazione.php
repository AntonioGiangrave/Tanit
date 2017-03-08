<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class registro_formazione extends Model
{
    protected $table="registro_formazione";


    public function _user(){
        return $this->belongsTo('App\User' , 'user_id');
    }

    public function _corsi(){
        return $this->belongsTo('App\corsi' , 'corso_id');
    }

    public function _sessioni(){
        return $this->belongsTo('App\aule_sessioni' , 'sessione_id');
    }

    public function _fondo(){
        return $this->belongsTo('App\fondi_professionali' , 'fondo_id');
    }



    public static function insertIgnore($array){
        $a = new static();
        if($a->timestamps){
            $now = \Carbon\Carbon::now();
            $array['created_at'] = $now;
            $array['updated_at'] = $now;
        }
        DB::insert('INSERT IGNORE INTO '.$a->table.' ('.implode(',',array_keys($array)).') values (?'.str_repeat(',?',count($array) - 1).')',array_values($array));
    }

    public function clean_formazione_user($id){
        $affectedRows = registro_formazione::whereNull('data_superamento')->where('user_id', '=', $id)->delete();
    }

    public function formazione_mansioni($utente){
        \Debugbar::info('fomrazione_mansioni');
        foreach ($utente->_mansioni as $mansione) {
            foreach ($mansione->_corsi as $corso) {
                $registro_formazione =  new registro_formazione();
                $registro_formazione->user_id= $utente->id;
                $registro_formazione->corso_id= $corso->id;
                $registro_formazione->description= 'formazione_mansioni';
                $registro_formazione->insertIgnore($registro_formazione->toArray());
            }
        }
    }

    public function formazione_sicurezza_generale($utente){
        \Debugbar::info('formazione_sicurezza_generale');
        $formazione_generale = \App\incarichi_sicurezza::find(1);
        $registro_formazione = new registro_formazione();
        $registro_formazione->user_id = $utente->id;
        $registro_formazione->corso_id = $formazione_generale->id_rischio_basso; //unico
        $registro_formazione->description= 'formazione_sicurezza_generale';
        $registro_formazione->insertIgnore($registro_formazione->toArray());
    }

    public function formazione_sicurezza_specifica($utente){
        \Debugbar::info('formazione_sicurezza_specifica -  Ateco_id:' . $utente->societa->ateco_id);

        if($utente->societa->ateco_id) {
            foreach ($utente->societa->ateco->_corsi_sicurezza_specifica as $corso) {

                $registro_formazione = new registro_formazione();
                $registro_formazione->user_id = $utente->id;
                $registro_formazione->corso_id = $corso->id;
                $registro_formazione->description= 'formazione_sicurezza_specifica [rischio'.$utente->societa->ateco->classe_rischio.']';
                $registro_formazione->insertIgnore($registro_formazione->toArray());
            }
        }
    }

    public function formazione_rspp($utente){
        \Debugbar::info('formazione_rspp');
        if($utente->societa->ateco_id) {
            foreach ($utente->societa->ateco->_corsi_rspp as $corso) {

                $registro_formazione = new registro_formazione();
                $registro_formazione->user_id = $utente->id;
                $registro_formazione->corso_id = $corso->id;
                $registro_formazione->description= 'formazione_rspp';
                $registro_formazione->insertIgnore($registro_formazione->toArray());
            }
        }
    }

    public function formazione_aspp($utente){
        \Debugbar::info('formazione_aspp');
        if($utente->societa->ateco_id) {
            foreach ($utente->societa->ateco->_corsi_aspp as $corso) {

                $registro_formazione = new registro_formazione();
                $registro_formazione->user_id = $utente->id;
                $registro_formazione->corso_id = $corso->id;
                $registro_formazione->description= 'formazione_aspp';
                $registro_formazione->insertIgnore($registro_formazione->toArray());
            }
        }
    }

    public function formazione_incarichi_sicurezza($utente){
        \Debugbar::info('formazione_incarichi_sicurezza');
        foreach ($utente->_incarichi_sicurezza as $singolo_incarico){

            $registro_formazione = new registro_formazione();
            $registro_formazione->user_id = $utente->id;

            switch ($singolo_incarico->id){

                case 3://DIRIGENTE
                case 4://PREPOSTO
                case 5://RLS
                case 6://ADDETTO PRONTO SOCCORSO
                case 7://ADDETTO ANTINCENDIO
                case 8://DATORE DI LAVORO / RSPP
                case 11://Coordinatore della sicurezza (CSP/CSE)

                    $classe[1] = $singolo_incarico->id_rischio_basso;
                    $classe[2] = $singolo_incarico->id_rischio_medio;
                    $classe[3] = $singolo_incarico->id_rischio_alto;

                    $corsi = explode(",",$classe[$utente->user_profiles->classe_rischio]);

                    foreach ($corsi as $corso) {
                        $registro_formazione->description = $singolo_incarico->nome.' [rischio '.$utente->user_profiles->classe_rischio.']';
                        $registro_formazione->corso_id = $corso;
                        $registro_formazione->insertIgnore($registro_formazione->toArray());
                    }
                    break;

                case 9:
                    $this->formazione_rspp($utente);
                    break;

                case 10:
                    $this->formazione_aspp($utente);
                    break;

            }
        }
    }

    public function sync_utente($id){

        $utente= User::find($id);

        \Debugbar::info('SyncUtente: ' . $utente->cognome);

        $this->clean_formazione_user($id);

        $this->formazione_mansioni($utente);

        $this->formazione_sicurezza_generale($utente);

        $this->formazione_sicurezza_specifica($utente);

        $this->formazione_incarichi_sicurezza($utente);

    }

    public function sync_azienda($id)
    {
        $societa = societa::with('user')->find($id);
        \Debugbar::info('SyncAzienda: '.$societa->ragione_sociale );

//        if(!$societa->ateco_id) {
//            \Debugbar::info('/societa/' . $societa->id . '/edit');
//            return redirect('/societa/' . $societa->id . '/edit')->with('errore', 'Devi aggiornare l\'ateco della società ' . $societa->ragione_sociale . 'prima di procedere');
//            \Debugbar::info('fine');
//        }

        foreach ($societa->user as $utente) {
            $this->sync_utente($utente->id);
        }
    }

    public function sync_tutto(){
        \Debugbar::info('SyncTutto');
        $societa = societa::all();
        foreach ($societa as $singola){
            $this->sync_azienda($singola->id);
        }
    }

}
