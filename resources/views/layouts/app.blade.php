<!DOCTYPE html>
<html>
<head>
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
    <!-- Top Navigation Bar -->
    @include('layouts.topnav')
    
    <!-- Sidebar -->
    @include('layouts.sidebar')
    
    <!-- Main Content -->
    <div class="sm:ml-64">
        <div class="p-4">
            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">@yield('header')</h1>
            </div>

            @yield('content')
        </div>
    </div>

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