<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Konten /</span> Upload Foto
      </h4>

      <a href="<?php echo BASE_URL; ?>/admin/gallery" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <!-- FORM -->
    <div class="card mb-4">
      <div class="card-body">

        <form action="<?php echo BASE_URL; ?>/admin/gallery/store" method="POST" enctype="multipart/form-data">

          <!-- JUDUL FOTO -->
          <div class="mb-3">
            <label for="judul_foto" class="form-label">Judul Foto</label>
            <input
              type="text"
              id="judul_foto"
              name="judul_foto"
              class="form-control"
              required />
          </div>

          <!-- DESKRIPSI -->
          <div class="mb-3">
            <label for="deskripsi_foto" class="form-label">Deskripsi</label>
            <textarea
              id="deskripsi_foto"
              name="deskripsi_foto"
              rows="3"
              class="form-control"></textarea>
          </div>

          <!-- FILE FOTO -->
          <div class="mb-3">
            <label for="file_foto" class="form-label">Pilih Foto</label>
            <input
              type="file"
              id="file_foto"
              name="file_foto"
              class="form-control"
              required />
            <small class="text-muted">Format: JPG, PNG. Maks 5MB.</small>
          </div>

          <!-- BUTTON -->
          <button type="submit" class="btn btn-primary">
            <i class="bx bx-upload"></i> Upload
          </button>

          <button type="reset" class="btn btn-light">Reset</button>

        </form>

      </div>
    </div>
  </div>


</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
