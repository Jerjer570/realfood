@extends('layouts.admin') {{-- Ganti ke layout admin untuk Sidebar navigasi --}}

@section('content')
<div class="space-y-8">
    {{-- Page Header --}}
    <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">Dashboard Analytics</h1>
        <p class="text-gray-500 text-sm mt-1">Laporan performa penjualan dan statistik menu Real Food.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-green-600 text-white rounded-2xl shadow-lg shadow-green-100">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Revenue</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-blue-600 text-white rounded-2xl shadow-lg shadow-blue-100">
                    <i class="fas fa-shopping-bag text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Pesanan</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-purple-600 text-white rounded-2xl shadow-lg shadow-purple-100">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Pelanggan</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-orange-500 text-white rounded-2xl shadow-lg shadow-orange-100">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Avg. Order</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalRevenue / ($totalOrders ?: 1), 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Top Selling Items --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-black text-gray-900 italic">Menu Terlaris</h2>
                <i class="fas fa-fire text-orange-500"></i>
            </div>
            <div class="space-y-6">
                @foreach($topItems as $item)
                <div class="flex items-center justify-between group p-2 hover:bg-gray-50 rounded-2xl transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-50 text-green-600 rounded-2xl flex items-center justify-center font-black shadow-sm group-hover:bg-green-600 group-hover:text-white transition-all">
                            #{{ $loop->iteration }}
                        </div>
                        <div>
                            <p class="font-black text-gray-900">{{ $item->name }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $item->total_sold }} porsi terjual</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-black text-green-600 italic">Rp {{ number_format($item->revenue, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Placeholder for Trends --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8 flex flex-col items-center justify-center text-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mb-4">
                <i class="fas fa-chart-area text-3xl"></i>
            </div>
            <h3 class="text-gray-900 font-black">Revenue Trend</h3>
            <p class="text-gray-400 text-xs mt-2 max-w-xs">Grafik tren pendapatan mingguan akan muncul di sini setelah data mencukupi.</p>
        </div>
    </div>
</div>



@endsection