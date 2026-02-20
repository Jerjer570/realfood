@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-white flex items-center justify-center px-4 py-12" x-data="{ showPassword: false }">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Akun</h1>
            <p class="text-gray-600">Daftar sekarang untuk mulai hidup sehat</p>
        </div>

        {{-- Alert untuk Error Umum --}}
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-center gap-3 text-red-700">
                <i class="fas fa-exclamation-circle"></i>
                <p class="text-sm">Mohon periksa kembali form pendaftaran Anda.</p>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf
            
            {{-- Nama Lengkap --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Nama Lengkap</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="name" value="{{ old('name') }}" required 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border @error('name') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-green-600 outline-none transition"
                           placeholder="Masukkan nama lengkap">
                </div>
                @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border @error('email') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-green-600 outline-none transition"
                           placeholder="nama@email.com">
                </div>
                @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nomor Telepon --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Nomor Telepon</label>
                <div class="relative">
                    <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none transition"
                           placeholder="0812xxxx">
                </div>
                @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Alamat --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Alamat</label>
                <div class="relative">
                    <i class="fas fa-map-marker-alt absolute left-4 top-3 text-gray-400"></i>
                    <textarea name="address" rows="2" 
                              class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none transition"
                              placeholder="Alamat lengkap pengiriman">{{ old('address') }}</textarea>
                </div>
                @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input :type="showPassword ? 'text' : 'password'" name="password" required 
                           class="w-full pl-12 pr-12 py-3 rounded-xl border @error('password') border-red-500 @else border-gray-200 @enderror focus:ring-2 focus:ring-green-600 outline-none transition"
                           placeholder="Minimal 6 karakter">
                    <button type="button" @click="showPassword = !showPassword" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600">
                        <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
                @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Konfirmasi Password --}}
            <div class="space-y-1">
                <label class="text-sm font-medium text-gray-700">Konfirmasi Password</label>
                <div class="relative">
                    <i class="fas fa-check-double absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" required 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none transition"
                           placeholder="Ulangi password">
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-green-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-lg shadow-green-100">
                Daftar Sekarang
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-green-600 font-bold hover:underline">Login di sini</a>
            </p>
        </div>
    </div>
</div>
@endsection