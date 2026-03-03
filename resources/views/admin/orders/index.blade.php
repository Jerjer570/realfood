@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight italic">Kelola Pesanan</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau dan perbarui status pengiriman pelanggan secara real-time.</p>
        </div>
        
        {{-- Filter Status --}}
        <div class="flex bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
            @php
                $statuses = [
                    'all' => 'Semua',
                    'pending' => 'Menunggu',
                    'dimasak' => 'Dimasak',
                    'dikemas' => 'Dikemas',
                    'diantar' => 'Diantar',
                    'completed' => 'Sampai Tujuan',
                    'cancelled' => 'Batal'
                ];
            @endphp
            @foreach($statuses as $key => $label)
                <a href="?status={{ $key }}" 
                   class="px-5 py-2 rounded-xl text-[10px] font-black transition-all whitespace-nowrap uppercase tracking-widest
                   {{ request('status', 'all') == $key 
                      ? 'bg-green-600 text-white shadow-lg shadow-green-100' 
                      : 'text-gray-400 hover:text-green-600 hover:bg-green-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-[2rem] p-20 text-center border border-gray-100 shadow-sm">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                <i class="fas fa-box-open text-4xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Tidak ada pesanan</h2>
            <p class="text-gray-500 mt-2">Belum ada pesanan dengan status "{{ $statuses[request('status', 'all')] }}" saat ini.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($orders as $pesanan)
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300 group">
                
                {{-- Card Header --}}
                <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">ID Pesanan</p>
                        <h3 class="font-black text-gray-900 text-lg">#{{ $pesanan->id_pesanan }}</h3>
                    </div>
                    {{-- Badge Status --}}
                    <div class="px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-widest
                        @if($pesanan->status == 'pending') bg-gray-100 text-gray-600 
                        @elseif($pesanan->status == 'dimasak') bg-orange-100 text-orange-600
                        @elseif($pesanan->status == 'dikemas') bg-blue-100 text-blue-600
                        @elseif($pesanan->status == 'diantar') bg-purple-100 text-purple-600
                        @elseif($pesanan->status == 'completed') bg-green-100 text-green-600
                        @else bg-red-100 text-red-600 @endif">
                        {{ $statuses[$pesanan->status] ?? $pesanan->status }}
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6 flex-1 space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-100">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <div>
                            <p class="font-black text-gray-900 leading-none">{{ $pesanan->user->nama }}</p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider mt-1.5">{{ $pesanan->created_at->format('d M Y • H:i') }}</p>
                        </div>
                    </div>

                    {{-- Items List --}}
                    <div class="bg-gray-50/50 rounded-2xl p-4 space-y-3">
                        @foreach($pesanan->keranjangg as $item)
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-600 font-medium">
                                    {{ $item->menu->nama_menu }} 
                                    <b class="text-gray-900 ml-1">x{{ $item->kuantitas }}</b>
                                </span>
                                <span class="font-black text-gray-900">Rp {{ number_format($item->harga * $item->kuantitas, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Address --}}
                    <div>
                        <p class="text-[9px] text-gray-400 uppercase font-black tracking-widest mb-2 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-green-600"></i> Alamat Pengiriman
                        </p>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">{{ $pesanan->alamat_pengiriman }}</p>
                    </div>
                </div>

                {{-- Footer & Action --}}
                <div class="p-6 bg-gray-50/30 border-t border-gray-50 mt-auto">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Bayar</span>
                        <span class="text-2xl font-black text-green-600 italic">Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex gap-2">
                        @if($pesanan->status == 'pending')
                            <form action="{{ route('admin.orders.update', $pesanan->id_pesanan) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="dimasak">
                                <button class="w-full bg-orange-500 text-white py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-orange-600 transition-all">Masak</button>
                            </form>
                        @elseif($pesanan->status == 'dimasak')
                            <form action="{{ route('admin.orders.update', $pesanan->id_pesanan) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="dikemas">
                                <button class="w-full bg-blue-500 text-white py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-blue-600 transition-all">Kemas</button>
                            </form>
                        @elseif($pesanan->status == 'dikemas')
                            <form action="{{ route('admin.orders.update', $pesanan->id_pesanan) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="diantar">
                                <button class="w-full bg-purple-500 text-white py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-purple-600 transition-all">Antar</button>
                            </form>
                        @elseif($pesanan->status == 'diantar')
                            <form action="{{ route('admin.orders.update', $pesanan->id_pesanan) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button class="w-full bg-green-600 text-white py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-green-700 transition-all">Selesai</button>
                            </form>
                        @endif

                        @if(in_array($pesanan->status, ['pending', 'dimasak']))
                            <form action="{{ route('admin.orders.update', $pesanan->id_pesanan) }}" method="POST" class="flex-none">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button class="px-4 bg-red-50 text-red-600 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-red-100 transition-all">Batal</button>
                            </form>
                        @endif

                        @if(in_array($pesanan->status, ['completed', 'cancelled']))
                            <div class="w-full text-center py-3 bg-white border border-gray-100 text-gray-400 rounded-xl text-[9px] font-black uppercase tracking-widest italic">
                                Transaksi {{ $pesanan->status == 'completed' ? 'Selesai' : 'Dibatalkan' }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection