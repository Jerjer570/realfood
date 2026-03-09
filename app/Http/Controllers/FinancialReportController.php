<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinancialReportController extends Controller
{
    public function index()
    {
        // 1. Total Revenue: Menghitung total harga dari semua pesanan
      $totalRevenue = pesanan::sum(DB::raw('subtotal + ongkos_kirim'));

        // 2. Total Pesanan
        $totalOrders = pesanan::count();

        // 3. Total Pelanggan: Menghitung user dengan role 'user'
        $totalCustomers = User::where('role', 'user')->count();

        // 4. Average Order Value (AOV)
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // 5. Ambil data transaksi terbaru untuk tabel (Real-Time)
        // Menggunakan eager loading 'user' agar tidak berat saat mengambil nama pelanggan
        $recentOrders = pesanan::with('user')
            ->latest()
            ->take(10) // Ambil 10 transaksi terakhir
            ->get();

        // PERBAIKAN: Arahkan ke folder yang benar 'admin.reports.financial'
        return view('admin.reports.financial', compact(
            'totalRevenue', 
            'totalOrders', 
            'totalCustomers', 
            'averageOrderValue',
            'recentOrders'
        ));
    }
}