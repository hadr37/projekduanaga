<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin() {
        return view('auth.login');
    }

    public function showRegister() {
        return view('auth.register');
    }

public function register(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed|min:6',
        'role' => 'required|in:admin,user'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role, // simpan role dari form
    ]);

    return redirect()->route('login')->with('success', 'Pendaftaran berhasil. Silakan login.');
}



public function login(Request $request)
{
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
    
        // Cek role setelah login berhasil
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'user') {
            
            return redirect()->route('katalog');

        } else {
            Auth::logout(); // keluar jika role tidak dikenali
            return back()->with('error', 'Role tidak dikenali');
        }
    }

    return back()->with('error', 'Email atau password salah');
}



    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
