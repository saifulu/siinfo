@extends('layouts.app')

@section('title', 'Dashboard Kunjungan')
@section('header', 'Dashboard Kunjungan')

@section('content')
<!-- Cards Utama -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Rawat Inap -->
    <div class="bg-white hover:bg-blue-50 transition-colors duration-300 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rawat Inap</h3>
            <i class='bx bx-bed text-2xl text-blue-500'></i>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Pasien</span>
                <span class="font-semibold">{{ number_format($data['rawat_inap']['total_pasien']) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Pasien Masuk</span>
                <span class="font-semibold text-green-500">{{ number_format($data['rawat_inap']['pasien_masuk']) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Pasien Keluar</span>
                <span class="font-semibold text-red-500">{{ number_format($data['rawat_inap']['pasien_keluar']) }}</span>
            </div>
        </div>
    </div>

    <!-- Rawat Jalan -->
    <div class="bg-white hover:bg-green-50 transition-colors duration-300 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rawat Jalan</h3>
            <i class='bx bx-walk text-2xl text-green-500'></i>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Kunjungan</span>
                <span class="font-semibold">{{ number_format($data['rawat_jalan']['total_kunjungan']) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Pasien Baru</span>
                <span class="font-semibold text-blue-500">{{ number_format($data['rawat_jalan']['pasien_baru']) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Pasien Lama</span>
                <span class="font-semibold text-purple-500">{{ number_format($data['rawat_jalan']['pasien_lama']) }}</span>
            </div>
        </div>
    </div>

    <!-- IGD -->
    <div class="bg-white hover:bg-red-50 transition-colors duration-300 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">IGD</h3>
            <i class='bx bx-plus-medical text-2xl text-red-500'></i>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Kasus Gawat Darurat</span>
                <span class="font-semibold text-red-500">5</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Kasus Non-Darurat</span>
                <span class="font-semibold text-yellow-500">8</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Total Kunjungan</span>
                <span class="font-semibold">13</span>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Kunjungan -->
<div class="bg-white hover:bg-gray-50 transition-colors duration-300 rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Tren Kunjungan</h3>
        <select class="rounded-md border-gray-300 text-sm px-3 py-1">
            <option>Hari</option>
            <option>Minggu</option>
            <option>Bulan</option>
        </select>
    </div>
    
    <!-- Legend -->
    <div class="flex items-center gap-4 mb-4 text-sm">
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
            <span>Rawat Inap</span>
        </div>
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
            <span>Rawat Jalan</span>
        </div>
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
            <span>IGD</span>
        </div>
    </div>

    <!-- Grafik -->
    <div class="h-64">
        <canvas id="kunjunganChart"></canvas>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kunjunganCtx = document.getElementById('kunjunganChart').getContext('2d');
    new Chart(kunjunganCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: 27}, (_, i) => i + 1),
            datasets: [{
                label: 'Rawat Inap',
                data: Array(27).fill(0),
                borderColor: 'rgb(59, 130, 246)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4
            }, {
                label: 'Rawat Jalan',
                data: Array(27).fill(0),
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4
            }, {
                label: 'IGD',
                data: Array(27).fill(0),
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4
            }]
        },
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
                        stepSize: 5
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