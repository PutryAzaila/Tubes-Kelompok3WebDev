@extends('layouts.dashboard')

@section('title', 'Data Vendor')
@section('page-title', 'Data Vendor')
@section('page-description', 'Kelola data vendor dan supplier')

@section('content')
    <!-- Welcome Header Card -->
    <div class="welcome-header-card mb-4">
        <div class="welcome-header-content">
            <div class="welcome-header-text">
                <h2>Data Vendor</h2>
                <p>Kelola informasi vendor dan supplier untuk kebutuhan pembelian</p>
            </div>
            @role('admin')
            <div class="welcome-header-action mt-3">
                <a href="{{ route('vendor.create') }}" class="btn btn-light-custom">
                    <i class="fas fa-plus-circle me-2"></i>
                    <span>Tambah Vendor</span>
                </a>
            </div>
            @endrole
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-modern alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-check-circle me-3"></i>
            <div class="alert-body">
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-modern alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-3"></i>
            <div class="alert-body">
                <strong>Error!</strong> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif
    
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6 col-md-6">
            <div class="stats-card total-card">
                <div class="stats-card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <div class="stats-card-content">
                    <div class="stats-value">{{ $vendors->count() }}</div>
                    <div class="stats-label">Total Vendor</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="stats-card available-card">
                <div class="stats-card-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="stats-card-content">
                    <div class="stats-value">{{ $kategoris->count() }}</div>
                    <div class="stats-label">Kategori Vendor</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <div class="row g-3 align-items-end">
            <div class="col-lg-6 col-md-6">
                <label class="filter-label">
                    <i class="fas fa-search"></i>
                    <span>Cari Vendor</span>
                </label>
                <div class="input-wrapper">
                    <div class="input-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <input type="text" 
                           id="searchInput"
                           class="form-control-custom" 
                           placeholder="Cari nama vendor atau kontak...">
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <label class="filter-label">
                    <i class="fas fa-tag"></i>
                    <span>Kategori</span>
                </label>
                <select id="filterKategori" class="form-select-custom">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-2 col-md-6">
                <div class="filter-actions">
                    <button type="button" id="resetFilter" class="btn btn-reset">
                        <i class="fas fa-redo"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <h3>Daftar Vendor</h3>
                <p>Total {{ $vendors->count() }} vendor tersedia</p>
            </div>
        </div>
        
        <div class="table-responsive">
            @if($vendors->count() > 0)
            <table id="vendorTable" class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 20%;">Vendor</th>
                        <th style="width: 12%;">Kategori</th>
                        <th style="width: 15%;">Kontak</th>
                        <th style="width: 18%;">Alamat</th>
                        <th style="width: @role('admin')20%@else30%@endrole;">Deskripsi</th>
                        @role('admin')
                        <th style="width: 10%;" class="text-center">Aksi</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $index => $vendor)
                    <tr>
                        <td>
                            <div class="table-number" style="background: linear-gradient(135deg, {{ $index % 2 == 0 ? '#dbeafe' : '#e5e7eb' }} 0%, {{ $index % 2 == 0 ? '#bfdbfe' : '#d1d5db' }} 100%); color: {{ $index % 2 == 0 ? '#1e3a8a' : '#4b5563' }};">
                                {{ $index + 1 }}
                            </div>
                        </td>
                        <td>
                            <div class="vendor-info-cell">
                                <div class="vendor-icon-wrapper">
                                    <i class="fas fa-store"></i>
                                </div>
                                <div class="vendor-details">
                                    <div class="vendor-name">{{ $vendor->nama_vendor }}</div>
                                    <div class="vendor-code">
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $categoryColors = [
                                    0 => ['bg' => 'linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%)', 'text' => '#1e3a8a'],
                                    1 => ['bg' => 'linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%)', 'text' => '#0369a1'],
                                    2 => ['bg' => 'linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%)', 'text' => '#7c3aed'],
                                    3 => ['bg' => 'linear-gradient(135deg, #fef7ff 0%, #fce7f3 100%)', 'text' => '#db2777'],
                                ];
                                $color = $categoryColors[$index % 4];
                            @endphp
                            <div class="category-badge" style="background: {{ $color['bg'] }}; color: {{ $color['text'] }};">
                                <i class="fas fa-tag"></i>
                                <span>{{ $vendor->kategori->nama_kategori ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="contact-info-cell">
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $vendor->no_telp_vendor }}</span>
                                </div>
                                @if($vendor->email_vendor)
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>{{ $vendor->email_vendor }}</span>
                                </div>
                                @endif
                            </div>
                        </td>
                       <td>
                        <div class="address-text" style="color: {{ $index % 2 == 0 ? '#4b5563' : '#6b7280' }};">
                            {{ Str::limit($vendor->alamat_vendor, 60) }}
                        </div>
                    </td>
                    <td>
                        <div class="description-text" style="color: {{ $index % 2 == 0 ? '#4b5563' : '#6b7280' }};">
                            {{ $vendor->deskripsi_vendor ? Str::limit($vendor->deskripsi_vendor, 50) : '-' }}
                        </div>
                    </td>                    
                        @role('admin')
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('vendor.edit', $vendor->id) }}" 
                                   class="btn-action btn-edit" 
                                   title="Edit"
                                   style="background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); color: #92400e;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn-action btn-delete" 
                                        data-id="{{ $vendor->id }}"
                                        data-name="{{ $vendor->nama_vendor }}"
                                        data-code="VEND-{{ str_pad($vendor->id, 4, '0', STR_PAD_LEFT) }}"
                                        title="Hapus"
                                        style="background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%); color: #991b1b;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        @endrole
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h5 style="color: #1f2937;">Tidak Ada Data Vendor</h5>
                <p style="color: #6b7280;">Belum ada vendor yang terdaftar dalam sistem</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Hidden form for delete -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('styles')
<link rel="icon" type="image/png" href="{{ asset('images/transdata-logo.png') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
:root {
    --primary-blue: #1e3a8a;
    --primary-blue-light: #2563eb;
    --orange: #f97316;
    --success-green: #059669;
    --danger-red: #dc2626;
    --warning-yellow: #f59e0b;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Welcome Header Card */
.welcome-header-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
    position: relative;
    overflow: hidden;
}

.welcome-header-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.welcome-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.welcome-header-text h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
}

.welcome-header-text p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
    font-size: 0.9375rem;
}

.welcome-header-action {
    position: relative;
    z-index: 1;
}

.btn-light-custom {
    background: white;
    color: var(--primary-blue);
    border: none;
    padding: 0.875rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
}

.btn-light-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
    color: var(--primary-blue);
}

/* Alert Modern */
.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    box-shadow: var(--shadow);
    border-left: 4px solid transparent;
}

.alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-left-color: var(--success-green);
    color: #065f46;
}

.alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border-left-color: var(--danger-red);
    color: #991b1b;
}

.alert-modern i {
    font-size: 1.25rem;
}

/* Statistics Cards */
.stats-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: var(--shadow-lg);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    border-left: 4px solid transparent;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.stats-card-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    flex-shrink: 0;
}

.total-card {
    border-left-color: var(--primary-blue);
}

.total-card .stats-card-icon {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: var(--primary-blue);
}

.available-card {
    border-left-color: var(--success-green);
}

.available-card .stats-card-icon {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: var(--success-green);
}

.stats-card-content {
    flex: 1;
}

.stats-value {
    font-size: 2.25rem;
    font-weight: 700;
    color: var(--gray-800);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: var(--gray-600);
    font-size: 0.95rem;
    font-weight: 500;
}

/* Filter Card */
.filter-card {
    background: white;
    border-radius: 18px;
    padding: 2rem;
    box-shadow: var(--shadow-lg);
    margin-bottom: 1.5rem;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--gray-700);
    font-size: 0.95rem;
    margin-bottom: 0.75rem;
}

.filter-label i {
    color: var(--primary-blue);
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1.125rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-600);
    font-size: 1.125rem;
    z-index: 2;
}

.form-control-custom {
    width: 100%;
    padding: 0.875rem 1rem 0.875rem 3.25rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    color: var(--gray-800);
}

.form-control-custom:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
}

.form-select-custom {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    color: var(--gray-800);
    cursor: pointer;
}

.form-select-custom:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-reset {
    width: 100%;
    background: white;
    color: var(--gray-700);
    border: 2px solid var(--gray-300);
    padding: 0.875rem 1.25rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-reset:hover {
    background: var(--gray-50);
    border-color: var(--gray-400);
}

/* Table Card */
.table-card {
    background: white;
    border-radius: 18px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.table-card-header {
    padding: 2rem;
    border-bottom: 2px solid var(--gray-100);
    background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
}

.table-card-title h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.table-card-title p {
    color: var(--gray-600);
    font-size: 0.95rem;
    margin-bottom: 0;
}

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}

.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom thead {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
}

.table-custom thead th {
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8125rem;
    letter-spacing: 0.05em;
    padding: 1.25rem 1.5rem;
    border: none;
    white-space: nowrap;
    position: relative;
}

.table-custom thead th:first-child {
    border-top-left-radius: 8px;
}

.table-custom thead th:last-child {
    border-top-right-radius: 8px;
}

.table-custom thead th::after {
    content: '';
    position: absolute;
    right: 0;
    top: 20%;
    height: 60%;
    width: 1px;
    background: rgba(255, 255, 255, 0.2);
}

.table-custom thead th:last-child::after {
    display: none;
}

.table-custom tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid var(--gray-100);
}

.table-custom tbody tr:nth-child(even) {
    background: linear-gradient(135deg, rgba(249, 250, 251, 0.5) 0%, rgba(243, 244, 246, 0.5) 100%);
}

.table-custom tbody tr:nth-child(odd) {
    background: white;
}

.table-custom tbody tr:hover {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    transform: translateX(4px);
}

.table-custom tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    border: none;
    position: relative;
}

.table-custom tbody td::after {
    content: '';
    position: absolute;
    right: 0;
    top: 20%;
    height: 60%;
    width: 1px;
    background: var(--gray-200);
}

.table-custom tbody td:last-child::after {
    display: none;
}

.table-number {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.95rem;
    margin: 0 auto;
}

/* Vendor Info Cell */
.vendor-info-cell {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.vendor-icon-wrapper {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.vendor-details {
    flex: 1;
}

.vendor-name {
    font-weight: 600;
    font-size: 1rem;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.vendor-code {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--gray-500);
}

.vendor-code i {
    font-size: 0.75rem;
}

/* Category Badge */
.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.category-badge:hover {
    transform: scale(1.05);
    box-shadow: var(--shadow);
}

/* Contact Info Cell */
.contact-info-cell {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    font-size: 0.9375rem;
}

.contact-item i {
    color: var(--gray-400);
    width: 16px;
    text-align: center;
    font-size: 0.875rem;
}

/* Address Text */
.address-text {
    font-size: 0.9375rem;
    line-height: 1.5;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9375rem;
    text-decoration: none;
}

.btn-edit {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.btn-edit:hover {
    background: linear-gradient(135deg, #fde68a 0%, #fcd34d 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-delete {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 3rem;
    color: var(--gray-600);
}

.empty-state h5 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
}

.empty-state p {
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

.btn-primary-custom {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    color: white;
    border: none;
    padding: 1rem 2rem;
    border-radius: 14px;
    font-weight: 600;
    font-size: 1.05rem;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(30, 58, 138, 0.3);
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(30, 58, 138, 0.4);
    color: white;
}

/* Responsive */
@media (max-width: 992px) {
    .welcome-header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .welcome-header-action {
        margin-top: 1rem;
    }
}

@media (max-width: 768px) {
    .welcome-header-card {
        padding: 1.5rem;
    }
    
    .welcome-header-text h2 {
        font-size: 1.5rem;
    }
    
    .stats-card {
        padding: 1.25rem;
    }
    
    .stats-card-icon {
        width: 50px;
        height: 50px;
        font-size: 1.5rem;
    }
    
    .stats-value {
        font-size: 1.75rem;
    }
    
    .filter-card {
        padding: 1.5rem;
    }
    
    .table-card-header {
        padding: 1.5rem;
    }
    
    .table-custom thead th,
    .table-custom tbody td {
        padding: 1rem;
    }
    
    .table-custom thead th::after,
    .table-custom tbody td::after {
        display: none;
    }
    
    .pagination-wrapper {
        flex-direction: column;
        align-items: center;
    }
}

@media (max-width: 576px) {
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-action {
        width: 100%;
    }
    
    .category-badge,
    .status-badge {
        padding: 0.5rem 0.75rem;
        font-size: 0.8125rem;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Delete confirmation with SweetAlert2
    $('.btn-delete').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        
        Swal.fire({
            title: 'Hapus Vendor?',
            html: `Anda yakin ingin menghapus vendor <strong>"${name}"</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
            reverseButtons: true,
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-custom-title',
                htmlContainer: 'swal-custom-html',
                confirmButton: 'swal-custom-confirm',
                cancelButton: 'swal-custom-cancel'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Submit form
                const form = $('#deleteForm');
                form.attr('action', '/vendor/' + id);
                form.submit();
            }
        });
    });

    // Show success message
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 3000,
            showConfirmButton: false,
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-custom-title'
            }
        });
    @endif

    // Show error message
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            confirmButtonColor: '#dc2626',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'swal-custom-popup',
                title: 'swal-custom-title',
                confirmButton: 'swal-custom-confirm'
            },
            buttonsStyling: false
        });
    @endif
});
</script>

<style>
/* SweetAlert2 Custom Styles */
.swal-custom-popup {
    border-radius: 20px !important;
    padding: 2rem !important;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%) !important;
}

.swal-custom-title {
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    color: var(--gray-800) !important;
}

.swal-custom-html {
    font-size: 1.05rem !important;
    color: var(--gray-600) !important;
    line-height: 1.6 !important;
}

.swal-custom-confirm {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
    color: white !important;
    border: none !important;
    padding: 0.875rem 2rem !important;
    border-radius: 12px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    transition: all 0.3s ease !important;
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3) !important;
}

.swal-custom-confirm:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4) !important;
}

.swal-custom-cancel {
    background: white !important;
    color: var(--gray-700) !important;
    border: 2px solid var(--gray-300) !important;
    padding: 0.875rem 2rem !important;
    border-radius: 12px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    transition: all 0.3s ease !important;
}

.swal-custom-cancel:hover {
    background: var(--gray-50) !important;
    border-color: var(--gray-400) !important;
}

.swal2-icon {
    border-width: 3px !important;
}

.swal2-success .swal2-success-ring {
    border-color: rgba(5, 150, 105, 0.3) !important;
}

.swal2-success [class^=swal2-success-line] {
    background-color: #059669 !important;
}

.swal2-error [class^=swal2-x-mark-line] {
    background-color: #dc2626 !important;
}
</style>
@endpush