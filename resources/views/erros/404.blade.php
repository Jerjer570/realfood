@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-white flex items-center justify-center px-4">
    <div class="text-center">
        <h1 class="text-9xl font-extrabold text-green-600 mb-4 animate-bounce">
            404
        </h1>
        
        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
            Halaman Tidak Ditemukan
        </h2>
        
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Maaf, halaman yang Anda cari tidak tersedia atau telah dipindahkan. Yuk, balik lagi cari makanan sehat!
        </p>

        <a href="{{ url('/') }}" 
           class="inline-flex items-center gap-2 bg-green-600 text-white px-8 py-3 rounded-full font-bold hover:bg-green-700 transition-all shadow-lg shadow-green-200 hover:shadow-green-300 transform hover:-translate-y-1">
            <i class="fas fa-home"></i>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection