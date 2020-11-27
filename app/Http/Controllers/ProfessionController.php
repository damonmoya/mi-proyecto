<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfessionController extends Controller
{
    public function index()
    {
        $professions = Profession::all();
        return $professions; 
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title' => 'required'
        ], [
            'title.required' => 'El campo nombre es obligatorio',
        ]);

        Profession::create($request->all());

        return;
    }

    public function show($id)
    {
        $profession = Profession::findOrFail($id);
        $users = $profession->users;

        return view('professions.show', compact('profession', 'users'));
    }

    public function update(Request $request, $id)
    {
        $profession = Profession::findOrFail($id);
        
        $data = $request->validate([
            'title' => 'required'
        ], [
            'title.required' => 'El campo nombre es obligatorio',
        ]);

        $profession->update($request->all());

        return;
    }

    public function destroy($id)
    {
        $profession = Profession::findOrFail($id);
        $profession->delete();
    }

    public function search(Request $request)
    {
        $professions = Profession::where('title', 'like', '%' . $request->get('keywords') . '%')->get();

        return response()->json($professions);
    }
}
