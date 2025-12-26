@extends('layouts.dashboard')

@section('title', 'Kategori Perangkat')

@section('page-title', 'Kategori Perangkat')
@section('page-subtitle', 'Kelola kategori perangkat inventaris')

@push('styles')
<link rel="icon" type="image/png" href="{{ asset('images/transdata-logo.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary-blue: #2563eb;
    --dark-blue: #1e3a8a;
    --orange: #f97316;
    --dark-orange: #ea580c;
}

.page-header {
    background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 50%, var(--orange) 100%);
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
}

.page-header-content {
    position: relative;
    z-index: 1;
}

.page-header h4 {
    color: white;
    font-weight: 800;
    margin-bottom: 0.75rem;
    font-size: 2rem;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.page-header p {
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 0;
    font-size: 1.05rem;
}

.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-blue), var(--orange));
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 24px rgba(37, 99, 235, 0.15);
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
    font-size: 1.75rem;
}

.stat-icon.blue {
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(30, 58, 138, 0.1));
    color: var(--primary-blue);
}

.stat-icon.orange {
    background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(234, 88, 12, 0.1));
    color: var(--orange);
}

.stat-label {
    color: #6b7280;
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-value {
    color: #1f2937;
    font-size: 2rem;
    font-weight: 700;
}

.action-bar {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.search-box {
    position: relative;
    flex: 1;
    max-width: 450px;
}

.search-box input {
    padding: 0.875rem 1.25rem 0.875rem 3rem;
    border-radius: 12px;
    border: 2px solid #e5e7eb;
    transition: all 0.3s ease;
    width: 100%;
    font-size: 0.95rem;
}

.search-box input:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 0.25rem rgba(37, 99, 235, 0.1);
    outline: none;
}

.search-box i {
    position: absolute;
    left: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 1.1rem;
}

.btn-add {
    background: linear-gradient(135deg, var(--primary-blue) 0%, var(--dark-blue) 100%);
    color: white;
    border: none;
    padding: 0.875rem 2rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-add:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    color: white;
}

.btn-add i {
    margin-right: 0.5rem;
}

.table-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, var(--dark-blue) 0%, var(--primary-blue) 100%);
    padding: 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.table-header h5 {
    color: white;
    font-weight: 700;
    margin: 0;
    font-size: 1.25rem;
}

.filter-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.875rem;
    font-weight: 600;
}

.table-responsive {
    overflow-x: auto;
}

.table-custom {
    margin-bottom: 0;
    width: 100%;
}

.table-custom thead {
    background: #f8fafc;
    border-bottom: 2px solid #e5e7eb;
}

.table-custom thead th {
    color: #374151;
    font-weight: 700;
    padding: 1.25rem 1.5rem;
    border: none;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}

.table-custom tbody tr {
    transition: all 0.3s ease;
    border-bottom: 1px solid #f3f4f6;
}

.table-custom tbody tr:hover {
    background: linear-gradient(90deg, rgba(37, 99, 235, 0.03), rgba(249, 115, 22, 0.03));
    transform: scale(1.005);
}

.table-custom tbody td {
    padding: 1.25rem 1.5rem;
    vertical-align: middle;
    color: #4b5563;
}

.category-name {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.category-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(249, 115, 22, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    color: var(--primary-blue);
}

.category-info h6 {
    margin: 0;
    color: #1f2937;
    font-weight: 700;
    font-size: 1rem;
}

.category-info span {
    color: #9ca3af;
    font-size: 0.85rem;
}

.badge-count {
    background: linear-gradient(135deg, var(--orange) 0%, var(--dark-orange) 100%);
    color: white;
    padding: 0.5rem 1.25rem;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
    box-shadow: 0 2px 8px rgba(249, 115, 22, 0.3);
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
}

.btn-action {
    padding: 0.5rem 1.25rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-edit {
    background: linear-gradient(135deg, var(--primary-blue), var(--dark-blue));
    color: white;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

.btn-edit:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.4);
    color: white;
}

.btn-delete {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
}

.btn-delete:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(220, 38, 38, 0.4);
    color: white;
}

.alert-custom {
    border-radius: 14px;
    border: none;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
}

.alert-custom i {
    font-size: 1.5rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state-icon {
    width: 120px;
    height: 120px;
    margin: 0 auto 2rem;
    border-radius: 50%;
    background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(249, 115, 22, 0.1));
    display: flex;
    align-items: center;
    justify-content: center;
}

.empty-state-icon i {
    font-size: 3.5rem;
    color: var(--primary-blue);
}

.empty-state h5 {
    color: #1f2937;
    font-weight: 700;
    font-size: 1.5rem;
    margin-bottom: 0.75rem;
}

.empty-state p {
    color: #6b7280;
    font-size: 1.05rem;
    margin-bottom: 1.5rem;
}

.pagination-container {
    padding: 1.5rem;
    border-top: 1px solid #f3f4f6;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pagination-info {
    color: #6b7280;
    font-size: 0.9rem;
}

@media (max-width: 992px) {
    .stats-container {
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    }
    
    .page-header h4 {
        font-size: 1.6rem;
    }
}

@media (max-width: 768px) {
    .action-bar {
        flex-direction: column;
        align-items: stretch;
    }
    
    .search-box {
        max-width: 100%;
    }
    
    .btn-add {
        width: 100%;
        justify-content: center;
    }
    
    .page-header {
        padding: 2rem;
    }
    
    .stats-container {
        grid-template-columns: 1fr;
    }
    
    .table-container {
        border-radius: 12px;
    }
    
    .action-buttons {
        flex-wrap: wrap;
    }
    
    .btn-action {
        flex: 1;
        justify-content: center;
    }
}
</style>
@endpush

@section('content')
<div class="row g-4">
    <!-- Page Header -->
    <div class="col-12">
        <div class="page-header">
            <div class="page-header-content">
                <h4><i class="fas fa-layer-group me-3"></i>Kategori Perangkat</h4>
                <p><i class="fas fa-info-circle me-2"></i>Kelola dan organisir kategori perangkat inventaris dengan mudah dan efisien</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="col-12">
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon blue">
                    <i class="fas fa-folder-open"></i>
                </div>
                <div class="stat-label">Total Kategori</div>
                <div class="stat-value">{{ $kategoriPerangkats->count() }}</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon orange">
                    <i class="fas fa-laptop"></i>
                </div>
                <div class="stat-label">Total Perangkat</div>
                <div class="stat-value">{{ $kategoriPerangkats->sum('perangkats_count') }}</div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="col-12">
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Berhasil!</strong>
                <p class="mb-0">{{ session('success') }}</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="col-12">
        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Gagal!</strong>
                <p class="mb-0">{{ session('error') }}</p>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Action Bar -->
    <div class="col-12">
        <div class="action-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="searchInput" placeholder="Cari kategori perangkat...">
            </div>
            
            {{-- Tombol Tambah - HANYA ADMIN --}}
            @role('admin')
            <a href="{{ route('kategori-perangkat.create') }}" class="btn btn-add">
                <i class="fas fa-plus-circle"></i>Tambah Kategori
            </a>
            @endrole
        </div>
    </div>

    <!-- Table Container -->
    <div class="col-12">
        <div class="table-container">
            <div class="table-header">
                <h5><i class="fas fa-list me-2"></i>Daftar Kategori Perangkat</h5>
                <span class="filter-badge" id="resultCount">{{ $kategoriPerangkats->count() }} Kategori</span>
            </div>
            
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No</th>
                            <th style="width: 42%;">Nama Kategori</th>
                            <th style="width: 20%;" class="text-center">Jumlah Perangkat</th>
                            {{-- Kolom Aksi - HANYA ADMIN yang bisa CRUD --}}
                            @role('admin')
                            <th style="width: 30%;" class="text-center">Aksi</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @forelse($kategoriPerangkats as $index => $kategori)
                        <tr>
                            <td><strong>#{{ $index + 1 }}</strong></td>
                            <td>
                                <div class="category-name">
                                    <div class="category-icon">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div class="category-info">
                                        <h6>{{ $kategori->nama_kategori }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge-count">
                                    <i class="fas fa-laptop"></i>
                                    {{ $kategori->perangkats_count }}
                                </span>
                            </td>
                            
                            {{-- Kolom Aksi - HANYA ADMIN yang bisa Edit & Hapus --}}
                            @role('admin')
                            <td class="text-center">
                                <div class="action-buttons">
                                    <a href="{{ route('kategori-perangkat.edit', $kategori->id) }}" class="btn-action btn-edit">
                                        <i class="fas fa-edit"></i>Edit
                                    </a>
                                    <form action="{{ route('kategori-perangkat.destroy', $kategori->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn-action btn-delete btn-delete-confirm">
                                            <i class="fas fa-trash-alt"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                            @endrole
                        </tr>
                        @empty
                        <tr id="emptyRow">
                            {{-- Colspan disesuaikan dengan jumlah kolom --}}
                            @role('admin')
                            <td colspan="4">
                            @else
                            <td colspan="3">
                            @endrole
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-inbox"></i>
                                    </div>
                                    <h5>Belum Ada Kategori</h5>
                                    <p>
                                        @role('admin')
                                        Mulai dengan menambahkan kategori perangkat pertama Anda
                                        @else
                                        Belum ada data kategori perangkat tersedia
                                        @endrole
                                    </p>
                                    @role('admin')
                                    <a href="{{ route('kategori-perangkat.create') }}" class="btn btn-add">
                                        <i class="fas fa-plus-circle"></i>
                                        Tambah Kategori Sekarang
                                    </a>
                                    @endrole
                                </div>
                            </td>
                        </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
            
            @if($kategoriPerangkats->count() > 0)
            <div class="pagination-container">
                <div class="pagination-info">
                    Menampilkan <strong>{{ $kategoriPerangkats->count() }}</strong> kategori
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Search functionality with counter
    $('#searchInput').on('keyup', function() {
        const value = $(this).val().toLowerCase();
        let visibleRows = 0;
        
        $('#tableBody tr').filter(function() {
            const matches = $(this).text().toLowerCase().indexOf(value) > -1;
            $(this).toggle(matches);
            if (matches && !$(this).attr('id')) visibleRows++;
        });
        
        // Update counter
        $('#resultCount').text(visibleRows + ' Kategori');
        
        // Show/hide empty state
        if (visibleRows === 0 && value !== '') {
            if ($('#noResultRow').length === 0) {
                const colspan = @role('admin')'4'@else'3'@endrole;
                $('#tableBody').append(`
                    <tr id="noResultRow">
                        <td colspan="${colspan}">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <h5>Tidak Ada Hasil</h5>
                                <p>Kategori "<strong>${value}</strong>" tidak ditemukan</p>
                                <button class="btn btn-add" onclick="$('#searchInput').val('').trigger('keyup')">
                                    <i class="fas fa-redo"></i>Reset Pencarian
                                </button>
                            </div>
                        </td>
                    </tr>
                `);
            }
        } else {
            $('#noResultRow').remove();
        }
    });

    // Delete confirmation with SweetAlert2 - HANYA UNTUK ADMIN
    @role('admin')
    $('.btn-delete-confirm').on('click', function(e) {
        e.preventDefault();
        const form = $(this).closest('form');
        const categoryName = $(this).closest('tr').find('.category-info h6').text();
        const deviceCount = $(this).closest('tr').find('.badge-count').text().match(/\d+/)[0];
        
        let warningMessage = '';
        if (deviceCount > 0) {
            warningMessage = `<br><small class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Perhatian: Kategori ini memiliki ${deviceCount} perangkat terkait</small>`;
        }
        
        Swal.fire({
            title: 'Konfirmasi Hapus',
            html: `Apakah Anda yakin ingin menghapus kategori<br><strong>"${categoryName}"</strong>?${warningMessage}`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fas fa-trash me-2"></i>Ya, Hapus!',
            cancelButtonText: '<i class="fas fa-times me-2"></i>Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Menghapus...',
                    html: 'Mohon tunggu sebentar',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                form.submit();
            }
        });
    });
    @endrole

    // Auto dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Keyboard shortcuts - DISESUAIKAN DENGAN ROLE
    $(document).on('keydown', function(e) {
        // Ctrl/Cmd + K = Focus search (Semua role)
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            $('#searchInput').focus();
        }
        
        // Ctrl/Cmd + N = New category (HANYA ADMIN)
        @role('admin')
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            window.location.href = '{{ route("kategori-perangkat.create") }}';
        }
        @endrole
    });

    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@endpush