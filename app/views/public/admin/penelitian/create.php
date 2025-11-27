<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Tambah Penelitian
      </h4>

      <a href="<?= BASE_URL ?>/admin/penelitian" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Kembali
      </a>
    </div>

    <!-- NOTIFIKASI ERROR -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- FORM -->
    <div class="card">
      <h5 class="card-header">Form Tambah Penelitian</h5>
      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/penelitian/store" method="POST" enctype="multipart/form-data">

          <!-- Judul -->
          <div class="mb-3">
            <label class="form-label">Judul Penelitian</label>
            <input type="text" class="form-control" name="judul_penelitian" required>
          </div>

          <!-- Tim Peneliti (Checkbox List) -->
          <div class="mb-3">
            <label class="form-label">Tim Peneliti (Pilih Anggota) <span class="text-danger">*</span></label>

            <?php if (!empty($list_pengelola)): ?>
              <div class="border rounded p-3" style="max-height: 160px; overflow-y: auto; background-color: #f8f9fa;">
                <div class="row g-2">
                  <?php foreach ($list_pengelola as $p): ?>
                    <div class="col-md-6">
                      <div class="form-check p-3 border rounded bg-white">
                        <input 
                          class="form-check-input" 
                          type="checkbox" 
                          name="peneliti[]" 
                          value="<?= $p['id_pengelola'] ?>" 
                          id="peneliti_<?= $p['id_pengelola'] ?>">
                        <label class="form-check-label w-100" for="peneliti_<?= $p['id_pengelola'] ?>">
                          <strong><?= htmlspecialchars($p['nama_pengelola']) ?></strong><br>
                          <small class="text-muted"><?= htmlspecialchars($p['jabatan']) ?></small>
                        </label>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="form-text">
                <i class="bx bx-info-circle"></i> Centang satu atau lebih peneliti untuk dipilih.
              </div>
            <?php else: ?>
              <div class="alert alert-warning">
                <i class="bx bx-error-circle"></i> Belum ada data pengelola. Silakan tambahkan di menu Profil terlebih dahulu.
              </div>
            <?php endif; ?>
          </div>

          <!-- Tahun -->
          <div class="mb-3">
            <label class="form-label">Tahun Penelitian</label>
            <input type="number" min="1900" max="2100" class="form-control" name="tahun_penelitian" required>
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label">Abstrak</label>
            <textarea name="deskripsi_singkat" class="form-control" rows="4" required></textarea>
          </div>

          <!-- Link Publikasi -->
          <div class="mb-3">
            <label class="form-label">Link Publikasi</label>
            <input type="url" class="form-control" name="link_publikasi" placeholder="https://">
            <div class="form-text">
              <i class="bx bx-info-circle"></i> Opsional. Link ke jurnal atau publikasi online.
            </div>
          </div>

          <!-- Upload File PDF -->
          <div class="mb-3">
            <label class="form-label">Upload Dokumen Penelitian <span class="text-muted">(Opsional)</span></label>
            <input type="file" class="form-control" name="file_dokumen" accept=".pdf">
            <div class="form-text">
              <i class="bx bx-info-circle"></i> Format: PDF. Maksimal 10MB.
            </div>
          </div>

          <!-- BUTTONS -->
          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
            <a href="<?= BASE_URL ?>/admin/penelitian" class="btn btn-light">Batal</a>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

<script>
  // Validasi minimal 1 checkbox harus dipilih
  document.querySelector('form').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('input[name="peneliti[]"]:checked');
    if (checkboxes.length === 0) {
      e.preventDefault();
      alert('Silakan pilih minimal 1 anggota tim peneliti!');
    }
  });
</script>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
