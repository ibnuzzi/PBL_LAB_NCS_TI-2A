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
              <th>Authors</th>
              <th>Tahun</th>
              <th>Tanggal Input</th>
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

                  <td style="max-width:280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="<?= htmlspecialchars($p['judul_kegiatan']); ?>">
                    <?= htmlspecialchars($p['judul_kegiatan']); ?>
                  </td>

                  <td>
                    <?php if (!empty($p['first_author'])): ?>
                      <?= htmlspecialchars($p['first_author']); ?>
                    <?php else: ?>
                      <span class="text-muted">-</span>
                    <?php endif; ?>
                  </td>

                  <td><?= htmlspecialchars($p['tahun_kegiatan']); ?></td>

                  <td>
                    <?php
                    if (!empty($p['created_at'])) {
                      $date = new DateTime($p['created_at']);
                      echo $date->format('d M Y');
                    } else {
                      echo '<span class="text-muted">-</span>';
                    }
                    ?>
                  </td>

                  <td>
                    <!-- DETAIL -->
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-info me-1 btn-view-pengabdian"
                      data-judul="<?= htmlspecialchars($p['judul_kegiatan']); ?>"
                      data-tim="<?= htmlspecialchars($p['tim_pengabdi'] ?? '-'); ?>"
                      data-anggota-luar="<?= htmlspecialchars($p['anggota_luar'] ?? ''); ?>"
                      data-tahun="<?= htmlspecialchars($p['tahun_kegiatan']); ?>"
                      data-deskripsi="<?= htmlspecialchars($p['deskripsi_kegiatan']); ?>"
                      data-file="<?= htmlspecialchars($p['file_dokumen_pdf'] ?? ''); ?>">
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
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header bg-primary text-white">
          <div>
            <h5 class="modal-title mb-0" style="color: white;">Informasi Detail</h5>
            <small class="opacity-75">Informasi Lengkap Pengabdian Masyarakat</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- Judul Pengabdian -->
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-book-bookmark"></i> JUDUL PENGABDIAN
            </label>
            <div class="alert alert-primary mb-0">
              <h5 class="mb-0 fw-bold" id="modalDetailJudul"></h5>
            </div>
          </div>

          <hr class="my-3">

          <!-- Tahun -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-calendar"></i> TAHUN KEGIATAN
            </label>
            <p class="fs-5 mb-0" id="modalDetailTahun"></p>
          </div>

          <hr class="my-3">

          <!-- Tim Pengabdi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-group"></i> TIM PENGABDI
            </label>
            <div class="alert alert-primary mb-0" id="modalPengabdiInfo">
              <i class="bx bx-user-circle"></i> <span id="modalDetailTim"></span>
            </div>
          </div>

          <!-- Anggota Luar -->
          <div class="mb-3" id="wrapperAnggotaLuar" style="display: none;">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-group"></i> ANGGOTA LUAR
            </label>
            <div class="alert alert-info mb-0">
              <i class="bx bx-user"></i> <span id="modalAnggotaLuar"></span>
            </div>
          </div>

          <hr class="my-3">

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-file-blank"></i> DESKRIPSI KEGIATAN
            </label>
            <div class="bg-light p-3 rounded" id="modalDetailDeskripsi"></div>
          </div>

          <hr class="my-3">

          <!-- Dokumen -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-2">
              <i class="bx bx-file-pdf"></i> DOKUMEN PDF
            </label>
            <div id="modalDetailFileContainer"></div>
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

      let judul = $(this).data("judul");
      let tahun = $(this).data("tahun");
      let tim = $(this).data("tim");
      let anggotaLuar = $(this).data("anggota-luar");
      let deskripsi = $(this).data("deskripsi");
      let file = $(this).data("file");

      // Set judul
      $("#modalDetailJudul").text(judul);

      // Set tahun
      $("#modalDetailTahun").html(`<strong>${tahun}</strong>`);

      // Set tim pengabdi
      if (tim && tim.trim() !== "" && tim !== "-") {
        $("#modalDetailTim").text(tim);
        $("#modalPengabdiInfo").removeClass("alert-warning").addClass("alert-primary");
      } else {
        $("#modalPengabdiInfo").removeClass("alert-primary").addClass("alert-warning");
        $("#modalDetailTim").text("Belum ada data tim pengabdi");
      }

      // Set anggota luar
      if (anggotaLuar && anggotaLuar.trim() !== "") {
        $("#wrapperAnggotaLuar").show();
        $("#modalAnggotaLuar").text(anggotaLuar);
      } else {
        $("#wrapperAnggotaLuar").hide();
      }

      // Set deskripsi
      if (deskripsi && deskripsi.trim() !== "") {
        $("#modalDetailDeskripsi").html(`<p class="mb-0">${deskripsi}</p>`);
      } else {
        $("#modalDetailDeskripsi").html(`<p class="text-muted mb-0"><em>Tidak ada deskripsi</em></p>`);
      }

      // Set file
      if (file && file.trim() !== "") {
        $("#modalDetailFileContainer").html(`
            <a href="<?= BASE_URL ?>/public/uploads/pengabdian/${file}" target="_blank" class="btn btn-primary btn-sm w-100">
              <i class="bx bx-download"></i> Unduh Dokumen PDF
            </a>
          `);
      } else {
        $("#modalDetailFileContainer").html(`
            <div class="text-muted small">Tidak tersedia</div>
          `);
      }

      new bootstrap.Modal(document.getElementById("modalDetailPengabdian")).show();
    });

  });
</script>