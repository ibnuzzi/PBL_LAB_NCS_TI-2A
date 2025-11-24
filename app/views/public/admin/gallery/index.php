<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Konten /</span> Data Galeri
      </h4>

      <a href="<?php echo BASE_URL; ?>/admin/gallery/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Upload Foto
      </a>
    </div>

    <div class="card">

      <div class="table-responsive text-nowrap p-3">
        <table id="table-gallery" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Foto</th>
              <th>Gambar</th>
              <th>Uploaded</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">
            <?php
            // Memastikan variabel ada dan merupakan array
            $gallery_list = isset($gallery_list) ? $gallery_list : [];
            if (empty($gallery_list) && isset($galleries)) $gallery_list = $galleries;
            if (empty($gallery_list) && isset($gallery)) $gallery_list = is_array($gallery) ? [$gallery] : [];

            if (!empty($gallery_list)):
              $counter = 1;

              foreach ($gallery_list as $g):

                // Format tanggal
                $created = $g['created_at'] ?? '';
                $createdFormatted = $created ? date('Y-m-d H:i', strtotime($created)) : '-';

            ?>

              <tr>
                <td><?php echo $counter++; ?></td>

                <td style="max-width:380px;">
                  <?php echo htmlspecialchars($g['judul_foto'] ?? ''); ?>
                </td>

                <td>
                  <?php if (!empty($g['nama_file_foto'])): ?>
                    <img
                      src="<?php echo BASE_URL; ?>/public/uploads/gallery/<?php echo htmlspecialchars($g['nama_file_foto']); ?>"
                      alt="foto"
                      class="rounded-2"
                      style="height:80px; border-radius:4px;" />
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>

                <td><?php echo htmlspecialchars($createdFormatted); ?></td>

                <td>

                  <!-- Modal Preview -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetail"

                    data-judul="<?php echo htmlspecialchars($g['judul_foto']); ?>"
                    data-deskripsi="<?php echo htmlspecialchars($g['deskripsi_foto'] ?? '-'); ?>"
                    data-gambar="<?php echo BASE_URL; ?>/public/uploads/gallery/<?php echo htmlspecialchars($g['nama_file_foto']); ?>"
                    data-tanggal="<?php echo htmlspecialchars($createdFormatted); ?>"
                  >
                    <i class="bx bx-show-alt"></i>
                  </button>

                  <a
                    href="<?php echo BASE_URL; ?>/admin/gallery/edit/<?php echo htmlspecialchars($g['id_foto']); ?>"
                    class="btn btn-sm btn-outline-primary me-1">
                    <i class="bx bx-edit-alt"></i>
                  </a>

                  <a
                    href="<?php echo BASE_URL; ?>/admin/gallery/delete/<?php echo htmlspecialchars($g['id_foto']); ?>"
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

  <?php
  include './app/views/components/modal.php';
  include './app/views/components/toaster.php';
  ?>
</div>

<?php
include './app/views/templates/admin/footer_admin.php';

// mengirim nama tabel ke script dinamis
$table_name = 'gallery';
include './app/views/components/page_scripts.php';
?>
