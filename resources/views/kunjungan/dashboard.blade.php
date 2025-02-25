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
                            <p class="text-xs text-gray-500">Update terakhir: {{ $data['update_time'] }}</p>
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
                    <div class="flex items-center gap-1">
                        <i class='bx bx-trending-up text-green-500'></i>
                        <span class="text-gray-600">vs kemarin</span>
                        <span class="text-green-500 font-medium">+12.5%</span>
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
                            <p class="text-xs text-gray-500">Update terakhir: {{ $data['update_time'] }}</p>
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
                    <div class="flex items-center gap-1">
                        <i class='bx bx-trending-up text-green-500'></i>
                        <span class="text-gray-600">vs kemarin</span>
                        <span class="text-green-500 font-medium">+12.5%</span>
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
                            <p class="text-xs text-gray-500">Update terakhir: {{ $data['update_time'] }}</p>
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
                    <div class="flex items-center gap-1">
                        <i class='bx bx-trending-up text-green-500'></i>
                        <span class="text-gray-600">vs kemarin</span>
                        <span class="text-green-500 font-medium">+12.5%</span>
                    </div>
                    <a href="{{ route('kunjungan.igd') }}" 
                       class="text-red-600 hover:text-red-700 font-medium">
                        Lihat Detail →
                    </a>
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