@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $users */
@endphp

@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">User Management</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola foto profil, data pribadi, dan akses pengguna Real Food.</p>
        </div>

        <a href="{{ route('admin.users.create') }}" 
           class="inline-flex items-center justify-center gap-3 bg-green-600 hover:bg-green-700 text-white px-6 py-3.5 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-green-100 transition-all active:scale-95">
            <i class="fas fa-plus-circle text-sm"></i>
            Tambah Pengguna
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-100">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Users</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $users->total() }}</h3> 
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-100">
                <i class="fas fa-user-shield text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Administrator</p>
                <h3 class="text-3xl font-black text-gray-900">{{ \App\Models\User::where('role', 'admin')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-green-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-100">
                <i class="fas fa-user text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Pelanggan Aktif</p>
                <h3 class="text-3xl font-black text-gray-900">{{ \App\Models\User::where('role', 'user')->count() }}</h3>
            </div>
        </div>
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
                        {{ ucfirst($role) }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pengguna</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kontak</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Role</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                {{-- FOTO PROFIL (Direct Public Access) --}}
                                <div class="w-14 h-14 rounded-2xl border-2 border-gray-100 overflow-hidden shadow-sm group-hover:border-green-400 transition-all flex-shrink-0">
                                    @if($user->foto && file_exists(public_path($user->foto)))
                                        <img src="{{ asset($user->foto) }}" 
                                             alt="Profile" 
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400 group-hover:bg-green-50 group-hover:text-green-600 transition-colors uppercase font-black text-xs">
                                            {{ substr($user->nama, 0, 2) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-black text-gray-900 leading-tight">{{ $user->nama }}</p>
                                    <p class="text-xs text-gray-400 font-medium mt-1">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($user->no_hp)
                                <span class="text-sm text-gray-600 font-bold flex items-center gap-2">
                                    <i class="fab fa-whatsapp text-green-500 text-sm"></i>
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
                        <td class="px-8 py-6 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.users.edit', $user->id_user) }}" 
                                   class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all" 
                                   title="Edit Pengguna">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>

                                <form action="{{ route('admin.users.destroy', $user->id_user) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus pengguna ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all" 
                                            title="Hapus Pengguna">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <p class="text-gray-400 font-bold italic">Tidak ada pengguna ditemukan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-8 border-t border-gray-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection