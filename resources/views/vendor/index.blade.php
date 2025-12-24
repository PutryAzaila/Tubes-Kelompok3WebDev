@extends('layouts.dashboard')

@section('title', 'Data Vendor')

@section('page-title', 'Data Vendor')
@section('page-subtitle', 'Kelola data vendor dan supplier')

@push('styles')
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

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
    max-width: 600px;
}

.btn-add {
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
    white-space: nowrap;
}

.btn-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    color: var(--primary-dark);
}

.btn-add i {
    font-size: 1.1rem;
}

/* ===== ALERTS ===== */
.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-left: 4px solid transparent;
}

.alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-left-color: var(--success);
    color: #065f46;
}

.alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border-left-color: var(--danger);
    color: #991b1b;
}

.alert-modern i {
    font-size: 1.25rem;
    margin-right: 0.75rem;
}

.alert-modern .alert-body {
    flex: 1;
}

/* ===== STATS CARDS ===== */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.25rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
    transition: transform 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.stat-card-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.25rem;
}

.stat-card-icon.primary {
    background: linear-gradient(135deg, var(--primary-light) 0%, #bfdbfe 100%);
    color: var(--primary);
}

.stat-card-icon.success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: var(--success);
}

.stat-card h3 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.stat-card p {
    color: var(--gray-500);
    margin: 0;
    font-size: 0.875rem;
}

/* ===== FILTER SECTION ===== */
.filter-section {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    margin-bottom: 2rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
    gap: 1rem;
}

.filter-header h3 {
    color: var(--gray-800);
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.filter-header h3 i {
    color: var(--primary);
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 400px;
}

.search-box input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 3rem;
    border: 1px solid var(--gray-300);
    border-radius: 12px;
    font-size: 0.9375rem;
    color: var(--gray-700);
    transition: all 0.2s ease;
}

.search-box input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.search-box i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
}

.filter-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.filter-group label {
    display: block;
    color: var(--gray-600);
    font-size: 0.875rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-group label i {
    color: var(--primary);
    font-size: 0.875rem;
}

.filter-group select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--gray-300);
    border-radius: 12px;
    font-size: 0.9375rem;
    color: var(--gray-700);
    background: white;
    cursor: pointer;
    transition: all 0.2s ease;
}

.filter-group select:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* ===== TABLE SECTION ===== */
.table-section {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border: 1px solid var(--gray-200);
}

.table-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
}

.table-header h3 {
    color: var(--gray-800);
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-header h3 i {
    color: var(--primary);
}

.table-container {
    padding: 0;
}

.table-modern {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin: 0;
}

.table-modern thead {
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
}

.table-modern thead th {
    padding: 1rem 1.5rem;
    color: var(--gray-600);
    font-weight: 600;
    font-size: 0.8125rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid var(--gray-200);
    white-space: nowrap;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
    border-top: 1px solid transparent;
}

.table-modern tbody tr:hover {
    background-color: var(--gray-50);
    transform: translateX(4px);
}

.table-modern tbody td {
    padding: 1.25rem 1.5rem;
    color: var(--gray-700);
    font-size: 0.9375rem;
    vertical-align: middle;
    border-top: 1px solid var(--gray-100);
}

/* ===== VENDOR AVATAR ===== */
.vendor-avatar {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.vendor-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.vendor-info h6 {
    color: var(--gray-800);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.vendor-info small {
    color: var(--gray-500);
    font-size: 0.8125rem;
}

/* ===== BADGES ===== */
.badge {
    padding: 0.5rem 0.875rem;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}

.badge i {
    font-size: 0.75rem;
}

.badge-primary {
    background: linear-gradient(135deg, var(--primary-light) 0%, #bfdbfe 100%);
    color: var(--primary);
    border: 1px solid rgba(37, 99, 235, 0.2);
}

.badge-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    border: 1px solid rgba(16, 185, 129, 0.2);
}

.badge-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    border: 1px solid rgba(245, 158, 11, 0.2);
}

.badge-info {
    background: linear-gradient(135deg, #cffafe 0%, #a5f3fc 100%);
    color: #155e75;
    border: 1px solid rgba(6, 182, 212, 0.2);
}

/* ===== CONTACT INFO ===== */
.contact-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    margin-bottom: 0.25rem;
}

.contact-info i {
    color: var(--gray-400);
    width: 16px;
    text-align: center;
}

/* ===== ADDRESS ===== */
.address-cell {
    max-width: 250px;
}

.address-text {
    color: var(--gray-600);
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ===== ACTION BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    color: white;
    font-size: 0.875rem;
}

.btn-action i {
    font-size: 0.875rem;
}

.btn-edit {
    background: linear-gradient(135deg, var(--warning) 0%, #d97706 100%);
}

.btn-edit:hover {
    background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-delete {
    background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
}

.btn-delete:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* ===== EMPTY STATE ===== */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: var(--gray-400);
    font-size: 2rem;
}

.empty-state h4 {
    color: var(--gray-700);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: var(--gray-500);
    margin-bottom: 1.5rem;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.btn-empty {
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
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
    
    .btn-add {
        width: 100%;
        justify-content: center;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .filter-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box {
        max-width: 100%;
    }
    
    .filter-options {
        grid-template-columns: 1fr;
    }
    
    .table-modern {
        font-size: 0.875rem;
    }
    
    .table-modern thead th,
    .table-modern tbody td {
        padding: 1rem;
    }
    
    .vendor-icon {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .action-buttons {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@media (max-width: 576px) {
    .table-modern {
        display: block;
        overflow-x: auto;
    }
    
    .badge {
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
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
                <h1><i class="fas fa-users"></i>Data Vendor</h1>
                <p>Kelola informasi vendor dan supplier untuk kebutuhan pembelian</p>
            </div>
            <div>
                {{-- TOMBOL TAMBAH HANYA UNTUK ADMIN --}}
                @role('admin')
                <a href="{{ route('vendor.create') }}" class="btn btn-add">
                    <i class="fas fa-plus"></i>
                    <span>Tambah Vendor</span>
                </a>
                @endrole
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle"></i>
            <div class="alert-body">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle"></i>
            <div class="alert-body">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-card-icon primary">
                <i class="fas fa-building"></i>
            </div>
            <h3>{{ $vendors->count() }}</h3>
            <p>Total Vendor</p>
        </div>
        <div class="stat-card">
            <div class="stat-card-icon success">
                <i class="fas fa-tag"></i>
            </div>
            <h3>{{ $kategoris->count() }}</h3>
            <p>Kategori Vendor</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <div class="filter-header">
            <h3><i class="fas fa-filter"></i>Filter & Pencarian</h3>
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Cari vendor...">
            </div>
        </div>
        
        <div class="filter-options">
            <div class="filter-group">
                <label for="filterKategori"><i class="fas fa-tag"></i>Kategori</label>
                <select id="filterKategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header">
            <h3><i class="fas fa-list"></i>Daftar Vendor</h3>
        </div>
        
        <div class="table-container">
            @if($vendors->count() > 0)
            <div class="table-responsive">
                <table id="vendorTable" class="table table-modern">
                    <thead>
                        <tr>
                            <th width="60">NO</th>
                            <th>VENDOR</th>
                            <th>KATEGORI</th>
                            <th>KONTAK</th>
                            <th>ALAMAT</th>
                            {{-- KOLOM AKSI HANYA UNTUK ADMIN --}}
                            @role('admin')
                            <th class="text-end" width="100">AKSI</th>
                            @endrole
                        </tr>
                    </thead>
                   <tbody>
                    @foreach($vendors as $index => $vendor)
                    <tr>
                        <td class="text-center fw-bold">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="vendor-avatar">
                                <div class="vendor-icon">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="vendor-info">
                                    <h6 class="mb-1">{{ $vendor->nama_vendor }}</h6>
                                    <small>VEND-{{ str_pad($vendor->id, 4, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $badgeClasses = ['badge-primary', 'badge-success', 'badge-warning', 'badge-info'];
                                $badgeClass = $badgeClasses[$index % 4];
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                <i class="fas fa-tag"></i>
                                {{ $vendor->kategori->nama_kategori ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="contact-info">
                                <i class="fas fa-phone"></i>
                                <span>{{ $vendor->no_telp_vendor }}</span>
                            </div>
                            @if($vendor->email_vendor)
                            <div class="contact-info">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $vendor->email_vendor }}</span>
                            </div>
                            @endif
                        </td>
                        <td class="address-cell">
                            <span class="address-text" title="{{ $vendor->alamat_vendor }}">
                                {{ $vendor->alamat_vendor }}
                            </span>
                        </td>
                        
                        {{-- TOMBOL AKSI HANYA UNTUK ADMIN --}}
                        @role('admin')
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('vendor.edit', $vendor->id) }}" 
                                class="btn btn-action btn-edit" 
                                title="Edit vendor">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('vendor.destroy', $vendor->id) }}" 
                                    method="POST" 
                                    class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-action btn-delete" 
                                            title="Hapus vendor">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4>Belum Ada Data Vendor</h4>
                <p>
                    @role('admin')
                    Mulai kelola vendor Anda dengan menambahkan data vendor pertama
                    @else
                    Belum ada data vendor tersedia
                    @endrole
                </p>
                @role('admin')
                <a href="{{ route('vendor.create') }}" class="btn btn-primary btn-empty">
                    <i class="fas fa-plus me-2"></i>Tambah Vendor
                </a>
                @endrole
            </div>
            @endif
        </div>
    </div>

</div>
@endsection
@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#vendorTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json',
            search: "_INPUT_",
            searchPlaceholder: "Cari vendor...",
            lengthMenu: "Tampilkan _MENU_ vendor",
            info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ vendor",
            infoEmpty: "Menampilkan 0 sampai 0 dari 0 vendor",
            infoFiltered: "(disaring dari _MAX_ total vendor)",
            zeroRecords: "Tidak ditemukan vendor yang sesuai",
            emptyTable: "Tidak ada data vendor tersedia",
            paginate: {
                first: "‹‹",
                last: "››",
                next: "›",
                previous: "‹"
            }
        },
        order: [[0, 'asc']],
        pageLength: 10,
        lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]],
        columnDefs: [
            @role('admin')
            { orderable: false, targets: [5] },
            @else
            { orderable: false, targets: [] },
            @endrole
            { className: "text-center", targets: [0] },
            @role('admin')
            { className: "text-end", targets: [5] }
            @endrole
        ],
        initComplete: function() {
            $('.dataTables_length select').addClass('form-select form-select-sm');
            $('.dataTables_filter input').addClass('form-control form-control-sm');
            $('.dataTables_filter').hide();
            
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });
        },
        drawCallback: function() {
            $('#vendorTable tbody tr').hover(
                function() {
                    $(this).css('transform', 'translateX(4px)');
                },
                function() {
                    $(this).css('transform', 'translateX(0)');
                }
            );
        }
    });

    // Filter by Category
    $('#filterKategori').on('change', function() {
        var kategori = $(this).val();
        table.column(2).search(kategori).draw();
    });

    // Delete Confirmation - HANYA UNTUK ADMIN
    @role('admin')
    $(document).on('submit', '.delete-form', function(e) {
        e.preventDefault();
        var form = this;
        var vendorName = $(this).closest('tr').find('.vendor-info h6').text();
        var vendorCode = $(this).closest('tr').find('.vendor-info small').text();
        
        Swal.fire({
            title: 'Hapus Vendor?',
            html: `
                <div class="text-center">
                    <i class="fas fa-trash text-danger mb-3" style="font-size: 3rem;"></i>
                    <p class="mb-2">Anda akan menghapus vendor:</p>
                    <h6 class="mb-1">${vendorName}</h6>
                    <small class="text-muted">${vendorCode}</small>
                    <p class="text-danger mt-3 mb-0"><small>Data yang dihapus tidak dapat dikembalikan</small></p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'border-0 shadow-lg',
                confirmButton: 'btn btn-danger px-4 py-2',
                cancelButton: 'btn btn-outline-secondary px-4 py-2'
            },
            buttonsStyling: false,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Sedang menghapus data vendor',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                form.submit();
            }
        });
    });
    @endrole

    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Add click effect to action buttons
    @role('admin')
    $(document).on('mousedown', '.btn-action', function() {
        $(this).css('transform', 'scale(0.95)');
    }).on('mouseup mouseleave', '.btn-action', function() {
        $(this).css('transform', '');
    });
    @endrole

    console.log('✅ Vendor Management System Loaded');
    console.log('📊 Total Vendors:', {{ $vendors->count() }});
});
</script>
@endpush