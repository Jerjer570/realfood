@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4">
        <a href="{{ route('about.detail') }}" class="text-green-600 font-bold flex items-center gap-2 mb-8 hover:underline">
            <i class="fas fa-arrow-left"></i> Kembali ke Tentang Kami
        </a>

        <div class="rounded-[3rem] overflow-hidden mb-12 shadow-2xl">
            <img src="https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?q=80&w=1200" class="w-full h-[400px] object-cover" alt="Benih Organik">
        </div>

        <h1 class="text-4xl font-black text-gray-900 mb-6">Standar Pemilihan Benih</h1>
        <div class="prose prose-lg text-gray-600 max-w-none space-y-6">
            <p>
                Kualitas makanan yang luar biasa dimulai dari benih yang berkualitas tinggi. Di <strong>Real Food</strong>, kami bekerja sama dengan petani lokal untuk memastikan setiap benih yang ditanam adalah varietas <strong>Non-GMO</strong>.
            </p>
            <div class="bg-green-50 p-8 rounded-3xl border border-green-100">
                <h3 class="text-xl font-bold text-green-800 mb-4">Kenapa Non-GMO?</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span>Lebih kaya akan nutrisi dan antioksidan alami.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span>Mendukung keberlangsungan ekosistem lingkungan.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-check-circle text-green-600 mt-1"></i>
                        <span>Aman dari modifikasi genetik yang tidak alami.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection