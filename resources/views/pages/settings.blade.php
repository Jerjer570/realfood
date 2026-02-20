@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50/50">
    {{-- 1. Sidebar Navigasi --}}
    <x-sidebar class="border-r border-gray-100">
        <div class="space-y-1">
            <x-nav-menu href="{{ route('admin.dashboard') }}" :active="false">
                <i class="fas fa-th-large mr-2"></i> Dashboard
            </x-nav-menu>
            {{-- Menggunakan Request::is untuk deteksi aktif otomatis --}}
            <x-nav-menu href="#" :active="Request::is('admin/settings*')">
                <i class="fas fa-cog mr-2"></i> Pengaturan
            </x-nav-menu>
        </div>
        <x-seperator class="my-6" />
        <x-nav-menu href="{{ route('menu.index') }}">
            <i class="fas fa-utensils mr-2"></i> Lihat Menu
        </x-nav-menu>
    </x-sidebar>

    {{-- 2. Konten Utama --}}
    <main class="flex-1 ml-64 p-10">
        <div class="max-w-4xl mx-auto">
            {{-- PERBAIKAN BREADCRUMB: Mengirim array asosiatif ke komponen --}}
            <x-breadcrumb :items="[
                ['label' => 'Admin', 'href' => route('admin.dashboard')],
                ['label' => 'Pengaturan Akun', 'href' => '#']
            ]" class="mb-8" />

            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-black italic tracking-tighter text-gray-900 uppercase">PENGATURAN<span class="text-green-600">AKUN.</span></h1>
                    <p class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">Kelola data personal dan preferensi makanmu</p>
                </div>
                <x-badge variant="default" class="px-4 py-2">Versi Pro 2.0</x-badge>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    {{-- Kolom Kiri --}}
                    <div class="md:col-span-2 space-y-6">
                        <x-card class="p-8">
                            <x-slot name="header">
                                <h2 class="text-lg font-black uppercase tracking-widest text-gray-900 italic">Informasi Personal</h2>
                            </x-slot>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-4">
                                <x-form-group label="Nomor WhatsApp" name="phone" placeholder="0812..." value="{{ Auth::user()->phone }}" />
                                
                                <x-form-group label="Email" name="email" type="email" value="{{ Auth::user()->email }}">
                                    {{-- Tooltip untuk info tambahan --}}
                                    <x-tooltip text="Email utama untuk invoice">
                                        <i class="fas fa-info-circle text-gray-300 ml-1 cursor-help"></i>
                                    </x-tooltip>
                                </x-form-group>
                            </div>

                            <div class="mt-6">
                                <x-label class="mb-3 text-xs font-black uppercase tracking-widest text-gray-400">Lokasi Default</x-label>
                                <x-select name="lokasi" :options="['sby' => 'Surabaya (Pusat)', 'jkt' => 'Jakarta (Cabang)']" />
                            </div>
                        </x-card>

                        <x-card class="p-8">
                            <h2 class="text-lg font-black uppercase tracking-widest text-gray-900 italic mb-6">Preferensi Makanan</h2>
                            
                            <div class="space-y-6">
                                <div class="flex items-center justify-between p-5 bg-gray-50 rounded-[2rem] border border-gray-100">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900">Notifikasi WhatsApp</span>
                                        <span class="text-[10px] text-gray-400 font-medium italic">Update status pengiriman real-time</span>
                                    </div>
                                    <x-switch name="notif" :checked="true" />
                                </div>

                                <div class="space-y-4">
                                    <div class="flex justify-between items-center">
                                        <x-label class="text-xs font-black uppercase tracking-widest text-gray-400">Tingkat Kepedasan</x-label>
                                        <x-badge variant="outline" class="text-[10px]">Level 1-5</x-badge>
                                    </div>
                                    <x-slider min="1" max="5" value="3" />
                                </div>

                                <div class="pt-6 border-t border-gray-50">
                                    <x-label class="mb-4 text-xs font-black uppercase tracking-widest text-gray-400">Durasi Paket Berlangganan</x-label>
                                    <div class="flex flex-wrap gap-6">
                                        <x-radio-group-item id="plan1" name="plan" value="weekly" label="Mingguan" :checked="true" />
                                        <x-radio-group-item id="plan2" name="plan" value="monthly" label="Bulanan" />
                                    </div>
                                </div>
                            </div>
                        </x-card>
                    </div>

                    {{-- Kolom Kanan --}}
                    <div class="space-y-6">
                        <x-card class="p-6 bg-green-600 text-white border-none shadow-xl shadow-green-100 relative overflow-hidden">
                            <div class="relative z-10">
                                <h3 class="font-black italic text-[10px] mb-4 uppercase tracking-widest opacity-80">Profil Lengkap</h3>
                                <div class="flex justify-between items-end mb-2">
                                    <span class="text-4xl font-black italic">85%</span>
                                    <i class="fas fa-check-double text-2xl opacity-30"></i>
                                </div>
                                <x-progress value="85" class="bg-green-700/50" />
                                <p class="text-[9px] mt-4 font-bold uppercase tracking-widest opacity-80 leading-relaxed">Isi alamat lengkap untuk klaim diskon member!</p>
                            </div>
                            {{-- Dekorasi --}}
                            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl"></div>
                        </x-card>

                        <x-card class="p-6">
                            <h3 class="font-black italic text-sm mb-6 uppercase tracking-widest text-gray-400">Keamanan</h3>
                            <p class="text-xs text-gray-500 mb-6 font-medium leading-relaxed italic">Verifikasi nomor WhatsApp untuk akses fitur premium.</p>
                            
                            <x-button type="button" variant="outline" size="sm" class="w-full rounded-xl" @click.prevent="$dispatch('open-dialog-verify')">
                                <i class="fas fa-shield-alt mr-2"></i> Verifikasi OTP
                            </x-button>
                        </x-card>

                        <x-button type="submit" variant="default" size="lg" class="w-full py-6 rounded-[2rem] shadow-2xl shadow-green-200/50">
                            SIMPAN PERUBAHAN
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

{{-- Modal OTP --}}
<x-dialog id="verify">
    <div class="text-center p-2">
        <h2 class="text-2xl font-black italic tracking-tighter uppercase mb-2">VERIFIKASI OTP</h2>
        <p class="text-xs text-gray-400 font-bold mb-8 uppercase tracking-widest">Cek WhatsApp Anda</p>
        
        <div class="flex justify-center mb-10">
            <x-input-otp length="4" name="kode_otp" />
        </div>

        <div class="grid grid-cols-2 gap-3">
            <x-button variant="ghost" @click="$dispatch('close-dialog')">Batal</x-button>
            <x-button variant="default">Kirim</x-button>
        </div>
    </div>
</x-dialog>
@endsection