<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\packages;
use App\Models\photographer;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

class packageController extends Controller
{
    public function index(Request $request)
    {
        $query = packages::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $package = $query->paginate(10);
        return view('Admin.packages.index', compact('package'));
    }
    public function store(Request $request)
    {
        $package = new packages();
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->is_active = $request->status;
        $package->save();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Menambahkan paket baru: ' . $package->name,
            'module' => 'Data Master'
        ]);

        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $package = packages::find($id);
        $package->name = $request->name;
        $package->price = $request->price;
        $package->description = $request->description;
        $package->is_active = $request->status;
        $package->save();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Mengubah data paket: ' . $package->name,
            'module' => 'Data Master'
        ]);

        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil diperbarui');
    }
    public function destroy($id)
    {
        $package = packages::find($id);
        $name = $package->name;
        $package->delete();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Menghapus paket: ' . $name,
            'module' => 'Data Master'
        ]);

        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil dihapus');
    }
}
