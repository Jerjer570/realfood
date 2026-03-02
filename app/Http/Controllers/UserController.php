<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan halaman profil user (Berdasarkan ProfilePage.tsx)
     */
    public function index()
    {
        $user = Auth::user();
        // Mengambil sesi aktif (jika kamu ingin fitur 'Device Ini' seperti di React)
        $sessions = []; 

        return view('pages.profile', compact('user', 'sessions'));
    }

    /**
     * Memperbarui data profil (Nama, Telepon, Alamat)
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::id());

        $request->validate([
            'nama' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $user->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menampilkan riwayat pesanan (Berdasarkan OrderHistoryPage.tsx)
     */
    public function orderHistory()
    {
        // Mengambil pesanan milik user, diurutkan dari yang terbaru
        $orders = pesanan::where('id_user', Auth::id())
            ->with('keranjangg') // Pastikan ada relasi 'items' di model pesanan
            ->latest()
            ->get();

        return view('pages.orders', compact('orders'));
    }
}