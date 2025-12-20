{{-- Modal Styles --}}
<style>
    /* Modal Styles */
    .modal-content {
        border: none;
        border-radius: 1rem;
        overflow: visible;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        background: #ffffff;
    }

    .modal-header {
        background: #ffffff;
        color: #1e293b;
        border: none;
        padding: 1.5rem 2rem 1.25rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .modal-title {
        font-weight: 700;
        font-size: 1.25rem;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .modal-title i {
        color: #3b82f6;
        font-size: 1.125rem;
    }

    .btn-close {
        background: transparent;
        opacity: 0.5;
        transition: all 0.2s;
    }

    .btn-close:hover {
        opacity: 1;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 1.5rem 2rem;
        max-height: 65vh;
        overflow-y: auto;
        background: #fafafa;
    }

    .modal-footer {
        padding: 1.25rem 2rem;
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        gap: 0.75rem;
    }

    /* Form Styles */
    .form-label {
        font-weight: 600;
        color: #475569;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: #3b82f6;
        font-size: 0.875rem;
    }

    .form-label .required {
        color: #ef4444;
        font-size: 1.1rem;
        line-height: 1;
    }

    .form-control, .form-select {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    /* Radio Card Styles */
    .jenis-transaksi-wrapper {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.875rem;
        margin-bottom: 1.25rem;
    }

    .radio-option {
        position: relative;
    }

    .radio-option input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .radio-card {
        border: 2px solid #e2e8f0;
        border-radius: 0.625rem;
        padding: 1.25rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        background: #ffffff;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .radio-option input[type="radio"]:checked + .radio-card {
        border-color: #3b82f6;
        background: #f0f9ff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .radio-card:hover {
        border-color: #3b82f6;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .radio-card-icon {
        width: 48px;
        height: 48px;
        border-radius: 0.625rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        margin-bottom: 0.625rem;
    }

    .radio-card-icon.masuk {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        color: white;
    }

    .radio-card-icon.keluar {
        background: linear-gradient(135deg, #f97316 0%, #fb923c 100%);
        color: white;
    }

    .radio-card-title {
        font-weight: 600;
        font-size: 0.9375rem;
        color: #1e293b;
        margin-bottom: 0.25rem;
    }

    .radio-card-desc {
        font-size: 0.75rem;
        color: #64748b;
        line-height: 1.4;
    }

    .radio-option input[type="radio"]:checked + .radio-card .radio-card-title {
        color: #3b82f6;
    }

    /* Section Divider */
    .section-divider {
        border-top: 1px solid #e2e8f0;
        margin: 1.5rem 0;
    }

    /* Serial Number List */
    .serial-list {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-top: 1rem;
        max-height: 180px;
        overflow-y: auto;
    }

    .serial-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.625rem 0.875rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s ease;
    }

    .serial-item:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .serial-item:last-child {
        margin-bottom: 0;
    }

    .serial-number-badge {
        font-family: 'SF Mono', 'Monaco', 'Courier New', monospace;
        font-weight: 600;
        font-size: 0.8125rem;
        color: #1e293b;
        background: #e0e7ff;
        padding: 0.25rem 0.625rem;
        border-radius: 0.375rem;
    }

    .btn-remove-serial {
        background: transparent;
        border: none;
        color: #ef4444;
        cursor: pointer;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
        font-size: 0.875rem;
    }

    .btn-remove-serial:hover {
        background: #fef2f2;
        color: #dc2626;
    }

    .serial-input-group {
        display: flex;
        gap: 0.625rem;
        margin-top: 0.5rem;
    }

    .btn-add-serial {
        background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        border: none;
        color: white;
        padding: 0.625rem 1.25rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .btn-add-serial:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    }

    .serial-check {
        font-size: 0.8125rem;
        margin-top: 0.5rem;
        padding: 0.5rem 0.75rem;
        border-radius: 0.375rem;
    }

    .serial-check.available {
        background: #f0fdf4;
        color: #10b981;
        border: 1px solid #bbf7d0;
    }

    .serial-check.used {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }

    .serial-counter {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 0.875rem;
        background: #3b82f6;
        color: white;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }

    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        min-height: 42px;
    }

    .select2-container--bootstrap-5.select2-container--focus .select2-selection {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-cancel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #475569;
        padding: 0.625rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
    }

    .btn-cancel:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    .modal-footer .btn-add {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        border: none;
        color: white;
        padding: 0.625rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
    }

    .modal-footer .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.35);
        color: white;
    }

    /* Smooth transitions */
    .conditional-field {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            max-height: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            max-height: 500px;
            transform: translateY(0);
        }
    }

    /* Scrollbar styling */
    .modal-body::-webkit-scrollbar,
    .serial-list::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-track,
    .serial-list::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb,
    .serial-list::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover,
    .serial-list::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

{{-- Modal HTML --}}
<div class="modal fade" id="inventoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-plus-circle"></i>
                    <span>Tambah Data Inventory</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="inventoryForm">
                    <input type="hidden" id="itemId" name="item_id">
                    <input type="hidden" id="itemType" name="item_type">
                    <input type="hidden" id="detailBarangId" name="detail_barang_id">

                    <!-- Jenis Inventori -->
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-exchange-alt"></i>
                            Jenis Transaksi <span class="required">*</span>
                        </label>
                        <div class="jenis-transaksi-wrapper">
                            <div class="radio-option">
                                <input type="radio" name="jenis_inventori" id="masuk" value="masuk" required>
                                <label for="masuk" class="radio-card">
                                    <div class="radio-card-icon masuk">
                                        <i class="fas fa-arrow-down"></i>
                                    </div>
                                    <div class="radio-card-title">Barang Masuk</div>
                                    <div class="radio-card-desc">Catat barang masuk ke inventory</div>
                                </label>
                            </div>
                            <div class="radio-option">
                                <input type="radio" name="jenis_inventori" id="keluar" value="keluar" required>
                                <label for="keluar" class="radio-card">
                                    <div class="radio-card-icon keluar">
                                        <i class="fas fa-arrow-up"></i>
                                    </div>
                                    <div class="radio-card-title">Barang Keluar</div>
                                    <div class="radio-card-desc">Catat barang keluar dari inventory</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="section-divider"></div>

                    <!-- Informasi Dasar -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="tanggal" class="form-label">
                                <i class="fas fa-calendar-alt"></i>
                                Tanggal <span class="required">*</span>
                            </label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" 
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="id_perangkat" class="form-label">
                                <i class="fas fa-box"></i>
                                Perangkat <span class="required">*</span>
                            </label>
                            <select class="form-select select2" id="id_perangkat" name="id_perangkat" required>
                                <option value="">-- Pilih Perangkat --</option>
                                @foreach($perangkats as $perangkat)
                                    <option value="{{ $perangkat->id }}">{{ $perangkat->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="kategori" class="form-label">
                                <i class="fas fa-tag"></i>
                                Kategori <span class="required">*</span>
                            </label>
                            <select class="form-select" id="kategori" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Listrik">Listrik</option>
                                <option value="Non-Listrik">Non-Listrik</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="stok" class="form-label">
                                <i class="fas fa-cubes"></i>
                                Jumlah/Stok <span class="required">*</span>
                            </label>
                            <input type="number" class="form-control" id="stok" name="stok" 
                                placeholder="Masukkan jumlah" min="1" required>
                        </div>
                    </div>

                    <!-- Serial Number Section -->
                    <div id="serialSection" class="mb-3" style="display: none;">
                        <div class="conditional-field">
                            <label class="form-label">
                                <i class="fas fa-barcode"></i>
                                Serial Number
                            </label>
                            <div class="alert alert-info mb-3" style="background: #eff6ff; border: 1px solid #bfdbfe; color: #1e40af; font-size: 0.8125rem; padding: 0.75rem;">
                                <i class="fas fa-info-circle me-2"></i>
                                Masukkan serial number satu per satu untuk setiap barang. Total yang harus diinput sesuai dengan jumlah stok.
                            </div>
                            
                            <div class="serial-input-group">
                                <div style="flex: 1;">
                                    <input type="text" class="form-control" id="serial_number_input" 
                                        placeholder="Masukkan serial number">
                                    <div id="serialCheck" class="serial-check"></div>
                                </div>
                                <button type="button" class="btn-add-serial" id="btnAddSerial">
                                    <i class="fas fa-plus me-2"></i>Tambah
                                </button>
                            </div>

                            <div id="serialListWrapper" style="display: none;">
                                <div class="serial-counter">
                                    <i class="fas fa-list-ol"></i>
                                    <span id="serialCount">0</span> / <span id="serialTotal">0</span>
                                </div>
                                <div class="serial-list" id="serialList"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Barang Masuk Fields -->
                    <div id="barangMasukSection" class="conditional-field mb-3" style="display: none;">
                        <div class="section-divider mb-3"></div>
                        <label class="form-label">
                            <i class="fas fa-building"></i>
                            Sumber <span class="required">*</span>
                        </label>
                        <select class="form-select" id="sumber" name="sumber">
                            <option value="">-- Pilih Sumber --</option>
                            <option value="Customer">Customer</option>
                            <option value="Vendor">Vendor</option>
                        </select>
                    </div>

                    <!-- Barang Keluar Fields -->
                    <div id="barangKeluarSection" class="conditional-field" style="display: none;">
                        <div class="section-divider mb-3"></div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="perihal" class="form-label">
                                    <i class="fas fa-clipboard-list"></i>
                                    Perihal <span class="required">*</span>
                                </label>
                                <select class="form-select" id="perihal" name="perihal">
                                    <option value="">-- Pilih Perihal --</option>
                                    <option value="Pemeliharaan">Pemeliharaan</option>
                                    <option value="Penjualan">Penjualan</option>
                                    <option value="Instalasi">Instalasi</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label for="alamat" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Alamat Tujuan
                                </label>
                                <input type="text" class="form-control" id="alamat" name="alamat" 
                                    placeholder="Masukkan alamat tujuan">
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <div class="section-divider mb-3"></div>
                    <div class="mb-0">
                        <label for="catatan" class="form-label">
                            <i class="fas fa-comment"></i>
                            Catatan
                        </label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3" 
                            placeholder="Tambahkan catatan atau keterangan tambahan..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <button type="button" class="btn btn-add" id="btnSubmit">
                    <i class="fas fa-save me-2"></i>Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal JavaScript --}}
<script>
$(document).ready(function() {
    let serialCheckTimeout;
    let isEdit = false;
    let serialNumbers = [];

    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Perangkat --',
        dropdownParent: $('#inventoryModal')
    });

    // Reset form when modal opens
    $('#inventoryModal').on('show.bs.modal', function(e) {
        if (!$(e.relatedTarget).hasClass('btn-edit-item')) {
            resetForm();
        }
    });

    // Handle jenis inventori change
    $('input[name="jenis_inventori"]').on('change', function() {
        const value = $(this).val();
        
        if (value === 'masuk') {
            $('#barangMasukSection').slideDown(300).css('display', 'block');
            $('#barangKeluarSection').slideUp(300);
            $('#sumber').prop('required', true);
            $('#perihal').prop('required', false);
        } else {
            $('#barangKeluarSection').slideDown(300).css('display', 'block');
            $('#barangMasukSection').slideUp(300);
            $('#perihal').prop('required', true);
            $('#sumber').prop('required', false);
        }
    });

    // Handle stok change
    $('#stok').on('input', function() {
        const stok = parseInt($(this).val()) || 0;
        const kategori = $('#kategori').val();
        
        if (stok > 0 && kategori === 'Listrik') {
            $('#serialSection').slideDown(300).css('display', 'block');
            $('#serialTotal').text(stok);
            updateSerialCounter();
        } else {
            $('#serialSection').slideUp(300);
            serialNumbers = [];
            updateSerialList();
        }
    });

    // Handle kategori change
    $('#kategori').on('change', function() {
        const kategori = $(this).val();
        const stok = parseInt($('#stok').val()) || 0;
        
        if (kategori === 'Listrik' && stok > 0) {
            $('#serialSection').slideDown(300).css('display', 'block');
            $('#serialTotal').text(stok);
        } else {
            $('#serialSection').slideUp(300);
            serialNumbers = [];
            updateSerialList();
        }
    });

    // Check serial number availability
    $('#serial_number_input').on('input', function() {
        const serialNumber = $(this).val().trim();
        const excludeId = $('#detailBarangId').val();
        
        clearTimeout(serialCheckTimeout);
        
        if (serialNumber === '') {
            $('#serialCheck').html('').removeClass('available used');
            return;
        }

        if (serialNumbers.includes(serialNumber)) {
            $('#serialCheck')
                .html('<i class="fas fa-times-circle me-2"></i>Serial number sudah ditambahkan')
                .removeClass('available').addClass('used');
            return;
        }

        $('#serialCheck').html('<i class="fas fa-spinner fa-spin me-2"></i>Memeriksa...');

        serialCheckTimeout = setTimeout(function() {
            $.ajax({
                url: '{{ route("inventory.check-serial") }}',
                method: 'GET',
                data: { 
                    serial_number: serialNumber,
                    exclude_id: excludeId
                },
                success: function(response) {
                    if (response.exists) {
                        $('#serialCheck')
                            .html('<i class="fas fa-times-circle me-2"></i>' + response.message)
                            .removeClass('available').addClass('used');
                    } else {
                        $('#serialCheck')
                            .html('<i class="fas fa-check-circle me-2"></i>' + response.message)
                            .removeClass('used').addClass('available');
                    }
                }
            });
        }, 500);
    });

    // Add serial number
    $('#btnAddSerial').on('click', function() {
        const serialNumber = $('#serial_number_input').val().trim();
        const totalStok = parseInt($('#stok').val()) || 0;
        
        if (!serialNumber) {
            alert('Masukkan serial number terlebih dahulu!');
            return;
        }

        if (serialNumbers.includes(serialNumber)) {
            alert('Serial number sudah ditambahkan!');
            return;
        }

        if (serialNumbers.length >= totalStok) {
            alert('Serial number sudah mencapai jumlah stok!');
            return;
        }

        const checkStatus = $('#serialCheck').hasClass('available');
        if (!checkStatus) {
            alert('Serial number tidak tersedia atau belum dicek!');
            return;
        }

        serialNumbers.push(serialNumber);
        updateSerialList();
        $('#serial_number_input').val('');
        $('#serialCheck').html('').removeClass('available used');
    });

    // Remove serial number
    $(document).on('click', '.btn-remove-serial', function() {
        const index = $(this).data('index');
        serialNumbers.splice(index, 1);
        updateSerialList();
    });

    // Update serial list display
    function updateSerialList() {
        const $list = $('#serialList');
        $list.empty();

        if (serialNumbers.length === 0) {
            $('#serialListWrapper').slideUp(300);
            return;
        }

        $('#serialListWrapper').slideDown(300);

        serialNumbers.forEach((serial, index) => {
            $list.append(`
                <div class="serial-item">
                    <div>
                        <span class="badge bg-secondary me-2">${index + 1}</span>
                        <span class="serial-number-badge">${serial}</span>
                    </div>
                    <button type="button" class="btn-remove-serial" data-index="${index}">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `);
        });

        updateSerialCounter();
    }

    // Update serial counter
    function updateSerialCounter() {
        $('#serialCount').text(serialNumbers.length);
    }

    // Submit form
    $('#btnSubmit').on('click', function() {
        if (!$('#inventoryForm')[0].checkValidity()) {
            $('#inventoryForm')[0].reportValidity();
            return;
        }

        const stok = parseInt($('#stok').val()) || 0;
        const kategori = $('#kategori').val();

        if (kategori === 'Listrik' && stok > 0) {
            if (serialNumbers.length !== stok) {
                alert(`Anda harus memasukkan ${stok} serial number sesuai jumlah stok!`);
                return;
            }
        }

        const formData = {
            tanggal: $('#tanggal').val(),
            id_perangkat: $('#id_perangkat').val(),
            jenis_inventori: $('input[name="jenis_inventori"]:checked').val(),
            stok: stok,
            kategori: kategori,
            serial_numbers: kategori === 'Listrik' ? serialNumbers : [],
            catatan: $('#catatan').val(),
            alamat: $('#alamat').val(),
            sumber: $('#sumber').val(),
            perihal: $('#perihal').val(),
            _token: '{{ csrf_token() }}'
        };

        const itemId = $('#itemId').val();
        const itemType = $('#itemType').val();
        let url = '{{ route("inventory.store") }}';
        let method = 'POST';

        if (isEdit && itemId) {
            url = `/inventory/${itemId}/${itemType}`;
            method = 'PUT';
            formData._method = 'PUT';
        }

        $('#btnSubmit').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        $.ajax({
            url: url,
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $('#inventoryModal').modal('hide');
                    alert(response.message);
                    location.reload();
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    for (let key in errors) {
                        errorMsg += errors[key][0] + '\n';
                    }
                    alert(errorMsg);
                } else {
                    alert(xhr.responseJSON.message || 'Terjadi kesalahan');
                }
            },
            complete: function() {
                $('#btnSubmit').prop('disabled', false).html('<i class="fas fa-save me-2"></i>Simpan Data');
            }
        });
    });

    // Edit button
    $('.btn-edit-item').on('3:34 PMclick', function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        isEdit = true;
        $.ajax({
        url: `/inventory/${id}/${type}/edit`,
        method: 'GET',
        success: function(response) {
            if (response.success) {
                const data = response.data;
                const detailBarang = data.detail_barang;

                $('#modalTitle').html('<i class="fas fa-edit"></i><span>Edit Data Inventory</span>');
                $('#itemId').val(data.id);
                $('#itemType').val(type);
                $('#detailBarangId').val(detailBarang.id);
                $('#tanggal').val(data.tanggal);
                $('#id_perangkat').val(detailBarang.id_perangkat).trigger('change');
                $('#kategori').val(detailBarang.kategori);
                $('#stok').val(data.jumlah);

                $(`#${type}`).prop('checked', true).trigger('change');

                if (type === 'masuk') {
                    $('#sumber').val(data.status);
                    $('#catatan').val(data.catatan_barang_masuk || '');
                } else {
                    $('#perihal').val(data.status);
                    $('#alamat').val(data.alamat || '');
                    $('#catatan').val(data.catatan_barang_keluar || '');
                }

                if (detailBarang.kategori === 'Listrik' && detailBarang.serial_number) {
                    serialNumbers = [detailBarang.serial_number];
                    updateSerialList();
                    $('#serialSection').show();
                    $('#serialTotal').text(data.jumlah);
                }

                $('#inventoryModal').modal('show');
            }
        },
        error: function(xhr) {
            alert('Gagal mengambil data');
        }
    });
});

// Delete button
$('.btn-delete-item').on('click', function() {
    if (!confirm('Yakin ingin menghapus data ini?')) return;

    const id = $(this).data('id');
    const type = $(this).data('type');

    $.ajax({
        url: `/inventory/${id}/${type}`,
        method: 'DELETE',
        data: { _token: '{{ csrf_token() }}' },
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            }
        },
        error: function(xhr) {
            alert(xhr.responseJSON.message || 'Gagal menghapus data');
        }
    });
});

function resetForm() {
    isEdit = false;
    serialNumbers = [];
    $('#modalTitle').html('<i class="fas fa-plus-circle"></i><span>Tambah Data Inventory</span>');
    $('#inventoryForm')[0].reset();
    $('#itemId').val('');
    $('#itemType').val('');
    $('#detailBarangId').val('');
    $('#tanggal').val('{{ date("Y-m-d") }}');
    $('#id_perangkat').val('').trigger('change');
    $('#serialCheck').html('').removeClass('available used');
    $('#serial_number_input').val('');
    $('#barangMasukSection, #barangKeluarSection, #serialSection').hide();
    $('input[name="jenis_inventori"]').prop('checked', false);
    $('#sumber, #perihal').prop('required', false);
    updateSerialList();
}
}); 
</script>