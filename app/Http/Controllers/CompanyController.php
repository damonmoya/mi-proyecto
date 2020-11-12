<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        
        return view('companies.index')
            ->with('companies', $companies)
            ->with('title', 'Listado de empresas');
        
    }

    public function show($id, Request $request)
    {
        $company = Company::findOrFail($id);

        $nombre_pdf = "company.pdf";

        $departments = $company->departments;

        $cuenta_empleados = 0;

        $array = array();
        $array2 = array();

        foreach($departments as $department){

            $cuenta_departamento = $department->users->count();          
            $cuenta_empleados += $cuenta_departamento;
            $array["{$department->name}"] = $cuenta_departamento;

            if($department->dependent_id == null){
                $array2["{$department->name}"] = "No";
            } else {
                $array2["{$department->name}"] = $department->dependent->name;
            }
        }

        if($request->has('download'))
        {
            $hide = true;
            $pdf = PDF::loadView('companies.show',compact('company', 'cuenta_empleados', 'departments', 'array', 'array2', 'hide'));
            return $pdf->download($nombre_pdf);
        }
        
        $hide = false;
        return view('companies.show', compact('company', 'cuenta_empleados', 'departments', 'array', 'array2', 'hide'));
    }

    public function edit($id)
    {
        $company = Company::findOrFail($id);

        return view('companies.edit', compact('company'));
    }

    public function update($id)
    {
        $company = Company::findOrFail($id);
        
        $data = request()->validate([
            'name' => 'required',
            'address' => 'required',
            'description' => ['required', 'min:20'],
            'contact' => ['required', 'regex:/[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}/']
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'address.required' => 'El campo dirección es obligatorio',
            'description.required' => 'El campo descripción es obligatorio',
            'description.min' => 'La descripción debe tener mínimo 20 caracteres',
            'contact.required' => 'El campo contacto es obligatorio',
            'contact.regex' => 'El teléfono introducido no es válido'
        ]);

        $company->update($data);

        return redirect()->route('companies.show', ['id' => $id]);
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'address' => 'required',
            'description' => ['required', 'min:20'],
            'contact' => ['required', 'regex:/[0-9]{3} [0-9]{2} [0-9]{2} [0-9]{2}/']
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'address.required' => 'El campo dirección es obligatorio',
            'description.required' => 'El campo descripción es obligatorio',
            'description.min' => 'La descripción debe tener mínimo 20 caracteres',
            'contact.required' => 'El campo contacto es obligatorio',
            'contact.regex' => 'El teléfono introducido no es válido'
        ]);

        Company::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'description' => $data['description'],
            'contact' => $data['contact']
        ]);

        return redirect()->route('companies.index');
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        
        return redirect()->route('companies.index');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output='';
            $query = $request->get('query');
            if ($query != '')
            {
                $companies=DB::table('companies')
                    ->where('name','LIKE','%'.$query.'%')
                    ->orWhere('id','LIKE','%'.$query.'%')
                    ->orderBy('id', 'asc')
                    ->get();
            } else 
            {
                $companies=DB::table('companies')
                    ->orderBy('id', 'asc')
                    ->get();
            }
            $total_rows = $companies->count();
            if($total_rows > 0)
            {
                foreach ($companies as $company) {
                    $output.='<tr>'.
                    '<td>'.$company->id.'</td>'.
                    '<td>'.$company->name.'</td>'.
                    '<td>'.$company->description.'</td>'.
                    "<td>";
                    $output.= 
                        "<a href='/empresas/{$company->id}' class='btn btn-info'><span class='oi oi-eye'></span></a>
                        <a href='/empresas/{$company->id}/editar' class='btn btn-primary'><span class='oi oi-pencil'></span></a>
                        <a href='/empresas/{$company->id}/borrar' class='btn btn-danger'><span class='oi oi-trash'></span></button>";
                    $output.="</td>".
                    '</tr>';
                }
            } else
            {
                $output.='<tr>
                    <td align="center" colspan="4">No hay resultados</td>
                </tr>';
            }
            $companies = array(
                'table_data' => $output,
                'total_data' => $total_rows
            );

            echo json_encode($companies);
            
        }
    }
}
