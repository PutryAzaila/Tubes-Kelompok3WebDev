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
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
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
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
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
                
                <!-- Role Badge -->
                <span class="badge-role badge-{{ strtolower(auth()->user()->role) }}">
                    <i class="fas fa-user-tag me-1"></i>{{ strtoupper(auth()->user()->role) }}
                </span>

                <!-- Tombol Tambah Data - Hanya NOC -->
                @if(auth()->user()->role === 'noc')
                <a href="{{ route('inventory.create') }}" class="btn btn-add">
                    <i class="fas fa-plus me-2"></i>Tambah Data
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Access Info Alert -->
    @if(auth()->user()->role === 'manajer')
    <div class="access-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Mode Tampilan:</strong> Anda login sebagai <strong>Manajer</strong> dengan hak akses <em>View Only</em> (Lihat Data Saja).
    </div>
    @elseif(auth()->user()->role === 'noc')
    <div class="access-info">
        <i class="fas fa-info-circle me-2"></i>
        <strong>Mode Input:</strong> Anda login sebagai <strong>NOC</strong> dengan hak akses <em>Tambah & Edit</em> data inventory.
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
    @php
        $totalMasuk = $data->whereInstanceOf(App\Models\BarangMasuk::class)->sum('jumlah');
        $totalKeluar = $data->whereInstanceOf(App\Models\BarangKeluar::class)->sum('jumlah');
        $totalStok = $totalMasuk - $totalKeluar;
    @endphp

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card stats-card card-gradient-blue">
                <div class="stats-card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-2 opacity-75 fw-semibold">Total Barang Masuk</p>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalMasuk) }}</h2>
                            <small class="opacity-75"><i class="fas fa-arrow-up me-1"></i>Unit masuk</small>
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
                            <small class="opacity-75"><i class="fas fa-arrow-down me-1"></i>Unit keluar</small>
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
                            <p class="mb-2 opacity-75 fw-semibold">Total Stok</p>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalStok) }}</h2>
                            <small class="opacity-75"><i class="fas fa-sync-alt me-1"></i>Masuk - Keluar</small>
                        </div>
                        <div class="stats-icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
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
                        @foreach($data as $index => $item)
                            @php
                                $isMasuk = $item instanceof App\Models\BarangMasuk;
                                $type = $isMasuk ? 'masuk' : 'keluar';
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $index + 1 }}</td>
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
                                    @if(auth()->user()->role === 'noc')
                                        <!-- NOC: Bisa Edit -->
                                        <a href="{{ route('inventory.edit', [$item->id, $type]) }}" 
                                            class="action-btn btn-edit" 
                                            title="Edit Data">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @elseif(auth()->user()->role === 'manajer')
                                        <!-- Manajer: Hanya View (optional, bisa dikosongkan atau diberi icon view) -->
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
    $('#inventoryTable').DataTable({
        searchPanes: {
            layout: 'columns-3',
            initCollapsed: true
        },
        dom: '<"row"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"f>>P<"row"<"col-sm-12"tr>><"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'searchPanes',
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
</script>
@endpush
