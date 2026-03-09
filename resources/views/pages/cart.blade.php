@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 mb-8 flex items-center gap-3">
            <i class="fas fa-shopping-cart text-green-600"></i>
            Keranjang Belanja
        </h1>

        @if($cartItems->isEmpty())
            {{-- Tampilan jika keranjang kosong --}}
            <div class="text-center py-20 bg-white rounded-3xl shadow-sm border border-gray-100">
                <div class="bg-green-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-basket text-3xl text-green-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Keranjangmu masih kosong</h2>
                <p class="text-gray-500 mb-8">Yuk, cari makanan sehat untuk harimu!</p>
                <a href="{{ route('menu') }}" class="inline-block bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition">
                    Lihat Menu
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Daftar Item di Keranjang --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cartItems as $item)
                        <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
                            {{-- Gambar: Menggunakan relasi 'menu' --}}
                            <img src="{{ asset('images/' . ($item->menu?->image ?? 'default.jpg')) }}" 
                                 alt="{{ $item->menu?->nama_menu ?? 'Menu' }}" 
                                 class="w-24 h-24 object-cover rounded-xl">
                            
                            <div class="flex-1">
                                <h3 class="font-bold text-gray-900">{{ $item->menu?->nama_menu ?? 'Produk Tidak Tersedia' }}</h3>
                                <p class="text-green-600 font-bold">Rp {{ number_format($item->menu?->harga ?? 0, 0, ',', '.') }}</p>
                            </div>

                            {{-- Kontrol Kuantitas --}}
                            <div class="flex items-center gap-3 bg-gray-50 px-3 py-1 rounded-full">
                                <form action="{{ route('cart.update', $item->id_keranjang) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="change" value="-1">
                                    <button type="submit" class="text-gray-500 hover:text-green-600">
                                        <i class="fas fa-minus-circle"></i>
                                    </button>
                                </form>
                                
                                <span class="font-bold w-4 text-center">{{ $item->kuantitas }}</span>
                                
                                <form action="{{ route('cart.update', $item->id_keranjang) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="change" value="1">
                                    <button type="submit" class="text-gray-500 hover:text-green-600">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </form>
                            </div>

                            {{-- Hapus Item --}}
                            <form action="{{ route('cart.destroy', $item->id_keranjang) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-600 p-2" onclick="return confirm('Hapus item ini?')">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>

                {{-- Ringkasan Pesanan --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 sticky top-24">
                        <h2 class="text-xl font-bold mb-6 text-gray-900">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Ongkos Kirim</span>
                                {{-- Gunakan variabel $shipping jika dikirim dari controller, atau angka langsung --}}
                                <span>Rp {{ number_format($shipping ?? 10000, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t pt-4 flex justify-between items-center">
                                <span class="text-lg font-bold">Total</span>
                                <span class="text-2xl font-bold text-green-600">
                                    Rp {{ number_format($subtotal + ($shipping ?? 10000), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('checkout') }}" class="block w-full bg-green-600 text-white text-center py-4 rounded-2xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-100">
                            Lanjut ke Checkout
                        </a>
                        
                        <a href="{{ route('menu') }}" class="block w-full text-center text-gray-500 mt-4 hover:text-green-600 transition">
                            <i class="fas fa-arrow-left mr-2"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection