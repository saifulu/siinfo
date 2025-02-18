<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan - SiHAI</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Sidebar - sama seperti di dashboard -->
    <aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
        <div class="h-full px-3 py-4 overflow-y-auto bg-indigo-700">
            <a href="#" class="flex items-center mb-5 pl-2.5">
                <i class='bx bx-layer text-white text-2xl'></i>
                <span class="ml-3 text-xl font-semibold text-white">SiHAI's</span>
            </a>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-grid-alt text-xl'></i>
                        <span class="ml-3">Dasbor</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.keuangan') }}" class="flex items-center p-2 text-white rounded-lg bg-indigo-600 group">
                        <i class='bx bx-money text-xl'></i>
                        <span class="ml-3">Laporan Keuangan</span>
                    </a>
                </li>
                <!-- Menu lainnya sama seperti di dashboard -->
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="p-4 sm:ml-64">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center">
                <button class="sm:hidden text-gray-600 hover:text-gray-900 mr-4">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
                <h1 class="text-2xl font-bold text-gray-800">Laporan Keuangan</h1>
            </div>
            <div class="text-gray-600">
                {{ Session::get('username') }}
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Pendapatan -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Pendapatan</h3>
                    <i class='bx bx-trending-up text-2xl text-green-500'></i>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Hari Ini</span>
                        <span class="font-semibold">Rp {{ number_format($data['pendapatan']['hari_ini'], 0, ',', '.') }}</span>
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
            <div class="bg-white rounded-lg shadow-md p-6">
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
            <div class="bg-white rounded-lg shadow-md p-6">
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

        <!-- Transaksi Terakhir -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">Transaksi Terakhir</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($data['transaksi_terakhir'] as $transaksi)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $transaksi['tanggal'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaksi['keterangan'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($transaksi['jumlah'], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaksi['tipe'] === 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($transaksi['tipe']) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const menuButton = document.querySelector('button');
            const sidebar = document.querySelector('aside');
            
            menuButton.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        });
    </script>
</body>
</html> 