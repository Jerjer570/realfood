<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // Regenerate session untuk keamanan dan mencegah 419 di aksi berikutnya
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
            // PERBAIKAN: Gunakan tabel 'user' sesuai migration Anda, bukan 'users'
            'email' => 'required|string|email|max:255|unique:user,email',
            'password' => 'required|string|min:6|confirmed', 
            'no_hp' => 'nullable|string',
            'alamat' => 'nullable|string',
        ]);

        // Model User akan men-hash otomatis jika di model ada protected $casts = ['password' => 'hashed']
        $user = User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => $request->password, 
            'role' => 'user', 
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'status_email' => 'unverified', // Menambah default value agar tidak null di DB
        ]);

        Auth::login($user);

        return redirect('/menu')->with('success', 'Selamat datang! Akun berhasil dibuat.');
    }

    // --- LOGOUT ---

    public function logout(Request $request)
    {
        // 1. Proses Logout dari Auth Guard
        Auth::logout();

        // 2. Hancurkan data sesi di server agar 419 tidak muncul saat login ulang
        

        // 3. Buat ulang CSRF Token baru untuk sesi tamu (guest)
        $request->session()->regenerateToken();

        // 4. Kembali ke beranda dengan pesan sukses
        return redirect('/')->with('success', 'Sampai jumpa kembali!');
    }
}