<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 bg-indigo-700">
    <div class="h-full px-3 py-4 overflow-y-auto">
        <!-- Logo di sidebar -->
        <div class="flex flex-col items-start gap-2 mb-5 pl-2.5">
            <!-- Logo dan nama singkat -->
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <i class='bx bx-plus-medical text-white text-2xl'></i>
                <span class="ml-3 text-xl font-semibold text-white">SiINFO</span>
            </a>
            
            <!-- Nama Instansi -->
            @php
                $setting = \App\Models\Setting::where('aktifkan', 'Yes')->first();
            @endphp
            @if($setting)
                <div class="text-sm font-medium text-gray-200 leading-tight">
                    {{ $setting->nama_instansi }}
                </div>
                <div class="text-xs text-gray-300">
                    {{ $setting->alamat_instansi }}
                </div>
            @endif
        </div>
        
        <!-- Mobile Menu - Tampil saat sidebar terbuka di mobile -->
        <div class="lg:hidden mb-4 border-b border-indigo-600 pb-4">
            <ul class="menu gap-2">
                <li>
                    <a href="{{ route('kunjungan') }}" 
                       class="text-gray-300 hover:bg-indigo-600 {{ request()->is('kunjungan*') ? 'bg-indigo-600' : '' }}">
                        <i class='bx bx-user-pin'></i>
                        <span>Kunjungan</span>
                    </a>
                </li>
                <!-- Menu lainnya untuk mobile -->
            </ul>
        </div>

        <!-- Menu Sidebar -->
        <ul class="space-y-2">
            <!-- Dasbor selalu muncul -->
            <li>
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group transition-colors duration-200">
                    <i class='bx bx-grid-alt text-xl'></i>
                    <span class="ml-3">Dasbor</span>
                </a>
            </li>

            @if(request()->is('kunjungan*'))
                <!-- Menu Kunjungan -->
                <li>
                    <a href="{{ route('kunjungan.dashboard') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-home text-xl'></i>
                        <span class="ml-3">Dashboard Kunjungan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kunjungan.rawatjalan') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-walk text-xl'></i>
                        <span class="ml-3">Rawat Jalan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kunjungan.rawatinap') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-bed text-xl'></i>
                        <span class="ml-3">Rawat Inap</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kunjungan.igd') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-plus-medical text-xl'></i>
                        <span class="ml-3">IGD</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kunjungan.operasi') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-knife text-xl'></i>
                        <span class="ml-3">Kamar Operasi</span>
                    </a>
                </li>
                <!-- Sub menu Laporan -->
                <li>
                    <a href="{{ route('kunjungan.laporan.harian') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-file text-xl'></i>
                        <span class="ml-3">Laporan Harian</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kunjungan.laporan.bulanan') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-calendar text-xl'></i>
                        <span class="ml-3">Laporan Bulanan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kunjungan.laporan.tahunan') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-calendar-star text-xl'></i>
                        <span class="ml-3">Laporan Tahunan</span>
                    </a>
                </li>
            @endif

            @if(request()->is('keuangan*'))
                <!-- Menu Keuangan -->
                <li>
                    <a href="{{ route('keuangan.dashboard') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-home text-xl'></i>
                        <span class="ml-3">Dashboard Keuangan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keuangan.bukukas') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-book text-xl'></i>
                        <span class="ml-3">Buku Kas</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keuangan.penerimaan') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-download text-xl'></i>
                        <span class="ml-3">Penerimaan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keuangan.pengeluaran') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-upload text-xl'></i>
                        <span class="ml-3">Pengeluaran</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keuangan.laporan') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-file text-xl'></i>
                        <span class="ml-3">Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keuangan.akun') }}" 
                       class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-list-ul text-xl'></i>
                        <span class="ml-3">Akun</span>
                    </a>
                </li>
            @endif

            <!-- Menu Keluar selalu di bawah -->
            <li class="mt-auto">
                <a href="{{ route('logout') }}" 
                   class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-red-600 group transition-colors duration-200">
                    <i class='bx bx-log-out text-xl'></i>
                    <span class="ml-3">Keluar</span>
                </a>
            </li>
        </ul>
    </div>

    <!-- Tombol close untuk mobile -->
    <button type="button"
            class="absolute top-4 right-4 lg:hidden text-white hover:text-gray-300"
            id="sidebar-close">
        <i class='bx bx-x text-2xl'></i>
    </button>
</aside>

<!-- Overlay untuk mobile -->
<div class="fixed inset-0 bg-gray-900 bg-opacity-50 z-30 hidden transition-opacity duration-300 lg:hidden"
     id="sidebar-overlay">
</div>

<!-- Tambahkan script ini di app.blade.php atau buat file js terpisah -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebarClose = document.getElementById('sidebar-close');
    const sidebar = document.querySelector('aside');
    const overlay = document.getElementById('sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
        document.body.classList.toggle('overflow-hidden');
    }

    if (sidebarToggle) sidebarToggle.addEventListener('click', toggleSidebar);
    if (sidebarClose) sidebarClose.addEventListener('click', toggleSidebar);
    if (overlay) overlay.addEventListener('click', toggleSidebar);

    // Handle window resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) { // lg breakpoint
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
});
</script> 