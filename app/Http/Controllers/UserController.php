<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {

        //$users = DB::table('users')->get();
        $users = User::all();
        
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
        return view('users.new');
    }
}
