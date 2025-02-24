<div class="navbar bg-base-100 fixed top-0 left-0 right-0 z-50 border-b">
    <!-- Menu di kiri -->
    <div class="navbar-start">
        <!-- Mobile menu button -->
        <div class="lg:hidden">
            <button class="btn btn-ghost btn-circle" id="sidebar-toggle">
                <i class='bx bx-menu text-2xl'></i>
            </button>
        </div>

        <!-- Menu Links - Tampil di desktop, sembunyi di mobile -->
        <div class="hidden lg:flex lg:ml-64">
            <ul class="menu menu-horizontal px-1 gap-2">
                <li>
                    <a href="{{ route('kunjungan') }}" 
                       class="btn btn-ghost btn-sm {{ request()->is('kunjungan*') ? 'bg-base-200' : '' }}">
                        <i class='bx bx-user-pin text-lg'></i>
                        <span>Kunjungan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keuangan') }}"
                       class="btn btn-ghost btn-sm {{ request()->is('keuangan*') ? 'bg-base-200' : '' }}">
                        <i class='bx bx-money text-lg'></i>
                        <span>Keuangan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apotek') }}"
                       class="btn btn-ghost btn-sm {{ request()->is('apotek*') ? 'bg-base-200' : '' }}">
                        <i class='bx bx-capsule text-lg'></i>
                        <span>Apotek</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hrd') }}"
                       class="btn btn-ghost btn-sm {{ request()->is('hrd*') ? 'bg-base-200' : '' }}">
                        <i class='bx bx-user text-lg'></i>
                        <span>HRD</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Avatar dan Nama Aplikasi di kanan -->
    <div class="navbar-end gap-4">
        <!-- Nama Aplikasi -->
        <div class="hidden md:block">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-primary hover:text-primary-focus transition-colors">
                {{ env('APP_NAME') }}
            </a>
        </div>

        <!-- Avatar dropdown -->
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle avatar">
                <div class="w-10 rounded-full">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Session::get('nama_pegawai')) }}&background=6366f1&color=fff" />
                </div>
            </label>
            <ul tabindex="0" class="dropdown-content menu menu-sm mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                    <a href="{{ route('profile') }}">
                        <i class='bx bx-user'></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings') }}">
                        <i class='bx bx-cog'></i>
                        Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="text-error">
                        <i class='bx bx-log-out'></i>
                        Logout
                    </a>
                </li>
            </ul>
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