<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT Transdata Inventory System</title>
    <link rel="icon" type="image/png" href="{{ asset('images/transdata-logo.png') }}">
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-30px, -30px) scale(1.1); }
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @keyframes slideInRight {
            from { transform: translateX(400px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes fadeOut {
            to { opacity: 0; transform: translateX(400px); }
        }
        @keyframes progress {
            from { width: 100%; }
            to { width: 0%; }
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        .animate-float { animation: float 8s ease-in-out infinite; }
        .animate-float-reverse { animation: float 10s ease-in-out infinite reverse; }
        .animate-slide-in { animation: slideIn 0.6s ease-out; }
        .animate-toast-in { animation: slideInRight 0.4s ease-out, fadeOut 0.4s ease-in 4.6s forwards; }
        .animate-progress { animation: progress 5s linear forwards; }
        .animate-spin { animation: spin 0.6s linear infinite; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-900 via-blue-600 to-orange-500 relative overflow-hidden p-5">
    
    <!-- Animated Background Circles -->
    <div class="absolute w-[600px] h-[600px] bg-gradient-radial from-orange-500/15 to-transparent rounded-full -top-[300px] -right-[200px] animate-float"></div>
    <div class="absolute w-[500px] h-[500px] bg-gradient-radial from-blue-900/15 to-transparent rounded-full -bottom-[250px] -left-[150px] animate-float-reverse"></div>

    <!-- Toast Container -->
    <div id="toastContainer" class="fixed top-5 right-5 z-[9999] flex flex-col gap-2.5 max-sm:left-2.5 max-sm:right-2.5"></div>

    <!-- Login Container -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-[450px] relative z-10 animate-slide-in p-9 max-sm:p-6">
        
        <!-- Logo Section -->
        <div class="text-center mb-1">
            <img src="{{ asset('images/transdata-logo.png') }}" alt="PT Transdata Logo" class="max-w-[170px] h-auto mx-auto drop-shadow-lg max-sm:max-w-[150px]">
            <span class="inline-block mt-0 px-3.5 py-1.5 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-full text-[10px] font-semibold tracking-wide max-sm:text-[9px] max-sm:px-3 max-sm:py-1">
                INVENTORY MANAGEMENT SYSTEM
            </span>
            <h1 class="text-blue-900 text-[22px] font-bold mb-1 mt-1.5 max-sm:text-xl">Selamat Datang</h1>
            <p class="text-slate-500 text-xs">Silakan login untuk melanjutkan</p>
        </div>

        <!-- Divider -->
        <div class="h-px bg-gradient-to-r from-transparent via-slate-200 to-transparent my-4.5"></div>

        <!-- Hidden Messages for Toast -->
        <div class="hidden">
            @if (session('error'))
                <span data-error="{{ session('error') }}"></span>
            @endif
            @if (session('success'))
                <span data-success="{{ session('success') }}"></span>
            @endif
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <span data-validation-error="{{ $error }}"></span>
                @endforeach
            @endif
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ url('/login') }}" id="loginForm">
            @csrf
            
            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-slate-700 font-semibold mb-1.5 text-xs">Email</label>
                <div class="relative">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="w-full py-3 px-3.5 pl-[42px] border-2 border-slate-200 rounded-xl text-[13px] transition-all bg-slate-50 text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/10 placeholder:text-slate-400"
                        placeholder="nama@gmail.com"
                        value="{{ old('email') }}"
                        required 
                        autofocus
                    >
                    <i class="fas fa-envelope absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm peer-focus:text-blue-600 transition-colors"></i>
                </div>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-slate-700 font-semibold mb-1.5 text-xs">Password</label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="w-full py-3 px-3.5 pl-[42px] border-2 border-slate-200 rounded-xl text-[13px] transition-all bg-slate-50 text-slate-900 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-4 focus:ring-blue-600/10 placeholder:text-slate-400"
                        placeholder="Masukkan password Anda"
                        required
                    >
                    <i class="fas fa-lock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm transition-colors"></i>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="loginBtn" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-lg text-sm font-semibold cursor-pointer transition-all shadow-lg shadow-blue-600/30 hover:from-blue-800 hover:to-blue-900 hover:-translate-y-0.5 hover:shadow-xl hover:shadow-blue-600/40 active:translate-y-0 flex items-center justify-center gap-1.5 disabled:opacity-70 disabled:pointer-events-none">
                <div class="hidden w-4 h-4 border-2 border-white/30 border-t-white rounded-full animate-spin" id="spinner"></div>
                <i class="fas fa-sign-in-alt" id="btnIcon"></i>
                <span id="btnText">Masuk ke Sistem</span>
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center mt-8 pt-4 border-t border-slate-200 text-slate-400 text-[11px]">
            © 2024 PT Transdata. All rights reserved.
        </p>
    </div>

    <script>
        // Toast Notification Function
        function showToast(type, title, message) {
            const container = document.getElementById('toastContainer');
            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                warning: 'fa-exclamation-triangle',
                info: 'fa-info-circle'
            };
            const colors = {
                success: 'from-green-600 to-green-700',
                error: 'from-red-600 to-red-700',
                warning: 'from-yellow-600 to-yellow-700',
                info: 'from-blue-600 to-blue-700'
            };

            const toast = document.createElement('div');
            toast.className = `min-w-[300px] max-w-[400px] p-3.5 rounded-xl shadow-2xl flex items-start gap-3 animate-toast-in backdrop-blur-lg relative bg-gradient-to-r ${colors[type]} text-white max-sm:min-w-0 max-sm:w-full`;
            toast.innerHTML = `
                <i class="fas ${icons[type]} text-xl mt-0.5 flex-shrink-0"></i>
                <div class="flex-1">
                    <div class="font-semibold text-sm mb-1">${title}</div>
                    <div class="text-xs opacity-95 leading-relaxed">${message}</div>
                </div>
                <button onclick="this.parentElement.remove()" class="w-6 h-6 flex items-center justify-center rounded-md hover:bg-white/20 transition-colors flex-shrink-0">
                    <i class="fas fa-times text-lg"></i>
                </button>
                <div class="absolute bottom-0 left-0 h-1 bg-white/30 rounded-b-xl animate-progress"></div>
            `;
            
            container.appendChild(toast);
            setTimeout(() => toast.remove(), 5000);
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

            // Show loading
            loginBtn.disabled = true;
            spinner.classList.remove('hidden');
            btnIcon.classList.add('hidden');
            btnText.textContent = 'Memproses...';
            showToast('info', 'Memproses...', 'Mohon tunggu, sedang memverifikasi login Anda.');
        });

        // Show Server Messages on Load
        window.addEventListener('DOMContentLoaded', function() {
            const successEl = document.querySelector('[data-success]');
            if (successEl) showToast('success', 'Berhasil!', successEl.dataset.success);

            const errorEl = document.querySelector('[data-error]');
            if (errorEl) showToast('error', 'Login Gagal!', errorEl.dataset.error);

            document.querySelectorAll('[data-validation-error]').forEach(el => {
                showToast('error', 'Validasi Error', el.dataset.validationError);
            });
        });

        // Reset Loading State on Back Button
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                const loginBtn = document.getElementById('loginBtn');
                loginBtn.disabled = false;
                document.getElementById('spinner').classList.add('hidden');
                document.getElementById('btnIcon').classList.remove('hidden');
                document.getElementById('btnText').textContent = 'Masuk ke Sistem';
            }
        });
    </script>
</body>
</html>