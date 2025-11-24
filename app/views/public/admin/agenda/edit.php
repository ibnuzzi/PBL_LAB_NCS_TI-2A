<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';

// $agenda dikirim dari controller
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">Edit Agenda</h4>
      <a href="<?php echo BASE_URL; ?>/admin/agenda" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <div class="card mb-4">
      <div class="card-body">

        <form action="<?php echo BASE_URL; ?>/admin/agenda/update/<?php echo htmlspecialchars($agenda['id_agenda'] ?? ''); ?>" 
              method="POST" enctype="multipart/form-data">

          <!-- Nama Agenda -->
          <div class="mb-3">
            <label for="nama_agenda" class="form-label">Nama Agenda</label>
            <input
              type="text"
              class="form-control"
              id="nama_agenda"
              name="nama_agenda"
              placeholder="Masukkan nama agenda"
              value="<?php echo htmlspecialchars($agenda['nama_agenda'] ?? ''); ?>"
              required
            />
          </div>

          <!-- Lokasi -->
          <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input
              type="text"
              class="form-control"
              id="lokasi"
              name="lokasi"
              placeholder="Masukkan lokasi agenda"
              value="<?php echo htmlspecialchars($agenda['lokasi'] ?? ''); ?>"
            />
          </div>

          <!-- Tanggal Mulai / Selesai -->
          <?php
            $mulaiVal = '';
            $selesaiVal = '';

            if (!empty($agenda['tanggal_mulai'])) {
              $dt1 = date_create($agenda['tanggal_mulai']);
              if ($dt1) $mulaiVal = date_format($dt1, 'Y-m-d\TH:i');
            }
            if (!empty($agenda['tanggal_selesai'])) {
              $dt2 = date_create($agenda['tanggal_selesai']);
              if ($dt2) $selesaiVal = date_format($dt2, 'Y-m-d\TH:i');
            }
          ?>

          <div class="row mb-3">
            <div class="col-md-6">
              <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
              <input
                type="datetime-local"
                class="form-control"
                id="tanggal_mulai"
                name="tanggal_mulai"
                value="<?php echo $mulaiVal; ?>"
              />
            </div>

            <div class="col-md-6">
              <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
              <input
                type="datetime-local"
                class="form-control"
                id="tanggal_selesai"
                name="tanggal_selesai"
                value="<?php echo $selesaiVal; ?>"
              />
            </div>
          </div>

          <!-- Gambar -->
          <div class="row mb-3">
            <div class="col-md-6 d-flex flex-column">
              <label for="gambar_agenda" class="form-label">Gambar Agenda</label>

              <?php if (!empty($agenda['gambar_agenda'])): ?>
                <div class="mb-2">
                  <img src="<?php echo BASE_URL; ?>/public/uploads/agenda/<?php echo htmlspecialchars($agenda['gambar_agenda']); ?>"
                       width="160" class="rounded-2" alt="gambar" />
                </div>
              <?php else: ?>
                <div class="text-muted mb-2 small">Belum ada gambar.</div>
              <?php endif; ?>

              <input type="file" class="form-control" id="gambar_agenda" name="gambar_agenda" />
              <small class="text-muted">Format: JPG atau PNG</small>
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

$table_name = 'agenda';    // <—— WAJIB AGAR page_scripts.php BACA TABEL BENAR
include './app/views/components/page_scripts.php';
?>
