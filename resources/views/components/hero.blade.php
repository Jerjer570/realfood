<section id="home" class="pt-16 min-h-screen flex items-center bg-gradient-to-br from-green-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-24">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h2 class="text-5xl lg:text-6xl text-gray-900">
                    Makanan Sehat, <span class="text-green-600">Hidup Berkualitas</span>
                </h2>
                <p class="text-xl text-gray-600">
                    Nikmati hidangan segar dan bergizi yang disiapkan dengan bahan-bahan organik pilihan untuk gaya hidup sehat Anda.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ url('/menu') }}" class="bg-green-600 text-white px-8 py-4 rounded-full hover:bg-green-700 transition-colors flex items-center justify-center gap-2 text-lg">
                        Pesan Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            
            <div class="relative">
                <div class="aspect-square rounded-3xl overflow-hidden shadow-2xl">
                    {{-- Gunakan asset() jika gambar sudah kamu download ke public/images --}}
                    <img 
                        src="{{ asset('images/poto1.jpeg') }}" 
                        alt="Fresh healthy food bowl" 
                        class="w-full h-full object-cover"
                    >
                </div>
                
                <div class="absolute -bottom-6 -left-6 bg-white p-6 rounded-2xl shadow-xl">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-3 rounded-full">
                            <span class="text-2xl">🥗</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Menu Tersedia</p>
                            <p class="text-2xl text-gray-900 font-bold">50+</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>