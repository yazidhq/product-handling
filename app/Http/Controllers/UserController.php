<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role->nama == 'admin'){
            $data = [
                'users' => User::all(),
                'roles' => Role::all()
            ];  
            return view('dashboard.admin.user.pegawai', $data);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(auth()->user()->role->nama == 'admin'){
            $data = $this->validate($request, [
                'role_id' => 'required',
                'name' => 'required|string|max:250',
                'email' => 'required|email|max:250|unique:users',
                'password' => 'required|min:8|confirmed'
            ]);

            User::create($data);

            return redirect()->route('user.index')->with(['success'=>'Berasil menambah user']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(auth()->user()->role->nama == 'admin'){
            $user = User::findOrFail($id);

            $data = $this->validate($request, [
                'role_id' => 'required',
                'name' => 'required|string|max:250',
                'email' => 'required|email|max:250|unique:users,email,'.$user->id,
                'password' => 'nullable|min:8|confirmed'
            ]);

            if ($request->filled('password')) {
                $data['password'] = bcrypt($request->input('password'));
            } else {
                unset($data['password']);
            }

            $user->update($data);

            return redirect()->route('user.index')->with(['success'=>'Berhasil mengupdate user']);
        }
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->role->nama == 'admin'){
            $user = User::where('id', $id)->firstOrFail();
            $user->delete();
            return redirect()->route('user.index')->with(['success'=>'Berasil menghapus user']);
        }
        return redirect()->route('dashboard');
    }
}
