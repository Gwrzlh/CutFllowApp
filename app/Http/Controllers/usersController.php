<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\role;

class usersController extends Controller
{
    public function index()
    {
        $user = User::with('role')->get();
        $role = role::all();
        return view('Admin.users.index', compact('user', 'role'));
    }

    public function create()
    {
        $user = User::with('role')->get();
        $role = role::all();
        return view('Admin.users.create', compact('user', 'role'));
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::with('role')->get();
        $role = role::all();
        $user_edit = User::find($id);
        return view('Admin.users.update', compact('user', 'role', 'user_edit'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role_id = $request->role_id;
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
