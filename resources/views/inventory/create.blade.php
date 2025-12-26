@extends('layouts.dashboard')

@section('title', 'Tambah Data Inventory')
@section('page-title', 'Tambah Data Inventory')
@section('page-description', 'Tambahkan data barang masuk atau keluar')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
/* Page Header */
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

/* Section Title */
.section-title {
    font-size: 1rem;
    font-weight: 700;
    color: #1e3a8a;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

/* Radio Cards */
.radio-card {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    height: 100%;
}

.radio-card:hover {
    border-color: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
}

.radio-card.active {
    border-color: #2563eb;
    background: rgba(37, 99, 235, 0.05);
}

.radio-checkmark {
    position: absolute;
    top: 1rem;
    right: 1rem;
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    opacity: 0;
    transition: all 0.3s ease;
}

.radio-card.active .radio-checkmark {
    opacity: 1;
}

/* Serial Number Sections */
.serial-input-group {
    background: #f9fafb;
    border: 2px dashed #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 0.75rem;
}

.serial-checkbox-item {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.serial-checkbox-item:hover {
    border-color: #2563eb;
    background: rgba(37, 99, 235, 0.05);
}

.serial-checkbox-item.selected {
    border-color: #2563eb;
    background: rgba(37, 99, 235, 0.1);
}

/* Buttons */
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

.btn-add-serial {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    border: none;
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
}

.btn-remove-serial {
    background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
    border: none;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    flex-wrap: wrap;
}

/* Info Badge */
.info-badge {
    background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-size: 0.85rem;
    display: inline-block;
    margin-bottom: 1rem;
}

/* Conditional Sections */
.conditional-section {
    display: none !important;
}

.conditional-section.show {
    display: block !important;
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

/* Info Card */
.info-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: none;
    overflow: hidden;
}

.info-card-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
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
                        <a href="{{ route('inventory.index') }}">
                            <i class="fas fa-box me-1"></i>Inventory
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Data</li>
                </ol>
            </nav>
            <h4><i class="fas fa-plus-circle me-2"></i>Tambah Data Inventory</h4>
            <p>Isi formulir di bawah untuk menambahkan data barang masuk atau keluar</p>
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
        <form action="{{ url('/inventory') }}" method="POST" id="inventoryForm">
            @csrf

            <!-- Jenis Transaksi Card -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5><i class="fas fa-exchange-alt me-2"></i>Jenis Transaksi</h5>
                </div>
                <div class="card-body-custom">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="radio-card" id="cardMasuk">
                                <input type="radio" name="jenis_inventori" value="masuk" class="d-none" required>
                                <div class="radio-card-body">
                                    <div class="mb-2">
                                        <i class="fas fa-arrow-down fa-2x text-success"></i>
                                    </div>
                                    <h5 class="mb-2">Barang Masuk</h5>
                                    <p class="text-muted mb-0 small">Catat barang yang masuk ke inventory</p>
                                </div>
                                <div class="radio-checkmark">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>
                        <div class="col-md-6">
                            <label class="radio-card" id="cardKeluar">
                                <input type="radio" name="jenis_inventori" value="keluar" class="d-none" required>
                                <div class="radio-card-body">
                                    <div class="mb-2">
                                        <i class="fas fa-arrow-up fa-2x text-warning"></i>
                                    </div>
                                    <h5 class="mb-2">Barang Keluar</h5>
                                    <p class="text-muted mb-0 small">Catat barang yang keluar dari inventory</p>
                                </div>
                                <div class="radio-checkmark">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Dasar Card -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5><i class="fas fa-info-circle me-2"></i>Informasi Dasar</h5>
                </div>
                <div class="card-body-custom">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label required-label">
                                <i class="fas fa-calendar-alt me-2"></i>Tanggal
                            </label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                value="{{ old('tanggal', date('Y-m-d')) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="id_perangkat" class="form-label required-label">
                                <i class="fas fa-box me-2"></i>Perangkat
                            </label>
                            <select class="form-select select2" id="id_perangkat" name="id_perangkat" required>
                                <option value="">-- Pilih Perangkat --</option>
                                @foreach($perangkats as $perangkat)
                                    <option value="{{ $perangkat->id }}">{{ $perangkat->nama_perangkat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="kategori" class="form-label required-label">
                                <i class="fas fa-tag me-2"></i>Kategori
                            </label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Listrik">Listrik</option>
                                <option value="Non-Listrik">Non-Listrik</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required-label">
                                <i class="fas fa-barcode me-2"></i>Ada Serial Number?
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="has_serial" id="hasSerialYes" value="1" required>
                                    <label class="form-check-label" for="hasSerialYes">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="has_serial" id="hasSerialNo" value="0" required>
                                    <label class="form-check-label" for="hasSerialNo">Tidak</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barang Masuk Section -->
            <div id="barangMasukSection" class="conditional-section">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-arrow-circle-down me-2"></i>Detail Barang Masuk</h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="mb-4">
                            <label for="sumber" class="form-label required-label">
                                <i class="fas fa-building me-2"></i>Sumber
                            </label>
                            <select class="form-select" id="sumber" name="sumber">
                                <option value="">-- Pilih Sumber --</option>
                                <option value="Vendor">Vendor (Barang Baru)</option>
                                <option value="Customer">Customer (Return/Titip Baru)</option>
                            </select>
                        </div>

                <!-- Serial Number Section for Masuk -->
                <div id="serialMasukSection" class="conditional-section">
                    <!-- Vendor: Input Baru -->
                    <div id="vendorSerialSection" class="conditional-section">
                        <div class="info-badge">
                            <i class="fas fa-info-circle me-2"></i>Vendor: Input serial number baru
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Jumlah Barang</label>
                            <input type="number" class="form-control" id="jumlahVendor" min="1" value="1">
                        </div>
                        <div id="serialInputsVendor"></div>
                    </div>

                    <!-- Customer: Return ONLY (no more "Tambah Serial Baru") -->
                    <div id="customerSerialSection" class="conditional-section">
                        <div class="info-badge">
                            <i class="fas fa-undo me-2"></i>Customer: Pilih barang yang akan dikembalikan
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label required-label">Serial Number Return</label>
                            <div id="returnSerialsContainer"></div>
                        </div>
                    </div>
                </div>
                        <!-- Stok untuk Non-Serial -->
                        <div id="stokMasukSection" class="conditional-section">
                            <label for="stokMasuk" class="form-label required-label">
                                <i class="fas fa-cubes me-2"></i>Jumlah/Stok
                            </label>
                            <input type="number" class="form-control" id="stokMasuk" name="stok" min="1" value="1">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Barang Keluar Section -->
            <div id="barangKeluarSection" class="conditional-section">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-arrow-circle-up me-2"></i>Detail Barang Keluar</h5>
                    </div>
                    <div class="card-body-custom">
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="perihal" class="form-label required-label">
                                    <i class="fas fa-clipboard-list me-2"></i>Perihal
                                </label>
                                <select class="form-select" id="perihal" name="perihal">
                                    <option value="">-- Pilih Perihal --</option>
                                    <option value="Pemeliharaan">Pemeliharaan</option>
                                    <option value="Penjualan">Penjualan</option>
                                    <option value="Instalasi">Instalasi</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="alamat" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Tujuan
                                </label>
                                <input type="text" class="form-control" id="alamat" name="alamat" 
                                    placeholder="Masukkan alamat tujuan">
                            </div>
                        </div>

                        <!-- Serial Number Section for Keluar -->
                        <div id="serialKeluarSection" class="conditional-section">
                            <div class="info-badge">
                                <i class="fas fa-info-circle me-2"></i>Pilih serial number yang akan keluar
                            </div>
                            <div id="availableSerialsContainer"></div>
                        </div>

                        <!-- Stok untuk Non-Serial -->
                        <div id="stokKeluarSection" class="conditional-section">
                            <label for="stokKeluar" class="form-label required-label">
                                <i class="fas fa-cubes me-2"></i>Jumlah/Stok
                            </label>
                            <input type="number" class="form-control" id="stokKeluar" name="stok" min="1" value="1">
                            <small class="form-text">Stok tersedia: <span id="availableStock">-</span></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Catatan Card -->
            <div class="card-custom">
                <div class="card-header-custom">
                    <h5><i class="fas fa-sticky-note me-2"></i>Catatan Tambahan</h5>
                </div>
                <div class="card-body-custom">
                    <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                        placeholder="Tambahkan catatan atau keterangan tambahan..."></textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card-custom">
                <div class="card-body-custom">
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-save me-2"></i>Simpan Data
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
                <h6><i class="fas fa-lightbulb me-2"></i>Panduan Pengisian</h6>
            </div>
            <div class="info-card-body">
                <div class="mb-3">
                    <h6 class="text-primary mb-2" style="font-size: 0.9rem;">
                        <i class="fas fa-check-circle me-2"></i>Barang Masuk
                    </h6>
                    <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Pilih sumber: Vendor atau Customer</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Vendor: Input serial number baru</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Customer: Pilih return atau input baru</small>
                        </li>
                    </ul>
                </div>
                
                <hr>
                
                <div>
                    <h6 class="text-primary mb-2" style="font-size: 0.9rem;">
                        <i class="fas fa-check-circle me-2"></i>Barang Keluar
                    </h6>
                    <ul class="list-unstyled mb-0" style="font-size: 0.85rem;">
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Pilih perihal barang keluar</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Untuk serial: Pilih dari yang tersedia</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-chevron-right me-2 text-muted"></i>
                            <small>Untuk non-serial: Input jumlah stok</small>
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
                <div class="alert alert-info mb-0" style="font-size: 0.85rem; border-radius: 8px;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Catatan:</strong><br>
                    Pastikan semua data telah diisi dengan benar sebelum menyimpan. 
                    Data yang sudah disimpan tidak dapat diubah.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
// Debug: Log when DOM is ready
console.log('Script loaded, jQuery version:', $.fn.jquery);

$(document).ready(function() {
    console.log('Document ready!');
    let serialCounterVendor = 0;
    let serialCounterCustomer = 0;

    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Perangkat --'
    });

    // Radio Card Handler
    $('.radio-card').on('click', function() {
        const radio = $(this).find('input[type="radio"]');
        $('.radio-card').removeClass('active');
        $(this).addClass('active');
        radio.prop('checked', true).trigger('change');
    });

    // Jenis Inventori Change
    $('input[name="jenis_inventori"]').on('change', function() {
        const value = $(this).val();
        
        if (value === 'masuk') {
            $('#barangMasukSection').removeClass('conditional-section').addClass('show');
            $('#barangKeluarSection').removeClass('show').addClass('conditional-section');
            $('#sumber').prop('required', true);
            $('#perihal').prop('required', false);
            $('#alamat').prop('required', false);
            
            $('#stokKeluar').prop('disabled', true);
            $('#perihal').prop('disabled', true);
            $('#alamat').prop('disabled', true);
        } else {
            $('#barangKeluarSection').removeClass('conditional-section').addClass('show');
            $('#barangMasukSection').removeClass('show').addClass('conditional-section');
            $('#perihal').prop('required', true);
            $('#sumber').prop('required', false);
            
            $('#stokMasuk').prop('disabled', true);
            $('#sumber').prop('disabled', true);
        }
    });

    // Has Serial Change
    $('input[name="has_serial"]').on('change', function() {
        const hasSerial = $(this).val() === '1';
        const jenisInventori = $('input[name="jenis_inventori"]:checked').val();
        
        console.log('Has Serial changed:', hasSerial, 'Jenis:', jenisInventori);

        if (jenisInventori === 'masuk') {
            if (hasSerial) {
                $('#serialMasukSection').removeClass('conditional-section').addClass('show');
                $('#stokMasukSection').removeClass('show').addClass('conditional-section');
                $('#stokMasuk').prop('disabled', true).prop('required', false);
            } else {
                $('#serialMasukSection').removeClass('show').addClass('conditional-section');
                $('#stokMasukSection').removeClass('conditional-section').addClass('show');
                $('#stokMasuk').prop('disabled', false).prop('required', true);
            }
        } else if (jenisInventori === 'keluar') {
            if (hasSerial) {
                $('#serialKeluarSection').removeClass('conditional-section').addClass('show');
                $('#stokKeluarSection').removeClass('show').addClass('conditional-section');
                $('#stokKeluar').prop('disabled', true).prop('required', false);
                loadAvailableSerials();
            } else {
                $('#serialKeluarSection').removeClass('show').addClass('conditional-section');
                $('#stokKeluarSection').removeClass('conditional-section').addClass('show');
                $('#stokKeluar').prop('disabled', false).prop('required', true);
                checkAvailableStock();
            }
        }
    });

    // Sumber Change
    $('#sumber').on('change', function() {
        const sumber = $(this).val();
        const hasSerial = $('input[name="has_serial"]:checked').val() === '1';
        
        console.log('Sumber changed:', sumber, 'Has Serial:', hasSerial);

        if (!hasSerial) return;

        if (sumber === 'Vendor') {
            $('#vendorSerialSection').removeClass('conditional-section').addClass('show');
            $('#customerSerialSection').removeClass('show').addClass('conditional-section');
            generateVendorSerialInputs();
        } else if (sumber === 'Customer') {
            $('#customerSerialSection').removeClass('conditional-section').addClass('show');
            $('#vendorSerialSection').removeClass('show').addClass('conditional-section');
            loadReturnableSerials();
        }
    });

    // Jumlah Vendor Change
    $('#jumlahVendor').on('change', function() {
        generateVendorSerialInputs();
    });

    // Generate Vendor Serial Inputs
    function generateVendorSerialInputs() {
        const jumlah = parseInt($('#jumlahVendor').val()) || 1;
        const container = $('#serialInputsVendor');
        container.empty();

        for (let i = 0; i < jumlah; i++) {
            container.append(`
                <div class="serial-input-group">
                    <label class="form-label">Serial Number ${i + 1}</label>
                    <input type="text" class="form-control" name="serial_numbers[]" 
                        placeholder="Masukkan serial number" required>
                </div>
            `);
        }
    }

    // Add Customer Serial Button
    $('#btnAddCustomerSerial').on('click', function() {
        serialCounterCustomer++;
        $('#serialInputsCustomer').append(`
            <div class="serial-input-group" id="customerSerial${serialCounterCustomer}">
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" name="serial_numbers[]" 
                        placeholder="Masukkan serial number baru">
                    <button type="button" class="btn btn-remove-serial" onclick="removeCustomerSerial(${serialCounterCustomer})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `);
    });

    // Remove Customer Serial
    window.removeCustomerSerial = function(id) {
        $('#customerSerial' + id).remove();
    };

// TAMBAHKAN SCRIPT INI ke bagian loadReturnableSerials() di create.blade.php

function loadReturnableSerials() {
    const perangkatId = $('#id_perangkat').val();
    const kategori = $('#kategori').val();

    if (!perangkatId || !kategori) return;

    $.get('/inventory/returnable-serials', {
        id_perangkat: perangkatId,
        kategori: kategori
    }, function(response) {
        const container = $('#returnSerialsContainer');
        container.empty();

        if (response.data.length === 0) {
            container.html(`
                <div class="alert alert-info" style="border-radius: 8px;">
                    <i class="fas fa-info-circle me-2"></i>
                    Tidak ada barang yang sedang keluar/disewa untuk dikembalikan
                </div>
            `);
            return;
        }

        // Tambahkan header info
        container.append(`
            <div class="alert alert-success mb-3" style="border-radius: 8px;">
                <i class="fas fa-undo me-2"></i>
                <strong>Ditemukan ${response.data.length} barang yang sedang disewa/keluar</strong><br>
                <small>Pilih barang yang akan dikembalikan:</small>
            </div>
        `);

        response.data.forEach(item => {
            // Format tanggal jika ada
            let dateInfo = '';
            if (item.last_out_date) {
                const date = new Date(item.last_out_date);
                dateInfo = date.toLocaleDateString('id-ID', { 
                    day: 'numeric', 
                    month: 'short', 
                    year: 'numeric' 
                });
            }

            container.append(`
                <div class="serial-checkbox-item">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="return_serials[]" 
                            value="${item.id}" id="return${item.id}">
                        <label class="form-check-label d-flex flex-column" for="return${item.id}">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <strong style="font-size: 1rem;">${item.serial_number}</strong>
                                <span class="badge bg-warning text-dark">
                                    <i class="fas fa-arrow-up me-1"></i>Keluar: ${item.out_stock}
                                </span>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>Keluar terakhir: ${dateInfo || 'N/A'}
                                ${item.last_out_status ? ` | <i class="fas fa-tag me-1"></i>${item.last_out_status}` : ''}
                            </small>
                            ${item.last_out_alamat ? `
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>${item.last_out_alamat}
                                </small>
                            ` : ''}
                        </label>
                    </div>
                </div>
            `);
        });

        // Enable click on card
        $('.serial-checkbox-item').on('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = $(this).find('input[type="checkbox"]');
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
            $(this).toggleClass('selected', $(this).find('input[type="checkbox"]').prop('checked'));
        });
    }).fail(function(xhr) {
        console.error('Error loading returnable serials:', xhr);
        $('#returnSerialsContainer').html(`
            <div class="alert alert-danger" style="border-radius: 8px;">
                <i class="fas fa-exclamation-triangle me-2"></i>
                Gagal memuat data. Silakan coba lagi.
            </div>
        `);
    });
}
    // Load Available Serials
    function loadAvailableSerials() {
        const perangkatId = $('#id_perangkat').val();
        const kategori = $('#kategori').val();

        if (!perangkatId || !kategori) return;

        $.get('/inventory/available-serials', {
            id_perangkat: perangkatId,
            kategori: kategori
        }, function(response) {
            const container = $('#availableSerialsContainer');
            container.empty();

            if (response.data.length === 0) {
                container.html('<p class="text-muted">Tidak ada serial number yang tersedia</p>');
                return;
            }

            response.data.forEach(item => {
                container.append(`
                    <div class="serial-checkbox-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="selected_serials[]" 
                                value="${item.id}" id="serial${item.id}">
                            <label class="form-check-label" for="serial${item.id}">
                                <strong>${item.serial_number}</strong>
                                <span class="badge bg-success ms-2">Tersedia: ${item.available_stock}</span>
                            </label>
                        </div>
                    </div>
                `);
            });

            $('.serial-checkbox-item').on('click', function(e) {
                if (e.target.type !== 'checkbox') {
                    const checkbox = $(this).find('input[type="checkbox"]');
                    checkbox.prop('checked', !checkbox.prop('checked'));
                }
                $(this).toggleClass('selected', $(this).find('input[type="checkbox"]').prop('checked'));
            });
        }).fail(function(xhr) {
            console.error('Error loading available serials:', xhr);
        });
    }

    function checkAvailableStock() {
        const perangkatId = $('#id_perangkat').val();
        const kategori = $('#kategori').val();

        if (!perangkatId || !kategori) {
            $('#availableStock').text('-');
            return;
        }

        $('#availableStock').text('Loading...');
        $('#availableStock').text('Cek manual di inventory');
    }

    $('#id_perangkat, #kategori').on('change', function() {
        const hasSerial = $('input[name="has_serial"]:checked').val() === '1';
        const jenisInventori = $('input[name="jenis_inventori"]:checked').val();
        const sumber = $('#sumber').val();

        if (jenisInventori === 'keluar') {
            if (hasSerial) {
                loadAvailableSerials();
            } else {
                checkAvailableStock();
            }
        } else if (jenisInventori === 'masuk' && sumber === 'Customer' && hasSerial) {
            loadReturnableSerials();
        }
    });

    function showError(message) {
        $('.alert-validation-error').remove();
        
        const alertHtml = `
            <div class="alert alert-danger alert-dismissible fade show alert-validation-error" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Validasi Gagal!</strong><br>${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('#inventoryForm').prepend(alertHtml);
        
        $('html, body').animate({
            scrollTop: $('#inventoryForm').offset().top - 100
        }, 500);
        
        setTimeout(function() {
            $('.alert-validation-error').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 5000);
        
        console.error('Validation Error:', message);
    }

    function showSuccessModal(message) {
        $('#successModal').remove();
        
        const modalHtml = `
            <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 2rem; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2); overflow: hidden;">
                        <div class="modal-body" style="padding: 3rem 2.5rem; text-align: center;">
                            <!-- Icon Circle -->
                            <div style="width: 100px; height: 100px; background: linear-gradient(135deg, #10b981, #34d399); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3); animation: bounceIn 0.6s ease;">
                                <i class="fas fa-check" style="font-size: 3rem; color: white;"></i>
                            </div>
                            
                            <!-- Success Text -->
                            <h2 style="color: #1f2937; font-weight: 800; margin-bottom: 1rem; font-size: 1.75rem; animation: fadeIn 0.8s ease;">
                                Data Tersimpan!
                            </h2>
                            <p style="color: #6b7280; font-size: 1rem; margin-bottom: 2.5rem; animation: fadeIn 1s ease;">
                                ${message}
                            </p>
                            
                            <!-- Action Buttons -->
                            <div class="d-flex flex-column gap-3">
                                <a href="/inventory" class="btn" style="background: linear-gradient(135deg, #1e3a8a, #3b82f6); color: white; border: none; padding: 1rem 2rem; border-radius: 1rem; font-weight: 600; font-size: 1rem; text-decoration: none; transition: all 0.3s ease;">
                                    <i class="fas fa-list me-2"></i>Lihat Semua Data
                                </a>
                                <button type="button" class="btn" id="btnAddMore" style="background: white; color: #374151; border: 2px solid #e5e7eb; padding: 1rem 2rem; border-radius: 1rem; font-weight: 600; font-size: 1rem; transition: all 0.3s ease;">
                                    <i class="fas fa-plus me-2"></i>Tambah Data Lagi
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        $('body').append(modalHtml);
        
        if (!$('#successModalStyles').length) {
            const styles = `
                <style id="successModalStyles">
                    @keyframes bounceIn {
                        0% { transform: scale(0); opacity: 0; }
                        50% { transform: scale(1.1); }
                        100% { transform: scale(1); opacity: 1; }
                    }
                    
                    @keyframes fadeIn {
                        from { opacity: 0; transform: translateY(10px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                    
                    #successModal .btn:hover {
                        transform: translateY(-3px);
                        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
                    }
                    
                    #successModal .modal-backdrop {
                        backdrop-filter: blur(5px);
                    }
                </style>
            `;
            $('head').append(styles);
        }
        
        const modal = new bootstrap.Modal(document.getElementById('successModal'));
        modal.show();
        
        $('#btnAddMore').on('click', function() {
            modal.hide();
            $('#inventoryForm')[0].reset();
            $('.select2').val('').trigger('change');
            $('.radio-card').removeClass('active');
            $('.conditional-section').removeClass('show');
            $('.alert-validation-error').remove();
            $('html, body').animate({ scrollTop: 0 }, 500);
        });
    }

    // Form Submit Handler
    $('#inventoryForm').on('submit', function(e) {
        e.preventDefault();
        
        console.log('=== FORM VALIDATION START ===');
        
        const form = $(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalBtnText = submitBtn.html();
        
        const jenisInventori = $('input[name="jenis_inventori"]:checked').val();
        const hasSerial = $('input[name="has_serial"]:checked').val() === '1';
        const tanggal = $('#tanggal').val();
        const perangkat = $('#id_perangkat').val();
        const kategori = $('#kategori').val();

        console.log('Validating:', { jenisInventori, hasSerial, tanggal, perangkat, kategori });

        if (!jenisInventori) {
            showError('Silakan pilih jenis transaksi (Barang Masuk atau Barang Keluar)!');
            return false;
        }

        if (!tanggal) {
            showError('Tanggal harus diisi!');
            $('#tanggal').focus();
            return false;
        }

        if (!perangkat) {
            showError('Silakan pilih perangkat!');
            $('#id_perangkat').focus();
            return false;
        }

        if (!kategori) {
            showError('Silakan pilih kategori (Listrik/Non-Listrik)!');
            $('#kategori').focus();
            return false;
        }

        if ($('input[name="has_serial"]:checked').length === 0) {
            showError('Silakan pilih apakah barang memiliki serial number atau tidak!');
            return false;
        }

        if (jenisInventori === 'masuk') {
            const sumber = $('#sumber').val();
            console.log('Validating Barang Masuk - Sumber:', sumber);
            
            if (!sumber) {
                showError('Silakan pilih sumber barang masuk (Vendor/Customer)!');
                $('#sumber').focus();
                return false;
            }

            if (!hasSerial) {
                const stokValue = $('#stokMasuk').val();
                console.log('Stok Masuk Value:', stokValue);
                
                if (!stokValue || parseInt(stokValue) < 1) {
                    showError('Silakan isi jumlah stok minimal 1!');
                    $('#stokMasuk').focus();
                    return false;
                }
            } else {
                if (sumber === 'Vendor') {
                    const serials = $('input[name="serial_numbers[]"]').filter(function() {
                        return $(this).val().trim() !== '';
                    });
                    
                    console.log('Vendor Serials Count:', serials.length);
                    
                    if (serials.length === 0) {
                        showError('Silakan isi minimal 1 serial number untuk barang dari Vendor!');
                        return false;
                    }
                } else if (sumber === 'Customer') {
                    const returnSerials = $('input[name="return_serials[]"]:checked').length;
                    const newSerials = $('input[name="serial_numbers[]"]').filter(function() {
                        return $(this).val().trim() !== '';
                    }).length;
                    
                    console.log('Customer - Return:', returnSerials, 'New:', newSerials);
                    
                    if (returnSerials === 0 && newSerials === 0) {
                        showError('Silakan pilih minimal 1 serial return ATAU input minimal 1 serial baru dari customer!');
                        return false;
                    }
                }
            }
            
        } else if (jenisInventori === 'keluar') {
            const perihal = $('#perihal').val();
            console.log('Validating Barang Keluar - Perihal:', perihal);
            
            if (!perihal) {
                showError('Silakan pilih perihal barang keluar (Pemeliharaan/Penjualan/Instalasi)!');
                $('#perihal').focus();
                return false;
            }

            if (!hasSerial) {
                const stokValue = $('#stokKeluar').val();
                console.log('Stok Keluar Value:', stokValue);
                
                if (!stokValue || parseInt(stokValue) < 1) {
                    showError('Silakan isi jumlah stok minimal 1!');
                    $('#stokKeluar').focus();
                    return false;
                }
            } else {
                const selectedSerials = $('input[name="selected_serials[]"]:checked').length;
                console.log('Selected Serials Count:', selectedSerials);
                
                if (selectedSerials === 0) {
                    showError('Silakan pilih minimal 1 serial number yang akan keluar!');
                    return false;
                }
            }
        }
        
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...');
        
        const formData = new FormData(form[0]);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log('=== SUBMIT SUCCESS ===', response);
                submitBtn.prop('disabled', false).html(originalBtnText);
                showSuccessModal(response.message || 'Data berhasil disimpan!');
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                let errorMessage = 'Terjadi kesalahan saat menyimpan data!';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    const errors = Object.values(xhr.responseJSON.errors).flat();
                    errorMessage = errors.join('<br>');
                }
                
                showError(errorMessage);
            }
        });
        
        return false;
    });
});
</script>
@endpush