<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

        return view('companies.show', compact('company'));
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
