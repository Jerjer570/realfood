@extends('layouts.admin')

@section('content')
<div class="space-y-8" id="financialContent">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight italic">Laporan Keuangan</h1>
            <p class="text-gray-500 text-sm mt-1">Data finansial Real Food berdasarkan transaksi asli di database.</p>
        </div>
        
        <button type="button" onclick="exportFinancialExcel(this)" class="flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-green-700 transition shadow-lg shadow-green-100 active:scale-95">
            <i class="fas fa-file-excel"></i> Export Laporan (.xlsx)
        </button>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-green-600 text-white rounded-2xl">
                    <i class="fas fa-wallet text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Revenue</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-blue-600 text-white rounded-2xl">
                    <i class="fas fa-shopping-cart text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Pesanan</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-purple-600 text-white rounded-2xl">
                    <i class="fas fa-user-check text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Total Pelanggan</p>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalCustomers }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100">
            <div class="flex items-center gap-5">
                <div class="p-4 bg-orange-500 text-white rounded-2xl">
                    <i class="fas fa-receipt text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Avg. Per Pesanan</p>
                    <h3 class="text-2xl font-black text-gray-900">Rp {{ number_format($averageOrderValue, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-8 border-b border-gray-50 flex justify-between items-center">
            <h2 class="text-xl font-black text-gray-900">Riwayat Pendapatan Terakhir</h2>
            <span class="px-4 py-1.5 bg-green-50 text-green-600 text-[10px] font-black uppercase rounded-full tracking-widest">Live Data</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse" id="financialTable">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">ID Transaksi</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Nama Pelanggan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest">Waktu Pembayaran</th>
                        <th class="px-8 py-5 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50/30 transition-colors">
                        <td class="px-8 py-6 font-bold text-gray-700">#RF-{{ $order->id_pesanan }}</td>
                        <td class="px-8 py-6">
                            <span class="font-black text-gray-900 text-sm">{{ $order->user->nama ?? 'Guest' }}</span>
                        </td>
                        <td class="px-8 py-6 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-8 py-6 text-right font-black text-green-600">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-20 text-center text-gray-400 italic">Belum ada data transaksi masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Excel Export Library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function exportFinancialExcel(btn) {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        btn.disabled = true;

        try {
            // Data Header Laporan
            const reportInfo = [
                ["REAL FOOD - LAPORAN KEUANGAN RESMI"],
                ["Waktu Ekspor:", new Date().toLocaleString()],
                [],
                ["RINGKASAN EKSEKUTIF", ""],
                ["Total Revenue", {{ $totalRevenue }}],
                ["Total Pesanan", {{ $totalOrders }}],
                ["Total Pelanggan", {{ $totalCustomers }}],
                ["Rata-rata Pendapatan per Order", {{ $averageOrderValue }}],
                [],
                ["DETAIL TRANSAKSI"]
            ];

            // Mengambil Data dari Tabel HTML
            const table = document.getElementById("financialTable");
            const tableContent = XLSX.utils.sheet_to_json(XLSX.utils.table_to_sheet(table), {header: 1});

            // Gabungkan Header dan Isi Tabel
            const finalSheetData = reportInfo.concat(tableContent);

            const ws = XLSX.utils.aoa_to_sheet(finalSheetData);
            
            // Format IDR untuk Excel
            const currencyFormat = '"Rp "#,##0';
            const currencyCells = ['B5', 'B8']; // Sel di ringkasan
            currencyCells.forEach(cell => { if(ws[cell]) ws[cell].z = currencyFormat; });

            const wb = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(wb, ws, "Financial Report");
            XLSX.writeFile(wb, "Laporan_Keuangan_RealFood_" + new Date().toISOString().split('T')[0] + ".xlsx");
        } catch (e) {
            alert('Terjadi kesalahan saat mengekspor data.');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }
</script>
@endsection