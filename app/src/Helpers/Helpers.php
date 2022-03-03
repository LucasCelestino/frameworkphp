<?php

namespace App\Helpers;

class Helpers
{
    public static function csrf_token()
    {
        if(!isset($_SESSION['token']))
        {
            $token = md5(uniqid(mt_rand(), true));
            $_SESSION['token'] = $token;
            return $token;
        }
        
        return $_SESSION['token'];
    }
}