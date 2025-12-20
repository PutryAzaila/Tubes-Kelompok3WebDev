<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Transdata Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --transdata-blue: #1e3a8a;
            --transdata-orange: #f97316;
            --transdata-gray: #6b7280;
        }

        @keyframes float {
            0%, 100% { 
                transform: translate(0, 0) scale(1); 
            }
            50% { 
                transform: translate(-30px, -30px) scale(1.1); 
            }
        }

        @keyframes slideIn {
            from { 
                opacity: 0; 
                transform: translateY(-40px) scale(0.95); 
            }
            to { 
                opacity: 1; 
                transform: translateY(0) scale(1); 
            }
        }

        @keyframes slideInRight {
            from { 
                transform: translateX(400px); 
                opacity: 0; 
            }
            to { 
                transform: translateX(0); 
                opacity: 1; 
            }
        }

        @keyframes fadeOut {
            to { 
                opacity: 0; 
                transform: translateX(400px); 
            }
        }

        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        body {
            min-height: 100vh;
            height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        .bg-circle-1 {
            position: fixed;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            top: -300px;
            right: -200px;
            animation: float 8s ease-in-out infinite;
            pointer-events: none;
            z-index: 1;
        }

        .bg-circle-2 {
            position: fixed;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(30, 58, 138, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            bottom: -250px;
            left: -150px;
            animation: float 10s ease-in-out infinite reverse;
            pointer-events: none;
            z-index: 1;
        }

        .login-container {
            position: relative;
            z-index: 10;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            padding: 2.25rem;
            width: 100%;
            max-width: 500px;
            animation: slideIn 0.6s ease-out;
        }

        .logo-img {
            max-width: 170px;
            height: auto;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.1));
        }

        .badge-system {
            display: inline-block;
            margin-top: 0.5rem;
            padding: 0.375rem 0.875rem;
            background: linear-gradient(to right, #1e3a8a, #2563eb);
            color: white !important;
            border-radius: 50px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .title-welcome {
            color: #1e3a8a;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 0.25rem;
            margin-top: 0.75rem;
        }

        .subtitle {
            color: #64748b;
            font-size: 12px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 1.125rem 0;
        }

        .form-label {
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 0.375rem;
            font-size: 12px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom .form-control {
            padding: 0.75rem 0.875rem 0.75rem 2.625rem;
            border: 2px solid #e2e8f0;
            border-radius: 0.75rem;
            font-size: 13px;
            background-color: #f8fafc;
            color: #0f172a;
            transition: all 0.3s ease;
        }

        .input-group-custom .form-control::placeholder {
            color: #94a3b8;
        }

        .input-group-custom .form-control:focus {
            outline: none;
            border-color: #1e3a8a !important;
            background-color: white;
            box-shadow: 0 0 0 4px rgba(3, 88, 234, 0.1) !important;
        }

        .input-group-custom .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 14px;
            z-index: 5;
            pointer-events: none;
            transition: color 0.3s ease;
        }

        .input-group-custom .form-control:focus ~ .input-icon {
            color: #1e3a8a !important;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #1e3a8a, #2563eb)!important;
            color: white !important;
            border: none !important;
            border-radius: 0.75rem;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 10px 15px -3px rgba(6, 6, 108, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .btn-login:hover:not(:disabled) {
            background: linear-gradient(to right, #1e3a8a, #2563eb)!important;
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(71, 22, 249, 0.4);
        }

        .btn-login:active:not(:disabled) {
            transform: translateY(0);
        }

        .btn-login:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        .footer-text {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
            color: #94a3b8;
            font-size: 11px;
        }

        /* Toast Notification Styles */
        .toast-container-custom {
            position: fixed;
            top: 1.25rem;
            right: 1.25rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 0.625rem;
        }

        .toast-custom {
            min-width: 300px;
            max-width: 400px;
            padding: 0.875rem;
            border-radius: 0.75rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: slideInRight 0.4s ease-out, fadeOut 0.4s ease-in 4.6s forwards;
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .toast-custom.toast-success {
            background: linear-gradient(to right, #16a34a, #15803d);
            color: white;
        }

        .toast-custom.toast-error {
            background: linear-gradient(to right, #dc2626, #b91c1c);
            color: white;
        }

        .toast-custom.toast-warning {
            background: linear-gradient(to right, #ca8a04, #a16207);
            color: white;
        }

        .toast-custom.toast-info {
            background: linear-gradient(to right, #2563eb, #1d4ed8);
            color: white;
        }

        .toast-icon {
            font-size: 1.25rem;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .toast-content {
            flex: 1;
        }

        .toast-title {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .toast-message {
            font-size: 0.75rem;
            opacity: 0.95;
            line-height: 1.5;
        }

        .toast-close {
            width: 1.5rem;
            height: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            background: transparent;
            border: none;
            color: white;
            cursor: pointer;
            transition: background-color 0.2s;
            flex-shrink: 0;
        }

        .toast-close:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 0.75rem 0.75rem;
            animation: progress 5s linear forwards;
        }

        @media (max-width: 576px) {
            body {
                padding: 1rem;
            }

            .login-container {
                padding: 1.5rem;
            }

            .logo-img {
                max-width: 150px;
            }

            .badge-system {
                font-size: 9px;
                padding: 0.25rem 0.75rem;
            }

            .title-welcome {
                font-size: 20px;
            }

            .toast-container-custom {
                left: 0.625rem;
                right: 0.625rem;
            }

            .toast-custom {
                min-width: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    
    <!-- Animated Background Circles -->
    <div class="bg-circle-1"></div>
    <div class="bg-circle-2"></div>

    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container-custom"></div>

    <!-- Login Container -->
    <div class="login-container">
        
        <!-- Logo Section -->
        <div class="text-center mb-1">
            <img src="/images/transdata-logo.png" alt="PT Transdata Logo" class="logo-img mx-auto">
            <div>
                <span class="badge-system">
                    INVENTORY MANAGEMENT SYSTEM
                </span>
            </div>
            <h1 class="title-welcome">Selamat Datang</h1>
            <p class="subtitle mb-0">Silakan login untuk melanjutkan</p>
        </div>

        <!-- Divider -->
        <div class="divider"></div>
        
        <!-- Hidden Messages for Toast (Laravel Blade) -->
        <div style="display: none;">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <span data-validation-error="{{ $error }}"></span>
                @endforeach
            @endif

            @if (session('error'))
                <span data-error="{{ session('error') }}"></span>
            @endif

            @if (session('success'))
                <span data-success="{{ session('success') }}"></span>
            @endif
        </div>
       
        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf
            
            <!-- Email Field -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <div class="input-group-custom">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-control"
                        placeholder="nama@example.com"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                    <i class="bi bi-envelope input-icon"></i>
                </div>
            </div>

            <!-- Password Field -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <div class="input-group-custom">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control"
                        placeholder="Masukkan password Anda"
                        required
                    >
                    <i class="bi bi-lock input-icon"></i>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-login" id="loginBtn">
                <div class="spinner" id="spinner"></div>
                <i class="bi bi-box-arrow-in-right" id="btnIcon"></i>
                <span id="btnText">Masuk ke Sistem</span>
            </button>
        </form>

        <!-- Footer -->
        <p class="footer-text mb-0">
            © 2024 PT Transdata. All rights reserved.
        </p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toast Notification Function
        function showToast(type, title, message) {
            const container = document.getElementById('toastContainer');
            
            const icons = {
                success: 'bi-check-circle-fill',
                error: 'bi-exclamation-circle-fill',
                warning: 'bi-exclamation-triangle-fill',
                info: 'bi-info-circle-fill'
            };

            const toast = document.createElement('div');
            toast.className = `toast-custom toast-${type}`;
            toast.innerHTML = `
                <i class="bi ${icons[type]} toast-icon"></i>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
                <button class="toast-close" onclick="this.parentElement.remove()">
                    <i class="bi bi-x-lg"></i>
                </button>
                <div class="toast-progress"></div>
            `;
            
            container.appendChild(toast);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.remove();
                }
            }, 5000);
        }

        // Form Submission Handler
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            const spinner = document.getElementById('spinner');
            const btnIcon = document.getElementById('btnIcon');
            const btnText = document.getElementById('btnText');
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value;

            // Validations
            if (!email || !password) {
                e.preventDefault();
                showToast('warning', 'Perhatian!', 'Email dan password harus diisi.');
                return;
            }

            if (!email.includes('@')) {
                e.preventDefault();
                showToast('error', 'Format Email Salah', 'Silakan masukkan alamat email yang valid.');
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                showToast('warning', 'Password Terlalu Pendek', 'Password minimal 6 karakter.');
                return;
            }

            // Show loading - form akan submit secara normal
            loginBtn.disabled = true;
            spinner.style.display = 'block';
            btnIcon.style.display = 'none';
            btnText.textContent = 'Memproses...';
            showToast('info', 'Memproses...', 'Mohon tunggu, sedang memverifikasi login Anda.');
            
            // Form akan submit otomatis ke Laravel
        });

        // Show Server Messages on Page Load (for Laravel)
        window.addEventListener('DOMContentLoaded', function() {
            // Success messages
            const successEl = document.querySelector('[data-success]');
            if (successEl) {
                showToast('success', 'Berhasil!', successEl.dataset.success);
            }

            // Error messages
            const errorEl = document.querySelector('[data-error]');
            if (errorEl) {
                showToast('error', 'Login Gagal!', errorEl.dataset.error);
            }

            // Validation errors
            document.querySelectorAll('[data-validation-error]').forEach(el => {
                showToast('error', 'Validasi Error', el.dataset.validationError);
            });
        });

        // Reset Loading State on Back Button
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                const loginBtn = document.getElementById('loginBtn');
                const spinner = document.getElementById('spinner');
                const btnIcon = document.getElementById('btnIcon');
                const btnText = document.getElementById('btnText');
                
                loginBtn.disabled = false;
                spinner.style.display = 'none';
                btnIcon.style.display = 'block';
                btnText.textContent = 'Masuk ke Sistem';
            }
        });
    </script>
</body>
</html>