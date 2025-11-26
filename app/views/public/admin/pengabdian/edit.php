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

          <div class="mb-3">
            <label class="form-label">Tim Pengabdi <span class="text-danger">*</span></label>

            <select class="form-select"
              name="anggota[]"
              multiple
              required
              style="height: 150px;">

              <?php if (!empty($list_pengelola)): ?>
                <?php foreach ($list_pengelola as $p): ?>

                  <?php
                  // LOGIKA PRE-SELECTED
                  // Cek apakah ID pengelola ini ada di array $selected_anggota
                  $isSelected = in_array($p['id_pengelola'], $selected_anggota) ? 'selected' : '';
                  ?>

                  <option value="<?= $p['id_pengelola'] ?>" <?= $isSelected ?>>
                    <?= htmlspecialchars($p['nama_pengelola']) ?>
                    (<?= htmlspecialchars($p['jabatan']) ?>)
                  </option>

                <?php endforeach; ?>
              <?php endif; ?>

            </select>
            <div class="form-text text-muted">
              Tahan tombol <strong>CTRL</strong> / <strong>CMD</strong> untuk mengubah pilihan tim.
            </div>
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
            <label class="form-label">Deskripsi Kegiatan</label>
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

<?php include './app/views/templates/admin/footer_admin.php'; ?>