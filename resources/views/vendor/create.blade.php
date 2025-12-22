@extends('layouts.dashboard')

@section('title', 'Tambah Vendor')

@section('page-title', 'Tambah Vendor')
@section('page-subtitle', 'Form tambah data vendor baru')

@push('styles')
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
}

.page-header h4 {
    color: white;
    margin-bottom: 0.25rem;
    font-weight: 700;
    font-size: 1.5rem;
}

.page-header p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-size: 0.9375rem;
}

.breadcrumb-custom {
    background: white;
    padding: 0.875rem 1.25rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.breadcrumb-custom .breadcrumb {
    margin: 0;
}

.breadcrumb-custom .breadcrumb-item a {
    color: #2563eb;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.breadcrumb-custom .breadcrumb-item a:hover {
    color: #1e40af;
}

.breadcrumb-custom .breadcrumb-item.active {
    color: #64748b;
}

.card-form {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.card-header-form {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    padding: 1.5rem;
    border: none;
}

.card-header-form h5 {
    color: white;
    margin: 0;
    font-weight: 700;
    font-size: 1.125rem;
}

.card-header-form p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0.5rem 0 0 0;
    font-size: 0.875rem;
}

.form-section {
    background: #f8fafc;
    padding: 1.25rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    border-left: 4px solid #2563eb;
}

.form-section-title {
    color: #1e293b;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-section-title i {
    color: #2563eb;
    font-size: 1.125rem;
}

.form-label {
    color: #475569;
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 0.9375rem;
}

.form-label .required {
    color: #ef4444;
    margin-left: 0.25rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    padding: 0.625rem 0.875rem;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
}

.form-control::placeholder {
    color: #94a3b8;
}

.invalid-feedback {
    font-size: 0.875rem;
    margin-top: 0.375rem;
}

.is-invalid {
    border-color: #ef4444 !important;
}

textarea.form-control {
    resize: vertical;
    min-height: 120px;
}

.btn-submit {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: white;
    border: none;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
    color: white;
}

.btn-cancel {
    background: #f1f5f9;
    color: #475569;
    border: 2px solid #e2e8f0;
    padding: 0.75rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-cancel:hover {
    background: #e2e8f0;
    color: #334155;
    border-color: #cbd5e1;
}

.form-footer {
    background: #f8fafc;
    padding: 1.5rem;
    border-top: 2px solid #e2e8f0;
}

.input-group-text {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border: 2px solid #e2e8f0;
    border-right: none;
    border-radius: 10px 0 0 10px;
    color: #475569;
    font-weight: 600;
}

.input-group .form-control {
    border-left: none;
    border-radius: 0 10px 10px 0;
}

.char-counter {
    font-size: 0.8125rem;
    color: #94a3b8;
    margin-top: 0.375rem;
}

.alert-info {
    background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
    border: none;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    color: #1e40af;
    margin-bottom: 1.5rem;
}

.alert-info i {
    margin-right: 0.5rem;
}

/* Select2 Custom Styles */
.select2-container--bootstrap-5 .select2-selection {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    min-height: 45px;
}

.select2-container--bootstrap-5.select2-container--focus .select2-selection {
    border-color: #2563eb;
    box-shadow: 0 0 0 0.2rem rgba(37, 99, 235, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        padding: 1.25rem 1.5rem;
    }
    
    .page-header h4 {
        font-size: 1.25rem;
    }
    
    .card-header-form {
        padding: 1.25rem;
    }
    
    .form-section {
        padding: 1rem;
    }
    
    .btn-submit, .btn-cancel {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">
    
    <!-- Page Header -->
    <div class="page-header">
        <h4><i class="fas fa-plus-circle me-2"></i>Tambah Vendor Baru</h4>
        <p>Lengkapi form di bawah untuk menambahkan vendor baru</p>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb-custom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('vendor.index') }}">
                        <i class="fas fa-building me-1"></i>Data Vendor
                    </a>
                </li>
                <li class="breadcrumb-item active">Tambah Vendor</li>
            </ol>
        </nav>
    </div>

    <!-- Alert Info -->
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Informasi:</strong> Field yang bertanda <span class="text-danger">*</span> wajib diisi.
    </div>

    <!-- Form Card -->
    <div class="card card-form">
        <div class="card-header-form">
            <h5><i class="fas fa-edit me-2"></i>Form Data Vendor</h5>
            <p>Masukkan informasi vendor dengan lengkap dan benar</p>
        </div>
        <form action="{{ route('vendor.store') }}" method="POST" id="vendorForm">
            @csrf
            
            <div class="card-body p-4">
                
                <!-- Section: Informasi Dasar -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-info-circle"></i>
                        <span>Informasi Dasar</span>
                    </div>
                    
                    <div class="row g-3">
                        <!-- Kategori Vendor -->
                        <div class="col-md-6">
                            <label for="id_kategori_vendor" class="form-label">
                                Kategori Vendor<span class="required">*</span>
                            </label>
                            <select class="form-select @error('id_kategori_vendor') is-invalid @enderror" 
                                    id="id_kategori_vendor" 
                                    name="id_kategori_vendor" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('id_kategori_vendor') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kategori_vendor')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Vendor -->
                        <div class="col-md-6">
                            <label for="nama_vendor" class="form-label">
                                Nama Vendor<span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-building"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('nama_vendor') is-invalid @enderror" 
                                       id="nama_vendor" 
                                       name="nama_vendor" 
                                       placeholder="Masukkan nama vendor"
                                       value="{{ old('nama_vendor') }}"
                                       maxlength="255"
                                       required>
                                @error('nama_vendor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="char-counter">
                                <span id="nama_counter">0</span>/255 karakter
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Informasi Kontak -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-address-book"></i>
                        <span>Informasi Kontak</span>
                    </div>
                    
                    <div class="row g-3">
                        <!-- Nomor Telepon -->
                        <div class="col-md-6">
                            <label for="no_telp_vendor" class="form-label">
                                Nomor Telepon<span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('no_telp_vendor') is-invalid @enderror" 
                                       id="no_telp_vendor" 
                                       name="no_telp_vendor" 
                                       placeholder="Contoh: 081234567890"
                                       value="{{ old('no_telp_vendor') }}"
                                       maxlength="255"
                                       required>
                                @error('no_telp_vendor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6">
                            <label for="alamat_vendor" class="form-label">
                                Alamat<span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('alamat_vendor') is-invalid @enderror" 
                                       id="alamat_vendor" 
                                       name="alamat_vendor" 
                                       placeholder="Masukkan alamat lengkap"
                                       value="{{ old('alamat_vendor') }}"
                                       required>
                                @error('alamat_vendor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Informasi Tambahan -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-file-alt"></i>
                        <span>Informasi Tambahan</span>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <label for="deskripsi_vendor" class="form-label">
                                Deskripsi Vendor
                            </label>
                            <textarea class="form-control @error('deskripsi_vendor') is-invalid @enderror" 
                                      id="deskripsi_vendor" 
                                      name="deskripsi_vendor" 
                                      rows="4"
                                      placeholder="Masukkan deskripsi atau catatan tambahan tentang vendor (opsional)">{{ old('deskripsi_vendor') }}</textarea>
                            @error('deskripsi_vendor')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="char-counter">
                                <span id="desk_counter">0</span> karakter
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="form-footer">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('vendor.index') }}" class="btn btn-cancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i>Simpan Data
                    </button>
                </div>
            </div>
            
        </form>
    </div>

</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('#id_kategori_vendor').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Kategori --',
        allowClear: true
    });

    // Character counter for nama vendor
    $('#nama_vendor').on('input', function() {
        var length = $(this).val().length;
        $('#nama_counter').text(length);
    });

    // Character counter for deskripsi
    $('#deskripsi_vendor').on('input', function() {
        var length = $(this).val().length;
        $('#desk_counter').text(length);
    });

    // Initialize counters
    $('#nama_counter').text($('#nama_vendor').val().length);
    $('#desk_counter').text($('#deskripsi_vendor').val().length);

    // Phone number validation (only numbers)
    $('#no_telp_vendor').on('input', function() {
        this.value = this.value.replace(/[^0-9+]/g, '');
    });

    // Form submission with validation
    $('#vendorForm').on('submit', function(e) {
        var isValid = true;
        
        // Validate kategori
        if (!$('#id_kategori_vendor').val()) {
            isValid = false;
            $('#id_kategori_vendor').addClass('is-invalid');
        }
        
        // Validate nama vendor
        if (!$('#nama_vendor').val().trim()) {
            isValid = false;
            $('#nama_vendor').addClass('is-invalid');
        }
        
        // Validate no telepon
        if (!$('#no_telp_vendor').val().trim()) {
            isValid = false;
            $('#no_telp_vendor').addClass('is-invalid');
        }
        
        // Validate alamat
        if (!$('#alamat_vendor').val().trim()) {
            isValid = false;
            $('#alamat_vendor').addClass('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Mohon lengkapi semua field yang wajib diisi!',
                confirmButtonColor: '#ef4444'
            });
        }
    });

    // Remove invalid class on input
    $('.form-control, .form-select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });

    console.log('✅ Create Vendor Page Loaded');
});
</script>
@endpush