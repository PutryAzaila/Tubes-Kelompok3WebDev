@extends('layouts.dashboard')

@section('title', 'Edit Data Inventory')
@section('page-title', 'Edit Data Inventory')
@section('page-description', 'Edit data barang masuk atau keluar')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 50%, #1e3a8a 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 10px 30px rgba(249, 115, 22, 0.3);
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

/* Card Styles */
.card-custom {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: none;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.card-header-custom {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
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

/* Form Elements */
.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.required-label::after {
    content: ' *';
    color: #dc2626;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    padding: 0.625rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #f97316;
    box-shadow: 0 0 0 0.2rem rgba(249, 115, 22, 0.15);
}

.form-control:disabled, .form-select:disabled {
    background-color: #f3f4f6;
    border-color: #d1d5db;
    color: #6b7280;
    cursor: not-allowed;
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

/* Section Title */
.section-title {
    font-size: 1rem;
    font-weight: 700;
    color: #f97316;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

/* Info Badge */
.info-badge {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    display: inline-block;
    margin-bottom: 1rem;
}

/* Badge Types */
.badge-type {
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-block;
}

.badge-masuk {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
}

.badge-keluar {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    color: white;
}

/* Buttons */
.btn-update {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    color: white;
    border: none;
    padding: 0.625rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-update:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(249, 115, 22, 0.4);
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

.btn-edit-serial {
    background: linear-gradient(135deg, #fbbf24 0%, #fcd34d 100%);
    border: none;
    color: #92400e;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-edit-serial:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(251, 191, 36, 0.4);
}

.btn-cancel-edit {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 600;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    flex-wrap: wrap;
}

/* Alerts */
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

.alert-warning {
    background: linear-gradient(135deg, #fbbf24 0%, #fcd34d 100%);
    border: none;
    color: #92400e;
}

/* Info Card */
.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: none;
    overflow: hidden;
}

.info-card-header {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    padding: 1rem 1.25rem;
    border: none;
}

.info-card-header h6 {
    color: white;
    font-weight: 600;
    margin-bottom: 0;
    font-size: 0.95rem;
}

.info-card-body {
    padding: 1.25rem;
}

/* Info Box */
.info-box {
    background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 12px rgba(249, 115, 22, 0.2);
}

.info-box .info-label {
    font-size: 0.75rem;
    opacity: 0.9;
    margin-bottom: 0.25rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-box .info-value {
    font-size: 1rem;
    font-weight: 700;
}

.info-box code {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.9rem;
}

/* Lock Icon for Disabled Fields */
.field-locked::after {
    content: '\f023';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    pointer-events: none;
}

.field-locked-wrapper {
    position: relative;
}

/* Responsive */
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
    
    .btn-update, .btn-cancel {
        width: 100%;
    }
    
    .info-box .row {
        row-gap: 1rem;
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
                        <a href="{{ route('inventory.index') }}">
                            <i class="fas fa-box me-1"></i>Inventory
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Edit Data</li>
                </ol>
            </nav>
            <h4><i class="fas fa-edit me-2"></i>Edit Data Inventory</h4>
            <p>Update data barang yang sudah ada di sistem</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
    <div class="col-12">
        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
            <strong><i class="fas fa-exclamation-circle me-2"></i>Terdapat kesalahan!</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Form Card -->
    <div class="col-12 col-lg-8">
        <form action="{{ route('inventory.update', [$inventory->id, $type]) }}" method="POST" id="editForm">
            @csrf
            @method('PUT')

            <!-- Info Box - Current Data -->
            <div class="info-box">
                <div class="row">
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="info-label">Jenis Transaksi</div>
                        <div class="info-value">
                            <span class="badge-type {{ $type === 'masuk' ? 'badge-masuk' : 'badge-keluar' }}">
                                <i class="fas fa-arrow-{{ $type === 'masuk' ? 'down' : 'up' }} me-2"></i>
                                {{ $type === 'masuk' ? 'Masuk' : 'Keluar' }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="info-label">Perangkat</div>
                        <div class="info-value">{{ $inventory->detailBarang->perangkat->nama_perangkat ?? '-' }}</div>
                    </div>
                    <div class="col-md-3 mb-3 mb-md-0">
                        <div class="info-label">Kategori</div>
                        <div class="info-value">{{ $inventory->detailBarang->kategori ?? '-' }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-label">Serial Number</div>
                        <div class="info-value">
                            <code>{{ $inventory->detailBarang->serial_number ?? 'Tidak Ada' }}</code>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Warning -->
            <div class="alert alert-warning alert-custom mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Perhatian!</strong> Anda dapat mengubah tanggal, jumlah/stok, catatan, dan serial number (jika ada typo). 
                Data perangkat, kategori, dan jenis transaksi tidak dapat diubah.
            </div>

            <!-- Data yang Dapat Diubah -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5><i class="fas fa-edit me-2"></i>Data yang Dapat Diubah</h5>
                </div>
                <div class="card-body-custom">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label required-label">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal
                            </label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                value="{{ old('tanggal', $inventory->tanggal) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="stok" class="form-label required-label">
                                <i class="fas fa-cubes me-2"></i>Jumlah/Stok
                            </label>
                            <input type="number" class="form-control" id="stok" name="stok" 
                                value="{{ old('stok', $inventory->jumlah) }}" min="1" required>
                            <small class="form-text">Jumlah saat ini: <strong>{{ $inventory->jumlah }}</strong> unit</small>
                        </div>

                        @if($type === 'keluar')
                        <div class="col-md-12">
                            <label for="alamat" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Alamat Tujuan
                            </label>
                            <input type="text" class="form-control" id="alamat" name="alamat" 
                                value="{{ old('alamat', $inventory->alamat) }}" 
                                placeholder="Masukkan alamat tujuan">
                        </div>
                        @endif

                        @if($inventory->detailBarang->serial_number)
                        <div class="col-md-12">
                            <label for="serialNumberDisplay" class="form-label">
                                <i class="fas fa-barcode me-2"></i>Serial Number
                            </label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="serialNumberDisplay" 
                                    value="{{ $inventory->detailBarang->serial_number }}" 
                                    disabled>
                                <button type="button" class="btn btn-edit-serial" id="btnEditSerial">
                                    <i class="fas fa-edit me-2"></i>Edit
                                </button>
                            </div>
                            <!-- Hidden input for editing -->
                            <input type="text" class="form-control mt-2" id="serialNumberEdit" 
                                name="serial_number" 
                                value="{{ $inventory->detailBarang->serial_number }}" 
                                style="display: none;"
                                placeholder="Masukkan serial number baru">
                            <small class="text-danger d-none" id="serialWarning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Pastikan serial number sudah benar sebelum menyimpan!
                            </small>
                        </div>
                        @endif

                        <div class="col-md-12">
                            <label for="catatan" class="form-label">
                                <i class="fas fa-sticky-note me-2"></i>Catatan
                            </label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                                placeholder="Tambahkan catatan atau keterangan...">{{ old('catatan', $type === 'masuk' ? $inventory->catatan_barang_masuk : $inventory->catatan_barang_keluar) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data yang Tidak Dapat Diubah -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5><i class="fas fa-lock me-2"></i>Data yang Tidak Dapat Diubah</h5>
                </div>
                <div class="card-body-custom">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-box me-2"></i>Perangkat
                            </label>
                            <div class="field-locked-wrapper">
                                <input type="text" class="form-control field-locked" 
                                    value="{{ $inventory->detailBarang->perangkat->nama_perangkat ?? '-' }}" 
                                    disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-tag me-2"></i>Kategori
                            </label>
                            <div class="field-locked-wrapper">
                                <input type="text" class="form-control field-locked" 
                                    value="{{ $inventory->detailBarang->kategori ?? '-' }}" 
                                    disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-exchange-alt me-2"></i>Jenis Transaksi
                            </label>
                            <div class="field-locked-wrapper">
                                <input type="text" class="form-control field-locked" 
                                    value="{{ $type === 'masuk' ? 'Barang Masuk' : 'Barang Keluar' }}" 
                                    disabled>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Status
                            </label>
                            <div class="field-locked-wrapper">
                                <input type="text" class="form-control field-locked" 
                                    value="{{ $inventory->status }}" 
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card-custom">
                <div class="card-body-custom">
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-update">
                            <i class="fas fa-save me-2"></i>Update Data
                        </button>
                        <a href="{{ route('inventory.index') }}" class="btn btn-cancel">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Info Sidebar -->
    <div class="col-12 col-lg-4">
        <div class="info-card">
            <div class="info-card-header">
                <h6><i class="fas fa-lightbulb me-2"></i>Panduan Edit</h6>
            </div>
            <div class="info-card-body">
                <div class="mb-3">
                    <h6 class="text-primary mb-2" style="font-size: 0.9rem; color: #f97316 !important;">
                        <i class="fas fa-check-circle me-2"></i>Yang Dapat Diubah
                    </h6>
                    <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Tanggal transaksi</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Jumlah/stok barang</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Serial number (jika typo)</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Catatan tambahan</small>
                        </li>
                        @if($type === 'keluar')
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Alamat tujuan</small>
                        </li>
                        @endif
                    </ul>
                </div>
                
                <hr>
                
                <div>
                    <h6 class="text-primary mb-2" style="font-size: 0.9rem; color: #f97316 !important;">
                        <i class="fas fa-lock me-2"></i>Yang Tidak Dapat Diubah
                    </h6>
                    <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Perangkat</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Kategori</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Jenis transaksi</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Status</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="info-card mt-3">
            <div class="info-card-header">
                <h6><i class="fas fa-info-circle me-2"></i>Informasi Penting</h6>
            </div>
            <div class="info-card-body">
                <div class="alert alert-warning mb-0" style="font-size: 0.85rem; border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Catatan:</strong><br>
                    Pastikan semua perubahan data sudah benar sebelum menyimpan. 
                    Perubahan yang sudah disimpan akan langsung mempengaruhi data inventory.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    console.log('Edit Form Ready');

    // Toggle Edit Serial Number
    $('#btnEditSerial').on('click', function() {
        const btn = $(this);
        const displayInput = $('#serialNumberDisplay');
        const editInput = $('#serialNumberEdit');
        const warning = $('#serialWarning');
        
        if (editInput.is(':visible')) {
            // Cancel edit - revert to display mode
            editInput.hide().val(displayInput.val());
            displayInput.show();
            warning.addClass('d-none');
            btn.html('<i class="fas fa-edit me-2"></i>Edit')
               .removeClass('btn-cancel-edit')
               .addClass('btn-edit-serial');
        } else {
            // Enable edit mode
            displayInput.hide();
            editInput.show().focus();
            warning.removeClass('d-none');
            btn.html('<i class="fas fa-times me-2"></i>Batal')
               .removeClass('btn-edit-serial')
               .addClass('btn-cancel-edit');
        }
    });

    // Form Validation
    $('#editForm').on('submit', function(e) {
        console.log('=== FORM SUBMIT ===');
        
        const stokValue = $('#stok').val();
        const tanggal = $('#tanggal').val();
        const serialEdit = $('#serialNumberEdit');
        
        console.log('Stok Value:', stokValue);
        console.log('Tanggal:', tanggal);
        
        // Validasi tanggal
        if (!tanggal) {
            e.preventDefault();
            showError('Tanggal harus diisi!');
            $('#tanggal').focus();
            return false;
        }
        
        // Validasi stok
        if (!stokValue || parseInt(stokValue) < 1) {
            e.preventDefault();
            showError('Jumlah/stok minimal 1!');
            $('#stok').focus();
            return false;
        }
        
        // Validasi serial number jika sedang di-edit
        if (serialEdit.is(':visible')) {
            const newSerial = serialEdit.val().trim();
            const oldSerial = $('#serialNumberDisplay').val();
            
            if (!newSerial) {
                e.preventDefault();
                showError('Serial number tidak boleh kosong!');
                serialEdit.focus();
                return false;
            }
            
            if (newSerial !== oldSerial) {
                if (!confirm(`Anda akan mengubah serial number dari "${oldSerial}" menjadi "${newSerial}". Pastikan sudah benar! Lanjutkan?`)) {
                    e.preventDefault();
                    return false;
                }
            }
        } else {
            // Jika tidak di-edit, hapus dari form data
            serialEdit.remove();
        }
        
        // Konfirmasi perubahan stok
        const currentStok = {{ $inventory->jumlah }};
        if (parseInt(stokValue) !== currentStok) {
            if (!confirm(`Anda akan mengubah jumlah dari ${currentStok} menjadi ${stokValue}. Lanjutkan?`)) {
                e.preventDefault();
                return false;
            }
        }
        
        console.log('=== VALIDATION PASSED ===');
        return true;
    });

    function showError(message) {
        $('.alert-validation-error').remove();
        
        const alertHtml = `
            <div class="alert alert-danger alert-custom alert-dismissible fade show alert-validation-error" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Validasi Gagal!</strong><br>${message}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('#editForm').prepend(alertHtml);
        
        $('html, body').animate({
            scrollTop: $('#editForm').offset().top - 100
        }, 500);
        
        setTimeout(function() {
            $('.alert-validation-error').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
    }
});
</script>
@endpush