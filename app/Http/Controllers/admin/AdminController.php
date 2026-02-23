<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * 1. DASHBOARD UTAMA
     * Menampilkan ringkasan statistik cepat dan pesanan terbaru.
     */
    public function index()
    {
        $stats = [
            'totalUsers' => User::where('role', 'user')->count(),
            'totalMenuItems' => Food::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::where('status', 'completed')->sum('total'),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'processingOrders' => Order::where('status', 'processing')->count(),
            'completedOrders' => Order::where('status', 'completed')->count(),
        ];

        // Mengambil 5 pesanan terbaru beserta data user-nya
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }

    /**
     * 2. HALAMAN ANALYTICS
     * Fokus pada performa menu, tren, dan data visual.
     */
    public function analytics()
    {
        $totalOrders = Order::count();
        $totalCustomers = User::where('role', 'user')->count();
        $completedOrders = Order::where('status', 'completed')->get();
        $totalRevenue = $completedOrders->sum('total');
        
        $averageOrderValue = $completedOrders->count() > 0 
            ? $totalRevenue / $completedOrders->count() 
            : 0;

        // Query Menu Terlaris (Top Selling Items)
        $topItems = DB::table('order_items')
            ->join('food', 'order_items.food_id', '=', 'food.id')
            ->select('food.name', 
                     DB::raw('SUM(order_items.quantity) as count'), 
                     DB::raw('SUM(order_items.quantity * order_items.price) as revenue'))
            ->groupBy('food.name', 'food.id')
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
     * 3. HALAMAN LAPORAN KEUANGAN (NEW)
     * Halaman khusus untuk ekspor metrik finansial utama (AOV, Revenue, dll).
     */
    public function financialReport()
    {
        $completedOrders = Order::where('status', 'completed')->get();
        
        $totalRevenue = $completedOrders->sum('total');
        $totalOrders = Order::count();
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
        $menuItems = Food::latest()->get();
        return view('admin.menu.index', compact('menuItems'));
    }

    public function menuStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|url',
            'category' => 'required|string',
        ]);

        Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image,
            'category' => $request->category,
            'rating' => 0,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan!');
    }

    public function menuUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|url',
            'category' => 'required|string',
        ]);

        $food = Food::findOrFail($id);
        $food->update($request->all());

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    public function menuDestroy($id)
    {
        $food = Food::findOrFail($id);
        $food->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * 5. FITUR KELOLA PESANAN
     */
    public function ordersIndex(Request $request)
    {
        $status = $request->query('status', 'all');
        $query = Order::with(['user', 'items.food'])->latest();

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $orders = $query->get();
        return view('admin.orders.index', compact('orders'));
    }

    public function orderUpdate(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

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

        $users = $query->get();
        return view('admin.users.index', compact('users'));
    }
}
