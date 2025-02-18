@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'D001')

@section('content')
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-gray-500 text-sm">Pasien Rawat Inap</h3>
        <div class="text-3xl font-bold my-2">{{ $data['rawatInap'] }}</div>
        <p class="text-gray-600 text-sm">Total pasien dirawat saat ini</p>
        <div class="mt-4">
            <canvas id="rawatInapChart"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-gray-500 text-sm">Pasien Pulang</h3>
        <div class="text-3xl font-bold my-2">{{ $data['pasienPulang'] }}</div>
        <p class="text-gray-600 text-sm">Pasien pulang hari ini</p>
        <div class="mt-4">
            <canvas id="pasienPulangChart"></canvas>
        </div>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-gray-500 text-sm">Pasien Masuk</h3>
        <div class="text-3xl font-bold my-2">{{ $data['pasienMasuk'] }}</div>
        <p class="text-gray-600 text-sm">Pasien masuk hari ini</p>
        <div class="mt-4">
            <canvas id="pasienMasukChart"></canvas>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="grid grid-cols-1 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Surveilans Infeksi Hari Ini</h3>
        <canvas id="surveilansChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 gap-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Alat Terpasang Hari Ini</h3>
        <canvas id="alatChart"></canvas>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function(event) {
    // Grafik Surveilans
    const surveilansCtx = document.getElementById('surveilansChart').getContext('2d');
    new Chart(surveilansCtx, {
        type: 'bar',
        data: {
            labels: ['IAD', 'PLEB', 'ISK', 'ILO', 'HAP'],
            datasets: [{
                label: 'Jumlah Kasus',
                data: Object.values({{ Js::from($data['surveilans']) }}),
                backgroundColor: '#4F46E5'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Grafik Alat Terpasang
    const alatCtx = document.getElementById('alatChart').getContext('2d');
    new Chart(alatCtx, {
        type: 'bar',
        data: {
            labels: ['ETT', 'CVL', 'IVL', 'UC'],
            datasets: [{
                label: 'Jumlah Alat',
                data: Object.values({{ Js::from($data['alatTerpasang']) }}),
                backgroundColor: [
                    '#EF4444',
                    '#4F46E5',
                    '#F59E0B',
                    '#10B981'
                ]
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Line charts
    const createLineChart = (elementId, label, data) => {
        const ctx = document.getElementById(elementId).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: label,
                    data: data,
                    borderColor: '#4F46E5',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
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
                        }
                    }
                }
            }
        });
    };

    createLineChart('rawatInapChart', 'Trend', [1, 2, 1, 1, 2, 1]);
    createLineChart('pasienPulangChart', 'Trend', [0, 1, 0, 1, 0, 0]);
    createLineChart('pasienMasukChart', 'Trend', [1, 0, 1, 0, 1, 0]);
});
</script>
@endpush 