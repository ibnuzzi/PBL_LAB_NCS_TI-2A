<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Struktur Pengelola /</span> Edit Pengelola
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
      <h5 class="card-header">Form Edit Pengelola</h5>

      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/pengelola/update/<?= $pengelola['id_pengelola'] ?>" method="POST" enctype="multipart/form-data">

          <!-- Nama -->
          <div class="mb-3">
            <label class="form-label">Nama Pengelola</label>
            <input type="text" name="nama_pengelola" class="form-control"
                   value="<?= htmlspecialchars($pengelola['nama_pengelola']) ?>" required>
          </div>

          <!-- Jabatan -->
          <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control"
                   value="<?= htmlspecialchars($pengelola['jabatan']) ?>" required>
          </div>

          <!-- Urutan -->
          <div class="mb-3">
            <label class="form-label">Urutan Tampil</label>
            <input type="number" name="urutan" class="form-control" min="1"
                   value="<?= htmlspecialchars($pengelola['urutan']) ?>" required>
          </div>

          <!-- Foto Lama -->
          <div class="mb-3">
            <label class="form-label">Foto Saat Ini</label>
            <br>
            <?php if (!empty($pengelola['foto_pengelola'])): ?>
              <img src="<?= BASE_URL ?>/public/uploads/pengelola/<?= htmlspecialchars($pengelola['foto_pengelola']) ?>"
                   style="height:120px;border-radius:8px;">
            <?php else: ?>
              <div class="text-muted fst-italic">Tidak ada foto</div>
            <?php endif; ?>
          </div>

          <!-- Upload Foto Baru -->
          <div class="mb-3">
            <label class="form-label">Ganti Foto (Opsional)</label>
            <input type="file" name="foto_pengelola" class="form-control" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
          </div>

          <button class="btn btn-primary">
            <i class="bx bx-save"></i> Update
          </button>

        </form>

      </div>
    </div>

  </div>

</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
