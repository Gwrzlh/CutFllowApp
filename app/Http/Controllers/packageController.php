<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\package;
use App\Models\photographer;

class packageController extends Controller
{
    public function index()
    {
        $package = package::all();
        return view('Admin.package.index', compact('package'));
    }
    public function create()
    {
        $photographer = photographer::all();
        return view('Admin.package.create', compact('photographer'));
    }
    public function store(Request $request)
    {
        $package = new package();
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->save();
        return redirect()->route('admin.package.index');
    }
    public function edit($id)
    {
        $package = package::find($id);
        return view('Admin.package.update', compact('package'));
    }
    public function update(Request $request, $id)
    {
        $package = package::find($id);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->save();
        return redirect()->route('admin.package.index');
    }
    public function destroy($id)
    {
        $package = package::find($id);
        $package->delete();
        return redirect()->route('admin.package.index');
    }
}
