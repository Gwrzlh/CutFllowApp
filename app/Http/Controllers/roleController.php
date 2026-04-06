<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;

class roleController extends Controller
{
    public function index()
    {
        $role = Role::all();
        return view('Admin.role.index', compact('role'));
    }
    public function create()
    {
        return view('Admin.role.create');
    }
    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->slug = Str::slug($request->name);
        $role->save();
        return redirect()->route('admin.role.index');
    }
    public function edit($id)
    {
        $role = role::find($id);
        return view('admin.role.update', compact('role'));
    }
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->slug = Str::slug($request->name);
        $role->save();
        return redirect()->route('admin.role.index');
    }
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('admin.role.index');
    }
}
