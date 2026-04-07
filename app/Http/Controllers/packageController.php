<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\packages;
use App\Models\photographer;

class packageController extends Controller
{
    public function index()
    {
        $package = packages::all();
        return view('Admin.packages.index', compact('package'));
    }
    public function create()
    {
        $package = packages::all();
        return view('Admin.packages.create', compact('package'));
    }

    public function store(Request $request)
    {
        $package = new packages();
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->save();
        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil ditambahkan');
    }

    public function edit($id)
    {
        $package = packages::all();
        $package_edit = packages::find($id); // Using _edit for consistency in Drawer controllers
        return view('Admin.packages.update', compact('package', 'package_edit'));
    }

    public function update(Request $request, $id)
    {
        $package = packages::find($id);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->save();
        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil diperbarui');
    }
    public function destroy($id)
    {
        $package = packages::find($id);
        $package->delete();
        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil dihapus');
    }
}
