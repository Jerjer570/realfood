@extends('layouts.app')

@section('content')
{{-- Gunakan font yang sama dengan Admin Dashboard untuk konsistensi --}}
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap');
    .font-jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }
</style>

<div class="min-h-screen bg-gray-50 font-jakarta flex items-center justify-center px-4" x-data="{ showPassword: false }">
    <div class="max-w-md w-full">
        {{-- Logo Brand --}}
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black text-green-600 italic tracking-tighter">
                REAL<span class="text-gray-900">FOOD.</span>
            </h1>
            <p class="text-gray-400 text-sm font-bold uppercase tracking-widest mt-2">Masuk ke Akun Anda</p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-200/50 border border-gray-100 overflow-hidden">
            <div class="p-10">
                {{-- Pesan Error --}}
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-100 rounded-2xl flex items-center gap-3 text-red-600 animate-pulse">
                        <i class="fas fa-exclamation-circle"></i>
                        <p class="text-xs font-bold">{{ $errors->first() }}</p>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    {{-- Input Email --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Alamat Email</label>
                        <div class="relative group">
                            <i class="fas fa-envelope absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-green-600 transition-colors"></i>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full pl-12 pr-5 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all placeholder:text-gray-300"
                                   placeholder="admin@realfood.id">
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div class="space-y-2">
                        <div class="flex justify-between items-center ml-1">
                            <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest">Password</label>
                            <a href="#" class="text-[10px] font-black text-green-600 hover:text-green-700 uppercase tracking-widest">Lupa Password?</a>
                        </div>
                        <div class="relative group">
                            <i class="fas fa-lock absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-green-600 transition-colors"></i>
                            <input :type="showPassword ? 'text' : 'password'" name="password" required 
                                   class="w-full pl-12 pr-12 py-4 bg-gray-50 border border-gray-100 rounded-2xl focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all placeholder:text-gray-300"
                                   placeholder="••••••••">
                            
                            <button type="button" @click="showPassword = !showPassword" 
                                    class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 hover:text-green-600 transition-colors">
                                <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    {{-- Tombol Login --}}
                    <button type="submit" 
                            class="w-full bg-gray-900 hover:bg-black text-white font-black uppercase tracking-widest text-xs py-5 rounded-2xl shadow-lg shadow-gray-200 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                        Masuk Sekarang
                        <i class="fas fa-arrow-right text-[10px]"></i>
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-xs text-gray-500 font-bold">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-green-600 hover:underline">Daftar di sini</a>
                    </p>
                </div>
            </div>

            {{-- Info Akun Demo (Gaya Dashboard) --}}
            <div class="bg-gray-50 p-8 border-t border-gray-100">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-4">Akses Cepat (Demo):</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
                        <p class="text-[10px] font-black text-purple-600 uppercase mb-1">Administrator</p>
                        <p class="text-xs font-bold text-gray-800">admin@realfood.id</p>
                        <p class="text-[10px] text-gray-400">Pass: admin123</p>
                    </div>
                    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-sm">
                        <p class="text-[10px] font-black text-blue-600 uppercase mb-1">Pelanggan</p>
                        <p class="text-xs font-bold text-gray-800">user@example.com</p>
                        <p class="text-[10px] text-gray-400">Pass: user123</p>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-center text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em] mt-10">
            &copy; {{ date('Y') }} Real Food Control Panel
        </p>
    </div>
</div>
@endsection