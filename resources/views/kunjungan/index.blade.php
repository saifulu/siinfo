@extends('layouts.app')

@section('title', 'Laporan Kunjungan')
@section('header', 'Laporan Kunjungan')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Kunjungan Hari Ini</h3>
        <i class='bx bx-group text-2xl text-blue-500'></i>
    </div>
    <div class="text-3xl font-bold mb-2">{{ $data['kunjungan_hari_ini'] }}</div>
    <p class="text-gray-600">Pasien</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
    <!-- Rata-rata Kunjungan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Rata-rata Kunjungan</h3>
            <i class='bx bx-line-chart text-2xl text-green-500'></i>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $data['rata_rata_kunjungan'] }}</div>
        <p class="text-gray-600">Pasien per hari</p>
    </div>

    <!-- Total Kunjungan Bulan Ini -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Total Kunjungan Bulan Ini</h3>
            <i class='bx bx-calendar text-2xl text-purple-500'></i>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $data['total_kunjungan_bulan'] }}</div>
        <p class="text-gray-600">Pasien</p>
    </div>

    <!-- Jenis Kunjungan -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Jenis Kunjungan</h3>
        <div class="space-y-3">
            @foreach($data['jenis_kunjungan'] as $jenis => $jumlah)
            <div class="flex justify-between items-center">
                <span class="text-gray-600">{{ $jenis }}</span>
                <span class="font-semibold">{{ $jumlah }} Pasien</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Grafik Jenis Kunjungan -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4">Jenis Kunjungan</h3>
    <canvas id="jenisKunjunganChart"></canvas>
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

    // Grafik Jenis Kunjungan
    const ctx = document.getElementById('jenisKunjunganChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: Object.keys({{ Js::from($data['jenis_kunjungan']) }}),
            datasets: [{
                data: Object.values({{ Js::from($data['jenis_kunjungan']) }}),
                backgroundColor: [
                    '#4F46E5',
                    '#10B981',
                    '#F59E0B'
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