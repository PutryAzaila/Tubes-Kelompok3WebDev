{{-- resources/views/components/navbar.blade.php --}}
@php
    $user = Auth::user();
@endphp

<nav class="top-navbar fixed-top">
    <div class="container-fluid">
        <div class="navbar-content">
            
            <!-- Left Section -->
            <div class="navbar-left">
                <!-- Mobile Menu Toggle -->
                <button class="mobile-toggle d-lg-none" onclick="openSidebar()" type="button">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Page Info -->
                <div class="page-info">
                    <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
                    <p class="page-subtitle">@yield('page-subtitle', 'Selamat datang kembali')</p>
                </div>
            </div>

            <!-- Right Section -->
            <div class="navbar-right">
                
                <!-- User Profile -->
                <div class="user-profile dropdown">
                    <button class="profile-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-info d-none d-sm-block">
                            <span class="profile-name">{{ $user->nama_lengkap ?? 'User' }}</span>
                            <span class="profile-role">{{ $user->jabatan ?? 'Staff' }}</span>
                        </div>
                        <div class="profile-avatar">
                            {{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 1)) }}
                        </div>
                        <i class="fas fa-chevron-down ms-2 d-none d-sm-inline"></i>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="dropdown-menu dropdown-menu-end profile-dropdown">
                        <!-- User Info (Mobile) -->
                        <div class="profile-header d-sm-none">
                            <div class="profile-avatar-lg">
                                {{ strtoupper(substr($user->nama_lengkap ?? 'U', 0, 1)) }}
                            </div>
                            <div class="profile-info-mobile">
                                <h6>{{ $user->nama_lengkap ?? 'User' }}</h6>
                                <p>{{ $user->email ?? 'user@example.com' }}</p>
                            </div>
                        </div>

                        <div class="dropdown-divider d-sm-none"></div>

                        <!-- Menu Items -->
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user-circle"></i>
                            <span>Profil Saya</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- Logout -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</nav>

<style>
/* ==================== TOP NAVBAR ==================== */
.top-navbar {
    background: #ffffff;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    z-index: 1030;
    height: 70px;
}

.navbar-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 70px;
    padding: 0 1.5rem;
}

/* ==================== BODY PADDING FIX ==================== */
/* Tambahkan padding untuk body agar tidak tertutup navbar */
body.dashboard-body,
body .main-content,
.content-wrapper {
    padding-top: 70px !important;
}

/* Untuk desktop dengan sidebar */
@media (min-width: 992px) {
    body.dashboard-body,
    body .main-content,
    .content-wrapper {
        padding-top: 70px !important;
        margin-left: 260px !important;
        transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* When sidebar is collapsed */
    body.sidebar-collapsed .main-content,
    body.sidebar-collapsed .content-wrapper {
        margin-left: 80px !important;
    }
    
    /* Navbar should also adjust */
    body.sidebar-collapsed .top-navbar {
        left: 80px;
        width: calc(100% - 80px);
    }
    
    .top-navbar {
        left: 260px;
        width: calc(100% - 260px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
}

/* ==================== LEFT SECTION ==================== */
.navbar-left {
    display: flex;
    align-items: center;
    gap: 1rem;
    flex: 1;
    min-width: 0;
}

/* Mobile Toggle */
.mobile-toggle {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    border: none;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.mobile-toggle:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
}

.mobile-toggle:active {
    transform: translateY(0);
}

/* Page Info */
.page-info {
    min-width: 0;
    flex: 1;
}

.page-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a202c;
    margin: 0;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-subtitle {
    font-size: 0.8125rem;
    color: #718096;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ==================== RIGHT SECTION ==================== */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* ==================== USER PROFILE ==================== */
.user-profile {
    position: relative;
}

.profile-btn {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.375rem 0.75rem 0.375rem 0.375rem;
    border-radius: 12px;
    border: none;
    background: #f7fafc;
    cursor: pointer;
    transition: all 0.3s ease;
}

.profile-btn:hover {
    background: #edf2f7;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.profile-info {
    text-align: right;
    line-height: 1.3;
}

.profile-name {
    display: block;
    font-size: 0.875rem;
    font-weight: 600;
    color: #2d3748;
}

.profile-role {
    display: block;
    font-size: 0.75rem;
    color: #718096;
}

.profile-avatar {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.875rem;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.profile-btn i {
    color: #a0aec0;
    font-size: 0.75rem;
    transition: transform 0.3s ease;
}

.profile-btn[aria-expanded="true"] i {
    transform: rotate(180deg);
}

/* ==================== DROPDOWN STYLES ==================== */
.profile-dropdown {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
    padding: 0.5rem;
    margin-top: 0.75rem !important;
    min-width: 260px;
    display: none;
    opacity: 0;
    transform: translateY(10px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    position: absolute !important;
    right: 0 !important;
    left: auto !important;
}

.profile-dropdown.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.dropdown-item {
    border-radius: 8px;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    color: #4a5568;
    font-size: 0.875rem;
    transition: all 0.2s ease;
    cursor: pointer;
    text-decoration: none;
    border: none;
    background: none;
    width: 100%;
    text-align: left;
}

.dropdown-item i {
    width: 20px;
    font-size: 1rem;
}

.dropdown-item:hover {
    background: #f7fafc;
    color: #2563eb;
}

.dropdown-item.text-danger:hover {
    background: #fff5f5;
    color: #f56565;
}

.dropdown-divider {
    margin: 0.5rem 0;
    border-color: #e2e8f0;
}

/* Profile Header (Mobile) */
.profile-header {
    padding: 1rem;
    text-align: center;
}

.profile-avatar-lg {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.5rem;
    margin: 0 auto 0.75rem;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.profile-info-mobile h6 {
    font-size: 0.9375rem;
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.25rem;
}

.profile-info-mobile p {
    font-size: 0.8125rem;
    color: #718096;
    margin: 0;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 991px) {
    .navbar-content {
        padding: 0 1rem;
    }
}

@media (max-width: 767px) {
    .top-navbar {
        height: 60px;
    }
    
    .navbar-content {
        height: 60px;
    }
    
    body.dashboard-body,
    body .main-content,
    .content-wrapper {
        padding-top: 60px !important;
    }
    
    .top-navbar {
        left: 0;
        width: 100%;
    }
    
    .page-title {
        font-size: 1.125rem;
    }
    
    .page-subtitle {
        font-size: 0.75rem;
    }
}

@media (max-width: 575px) {
    .navbar-content {
        padding: 0 0.75rem;
        gap: 0.5rem;
    }
    
    .navbar-right {
        gap: 0.5rem;
    }
    
    .profile-avatar {
        width: 36px;
        height: 36px;
        font-size: 0.8125rem;
    }
    
    .profile-btn {
        padding: 0.25rem;
    }
}

/* JavaScript fallback for dropdown */
.profile-dropdown[data-bs-popper] {
    position: absolute;
    inset: auto auto 0px 0px;
    margin: 0px;
    transform: translate(0px, -10px);
}
</style>

<script>
// Sidebar toggle functionality
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const body = document.body;
    
    if (sidebar) {
        sidebar.classList.toggle('collapsed');
        body.classList.toggle('sidebar-collapsed');
        
        // Save state to localStorage
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    }
}

// Open sidebar (mobile)
function openSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (sidebar) {
        sidebar.classList.add('show');
    }
    if (overlay) {
        overlay.classList.add('show');
    }
    document.body.style.overflow = 'hidden';
}

// Close sidebar (mobile)
function closeSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    
    if (sidebar) {
        sidebar.classList.remove('show');
    }
    if (overlay) {
        overlay.classList.remove('show');
    }
    document.body.style.overflow = '';
}

// Fallback for Bootstrap dropdown if not working
document.addEventListener('DOMContentLoaded', function() {
    // Profile dropdown
    const profileBtn = document.querySelector('.profile-btn');
    const profileDropdown = document.querySelector('.profile-dropdown');
    
    if (profileBtn && profileDropdown) {
        profileBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.remove('show');
            }
        });
        
        // Close dropdown when clicking on dropdown items
        const dropdownItems = profileDropdown.querySelectorAll('.dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function() {
                profileDropdown.classList.remove('show');
            });
        });
    }
    
    // Sidebar toggle button
    const sidebarToggleBtn = document.getElementById('sidebarToggleBtn');
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', toggleSidebar);
    }
    
    // Restore sidebar state from localStorage
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
        const sidebar = document.getElementById('sidebar');
        const body = document.body;
        if (sidebar) {
            sidebar.classList.add('collapsed');
            body.classList.add('sidebar-collapsed');
        }
    }
    
    // Close mobile sidebar when clicking on nav items
    const navItems = document.querySelectorAll('.sidebar-nav-item, .submenu-item');
    navItems.forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                closeSidebar();
            }
        });
    });
});
</script>