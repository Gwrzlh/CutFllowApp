<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lokasi;

class lokasiController extends Controller
{
    public function index()
    {
      $lokasi = lokasi::all();
      return view('Admin.lokasi.index', compact('lokasi'));
    }
    public function create()
    {
      return view('Admin.lokasi.create');
    }
    public function store(Request $request)
    {
      $lokasi = new lokasi();
      $lokasi->name = $request->name;
      $lokasi->Kabupaten = $request->Kabupaten;
      $lokasi->save();
      return redirect()->route('admin.lokasi.index');
    }
    public function edit($id)
    {
      $lokasi = lokasi::find($id);
      return view('Admin.lokasi.update', compact('lokasi'));
    }
    public function update(Request $request, $id)
    {
      $lokasi = lokasi::find($id);
      $lokasi->name = $request->name;
      $lokasi->Kabupaten = $request->Kabupaten;
      $lokasi->save();
      return redirect()->route('admin.lokasi.index');
    }
    public function destroy($id)
    {
      $lokasi = lokasi::find($id);
      $lokasi->delete();
      return redirect()->route('admin.lokasi.index');
    }
}
