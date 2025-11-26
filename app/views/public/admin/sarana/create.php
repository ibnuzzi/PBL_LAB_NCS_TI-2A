<?php 
include './app/views/templates/admin/header_admin.php'; 
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Layanan /</span> Tambah Sarana & Prasarana
      </h4>

      <a href="<?php echo BASE_URL; ?>/admin/sarana" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <!-- NOTIFIKASI -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($_SESSION['error_message']); ?>
        <?php unset($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <!-- FORM -->
    <div class="card mb-4">
      <h5 class="card-header">Form Tambah Sarana</h5>

      <div class="card-body">

        <form action="<?php echo BASE_URL; ?>/admin/sarana/store" 
              method="POST" enctype="multipart/form-data">

          <div class="row g-3">

            <!-- NAMA SARANA -->
            <div class="col-md-6">
              <label class="form-label">Nama Sarana</label>
              <input 
                type="text" 
                name="nama_sarana" 
                class="form-control" 
                required>
            </div>

            <!-- JUMLAH -->
            <div class="col-md-6">
              <label class="form-label">Jumlah</label>
              <input 
                type="number" 
                name="jumlah" 
                class="form-control" 
                required>
            </div>

            <!-- FOTO -->
            <div class="col-md-6">
              <label class="form-label">Foto Sarana</label>
              <input 
                type="file" 
                name="foto_sarana" 
                class="form-control"
                accept="image/*">
              <small class="text-muted">Opsional, JPG/PNG maksimum 5MB.</small>
            </div>

            <!-- DESKRIPSI -->
            <div class="col-12">
              <label class="form-label">Deskripsi</label>
              <textarea 
                name="deskripsi" 
                class="form-control" 
                rows="4"></textarea>
            </div>

          </div>

          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary">
              <i class="bx bx-save"></i> Simpan
            </button>
            <a href="<?php echo BASE_URL; ?>/admin/sarana" 
               class="btn btn-outline-secondary">Batal</a>
          </div>

        </form>

      </div>
    </div>

  </div>

</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
