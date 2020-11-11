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
            ->with('companies', $departments)
            ->with('title', 'Listado de departamentos');
        
    }

    public function show($id)
    {
        $department = Department::findOrFail($id);
        $dependents = $department->departments;
        $employees = $department->users;
            
        return view('departments.show', compact('department', 'dependents', 'employees'));
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
