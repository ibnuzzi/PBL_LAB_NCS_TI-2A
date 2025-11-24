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
        <div class="card-body">
          <p>Penambahan data konsultasi tidak dilakukan oleh admin secara manual. Mohon arahkan pengguna untuk menggunakan form pengajuan pertanyaan pada halaman publik.</p>
          <a href="<?= BASE_URL ?>/admin/konsultasi" class="btn btn-primary">Kembali ke Daftar Konsultasi</a>
        </div>
      </div>
    </div>
  </div>

  <?php include './app/views/templates/admin/footer_admin.php'; ?>
</div>
