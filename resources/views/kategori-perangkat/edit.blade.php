@extends('layouts.dashboard')

@section('title', 'Edit Kategori Perangkat')

@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Perbarui data kategori perangkat')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary-orange: #ea580c;
    --primary-orange-light: #fb923c;
    --primary-orange-dark: #c2410c;
    --success-green: #059669;
    --danger-red: #dc2626;
    --warning-yellow: #f59e0b;
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

/* Breadcrumb */
.breadcrumb-custom {
    margin-bottom: 0;
}

.breadcrumb {
    background: white;
    padding: 1rem 1.5rem;
    border-radius: 14px;
    box-shadow: var(--shadow-sm);
    margin-bottom: 0;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-item a {
    color: var(--primary-orange);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.breadcrumb-item a:hover {
    color: var(--primary-orange-dark);
}

.breadcrumb-item.active {
    color: var(--gray-600);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

/* Page Header */
.page-header {
    background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: var(--shadow-xl);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    position: relative;
    overflow: hidden;
}

.page-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
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
    position: relative;
    z-index: 1;
}

.page-header-content {
    position: relative;
    z-index: 1;
}

.page-header-content h4 {
    font-size: 2rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.5rem;
}

.page-header-content p {
    color: rgba(255, 255, 255, 0.9);
    font-size: 1.05rem;
    margin-bottom: 0;
}

/* Form Card */
.card-custom {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    margin-bottom: 2rem;
}

.card-header-custom {
    padding: 2rem;
    border-bottom: 2px solid var(--gray-100);
    background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.form-header-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.75rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
}

.card-header-custom h5 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.card-header-custom p {
    color: var(--gray-600);
    font-size: 1rem;
    margin-bottom: 0;
}

.card-body-custom {
    padding: 2.5rem;
}

/* Form Group */
.form-group-custom {
    margin-bottom: 2rem;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: var(--gray-800);
    font-size: 1.05rem;
    margin-bottom: 0.75rem;
}

.form-label i {
    color: var(--primary-orange);
    font-size: 1.1rem;
}

.required-label::after {
    content: ' *';
    color: var(--danger-red);
    font-size: 1.25rem;
    margin-left: auto;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-600);
    font-size: 1.25rem;
    z-index: 2;
}

.form-control {
    width: 100%;
    padding: 1.125rem 1rem 1.125rem 3.75rem;
    border: 2px solid var(--gray-200);
    border-radius: 14px;
    font-size: 1.05rem;
    transition: all 0.3s ease;
    background: white;
    color: var(--gray-800);
}

.form-control:focus {
    outline: none;
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
}

.form-control.is-invalid {
    border-color: var(--primary-orange);
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
}

.invalid-feedback {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-orange);
    font-size: 0.95rem;
    margin-top: 0.75rem;
    font-weight: 500;
    padding: 0.75rem 1rem;
    background: rgba(234, 88, 12, 0.1);
    border-radius: 10px;
    border-left: 3px solid var(--primary-orange);
}

.invalid-feedback i {
    font-size: 1.1rem;
}

.form-text {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    color: var(--gray-600);
    font-size: 0.95rem;
    margin-top: 0.75rem;
}

.form-text i {
    color: var(--primary-orange);
    margin-top: 0.125rem;
    flex-shrink: 0;
    font-size: 1.1rem;
}

/* Alert */
.alert-custom {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.25rem;
    box-shadow: var(--shadow);
}

.alert-danger {
    background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);
    color: white;
}

/* Info Box */
.info-box {
    background: #fff7ed;
    border-left: 4px solid var(--primary-orange-light);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.info-box h6 {
    color: var(--primary-orange);
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-box p {
    color: var(--gray-700);
    margin-bottom: 0;
    font-size: 0.95rem;
    line-height: 1.5;
}

.badge-info {
    background: linear-gradient(135deg, var(--primary-orange-light) 0%, var(--primary-orange) 100%);
    color: white;
    padding: 0.375rem 0.875rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
}

/* Form Actions */
.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 2px solid var(--gray-100);
}

.btn-update {
    background: linear-gradient(135deg, var(--primary-orange) 0%, var(--primary-orange-light) 100%);
    color: white;
    border: none;
    padding: 1rem 2.5rem;
    border-radius: 14px;
    font-weight: 600;
    font-size: 1.05rem;
    display: inline-flex;
    align-items: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(234, 88, 12, 0.3);
}

.btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(234, 88, 12, 0.4);
    color: white;
}

.btn-cancel {
    background: white;
    color: var(--gray-700);
    border: 2px solid var(--gray-300);
    padding: 1rem 2.5rem;
    border-radius: 14px;
    font-weight: 600;
    font-size: 1.05rem;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: var(--gray-50);
    border-color: var(--gray-400);
    color: var(--gray-800);
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 18px;
    box-shadow: var(--shadow-lg);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.info-card-header {
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border-bottom: 2px solid var(--gray-100);
}

.info-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.info-icon.lightbulb-icon {
    background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
    color: var(--primary-orange);
}

.info-icon.history-icon {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: #1e40af;
}

.info-card-header h5 {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0;
}

.info-card-body {
    padding: 1.5rem;
}

.text-primary {
    color: var(--primary-orange) !important;
}

.info-card-body h6 {
    font-size: 1rem;
    font-weight: 600;
    color: var(--primary-orange);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-card-body ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.info-card-body ul li {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
    color: var(--gray-700);
}

.info-card-body ul li i {
    color: var(--gray-600);
    font-size: 0.875rem;
}

.info-card-body p {
    color: var(--gray-700);
    font-size: 0.95rem;
    line-height: 1.6;
    margin: 0;
}

.info-card-body hr {
    margin: 1.25rem 0;
    border-color: var(--gray-200);
}

/* Responsive */
@media (max-width: 992px) {
    .page-header {
        flex-direction: column;
        text-align: center;
    }
    
    .page-header-content h4 {
        font-size: 1.75rem;
    }
    
    .action-buttons {
        flex-direction: column;
    }
    
    .btn-update, .btn-cancel {
        width: 100%;
        justify-content: center;
    }

    .card-header-custom {
        flex-direction: column;
        text-align: center;
    }
}

@media (max-width: 768px) {
    .card-body-custom {
        padding: 1.5rem;
    }
    
    .page-header {
        padding: 1.5rem;
    }
    
    .page-header-icon {
        width: 60px;
        height: 60px;
        font-size: 2rem;
    }

    .page-header-content h4 {
        font-size: 1.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav class="breadcrumb-custom" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('kategori-perangkat.index') }}">
                            <i class="fas fa-home"></i>
                            <span>Kategori Perangkat</span>
                        </a>
                    </li>
                    <li class="breadcrumb-item active">
                        <i class="fas fa-edit"></i>
                        <span>Edit Kategori</span>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <div class="page-header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div class="page-header-content">
                    <h4>Edit Kategori Perangkat</h4>
                    <p>Perbarui informasi kategori "{{ $kategori->nama_kategori }}"</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('error'))
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-8">
            <div class="card-custom">
                <div class="card-header-custom">
                    <div class="form-header-icon">
                        <i class="fas fa-pen"></i>
                    </div>
                    <div>
                        <h5>Form Edit Kategori</h5>
                        <p>Perbarui informasi kategori dengan data yang valid</p>
                    </div>
                </div>
                <div class="card-body-custom">
                    <!-- Info Box -->
                    <div class="info-box">
                        <h6><i class="fas fa-info-circle"></i>Informasi Kategori</h6>
                        <p>
                            Anda sedang mengedit kategori: 
                            <strong>{{ $kategori->nama_kategori }}</strong>
                            @if($kategori->perangkats_count > 0)
                            <br>
                            <span class="badge-info mt-2">
                                <i class="fas fa-laptop"></i>
                                Terdapat {{ $kategori->perangkats_count }} perangkat dalam kategori ini
                            </span>
                            @endif
                        </p>
                    </div>

                    <form action="{{ route('kategori-perangkat.update', $kategori->id) }}" method="POST" id="kategoriForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group-custom">
                            <label for="nama_kategori" class="form-label required-label">
                                <i class="fas fa-tag"></i>
                                <span>Nama Kategori</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <input 
                                    type="text" 
                                    class="form-control @error('nama_kategori') is-invalid @enderror" 
                                    id="nama_kategori" 
                                    name="nama_kategori" 
                                    value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                    placeholder="Masukkan nama kategori"
                                    required
                                    autofocus
                                    maxlength="255"
                                >
                            </div>
                            @error('nama_kategori')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>{{ $message }}</span>
                                </div>
                            @enderror
                            <small class="form-text">
                                <i class="fas fa-info-circle"></i>
                                <span>Masukkan nama kategori yang unik dan deskriptif</span>
                            </small>
                        </div>

                        <div class="action-buttons">
                            <button type="submit" class="btn btn-update">
                                <i class="fas fa-save me-2"></i>
                                <span>Update Kategori</span>
                            </button>
                            <a href="{{ route('kategori-perangkat.index') }}" class="btn btn-cancel">
                                <i class="fas fa-times-circle me-2"></i>
                                <span>Batal</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Sidebar -->
        <div class="col-lg-4">
            <!-- Panduan Card -->
            <div class="info-card">
                <div class="info-card-header">
                    <div class="info-icon lightbulb-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h5>Panduan</h5>
                </div>
                <div class="info-card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-check-circle"></i>Aturan Pengisian</h6>
                        <ul>
                            <li>
                                <i class="fas fa-chevron-right"></i>
                                <span>Nama kategori harus unik</span>
                            </li>
                            <li>
                                <i class="fas fa-chevron-right"></i>
                                <span>Maksimal 255 karakter</span>
                            </li>
                            <li>
                                <i class="fas fa-chevron-right"></i>
                                <span>Tidak boleh sama dengan kategori lain</span>
                            </li>
                        </ul>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <h6><i class="fas fa-exclamation-triangle"></i>Perhatian</h6>
                        <p>
                            Mengubah nama kategori akan mempengaruhi semua perangkat yang menggunakan kategori ini.
                        </p>
                    </div>

                    @if($kategori->perangkats_count > 0)
                    <hr>
                    
                    <div>
                        <h6><i class="fas fa-laptop"></i>Perangkat Terkait</h6>
                        <p>
                            Kategori ini digunakan oleh <strong>{{ $kategori->perangkats_count }}</strong> perangkat. 
                            Perubahan akan diterapkan ke semua perangkat tersebut.
                        </p>
                    </div>
                    @endif
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
                confirmButtonColor: '#ea580c'
            });
            $('#nama_kategori').focus();
            return false;
        }
    });

    // Confirm update if there are devices using this category
    const deviceCount = {{ $kategori->perangkats_count ?? 0 }};
    if (deviceCount > 0) {
        $('#kategoriForm').on('submit', function(e) {
            e.preventDefault();
            const form = this;
            
            Swal.fire({
                title: 'Konfirmasi Update',
                text: `Kategori ini digunakan oleh ${deviceCount} perangkat. Yakin ingin mengupdate?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ea580c',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Update!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    }

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