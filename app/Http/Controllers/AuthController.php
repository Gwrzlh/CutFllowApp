<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\LogActivity;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $user = Auth::user();
            
            if ($user->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'Akun Anda sudah tidak aktif. Silakan hubungi Administrator.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            LogActivity::create([
                'user_id' => $user->id,
                'action' => 'Melakukan Login',
                'module' => 'Authentication'
            ]);

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * Redirect user based on their role slug.
     */
    private function redirectBasedOnRole($user)
    {
        $role = $user->role->slug;
        
        switch ($role) {
            case 'admin':
                return redirect()->intended('/admin/dashboard');
            case 'kasir':
                return redirect()->intended('/kasir/dashboard');
            case 'owner':
                return redirect()->intended('/owner/dashboard');
            default:
                return redirect('/');
        }
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            LogActivity::create([
                'user_id' => Auth::id(),
                'action' => 'Melakukan Logout',
                'module' => 'Authentication'
            ]);
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
