@extends('layouts.admin') {{-- Ganti ke layout admin agar Sidebar muncul --}}

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Kelola Pesanan</h1>
            <p class="text-gray-500 text-sm mt-1">Pantau dan perbarui status pengiriman pelanggan secara real-time.</p>
        </div>
        
        {{-- Filter Status --}}
        <div class="flex bg-white p-1.5 rounded-2xl shadow-sm border border-gray-100 overflow-x-auto">
            @foreach(['all', 'pending', 'processing', 'completed', 'cancelled'] as $status)
                <a href="?status={{ $status }}" 
                   class="px-5 py-2 rounded-xl text-xs font-black transition-all whitespace-nowrap uppercase tracking-widest
                   {{ request('status', 'all') == $status 
                      ? 'bg-green-600 text-white shadow-lg shadow-green-100' 
                      : 'text-gray-400 hover:text-green-600 hover:bg-green-50' }}">
                    {{ $status }}
                </a>
            @endforeach
        </div>
    </div>

    @if($orders->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-[2rem] p-20 text-center border border-gray-100 shadow-sm">
            <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-300">
                <i class="fas fa-box-open text-4xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900">Tidak ada pesanan</h2>
            <p class="text-gray-500 mt-2">Belum ada pesanan dengan status "{{ request('status', 'all') }}" saat ini.</p>
        </div>
    @else
        {{-- Orders Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
            @foreach($orders as $order)
            <div class="bg-white rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden flex flex-col hover:shadow-xl hover:shadow-gray-200/50 transition-all duration-300 group">
                
                {{-- Card Header --}}
                <div class="p-6 border-b border-gray-50 bg-gray-50/30 flex justify-between items-start">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">ID Pesanan</p>
                        <h3 class="font-black text-gray-900 text-lg">#{{ $order->id }}</h3>
                    </div>
                    <div class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                        @if($order->status == 'pending') bg-yellow-100 text-yellow-700 
                        @elseif($order->status == 'processing') bg-blue-100 text-blue-700
                        @elseif($order->status == 'completed') bg-green-100 text-green-700
                        @else bg-red-100 text-red-700 @endif">
                        {{ $order->status }}
                    </div>
                </div>

                {{-- Order Content --}}
                <div class="p-6 flex-1 space-y-6">
                    {{-- User Info --}}
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-600 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-100">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="font-black text-gray-900">{{ $order->user->name }}</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">{{ $order->created_at->format('d M Y • H:i') }}</p>
                        </div>
                    </div>

                    {{-- Items List --}}
                    <div class="bg-gray-50/50 rounded-2xl p-4 space-y-3">
                        @foreach($order->items as $item)
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-gray-600 font-medium">{{ $item->name }} <b class="text-gray-900 ml-1">x{{ $item->quantity }}</b></span>
                                <span class="font-black text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Address --}}
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-2 flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-green-600"></i> Alamat Pengiriman
                        </p>
                        <p class="text-xs text-gray-600 leading-relaxed font-medium">{{ $order->deliveryAddress }}</p>
                    </div>
                </div>

                {{-- Card Footer --}}
                <div class="p-6 bg-gray-50/30 border-t border-gray-50 mt-auto">
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-xs text-gray-400 font-black uppercase tracking-widest">Total Bayar</span>
                        <span class="text-2xl font-black text-green-600 italic">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-3">
                        @if($order->status == 'pending')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="processing">
                                <button class="w-full bg-blue-600 text-white py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-blue-700 hover:shadow-lg hover:shadow-blue-100 transition-all">
                                    Proses
                                </button>
                            </form>
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex-1">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="cancelled">
                                <button class="w-full bg-red-50 text-red-600 py-3.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-100 transition-all">
                                    Batal
                                </button>
                            </form>
                        @elseif($order->status == 'processing')
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="w-full">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="completed">
                                <button class="w-full bg-green-600 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-green-700 hover:shadow-lg hover:shadow-green-100 transition-all">
                                    Selesaikan Pesanan
                                </button>
                            </form>
                        @else
                            <div class="w-full text-center py-4 bg-white border border-gray-100 text-gray-400 rounded-2xl text-[10px] font-black uppercase tracking-widest italic">
                                Selesai / Dibatalkan
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