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
        return view('Admin.users.index', compact('user'));
    }

    public function create()
    {
        $role = role::all();
        return view('Admin.users.create', compact('role'));
    }
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        return redirect()->route('admin.users.index');
    }
    public function edit($id)
    {
        $user = User::find($id);
        $role = role::all();
        return view('Admin.users.update', compact('user', 'role'));
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->save();
        return redirect()->route('admin.users.index');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.users.index');
    }
}
