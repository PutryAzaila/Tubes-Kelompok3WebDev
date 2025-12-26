@extends('layouts.dashboard')

@section('title', 'Edit Profil')
@section('page-title', 'Edit Profil')
@section('page-subtitle', 'Perbarui informasi profil dan kata sandi Anda')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
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

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.required-label::after {
    content: ' *';
    color: #dc2626;
}

.form-control {
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    padding: 0.625rem 1rem;
    transition: all 0.2s ease;
}

.form-control:focus {
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

.btn-submit-warning {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    border: none;
    padding: 0.625rem 2rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-submit-warning:hover {
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

.alert-custom {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.25rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    margin-bottom: 1.5rem;
}

.alert-success {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
}

.alert-danger {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
}

.password-toggle-btn {
    border-radius: 0 8px 8px 0;
    border-left: 1px solid #e5e7eb;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: flex-start;
    flex-wrap: wrap;
    padding-top: 1rem;
}

.info-card {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
}

.info-card h6 {
    color: #1e40af;
    font-weight: 600;
    margin-bottom: 1rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 0.75rem;
}

.info-item i {
    color: #3b82f6;
    margin-top: 0.125rem;
    margin-right: 0.75rem;
}

.info-item span {
    color: #4b5563;
    font-size: 0.875rem;
}

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
                        <a href="{{ route('profile.index') }}">
                            <i class="fas fa-user me-1"></i>Profil
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Edit Profil</li>
                </ol>
            </nav>
            <h4><i class="fas fa-user-edit me-2"></i>Edit Profil Pengguna</h4>
            <p>Perbarui informasi profil dan kata sandi Anda</p>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="col-12">
        <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    @if($errors->any())
    <div class="col-12">
        <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            Terdapat kesalahan dalam pengisian form. Silakan periksa kembali.
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif

    <!-- Edit Profile Information -->
    <div class="col-12 col-lg-8">
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-user-edit me-2"></i>Edit Informasi Profil</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Full Name -->
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label required-label">Nama Lengkap</label>
                            <input 
                                type="text" 
                                class="form-control @error('nama_lengkap') is-invalid @enderror" 
                                id="nama_lengkap" 
                                name="nama_lengkap" 
                                value="{{ old('nama_lengkap', auth()->user()->nama_lengkap) }}" 
                                required
                                placeholder="Masukkan nama lengkap"
                            >
                            @error('nama_lengkap')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="email" class="form-label required-label">Email</label>
                            <input 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email', auth()->user()->email) }}" 
                                required
                                placeholder="contoh@email.com"
                            >
                            @error('email')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label">No. Handphone</label>
                            <input 
                                type="text" 
                                class="form-control @error('no_hp') is-invalid @enderror" 
                                id="no_hp" 
                                name="no_hp" 
                                value="{{ old('no_hp', auth()->user()->no_hp) }}"
                                placeholder="0812-3456-7890"
                            >
                            @error('no_hp')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select 
                                class="form-select @error('jenis_kelamin') is-invalid @enderror" 
                                id="jenis_kelamin" 
                                name="jenis_kelamin"
                            >
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', auth()->user()->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Birth Place -->
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                            <input 
                                type="text" 
                                class="form-control @error('tempat_lahir') is-invalid @enderror" 
                                id="tempat_lahir" 
                                name="tempat_lahir" 
                                value="{{ old('tempat_lahir', auth()->user()->tempat_lahir) }}"
                                placeholder="Nama kota"
                            >
                            @error('tempat_lahir')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                            <input 
                                type="date" 
                                class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                id="tanggal_lahir" 
                                name="tanggal_lahir" 
                                value="{{ old(
                                    'tanggal_lahir',
                                    auth()->user()->tanggal_lahir 
                                        ? \Carbon\Carbon::parse(auth()->user()->tanggal_lahir)->format('Y-m-d') 
                                        : null
                                ) }}"                            >
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Position -->
                        <div class="col-md-6">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input 
                                type="text" 
                                class="form-control @error('jabatan') is-invalid @enderror" 
                                id="jabatan" 
                                name="jabatan" 
                                value="{{ old('jabatan', auth()->user()->jabatan) }}"
                                placeholder="Posisi/jabatan"
                            >
                            @error('jabatan')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="col-12">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea 
                                class="form-control @error('alamat') is-invalid @enderror" 
                                id="alamat" 
                                name="alamat" 
                                rows="3"
                                placeholder="Masukkan alamat lengkap"
                            >{{ old('alamat', auth()->user()->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <div class="action-buttons">
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('profile.index') }}" class="btn btn-cancel">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-lock me-2"></i>Ganti Kata Sandi</h5>
            </div>
            <div class="card-body-custom">
                <form action="{{ route('profile.password.update') }}" method="POST" id="passwordForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <!-- Current Password -->
                        <div class="col-12">
                            <label for="current_password" class="form-label required-label">Kata Sandi Saat Ini</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control @error('current_password') is-invalid @enderror" 
                                    id="current_password" 
                                    name="current_password" 
                                    required
                                    placeholder="Masukkan kata sandi saat ini"
                                >
                                <button class="btn btn-outline-secondary password-toggle-btn" type="button" onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('current_password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="col-md-6">
                            <label for="password" class="form-label required-label">Kata Sandi Baru</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control @error('password') is-invalid @enderror" 
                                    id="password" 
                                    name="password" 
                                    required
                                    placeholder="Minimal 8 karakter"
                                >
                                <button class="btn btn-outline-secondary password-toggle-btn" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <small class="form-text">
                                <i class="fas fa-info-circle me-1"></i>Minimal 8 karakter
                            </small>
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label required-label">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <input 
                                    type="password" 
                                    class="form-control @error('password_confirmation') is-invalid @enderror" 
                                    id="password_confirmation" 
                                    name="password_confirmation" 
                                    required
                                    placeholder="Ulangi kata sandi baru"
                                >
                                <button class="btn btn-outline-secondary password-toggle-btn" type="button" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @error('password_confirmation')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12">
                            <div class="action-buttons">
                                <button type="submit" class="btn btn-submit-warning">
                                    <i class="fas fa-key me-2"></i>Ganti Kata Sandi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="col-12 col-lg-4">
        <div class="info-card">
            <h6><i class="fas fa-lightbulb me-2"></i>Panduan Pengisian</h6>
            
            <div class="info-item">
                <i class="fas fa-check-circle"></i>
                <span>Isi semua field yang wajib diisi (ditandai dengan *)</span>
            </div>
            
            <div class="info-item">
                <i class="fas fa-check-circle"></i>
                <span>Pastikan email yang dimasukkan valid</span>
            </div>
            
            <div class="info-item">
                <i class="fas fa-check-circle"></i>
                <span>Format nomor handphone: 0812-3456-7890</span>
            </div>
            
            <div class="info-item">
                <i class="fas fa-check-circle"></i>
                <span>Untuk keamanan, gunakan kata sandi yang kuat</span>
            </div>
            
            <div class="info-item">
                <i class="fas fa-check-circle"></i>
                <span>Periksa kembali data sebelum disimpan</span>
            </div>

            <hr class="my-4">

            <h6><i class="fas fa-shield-alt me-2"></i>Keamanan Akun</h6>
            
            <div class="info-item">
                <i class="fas fa-lock"></i>
                <span>Jangan bagikan kata sandi kepada siapapun</span>
            </div>
            
            <div class="info-item">
                <i class="fas fa-history"></i>
                <span>Ganti kata sandi secara berkala</span>
            </div>
            
            <div class="info-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Selalu logout setelah menggunakan sistem</span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Form validation
    $('#profileForm').on('submit', function(e) {
        const namaLengkap = $('#nama_lengkap').val().trim();
        const email = $('#email').val().trim();
        
        if (namaLengkap === '' || email === '') {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Harap isi semua field yang wajib diisi!',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }
    });

    $('#passwordForm').on('submit', function(e) {
        const currentPassword = $('#current_password').val().trim();
        const newPassword = $('#password').val().trim();
        const confirmPassword = $('#password_confirmation').val().trim();
        
        if (currentPassword === '' || newPassword === '' || confirmPassword === '') {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Harap isi semua field kata sandi!',
                confirmButtonColor: '#2563eb'
            });
            return false;
        }
        
        if (newPassword.length < 8) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Kata sandi baru minimal 8 karakter!',
                confirmButtonColor: '#2563eb'
            });
            $('#password').focus();
            return false;
        }
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Konfirmasi kata sandi tidak cocok!',
                confirmButtonColor: '#2563eb'
            });
            $('#password_confirmation').focus();
            return false;
        }
    });

    // Auto dismiss alerts
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);

    // Set maximum date for birth date
    const today = new Date().toISOString().split('T')[0];
    $('#tanggal_lahir').attr('max', today);
});

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const button = field.nextElementSibling;
    const icon = button.querySelector('i');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>
@endpush