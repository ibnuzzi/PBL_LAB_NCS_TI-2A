<?php
// File: /app/views/public/admin/penelitian/index.php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Manajemen Arsip /</span> Penelitian</h4>
      <a href="<?php echo BASE_URL; ?>/admin/penelitian/create" class="btn btn-primary">
        <i class="bx bx-plus"></i> Tambah Penelitian
      </a>
    </div>

    <div class="card">
      <h5 class="card-header">Daftar Penelitian</h5>
      <?php if (!empty($_SESSION['success_message']) || !empty($_SESSION['error_message'])): ?>
        <div class="card-body">
          <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
              <?php echo htmlspecialchars($_SESSION['success_message']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
          <?php endif; ?>

          <?php if (!empty($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
              <?php echo htmlspecialchars($_SESSION['error_message']); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <div class="table-responsive text-nowrap">
        <table class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Penelitian</th>
              <th>Tahun Penelitian</th>
              <th>Link Publikasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php
            // Check if penelitian data exists
            if (empty($penelitian_list)):
            ?>
              <tr>
                <td colspan="5" class="text-center">Belum ada data penelitian.</td>
              </tr>
            <?php else:
              $counter = 1;
              foreach ($penelitian_list as $penelitian): ?>
                <tr>
                  <td><?php echo $counter++; ?></td>
                  <td style="max-width: 380px;">
                    <?php echo htmlspecialchars($penelitian['judul_penelitian'] ?? ''); ?>
                  </td>
                  <td><?php echo htmlspecialchars($penelitian['tahun_penelitian'] ?? ''); ?></td>
                  <td><a href="<?php echo htmlspecialchars($penelitian['link_publikasi'] ?? '#'); ?>" target="_blank">Link</a></td>
                  <td>
                    <button type="button" class="btn btn-sm btn-outline-info me-1 btn-view-penelitian"
                            data-judul="<?php echo htmlspecialchars($penelitian['judul_penelitian'] ?? ''); ?>"
                            data-peneliti="<?php echo htmlspecialchars($penelitian['peneliti'] ?? ''); ?>"
                            data-tahun="<?php echo htmlspecialchars($penelitian['tahun_penelitian'] ?? ''); ?>"
                            data-deskripsi="<?php echo htmlspecialchars($penelitian['deskripsi_singkat'] ?? ''); ?>"
                            data-link="<?php echo htmlspecialchars($penelitian['link_publikasi'] ?? ''); ?>">
                      <i class="bx bx-show-alt"></i>
                    </button>

                    <a href="<?php echo BASE_URL; ?>/admin/penelitian/edit/<?php echo htmlspecialchars($penelitian['id_penelitian'] ?? ''); ?>" class="btn btn-sm btn-outline-primary me-1">
                      <i class="bx bx-edit-alt"></i>
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/penelitian/delete/<?php echo htmlspecialchars($penelitian['id_penelitian'] ?? ''); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus penelitian ini?');">
                      <i class="bx bx-trash"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Modal Popup for Viewing Penelitian -->
  <div class="modal fade" id="modalDetailPenelitian" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailJudul">Judul Penelitian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <p class="mb-1 text-muted">
                <strong>Peneliti: </strong><span id="modalDetailPeneliti"></span>
              </p>
              <p class="mb-1 text-muted">
                <strong>Tahun Penelitian: </strong><span id="modalDetailTahun"></span>
              </p>
              <hr class="my-2" />
              <p id="modalDetailDeskripsi" class="mb-0">
                Deskripsi penelitian akan tampil di sini.
              </p>
            </div>
            <div class="col-md-6">
              <p class="mb-1 text-muted">
                <strong>Link Publikasi: </strong><a id="modalDetailLink" href="#" target="_blank">Lihat Publikasi</a>
              </p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
      <div class="mb-2 mb-md-0">
        © <script>document.write(new Date().getFullYear());</script>, Lab NCS
      </div>
    </div>
  </footer>
  <!-- /FOOTER -->

  <div class="content-backdrop fade"></div>
</div>

<?php
include './app/views/templates/admin/footer_admin.php';
?>
<script>
  $(document).ready(function() {
    $('.btn-view-penelitian').on('click', function() {
      var judul = $(this).data('judul');
      var peneliti = $(this).data('peneliti');
      var tahun = $(this).data('tahun');
      var deskripsi = $(this).data('deskripsi');
      var link = $(this).data('link');

      $('#modalDetailJudul').text(judul);
      $('#modalDetailPeneliti').text(peneliti);
      $('#modalDetailTahun').text(tahun);
      $('#modalDetailDeskripsi').text(deskripsi);
      $('#modalDetailLink').attr('href', link);

      var modal = new bootstrap.Modal(document.getElementById('modalDetailPenelitian'));
      modal.show();
    });
  });
</script>

<script>
    // Auto-dismiss bootstrap alerts after 4 seconds
    document.addEventListener('DOMContentLoaded', function() {
        var alerts = document.querySelectorAll('.alert');
        if (alerts.length) {
            setTimeout(function() {
                alerts.forEach(function(el) {
                    try {
                        var bsAlert = bootstrap.Alert.getOrCreateInstance(el);
                        bsAlert.close();
                    } catch (e) {
                        el.parentNode && el.parentNode.removeChild(el);
                    }
                });
            }, 3000);
        }
    });
</script>
