<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::all();
        $title = 'Listado de usuarios';
        
        return view('users.index')
            ->with('users', $users)
            ->with('title', $title);
        
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        $profession = $user->profession;
        $department = $user->department;

        if ($profession == null){
            $oficio = "Sin profesión asignada";
        } else {
            $oficio = $profession->title;
        }

        if ($department == null){
            $departamento_usuario = "Sin departamento asignado";
            $departamento_dependiente = "-";
            $empresa = "-";
        } else {
            $departamento_usuario = $department->name;
            $empresa = $department->company
                ->name;
        
            if ($department->dependent_id == null){
                $departamento_dependiente = "No";
            } else {
                $departamento_dependiente = $department->dependent
                    ->name;
            }

        }

        if ($user->hasrole('Administrador')){
            $tipo_usuario = "Administrador";
        } else {
            $tipo_usuario = "Usuario normal";
        }

        return view('users.show', compact('user', 'oficio', 'departamento_usuario',
                    'departamento_dependiente', 'empresa', 'tipo_usuario'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    public function update($id)
    {
        $user = User::findOrFail($id);
        
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

        return redirect()->route('users.show', ['id' => $id]);
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
        $user = User::findOrFail($id)->delete();
        return redirect()->route('users.index');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output='';
            $query = $request->get('query');
            if ($query != '')
            {
                $users=DB::table('users')
                    ->where('name','LIKE','%'.$query.'%')
                    ->orWhere('email','LIKE','%'.$query.'%')
                    ->orWhere('id','LIKE','%'.$query.'%')
                    ->orderBy('id', 'asc')
                    ->get();
            } else 
            {
                $users=DB::table('users')
                    ->orderBy('id', 'asc')
                    ->get();
            }
            $total_rows = $users->count();
            if($total_rows > 0)
            {
                foreach ($users as $user) {
                    $output.='<tr>'.
                    '<td>'.$user->id.'</td>'.
                    '<td>'.$user->name.'</td>'.
                    '<td>'.$user->email.'</td>'.
                    "<td>";

                        $loggedUser = auth()->user();
                        if ($loggedUser->can('Eliminar usuarios') && $loggedUser->can('Crear usuarios')){
                            $output.= 
                            "<a href='/usuarios/{$user->id}' class='btn btn-info'><span class='oi oi-eye'></span></a>
                            <a href='/usuarios/{$user->id}/editar' class='btn btn-primary'><span class='oi oi-pencil'></span></a> 
                            <a href='/usuarios/{$user->id}/borrar' class='btn btn-danger'><span class='oi oi-trash'></span></button>";
                        } else {
                            $output.= 
                            "<a href='/usuarios/{$user->id}' class='btn btn-info'><span class='oi oi-eye'></span></a>";
                        }
                        
                    $output.="</td>".
                    '</tr>';
                }
            } else
            {
                $output.='<tr>
                    <td align="center" colspan="4">No hay resultados</td>
                </tr>';
            }
            $users = array(
                'table_data' => $output,
                'total_data' => $total_rows
            );

            echo json_encode($users);
            
        }
    }
}