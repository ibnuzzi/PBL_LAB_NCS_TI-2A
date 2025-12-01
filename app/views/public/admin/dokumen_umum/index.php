<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Dokumen Umum
      </h4>

      <a href="<?= BASE_URL ?>/admin/dokumen_umum/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Dokumen
      </a>
    </div>

    <div class="card">

      <div class="table-responsive text-nowrap p-3">
        <table id="table-dokumen_umum" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Dokumen</th>
              <th>Kategori</th>
              <th>Tanggal Upload</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">

            <?php
              // Normalisasi variabel seperti galeri & berita
              $dokumen_list = $dokumen_list ?? [];
              if (empty($dokumen_list) && isset($dokumens)) $dokumen_list = $dokumens;
              if (empty($dokumen_list) && isset($dokumen)) $dokumen_list = is_array($dokumen) ? [$dokumen] : [];

              if (!empty($dokumen_list)):

                $no = 1;
                foreach ($dokumen_list as $d):

                  $created = $d['created_at'] ?? '';
                  $createdFormatted = $created ? date('Y-m-d H:i', strtotime($created)) : '-';
            ?>

              <tr>
                <td><?= $no++; ?></td>

                <td style="max-width:380px;">
                  <?= htmlspecialchars($d['nama_dokumen'] ?? '-'); ?>
                </td>

                <td style="max-width:380px;">
                  <?= htmlspecialchars($d['nama_kategori'] ?? '-'); ?>
                </td>

                <td><?= htmlspecialchars($createdFormatted); ?></td>

                <td>

                  <!-- VIEW -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1 btn-view-dokumen"
                    data-judul="<?= htmlspecialchars($d['nama_dokumen'] ?? ''); ?>"
                    data-kategori="<?= htmlspecialchars($d['nama_kategori'] ?? '-'); ?>"
                    data-deskripsi="<?= htmlspecialchars($d['deskripsi_dokumen'] ?? '-'); ?>"
                    data-file="<?= BASE_URL . '/public/uploads/dokumen_umum/' . htmlspecialchars($d['nama_file_dokumen'] ?? ''); ?>"
                    data-tanggal="<?= htmlspecialchars($createdFormatted); ?>">
                    <i class="bx bx-show-alt"></i>
                  </button>

                  <!-- EDIT -->
                  <a href="<?= BASE_URL ?>/admin/dokumen_umum/edit/<?= (int)($d['id_dokumen'] ?? 0); ?>"
                     class="btn btn-sm btn-outline-primary me-1">
                    <i class="bx bx-edit-alt"></i>
                  </a>

                  <!-- DELETE -->
                  <a href="<?= BASE_URL ?>/admin/dokumen_umum/delete/<?= (int)($d['id_dokumen'] ?? 0); ?>"
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

  <!-- MODAL DETAIL -->
  <div class="modal fade" id="modalDetailDokumen" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header bg-primary text-white">
          <div>
            <h5 class="modal-title mb-0" style="color: white;">Informasi Detail</h5>
            <small class="opacity-75">Informasi Dokumen Arsip</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- Judul Dokumen -->
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-file-text"></i> JUDUL DOKUMEN
            </label>
            <div class="alert alert-primary mb-0">
              <h5 class="mb-0 fw-bold" id="modalDetailJudul"></h5>
            </div>
          </div>

          <hr class="my-3">

          <!-- Tanggal Upload -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-calendar"></i> TANGGAL UPLOAD
            </label>
            <p class="fs-6 mb-0" id="modalDetailTanggal"></p>
          </div>

          <hr class="my-3">

          <!-- Kategori -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-category"></i> KATEGORI
            </label>
            <div class="alert alert-info mb-0">
              <i class="bx bx-folder"></i> <strong id="modalDetailKategori"></strong>
            </div>
          </div>

          <hr class="my-3">

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-file-blank"></i> DESKRIPSI
            </label>
            <div class="bg-light p-3 rounded" id="modalDetailDeskripsi"></div>
          </div>

          <hr class="my-3">

          <!-- File Download -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-2">
              <i class="bx bx-download"></i> UNDUH DOKUMEN
            </label>
            <a id="modalDetailFile" href="#" target="_blank" class="btn btn-primary btn-sm w-100">
              <i class="bx bx-download"></i> Unduh / Lihat Dokumen
            </a>
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
$table_name = 'dokumen_umum';
include './app/views/components/page_scripts.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function () {

  $(".btn-view-dokumen").on("click", function () {

    let judul = $(this).data("judul");
    let kategori = $(this).data("kategori");
    let deskripsi = $(this).data("deskripsi");
    let tanggal = $(this).data("tanggal");
    let file = $(this).data("file");

    // Set judul
    $("#modalDetailJudul").text(judul);

    // Set tanggal
    $("#modalDetailTanggal").html(`<strong>${tanggal}</strong>`);

    // Set kategori
    $("#modalDetailKategori").text(kategori);

    // Set deskripsi
    if (deskripsi && deskripsi.trim() !== "" && deskripsi !== "-") {
        $("#modalDetailDeskripsi").html(`<p class="mb-0">${deskripsi}</p>`);
    } else {
        $("#modalDetailDeskripsi").html(`<p class="text-muted mb-0"><em>Tidak ada deskripsi</em></p>`);
    }

    // Set file link
    $("#modalDetailFile").attr("href", file);

    new bootstrap.Modal(document.getElementById("modalDetailDokumen")).show();
  });

});
</script>
