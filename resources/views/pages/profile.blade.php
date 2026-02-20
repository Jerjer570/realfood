@extends('layouts.app')

@section('content')
<div class="pt-24 pb-16 bg-gray-50 min-h-screen" x-data="{ isEditing: false }">
    <div class="max-w-4xl mx-auto px-4">
        
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 mb-8">
            <div class="flex flex-col md:flex-row items-center gap-6">
                <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center text-green-600 text-4xl">
                    <i class="fas fa-user"></i>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <span class="inline-block mt-2 px-4 py-1 bg-green-50 text-green-700 rounded-full text-sm font-bold uppercase tracking-wider">
                        {{ $user->role }}
                    </span>
                </div>
                <button @click="isEditing = !isEditing" 
                        class="flex items-center gap-2 px-6 py-3 rounded-full font-bold transition"
                        :class="isEditing ? 'bg-gray-100 text-gray-600 hover:bg-gray-200' : 'bg-green-600 text-white hover:bg-green-700'">
                    <i class="fas" :class="isEditing ? 'fa-times' : 'fa-edit'"></i>
                    <span x-text="isEditing ? 'Batal' : 'Edit Profil'"></span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                        <i class="fas fa-id-card text-green-600"></i> Informasi Pribadi
                    </h2>

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" :disabled="!isEditing" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none disabled:bg-gray-50 disabled:text-gray-500 transition"
                                   value="{{ old('name', $user->name) }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email (Tidak dapat diubah)</label>
                            <input type="email" disabled 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-500 outline-none"
                                   value="{{ $user->email }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                            <input type="text" name="phone" :disabled="!isEditing" 
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none disabled:bg-gray-50 transition"
                                   value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 08123456789">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Default</label>
                            <textarea name="address" :disabled="!isEditing" rows="3"
                                      class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none disabled:bg-gray-50 transition"
                                      placeholder="Alamat pengiriman makanan">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <div x-show="isEditing" x-transition>
                            <button type="submit" class="w-full bg-green-600 text-white py-4 rounded-xl font-bold hover:bg-green-700 transition shadow-lg flex items-center justify-center gap-2">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold mb-6 flex items-center gap-2 text-gray-900">
                        <i class="fas fa-desktop text-green-600"></i> Perangkat Aktif
                    </h2>

                    <div class="space-y-4">
                        <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100 relative overflow-hidden">
                            <div class="flex items-start justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <i class="fas fa-mobile-alt text-gray-400"></i>
                                    <span class="font-bold text-sm text-gray-800">Device Ini</span>
                                </div>
                                <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold uppercase">Online</span>
                            </div>
                            <p class="text-xs text-gray-500 mb-1">Login: {{ now()->format('d M Y, H:i') }}</p>
                            <p class="text-[10px] text-gray-400 italic">IP: 127.0.0.1 (Localhost)</p>
                        </div>

                        <div class="pt-4">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-red-600 text-sm font-bold hover:underline flex items-center justify-center gap-2">
                                    <i class="fas fa-sign-out-alt"></i> Logout dari Semua Sesi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection