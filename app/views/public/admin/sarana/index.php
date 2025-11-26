<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- TITLE + BUTTON -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Layanan /</span> Sarana & Prasarana
      </h4>

      <a href="<?php echo BASE_URL; ?>/admin/sarana/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Sarana
      </a>
    </div>

    <div class="card">

      <div class="table-responsive text-nowrap p-3">
        <table id="table-sarana" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama Sarana</th>
              <th>Jumlah</th>
              <th>Foto</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">

            <?php
            // fleksibilitas variabel
            $list = $list ?? [];
            if (empty($list) && isset($sarana_list)) $list = $sarana_list;
            if (empty($list) && isset($sarana)) $list = is_array($sarana) ? [$sarana] : [];

            if (!empty($list)):
              foreach ($list as $s):
            ?>

              <tr>
                <td><?php echo htmlspecialchars($s['id_sarana']); ?></td>

                <td><?php echo htmlspecialchars($s['nama_sarana']); ?></td>

                <td><?php echo htmlspecialchars($s['jumlah']); ?></td>

                <td>
                  <?php if (!empty($s['foto_sarana'])): ?>
                    <img
                      src="<?php echo BASE_URL; ?>/public/uploads/sarana/<?php echo htmlspecialchars($s['foto_sarana']); ?>"
                      alt="foto"
                      class="rounded-2"
                      style="height:80px; border-radius:4px;">
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>

                <td>

                  <!-- Modal Preview -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetail"

                    data-judul="<?php echo htmlspecialchars($s['nama_sarana']); ?>"
                    data-deskripsi="Jumlah: <?php echo htmlspecialchars($s['jumlah']); ?>"
                    data-gambar="<?php echo BASE_URL; ?>/public/uploads/sarana/<?php echo htmlspecialchars($s['foto_sarana']); ?>"
                    data-tanggal=""
                  >
                    <i class="bx bx-show-alt"></i>
                  </button>

                  <a
                    href="<?php echo BASE_URL; ?>/admin/sarana/edit/<?php echo htmlspecialchars($s['id_sarana']); ?>"
                    class="btn btn-sm btn-outline-primary me-1">
                    <i class="bx bx-edit-alt"></i>
                  </a>

                  <a
                    href="<?php echo BASE_URL; ?>/admin/sarana/delete/<?php echo htmlspecialchars($s['id_sarana']); ?>"
                    class="btn btn-sm btn-outline-danger btn-delete">
                    <i class="bx bx-trash"></i>
                  </a>

                </td>
              </tr>

            <?php endforeach; endif; ?>

          </tbody>
        </table>
      </div>

    </div>
  </div>

  <!-- MODAL DETAIL -->
  <?php include './app/views/components/modal.php'; ?>

  <!-- TOASTER -->
  <?php include './app/views/components/toaster.php'; ?>

</div>

<?php
include './app/views/templates/admin/footer_admin.php';

// Kirim table_name untuk script dinamis
$table_name = 'sarana';
include './app/views/components/page_scripts.php';
?>
