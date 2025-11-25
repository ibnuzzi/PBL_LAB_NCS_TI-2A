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
            $penelitian_list = $penelitian_list ?? [];
            if (empty($penelitian_list) && isset($penelitians)) $penelitian_list = $penelitians;
            if (empty($penelitian_list) && isset($penelitian)) $penelitian_list = is_array($penelitian) ? [$penelitian] : [];

            if (!empty($penelitian_list)):
              $no = 1;

              foreach ($penelitian_list as $p):
            ?>

              <tr>
                <td><?= $no++; ?></td>

                <td style="max-width:390px;">
                  <?= htmlspecialchars($p['judul_penelitian']); ?>
                </td>

                <td><?= htmlspecialchars($p['tahun_penelitian']); ?></td>

                <td>

                  <!-- BUTTON VIEW -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1 btn-view-penelitian"
                    data-judul="<?= htmlspecialchars($p['judul_penelitian']); ?>"
                    data-tahun="<?= htmlspecialchars($p['tahun_penelitian']); ?>"
                    data-link="<?= htmlspecialchars($p['link_publikasi'] ?? ''); ?>"
                  >
                    <i class="bx bx-show-alt"></i>
                  </button>

                  <!-- BUTTON EDIT -->
                  <a href="<?= BASE_URL ?>/admin/penelitian/edit/<?= (int)$p['id_penelitian']; ?>"
                     class="btn btn-sm btn-outline-primary me-1">
                    <i class="bx bx-edit-alt"></i>
                  </a>

                  <!-- BUTTON DELETE -->
                  <a href="<?= BASE_URL ?>/admin/penelitian/delete/<?= (int)$p['id_penelitian']; ?>"
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

  <?php include './app/views/components/modal.php'; ?>
  <?php include './app/views/components/toaster.php'; ?>

</div>

<?php
include './app/views/templates/admin/footer_admin.php';
$table_name = 'penelitian';
include './app/views/components/page_scripts.php';
?>

<!-- MODAL DETAIL PENELITIAN -->
<div class="modal fade" id="modalDetailPenelitian" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalJudulPenelitian">Detail Penelitian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <p><strong>Tahun:</strong> <span id="modalTahunPenelitian"></span></p>

        <hr>

        <div id="modalLinkPenelitian"></div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Tutup
        </button>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  $(".btn-view-penelitian").on("click", function () {

    let link = $(this).data("link");

    $("#modalJudulPenelitian").text($(this).data("judul"));
    $("#modalTahunPenelitian").text($(this).data("tahun"));

    if (link && link.trim() !== "") {
        $("#modalLinkPenelitian").html(`
          <a href="${link}" target="_blank" class="btn btn-info btn-sm">
            <i class="bx bx-link-external"></i> Kunjungi Link Penelitian
          </a>
        `);
    } else {
        $("#modalLinkPenelitian").html(`
          <p class="text-danger mb-0">Tidak ada link penelitian.</p>
        `);
    }

    new bootstrap.Modal(document.getElementById("modalDetailPenelitian")).show();
  });

});
</script>
