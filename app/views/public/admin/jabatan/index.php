<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex align-items-center justify-content-between mb-4">
      <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Manajemen Data /</span> Kelola Jabatan
      </h4>
      <button type="button" class="btn btn-primary btn-tambah" data-bs-toggle="modal" data-bs-target="#modalJabatan">
        <i class="bx bx-plus me-1"></i> Tambah Jabatan
      </button>
    </div>

    <div class="card">
      <h5 class="card-header">Daftar Jabatan</h5>
      <div class="table-responsive text-nowrap">
        <table class="table table-hover">
          <thead class="table-light">
            <tr>
              <th style="width: 70px;">No</th>
              <th>Nama Jabatan</th>
              <th>Deskripsi</th>
              <th style="width: 150px;">Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php if (empty($jabatan_list) || !is_array($jabatan_list)): ?>
              <tr>
                <td colspan="4" class="text-center py-5 text-muted">
                  <i class="bx bx-briefcase-alt-2 bx-lg mb-2"></i>
                  <p>Belum ada data jabatan.</p>
                </td>
              </tr>
            <?php else: ?>
              <?php $no = 1; foreach ($jabatan_list as $row): ?>
                <tr>
                  <td><strong><?= $no++ ?></strong></td>
                  <td>
                    <span class="fw-medium"><?= htmlspecialchars($row['nama_jabatan']) ?></span>
                  </td>
                  <td><?= htmlspecialchars($row['deskripsi'] ?? '-') ?></td>
                  <td>
                    <button type="button" 
                            class="btn btn-sm btn-outline-info btn-edit"
                            data-bs-toggle="modal" 
                            data-bs-target="#modalJabatan"
                            data-id="<?= $row['id_jabatan'] ?>"
                            data-nama="<?= htmlspecialchars($row['nama_jabatan']) ?>"
                            data-deskripsi="<?= htmlspecialchars($row['deskripsi'] ?? '') ?>">
                      <i class="bx bx-edit-alt me-1"></i> Edit
                    </button>

                    <a href="<?= BASE_URL ?>/admin/jabatan/delete/<?= $row['id_jabatan'] ?>" 
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

<!-- Modal Jabatan -->
<div class="modal fade" id="modalJabatan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title text-white" id="modalTitle">Tambah Jabatan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <form id="formJabatan" action="<?= BASE_URL ?>/admin/jabatan/store" method="POST">
        <div class="modal-body">
          
          <input type="hidden" name="id_jabatan" id="modal_id_jabatan">

          <div class="mb-3">
            <label class="form-label">Nama Jabatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nama_jabatan" id="modal_nama_jabatan" placeholder="Contoh: Kepala Laboratorium" required>
            <div class="form-text">Nama jabatan untuk pengelola laboratorium.</div>
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea class="form-control" name="deskripsi" id="modal_deskripsi" rows="3" placeholder="Deskripsi jabatan (opsional)"></textarea>
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
    const modal = document.getElementById('modalJabatan');
    const form = document.getElementById('formJabatan');
    const modalTitle = document.getElementById('modalTitle');
    
    const inputId = document.getElementById('modal_id_jabatan');
    const inputNama = document.getElementById('modal_nama_jabatan');
    const inputDeskripsi = document.getElementById('modal_deskripsi');

    const baseUrl = '<?= BASE_URL ?>';

    // Logic saat Tombol TAMBAH diklik
    document.querySelector('.btn-tambah').addEventListener('click', function() {
      modalTitle.textContent = 'Tambah Jabatan Baru';
      form.action = baseUrl + '/admin/jabatan/store';
      
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

        modalTitle.textContent = 'Edit Jabatan';
        form.action = baseUrl + '/admin/jabatan/update';

        inputId.value = id;
        inputNama.value = nama;
        inputDeskripsi.value = deskripsi;
      });
    });
  });
</script>
