@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 to-white flex items-center justify-center px-4" x-data="{ showPassword: false }">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Selamat Datang</h1>
            <p class="text-gray-600">Silakan login untuk memesan makanan sehat</p>
        </div>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl flex items-center gap-3 text-red-700">
                <i class="fas fa-exclamation-circle"></i>
                <p class="text-sm">{{ $errors->first() }}</p>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition"
                           placeholder="admin@realfood.id">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input :type="showPassword ? 'text' : 'password'" name="password" required 
                           class="w-full pl-12 pr-12 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent transition"
                           placeholder="••••••••">
                    
                    <button type="button" @click="showPassword = !showPassword" 
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 transition">
                        <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                    </button>
                </div>
            </div>

            <button type="submit" 
                    class="w-full bg-green-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-lg shadow-green-100">
                Login
            </button>
        </form>

        <div class="mt-8 text-center">
            <p class="text-gray-600">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-green-600 font-bold hover:underline">Daftar di sini</a>
            </p>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-100">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Akun Demo:</p>
            <div class="grid grid-cols-2 gap-3 text-xs">
                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <p class="font-bold text-gray-700">Admin</p>
                    <p class="text-gray-500">admin@realfood.id</p>
                    <p class="text-gray-500">pass: admin123</p>
                </div>
                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                    <p class="font-bold text-gray-700">User</p>
                    <p class="text-gray-500">user@example.com</p>
                    <p class="text-gray-500">pass: user123</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection