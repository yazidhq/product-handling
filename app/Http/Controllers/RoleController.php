<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->role->nama == 'admin') {
            $data = [
                'roles' => Role::all(),
            ];
            return view('dashboard.admin.role.role', $data);
        }
        return redirect()->route('dashboard');
    }
}
