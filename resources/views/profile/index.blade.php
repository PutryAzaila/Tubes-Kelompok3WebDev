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
    --danger: #ef4444;
    --gray-50: #f8fafc;
    --gray-100: #f1f5f9;
    --gray-200: #e2e8f0;
    --gray-300: #cbd5e1;
    --gray-600: #475569;
    --gray-700: #334155;
    --gray-800: #1e293b;
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
}

body {
    background-color: var(--gray-50);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
}

/* ===== ENHANCED PROFILE HEADER CARD ===== */
.profile-header-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 20px;
    padding: 2.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    border: 1px solid var(--gray-200);
    position: relative;
    overflow: hidden;
}

/* Decorative background pattern */
.profile-header-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(37, 99, 235, 0.05) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.profile-header-content {
    display: flex;
    align-items: center;
    gap: 2.5rem;
    position: relative;
    z-index: 1;
}

/* Enhanced Avatar with Initials */
.profile-avatar {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.3);
    position: relative;
    transition: transform 0.3s ease;
    overflow: hidden;
}

.profile-avatar:hover {
    transform: scale(1.05);
}

/* Avatar ring animation */
.profile-avatar::after {
    content: '';
    position: absolute;
    inset: -4px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    opacity: 0.2;
    z-index: -1;
}

/* Initials styling */
.profile-avatar-initials {
    font-size: 2.5rem;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 2px;
    user-select: none;
}

/* If image exists */
.profile-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
}

/* Alternative gradient colors for variety */
.profile-avatar.gradient-1 {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.profile-avatar.gradient-2 {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.profile-avatar.gradient-3 {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.profile-avatar.gradient-4 {
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
}

.profile-avatar.gradient-5 {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

/* Enhanced Profile Info */
.profile-info {
    flex: 1;
}

.profile-info h1 {
    color: var(--gray-800);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.75rem;
    line-height: 1.2;
    background: linear-gradient(135deg, var(--gray-800) 0%, var(--gray-600) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Enhanced Meta Items */
.profile-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 2rem;
    margin-top: 1rem;
}

.profile-meta-item {
    display: flex;
    align-items: center;
    gap: 0.625rem;
    padding: 0.5rem 0.75rem;
    background: white;
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
}

.profile-meta-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);
}

.profile-meta-item i {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-light) 0%, #bfdbfe 100%);
    color: var(--primary);
    border-radius: 8px;
    font-size: 1rem;
    flex-shrink: 0;
}

.profile-meta-item span {
    color: var(--gray-700);
    font-size: 0.9375rem;
    font-weight: 500;
}

/* Badge for position */
.profile-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 1rem;
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    border-radius: 20px;
    font-size: 0.8125rem;
    font-weight: 600;
    margin-top: 0.5rem;
    box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
}

.profile-badge i {
    font-size: 0.875rem;
}

/* Alternative: Card Style with Stats */
.profile-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gray-200);
}

.profile-stat-item {
    text-align: center;
    padding: 1rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease;
}

.profile-stat-item:hover {
    transform: translateY(-3px);
}

.profile-stat-icon {
    width: 48px;
    height: 48px;
    margin: 0 auto 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary-light) 0%, #bfdbfe 100%);
    border-radius: 12px;
    color: var(--primary);
    font-size: 1.25rem;
}

.profile-stat-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.profile-stat-label {
    font-size: 0.8125rem;
    color: var(--gray-600);
    font-weight: 500;
}

/* ===== RESPONSIVE ENHANCEMENTS ===== */
@media (max-width: 991px) {
    .profile-header-card {
        padding: 2rem;
    }
    
    .profile-header-content {
        gap: 2rem;
    }
    
    .profile-avatar {
        width: 90px;
        height: 90px;
    }
    
    .profile-avatar i {
        font-size: 2.25rem;
    }
    
    .profile-info h1 {
        font-size: 1.625rem;
    }
    
    .profile-meta {
        gap: 1rem;
    }
}

@media (max-width: 767px) {
    .profile-header-card {
        padding: 1.5rem;
    }
    
    .profile-header-card::before {
        width: 300px;
        height: 300px;
    }
    
    .profile-header-content {
        flex-direction: column;
        text-align: center;
        gap: 1.5rem;
    }
    
    .profile-info h1 {
        font-size: 1.5rem;
    }
    
    .profile-meta {
        justify-content: center;
        gap: 0.75rem;
    }
    
    .profile-meta-item {
        padding: 0.5rem;
    }
    
    .profile-meta-item i {
        width: 32px;
        height: 32px;
        font-size: 0.875rem;
    }
    
    .profile-meta-item span {
        font-size: 0.875rem;
    }
    
    .profile-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

/* ===== ALERTS ===== */
.alert-modern {
    border: none;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    border-left: 4px solid;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.alert-success {
    background-color: #f0fdf4;
    border-left-color: var(--success);
    color: #065f46;
}

.alert-danger {
    background-color: #fef2f2;
    border-left-color: var(--danger);
    color: #991b1b;
}

.alert-modern i {
    font-size: 1.125rem;
    flex-shrink: 0;
    margin-top: 0.125rem;
}

.alert-modern ul {
    margin: 0.5rem 0 0 0;
    padding-left: 1.25rem;
}

/* ===== CARDS ===== */
.profile-card {
    background: white;
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
    border: 1px solid var(--gray-200);
    margin-bottom: 1.5rem;
    overflow: hidden;
}

.card-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    background: var(--gray-50);
}

.card-header h3 {
    color: var(--gray-800);
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.625rem;
}

.card-header h3 i {
    color: var(--primary);
    font-size: 1.125rem;
}

.card-body {
    padding: 1.5rem;
}

/* ===== READ ONLY FIELDS ===== */
.info-section {
    background: var(--gray-50);
    border-radius: 12px;
    padding: 1.25rem;
    margin-bottom: 1.5rem;
    border: 1px solid var(--gray-200);
}

.info-section-title {
    color: var(--gray-700);
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-row {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.info-field {
    display: flex;
    flex-direction: column;
    gap: 0.375rem;
}

.info-field-label {
    color: var(--gray-600);
    font-size: 0.875rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.info-field-label i {
    color: var(--primary);
    font-size: 0.75rem;
    width: 14px;
}

.info-field-value {
    color: var(--gray-800);
    font-size: 0.9375rem;
    font-weight: 500;
}

/* ===== FORMS ===== */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.form-label i {
    color: var(--primary);
    font-size: 0.875rem;
    width: 14px;
}

.form-label .required {
    color: var(--danger);
}

.form-control, .form-select {
    border: 1px solid var(--gray-300);
    border-radius: 10px;
    padding: 0.625rem 0.875rem;
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
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.invalid-feedback {
    color: var(--danger);
    font-size: 0.8125rem;
    margin-top: 0.375rem;
    display: flex;
    align-items: center;
    gap: 0.375rem;
}

.invalid-feedback::before {
    content: '⚠';
    font-size: 0.875rem;
}

/* ===== BUTTONS ===== */
.btn {
    padding: 0.625rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9375rem;
    border: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    cursor: pointer;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: white;
    box-shadow: var(--shadow-sm);
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--primary-dark) 0%, #1e3a8a 100%);
    transform: translateY(-1px);
    box-shadow: var(--shadow-md);
    color: white;
}

.btn-secondary {
    background: white;
    color: var(--gray-700);
    border: 1px solid var(--gray-300);
}

.btn-secondary:hover {
    background: var(--gray-50);
    border-color: var(--gray-600);
    color: var(--gray-800);
}

.btn-group {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid var(--gray-200);
}

/* ===== PASSWORD INFO ===== */
.password-info {
    background: var(--primary-light);
    border-radius: 10px;
    padding: 0.875rem 1rem;
    margin-bottom: 1.25rem;
    border: 1px solid rgba(37, 99, 235, 0.2);
    font-size: 0.875rem;
    color: var(--primary-dark);
    display: flex;
    align-items: flex-start;
    gap: 0.625rem;
}

.password-info i {
    color: var(--primary);
    margin-top: 0.125rem;
    flex-shrink: 0;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 991px) {
    .profile-header-content {
        gap: 1.5rem;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
    }
    
    .profile-avatar i {
        font-size: 2rem;
    }
    
    .profile-info h1 {
        font-size: 1.5rem;
    }
}

@media (max-width: 767px) {
    .profile-header-card {
        padding: 1.5rem;
    }
    
    .profile-header-content {
        flex-direction: column;
        text-align: center;
    }
    
    .profile-meta {
        justify-content: center;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
    
    .info-row {
        grid-template-columns: 1fr;
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
                <ul>
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
        <div class="profile-header-card">
            <div class="profile-header-content">
                <div class="profile-avatar {{ 'gradient-' . (ord(substr($user->nama_lengkap, 0, 1)) % 5 + 1) }}">
                    @if($user->photo_path && file_exists(public_path('storage/' . $user->photo_path)))
                        <img src="{{ asset('storage/' . $user->photo_path) }}" alt="Profile Photo">
                    @else
                        @php
                            // Ambil inisial dari nama
                            $nameParts = explode(' ', $user->nama_lengkap);
                            $initials = '';
                            
                            if (count($nameParts) >= 2) {
                                // Jika nama ada 2 kata atau lebih, ambil huruf pertama dari 2 kata pertama
                                $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                            } else {
                                // Jika hanya 1 kata, ambil 2 huruf pertama
                                $initials = strtoupper(substr($user->nama_lengkap, 0, 2));
                            }
                        @endphp
                        <div class="profile-avatar-initials">{{ $initials }}</div>
                    @endif
                </div>
                <div class="profile-info">
                    <h1>{{ $user->nama_lengkap }}</h1>
                    <div class="profile-meta">
                        <div class="profile-meta-item">
                            <i class="fas fa-briefcase"></i>
                            <span>{{ $user->jabatan ?? 'Staff' }}</span>
                        </div>
                        <div class="profile-meta-item">
                            <i class="fas fa-envelope"></i>
                            <span>{{ $user->email }}</span>
                        </div>
                        @if($user->no_hp)
                        <div class="profile-meta-item">
                            <i class="fas fa-phone"></i>
                            <span>{{ $user->no_hp }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Update Profile Form -->
        <div class="profile-card">
            <div class="card-header">
                <h3><i class="fas fa-edit"></i>Edit Informasi Profil</h3>
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
                                    Nama Lengkap
                                    <span class="required">*</span>
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
                                    Email
                                    <span class="required">*</span>
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
                                       value="{{ old('no_hp', $user->no_hp) }}"
                                       placeholder="08xxxxxxxxxx">
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
                                       value="{{ old('tempat_lahir', $user->tempat_lahir) }}"
                                       placeholder="Kota kelahiran">
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
                        
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="alamat">
                                    <i class="fas fa-home"></i>
                                    Alamat Lengkap
                                </label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" 
                                          id="alamat" 
                                          name="alamat" 
                                          rows="3"
                                          placeholder="Alamat lengkap tempat tinggal">{{ old('alamat', $user->alamat) }}</textarea>
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
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="profile-card">
            <div class="card-header">
                <h3><i class="fas fa-shield-alt"></i>Keamanan Akun</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.password.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="password-info">
                        <i class="fas fa-info-circle"></i>
                        <span>
                            Gunakan password yang kuat dengan kombinasi huruf besar, huruf kecil, angka, dan simbol untuk keamanan maksimal.
                        </span>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="current_password">
                                    <i class="fas fa-lock"></i>
                                    Password Saat Ini
                                    <span class="required">*</span>
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
                                    Password Baru
                                    <span class="required">*</span>
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
                                    <i class="fas fa-check-double"></i>
                                    Konfirmasi Password Baru
                                    <span class="required">*</span>
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
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Form animation on focus
    $('.form-control, .form-select').on('focus', function() {
        $(this).parent().addClass('input-focused');
    }).on('blur', function() {
        $(this).parent().removeClass('input-focused');
    });
});
</script>
@endpush