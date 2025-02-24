<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="min-h-screen bg-gray-50">
    <!-- Top Navigation Bar -->
    @include('layouts.topnav')
    
    <!-- Sidebar -->
    @include('layouts.sidebar')
    
    <!-- Main Content -->
    <main class="p-4 transition-all duration-300 md:ml-64">
        @yield('content')
    </main>

    <!-- Script untuk toggle sidebar -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Ambil elemen yang diperlukan
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.querySelector('aside');
        
        if (sidebarToggle && sidebar) {
            // Event listener untuk toggle button
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('-translate-x-full');
            });

            // Tambahkan event listener untuk menutup sidebar saat klik di luar
            document.addEventListener('click', function(event) {
                const isClickInsideSidebar = sidebar.contains(event.target);
                const isClickInsideToggle = sidebarToggle.contains(event.target);
                
                if (!isClickInsideSidebar && !isClickInsideToggle && !sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            });
        }
    });
    </script>

    @stack('scripts')
</body>
</html> 