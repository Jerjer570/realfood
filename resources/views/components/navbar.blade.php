<nav class="fixed top-0 w-full bg-white/95 backdrop-blur-sm z-50 shadow-sm" x-data="{ isOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ url('/') }}" class="flex-shrink-0">
                <h1 class="text-2xl text-green-600">Real Food</h1>
            </a>
            
            <div class="hidden md:block">
                <div class="ml-10 flex items-center space-x-6">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-green-600 transition-colors">Home</a>
                    <a href="{{ url('/menu') }}" class="text-gray-700 hover:text-green-600 transition-colors">Menu</a>
                    
                    @auth
                        @if(auth()->user()->role === 'user')
                            <a href="{{ url('/orders') }}" class="text-gray-700 hover:text-green-600 transition-colors">Pesanan Saya</a>
                            <a href="{{ url('/cart') }}" class="relative text-gray-700 hover:text-green-600 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                                <span class="absolute -top-2 -right-2 bg-green-600 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                    {{ $cartCount ?? 0 }}
                                </span>
                            </a>
                        @endif

                        <div class="flex items-center gap-4">
                            @if(auth()->user()->role === 'admin')
                                <a href="{{ url('/admin') }}" class="text-gray-700 hover:text-green-600 transition-colors">Dashboard</a>
                            @else
                                <a href="{{ url('/profile') }}" class="text-gray-700 hover:text-green-600 transition-colors flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                    {{ auth()->user()->name }}
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-gray-700 hover:text-green-600 transition-colors">Logout</button>
                            </form>
                        </div>
                    @else
                        <a href="{{ url('/login') }}" class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition-colors">Login</a>
                    @endauth
                </div>
            </div>

            <div class="md:hidden">
                <button @click="isOpen = !isOpen" class="text-gray-700 hover:text-green-600">
                    <template x-if="!isOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
                    </template>
                    <template x-if="isOpen">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" x2="6" y1="6" y2="18"/><line x1="6" x2="18" y1="6" y2="18"/></svg>
                    </template>
                </button>
            </div>
        </div>
    </div>

    <div x-show="isOpen" class="md:hidden bg-white border-t" x-cloak>
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ url('/') }}" class="block px-3 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-md">Home</a>
            </div>
    </div>
</nav>