<div class="navbar bg-white/80 backdrop-blur-md fixed top-0 left-0 right-0 z-50 border-b shadow-sm">
    <!-- Menu di kiri -->
    <div class="navbar-start">
        <!-- Mobile menu button -->
        <div class="md:hidden">
            <button class="btn btn-ghost btn-circle hover:bg-indigo-50" id="sidebar-toggle">
                <i class='bx bx-menu text-2xl text-indigo-600'></i>
            </button>
        </div>

        <!-- Nama Aplikasi - Tampil di medium & desktop -->
        <div class="hidden md:flex items-center">
            <a href="{{ route('dashboard') }}" class="btn btn-ghost gap-2 text-xl font-bold text-indigo-600 hover:bg-indigo-50">
                <i class='bx bx-plus-medical'></i>
                {{ env('APP_NAME') }}
            </a>
        </div>
    </div>

    <!-- Menu di tengah -->
    <div class="navbar-center">
        <!-- Menu untuk desktop -->
        <div class="hidden xl:flex">
            <ul class="menu menu-horizontal gap-3">
                <li>
                    <a href="{{ route('kunjungan') }}" 
                       class="btn btn-sm font-medium {{ request()->is('kunjungan*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50 hover:text-indigo-600' }}">
                        <i class='bx bx-user-pin text-lg'></i>
                        <span>Kunjungan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('keuangan') }}"
                       class="btn btn-sm font-medium {{ request()->is('keuangan*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50 hover:text-indigo-600' }}">
                        <i class='bx bx-money text-lg'></i>
                        <span>Keuangan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('apotek') }}"
                       class="btn btn-sm font-medium {{ request()->is('apotek*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50 hover:text-indigo-600' }}">
                        <i class='bx bx-capsule text-lg'></i>
                        <span>Apotek</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hrd') }}"
                       class="btn btn-sm font-medium {{ request()->is('hrd*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50 hover:text-indigo-600' }}">
                        <i class='bx bx-user text-lg'></i>
                        <span>HRD</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Menu untuk mobile & tablet -->
        <div class="xl:hidden">
            <div class="btn-group shadow-sm rounded-lg bg-base-200">
                <a href="{{ route('kunjungan') }}" 
                   class="btn btn-sm normal-case {{ request()->is('kunjungan*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50' }}">
                    <i class='bx bx-user-pin'></i>
                    <span class="text-xs sm:text-sm">Kunjungan</span>
                </a>
                <a href="{{ route('keuangan') }}"
                   class="btn btn-sm normal-case {{ request()->is('keuangan*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50' }}">
                    <i class='bx bx-money'></i>
                    <span class="text-xs sm:text-sm">Keuangan</span>
                </a>
                <a href="{{ route('apotek') }}"
                   class="btn btn-sm normal-case {{ request()->is('apotek*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50' }}">
                    <i class='bx bx-capsule'></i>
                    <span class="text-xs sm:text-sm">Apotek</span>
                </a>
                <a href="{{ route('hrd') }}"
                   class="btn btn-sm normal-case {{ request()->is('hrd*') ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'btn-ghost hover:bg-indigo-50' }}">
                    <i class='bx bx-user'></i>
                    <span class="text-xs sm:text-sm">HRD</span>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Avatar di kanan -->
    <div class="navbar-end gap-2">
        <!-- Nama Aplikasi (hanya tampil di tablet) -->
        <div class="hidden md:block xl:hidden">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold text-primary hover:text-primary-focus transition-colors">
                {{ env('APP_NAME') }}
            </a>
        </div>

        <!-- Avatar dropdown -->
        <div class="dropdown dropdown-end">
            <label tabindex="0" class="btn btn-ghost btn-circle avatar ring-2 ring-indigo-100 hover:ring-indigo-300">
                <div class="w-10 rounded-full">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Session::get('nama_pegawai')) }}&background=6366f1&color=fff" />
                </div>
            </label>
            <ul tabindex="0" class="dropdown-content menu menu-sm mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border">
                <li class="menu-title px-4 py-2">
                    <span class="text-xs font-medium text-gray-500">Akun</span>
                </li>
                <li>
                    <a href="{{ route('profile') }}" class="gap-3 hover:text-indigo-600">
                        <i class='bx bx-user text-lg'></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings') }}" class="gap-3 hover:text-indigo-600">
                        <i class='bx bx-cog text-lg'></i>
                        Settings
                    </a>
                </li>
                <div class="divider my-1"></div>
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 text-red-500 hover:text-red-600 hover:bg-red-50 px-4 py-2">
                            <i class='bx bx-log-out text-lg'></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<!-- Tambahkan padding untuk konten -->
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

<style>
/* Custom styles untuk mobile */
@media (max-width: 640px) {
    .btn-group .btn {
        @apply px-2 py-1 text-xs;
    }
    
    .btn-group .btn i {
        @apply mr-1 text-lg;
    }
}

/* Custom styles untuk tablet */
@media (min-width: 641px) and (max-width: 1279px) {
    .btn-group .btn {
        @apply px-3 py-2;
    }
}

/* Animasi hover untuk menu */
.btn-ghost {
    @apply transition-all duration-200;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    @apply bg-gray-100;
}

::-webkit-scrollbar-thumb {
    @apply bg-indigo-200 rounded-full hover:bg-indigo-300;
}
</style> 