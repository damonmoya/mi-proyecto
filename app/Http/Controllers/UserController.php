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
        $user = User::find($id);

        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.show', compact('user'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        $user = User::find($id);

        if ($user == null) {
            return response()->view('errors.404', [], 404);
        }

        return view('users.edit', compact('user'));
    }

    public function update($id)
    {
        $user = User::find($id);
        
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email,'.$user->id],
            'password' => ['nullable', 'min:6'],
            'confirm_password' => 'same:password'
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'email.email' => 'El correo no es válido',
            'email.unique' => 'El correo ya está en uso',
            'password.min' => 'La clave debe tener mínimo 6 caracteres',
            'confirm_password.same' => 'Las claves no coinciden',
        ]);

        if ($data['password'] != null) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }


        $user->update($data);

        return redirect("/usuarios/$id");
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
            'confirm_password' => ['required', 'same:password']
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'email.required' => 'El campo correo es obligatorio',
            'email.email' => 'El correo no es válido',
            'email.unique' => 'El correo ya está en uso',
            'password.required' => 'El campo clave es obligatorio',
            'password.min' => 'La clave debe tener mínimo 6 caracteres',
            'confirm_password.required' => 'Se debe confirmar la clave',
            'confirm_password.same' => 'Las claves no coinciden'
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();

        return redirect()->route('users.index');
        
    }

    public function search(Request $request)
    {
    if($request->ajax())
        {
            $output="";
            $users=DB::table('users')->where('name','LIKE','%'.$request->search."%")->get();
            if($users)
            {
                foreach ($users as $key => $user) {
                    $output.='<tr>'.
                    '<td>'.$user->id.'</td>'.
                    '<td>'.$user->name.'</td>'.
                    '<td>'.$user->email.'</td>'.
                    "<td>
                        <form action='/usuarios/{$user->id}' method='POST'>
                            <input type='hidden' name='_method' value='delete'/>
                            <input type='hidden' name='token' value='{csrf_token()}'/>
                            <a href='/usuarios/{$user->id}' class='btn btn-info'><span class='oi oi-eye'></span></a> 
                            <a href='/usuarios/{$user->id}/editar' class='btn btn-primary'><span class='oi oi-pencil'></span></a> 
                            <button type='submit' class='btn btn-danger'><span class='oi oi-trash'></span></button>
                        </form>
                    </td>".
                    '</tr>';
                }
                return Response($output);
            }
        }
    }
}
