@extends('layouts.dashboard')

@section('title', 'Data Perangkat')
@section('page-title', 'Data Perangkat')
@section('page-description', 'Kelola data perangkat inventory')

@section('content')
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div class="page-header-content">
                    <div class="page-header-icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div>
                        <h1 class="page-title">Data Perangkat</h1>
                        <p class="page-subtitle">Kelola dan pantau semua perangkat inventory Anda</p>
                    </div>
                </div>
                <div class="page-header-actions">
                    {{-- Tombol Tambah - HANYA ADMIN --}}
                    @role('admin')
                    <a href="{{ route('perangkat.create') }}" class="btn btn-primary-custom">
                        <i class="fas fa-plus-circle me-2"></i>
                        <span>Tambah Perangkat</span>
                    </a>
                    @endrole
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stats-card total-card">
                <div class="stats-card-icon">
                    <i class="fas fa-boxes"></i>
                </div>
                <div class="stats-card-content">
                    <div class="stats-value">{{ $statistics['total'] }}</div>
                    <div class="stats-label">Total Perangkat</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card available-card">
                <div class="stats-card-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-card-content">
                    <div class="stats-value">{{ $statistics['available'] }}</div>
                    <div class="stats-label">Berfungsi</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card damaged-card">
                <div class="stats-card-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-card-content">
                    <div class="stats-value">{{ $statistics['damaged'] }}</div>
                    <div class="stats-label">Rusak</div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stats-card missing-card">
                <div class="stats-card-icon">
                    <i class="fas fa-question-circle"></i>
                </div>
                <div class="stats-card-content">
                    <div class="stats-value">{{ $statistics['missing'] }}</div>
                    <div class="stats-label">Hilang</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form action="{{ route('perangkat.index') }}" method="GET" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-lg-4 col-md-6">
                    <label class="filter-label">
                        <i class="fas fa-search"></i>
                        <span>Cari Perangkat</span>
                    </label>
                    <div class="input-wrapper">
                        <div class="input-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <input type="text" 
                               name="search" 
                               class="form-control-custom" 
                               placeholder="Cari nama perangkat atau catatan..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <label class="filter-label">
                        <i class="fas fa-tag"></i>
                        <span>Kategori</span>
                    </label>
                    <select name="kategori" class="form-select-custom">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-2 col-md-6">
                    <label class="filter-label">
                        <i class="fas fa-info-circle"></i>
                        <span>Status</span>
                    </label>
                    <select name="status" class="form-select-custom">
                        <option value="">Semua Status</option>
                        <option value="Berfungsi" {{ request('status') == 'Berfungsi' ? 'selected' : '' }}>Berfungsi</option>
                        <option value="Rusak" {{ request('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                        <option value="Hilang" {{ request('status') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                        <option value="Return" {{ request('status') == 'Return' ? 'selected' : '' }}>Return</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="filter-actions">
                        <button type="submit" class="btn btn-filter">
                            <i class="fas fa-filter me-2"></i>
                            <span>Filter</span>
                        </button>
                        <a href="{{ route('perangkat.index') }}" class="btn btn-reset">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Table Card -->
    <div class="table-card">
        <div class="table-card-header">
            <div class="table-card-title">
                <h3>Daftar Perangkat</h3>
                <p>Total {{ $perangkat->total() }} perangkat ditemukan</p>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 30%;">Nama Perangkat</th>
                        <th style="width: 20%;">Kategori</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: @role('admin')20%@else30%@endrole;">Catatan</th>
                        @role('admin')
                        <th style="width: 10%;" class="text-center">Aksi</th>
                        @endrole
                    </tr>
                </thead>
                <tbody>
                    @forelse($perangkat as $index => $item)
                    <tr>
                        <td>
                            <div class="table-number">{{ $perangkat->firstItem() + $index }}</div>
                        </td>
                        <td>
                            <div class="device-info">
                                <div class="device-name">{{ $item->nama_perangkat }}</div>
                                <div class="device-meta">
                                    <i class="fas fa-clock"></i>
                                    <span>{{ $item->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="category-badge">
                                <i class="fas fa-tag"></i>
                                <span>{{ $item->kategoriPerangkat->nama_kategori ?? '-' }}</span>
                            </div>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'Berfungsi' => ['class' => 'status-available', 'icon' => 'fa-check-circle'],
                                    'Rusak' => ['class' => 'status-damaged', 'icon' => 'fa-exclamation-triangle'],
                                    'Hilang' => ['class' => 'status-missing', 'icon' => 'fa-question-circle'],
                                    'Return' => ['class' => 'status-return', 'icon' => 'fa-undo']
                                ];
                                $config = $statusConfig[$item->status] ?? ['class' => 'status-default', 'icon' => 'fa-circle'];
                            @endphp
                            <span class="status-badge {{ $config['class'] }}">
                                <i class="fas {{ $config['icon'] }}"></i>
                                <span>{{ $item->status }}</span>
                            </span>
                        </td>
                        <td>
                            <div class="note-text">{{ Str::limit($item->catatan_perangkat, 50) ?: '-' }}</div>
                        </td>
                        
                        {{-- Kolom Aksi - HANYA ADMIN --}}
                        @role('admin')
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('perangkat.edit', $item->id) }}" 
                                   class="btn-action btn-edit" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn-action btn-delete" 
                                        data-id="{{ $item->id }}"
                                        data-name="{{ $item->nama_perangkat }}"
                                        title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                        @endrole
                    </tr>
                    @empty
                    <tr>
                        @role('admin')
                        <td colspan="6">
                        @else
                        <td colspan="5">
                        @endrole
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h5>Tidak Ada Data</h5>
                                <p>
                                    @role('admin')
                                        Tidak ada perangkat yang ditemukan. Tambahkan perangkat baru untuk memulai.
                                    @else
                                        Belum ada data perangkat tersedia.
                                    @endrole
                                </p>
                                @role('admin')
                                <a href="{{ route('perangkat.create') }}" class="btn btn-primary-custom">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    <span>Tambah Perangkat</span>
                                </a>
                                @endrole
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($perangkat->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <span>Menampilkan {{ $perangkat->firstItem() }} - {{ $perangkat->lastItem() }} dari {{ $perangkat->total() }} data</span>
            </div>
            <div class="pagination-links">
                {{ $perangkat->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>

    <!-- Hidden form for delete -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
:root {
    --primary-blue: #1e40af;
    --primary-orange: #ea580c;
    --success-green: #059669;
    --danger-red: #dc2626;
    --warning-yellow: #f59e0b;
    --purple: #8b5cf6;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--shadow-xl);
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

.page-header-content {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    z-index: 1;
}

.page-header-icon {
    width: 70px;
    height: 70px;
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2.5rem;
    flex-shrink: 0;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
}

.page-subtitle {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.05rem;
    margin-bottom: 0;
}

.page-header-actions {
    position: relative;
    z-index: 1;
}

/* Button Primary Custom */
.btn-primary-custom {
    background: white;
    color: var(--primary-orange);
    border: none;
    padding: 1rem 2rem;
    border-radius: 14px;
    font-weight: 600;
    font-size: 1.05rem;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
}

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
    color: var(--primary-orange);
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

.damaged-card {
    border-left-color: var(--danger-red);
}

.damaged-card .stats-card-icon {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: var(--danger-red);
}

.missing-card {
    border-left-color: var(--warning-yellow);
}

.missing-card .stats-card-icon {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: var(--warning-yellow);
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
    color: var(--primary-orange);
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
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
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
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.75rem;
}

.btn-filter {
    flex: 1;
    background: linear-gradient(135deg, var(--primary-orange) 0%, #fb923c 100%);
    color: white;
    border: none;
    padding: 0.875rem 1.5rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(234, 88, 12, 0.4);
}

.btn-reset {
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

.table-responsive {
    overflow-x: auto;
}

.table-custom {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.table-custom thead th {
    background: var(--gray-50);
    color: var(--gray-700);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8125rem;
    letter-spacing: 0.05em;
    padding: 1.25rem 1.5rem;
    border-bottom: 2px solid var(--gray-200);
    white-space: nowrap;
}

.table-custom tbody td {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-100);
    vertical-align: middle;
}

.table-custom tbody tr {
    transition: all 0.2s ease;
}

.table-custom tbody tr:hover {
    background: var(--gray-50);
}

.table-number {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: var(--gray-700);
    font-size: 0.95rem;
}

.device-info {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.device-name {
    font-weight: 600;
    color: var(--gray-800);
    font-size: 1rem;
}

.device-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    font-size: 0.875rem;
}

.device-meta i {
    font-size: 0.75rem;
}

.category-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 10px;
    color: var(--primary-blue);
    font-weight: 600;
    font-size: 0.875rem;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.875rem;
    white-space: nowrap;
}

.status-available {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-damaged {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.status-missing {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.status-return {
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    color: #5b21b6;
}

.note-text {
    color: var(--gray-600);
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
    color: var(--gray-800);
    margin-bottom: 0.75rem;
}

.empty-state p {
    color: var(--gray-600);
    font-size: 1rem;
    margin-bottom: 1.5rem;
}

/* Pagination */
.pagination-wrapper {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem 2rem;
    border-top: 2px solid var(--gray-100);
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination-info {
    color: var(--gray-600);
    font-size: 0.9375rem;
    font-weight: 500;
}

.pagination-links .pagination {
    margin: 0;
    display: flex;
    gap: 0.5rem;
}

.pagination-links .page-item {
    list-style: none;
}

.pagination-links .page-link {
    padding: 0.625rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    color: var(--gray-700);
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination-links .page-link:hover {
    background: var(--primary-orange);
    border-color: var(--primary-orange);
    color: white;
}

.pagination-links .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary-orange) 0%, #fb923c 100%);
    border-color: var(--primary-orange);
    color: white;
}

.pagination-links .page-item.disabled .page-link {
    opacity: 0.5;
    cursor: not-allowed;
}

/* Responsive */
@media (max-width: 1200px) {
    .stats-value {
        font-size: 2rem;
    }
}

@media (max-width: 992px) {
    .page-header {
        flex-direction: column;
        text-align: center;
    }
    
    .page-header-content {
        flex-direction: column;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .filter-actions {
        flex-direction: column;
    }
    
    .btn-filter,
    .btn-reset {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .page-header {
        padding: 1.5rem;
    }
    
    .page-header-icon {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }
    
    .page-title {
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
            title: 'Hapus Perangkat?',
            html: `Anda yakin ingin menghapus perangkat <strong>"${name}"</strong>?<br><small class="text-muted">Data yang dihapus tidak dapat dikembalikan.</small>`,
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
                form.attr('action', '/perangkat/' + id);
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
</style>
@endpush