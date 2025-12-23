@extends('layouts.dashboard')

@section('title', 'Edit Purchase Order')
@section('page-title', 'Edit Purchase Order')
@section('page-subtitle', 'PO-' . str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT))

@push('styles')
<style>
/* Header Card */
.header-action-card {
    background: white;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    margin-bottom: 2rem;
}

.header-action-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-action-title {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.header-text h5 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 0.25rem;
}

.header-text p {
    color: #6b7280;
    margin: 0;
    font-size: 0.875rem;
}

.btn-back {
    background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(107, 114, 128, 0.4);
    color: white;
}

/* Card Modern */
.card-modern {
    border: none;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.card-gradient-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #f97316 100%);
    padding: 1.25rem 1.5rem;
    border: none;
}

.card-gradient-header h6 {
    color: white;
    margin: 0;
    font-weight: 700;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.card-body-modern {
    padding: 1.5rem;
}

/* Form Styling */
.form-label-modern {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
    font-size: 0.9375rem;
}

.form-control-modern,
.form-select-modern {
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    font-size: 0.9375rem;
    transition: all 0.3s ease;
}

.form-control-modern:focus,
.form-select-modern:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

/* Summary Box */
.summary-box {
    background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
    border-radius: 12px;
    padding: 1.5rem;
    border: 2px solid #bfdbfe;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid #dbeafe;
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-label {
    color: #1e40af;
    font-weight: 600;
    font-size: 0.9375rem;
}

.summary-value {
    color: #1e3a8a;
    font-weight: 700;
    font-size: 1.125rem;
}

.summary-value.highlight {
    color: #2563eb;
    font-size: 1.5rem;
}

/* Item Card */
.item-card {
    background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
    border: 2px solid #e9d5ff;
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 1.25rem;
    transition: all 0.3s ease;
    position: relative;
}

.item-card:hover {
    border-color: #c084fc;
    box-shadow: 0 8px 20px rgba(168, 85, 247, 0.15);
    transform: translateY(-2px);
}

.item-number {
    width: 45px;
    height: 45px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.25rem;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.btn-remove-item {
    width: 45px;
    height: 45px;
    border-radius: 12px;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    border: none;
    color: white;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

.btn-remove-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
}

/* Button Add Item */
.btn-add-item {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.625rem 1.25rem;
    font-weight: 600;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    transition: all 0.3s ease;
}

.btn-add-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(16, 185, 129, 0.4);
    color: white;
}

/* Button Submit */
.btn-submit-modern {
    width: 100%;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: white;
    border: none;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    font-weight: 700;
    font-size: 1.0625rem;
    box-shadow: 0 6px 16px rgba(245, 158, 11, 0.4);
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.btn-submit-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(245, 158, 11, 0.5);
}

/* Empty State */
.empty-items {
    padding: 3rem 2rem;
    text-align: center;
}

.empty-icon {
    font-size: 4rem;
    color: #d1d5db;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.empty-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.75rem;
}

.empty-text {
    color: #9ca3af;
    margin-bottom: 1.5rem;
}

/* Sticky Sidebar */
.sticky-sidebar {
    position: sticky;
    top: 100px;
}

/* Responsive */
@media (max-width: 991px) {
    .sticky-sidebar {
        position: relative;
        top: 0;
    }
    
    .header-action-content {
        flex-direction: column;
    }
    
    .btn-back {
        width: 100%;
    }
}
</style>
@endpush

@section('content')
<div class="row g-3 g-lg-4">
    
    <!-- Header Action Card -->
    <div class="col-12">
        <div class="header-action-card">
            <div class="header-action-content">
                <div class="header-action-title">
                    <div class="header-icon">
                        <i class="fas fa-edit"></i>
                    </div>
                    <div class="header-text">
                        <h5>Edit Purchase Order</h5>
                        <p>PO-{{ str_pad($purchaseOrder->id, 3, '0', STR_PAD_LEFT) }} - Ubah data purchase order</p>
                    </div>
                </div>
                <a href="{{ route('purchase-order.show', $purchaseOrder->id) }}" class="btn btn-back">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('purchase-order.update', $purchaseOrder->id) }}" method="POST" id="poForm" class="w-100">
        @csrf
        @method('PUT')
        
        <div class="row g-3 g-lg-4">
            <!-- Form Info PO (Sidebar) -->
            <div class="col-lg-4">
                <div class="sticky-sidebar">
                    <div class="card card-modern">
                        <div class="card-gradient-header">
                            <h6>
                                <i class="fas fa-info-circle"></i>
                                Informasi PO
                            </h6>
                        </div>
                        <div class="card-body-modern">
                            <div class="mb-4">
                                <label class="form-label-modern">
                                    Vendor <span class="text-danger">*</span>
                                </label>
                                <select class="form-select form-select-modern @error('id_vendor') is-invalid @enderror" 
                                        name="id_vendor" 
                                        required>
                                    <option value="">-- Pilih Vendor --</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}" 
                                            {{ (old('id_vendor', $purchaseOrder->id_vendor) == $vendor->id) ? 'selected' : '' }}>
                                            {{ $vendor->nama_vendor }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_vendor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label-modern">
                                    Tanggal Pemesanan <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control form-control-modern @error('tanggal_pemesanan') is-invalid @enderror" 
                                       name="tanggal_pemesanan" 
                                       value="{{ old('tanggal_pemesanan', $purchaseOrder->tanggal_pemesanan) }}" 
                                       required>
                                @error('tanggal_pemesanan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="summary-box mb-4">
                                <div class="summary-item">
                                    <span class="summary-label">
                                        <i class="fas fa-box me-2"></i>Total Item
                                    </span>
                                    <span class="summary-value" id="totalItems">0</span>
                                </div>
                                <div class="summary-item">
                                    <span class="summary-label">
                                        <i class="fas fa-cubes me-2"></i>Total Jumlah
                                    </span>
                                    <span class="summary-value highlight" id="totalQuantity">0 Unit</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-submit-modern">
                                <i class="fas fa-save me-2"></i>Update PO
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Items -->
            <div class="col-lg-8">
                <div class="card card-modern">
                    <div class="card-gradient-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">
                                <i class="fas fa-boxes"></i>
                                Daftar Item
                            </h6>
                            <button type="button" class="btn btn-add-item" onclick="addItem()">
                                <i class="fas fa-plus me-2"></i>Tambah Item
                            </button>
                        </div>
                    </div>
                    <div class="card-body-modern">
                        <div id="itemsContainer">
                            <!-- Existing items will be loaded here -->
                        </div>

                        <div class="empty-items" id="emptyState" style="display: none;">
                            <div class="empty-icon">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <h5 class="empty-title">Belum ada item ditambahkan</h5>
                            <p class="empty-text">Klik tombol "Tambah Item" untuk menambahkan perangkat</p>
                            <button type="button" class="btn btn-primary btn-add-item" onclick="addItem()">
                                <i class="fas fa-plus me-2"></i>Tambah Item Pertama
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let itemCount = 0;
const perangkats = @json($perangkats);
const existingItems = @json($purchaseOrder->detailPO);

function addItem(perangkatId = '', jumlah = 1) {
    itemCount++;
    const emptyState = document.getElementById('emptyState');
    if (emptyState) emptyState.style.display = 'none';
    
    const container = document.getElementById('itemsContainer');
    const itemHtml = `
        <div class="item-card" id="item-${itemCount}">
            <div class="d-flex gap-3">
                <div class="item-number">${itemCount}</div>
                <div class="flex-grow-1">
                    <div class="row">
                        <div class="col-md-7 mb-3">
                            <label class="form-label-modern">Perangkat</label>
                            <select class="form-select form-select-modern" name="items[${itemCount}][id_perangkat]" required onchange="updateSummary()">
                                <option value="">-- Pilih Perangkat --</option>
                                ${perangkats.map(p => `
                                    <option value="${p.id}" ${p.id == perangkatId ? 'selected' : ''}>
                                        ${p.nama_perangkat} - ${p.merk}
                                    </option>
                                `).join('')}
                            </select>
                        </div>
                        <div class="col-md-5 mb-3">
                            <label class="form-label-modern">Jumlah</label>
                            <input type="number" 
                                   class="form-control form-control-modern" 
                                   name="items[${itemCount}][jumlah]" 
                                   min="1" 
                                   value="${jumlah}" 
                                   required
                                   onchange="updateSummary()">
                        </div>
                    </div>
                </div>
                <div>
                    <button type="button" class="btn-remove-item" onclick="removeItem(${itemCount})" data-bs-toggle="tooltip" title="Hapus Item">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', itemHtml);
    updateSummary();
    
    // Initialize tooltips for new item
    const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltips.map(el => new bootstrap.Tooltip(el));
}

function removeItem(id) {
    const item = document.getElementById(`item-${id}`);
    if (item) {
        item.remove();
        updateItemNumbers();
        updateSummary();
        
        const container = document.getElementById('itemsContainer');
        if (container.children.length === 0) {
            document.getElementById('emptyState').style.display = 'block';
        }
    }
}

function updateItemNumbers() {
    const items = document.querySelectorAll('.item-card');
    items.forEach((item, index) => {
        const numberDiv = item.querySelector('.item-number');
        if (numberDiv) {
            numberDiv.textContent = index + 1;
        }
    });
}

function updateSummary() {
    const items = document.querySelectorAll('.item-card');
    let totalItems = items.length;
    let totalQuantity = 0;
    
    items.forEach(item => {
        const quantityInput = item.querySelector('input[type="number"]');
        if (quantityInput && quantityInput.value) {
            totalQuantity += parseInt(quantityInput.value);
        }
    });
    
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('totalQuantity').textContent = totalQuantity + ' Unit';
}

// Form validation
document.getElementById('poForm').addEventListener('submit', function(e) {
    const items = document.querySelectorAll('.item-card');
    
    if (items.length === 0) {
        e.preventDefault();
        alert('Mohon tambahkan minimal 1 item!');
        return false;
    }
    
    let isValid = true;
    items.forEach(item => {
        const select = item.querySelector('select');
        const input = item.querySelector('input[type="number"]');
        
        if (!select.value || !input.value || input.value < 1) {
            isValid = false;
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        alert('Mohon lengkapi semua item dengan benar!');
        return false;
    }
});

// Load existing items on page load
$(document).ready(function() {
    if (existingItems.length > 0) {
        existingItems.forEach(item => {
            addItem(item.id_perangkat, item.jumlah);
        });
    } else {
        addItem();
    }
});
</script>
@endpush