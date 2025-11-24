<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Edit Penelitian
      </h4>

      <a href="<?= BASE_URL ?>/admin/penelitian" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <div class="card mb-4">
      <h5 class="card-header">Form Edit Penelitian</h5>

      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/penelitian/update/<?= htmlspecialchars($penelitian['id_penelitian']); ?>" method="POST">

          <!-- Judul -->
          <div class="mb-3">
            <label for="judul_penelitian" class="form-label">Judul Penelitian</label>
            <input
              type="text"
              class="form-control"
              id="judul_penelitian"
              name="judul_penelitian"
              value="<?= htmlspecialchars($penelitian['judul_penelitian']); ?>"
              required
            >
          </div>

          <!-- Peneliti -->
          <div class="mb-3">
            <label for="peneliti" class="form-label">Peneliti</label>
            <input
              type="text"
              class="form-control"
              id="peneliti"
              name="peneliti"
              value="<?= htmlspecialchars($penelitian['peneliti']); ?>"
              required
            >
          </div>

          <!-- Tahun -->
          <div class="mb-3">
            <label for="tahun_penelitian" class="form-label">Tahun Penelitian</label>
            <input
              type="number"
              class="form-control"
              id="tahun_penelitian"
              name="tahun_penelitian"
              value="<?= htmlspecialchars($penelitian['tahun_penelitian']); ?>"
              required
            >
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
            <textarea
              class="form-control"
              id="deskripsi_singkat"
              name="deskripsi_singkat"
              rows="4"
              required
            ><?= htmlspecialchars($penelitian['deskripsi_singkat']); ?></textarea>
          </div>

          <!-- Link Publikasi -->
          <div class="mb-3">
            <label for="link_publikasi" class="form-label">Link Publikasi</label>
            <input
              type="url"
              class="form-control"
              id="link_publikasi"
              name="link_publikasi"
              value="<?= htmlspecialchars($penelitian['link_publikasi']); ?>"
              placeholder="https://..."
            >
          </div>

          <!-- BUTTONS -->
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> Simpan Perubahan
          </button>

          <a href="<?= BASE_URL ?>/admin/penelitian" class="btn btn-light ms-2">
            Batal
          </a>

        </form>

      </div>
    </div>

  </div>

  <!-- FOOTER -->
  <footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        © <script>document.write(new Date().getFullYear());</script>, Lab NCS
      </div>
    </div>
  </footer>

  <div class="content-backdrop fade"></div>
</div>

<?php
include './app/views/templates/admin/footer_admin.php';
?>
