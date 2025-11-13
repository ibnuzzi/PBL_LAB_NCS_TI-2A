<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0">Data Berita</h4>
            <a href="<?php echo BASE_URL; ?>/admin/berita/create" class="btn btn-primary">
                <i class="bx bx-plus"></i> Tambah Berita
            </a>
        </div>

        <div class="card">
            <h5 class="card-header">Tabel Berita</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped align-middle">
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
                        // Expecting controller to pass 'berita_list' (array of rows)
                        $berita_list = isset($berita_list) ? $berita_list : (isset($berita_list) ? $berita_list : []);
                        // Backwards-compat: maybe controller provided 'berita' single or 'beritas'
                        if (empty($berita_list) && isset($beritas)) $berita_list = $beritas;
                        if (empty($berita_list) && isset($berita)) $berita_list = is_array($berita) ? [$berita] : [];

                        if (empty($berita_list)):
                        ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data berita.</td>
                            </tr>
                            <?php else:
                            $counter = 1;
                            foreach ($berita_list as $b): ?>
                                <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td style="max-width:380px;">
                                        <?php echo htmlspecialchars($b['judul_berita'] ?? $b['judul'] ?? ''); ?>
                                        <?php if (!empty($b['slug_berita'] ?? $b['slug'])): ?>
                                            <div class="text-muted small">/<span><?php echo htmlspecialchars($b['slug_berita'] ?? $b['slug']); ?></span></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($b['gambar_berita'])): ?>
                                            <img src="<?php echo BASE_URL; ?>/public/uploads/berita/<?php echo htmlspecialchars($b['gambar_berita']); ?>" alt="gambar" width="80" class="rounded-2" />
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($b['tanggal_publish'] ?? ($b['tanggal'] ?? '')); ?></td>
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-info me-1 btn-view-berita"
                                            data-judul="<?php echo htmlspecialchars($b['judul_berita'] ?? $b['judul'] ?? ''); ?>"
                                            data-deskripsi="<?php echo htmlspecialchars($b['isi_berita'] ?? $b['isi'] ?? ''); ?>"
                                            data-gambar="<?php echo BASE_URL; ?>/public/uploads/berita/<?php echo htmlspecialchars($b['gambar_berita']); ?>"
                                            data-tanggal="<?php echo htmlspecialchars($b['tanggal_publish'] ?? ($b['tanggal'] ?? '')); ?>">
                                            <i class="bx bx-show-alt"></i>
                                        </button>

                                        <a href="<?php echo BASE_URL; ?>/admin/berita/edit/<?php echo htmlspecialchars($b['id_berita'] ?? $b['id'] ?? ''); ?>" class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/admin/berita/delete/<?php echo htmlspecialchars($b['id_berita'] ?? $b['id'] ?? ''); ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin menghapus berita ini?');">
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

    <div class="modal fade" id="modalDetailBerita" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalDetailJudul">Judul Berita</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-5 mb-3">
                <img id="modalDetailGambar" src="" alt="Gambar Berita" class="img-fluid rounded-3 w-100" />
              </div>
              <div class="col-md-7">
                <p class="mb-1 text-muted">
                  <i class="bx bx-calendar"></i>
                  <span id="modalDetailTanggal">-</span>
                </p>
                <hr class="my-2" />
                <p id="modalDetailDeskripsi" class="mb-0">
                  Deskripsi berita akan tampil di sini.
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
              Tutup
            </button>
          </div>
        </div>
      </div>
    </div>


    <!-- FOOTER -->
    <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
                , Lab NCS
            </div>
        </div>
    </footer>
    <!-- /FOOTER -->

    <div class="content-backdrop fade"></div>
</div>


<?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
?>
<script>
      $(document).ready(function () {
        $('.btn-view-berita').on('click', function () {
          var judul = $(this).data('judul');
          var deskripsi = $(this).data('deskripsi');
          var gambar = $(this).data('gambar');
          var tanggal = $(this).data('tanggal');

          $('#modalDetailJudul').text(judul);
          $('#modalDetailDeskripsi').text(deskripsi);
          $('#modalDetailGambar').attr('src', gambar);
          $('#modalDetailTanggal').text(tanggal);

          var modal = new bootstrap.Modal(document.getElementById('modalDetailBerita'));
          modal.show();
        });
      });
    </script>