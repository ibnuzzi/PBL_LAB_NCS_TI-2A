<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Manajemen Konten /</span> Data Berita</h4>
      <a href="<?php echo BASE_URL; ?>/admin/berita/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Berita
      </a>
    </div>

    <div class="card">


      <div class="table-responsive text-nowrap p-3">
        <table id="table-berita" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Berita</th>
              <th>Gambar</th>
              <th>Tanggal Publish</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php
            // Memastikan variabel ada dan merupakan array
            $berita_list = isset($berita_list) ? $berita_list : (isset($berita_list) ? $berita_list : []);
            if (empty($berita_list) && isset($beritas)) $berita_list = $beritas;
            if (empty($berita_list) && isset($berita)) $berita_list = is_array($berita) ? [$berita] : [];

            if (!empty($berita_list)) {
              $counter = 1;
              foreach ($berita_list as $b): ?>
                <tr>
                  <td><?php echo $counter++; ?></td>
                  <td style="max-width:380px;">
                    <?php
                    // 1. Logika Potong Judul (Max 40 karakter)
                    $judul_asli = $b['judul_berita'] ?? $b['judul'] ?? '';
                    $judul_tampil = (strlen($judul_asli) > 40) ? substr($judul_asli, 0, 40) . '...' : $judul_asli;

                    // Tampilkan Judul (Style Asli)
                    echo htmlspecialchars($judul_tampil);
                    ?>

                    <?php
                    // 2. Logika Potong Slug
                    $slug_asli = $b['slug_berita'] ?? $b['slug'] ?? '';
                    ?>

                    <?php if (!empty($slug_asli)): ?>
                      <?php
                      // Potong Slug (Max 40 karakter)
                      $slug_tampil = (strlen($slug_asli) > 40) ? substr($slug_asli, 0, 40) . '...' : $slug_asli;
                      ?>
                      <div class="text-muted small" title="<?php echo htmlspecialchars($slug_asli); ?>">
                        /<span><?php echo htmlspecialchars($slug_tampil); ?></span>
                      </div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($b['gambar_berita'])): ?>
                      <?php
                      $imagePath = __DIR__ . '/../../../../public/uploads/berita/' . $b['gambar_berita'];
                      $imageUrl = BASE_URL . '/public/uploads/berita/' . htmlspecialchars($b['gambar_berita']);
                      $cacheParam = file_exists($imagePath) ? '?v=' . filemtime($imagePath) : '?v=' . time();
                      ?>
                      <img src="<?php echo $imageUrl . $cacheParam; ?>" alt="gambar" class="rounded-2" style="height:80px; border-radius:4px;" />
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                  <td><?php echo htmlspecialchars($b['tanggal_publish'] ?? ($b['tanggal'] ?? '')); ?></td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-info me-1"

                      data-bs-toggle="modal"
                      data-bs-target="#modalDetail"

                      data-judul="<?php echo htmlspecialchars($b['judul_berita'] ?? $b['judul'] ?? ''); ?>"
                      data-deskripsi="<?php echo htmlspecialchars($b['isi_berita'] ?? $b['isi'] ?? ''); ?>"
                      <?php
                      $imagePath = __DIR__ . '/../../../../public/uploads/berita/' . $b['gambar_berita'];
                      $imageUrl = BASE_URL . '/public/uploads/berita/' . htmlspecialchars($b['gambar_berita']);
                      $cacheParam = file_exists($imagePath) ? '?v=' . filemtime($imagePath) : '?v=' . time();
                      ?>
                      data-gambar="<?php echo $imageUrl . $cacheParam; ?>"
                      data-tanggal="<?php echo htmlspecialchars($b['tanggal_publish'] ?? ($b['tanggal'] ?? '')); ?>">

                      <i class="bx bx-show-alt"></i>
                    </button>

                    <a href="<?php echo BASE_URL; ?>/admin/berita/edit/<?php echo htmlspecialchars($b['id_berita'] ?? $b['id'] ?? ''); ?>" class="btn btn-sm btn-outline-primary me-1">
                      <i class="bx bx-edit-alt"></i>
                    </a>

                    <a href="<?php echo BASE_URL; ?>/admin/berita/delete/<?php echo htmlspecialchars($b['id_berita'] ?? $b['id'] ?? ''); ?>" class="btn btn-sm btn-outline-danger btn-delete">
                      <i class="bx bx-trash"></i>
                    </a>

                  </td>
                </tr>
            <?php endforeach;
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php
  include './app/views/components/toaster.php';
  ?>

  <!-- MODAL DETAIL BERITA (CUSTOM BLUE) -->
  <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <div>
            <h5 class="modal-title mb-0" style="color: white;">Informasi Detail</h5>
            <small class="opacity-75">Informasi Lengkap Berita</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <!-- Judul/Nama -->
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-bookmark"></i> JUDUL BERITA
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
              <i class="bx bx-calendar"></i> TANGGAL PUBLISH
            </label>
            <p class="fs-6 mb-0">
              <span data-fill-text="tanggal">-</span>
            </p>
          </div>

          <hr class="my-3" data-section="tanggal">

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-file-blank"></i> ISI BERITA
            </label>
            <div class="bg-light p-3 rounded">
              <div data-fill-html="deskripsi" class="mb-0">-</div>
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
    // Auto-fill modal khusus berita
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

          // Fill HTML elements (untuk isi berita yang mungkin ada tag HTML)
          modalDetail.querySelectorAll('[data-fill-html]').forEach(el => {
            const key = el.getAttribute('data-fill-html');
            const value = button.getAttribute('data-' + key) || '-';
            el.innerHTML = value; // Gunakan innerHTML agar tag HTML ter-render
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
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
$table_name = 'berita';
include './app/views/components/page_scripts.php';
?>