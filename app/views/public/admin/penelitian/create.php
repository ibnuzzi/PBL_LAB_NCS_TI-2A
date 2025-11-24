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

        <form action="<?= BASE_URL ?>/admin/penelitian/store" method="POST">

          <!-- Judul -->
          <div class="mb-3">
            <label class="form-label">Judul Penelitian</label>
            <input type="text" class="form-control" name="judul_penelitian" required>
          </div>

          <!-- Peneliti -->
          <div class="mb-3">
            <label class="form-label">Peneliti</label>
            <input type="text" class="form-control" name="peneliti" required>
          </div>

          <!-- Tahun -->
          <div class="mb-3">
            <label class="form-label">Tahun Penelitian</label>
            <input type="number" min="1900" max="2100" class="form-control" name="tahun_penelitian" required>
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="deskripsi_singkat" class="form-control" rows="4" required></textarea>
          </div>

          <!-- Link Publikasi -->
          <div class="mb-3">
            <label class="form-label">Link Publikasi</label>
            <input type="url" class="form-control" name="link_publikasi" placeholder="https://">
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

<?php include './app/views/templates/admin/footer_admin.php'; ?>
