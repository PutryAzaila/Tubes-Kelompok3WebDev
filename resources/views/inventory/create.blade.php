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

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--transdata-blue);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 3px solid var(--transdata-orange);
        display: inline-block;
    }

    .radio-card {
        border: 2px solid #e5e7eb;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .radio-card:hover {
        border-color: var(--transdata-blue);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(30, 58, 138, 0.15);
    }

    .radio-card.active {
        border-color: var(--transdata-blue);
        background: rgba(30, 58, 138, 0.05);
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

    .radio-card.active .radio-checkmark {
        opacity: 1;
    }

    .serial-input-group {
        background: #f9fafb;
        border: 2px dashed #e5e7eb;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
    }

    .serial-checkbox-item {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .serial-checkbox-item:hover {
        border-color: var(--transdata-blue);
        background: rgba(30, 58, 138, 0.05);
    }

    .serial-checkbox-item.selected {
        border-color: var(--transdata-blue);
        background: rgba(30, 58, 138, 0.1);
    }

    .btn-add-serial {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
    }

    .btn-remove-serial {
        background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
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

    .conditional-section {
        display: none !important;
    }
    
    .conditional-section.show {
        display: block !important;
    }

    .info-badge {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.85rem;
        display: inline-block;
        margin-bottom: 1rem;
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
                        <div class="alert alert-danger">
                            <strong>Terdapat kesalahan!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ url('/inventory') }}" method="POST" id="inventoryForm">
                        @csrf

                        <!-- Jenis Transaksi -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-exchange-alt me-2"></i>Jenis Transaksi
                            </h5>
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

                        <!-- Informasi Dasar -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="tanggal" class="form-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Tanggal
                                    </label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="id_perangkat" class="form-label">
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
                                    <label for="kategori" class="form-label">
                                        <i class="fas fa-tag me-2"></i>Kategori
                                    </label>
                                    <select class="form-select" id="kategori" name="kategori" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        <option value="Listrik">Listrik</option>
                                        <option value="Non-Listrik">Non-Listrik</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
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

                        <!-- Barang Masuk Section -->
                        <div id="barangMasukSection" class="conditional-section mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-arrow-circle-down me-2"></i>Detail Barang Masuk
                            </h5>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-12">
                                    <label for="sumber" class="form-label">
                                        <i class="fas fa-building me-2"></i>Sumber
                                    </label>
                                    <select class="form-select" id="sumber" name="sumber">
                                        <option value="">-- Pilih Sumber --</option>
                                        <option value="Vendor">Vendor (Barang Baru)</option>
                                        <option value="Customer">Customer (Return/Titip Baru)</option>
                                    </select>
                                </div>
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

                                <!-- Customer: Return atau Baru -->
                                <div id="customerSerialSection" class="conditional-section">
                                    <div class="info-badge">
                                        <i class="fas fa-info-circle me-2"></i>Customer: Pilih serial return atau input baru
                                    </div>
                                    
                                    <!-- Return Serials -->
                                    <div class="mb-4">
                                        <label class="form-label">Serial Number Return (Opsional)</label>
                                        <div id="returnSerialsContainer"></div>
                                    </div>

                                    <!-- New Serials from Customer -->
                                    <div>
                                        <label class="form-label">Serial Number Baru dari Customer (Opsional)</label>
                                        <div class="mb-3">
                                            <button type="button" class="btn btn-add-serial" id="btnAddCustomerSerial">
                                                <i class="fas fa-plus me-2"></i>Tambah Serial Baru
                                            </button>
                                        </div>
                                        <div id="serialInputsCustomer"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Stok untuk Non-Serial -->
                            <div id="stokMasukSection" class="conditional-section">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="stokMasuk" class="form-label">
                                            <i class="fas fa-cubes me-2"></i>Jumlah/Stok
                                        </label>
                                        <input type="number" class="form-control" id="stokMasuk" name="stok" min="1" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Barang Keluar Section -->
                        <div id="barangKeluarSection" class="conditional-section mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-arrow-circle-up me-2"></i>Detail Barang Keluar
                            </h5>
                            <div class="row g-4 mb-4">
                                <div class="col-md-6">
                                    <label for="perihal" class="form-label">
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
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="stokKeluar" class="form-label">
                                            <i class="fas fa-cubes me-2"></i>Jumlah/Stok
                                        </label>
                                        <input type="number" class="form-control" id="stokKeluar" name="stok" min="1" value="1">
                                        <small class="text-muted">Stok tersedia: <span id="availableStock">-</span></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-sticky-note me-2"></i>Catatan Tambahan
                            </h5>
                            <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                                placeholder="Tambahkan catatan atau keterangan tambahan..."></textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
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
            
            // Disable fields barang keluar
            $('#stokKeluar').prop('disabled', true);
            $('#perihal').prop('disabled', true);
            $('#alamat').prop('disabled', true);
        } else {
            $('#barangKeluarSection').removeClass('conditional-section').addClass('show');
            $('#barangMasukSection').removeClass('show').addClass('conditional-section');
            $('#perihal').prop('required', true);
            $('#sumber').prop('required', false);
            
            // Disable fields barang masuk
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
        $(`#customerSerial${id}`).remove();
    };

    // Load Returnable Serials
    function loadReturnableSerials() {
        const perangkatId = $('#id_perangkat').val();
        const kategori = $('#kategori').val();

        if (!perangkatId || !kategori) return;

        $.get('{{ route("inventory.returnable-serials") }}', {
            id_perangkat: perangkatId,
            kategori: kategori
        }, function(response) {
            const container = $('#returnSerialsContainer');
            container.empty();

            if (response.data.length === 0) {
                container.html('<p class="text-muted">Tidak ada serial number yang dapat dikembalikan</p>');
                return;
            }

            response.data.forEach(item => {
                container.append(`
                    <div class="serial-checkbox-item">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="return_serials[]" 
                                value="${item.id}" id="return${item.id}">
                            <label class="form-check-label" for="return${item.id}">
                                <strong>${item.serial_number}</strong>
                                <span class="badge bg-warning ms-2">Keluar: ${item.out_stock}</span>
                            </label>
                        </div>
                    </div>
                `);
            });
        }).fail(function(xhr) {
            console.error('Error loading returnable serials:', xhr);
        });
    }

    // Load Available Serials
    function loadAvailableSerials() {
        const perangkatId = $('#id_perangkat').val();
        const kategori = $('#kategori').val();

        if (!perangkatId || !kategori) return;

        $.get('{{ route("inventory.available-serials") }}', {
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

    // Check Available Stock
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

    // Trigger reload when perangkat or kategori changes
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

    $('#inventoryForm').on('submit', function(e) {
    e.preventDefault(); // Prevent default submit
    
    console.log('=== FORM VALIDATION START ===');
    
    const form = $(this);
    const submitBtn = $('#btnSubmit');
    const originalBtnText = submitBtn.html();
    
    // Basic validation
    const jenisInventori = $('input[name="jenis_inventori"]:checked').val();
    const hasSerial = $('input[name="has_serial"]:checked').val() === '1';
    const tanggal = $('#tanggal').val();
    const perangkat = $('#id_perangkat').val();
    const kategori = $('#kategori').val();

    console.log('Validating:', { jenisInventori, hasSerial, tanggal, perangkat, kategori });

    // Validation: Jenis Transaksi
    if (!jenisInventori) {
        showError('Silakan pilih jenis transaksi (Barang Masuk atau Barang Keluar)!');
        return false;
    }

    // Validation: Tanggal
    if (!tanggal) {
        showError('Tanggal harus diisi!');
        $('#tanggal').focus();
        return false;
    }

    // Validation: Perangkat
    if (!perangkat) {
        showError('Silakan pilih perangkat!');
        $('#id_perangkat').focus();
        return false;
    }

    // Validation: Kategori
    if (!kategori) {
        showError('Silakan pilih kategori (Listrik/Non-Listrik)!');
        $('#kategori').focus();
        return false;
    }

    // Validation: Has Serial
    if ($('input[name="has_serial"]:checked').length === 0) {
        showError('Silakan pilih apakah barang memiliki serial number atau tidak!');
        return false;
    }

    // Validation berdasarkan Jenis Inventori
    if (jenisInventori === 'masuk') {
        const sumber = $('#sumber').val();
        console.log('Validating Barang Masuk - Sumber:', sumber);
        
        if (!sumber) {
            showError('Silakan pilih sumber barang masuk (Vendor/Customer)!');
            $('#sumber').focus();
            return false;
        }

        if (!hasSerial) {
            // Validasi stok untuk barang tanpa serial
            const stokValue = $('#stokMasuk').val();
            console.log('Stok Masuk Value:', stokValue);
            
            if (!stokValue || parseInt(stokValue) < 1) {
                showError('Silakan isi jumlah stok minimal 1!');
                $('#stokMasuk').focus();
                return false;
            }
        } else {
            // Validasi serial number
            if (sumber === 'Vendor') {
                const serials = $('input[name="serial_numbers[]"]').filter(function() {
                    return $(this).val().trim() !== '';
                });
                
                console.log('Vendor Serials Count:', serials.length);
                
                if (serials.length === 0) {
                    showError('Silakan isi minimal 1 serial number untuk barang dari Vendor!');
                    return false;
                }
                
                // Validasi tidak ada serial yang kosong
                let hasEmptySerial = false;
                serials.each(function() {
                    if (!$(this).val().trim()) {
                        hasEmptySerial = true;
                        return false;
                    }
                });
                
                if (hasEmptySerial) {
                    showError('Semua serial number harus diisi, tidak boleh ada yang kosong!');
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
            // Validasi stok untuk barang tanpa serial
            const stokValue = $('#stokKeluar').val();
            console.log('Stok Keluar Value:', stokValue);
            
            if (!stokValue || parseInt(stokValue) < 1) {
                showError('Silakan isi jumlah stok minimal 1!');
                $('#stokKeluar').focus();
                return false;
            }
        } else {
            // Validasi serial number selection
            const selectedSerials = $('input[name="selected_serials[]"]:checked').length;
            console.log('Selected Serials Count:', selectedSerials);
            
            if (selectedSerials === 0) {
                showError('Silakan pilih minimal 1 serial number yang akan keluar!');
                return false;
            }
        }
    }

    console.log('=== VALIDATION PASSED ===');
    
    // Show loading state
    submitBtn.prop('disabled', true).html(
        '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...'
    );
    
    // Submit form
    form.off('submit').submit();
    
    return true;
});

// Helper function untuk menampilkan error
function showError(message) {
    // Hapus alert lama jika ada
    $('.alert-validation-error').remove();
    
    // Buat alert baru
    const alertHtml = `
        <div class="alert alert-danger alert-dismissible fade show alert-validation-error" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Validasi Gagal!</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert alert di atas form
    $('#inventoryForm').prepend(alertHtml);
    
    // Scroll ke atas untuk lihat alert
    $('html, body').animate({
        scrollTop: $('#inventoryForm').offset().top - 100
    }, 500);
    
    // Auto hide setelah 5 detik
    setTimeout(function() {
        $('.alert-validation-error').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000);
    
    console.error('Validation Error:', message);
    }
});
</script>
@endpush