@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen" x-data="{ searchQuery: '', selectedCategory: 'All' }">
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

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($menuItems as $item)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md hover:-translate-y-2 transition-all duration-300 group"
                 x-show="searchQuery === '' || '{{ strtolower($item->nama_menu) }}'.includes(searchQuery.toLowerCase())">
                
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama_menu }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    
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
                            <button type="submit" title="Tambah ke keranjang" 
                                    class="bg-green-600 text-white w-10 h-10 rounded-full hover:bg-green-700 transition-all active:scale-90 flex items-center justify-center shadow-lg shadow-green-100">
                                <i class="fas fa-plus"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-12 px-4">
            {{ $menuItems->links() }}
        </div>

        <div x-show="searchQuery !== '' && !document.querySelector('.grid > div[style*=\'display: block\']') && !document.querySelector('.grid > div:not([style*=\'display: none\'])')" 
             class="text-center py-20">
            <i class="fas fa-utensils text-4xl text-gray-200 mb-4"></i>
            <p class="text-gray-500">Wah, menu "<span x-text="searchQuery" class="font-bold"></span>" belum tersedia nih.</p>
        </div>
    </div>
</div>
@endsection