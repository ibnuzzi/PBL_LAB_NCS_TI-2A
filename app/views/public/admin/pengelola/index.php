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
              <th>NID/NIP</th>
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

                  // Keminatan string
                  $keminatan_str = '';
                  if (!empty($p['keminatan_list'])) {
                    $keminatan_names = array_map(function($k) { return $k['nama_keminatan']; }, $p['keminatan_list']);
                    $keminatan_str = implode(', ', $keminatan_names);
                  }
            ?>
              <tr>
                <td><?= $no++; ?></td>

                <td>
                  <img src="<?= $foto ?>" style="height:80px; width:80px; object-fit:cover; border-radius:6px;">
                </td>

                <td><?= htmlspecialchars($p['nama_pengelola']); ?></td>

                <td><?= htmlspecialchars($p['nid_nip'] ?? '-'); ?></td>

                <td><?= htmlspecialchars($p['nama_jabatan'] ?? 'Tidak ada jabatan'); ?></td>

                <td>
                  <!-- DETAIL -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1 btn-view"
                    data-nama="<?= htmlspecialchars($p['nama_pengelola']); ?>"
                    data-nip="<?= htmlspecialchars($p['nid_nip'] ?? '-'); ?>"
                    data-jabatan="<?= htmlspecialchars($p['nama_jabatan'] ?? 'Tidak ada jabatan'); ?>"
                    data-keminatan="<?= htmlspecialchars($keminatan_str ?: '-'); ?>"
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
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header bg-info text-white">
          <div>
            <h5 class="modal-title mb-0" style="color: white;">Informasi Detail</h5>
            <small class="opacity-75">Profil Pengelola Laboratorium</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body text-center">

          <!-- Foto Profile -->
          <div class="mb-4">
            <div class="border rounded-circle d-inline-block p-2 bg-light" style="width: 180px; height: 180px;">
              <img id="detailFoto" src="" class="rounded-circle" style="width:160px; height:160px; object-fit:cover;">
            </div>
          </div>

          <!-- Nama -->
          <h4 id="detailNama" class="fw-bold mb-2"></h4>

          <!-- NID/NIP -->
          <p class="text-muted mb-3"><strong>NID/NIP:</strong> <span id="detailNIP"></span></p>

          <!-- Jabatan -->
          <div class="alert alert-info mb-3">
            <i class="bx bx-briefcase-alt-2"></i> <strong id="detailJabatan"></strong>
          </div>

          <!-- Keminatan -->
          <div class="alert alert-success mb-0">
            <i class="bx bx-book-bookmark"></i> <strong>Keminatan:</strong><br>
            <span id="detailKeminatan" class="small"></span>
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
    let nama = $(this).data("nama");
    let nip = $(this).data("nip");
    let jabatan = $(this).data("jabatan");
    let keminatan = $(this).data("keminatan");
    let foto = $(this).data("foto");

    $("#detailNama").text(nama);
    $("#detailNIP").text(nip);
    $("#detailJabatan").text(jabatan);
    $("#detailKeminatan").text(keminatan);
    $("#detailFoto").attr("src", foto);

    new bootstrap.Modal(document.getElementById("modalDetailPengelola")).show();
  });

});
</script>
