<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<!-- CONTENT -->
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">Tambah Agenda</h4>
      <a href="<?php echo BASE_URL; ?>/admin/agenda" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <div class="card mb-4">
      <div class="card-body">

        <form action="<?php echo BASE_URL; ?>/admin/agenda/store" method="POST" enctype="multipart/form-data">

          <!-- Nama Agenda -->
          <div class="mb-3">
            <label for="nama_agenda" class="form-label">Nama Agenda</label>
            <input
              type="text"
              class="form-control <?php echo isset($errors['nama_agenda']) ? 'is-invalid' : ''; ?>"
              id="nama_agenda"
              name="nama_agenda"
              placeholder="Masukkan nama agenda"
              value="<?php echo htmlspecialchars($agenda['nama_agenda'] ?? ''); ?>"
              required
            />
            <?php if (isset($errors['nama_agenda'])): ?>
              <div class="invalid-feedback"><?php echo $errors['nama_agenda']; ?></div>
            <?php endif; ?>
          </div>

          <!-- Lokasi -->
          <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input
              type="text"
              class="form-control <?php echo isset($errors['lokasi']) ? 'is-invalid' : ''; ?>"
              id="lokasi"
              name="lokasi"
              placeholder="Masukkan lokasi agenda"
              value="<?php echo htmlspecialchars($agenda['lokasi'] ?? ''); ?>"
            />
            <?php if (isset($errors['lokasi'])): ?>
              <div class="invalid-feedback"><?php echo $errors['lokasi']; ?></div>
            <?php endif; ?>
          </div>

          <!-- Tanggal Mulai & Selesai -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
              <input
                type="datetime-local"
                class="form-control <?php echo isset($errors['tanggal_mulai']) ? 'is-invalid' : ''; ?>"
                id="tanggal_mulai"
                name="tanggal_mulai"
                value="<?php echo htmlspecialchars($agenda['tanggal_mulai'] ?? ''); ?>"
              />
              <?php if (isset($errors['tanggal_mulai'])): ?>
                <div class="invalid-feedback"><?php echo $errors['tanggal_mulai']; ?></div>
              <?php endif; ?>
            </div>

            <div class="col-md-6">
              <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
              <input
                type="datetime-local"
                class="form-control <?php echo isset($errors['tanggal_selesai']) ? 'is-invalid' : ''; ?>"
                id="tanggal_selesai"
                name="tanggal_selesai"
                value="<?php echo htmlspecialchars($agenda['tanggal_selesai'] ?? ''); ?>"
              />
              <?php if (isset($errors['tanggal_selesai'])): ?>
                <div class="invalid-feedback"><?php echo $errors['tanggal_selesai']; ?></div>
              <?php endif; ?>
            </div>
          </div>

          <!-- Gambar Agenda -->
          <div class="mb-3">
            <label for="gambar_agenda" class="form-label">Gambar Agenda</label>
            <input
              class="form-control <?php echo isset($errors['gambar_agenda']) ? 'is-invalid' : ''; ?>"
              type="file"
              id="gambar_agenda"
              name="gambar_agenda"
            />
            <small class="text-muted">Format: JPG, PNG. Ukuran maksimal 5MB.</small>
            <?php if (isset($errors['gambar_agenda'])): ?>
              <div class="invalid-feedback"><?php echo $errors['gambar_agenda']; ?></div>
            <?php endif; ?>
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
      <div class="mb-2 mb-md-0">
        © <script>document.write(new Date().getFullYear());</script>, Lab NCS
      </div>
    </div>
  </footer>

  <div class="content-backdrop fade"></div>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
