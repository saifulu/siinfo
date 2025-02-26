@extends('layouts.app')

@section('title', 'Dashboard Keuangan')
@section('header', 'Dashboard Keuangan')

@section('content')
<div class="flex flex-col h-[calc(100vh-5rem)] gap-3">
    <!-- Cards Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        <!-- Card Pendapatan -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-300/80 via-emerald-100/50 to-teal-200/60"></div>
            <div class="absolute inset-0 bg-[linear-gradient(110deg,transparent_0.8px,#ffffff10_0.8px),linear-gradient(-110deg,transparent_0.8px,#ffffff20_0.8px)] bg-[length:10px_10px]"></div>
            <div class="absolute inset-0 bg-gradient-to-tr from-emerald-400/10 via-transparent to-teal-300/10"></div>
            <div class="relative p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="p-3.5 bg-gradient-to-br from-emerald-500 via-emerald-600 to-teal-600 shadow-lg rounded-xl flex items-center justify-center ring-2 ring-emerald-400/20">
                            <i class='bx bxs-dollar-circle text-2xl text-emerald-100'></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Pendapatan</h2>
                            <div class="flex items-center gap-2 text-xs">
                                <i class='bx bx-refresh text-gray-500'></i>
                                <span class="text-gray-500">Update: {{ now()->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <i class='bx bxs-trending-up text-emerald-600 text-xl sm:text-2xl opacity-80'></i>
                </div>
                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Hari Ini</span>
                        <span class="text-base sm:text-lg font-semibold text-green-600">Rp {{ number_format($data['pendapatan_hari'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Bulan Ini</span>
                        <span class="text-base sm:text-lg font-semibold">Rp {{ number_format($data['pendapatan_bulan'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Tahun Ini</span>
                        <span class="text-base sm:text-lg font-semibold">Rp {{ number_format($data['pendapatan_tahun'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Pengeluaran -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-rose-300/80 via-rose-100/50 to-pink-200/60"></div>
            <div class="absolute inset-0 bg-[linear-gradient(110deg,transparent_0.8px,#ffffff10_0.8px),linear-gradient(-110deg,transparent_0.8px,#ffffff20_0.8px)] bg-[length:10px_10px]"></div>
            <div class="absolute inset-0 bg-gradient-to-tr from-rose-400/10 via-transparent to-pink-300/10"></div>
            <div class="relative p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="p-3.5 bg-gradient-to-br from-rose-500 via-rose-600 to-pink-600 shadow-lg rounded-xl flex items-center justify-center ring-2 ring-rose-400/20">
                            <i class='bx bxs-wallet text-2xl text-rose-100'></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Pengeluaran</h2>
                            <div class="flex items-center gap-2 text-xs">
                                <i class='bx bx-refresh text-gray-500'></i>
                                <span class="text-gray-500">Update: {{ now()->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <i class='bx bxs-trending-down text-rose-600 text-xl sm:text-2xl opacity-80'></i>
                </div>
                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Hari Ini</span>
                        <span class="text-base sm:text-lg font-semibold text-red-600">Rp {{ number_format($data['pengeluaran_hari'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Bulan Ini</span>
                        <span class="text-base sm:text-lg font-semibold">Rp {{ number_format($data['pengeluaran_bulan'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Tahun Ini</span>
                        <span class="text-base sm:text-lg font-semibold">Rp {{ number_format($data['pengeluaran_tahun'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Piutang -->
        <div class="relative overflow-hidden bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-300/80 via-violet-100/50 to-purple-200/60"></div>
            <div class="absolute inset-0 bg-[linear-gradient(110deg,transparent_0.8px,#ffffff10_0.8px),linear-gradient(-110deg,transparent_0.8px,#ffffff20_0.8px)] bg-[length:10px_10px]"></div>
            <div class="absolute inset-0 bg-gradient-to-tr from-violet-400/10 via-transparent to-purple-300/10"></div>
            <div class="relative p-4">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="p-3.5 bg-gradient-to-br from-violet-500 via-violet-600 to-purple-600 shadow-lg rounded-xl flex items-center justify-center ring-2 ring-violet-400/20">
                            <i class='bx bxs-credit-card text-2xl text-indigo-100'></i>
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-800">Piutang</h2>
                            <div class="flex items-center gap-2 text-xs">
                                <i class='bx bx-refresh text-gray-500'></i>
                                <span class="text-gray-500">Update: {{ now()->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                    <i class='bx bxs-wallet text-violet-600 text-xl sm:text-2xl opacity-80'></i>
                </div>
                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Total Piutang</span>
                        <span class="text-base sm:text-lg font-semibold text-blue-600">Rp {{ number_format($data['total_piutang'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Jatuh Tempo</span>
                        <span class="text-base sm:text-lg font-semibold text-red-600">Rp {{ number_format($data['piutang_jatuh_tempo'] ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-xs sm:text-sm text-gray-600">Lunas</span>
                        <span class="text-base sm:text-lg font-semibold text-green-600">Rp {{ number_format($data['piutang_lunas'] ?? 0) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Laba Rugi -->
    <div class="bg-white hover:bg-gray-50 transition-colors duration-300 rounded-lg shadow-md p-4 sm:p-6 flex-grow">
        <div class="flex flex-col h-full">
            <!-- Header Grafik -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-gray-800">Laba Rugi</h3>
                <select id="filterLabaRugi" 
                        class="select select-bordered select-sm w-32"
                        onchange="window.location.href='?filter=' + this.value">
                    <option value="hari" {{ request('filter', 'hari') == 'hari' ? 'selected' : '' }}>Hari</option>
                    <option value="minggu" {{ request('filter') == 'minggu' ? 'selected' : '' }}>Minggu</option>
                    <option value="bulan" {{ request('filter') == 'bulan' ? 'selected' : '' }}>Bulan</option>
                </select>
            </div>
            
            <!-- Container Grafik -->
            <div class="flex-grow relative min-h-[300px]">
                <canvas id="labaRugiChart" class="absolute inset-0 w-full h-full"></canvas>
            </div>

            <!-- Legend -->
            <div class="flex justify-center mt-4 gap-6 text-sm pt-2">
                <div class="flex items-center">
                    <div class="w-8 h-0.5 bg-green-500 mr-2"></div>
                    <span class="text-gray-600">Laba Bersih</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-0.5 bg-yellow-500 mr-2"></div>
                    <span class="text-gray-600">Total Beban</span>
                </div>
                <div class="flex items-center">
                    <div class="w-8 h-0.5 bg-blue-500 mr-2"></div>
                    <span class="text-gray-600">Total Pendapatan</span>
                </div>
            </div>
        </div>
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

<!-- Key Metrics Section -->
<div class="grid grid-cols-1 gap-6 mt-6">
    <!-- Header dengan Filter -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <h2 class="text-lg font-semibold text-gray-800">Key Metrics</h2>
            <span class="text-sm text-gray-500">Oct 01, 2024 - Dec 30, 2024</span>
        </div>
        <div class="flex items-center gap-2">
            <button class="px-3 py-1 text-sm font-medium text-gray-600 bg-white rounded-full hover:bg-gray-50">All</button>
            <button class="px-3 py-1 text-sm font-medium text-gray-600 bg-white rounded-full hover:bg-gray-50">7d</button>
            <button class="px-3 py-1 text-sm font-medium text-gray-600 bg-white rounded-full shadow-sm bg-gray-100">30d</button>
        </div>
    </div>

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200">
        <nav class="flex gap-8">
            <button class="px-1 py-4 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">
                Workplace Happiness Index
            </button>
            <button class="px-1 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                Absenteeism Overview
            </button>
            <button class="px-1 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                Employee Turnover Insights
            </button>
            <button class="px-1 py-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                Training Completion Rate
            </button>
        </nav>
    </div>

    <!-- Graph Section -->
    <div class="bg-white p-6 rounded-xl shadow-sm">
        <div class="h-[300px]">
            <canvas id="metricsChart"></canvas>
        </div>
    </div>

    <!-- Data Tables Section -->
    <div class="grid grid-cols-2 gap-6">
        <!-- Attendance Table -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800">Attendance</h3>
                <button class="p-2 text-gray-400 hover:text-gray-600">
                    <i class='bx bx-filter'></i>
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-xs text-gray-500">
                            <th class="pb-3">Employee</th>
                            <th class="pb-3">Employee ID</th>
                            <th class="pb-3">Job Title</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-t border-gray-100">
                            <td class="py-3">John Doe</td>
                            <td class="py-3">EMP001</td>
                            <td class="py-3">Developer</td>
                            <td class="py-3"><span class="px-2 py-1 text-xs text-green-700 bg-green-50 rounded-full">Active</span></td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Daily Time Limits -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-800">Daily Time Limits</h3>
                <button class="text-sm text-gray-500 hover:text-gray-700">See All</button>
            </div>
            <div class="space-y-4">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-gray-100"></div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Alex Hales</span>
                            <span class="text-sm text-gray-500">9:00 AM</span>
                        </div>
                        <span class="text-sm text-gray-500">10 Hour</span>
                    </div>
                </div>
                <!-- Add more items as needed -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('labaRugiChart').getContext('2d');
    const chartData = @json($data['chart_data']);
    
    const chart = new Chart(ctx, {
        type: 'line',
        data: chartData,
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
                        callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                        }
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

    // New Metrics Chart
    const metricsCtx = document.getElementById('metricsChart').getContext('2d');
    new Chart(metricsCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Actual',
                data: [10000, 15000, 8000, 20000, 25000, 20000, 25000],
                borderColor: 'rgb(99, 102, 241)',
                tension: 0.4,
                borderWidth: 2
            },
            {
                label: 'Target',
                data: [12000, 12000, 12000, 12000, 12000, 12000, 12000],
                borderColor: 'rgb(229, 231, 235)',
                borderDash: [5, 5],
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

<style>
/* Glassmorphism effect */
.glass-effect {
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* Custom shadows */
.custom-shadow {
    box-shadow: 
        0 10px 15px -3px rgba(0, 0, 0, 0.05),
        0 4px 6px -2px rgba(0, 0, 0, 0.025),
        inset 0 0 0 1px rgba(255, 255, 255, 0.1);
}

/* Gradient animations */
@keyframes gradient {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

.animate-gradient {
    animation: gradient 15s ease infinite;
    background-size: 200% 200%;
}

.card-hover {
    transition: all 0.3s ease;
}

.card-hover:hover {
    transform: translateY(-2px);
    box-shadow: 
        0 20px 25px -5px rgba(0, 0, 0, 0.1),
        0 8px 10px -6px rgba(0, 0, 0, 0.1),
        inset 0 0 0 1px rgba(255, 255, 255, 0.2);
}
</style> 