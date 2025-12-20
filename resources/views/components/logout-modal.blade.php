{{-- resources/views/components/logout-modal.blade.php --}}

<!-- Logout Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content logout-modal-content">
            <!-- Icon -->
            <div class="logout-modal-icon">
                <div class="icon-circle">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
            </div>
            
            <!-- Content -->
            <div class="modal-body text-center">
                <h5 class="logout-modal-title">Konfirmasi Logout</h5>
                <p class="logout-modal-text">
                    Apakah Anda yakin ingin keluar dari sistem?<br>
                    Anda harus login kembali untuk mengakses sistem.
                </p>
            </div>
            
            <!-- Actions -->
            <div class="logout-modal-actions">
                <button type="button" class="btn-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </button>
                <form action="{{ route('logout') }}" method="POST" class="d-inline form-logout">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Ya, Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* ==================== LOGOUT MODAL STYLES ==================== */
.logout-modal-content {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    padding: 2rem 1.5rem 1.5rem;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    width: 100%;
    box-sizing: border-box;
}

/* Icon Section */
.logout-modal-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
    width: 100%;
}

.icon-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    animation: pulse 2s ease-in-out infinite;
}

.icon-circle::before {
    content: '';
    position: absolute;
    inset: -8px;
    border: 2px solid #fecaca;
    border-radius: 50%;
    opacity: 0.5;
}

.icon-circle i {
    font-size: 32px;
    color: #dc2626;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

/* Content */
.logout-modal-title {
    color: #1e3a8a;
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 0.75rem;
    line-height: 1.3;
}

.logout-modal-text {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 0;
}

/* Actions */
.logout-modal-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
    padding-top: 1.5rem;
    border-top: 1px solid #e5e7eb;
    width: 100%;
    box-sizing: border-box;
}

/* Form styling */
.form-logout {
    flex: 1;
    margin: 0;
    padding: 0;
    display: block;
}

.btn-cancel,
.btn-logout {
    flex: 1;
    min-width: 120px;
    padding: 0.875rem 1rem;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    height: 46px;
    line-height: 1;
    text-align: center;
    white-space: nowrap;
    box-sizing: border-box;
    position: relative;
}

/* Button Cancel */
.btn-cancel {
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
    color: #4b5563;
    border: 1px solid #d1d5db;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    text-decoration: none;
}

.btn-cancel:hover {
    background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
    color: #374151;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-color: #9ca3af;
}

.btn-cancel:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

/* Button Logout */
.btn-logout {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    color: white;
    box-shadow: 0 4px 8px rgba(220, 38, 38, 0.25);
    border: 1px solid #b91c1c;
    width: 100%;
    margin: 0;
    position: relative;
    overflow: hidden;
}

.btn-logout:hover {
    background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(220, 38, 38, 0.3);
    border-color: #991b1b;
}

.btn-logout:active {
    transform: translateY(0);
    box-shadow: 0 4px 8px rgba(220, 38, 38, 0.25);
}

/* Add glow effect for logout button */
.btn-logout::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
    opacity: 0;
    transition: opacity 0.3s ease;
    pointer-events: none;
}

.btn-logout:hover::after {
    opacity: 1;
}

/* Icons */
.btn-cancel i,
.btn-logout i {
    font-size: 14px;
    flex-shrink: 0;
    line-height: 1;
}

/* Text in buttons */
.btn-cancel span,
.btn-logout span {
    display: inline-block;
    line-height: 1;
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* Focus states for accessibility */
.btn-cancel:focus-visible,
.btn-logout:focus-visible {
    outline: none;
}

.btn-cancel:focus-visible {
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.4), 0 2px 4px rgba(0, 0, 0, 0.05);
}

.btn-logout:focus-visible {
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.5), 0 4px 8px rgba(220, 38, 38, 0.25);
}

/* Modal Animation */
.modal.fade .modal-dialog {
    transform: scale(0.8);
    opacity: 0;
    transition: all 0.3s ease-out;
}

.modal.show .modal-dialog {
    transform: scale(1);
    opacity: 1;
}

/* Modal dialog size */
.modal-dialog {
    max-width: 400px;
    margin: 1.75rem auto;
}

.modal-body {
    padding: 0;
}

/* Responsive Design */
@media (max-width: 576px) {
    .logout-modal-content {
        padding: 1.5rem 1rem 1rem;
    }
    
    .icon-circle {
        width: 70px;
        height: 70px;
    }
    
    .icon-circle i {
        font-size: 28px;
    }
    
    .logout-modal-title {
        font-size: 18px;
    }
    
    .logout-modal-text {
        font-size: 13px;
    }
    
    .logout-modal-actions {
        flex-direction: row;
        gap: 0.5rem;
    }
    
    .btn-cancel,
    .btn-logout {
        flex: 1;
        min-width: 0;
        font-size: 13px;
        padding: 0.75rem 0.5rem;
        height: 42px;
    }
    
    .btn-cancel i,
    .btn-logout i {
        font-size: 13px;
        margin-right: 0.25rem;
    }
    
    .modal-dialog {
        margin: 1rem auto;
        max-width: 95%;
    }
}

/* For very small screens */
@media (max-width: 400px) {
    .logout-modal-actions {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .btn-cancel,
    .btn-logout {
        width: 100%;
    }
    
    .logout-modal-content {
        padding: 1.25rem 0.75rem 0.75rem;
    }
}

/* Loading state for buttons */
.btn-logout.loading,
.btn-cancel.loading {
    opacity: 0.7;
    cursor: wait;
}

.btn-logout.loading i,
.btn-cancel.loading i {
    animation: spin 1s linear infinite;
    margin-right: 0.5rem;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* Modal backdrop */
.modal-backdrop.show {
    opacity: 0.5;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get modal elements
    const logoutModal = document.getElementById('logoutModal');
    const cancelBtn = logoutModal.querySelector('.btn-cancel');
    const logoutBtn = logoutModal.querySelector('.btn-logout');
    const logoutForm = logoutModal.querySelector('.form-logout');
    
    // Handle logout button click
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            // Add loading state
            logoutBtn.classList.add('loading');
            logoutBtn.disabled = true;
            logoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';
            
            // Submit form after short delay for visual feedback
            setTimeout(() => {
                if (logoutForm) {
                    logoutForm.submit();
                }
            }, 500);
        });
    }
    
    // Handle cancel button click
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            const modal = bootstrap.Modal.getInstance(logoutModal);
            if (modal) {
                modal.hide();
            }
        });
    }
    
    // Reset button state when modal is hidden
    logoutModal.addEventListener('hidden.bs.modal', function() {
        if (logoutBtn) {
            logoutBtn.classList.remove('loading');
            logoutBtn.disabled = false;
            logoutBtn.innerHTML = '<i class="fas fa-sign-out-alt"></i><span>Ya, Logout</span>';
        }
    });
    
    // Keyboard support
    logoutModal.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = bootstrap.Modal.getInstance(logoutModal);
            if (modal) {
                modal.hide();
            }
        }
        
        if (e.key === 'Enter' && document.activeElement === logoutBtn) {
            logoutBtn.click();
        }
    });
});
</script>