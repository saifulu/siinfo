<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 bg-indigo-700">
    <!-- Logo dan Nama Aplikasi -->
    <div class="flex items-center gap-2 px-6 py-4 border-b border-indigo-600">
        <i class='bx bx-plus-medical text-2xl text-white'></i>
        <span class="text-lg font-semibold text-white">SiINFO</span>
    </div>

    <!-- Menu Container -->
    <div class="h-[calc(100vh-64px)] overflow-y-auto px-4">
        <!-- Menu Groups -->
        <div class="py-4 space-y-1">
            <!-- Dashboard -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-2.5 text-gray-300 rounded-lg hover:bg-indigo-600 group transition-all">
                    <i class='bx bx-grid-alt text-xl'></i>
                    <span class="ml-3 font-medium">Dashboard</span>
                </a>
            </div>

            @if(request()->is('kunjungan*'))
                <!-- Kunjungan Section -->
                <div class="space-y-1 pb-2">
                    <div class="px-4 py-2">
                        <span class="text-xs font-semibold text-indigo-300 uppercase tracking-wider">Kunjungan</span>
                    </div>

                    <a href="{{ route('kunjungan.dashboard') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-home text-xl'></i>
                        <span class="ml-3">Dashboard Kunjungan</span>
                    </a>

                    <a href="{{ route('kunjungan.rawatjalan') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-walk text-xl'></i>
                        <span class="ml-3">Rawat Jalan</span>
                    </a>

                    <a href="{{ route('kunjungan.rawatinap') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-bed text-xl'></i>
                        <span class="ml-3">Rawat Inap</span>
                    </a>

                    <a href="{{ route('kunjungan.igd') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-plus-medical text-xl'></i>
                        <span class="ml-3">IGD</span>
                    </a>

                    <a href="{{ route('kunjungan.operasi') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-knife text-xl'></i>
                        <span class="ml-3">Kamar Operasi</span>
                    </a>
                </div>

                <!-- Laporan Section -->
                <div class="space-y-1">
                    <div class="px-4 py-2">
                        <span class="text-xs font-semibold text-indigo-300 uppercase tracking-wider">Laporan</span>
                    </div>

                    <a href="{{ route('kunjungan.laporan.harian') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-file text-xl'></i>
                        <span class="ml-3">Laporan Harian</span>
                    </a>

                    <a href="{{ route('kunjungan.laporan.bulanan') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-calendar text-xl'></i>
                        <span class="ml-3">Laporan Bulanan</span>
                    </a>

                    <a href="{{ route('kunjungan.laporan.tahunan') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-calendar-star text-xl'></i>
                        <span class="ml-3">Laporan Tahunan</span>
                    </a>
                </div>
            @endif

            @if(request()->is('keuangan*'))
                <!-- Menu Keuangan -->
                <div class="py-4 space-y-1">
                    <div class="px-4 py-2">
                        <span class="text-xs font-semibold text-indigo-300 uppercase tracking-wider">Keuangan</span>
                    </div>

                    <a href="{{ route('keuangan.dashboard') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-home text-xl'></i>
                        <span class="ml-3">Dashboard Keuangan</span>
                    </a>

                    <a href="{{ route('keuangan.bukukas') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-book text-xl'></i>
                        <span class="ml-3">Buku Kas</span>
                    </a>

                    <a href="{{ route('keuangan.penerimaan') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-download text-xl'></i>
                        <span class="ml-3">Penerimaan</span>
                    </a>

                    <a href="{{ route('keuangan.pengeluaran') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-upload text-xl'></i>
                        <span class="ml-3">Pengeluaran</span>
                    </a>

                    <a href="{{ route('keuangan.laporan') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-file text-xl'></i>
                        <span class="ml-3">Laporan</span>
                    </a>

                    <a href="{{ route('keuangan.akun') }}" 
                       class="flex items-center px-4 py-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-list-ul text-xl'></i>
                        <span class="ml-3">Akun</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Menu Keluar -->
        <div class="absolute bottom-4 left-0 right-0 px-3">
            <a href="{{ route('logout') }}" 
               class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-red-600 group transition-colors duration-200">
                <i class='bx bx-log-out text-xl'></i>
                <span class="ml-3">Keluar</span>
            </a>
        </div>
    </div>

    <!-- Tombol close untuk mobile & tablet -->
    <button type="button"
            class="absolute top-4 right-4 lg:hidden text-white hover:text-gray-300 focus:outline-none"
            id="sidebar-close">
        <i class='bx bx-x text-2xl'></i>
    </button>
</aside>

<!-- Overlay untuk mobile & tablet -->
<div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 hidden transition-opacity duration-300 md:hidden"
     id="sidebar-overlay">
</div>

<!-- Script untuk sidebar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebar = document.querySelector('aside');
    const overlay = document.getElementById('sidebar-overlay');
    const body = document.body;

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        body.classList.toggle('overflow-hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
        body.classList.remove('overflow-hidden');
    }

    // Toggle sidebar
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    // Close sidebar
    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }

    // Close when clicking overlay
    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeSidebar();
        }
    });

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            closeSidebar();
        }
    });

    // Handle swipe to close on mobile
    let touchStartX = 0;
    let touchEndX = 0;

    sidebar.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    });

    sidebar.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        if (touchStartX - touchEndX > 50) { // Swipe left
            closeSidebar();
        }
    });
});
</script>

<style>
/* Transisi smooth untuk sidebar */
aside {
    transition: transform 0.3s ease-in-out;
}

/* Animasi untuk overlay */
#sidebar-overlay {
    transition: opacity 0.3s ease-in-out;
}

/* Prevent content shift when scrollbar appears/disappears */
html {
    scrollbar-gutter: stable;
}

/* Custom scrollbar untuk sidebar */
aside::-webkit-scrollbar {
    width: 4px;
}

aside::-webkit-scrollbar-track {
    @apply bg-indigo-800;
}

aside::-webkit-scrollbar-thumb {
    @apply bg-indigo-400 rounded-full hover:bg-indigo-300;
}
</style> 