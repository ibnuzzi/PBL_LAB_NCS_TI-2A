<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<!-- Select2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Edit Penelitian
      </h4>

      <a href="<?= BASE_URL ?>/admin/penelitian" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Kembali
      </a>
    </div>

    <!-- ERROR MESSAGE -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <!-- FORM -->
    <div class="card">
      <h5 class="card-header">Form Edit Penelitian</h5>
      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/penelitian/update/<?= $penelitian['id_penelitian']; ?>" method="POST" enctype="multipart/form-data">

          <!-- Judul -->
          <div class="mb-3">
            <label class="form-label">Judul Penelitian</label>
            <input type="text" class="form-control"
              name="judul_penelitian"
              value="<?= htmlspecialchars($penelitian['judul_penelitian']); ?>"
              required>
          </div>

          <!-- Tim Peneliti (Select2) -->
          <div class="mb-3">
            <label class="form-label">Tim Peneliti <span class="text-danger">*</span></label>
            <?php if (!empty($list_pengelola)): ?>
              <select class="form-select select2" name="peneliti[]" multiple="multiple" required>
                <?php foreach ($list_pengelola as $p): ?>
                  <?php
                  // Cek apakah ID pengelola ini ada di array $selected_peneliti
                  $isSelected = in_array($p['id_pengelola'], $selected_peneliti) ? 'selected' : '';
                  ?>
                  <option value="<?= $p['id_pengelola'] ?>" <?= $isSelected ?>>
                    <?= htmlspecialchars($p['nama_pengelola']) ?><?php if (!empty($p['jabatan'])): ?> (<?= htmlspecialchars($p['jabatan']) ?>)<?php endif; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="form-text">
                <i class="bx bx-info-circle"></i> Ketik nama untuk mencari. Bisa pilih lebih dari satu.
              </div>
            <?php else: ?>
              <div class="alert alert-warning">
                <i class="bx bx-error-circle"></i> Belum ada data pengelola. Silakan tambahkan di menu Profil terlebih dahulu.
              </div>
            <?php endif; ?>
          </div>

          <!-- Anggota Luar -->
          <div class="mb-3">
            <label class="form-label">Anggota Luar (Opsional)</label>
            <textarea name="anggota_luar" class="form-control" rows="2" placeholder="Tulis nama anggota luar jika ada (pisahkan dengan koma)"><?= htmlspecialchars($penelitian['anggota_luar'] ?? '') ?></textarea>
            <div class="form-text">
              <i class="bx bx-info-circle"></i> Masukkan nama anggota yang tidak terdaftar di sistem (misal: mahasiswa atau peneliti luar).
            </div>
          </div>

          <!-- Tahun -->
          <div class="mb-3">
            <label class="form-label">Tahun Penelitian</label>
            <input type="number" min="1900" max="2100" class="form-control"
              name="tahun_penelitian"
              value="<?= htmlspecialchars($penelitian['tahun_penelitian']); ?>"
              required>
          </div>

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label">Abstrak</label>
            <textarea class="form-control" name="deskripsi_singkat" rows="4" required><?= htmlspecialchars($penelitian['deskripsi_singkat']); ?></textarea>
          </div>

          <!-- Link Publikasi -->
          <div class="mb-3">
            <label class="form-label">Link Publikasi</label>
            <input type="url" class="form-control"
              name="link_publikasi"
              value="<?= htmlspecialchars($penelitian['link_publikasi']); ?>"
              placeholder="https://">
            <div class="form-text">
              <i class="bx bx-info-circle"></i> Opsional. Link ke jurnal atau publikasi online.
            </div>
          </div>

          <!-- Upload File PDF -->
          <div class="mb-3">
            <label class="form-label">Upload Dokumen Penelitian <span class="text-muted">(Opsional)</span></label>
            <?php if (!empty($penelitian['file_dokumen_pdf'])): ?>
              <div class="alert alert-info mb-2">
                <i class="bx bx-file"></i> File saat ini: <strong><?= htmlspecialchars($penelitian['file_dokumen_pdf']) ?></strong>
              </div>
            <?php endif; ?>
            <input type="file" class="form-control" name="file_dokumen" accept=".pdf">
            <div class="form-text">
              <i class="bx bx-info-circle"></i> Format: PDF. Maksimal 10MB. Biarkan kosong jika tidak ingin mengganti.
            </div>
          </div>

          <!-- BUTTONS -->
          <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary"><i class="bx bx-save"></i> Update</button>
            <a href="<?= BASE_URL ?>/admin/penelitian" class="btn btn-light">Batal</a>
          </div>

        </form>

      </div>
    </div>

  </div>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      theme: 'bootstrap-5',
      placeholder: 'Pilih Anggota Tim',
      allowClear: true,
      width: '100%'
    });
  });
</script>