<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';

// Safety: pastikan variabel ada
$gallery = $gallery ?? [];
$id_foto = htmlspecialchars($gallery['id_foto'] ?? 0);
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Konten /</span> Edit Foto
      </h4>

      <a href="<?= BASE_URL ?>/admin/gallery" class="btn btn-outline-secondary">
        <i class="bx bx-left-arrow-alt"></i> Kembali
      </a>
    </div>

    <!-- FORM -->
    <div class="card mb-4">
      <div class="card-body">

        <?php if ($id_foto == 0): ?>
          <div class="alert alert-danger">Data foto tidak ditemukan.</div>
        <?php else: ?>

          <form
            action="<?= BASE_URL ?>/admin/gallery/update/<?= $id_foto ?>"
            method="POST"
            enctype="multipart/form-data">

            <!-- JUDUL -->
            <div class="mb-3">
              <label for="judul_foto" class="form-label">Judul Foto</label>
              <input
                type="text"
                id="judul_foto"
                name="judul_foto"
                class="form-control"
                value="<?= htmlspecialchars($gallery['judul_foto'] ?? '') ?>"
                required />
            </div>

            <!-- DESKRIPSI -->
            <div class="mb-3">
              <label for="deskripsi_foto" class="form-label">Deskripsi</label>
              <textarea
                id="deskripsi_foto"
                name="deskripsi_foto"
                rows="3"
                class="form-control"><?= htmlspecialchars($gallery['deskripsi_foto'] ?? '') ?></textarea>
            </div>

            <!-- GAMBAR SAAT INI -->
            <div class="mb-3">
              <label class="form-label d-block">Gambar Saat Ini</label>

              <?php if (!empty($gallery['nama_file_foto'])): ?>
                <img
                  src="<?= BASE_URL ?>/public/uploads/gallery/<?= htmlspecialchars($gallery['nama_file_foto']) ?>"
                  class="rounded mb-2"
                  style="height:120px; object-fit:cover; border-radius:6px;" />
              <?php else: ?>
                <p class="text-muted small">Belum ada gambar tersimpan.</p>
              <?php endif; ?>
            </div>

            <!-- UPLOAD FOTO BARU -->
            <div class="mb-3">
              <label for="nama_file_foto" class="form-label">Ganti Foto (opsional)</label>

              <!-- CRITICAL FIX: name MUST be "file_foto" to match controller -->
              <input
                type="file"
                id="file_foto"
                name="file_foto"
                class="form-control" />

              <small class="text-muted">Format JPG/PNG, maksimal 5MB.</small>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary">
              <i class="bx bx-save"></i> Simpan Perubahan
            </button>

            <button type="reset" class="btn btn-light">Reset</button>

          </form>

        <?php endif; ?>

      </div>
    </div>
  </div>

</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>