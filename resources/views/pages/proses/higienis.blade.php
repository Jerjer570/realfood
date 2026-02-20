@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16">
    <div class="max-w-4xl mx-auto px-4">
        <a href="{{ route('about.detail') }}" class="text-green-600 font-bold flex items-center gap-2 mb-8 hover:underline">
            <i class="fas fa-arrow-left"></i> Kembali ke Tentang Kami
        </a>

        <div class="rounded-[3rem] overflow-hidden mb-12 shadow-2xl">
            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=1200" class="w-full h-[400px] object-cover" alt="Dapur Higienis">
        </div>

        <h1 class="text-4xl font-black text-gray-900 mb-6">Proses Higienis & Standar Dapur</h1>
        <div class="prose prose-lg text-gray-600 max-w-none space-y-6">
            <p>
                Kebersihan adalah prioritas utama kami. Dapur <strong>Real Food</strong> dirancang dengan standar internasional untuk mencegah kontaminasi silang dan menjaga kesegaran bahan makanan.
            </p>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="p-6 border border-gray-100 rounded-3xl shadow-sm">
                    <i class="fas fa-hands-wash text-3xl text-green-600 mb-4"></i>
                    <h4 class="font-bold text-gray-900">Sanitasi Ketat</h4>
                    <p class="text-sm">Staf kami melalui prosedur sanitasi menyeluruh sebelum memasuki area pengolahan.</p>
                </div>
                <div class="p-6 border border-gray-100 rounded-3xl shadow-sm">
                    <i class="fas fa-temperature-low text-3xl text-green-600 mb-4"></i>
                    <h4 class="font-bold text-gray-900">Kontrol Suhu</h4>
                    <p class="text-sm">Suhu ruangan dan tempat penyimpanan dipantau setiap jam untuk menjaga kualitas nutrisi.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection