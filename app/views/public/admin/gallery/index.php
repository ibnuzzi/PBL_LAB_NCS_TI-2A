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
                      <?php
                      $imagePath = __DIR__ . '/../../../../public/uploads/gallery/' . $g['nama_file_foto'];
                      $imageUrl = BASE_URL . '/public/uploads/gallery/' . htmlspecialchars($g['nama_file_foto']);
                      $cacheParam = file_exists($imagePath) ? '?v=' . filemtime($imagePath) : '?v=' . time();
                      ?>
                      <img
                        src="<?php echo $imageUrl . $cacheParam; ?>"
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
                      <?php
                      $imagePath = __DIR__ . '/../../../../public/uploads/gallery/' . $g['nama_file_foto'];
                      $imageUrl = BASE_URL . '/public/uploads/gallery/' . htmlspecialchars($g['nama_file_foto']);
                      $cacheParam = file_exists($imagePath) ? '?v=' . filemtime($imagePath) : '?v=' . time();
                      ?>
                      data-gambar="<?php echo $imageUrl . $cacheParam; ?>"
                      data-tanggal="<?php echo htmlspecialchars($createdFormatted); ?>">
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

            <?php endforeach;
            endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php
  include './app/views/components/toaster.php';
  ?>

  <!-- MODAL DETAIL GALLERY (CUSTOM BLUE) -->
  <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <div>
            <h5 class="modal-title mb-0" style="color: white;">Informasi Detail</h5>
            <small class="opacity-75">Informasi Lengkap Galeri</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- Judul/Nama -->
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-bookmark"></i> JUDUL FOTO
            </label>
            <div class="alert alert-primary mb-0">
              <h5 class="mb-0 fw-bold" data-fill-text="judul">-</h5>
            </div>
          </div>

          <hr class="my-3">

          <!-- Preview Gambar -->
          <div class="mb-4 text-center">
            <label class="form-label fw-bold text-muted small mb-2">
              <i class="bx bx-image"></i> PREVIEW GAMBAR
            </label>
            <div class="border rounded p-2 bg-light">
              <img data-fill-src="gambar" src="" alt="Gambar" class="img-fluid rounded" style="max-height: 350px; object-fit: contain;" />
            </div>
          </div>

          <hr class="my-3">

          <!-- Tanggal (jika ada) -->
          <div class="mb-3" data-section="tanggal">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-calendar"></i> TANGGAL UPLOAD
            </label>
            <p class="fs-6 mb-0">
              <span data-fill-text="tanggal">-</span>
            </p>
          </div>

          <hr class="my-3" data-section="tanggal">

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-file-blank"></i> DESKRIPSI FOTO
            </label>
            <div class="bg-light p-3 rounded">
              <p data-fill-text="deskripsi" class="mb-0">-</p>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-light">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
            <i class="bx bx-x"></i> Tutup
          </button>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Auto-fill modal khusus gallery
    document.addEventListener("DOMContentLoaded", function() {
      const modalDetail = document.getElementById('modalDetail');

      if (modalDetail) {
        modalDetail.addEventListener('show.bs.modal', function(event) {
          const button = event.relatedTarget;

          // Fill text elements
          modalDetail.querySelectorAll('[data-fill-text]').forEach(el => {
            const key = el.getAttribute('data-fill-text');
            const value = button.getAttribute('data-' + key) || '-';
            el.textContent = value;
          });

          // Fill image source
          modalDetail.querySelectorAll('[data-fill-src]').forEach(el => {
            const key = el.getAttribute('data-fill-src');
            const value = button.getAttribute('data-' + key);
            if (value) {
              el.setAttribute('src', value);
            }
          });
        });
      }
    });
  </script>
</div>

<?php
include './app/views/templates/admin/footer_admin.php';

// mengirim nama tabel ke script dinamis
$table_name = 'gallery';
include './app/views/components/page_scripts.php';
?>