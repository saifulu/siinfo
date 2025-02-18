<div class="sticky top-0 z-50">
    <div class="bg-white shadow-md mb-6 rounded-lg">
        <div class="border-b">
            <!-- Tombol menu untuk mobile -->
            <div class="flex items-center sm:hidden px-4 py-2">
                <button type="button" 
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        id="sidebar-toggle">
                    <i class='bx bx-menu text-2xl'></i>
                </button>
            </div>

            <nav class="flex flex-wrap justify-between items-center px-4 sm:ml-64">
                <!-- Menu Links -->
                <div class="flex flex-1 space-x-4">
                    <a href="{{ route('kunjungan') }}" 
                       class="group inline-block px-6 py-4 text-sm font-medium transition-all duration-300 ease-in-out
                              {{ request()->is('kunjungan*') ? 'text-indigo-600 border-b-[3px] border-indigo-500' : 'text-gray-600 border-b-[3px] border-transparent' }}
                              hover:text-indigo-600 hover:border-indigo-500">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-user-pin text-xl'></i>
                            <span>Kunjungan</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('keuangan') }}"
                       class="group inline-block px-6 py-4 text-sm font-medium transition-all duration-300 ease-in-out
                              {{ request()->is('keuangan*') ? 'text-indigo-600 border-b-[3px] border-indigo-500' : 'text-gray-600 border-b-[3px] border-transparent' }}
                              hover:text-indigo-600 hover:border-indigo-500">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-money text-xl'></i>
                            <span>Keuangan</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('apotek') }}"
                       class="group inline-block px-6 py-4 text-sm font-medium transition-all duration-300 ease-in-out
                              {{ request()->is('apotek*') ? 'text-indigo-600 border-b-[3px] border-indigo-500' : 'text-gray-600 border-b-[3px] border-transparent' }}
                              hover:text-indigo-600 hover:border-indigo-500">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-capsule text-xl'></i>
                            <span>Apotek</span>
                        </div>
                    </a>
                    
                    <a href="{{ route('hrd') }}"
                       class="group inline-block px-6 py-4 text-sm font-medium transition-all duration-300 ease-in-out
                              {{ request()->is('hrd*') ? 'text-indigo-600 border-b-[3px] border-indigo-500' : 'text-gray-600 border-b-[3px] border-transparent' }}
                              hover:text-indigo-600 hover:border-indigo-500">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-user text-xl'></i>
                            <span>HRD</span>
                        </div>
                    </a>
                </div>

                <!-- User Menu -->
                <div class="relative">
                    @auth
                        <button type="button" 
                                class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-600 hover:bg-indigo-50 rounded-lg focus:outline-none"
                                id="user-menu-button">
                            <span class="font-medium">{{ Session::get('nama_pegawai') ?? 'Pegawai' }}</span>
                            <i class='bx bx-chevron-down text-xl'></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50" 
                             id="user-dropdown">
                            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                                <p class="font-medium">{{ Session::get('nama_pegawai') ?? 'Pegawai' }}</p>
                                <p class="text-xs text-gray-500">{{ Session::get('jabatan') ?? '-' }}</p>
                            </div>
                            <a href="{{ route('profile') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">
                                <i class='bx bx-user mr-2'></i>
                                <span>Profil</span>
                            </a>
                            <a href="{{ route('settings') }}" 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50">
                                <i class='bx bx-cog mr-2'></i>
                                <span>Pengaturan</span>
                            </a>
                            <hr class="my-1">
                            <a href="{{ route('logout') }}" 
                               class="flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                <i class='bx bx-log-out mr-2'></i>
                                <span>Keluar</span>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-600">Masuk</a>
                    @endauth
                </div>
            </nav>
        </div>
    </div>
</div>

<!-- Add padding to main content to prevent overlap -->
<div class="pt-16">
    <!-- Your main content here -->
</div>

<!-- Script untuk dropdown menu -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userMenuButton = document.getElementById('user-menu-button');
    const userDropdown = document.getElementById('user-dropdown');
    
    if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', () => {
            userDropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (event) => {
            if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
                userDropdown.classList.add('hidden');
            }
        });
    }

    // Existing sidebar toggle code
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('aside');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    }
});
</script> 