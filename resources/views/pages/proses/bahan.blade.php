@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16">
    <div class="max-w-5xl mx-auto px-4">
        <a href="{{ route('about.detail') }}" class="text-green-600 font-bold flex items-center gap-2 mb-8 hover:underline">
            <i class="fas fa-arrow-left"></i> Kembali ke Tentang Kami
        </a>

        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-4">Kualitas Bahan Baku</h1>
            <p class="text-gray-500 max-w-2xl mx-auto text-lg">Setiap elemen dalam piring Anda telah melalui seleksi ketat untuk memastikan standar Real Food terpenuhi.</p>
        </div>

        <div class="space-y-16">
            
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="rounded-[2.5rem] overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?q=80&w=1000" class="w-full h-[350px] object-cover" alt="Fresh Salmon">
                </div>
                <div>
                    <div class="inline-block px-4 py-1 bg-blue-100 text-blue-600 rounded-full text-xs font-bold uppercase mb-4">Protein Utama</div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Salmon & Ikan Segar</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Kami tidak menggunakan produk beku (frozen) yang sudah berbulan-bulan. Salmon kami adalah <strong>Premium Grade</strong> yang didatangkan segar. Kami memilih ikan yang ditangkap secara berkelanjutan (sustainable) untuk menjaga kelestarian laut.
                    </p>
                    <ul class="space-y-3 text-sm text-gray-500 font-medium">
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Sumber Omega-3 Tinggi</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Bebas Pewarna Buatan</li>
                        <li class="flex items-center gap-2"><i class="fas fa-check text-green-500"></i> Tekstur Lembut & Rasa Gurih Alami</li>
                    </ul>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center lg:flex-row-reverse">
                <div class="lg:order-2 rounded-[2.5rem] overflow-hidden shadow-xl">
                    <img src="https://images.unsplash.com/photo-1610970881699-44a5587cabec?q=80&w=1000" class="w-full h-[350px] object-cover" alt="Healthy Drinks">
                </div>
                <div class="lg:order-1 text-right lg:text-left">
                    <div class="inline-block px-4 py-1 bg-orange-100 text-orange-600 rounded-full text-xs font-bold uppercase mb-4 text-left">Minuman Sehat</div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Murni Tanpa Gula Tambahan</h2>
                    <p class="text-gray-600 leading-relaxed mb-6">
                        Minuman kami adalah perasan murni dari buah dan sayuran. Kami percaya bahwa rasa manis alami jauh lebih baik bagi tubuh daripada gula rafinasi atau pemanis buatan yang dapat memicu lonjakan insulin.
                    </p>
                    <div class="bg-orange-50 p-6 rounded-3xl border border-orange-100 text-left">
                        <h4 class="font-bold text-orange-800 mb-2">Proses Cold-Pressed:</h4>
                        <p class="text-sm text-orange-700 opacity-80">Kami menggunakan teknologi Cold-Pressed agar panas tidak merusak nutrisi dan vitamin dalam buah saat proses ekstraksi.</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-24 bg-green-600 rounded-[3rem] p-12 text-center text-white shadow-2xl shadow-green-200">
            <h3 class="text-2xl font-bold mb-4 italic">"Kesehatan Anda adalah Prioritas Kami"</h3>
            <p class="opacity-80 max-w-xl mx-auto mb-8">Setiap menu di Real Food dirancang oleh ahli gizi untuk memberikan profil nutrisi yang seimbang.</p>
            <div class="flex justify-center gap-8">
                <div class="text-center">
                    <div class="text-3xl font-black">0%</div>
                    <div class="text-xs uppercase opacity-70">Gula Tambahan</div>
                </div>
                <div class="h-10 w-px bg-white/20"></div>
                <div class="text-center">
                    <div class="text-3xl font-black">100%</div>
                    <div class="text-xs uppercase opacity-70">Bahan Alami</div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection