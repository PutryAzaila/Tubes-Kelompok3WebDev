@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan sistem hari ini')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* Welcome Card */
.welcome-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}

.welcome-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.welcome-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    position: relative;
    z-index: 1;
}

.welcome-title {
    font-size: 1.875rem;
    font-weight: 700;
    color: white;
    margin-bottom: 0.75rem;
}

.text-gradient {
    background: linear-gradient(135deg, #ffd89b 0%, #ffffff 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.badge-role {
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 10px;
    font-weight: 600;
}

.welcome-description {
    color: rgba(255, 255, 255, 0.95);
    margin-bottom: 0;
    font-size: 1rem;
    line-height: 1.6;
}

.welcome-illustration {
    font-size: 7rem;
    color: rgba(255, 255, 255, 0.12);
    margin-left: 2rem;
}

/* Notification Banner (Khusus Manajer) */
.notification-banner {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-left: 5px solid #f59e0b;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(245, 158, 11, 0.2);
    animation: slideInDown 0.5s ease;
}

@keyframes slideInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.notification-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1rem;
}

.notification-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.notification-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #92400e;
    margin: 0;
}

.notification-body {
    color: #78350f;
    line-height: 1.6;
}

.notification-list {
    list-style: none;
    padding: 0;
    margin: 1rem 0 0 0;
}

.notification-list li {
    background: white;
    padding: 0.875rem 1.25rem;
    border-radius: 10px;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
}

.notification-list li:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.12);
}

.notification-list li:last-child {
    margin-bottom: 0;
}

.po-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.po-code {
    background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
    color: #1e40af;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.875rem;
}

.po-details {
    color: #6b7280;
    font-size: 0.875rem;
}

.btn-review {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
    padding: 0.5rem 1.25rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-review:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
    color: white;
}

/* Stats Cards */
.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    opacity: 0.1;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 28px rgba(0,0,0,0.15);
}

.stat-card:hover::before {
    transform: scale(1.5);
}

.stat-card.stat-primary::before {
    background: #2563eb;
}

.stat-card.stat-success::before {
    background: #10b981;
}

.stat-card.stat-warning::before {
    background: #f59e0b;
}

.stat-card.stat-danger::before {
    background: #ef4444;
}

.stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
    position: relative;
    z-index: 1;
}

.stat-card.stat-primary .stat-icon-wrapper {
    background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
    color: #2563eb;
}

.stat-card.stat-success .stat-icon-wrapper {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #10b981;
}

.stat-card.stat-warning .stat-icon-wrapper {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #f59e0b;
}

.stat-card.stat-danger .stat-icon-wrapper {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #ef4444;
}

.stat-icon {
    font-size: 1.75rem;
}

.stat-label {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1f2937;
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-trend {
    font-size: 0.8125rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.stat-trend.trend-up {
    color: #10b981;
}

.stat-trend.trend-down {
    color: #ef4444;
}

/* Chart Cards */
.chart-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
    height: 100%;
}

.chart-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
    padding: 1.5rem;
    color: white;
}

.chart-title {
    font-size: 1.125rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.chart-body {
    padding: 1.75rem;
}

/* Recent Activity */
.activity-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.activity-header {
    background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%);
    padding: 1.5rem;
    color: white;
}

.activity-title {
    font-size: 1.125rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.activity-body {
    padding: 1.5rem;
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.activity-item:hover {
    background: #f9fafb;
}

.activity-item:last-child {
    margin-bottom: 0;
}

.activity-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.125rem;
}

.activity-icon.icon-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #059669;
}

.activity-icon.icon-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #dc2626;
}

.activity-icon.icon-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #d97706;
}

.activity-icon.icon-primary {
    background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
    color: #2563eb;
}

.activity-content {
    flex: 1;
}

.activity-title-text {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.activity-description {
    color: #6b7280;
    font-size: 0.875rem;
    margin-bottom: 0.25rem;
}

.activity-time {
    color: #9ca3af;
    font-size: 0.8125rem;
}

/* Low Stock Alert */
.alert-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.alert-header {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    padding: 1.5rem;
    color: white;
}

.alert-title {
    font-size: 1.125rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.alert-body {
    padding: 1.5rem;
}

.alert-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    border-radius: 12px;
    background: #fef2f2;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}

.alert-item:hover {
    background: #fee2e2;
    transform: translateX(5px);
}

.alert-item:last-child {
    margin-bottom: 0;
}

.alert-item-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-item-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #dc2626;
    font-size: 1rem;
}

.alert-item-text h6 {
    font-weight: 600;
    color: #991b1b;
    margin-bottom: 0.125rem;
    font-size: 0.9375rem;
}

.alert-item-text p {
    color: #7f1d1d;
    font-size: 0.8125rem;
    margin: 0;
}

.alert-item-stock {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    font-weight: 700;
    font-size: 0.875rem;
}

/* Responsive */
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
    
    .stat-value {
        font-size: 2rem;
    }
}

@media (max-width: 575px) {
    .welcome-card {
        padding: 1.25rem;
    }
    
    .welcome-title {
        font-size: 1.25rem;
    }
    
    .notification-banner {
        padding: 1.25rem;
    }
}
</style>
@endpush
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
                    <p class="mb-3">
                        <span class="badge badge-role me-2">
                            <i class="fas fa-briefcase me-2"></i>
                            {{ ucfirst(Auth::user()->jabatan ?? 'Administrator') }}
                        </span>
                        <span class="text-white-50">
                            {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                        </span>
                    </p>
                    <p class="welcome-description">
                        Kelola sistem inventory dengan mudah. Monitor stok, vendor, dan purchase order secara real-time.
                    </p>
                </div>
                <div class="welcome-illustration d-none d-lg-block">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

<!-- Notification Banner (Khusus Manajer) -->
@if(Auth::check() && isset(Auth::user()->jabatan) && strtolower(trim(Auth::user()->jabatan)) === 'manajer')
    @if(isset($pendingPOs) && $pendingPOs->count() > 0)
    <div class="col-12">
        <div class="notification-banner">
            <div class="notification-header">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <div>
                    <h5 class="notification-title">
                        Pengajuan Purchase Order Menunggu Persetujuan
                    </h5>
                </div>
            </div>
            <div class="notification-body">
                <p class="mb-2">
                    <strong>{{ $pendingPOs->count() }} Purchase Order</strong> membutuhkan persetujuan Anda.
                </p>
                <ul class="notification-list">
                    @foreach($pendingPOs->take(3) as $po)
                    <li>
                        <div class="po-info">
                            <span class="po-code">PO-{{ str_pad($po->id, 3, '0', STR_PAD_LEFT) }}</span>
                            <div class="po-details">
                                <strong>{{ $po->vendor->nama_vendor ?? 'N/A' }}</strong>
                                <span class="mx-2">•</span>
                                <span>{{ $po->detailPO->sum('jumlah') }} Item</span>
                            </div>
                        </div>
                        <a href="{{ route('purchase-order.show', $po->id) }}" class="btn btn-review">
                            <i class="fas fa-eye me-2"></i>Review
                        </a>
                    </li>
                    @endforeach
                </ul>
                @if($pendingPOs->count() > 3)
                <div class="text-center mt-3">
                    <a href="{{ route('purchase-order.index') }}" class="btn btn-warning">
                        <i class="fas fa-list me-2"></i>Lihat Semua ({{ $pendingPOs->count() }})
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    @else
    <div class="col-12">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Tidak ada Purchase Order yang menunggu persetujuan.</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
    @endif
@endif
    <!-- ========== AKHIR KODE BARU ========== -->

    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-primary">
            <div class="stat-icon-wrapper">
                <i class="fas fa-boxes stat-icon"></i>
            </div>
            <div class="stat-label">Total Perangkat</div>
            <div class="stat-value">{{ $totalPerangkat ?? 0 }}</div>
            <div class="stat-trend trend-up">
                <i class="fas fa-arrow-up"></i>
                <span>Item tersedia</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-success">
            <div class="stat-icon-wrapper">
                <i class="fas fa-building stat-icon"></i>
            </div>
            <div class="stat-label">Total Vendor</div>
            <div class="stat-value">{{ $totalVendor ?? 0 }}</div>
            <div class="stat-trend trend-up">
                <i class="fas fa-check-circle"></i>
                <span>Vendor aktif</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-warning">
            <div class="stat-icon-wrapper">
                <i class="fas fa-file-invoice stat-icon"></i>
            </div>
            <div class="stat-label">PO Bulan Ini</div>
            <div class="stat-value">{{ $poThisMonth ?? 0 }}</div>
            <div class="stat-trend trend-up">
                <i class="fas fa-calendar"></i>
                <span>{{ \Carbon\Carbon::now()->isoFormat('MMMM') }}</span>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stat-card stat-danger">
            <div class="stat-icon-wrapper">
                <i class="fas fa-exclamation-triangle stat-icon"></i>
            </div>
            <div class="stat-label">Stok Rendah</div>
            <div class="stat-value">{{ $lowStockCount ?? 0 }}</div>
            <div class="stat-trend trend-down">
                <i class="fas fa-arrow-down"></i>
                <span>Perlu restock</span>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="col-lg-8">
        <div class="chart-card">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="fas fa-chart-bar"></i>
                    Statistik Purchase Order (6 Bulan Terakhir)
                </h5>
            </div>
            <div class="chart-body">
                <canvas id="poChart" height="80"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="chart-card">
            <div class="chart-header">
                <h5 class="chart-title">
                    <i class="fas fa-chart-pie"></i>
                    Status Purchase Order
                </h5>
            </div>
            <div class="chart-body">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Low Stock -->
    <div class="col-lg-8">
        <div class="activity-card">
            <div class="activity-header">
                <h5 class="activity-title">
                    <i class="fas fa-history"></i>
                    Aktivitas Terbaru
                </h5>
            </div>
            <div class="activity-body">
                @forelse($recentActivities ?? [] as $activity)
                <div class="activity-item">
                    <div class="activity-icon icon-{{ $activity['type'] ?? 'primary' }}">
                        <i class="fas fa-{{ $activity['icon'] ?? 'circle' }}"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-title-text">{{ $activity['title'] }}</div>
                        <div class="activity-description">{{ $activity['description'] }}</div>
                        <div class="activity-time">
                            <i class="fas fa-clock me-1"></i>{{ $activity['time'] }}
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                    <p class="text-muted">Belum ada aktivitas</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="alert-card">
            <div class="alert-header">
                <h5 class="alert-title">
                    <i class="fas fa-exclamation-circle"></i>
                    Stok Rendah
                </h5>
            </div>
            <div class="alert-body">
                @forelse($lowStockItems ?? [] as $item)
                <div class="alert-item">
                    <div class="alert-item-info">
                        <div class="alert-item-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="alert-item-text">
                            <h6>{{ $item->nama_perangkat }}</h6>
                            <p>{{ $item->tipe ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="alert-item-stock">
                        {{ $item->stok }} Unit
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-check-circle fa-3x text-success mb-3" style="opacity: 0.3;"></i>
                    <p class="text-muted">Semua stok aman</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
$(document).ready(function() {
    console.log('✅ Dashboard loaded!');

    // Chart colors
    const colors = {
        primary: '#2563eb',
        success: '#10b981',
        warning: '#f59e0b',
        danger: '#ef4444',
        purple: '#7c3aed',
    };

    // PO Chart (Bar Chart)
    const poCtx = document.getElementById('poChart');
    if (poCtx) {
        new Chart(poCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($poChartLabels ?? ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun']) !!},
                datasets: [{
                    label: 'Diajukan',
                    data: {!! json_encode($poDiajukan ?? [5, 8, 3, 7, 4, 6]) !!},
                    backgroundColor: colors.warning,
                    borderRadius: 8,
                },
                {
                    label: 'Disetujui',
                    data: {!! json_encode($poDisetujui ?? [4, 6, 2, 5, 3, 5]) !!},
                    backgroundColor: colors.success,
                    borderRadius: 8,
                },
                {
                    label: 'Ditolak',
                    data: {!! json_encode($poDitolak ?? [1, 2, 1, 2, 1, 1]) !!},
                    backgroundColor: colors.danger,
                    borderRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        },
                        grid: {
                            drawBorder: false,
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Status Chart (Doughnut Chart)
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Diajukan', 'Disetujui', 'Ditolak'],
                datasets: [{
                    data: {!! json_encode([$statusDiajukan ?? 12, $statusDisetujui ?? 25, $statusDitolak ?? 5]) !!},
                    backgroundColor: [colors.warning, colors.success, colors.danger],
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }
});
</script>
@endpush