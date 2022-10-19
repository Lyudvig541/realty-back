<?php
namespace App\Helper;

class Helper
{
    public static function language($lang){
        if ($lang == "us"){
            $lang = "en";
        }
        return $lang;
    }
}
