<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Pengaturan /</span> My Profile
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
          <h5 class="card-header">Informasi Profile</h5>
          
          <div class="card-body">
            <form action="<?= BASE_URL ?>/admin/profile/update" method="POST">
              
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                  <input type="text" name="nama_lengkap" class="form-control" 
                         value="<?= htmlspecialchars($admin['nama_lengkap'] ?? ''); ?>" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Email <span class="text-danger">*</span></label>
                  <input type="email" name="email" class="form-control" 
                         value="<?= htmlspecialchars($admin['email'] ?? ''); ?>" required>
                  <small class="text-muted">Email digunakan untuk login</small>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Role</label>
                  <input type="text" class="form-control" 
                         value="<?= htmlspecialchars($admin['role'] ?? 'Administrator'); ?>" disabled>
                  <small class="text-muted">Role tidak dapat diubah</small>
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">Terdaftar Sejak</label>
                  <input type="text" class="form-control" 
                         value="<?= isset($admin['created_at']) ? date('d F Y', strtotime($admin['created_at'])) : '-'; ?>" disabled>
                </div>
              </div>

              <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                  <i class="bx bx-save me-1"></i> Simpan Perubahan
                </button>
                <a href="<?= BASE_URL ?>/admin/change-password" class="btn btn-outline-warning">
                  <i class="bx bx-key me-1"></i> Ganti Password
                </a>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<?php include './app/views/templates/admin/footer_admin.php'; ?>
