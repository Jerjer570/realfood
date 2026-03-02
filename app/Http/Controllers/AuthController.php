<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Hash::make tidak lagi dibutuhkan di sini karena sudah ditangani oleh Model

class AuthController extends Controller
{
    // --- LOGIN ---

    public function showLogin()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended('/menu');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang kamu masukkan salah.',
        ])->onlyInput('email');
    }

    // --- REGISTER ---

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', 
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        // PERBAIKAN: Kirim password asli (plain string). 
        // Model User akan men-hash otomatis karena adanya cast 'password' => 'hashed'.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, 
            'role' => 'user', 
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        Auth::login($user);

        return redirect('/menu')->with('success', 'Akun berhasil dibuat!');
    }

    // --- LOGOUT ---

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}