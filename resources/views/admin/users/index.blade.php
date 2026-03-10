@extends('layouts.admin') {{-- Ganti ke layout admin untuk Sidebar --}}

@section('content')
<style>[x-cloak] { display: none !important; }</style>
<div class="space-y-8 min-h-screen" x-data="{ isModalOpen: false, editingItem: null, searchQuery: '' }" x-cloak>

    {{-- Header Section and alert --}}
    {{-- Header & Alert --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-2xl font-bold shadow-sm flex items-center gap-3">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif
        {{-- Pesan Error --}}
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-700 rounded-2xl font-bold shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Terjadi kesalahan:</span>
                </div>

                <ul class="list-disc list-inside font-medium space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

    <div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight">User Management</h1>
        <p class="text-gray-500 text-sm mt-1">Kelola dan pantau seluruh basis data pengguna sistem Real Food.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-100">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Users</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $usersss->count() }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-100">
                <i class="fas fa-user-shield text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Administrator</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $usersss->where('role', 'admin')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-green-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-100">
                <i class="fas fa-user text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Pelanggan Aktif</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $usersss->where('role', 'user')->count() }}</h3>
            </div>
        </div>    
    </div>

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
        </div>
        <button @click="isModalOpen = true; editingItem = null" 
                class="bg-green-600 text-white px-8 py-4 rounded-2xl font-black hover:bg-green-700 transition-all flex items-center gap-2 shadow-lg shadow-green-100 active:scale-95">
            <i class="fas fa-plus"></i>Tambah Admin
        </button>
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex flex-wrap gap-4 justify-between items-center">
            <div class="flex bg-gray-50 p-1.5 rounded-2xl border border-gray-100">
                @foreach(['all', 'admin', 'user'] as $role)
                    <a href="?role={{ $role }}" 
                       class="px-6 py-2 rounded-xl text-xs font-black uppercase tracking-widest transition-all
                       {{ request('role', 'all') == $role 
                          ? 'bg-white shadow-sm text-gray-900' 
                          : 'text-gray-400 hover:text-gray-900' }}">
                        {{ $role }}
                    </a>
                @endforeach
            </div>

            <div x-data="{ search: '{{ request('search') }}' }" class="flex flex-col sm:flex-row gap-4">
                <div class="relative">
                    <form method="GET" class="mb-4 flex items-center space-x-2">
                        <input type="text" name="search" x-model="search" placeholder="Cari user..."
                            class="pl-4 pr-10 py-2 rounded-full border border-gray-200 focus:ring-2 focus:ring-green-600 outline-none w-full sm:w-64">

                        <button type="submit"
                            class="text-gray-400 hover:text-green-600 transition">
                            <i class="fas fa-search"></i>
                        </button>

                        <button type="button"
                            class="text-gray-400 hover:text-red-500 transition"
                            x-show="search !== ''"
                            @click="search=''; window.location='{{ route('admin.users.index') }}'">
                            <i class="fas fa-times"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">No</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pengguna</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat Pengiriman</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <span class="text-sm text-gray-600 font-bold">{{ $loop->iteration }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 transition-colors">
                                    @if($user->foto_profil && file_exists(public_path('images/pp/'.$user->foto_profil)))
                                        <img src="{{ asset('images/pp/' . $user->foto_profil) }}" 
                                            class="w-full h-full object-cover">
                                    @else
                                        <i class="fas fa-user text-lg"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-gray-900">{{ $user->nama }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($user->no_hp)
                                <span class="text-sm text-gray-600 font-bold flex items-center gap-2">
                                    <i class="fas fa-phone text-green-500 text-[10px]"></i>
                                    {{ $user->no_hp }}
                                </span>
                            @else
                                <span class="text-gray-300 italic text-xs">Belum diisi</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest
                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="px-8 py-6">
                            @if($user->alamat)
                                <div class="flex items-start gap-2 max-w-xs group-hover:text-gray-900 transition-colors">
                                    <i class="fas fa-map-marker-alt text-red-400 text-[10px] mt-1"></i>
                                    <p class="text-sm text-gray-500 leading-relaxed line-clamp-2" title="{{ $user->alamat }}">
                                        {{ $user->alamat }}
                                    </p>
                                </div>
                            @else
                                <span class="text-gray-300 italic text-xs">Alamat kosong</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center justify-end gap-4">
                            @if($user->role == 'admin')
                                <button @click="isModalOpen = true; editingItem = {{ $user->toJson() }}" 
                                        class="text-green-600 hover:text-green-900 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                            @endif
                                <form action="{{ route('admin.users.destroy', $user->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-50 w-20 h-20 rounded-full flex items-center justify-center text-gray-200 mb-4">
                                    <i class="fas fa-users-slash text-3xl"></i>
                                </div>
                                <p class="text-gray-400 font-bold italic">Tidak ada pengguna yang sesuai filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- Navigasi Paginasi --}}
        <div class="p-6 border-t border-gray-200 flex justify-between items-center">
            {{ $users->links() }}
        </div>
    </div>


    {{-- Modal Alpine.js --}}
        <div x-show="isModalOpen" 
             style="display: none;"
             class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            
            <div class="bg-white w-full max-w-lg rounded-[3rem] p-10 shadow-2xl relative max-h-[90vh] overflow-y-auto" @click.away="isModalOpen = false">
                <button @click="isModalOpen = false" class="absolute top-8 right-8 text-gray-300 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>

                <h2 class="text-3xl font-black text-gray-900 mb-8 italic" x-text="editingItem ? 'Edit Admin' : 'Tambah Admin'"></h2>

                <form :action="editingItem ? `/admin/users/${editingItem.id_user}` : '{{ route('admin.users.store') }}'" 
                      method="POST" 
                      enctype="multipart/form-data" 
                      class="space-y-5">
                    @csrf
                    <template x-if="editingItem">
                        <input type="hidden" name="_method" value="PUT">
                    </template>

                    {{-- Nama --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Nama</label>
                        <input type="text" name="nama" x-model="editingItem ? editingItem.nama : ''" :readonly="editingItem" required 
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 
                               font-bold outline-none transition-all"
                               >
                    </div>
                    {{-- Email --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Email</label>
                        <input type="email" name="email" x-model="editingItem ? editingItem.email : ''" required 
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none transition-all">
                    </div>
                    {{-- Password --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Password</label>
                        <input type="password" name="password" :readonly="editingItem && (editingItem.id_user != {{ auth()->user()->id_user }})" :required="!editingItem" 
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none transition-all">
                    </div>
                    {{-- Role --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Role</label>
                        <select name="role" x-model="editingItem ? editingItem.role : 'Admin'" required
                                class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none appearance-none">
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    {{-- Alamat --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Alamat</label>
                        <textarea name="alamat" rows="3" x-model="editingItem ? editingItem.alamat : ''" required
                                  class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none"></textarea>
                    </div>
                    {{-- No hp --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">No HP</label>
                        <input type="text" 
                            name="no_hp" 
                            x-model="editingItem ? editingItem.no_hp : ''"
                            required
                            pattern="^(?:\+62|0)8[0-9]{8,12}$"
                            class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none transition-all">
                            <p class="text-[8px] text-yellow-400 uppercase font-black tracking-widest mb-1">Harus diawali 08 | contoh: 087654321098</p>
                    </div>
                    

                    {{-- foto profil --}}
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-2">Foto Profil</label>
                        <input type="file" name="foto_profil" accept=".jfif,.jpeg,.jpg,.png,.webp"
                               class="w-full px-6 py-4 rounded-2xl bg-gray-50 border-none focus:ring-2 focus:ring-green-600 font-bold outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                        
                        <template x-if="editingItem && editingItem.foto_profil">
                            <div class="mt-2 ml-2">
                                <p class="text-[10px] text-gray-400 uppercase font-black tracking-widest mb-1">Preview Saat Ini:</p>
                                <img :src="'/images/pp' + editingItem.foto_profil" class="w-20 h-20 object-cover rounded-xl border">
                            </div>
                        </template>
                    </div>

                    <button type="submit" 
                            class="w-full bg-green-600 text-white py-5 rounded-2xl font-black mt-6 hover:bg-green-700 transition-all shadow-lg shadow-green-100 active:scale-95" 
                            x-text="editingItem ? 'Update Admin' : 'Simpan Admin'"></button>
                </form>
            </div>
        </div>
</div>




@endsection