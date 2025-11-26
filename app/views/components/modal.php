<div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-white">
                <div>
                    <h5 class="modal-title mb-0" data-fill-text="judul">Detail</h5>
                    <small class="opacity-75">Informasi Lengkap</small>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Preview Gambar -->
                <div class="mb-4 text-center">
                    <label class="form-label fw-bold text-muted small mb-2">
                        <i class="bx bx-image"></i> PREVIEW GAMBAR
                    </label>
                    <div class="border rounded p-2 bg-light">
                        <img data-fill-src="gambar" src="" alt="Gambar" class="img-fluid rounded" style="max-height: 350px; object-fit: contain;" />
                    </div>
                </div>

                <hr class="my-3">

                <!-- Tanggal (jika ada) -->
                <div class="mb-3" data-section="tanggal">
                    <label class="form-label fw-bold text-muted small mb-1">
                        <i class="bx bx-calendar"></i> TANGGAL
                    </label>
                    <p class="fs-6 mb-0">
                        <span data-fill-text="tanggal">-</span>
                    </p>
                </div>

                <hr class="my-3" data-section="tanggal">

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label class="form-label fw-bold text-muted small mb-1">
                        <i class="bx bx-file-blank"></i> DESKRIPSI
                    </label>
                    <div class="bg-light p-3 rounded">
                        <p data-fill-text="deskripsi" class="mb-0">-</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-fill modal universal dengan data attributes
document.addEventListener("DOMContentLoaded", function() {
    const modalDetail = document.getElementById('modalDetail');
    
    if (modalDetail) {
        modalDetail.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            // Fill text elements
            modalDetail.querySelectorAll('[data-fill-text]').forEach(el => {
                const key = el.getAttribute('data-fill-text');
                const value = button.getAttribute('data-' + key) || '-';
                el.textContent = value;
                
                // Hide section if tanggal is empty or '-'
                if (key === 'tanggal' && (value === '-' || value === '')) {
                    modalDetail.querySelectorAll('[data-section="tanggal"]').forEach(section => {
                        section.style.display = 'none';
                    });
                } else {
                    modalDetail.querySelectorAll('[data-section="tanggal"]').forEach(section => {
                        section.style.display = '';
                    });
                }
            });
            
            // Fill image source
            modalDetail.querySelectorAll('[data-fill-src]').forEach(el => {
                const key = el.getAttribute('data-fill-src');
                const value = button.getAttribute('data-' + key);
                if (value) {
                    el.setAttribute('src', value);
                }
            });
        });
    }
});
</script>