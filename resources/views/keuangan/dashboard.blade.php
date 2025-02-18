@extends('layouts.app')

@section('title', 'Dashboard Keuangan')
@section('header', 'Dashboard Keuangan')

@section('content')
<!-- Cards Utama -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Pendapatan -->
    <div class="bg-white hover:bg-green-50 transition-colors duration-300 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pendapatan</h3>
            <i class='bx bx-trending-up text-2xl text-green-500'></i>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Hari Ini</span>
                <span class="font-semibold">Rp {{ number_format($data['pendapatan']['hari_ini'] ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Bulan Ini</span>
                <span class="font-semibold">Rp {{ number_format($data['pendapatan']['bulan_ini'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Tahun Ini</span>
                <span class="font-semibold">Rp {{ number_format($data['pendapatan']['tahun_ini'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Pengeluaran -->
    <div class="bg-white hover:bg-red-50 transition-colors duration-300 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Pengeluaran</h3>
            <i class='bx bx-trending-down text-2xl text-red-500'></i>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Hari Ini</span>
                <span class="font-semibold">Rp {{ number_format($data['pengeluaran']['hari_ini'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Bulan Ini</span>
                <span class="font-semibold">Rp {{ number_format($data['pengeluaran']['bulan_ini'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Tahun Ini</span>
                <span class="font-semibold">Rp {{ number_format($data['pengeluaran']['tahun_ini'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Piutang -->
    <div class="bg-white hover:bg-blue-50 transition-colors duration-300 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Piutang</h3>
            <i class='bx bx-wallet text-2xl text-blue-500'></i>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Piutang</span>
                <span class="font-semibold">Rp {{ number_format($data['piutang']['total'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Jatuh Tempo</span>
                <span class="font-semibold text-red-500">Rp {{ number_format($data['piutang']['jatuh_tempo'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Lunas</span>
                <span class="font-semibold text-green-500">Rp {{ number_format($data['piutang']['lunas'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Grafik Laba Rugi -->
<div class="bg-white hover:bg-gray-50 transition-colors duration-300 rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Laba Rugi</h3>
        <select class="rounded-md border-gray-300 text-sm px-3 py-1">
            <option>Hari</option>
        </select>
    </div>
    
    <!-- Legend -->
    <div class="flex items-center gap-4 mb-4 text-sm">
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
            <span>Laba Bersih</span>
        </div>
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></div>
            <span>Total Beban</span>
        </div>
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
            <span>Total Pendapatan (setelah dikurangi promo & HPP)</span>
        </div>
    </div>

    <!-- Grafik -->
    <div class="h-64">
        <canvas id="labaRugiChart"></canvas>
    </div>
</div>

<!-- Grafik Arus Kas -->
<div class="bg-white hover:bg-gray-50 transition-colors duration-300 rounded-lg shadow-md p-6 mt-6">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-semibold text-gray-800">Arus Kas</h3>
        <select class="rounded-md border-gray-300 text-sm px-3 py-1">
            <option>Hari</option>
        </select>
    </div>
    
    <!-- Legend -->
    <div class="flex items-center gap-4 mb-4 text-sm">
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-green-500 mr-2"></div>
            <span>Saldo Keseluruhan</span>
        </div>
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-red-500 mr-2"></div>
            <span>Saldo Kas Keluar</span>
        </div>
        <div class="flex items-center">
            <div class="w-2 h-2 rounded-full bg-blue-500 mr-2"></div>
            <span>Saldo Kas Masuk</span>
        </div>
    </div>

    <!-- Grafik -->
    <div class="h-64">
        <canvas id="arusKasChart"></canvas>
    </div>
</div>

<!-- Setelah grafik Arus Kas -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
    <!-- Saldo Kas -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Saldo Kas</h3>
                <p class="text-sm text-gray-500">Per {{ date('d F Y') }}</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <i class='bx bx-refresh text-xl'></i>
            </button>
        </div>

        <!-- Header Tabel -->
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg mt-4">
            <span class="text-sm font-medium text-gray-600">AKUN</span>
            <span class="text-sm font-medium text-gray-600">SALDO</span>
        </div>

        @if(empty($data['saldo_kas'] ?? []))
            <!-- Tampilan jika data kosong -->
            <div class="flex flex-col items-center justify-center py-8">
                <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="w-32 h-32 mb-4 opacity-75">
                <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                <p class="text-sm text-gray-400 text-center">
                    Belum ada data yang dapat ditampilkan di halaman ini
                </p>
            </div>
        @else
            <!-- Tampilan jika ada data -->
            <div class="space-y-2 mt-2">
                @foreach($data['saldo_kas'] as $saldo)
                <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">{{ $saldo['akun'] }}</span>
                    <span class="text-sm font-medium">Rp {{ number_format($saldo['saldo'], 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Neraca -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Neraca</h3>
                <p class="text-sm text-gray-500">Per {{ date('d F Y') }}</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <i class='bx bx-refresh text-xl'></i>
            </button>
        </div>

        <div class="space-y-6 mt-4">
            <!-- Aset -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Aset</span>
                    <span class="text-sm font-medium">Rp 0</span>
                </div>
                <div class="w-full h-1 bg-green-100 rounded-full">
                    <div class="w-full h-full bg-green-500 rounded-full"></div>
                </div>
            </div>

            <!-- Liabilitas -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Liabilitas</span>
                    <span class="text-sm font-medium">Rp 0</span>
                </div>
                <div class="w-full h-1 bg-blue-100 rounded-full">
                    <div class="w-full h-full bg-blue-500 rounded-full"></div>
                </div>
            </div>

            <!-- Modal -->
            <div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Modal</span>
                    <span class="text-sm font-medium">Rp 0</span>
                </div>
                <div class="w-full h-1 bg-purple-100 rounded-full">
                    <div class="w-full h-full bg-purple-500 rounded-full"></div>
                </div>
            </div>
        </div>

        <p class="text-xs text-gray-500 mt-6">
            Terakhir update: {{ date('d F Y H:i') }}
        </p>
    </div>
</div>

<!-- Setelah grid Saldo Kas -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">
    <!-- Hutang -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Hutang</h3>
                <p class="text-sm text-gray-500">Per {{ date('d F Y') }}</p>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <i class='bx bx-refresh text-xl'></i>
            </button>
        </div>

        <!-- Header Tabel -->
        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg mt-4">
            <span class="text-sm font-medium text-gray-600">AKUN</span>
            <span class="text-sm font-medium text-gray-600">SALDO</span>
        </div>

        @if(empty($data['hutang'] ?? []))
            <!-- Tampilan jika data kosong -->
            <div class="flex flex-col items-center justify-center py-8">
                <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="w-32 h-32 mb-4 opacity-75">
                <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                <p class="text-sm text-gray-400 text-center">
                    Belum ada data yang dapat ditampilkan di halaman ini
                </p>
            </div>
        @else
            <!-- Tampilan jika ada data -->
            <div class="space-y-2 mt-2">
                @foreach($data['hutang'] as $hutang)
                <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">{{ $hutang['akun'] }}</span>
                    <span class="text-sm font-medium">Rp {{ number_format($hutang['saldo'], 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Biaya -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h3 class="text-lg font-semibold text-gray-800">Biaya</h3>
                <p class="text-sm text-gray-500">{{ date('d F Y') }}</p>
            </div>
            <select class="rounded-md border-gray-300 text-sm px-3 py-1">
                <option>Hari</option>
            </select>
        </div>

        @if(empty($data['biaya'] ?? []))
            <!-- Tampilan jika data kosong -->
            <div class="flex flex-col items-center justify-center py-8">
                <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="w-32 h-32 mb-4 opacity-75">
                <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                <p class="text-sm text-gray-400 text-center">
                    Belum ada biaya yang dikeluarkan di periode ini
                </p>
            </div>
        @else
            <!-- Tampilan jika ada data -->
            <div class="space-y-2 mt-4">
                @foreach($data['biaya'] as $biaya)
                <div class="flex justify-between items-center p-2 hover:bg-gray-50 rounded-lg">
                    <span class="text-sm text-gray-600">{{ $biaya['nama'] }}</span>
                    <span class="text-sm font-medium">Rp {{ number_format($biaya['jumlah'], 0, ',', '.') }}</span>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const labaRugiCtx = document.getElementById('labaRugiChart').getContext('2d');
    new Chart(labaRugiCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: 27}, (_, i) => i + 1),
            datasets: [{
                label: 'Laba Bersih',
                data: Array(27).fill(0),
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4
            }, {
                label: 'Total Beban',
                data: Array(27).fill(0),
                borderColor: 'rgb(234, 179, 8)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4
            }, {
                label: 'Total Pendapatan',
                data: Array(27).fill(0),
                borderColor: 'rgb(59, 130, 246)',
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
                        stepSize: 0.5
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

    // Tambahkan script untuk Arus Kas
    const arusKasCtx = document.getElementById('arusKasChart').getContext('2d');
    new Chart(arusKasCtx, {
        type: 'line',
        data: {
            labels: Array.from({length: 27}, (_, i) => i + 1),
            datasets: [{
                label: 'Saldo Keseluruhan',
                data: Array(27).fill(0),
                borderColor: 'rgb(34, 197, 94)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4
            }, {
                label: 'Saldo Kas Keluar',
                data: Array(27).fill(0),
                borderColor: 'rgb(239, 68, 68)',
                borderWidth: 1.5,
                pointRadius: 0,
                tension: 0.4
            }, {
                label: 'Saldo Kas Masuk',
                data: Array(27).fill(0),
                borderColor: 'rgb(59, 130, 246)',
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
                        stepSize: 0.5
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