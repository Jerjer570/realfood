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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- 1. Menu Terlaris --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-black text-gray-900 italic mb-8">Menu Terlaris</h2>
            
            <div class="space-y-6">
                @forelse($topItems as $item)
                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-2xl hover:bg-green-50 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-600 text-white rounded-xl flex items-center justify-center font-black">
                            {{ $loop->iteration }}
                        </div>
                        <div>
                            <p class="font-black text-gray-900">{{ $item->name }}</p>
                            <p class="text-xs text-gray-500">{{ $item->count }} Terjual</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-black text-green-600">Rp {{ number_format($item->revenue, 0, ',', '.') }}</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 italic text-center py-10">Belum ada data penjualan.</p>
                @endforelse
            </div>
        </div>

        {{-- 2. Revenue Trends (Grafik) --}}
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 p-8">
            <h2 class="text-xl font-black text-gray-900 italic mb-8">Revenue Trend</h2>
            
            <div class="h-[300px] w-full">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // Desain Gradien Hijau untuk Grafik
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(22, 163, 74, 0.2)');
        gradient.addColorStop(1, 'rgba(22, 163, 74, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'], // Data contoh seminggu
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: [150000, 450000, 300000, 700000, 550000, 900000, 1200000], // Sesuaikan dengan data asli nanti
                    borderColor: '#16a34a',
                    borderWidth: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#16a34a',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    tension: 0.4,
                    fill: true,
                    backgroundColor: gradient,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827',
                        titleFont: { family: 'Plus Jakarta Sans', weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans' },
                        padding: 12,
                        cornerRadius: 12,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], drawBorder: false },
                        ticks: {
                            callback: (value) => 'Rp ' + value.toLocaleString(),
                            font: { size: 10, weight: 'bold' }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' } }
                    }
                }
            }
        });
    });
</script>
@endsection