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
                      <?php
                      $imagePath = __DIR__ . '/../../../../public/uploads/sarana/' . $s['foto_sarana'];
                      $imageUrl = BASE_URL . '/public/uploads/sarana/' . htmlspecialchars($s['foto_sarana']);
                      $cacheParam = file_exists($imagePath) ? '?v=' . filemtime($imagePath) : '?v=' . time();
                      ?>
                      <img
                        src="<?php echo $imageUrl . $cacheParam; ?>"
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
                      <?php
                      $imagePath = __DIR__ . '/../../../../public/uploads/sarana/' . $s['foto_sarana'];
                      $imageUrl = BASE_URL . '/public/uploads/sarana/' . htmlspecialchars($s['foto_sarana']);
                      $cacheParam = file_exists($imagePath) ? '?v=' . filemtime($imagePath) : '?v=' .  time();
                      ?>
                      data-gambar="<?php echo $imageUrl . $cacheParam; ?>"
                      data-tanggal="">
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

            <?php endforeach;
            endif; ?>

          </tbody>
        </table>
      </div>

    </div>
  </div>

  <!-- MODAL DETAIL SARANA (CUSTOM BLUE) -->
  <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <div>
            <h5 class="modal-title mb-0" style="color: white;">Informasi Detail</h5>
            <small class="opacity-75">Informasi Lengkap Sarana & Prasarana</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- Nama Sarana -->
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-cube"></i> NAMA SARANA
            </label>
            <div class="alert alert-primary mb-0">
              <h5 class="mb-0 fw-bold" data-fill-text="judul">-</h5>
            </div>
          </div>

          <hr class="my-3">

          <!-- Preview Gambar -->
          <div class="mb-4 text-center">
            <label class="form-label fw-bold text-muted small mb-2">
              <i class="bx bx-image"></i> FOTO SARANA
            </label>
            <div class="border rounded p-2 bg-light">
              <img data-fill-src="gambar" src="" alt="Gambar" class="img-fluid rounded" style="max-height: 350px; object-fit: contain;" />
            </div>
          </div>

          <hr class="my-3">

          <!-- Jumlah / Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-info-circle"></i> KETERANGAN / JUMLAH
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
    // Auto-fill modal khusus sarana
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

  <!-- TOASTER -->
  <?php include './app/views/components/toaster.php'; ?>

</div>

<?php
include './app/views/templates/admin/footer_admin.php';

// Kirim table_name untuk script dinamis
$table_name = 'sarana';
include './app/views/components/page_scripts.php';
?>