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

    public function restoreUser($id)
    {
        User::withTrashed()
            ->where('id', $id)
            ->restore();
    }

    public function eliminateUser($id)
    {
        User::withTrashed()
            ->where('id', $id)
            ->forceDelete();
    }
}
