@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4">
        <a href="{{ route('about.detail') }}" class="text-green-600 font-bold flex items-center gap-2 mb-8 hover:underline">
            <i class="fas fa-arrow-left"></i> Kembali ke Tentang Kami
        </a>

        <div class="rounded-[3rem] overflow-hidden mb-12 shadow-2xl">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=1200" class="w-full h-[400px] object-cover" alt="Pengiriman Segar">
        </div>

        <h1 class="text-4xl font-black text-gray-900 mb-6">Sistem Pengiriman Segar</h1>
        <div class="prose prose-lg text-gray-600 max-w-none space-y-6">
            <p>
                Kami memahami bahwa perjalanan makanan dari dapur ke meja Anda sangatlah krusial. Real Food menggunakan teknologi pengemasan ramah lingkungan yang mampu menjaga suhu optimal.
            </p>
            <div class="bg-gray-900 text-white p-10 rounded-[3rem] shadow-xl">
                <h3 class="text-2xl font-bold mb-6 italic text-green-400">Komitmen Eco-Friendly</h3>
                <p class="mb-6 opacity-80">
                    Kami tidak lagi menggunakan plastik sekali pakai. Kemasan kami terbuat dari bahan nabati yang mudah terurai namun tetap kokoh menjaga integritas makanan Anda.
                </p>
                <div class="flex flex-wrap gap-4">
                    <span class="bg-white/10 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest">Bisa Didaur Ulang</span>
                    <span class="bg-white/10 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest">Tahan Bocor</span>
                    <span class="bg-white/10 px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest">Menjaga Suhu</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection