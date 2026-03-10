@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
            <i class="fas fa-history text-green-600"></i>
            Riwayat Pesanan
        </h1>

        @if($orders->isEmpty())
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-box-open text-3xl text-gray-400"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Belum ada pesanan</h2>
                <p class="text-gray-500 mb-8">Pesanan sehatmu akan muncul di sini setelah kamu berbelanja.</p>
                <a href="{{ route('menu') }}" class="inline-block bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition">
                    Pesan Sekarang
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $pesanan)
                    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-50 flex flex-wrap justify-between items-center gap-4">
                            <div class="flex items-center gap-4">
                                <div class="p-3 bg-green-50 rounded-2xl text-green-600">
                                    <i class="fas fa-receipt text-xl"></i>
                                </div>
                                <div>
                                    
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $pesanan->created_at->format('d M Y • H:i') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold
                                @if($pesanan->status == 'selesai') bg-green-100 text-green-700 
                                @elseif($pesanan->status == 'menunggu') bg-yellow-100 text-yellow-700
                                @else bg-blue-100 text-blue-700 @endif">
                                <i class="fas 
                                    @if($pesanan->status == 'selesai') fa-check-circle 
                                    @elseif($pesanan->status == 'menunggu') fa-clock
                                    @elseif($pesanan->status == 'dimasak') fa-box
                                    @elseif($pesanan->status == 'menuju alamat') fa-truck
                                    @else fa-box @endif"></i>
                                {{ ucfirst($pesanan->status) }}
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            @foreach($pesanan->keranjangg as $item)
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="text-sm">
                                            <p class="font-bold text-gray-900">{{ $item->menuu->nama_menu }}</p>
                                            <p class="text-gray-500">Qty: {{ $item->kuantitas }}</p>
                                        </div>
                                    </div>
                                    <p class="font-bold text-gray-900">Rp {{ number_format($item->menuu->harga * $item->kuantitas, 0, ',', '.') }}</p>
                                </div>
                            @endforeach
                                <div class="flex justify-between items-center">
                                    <div class="flex items-center gap-4">
                                        <div class="text-sm">
                                            <p class="font-bold text-gray-900">Ongkos Pengiriman</p>
                                        </div>
                                    </div>
                                    <p class="font-bold text-gray-900">Rp 10.000</p>
                                </div>
                        </div>

                        <div class="p-6 bg-gray-50 flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Total Pembayaran</p>
                                <p class="text-2xl font-bold text-green-600">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</p>
                            </div>
                            @if($pesanan->status == 'menuju alamat')
                            <form action="{{ route('admin.orders.update', $pesanan->id_pesanan) }}" method="POST" class="w-full">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="selesai">
                                <button class="bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition shadow-lg shadow-green-100">
                                        Selesaikan Pesanan
                                    </button>
                            </form>
                            @elseif($pesanan->status == 'selesai')
                                <a href="{{ route('menu') }}">
                                    <button class="bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition shadow-lg shadow-green-100">
                                        Pesan Lagi
                                    </button>
                                </a>
                            @endif
                        </div>

                        <div class="px-6 py-4 border-t border-gray-100 text-xs text-gray-500">
                            <p><i class="fas fa-map-marker-alt mr-1"></i> {{ $pesanan->alamat_pengiriman }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection