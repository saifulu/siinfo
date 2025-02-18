@extends('layouts.app')

@section('title', 'Settings')

@section('header', 'Settings')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="max-w-xl">
        <form action="{{ route('settings.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Akun</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="name" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ auth()->user()->name }}">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                               value="{{ auth()->user()->email }}">
                    </div>

                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700">Password Saat Ini</label>
                        <input type="password" name="current_password" id="current_password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" name="new_password" id="new_password" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="pt-5">
                <div class="flex justify-end">
                    <button type="submit" 
                            class="ml-3 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection 