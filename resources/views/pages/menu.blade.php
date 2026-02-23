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
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all group"
                 x-show="searchQuery === '' || '{{ strtolower($item->name) }}'.includes(searchQuery.toLowerCase())">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-green-600">
                        {{ $item->calories }} kal
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-lg font-bold text-gray-900">{{ $item->name }}</h3>
                        <div class="flex items-center text-yellow-400">
                            <i class="fas fa-star text-xs"></i>
                            <span class="text-xs text-gray-600 ml-1">{{ $item->rating }}</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $item->description }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                       {{-- Bungkus dengan Form POST untuk mengirim ID makanan ke CartController --}}
<form action="{{ route('cart.add', $item->id) }}" method="POST">
    @csrf {{-- Wajib untuk keamanan Laravel --}}
    <button type="submit" class="bg-green-600 text-white p-2 rounded-full hover:bg-green-700 transition-colors active:scale-90">
        <i class="fas fa-plus"></i>
    </button>
</form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection