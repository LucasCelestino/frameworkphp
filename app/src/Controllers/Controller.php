<?php

namespace App\Controllers;

abstract class Controller
{
    protected function model($model)
    {
        $model = "\App\Models\\".$model;
        return new $model();
    }

    protected function render(String $page, Array $data)
    {
        \App\Views\ViewEngine::render($page, $data);
    }
}