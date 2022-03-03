<?php

namespace App\Helpers;

class Messages
{
    public static function sendMessage($type, $message)
    {
        switch ($type)
        {
            case 0:
                return '<p class="error-message">'.$message.'</p>';
                break;
            case 1:
                return '<p class="warning-message">'.$message.'</p>';
                break;
            case 2:
                return '<p class="sucess-message">'.$message.'</p>';
                break;
        }
    }
}