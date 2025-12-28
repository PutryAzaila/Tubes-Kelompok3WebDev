@extends('layouts.dashboard')

@section('title', 'Tambah Perangkat')

@section('page-title', 'Tambah Perangkat')
@section('page-subtitle', 'Form tambah data perangkat baru')

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

/* Status Radio Options */
.status-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
}

.status-option {
    position: relative;
}

.status-option input[type="radio"] {
    position: absolute;
    opacity: 0;
}

.status-option label {
    display: block;
    border: 2px solid #e2e8f0;
    border-radius: 10px;
    padding: 1rem 0.75rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
    background: white;
}

.status-option label:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
    transform: translateY(-2px);
}

.status-option input[type="radio"]:checked + label {
    border-width: 3px;
    font-weight: 600;
}

.status-option.berfungsi input[type="radio"]:checked + label {
    border-color: #10b981;
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-option.rusak input[type="radio"]:checked + label {
    border-color: #ef4444;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

.status-option.hilang input[type="radio"]:checked + label {
    border-color: #f59e0b;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.status-option.return input[type="radio"]:checked + label {
    border-color: #8b5cf6;
    background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
    color: #5b21b6;
}

.status-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: #f1f5f9;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    margin: 0 auto 0.5rem;
    transition: all 0.3s ease;
}

.status-option input[type="radio"]:checked + label .status-icon {
    background: rgba(255, 255, 255, 0.5);
}

.status-option.berfungsi input[type="radio"]:checked + label .status-icon {
    color: #065f46;
}

.status-option.rusak input[type="radio"]:checked + label .status-icon {
    color: #991b1b;
}

.status-option.hilang input[type="radio"]:checked + label .status-icon {
    color: #92400e;
}

.status-option.return input[type="radio"]:checked + label .status-icon {
    color: #5b21b6;
}

.status-label {
    font-weight: 600;
    color: #64748b;
    margin: 0;
    font-size: 0.875rem;
}

.status-option input[type="radio"]:checked + label .status-label {
    font-weight: 700;
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
    
    .status-options {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .btn-submit, .btn-cancel {
        width: 100%;
        margin-bottom: 0.5rem;
    }
}

@media (max-width: 576px) {
    .status-options {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-lg-4">
    
    <!-- Page Header -->
    <div class="page-header">
        <h4><i class="fas fa-plus-circle me-2"></i>Tambah Perangkat Baru</h4>
        <p>Lengkapi form di bawah untuk menambahkan perangkat baru</p>
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb-custom">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('perangkat.index') }}">
                        <i class="fas fa-laptop me-1"></i>Data Perangkat
                    </a>
                </li>
                <li class="breadcrumb-item active">Tambah Perangkat</li>
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
            <h5><i class="fas fa-edit me-2"></i>Form Data Perangkat</h5>
            <p>Masukkan informasi perangkat dengan lengkap dan benar</p>
        </div>
        <form action="{{ route('perangkat.store') }}" method="POST" id="perangkatForm">
            @csrf
            
            <div class="card-body p-4">
                
                <!-- Section: Informasi Perangkat -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-info-circle"></i>
                        <span>Informasi Perangkat</span>
                    </div>
                    
                    <div class="row g-3">
                        <!-- Nama Perangkat -->
                        <div class="col-md-6">
                            <label for="nama_perangkat" class="form-label">
                                Nama Perangkat<span class="required">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-laptop"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('nama_perangkat') is-invalid @enderror" 
                                       id="nama_perangkat" 
                                       name="nama_perangkat" 
                                       placeholder="Contoh: Laptop Dell Latitude 5420"
                                       value="{{ old('nama_perangkat') }}"
                                       maxlength="255"
                                       required>
                                @error('nama_perangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="char-counter">
                                <span id="nama_counter">0</span>/255 karakter
                            </div>
                        </div>

                        <!-- Kategori Perangkat -->
                        <div class="col-md-6">
                            <label for="id_kategori_perangkat" class="form-label">
                                Kategori Perangkat<span class="required">*</span>
                            </label>
                            <select class="form-select @error('id_kategori_perangkat') is-invalid @enderror" 
                                    id="id_kategori_perangkat" 
                                    name="id_kategori_perangkat" 
                                    required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('id_kategori_perangkat') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_kategori_perangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Section: Status Perangkat -->
                <div class="form-section">
                    <div class="form-section-title">
                        <i class="fas fa-clipboard-check"></i>
                        <span>Status Perangkat</span>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">
                                Pilih Status<span class="required">*</span>
                            </label>
                            <div class="status-options">
                                <div class="status-option berfungsi">
                                    <input type="radio" 
                                           name="status" 
                                           id="status_berfungsi" 
                                           value="Berfungsi"
                                           {{ old('status', 'Berfungsi') == 'Berfungsi' ? 'checked' : '' }}>
                                    <label for="status_berfungsi">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <p class="status-label">Berfungsi</p>
                                    </label>
                                </div>
                                <div class="status-option rusak">
                                    <input type="radio" 
                                           name="status" 
                                           id="status_rusak" 
                                           value="Rusak"
                                           {{ old('status') == 'Rusak' ? 'checked' : '' }}>
                                    <label for="status_rusak">
                                        <div class="status-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <p class="status-label">Rusak</p>
                                    </label>
                                </div>
                                <div class="status-option hilang">
                                    <input type="radio" 
                                           name="status" 
                                           id="status_hilang" 
                                           value="Hilang"
                                           {{ old('status') == 'Hilang' ? 'checked' : '' }}>
                                    <label for="status_hilang">
                                        <div class="status-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <p class="status-label">Hilang</p>
                                    </label>
                                </div>
                                <div class="status-option return">
                                    <input type="radio" 
                                           name="status" 
                                           id="status_return" 
                                           value="Return"
                                           {{ old('status') == 'Return' ? 'checked' : '' }}>
                                    <label for="status_return">
                                        <div class="status-icon">
                                            <i class="fas fa-undo"></i>
                                        </div>
                                        <p class="status-label">Return</p>
                                    </label>
                                </div>
                            </div>
                            @error('status')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
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
                            <label for="catatan_perangkat" class="form-label">
                                Catatan Perangkat
                            </label>
                            <textarea class="form-control @error('catatan_perangkat') is-invalid @enderror" 
                                      id="catatan_perangkat" 
                                      name="catatan_perangkat" 
                                      rows="4"
                                      placeholder="Tambahkan catatan atau keterangan tambahan tentang perangkat (opsional)">{{ old('catatan_perangkat') }}</textarea>
                            @error('catatan_perangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="char-counter">
                                <span id="catatan_counter">0</span> karakter
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="form-footer">
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('perangkat.index') }}" class="btn btn-cancel">
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
    $('#id_kategori_perangkat').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Kategori --',
        allowClear: true
    });

    // Character counter for nama perangkat
    $('#nama_perangkat').on('input', function() {
        var length = $(this).val().length;
        $('#nama_counter').text(length);
    });

    // Character counter for catatan
    $('#catatan_perangkat').on('input', function() {
        var length = $(this).val().length;
        $('#catatan_counter').text(length);
    });

    // Initialize counters
    $('#nama_counter').text($('#nama_perangkat').val().length);
    $('#catatan_counter').text($('#catatan_perangkat').val().length);

    // Form submission with validation
    $('#perangkatForm').on('submit', function(e) {
        var isValid = true;
        
        // Validate nama perangkat
        if (!$('#nama_perangkat').val().trim()) {
            isValid = false;
            $('#nama_perangkat').addClass('is-invalid');
        }
        
        // Validate kategori
        if (!$('#id_kategori_perangkat').val()) {
            isValid = false;
            $('#id_kategori_perangkat').addClass('is-invalid');
        }
        
        // Validate status
        if (!$('input[name="status"]:checked').length) {
            isValid = false;
            Swal.fire({
                icon: 'error',
                title: 'Status Belum Dipilih',
                text: 'Mohon pilih status perangkat!',
                confirmButtonColor: '#ef4444'
            });
        }
        
        if (!isValid) {
            e.preventDefault();
            if ($('input[name="status"]:checked').length) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: 'Mohon lengkapi semua field yang wajib diisi!',
                    confirmButtonColor: '#ef4444'
                });
            }
        }
    });

    // Remove invalid class on input
    $('.form-control, .form-select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });

    // Show success message if redirected with success
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session("success") }}',
            timer: 3000,
            showConfirmButton: false
        });
    @endif

    console.log('✅ Create Perangkat Page Loaded');
});
</script>
@endpush