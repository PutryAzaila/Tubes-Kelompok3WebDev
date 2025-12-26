@extends('layouts.dashboard')

@section('title', 'Inventory Management')
@section('page-title', 'Inventory Management')
@section('page-description', 'Kelola data barang masuk dan keluar')

@push('styles')
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables Bootstrap 5 -->
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/searchpanes/2.2.0/css/searchPanes.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.7.0/css/select.bootstrap5.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- jsPDF & jsPDF-AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>
<!-- SheetJS for Excel -->
<script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
<style>
    :root {
        --transdata-blue: #1e3a8a;
        --transdata-orange: #f97316;
        --transdata-gray: #6b7280;
        --primary-gradient: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        --success-gradient: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        --warning-gradient: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    }

    body {
        background: #f8f9fa;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .page-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
        color: white;
        padding: 2rem 0;
        margin-bottom: 2rem;
        margin-top: 3rem;
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);
    }

    .stats-card {
        border: none;
        border-radius: 1rem;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .stats-card-body {
        padding: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .card-gradient-blue {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
    }

    .card-gradient-green {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
    }

    .card-gradient-orange {
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        color: white;
    }

    .main-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .card-header-custom {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        border: none;
        padding: 1.5rem;
    }

    .btn-add {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
    }

    .btn-add:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
        color: white;
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .badge-masuk {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
    }

    .badge-keluar {
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        color: white;
    }

    .table-modern {
        border-collapse: separate;
        border-spacing: 0;
    }

    .table-modern thead th {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        border: none;
        padding: 1rem;
    }

    .table-modern tbody tr {
        transition: all 0.3s ease;
    }

    .table-modern tbody tr:hover {
        background: rgba(30, 58, 138, 0.05);
        transform: scale(1.01);
    }

    .table-modern tbody td {
        padding: 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f0f0f0;
    }

    .action-btn {
        width: 35px;
        height: 35px;
        border-radius: 0.5rem;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        margin: 0 0.2rem;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .btn-edit {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
    }

    .btn-view {
        background: linear-gradient(135deg, #6b7280 0%, #9ca3af 100%);
        color: white;
    }

    .badge-role {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .badge-noc {
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        color: white;
    }

    .badge-manajer {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        color: white;
    }

    .badge-admin {
        background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%);
        color: white;
    }

    .dtsp-searchPane {
        border-radius: 0.75rem !important;
        border: 1px solid #e0e0e0 !important;
    }

    .dtsp-searchPane .dtsp-topRow {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%) !important;
        color: white !important;
        border-radius: 0.75rem 0.75rem 0 0 !important;
    }

    div.dataTables_wrapper div.dataTables_filter input {
        border-radius: 0.75rem;
        border: 2px solid #e0e0e0;
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }

    div.dataTables_wrapper div.dataTables_filter input:focus {
        border-color: #1e3a8a;
        box-shadow: 0 0 0 0.2rem rgba(30, 58, 138, 0.25);
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .access-info {
        background: linear-gradient(135deg, rgba(30, 58, 138, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
        border-left: 4px solid var(--transdata-blue);
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
    }
/* Button Export Area - Modern & Clean */
.dataTables_wrapper .dt-buttons {
    display: flex;
    gap: 0.5rem;
    margin: 0;
}

.btn-export {
    padding: 0.5rem 1rem !important;
    border-radius: 6px !important;
    border: none !important;
    font-weight: 500 !important;
    font-size: 0.8125rem !important;
    transition: all 0.2s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

.btn-export:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
}

.btn-export:active {
    transform: translateY(0px) !important;
}

/* Excel Button */
.btn-export-excel {
    background: #10b981 !important;
    color: white !important;
}

.btn-export-excel:hover {
    background: #059669 !important;
}

/* PDF Button */
.btn-export-pdf {
    background: #ef4444 !important;
    color: white !important;
}

.btn-export-pdf:hover {
    background: #dc2626 !important;
}

/* Filter Button */
.btn-export-filter {
    background: #3b82f6 !important;
    color: white !important;
}

.btn-export-filter:hover {
    background: #2563eb !important;
}

/* Container Area - Clean Layout */
.dataTables_wrapper .row:first-child {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    margin-bottom: 1rem;
    margin-left: 0 !important;
    margin-right: 0 !important;
}

.dataTables_wrapper .row:first-child > div {
    display: flex;
    align-items: center;
}

.dataTables_wrapper .dataTables_filter {
    float: none;
    text-align: right;
    margin-left: auto !important;
}

.dataTables_wrapper .dataTables_filter input {
    border-radius: 6px !important;
    border: 1px solid #d1d5db !important;
    padding: 0.5rem 0.875rem !important;
    transition: all 0.2s ease !important;
    font-size: 0.8125rem !important;
    margin-left: 0.5rem !important;
    width: 250px !important;
}

.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    outline: none !important;
}

.dataTables_wrapper .dataTables_filter label {
    font-weight: 500 !important;
    color: #6b7280 !important;
    font-size: 0.8125rem !important;
    margin: 0 !important;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

/* Button Area - Kiri */
.dataTables_wrapper .dt-buttons {
    display: flex;
    gap: 0.5rem;
    margin: 0;
    margin-right: auto !important;
}

/* Container dengan Justify Space Between */
.dataTables_wrapper .row:first-child {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    margin-bottom: 1rem;
    margin-left: 0 !important;
    margin-right: 0 !important;
    display: flex !important;
    justify-content: space-between !important;
    align-items: center !important;
}

.dataTables_wrapper .row:first-child > div {
    display: flex;
    align-items: center;
    width: auto !important;
}

/* Left side - buttons */
.dataTables_wrapper .row:first-child > div:first-child {
    flex: 0 0 auto;
}

/* Right side - search */
.dataTables_wrapper .row:first-child > div:last-child {
    flex: 0 0 auto;
    margin-left: auto;
}

/* Button Export */
.btn-export {
    padding: 0.5rem 1rem !important;
    border-radius: 6px !important;
    border: none !important;
    font-weight: 500 !important;
    font-size: 0.8125rem !important;
    transition: all 0.2s ease !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1) !important;
}

.btn-export:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15) !important;
}

.btn-export:active {
    transform: translateY(0px) !important;
}

/* Excel Button */
.btn-export-excel {
    background: #10b981 !important;
    color: white !important;
}

.btn-export-excel:hover {
    background: #059669 !important;
}

/* PDF Button */
.btn-export-pdf {
    background: #ef4444 !important;
    color: white !important;
}

.btn-export-pdf:hover {
    background: #dc2626 !important;
}

/* Filter Button */
.btn-export-filter {
    background: #3b82f6 !important;
    color: white !important;
}

.btn-export-filter:hover {
    background: #2563eb !important;
}

/* Card Header */
.card-header-custom {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    color: white;
    border: none;
    padding: 1.25rem 1.5rem;
}

.card-header-custom h5 {
    margin: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dataTables_wrapper .row:first-child {
        padding: 0.75rem;
        flex-direction: column;
        align-items: stretch !important;
    }
    
    .dataTables_wrapper .row:first-child > div {
        width: 100% !important;
        margin: 0 !important;
    }
    
    .dataTables_wrapper .row:first-child > div:first-child {
        margin-bottom: 0.75rem;
    }
    
    .dataTables_wrapper .dt-buttons {
        width: 100%;
        flex-direction: column;
    }
    
    .btn-export {
        width: 100% !important;
    }
    
    .dataTables_wrapper .dataTables_filter {
        text-align: left;
        width: 100%;
        margin-left: 0 !important;
    }
    
    .dataTables_wrapper .dataTables_filter label {
        width: 100%;
        justify-content: flex-start;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        width: 100% !important;
        margin-left: 0 !important;
        margin-top: 0.5rem !important;
    }
}

.dt-button {
    background-image: none !important;
}

.dt-button:focus {
    outline: none !important;
}
</style>
@endpush

@section('content')
<div class="container-fluid px-4 animate-fade-in">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center position-relative">
                <div>
                    <h1 class="mb-2"><i class="fas fa-boxes me-2"></i>Inventory Management</h1>
                    <p class="mb-0 opacity-75">Kelola data barang masuk dan keluar dengan mudah</p>
                </div>

                <!-- Tombol Tambah Data - Hanya NOC -->
                @if(strtoupper(auth()->user()->jabatan) === 'NOC')
                <a href="{{ route('inventory.create') }}" class="btn btn-add">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Access Info Alert -->
    @if(strtoupper(auth()->user()->jabatan) === 'MANAJER')
    <div class="access-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Mode Tampilan:</strong> Anda login sebagai <strong>Manajer</strong> dengan hak akses <em>View Only</em> (Lihat Data Saja).
    </div>
    @elseif(strtoupper(auth()->user()->jabatan) === 'NOC')
    <div class="access-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Mode Input:</strong> Anda login sebagai <strong>NOC</strong> dengan hak akses <em>Tambah & Edit</em> data inventory.
    </div>
    @elseif(strtoupper(auth()->user()->jabatan) === 'ADMIN')
    <div class="access-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Mode Tampilan:</strong> Anda login sebagai <strong>Admin</strong> dengan hak akses <em>View Only</em> (Lihat Data Saja).
    </div>
    @endif

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card stats-card card-gradient-blue">
                    <div class="stats-card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-2 opacity-75 fw-semibold">Total Barang Masuk</p>
                                <h2 class="mb-0 fw-bold">{{ number_format($totalMasuk) }}</h2>
                                <small class="opacity-75"><i class="fas fa-arrow-down me-1"></i>Unit masuk</small>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-arrow-down"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card stats-card card-gradient-orange">
                    <div class="stats-card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-2 opacity-75 fw-semibold">Total Barang Keluar</p>
                                <h2 class="mb-0 fw-bold">{{ number_format($totalKeluar) }}</h2>
                                <small class="opacity-75"><i class="fas fa-arrow-up me-1"></i>Unit keluar</small>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-arrow-up"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card stats-card card-gradient-green">
                    <div class="stats-card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="mb-2 opacity-75 fw-semibold">Sisa Stok Tersedia</p>
                                <h2 class="mb-0 fw-bold">{{ number_format($totalStok) }}</h2>
                                <small class="opacity-75">
                                    <i class="fas {{ $stokIcon }} me-1"></i>{{ $stokStatus }}
                                </small>
                            </div>
                            <div class="stats-icon">
                                <i class="fas {{ $stokIcon }}"></i>
                            </div>
                        </div>
                        
                        {{-- Info tambahan jika ada item out of stock --}}
                        @if(isset($itemsOutOfStock) && $itemsOutOfStock > 0)
                        <div class="mt-3 pt-3 border-top border-light border-opacity-25">
                            <small class="opacity-75">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ $itemsOutOfStock }} item habis, {{ $itemsWithStock ?? 0 }} item tersedia
                            </small>
                        </div>
                        @else
                        <div class="mt-3 pt-3 border-top border-light border-opacity-25">
                            <small class="opacity-75">
                                <i class="fas fa-check-circle me-1"></i>
                                {{ $itemsWithStock ?? 0 }} item memiliki stok
                            </small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    <!-- Data Table -->
    <div class="card main-card">
        <div class="card-header-custom">
            <h5 class="mb-0"><i class="fas fa-table me-2"></i>Data Inventory</h5>
         </div>
        <div class="card-body p-0">
            <div class="table-responsive p-4">
                <table id="inventoryTable" class="table table-hover table-modern" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Perangkat</th>
                            <th>Kategori</th>
                            <th>Serial Number</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                        <tbody>
                            @php
                                $rowNumber = 1;
                            @endphp
                            
                            @foreach($data as $item)
                                @php
                                    $isMasuk = $item instanceof App\Models\BarangMasuk;
                                    $type = $isMasuk ? 'masuk' : 'keluar';
                                @endphp
                                <tr>
                                    <td class="fw-semibold">{{ $rowNumber++ }}</td>
                                    <td>{{ date('d/m/Y', strtotime($item->tanggal)) }}</td>
                                    <td>
                                        @if($isMasuk)
                                            <span class="badge badge-modern badge-masuk">
                                                <i class="fas fa-arrow-down me-1"></i>Masuk
                                            </span>
                                        @else
                                            <span class="badge badge-modern badge-keluar">
                                                <i class="fas fa-arrow-up me-1"></i>Keluar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold">{{ $item->detailBarang->perangkat->nama_perangkat ?? '-' }}</td>
                                    <td>
                                        <span class="badge bg-primary">
                                            {{ $item->detailBarang->kategori ?? '-' }}
                                        </span>
                                    </td>
                                    <td><code>{{ $item->detailBarang->serial_number ?? '-' }}</code></td>
                                    <td class="fw-bold text-primary">{{ $item->jumlah }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $isMasuk ? ($item->catatan_barang_masuk ?? '-') : ($item->catatan_barang_keluar ?? '-') }}
                                    </td>
                                    <td class="text-center">
                                        @if(strtoupper(auth()->user()->jabatan) === 'NOC')
                                            <a href="{{ route('inventory.edit', [$item->id, $type]) }}" 
                                                class="action-btn btn-edit" 
                                                title="Edit Data">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @elseif(strtoupper(auth()->user()->jabatan) === 'MANAJER' || strtoupper(auth()->user()->jabatan) === 'ADMIN')
                                            <!-- Manajer/Admin: Hanya View -->
                                            <button class="action-btn btn-view" 
                                                    title="Lihat Saja (View Only)" 
                                                    disabled>
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!-- DataTables Extensions -->
<script src="https://cdn.datatables.net/searchpanes/2.2.0/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/searchpanes/2.2.0/js/searchPanes.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    const table = $('#inventoryTable').DataTable({
        searchPanes: {
            layout: 'columns-3',
            initCollapsed: true
        },
        // Tambahkan "B" untuk buttons area
        dom: '<"row mb-3"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>P<"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                text: '<i class="fas fa-file-excel me-2"></i>Export Excel',
                className: 'btn-export btn-export-excel',
                action: function (e, dt, node, config) {
                    exportToExcel();
                }
            },
            {
                text: '<i class="fas fa-file-pdf me-2"></i>Export PDF',
                className: 'btn-export btn-export-pdf',
                action: function (e, dt, node, config) {
                    exportToPDF();
                }
            },
            {
                extend: 'searchPanes',
                text: '<i class="fas fa-filter me-2"></i>Filter',
                className: 'btn-export btn-export-filter',
                config: {
                    cascadePanes: true,
                    columns: [2, 3, 4, 7]
                }
            }
        ],
        columnDefs: [
            {
                searchPanes: {
                    show: true
                },
                targets: [2, 3, 4, 7]
            },
            {
                searchPanes: {
                    show: false
                },
                targets: [0, 1, 5, 6, 8, 9]
            }
        ],
        language: {
            searchPanes: {
                title: {
                    _: 'Filter Aktif - %d',
                    0: 'Tidak Ada Filter',
                    1: '1 Filter Aktif'
                },
                clearMessage: 'Hapus Semua',
                collapse: 'Filter',
                count: '{total}',
                countFiltered: '{shown} ({total})'
            },
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        responsive: true,
        order: [[1, 'desc']]
    });
});

// Export to Excel
function exportToExcel() {
    const dataTable = $('#inventoryTable').DataTable();
    const filteredData = dataTable.rows({ search: 'applied' }).data();
    
    if (filteredData.length === 0) {
        alert('Tidak ada data untuk di-export!');
        return;
    }
    
    // Prepare data for Excel
    const data = [
        ['No', 'Tanggal', 'Jenis', 'Perangkat', 'Kategori', 'Serial Number', 'Jumlah', 'Status', 'Catatan']
    ];
    
    filteredData.each(function(row, index) {
        const rowNode = dataTable.row(index).node();
        const cells = $(rowNode).find('td');
        
        data.push([
            index + 1,
            $(cells[1]).text().trim(),
            $(cells[2]).text().trim(),
            $(cells[3]).text().trim(),
            $(cells[4]).text().trim(),
            $(cells[5]).text().trim(),
            $(cells[6]).text().trim(),
            $(cells[7]).text().trim(),
            $(cells[8]).text().trim()
        ]);
    });
    
    // Create worksheet
    const ws = XLSX.utils.aoa_to_sheet(data);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, 'Inventory Data');
    
    // Auto width columns
    const maxWidth = data.reduce((acc, row) => {
        row.forEach((cell, i) => {
            const len = cell.toString().length;
            acc[i] = Math.max(acc[i] || 10, len + 2);
        });
        return acc;
    }, []);
    ws['!cols'] = maxWidth.map(w => ({ width: w }));
    
    // Generate filename with current date
    const fileName = `Inventory_Data_${new Date().toISOString().split('T')[0]}.xlsx`;
    XLSX.writeFile(wb, fileName);
    
    console.log('✅ Excel exported:', fileName);
    
    // Show success message
    showExportMessage('Excel berhasil di-download!', 'success');
}

// Show Export Success Message
function showExportMessage(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    
    const alertHTML = `
        <div class="alert ${alertClass} alert-dismissible fade show animate-fade-in" role="alert">
            <i class="fas ${icon} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('.container-fluid.px-4').prepend(alertHTML);
    
    // Auto dismiss after 3 seconds
    setTimeout(() => {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 3000);
}
// Export to PDF - IMPROVED & SIMPLIFIED
function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4'); // landscape
    
    const dataTable = $('#inventoryTable').DataTable();
    const filteredData = dataTable.rows({ search: 'applied' }).data();
    
    if (filteredData.length === 0) {
        alert('Tidak ada data untuk di-export!');
        return;
    }
    
    // Prepare table data
    const tableData = [];
    filteredData.each(function(row, index) {
        const rowNode = dataTable.row(index).node();
        const cells = $(rowNode).find('td');
        
        tableData.push([
            index + 1,
            $(cells[1]).text().trim(),
            $(cells[2]).text().trim(),
            $(cells[3]).text().trim(),
            $(cells[4]).text().trim(),
            $(cells[5]).text().trim(),
            $(cells[6]).text().trim(),
            $(cells[7]).text().trim(),
            $(cells[8]).text().trim().substring(0, 35) + ($(cells[8]).text().trim().length > 35 ? '...' : '')
        ]);
    });
    
    // Calculate statistics
    const totalMasuk = tableData.filter(row => row[2].includes('Masuk')).reduce((sum, row) => sum + parseInt(row[6]), 0);
    const totalKeluar = tableData.filter(row => row[2].includes('Keluar')).reduce((sum, row) => sum + parseInt(row[6]), 0);
    const sisaStok = totalMasuk - totalKeluar;
    
    // Page width for centering
    const pageWidth = doc.internal.pageSize.getWidth();
    
    // === HEADER SECTION ===
    // Logo/Icon Area
    doc.setFillColor(30, 58, 138);
    doc.rect(0, 0, pageWidth, 40, 'F');
    
    // Main Title
    doc.setFontSize(24);
    doc.setFont(undefined, 'bold');
    doc.setTextColor(255, 255, 255);
    doc.text('INVENTORY MANAGEMENT REPORT', pageWidth / 2, 15, { align: 'center' });
    
    // Subtitle
    doc.setFontSize(11);
    doc.setFont(undefined, 'normal');
    doc.text('Laporan Data Barang Masuk dan Keluar', pageWidth / 2, 22, { align: 'center' });
    
    // Export Date
    const currentDate = new Date().toLocaleDateString('id-ID', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric' 
    });
    doc.setFontSize(10);
    doc.text(`Tanggal Export: ${currentDate}`, pageWidth / 2, 28, { align: 'center' });
    
    // Divider line
    doc.setDrawColor(255, 255, 255);
    doc.setLineWidth(0.5);
    doc.line(40, 32, pageWidth - 40, 32);
    
    // === STATISTICS TEXT (Simple) ===
    doc.setFontSize(10);
    doc.setFont(undefined, 'normal');
    doc.text(
        `Total Barang Masuk: ${totalMasuk} Unit  |  Total Barang Keluar: ${totalKeluar} Unit  |  Sisa Stok: ${sisaStok} Unit`, 
        pageWidth / 2, 
        37, 
        { align: 'center' }
    );
    
    // Reset colors
    doc.setTextColor(0, 0, 0);
    
    // === TABLE SECTION ===
    doc.autoTable({
        head: [['No', 'Tanggal', 'Jenis', 'Perangkat', 'Kategori', 'Serial Number', 'Jumlah', 'Status', 'Catatan']],
        body: tableData,
        startY: 45,
        theme: 'striped',
        styles: {
            fontSize: 8,
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
            fontSize: 9,
            cellPadding: 4
        },
        alternateRowStyles: {
            fillColor: [248, 249, 250]
        },
        columnStyles: {
            0: { cellWidth: 12, halign: 'center' },
            1: { cellWidth: 24, halign: 'center' },
            2: { cellWidth: 22, halign: 'center' },
            3: { cellWidth: 40, halign: 'left' },
            4: { cellWidth: 24, halign: 'center' },
            5: { cellWidth: 32, halign: 'center', fontStyle: 'mono' },
            6: { cellWidth: 18, halign: 'center', fontStyle: 'bold' },
            7: { cellWidth: 22, halign: 'center' },
            8: { cellWidth: 44, halign: 'left', fontSize: 7 }
        },
        didDrawPage: function(data) {
            // === FOOTER SECTION ===
            const pageHeight = doc.internal.pageSize.getHeight();
            const footerY = pageHeight - 15;
            
            // Footer background
            doc.setFillColor(248, 249, 250);
            doc.rect(0, footerY - 5, pageWidth, 20, 'F');
            
            // Divider line
            doc.setDrawColor(220, 220, 220);
            doc.setLineWidth(0.3);
            doc.line(20, footerY - 5, pageWidth - 20, footerY - 5);
            
            // Page number
            doc.setFontSize(9);
            doc.setFont(undefined, 'bold');
            doc.setTextColor(30, 58, 138);
            const pageNum = doc.internal.getCurrentPageInfo().pageNumber;
            const totalPages = doc.internal.getNumberOfPages();
            doc.text(`Halaman ${pageNum} dari ${totalPages}`, pageWidth / 2, footerY, { align: 'center' });
            
            // Footer info
            doc.setFontSize(8);
            doc.setFont(undefined, 'normal');
            doc.setTextColor(107, 114, 128);
            doc.text('Generated by Inventory Management System', pageWidth / 2, footerY + 5, { align: 'center' });
            
            // Timestamp
            const timestamp = new Date().toLocaleString('id-ID', { 
                hour: '2-digit', 
                minute: '2-digit',
                second: '2-digit'
            });
            doc.text(`Dicetak pada: ${currentDate} pukul ${timestamp}`, pageWidth / 2, footerY + 9, { align: 'center' });
        },
        margin: { left: (pageWidth - 238) / 2, right: (pageWidth - 238) / 2 }
    });
    
    // Save PDF
    const fileName = `Inventory_Report_${new Date().toISOString().split('T')[0]}.pdf`;
    doc.save(fileName);
    
    console.log('✅ PDF exported:', fileName);
    
    // Show success message
    showExportMessage('PDF berhasil di-download!', 'success');
}
</script>
@endpush