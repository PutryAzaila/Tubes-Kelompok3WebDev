@extends('layouts.dashboard')

@section('title', 'Detail Purchase Order')
@section('page-title', 'Detail Purchase Order')
@section('page-subtitle', 'PO-' . str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT))

@push('styles')
<style>
/* Header Card */
.detail-header-card {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 10px 30px rgba(37, 99, 235, 0.3);
    margin-bottom: 2rem;
    color: white;
}

.detail-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1.5rem;
}

.detail-header-info h2 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.detail-header-info p {
    opacity: 0.95;
    margin: 0;
    font-size: 1rem;
}

.detail-header-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.btn-header {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-header:hover {
    background: white;
    color: #2563eb;
    transform: translateY(-2px);
}

/* Status Badge Large */
.status-badge-large {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.75rem;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.125rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.15);
}

.status-badge-large i {
    font-size: 1.375rem;
}

.status-badge-large.status-warning {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    color: #92400e;
}

.status-badge-large.status-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.status-badge-large.status-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

/* Info Cards */
.info-card {
    background: white;
    border-radius: 16px;
    padding: 1.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    height: 100%;
    transition: all 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.12);
}

.info-card-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f3f4f6;
}

.info-card-icon {
    width: 50px;
    height: 50px;
    border-radius: 14px;
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.375rem;
}

.info-card-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0;
}

.info-item {
    margin-bottom: 1.25rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-label {
    font-size: 0.8125rem;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 0.375rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-size: 1.0625rem;
    color: #1f2937;
    font-weight: 600;
}

/* Table Card */
.table-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.table-card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
}

.table-card-title {
    color: white;
    font-size: 1.25rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.table-modern {
    margin: 0;
}

.table-modern thead {
    background: #f9fafb;
}

.table-modern thead th {
    border: none;
    font-weight: 600;
    font-size: 0.875rem;
    padding: 1.25rem 1.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #374151;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
    border-bottom: 1px solid #f3f4f6;
}

.table-modern tbody tr:hover {
    background: linear-gradient(90deg, #f8f9ff 0%, #ffffff 100%);
}

.table-modern tbody td {
    padding: 1.5rem;
    vertical-align: middle;
    color: #1f2937;
    font-size: 0.9375rem;
}

.table-modern tfoot {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    font-weight: 700;
}

.table-modern tfoot td {
    padding: 1.5rem;
    color: #1f2937;
    font-size: 1.125rem;
}

.item-icon {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    background: linear-gradient(135deg, #dbeafe 0%, #e0e7ff 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2563eb;
    font-size: 1.125rem;
}

.item-details h6 {
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

.item-details p {
    color: #6b7280;
    margin: 0;
    font-size: 0.875rem;
}

.quantity-badge {
    background: linear-gradient(135deg, #ddd6fe 0%, #e0e7ff 100%);
    color: #5b21b6;
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 700;
    font-size: 1rem;
}

/* Alert Custom */
.alert-custom {
    border-radius: 12px;
    border: none;
    padding: 1rem 1.5rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.alert-custom.alert-success {
    background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    color: #065f46;
}

.alert-custom.alert-danger {
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    color: #991b1b;
}

/* Modal Custom */
.modal-content {
    border-radius: 20px;
    border: none;
}

.modal-header-danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    color: white;
    border: none;
    border-radius: 20px 20px 0 0;
    padding: 1.5rem;
}

.modal-header-danger h5 {
    font-weight: 700;
    margin: 0;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    border-top: 2px solid #f3f4f6;
    padding: 1.5rem;
}

/* Responsive */
@media (max-width: 991px) {
    .detail-header-card {
        padding: 1.5rem;
    }
    
    .detail-header-content {
        flex-direction: column;
        align-items: stretch;
    }
    
    .detail-header-actions {
        width: 100%;
    }
    
    .btn-header {
        flex: 1;
    }
}

@media (max-width: 575px) {
    .detail-header-info h2 {
        font-size: 1.5rem;
    }
    
    .detail-header-actions {
        flex-direction: column;
    }
}
</style>
@endpush

@section('content')
<div class="row g-3 g-lg-4">
    
    <!-- Header Card -->
    <div class="col-12">
        <div class="detail-header-card">
            <div class="detail-header-content">
                <div class="detail-header-info">
                    <h2>
                        <i class="fas fa-file-invoice me-2"></i>
                        PO-{{ str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT) }}
                    </h2>
                    <p>{{ $purchaseOrder->vendor->nama_vendor ?? 'N/A' }} • {{ $dateInfo['value'] }}</p>
                </div>
                <div class="detail-header-actions">
                    @role('manajer')
                        @if($purchaseOrder->status === 'Diajukan')
                            <button type="button" 
                                    class="btn btn-header" 
                                    onclick="confirmApprove()">
                                <i class="fas fa-check-circle me-2"></i>Setujui
                            </button>
                            
                            <button type="button" 
                                    class="btn btn-header" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#rejectModal">
                                <i class="fas fa-times-circle me-2"></i>Tolak
                            </button>
                        @endif
                    @endrole
                    
                    @role('admin')
                        @if($purchaseOrder->status === 'Diajukan')
                            <a href="{{ route('purchase-order.edit', $purchaseOrder->id) }}" 
                               class="btn btn-header">
                                <i class="fas fa-edit me-2"></i>Edit
                            </a>
                        @endif
                    @endrole
                    
                    <a href="{{ route('purchase-order.index') }}" class="btn btn-header">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="col-12">
            <div class="alert alert-custom alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="col-12">
            <div class="alert alert-custom alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Info Cards Row -->
    <div class="col-md-6 col-lg-3">
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon">
                    <i class="fas fa-hashtag"></i>
                </div>
                <h5 class="info-card-title">Status</h5>
            </div>
            <div class="text-center">
                @if($purchaseOrder->status === 'Diajukan')
                    <span class="status-badge-large status-warning">
                        <i class="fas fa-clock"></i>
                        <span>Diajukan</span>
                    </span>
                @elseif($purchaseOrder->status === 'Disetujui')
                    <span class="status-badge-large status-success">
                        <i class="fas fa-check-circle"></i>
                        <span>Disetujui</span>
                    </span>
                @else
                    <span class="status-badge-large status-danger">
                        <i class="fas fa-times-circle"></i>
                        <span>Ditolak</span>
                    </span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon">
                    <i class="fas fa-building"></i>
                </div>
                <h5 class="info-card-title">Vendor</h5>
            </div>
            <div class="info-item">
                <div class="info-label">Nama Vendor</div>
                <div class="info-value">{{ $purchaseOrder->vendor->nama_vendor ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon">
                    <i class="fas fa-user"></i>
                </div>
                <h5 class="info-card-title">Staff</h5>
            </div>
            <div class="info-item">
                <div class="info-label">Pengaju PO</div>
                <div class="info-value">{{ $purchaseOrder->karyawan->nama_lengkap ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="info-card">
            <div class="info-card-header">
                <div class="info-card-icon">
                    <i class="fas {{ $dateInfo['icon'] }}"></i>
                </div>
                <h5 class="info-card-title">Tanggal</h5>
            </div>
            <div class="info-item">
                <div class="info-label">{{ $dateInfo['label'] }}</div>
                <div class="info-value">{{ $dateInfo['value'] }}</div>
            </div>
        </div>
    </div>

    <!-- Table Items -->
    <div class="col-12">
        <div class="table-card">
            <div class="table-card-header">
                <h5 class="table-card-title">
                    <i class="fas fa-boxes"></i>
                    Daftar Item Purchase Order
                </h5>
            </div>
            <div class="table-responsive">
                <table class="table table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No</th>
                            <th style="width: 62%;">Nama Perangkat</th>
                            <th style="width: 30%;" class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchaseOrder->detailPO as $index => $detail)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="item-icon">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    <div class="item-details">
                                        <h6>{{ $detail->perangkat->nama_perangkat ?? 'N/A' }}</h6>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="quantity-badge">
                                    {{ $detail->jumlah }} Unit
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end">
                                <i class="fas fa-calculator me-2"></i>Total Jumlah:
                            </td>
                            <td class="text-center">
                                <span class="quantity-badge" style="font-size: 1.125rem;">
                                    {{ $purchaseOrder->detailPO->sum('jumlah') }} Unit
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-header-danger">
                <h5>
                    <i class="fas fa-times-circle me-2"></i>Tolak Purchase Order
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('purchase-order.reject', $purchaseOrder->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p class="mb-3"><strong>Apakah Anda yakin ingin menolak Purchase Order ini?</strong></p>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alasan Penolakan (Opsional)</label>
                        <textarea class="form-control" 
                                  name="reason" 
                                  rows="4" 
                                  placeholder="Masukkan alasan penolakan..."
                                  style="border-radius: 10px; border: 2px solid #e5e7eb;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" 
                            class="btn btn-secondary" 
                            data-bs-dismiss="modal"
                            style="border-radius: 10px; padding: 0.75rem 1.5rem;">
                        Batal
                    </button>
                    <button type="submit" 
                            class="btn btn-danger"
                            style="border-radius: 10px; padding: 0.75rem 1.5rem;">
                        <i class="fas fa-times-circle me-2"></i>Ya, Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Approve Form -->
<form id="approveForm" action="{{ route('purchase-order.approve', $purchaseOrder->id) }}" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

@endsection

@push('scripts')
<script>
function confirmApprove() {
    if (confirm('Apakah Anda yakin ingin menyetujui Purchase Order ini?')) {
        document.getElementById('approveForm').submit();
    }
}
</script>
@endpush