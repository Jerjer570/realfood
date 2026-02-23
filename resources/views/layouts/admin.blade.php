<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ $title ?? 'Admin Panel - Real Food' }}</title>
    
    {{-- Fonts & Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    {{-- Asset Management --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Alpine.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50" x-data="{ isSidebarOpen: false }">

    {{-- Sidebar --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 text-white transform transition-transform duration-300 lg:translate-x-0 shadow-2xl lg:shadow-none"
           :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           @click.away="isSidebarOpen = false">
        
        <div class="flex flex-col h-full">
            <div class="p-8">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-black text-green-500 italic tracking-tighter">
                    REAL<span class="text-white">FOOD.</span>
                </a>
                <p class="text-[10px] text-gray-500 font-black uppercase tracking-[0.2em] mt-2">Admin Control</p>
            </div>

            <nav class="flex-1 px-4 space-y-1.5 mt-4 overflow-y-auto">
                @php
                    $menuItems = [
                        ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'fa-th-large'],
                        ['route' => 'admin.menu.index', 'label' => 'Daftar Menu', 'icon' => 'fa-utensils'],
                        ['route' => 'admin.orders.index', 'label' => 'Pesanan', 'icon' => 'fa-shopping-bag'],
                        ['route' => 'admin.users.index', 'label' => 'Pengguna', 'icon' => 'fa-users'],
                        ['route' => 'admin.analytics', 'label' => 'Analitik', 'icon' => 'fa-chart-line'],
                        // MENU BARU DISINI
                        ['route' => 'admin.financial.report', 'label' => 'Laporan Keuangan', 'icon' => 'fa-file-invoice-dollar'],
                    ];
                @endphp

                @foreach($menuItems as $item)
                <a href="{{ route($item['route']) }}" 
                   class="flex items-center gap-3 px-5 py-3.5 rounded-2xl transition-all duration-200 font-bold text-sm {{ request()->routeIs($item['route'] . '*') ? 'bg-green-600 text-white shadow-lg shadow-green-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fas {{ $item['icon'] }} w-5 text-center"></i>
                    <span>{{ $item['label'] }}</span>
                </a>
                @endforeach
            </nav>

            {{-- Logout Section --}}
            <div class="p-6 border-t border-gray-800 bg-gray-950/30">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-3 px-5 py-3.5 w-full text-left text-gray-400 hover:text-red-400 transition-colors font-bold text-sm rounded-2xl hover:bg-red-400/10">
                        <i class="fas fa-sign-out-alt w-5 transition-transform group-hover:-translate-x-1"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="lg:ml-64 min-h-screen flex flex-col">
        
        {{-- Header --}}
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 h-20 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-40">
            <button @click="isSidebarOpen = true" class="lg:hidden p-2 text-gray-500 hover:bg-gray-100 rounded-xl transition">
                <i class="fas fa-bars text-xl"></i>
            </button>

            <div class="flex items-center gap-5 ml-auto">
                @auth
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-black text-gray-900 leading-none mb-1">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-green-600 font-black uppercase tracking-widest">{{ Auth::user()->role ?? 'Administrator' }}</p>
                </div>
                <div class="relative group">
                    <div class="w-11 h-11 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 font-black border-2 border-white shadow-sm overflow-hidden group-hover:scale-105 transition-transform">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                @endauth
            </div>
        </header>

        {{-- Main Content --}}
        <main class="p-6 lg:p-10 flex-1">
            @yield('content')
        </main>
        
        {{-- Footer --}}
        <footer class="px-10 py-6 border-t border-gray-100 text-center lg:text-left">
            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">
                &copy; {{ date('Y') }} Real Food Control Panel • Built with Laravel
            </p>
        </footer>
    </div>

    {{-- Mobile Overlay --}}
    <div x-show="isSidebarOpen" 
         x-cloak
         @click="isSidebarOpen = false"
         class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
         x-transition:enter="transition opacity-0 duration-300"
         x-transition:leave="transition opacity-100 duration-300">
    </div>

</body>
</html>
