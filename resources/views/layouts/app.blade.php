<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Real Food - Healthy Catering' }}</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-white min-h-screen flex flex-col">

    <nav class="fixed top-0 left-0 right-0 bg-white/80 backdrop-blur-xl z-50 border-b border-gray-100" x-data="{ openProfile: false }">
        <div class="max-w-7xl mx-auto px-4 h-20 flex items-center justify-between">
            <a href="{{ url('/') }}" class="text-2xl font-black text-green-600 italic tracking-tighter">
                REAL<span class="text-gray-900">FOOD.</span>
            </a>

            <div class="hidden md:flex items-center gap-10 font-bold text-sm text-gray-500">
                <a href="{{ url('/') }}" class="hover:text-green-600 transition {{ Request::is('/') ? 'text-green-600' : '' }}">Beranda</a>
                
                <a href="{{ route('menu') }}" class="hover:text-green-600 transition {{ Request::is('menu*') ? 'text-green-600' : '' }}">Menu</a>
                
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-purple-50 text-purple-600 px-4 py-2 rounded-xl font-black hover:bg-purple-100 transition">Admin Panel</a>
                    @else
                        <a href="{{ route('orders') }}" class="hover:text-green-600 transition {{ Request::is('orders*') ? 'text-green-600' : '' }}">Pesanan Saya</a>
                    @endif
                @endauth
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('cart.index') }}" class="w-11 h-11 flex items-center justify-center bg-gray-50 rounded-2xl text-gray-600 hover:bg-green-50 hover:text-green-600 transition relative">
                        <i class="fas fa-shopping-basket text-sm"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-white">
                            0
                        </span>
                    </a>

                    <div class="relative">
                        <button @click="openProfile = !openProfile" class="flex items-center gap-3 bg-white p-1.5 pr-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                            <div class="w-8 h-8 bg-green-600 rounded-xl flex items-center justify-center text-white text-[10px] font-black uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-xs font-black text-gray-700 hidden sm:block">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-[10px] text-gray-400"></i>
                        </button>
                        
                        <div x-show="openProfile" @click.away="openProfile = false" 
                             class="absolute right-0 mt-3 w-56 bg-white rounded-[2rem] shadow-2xl border border-gray-100 p-3 z-[60]"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             style="display: none;">
                            
                            <div class="px-4 py-4 border-b border-gray-50 mb-2 text-center sm:text-left">
                                <p class="text-xs font-black text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">{{ Auth::user()->role }}</p>
                            </div>

                            <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-green-50 rounded-2xl transition font-bold text-gray-600 hover:text-green-600">
                                <i class="fas fa-user-circle opacity-50"></i> Profil Saya
                            </a>
                            
                            <div class="h-px bg-gray-50 my-1"></div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-2xl transition font-bold">
                                    <i class="fas fa-sign-out-alt opacity-50"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-4">
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-500 hover:text-green-600 transition">Masuk</a>
                        
                        <a href="{{ route('register') }}" class="bg-green-600 text-white px-8 py-3 rounded-2xl text-sm font-black hover:bg-green-700 transition shadow-xl shadow-green-100">
                            Daftar
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 mt-20">
        @yield('content')
    </main>

    <footer class="bg-gray-50 border-t border-gray-100 py-16 mt-auto">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 items-center text-center md:text-left">
                <div>
                    <p class="text-2xl font-black text-green-600 italic tracking-tighter">REALFOOD.</p>
                    <p class="text-sm text-gray-500 mt-4 leading-relaxed max-w-xs mx-auto md:mx-0">
                        Katering sehat premium yang dirancang khusus untuk mendukung produktivitas dan gaya hidup aktifmu.
                    </p>
                </div>
                <div class="flex justify-center gap-12 text-sm font-black text-gray-400 uppercase tracking-widest">
                    <a href="#" class="hover:text-green-600 transition">Tentang</a>
                    <a href="#" class="hover:text-green-600 transition">FAQ</a>
                    <a href="#" class="hover:text-green-600 transition">Kontak</a>
                </div>
                <div class="flex justify-center md:justify-end gap-4">
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-200 text-gray-400 hover:text-green-600 transition"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-gray-200 text-gray-400 hover:text-green-600 transition"><i class="fab fa-whatsapp"></i></a>
                </div>
            </div>
            <div class="mt-16 pt-8 border-t border-gray-200 text-center">
                <p class="text-[10px] text-gray-400 uppercase font-bold tracking-[0.2em]">&copy; {{ date('Y') }} Real Food Indonesia. Dibuat dengan <i class="fas fa-heart text-red-400 mx-1"></i> untuk kesehatanmu.</p>
            </div>
        </div>
    </footer>

    @if(session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" 
         class="fixed bottom-8 right-8 bg-gray-900 text-white px-6 py-4 rounded-[2rem] shadow-2xl z-[100] flex items-center gap-4 border border-white/10"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-10 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 translate-x-10"
         style="display: none;">
        <div class="bg-green-500 w-8 h-8 rounded-full flex items-center justify-center">
            <i class="fas fa-check text-xs"></i>
        </div>
        <span class="text-sm font-bold tracking-tight">{{ session('success') }}</span>
    </div>
    @endif

</body>
</html>