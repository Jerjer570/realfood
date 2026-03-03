@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-3 italic">
            <i class="fas fa-history text-green-600"></i>
            Riwayat Pesanan
        </h1>

        @if($orders->isEmpty())
            <div class="text-center py-20 bg-white rounded-[3rem] shadow-sm border border-gray-100">
                <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                    <i class="fas fa-box-open text-4xl"></i>
                </div>
                <h2 class="text-2xl font-black text-gray-900 mb-2">Belum ada pesanan</h2>
                <p class="text-gray-500 mb-8">Pesanan sehatmu akan muncul di sini setelah kamu berbelanja.</p>
                <a href="{{ route('menu') }}" class="inline-block bg-green-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-green-700 transition-all shadow-lg shadow-green-100 active:scale-95">
                    Pesan Sekarang
                </a>
            </div>
        @else
            <div class="space-y-8">
                @foreach($orders as $order)
                    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all">
                        {{-- Status Header --}}
                        <div class="p-6 border-b border-gray-50 flex flex-wrap justify-between items-center gap-4 bg-gray-50/30">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-white rounded-2xl text-green-600 shadow-sm">
                                    <i class="fas fa-receipt text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-widest font-black">ID Pesanan</p>
                                    <p class="font-black text-gray-900">#{{ $order->id_pesanan }}</p>
                                </div>
                            </div>
                            
                            {{-- Badge Status Bahasa Indonesia --}}
                            <div class="flex items-center gap-2 px-5 py-2 rounded-full text-[10px] font-black uppercase tracking-widest
                                @if($order->status == 'completed') bg-green-100 text-green-700 
                                @elseif($order->status == 'pending') bg-gray-100 text-gray-600 
                                @elseif($order->status == 'dimasak') bg-orange-100 text-orange-600
                                @elseif($order->status == 'dikemas') bg-blue-100 text-blue-600
                                @elseif($order->status == 'diantar') bg-purple-100 text-purple-600
                                @else bg-red-100 text-red-600 @endif">
                                
                                <i class="fas 
                                    @if($order->status == 'completed') fa-check-circle 
                                    @elseif($order->status == 'pending') fa-clock 
                                    @elseif($order->status == 'dimasak') fa-utensils
                                    @elseif($order->status == 'dikemas') fa-box
                                    @elseif($order->status == 'diantar') fa-truck
                                    @else fa-times-circle @endif"></i>

                                @php
                                    $statusIndo = [
                                        'pending' => 'Menunggu',
                                        'dimasak' => 'Dimasak',
                                        'dikemas' => 'Dikemas',
                                        'diantar' => 'Diantar',
                                        'completed' => 'Sampai Tujuan',
                                        'cancelled' => 'Batal'
                                    ];
                                @endphp
                                {{ $statusIndo[$order->status] ?? $order->status }}
                            </div>
                        </div>

                        {{-- Item List --}}
                        <div class="p-8 space-y-6">
                            @foreach($order->keranjangg as $item)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-2xl overflow-hidden border border-gray-100">
                                            <img src="{{ asset($item->menu->gambar) }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-black text-gray-900">{{ $item->menu->nama_menu }}</p>
                                            <p class="text-xs text-gray-400 font-bold">Qty: {{ $item->kuantitas }} × Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                    <p class="font-black text-gray-900">Rp {{ number_format($item->harga * $item->kuantitas, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                        </div>

                        {{-- Summary Footer --}}
                        <div class="p-8 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-6 border-t border-gray-50">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-black text-green-600 italic">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</p>
                            </div>
                            
                            @if($order->status == 'completed')
                                <a href="{{ route('menu') }}" class="w-full md:w-auto">
                                    <button class="w-full bg-green-600 text-white px-10 py-4 rounded-2xl font-black hover:bg-green-700 transition-all shadow-lg shadow-green-100 active:scale-95 flex items-center justify-center gap-2">
                                        <i class="fas fa-redo-alt text-sm"></i> Pesan Lagi
                                    </button>
                                </a>
                            @endif
                        </div>

                        {{-- Delivery Address --}}
                        <div class="px-8 py-4 bg-white border-t border-gray-50 text-[11px] text-gray-400 font-bold">
                            <p class="flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-green-600"></i> 
                                <span class="uppercase tracking-widest mr-1">Tujuan:</span> 
                                {{ $order->alamat_pengiriman }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection