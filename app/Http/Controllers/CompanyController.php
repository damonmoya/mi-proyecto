<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        
        return view('companies.index')
            ->with('companies', $companies)
            ->with('title', 'Listado de empresas');
        
    }

    public function show($id)
    {
        $company = Company::find($id);

        if ($company == null) {
            return response()->view('errors.404', [], 404);
        }

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
        

        return view('companies.show', compact('company', 'cuenta_empleados', 'departments', 'array', 'array2'));
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
                        "<a href='/empresas/{$company->id}' class='btn btn-info'><span class='oi oi-eye'></span></a>";
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
