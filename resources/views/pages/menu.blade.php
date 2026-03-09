@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen" 
     x-data="{ 
        searchQuery: '', 
        selectedCategory: 'All',
        maxCalories: 1000,
        minRating: 0,
        sortBy: 'default'
     }">
    <div class="max-w-7xl mx-auto px-4">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Menu Sehat</h1>
            
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="relative">
                    <input type="text" x-model="searchQuery" placeholder="Cari menu..." 
                           class="pl-10 pr-4 py-2 rounded-full border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none w-full sm:w-64">
                    <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex flex-wrap gap-6 items-center">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Kategori</label>
                <select x-model="selectedCategory" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-green-600 cursor-pointer">
                    <option value="All">Semua Kategori</option>
                    @isset($categories)
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">{{ $cat }}</option>
                        @endforeach
                    @endisset
                </select>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Maks. Kalori: <span x-text="maxCalories" class="text-green-600"></span></label>
                <input type="range" x-model="maxCalories" min="100" max="1000" step="50" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-green-600">
            </div>

            <div class="flex-1 min-w-[150px]">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Rating Minimal</label>
                <div class="flex gap-2">
                    <template x-for="i in 5">
                        <button @click="minRating = i" :class="minRating >= i ? 'text-yellow-400' : 'text-gray-300'">
                            <i class="fas fa-star"></i>
                        </button>
                    </template>
                </div>
            </div>

            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Urutkan</label>
                <select x-model="sortBy" class="w-full bg-gray-50 border-none rounded-xl focus:ring-2 focus:ring-green-600 cursor-pointer">
                    <option value="default">Terbaru</option>
                    <option value="populer">Banyak Dipesan 🔥</option>
                    <option value="murah">Harga Terendah</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 flex flex-wrap">
            @foreach($menuItems as $item)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:-translate-y-2 transition-all duration-300 group"
                 x-show="(selectedCategory === 'All' || '{{ $item->kategori }}' === selectedCategory) && 
                         (searchQuery === '' || '{{ strtolower($item->nama_menu) }}'.includes(searchQuery.toLowerCase())) && 
                         ({{ $item->kalori }} <= maxCalories) && 
                         ({{ $item->rating }} >= minRating)"
                 :style="sortBy === 'populer' ? 'order: -{{ $item->total_dipesan ?? 0 }}' : (sortBy === 'murah' ? 'order: {{ $item->harga }}' : 'order: 0')">
                
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('images/' . $item->image) }}" alt="{{ $item->nama_menu }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    
                    @if(($item->total_dipesan ?? 0) > 10)
                    <div class="absolute top-4 left-4 bg-orange-500 text-white px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest">
                        Terlaris
                    </div>
                    @endif

                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-green-600 shadow-sm">
                        {{ $item->kalori }} kal
                    </div>
                </div>

                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <span class="text-[10px] uppercase tracking-wider font-bold text-gray-400">{{ $item->kategori }}</span>
                            <h3 class="text-lg font-bold text-gray-900 leading-tight">{{ $item->nama_menu }}</h3>
                        </div>
                        <div class="flex items-center text-yellow-400 bg-yellow-50 px-2 py-1 rounded-lg">
                            <i class="fas fa-star text-[10px]"></i>
                            <span class="text-xs font-bold text-gray-700 ml-1">{{ number_format($item->rating, 1) }}</span>
                        </div>
                    </div>

                    <p class="text-sm text-gray-500 mb-4 line-clamp-2 h-10">{{ $item->deskripsi }}</p>

                    <div class="flex items-center justify-between border-t border-gray-50 pt-4">
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        
                        <form action="{{ route('cart.add', $item->id_menu) }}" method="POST">
                            @csrf 
                            <button type="submit" class="bg-green-600 text-white w-10 h-10 rounded-full hover:bg-green-700 flex items-center justify-center shadow-lg active:scale-90 transition-all">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div x-show="false" id="no-results" class="text-center py-20">
            <i class="fas fa-utensils text-4xl text-gray-200 mb-4"></i>
            <p class="text-gray-500">Menu tidak ditemukan dengan kriteria tersebut.</p>
        </div>
    </div>
</div>
@endsection