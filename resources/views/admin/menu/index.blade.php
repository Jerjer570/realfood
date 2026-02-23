@extends('layouts.admin')

@section('content')
{{-- x-cloak mencegah modal muncul sekilas saat refresh --}}
<style>[x-cloak] { display: none !important; }</style>

<div class="pb-16 min-h-screen" x-data="{ isModalOpen: false, editingItem: null }" x-cloak>
    <div class="mx-auto">
        {{-- Header & Alert --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold shadow-sm flex items-center gap-3">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-gray-900 tracking-tight italic">Kelola Menu</h1>
                <p class="text-gray-500 text-sm mt-1">Total <span class="font-bold text-green-600">{{ count($menuItems) }}</span> menu tersedia saat ini.</p>
            </div>
            <button @click="isModalOpen = true; editingItem = null" 
                    class="bg-green-600 text-white px-8 py-4 rounded-2xl font-black hover:bg-green-700 transition-all flex items-center gap-2 shadow-lg shadow-green-100 active:scale-95">
                <i class="fas fa-plus"></i> Tambah Menu
            </button>
        </div>

        {{-- Grid Menu --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($menuItems as $item)
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                <div class="relative h-52 overflow-hidden">
                    <img src="{{ $item->image }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-4 py-1.5 rounded-full text-[10px] font-black uppercase text-green-600 tracking-widest shadow-sm">
                        {{ $item->category }}
                    </div>
                </div>
                <div class="p-8">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="text-lg font-black text-gray-900 leading-tight h-12 line-clamp-2">{{ $item->name }}</h3>
                        <div class="flex items-center gap-1 text-yellow-400">
                            <i class="fas fa-star text-[10px]"></i>
                            <span class="text-xs text-gray-600 font-black">{{ $item->rating ?? '0' }}</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-6 font-medium h-10">{{ $item->description }}</p>
                    
                    <div class="flex justify-between items-center pt-6 border-t border-gray-50">
                        <span class="text-xl font-black text-green-600 italic">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        <div class="flex gap-2">
                            {{-- Tombol Edit --}}
                            <button @click="isModalOpen = true; editingItem = {{ json_encode($item) }}" 
                                    class="p-3 bg-blue-50 text-blue-600 rounded-2xl hover:bg-blue-600 hover:text-white transition-all shadow-sm active:scale-90">
                                <i class="fas fa-edit text-sm"></i>
                            </button>
                            {{-- Tombol Hapus --}}
                            <form action="{{ route('admin.menu.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus menu ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-3 bg-red-50 text-red-600 rounded-2xl hover:bg-red-600 hover:text-white transition-all shadow-sm active:scale-90">
                                    <i class="fas fa-trash text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full py-20 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100">
                <p class="text-gray-400 font-bold">Belum ada menu yang terdaftar.</p>
            </div>
            @endforelse
        </div>

        {{-- Modal Alpine.js --}}
        <div x-show="isModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="bg-white w-full max-w-lg rounded-[3rem] p-10 shadow-2xl relative" @click.away="isModalOpen = false">
                <button @click="isModalOpen = false" class="absolute top-8 right-8 text-gray-300 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <h2 class="text-3xl font-black text-gray-900 mb-8 italic" x-text="editingItem ? 'Edit Menu' : 'Tambah Menu Baru'"></h2>

                <form :action="editingItem ? `/admin/menu/${editingItem.id}` : '{{ route('admin.menu.store') }}'" method="POST" class="space-y-5">
                    @csrf
                    <template x-if="editingItem">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Nama Menu</label>
                        <input type="text" name="name" x-model="editingItem ? editingItem.name : ''" required 
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none transition-all">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Harga (Rp)</label>
                            <input type="number" name="price" x-model="editingItem ? editingItem.price : ''" required 
                                   class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Kategori</label>
                            <select name="category" x-model="editingItem ? editingItem.category : 'Bowls'" 
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none appearance-none">
                                <option value="Bowls">Bowls</option>
                                <option value="Salads">Salads</option>
                                <option value="Drinks">Drinks</option>
                                <option value="Drinks">Main Course</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">URL Gambar</label>
                        <input type="text" name="image" x-model="editingItem ? editingItem.image : ''" required 
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Deskripsi</label>
                        <textarea name="description" rows="3" x-model="editingItem ? editingItem.description : ''" 
                                  class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-5 rounded-2xl font-black mt-6 hover:bg-green-700 transition-all shadow-lg shadow-green-100 active:scale-95" 
                            x-text="editingItem ? 'Update Menu' : 'Simpan Menu'"></button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection