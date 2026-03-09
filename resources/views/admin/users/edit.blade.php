@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-gray-400 hover:text-gray-900 border border-gray-100 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Edit Pengguna</h1>
            <p class="text-gray-500 text-sm mt-1">Perbarui informasi akun untuk <span class="font-bold text-gray-900">{{ $user->nama }}</span>.</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST" enctype="multipart/form-data" class="p-10 space-y-8">
            @csrf
            @method('PUT')
            
            {{-- Bagian Edit Foto Profil --}}
            <div class="flex flex-col items-center justify-center pb-8 border-b border-gray-50 mb-4" x-data="{ photoPreview: null }">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-4">Foto Profil Pengguna</label>
                
                <div class="relative group">
                    {{-- Preview Container --}}
                    <div class="w-36 h-36 rounded-[2.5rem] bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-blue-400 shadow-inner">
                        <template x-if="!photoPreview">
                            @if($user->foto && file_exists(public_path($user->foto)))
                                {{-- Jalur Langsung ke Public --}}
                                <img src="{{ asset($user->foto) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex flex-col items-center gap-2">
                                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-300">
                                        <i class="fas fa-user text-2xl"></i>
                                    </div>
                                    <span class="text-[9px] font-bold text-gray-300 uppercase mt-1">Belum Ada Foto</span>
                                </div>
                            @endif
                        </template>
                        
                        {{-- New Photo Preview --}}
                        <template x-if="photoPreview">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </template>
                    </div>

                    {{-- Upload Button --}}
                    <input type="file" name="foto" class="hidden" id="photoInput" accept="image/*"
                           @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                    
                    <button type="button" @click="document.getElementById('photoInput').click()" 
                            class="absolute -bottom-2 -right-2 w-12 h-12 bg-blue-600 text-white rounded-2xl flex items-center justify-center shadow-xl hover:bg-blue-700 transition-all border-4 border-white">
                        <i class="fas fa-camera text-sm"></i>
                    </button>
                </div>
                
                @if($user->foto)
                    <p class="text-[9px] text-blue-500 font-bold uppercase tracking-widest mt-4 bg-blue-50 px-3 py-1 rounded-full">File Tersimpan di Public/Images</p>
                @endif
                @error('foto') <p class="text-red-500 text-[10px] mt-3 font-bold">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    @error('nama') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Role --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Role / Hak Akses</label>
                    <div class="relative">
                        <select name="role" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all appearance-none cursor-pointer">
                            <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>Pelanggan (User)</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        <div class="absolute inset-y-0 right-5 flex items-center pointer-events-none text-gray-400">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                {{-- No HP --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Nomor WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">
                    @error('no_hp') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3"
                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 outline-none transition-all">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
            </div>

            {{-- ALERT KEAMANAN (Password Note) --}}
            <div class="bg-amber-50 rounded-3xl p-6 border border-amber-100 flex items-start gap-4">
                <div class="bg-amber-500 w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg shadow-amber-200">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div>
                    <h4 class="text-amber-900 font-black text-xs uppercase tracking-widest mb-1">Catatan Keamanan</h4>
                    <p class="text-amber-700 text-xs leading-relaxed">
                        Password tidak dapat diubah melalui halaman ini demi keamanan privasi pengguna. 
                    </p>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4">
                <button type="submit" 
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black uppercase tracking-widest text-xs py-5 rounded-2xl shadow-lg shadow-blue-100 transition-all active:scale-[0.98] flex items-center justify-center gap-3">
                    <i class="fas fa-save"></i>
                    Simpan Perubahan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection