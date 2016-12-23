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
}