@extends('layouts.app')

@section('title', 'Profile')

@section('header', 'Profile')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="max-w-xl">
        <div class="flex items-center space-x-4 mb-6">
            <div class="bg-indigo-100 p-3 rounded-full">
                <i class='bx bx-user text-3xl text-indigo-600'></i>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ auth()->user()->name }}</h2>
                <p class="text-gray-600">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div class="border-t pt-4">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Informasi Pengguna</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <p class="mt-1 text-gray-900">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-gray-900">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <p class="mt-1 text-gray-900">{{ auth()->user()->role ?? 'User' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bergabung Sejak</label>
                        <p class="mt-1 text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 