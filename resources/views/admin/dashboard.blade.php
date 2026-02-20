@extends('layouts.admin') {{-- Ganti ke layout admin agar Sidebar muncul --}}

@section('content')
<div class="space-y-8">
    {{-- Top Section: Welcome & Status --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Admin Dashboard</h1>
            <p class="text-gray-500 text-sm mt-1 font-medium">Pantau performa Real Food hari ini secara real-time.</p>
        </div>
        <div class="flex items-center gap-3 bg-white px-5 py-2.5 rounded-2xl shadow-sm border border-gray-100 self-start">
            <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse shadow-[0_0_10px_rgba(34,197,94,0.6)]"></div>
            <span class="text-[10px] font-black text-gray-500 uppercase tracking-widest">Sistem Online</span>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-4 bg-green-600 text-white rounded-2xl shadow-lg shadow-green-100 group-hover:scale-110 transition-transform">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-green-600 bg-green-50 px-3 py-1 rounded-full uppercase tracking-tighter">+12.5%</span>
            </div>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Total Revenue</p>
            <h3 class="text-2xl font-black text-gray-900 italic">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-4 bg-blue-600 text-white rounded-2xl shadow-lg shadow-blue-100 group-hover:scale-110 transition-transform">
                    <i class="fas fa-shopping-bag text-xl"></i>
                </div>
                <span class="text-[10px] font-black text-blue-600 bg-blue-50 px-3 py-1 rounded-full uppercase tracking-tighter">{{ $stats['totalOrders'] }} Total</span>
            </div>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Pesanan Selesai</p>
            <h3 class="text-2xl font-black text-gray-900 italic">{{ $stats['completedOrders'] }}</h3>
        </div>

        <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-4 bg-purple-600 text-white rounded-2xl shadow-lg shadow-purple-100 group-hover:scale-110 transition-transform">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Total Pelanggan</p>
            <h3 class="text-2xl font-black text-gray-900 italic">{{ $stats['totalUsers'] }}</h3>
        </div>

        <div class="bg-white p-7 rounded-[2.5rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all group">
            <div class="flex justify-between items-start mb-4">
                <div class="p-4 bg-orange-500 text-white rounded-2xl shadow-lg shadow-orange-100 group-hover:scale-110 transition-transform">
                    <i class="fas fa-utensils text-xl"></i>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Menu Aktif</p>
            <h3 class="text-2xl font-black text-gray-900 italic">{{ $stats['totalMenuItems'] }}</h3>
        </div>
    </div>

    {{-- Main Row: Recent Orders & Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Recent Orders Section --}}
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-50 flex justify-between items-center">
                <h2 class="text-xl font-black text-gray-900 italic">Pesanan Terbaru</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black uppercase tracking-widest text-green-600 hover:text-green-700 transition-colors">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentOrders as $order)
                <div class="p-8 flex items-center justify-between hover:bg-gray-50/50 transition-colors group">
                    <div class="flex items-center gap-5">
                        <div class="p-4 rounded-2xl transition-all shadow-sm
                            @if($order->status == 'pending') bg-yellow-50 text-yellow-600 group-hover:bg-yellow-100 
                            @elseif($order->status == 'processing') bg-blue-50 text-blue-600 group-hover:bg-blue-100
                            @else bg-green-50 text-green-600 group-hover:bg-green-100 @endif">
                            <i class="fas @if($order->status == 'pending') fa-clock @elseif($order->status == 'processing') fa-box @else fa-check @endif text-lg"></i>
                        </div>
                        <div>
                            <p class="font-black text-gray-900 text-base">Order #{{ $order->id }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-gray-900 text-lg">Rp {{ number_format($order->total, 0, ',', '.') }}</p>
                        <span class="text-[10px] font-black uppercase tracking-widest
                            @if($order->status == 'pending') text-yellow-600 
                            @elseif($order->status == 'processing') text-blue-600
                            @else text-green-600 @endif">
                            {{ $order->status }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-16 text-center">
                    <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <i class="fas fa-inbox text-2xl"></i>
                    </div>
                    <p class="text-gray-400 font-bold italic">Belum ada pesanan masuk.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions Section --}}
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                <h2 class="text-xl font-black text-gray-900 mb-8 italic">Aksi Cepat</h2>
                <div class="grid gap-5">
                    <a href="{{ route('admin.menu.index') }}" class="flex items-center justify-between p-5 bg-green-600 text-white rounded-3xl hover:bg-green-700 transition shadow-lg shadow-green-100 group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-plus-circle text-xl"></i>
                            <span class="text-xs font-black uppercase tracking-widest">Tambah Menu</span>
                        </div>
                        <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    
                    <a href="{{ route('admin.menu.index') }}" class="flex items-center justify-between p-5 bg-white border border-gray-100 text-gray-700 rounded-3xl hover:border-green-600 hover:text-green-600 transition shadow-sm group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-list-ul text-xl text-gray-400 group-hover:text-green-600 transition-colors"></i>
                            <span class="text-xs font-black uppercase tracking-widest">Kelola Menu</span>
                        </div>
                        <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between p-5 bg-white border border-gray-100 text-gray-700 rounded-3xl hover:border-blue-600 hover:text-blue-600 transition shadow-sm group">
                        <div class="flex items-center gap-4">
                            <i class="fas fa-truck text-xl text-gray-400 group-hover:text-blue-600 transition-colors"></i>
                            <span class="text-xs font-black uppercase tracking-widest">Cek Pengiriman</span>
                        </div>
                        <i class="fas fa-chevron-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection