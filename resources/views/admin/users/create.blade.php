@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-900 border border-gray-100 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Tambah Pengguna</h1>
            <p class="text-gray-500 text-sm mt-1">Buat akun baru untuk Administrator atau Pelanggan.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        {{-- UPDATE: Tambahkan enctype agar bisa upload file --}}
        <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-6">
            @csrf
            
            {{-- Bagian Upload Foto --}}
            <div class="flex flex-col items-center justify-center pb-6 border-b border-gray-50 mb-6" x-data="{photoPreview: null}">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Foto Profil</label>
                <div class="relative group">
                    <div class="w-32 h-32 rounded-[2rem] bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-green-400">
                        <template x-if="!photoPreview">
                            <i class="fas fa-camera text-2xl text-gray-300"></i>
                        </template>
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                    </div>
                    
                    <input type="file" name="foto" class="hidden" id="photoInput" accept="image/*"
                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                    
                    <button type="button" @click="document.getElementById('photoInput').click()" 
                            class="absolute -bottom-2 -right-2 w-10 h-10 bg-green-600 text-white rounded-xl flex items-center justify-center shadow-lg hover:bg-green-700 transition-all">
                        <i class="fas fa-plus text-xs"></i>
                    </button>
                </div>
                @error('foto') <p class="text-red-500 text-[10px] mt-3 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                        class="w-full bg-gray-50 border {{ $errors->has('nama') ? 'border-red-300' : 'border-gray-100' }} rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all placeholder:text-gray-300"
                        placeholder="Contoh: Budi Santoso">
                    @error('nama') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-gray-50 border {{ $errors->has('email') ? 'border-red-300' : 'border-gray-100' }} rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all placeholder:text-gray-300"
                        placeholder="budi@example.com">
                    @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full bg-gray-50 border {{ $errors->has('password') ? 'border-red-300' : 'border-gray-100' }} rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all placeholder:text-gray-300"
                        placeholder="Minimal 8 karakter">
                    @error('password') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Role --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Role / Hak Akses</label>
                    <div class="relative">
                        <select name="role" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all appearance-none cursor-pointer">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Pelanggan (User)</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- No HP --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Nomor WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all placeholder:text-gray-300"
                        placeholder="08123456789">
                    @error('no_hp') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3"
                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all placeholder:text-gray-300"
                    placeholder="Masukkan alamat pengiriman...">{{ old('alamat') }}</textarea>
                @error('alamat') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit" 
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-black uppercase tracking-widest text-xs py-5 rounded-2xl shadow-lg shadow-green-100 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    <i class="fas fa-save"></i>
                    Simpan Data Pengguna
                </button>
            </div>
        </form>
    </div>
</div>
@endsection