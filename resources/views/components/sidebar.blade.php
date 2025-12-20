{{-- resources/views/components/sidebar.blade.php --}}
<aside id="sidebar" class="sidebar">
    
    <!-- Logo Section -->
    <div class="sidebar-logo">
        <img src="{{ asset('images/transdata-logo.png') }}" 
             alt="PT Transdata Logo" 
             id="logoImage"
             class="logo-img">
        <span id="logoSubtitle" class="logo-subtitle">
            INVENTORY SYSTEM
        </span>
    </div>

    <!-- Toggle Button (Desktop) -->
    <button id="sidebarToggleBtn" class="sidebar-toggle d-none d-lg-flex" type="button">
        <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        
        <!-- Dashboard -->
        <a href="{{ route('dashboard') }}" 
           class="sidebar-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i>
            <span class="nav-text">Dashboard</span>
            <span class="nav-tooltip">Dashboard</span>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Section Title -->
        <div class="nav-section-title">
            <span class="section-text">Menu Utama</span>
        </div>

        <!-- Menu Items -->
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

        <div class="nav-items">
            @foreach ($menus as $menu)
                @php
                    $isActive = isMenuActive($menu);
                    $hasSubmenus = !empty($menu['submenus']);
                @endphp
                
                @if($hasSubmenus)
                    <div class="nav-item-group">
                        <button type="button"
                                class="sidebar-nav-item nav-item-dropdown {{ $isActive ? 'active' : '' }}"
                                onclick="toggleSubmenu(this)">
                            <div class="nav-item-content">
                                <i class="fas {{ $menu['icon'] }}"></i>
                                <span class="nav-text">{{ $menu['label'] }}</span>
                            </div>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                            <span class="nav-tooltip">{{ $menu['label'] }}</span>
                        </button>
                        
                        <div class="submenu-container {{ $isActive ? 'show' : '' }}">
                            <div class="submenu-items">
                                @foreach ($menu['submenus'] as $submenu)
                                    <a href="{{ url($submenu['url']) }}"
                                       class="submenu-item {{ request()->is(ltrim($submenu['url'], '/') . '*') ? 'active' : '' }}">
                                        <i class="fas fa-circle submenu-bullet"></i>
                                        <span class="nav-text">{{ $submenu['label'] }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ url($menu['url']) }}"
                       class="sidebar-nav-item {{ request()->is(ltrim($menu['url'], '/') . '*') ? 'active' : '' }}">
                        <i class="fas {{ $menu['icon'] }}"></i>
                        <span class="nav-text">{{ $menu['label'] }}</span>
                        <span class="nav-tooltip">{{ $menu['label'] }}</span>
                    </a>
                @endif
            @endforeach
        </div>
    </nav>

    <!-- Logout -->
    <div class="sidebar-footer">
        <button type="button" 
                class="sidebar-nav-item logout-btn" 
                data-bs-toggle="modal" 
                data-bs-target="#logoutModal">
            <i class="fas fa-sign-out-alt"></i>
            <span class="nav-text">Logout</span>
            <span class="nav-tooltip">Logout</span>
        </button>
    </div>
</aside>

<!-- Mobile Overlay -->
<div id="sidebarOverlay" class="sidebar-overlay d-lg-none" onclick="closeSidebar()"></div>

<!-- Include Logout Modal -->
@include('components.logout-modal')

<style>
/* ==================== SIDEBAR STYLES ==================== */
.sidebar {
    position: fixed;
    left: 0;
    top: 0;
    height: 100vh;
    background: #ffffff;
    box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
    z-index: 1050;
    width: 260px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
}

/* Logo Section */
.sidebar-logo {
    height: 96px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1rem;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #eff6ff 0%, #f3e8ff 100%);
}

.logo-img {
    height: 48px;
    width: auto;
    margin-bottom: 6px;
    filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
    transition: all 0.3s ease;
}

.logo-subtitle {
    padding: 2px 10px;
    background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
    color: white;
    border-radius: 50px;
    font-size: 9px;
    font-weight: 600;
    letter-spacing: 1px;
    white-space: nowrap;
    margin-top: 4px;
    transition: all 0.3s ease;
}

/* Toggle Button */
.sidebar-toggle {
    position: absolute;
    right: -12px;
    top: 60px;
    width: 24px;
    height: 24px;
    background: white;
    border: 2px solid #2563eb;
    border-radius: 50%;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    z-index: 10;
}

.sidebar-toggle:hover {
    background: #2563eb;
    color: white;
    transform: scale(1.1);
}

.sidebar-toggle i {
    font-size: 10px;
    transition: transform 0.3s ease;
}

/* Navigation */
.sidebar-nav {
    padding: 1rem 0.75rem;
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
}

.sidebar-nav::-webkit-scrollbar {
    width: 6px;
}

.sidebar-nav::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar-nav::-webkit-scrollbar-thumb {
    background: #e5e7eb;
    border-radius: 10px;
}

.sidebar-divider {
    margin: 1rem 0;
    border: 0;
    border-top: 1px solid #e5e7eb;
}

/* Section Title */
.nav-section-title {
    padding: 0 1rem;
    margin-bottom: 0.75rem;
}

.section-text {
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: opacity 0.2s ease;
}

/* Nav Items */
.nav-items {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.sidebar-nav-item {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    border-radius: 12px;
    color: #374151;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
    border: none;
    background: transparent;
    width: 100%;
    text-align: left;
}

.sidebar-nav-item i {
    font-size: 16px;
    min-width: 20px;
    text-align: center;
}

.nav-text {
    font-weight: 500;
    white-space: nowrap;
    transition: opacity 0.2s ease;
}

.sidebar-nav-item:hover {
    background: #f3f4f6;
    color: #2563eb;
}

.sidebar-nav-item.active {
    background: linear-gradient(90deg, #2563eb 0%, #1e40af 100%);
    color: white;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

/* Dropdown */
.nav-item-dropdown {
    justify-content: space-between;
}

.nav-item-content {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex: 1;
}

.dropdown-icon {
    font-size: 10px;
    transition: transform 0.3s;
}

.nav-item-dropdown[aria-expanded="true"] .dropdown-icon {
    transform: rotate(180deg);
}

/* Submenu */
.submenu-container {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.submenu-container.show {
    max-height: 500px;
}

.submenu-items {
    margin-left: 2.25rem;
    padding: 0.25rem 0;
}

.submenu-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.625rem 0.75rem;
    border-radius: 8px;
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.2s;
}

.submenu-bullet {
    font-size: 6px;
    min-width: 12px;
    text-align: center;
}

.submenu-item:hover {
    background: #f3f4f6;
    color: #2563eb;
}

.submenu-item.active {
    background: #dbeafe;
    color: #1e40af;
    font-weight: 500;
}

/* Tooltip */
.nav-tooltip {
    visibility: hidden;
    opacity: 0;
    position: absolute;
    left: 100%;
    margin-left: 8px;
    padding: 6px 12px;
    background: #1f2937;
    color: white;
    font-size: 12px;
    border-radius: 8px;
    white-space: nowrap;
    pointer-events: none;
    transition: opacity 0.2s ease;
    z-index: 1000;
}

/* Sidebar Footer */
.sidebar-footer {
    border-top: 1px solid #e5e7eb;
    padding: 0.75rem;
    background: #f9fafb;
}

.logout-btn {
    color: #dc2626;
    font-weight: 500;
}

.logout-btn:hover {
    background: #fef2f2 !important;
    color: #dc2626 !important;
}

/* Collapsed State */
.sidebar.collapsed {
    width: 80px;
}

.sidebar.collapsed .logo-img {
    height: 32px;
}

.sidebar.collapsed .logo-subtitle {
    max-height: 0;
    opacity: 0;
    margin-top: 0;
    padding: 0;
    overflow: hidden;
}

.sidebar.collapsed .nav-text,
.sidebar.collapsed .section-text {
    opacity: 0;
    width: 0;
    overflow: hidden;
}

.sidebar.collapsed .dropdown-icon {
    opacity: 0;
}

.sidebar.collapsed .sidebar-nav-item:hover .nav-tooltip {
    visibility: visible;
    opacity: 1;
}

.sidebar.collapsed .submenu-container {
    display: none;
}

.sidebar.collapsed .sidebar-toggle i {
    transform: rotate(180deg);
}

/* Mobile */
@media (max-width: 991px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
}

.sidebar-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1040;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.sidebar-overlay.show {
    opacity: 1;
    visibility: visible;
}
</style>

<script>
// Toggle Submenu
function toggleSubmenu(button) {
    const sidebar = document.getElementById('sidebar');
    
    if (sidebar.classList.contains('collapsed')) {
        return;
    }
    
    const submenu = button.parentElement.querySelector('.submenu-container');
    const isOpen = submenu.classList.contains('show');
    
    document.querySelectorAll('.submenu-container').forEach(sm => {
        if (sm !== submenu) {
            sm.classList.remove('show');
            const btn = sm.parentElement.querySelector('.nav-item-dropdown');
            if (btn) btn.setAttribute('aria-expanded', 'false');
        }
    });
    
    submenu.classList.toggle('show');
    button.setAttribute('aria-expanded', !isOpen);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Auto-open active submenus
    document.querySelectorAll('.nav-item-group').forEach(group => {
        const activeSubmenu = group.querySelector('.submenu-item.active');
        if (activeSubmenu) {
            const submenu = group.querySelector('.submenu-container');
            const button = group.querySelector('.nav-item-dropdown');
            submenu.classList.add('show');
            button.setAttribute('aria-expanded', 'true');
        }
    });
});
</script>