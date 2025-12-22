@extends('layouts.dashboard')

@section('title', 'Tambah Kategori Perangkat')

@section('page-title', 'Tambah Kategori')
@section('page-subtitle', 'Tambahkan kategori perangkat baru')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
}

.page-header h4 {
    color: white;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.page-header p {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
}

.breadcrumb-custom {
    background: transparent;
    padding: 0;
    margin-bottom: 0;
}

.breadcrumb-custom .breadcrumb-item {
    color: rgba(255, 255, 255, 0.8);
}

.breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

.breadcrumb-custom .breadcrumb-item.active {
    color: white;
    font-weight: 600;
}

.breadcrumb-custom a {
    color: white;
    text-decoration: none;
    transition: all 0.2s;
}

.breadcrumb-custom a:hover {
    color: #fbbf24;
}

.card-custom {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: none;
    overflow: hidden;
}

.card-header-custom {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    padding: 1.25rem 1.5rem;
    border: none;
}

.card-header-custom h5 {
    color: white;
    font-weight: 600;
    margin-bottom: 0;
}

.card-body-custom {
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.required-label::after {
    content: ' *';
    color: #dc2626;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    padding: 0.625rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
}

.form-control.is-invalid {
    border-color: #dc2626;
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 38, 38, 0.15);
}

.invalid-feedback {
    display: block;
    color: #dc2626;
    font-size: 0.875rem;
    margin-top: 0.375rem;
}

.form-text {
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.375rem;
}

.btn-submit {
    background: linear-gradient(135deg, #2563eb 0%, #1e3a8a 100%);
    color: white;
    border: none;
    padding: 0.625rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    color: white;
}

.btn-cancel {
    background: white;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    padding: 0.625rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #f9fafb;
    color: #374151;
    border-color: #d1d5db;
}

.alert-custom {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.alert-danger {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    flex-wrap: wrap;
}

@media (max-width: 768px) {
    .card-body-custom {
        padding: 1.5rem;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-submit, .btn-cancel {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
<div class="row g-4">
    <!-- Page Header -->
    <div class="col-12">
        <div class="page-header">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('kategori-perangkat.index') }}">
                            <i class="fas fa-tags me-1"></i>Kategori Perangkat
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Kategori</li>
                </ol>
            </nav>
            <h4><i class="fas fa-plus-circle me-2"></i>Tambah Kategori Perangkat</h4>
            <p>Isi form di bawah untuk menambahkan kategori perangkat baru</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
    <div class="col-12">
        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="col-12 col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-edit me-2"></i>Form Kategori Perangkat</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('kategori-perangkat.store') }}" method="POST" id="kategoriForm">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="nama_kategori" class="form-label required-label">Nama Kategori</label>
                        <input 
                            type="text" 
                            class="form-control @error('nama_kategori') is-invalid @enderror" 
                            id="nama_kategori" 
                            name="nama_kategori" 
                            value="{{ old('nama_kategori') }}"
                            placeholder="Contoh: Laptop, Desktop, Printer, dll"
                            required
                            autofocus
                        >
                        @error('nama_kategori')
                            <div class="invalid-feedback">
                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                        <small class="form-text">
                            <i class="fas fa-info-circle me-1"></i>Masukkan nama kategori yang unik dan deskriptif
                        </small>
                    </div>

                    <hr class="my-4">

                    <div class="action-buttons">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i>Simpan Kategori
                        </button>
                        <a href="{{ route('kategori-perangkat.index') }}" class="btn btn-cancel">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="col-12 col-lg-4">
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-lightbulb me-2"></i>Informasi</h5>
            </div>
            <div class="card-body-custom">
                <div class="mb-3">
                    <h6 class="text-primary mb-2"><i class="fas fa-check-circle me-2"></i>Panduan Pengisian</h6>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Nama kategori harus unik</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Maksimal 255 karakter</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Gunakan nama yang jelas dan mudah dipahami</small>
                        </li>
                    </ul>
                </div>
                
                <hr>
                
                <div>
                    <h6 class="text-primary mb-2"><i class="fas fa-tag me-2"></i>Contoh Kategori</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge bg-primary">Laptop</span>
                        <span class="badge bg-primary">Desktop</span>
                        <span class="badge bg-primary">Printer</span>
                        <span class="badge bg-primary">Scanner</span>
                        <span class="badge bg-primary">Monitor</span>
                        <span class="badge bg-primary">Keyboard</span>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Form validation
    $('#kategoriForm').on('submit', function(e) {
        const namaKategori = $('#nama_kategori').val().trim();
        
        if (namaKategori === '') {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Nama kategori harus diisi!',
                confirmButtonColor: '#2563eb'
            });
            $('#nama_kategori').focus();
            return false;
        }
    });

    // Auto dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Character counter
    $('#nama_kategori').on('input', function() {
        const length = $(this).val().length;
        const maxLength = 255;
        
        if (length > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
        }
    });
});
</script>
@endpush