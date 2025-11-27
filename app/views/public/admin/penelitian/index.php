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
                    data-deskripsi="<?= htmlspecialchars($p['deskripsi_singkat'] ?? ''); ?>"
                    data-peneliti="<?= htmlspecialchars($p['peneliti'] ?? 'Belum ada data'); ?>"
                    data-link="<?= htmlspecialchars($p['link_publikasi'] ?? ''); ?>"
                    data-file="<?= htmlspecialchars($p['file_dokumen_pdf'] ?? ''); ?>"
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
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <div>
          <h5 class="modal-title mb-0" style="color: white;">Informasi Detail</h5>
          <small class="opacity-75">Informasi Lengkap Penelitian</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <!-- Judul Penelitian -->
        <div class="mb-4">
          <label class="form-label fw-bold text-muted small mb-1">
            <i class="bx bx-book-bookmark"></i> JUDUL PENELITIAN
          </label>
          <div class="alert alert-primary mb-0">
            <h5 class="mb-0 fw-bold" id="modalJudulPenelitian"></h5>
          </div>
        </div>

        <hr class="my-3">

        <!-- Tahun -->
        <div class="mb-3">
          <label class="form-label fw-bold text-muted small mb-1">
            <i class="bx bx-calendar"></i> TAHUN PENELITIAN
          </label>
          <p class="fs-5 mb-0" id="modalTahunPenelitian"></p>
        </div>

        <hr class="my-3">

        <!-- Tim Peneliti -->
        <div class="mb-3">
          <label class="form-label fw-bold text-muted small mb-1">
            <i class="bx bx-group"></i> TIM PENELITI
          </label>
          <div class="alert alert-info mb-0" id="modalPenelitiInfo">
            <i class="bx bx-user-circle"></i> <span id="modalTimPeneliti"></span>
          </div>
        </div>

        <hr class="my-3">

        <!-- Deskripsi -->
        <div class="mb-3">
          <label class="form-label fw-bold text-muted small mb-1">
            <i class="bx bx-file-blank"></i> DESKRIPSI SINGKAT
          </label>
          <div class="bg-light p-3 rounded" id="modalDeskripsiPenelitian">
            
          </div>
        </div>

        <hr class="my-3">

        <!-- Link & File -->
        <div class="row">
          <!-- Link Publikasi -->
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold text-muted small mb-2">
              <i class="bx bx-link-alt"></i> LINK PUBLIKASI
            </label>
            <div id="modalLinkPenelitian"></div>
          </div>

          <!-- Dokumen -->
          <div class="col-md-6 mb-3">
            <label class="form-label fw-bold text-muted small mb-2">
              <i class="bx bx-file-pdf"></i> DOKUMEN PDF
            </label>
            <div id="modalFilePenelitian"></div>
          </div>
        </div>

      </div>

      <div class="modal-footer bg-light">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <i class="bx bx-x"></i> Tutup
        </button>
      </div>

    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  $(".btn-view-penelitian").on("click", function () {

    let judul = $(this).data("judul");
    let tahun = $(this).data("tahun");
    let deskripsi = $(this).data("deskripsi");
    let peneliti = $(this).data("peneliti");
    let link = $(this).data("link");
    let file = $(this).data("file");

    // Set judul di header
    $("#modalJudulPenelitian").text(judul);
    
    // Set tahun
    $("#modalTahunPenelitian").html(`<strong>${tahun}</strong>`);

    // Set tim peneliti
    if (peneliti && peneliti.trim() !== "" && peneliti !== "Belum ada data") {
        $("#modalTimPeneliti").text(peneliti);
    } else {
        $("#modalPenelitiInfo").removeClass("alert-info").addClass("alert-warning");
        $("#modalTimPeneliti").text("Belum ada data tim peneliti");
    }

    // Set deskripsi
    if (deskripsi && deskripsi.trim() !== "") {
        $("#modalDeskripsiPenelitian").html(`<p class="mb-0">${deskripsi}</p>`);
    } else {
        $("#modalDeskripsiPenelitian").html(`<p class="text-muted mb-0"><em>Tidak ada deskripsi</em></p>`);
    }

    // Link Publikasi
    if (link && link.trim() !== "") {
        $("#modalLinkPenelitian").html(`
          <a href="${link}" target="_blank" class="btn btn-info btn-sm w-100">
            <i class="bx bx-link-external"></i> Buka Link
          </a>
        `);
    } else {
        $("#modalLinkPenelitian").html(`
          <div class="text-muted small">Tidak tersedia</div>
        `);
    }

    // File Dokumen PDF
    if (file && file.trim() !== "") {
        $("#modalFilePenelitian").html(`
          <a href="<?= BASE_URL ?>/public/uploads/penelitian/${file}" target="_blank" class="btn btn-success btn-sm w-100">
            <i class="bx bx-download"></i> Unduh PDF
          </a>
        `);
    } else {
        $("#modalFilePenelitian").html(`
          <div class="text-muted small">Tidak tersedia</div>
        `);
    }

    new bootstrap.Modal(document.getElementById("modalDetailPenelitian")).show();
  });

});
</script>
