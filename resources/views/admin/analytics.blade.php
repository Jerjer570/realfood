@extends('layouts.admin')

@section('content')
<div class="space-y-8" id="analyticsContent">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Dashboard Analytics</h1>
            <p class="text-gray-500 text-sm mt-1">Fokus pada performa menu dan tren penjualan.</p>
        </div>
    </div>

    {{-- Langsung ke Bagian Menu Terlaris & Grafik --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Menu Terlaris --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-black text-gray-900 italic mb-8">Menu Terlaris</h2>
            {{-- Loop topItems anda disini --}}
        </div>

        {{-- Revenue Trends --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-black text-gray-900 italic mb-8">Revenue Trend</h2>
            {{-- Grafik anda disini --}}
        </div>
    </div>
</div>
@endsection