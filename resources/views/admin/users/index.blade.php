@extends('layouts.admin') {{-- Pastikan file ini ada di resources/views/layouts/admin.blade.php --}}

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
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
                <h3 class="text-3xl font-black text-gray-900">{{ $users->total() }}</h3> {{-- Gunakan total() untuk paginasi --}}
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-100">
                <i class="fas fa-user-shield text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Administrator</p>@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $users */
@endphp

@extends('layouts.admin')

@section('content')
<div class="space-y-8">
    {{-- Header Section --}}
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
                {{-- BARIS 20: Sekarang tidak akan merah lagi karena ada Type Hint di atas --}}
                <h3 class="text-3xl font-black text-gray-900">{{ $users->total() }}</h3> 
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-purple-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-purple-100">
                <i class="fas fa-user-shield text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Administrator</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $users->where('role', 'admin')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-green-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-100">
                <i class="fas fa-user text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Pelanggan Aktif</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $users->where('role', 'user')->count() }}</h3>
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
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 transition-colors">
                                    <i class="fas fa-user text-lg"></i>
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
                                <span class="text-gray-300 italic text-xs">N/A</span>
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
                                <p class="text-sm text-gray-500 line-clamp-1" title="{{ $user->alamat }}">
                                    {{ $user->alamat }}
                                </p>
                            @else
                                <span class="text-gray-300 italic text-xs">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic">
                            Data tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Navigasi Paginasi --}}
        <div class="p-8 border-t border-gray-50 pagination-custom">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
                {{-- Catatan: Filter manual ini hanya menghitung data di halaman AKTIF. --}}
                <h3 class="text-3xl font-black text-gray-900">{{ $users->where('role', 'admin')->count() }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-gray-100 flex items-center gap-6 hover:shadow-lg transition-all">
            <div class="bg-green-600 w-16 h-16 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-green-100">
                <i class="fas fa-user text-2xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Pelanggan Aktif</p>
                <h3 class="text-3xl font-black text-gray-900">{{ $users->where('role', 'user')->count() }}</h3>
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
                        {{ $role }}
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
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Alamat Pengiriman</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($users as $user)
                    <tr class="hover:bg-gray-50/30 transition-colors group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 group-hover:bg-green-100 group-hover:text-green-600 transition-colors">
                                    <i class="fas fa-user text-lg"></i>
                                </div>
                                <div>
                                    {{-- PERBAIKAN: Gunakan $user->nama bukan $user->name --}}
                                    <p class="font-black text-gray-900">{{ $user->nama }}</p>
                                    <p class="text-xs text-gray-400 font-medium">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            {{-- PERBAIKAN: Gunakan $user->no_hp bukan $user->phone --}}
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <p class="text-gray-400 font-bold italic">Tidak ada pengguna yang sesuai filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PERBAIKAN: Tambahkan Navigasi Paginasi --}}
        <div class="p-8 border-t border-gray-50">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection