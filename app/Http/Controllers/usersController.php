<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\role;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

class usersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Role Filter
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->role_id);
        }

        $user = $query->paginate(10);
        $role = role::all();
        return view('Admin.users.index', compact('user', 'role'));
    }
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->status = $request->status ?? 'active';
        $user->save();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Menambahkan user baru: ' . $user->name,
            'module' => 'User Management'
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->save();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Mengubah data user: ' . $user->name,
            'module' => 'User Management'
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui');
    }
    public function destroy($id)
    {
        $user = User::find($id);
        $name = $user->name;
        $user->delete();
        
        LogActivity::create([
            'user_id' => Auth::id(),
            'action' => 'Menghapus user: ' . $name,
            'module' => 'User Management'
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus');
    }
}
