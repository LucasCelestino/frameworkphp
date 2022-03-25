<?php

namespace App\Controllers;

class UserController extends Controller
{
    /* 
    GET
    Exibe uma lista do recurso
    */ 
    public function index()
    {
        $data['name'] = 'Fulano';
        $this->render('cadastro.html', $data);
    }

    /*
     GET
     Exibe um form para criar um novo recurso
    */ 
    public function create()
    {
        
    }

    /*
    POST
    Armazena um novo recurso criado no banco de dados
    */ 
    public function store()
    {
        
    }

    /*
     GET
     Exibe um recurso
    */  
    public function show(int $id)
    {
        
    }

    /*
    GET
    Exibe um form para editar um recurso
    */ 
    public function edit(int $id)
    {
        
    }

    /*
    PUT/PATCH
    Atualiza um recurso especifico no banco de dados
    */ 
    public function update()
    {
        
    }
    /*
    DELETE
    Exclui um recurso especifico no banco de dados
    */ 
    public function destroy(int $id)
    {
        
    }
}