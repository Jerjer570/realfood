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
        <form action="{{ route('admin.users.update', $user->id_user) }}" method="POST" class="p-10 space-y-8">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Lengkap --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all">
                    @error('nama') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Email --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all">
                    @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>

                {{-- Role --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Role / Hak Akses</label>
                    <div class="relative">
                        <select name="role" required
                            class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all appearance-none cursor-pointer">
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
                        class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all">
                    @error('no_hp') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Alamat --}}
            <div class="space-y-2">
                <label class="text-[10px] font-black uppercase text-gray-400 tracking-widest ml-1">Alamat Lengkap</label>
                <textarea name="alamat" rows="3"
                    class="w-full bg-gray-50 border border-gray-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-green-500/10 focus:border-green-500 outline-none transition-all">{{ old('alamat', $user->alamat) }}</textarea>
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
                        Jika pengguna lupa password, silakan arahkan mereka untuk menggunakan fitur <b>Reset Password</b> di halaman login.
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