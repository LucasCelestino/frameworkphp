<?php

namespace App\Controllers;

class UserController extends Controller
{
    /* 
    GET
    Show a list of the resource
    */ 
    public function index()
    {
        $data['name'] = 'Fulano';
        $this->render('cadastro.html', $data);
    }

    /*
     GET
     Show a form to create new resource
    */ 
    public function create()
    {
        
    }

    /*
    POST
    Store a newly created resource in database
    */ 
    public function store()
    {
        
    }

    /*
     GET
     Show one resource
    */  
    public function show(int $id)
    {
        
    }

    /*
    GET
    Show a form to edit one resource
    */ 
    public function edit(int $id)
    {
        
    }

    /*
    PUT/PATCH
    Update the specified resource in database
    */ 
    public function update()
    {
        
    }
    /*
    DELETE
    Delete the specified resource from database
    */ 
    public function destroy()
    {
        
    }
}