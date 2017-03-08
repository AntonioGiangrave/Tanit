<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

class Helper
{
    public static function view_dd_if($data)
    {
        if($data) {
            return strtoupper($data);
        }
        else
        {
            return "Non previsto";
        }

    }


    public static function classe_rischio_to_text($data)
    {
        switch($data){
            case 1:
                return 'rischio basso';
                break;

            case 2:
                return 'rischio medio';
                break;

            case 3:
                return 'rischio alto';
                break;

            default:
                return 'non disponibile';
                break;
            
        }

    }





}