<section id="about" class="py-20 bg-green-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-2xl">
                    <img 
                        src="https://images.unsplash.com/photo-1657288089316-c0350003ca49?q=80&w=1080" 
                        alt="Tentang Real Food" 
                        class="w-full h-full object-cover"
                    >
                </div>
                <div class="absolute -top-4 -left-4 w-24 h-24 bg-green-200/50 rounded-full blur-2xl"></div>
            </div>

            <div class="space-y-8">
                <div class="space-y-4">
                    <h2 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                        Tentang <span class="text-green-600 italic">Real Food</span>
                    </h2>
                    <p class="text-lg text-gray-600">
                        Real Food didirikan dengan misi untuk menyediakan makanan sehat dan lezat yang mudah diakses oleh semua orang. Kami percaya bahwa makanan yang baik adalah investasi terbaik untuk kesehatan Anda.
                    </p>
                </div>

                <div class="space-y-6">
                    {{-- Feature 1 --}}
                    <div class="flex gap-4 group">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white shadow-lg group-hover:rotate-12 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C10 14.5 12 15 15 15"/></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Bahan Organik</h3>
                            <p class="text-gray-600">Kami hanya menggunakan bahan organik berkualitas tinggi dari petani lokal terpercaya.</p>
                        </div>
                    </div>

                    {{-- Feature 2 --}}
                    <div class="flex gap-4 group">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white shadow-lg group-hover:rotate-12 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Penuh Nutrisi</h3>
                            <p class="text-gray-600">Setiap hidangan dirancang oleh ahli gizi untuk memenuhi kebutuhan nutrisi harian Anda.</p>
                        </div>
                    </div>

                    {{-- Feature 3 --}}
                    <div class="flex gap-4 group">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white shadow-lg group-hover:rotate-12 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1">Selalu Segar</h3>
                            <p class="text-gray-600">Makanan disiapkan fresh setiap hari dengan standar kebersihan tertinggi.</p>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about.detail') }}" class="inline-block bg-green-600 text-white px-10 py-4 rounded-full hover:bg-green-700 transition-all shadow-xl shadow-green-200 font-bold text-lg active:scale-95">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </div>
</section>