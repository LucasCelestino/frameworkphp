<?php

namespace App\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        $data['name'] = 'Fulano';
        $this->render('index.html', $data);
    }
}