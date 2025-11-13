<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">Upload Foto</h4>
      <a href="<?php echo BASE_URL; ?>/admin/gallery" class="btn btn-outline-secondary"><i class="bx bx-left-arrow-alt"></i> Kembali</a>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <form action="<?php echo BASE_URL; ?>/admin/gallery/store" method="POST" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="judul_foto" class="form-label">Judul Foto</label>
            <input type="text" id="judul_foto" name="judul_foto" class="form-control" required />
          </div>

          <div class="mb-3">
            <label for="deskripsi_foto" class="form-label">Deskripsi</label>
            <textarea id="deskripsi_foto" name="deskripsi_foto" rows="3" class="form-control"></textarea>
          </div>

          <div class="mb-3">
            <label for="file_foto" class="form-label">Pilih Foto</label>
            <input class="form-control" type="file" id="file_foto" name="file_foto" required />
            <small class="text-muted">Format: JPG, PNG. Ukuran maks 5MB.</small>
          </div>

          <button type="submit" class="btn btn-primary"><i class="bx bx-upload"></i> Upload</button>
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
