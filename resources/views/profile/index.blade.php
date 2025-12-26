@extends('layouts.dashboard')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi profil Anda')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ===== VARIABLES ===== */
:root {
    --primary: #2563eb;
    --primary-dark: #1e40af;
    --primary-light: #dbeafe;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #06b6d4;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
}

/* ===== RESET & BASE ===== */
body {
    background-color: var(--gray-50);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* ===== HEADER ===== */
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 16px;
    padding: 2.5rem 2rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(37, 99, 235, 0.15);
}

.page-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
    position: relative;
    z-index: 2;
}

.header-text h1 {
    color: white;
    font-size: 1.875rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-text h1 i {
    background: rgba(255, 255, 255, 0.2);
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.header-text p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 1rem;
}

.btn-edit-profile {
    background: white;
    color: var(--primary);
    border: none;
    padding: 0.875rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 0.75rem;
    text-decoration: none;
}

.btn-edit-profile:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    color: var(--primary-dark);
}

/* ===== PROFILE AVATAR SECTION ===== */
.profile-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
    text-align: center;
}

.profile-avatar-large {
    position: relative;
    display: inline-block;
    margin-bottom: 1.5rem;
}

.avatar-circle {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    font-weight: 700;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.25);
    border: 5px solid white;
}

.status-indicator {
    position: absolute;
    bottom: 8px;
    right: 8px;
    width: 24px;
    height: 24px;
    background: var(--success);
    border-radius: 50%;
    border: 4px solid white;
}

.profile-name {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.5rem;
}

.profile-role {
    color: var(--gray-500);
    font-size: 1rem;
    margin-bottom: 0;
}

/* ===== INFO CARDS ===== */
.info-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--gray-100);
}

.section-header i {
    color: var(--primary);
    font-size: 1.25rem;
}

.section-header h3 {
    color: var(--gray-800);
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
}

.info-card {
    background: var(--gray-50);
    border-radius: 12px;
    padding: 1.25rem;
    border-left: 4px solid transparent;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.info-card.primary {
    border-left-color: var(--primary);
}

.info-card.success {
    border-left-color: var(--success);
}

.info-card.danger {
    border-left-color: var(--danger);
}

.info-card.warning {
    border-left-color: var(--warning);
}

.info-card.purple {
    border-left-color: #8b5cf6;
}

.info-card.orange {
    border-left-color: #f97316;
}

.info-card.cyan {
    border-left-color: var(--info);
}

.info-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.75rem;
}

.info-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    flex-shrink: 0;
}

.info-icon.primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
}

.info-icon.success {
    background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
    color: white;
}

.info-icon.danger {
    background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
    color: white;
}

.info-icon.warning {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
    color: white;
}

.info-icon.purple {
    background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
    color: white;
}

.info-icon.orange {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
}

.info-icon.cyan {
    background: linear-gradient(135deg, var(--info) 0%, #0891b2 100%);
    color: white;
}

.info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.info-value {
    font-size: 0.9375rem;
    color: var(--gray-700);
    font-weight: 500;
    word-break: break-word;
}

/* Address Card Full Width */
.info-card-full {
    grid-column: 1 / -1;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 768px) {
    .page-header {
        padding: 1.75rem 1.5rem;
    }
    
    .header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-text h1 {
        font-size: 1.5rem;
    }
    
    .btn-edit-profile {
        width: 100%;
        justify-content: center;
    }
    
    .profile-section {
        padding: 1.5rem;
    }
    
    .avatar-circle {
        width: 100px;
        height: 100px;
        font-size: 2rem;
    }
    
    .profile-name {
        font-size: 1.5rem;
    }
    
    .info-section {
        padding: 1.5rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 576px) {
    .info-card {
        padding: 1rem;
    }
    
    .info-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-text">
                <h1><i class="fas fa-user-circle"></i>Profil Saya</h1>
                <p>Kelola dan perbarui informasi profil Anda</p>
            </div>
            <div>
                <a href="{{ route('profile.edit') }}" class="btn-edit-profile">
                    <i class="fas fa-edit"></i>
                    <span>Edit Profil</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            
            <!-- Profile Avatar Section -->
            <div class="profile-section">
                <div class="profile-avatar-large">
                    <div class="avatar-circle">
                        {{ strtoupper(substr(explode(' ', auth()->user()->nama_lengkap)[0], 0, 1)) }}{{ strtoupper(substr(explode(' ', auth()->user()->nama_lengkap)[count(explode(' ', auth()->user()->nama_lengkap)) - 1], 0, 1)) }}
                    </div>
                    <div class="status-indicator"></div>
                </div>
                <h2 class="profile-name">{{ auth()->user()->nama_lengkap }}</h2>
                <p class="profile-role">{{ auth()->user()->jabatan ?? 'Karyawan' }}</p>
            </div>

            <!-- Information Section -->
            <div class="info-section">
                <div class="section-header">
                    <i class="fas fa-info-circle"></i>
                    <h3>Informasi Pribadi</h3>
                </div>
                
                <div class="info-grid">
                    
                    <!-- Email -->
                    <div class="info-card primary">
                        <div class="info-card-header">
                            <div class="info-icon primary">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="info-card success">
                        <div class="info-card-header">
                            <div class="info-icon success">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="info-label">No. Handphone</div>
                                <div class="info-value">{{ auth()->user()->no_hp ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Gender -->
                    <div class="info-card danger">
                        <div class="info-card-header">
                            <div class="info-icon danger">
                                <i class="fas fa-venus-mars"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="info-label">Jenis Kelamin</div>
                                <div class="info-value">{{ auth()->user()->jenis_kelamin ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Birth Place -->
                    <div class="info-card warning">
                        <div class="info-card-header">
                            <div class="info-icon warning">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="info-label">Tempat Lahir</div>
                                <div class="info-value">{{ auth()->user()->tempat_lahir ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Birth Date -->
                    <div class="info-card purple">
                        <div class="info-card-header">
                            <div class="info-icon purple">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="info-label">Tanggal Lahir</div>
                                <div class="info-value">
                                    {{ auth()->user()->tanggal_lahir 
                                        ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('d F Y') 
                                        : '-' 
                                    }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Position -->
                    <div class="info-card orange">
                        <div class="info-card-header">
                            <div class="info-icon orange">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="info-label">Jabatan</div>
                                <div class="info-value">{{ auth()->user()->jabatan ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Address - Full Width -->
                    <div class="info-card cyan info-card-full">
                        <div class="info-card-header">
                            <div class="info-icon cyan">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="info-label">Alamat</div>
                                <div class="info-value">{{ auth()->user()->alamat ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Hover effect untuk info cards
    $('.info-card').hover(
        function() {
            $(this).css('transform', 'translateY(-2px)');
        },
        function() {
            $(this).css('transform', 'translateY(0)');
        }
    );

    console.log('✅ Profile Page Loaded');
});
</script>
@endpush