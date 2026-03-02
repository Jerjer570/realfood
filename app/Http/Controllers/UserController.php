<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // Method untuk menampilkan 10 baris data per halaman (Paginasi)
    public function listUsers(Request $request)
    {
        $roleFilter = $request->query('role', 'all');
        $query = User::query();

        if ($roleFilter !== 'all') {
            $query->where('role', $roleFilter);
        }

        // Ini kunci agar ->total() tidak error
        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function index()
    {
        $user = Auth::user();
        $sessions = []; 
        return view('pages.profile', compact('user', 'sessions'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
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

    public function orderHistory()
    {
        $orders = pesanan::where('id_user', Auth::id())
            ->with('keranjangg') 
            ->latest()
            ->get();

        return view('pages.orders', compact('orders'));
    }
}