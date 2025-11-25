<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">Tambah Agenda</h4>

      <a href="<?= BASE_URL ?>/admin/agenda" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <div class="card mb-4">
      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/agenda/store" method="POST" enctype="multipart/form-data">

          <!-- NAMA AGENDA -->
          <div class="mb-3">
            <label class="form-label">Nama Agenda</label>
            <input
              type="text"
              class="form-control"
              name="nama_agenda"
              placeholder="Masukkan nama agenda"
              value="<?= htmlspecialchars($agenda['nama_agenda'] ?? '') ?>"
              required
            >
          </div>

          <!-- LOKASI -->
          <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input
              type="text"
              class="form-control"
              name="lokasi"
              placeholder="Tempat agenda berlangsung"
              value="<?= htmlspecialchars($agenda['lokasi'] ?? '') ?>"
            >
          </div>

          <!-- DESKRIPSI -->
          <div class="mb-3">
            <label class="form-label">Deskripsi Agenda</label>
            <textarea
              class="form-control"
              name="deskripsi_agenda"
              rows="4"
              placeholder="Tuliskan deskripsi agenda..."
            ><?= htmlspecialchars($agenda['deskripsi_agenda'] ?? '') ?></textarea>
          </div>

          <!-- TANGGAL MULAI & SELESAI -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input
                type="datetime-local"
                class="form-control"
                name="tanggal_mulai"
                value="<?= isset($agenda['tanggal_mulai']) ? date('Y-m-d\TH:i', strtotime($agenda['tanggal_mulai'])) : '' ?>"
              >
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input
                type="datetime-local"
                class="form-control"
                name="tanggal_selesai"
                value="<?= isset($agenda['tanggal_selesai']) ? date('Y-m-d\TH:i', strtotime($agenda['tanggal_selesai'])) : '' ?>"
              >
            </div>
          </div>

          <!-- GAMBAR -->
          <div class="mb-3">
            <label class="form-label">Gambar Agenda</label>
            <input
              type="file"
              class="form-control"
              name="gambar_agenda"
              id="gambarInput"
              accept="image/*"
            >
            <small class="text-muted">Format JPG/PNG — Max 5MB</small>

            <!-- Preview -->
            <div class="mt-3">
              <img id="previewGambar" src="#" alt="" style="display:none; width:220px; border-radius:6px;">
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> Simpan
          </button>

          <button type="reset" class="btn btn-light">Reset</button>

        </form>

      </div>
    </div>

  </div>

  <footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
      © <?= date("Y") ?>, Lab NCS
    </div>
  </footer>

</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>


<!-- PREVIEW GAMBAR -->
<script>
document.getElementById("gambarInput").addEventListener("change", function(event) {
    const preview = document.getElementById("previewGambar");
    const file = event.target.files[0];

    if (file) {
        preview.style.display = "block";
        preview.src = URL.createObjectURL(file);
    } else {
        preview.style.display = "none";
    }
});
</script>
