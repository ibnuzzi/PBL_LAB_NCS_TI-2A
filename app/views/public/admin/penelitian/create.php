<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER + BACK BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Tambah Penelitian
      </h4>

      <a href="<?php echo BASE_URL; ?>/admin/penelitian" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <!-- CARD -->
    <div class="card mb-4">
      <h5 class="card-header">Form Tambah Penelitian</h5>

      <div class="card-body">

        <form action="<?php echo BASE_URL; ?>/admin/penelitian/store" method="POST">

          <!-- Judul -->
          <div class="mb-3">
            <label for="judul_penelitian" class="form-label">Judul Penelitian</label>
            <input type="text" class="form-control" id="judul_penelitian" name="judul_penelitian" required>
          </div>

          <!-- Peneliti -->
          <div class="mb-3">
            <label for="peneliti" class="form-label">Peneliti</label>
            <input type="text" class="form-control" id="peneliti" name="peneliti" required>
          </div>

          <!-- Tahun -->
          <div class="mb-3">
            <label for="tahun_penelitian" class="form-label">Tahun Penelitian</label>
            <input type="number" class="form-control" id="tahun_penelitian" name="tahun_penelitian" required>
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
            <textarea class="form-control" id="deskripsi_singkat" name="deskripsi_singkat" rows="4" required></textarea>
          </div>

          <!-- Link -->
          <div class="mb-3">
            <label for="link_publikasi" class="form-label">Link Publikasi</label>
            <input type="url" class="form-control" id="link_publikasi" name="link_publikasi" placeholder="https://...">
          </div>

          <!-- Buttons -->
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> Simpan
          </button>

          <button type="reset" class="btn btn-light">
            Reset
          </button>

        </form>

      </div>
    </div>

  </div>

  

  <div class="content-backdrop fade"></div>
</div>

<?php
include './app/views/templates/admin/footer_admin.php';
?>
