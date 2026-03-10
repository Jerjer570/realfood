<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\pesanan;
use App\Models\User;
use App\Models\menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

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
            'totalRevenue' => pesanan::where('status', 'selesai')->sum('subtotal'),
            'pendingOrders' => pesanan::where('status', 'menunggu')->count(),
            'processingOrders' => pesanan::where('status', 'dimasak')->orWhere('status', 'menuju alamat')->count(),
            'completedOrders' => pesanan::where('status', 'selesai')->count(),
        ];

        $recentOrders = pesanan::with('userr')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * 2. HALAMAN ANALYTICS
     */
    public function analytics()
    {
        $totalOrders = pesanan::count();
        $totalCustomers = User::where('role', 'user')->count();
        $completedOrders = pesanan::where('status', 'selesai')->get();
        $totalRevenue = $completedOrders->sum('subtotal');
        
        $averageOrderValue = $completedOrders->count() > 0 
            ? $totalRevenue / $completedOrders->count() 
            : 0;

        $topItems = DB::table('detail_pesanan')
            ->join('menu', 'detail_pesanan.id_menu', '=', 'menu.id_menu')
            ->select('menu.nama_menu', 
                     DB::raw('SUM(detail_pesanan.kuantitas) as count'), 
                     DB::raw('SUM(detail_pesanan.kuantitas * detail_pesanan.subtotal) as revenue'))
            ->groupBy('menu.nama_menu', 'menu.id_menu')
            ->orderByDesc('count')
            ->take(5)
            ->get();
        
        $grafikPendapatan = DB::table('pesanan')
        ->selectRaw('DATE(created_at) as tanggal, SUM(subtotal + ongkos_kirim) as total')
        ->where('status', 'selesai')
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('tanggal')
        ->orderBy('tanggal', 'asc')
        ->get();

        // Mapping ke nama hari (Indonesia)
        $labels = [];
        $totals = [];

        foreach ($grafikPendapatan as $row) {
            $labels[] = Carbon::parse($row->tanggal)->locale('id')->dayName;
            $totals[] = $row->total;
        }
        return view('admin.analytics', compact(
            'totalRevenue', 
            'averageOrderValue', 
            'topItems', 
            'totalOrders', 
            'totalCustomers',
            'labels',
            'totals'
        ));
    }

    /**
     * 3. HALAMAN LAPORAN KEUANGAN
     */
    public function financialReport()
    {
        $completedOrders = pesanan::where('status', 'selesai')->get();
        
        $totalOrders = pesanan::count();
        $totalCustomers = User::where('role', 'user')->count();
        
        $totalPendapatanOngkir = $completedOrders->sum('ongkos_kirim');
        $totalPendapatanPesanan = $completedOrders->sum('subtotal');
        $totalRevenue = $totalPendapatanOngkir + $totalPendapatanPesanan;

        $averageOrderValue = $completedOrders->count() > 0 
            ? $totalRevenue / $completedOrders->count() 
            : 0;


        return view('admin.reports.financial', compact(
            'totalRevenue', 
            'totalOrders', 
            'totalCustomers', 
            'averageOrderValue',
            'totalPendapatanOngkir',
            'totalPendapatanPesanan'
        ));
    }

    /**
     * 4. FITUR KELOLA MENU (CRUD)
     */
    public function menuIndex()
    {
        $menuItems = menu::latest()->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function menuStore(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'kalori' => 'nullable|numeric',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'gambar' => 'required|image|mimes:jfif,jpeg,png,jpg,webp|max:2048',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/'), $imageName);
        }

        menu::create([
            'nama_menu' => $request->nama_menu,
            'harga' => $request->harga,
            'kalori' => $request->kalori ?? 0,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'gambar' => $imageName,
            'rating' => $request->rating ?? 0, 
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function menuUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jfif,jpeg,png,jpg,webp|max:2048',
            'kategori' => 'required|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'kalori' => 'nullable|numeric',
        ]);

        $menu = menu::findOrFail($id);
        $data = $request->except('gambar'); // Ambil semua data kecuali gambar dulu

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari folder
            if ($menu->gambar && File::exists(public_path('images/' . $menu->gambar))) {
                File::delete(public_path('images/' . $menu->gambar));
            }

            $image = $request->file('gambar');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['gambar'] = $imageName;
        }

        $menu->update($data);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function menuDestroy($id)
    {
        $menu = menu::findOrFail($id);

        // Hapus file gambar dari folder public/images sebelum menghapus data
        if ($menu->gambar && File::exists(public_path('images/' . $menu->gambar))) {
            File::delete(public_path('images/' . $menu->gambar));
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
        $query = pesanan::with(['userr', 'keranjangg.menuu'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dimasak,menuju alamat,selesai,dibatalkan'
        ]);

        $pesanan = pesanan::findOrFail($id);
        $pesanan->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * 6. FITUR KELOLA PENGGUNA
     */
    public function usersIndex(Request $request)
    {
        $role = $request->query('role', 'all');
        $query = User::latest();

        if ($role !== 'all') {
            $query->where('role', $role);
        }

        $usersss = $query->get();
        return view('admin.users.index', compact('usersss'));
    }

public function usersStore(Request $request){
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => ['required', 'regex:/^(?:\+62|0)8[0-9]{8,12}$/'],
            'foto_profil' => 'nullable|image|mimes:jfif,jpeg,png,jpg,webp|max:2048']);
        $imageName = null;
        if ($request->hasFile('foto_profil')) {
            $image = $request->file('foto_profil');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/pp'), $imageName); }
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'foto_profil' => $imageName,
            'status_email' => 'unverified']);
        return redirect()->back()->with('success', 'Pengguna berhasil ditambahkan!');
    }

    public function usersUpdate(Request $request, $id)
    {
       
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id . ',id_user',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string',
            'alamat' => 'required|string',
            'no_hp' => ['required', 'regex:/^(?:\+62|0)8[0-9]{8,12}$/'],
            'foto_profil' => 'nullable|image|mimes:jfif,jpeg,png,jpg,webp|max:2048',
        ]);
        
        if ($request->filled('password')) {
            $request->merge(['password' => Hash::make($request->password)]);
        } else {
            $request->request->remove('password');
        }
        

        $user = User::findOrFail($id);
        $data = $request->except('foto_profil');

        if ($request->hasFile('foto_profil')) {
            // Hapus foto profil lama dari folder
            if ($user->foto_profil && File::exists(public_path('images/pp/' . $user->foto_profil))) {
                File::delete(public_path('images/pp/' . $user->foto_profil));
            }

            $image = $request->file('foto_profil');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/pp/'), $imageName);
            $data['foto_profil'] = $imageName;
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Pengguna berhasil diperbarui!');
    }

    public function usersDestroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus file foto profil dari folder public/images/pp sebelum menghapus data
        if ($user->foto_profil && File::exists(public_path('images/pp/' . $user->foto_profil))) {
            File::delete(public_path('images/pp/' . $user->foto_profil));
        }

        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }
}