@extends('layouts.dashboard')

@section('title', 'Tambah Perangkat')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    :root {
        --transdata-blue: #1e3a8a;
        --transdata-orange: #f97316;
    }

    body {
        background: #f8f9fa;
        font-family: 'Inter', sans-serif;
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
        background: white;
    }

    .form-card-header {
        background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
        color: white;
        padding: 2rem;
        border: none;
        border-radius: 1.5rem 1.5rem 0 0;
    }

    .form-label {
        font-weight: 600;
        color: #4b5563;
        margin-bottom: 0.75rem;
    }

    .form-control, .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.875rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--transdata-blue);
        box-shadow: 0 0 0 0.25rem rgba(30, 58, 138, 0.15);
    }

    .btn-submit {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border: none;
        color: white;
        padding: 1rem 3rem;
        border-radius: 0.75rem;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <div class="page-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-2"><i class="fas fa-plus-circle me-2"></i>Tambah Perangkat</h1>
                    <p class="mb-0 opacity-75">Tambahkan data perangkat baru</p>
                </div>
                <a href="{{ route('perangkat.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card form-card">
                <div class="form-card-header">
                    <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Form Data Perangkat</h4>
                </div>
                <div class="card-body p-4">
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

                    <form action="{{ route('perangkat.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="id_kategori_perangkat" class="form-label">
                                <i class="fas fa-folder me-2"></i>Kategori Perangkat
                            </label>
                            <select class="form-select @error('id_kategori_perangkat') is-invalid @enderror" 
                                    id="id_kategori_perangkat" 
                                    name="id_kategori_perangkat" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('id_kategori_perangkat') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_kategori_perangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="nama_perangkat" class="form-label">
                                <i class="fas fa-laptop me-2"></i>Nama Perangkat
                            </label>
                            <input type="text" 
                                   class="form-control @error('nama_perangkat') is-invalid @enderror" 
                                   id="nama_perangkat" 
                                   name="nama_perangkat" 
                                   value="{{ old('nama_perangkat') }}"
                                   placeholder="Masukkan nama perangkat" required>
                            @error('nama_perangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="status" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Status
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="Berfungsi" {{ old('status') == 'Berfungsi' ? 'selected' : '' }}>Berfungsi</option>
                                <option value="Rusak" {{ old('status') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                <option value="Return" {{ old('status') == 'Return' ? 'selected' : '' }}>Return</option>
                                <option value="Hilang" {{ old('status') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="catatan_perangkat" class="form-label">
                                <i class="fas fa-sticky-note me-2"></i>Catatan Perangkat
                            </label>
                            <textarea class="form-control @error('catatan_perangkat') is-invalid @enderror" 
                                      id="catatan_perangkat" 
                                      name="catatan_perangkat" 
                                      rows="4"
                                      placeholder="Tambahkan catatan (opsional)">{{ old('catatan_perangkat') }}</textarea>
                            @error('catatan_perangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                            <a href="{{ route('perangkat.index') }}" class="btn btn-secondary">
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
$(document).ready(function() {
    // Initialize Select2
    $('#id_kategori_perangkat').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Kategori --'
    });
});
</script>
@endpush