<?php

namespace App\Views;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class ViewEngine
{
    public static function render(String $page, Array $data)
    {
        $loader = new FilesystemLoader('app/src/Views/pages');
        $twig = new Environment($loader, [
            'cache' => false,
        ]);

        echo $twig->load($page)->render(['data'=>$data]);
    }
}