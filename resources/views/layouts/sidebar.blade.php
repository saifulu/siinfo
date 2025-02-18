<aside class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-indigo-700">
        <a href="{{ route('dashboard') }}" class="flex items-center mb-5 pl-2.5">
            <i class='bx bx-layer text-white text-2xl'></i>
            <span class="ml-3 text-xl font-semibold text-white">SiINFO</span>
        </a>
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                    <i class='bx bx-grid-alt text-xl'></i>
                    <span class="ml-3">Dasbor</span>
                </a>
            </li>
            @if(!request()->routeIs('dashboard'))
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
            <li class="mt-auto">
                <a href="{{ route('logout') }}" class="flex items-center p-2 text-gray-300 rounded-lg hover:bg-indigo-600 group">
                    <i class='bx bx-log-out text-xl'></i>
                    <span class="ml-3">Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</aside> 