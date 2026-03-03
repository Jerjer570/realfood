@extends('layouts.admin')

@section('content')
<div class="space-y-8" id="financialContent">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight italic">Laporan Keuangan</h1>
            <p class="text-gray-500 text-sm mt-1">Ringkasan performa finansial Real Food.</p>
        </div>
        
        <button type="button" onclick="exportFinancialExcel(this)" class="flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-100 active:scale-95">
            <i class="fas fa-file-excel"></i> Export Excel
        </button>
    </div>

    {{-- Stats Grid Sesuai Desain Dashboard --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Revenue --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-green-600 text-white rounded-2xl shadow-lg">
                    <i class="fas fa-dollar-sign text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Revenue</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        {{-- Total Pesanan --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-blue-600 text-white rounded-2xl shadow-lg">
                    <i class="fas fa-shopping-bag text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Pesanan</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        {{-- Total Pelanggan --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-purple-600 text-white rounded-2xl shadow-lg">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Pelanggan</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>
        
        {{-- Avg pesanan Value --}}
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 hover:shadow-lg transition-all">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-orange-500 text-white rounded-2xl shadow-lg">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Avg. pesanan</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function exportFinancialExcel(btn) {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        btn.disabled = true;

        try {
            const data = [
                ["REAL FOOD - LAPORAN KEUANGAN"],
                ["Tanggal Ekspor:", new Date().toLocaleString()],
                [],
                ["RINGKASAN METRIK", "NILAI"],
                ["Total Revenue", "Rp {{ number_format($totalRevenue, 0, ',', '.') }}"],
                ["Total Pesanan", "{{ $totalOrders }}"],
                ["Total Pelanggan", "{{ $totalCustomers }}"],
                ["Average pesanan Value", "Rp {{ number_format($averageOrderValue, 0, ',', '.') }}"]
            ];

            const ws = XLSX.utils.aoa_to_sheet(data);
            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Financial Report");
            XLSX.writeFile(wb, "RealFood_Financial_" + new Date().toISOString().slice(0,10) + ".xlsx");
        } catch (e) {
            alert('Gagal mengekspor Excel.');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }
</script>
@endsection