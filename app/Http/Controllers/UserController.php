<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {

        $users = [
            'Pepe',
            'Pablo',
            'Willy',
        ];

        return view('users')
            ->with('users', $users)
            ->with('title', 'Listado de usuarios');
        
    }

    public function show($id)
    {
        return "Mostrar detalles del usuario: {$id}";
    }

    public function create()
    {
        return "Crear nuevo usuario";
    }
}
