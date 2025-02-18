@extends('layouts.app')

@section('title', 'Laporan Obat')
@section('header', 'Laporan Obat')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <!-- Total Stok -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Total Stok</h3>
            <i class='bx bx-package text-2xl text-blue-500'></i>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $data['stok_obat']['total'] }}</div>
        <p class="text-gray-600">Item</p>
    </div>

    <!-- Hampir Habis -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Hampir Habis</h3>
            <i class='bx bx-error text-2xl text-yellow-500'></i>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $data['stok_obat']['hampir_habis'] }}</div>
        <p class="text-gray-600">Item</p>
    </div>

    <!-- Kadaluarsa -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Kadaluarsa</h3>
            <i class='bx bx-x-circle text-2xl text-red-500'></i>
        </div>
        <div class="text-3xl font-bold mb-2">{{ $data['stok_obat']['kadaluarsa'] }}</div>
        <p class="text-gray-600">Item</p>
    </div>
</div>

<!-- Tabel Obat Terlaris -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold mb-4">Obat Terlaris</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Terjual</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($data['obat_terlaris'] as $obat)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $obat['nama'] }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        {{ $obat['jumlah'] }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection 