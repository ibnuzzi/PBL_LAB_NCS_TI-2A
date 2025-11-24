<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Penelitian
      </h4>

      <a href="<?= BASE_URL ?>/admin/penelitian/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Penelitian
      </a>
    </div>

    <div class="card">

      <div class="table-responsive text-nowrap p-3">
        <table id="table-penelitian" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Penelitian</th>
              <th>Tahun</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">

            <?php
            // Normalisasi variabel
            $penelitian_list = $penelitian_list ?? [];
            if (empty($penelitian_list) && isset($penelitians)) $penelitian_list = $penelitians;
            if (empty($penelitian_list) && isset($penelitian)) $penelitian_list = is_array($penelitian) ? [$penelitian] : [];

            if (!empty($penelitian_list)):

              $counter = 1;
              foreach ($penelitian_list as $p):
            ?>

              <tr>
                <td><?= $counter++; ?></td>

                <td style="max-width:380px;">
                  <?= htmlspecialchars($p['judul_penelitian']); ?>
                </td>

                <td><?= htmlspecialchars($p['tahun_penelitian']); ?></td>

                <td>

                  <a href="<?= BASE_URL ?>/admin/penelitian/edit/<?= htmlspecialchars($p['id_penelitian']); ?>"
                     class="btn btn-sm btn-outline-primary me-1">
                    <i class="bx bx-edit-alt"></i>
                  </a>

                  <a href="<?= BASE_URL ?>/admin/penelitian/delete/<?= htmlspecialchars($p['id_penelitian']); ?>"
                     class="btn btn-sm btn-outline-danger btn-delete">
                    <i class="bx bx-trash"></i>
                  </a>

                </td>
              </tr>

            <?php endforeach; else: ?>

              <!-- TAMPILAN SAAT TIDAK ADA DATA (AMAN UNTUK DATATABLE) -->
              <tr>
                <td colspan="4" class="text-center py-5">

                  <img width="220px"
                       src="<?= BASE_URL ?>/public/assets/images/empty/empty_data.png"
                       class="mb-3">

                  <div class="text-muted">Belum ada data penelitian.</div>

                </td>
              </tr>

            <?php endif; ?>

          </tbody>
        </table>
      </div>

    </div>
  </div>

  <?php include './app/views/components/modal.php'; ?>
  <?php include './app/views/components/toaster.php'; ?>

</div>

<?php
include './app/views/templates/admin/footer_admin.php';
$table_name = 'penelitian';
include './app/views/components/page_scripts.php';
?>
