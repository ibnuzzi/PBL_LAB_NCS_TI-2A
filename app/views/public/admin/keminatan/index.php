<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex align-items-center justify-content-between mb-4">
      <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Manajemen Data /</span> Kelola Minat & Keilmuan
      </h4>
      <button type="button" class="btn btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modalKeminatan">
        <i class="bx bx-plus me-1"></i> Tambah Keminatan
      </button>
    </div>

    <div class="card">
      <h5 class="card-header">Daftar Keminatan / Keilmuan</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th style="width: 70px;">No</th>
              <th>Nama Keminatan</th>
              <th>Deskripsi</th>
              <th style="width: 150px;">Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php if (empty($keminatan_list) || !is_array($keminatan_list)): ?>
              <tr>
                <td colspan="4" class="text-center py-5 text-muted">
                  <i class="bx bx-book-bookmark bx-lg mb-2"></i>
                  <p>Belum ada data keminatan.</p>
                </td>
              </tr>
            <?php else: ?>
              <?php $no = 1; foreach ($keminatan_list as $row): ?>
                <tr>
                  <td><strong><?= $no++ ?></strong></td>
                  <td>
                    <span class="fw-medium"><?= htmlspecialchars($row['nama_keminatan']) ?></span>
                  </td>
                  <td><?= htmlspecialchars($row['deskripsi'] ?? '-') ?></td>
                  <td>
                    <button type="button" 
                            class="btn btn-sm btn-outline-info btn-edit"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalKeminatan"
                            data-id="<?= $row['id_keminatan'] ?>"
                            data-nama="<?= htmlspecialchars($row['nama_keminatan']) ?>"
                            data-deskripsi="<?= htmlspecialchars($row['deskripsi'] ?? '') ?>">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </button>

                    <a href="<?= BASE_URL ?>/admin/minat_ilmu/delete/<?= $row['id_keminatan'] ?>" 
                       class="btn btn-sm btn-outline-danger ms-1 btn-delete">
                      <i class="bx bx-trash me-1"></i> Hapus
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="content-backdrop fade"></div>
</div>

<?php
  include './app/views/components/modal.php';
  include './app/views/components/toaster.php';
?>

<!-- Modal Keminatan -->
<div class="modal fade" id="modalKeminatan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title text-white" id="modalTitle">Tambah Keminatan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="formKeminatan" action="<?= BASE_URL ?>/admin/minat_ilmu/store" method="POST">
        <div class="modal-body">
          
          <input type="hidden" name="id_keminatan" id="modal_id_keminatan">

          <div class="mb-3">
            <label class="form-label">Nama Keminatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nama_keminatan" id="modal_nama_keminatan" placeholder="Contoh: Jaringan Komputer" required>
            <div class="form-text">Nama bidang keminatan atau keilmuan.</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="modal_deskripsi" rows="3" placeholder="Deskripsi keminatan (opsional)"></textarea>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php 
include './app/views/templates/admin/footer_admin.php'; 
include './app/views/components/page_scripts.php';
?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('modalKeminatan');
    const form = document.getElementById('formKeminatan');
    const modalTitle = document.getElementById('modalTitle');
    
    const inputId = document.getElementById('modal_id_keminatan');
    const inputNama = document.getElementById('modal_nama_keminatan');
    const inputDeskripsi = document.getElementById('modal_deskripsi');

    const baseUrl = '<?= BASE_URL ?>';

    // Logic saat Tombol TAMBAH diklik
    document.querySelector('.btn-tambah').addEventListener('click', function() {
      modalTitle.textContent = 'Tambah Keminatan Baru';
      form.action = baseUrl + '/admin/minat_ilmu/store';
      
      // Reset Form
      inputId.value = '';
      inputNama.value = '';
      inputDeskripsi.value = '';
    });

    // Logic saat Tombol EDIT diklik
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        const id = this.getAttribute('data-id');
        const nama = this.getAttribute('data-nama');
        const deskripsi = this.getAttribute('data-deskripsi');

        modalTitle.textContent = 'Edit Keminatan';
        form.action = baseUrl + '/admin/minat_ilmu/update';

        inputId.value = id;
        inputNama.value = nama;
        inputDeskripsi.value = deskripsi;
      });
    });
  });
</script>
