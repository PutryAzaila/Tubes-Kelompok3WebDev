@extends('layouts.dashboard')

@section('title', 'Kategori Vendor')
@section('page-title', 'Kategori Vendor')
@section('page-description', 'Kelola kategori vendor untuk sistem inventaris')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="header-wrapper">
                <div class="header-content">
                    <div class="header-text">
                        <div class="d-flex align-items-center mb-2">
                            <div class="header-icon">
                                <i class="fas fa-tags"></i>
                            </div>
                            <h1 class="header-title mb-0">Kategori Vendor</h1>
                        </div>
                        <p class="header-subtitle">Kelola dan organisir kategori vendor dengan mudah</p>
                    </div>
                    <div class="header-actions">
                        <a href="{{ route('kategori-vendor.create') }}" class="btn btn-primary-gradient">
                            <i class="fas fa-plus-circle me-2"></i>
                            <span>Tambah Kategori</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success-custom alert-dismissible fade show" role="alert">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="alert-text">
                <strong>Berhasil!</strong>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger-custom alert-dismissible fade show" role="alert">
        <div class="alert-content">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-text">
                <strong>Error!</strong>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Statistics & Search Section -->
    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="stats-card stats-card-blue">
                <div class="stats-card-content">
                    <div class="stats-icon-wrapper">
                        <div class="stats-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                    </div>
                    <div class="stats-info">
                        <h2 class="stats-value">{{ $kategoris->count() }}</h2>
                        <p class="stats-label">Total Kategori</p>
                        <div class="stats-badge">
                            <i class="fas fa-arrow-up"></i> Aktif
                        </div>
                    </div>
                </div>
                <div class="stats-decoration"></div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="stats-card stats-card-green">
                <div class="stats-card-content">
                    <div class="stats-icon-wrapper">
                        <div class="stats-icon">
                            <i class="fas fa-store"></i>
                        </div>
                    </div>
                    <div class="stats-info">
                        <h2 class="stats-value">{{ $kategoris->sum('vendors_count') }}</h2>
                        <p class="stats-label">Total Vendor</p>
                        <div class="stats-badge">
                            <i class="fas fa-check-circle"></i> Terdaftar
                        </div>
                    </div>
                </div>
                <div class="stats-decoration"></div>
            </div>
        </div>

        <div class="col-xl-4 col-md-12">
            <div class="search-card">
                <div class="search-wrapper">
                    <div class="search-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" 
                           class="search-input" 
                           id="searchInput"
                           placeholder="Cari kategori vendor...">
                    <button class="search-clear" id="clearSearch" style="display: none;">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="search-info">
                    <i class="fas fa-info-circle"></i>
                    <span id="searchResultText">Menampilkan semua kategori</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Grid -->
    <div class="row g-4" id="kategoriGrid">
        @forelse($kategoris as $kategori)
        <div class="col-xl-3 col-lg-4 col-md-6 kategori-item" data-kategori-name="{{ strtolower($kategori->nama_kategori) }}">
            <div class="kategori-card">
                <div class="kategori-card-header">
                    <div class="kategori-badge">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div class="dropdown">
                        <button class="btn-action" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('kategori-vendor.edit', $kategori->id) }}">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit Kategori</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <button type="button" class="dropdown-item text-danger" 
                                        onclick="confirmDelete({{ $kategori->id }}, '{{ $kategori->nama_kategori }}', {{ $kategori->vendors_count }})">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Hapus Kategori</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="kategori-card-body">
                    <h3 class="kategori-title" title="{{ $kategori->nama_kategori }}">
                        {{ $kategori->nama_kategori }}
                    </h3>
                    
                    <div class="vendor-count">
                        <div class="vendor-count-icon">
                            <i class="fas fa-store-alt"></i>
                        </div>
                        <div class="vendor-count-text">
                            <span class="count-number">{{ $kategori->vendors_count }}</span>
                            <span class="count-label">Vendor Terdaftar</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-state-content">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Kategori</h3>
                    <p class="empty-text">Mulai kelola vendor Anda dengan membuat kategori pertama</p>
                    <a href="{{ route('kategori-vendor.create') }}" class="btn btn-primary-gradient">
                        <i class="fas fa-plus-circle me-2"></i>
                        Buat Kategori Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- No Results Message -->
    <div class="row" id="noResults" style="display: none;">
        <div class="col-12">
            <div class="empty-state">
                <div class="empty-state-content">
                    <div class="empty-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3 class="empty-title">Tidak Ada Hasil</h3>
                    <p class="empty-text">Kategori yang Anda cari tidak ditemukan</p>
                    <button class="btn btn-primary-gradient" onclick="clearSearchManual()">
                        <i class="fas fa-redo me-2"></i>
                        Reset Pencarian
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-custom">
            <div class="modal-body">
                <div class="modal-icon-wrapper">
                    <div class="modal-icon modal-icon-danger">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                </div>
                <h4 class="modal-title-custom">Konfirmasi Hapus</h4>
                <p class="modal-text">
                    Apakah Anda yakin ingin menghapus kategori <strong id="kategoriName"></strong>?
                    <span id="vendorWarning" class="warning-text"></span>
                </p>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-actions">
                        <button type="button" class="btn btn-secondary-outline" data-bs-dismiss="modal">
                            <i class="fas fa-times-circle me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-danger-gradient">
                            <i class="fas fa-trash-alt me-2"></i>Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary-blue: #1e40af;
    --primary-green: #059669;
    --primary-orange: #ea580c;
    --danger-red: #dc2626;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-600: #4b5563;
    --gray-800: #1f2937;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Header Section */
.header-wrapper {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: var(--shadow-xl);
    position: relative;
    overflow: hidden;
}

.header-wrapper::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    z-index: 0;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
    position: relative;
    z-index: 1;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.header-icon i {
    font-size: 2rem;
    color: white;
}

.header-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
}

.header-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.1rem;
    margin-top: 0.5rem;
    margin-bottom: 0;
}

.btn-primary-gradient {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);
    text-decoration: none;
}

.btn-primary-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(249, 115, 22, 0.5);
    color: white;
}

/* Alert Styles */
.alert-success-custom,
.alert-danger-custom {
    border: none;
    border-radius: 16px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    box-shadow: var(--shadow-lg);
}

.alert-success-custom {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
}

.alert-danger-custom {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
}

.alert-content {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.alert-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.alert-success-custom .alert-icon {
    background: rgba(5, 150, 105, 0.1);
    color: #059669;
}

.alert-danger-custom .alert-icon {
    background: rgba(220, 38, 38, 0.1);
    color: #dc2626;
}

.alert-text strong {
    display: block;
    margin-bottom: 0.25rem;
    font-weight: 600;
}

/* Statistics Cards */
.stats-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: var(--shadow-lg);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    height: 100%;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.stats-card-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.stats-icon-wrapper {
    flex-shrink: 0;
}

.stats-icon {
    width: 70px;
    height: 70px;
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: white;
    position: relative;
}

.stats-card-blue .stats-icon {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    box-shadow: 0 8px 20px rgba(30, 64, 175, 0.3);
}

.stats-card-green .stats-icon {
    background: linear-gradient(135deg, #059669 0%, #10b981 100%);
    box-shadow: 0 8px 20px rgba(5, 150, 105, 0.3);
}

.stats-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--gray-800);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: var(--gray-600);
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
    font-weight: 500;
}

.stats-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.875rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
}

.stats-card-blue .stats-badge {
    background: rgba(30, 64, 175, 0.1);
    color: var(--primary-blue);
}

.stats-card-green .stats-badge {
    background: rgba(5, 150, 105, 0.1);
    color: var(--primary-green);
}

.stats-decoration {
    position: absolute;
    bottom: -20px;
    right: -20px;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    opacity: 0.05;
}

.stats-card-blue .stats-decoration {
    background: var(--primary-blue);
}

.stats-card-green .stats-decoration {
    background: var(--primary-green);
}

/* Search Card */
.search-card {
    background: white;
    border-radius: 20px;
    padding: 1.75rem;
    box-shadow: var(--shadow-lg);
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.search-wrapper {
    position: relative;
    margin-bottom: 0.75rem;
}

.search-icon {
    position: absolute;
    left: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-600);
    font-size: 1.25rem;
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 1rem 3.5rem 1rem 3.75rem;
    border: 2px solid var(--gray-200);
    border-radius: 14px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    color: var(--gray-800);
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(30, 64, 175, 0.1);
}

.search-clear {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: var(--gray-200);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    color: var(--gray-600);
}

.search-clear:hover {
    background: var(--gray-300);
    color: var(--gray-800);
}

.search-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    font-size: 0.875rem;
}

.search-info i {
    color: var(--primary-blue);
}

/* Kategori Cards */
.kategori-card {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.kategori-card:hover {
    transform: translateY(-8px);
    box-shadow: var(--shadow-xl);
}

.kategori-card-header {
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid var(--gray-100);
}

.kategori-badge {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    background: var(--gray-100);
    color: var(--gray-600);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    cursor: pointer;
}

.btn-action:hover {
    background: var(--gray-200);
    color: var(--gray-800);
}

.kategori-card-body {
    padding: 1.5rem;
    flex: 1;
}

.kategori-title {
    font-size: 1.35rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 1.25rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.vendor-count {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 14px;
}

.vendor-count-icon {
    width: 44px;
    height: 44px;
    background: rgba(59, 130, 246, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-blue);
    font-size: 1.25rem;
}

.vendor-count-text {
    display: flex;
    flex-direction: column;
}

.count-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--primary-blue);
    line-height: 1;
}

.count-label {
    font-size: 0.8rem;
    color: var(--gray-600);
    margin-top: 0.25rem;
}

/* Dropdown Menu */
.dropdown-menu {
    border: none;
    border-radius: 14px;
    box-shadow: var(--shadow-xl);
    padding: 0.5rem;
    min-width: 200px;
}

.dropdown-item {
    border-radius: 10px;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.dropdown-item i {
    font-size: 1.1rem;
}

.dropdown-item:hover {
    background: var(--gray-100);
}

.dropdown-item.text-danger:hover {
    background: rgba(220, 38, 38, 0.1);
}

/* Empty State */
.empty-state {
    min-height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow);
}

.empty-state-content {
    text-align: center;
    max-width: 400px;
    padding: 3rem;
}

.empty-icon {
    width: 140px;
    height: 140px;
    margin: 0 auto 2rem;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-icon i {
    font-size: 4.5rem;
    color: var(--gray-300);
}

.empty-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.75rem;
}

.empty-text {
    color: var(--gray-600);
    font-size: 1.05rem;
    margin-bottom: 2rem;
}

/* Modal */
.modal-custom {
    border: none;
    border-radius: 20px;
    box-shadow: var(--shadow-xl);
}

.modal-custom .modal-body {
    padding: 2.5rem;
    text-align: center;
}

.modal-icon-wrapper {
    margin-bottom: 1.5rem;
}

.modal-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
}

.modal-icon-danger {
    background: rgba(220, 38, 38, 0.1);
    color: var(--danger-red);
}

.modal-title-custom {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 1rem;
}

.modal-text {
    color: var(--gray-600);
    font-size: 1.05rem;
    margin-bottom: 2rem;
    line-height: 1.6;
}

.warning-text {
    display: block;
    margin-top: 1rem;
    color: var(--danger-red);
    font-weight: 600;
}

.modal-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.btn-secondary-outline {
    background: white;
    border: 2px solid var(--gray-300);
    color: var(--gray-700);
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-secondary-outline:hover {
    background: var(--gray-50);
    border-color: var(--gray-400);
}

.btn-danger-gradient {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.2s ease;
    box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
}

.btn-danger-gradient:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-value {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .header-title {
        font-size: 2rem;
    }
    
    .header-actions {
        width: 100%;
    }
    
    .btn-primary-gradient {
        width: 100%;
        justify-content: center;
    }
    
    .stats-value {
        font-size: 1.75rem;
    }
    
    .kategori-title {
        font-size: 1.15rem;
    }
    
    .modal-actions {
        flex-direction: column;
    }
    
    .modal-actions .btn {
        width: 100%;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Delete Confirmation
function confirmDelete(id, name, vendorCount) {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    const form = document.getElementById('deleteForm');
    const nameElement = document.getElementById('kategoriName');
    const warningElement = document.getElementById('vendorWarning');
    
    form.action = `/kategori-vendor/${id}`;
    nameElement.textContent = name;
    
    if (vendorCount > 0) {
        warningElement.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>Perhatian: Kategori ini memiliki ${vendorCount} vendor terkait`;
    } else {
        warningElement.textContent = '';
    }
    
    modal.show();
}

// Search Functionality
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const clearButton = document.getElementById('clearSearch');
    const searchResultText = document.getElementById('searchResultText');
    const kategoriItems = document.querySelectorAll('.kategori-item');
    const noResults = document.getElementById('noResults');
    const kategoriGrid = document.getElementById('kategoriGrid');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        let visibleCount = 0;
        
        if (searchTerm === '') {
            clearButton.style.display = 'none';
            kategoriItems.forEach(item => {
                item.style.display = 'block';
            });
            searchResultText.textContent = 'Menampilkan semua kategori';
            noResults.style.display = 'none';
            kategoriGrid.style.display = 'flex';
            return;
        }
        
        clearButton.style.display = 'flex';
        
        kategoriItems.forEach(item => {
            const kategoriName = item.getAttribute('data-kategori-name');
            if (kategoriName.includes(searchTerm)) {
                item.style.display = 'block';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        if (visibleCount === 0) {
            searchResultText.textContent = 'Tidak ada hasil ditemukan';
            noResults.style.display = 'block';
            kategoriGrid.style.display = 'none';
        } else {
            searchResultText.textContent = `Menampilkan ${visibleCount} kategori`;
            noResults.style.display = 'none';
            kategoriGrid.style.display = 'flex';
        }
    });
    
    clearButton.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });
});

// Clear Search Manual
function clearSearchManual() {
    const searchInput = document.getElementById('searchInput');
    searchInput.value = '';
    searchInput.dispatchEvent(new Event('input'));
    searchInput.focus();
}
</script>
@endpush
@endsection