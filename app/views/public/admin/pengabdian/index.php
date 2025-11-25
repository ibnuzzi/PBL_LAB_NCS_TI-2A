<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Pengabdian
      </h4>

      <a href="<?= BASE_URL ?>/admin/pengabdian/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Pengabdian
      </a>
    </div>

    <div class="card">

      <div class="table-responsive text-nowrap p-3">

        <table id="table-pengabdian" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Pengabdian</th>
              <th>Tahun</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>

            <?php
            // Normalisasi variabel
            $pengabdian_list = $pengabdian_list ?? [];
            if (empty($pengabdian_list) && isset($pengabdians)) $pengabdian_list = $pengabdians;
            if (empty($pengabdian_list) && isset($pengabdian)) $pengabdian_list = is_array($pengabdian) ? [$pengabdian] : [];

            if (!empty($pengabdian_list)):
              $counter = 1;
              foreach ($pengabdian_list as $p):
            ?>
                <tr>
                  <td><?= $counter++; ?></td>

                  <td style="max-width:380px;">
                    <?= htmlspecialchars($p['judul_kegiatan']); ?>
                  </td>

                  <td><?= htmlspecialchars($p['tahun_kegiatan']); ?></td>

                  <td>
                    <!-- DETAIL -->
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-info me-1 btn-view-pengabdian"
                      data-judul="<?= htmlspecialchars($p['judul_kegiatan']); ?>"
                      data-tim="<?= htmlspecialchars($p['tim_pengabdi']); ?>"
                      data-tahun="<?= htmlspecialchars($p['tahun_kegiatan']); ?>"
                      data-deskripsi="<?= htmlspecialchars($p['deskripsi_kegiatan']); ?>"
                      data-file="<?= BASE_URL . '/public/uploads/pengabdian/' . htmlspecialchars($p['file_dokumen_pdf']); ?>">
                      <i class="bx bx-show-alt"></i>
                    </button>

                    <!-- EDIT -->
                    <a href="<?= BASE_URL ?>/admin/pengabdian/edit/<?= htmlspecialchars($p['id_pengabdian']); ?>"
                      class="btn btn-sm btn-outline-primary me-1">
                      <i class="bx bx-edit-alt"></i>
                    </a>

                    <!-- DELETE -->
                    <a href="<?= BASE_URL ?>/admin/pengabdian/delete/<?= htmlspecialchars($p['id_pengabdian']); ?>"
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

  <!-- MODAL DETAIL -->
  <div class="modal fade" id="modalDetailPengabdian" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailJudul">Detail Pengabdian</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <p><strong>Tim Pengabdi:</strong> <span id="modalDetailTim"></span></p>
          <p><strong>Tahun:</strong> <span id="modalDetailTahun"></span></p>

          <p><strong>Deskripsi:</strong></p>
          <p id="modalDetailDeskripsi"></p>

          <hr>

          <p><strong>Dokumen PDF:</strong></p>
          <a id="modalDetailFile" href="#" target="_blank" class="btn btn-info btn-sm">
            <i class="bx bx-file"></i> Lihat Dokumen
          </a>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Tutup
          </button>
        </div>

      </div>
    </div>
  </div>

  <?php include './app/views/components/modal.php'; ?>
  <?php include './app/views/components/toaster.php'; ?>

</div>

<?php
include './app/views/templates/admin/footer_admin.php';
$table_name = 'pengabdian';
include './app/views/components/page_scripts.php';
?>

<!-- JS DETAIL -->
<script>
  document.addEventListener("DOMContentLoaded", function() {

    $(".btn-view-pengabdian").on("click", function() {

      $("#modalDetailJudul").text($(this).data("judul"));
      $("#modalDetailTim").text($(this).data("tim"));
      $("#modalDetailTahun").text($(this).data("tahun"));
      $("#modalDetailDeskripsi").text($(this).data("deskripsi"));
      $("#modalDetailFile").attr("href", $(this).data("file"));

      new bootstrap.Modal(document.getElementById("modalDetailPengabdian")).show();
    });

  });
</script>