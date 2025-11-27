<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Edit Pengabdian
      </h4>

      <a href="<?= BASE_URL ?>/admin/pengabdian" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Kembali
      </a>
    </div>

    <!-- NOTIFIKASI -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- FORM EDIT -->
    <div class="card mb-4">
      <h5 class="card-header">Form Edit Pengabdian</h5>

      <div class="card-body">
        <form action="<?= BASE_URL ?>/admin/pengabdian/update/<?= $pengabdian['id_pengabdian'] ?>"
          method="POST"
          enctype="multipart/form-data">

          <!-- Judul -->
          <div class="mb-3">
            <label class="form-label">Judul Pengabdian</label>
            <input type="text"
              class="form-control"
              name="judul_pengabdian"
              value="<?= htmlspecialchars($pengabdian['judul_kegiatan']); ?>"
              required>
          </div>

          <!-- Tim Pengabdi (Checkbox List) -->
          <div class="mb-3">
            <label class="form-label">Tim Pengabdi <span class="text-danger">*</span></label>

            <?php if (!empty($list_pengelola)): ?>
              <div class="border rounded p-3" style="max-height: 160px; overflow-y: auto; background-color: #f8f9fa;">
                <div class="row g-2">
                  <?php foreach ($list_pengelola as $p): ?>
                    <?php
                    // LOGIKA PRE-SELECTED
                    // Cek apakah ID pengelola ini ada di array $selected_anggota
                    $isChecked = in_array($p['id_pengelola'], $selected_anggota) ? 'checked' : '';
                    ?>
                    
                    <div class="col-md-6">
                      <div class="form-check p-3 border rounded bg-white">
                        <input 
                          class="form-check-input" 
                          type="checkbox" 
                          name="anggota[]" 
                          value="<?= $p['id_pengelola'] ?>" 
                          id="anggota_<?= $p['id_pengelola'] ?>"
                          <?= $isChecked ?>>
                        <label class="form-check-label w-100" for="anggota_<?= $p['id_pengelola'] ?>">
                          <strong><?= htmlspecialchars($p['nama_pengelola']) ?></strong><br>
                          <small class="text-muted"><?= htmlspecialchars($p['jabatan']) ?></small>
                        </label>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
              <div class="form-text">
                <i class="bx bx-info-circle"></i> Centang satu atau lebih anggota tim untuk dipilih.
              </div>
            <?php else: ?>
              <div class="alert alert-warning">
                <i class="bx bx-error-circle"></i> Belum ada data pengelola. Silakan tambahkan di menu Profil terlebih dahulu.
              </div>
            <?php endif; ?>
          </div>

          <!-- Tahun -->
          <div class="mb-3">
            <label class="form-label">Tahun</label>
            <input type="number"
              min="1900"
              max="2100"
              class="form-control"
              name="tahun_pengabdian"
              value="<?= htmlspecialchars($pengabdian['tahun_kegiatan']); ?>"
              required>
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label">Abstrak</label>
            <textarea class="form-control"
              name="deskripsi_kegiatan"
              rows="4"
              required><?= htmlspecialchars($pengabdian['deskripsi_kegiatan']); ?></textarea>
          </div>

          <!-- FILE PDF -->
          <div class="mb-3">
            <label class="form-label">File Dokumen (PDF)</label>
            <input type="file"
              class="form-control"
              name="file_dokumen"
              accept="application/pdf">

            <?php if (!empty($pengabdian['file_dokumen_pdf'])): ?>
              <div class="mt-2">
                <small class="text-muted d-block">File saat ini:</small>
                <a href="<?= BASE_URL . '/public/uploads/pengabdian/' . $pengabdian['file_dokumen_pdf']; ?>"
                  target="_blank"
                  class="btn btn-sm btn-info mt-1">
                  <i class="bx bx-file"></i> Lihat PDF
                </a>
              </div>
            <?php endif; ?>

            <small class="text-muted d-block mt-2">Kosongkan jika tidak ingin mengganti file.</small>
          </div>

          <!-- ACTION -->
          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">
              <i class="bx bx-save"></i> Simpan Perubahan
            </button>

            <a href="<?= BASE_URL ?>/admin/pengabdian" class="btn btn-light">
              Batal
            </a>
          </div>

        </form>
      </div>
    </div>

  </div>

</div>

<script>
  // Validasi minimal 1 checkbox harus dipilih
  document.querySelector('form').addEventListener('submit', function(e) {
    const checkboxes = document.querySelectorAll('input[name="anggota[]"]:checked');
    if (checkboxes.length === 0) {
      e.preventDefault();
      alert('Silakan pilih minimal 1 anggota tim pengabdi!');
    }
  });
</script>

<?php include './app/views/templates/admin/footer_admin.php'; ?>