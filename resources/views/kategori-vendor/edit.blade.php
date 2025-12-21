@extends('layouts.dashboard')

@section('title', 'Edit Kategori Vendor')
@section('page-title', 'Edit Kategori Vendor')
@section('page-description', 'Perbarui informasi kategori vendor')

@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12">
            <nav class="breadcrumb-custom" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('kategori-vendor.index') }}">
                            <i class="fas fa-home"></i>
                            <span>Kategori Vendor</span>
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
                    <h1 class="page-title">Edit Kategori Vendor</h1>
                    <p class="page-subtitle">Perbarui informasi kategori "{{ $kategori->nama_kategori }}"</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Section -->
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <div class="form-header-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div>
                        <h3 class="form-card-title">Informasi Kategori</h3>
                        <p class="form-card-subtitle">Perbarui informasi kategori dengan data yang valid</p>
                    </div>
                </div>

                <div class="form-card-body">
                    <form action="{{ route('kategori-vendor.update', $kategori->id) }}" method="POST" id="kategoriForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group-custom">
                            <label for="nama_kategori" class="form-label-custom">
                                <i class="fas fa-tag"></i>
                                <span class="label-text">Nama Kategori</span>
                                <span class="label-required">*</span>
                            </label>
                            <div class="input-wrapper">
                                <div class="input-icon">
                                    <i class="fas fa-tags"></i>
                                </div>
                                <input type="text" 
                                       class="form-control-custom @error('nama_kategori') is-invalid @enderror" 
                                       id="nama_kategori" 
                                       name="nama_kategori" 
                                       value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                                       placeholder="Masukkan nama kategori"
                                       required
                                       maxlength="255">
                                <div class="char-counter">
                                    <span id="charCount">{{ strlen($kategori->nama_kategori) }}</span>/255
                                </div>
                            </div>
                            @error('nama_kategori')
                            <div class="error-message">
                                <i class="fas fa-exclamation-circle"></i>
                                <span>{{ $message }}</span>
                            </div>
                            @enderror
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Perubahan nama akan mempengaruhi semua vendor yang menggunakan kategori ini</span>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary-custom">
                                <i class="fas fa-save me-2"></i>
                                <span>Update Kategori</span>
                            </button>
                            <a href="{{ route('kategori-vendor.index') }}" class="btn btn-secondary-custom">
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
            <!-- Current Stats Card -->
            @if($kategori->vendors()->count() > 0)
            <div class="info-card stats-info-card">
                <div class="info-card-header">
                    <div class="info-icon stats-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4 class="info-title">Statistik Saat Ini</h4>
                </div>
                <div class="info-card-body">
                    <div class="stat-item-large">
                        <div class="stat-icon-large">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $kategori->vendors()->count() }}</div>
                            <div class="stat-label">Vendor Menggunakan</div>
                            <div class="stat-badge">
                                <i class="fas fa-check-circle"></i>
                                Aktif
                            </div>
                        </div>
                    </div>
                    <div class="alert-info-custom">
                        <i class="fas fa-info-circle"></i>
                        <p>Kategori ini sedang digunakan oleh <strong>{{ $kategori->vendors()->count() }} vendor</strong>. Perubahan nama akan mempengaruhi semua vendor tersebut.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Vendor List Card -->
            @if($kategori->vendors()->count() > 0)
            <div class="info-card vendor-list-card">
                <div class="info-card-header">
                    <div class="info-icon vendor-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h4 class="info-title">Vendor Terkait</h4>
                </div>
                <div class="info-card-body">
                    <div class="vendor-list">
                        @foreach($kategori->vendors()->limit(5)->get() as $vendor)
                        <div class="vendor-item">
                            <div class="vendor-avatar">
                                {{ strtoupper(substr($vendor->nama_vendor, 0, 2)) }}
                            </div>
                            <div class="vendor-info">
                                <div class="vendor-name">{{ $vendor->nama_vendor }}</div>
                                <div class="vendor-meta">
                                    <i class="fas fa-phone"></i>
                                    <span>{{ $vendor->no_telp_vendor ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        @if($kategori->vendors()->count() > 5)
                        <div class="vendor-more">
                            <i class="fas fa-plus-circle"></i>
                            <span>dan {{ $kategori->vendors()->count() - 5 }} vendor lainnya</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root {
    --primary-blue: #1e40af;
    --primary-orange: #ea580c;
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
    color: var(--primary-blue);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.breadcrumb-item a:hover {
    color: #1e3a8a;
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

/* Form Card */
.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    overflow: hidden;
    margin-bottom: 2rem;
}

.form-card-header {
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
    background: linear-gradient(135deg, var(--primary-orange) 0%, #fb923c 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.75rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(234, 88, 12, 0.3);
}

.form-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.form-card-subtitle {
    color: var(--gray-600);
    font-size: 1rem;
    margin-bottom: 0;
}

.form-card-body {
    padding: 2.5rem;
}

/* Form Group */
.form-group-custom {
    margin-bottom: 2rem;
}

.form-label-custom {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 600;
    color: var(--gray-800);
    font-size: 1.05rem;
    margin-bottom: 0.75rem;
}

.form-label-custom i {
    color: var(--primary-orange);
    font-size: 1.1rem;
}

.label-required {
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

.form-control-custom {
    width: 100%;
    padding: 1.125rem 5.5rem 1.125rem 3.75rem;
    border: 2px solid var(--gray-200);
    border-radius: 14px;
    font-size: 1.05rem;
    transition: all 0.3s ease;
    background: white;
    color: var(--gray-800);
}

.form-control-custom:focus {
    outline: none;
    border-color: var(--primary-orange);
    box-shadow: 0 0 0 4px rgba(234, 88, 12, 0.1);
}

.form-control-custom.is-invalid {
    border-color: var(--danger-red);
}

.form-control-custom.is-invalid:focus {
    box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.1);
}

.char-counter {
    position: absolute;
    right: 1.25rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-600);
    font-size: 0.875rem;
    font-weight: 600;
    background: var(--gray-100);
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--danger-red);
    font-size: 0.95rem;
    margin-top: 0.75rem;
    font-weight: 500;
    padding: 0.75rem 1rem;
    background: rgba(220, 38, 38, 0.1);
    border-radius: 10px;
    border-left: 3px solid var(--danger-red);
}

.error-message i {
    font-size: 1.1rem;
}

.form-hint {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    color: var(--gray-600);
    font-size: 0.95rem;
    margin-top: 0.75rem;
    padding: 0.75rem 1rem;
    background: #fef3c7;
    border-radius: 10px;
    border-left: 3px solid var(--warning-yellow);
}

.form-hint i {
    color: var(--warning-yellow);
    margin-top: 0.125rem;
    flex-shrink: 0;
    font-size: 1.1rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2.5rem;
    padding-top: 2rem;
    border-top: 2px solid var(--gray-100);
}

.btn-primary-custom {
    background: linear-gradient(135deg, var(--primary-orange) 0%, #fb923c 100%);
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

.btn-primary-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(234, 88, 12, 0.4);
}

.btn-secondary-custom {
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

.btn-secondary-custom:hover {
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

.stats-icon {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    color: var(--primary-blue);
}

.vendor-icon {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: var(--success-green);
}

.info-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--gray-800);
    margin: 0;
}

.info-card-body {
    padding: 1.5rem;
}

/* Stat Item Large */
.stat-item-large {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 14px;
    margin-bottom: 1rem;
}

.stat-icon-large {
    width: 70px;
    height: 70px;
    background: linear-gradient(135deg, var(--primary-blue) 0%, #3b82f6 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(30, 64, 175, 0.3);
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--primary-blue);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--gray-600);
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.stat-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.875rem;
    background: rgba(30, 64, 175, 0.1);
    border-radius: 8px;
    color: var(--primary-blue);
    font-size: 0.875rem;
    font-weight: 600;
}

.alert-info-custom {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 1rem;
    background: #fef3c7;
    border-radius: 10px;
    border-left: 3px solid var(--warning-yellow);
}

.alert-info-custom i {
    color: var(--warning-yellow);
    font-size: 1.25rem;
    margin-top: 0.125rem;
    flex-shrink: 0;
}

.alert-info-custom p {
    color: var(--gray-700);
    font-size: 0.95rem;
    margin: 0;
    line-height: 1.5;
}

/* Vendor List */
.vendor-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.vendor-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--gray-50);
    border-radius: 12px;
    transition: all 0.2s ease;
}

.vendor-item:hover {
    background: var(--gray-100);
}

.vendor-avatar {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, var(--primary-blue) 0%, #3b82f6 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    flex-shrink: 0;
}

.vendor-info {
    flex: 1;
    min-width: 0;
}

.vendor-name {
    font-weight: 600;
    color: var(--gray-800);
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.vendor-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-600);
    font-size: 0.875rem;
}

.vendor-meta i {
    font-size: 0.875rem;
}

.vendor-more {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 1rem;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    border-radius: 12px;
    color: var(--primary-blue);
    font-weight: 600;
    font-size: 0.95rem;
}

/* Responsive */
@media (max-width: 992px) {
    .page-header {
        flex-direction: column;
        text-align: center;
    }
    
    .page-title {
        font-size: 1.75rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }

    .form-card-header {
        flex-direction: column;
        text-align: center;
    }

    .stat-item-large {
        flex-direction: column;
        text-align: center;
    }
    .stat-icon-large {
        margin-bottom: 1rem;
    }
    .vendor-item {
        flex-direction: column;
        text-align: center;
    }
    .vendor-avatar {
        margin-bottom: 0.5rem;
    }
}

@media (max-width: 576px) {
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

    .form-card-body {
        padding: 1.5rem;
    }
}
</style>
@endpush
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const namaKategoriInput = document.getElementById('nama_kategori');
    const charCount = document.getElementById('charCount');
    
    // Character counter
    namaKategoriInput.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length;
    });
    
    // Form validation
    const form = document.getElementById('kategoriForm');
    form.addEventListener('submit', function(e) {
        const namaKategori = namaKategoriInput.value.trim();
        
        if (namaKategori === '') {
            e.preventDefault();
            namaKategoriInput.classList.add('is-invalid');
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i><span>Menyimpan...</span>';
    });
    
    // Remove invalid class on input
    namaKategoriInput.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
});
</script>
@endpush
@endsection