@extends('layouts.dashboard')

@section('title', 'Purchase Order')
@section('page-title', 'Purchase Order')
@section('page-subtitle', 'Kelola Purchase Order perusahaan')

@push('styles')
<link rel="icon" type="image/png" href="{{ asset('images/transdata-logo.png') }}">
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- jsPDF & jsPDF-AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<!-- SheetJS for Excel -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
/* Welcome Header Card */
.welcome-header-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
    margin-bottom: 2rem;
}

.welcome-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
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

/* Statistics Cards */
.stat-card {
    border: none;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    height: 100%;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    opacity: 0.1;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.15);
}

.stat-card:hover::before {
    transform: scale(1.5);
}

.stat-card.stat-primary {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    color: white;
}

.stat-card.stat-primary::before {
    background: #2563eb;
}

.stat-card.stat-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #f97316 100%);
    color: white;
}

.stat-card.stat-warning::before {
    background: #f97316;
}

.stat-card.stat-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.stat-card.stat-success::before {
    background: #10b981;
}

.stat-card.stat-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

.stat-card.stat-danger::before {
    background: #ef4444;
}

.stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 16px;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.stat-icon {
    font-size: 1.75rem;
}

.stat-label {
    font-size: 0.875rem;
    opacity: 0.95;
    font-weight: 500;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
}

/* Card Modern */
.card-modern {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.card-modern .card-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border: none;
    padding: 1.25rem 1.5rem;
}

.card-modern .card-header h6 {
    color: white;
    margin: 0;
    font-weight: 600;
    font-size: 1.1rem;
}

.card-modern .card-body {
    padding: 0;
}

/* Button Modern */
.btn-modern {
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
    transition: all 0.3s ease;
    border: none;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
}

.btn-primary.btn-modern {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
}

/* Filter Section */
.filter-section {
    background: white;
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 1.5rem;
}

.filter-controls {
    display: flex;
    gap: 1rem;
    align-items: center;
    flex-wrap: wrap;
}

.filter-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.filter-item label {
    font-weight: 600;
    color: #374151;
    margin: 0;
    white-space: nowrap;
}

.filter-item select,
.filter-item input {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.625rem 1rem;
    transition: all 0.3s ease;
    min-width: 180px;
}

.filter-item select:focus,
.filter-item input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

.btn-filter {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.625rem 1.25rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    color: white;
}

.btn-reset {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.625rem 1.25rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-reset:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
    color: white;
}

/* Table Modern - SUPER FIXED */
.table-modern {
    margin: 0;
    width: 100%;
}

.table-modern thead {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
}

.table-modern thead th {
    border: none !important;
    font-weight: 600 !important;
    font-size: 0.875rem !important;
    padding: 1.25rem 1rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.5px !important;
    color: #ffffff !important; /* SUPER FIXED: Paksa warna putih */
    background: transparent !important;
    white-space: nowrap !important;
    vertical-align: middle !important;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.table-modern tbody tr:hover {
    background: linear-gradient(90deg, #f8f9ff 0%, #ffffff 100%);
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.table-modern tbody td {
    padding: 1.25rem 1rem;
    vertical-align: middle;
    color: #374151;
}

/* Avatar */
.avatar-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.avatar-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.avatar-icon.bg-primary-subtle {
    background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
    color: #2563eb;
}

.avatar-text {
    font-weight: 600;
    color: #1f2937;
}

/* Badge Status */
.badge-code {
    background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
    color: #1e40af;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.875rem;
    letter-spacing: 0.5px;
}

.badge-items {
    background: linear-gradient(135deg, #ddd6fe 0%, #e0e7ff 100%);
    color: #5b21b6;
    padding: 0.5rem 0.875rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.8125rem;
}

.badge-status {
    padding: 0.625rem 1.125rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.8125rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-status i {
    font-size: 0.875rem;
}

.badge-status.badge-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
    box-shadow: 0 2px 8px rgba(245, 158, 11, 0.2);
}

.badge-status.badge-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
}

.badge-status.badge-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
    box-shadow: 0 2px 8px rgba(239, 68, 68, 0.2);
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.btn-action:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.btn-action.btn-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    color: white;
}

.btn-action.btn-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
}

.btn-action.btn-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
}

/* Empty State */
.empty-state {
    padding: 4rem 2rem;
    text-align: center;
}

.empty-state-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-state-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
}

.empty-state-text {
    color: #9ca3af;
    margin-bottom: 1.5rem;
}

/* Alert Custom */
.alert-custom {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: slideInDown 0.3s ease;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-custom.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.alert-custom.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.alert-custom i {
    font-size: 1.25rem;
}

/* Responsive */
@media (max-width: 991px) {
    .welcome-header-card {
        padding: 1.5rem;
    }
    
    .welcome-header-illustration {
        display: none;
    }
    
    .stat-value {
        font-size: 2rem;
    }
    
    .filter-controls {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-item {
        flex-direction: column;
        align-items: stretch;
    }
    
    .filter-item select,
    .filter-item input {
        width: 100%;
        min-width: auto;
    }
}

@media (max-width: 575px) {
    .welcome-header-card {
        padding: 1.25rem;
    }
    
    .welcome-header-text h2 {
        font-size: 1.5rem;
    }
    
    .btn-modern {
        width: 100%;
    }
    
    .action-buttons {
        flex-direction: column;
    }
}
/* Export Buttons */
.btn-group .btn-modern {
    border-radius: 0;
}

.btn-group .btn-modern:first-child {
    border-top-left-radius: 12px;
    border-bottom-left-radius: 12px;
}

.btn-group .btn-modern:last-child {
    border-top-right-radius: 12px;
    border-bottom-right-radius: 12px;
}

.btn-success.btn-modern {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.btn-danger.btn-modern {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}
/* SweetAlert2 Custom Styles */
.swal-custom-popup {
    border-radius: 20px !important;
    padding: 2rem !important;
    background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%) !important;
}

.swal-custom-title {
    font-size: 1.75rem !important;
    font-weight: 700 !important;
    color: #1f2937 !important;
}

.swal-custom-html {
    font-size: 1.05rem !important;
    color: #6b7280 !important;
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
    color: #374151 !important;
    border: 2px solid #d1d5db !important;
    padding: 0.875rem 2rem !important;
    border-radius: 12px !important;
    font-weight: 600 !important;
    font-size: 1rem !important;
    transition: all 0.3s ease !important;
}

.swal-custom-cancel:hover {
    background: #f3f4f6 !important;
    border-color: #9ca3af !important;
}
</style>
@endpush

@section('content')
<div class="row g-3 g-lg-4">
    
    <!-- Welcome Header Card -->
    <div class="col-12">
        <div class="welcome-header-card">
            <div class="welcome-header-content">
                <div class="welcome-header-text">
                    <h2>
                        <i class="fas fa-file-invoice me-2"></i>Purchase Order
                    </h2>
                    <p>Kelola pengajuan dan persetujuan Purchase Order dengan mudah dan efisien</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-custom alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-custom alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-primary">
            <div class="stat-icon-wrapper">
                <i class="fas fa-file-invoice stat-icon"></i>
            </div>
            <div class="stat-label">Total PO</div>
            <div class="stat-value">{{ $purchaseOrders->count() }}</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-warning">
            <div class="stat-icon-wrapper">
                <i class="fas fa-clock stat-icon"></i>
            </div>
            <div class="stat-label">Diajukan</div>
            <div class="stat-value">{{ $purchaseOrders->where('status', 'Diajukan')->count() }}</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-success">
            <div class="stat-icon-wrapper">
                <i class="fas fa-check-circle stat-icon"></i>
            </div>
            <div class="stat-label">Disetujui</div>
            <div class="stat-value">{{ $purchaseOrders->where('status', 'Disetujui')->count() }}</div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-danger">
            <div class="stat-icon-wrapper">
                <i class="fas fa-times-circle stat-icon"></i>
            </div>
            <div class="stat-label">Ditolak</div>
            <div class="stat-value">{{ $purchaseOrders->where('status', 'Ditolak')->count() }}</div>
        </div>
    </div>

    <!-- Filter & Action Section -->
    <div class="col-12">
        <div class="filter-section">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div class="filter-controls">
                    <div class="filter-item">
                        <label for="filterStatus">
                            <i class="fas fa-filter me-2"></i>Status:
                        </label>
                        <select class="form-select" id="filterStatus">
                            <option value="">Semua Status</option>
                            <option value="Diajukan">Diajukan</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                    
                    <div class="filter-item">
                        <label for="filterVendor">
                            <i class="fas fa-building me-2"></i>Vendor:
                        </label>
                        <select class="form-select" id="filterVendor">
                            <option value="">Semua Vendor</option>
                            @foreach($purchaseOrders->pluck('vendor')->unique() as $vendor)
                                @if($vendor)
                                    <option value="{{ $vendor->nama_vendor }}">{{ $vendor->nama_vendor }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="button" class="btn btn-reset" onclick="resetFilters()">
                        <i class="fas fa-redo me-2"></i>Reset
                    </button>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <!-- Tombol Export -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-modern" onclick="exportToExcel()">
                            <i class="fas fa-file-excel me-2"></i>Export Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-modern" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf me-2"></i>Export PDF
                        </button>
                    </div>
                @role('admin')
                <a href="{{ route('purchase-order.create') }}" class="btn btn-primary btn-modern">
                    <i class="fas fa-plus me-2"></i>Buat PO Baru
                </a>
                @endrole
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="col-12">
        <div class="card card-modern">
            <div class="card-header">
                <h6>
                    <i class="fas fa-list me-2"></i>Daftar Purchase Order
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-modern" id="poTable">
                        <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 12%;">Kode PO</th>
                                <th style="width: 18%;">Vendor</th>
                                <th style="width: 15%;">Staff</th>
                                <th style="width: 12%;">Tanggal</th>
                                <th style="width: 10%;">Items</th>
                                <th style="width: 13%;">Status</th>
                                <th style="width: 15%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($purchaseOrders as $index => $po)
                            <tr data-status="{{ $po->status }}" data-vendor="{{ $po->vendor->nama_vendor ?? '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <span class="badge-code">
                                        PO-{{ str_pad($po->id, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="avatar-wrapper">
                                        <div class="avatar-icon bg-primary-subtle">
                                            <i class="fas fa-building"></i>
                                        </div>
                                        <span class="avatar-text">{{ $po->vendor->nama_vendor ?? 'N/A' }}</span>
                                    </div>
                                </td>
                                <td>{{ $po->karyawan->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ date('d M Y', strtotime($po->tanggal_pemesanan)) }}</td>
                                <td>
                                    <span class="badge-items">
                                        {{ $po->detailPO->sum('jumlah') }} Unit
                                    </span>
                                </td>
                                <td>
                                    @if($po->status === 'Diajukan')
                                        <span class="badge-status badge-warning">
                                            <i class="fas fa-clock"></i>
                                            <span>Diajukan</span>
                                        </span>
                                    @elseif($po->status === 'Disetujui')
                                        <span class="badge-status badge-success">
                                            <i class="fas fa-check-circle"></i>
                                            <span>Disetujui</span>
                                        </span>
                                    @else
                                        <span class="badge-status badge-danger">
                                            <i class="fas fa-times-circle"></i>
                                            <span>Ditolak</span>
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('purchase-order.show', $po->id) }}" 
                                           class="btn-action btn-info" 
                                           data-bs-toggle="tooltip" 
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @role('admin')
                                        @if($po->status === 'Diajukan')
                                            <a href="{{ route('purchase-order.edit', $po->id) }}" 
                                               class="btn-action btn-warning" 
                                               data-bs-toggle="tooltip" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <button type="button" 
                                                    class="btn-action btn-danger" 
                                                    onclick="confirmDelete({{ $po->id }})"
                                                    data-bs-toggle="tooltip" 
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                        @endrole
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr id="emptyRow">
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <h5 class="empty-state-title">Belum ada Purchase Order</h5>
                                        <p class="empty-state-text">Mulai dengan membuat Purchase Order pertama Anda</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

<!-- Modal Pop-up untuk No Data -->
<div class="modal fade" id="noDataModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 1rem; overflow: hidden;">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center" 
                         style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);">
                        <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #f59e0b;"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-3" style="color: #1e3a8a;">Tidak Ada Data!</h4>
                <p class="text-muted mb-4">
                    Data yang akan di-export tidak ditemukan.<br>
                    Pastikan tabel memiliki data atau cek filter yang aktif.
                </p>
                <button type="button" class="btn btn-primary px-4 py-2" data-bs-dismiss="modal" 
                        style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none; border-radius: 0.5rem;">
                    <i class="fas fa-check me-2"></i>Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pop-up untuk Success Export -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border: none; border-radius: 1rem; overflow: hidden;">
            <div class="modal-body text-center p-5">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center" 
                         style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);">
                        <i class="fas fa-check-circle" style="font-size: 3rem; color: #10b981;"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-3" style="color: #1e3a8a;">Export Berhasil!</h4>
                <p class="text-muted mb-4" id="successMessage">
                    File berhasil di-download ke perangkat Anda.
                </p>
                <button type="button" class="btn btn-success px-4 py-2" data-bs-dismiss="modal" 
                        style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); border: none; border-radius: 0.5rem;">
                    <i class="fas fa-times me-2"></i>Tutup
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery (WAJIB LOAD DULUAN) -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('✅ Purchase Order page loaded');
    console.log('✅ jQuery version:', $.fn.jquery);
    console.log('✅ Bootstrap loaded:', typeof bootstrap !== 'undefined');
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Filter by Status
    $('#filterStatus').on('change', function() {
        applyFilters();
    });
    
    // Filter by Vendor
    $('#filterVendor').on('change', function() {
        applyFilters();
    });
    
    // Apply Filters Function
    function applyFilters() {
        const statusFilter = $('#filterStatus').val();
        const vendorFilter = $('#filterVendor').val();
        const rows = $('#poTable tbody tr');
        let visibleCount = 0;
        
        rows.each(function() {
            const $row = $(this);
            
            // Skip empty state row
            if ($row.attr('id') === 'emptyRow') return;
            
            const rowStatus = $row.data('status');
            const rowVendor = $row.data('vendor');
            
            let showRow = true;
            
            // Check status filter
            if (statusFilter && rowStatus !== statusFilter) {
                showRow = false;
            }
            
            // Check vendor filter
            if (vendorFilter && rowVendor !== vendorFilter) {
                showRow = false;
            }
            
            if (showRow) {
                $row.show();
                visibleCount++;
            } else {
                $row.hide();
            }
        });
        
        // Show "no results" message if needed
        if (visibleCount === 0 && !$('#noResultsRow').length) {
            $('#poTable tbody').append(`
                <tr id="noResultsRow">
                    <td colspan="8">
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h5 class="empty-state-title">Tidak ada hasil</h5>
                            <p class="empty-state-text">Tidak ditemukan Purchase Order dengan filter yang dipilih</p>
                            <button type="button" class="btn btn-primary btn-modern" onclick="resetFilters()">
                                <i class="fas fa-redo me-2"></i>Reset Filter
                            </button>
                        </div>
                    </td>
                </tr>
            `);
        } else if (visibleCount > 0) {
            $('#noResultsRow').remove();
        }
    }
});

// Reset Filters
function resetFilters() {
    $('#filterStatus').val('');
    $('#filterVendor').val('');
    $('#poTable tbody tr').show();
    $('#noResultsRow').remove();
}

// Confirm Delete dengan SweetAlert2
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Purchase Order?',
        html: 'Anda yakin ingin menghapus Purchase Order ini?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>',
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
            const form = document.getElementById('deleteForm');
            form.action = `/purchase-order/${id}`;
            form.submit();
        }
    });
}

// Export to Excel
function exportToExcel() {
    const table = document.getElementById('poTable');
    const rows = Array.from(table.querySelectorAll('tbody tr')).filter(row => {
        return row.style.display !== 'none' && !row.id.includes('Row');
    });
    
    if (rows.length === 0) {
        const noDataModal = new bootstrap.Modal(document.getElementById('noDataModal'));
        noDataModal.show();
        return;
    }
    
    const data = [
        ['No', 'Kode PO', 'Vendor', 'Staff', 'Tanggal', 'Jumlah Items', 'Status']
    ];
    
    rows.forEach((row, index) => {
        const cells = row.querySelectorAll('td');
        data.push([
            index + 1,
            cells[1].textContent.trim(),
            cells[2].querySelector('.avatar-text').textContent.trim(),
            cells[3].textContent.trim(),
            cells[4].textContent.trim(),
            cells[5].textContent.trim(),
            cells[6].textContent.trim()
        ]);
    });
    
    const ws = XLSX.utils.aoa_to_sheet(data);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Purchase Orders');
    
    // Auto width columns
    const maxWidth = data.reduce((acc, row) => {
        row.forEach((cell, i) => {
            const len = cell.toString().length;
            acc[i] = Math.max(acc[i] || 10, len + 2);
        });
        return acc;
    }, []);
    ws['!cols'] = maxWidth.map(w => ({ width: w }));
    
    const fileName = `Purchase_Orders_${new Date().toISOString().split('T')[0]}.xlsx`;
    XLSX.writeFile(wb, fileName);
    
    console.log('✅ Excel exported:', fileName);

    // Show success modal
    document.getElementById('successMessage').textContent = `File Excel "${fileName}" berhasil di-download!`;
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
}

// Export to PDF - Modern Style
function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');
    
    const table = document.getElementById('poTable');
    const rows = Array.from(table.querySelectorAll('tbody tr')).filter(row => {
        return row.style.display !== 'none' && !row.id.includes('Row');
    });
    
    if (rows.length === 0) {
        const noDataModal = new bootstrap.Modal(document.getElementById('noDataModal'));
        noDataModal.show();
        return;
    }
    const tableData = rows.map((row, index) => {
        const cells = row.querySelectorAll('td');
        return [
            index + 1,
            cells[1].textContent.trim(),
            cells[2].querySelector('.avatar-text').textContent.trim(),
            cells[3].textContent.trim(),
            cells[4].textContent.trim(),
            cells[5].textContent.trim(),
            cells[6].textContent.trim()
        ];
    });
    
    // Calculate statistics
    const totalPO = tableData.length;
    const totalDiajukan = tableData.filter(row => row[6].includes('Diajukan')).length;
    const totalDisetujui = tableData.filter(row => row[6].includes('Disetujui')).length;
    const totalDitolak = tableData.filter(row => row[6].includes('Ditolak')).length;
    
    const pageWidth = doc.internal.pageSize.getWidth();
    
    // Header Section
    doc.setFillColor(30, 58, 138);
    doc.rect(0, 0, pageWidth, 40, 'F');
    
    doc.setFontSize(24);
    doc.setFont(undefined, 'bold');
    doc.setTextColor(255, 255, 255);
    doc.text('PURCHASE ORDER REPORT', pageWidth / 2, 15, { align: 'center' });
    
    doc.setFontSize(11);
    doc.setFont(undefined, 'normal');
    doc.text('Laporan Daftar Purchase Order', pageWidth / 2, 22, { align: 'center' });
    
    const currentDate = new Date().toLocaleDateString('id-ID', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    doc.setFontSize(10);
    doc.text(`Tanggal Export: ${currentDate}`, pageWidth / 2, 28, { align: 'center' });
    
    doc.setDrawColor(255, 255, 255);
    doc.setLineWidth(0.5);
    doc.line(40, 32, pageWidth - 40, 32);
    
    doc.setFontSize(10);
    doc.setFont(undefined, 'normal');
    doc.text(
        `Total PO: ${totalPO}  |  Diajukan: ${totalDiajukan}  |  Disetujui: ${totalDisetujui}  |  Ditolak: ${totalDitolak}`, 
        pageWidth / 2, 
        37, 
        { align: 'center' }
    );
    
    doc.setTextColor(0, 0, 0);
    
    doc.autoTable({
        head: [['No', 'Kode PO', 'Vendor', 'Staff', 'Tanggal', 'Items', 'Status']],
        body: tableData,
        startY: 45,
        theme: 'striped',
        styles: {
            fontSize: 9,
            cellPadding: 3,
            halign: 'center',
            valign: 'middle',
            lineColor: [220, 220, 220],
            lineWidth: 0.1
        },
        headStyles: {
            fillColor: [30, 58, 138],
            textColor: [255, 255, 255],
            fontStyle: 'bold',
            halign: 'center',
            fontSize: 10,
            cellPadding: 4
        },
        alternateRowStyles: {
            fillColor: [248, 249, 250]
        },
        columnStyles: {
            0: { cellWidth: 15, halign: 'center' },
            1: { cellWidth: 35, halign: 'center' },
            2: { cellWidth: 60, halign: 'left' },
            3: { cellWidth: 50, halign: 'left' },
            4: { cellWidth: 30, halign: 'center' },
            5: { cellWidth: 25, halign: 'center' },
            6: { cellWidth: 30, halign: 'center' }
        },
        didDrawPage: function(data) {
            const pageHeight = doc.internal.pageSize.getHeight();
            const footerY = pageHeight - 15;
            
            doc.setFillColor(248, 249, 250);
            doc.rect(0, footerY - 5, pageWidth, 20, 'F');
            
            doc.setDrawColor(220, 220, 220);
            doc.setLineWidth(0.3);
            doc.line(20, footerY - 5, pageWidth - 20, footerY - 5);
            
            doc.setFontSize(9);
            doc.setFont(undefined, 'bold');
            doc.setTextColor(30, 58, 138);
            const pageNum = doc.internal.getCurrentPageInfo().pageNumber;
            const totalPages = doc.internal.getNumberOfPages();
            doc.text(`Halaman ${pageNum} dari ${totalPages}`, pageWidth / 2, footerY, { align: 'center' });
            
            doc.setFontSize(8);
            doc.setFont(undefined, 'normal');
            doc.setTextColor(107, 114, 128);
            doc.text('Generated by Purchase Order Management System', pageWidth / 2, footerY + 5, { align: 'center' });
            
            const timestamp = new Date().toLocaleString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit'
            });
            doc.text(`Dicetak pada: ${currentDate} pukul ${timestamp}`, pageWidth / 2, footerY + 9, { align: 'center' });
        },
        margin: { left: (pageWidth - 245) / 2, right: (pageWidth - 245) / 2 }
    });
    
    const fileName = `Purchase_Orders_${new Date().toISOString().split('T')[0]}.pdf`;
    doc.save(fileName);
    
    console.log('✅ PDF exported:', fileName);

    document.getElementById('successMessage').textContent = `File PDF "${fileName}" berhasil di-download!`;
    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();
}
</script>
@endpush