@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-white">
    <div class="relative py-20 bg-green-50 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-black text-gray-900 mb-6">
                    Lebih Dari Sekadar <span class="text-green-600">Makanan</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Kami percaya bahwa apa yang Anda makan menentukan kualitas hidup Anda. Real Food hadir sebagai partner investasi kesehatan jangka panjang Anda.
                </p>
            </div>
        </div>
        <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-green-200/30 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-green-200/30 rounded-full blur-3xl"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 mt-20">
        <div class="grid lg:grid-cols-2 gap-16 items-center mb-32">
            <div class="order-2 lg:order-1">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Misi Nutrisi Kami</h2>
                <div class="space-y-6 text-gray-600 text-lg">
                    <p>
                        Banyak orang menganggap makanan sehat itu membosankan dan hambar. Di <strong>Real Food</strong>, kami mematahkan mitos tersebut. Kami menggabungkan teknik kuliner modern dengan bahan-bahan organik untuk menciptakan harmoni rasa.
                    </p>
                    <div class="grid grid-cols-2 gap-6 pt-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border-l-4 border-green-600">
                            <h4 class="font-bold text-gray-900">100% Alami</h4>
                            <p class="text-sm">Tanpa pengawet & MSG</p>
                        </div>
                        <div class="p-4 bg-gray-50 rounded-2xl border-l-4 border-green-600">
                            <h4 class="font-bold text-gray-900">Lokal</h4>
                            <p class="text-sm">Bahan dari petani lokal</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-1 lg:order-2 rounded-[2rem] overflow-hidden shadow-2xl transform rotate-2">
                <img src="https://images.unsplash.com/photo-1490645935967-10de6ba17061?q=80&w=1000" alt="Healthy Lifestyle" class="w-full h-full object-cover">
            </div>
        </div>

        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold mb-4">Bagaimana Kami Menjamin Kualitas?</h2>
            <p class="text-gray-500">Klik setiap kartu untuk melihat detail standar tinggi kami.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8 mb-24">
            <a href="{{ route('proses.benih') }}" class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all group block text-left">
                <div class="w-14 h-14 bg-green-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-200 group-hover:scale-110 transition">
                    <i class="fas fa-seedling text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Pemilihan Benih</h3>
                <p class="text-gray-500 italic text-sm mb-4">Kami memastikan sayuran berasal dari benih non-GMO untuk nutrisi maksimal.</p>
                <span class="text-green-600 font-bold text-sm group-hover:underline">Selengkapnya &rarr;</span>
            </a>

            <a href="{{ route('proses.higienis') }}" class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all group block text-left">
                <div class="w-14 h-14 bg-green-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-200 group-hover:scale-110 transition">
                    <i class="fas fa-hand-holding-heart text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Proses Higienis</h3>
                <p class="text-gray-500 italic text-sm mb-4">Dapur kami menggunakan standar kebersihan internasional (HACCP).</p>
                <span class="text-green-600 font-bold text-sm group-hover:underline">Selengkapnya &rarr;</span>
            </a>

            <a href="{{ route('proses.pengiriman') }}" class="p-8 bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all group block text-left">
                <div class="w-14 h-14 bg-green-600 text-white rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-green-200 group-hover:scale-110 transition">
                    <i class="fas fa-truck-loading text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-900">Pengiriman Segar</h3>
                <p class="text-gray-500 italic text-sm mb-4">Dikirim dengan kemasan eco-friendly yang menjaga suhu makanan tetap terjaga.</p>
                <span class="text-green-600 font-bold text-sm group-hover:underline">Selengkapnya &rarr;</span>
            </a>
        </div>

        <div class="mt-20 border-t border-gray-100 pt-20 mb-32">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Bahan & Minuman Unggulan</h2>
            <div class="grid md:grid-cols-2 gap-8 text-left">
                
                <a href="{{ route('proses.bahan') }}" class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row gap-6 hover:shadow-xl hover:-translate-y-1 transition-all group">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                        <i class="fas fa-fish"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xl mb-2 text-gray-900">Protein Laut Pilihan</h4>
                        <p class="text-gray-600 text-sm leading-relaxed mb-3">
                            Salmon dan ikan kami didatangkan dalam kondisi segar setiap hari. Kaya akan Omega-3 untuk mendukung kesehatan jantung.
                        </p>
                        <span class="text-blue-600 font-bold text-xs uppercase tracking-wider">Lihat Detail Bahan &rarr;</span>
                    </div>
                </a>

                <a href="{{ route('proses.bahan') }}" class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm flex flex-col sm:flex-row gap-6 hover:shadow-xl hover:-translate-y-1 transition-all group">
                    <div class="w-16 h-16 bg-orange-100 text-orange-600 rounded-2xl flex-shrink-0 flex items-center justify-center text-2xl group-hover:scale-110 transition">
                        <i class="fas fa-glass-whiskey"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-xl mb-2 text-gray-900">Minuman Tanpa Gula Tambahan</h4>
                        <p class="text-gray-600 text-sm leading-relaxed mb-3">
                            Jus dan smoothie kami murni dari buah segar tanpa tambahan pemanis buatan. Menghidrasi tubuh secara alami.
                        </p>
                        <span class="text-orange-600 font-bold text-xs uppercase tracking-wider">Lihat Detail Minuman &rarr;</span>
                    </div>
                </a>

            </div>
        </div>

        <div class="text-center py-10 bg-gray-900 rounded-[3rem] mb-20 px-6 shadow-2xl shadow-gray-200">
            <h2 class="text-3xl font-bold text-white mb-6">Siap Memulai Hidup Sehat?</h2>
            <a href="{{ route('menu') }}" class="inline-block bg-green-600 text-white px-12 py-5 rounded-full font-bold text-lg hover:bg-green-700 transition transform hover:-translate-y-1 shadow-lg shadow-green-900/20">
                Lihat Menu Sekarang
            </a>
        </div>
    </div>
</div>
@endsection