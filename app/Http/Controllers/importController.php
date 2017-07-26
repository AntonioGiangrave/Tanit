<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session;
use Redirect;
use DB;

class importController extends Controller
{

    public function index(Request $request) {

        $userfield = \App\User::first();
        $userfield = $userfield->getFillable();

        $userprofiles = \App\user_profiles::first();
        $userprofiles = $userprofiles->getFillable();

        $societa = \App\societa::first();
        $societa = $societa->getFillable();

        $data['userfield'] = implode(", " ,array_merge($userfield, $userprofiles));
        $data['societafield'] = implode(", " ,$societa);
            
        
        $data['societa'] = \App\societa::lists('ragione_sociale', 'id');

        return view('import.index', $data);

    }


    public function do_import(Request $request)
    {

        $tipo = $request->input('tipo', null);
        $data = $request->input('newdata', null);
        $societa = $request->input('societa', null);

        $data = explode("\n", $data);

        $headers = explode(",",array_shift($data));
        $headers = array_map('trim', $headers);

        $error_field = array();

       
        switch ($tipo)
        {
            case 'utenti': {
                $user = \App\User::first();
                $user_field = array_merge(['id'], $user->getFillable());

                $user_profile = \App\user_profiles::first();
                $user_profile_field = $user_profile->getFillable();

                foreach ($headers as $header)
                    if (!in_array($header, array_merge(['id'], $user_field, $user_profile_field)))
                        array_push($error_field, $header);

                if (!empty($error_field)) {
                    return redirect()->back()->withErrors($error_field)->withInput();
                }

                foreach ($data as $row) {
                    $row = explode(",", $row);
                    $user = array_combine($headers, $row);
                    $user['societa_id'] = $societa;

                    if(array_key_exists('password', $user))
                        $user['password'] = bcrypt($user['password']);

                    $user_data = array_intersect_key($user, array_flip($user_field));
                    $user_profile_data = array_intersect_key($data, array_flip($user_profile_field));

                    $id = $this->insertUser($user_data);
                    $this->insertUserProfile($id, $user_profile_data);

                }
            }
                break;

            case 'societa':{
                $societa = \App\societa::first();
                $societa_field = array_merge(['id'], $societa->getFillable());


                foreach ($headers as $header)
                    if (!in_array($header, array_merge(['id'], $societa_field )))
                        array_push($error_field, $header);

                if (!empty($error_field)) {
                    return redirect()->back()->withErrors($error_field)->withInput();
                }

                foreach ($data as $singolasocieta) {
                    $singolasocieta= explode(",", $singolasocieta);
                    $data = array_combine($headers, $singolasocieta);

                    $societa_data = array_intersect_key($data, array_flip($societa_field));

                    $id = $this->insertSocieta($societa_data);

                }
            }
                break;



        }

        return redirect('/importa')->with('ok_message', 'Dati inseriti correttamente');
    }

    public static function insertUser($array)
    {
        if (array_key_exists('id', $array)) {
//            UPDATE
            $id = $array['id'];
            unset($array['id']);

            $user = \App\User::find($id);
            $user->update($array);
            $user->save();

        } else {
//            INSERT
            $user = new \App\User;
            foreach ($array as $key => $value) {
                $user->$key = trim($value);
            }
            $user->save();

        }

        return $user->id;
    }

    public static function insertSocieta($array)
    {
        if (array_key_exists('id', $array)) {
//            UPDATE
            $id = $array['id'];
            unset($array['id']);

            $user = \App\societa::find($id);
            $user->update($array);
            $user->save();

        } else {
//            INSERT
            $user = new \App\societa();
            foreach ($array as $key => $value) {
                $user->$key = trim($value);
            }
            $user->save();

        }

        return $user->id;
    }

    public static function insertUserProfile($id, $array)
    {

        $user = \App\user_profiles::find($id);
        try {

            if ($user) {
//            UPDATE
                $user->update($array);
                $user->save();

            } else {
//            INSERT
                $array['id'] = $id;
                $array['user_id'] = $id;

                $user = new \App\user_profiles();
                foreach ($array as $key => $value) {
                    $user->$key = trim($value);
                }
                $user->save();


            }
        }
        catch (Exception $e){
            print_r($e);
        }
    }


}
