<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Mail;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::all();
        return $departments;
        //$companies = Company::all();
        
    }

    public function show($id, Request $request)
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

        $email_sent = false;
        if($request->has('download'))
        {
            $loggedUserEmail = auth()->user()->email;
            $email_sent = true;

            $email['address'] = "{$loggedUserEmail}";
            $email['title'] = "PDF listo";
            $email['body'] = "Aquí tienes tu pdf con el detalle del departamento {$department->name}";
            $email['pdf_name'] = "{$department->name}.pdf";
            $email['pdf'] = PDF::loadView('emails.departmentDetail', compact('department', 'dependents', 'employees', 'company', 'email_sent'));

            Mail::send([], [], function($message)use($email) {
                $message->to($email['address'], $email['address'])
                        ->attachData($email['pdf']->output(), $email['pdf_name'])
                        ->subject($email['title'])
                        ->setBody($email['body']);
            });

            //return $pdf->download($email['pdf_name']);
        }

        return view('departments.show', compact('department', 'dependents', 'employees', 'company', 'email_sent'));
    }

    public function create()
    {
        $companies = Company::all();
        return view('departments.create', compact('companies'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'director' => 'required',
            'director_type' => 'required',
            'company_id' => 'required',
            'dependent_id' => 'required',
            'budget' => ['required', 'numeric', 'between:10000,100000'],
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'director.required' => 'El campo director es obligatorio',
            'director_type.required' => 'Se debe seleccionar un tipo de director',
            'company_id.required' => 'Se debe seleccionar una empresa o ninguna',
            'dependent_id.required' => 'Se debe seleccionar un departamento dependiente o ninguno',
            'budget.required' => 'El campo presupuesto es obligatorio',
            'budget.numeric' => 'El valor de presupuesto introducido no es un número',
            'budget.between' => 'El presupuesto debe comprender entre 10.000€ y 100.000€'
        ]);
        
        if ($request['dependent_id'] == 'no') {
            unset($request['dependent_id']);
        } 
        
        Department::create($request->all());

        return;
    }

    public function edit($id)
    {
        $department = Department::findOrFail($id);
        $companies = Company::all();
        return view('departments.edit', compact('department', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        
        $data = request()->validate([
            'name' => 'required',
            'director' => 'required',
            'director_type' => 'required',
            'company_id' => 'required',
            'dependent_id' => 'required',
            'budget' => ['required', 'numeric', 'between:10000,100000'],
        ], [
            'name.required' => 'El campo nombre es obligatorio',
            'director.required' => 'El campo director es obligatorio',
            'director_type.required' => 'Se debe seleccionar un tipo de director',
            'company_id.required' => 'Se debe seleccionar una empresa o ninguna',
            'dependent_id.required' => 'Se debe seleccionar un departamento dependiente o ninguno',
            'budget.required' => 'El campo presupuesto es obligatorio',
            'budget.numeric' => 'El valor de presupuesto introducido no es un número',
            'budget.between' => 'El presupuesto debe comprender entre 10.000€ y 100.000€'
        ]);

        if ($request['dependent_id'] == 'no') {
            unset($request['dependent_id']);
        } 

        $department->update($request->all());

        return;
    }



    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
    }

    public function search(Request $request)
    {
        $departments = Department::where('name', 'like', '%' . $request->get('keywords') . '%')->get();

        return response()->json($departments);
    }
}
