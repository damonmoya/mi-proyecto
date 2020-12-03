<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use App\Models\Profession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function searchUsers(Request $request)
    {
        $users = User::withTrashed()
            ->where('name', 'like', '%' . $request->get('keywords') . '%')
            ->orderBy('deleted_at', 'ASC')
            ->get();

        return response()->json($users);
    }

    public function searchProfessions(Request $request)
    {
        $professions = Profession::withTrashed()
            ->where('title', 'like', '%' . $request->get('keywords') . '%')
            ->orderBy('deleted_at', 'ASC')
            ->get();

        return response()->json($professions);
    }

    public function searchCompanies(Request $request)
    {
        $companies = Company::withTrashed()
            ->where('name', 'like', '%' . $request->get('keywords') . '%')
            ->orderBy('deleted_at', 'ASC')
            ->get();

        return response()->json($companies);
    }

    public function searchDepartments(Request $request)
    {
        $departments = Department::withTrashed()
            ->where('name', 'like', '%' . $request->get('keywords') . '%')
            ->orderBy('deleted_at', 'ASC')
            ->get();

        return response()->json($departments);
    }

    public function restoreUser($id)
    {
        User::withTrashed()
            ->where('id', $id)
            ->restore();
    }

    public function restoreProfession($id)
    {
        Profession::withTrashed()->where('id', $id)->restore();
    }

    public function restoreCompany($id)
    {
        Company::withTrashed()->where('id', $id)->restore();
    }

    public function restoreDepartment($id)
    {
        Department::withTrashed()->where('id', $id)->restore();
    }

    public function eliminateUser($id)
    {
        User::withTrashed()->where('id', $id)->forceDelete();
    }

    public function eliminateProfession($id)
    {
        Profession::withTrashed()->where('id', $id)->forceDelete();
    }

    public function eliminateCompany($id)
    {
        Company::withTrashed()->where('id', $id)->forceDelete();
    }

    public function eliminateDepartment($id)
    {
        Department::withTrashed()->where('id', $id)->forceDelete();
    }
}
