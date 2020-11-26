<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Mail;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return $users;       
    }

    public function show($id, Request $request)
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

        $email_sent = false;
        if($request->has('download'))
        {
            $loggedUserEmail = auth()->user()->email;
            $email_sent = true;

            $email['address'] = "{$loggedUserEmail}";
            $email['title'] = "PDF listo";
            $email['body'] = "Aquí tienes tu pdf con el detalle del usuario {$user->name}";
            $email['pdf_name'] = "{$user->name}.pdf";
            $email['pdf'] = PDF::loadView('emails.userDetail', compact('user', 'oficio', 'departamento_usuario',
                    'departamento_dependiente', 'empresa', 'tipo_usuario', 'email_sent'));

            Mail::send([], [], function($message)use($email) {
                $message->to($email['address'], $email['address'])
                        ->attachData($email['pdf']->output(), $email['pdf_name'])
                        ->subject($email['title'])
                        ->setBody($email['body']);
            });

            //return $pdf->download($email['pdf_name']);
        }

        return view('users.show', compact('user', 'oficio', 'departamento_usuario',
                    'departamento_dependiente', 'empresa', 'tipo_usuario', 'email_sent'));
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

    public function update(Request $request, $id)
    {       
        $user = User::findOrFail($id);
        
        $data = $request->validate([
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

        if ($request['password'] != null) {
            $request['password'] = bcrypt($request['password']);
        } else {
            unset($request['password']);
        }

        $user->update($request->all());

        return;
    }

    public function store(Request $request)
    {
        $this->validate($request,[
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

        User::create($request->all());

        return;
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
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
                            "<button type='button' class='btn btn-info' @click='showDetailModel = true'><span class='oi oi-eye'></span></button>
                            <button type='button' class='btn btn-primary' @click='showEditModel = true'><span class='oi oi-pencil'></span></button> 
                            <a href='/usuarios/{$user->id}/borrar' class='btn btn-danger'><span class='oi oi-trash'></span></button>";
                        } else {
                            $output.= 
                            "<button type='button' class='btn btn-info' @click='showDetailModel = true'><span class='oi oi-eye'></span></button>";
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