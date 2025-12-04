<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Pengaturan /</span> Ganti Password
      </h4>
    </div>

    <!-- ALERT -->
    <?php if (!empty($_SESSION['error_message'])): ?>
      <div class="alert alert-danger alert-dismissible fade show">
        <?= htmlspecialchars($_SESSION['error_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['success_message'])): ?>
      <div class="alert alert-success alert-dismissible fade show">
        <?= htmlspecialchars($_SESSION['success_message']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-12">
        <div class="card mb-4">
          <h5 class="card-header">Ubah Password</h5>
          
          <div class="card-body">
            <form action="<?= BASE_URL ?>/admin/profile/update-password" method="POST">
              
              <div class="mb-3">
                <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                <input type="password" name="current_password" class="form-control" 
                       placeholder="Masukkan password lama" required autocomplete="current-password">
              </div>

              <hr class="my-4">

              <div class="mb-3">
                <label class="form-label">Password Baru <span class="text-danger">*</span></label>
                <input type="password" name="new_password" class="form-control" 
                       placeholder="Masukkan password baru" required minlength="6" autocomplete="new-password">
                <small class="text-muted">Minimal 6 karakter</small>
              </div>

              <div class="mb-3">
                <label class="form-label">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                <input type="password" name="confirm_password" class="form-control" 
                       placeholder="Ulangi password baru" required minlength="6" autocomplete="new-password">
              </div>

              <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                  <i class="bx bx-check me-1"></i> Ubah Password
                </button>
                <a href="<?= BASE_URL ?>/admin/profile" class="btn btn-outline-secondary">
                  <i class="bx bx-x me-1"></i> Batal
                </a>
              </div>

            </form>
          </div>
        </div>

        <!-- Info Card -->
        <div class="card bg-label-warning">
          <div class="card-body">
            <h6 class="card-title mb-2">
              <i class="bx bx-info-circle"></i> Tips Keamanan Password
            </h6>
            <ul class="mb-0 small">
              <li>Gunakan minimal 6 karakter</li>
              <li>Kombinasikan huruf besar, huruf kecil, dan angka</li>
              <li>Jangan gunakan password yang mudah ditebak</li>
              <li>Ganti password secara berkala</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
