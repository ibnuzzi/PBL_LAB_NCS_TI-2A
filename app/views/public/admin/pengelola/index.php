<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Arsip /</span> Struktur Pengelola
      </h4>

      <a href="<?= BASE_URL ?>/admin/pengelola/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Pengelola
      </a>
    </div>

    <div class="card">
      <div class="table-responsive text-nowrap p-3">

        <table id="table-pengelola" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Foto</th>
              <th>Nama Pengelola</th>
              <th>Jabatan</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">

            <?php
              $pengelola_list = $pengelola_list ?? [];
              if (empty($pengelola_list) && isset($pengelolas)) $pengelola_list = $pengelolas;
              if (empty($pengelola_list) && isset($pengelola))  $pengelola_list = is_array($pengelola) ? [$pengelola] : [];

              if (!empty($pengelola_list)):
                $no = 1;
                foreach ($pengelola_list as $p):

                  // Foto Default
                  $foto = !empty($p['foto_pengelola'])
                          ? BASE_URL . "/public/uploads/pengelola/" . $p['foto_pengelola']
                          : BASE_URL . "/public/assets/images/default/user_default.png";
            ?>
              <tr>
                <td><?= $no++; ?></td>

                <td>
                  <img src="<?= $foto ?>" style="height:80px; width:80px; object-fit:cover; border-radius:6px;">
                </td>

                <td><?= htmlspecialchars($p['nama_pengelola']); ?></td>

                <td><?= htmlspecialchars($p['jabatan']); ?></td>

                <td>
                  <!-- DETAIL -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1 btn-view"
                    data-nama="<?= htmlspecialchars($p['nama_pengelola']); ?>"
                    data-jabatan="<?= htmlspecialchars($p['jabatan']); ?>"
                    data-foto="<?= $foto ?>">
                    <i class="bx bx-show-alt"></i>
                  </button>

                  <!-- EDIT -->
                  <a href="<?= BASE_URL ?>/admin/pengelola/edit/<?= (int)$p['id_pengelola']; ?>"
                     class="btn btn-sm btn-outline-primary me-1">
                    <i class="bx bx-edit-alt"></i>
                  </a>

                  <!-- DELETE -->
                  <a href="<?= BASE_URL ?>/admin/pengelola/delete/<?= (int)$p['id_pengelola']; ?>"
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
  <div class="modal fade" id="modalDetailPengelola" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Detail Pengelola</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">

          <img id="detailFoto" src="" class="rounded mb-3"
               style="width:150px; height:150px; object-fit:cover; border-radius:8px;">

          <h5 id="detailNama" class="fw-bold"></h5>
          <p id="detailJabatan" class="text-muted"></p>

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
$table_name = 'pengelola';
include './app/views/components/page_scripts.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function () {

  $(".btn-view").on("click", function () {
    $("#detailNama").text($(this).data("nama"));
    $("#detailJabatan").text($(this).data("jabatan"));
    $("#detailFoto").attr("src", $(this).data("foto"));

    new bootstrap.Modal(document.getElementById("modalDetailPengelola")).show();
  });

});
</script>
