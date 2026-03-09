<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\pesanan;
use App\Models\User;
use App\Models\menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash; // Tambahkan ini untuk enkripsi password

class AdminController extends Controller
{
    /**
     * 1. DASHBOARD UTAMA
     */
    public function index()
    {
        $stats = [
            'totalUsers' => User::where('role', 'user')->count(),
            'totalMenuItems' => menu::count(),
            'totalOrders' => pesanan::count(),
            'totalRevenue' => pesanan::where('status', 'completed')->sum('subtotal') ?? 0,
            'pendingOrders' => pesanan::where('status', 'pending')->count(),
            'processingOrders' => pesanan::where('status', 'dimasak')->orWhere('status', 'dikemas')->count(),
            'completedOrders' => pesanan::where('status', 'completed')->count(),
        ];

        $recentOrders = pesanan::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * 2. HALAMAN ANALYTICS
     */
    public function analytics()
    {
        $totalOrders = pesanan::count();
        $totalCustomers = User::where('role', 'user')->count();
        $completedOrders = pesanan::where('status', 'completed')->get();
        $totalRevenue = $completedOrders->sum('subtotal');
        
        $averageOrderValue = $completedOrders->count() > 0 
            ? $totalRevenue / $completedOrders->count() 
            : 0;

        $topItems = DB::table('detail_pesanan')
            ->join('menu', 'detail_pesanan.id_menu', '=', 'menu.id_menu')
            ->select('menu.nama_menu', 
                     DB::raw('SUM(detail_pesanan.kuantitas) as count'), 
                     DB::raw('SUM(detail_pesanan.kuantitas * menu.harga) as revenue'))
            ->groupBy('menu.nama_menu', 'menu.id_menu', 'menu.harga')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return view('admin.analytics', compact(
            'totalRevenue', 
            'averageOrderValue', 
            'topItems', 
            'totalOrders', 
            'totalCustomers'
        ));
    }

    /**
     * 3. HALAMAN LAPORAN KEUANGAN
     */
    public function financialReport()
    {
        $completedOrders = pesanan::where('status', 'completed')->get();
        $totalRevenue = $completedOrders->sum('subtotal');
        $totalOrders = pesanan::count();
        $totalCustomers = User::where('role', 'user')->count();
        
        $averageOrderValue = $completedOrders->count() > 0 
            ? $totalRevenue / $completedOrders->count() 
            : 0;

        return view('admin.reports.financial', compact(
            'totalRevenue', 
            'totalOrders', 
            'totalCustomers', 
            'averageOrderValue'
        ));
    }

    /**
     * 4. FITUR KELOLA MENU (CRUD)
     */
    public function menuIndex()
    {
        $menuItems = menu::latest()->paginate(10); 
        return view('admin.menu.index', compact('menuItems'));
    }

    public function menuStore(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga'     => 'required|numeric',
            'gambar'    => 'required|image|mimes:jfif,jpeg,png,jpg,webp|max:2048',
            'kategori'  => 'required|string',
            'rating'    => 'nullable|numeric|min:0|max:5',
            'kalori'    => 'nullable|numeric',
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = 'images/' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        }

        menu::create([
            'nama_menu' => $request->nama_menu,
            'deskripsi' => $request->deskripsi,
            'harga'     => $request->harga,
            'gambar'    => $imageName,
            'kategori'  => $request->kategori,
            'rating'    => $request->rating ?? 0,
            'kalori'    => $request->kalori ?? 0,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function menuUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga'     => 'required|numeric',
            'gambar'    => 'nullable|image|mimes:jfif,jpeg,png,jpg,webp|max:2048',
            'kategori'  => 'required|string',
            'rating'    => 'nullable|numeric|min:0|max:5',
            'kalori'    => 'nullable|numeric',
        ]);

        $menu = menu::findOrFail($id);
        $data = $request->except('gambar');

        if ($request->hasFile('gambar')) {
            if ($menu->gambar && File::exists(public_path($menu->gambar))) {
                File::delete(public_path($menu->gambar));
            }

            $image = $request->file('gambar');
            $imageName = 'images/' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['gambar'] = $imageName;
        }

        $menu->update($data);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function menuDestroy($id)
    {
        $menu = menu::findOrFail($id);
        if ($menu->gambar && File::exists(public_path($menu->gambar))) {
            File::delete(public_path($menu->gambar));
        }
        $menu->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * 5. FITUR KELOLA PESANAN
     */
    public function ordersIndex(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = pesanan::with(['user', 'keranjangg.menu'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->paginate(10); 
        return view('admin.orders.index', compact('orders'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,dimasak,dikemas,diantar,completed,cancelled'
        ]);

        $pesanan = pesanan::findOrFail($id);
        $pesanan->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * 6. FITUR KELOLA PENGGUNA (CRUD)
     */
    public function usersIndex(Request $request)
    {
        $role = $request->query('role', 'all');
        $query = User::latest();

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $users = $query->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan Form Tambah User
    public function userCreate()
    {
        return view('admin.users.create');
    }

    // Menyimpan Data User Baru
    public function userStore(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:admin,user',
            'no_hp'    => 'nullable|string|max:15',
            'alamat'   => 'nullable|string',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role'     => $request->role,
            'no_hp'    => $request->no_hp,
            'alamat'   => $request->alamat,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna baru berhasil ditambahkan!');
    }
}