@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', content: 'Ringkasan sistem hari ini')

@section('content')
<div class="row g-3 g-lg-4">
    
    <!-- Welcome Card -->
    <div class="col-12">
        <div class="welcome-card">
            <div class="welcome-content">
                <div class="welcome-text">
                    <h2 class="welcome-title">
                        Selamat Datang, <span class="text-gradient">{{ Auth::user()->nama_lengkap ?? 'Admin' }}</span> 👋
                    </h2>
                    <p class="welcome-subtitle">
                        <span class="badge bg-gradient-primary me-2">
                            <i class="fas fa-briefcase me-1"></i>
                            {{ Auth::user()->jabatan ?? 'Administrator' }}
                        </span>
                        <span class="text-muted">
                            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                        </span>
                    </p>
                    <p class="welcome-description">
                        Selamat datang di sistem inventory. Kelola data perangkat, vendor, dan purchase order dengan mudah.
                    </p>
                </div>
                <div class="welcome-illustration d-none d-lg-block">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.welcome-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
    margin-top: 30px;
    margin-bottom: 0;
}

.welcome-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.welcome-text {
    flex: 1;
}

.welcome-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.75rem;
}

.text-gradient {
    background: linear-gradient(135deg, #ffd89b 0%, #ffffff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.welcome-subtitle {
    margin-bottom: 0.75rem;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.1) 100%);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.375rem 0.875rem;
    border-radius: 8px;
    font-weight: 500;
}

.welcome-subtitle .text-muted {
    color: rgba(255, 255, 255, 0.8) !important;
}

.welcome-description {
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 0;
    font-size: 0.9375rem;
    line-height: 1.6;
}

.welcome-illustration {
    font-size: 6rem;
    color: rgba(255, 255, 255, 0.15);
    margin-left: 2rem;
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 991px) {
    .welcome-card {
        padding: 1.5rem;
    }
    
    .welcome-title {
        font-size: 1.5rem;
    }
    
    .welcome-illustration {
        display: none;
    }
}

@media (max-width: 575px) {
    .welcome-card {
        padding: 1.25rem;
    }
    
    .welcome-title {
        font-size: 1.25rem;
    }
}
</style>
@endsection