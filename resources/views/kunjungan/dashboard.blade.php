@extends('layouts.app')

@section('title', 'Dashboard Kunjungan')
@section('header', 'Dashboard Kunjungan')

@section('content')
<!-- Cards Utama -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Rawat Inap Card -->
    <div class="bg-gradient-to-br from-blue-50 via-white to-blue-100 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 rounded-xl shadow-md p-4 border border-blue-100">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-blue-800">Rawat Inap</h3>
            <div class="p-1.5 bg-blue-100 rounded-lg">
                <i class='bx bx-bed text-xl text-blue-600'></i>
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between items-center p-1.5 hover:bg-blue-50 rounded-lg transition-colors">
                <span class="text-blue-700 font-medium">Total Pasien</span>
                <span class="font-bold text-blue-900">{{ number_format($data['rawat_inap']['total_pasien']) }}</span>
            </div>
            <div class="flex justify-between items-center p-1.5 hover:bg-blue-50 rounded-lg transition-colors">
                <span class="text-blue-700 font-medium">Pasien Masuk</span>
                <span class="font-bold text-blue-900">{{ number_format($data['rawat_inap']['pasien_masuk']) }}</span>
            </div>
            <div class="flex justify-between items-center p-1.5 hover:bg-blue-50 rounded-lg transition-colors">
                <span class="text-blue-700 font-medium">Pasien Keluar</span>
                <span class="font-bold text-blue-900">{{ number_format($data['rawat_inap']['pasien_keluar']) }}</span>
            </div>
        </div>
    </div>

    <!-- Rawat Jalan Card -->
    <div class="bg-gradient-to-br from-green-50 via-white to-green-100 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 rounded-xl shadow-md p-4 border border-green-100">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-green-800">Rawat Jalan</h3>
            <div class="p-1.5 bg-green-100 rounded-lg">
                <i class='bx bx-walk text-xl text-green-600'></i>
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between items-center p-1.5 hover:bg-green-50 rounded-lg transition-colors">
                <span class="text-green-700 font-medium">Total Kunjungan</span>
                <span class="font-bold text-green-900">{{ number_format($data['rawat_jalan']['total_kunjungan']) }}</span>
            </div>
            <div class="flex justify-between items-center p-1.5 hover:bg-green-50 rounded-lg transition-colors">
                <span class="text-green-700 font-medium">Pasien Baru</span>
                <span class="font-bold text-green-900">{{ number_format($data['rawat_jalan']['pasien_baru']) }}</span>
            </div>
            <div class="flex justify-between items-center p-1.5 hover:bg-green-50 rounded-lg transition-colors">
                <span class="text-green-700 font-medium">Pasien Lama</span>
                <span class="font-bold text-green-900">{{ number_format($data['rawat_jalan']['pasien_lama']) }}</span>
            </div>
        </div>
    </div>

    <!-- IGD Card -->
    <div class="bg-gradient-to-br from-red-50 via-white to-red-100 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-300 rounded-xl shadow-md p-4 border border-red-100">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-red-800">IGD</h3>
            <div class="p-1.5 bg-red-100 rounded-lg">
                <i class='bx bx-plus-medical text-xl text-red-600'></i>
            </div>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between items-center p-1.5 hover:bg-red-50 rounded-lg transition-colors">
                <span class="text-red-700 font-medium">Total Kunjungan</span>
                <span class="font-bold text-red-900">{{ number_format($data['igd']['total_kunjungan']) }}</span>
            </div>
            <div class="flex justify-between items-center p-1.5 hover:bg-red-50 rounded-lg transition-colors">
                <span class="text-red-700 font-medium">Lanjut Rawat Inap</span>
                <span class="font-bold text-red-900">{{ number_format($data['igd']['kasus_darurat']) }}</span>
            </div>
            <div class="flex justify-between items-center p-1.5 hover:bg-red-50 rounded-lg transition-colors">
                <span class="text-red-700 font-medium">Pasien Pulang</span>
                <span class="font-bold text-red-900">{{ number_format($data['igd']['kasus_non_darurat']) }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Kunjungan -->
<div class="bg-white hover:bg-gray-50 transition-colors duration-300 rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Tren Kunjungan</h3>
        <select id="filterTren" class="rounded-md border-gray-300 text-sm px-3 py-1" 
                onchange="window.location.href='?filter=' + this.value">
            <option value="hari" {{ $data['current_filter'] == 'hari' ? 'selected' : '' }}>Hari</option>
            <option value="minggu" {{ $data['current_filter'] == 'minggu' ? 'selected' : '' }}>Minggu</option>
            <option value="bulan" {{ $data['current_filter'] == 'bulan' ? 'selected' : '' }}>Bulan</option>
        </select>
    </div>
    
    <!-- Grafik -->
    <div class="h-64">
        <canvas id="kunjunganChart"></canvas>
    </div>

    <!-- Legend di bawah grafik -->
    <div class="flex justify-center mt-4 gap-6 text-sm">
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

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kunjunganCtx = document.getElementById('kunjunganChart').getContext('2d');
    new Chart(kunjunganCtx, {
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
});
</script>
@endpush 