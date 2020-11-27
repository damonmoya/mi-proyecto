<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Mail;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::all();
        return $companies;
    }

    public function show($id, Request $request)
    {
        $company = Company::findOrFail($id);

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

        $email_sent = false;
        if($request->has('download'))
        {
            $loggedUserEmail = auth()->user()->email;
            $email_sent = true;

            $email['address'] = "{$loggedUserEmail}";
            $email['title'] = "PDF listo";
            $email['body'] = "Aquí tienes tu pdf con el detalle de la empresa {$company->name}";
            $email['pdf_name'] = "{$company->name}.pdf";
            $email['pdf'] = PDF::loadView('emails.companyDetail', compact('company', 'cuenta_empleados', 'departments', 'array', 'array2', 'email_sent'));

            Mail::send([], [], function($message)use($email) {
                $message->to($email['address'], $email['address'])
                        ->attachData($email['pdf']->output(), $email['pdf_name'])
                        ->subject($email['title'])
                        ->setBody($email['body']);
            });

            //return $pdf->download($email['pdf_name']);
        }
        
        $hide = false;
        return view('companies.show', compact('company', 'cuenta_empleados', 'departments', 'array', 'array2', 'email_sent'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);
        
        $data = $request->validate([
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

        $company->update($request->all());

        return;
    }

    public function store(Request $request)
    {
        $this->validate($request,[
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

        Company::create($request->all());

        return;
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
    }

    public function search(Request $request)
    {
        $companies = Company::where('name', 'like', '%' . $request->get('keywords') . '%')->get();
        return response()->json($companies);
    }

    public function dependents(Request $request)
    {
        $company = Company::findOrFail($request->get('company'));
        $departments = $company->departments;
        return response()->json($departments);
    }
}
