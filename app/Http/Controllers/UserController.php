<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File; // Tambahkan ini untuk mengelola file

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
     * 3. Menyimpan User Baru (Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,user',
            'no_hp'    => 'nullable|string|max:20',
            'alamat'   => 'nullable|string',
            'foto'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi foto
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['status_email'] = 'unverified';

        // Logika Simpan Foto ke PUBLIC/IMAGES/PROFILES
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $nama_foto = time() . '_' . str_replace(' ', '-', $request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $nama_foto);
            $data['foto'] = 'images/profiles/' . $nama_foto;
        }

        User::create($data);

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
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:user,email,' . $user->id_user . ',id_user',
            'role'   => 'required|in:admin,user',
            'no_hp'  => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Logika Update Foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && File::exists(public_path($user->foto))) {
                File::delete(public_path($user->foto));
            }

            $file = $request->file('foto');
            $nama_foto = time() . '_' . str_replace(' ', '-', $request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $nama_foto);
            $data['foto'] = 'images/profiles/' . $nama_foto;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    /**
     * 6. Menghapus Pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id_user == Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        // Hapus file foto dari folder public sebelum data dihapus
        if ($user->foto && File::exists(public_path($user->foto))) {
            File::delete(public_path($user->foto));
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus!');
    }

    /* |--------------------------------------------------------------------------
    | USER PROFILE METHODS (Untuk User Biasa di Halaman Profile)
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
            'foto'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'nama'   => $request->nama,
            'no_hp'  => $request->no_hp,
            'alamat' => $request->alamat,
        ];

        if ($request->hasFile('foto')) {
            if ($user->foto && File::exists(public_path($user->foto))) {
                File::delete(public_path($user->foto));
            }

            $file = $request->file('foto');
            $nama_foto = time() . '_' . str_replace(' ', '-', $request->nama) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/profiles'), $nama_foto);
            $data['foto'] = 'images/profiles/' . $nama_foto;
        }

        $user->update($data);

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

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'Password berhasil diperbarui!');
    }
}