{{-- resources/views/components/sidebar.blade.php --}}
<aside id="sidebar"
    class="fixed left-0 top-0 h-screen bg-white shadow-lg z-50 w-64 transition-[width] duration-300 ease-in-out">

    <!-- Logo -->
    <div class="h-20 flex items-center justify-between px-4 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-lg flex items-center justify-center text-white font-bold text-lg">
                <i class="fas fa-box"></i>
            </div>
            <span class="menu-text-visible font-bold text-gray-800 text-lg whitespace-nowrap">
                Transdata
            </span>
        </div>
        <button id="toggleBtn"
            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 transition-colors">
            <i class="fas fa-bars text-gray-600"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="py-4 px-3 flex-1 overflow-y-auto h-[calc(100vh-160px)]">

        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-3 py-3 rounded-lg mb-4 transition-all
            {{ request()->routeIs('dashboard')
                ? 'bg-gradient-to-r from-blue-600 to-purple-600 text-white shadow-lg'
                : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-home text-lg w-5"></i>
            <span class="menu-text-visible font-medium whitespace-nowrap">Dashboard</span>
        </a>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Menu -->
        @php
            $menus = [
                [
                    'label' => 'Perangkat',
                    'icon' => 'fa-desktop',
                    'url' => '/perangkat',
                    'submenus' => [
                        ['label' => 'Daftar Perangkat', 'url' => '/perangkat'],
                        ['label' => 'Kategori Perangkat', 'url' => '/kategori-perangkat'],
                    ]
                ],
                [
                    'label' => 'Vendor',
                    'icon' => 'fa-building',
                    'url' => '/vendor',
                    'submenus' => [
                        ['label' => 'Daftar Vendor', 'url' => '/vendor'],
                        ['label' => 'Kategori Vendor', 'url' => '/kategori-vendor'],
                    ]
                ],
                [
                    'label' => 'Inventory',
                    'icon' => 'fa-boxes-stacked',
                    'url' => '/inventory',
                    'submenus' => []
                ],
                [
                    'label' => 'Purchase Order',
                    'icon' => 'fa-file-invoice',
                    'url' => '/purchase-order',
                    'submenus' => []
                ],
            ];
            
            // Fungsi untuk cek apakah menu aktif
            function isMenuActive($menu) {
                if (!empty($menu['submenus'])) {
                    foreach ($menu['submenus'] as $submenu) {
                        if (request()->is(ltrim($submenu['url'], '/') . '*')) {
                            return true;
                        }
                    }
                }
                return request()->is(ltrim($menu['url'], '/') . '*');
            }
        @endphp

        <div class="space-y-1">
            @foreach ($menus as $menu)
                @php
                    $isActive = isMenuActive($menu);
                    $hasSubmenus = !empty($menu['submenus']);
                @endphp
                
                @if($hasSubmenus)
                    <!-- Menu dengan submenu -->
                    <div class="mb-1">
                        <!-- Header Menu -->
                        <button type="button"
                            class="w-full flex items-center justify-between gap-3 px-3 py-3 rounded-lg transition-all
                            {{ $isActive ? 'bg-blue-50 text-blue-600 font-medium' : 'text-gray-700 hover:bg-gray-100' }}"
                            onclick="toggleSubmenu(this)">
                            <div class="flex items-center gap-3">
                                <i class="fas {{ $menu['icon'] }} text-lg w-5"></i>
                                <span class="menu-text-visible whitespace-nowrap">{{ $menu['label'] }}</span>
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                        </button>
                        
                        <!-- Submenu -->
                        <div class="submenu-container ml-7 mt-1 space-y-1 hidden">
                            @foreach ($menu['submenus'] as $submenu)
                                <a href="{{ url($submenu['url']) }}"
                                    class="flex items-center gap-3 px-3 py-2 rounded-lg transition-all text-sm
                                    {{ request()->is(ltrim($submenu['url'], '/') . '*')
                                        ? 'bg-blue-100 text-blue-600 font-medium'
                                        : 'text-gray-600 hover:bg-gray-100' }}">
                                    <i class="fas fa-circle text-xs w-3"></i>
                                    <span class="menu-text-visible whitespace-nowrap">{{ $submenu['label'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Menu tanpa submenu -->
                    <a href="{{ url($menu['url']) }}"
                        class="flex items-center gap-3 px-3 py-3 rounded-lg transition-all
                        {{ request()->is(ltrim($menu['url'], '/') . '*')
                            ? 'bg-blue-50 text-blue-600 font-medium'
                            : 'text-gray-700 hover:bg-gray-100' }}">
                        <i class="fas {{ $menu['icon'] }} text-lg w-5"></i>
                        <span class="menu-text-visible whitespace-nowrap">{{ $menu['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </nav>

    <!-- Logout -->
    <div class="border-t border-gray-200 p-3">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-3 rounded-lg text-red-600 hover:bg-red-50 transition-all">
                <i class="fas fa-sign-out-alt text-lg w-5"></i>
                <span class="menu-text-visible font-medium whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>
</aside>

<script>
function toggleSubmenu(button) {
    const submenu = button.nextElementSibling;
    const icon = button.querySelector('.fa-chevron-down');
    
    // Toggle submenu visibility
    submenu.classList.toggle('hidden');
    
    // Rotate chevron icon
    if (submenu.classList.contains('hidden')) {
        icon.classList.remove('rotate-180');
    } else {
        icon.classList.add('rotate-180');
    }
}

// Buka submenu yang aktif saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    const activeSubmenus = document.querySelectorAll('.submenu-container');
    
    activeSubmenus.forEach(submenu => {
        const activeLink = submenu.querySelector('a.bg-blue-100');
        if (activeLink) {
            // Buka parent submenu
            submenu.classList.remove('hidden');
            const button = submenu.previousElementSibling;
            const icon = button.querySelector('.fa-chevron-down');
            icon.classList.add('rotate-180');
            
            // Tambah kelas aktif ke parent menu
            button.classList.add('bg-blue-50', 'text-blue-600', 'font-medium');
        }
    });
});
</script>

<style>
.rotate-180 {
    transform: rotate(180deg);
}
</style>