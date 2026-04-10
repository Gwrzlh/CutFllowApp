<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\photographer;
use App\models\lokasi;
use App\Models\LogActivity;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class picController extends Controller
{
    public function index(Request $request)
    {
        $query = photographer::query();

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }
        $photographer = $query->paginate(10);
        return view('Admin.pic.index', compact('photographer'));
    }
    public function create()
    {
        $photographer = photographer::all()->paginate(5);
        return view('Admin.pic.create', compact('photographer'));
    }

    public function edit($id)
    {
        $photographer = photographer::all();
        $pic = photographer::find($id);
        return view('Admin.pic.update', compact('photographer', 'pic'));
    }

    public function store(Request $request)
    {
        $photographer = new photographer();
        $photographer->name = $request->name;
        $photographer->phone = $request->phone;
        $photographer->save();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Menambahkan PIC baru: ' . $photographer->name,
            'module' => 'Data Master'
        ]);

        return redirect()->route('admin.pic.index')->with('success', 'PIC berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $photographer = photographer::find($id);
        $photographer->name = $request->name;
        $photographer->phone = $request->phone;
        $photographer->save();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Mengubah data PIC: ' . $photographer->name,
            'module' => 'Data Master'
        ]);

        return redirect()->route('admin.pic.index')->with('success', 'PIC berhasil diperbarui');
    }
    public function destroy($id)
    {
        $photographer = photographer::find($id);

        if ($photographer->Transaction()->exists()) {
            return redirect()->route('admin.pic.index')->with('error', 'PIC tidak bisa dihapus karena sudah terdaftar di transaksi');
        }

        $name = $photographer->name;
        $photographer->delete();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Menghapus PIC: ' . $name,
            'module' => 'Data Master'
        ]);

        return redirect()->route('admin.pic.index')->with('success', 'PIC berhasil dihapus');
    }
}

