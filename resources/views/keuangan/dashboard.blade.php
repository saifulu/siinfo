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

    <!-- Grid Container untuk List dan Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- List Daftar Saldo Akhir -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100/50 backdrop-blur-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Saldo Akhir</h3>
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        <i class='bx bx-calendar'></i>
                        <span>{{ now()->format('d M Y') }}</span>
                    </div>
                </div>
                <!-- ... content saldo ... -->
            </div>
        </div>

        <!-- Grafik Laba Rugi -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100/50 backdrop-blur-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Grafik Laba Rugi</h3>
                    <select class="rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500"
                            id="filterLabaRugi"
                            onchange="updateLabaRugiChart(this.value)">
                        <option value="hari" {{ request('filter', 'hari') == 'hari' ? 'selected' : '' }}>Hari Ini</option>
                        <option value="minggu" {{ request('filter') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan" {{ request('filter') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                    </select>
                </div>
                <div class="h-[200px]">
                    <canvas id="arusKasChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Container untuk Arus Kas dan Saldo Kas -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Grafik Arus Kas -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100/50 backdrop-blur-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">Grafik Arus Kas</h3>
                    <select class="rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500"
                            id="filterArusKas"
                            onchange="updateArusKasChart(this.value)">
                        <option value="hari">Hari Ini</option>
                        <option value="minggu">Minggu Ini</option>
                        <option value="bulan">Bulan Ini</option>
                    </select>
                </div>
                <div class="h-[200px]">
                    <canvas id="labaRugiChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Saldo Kas -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100/50 backdrop-blur-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Saldo Kas</h3>
                        <p class="text-sm text-gray-500">Per {{ date('d F Y') }}</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-refresh text-xl'></i>
                    </button>
                </div>
                
                @if(empty($data['biaya'] ?? []))
                    <div class="flex flex-col items-center justify-center py-8">
                        <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="w-32 h-32 mb-4 opacity-75">
                        <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                        <p class="text-sm text-gray-400 text-center">Belum ada data saldo kas</p>
                    </div>
                @else
                    <div class="space-y-2">
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
    </div>

    <!-- Grid Container untuk Hutang dan Biaya -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Hutang -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100/50 backdrop-blur-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Hutang</h3>
                        <p class="text-sm text-gray-500">Per {{ date('d F Y') }}</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <i class='bx bx-refresh text-xl'></i>
                    </button>
                </div>

                @if(empty($data['hutang'] ?? []))
                    <div class="flex flex-col items-center justify-center py-8">
                        <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="w-32 h-32 mb-4 opacity-75">
                        <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                        <p class="text-sm text-gray-400 text-center">Belum ada data hutang</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($data['hutang'] as $hutang)
                        <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <span class="text-sm text-gray-600">{{ $hutang['akun'] }}</span>
                            <span class="text-sm font-medium">Rp {{ number_format($hutang['saldo'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Biaya -->
        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100/50 backdrop-blur-sm">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Biaya</h3>
                        <p class="text-sm text-gray-500">{{ date('d F Y') }}</p>
                    </div>
                    <select class="rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option>Hari</option>
                        <option>Minggu</option>
                        <option>Bulan</option>
                    </select>
                </div>

                @if(empty($data['biaya'] ?? []))
                    <div class="flex flex-col items-center justify-center py-8">
                        <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="w-32 h-32 mb-4 opacity-75">
                        <p class="text-gray-500 font-medium">Data tidak tersedia</p>
                        <p class="text-sm text-gray-400 text-center">Belum ada data biaya</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($data['biaya'] as $biaya)
                        <div class="flex justify-between items-center p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <span class="text-sm text-gray-600">{{ $biaya['nama'] }}</span>
                            <span class="text-sm font-medium">Rp {{ number_format($biaya['jumlah'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                @endif
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
    const arusKasData = @json($data['arus_kas_chart']);
    new Chart(arusKasCtx, {
        type: 'line',
        data: arusKasData,
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

// Fungsi untuk update chart arus kas
function updateArusKasChart(filter) {
    fetch(`/keuangan/arus-kas?filter=${filter}`)
        .then(response => response.json())
        .then(data => {
            arusKasChart.data = data;
            arusKasChart.update();
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Inisialisasi chart arus kas
const arusKasCtx = document.getElementById('arusKasChart').getContext('2d');
let arusKasChart = new Chart(arusKasCtx, {
    type: 'line',
    data: @json($data['arus_kas_chart']),
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

// Tambahkan event listener untuk filter
document.getElementById('filterArusKas').addEventListener('change', function() {
    updateArusKasChart(this.value);
});

// Inisialisasi chart laba rugi
const labaRugiCtx = document.getElementById('labaRugiChart').getContext('2d');
const labaRugiData = @json($data['chart_data']);
let labaRugiChart = new Chart(labaRugiCtx, {
    type: 'line',
    data: labaRugiData,
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

// Fungsi untuk update chart laba rugi
function updateLabaRugiChart(filter) {
    window.location.href = '?filter=' + filter;
}
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