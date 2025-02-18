<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform duration-300 ease-in-out -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-indigo-700">
        <a href="{{ route('dashboard') }}" class="flex items-center mb-5 pl-2.5">
            <i class='bx bx-layer text-white text-2xl'></i>
            <span class="ml-3 text-xl font-semibold text-white">SiINFO</span>
        </a>
        
        <ul class="space-y-2">
            <!-- Dasbor selalu muncul -->
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                    <i class='bx bx-grid-alt text-xl'></i>
                    <span class="ml-3">Dasbor</span>
                </a>
            </li>

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
            @elseif(!request()->routeIs('dashboard'))
                <!-- Menu Laporan Default -->
                <li>
                    <a href="{{ route('laporan.keuangan') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-money text-xl'></i>
                        <span class="ml-3">Laporan Keuangan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.kunjungan') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-user-pin text-xl'></i>
                        <span class="ml-3">Laporan Kunjungan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.obat') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-capsule text-xl'></i>
                        <span class="ml-3">Laporan Obat</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.laboratorium') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-test-tube text-xl'></i>
                        <span class="ml-3">Laporan Laboratorium</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.radiologi') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                        <i class='bx bx-radio-circle text-xl'></i>
                        <span class="ml-3">Laporan Radiologi</span>
                    </a>
                </li>
            @endif

            <!-- Menu Keluar selalu di bawah -->
            <li class="mt-auto">
                <a href="{{ route('logout') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                    <i class='bx bx-log-out text-xl'></i>
                    <span class="ml-3">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside> 