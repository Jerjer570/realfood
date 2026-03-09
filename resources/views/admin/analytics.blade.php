{{-- Tambahkan Script Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        
        // MENGAMBIL DATA ASLI DARI CONTROLLER
        // @json akan mengubah array PHP menjadi array JavaScript secara otomatis
        const labelsAsli = @json($labels ?? ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab']);
        const dataAsli = @json($totals ?? [0, 0, 0, 0, 0, 0, 0]);

        // Desain Gradien Hijau untuk Grafik
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(22, 163, 74, 0.2)');
        gradient.addColorStop(1, 'rgba(22, 163, 74, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labelsAsli, // DATA ASLI
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataAsli, // DATA ASLI
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
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], drawBorder: false },
                        ticks: {
                            callback: (value) => 'Rp ' + value.toLocaleString('id-ID'),
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