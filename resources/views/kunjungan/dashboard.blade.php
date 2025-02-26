@extends('layouts.app')

@section('title', 'Dashboard Kunjungan')
@section('header', 'Dashboard Kunjungan')

@section('content')
<div class="flex flex-col h-[calc(100vh-5rem)] gap-3">
    <!-- Cards Container dengan Grid dan Gap -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <!-- Card Rawat Inap -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-blue-100">
            <div class="p-3">
                <!-- Header Card -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-blue-50 rounded-lg">
                            <i class='bx bx-bed text-xl text-blue-600'></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Rawat Inap</h2>
                            <p class="text-xs text-gray-500">Update terakhir: <span id="current-time-ri"></span></p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs">
                        <i class='bx bx-dots-vertical-rounded text-lg'></i>
                    </button>
                </div>

                <!-- Total, Masuk, dan Keluar dalam satu baris horizontal -->
                <div class="flex justify-between items-center mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-600">Total</span>
                        <span class="text-xl font-bold text-blue-600">{{ $data['rawat_inap']['total_pasien'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-600">Masuk</span>
                        <span class="text-xl font-bold text-green-600">{{ $data['rawat_inap']['pasien_masuk'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-600">Keluar</span>
                        <span class="text-xl font-bold text-red-600">{{ $data['rawat_inap']['pasien_keluar'] }}</span>
                    </div>
                </div>

                <!-- Progress dan Tren -->
                <div class="space-y-2">
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-gray-600">Okupansi</span>
                            <span class="text-blue-600 font-medium">{{ $data['rawat_inap']['okupansi'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5">
                            <div class="bg-blue-600 h-1.5 rounded-full" 
                                 style="width: {{ $data['rawat_inap']['okupansi'] }}%"></div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ $data['rawat_inap']['tt_terisi'] }} dari {{ $data['rawat_inap']['total_tt'] }} tempat tidur terisi
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-gray-600">Rata-rata Rawat</span>
                        <span class="text-blue-600 font-medium">{{ number_format($data['rawat_inap']['avg_los'], 1) }} Hari</span>
                    </div>
                </div>
            </div>

            <!-- Footer Card -->
            <div class="border-t border-gray-100 p-2">
                <div class="flex justify-between items-center text-xs">
                    <div class="flex items-center gap-1" 
                         title="Perubahan dari hari kemarin ke hari ini">
                        <i class='bx {{ $data['rawat_inap']['perubahan']['total'] >= 0 ? 'bx-trending-up text-green-500' : 'bx-trending-down text-red-500' }}'></i>
                        <span class="text-gray-600">vs kemarin</span>
                        <span class="{{ $data['rawat_inap']['perubahan']['total'] >= 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                            {{ $data['rawat_inap']['perubahan']['total'] >= 0 ? '+' : '' }}{{ $data['rawat_inap']['perubahan']['total'] }}%
                        </span>
                    </div>
                    <a href="{{ route('kunjungan.rawatinap') }}" 
                       class="text-blue-600 hover:text-blue-700 font-medium">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>

        <!-- Card Rawat Jalan -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-green-100">
            <div class="p-3">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-green-50 rounded-lg">
                            <i class='bx bx-walk text-xl text-green-600'></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Rawat Jalan</h2>
                            <p class="text-xs text-gray-500">Update terakhir: <span id="current-time-rj"></span></p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs">
                        <i class='bx bx-dots-vertical-rounded text-lg'></i>
                    </button>
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Total Kunjungan</span>
                        <span class="text-base sm:text-lg font-semibold text-green-600">{{ $data['rawat_jalan']['total_kunjungan'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Pasien Baru</span>
                        <span class="text-base sm:text-lg font-semibold">{{ $data['rawat_jalan']['pasien_baru'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Pasien Lama</span>
                        <span class="text-base sm:text-lg font-semibold">{{ $data['rawat_jalan']['pasien_lama'] }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 p-2">
                <div class="flex justify-between items-center text-xs">
                    <div class="flex items-center gap-1" 
                         title="Perubahan dari hari kemarin ke hari ini">
                        <i class='bx {{ $data['rawat_jalan']['perubahan']['total'] >= 0 ? 'bx-trending-up text-green-500' : 'bx-trending-down text-red-500' }}'></i>
                        <span class="text-gray-600">vs kemarin</span>
                        <span class="{{ $data['rawat_jalan']['perubahan']['total'] >= 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                            {{ $data['rawat_jalan']['perubahan']['total'] >= 0 ? '+' : '' }}{{ $data['rawat_jalan']['perubahan']['total'] }}%
                        </span>
                    </div>
                    <a href="{{ route('kunjungan.rawatjalan') }}" 
                       class="text-green-600 hover:text-green-700 font-medium">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>

        <!-- Card IGD -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-all duration-200 border border-red-100">
            <div class="p-3">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-red-50 rounded-lg">
                            <i class='bx bx-plus-medical text-xl text-red-600'></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">IGD</h2>
                            <p class="text-xs text-gray-500">Update terakhir: <span id="current-time-igd"></span></p>
                        </div>
                    </div>
                    <button class="btn btn-ghost btn-xs">
                        <i class='bx bx-dots-vertical-rounded text-lg'></i>
                    </button>
                </div>

                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Total Kunjungan</span>
                        <span class="text-base sm:text-lg font-semibold text-red-600">{{ $data['igd']['total_kunjungan'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Lanjut Rawat Inap</span>
                        <span class="text-base sm:text-lg font-semibold">{{ $data['igd']['lanjut_rawat_inap'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Pasien Pulang</span>
                        <span class="text-base sm:text-lg font-semibold">{{ $data['igd']['pasien_pulang'] }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100 p-2">
                <div class="flex justify-between items-center text-xs">
                    <div class="flex items-center gap-1" 
                         title="Perubahan dari hari kemarin ke hari ini">
                        <i class='bx {{ $data['igd']['perubahan']['total'] >= 0 ? 'bx-trending-up text-green-500' : 'bx-trending-down text-red-500' }}'></i>
                        <span class="text-gray-600">vs kemarin</span>
                        <span class="{{ $data['igd']['perubahan']['total'] >= 0 ? 'text-green-500' : 'text-red-500' }} font-medium">
                            {{ $data['igd']['perubahan']['total'] >= 0 ? '+' : '' }}{{ $data['igd']['perubahan']['total'] }}%
                        </span>
                    </div>
                    <a href="{{ route('kunjungan.igd') }}" 
                       class="text-red-600 hover:text-red-700 font-medium">
                        Lihat Detail →
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tren Kunjungan Section -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-800">Tren Kunjungan</h3>
            <select id="filterTren" class="rounded-lg border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="minggu" {{ $filter === 'minggu' ? 'selected' : '' }}>Minggu</option>
                <option value="bulan" {{ $filter === 'bulan' ? 'selected' : '' }}>Bulan</option>
                <option value="tahun" {{ $filter === 'tahun' ? 'selected' : '' }}>Tahun</option>
            </select>
        </div>
        <div class="h-[400px] relative">
            <div class="absolute inset-0 bg-gradient-to-b from-white/50 to-transparent z-0"></div>
            <canvas id="trendChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctxTrend = document.getElementById('trendChart').getContext('2d');
    const chartData = @json($chartData);
    
    // Gradient untuk area di bawah garis
    const gradientRawatJalan = ctxTrend.createLinearGradient(0, 0, 0, 400);
    gradientRawatJalan.addColorStop(0, 'rgba(34, 197, 94, 0.2)');
    gradientRawatJalan.addColorStop(1, 'rgba(34, 197, 94, 0)');
    
    const gradientRawatInap = ctxTrend.createLinearGradient(0, 0, 0, 400);
    gradientRawatInap.addColorStop(0, 'rgba(59, 130, 246, 0.2)');
    gradientRawatInap.addColorStop(1, 'rgba(59, 130, 246, 0)');
    
    const gradientIGD = ctxTrend.createLinearGradient(0, 0, 0, 400);
    gradientIGD.addColorStop(0, 'rgba(239, 68, 68, 0.2)');
    gradientIGD.addColorStop(1, 'rgba(239, 68, 68, 0)');

    // Update dataset styling
    chartData.datasets = chartData.datasets.map(dataset => {
        if (dataset.label === 'Rawat Jalan') {
            return {
                ...dataset,
                borderWidth: 2,
                fill: true,
                backgroundColor: gradientRawatJalan,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#22c55e',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2
            };
        } else if (dataset.label === 'Rawat Inap') {
            return {
                ...dataset,
                borderWidth: 2,
                fill: true,
                backgroundColor: gradientRawatInap,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#3b82f6',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2
            };
        } else {
            return {
                ...dataset,
                borderWidth: 2,
                fill: true,
                backgroundColor: gradientIGD,
                pointRadius: 0,
                pointHoverRadius: 6,
                pointHoverBackgroundColor: '#ef4444',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2
            };
        }
    });
    
    const trendChart = new Chart(ctxTrend, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'circle',
                        padding: 15,
                        font: {
                            family: "'Inter', sans-serif",
                            size: 12
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    border: {
                        display: false
                    },
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif",
                            size: 11
                        },
                        padding: 8,
                        color: '#64748b'
                    }
                },
                x: {
                    border: {
                        display: false
                    },
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            family: "'Inter', sans-serif",
                            size: 11
                        },
                        padding: 8,
                        color: '#64748b'
                    }
                }
            }
        }
    });

    // Handle filter change
    document.getElementById('filterTren').addEventListener('change', function() {
        window.location.href = `{{ route('kunjungan.dashboard') }}?filter=${this.value}`;
    });
});

// Fungsi untuk update waktu
function updateTime() {
    const now = new Date();
    const time = now.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit'
    });
    
    // Update semua elemen waktu
    document.getElementById('current-time-ri').textContent = time;
    document.getElementById('current-time-rj').textContent = time;
    document.getElementById('current-time-igd').textContent = time;
}

// Update waktu setiap detik
updateTime();
setInterval(updateTime, 1000);
</script>
@endpush

@php
    \Log::info('Data di View:', [
        'rawat_inap' => $data['rawat_inap'] ?? 'tidak ada data'
    ]);
@endphp
@endsection