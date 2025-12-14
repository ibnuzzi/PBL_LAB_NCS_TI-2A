<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<!-- CONTENT -->
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">Tambah Berita</h4>
      <a href="<?php echo BASE_URL; ?>/admin/berita" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <div class="card mb-4">
      <div class="card-body">
        <!-- ganti action ke file php mu -->
        <form action="<?php echo BASE_URL; ?>/admin/berita/store" method="POST" enctype="multipart/form-data">
          <!-- Judul -->
          <div class="mb-3">
            <label for="judul_berita" class="form-label">Judul Berita</label>
            <input
              type="text"
              class="form-control <?php echo isset($errors['judul_berita']) ? 'is-invalid' : ''; ?>"
              id="judul_berita"
              name="judul_berita"
              placeholder="Masukkan judul berita"
              value="<?php echo htmlspecialchars($berita['judul_berita'] ?? ''); ?>" />
            <?php if (isset($errors['judul_berita'])): ?>
              <div class="invalid-feedback"><?php echo $errors['judul_berita']; ?></div>
            <?php endif; ?>
          </div>

          <!-- Slug -->
          <div class="mb-3">
            <label for="slug_berita" class="form-label">Slug (otomatis / manual)</label>
            <input
              type="text"
              class="form-control <?php echo isset($errors['slug_berita']) ? 'is-invalid' : ''; ?>"
              id="slug_berita"
              name="slug_berita"
              placeholder="contoh: pelatihan-keamanan-siber"
              value="<?php echo htmlspecialchars($berita['slug_berita'] ?? ''); ?>" />
            <?php if (isset($errors['slug_berita'])): ?>
              <div class="invalid-feedback"><?php echo $errors['slug_berita']; ?></div>
            <?php endif; ?>
            <small class="text-muted">Kalau dikosongkan nanti bisa dibuat otomatis di backend.</small>
          </div>

          <!-- Isi -->
          <div class="mb-3">
            <label for="isi_berita" class="form-label">Isi Berita</label>
            <textarea
              id="isi_berita"
              name="isi_berita"
              rows="5"
              class="form-control <?php echo isset($errors['isi_berita']) ? 'is-invalid' : ''; ?>"
              placeholder="Tulis isi berita di sini..."><?php echo $berita['isi_berita'] ?? ''; ?></textarea>
            <?php if (isset($errors['isi_berita'])): ?>
              <div class="invalid-feedback"><?php echo $errors['isi_berita']; ?></div>
            <?php endif; ?>
          </div>

          <!-- Gambar -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="gambar_berita" class="form-label">Gambar Berita</label>
              <input class="form-control" type="file" id="gambar_berita" name="gambar_berita" />
              <small class="text-muted">Format: JPG, PNG. Disarankan ukuran landscape.</small>
            </div>
            <div class="col-md-6">
              <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
              <input
                type="datetime-local"
                class="form-control <?php echo isset($errors['tanggal_publish']) ? 'is-invalid' : ''; ?>"
                id="tanggal_publish"
                name="tanggal_publish"
                value="<?php echo htmlspecialchars($berita['tanggal_publish'] ?? ''); ?>" />
              <?php if (isset($errors['tanggal_publish'])): ?>
                <div class="invalid-feedback"><?php echo $errors['tanggal_publish']; ?></div>
              <?php endif; ?>
            </div>
          </div>


          <!-- (opsional) id admin penulis -->
          <input type="hidden" name="id_admin_penulis" value="1" />

          <button type="submit" class="btn btn-primary">
            <i class="bx bx-save"></i> Simpan
          </button>
          <button type="reset" class="btn btn-light">Reset</button>
        </form>
      </div>
    </div>

    <div class="content-backdrop fade"></div>
  </div>
  <!-- /CONTENT -->
  <?php
  // Footer (includes scripts)
  include './app/views/templates/admin/footer_admin.php';
  ?>

  <!-- Summernote Lite CSS -->
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

  <!-- Summernote Lite JS -->
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

  <!-- Initialize Summernote -->
  <script>
    $(document).ready(function() {
      $('#isi_berita').summernote({
        height: 300,
        placeholder: 'Tulis isi berita di sini...',
        tabsize: 2,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'italic', 'clear']],
          ['fontname', ['fontname']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link', 'picture', 'video']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });
  </script>