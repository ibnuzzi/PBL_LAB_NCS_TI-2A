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

                <td><?= htmlspecialchars($createdFormatted); ?></td>

                <td>

                  <!-- VIEW -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1 btn-view-dokumen"
                    data-judul="<?= htmlspecialchars($d['nama_dokumen'] ?? ''); ?>"
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="modalDetailJudul">Detail Dokumen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <p class="text-muted small mb-1">
            <i class="bx bx-calendar"></i>
            <span id="modalDetailTanggal"></span>
          </p>

          <p><strong>Deskripsi:</strong></p>
          <p id="modalDetailDeskripsi"></p>

          <hr>

          <a id="modalDetailFile" href="#" target="_blank" class="btn btn-info btn-sm">
            <i class="bx bx-file"></i> Lihat / Unduh Dokumen
          </a>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
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

    $("#modalDetailJudul").text($(this).data("judul"));
    $("#modalDetailDeskripsi").text($(this).data("deskripsi"));
    $("#modalDetailTanggal").text($(this).data("tanggal"));
    $("#modalDetailFile").attr("href", $(this).data("file"));

    new bootstrap.Modal(document.getElementById("modalDetailDokumen")).show();
  });

});
</script>
