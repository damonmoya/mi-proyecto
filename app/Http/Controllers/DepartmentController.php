<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        
        return view('departments.index')
            ->with('departments', $departments)
            ->with('title', 'Listado de departamentos');
        
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        $dependents = $department->departments;
        $employees = $department->users;
        $company = $department->company;
        if($company == null){
            $company = "Sin empresa asignada";
        } else {
            $company = $company->name;
        }
            
        return view('departments.show', compact('department', 'dependents', 'employees', 'company'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('departments.create', compact('companies'));
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'director' => 'required',
            'director_type' => 'required',
            'company' => 'required',
            'budget' => ['required', 'numeric', 'between:10000,100000'],
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'director.required' => 'El campo director es obligatorio',
            'director_type.required' => 'Se debe seleccionar un tipo de director',
            'company.required' => 'Se debe seleccionar una empresa o ninguna',
            'budget.required' => 'El campo presupuesto es obligatorio',
            'budget.numeric' => 'El valor de presupuesto introducido no es un número',
            'budget.between' => 'El presupuesto debe comprender entre 10.000€ y 100.000€'
        ]);

        $company = null;

        if($data['company'] != "Sin empresa"){
            $company = Company::where('name', $data['company'])->value('id');
        }      
        
        Department::create([
            'name' => $data['name'],
            'director' => $data['director'],
            'director_type' => $data['director_type'],
            'company_id' => $company,
            'budget' => $data['budget']
        ]);

        return redirect()->route('departments.index');
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $companies = Company::all();
        return view('departments.edit', compact('department', 'companies'));
    }

    public function update($id)
    {
        $department = Department::findOrFail($id);
        
        $data = request()->validate([
            'name' => 'required',
            'director' => 'required',
            'director_type' => 'required',
            'company_id' => 'required',
            'budget' => ['required', 'numeric', 'between:10000,100000'],
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'director.required' => 'El campo director es obligatorio',
            'director_type.required' => 'Se debe seleccionar un tipo de director',
            'company_id.required' => 'Se debe seleccionar una empresa o ninguna',
            'budget.required' => 'El campo presupuesto es obligatorio',
            'budget.numeric' => 'El valor de presupuesto introducido no es un número',
            'budget.between' => 'El presupuesto debe comprender entre 10.000€ y 100.000€'
        ]);

        if($data['company_id'] != "Sin empresa"){
            $data['company_id'] = Company::where('name', $data['company_id'])->value('id');
        } else{
            $data['company_id'] = null;
        }

        $department->update($data);

        return redirect()->route('departments.show', ['id' => $id]);
    }



    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        
        return redirect()->route('departments.index');
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output='';
            $query = $request->get('query');
            if ($query != '')
            {
                $departments=DB::table('departments')
                    ->where('name','LIKE','%'.$query.'%')
                    ->orWhere('id','LIKE','%'.$query.'%')
                    ->orWhere('director','LIKE','%'.$query.'%')
                    ->orderBy('id', 'asc')
                    ->get();
            } else 
            {
                $departments=DB::table('departments')
                    ->orderBy('id', 'asc')
                    ->get();
            }
            $total_rows = $departments->count();
            if($total_rows > 0)
            {
                foreach ($departments as $department) {
                    $output.='<tr>'.
                    '<td>'.$department->id.'</td>'.
                    '<td>'.$department->name.'</td>'.
                    '<td>'.$department->director.'</td>'.
                    "<td>";
                    $output.= 
                        "<a href='/departamentos/{$department->id}' class='btn btn-info'><span class='oi oi-eye'></span></a>
                        <a href='/departamentos/{$department->id}/editar' class='btn btn-primary'><span class='oi oi-pencil'></span></a>
                        <a href='/departamentos/{$department->id}/borrar' class='btn btn-danger'><span class='oi oi-trash'></span></button>";
                    $output.="</td>".
                    '</tr>';
                }
            } else
            {
                $output.='<tr>
                    <td align="center" colspan="4">No hay resultados</td>
                </tr>';
            }
            $departments = array(
                'table_data' => $output,
                'total_data' => $total_rows
            );

            echo json_encode($departments);
            
        }
    }
}
