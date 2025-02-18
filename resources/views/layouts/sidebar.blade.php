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
            @elseif(request()->is('keuangan*'))
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