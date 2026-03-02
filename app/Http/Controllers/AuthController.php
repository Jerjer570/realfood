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
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', 
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        // PERBAIKAN: Kirim password asli (plain string). 
        // Model User akan men-hash otomatis karena adanya cast 'password' => 'hashed'.
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password, 
            'role' => 'user', 
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
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