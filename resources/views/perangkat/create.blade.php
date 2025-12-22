@extends('layouts.dashboard')

@section('title', 'Tambah Perangkat')

@section('page-title', 'Tambah Perangkat')
@section('page-subtitle', 'Tambah data perangkat baru')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
.page-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
}

.page-header h4 {
    color: white;
    font-weight: 700;
    margin: 0;
    font-size: 1.75rem;
}

.page-header p {
    color: rgba(255, 255, 255, 0.9);
    margin: 0.5rem 0 0 0;
}

.breadcrumb-custom {
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 8px;
    display: inline-flex;
    margin-top: 1rem;
}

.breadcrumb-custom .breadcrumb {
    margin: 0;
}

.breadcrumb-custom .breadcrumb-item {
    color: rgba(255, 255, 255, 0.9);
}

.breadcrumb-custom .breadcrumb-item.active {
    color: white;
    font-weight: 600;
}

.breadcrumb-custom .breadcrumb-item a {
    color: white;
    text-decoration: none;
}

.breadcrumb-custom .breadcrumb-item + .breadcrumb-item::before {
    color: rgba(255, 255, 255, 0.6);
}

.form-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
}

.form-section-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 3px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.form-section-title i {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: white;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-label {
    font-weight: 600;
    color: #334155;
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
    padding: 0.75rem 1rem;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: #ef4444;
}

.invalid-feedback {
    font-size: 0.8125rem;
    color: #ef4444;
}

.form-text {
    color: #64748b;
    font-size: 0.8125rem;
    margin-top: 0.5rem;
}

.btn-gradient-primary {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    border: none;
    color: white;
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-gradient-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    color: white;
}

.btn-outline-secondary {
    border: 2px solid #e2e8f0;
    color: #64748b;
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #f1f5f9;
    border-color: #cbd5e1;
    color: #475569;
}

.status-options {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-top: 0.5rem;
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
    padding: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: center;
}

.status-option label:hover {
    border-color: #cbd5e1;
    background: #f8fafc;
}

.status-option input[type="radio"]:checked + label {
    border-color: #2563eb;
    background: #dbeafe;
}

.status-option.berfungsi input[type="radio"]:checked + label {
    border-color: #10b981;
    background: #d1fae5;
}

.status-option.rusak input[type="radio"]:checked + label {
    border-color: #ef4444;
    background: #fee2e2;
}

.status-option.hilang input[type="radio"]:checked + label {
    border-color: #f59e0b;
    background: #fef3c7;
}

.status-option.return input[type="radio"]:checked + label {
    border-color: #8b5cf6;
    background: #ede9fe;
}

.status-icon {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background: #f1f5f9;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
    margin: 0 auto 0.75rem;
    transition: all 0.3s ease;
}

.status-option input[type="radio"]:checked + label .status-icon {
    color: #1e293b;
}

.status-label {
    font-weight: 600;
    color: #64748b;
    margin: 0;
}

.status-option input[type="radio"]:checked + label .status-label {
    color: #1e293b;
}

@media (max-width: 768px) {
    .form-card {
        padding: 1.5rem;
    }
    
    .status-options {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h4><i class="fas fa-plus-circle me-2"></i>Tambah Perangkat Baru</h4>
        <p class="mb-0">Lengkapi form di bawah untuk menambahkan perangkat baru</p>
        <nav class="breadcrumb-custom" aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('perangkat.index') }}">Perangkat</a>
                </li>
                <li class="breadcrumb-item active">Tambah</li>
            </ol>
        </nav>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <form action="{{ route('perangkat.store') }}" method="POST">
                @csrf
                
                <div class="form-card">
                    <div class="form-section-title">
                        <i class="fas fa-info-circle"></i>
                        <span>Informasi Perangkat</span>
                    </div>

                    <div class="row g-3">
                        <!-- Nama Perangkat -->
                        <div class="col-12">
                            <label for="nama_perangkat" class="form-label">
                                Nama Perangkat<span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                class="form-control @error('nama_perangkat') is-invalid @enderror" 
                                id="nama_perangkat" 
                                name="nama_perangkat"
                                value="{{ old('nama_perangkat') }}"
                                placeholder="Contoh: Laptop Dell Latitude 5420"
                                required
                            >
                            @error('nama_perangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Masukkan nama perangkat yang jelas dan spesifik
                            </div>
                        </div>

                        <!-- Kategori Perangkat -->
                        <div class="col-12">
                            <label for="id_kategori_perangkat" class="form-label">
                                Kategori Perangkat<span class="required">*</span>
                            </label>
                            <select 
                                class="form-select @error('id_kategori_perangkat') is-invalid @enderror" 
                                id="id_kategori_perangkat" 
                                name="id_kategori_perangkat"
                                required
                            >
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
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Pilih kategori yang sesuai dengan jenis perangkat
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-12">
                            <label class="form-label">
                                Status Perangkat<span class="required">*</span>
                            </label>
                            <div class="status-options">
                                <div class="status-option berfungsi">
                                    <input 
                                        type="radio" 
                                        name="status" 
                                        id="status_berfungsi" 
                                        value="Berfungsi"
                                        {{ old('status', 'Berfungsi') == 'Berfungsi' ? 'checked' : '' }}
                                    >
                                    <label for="status_berfungsi">
                                        <div class="status-icon">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <p class="status-label">Berfungsi</p>
                                    </label>
                                </div>
                                <div class="status-option rusak">
                                    <input 
                                        type="radio" 
                                        name="status" 
                                        id="status_rusak" 
                                        value="Rusak"
                                        {{ old('status') == 'Rusak' ? 'checked' : '' }}
                                    >
                                    <label for="status_rusak">
                                        <div class="status-icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <p class="status-label">Rusak</p>
                                    </label>
                                </div>
                                <div class="status-option hilang">
                                    <input 
                                        type="radio" 
                                        name="status" 
                                        id="status_hilang" 
                                        value="Hilang"
                                        {{ old('status') == 'Hilang' ? 'checked' : '' }}
                                    >
                                    <label for="status_hilang">
                                        <div class="status-icon">
                                            <i class="fas fa-question-circle"></i>
                                        </div>
                                        <p class="status-label">Hilang</p>
                                    </label>
                                </div>
                                <div class="status-option return">
                                    <input 
                                        type="radio" 
                                        name="status" 
                                        id="status_return" 
                                        value="Return"
                                        {{ old('status') == 'Return' ? 'checked' : '' }}
                                    >
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

                        <!-- Catatan -->
                        <div class="col-12">
                            <label for="catatan_perangkat" class="form-label">
                                Catatan Perangkat
                            </label>
                            <textarea 
                                class="form-control @error('catatan_perangkat') is-invalid @enderror" 
                                id="catatan_perangkat" 
                                name="catatan_perangkat"
                                rows="4"
                                placeholder="Tambahkan catatan atau keterangan tambahan..."
                            >{{ old('catatan_perangkat') }}</textarea>
                            @error('catatan_perangkat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Opsional - Tambahkan informasi tambahan jika diperlukan
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-card">
                    <div class="d-flex justify-content-between gap-3">
                        <a href="{{ route('perangkat.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-gradient-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perangkat
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush