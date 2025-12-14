<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">Edit Agenda</h4>

      <a href="<?= BASE_URL ?>/admin/agenda" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <div class="card mb-4">
      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/agenda/update/<?= htmlspecialchars($agenda['id_agenda']) ?>"
          method="POST" enctype="multipart/form-data">

          <!-- Nama Agenda -->
          <div class="mb-3">
            <label class="form-label">Nama Agenda</label>
            <input
              type="text"
              class="form-control"
              name="nama_agenda"
              value="<?= htmlspecialchars($agenda['nama_agenda']) ?>"
              required>
          </div>

          <!-- Lokasi -->
          <div class="mb-3">
            <label class="form-label">Lokasi</label>
            <input
              type="text"
              class="form-control"
              name="lokasi"
              value="<?= htmlspecialchars($agenda['lokasi']) ?>">
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label">Deskripsi Agenda</label>
            <textarea
              class="form-control"
              name="deskripsi_agenda"
              rows="4"><?= htmlspecialchars($agenda['deskripsi_agenda'] ?? '') ?></textarea>
          </div>

          <!-- Format tanggal -->
          <?php
          $mulai = !empty($agenda['tanggal_mulai'])
            ? date('Y-m-d\TH:i', strtotime($agenda['tanggal_mulai']))
            : '';

          $selesai = !empty($agenda['tanggal_selesai'])
            ? date('Y-m-d\TH:i', strtotime($agenda['tanggal_selesai']))
            : '';
          ?>

          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label">Tanggal Mulai</label>
              <input
                type="datetime-local"
                class="form-control"
                name="tanggal_mulai"
                id="tanggalMulai"
                value="<?= $mulai ?>">
            </div>

            <div class="col-md-6">
              <label class="form-label">Tanggal Selesai</label>
              <input
                type="datetime-local"
                class="form-control"
                name="tanggal_selesai"
                id="tanggalSelesai"
                value="<?= $selesai ?>">
              <small id="dateError" class="text-danger" style="display:none;">Tanggal selesai tidak boleh sebelum tanggal mulai!</small>
            </div>
          </div>

          <!-- Foto -->
          <div class="mb-3">
            <label class="form-label">Gambar Agenda</label>

            <!-- Gambar Lama -->
            <?php if (!empty($agenda['gambar_agenda'])): ?>
              <div class="mb-2">
                <img src="<?= BASE_URL ?>/public/uploads/agenda/<?= htmlspecialchars($agenda['gambar_agenda']) ?>"
                  alt="gambar"
                  style="width:160px; border-radius:6px">
              </div>
            <?php else: ?>
              <p class="text-muted small">Belum ada gambar.</p>
            <?php endif; ?>

            <!-- Input perubahan gambar -->
            <input type="file" class="form-control" name="gambar_agenda" id="gambarInput" accept="image/*">

            <small class="text-muted">Format JPG/PNG — Maksimal 5MB</small>

            <!-- Preview gambar baru -->
            <div class="mt-3">
              <img id="previewGambar" src="#" style="display:none; width:200px; border-radius:6px;">
            </div>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> Simpan Perubahan
          </button>

          <button type="reset" class="btn btn-light">Reset</button>

        </form>

      </div>
    </div>

  </div>

  <div class="content-backdrop fade"></div>

</div>

<?php
include './app/views/templates/admin/footer_admin.php';

$table_name = "agenda";
include './app/views/components/page_scripts.php';
?>


<!-- JS Preview Gambar Baru -->
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

  // Validasi tanggal: selesai tidak boleh sebelum mulai
  const tanggalMulai = document.getElementById('tanggalMulai');
  const tanggalSelesai = document.getElementById('tanggalSelesai');
  const dateError = document.getElementById('dateError');
  const form = document.querySelector('form');

  function validateDates() {
    if (tanggalMulai.value && tanggalSelesai.value) {
      if (new Date(tanggalSelesai.value) < new Date(tanggalMulai.value)) {
        tanggalSelesai.classList.add('is-invalid');
        dateError.style.display = 'block';
        return false;
      } else {
        tanggalSelesai.classList.remove('is-invalid');
        dateError.style.display = 'none';
        return true;
      }
    }
    return true;
  }

  // Set minimum date untuk tanggal selesai
  tanggalMulai.addEventListener('change', function() {
    tanggalSelesai.min = this.value;
    validateDates();
  });

  tanggalSelesai.addEventListener('change', validateDates);

  // Validasi saat submit
  form.addEventListener('submit', function(e) {
    if (!validateDates()) {
      e.preventDefault();
      alert('Tanggal selesai tidak boleh sebelum tanggal mulai!');
    }
  });
</script>