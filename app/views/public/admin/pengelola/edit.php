<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Struktur Pengelola /</span> Edit Pengelola
      </h4>

      <a href="<?= BASE_URL ?>/admin/pengelola" class="btn btn-outline-secondary">
        <i class="bx bx-arrow-back"></i> Kembali
      </a>
    </div>

    <!-- ALERT -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <div class="card mb-4">
      <h5 class="card-header">Form Edit Pengelola</h5>

      <div class="card-body">

        <form action="<?= BASE_URL ?>/admin/pengelola/update/<?= $pengelola['id_pengelola'] ?>" method="POST" enctype="multipart/form-data">

          <!-- Nama -->
          <div class="mb-3">
            <label class="form-label">Nama Pengelola <span class="text-danger">*</span></label>
            <input type="text" name="nama_pengelola" class="form-control"
                   value="<?= htmlspecialchars($pengelola['nama_pengelola']) ?>" required>
          </div>

          <!-- NID/NIP -->
          <div class="mb-3">
            <label class="form-label">NIDN/NIP</label>
            <input type="text" name="nid_nip" class="form-control" 
                   value="<?= htmlspecialchars($pengelola['nid_nip'] ?? '') ?>" placeholder="Opsional">
          </div>

          <!-- Jabatan -->
          <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <select name="id_jabatan" class="form-select">
              <option value="">-- Pilih Jabatan --</option>
              <?php if (!empty($jabatan_list)): foreach ($jabatan_list as $j): ?>
                <option value="<?= $j['id_jabatan']; ?>" 
                        <?= ($pengelola['id_jabatan'] == $j['id_jabatan']) ? 'selected' : ''; ?>>
                  <?= htmlspecialchars($j['nama_jabatan']); ?>
                </option>
              <?php endforeach; endif; ?>
            </select>
          </div>

          <!-- Keminatan (Multiple) -->
          <div class="mb-3">
            <label class="form-label">Keminatan / Keilmuan</label>
            <small class="text-muted d-block mb-2">Pilih satu atau lebih keminatan</small>
            <div class="row">
              <?php if (!empty($keminatan_list)): foreach ($keminatan_list as $k): ?>
                <div class="col-md-6">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="keminatan[]" 
                           value="<?= $k['id_keminatan']; ?>" id="keminatan_<?= $k['id_keminatan']; ?>"
                           <?= in_array($k['id_keminatan'], $selected_keminatan ?? []) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="keminatan_<?= $k['id_keminatan']; ?>">
                      <?= htmlspecialchars($k['nama_keminatan']); ?>
                    </label>
                  </div>
                </div>
              <?php endforeach; endif; ?>
            </div>
          </div>

          <!-- Foto Lama -->
          <div class="mb-3">
            <label class="form-label">Foto Saat Ini</label>
            <br>
            <?php if (!empty($pengelola['foto_pengelola'])): ?>
              <img src="<?= BASE_URL ?>/public/uploads/pengelola/<?= htmlspecialchars($pengelola['foto_pengelola']) ?>"
                   style="height:120px;border-radius:8px;">
            <?php else: ?>
              <div class="text-muted fst-italic">Tidak ada foto</div>
            <?php endif; ?>
          </div>

          <!-- Upload Foto Baru -->
          <div class="mb-3">
            <label class="form-label">Ganti Foto (Opsional)</label>
            <input type="file" name="foto_pengelola" class="form-control" accept="image/*">
            <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
          </div>

          <button class="btn btn-primary">
            <i class="bx bx-save"></i> Update
          </button>

        </form>

      </div>
    </div>

  </div>

</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
