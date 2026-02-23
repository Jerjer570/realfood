<footer class="bg-gray-900 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8 mb-8">
            {{-- Brand Section --}}
            <div class="space-y-4">
                <h3 class="text-2xl text-green-400 font-black italic">Real Food</h3>
                <p class="text-gray-400">
                    Makanan sehat untuk hidup yang lebih berkualitas.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-green-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                    </a>
                    <a href="#" class="hover:text-green-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" class="hover:text-green-400 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.2-18 11.6 7.2 1.5 11-4.8 8.1-11.4z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Menu Utama --}}
            <div>
                <h4 class="text-lg mb-4 font-bold">Menu</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('home') }}" class="hover:text-green-400 transition-colors">Beranda</a></li>
                    <li><a href="{{ route('menu') }}" class="hover:text-green-400 transition-colors">Menu</a></li>
                    <li><a href="{{ url('/#about') }}" class="hover:text-green-400 transition-colors">Tentang Kami</a></li>
                    <li><a href="#" class="hover:text-green-400 transition-colors">Kontak</a></li>
                </ul>
            </div>

            {{-- Link Layanan (Sesuai web.php Anda) --}}
            <div>
                <h4 class="text-lg mb-4 font-bold">Layanan</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('services.delivery') }}" class="hover:text-green-400 transition-colors">Delivery</a></li>
                    <li><a href="{{ route('services.catering') }}" class="hover:text-green-400 transition-colors">Catering</a></li>
                    <li><a href="{{ route('services.meal-plan') }}" class="hover:text-green-400 transition-colors">Meal Plan</a></li>
                    <li><a href="{{ route('services.gift-card') }}" class="hover:text-green-400 transition-colors">Gift Card</a></li>
                </ul>
            </div>

            {{-- Informasi Kontak --}}
            <div class="space-y-4">
                <h4 class="text-lg mb-4 font-bold">Kontak Kami</h4>
                <div class="space-y-3 text-gray-400 text-sm">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 text-green-400"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                        <span>Jl. Sehat No. 123, Jakarta</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 text-green-400"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        <span>+62 812-3456-7890</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="flex-shrink-0 text-green-400"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        <span>hello@realfood.id</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-800 pt-8 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Real Food Indonesia. All rights reserved.</p>
        </div>
    </div>
</footer>