<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\photographer;

class picController extends Controller
{
    public function index()
    {
        $photographer = photographer::with('lokasi')->get();
        return view('Admin.photographer.index', compact('photographer'));
    }
    public function create()
    {
        $lokasi = lokasi::all();
        return view('Admin.photographer.create', compact('lokasi'));
    }
    public function store(Request $request)
    {
        $photographer = new photographer();
        $photographer->name = $request->name;
        $photographer->lokasi_id = $request->lokasi_id;
        $photographer->phone = $request->phone;
        $photographer->save();
        return redirect()->route('admin.photographer.index');
    }
    public function edit($id)
    {
        $photographer = photographer::find($id);
        return view('Admin.photographer.update', compact('photographer'));
    }
    public function update(Request $request, $id)
    {
        $photographer = photographer::find($id);
        $photographer->name = $request->name;
        $photographer->lokasi_id = $request->lokasi_id;
        $photographer->phone = $request->phone;
        $photographer->save();
        return redirect()->route('admin.photographer.index');
    }
    public function destroy($id)
    {
        $photographer = photographer::find($id);
        $photographer->delete();
        return redirect()->route('admin.photographer.index');
    }
}
