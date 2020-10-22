<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        if (request()->has('empty')) {
            $users = [];
        } else {
            $users = [
                'Pepe',
                'Pablo',
                'Willy',
            ];
        }

        
        return view('users.index')
            ->with('users', $users)
            ->with('title', 'Listado de usuarios');
        
    }

    public function show($id)
    {
        return view('users.show', compact('id'));
    }

    public function create()
    {
        return "Crear nuevo usuario";
    }
}
