<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\photographer;
use App\models\lokasi;

class picController extends Controller
{
    public function index(Request $request)
    {
        $query = photographer::with('lokasi');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Location Filter (Kabupaten)
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        $photographer = $query->paginate(10);
        $lokasi = lokasi::all();
        return view('Admin.pic.index', compact('photographer', 'lokasi'));
    }
    public function create()
    {
        $photographer = photographer::with('lokasi')->get();
        $lokasi = lokasi::all();
        return view('Admin.pic.create', compact('photographer', 'lokasi'));
    }

    public function edit($id)
    {
        $photographer = photographer::with('lokasi')->get();
        $lokasi = lokasi::all();
        $pic = photographer::find($id);
        return view('Admin.pic.update', compact('photographer', 'lokasi', 'pic'));
    }

    public function store(Request $request)
    {
        $photographer = new photographer();
        $photographer->name = $request->name;
        $photographer->location_id = $request->location_id;
        $photographer->phone = $request->phone;
        $photographer->save();
        return redirect()->route('admin.pic.index')->with('success', 'PIC berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $photographer = photographer::find($id);
        $photographer->name = $request->name;
        $photographer->location_id = $request->location_id;
        $photographer->phone = $request->phone;
        $photographer->save();
        return redirect()->route('admin.pic.index')->with('success', 'PIC berhasil diperbarui');
    }
    public function destroy($id)
    {
        $photographer = photographer::find($id);
        $photographer->delete();
        return redirect()->route('admin.pic.index')->with('success', 'PIC berhasil dihapus');
    }
}

