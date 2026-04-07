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
        $role = Role::all();
        return view('Admin.role.create', compact('role'));
    }

    public function edit($id)
    {
        $role = Role::all();
        $role_edit = role::find($id);
        return view('Admin.role.update', compact('role', 'role_edit'));
    }

    public function store(Request $request)
    {
        $role = new Role();
        $role->name = $request->name;
        $role->slug = Str::slug($request->name);
        $role->save();
        return redirect()->route('admin.role.index')->with('success', 'Role berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->name = $request->name;
        $role->slug = Str::slug($request->name);
        $role->save();
        return redirect()->route('admin.role.index')->with('success', 'Role berhasil diperbarui');
    }
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->route('admin.role.index')->with('success', 'Role berhasil dihapus');
    }
}

