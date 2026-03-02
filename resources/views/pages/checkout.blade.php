@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4">
        <h1 class="text-3xl font-black text-gray-900 mb-8 flex items-center gap-3 italic">
            <i class="fas fa-shopping-cart text-green-600"></i>
            Konfirmasi Pesanan
        </h1>

        {{-- Form Checkout --}}
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Bagian Kiri: Form Input --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Informasi Pengiriman --}}
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
                        <h2 class="text-xl font-black mb-6 flex items-center gap-2 italic">
                            <i class="fas fa-map-marker-alt text-green-600"></i> Informasi Pengiriman
                        </h2>
                        
                        <div class="space-y-5">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Alamat Lengkap</label>
                                <textarea name="address" required rows="3" 
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none transition-all"
                                    placeholder="Jl. Sehat No. 456, Sidoarjo">{{ old('address', Auth::user()->address) }}</textarea>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Nomor Telepon</label>
                                <input type="text" name="phone" required 
                                    value="{{ old('phone', Auth::user()->phone) }}"
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none transition-all"
                                    placeholder="0812xxxx">
                            </div>
                        </div>
                    </div>

                    {{-- Metode Pembayaran --}}
<div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100">
    <h2 class="text-xl font-black mb-6 flex items-center gap-2 italic">
        <i class="fas fa-credit-card text-green-600"></i> Metode Pembayaran
    </h2>
    
    <div class="space-y-6">
        {{-- Grup Transfer Bank --}}
        <div class="space-y-3">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Transfer Bank</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['BCA', 'BNI', 'BRI', 'Mandiri'] as $bank)
                <label class="relative cursor-pointer group">
                    <input type="radio" name="payment_method" value="transfer_{{ strtolower($bank) }}" class="peer sr-only">
                    <div class="px-4 py-3 rounded-2xl bg-gray-50 border-2 border-transparent peer-checked:border-green-600 peer-checked:bg-green-50 font-bold text-center text-sm transition-all hover:bg-gray-100">
                        {{ $bank }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Grup E-Wallet --}}
        <div class="space-y-3">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">E-Wallet</p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @foreach(['Gopay', 'OVO', 'Dana', 'ShopeePay'] as $wallet)
                <label class="relative cursor-pointer group">
                    <input type="radio" name="payment_method" value="{{ strtolower($wallet) }}" class="peer sr-only">
                    <div class="px-4 py-3 rounded-2xl bg-gray-50 border-2 border-transparent peer-checked:border-green-600 peer-checked:bg-green-50 font-bold text-center text-sm transition-all hover:bg-gray-100">
                        {{ $wallet }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Grup COD --}}
        <div class="space-y-3">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Lainnya</p>
            <label class="relative cursor-pointer group block">
                <input type="radio" name="payment_method" value="cod" checked class="peer sr-only">
                <div class="px-6 py-4 rounded-2xl bg-gray-50 border-2 border-transparent peer-checked:border-green-600 peer-checked:bg-green-50 font-bold text-center transition-all hover:bg-gray-100">
                    COD (Bayar di Tempat)
                </div>
            </label>
        </div>
    </div>
</div>

                {{-- Bagian Kanan: Ringkasan --}}
                <div class="lg:col-span-1">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100 sticky top-24">
                        <h2 class="text-xl font-black mb-6 text-gray-900 italic">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4 mb-8">
                            @foreach($cartItems as $item)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 font-bold">{{ $item->food->name }} (x{{ $item->quantity }})</span>
                                <span class="font-black text-gray-900 italic">Rp {{ number_format($item->food->price * $item->quantity, 0, ',', '.') }}</span>
                            </div>
                            @endforeach

                            <div class="border-t border-gray-50 pt-4 flex justify-between text-gray-400 text-xs font-black uppercase tracking-widest">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-gray-400 text-xs font-black uppercase tracking-widest">
                                <span>Ongkos Kirim</span>
                                <span>Rp {{ number_format($shipping, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-gray-50 pt-4 flex justify-between items-center">
                                <span class="text-lg font-black italic">Total</span>
                                <span class="text-2xl font-black text-green-600 italic">
                                    Rp {{ number_format($subtotal + $shipping, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-green-600 text-white py-5 rounded-2xl font-black shadow-lg shadow-green-100 hover:bg-green-700 transition-all flex items-center justify-center gap-2 active:scale-95">
                            <i class="fas fa-check-circle"></i> Buat Pesanan Sekarang
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection