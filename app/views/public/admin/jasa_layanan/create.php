<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold mb-0">
        <span class="text-muted fw-light">Manajemen Layanan /</span> Tambah Jasa dan Layanan
      </h4>
      <a href="<?= BASE_URL ?>/admin/jasa-layanan" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <div class="card">
      <h5 class="card-header">Form Tambah Layanan</h5>
      <div class="card-body">
        <form action="<?= BASE_URL ?>/admin/jasa-layanan/store" method="POST">
          <div class="mb-3">
            <label class="form-label">Nama Layanan</label>
            <input type="text" name="nama_layanan" class="form-control" placeholder="Masukkan nama layanan" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Deskripsi Layanan</label>
            <textarea name="deskripsi_layanan" rows="4" class="form-control" placeholder="Tuliskan deskripsi layanan..."></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Icon Layanan (mis. nama class Boxicons)</label>
            <input type="text" name="icon_layanan" class="form-control" placeholder="Contoh: bx bx-network-chart">
            <small class="text-muted">Opsional. Isi dengan class icon jika ingin pakai icon di frontend.</small>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> Simpan
          </button>
          <a href="<?= BASE_URL ?>/admin/jasa-layanan" class="btn btn-outline-secondary">Batal</a>
        </form>
      </div>
    </div>
  </div>

  <?php include './app/views/templates/admin/footer_admin.php'; ?>
</div>
