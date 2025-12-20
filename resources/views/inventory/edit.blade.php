<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    <i class="fas fa-edit me-2"></i>Edit Data Inventory
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit_item_id" name="item_id">
                    <input type="hidden" id="edit_item_type" name="item_type">
                    <input type="hidden" id="edit_detail_barang_id" name="detail_barang_id">

                    <!-- Jenis Transaksi -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-3">
                            <i class="fas fa-exchange-alt me-2"></i>
                            Jenis Transaksi <span class="text-danger">*</span>
                        </label>
                        <div class="row g-3">
                            <div class="col-12 col-sm-6">
                                <div class="form-check-card">
                                    <input type="radio" name="jenis_inventori" id="edit_masuk" value="masuk" class="form-check-input" required>
                                    <label for="edit_masuk" class="form-check-label w-100">
                                        <div class="card border h-100">
                                            <div class="card-body text-center p-3">
                                                <div class="mb-2">
                                                    <div class="mx-auto bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fas fa-arrow-down text-success fs-4"></i>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-1">Barang Masuk</h6>
                                                <p class="text-muted small mb-0">Catat barang masuk ke inventory</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-check-card">
                                    <input type="radio" name="jenis_inventori" id="edit_keluar" value="keluar" class="form-check-input" required>
                                    <label for="edit_keluar" class="form-check-label w-100">
                                        <div class="card border h-100">
                                            <div class="card-body text-center p-3">
                                                <div class="mb-2">
                                                    <div class="mx-auto bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                        <i class="fas fa-arrow-up text-warning fs-4"></i>
                                                    </div>
                                                </div>
                                                <h6 class="fw-bold mb-1">Barang Keluar</h6>
                                                <p class="text-muted small mb-0">Catat barang keluar dari inventory</p>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Informasi Dasar -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-md-6">
                            <label for="edit_tanggal" class="form-label">
                                <i class="fas fa-calendar-alt me-2"></i>
                                Tanggal <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="edit_id_perangkat" class="form-label">
                                <i class="fas fa-box me-2"></i>
                                Perangkat <span class="text-danger">*</span>
                            </label>
                            <select class="form-select select2-edit" id="edit_id_perangkat" name="id_perangkat" required>
                                <option value="">-- Pilih Perangkat --</option>
                                @foreach($perangkats as $perangkat)
                                    <option value="{{ $perangkat->id }}">{{ $perangkat->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="edit_kategori" class="form-label">
                                <i class="fas fa-tag me-2"></i>
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="edit_kategori" name="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="Listrik">Listrik</option>
                                <option value="Non-Listrik">Non-Listrik</option>
                            </select>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="edit_stok" class="form-label">
                                <i class="fas fa-cubes me-2"></i>
                                Jumlah/Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="edit_stok" name="stok" 
                                placeholder="Masukkan jumlah" min="1" required>
                        </div>
                    </div>

                    <!-- Serial Number Section -->
                    <div id="editSerialSection" class="mb-4" style="display: none;">
                        <label class="form-label">
                            <i class="fas fa-barcode me-2"></i>
                            Serial Number
                        </label>
                        <div class="alert alert-info mb-3 py-2">
                            <i class="fas fa-info-circle me-2"></i>
                            <small>Masukkan serial number satu per satu sesuai jumlah stok</small>
                        </div>
                        
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="edit_serial_number_input" 
                                placeholder="Masukkan serial number">
                            <button type="button" class="btn btn-success" id="editBtnAddSerial">
                                <i class="fas fa-plus me-1"></i>Tambah
                            </button>
                        </div>
                        
                        <div id="editSerialCheck" class="small mb-2"></div>

                        <div id="editSerialListWrapper" style="display: none;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge bg-primary">
                                    <i class="fas fa-list-ol me-1"></i>
                                    <span id="editSerialCount">0</span>/<span id="editSerialTotal">0</span> Serial
                                </span>
                                <button type="button" class="btn btn-sm btn-outline-danger" id="editClearAllSerial">
                                    <i class="fas fa-trash me-1"></i>Hapus Semua
                                </button>
                            </div>
                            <div class="serial-list border rounded p-2" id="editSerialList" style="max-height: 150px; overflow-y: auto;"></div>
                        </div>
                    </div>

                    <!-- Barang Masuk Fields -->
                    <div id="editBarangMasukSection" style="display: none;">
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="edit_sumber" class="form-label">
                                    <i class="fas fa-building me-2"></i>
                                    Sumber <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="edit_sumber" name="sumber">
                                    <option value="">-- Pilih Sumber --</option>
                                    <option value="Customer">Customer</option>
                                    <option value="Vendor">Vendor</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Barang Keluar Fields -->
                    <div id="editBarangKeluarSection" style="display: none;">
                        <hr class="my-4">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="edit_perihal" class="form-label">
                                    <i class="fas fa-clipboard-list me-2"></i>
                                    Perihal <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="edit_perihal" name="perihal">
                                    <option value="">-- Pilih Perihal --</option>
                                    <option value="Pemeliharaan">Pemeliharaan</option>
                                    <option value="Penjualan">Penjualan</option>
                                    <option value="Instalasi">Instalasi</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="edit_alamat" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Alamat Tujuan
                                </label>
                                <input type="text" class="form-control" id="edit_alamat" name="alamat" 
                                    placeholder="Masukkan alamat tujuan">
                            </div>
                        </div>
                    </div>

                    <!-- Catatan -->
                    <hr class="my-4">
                    <div class="mb-3">
                        <label for="edit_catatan" class="form-label">
                            <i class="fas fa-comment me-2"></i>
                            Catatan
                        </label>
                        <textarea class="form-control" id="edit_catatan" name="catatan" rows="3" 
                            placeholder="Tambahkan catatan atau keterangan tambahan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Edit Modal Styles */
    #editModal .modal-content {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    #editModal .modal-header {
        background: linear-gradient(135deg, var(--transdata-orange) 0%, #fb923c 100%);
        color: white;
        border-radius: 1rem 1rem 0 0;
        padding: 1.5rem;
        border: none;
    }

    #editModal .btn-close {
        filter: brightness(0) invert(1);
    }

    #editModal .form-check-card {
        position: relative;
    }

    #editModal .form-check-input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    #editModal .form-check-card .card {
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid #e5e7eb;
    }

    #editModal .form-check-card .form-check-input:checked + .form-check-label .card {
        border-color: var(--transdata-orange);
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.05) 0%, rgba(251, 146, 60, 0.05) 100%);
        box-shadow: 0 5px 15px rgba(249, 115, 22, 0.1);
    }

    #editModal .form-check-card .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    #editModal .form-label {
        font-weight: 600;
        color: var(--transdata-gray);
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    #editModal .form-control,
    #editModal .form-select {
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
    }

    #editModal .form-control:focus,
    #editModal .form-select:focus {
        border-color: var(--transdata-orange);
        box-shadow: 0 0 0 0.25rem rgba(249, 115, 22, 0.1);
    }

    #editModal .btn-primary {
        background: linear-gradient(135deg, var(--transdata-orange) 0%, #fb923c 100%);
        border: none;
        padding: 0.75rem 2rem;
        border-radius: 0.75rem;
        font-weight: 600;
    }

    #editModal .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
    }

    #editModal .btn-success {
        background: linear-gradient(135deg, var(--transdata-green) 0%, #34d399 100%);
        border: none;
        border-radius: 0.75rem;
        padding: 0.75rem 1.5rem;
    }

    /* Mobile Responsive for Edit Modal */
    @media (max-width: 768px) {
        #editModal .modal-dialog {
            margin: 0.5rem;
        }
        
        #editModal .modal-content {
            border-radius: 0.75rem;
        }
        
        #editModal .modal-header {
            padding: 1rem 1.25rem;
        }
        
        #editModal .modal-body {
            padding: 1rem;
        }
        
        #editModal .modal-footer {
            padding: 1rem;
            flex-direction: column;
        }
        
        #editModal .modal-footer .btn {
            width: 100%;
            margin: 0.25rem 0;
        }
    }
</style>

<script>
$(document).ready(function() {
    let editSerialCheckTimeout;
    let editSerialNumbers = [];

    // Initialize Select2 for edit modal
    $('#editModal .select2-edit').select2({
        theme: 'bootstrap-5',
        placeholder: '-- Pilih Perangkat --',
        dropdownParent: $('#editModal'),
        width: '100%'
    });

    // Handle edit button click
    $(document).on('click', '.btn-edit-item', function() {
        const id = $(this).data('id');
        const type = $(this).data('type');
        
        $.ajax({
            url: `/inventory/${id}/${type}/edit`,
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    loadEditData(response.data, type);
                    $('#editModal').modal('show');
                }
            },
            error: function(xhr) {
                alert('Gagal mengambil data');
            }
        });
    });

    // Reset form when modal opens
    $('#editModal').on('show.bs.modal', function() {
        resetEditForm();
    });

    // Handle jenis inventori change for edit
    $('#editModal input[name="jenis_inventori"]').on('change', function() {
        const value = $(this).val();
        
        if (value === 'masuk') {
            $('#editBarangMasukSection').slideDown(300).css('display', 'block');
            $('#editBarangKeluarSection').slideUp(300);
            $('#edit_sumber').prop('required', true);
            $('#edit_perihal').prop('required', false);
        } else {
            $('#editBarangKeluarSection').slideDown(300).css('display', 'block');
            $('#editBarangMasukSection').slideUp(300);
            $('#edit_perihal').prop('required', true);
            $('#edit_sumber').prop('required', false);
        }
    });

    // Handle stok change for edit
    $('#edit_stok').on('input', function() {
        updateEditSerialSection();
    });

    // Handle kategori change for edit
    $('#edit_kategori').on('change', function() {
        updateEditSerialSection();
    });

    // Check serial number availability for edit
    $('#edit_serial_number_input').on('input', function() {
        const serialNumber = $(this).val().trim();
        const excludeId = $('#edit_detail_barang_id').val();
        
        clearTimeout(editSerialCheckTimeout);
        
        if (serialNumber === '') {
            $('#editSerialCheck').html('').removeClass('text-success text-danger');
            return;
        }

        // Check if already in local list
        if (editSerialNumbers.includes(serialNumber)) {
            $('#editSerialCheck')
                .html('<i class="fas fa-times-circle me-1"></i>Serial number sudah ditambahkan')
                .removeClass('text-success').addClass('text-danger');
            return;
        }

        $('#editSerialCheck').html('<i class="fas fa-spinner fa-spin me-1"></i>Memeriksa...');

        editSerialCheckTimeout = setTimeout(function() {
            $.ajax({
                url: '{{ route("inventory.check-serial") }}',
                method: 'GET',
                data: { 
                    serial_number: serialNumber,
                    exclude_id: excludeId
                },
                success: function(response) {
                    if (response.exists) {
                        $('#editSerialCheck')
                            .html('<i class="fas fa-times-circle me-1"></i>' + response.message)
                            .removeClass('text-success').addClass('text-danger');
                    } else {
                        $('#editSerialCheck')
                            .html('<i class="fas fa-check-circle me-1"></i>' + response.message)
                            .removeClass('text-danger').addClass('text-success');
                    }
                },
                error: function() {
                    $('#editSerialCheck')
                        .html('<i class="fas fa-exclamation-circle me-1"></i>Gagal memeriksa')
                        .removeClass('text-success text-danger');
                }
            });
        }, 500);
    });

    // Add serial number to list for edit
    $('#editBtnAddSerial').on('click', function() {
        const serialNumber = $('#edit_serial_number_input').val().trim();
        const totalStok = parseInt($('#edit_stok').val()) || 0;
        
        if (!serialNumber) {
            showEditAlert('warning', 'Masukkan serial number terlebih dahulu!');
            return;
        }

        if (editSerialNumbers.includes(serialNumber)) {
            showEditAlert('warning', 'Serial number sudah ditambahkan!');
            return;
        }

        if (editSerialNumbers.length >= totalStok) {
            showEditAlert('warning', `Serial number sudah mencapai jumlah stok (${totalStok})!`);
            return;
        }

        // Check if serial available
        const checkStatus = $('#editSerialCheck').hasClass('text-success');
        if (!checkStatus) {
            showEditAlert('warning', 'Serial number tidak tersedia atau belum dicek!');
            return;
        }

        editSerialNumbers.push(serialNumber);
        updateEditSerialList();
        $('#edit_serial_number_input').val('');
        $('#editSerialCheck').html('').removeClass('text-success text-danger');
    });

    // Remove serial number from list for edit
    $(document).on('click', '#editModal .btn-remove-serial', function() {
        const index = $(this).data('index');
        editSerialNumbers.splice(index, 1);
        updateEditSerialList();
    });

    // Clear all serial numbers for edit
    $('#editClearAllSerial').on('click', function() {
        if (confirm('Hapus semua serial number?')) {
            editSerialNumbers = [];
            updateEditSerialList();
        }
    });

    // Form submission for edit
    $('#editForm').on('submit', function(e) {
        e.preventDefault();
        
        const stok = parseInt($('#edit_stok').val()) || 0;
        const kategori = $('#edit_kategori').val();
        const itemId = $('#edit_item_id').val();
        const itemType = $('#edit_item_type').val();

        // Validate serial numbers if kategori is Listrik
        if (kategori === 'Listrik' && stok > 0) {
            if (editSerialNumbers.length !== stok) {
                showEditAlert('error', `Anda harus memasukkan ${stok} serial number sesuai jumlah stok!`);
                return;
            }
        }

        // Prepare form data
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        // Add serial numbers to form data
        if (kategori === 'Listrik') {
            editSerialNumbers.forEach((serial, index) => {
                formData.append(`serial_numbers[${index}]`, serial);
            });
        }

        // Set form action
        const form = $(this);
        form.attr('action', `/inventory/${itemId}/${itemType}`);

        // Disable submit button
        const submitBtn = form.find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...');

        // Submit form
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showEditAlert('success', response.message);
                    setTimeout(function() {
                        $('#editModal').modal('hide');
                        location.reload();
                    }, 1500);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    let errorMsg = '';
                    for (let key in errors) {
                        errorMsg += errors[key][0] + '<br>';
                    }
                    showEditAlert('error', errorMsg);
                } else {
                    showEditAlert('error', xhr.responseJSON?.message || 'Terjadi kesalahan');
                }
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save me-2"></i>Update Data');
            }
        });
    });

    // Helper functions for edit modal
    function loadEditData(data, type) {
        const detailBarang = data.detail_barang;
        
        $('#edit_item_id').val(data.id);
        $('#edit_item_type').val(type);
        $('#edit_detail_barang_id').val(detailBarang.id);
        $('#edit_tanggal').val(data.tanggal);
        $('#edit_id_perangkat').val(detailBarang.id_perangkat).trigger('change');
        $('#edit_kategori').val(detailBarang.kategori);
        $('#edit_stok').val(data.jumlah);
        
        // Set jenis inventori
        $(`#edit_${type}`).prop('checked', true).trigger('change');
        
        // Set additional fields based on type
        if (type === 'masuk') {
            $('#edit_sumber').val(data.status);
            $('#edit_catatan').val(data.catatan_barang_masuk || '');
        } else {
            $('#edit_perihal').val(data.status);
            $('#edit_alamat').val(data.alamat || '');
            $('#edit_catatan').val(data.catatan_barang_keluar || '');
        }

        // Handle serial numbers
        editSerialNumbers = [];
        if (detailBarang.kategori === 'Listrik' && detailBarang.serial_number) {
            editSerialNumbers = [detailBarang.serial_number];
            $('#editSerialTotal').text(data.jumlah);
            updateEditSerialSection();
            updateEditSerialList();
        }
    }

    function updateEditSerialSection() {
        const stok = parseInt($('#edit_stok').val()) || 0;
        const kategori = $('#edit_kategori').val();
        
        if (stok > 0 && kategori === 'Listrik') {
            $('#editSerialSection').slideDown(300);
            $('#editSerialTotal').text(stok);
            updateEditSerialCounter();
        } else {
            $('#editSerialSection').slideUp(300);
            editSerialNumbers = [];
            updateEditSerialList();
        }
    }

    function updateEditSerialList() {
        const $list = $('#editSerialList');
        $list.empty();

        if (editSerialNumbers.length === 0) {
            $('#editSerialListWrapper').slideUp(300);
            return;
        }

        $('#editSerialListWrapper').slideDown(300);

        editSerialNumbers.forEach((serial, index) => {
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

        updateEditSerialCounter();
    }

    function updateEditSerialCounter() {
        $('#editSerialCount').text(editSerialNumbers.length);
    }

    function resetEditForm() {
        editSerialNumbers = [];
        $('#editForm')[0].reset();
        $('#editSerialCheck').html('').removeClass('text-success text-danger');
        $('#edit_serial_number_input').val('');
        $('#editBarangMasukSection, #editBarangKeluarSection, #editSerialSection').hide();
        $('#edit_sumber, #edit_perihal').prop('required', false);
        updateEditSerialList();
    }

    function showEditAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' : 'alert-danger';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('#editModal .alert').remove();
        
        // Add new alert
        $('#editModal .modal-body').prepend(alertHtml);
        
        // Auto remove after 5 seconds
        setTimeout(function() {
            $('#editModal .alert').alert('close');
        }, 5000);
    }
});
</script>