@extends('layouts.app')

@section('title', 'Dashboard Keuangan')
@section('header', 'Dashboard Keuangan')

@section('content')
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
            <i class='bx bx-credit-card text-2xl text-blue-500'></i>
        </div>
        <div class="space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-600">Total Piutang</span>
                <span class="font-semibold">Rp {{ number_format($data['piutang']['total'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Jatuh Tempo</span>
                <span class="font-semibold">Rp {{ number_format($data['piutang']['jatuh_tempo'], 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Lunas</span>
                <span class="font-semibold">Rp {{ number_format($data['piutang']['lunas'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Transaksi Terakhir -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Transaksi Terakhir</h3>
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
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaksi['tanggal'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaksi['keterangan'] }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($transaksi['jumlah'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $transaksi['tipe'] == 'masuk' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($transaksi['tipe']) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 