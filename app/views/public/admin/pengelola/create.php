<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Struktur Pengelola /</span> Tambah Pengelola
      </h4>

      <a href="<?= BASE_URL ?>/admin/pengelola" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Kembali
      </a>
    </div>

    <!-- ALERT -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="card mb-4">
      <h5 class="card-header">Form Tambah Pengelola</h5>

      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/pengelola/store" method="POST" enctype="multipart/form-data">

          <!-- Nama -->
          <div class="mb-3">
            <label class="form-label">Nama Pengelola</label>
            <input type="text" name="nama_pengelola" class="form-control" required>
          </div>

          <!-- Jabatan -->
          <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
          </div>

          <!-- Urutan -->
          <div class="mb-3">
            <label class="form-label">Urutan Tampil</label>
            <input type="number" name="urutan" class="form-control" min="1" value="1" required>
          </div>

          <!-- Foto -->
          <div class="mb-3">
            <label class="form-label">Foto Pengelola</label>
            <input type="file" name="foto_pengelola" class="form-control" accept="image/*" required>
            <small class="text-muted">Format JPG/PNG/GIF. Maksimal 5MB.</small>
          </div>

          <button class="btn btn-primary">
            <i class="bx bx-save"></i> Simpan
          </button>

        </form>

      </div>
    </div>

  </div>

</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
