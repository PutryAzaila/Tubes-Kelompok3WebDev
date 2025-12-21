@extends('layouts.dashboard')

@section('title', 'Edit Data Inventory')
@section('page-title', 'Edit Data Inventory')
@section('page-description', 'Edit data barang masuk atau keluar')

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
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
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

    .form-control:disabled, .form-select:disabled {
        background-color: #f3f4f6;
        cursor: not-allowed;
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

    .info-box {
        background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
        color: white;
        padding: 1.5rem;
        border-radius: 1rem;
        margin-bottom: 2rem;
    }

    .info-box .info-label {
        font-size: 0.85rem;
        opacity: 0.9;
        margin-bottom: 0.25rem;
    }

    .info-box .info-value {
        font-size: 1.1rem;
        font-weight: 700;
    }

    .btn-update {
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        border: none;
        color: white;
        padding: 1rem 3rem;
        border-radius: 0.75rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
    }

    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.4);
        color: white;
    }

    .badge-type {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .badge-masuk {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
    }

    .badge-keluar {
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        color: white;
    }

    .alert-warning {
        background: linear-gradient(135deg, #fbbf24 0%, #fcd34d 100%);
        border: none;
        color: #92400e;
        border-radius: 1rem;
        padding: 1.5rem;
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
                    <h1 class="mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Data Inventory
                    </h1>
                    <p class="mb-0 opacity-75">Update data barang yang sudah ada</p>
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
                    <h4 class="mb-0">
                        <i class="fas fa-pencil-alt me-2"></i>Form Edit Inventory
                    </h4>
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

                    <!-- Information Box -->
                    <div class="info-box">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="info-label">Jenis Transaksi</div>
                                <div class="info-value">
                                    <span class="badge-type {{ $type === 'masuk' ? 'badge-masuk' : 'badge-keluar' }}">
                                        <i class="fas fa-arrow-{{ $type === 'masuk' ? 'down' : 'up' }} me-2"></i>
                                        {{ $type === 'masuk' ? 'Barang Masuk' : 'Barang Keluar' }}
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Perangkat</div>
                                <div class="info-value">{{ $inventory->detailBarang->perangkat->nama_perangkat ?? '-' }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Kategori</div>
                                <div class="info-value">{{ $inventory->detailBarang->kategori ?? '-' }}</div>
                            </div>
                            <div class="col-md-3">
                                <div class="info-label">Serial Number</div>
                                <div class="info-value">
                                    <code style="background: rgba(255,255,255,0.2); padding: 0.25rem 0.5rem; border-radius: 0.25rem;">
                                        {{ $inventory->detailBarang->serial_number ?? 'Tidak Ada' }}
                                    </code>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Info -->
                    <div class="alert alert-warning mb-4">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Perhatian!</strong> Anda dapat mengubah tanggal, jumlah/stok, catatan, dan serial number (jika ada typo). 
                        Data perangkat, kategori, dan status tidak dapat diubah.
                    </div>

                    <form action="{{ route('inventory.update', [$inventory->id, $type]) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')

                        <!-- Informasi yang Dapat Diubah -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-edit me-2"></i>Data yang Dapat Diubah
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label for="tanggal" class="form-label">
                                        <i class="fas fa-calendar-alt me-2"></i>Tanggal
                                    </label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                        value="{{ old('tanggal', $inventory->tanggal) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="stok" class="form-label">
                                        <i class="fas fa-cubes me-2"></i>Jumlah/Stok
                                    </label>
                                    <input type="number" class="form-control" id="stok" name="stok" 
                                        value="{{ old('stok', $inventory->jumlah) }}" min="1" required>
                                    <small class="text-muted">Jumlah saat ini: {{ $inventory->jumlah }} unit</small>
                                </div>

                                <!-- Alamat (hanya untuk Barang Keluar) -->
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

                                <div class="col-md-12">
                                    <label for="catatan" class="form-label">
                                        <i class="fas fa-sticky-note me-2"></i>Catatan
                                    </label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="4" 
                                        placeholder="Tambahkan catatan atau keterangan...">{{ old('catatan', $type === 'masuk' ? $inventory->catatan_barang_masuk : $inventory->catatan_barang_keluar) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi yang Tidak Dapat Diubah (Read-only) -->
                        <div class="mb-5">
                            <h5 class="section-title">
                                <i class="fas fa-lock me-2"></i>Data yang Tidak Dapat Diubah
                            </h5>
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-box me-2"></i>Perangkat
                                    </label>
                                    <input type="text" class="form-control" 
                                        value="{{ $inventory->detailBarang->perangkat->nama_perangkat ?? '-' }}" 
                                        disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-tag me-2"></i>Kategori
                                    </label>
                                    <input type="text" class="form-control" 
                                        value="{{ $inventory->detailBarang->kategori ?? '-' }}" 
                                        disabled>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-barcode me-2"></i>Serial Number
                                    </label>
                                    @if($inventory->detailBarang->serial_number)
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="serialNumberDisplay" 
                                                value="{{ $inventory->detailBarang->serial_number }}" 
                                                disabled>
                                            <button type="button" class="btn btn-warning" id="btnEditSerial">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                        </div>
                                        <!-- Hidden input for editing -->
                                        <input type="text" class="form-control mt-2" id="serialNumberEdit" 
                                            name="serial_number" 
                                            value="{{ $inventory->detailBarang->serial_number }}" 
                                            style="display: none;"
                                            placeholder="Masukkan serial number baru">
                                        <small class="text-danger d-none" id="serialWarning">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            Pastikan serial number sudah benar sebelum menyimpan!
                                        </small>
                                    @else
                                        <input type="text" class="form-control" 
                                            value="Tidak Ada Serial Number" 
                                            disabled>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">
                                        <i class="fas fa-info-circle me-2"></i>Status
                                    </label>
                                    <input type="text" class="form-control" 
                                        value="{{ $inventory->status }}" 
                                        disabled>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-update">
                                <i class="fas fa-save me-2"></i>Update Data
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
            editInput.hide();
            displayInput.show();
            warning.addClass('d-none');
            btn.html('<i class="fas fa-edit"></i> Edit');
            btn.removeClass('btn-danger').addClass('btn-warning');
        } else {
            // Enable edit mode
            displayInput.hide();
            editInput.show().focus();
            warning.removeClass('d-none');
            btn.html('<i class="fas fa-times"></i> Batal');
            btn.removeClass('btn-warning').addClass('btn-danger');
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
            alert('Tanggal harus diisi!');
            $('#tanggal').focus();
            return false;
        }
        
        // Validasi stok
        if (!stokValue || parseInt(stokValue) < 1) {
            e.preventDefault();
            alert('Jumlah/stok minimal 1!');
            $('#stok').focus();
            return false;
        }
        
        // Validasi serial number jika sedang di-edit
        if (serialEdit.is(':visible')) {
            const newSerial = serialEdit.val().trim();
            const oldSerial = $('#serialNumberDisplay').val();
            
            if (!newSerial) {
                e.preventDefault();
                alert('Serial number tidak boleh kosong!');
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
        
        console.log('=== VALIDATION PASSED ===');
        return true;
    });

    // Konfirmasi sebelum submit (untuk perubahan stok)
    $('#editForm').on('submit', function(e) {
        const stok = $('#stok').val();
        const currentStok = {{ $inventory->jumlah }};
        
        if (parseInt(stok) !== currentStok) {
            if (!confirm(`Anda akan mengubah jumlah dari ${currentStok} menjadi ${stok}. Lanjutkan?`)) {
                e.preventDefault();
                return false;
            }
        }
    });
});
</script>
@endpush