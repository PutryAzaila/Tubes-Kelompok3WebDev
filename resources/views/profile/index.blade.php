@extends('layouts.dashboard')

@section('title', 'Profile')

@section('page-title', 'Profile Saya')
@section('page-subtitle', 'Kelola informasi profile dan keamanan akun Anda')

@push('styles')
<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* ===== VARIABLES ===== */
:root {
    --primary: #2563eb;
    --primary-dark: #1e40af;
    --primary-light: #dbeafe;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-400: #94a3b8;
    --gray-500: #64748b;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --gray-900: #0f172a;
}

/* ===== RESET ===== */
body {
    background-color: var(--gray-50);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* ===== HEADER ===== */
.profile-header {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    border-radius: 20px;
    padding: 3rem 2.5rem;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 32px rgba(37, 99, 235, 0.2);
}

.profile-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 100%;
    background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    opacity: 0.3;
}

.header-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 2.5rem;
}

.profile-avatar-wrapper {
    position: relative;
    flex-shrink: 0;
}

.profile-avatar {
    width: 140px;
    height: 140px;
    border-radius: 50%;
    border: 6px solid rgba(255, 255, 255, 0.3);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.1) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
}

.profile-avatar i {
    font-size: 4rem;
    color: white;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.profile-info {
    flex: 1;
}

.profile-info h1 {
    color: white;
    font-size: 2.25rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    letter-spacing: -0.5px;
}

.profile-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
}

.profile-badge {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    font-weight: 500;
    font-size: 0.9375rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.profile-badge:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-2px);
}

.profile-badge i {
    font-size: 0.875rem;
}

.profile-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.9375rem;
}

.profile-meta i {
    margin-right: 0.375rem;
}

/* ===== ALERTS ===== */
.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border-left: 4px solid transparent;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-success {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-left-color: var(--success);
    color: #065f46;
}

.alert-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    border-left-color: var(--danger);
    color: #991b1b;
}

.alert-modern i {
    font-size: 1.25rem;
    flex-shrink: 0;
}

.alert-modern ul {
    margin: 0.5rem 0 0 1.5rem;
    padding: 0;
}

.alert-modern ul li {
    margin-bottom: 0.25rem;
}

.alert-modern ul li:last-child {
    margin-bottom: 0;
}

/* ===== CARDS ===== */
.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
}

.card-header {
    padding: 1.75rem;
    border-bottom: 1px solid var(--gray-200);
    background: linear-gradient(135deg, var(--gray-50) 0%, var(--gray-100) 100%);
}

.card-header h3 {
    color: var(--gray-800);
    font-size: 1.25rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-header h3 i {
    color: var(--primary);
    width: 24px;
    text-align: center;
}

.card-body {
    padding: 1.75rem;
}

/* ===== INFO ITEMS ===== */
.info-grid {
    display: grid;
    gap: 1.25rem;
}

.info-item {
    padding: 1rem;
    border-radius: 12px;
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    transition: all 0.2s ease;
}

.info-item:hover {
    background: white;
    border-color: var(--primary-light);
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.1);
}

.info-label {
    font-weight: 500;
    color: var(--gray-600);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-label i {
    color: var(--primary);
    font-size: 0.875rem;
}

.info-value {
    color: var(--gray-800);
    font-size: 1rem;
    font-weight: 500;
}

/* ===== FORMS ===== */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-label i {
    color: var(--primary);
    font-size: 0.875rem;
}

.form-control, .form-select {
    border: 2px solid var(--gray-300);
    border-radius: 12px;
    padding: 0.75rem 1rem;
    font-size: 0.9375rem;
    color: var(--gray-700);
    transition: all 0.2s ease;
    background: white;
}

.form-control:focus, .form-select:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    outline: none;
}

.form-control.is-invalid, .form-select.is-invalid {
    border-color: var(--danger);
    background-image: none;
}

.form-control.is-invalid:focus {
    border-color: var(--danger);
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.invalid-feedback {
    color: var(--danger);
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.invalid-feedback::before {
    content: '⚠️';
    font-size: 0.875rem;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.9375rem;
    border: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #1e3a8a 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(37, 99, 235, 0.4);
    color: white;
}

.btn-secondary {
    background: linear-gradient(135deg, var(--gray-400) 0%, var(--gray-500) 100%);
    color: white;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, var(--gray-500) 0%, var(--gray-600) 100%);
    transform: translateY(-2px);
    color: white;
}

.btn-danger {
    background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-danger:hover {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239, 68, 68, 0.4);
    color: white;
}

.btn-group {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

/* ===== PASSWORD INFO ===== */
.password-info {
    background: linear-gradient(135deg, var(--primary-light) 0%, #bfdbfe 100%);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin: 1.5rem 0;
    border: 1px solid rgba(37, 99, 235, 0.2);
}

.password-info i {
    color: var(--primary);
    margin-right: 0.5rem;
}

.password-info strong {
    color: var(--primary-dark);
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991px) {
    .profile-header {
        padding: 2rem 1.5rem;
    }
    
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
    
    .profile-avatar i {
        font-size: 3rem;
    }
    
    .profile-info h1 {
        font-size: 1.875rem;
    }
    
    .profile-badges {
        justify-content: center;
    }
    
    .profile-meta {
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .card-header, .card-body {
        padding: 1.25rem;
    }
}

@media (max-width: 767px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn {
        width: 100%;
    }
}

@media (max-width: 575px) {
    .profile-header {
        padding: 1.5rem 1.25rem;
        border-radius: 16px;
    }
    
    .profile-info h1 {
        font-size: 1.5rem;
    }
    
    .profile-badge {
        padding: 0.375rem 1rem;
        font-size: 0.875rem;
    }
    
    .profile-meta {
        font-size: 0.875rem;
    }
    
    .card-header h3 {
        font-size: 1.125rem;
    }
}
</style>
@endpush

@section('content')
<div class="row g-3 g-lg-4">
    
    <!-- Alerts -->
    @if(session('success'))
    <div class="col-12">
        <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            <div>
                <strong>Berhasil!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="col-12">
        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Terjadi kesalahan!</strong>
                <ul class="mt-2 mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Profile Header -->
    <div class="col-12">
        <div class="profile-header">
            <div class="header-content">
                <div class="profile-avatar-wrapper">
                    <div class="profile-avatar">
                        @if($user->photo_path)
                            <img src="{{ asset('storage/' . $user->photo_path) }}" alt="Profile Photo">
                        @else
                            <i class="fas fa-user"></i>
                        @endif
                    </div>
                </div>
                <div class="profile-info">
                    <h1>{{ $user->nama_lengkap }}</h1>
                    
                    <div class="profile-badges">
                        <span class="profile-badge">
                            <i class="fas fa-briefcase"></i>
                            {{ $user->jabatan ?? 'Staff' }}
                        </span>
                        <span class="profile-badge">
                            <i class="fas fa-envelope"></i>
                            {{ $user->email }}
                        </span>
                        @if($user->no_hp)
                        <span class="profile-badge">
                            <i class="fas fa-phone"></i>
                            {{ $user->no_hp }}
                        </span>
                        @endif
                    </div>
                    
                    <div class="profile-meta">
                        <span>
                            <i class="fas fa-calendar"></i>
                            Bergabung {{ $user->created_at->diffForHumans() }}
                        </span>
                        <span>
                            <i class="fas fa-clock"></i>
                            Terakhir login: {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Belum pernah' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Left Column: Personal Information -->
    <div class="col-lg-4">
        <div class="profile-card">
            <div class="card-header">
                <h3><i class="fas fa-user-circle"></i>Informasi Personal</h3>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-venus-mars"></i>
                            Jenis Kelamin
                        </div>
                        <div class="info-value">
                            {{ $user->jenis_kelamin ?? 'Tidak ditentukan' }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-map-marker-alt"></i>
                            Tempat Lahir
                        </div>
                        <div class="info-value">
                            {{ $user->tempat_lahir ?? 'Tidak diketahui' }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-birthday-cake"></i>
                            Tanggal Lahir
                        </div>
                        <div class="info-value">
                            @if($user->tanggal_lahir)
                                {{ $user->tanggal_lahir->isoFormat('D MMMM YYYY') }}
                                <small class="text-muted d-block mt-1">
                                    ({{ $user->tanggal_lahir->age }} tahun)
                                </small>
                            @else
                                Tidak diketahui
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-phone"></i>
                            No. Telepon
                        </div>
                        <div class="info-value">
                            {{ $user->no_hp ?? 'Tidak tersedia' }}
                        </div>
                    </div>
                    
                    @if($user->alamat)
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-home"></i>
                            Alamat
                        </div>
                        <div class="info-value">
                            {{ $user->alamat }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Forms -->
    <div class="col-lg-8">
        <!-- Update Profile Form -->
        <div class="profile-card">
            <div class="card-header">
                <h3><i class="fas fa-edit"></i>Edit Profil</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="nama_lengkap">
                                    <i class="fas fa-user"></i>
                                    Nama Lengkap *
                                </label>
                                <input type="text" 
                                       class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                       id="nama_lengkap" 
                                       name="nama_lengkap" 
                                       value="{{ old('nama_lengkap', $user->nama_lengkap) }}" 
                                       required>
                                @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="email">
                                    <i class="fas fa-envelope"></i>
                                    Email *
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="jenis_kelamin">
                                    <i class="fas fa-venus-mars"></i>
                                    Jenis Kelamin
                                </label>
                                <select class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                        id="jenis_kelamin" 
                                        name="jenis_kelamin">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>
                                        Laki-laki
                                    </option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>
                                        Perempuan
                                    </option>
                                </select>
                                @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="no_hp">
                                    <i class="fas fa-phone"></i>
                                    No. Telepon
                                </label>
                                <input type="text" 
                                       class="form-control @error('no_hp') is-invalid @enderror" 
                                       id="no_hp" 
                                       name="no_hp" 
                                       value="{{ old('no_hp', $user->no_hp) }}">
                                @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="tempat_lahir">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Tempat Lahir
                                </label>
                                <input type="text" 
                                       class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                       id="tempat_lahir" 
                                       name="tempat_lahir" 
                                       value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                                @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="tanggal_lahir">
                                    <i class="fas fa-calendar"></i>
                                    Tanggal Lahir
                                </label>
                                <input type="date" 
                                       class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                       id="tanggal_lahir" 
                                       name="tanggal_lahir" 
                                       value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}">
                                @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="jabatan">
                                    <i class="fas fa-briefcase"></i>
                                    Jabatan
                                </label>
                                <input type="text" 
                                       class="form-control @error('jabatan') is-invalid @enderror" 
                                       id="jabatan" 
                                       name="jabatan" 
                                       value="{{ old('jabatan', $user->jabatan) }}">
                                @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="alamat">
                                    <i class="fas fa-home"></i>
                                    Alamat
                                </label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" onclick="window.location.reload()">
                            <i class="fas fa-undo"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Profil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="profile-card">
            <div class="card-header">
                <h3><i class="fas fa-key"></i>Ubah Password</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="password-info">
                        <i class="fas fa-info-circle"></i>
                        <strong>Keamanan Password:</strong> Pastikan password Anda kuat dan unik untuk menjaga keamanan akun.
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="current_password">
                                    <i class="fas fa-lock"></i>
                                    Password Saat Ini *
                                </label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password" 
                                       required>
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="password">
                                    <i class="fas fa-key"></i>
                                    Password Baru *
                                </label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">
                                    <i class="fas fa-key"></i>
                                    Konfirmasi Password *
                                </label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sync-alt"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    console.log('✅ Profile page loaded');
    
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Add animation to form inputs on focus
    $('.form-control, .form-select').on('focus', function() {
        $(this).parent().addClass('input-focused');
    }).on('blur', function() {
        $(this).parent().removeClass('input-focused');
    });
    
    // Password strength indicator (optional enhancement)
    $('#password').on('input', function() {
        const password = $(this).val();
        const strength = checkPasswordStrength(password);
        updateStrengthIndicator(strength);
    });
});

// Function to check password strength (basic example)
function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength += 1;
    if (/[A-Z]/.test(password)) strength += 1;
    if (/[a-z]/.test(password)) strength += 1;
    if (/[0-9]/.test(password)) strength += 1;
    if (/[^A-Za-z0-9]/.test(password)) strength += 1;
    
    return strength;
}

// Function to update strength indicator (optional)
function updateStrengthIndicator(strength) {
    const indicator = $('#password-strength');
    if (!indicator.length) return;
    
    const colors = ['#dc2626', '#ea580c', '#f59e0b', '#10b981'];
    const messages = ['Sangat Lemah', 'Lemah', 'Cukup', 'Kuat'];
    
    indicator.css('width', (strength * 20) + '%');
    indicator.css('background-color', colors[strength - 1] || '#dc2626');
    indicator.text(messages[strength - 1] || 'Sangat Lemah');
}
</script>
@endpush