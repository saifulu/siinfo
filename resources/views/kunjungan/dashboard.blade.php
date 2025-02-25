@extends('layouts.app')

@section('title', 'Dashboard Kunjungan')
@section('header', 'Dashboard Kunjungan')

@section('content')
<div class="flex flex-col h-[calc(100vh-5rem)] gap-3">
    <!-- Cards Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        <!-- Card Rawat Inap -->
        <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="card-body p-3 sm:p-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="card-title text-blue-600 text-base sm:text-lg">Rawat Inap</h2>
                    <i class='bx bx-bed text-blue-100 text-xl sm:text-2xl'></i>
                </div>
                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Total Pasien</span>
                        <span class="text-base sm:text-lg font-semibold text-blue-600">{{ $data['rawat_inap']['total_pasien'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Pasien Masuk</span>
                        <span class="text-base sm:text-lg font-semibold">{{ $data['rawat_inap']['pasien_masuk'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Pasien Keluar</span>
                        <span class="text-base sm:text-lg font-semibold">{{ $data['rawat_inap']['pasien_keluar'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Rawat Jalan -->
        <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow">
            <div class="card-body p-3 sm:p-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="card-title text-green-600 text-base sm:text-lg">Rawat Jalan</h2>
                    <i class='bx bx-walk text-green-100 text-xl sm:text-2xl'></i>
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
        </div>

        <!-- Card IGD -->
        <div class="card bg-base-100 shadow-sm hover:shadow-md transition-shadow sm:col-span-2 lg:col-span-1">
            <div class="card-body p-3 sm:p-4">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="card-title text-red-600 text-base sm:text-lg">IGD</h2>
                    <i class='bx bx-plus-medical text-red-100 text-xl sm:text-2xl'></i>
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
        </div>
    </div>

    <!-- Grafik Kunjungan -->
    <div class="bg-white hover:bg-gray-50 transition-colors duration-300 rounded-lg shadow-md p-4 sm:p-6 flex-grow">
        <div class="flex flex-col h-full">
            <!-- Header Grafik -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Tren Kunjungan</h3>
                <select id="filterTren" 
                        class="select select-bordered select-sm w-32"
                        onchange="window.location.href='?filter=' + this.value">
                    <option value="hari" {{ $data['current_filter'] == 'hari' ? 'selected' : '' }}>Hari</option>
                    <option value="minggu" {{ $data['current_filter'] == 'minggu' ? 'selected' : '' }}>Minggu</option>
                    <option value="bulan" {{ $data['current_filter'] == 'bulan' ? 'selected' : '' }}>Bulan</option>
                </select>
            </div>
            
            <!-- Container Grafik -->
            <div class="flex-grow relative min-h-[300px]">
                <canvas id="kunjunganChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>

            <!-- Legend di bawah grafik -->
            <div class="flex justify-center mt-4 gap-6 text-sm pt-2">
                <div class="flex items-center">
                    <div class="w-8 h-0.5 bg-blue-500 mr-2"></div>
                    <span class="text-gray-600">Rawat Inap</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-0.5 bg-green-500 mr-2"></div>
                    <span class="text-gray-600">Rawat Jalan</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-0.5 bg-red-500 mr-2"></div>
                    <span class="text-gray-600">IGD</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('kunjunganChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'line',
        data: @json($data['chart_data']),
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: '#f0f0f0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Handle resize
    new ResizeObserver(() => {
        chart.resize();
    }).observe(ctx.canvas);
});
</script>
@endpush

@php
    \Log::info('Data di View:', [
        'rawat_inap' => $data['rawat_inap'] ?? 'tidak ada data'
    ]);
@endphp
@endsection