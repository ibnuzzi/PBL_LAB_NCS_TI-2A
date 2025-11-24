<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Edit Dokumen Umum
      </h4>

      <a href="<?= BASE_URL ?>/admin/dokumen_umum" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Kembali
      </a>
    </div>

    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="card mb-4">
      <h5 class="card-header">Form Edit Dokumen Umum</h5>
      <div class="card-body">
        <form action="<?= BASE_URL ?>/admin/dokumen_umum/update/<?= (int)$dokumen['id_dokumen']; ?>"
              method="POST" enctype="multipart/form-data">

          <div class="mb-3">
            <label class="form-label">Judul Dokumen</label>
            <input type="text" name="nama_dokumen" class="form-control"
                   value="<?= htmlspecialchars($dokumen['nama_dokumen']); ?>" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi Dokumen</label>
            <textarea name="deskripsi_dokumen" rows="4" class="form-control" required><?= htmlspecialchars($dokumen['deskripsi_dokumen']); ?></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Ganti File (Opsional)</label>
            <input type="file" name="nama_file_dokumen" class="form-control">
            <small class="text-muted">
              File saat ini: <?= htmlspecialchars($dokumen['nama_file_dokumen']); ?>
            </small>
          </div>

          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">
              <i class="bx bx-save"></i> Update
            </button>
            <a href="<?= BASE_URL ?>/admin/dokumen_umum" class="btn btn-light">
              Batal
            </a>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
