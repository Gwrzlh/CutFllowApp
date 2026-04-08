<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Str;

class roleController extends Controller
{
    public function index(Request $request)
    {
        $query = Role::query();

        if ($request->filled('search')) {
            $query->where('name', 'LIKE', "%{$request->search}%");
        }

        $role = $query->paginate(10);
        return view('Admin.role.index', compact('role'));
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

