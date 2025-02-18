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
            <!-- Page ID -->
            <div class="text-right text-gray-600 mb-4">
                D001
            </div>

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">@yield('header')</h1>
            </div>

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html> 