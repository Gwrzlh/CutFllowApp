<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\lokasi;

class lokasiController extends Controller
{
    public function index(Request $request)
    {
      $query = lokasi::query();

      if ($request->filled('search')) {
          $search = $request->search;
          $query->where(function($q) use ($search) {
              $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('Kabupaten', 'LIKE', "%{$search}%");
          });
      }

      $lokasi = $query->paginate(10);
      return view('Admin.lokasi.index', compact('lokasi'));
    }
    public function store(Request $request)
    {
      $lokasi = new lokasi();
      $lokasi->name = $request->name;
      $lokasi->Kabupaten = $request->Kabupaten;
      $lokasi->save();
      return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
      $lokasi = lokasi::find($id);
      $lokasi->name = $request->name;
      $lokasi->Kabupaten = $request->Kabupaten;
      $lokasi->save();
      return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil diperbarui');
    }
    public function destroy($id)
    {
      $lokasi = lokasi::find($id);
      $lokasi->delete();
      return redirect()->route('admin.lokasi.index')->with('success', 'Lokasi berhasil dihapus');
    }
}
