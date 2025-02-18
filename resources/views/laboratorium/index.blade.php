@extends('layouts.app')

@section('title', 'Laporan Laboratorium')
@section('header', 'Laporan Laboratorium')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <!-- Total Pemeriksaan Hari Ini -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pemeriksaan Hari Ini</h3>
            <i class='bx bx-test-tube text-2xl text-blue-500'></i>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $data['pemeriksaan_hari_ini'] }}</div>
        <p class="text-gray-600">Pemeriksaan</p>
    </div>

    <!-- Grafik Jenis Pemeriksaan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Distribusi Pemeriksaan</h3>
            <i class='bx bx-pie-chart-alt-2 text-2xl text-purple-500'></i>
        </div>
        <canvas id="jenisPemeriksaanChart"></canvas>
    </div>
</div>

<!-- Tabel Detail Pemeriksaan -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4">Detail Pemeriksaan</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Pemeriksaan</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Persentase</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data['jenis_pemeriksaan'] as $jenis => $jumlah)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $jenis }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $jumlah }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ number_format(($jumlah / array_sum($data['jenis_pemeriksaan'])) * 100, 1) }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function(event) {
    const menuButton = document.querySelector('button');
    const sidebar = document.querySelector('aside');
    
    menuButton.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');
    });

    // Grafik Jenis Pemeriksaan
    const ctx = document.getElementById('jenisPemeriksaanChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: Object.keys({{ Js::from($data['jenis_pemeriksaan']) }}),
            datasets: [{
                data: Object.values({{ Js::from($data['jenis_pemeriksaan']) }}),
                backgroundColor: [
                    '#4F46E5',
                    '#10B981',
                    '#F59E0B',
                    '#EF4444'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
});
</script>
@endpush 