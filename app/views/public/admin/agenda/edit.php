<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';

// $agenda is passed from controller
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
        <form action="<?php echo BASE_URL; ?>/admin/agenda/update/<?php echo htmlspecialchars($agenda['id_agenda'] ?? ''); ?>" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nama_agenda" class="form-label">Nama Agenda</label>
            <input type="text" id="nama_agenda" name="nama_agenda" class="form-control" value="<?php echo htmlspecialchars($agenda['nama_agenda'] ?? ''); ?>" required />
          </div>

          <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" id="lokasi" name="lokasi" class="form-control" value="<?php echo htmlspecialchars($agenda['lokasi'] ?? ''); ?>" />
          </div>

          <?php
            $mulaiVal = '';
            $selesaiVal = '';
            if (!empty($agenda['tanggal_mulai'])) {
              $dt = date_create($agenda['tanggal_mulai']);
              if ($dt) $mulaiVal = date_format($dt, 'Y-m-d\TH:i');
            }
            if (!empty($agenda['tanggal_selesai'])) {
              $dt2 = date_create($agenda['tanggal_selesai']);
              if ($dt2) $selesaiVal = date_format($dt2, 'Y-m-d\TH:i');
            }
          ?>

          <div class="mb-3 row">
            <div class="col-md-6">
              <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
              <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai" class="form-control" value="<?php echo $mulaiVal; ?>" />
            </div>
            <div class="col-md-6">
              <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
              <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai" class="form-control" value="<?php echo $selesaiVal; ?>" />
            </div>
          </div>

          <div class="mb-3">
            <label for="gambar_agenda" class="form-label">Gambar Agenda</label>
            <?php if (!empty($agenda['gambar_agenda'])): ?>
              <div class="mb-2">
                <img src="<?php echo BASE_URL; ?>/public/uploads/agenda/<?php echo htmlspecialchars($agenda['gambar_agenda']); ?>" alt="gambar" width="160" class="rounded-2" />
              </div>
            <?php else: ?>
              <div class="text-muted small mb-2">Belum ada gambar.</div>
            <?php endif; ?>
            <input class="form-control" type="file" id="gambar_agenda" name="gambar_agenda" />
            <small class="text-muted">Format: JPG, PNG. Ukuran maks 5MB.</small>
          </div>

          <button type="submit" class="btn btn-primary"><i class="bx bx-save"></i> Simpan</button>
          <button type="reset" class="btn btn-light">Reset</button>
        </form>
      </div>
    </div>
  </div>

  <footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">© <script>document.write(new Date().getFullYear());</script>, Lab NCS</div>
    </div>
  </footer>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
