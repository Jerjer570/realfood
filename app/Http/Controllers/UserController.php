<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
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
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menampilkan riwayat pesanan (Berdasarkan OrderHistoryPage.tsx)
     */
    public function orderHistory()
    {
        // Mengambil pesanan milik user, diurutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
            ->with('items') // Pastikan ada relasi 'items' di model Order
            ->latest()
            ->get();

        return view('pages.orders', compact('orders'));
    }
}