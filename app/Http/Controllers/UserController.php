<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * 1. Menampilkan Daftar User (Paginasi)
     */
    public function listUsers(Request $request)
    {
        $roleFilter = $request->query('role', 'all');
        $query = User::query();

        if ($roleFilter !== 'all') {
            $query->where('role', $roleFilter);
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * 2. Menampilkan Form Tambah User/Admin
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * 3. Menyimpan User Baru ke Database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user,email', // Gunakan 'user' sesuai nama tabel
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,user',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
        ]);

        User::create([
            'nama'         => $request->nama,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'no_hp'        => $request->no_hp,
            'alamat'       => $request->alamat,
            'status_email' => 'unverified',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * 4. Menampilkan Form Edit User (Admin)
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * 5. Memperbarui Data User oleh Admin
     */
    public function updateAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'  => 'required|string|max:255',
            // Kecualikan ID user saat ini dari pengecekan unik email
            'email' => 'required|email|unique:user,email,' . $user->id_user . ',id_user',
            'role'  => 'required|in:admin,user',
            'no_hp' => 'nullable|string|max:20',
            'alamat'=> 'nullable|string',
        ]);

        $user->update([
            'nama'  => $request->nama,
            'email' => $request->email,
            'role'  => $request->role,
            'no_hp' => $request->no_hp,
            'alamat'=> $request->alamat,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * 6. Menghapus Pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Proteksi agar admin tidak menghapus dirinya sendiri
        if ($user->id_user == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }

    /* |--------------------------------------------------------------------------
    | USER PROFILE METHODS (Untuk User Biasa)
    |--------------------------------------------------------------------------
    */

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
            'nama'   => 'required|string|max:255',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $user->update([
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
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

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:8|confirmed',
    ], [
        'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        'new_password.min'       => 'Password baru minimal 8 karakter.',
    ]);

    $user = Auth::user();

    // Cek apakah password lama benar
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Password saat ini salah.']);
    }

    // Update password
    $user->update([
        'password' => Hash::make($request->new_password)
    ]);

    return back()->with('success', 'Password berhasil diperbarui!');
}

}