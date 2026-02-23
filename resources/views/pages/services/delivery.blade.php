@extends('layouts.app')

@section('content')
<div class="pt-32 pb-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="flex-1 space-y-6">
                <span class="bg-green-100 text-green-600 px-4 py-2 rounded-full text-xs font-black uppercase tracking-widest">Layanan Kami</span>
                <h1 class="text-5xl font-black text-gray-900 leading-tight italic">Pengiriman Cepat & <span class="text-green-600">Selalu Segar.</span></h1>
                <p class="text-gray-500 text-lg leading-relaxed">Kami memastikan setiap pesanan Real Food sampai di tangan Anda dalam kondisi suhu yang terjaga dan kualitas rasa yang tetap sempurna.</p>
                <div class="pt-4">
                    <a href="{{ route('menu') }}" class="bg-green-600 text-white px-10 py-4 rounded-2xl font-black shadow-lg shadow-green-100 hover:bg-green-700 transition-all inline-block">Pesan Sekarang</a>
                </div>
            </div>
            <div class="flex-1">
                <div class="bg-gray-100 rounded-[3rem] aspect-square overflow-hidden shadow-2xl">
                    {{-- Ganti dengan image delivery yang kamu punya --}}
                    <img src="https://images.unsplash.com/photo-1586769852836-bc069f19e1b6?auto=format&fit=crop&q=80" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection