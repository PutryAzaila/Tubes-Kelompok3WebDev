@extends('layouts.dashboard')

@section('title', 'Tambah Data Inventory')
@section('page-title', 'Tambah Data Inventory')
@section('page-description', 'Tambahkan data barang masuk atau keluar')

@push('styles')
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<style>
    :root {
        --transdata-blue: #1e3a8a;
        --transdata-orange: #f97316;
        --transdata-gray: #6b7280;
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
        border-radius: 1rem;
        box-shadow: 0 10px 30px rgba(30, 58, 138, 0.3);
    }

    .form-card {
        border: none;
        border-radius: 1.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        background: white;
    }

    .form-card-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 2rem;
        border: none;
    }

    .form-card-body {
        padding: 2.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--transdata-gray);
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--transdata-blue);
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.15);
    }

    .input-group-text {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border: none;
        color: white;
        border-radius: 0.75rem 0 0 0.75rem;
        padding: 0 1rem;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 0.75rem 0.75rem 0;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--transdata-blue);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--transdata-orange);
        display: inline-block;
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border: none;
        color: white;
        padding: 1rem 3rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-cancel {
        background: linear-gradient(135deg, var(--transdata-gray) 0%, #9ca3af 100%);
        border: none;
        color: white;
        padding: 1rem 3rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-cancel:hover {
        transform: translateY(-2px);
        background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%);
        color: white;
    }

    .alert-custom {
        border: none;
        border-radius: 1rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .alert-danger {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        color: #991b1b;
        border-left: 4px solid #dc2626;
    }

    .animate-fade-in {
        animation: fadeIn 0.5s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .conditional-section {
        display: none;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .radio-card {
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .radio-card:hover {
        border-color: var(--transdata-blue);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 58, 138, 0.15);
    }

    .radio-card input[type="radio"]:checked + .radio-card-body {
        color: var(--transdata-blue);
    }

    .radio-card input[type="radio"]:checked ~ .radio-checkmark {
        opacity: 1;
    }

    .radio-checkmark {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        opacity: 0;
        transition: all 0.3s ease;
    }

    .form-icon {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        min-height: 48px;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: var(--transdata-blue);
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.15);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 animate-fade-in">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2"><i class="fas fa-plus-circle me-2"></i>Tambah Data Inventory</h1>
                    <p class="mb-0 opacity-75">Isi formulir di bawah untuk menambahkan data barang</p>
                </div>
                <a href="{{ route('inventory.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card form-card">
                <div class="form-card-header">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Form Data Inventory</h4>
                </div>
                <div class="form-card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-custom">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-exclamation-circle me-3 mt-1" style="font-size: 1.5rem;"></i>
                                <div>
                                    <strong>Terdapat kesalahan!</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('inventory.store') }}" method="POST" id="inventoryForm">
                        @csrf

                        <!-- Jenis Inventori Section -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-exchange-alt me-2"></i>Jenis Transaksi
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="radio-card">
                                        <input type="radio" name="jenis_inventori" value="masuk" class="d-none" required>
                                        <div class="radio-card-body">
                                            <div class="form-icon bg-gradient" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%);">
                                                <i class="fas fa-arrow-down"></i>
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
                                    <label class="radio-card">
                                        <input type="radio" name="jenis_inventori" value="keluar" class="d-none" required>
                                        <div class="radio-card-body">
                                            <div class="form-icon" style="background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);">
                                                <i class="fas fa-arrow-up"></i>
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

                        <!-- Informasi Dasar Section -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="tanggal" class="form-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Tanggal
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                            value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="id_perangkat" class="form-label">
                                        <i class="fas fa-box me-2"></i>Perangkat
                                    </label>
                                    <select class="form-select select2" id="id_perangkat" name="id_perangkat" required>
                                        <option value="">-- Pilih Perangkat --</option>
                                        @foreach($perangkats as $perangkat)
                                            <option value="{{ $perangkat->id }}" {{ old('id_perangkat') == $perangkat->id ? 'selected' : '' }}>
                                                {{ $perangkat->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="kategori" class="form-label">
                                        <i class="fas fa-tag me-2"></i>Kategori
                                    </label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Listrik" {{ old('kategori') == 'Listrik' ? 'selected' : '' }}>Listrik</option>
                                        <option value="Non-Listrik" {{ old('kategori') == 'Non-Listrik' ? 'selected' : '' }}>Non-Listrik</option>
                                    </select>
                                </div>

                                <div class="col-md-6" id="serialNumberSection" style="display: none;">
                                    <label for="serial_number" class="form-label">
                                        <i class="fas fa-barcode me-2"></i>Serial Number
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-hashtag"></i></span>
                                        <input type="text" class="form-control" id="serial_number" name="serial_number" 
                                            placeholder="Masukkan serial number" value="{{ old('serial_number') }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="stok" class="form-label">
                                        <i class="fas fa-cubes me-2"></i>Jumlah/Stok
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                        <input type="number" class="form-control" id="stok" name="stok" 
                                            placeholder="Masukkan jumlah" min="1" value="{{ old('stok') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Barang Masuk Section -->
                        <div id="barangMasukSection" class="conditional-section mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-arrow-circle-down me-2"></i>Detail Barang Masuk
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label for="sumber" class="form-label">
                                        <i class="fas fa-building me-2"></i>Sumber
                                    </label>
                                    <select class="form-select" id="sumber" name="sumber">
                                        <option value="">-- Pilih Sumber --</option>
                                        <option value="Customer" {{ old('sumber') == 'Customer' ? 'selected' : '' }}>Customer</option>
                                        <option value="Vendor" {{ old('sumber') == 'Vendor' ? 'selected' : '' }}>Vendor</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Barang Keluar Section -->
                        <div id="barangKeluarSection" class="conditional-section mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-arrow-circle-up me-2"></i>Detail Barang Keluar
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="perihal" class="form-label">
                                        <i class="fas fa-clipboard-list me-2"></i>Perihal
                                    </label>
                                    <select class="form-select" id="perihal" name="perihal">
                                        <option value="">-- Pilih Perihal --</option>
                                        <option value="Pemeliharaan" {{ old('perihal') == 'Pemeliharaan' ? 'selected' : '' }}>Pemeliharaan</option>
                                        <option value="Penjualan" {{ old('perihal') == 'Penjualan' ? 'selected' : '' }}>Penjualan</option>
                                        <option value="Instalasi" {{ old('perihal') == 'Instalasi' ? 'selected' : '' }}>Instalasi</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="alamat" class="form-label">
                                        <i class="fas fa-map-marker-alt me-2"></i>Alamat Tujuan
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-location-dot"></i></span>
                                        <input type="text" class="form-control" id="alamat" name="alamat" 
                                            placeholder="Masukkan alamat tujuan" value="{{ old('alamat') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan Section -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                            </h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="catatan" class="form-label">
                                        <i class="fas fa-comment me-2"></i>Catatan (Opsional)
                                    </label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                                        placeholder="Tambahkan catatan atau keterangan tambahan...">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                            <a href="{{ route('inventory.index') }}" class="btn btn-cancel">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save me-2"></i>Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
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
<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Perangkat --',
        allowClear: true
    });

    // Handle Jenis Inventori Change
    $('input[name="jenis_inventori"]').on('change', function() {
        const value = $(this).val();
        
        if (value === 'masuk') {
            $('#barangMasukSection').slideDown(300).css('display', 'block');
            $('#barangKeluarSection').slideUp(300);
            $('#sumber').prop('required', true);
            $('#perihal').prop('required', false);
        } else if (value === 'keluar') {
            $('#barangKeluarSection').slideDown(300).css('display', 'block');
            $('#barangMasukSection').slideUp(300);
            $('#perihal').prop('required', true);
            $('#sumber').prop('required', false);
        }
    });

    // Handle Kategori Change
    $('#kategori').on('change', function() {
        if ($(this).val() === 'Listrik') {
            $('#serialNumberSection').slideDown(300).css('display', 'block');
            $('#serial_number').prop('required', true);
        } else {
            $('#serialNumberSection').slideUp(300);
            $('#serial_number').prop('required', false).val('');
        }
    });

    // Trigger kategori change on page load if old value exists
    if ($('#kategori').val() === 'Listrik') {
        $('#serialNumberSection').show();
        $('#serial_number').prop('required', true);
    }

    // Radio Card Click Handler
    $('.radio-card').on('click', function() {
        const radio = $(this).find('input[type="radio"]');
        radio.prop('checked', true).trigger('change');
        
        // Remove active class from all cards
        $('.radio-card').removeClass('border-primary');
        // Add active class to clicked card
        $(this).addClass('border-primary');
    });

    // Form Validation
    $('#inventoryForm').on('submit', function(e) {
        const jenisInventori = $('input[name="jenis_inventori"]:checked').val();
        
        if (!jenisInventori) {
            e.preventDefault();
            alert('Silakan pilih jenis transaksi terlebih dahulu!');
            return false;
        }

        if (jenisInventori === 'masuk' && !$('#sumber').val()) {
            e.preventDefault();
            alert('Silakan pilih sumber untuk barang masuk!');
            $('#sumber').focus();
            return false;
        }

        if (jenisInventori === 'keluar' && !$('#perihal').val()) {
            e.preventDefault();
            alert('Silakan pilih perihal untuk barang keluar!');
            $('#perihal').focus();
            return false;
        }
    });
});
</script>
@endpush