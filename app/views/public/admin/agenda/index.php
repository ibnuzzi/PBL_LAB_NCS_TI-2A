<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Konten /</span> Agenda
      </h4>

      <a href="<?= BASE_URL ?>/admin/agenda/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Agenda
      </a>
    </div>

    <div class="card">

      <div class="table-responsive text-nowrap p-3">
        <table id="table-agenda" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Agenda</th>
              <th>Tanggal Mulai</th>
              <th>Tanggal Selesai</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">

            <?php
            $agenda_list = $agenda_list ?? [];
            if (empty($agenda_list) && isset($agendas)) $agenda_list = $agendas;
            if (empty($agenda_list) && isset($agenda)) $agenda_list = [$agenda];

            if (!empty($agenda_list)):
              $no = 1;

              foreach ($agenda_list as $a):

                $mulai = $a['tanggal_mulai'] ?? null;
                $selesai = $a['tanggal_selesai'] ?? null;

                $mulaiTxt = $mulai ? date('Y-m-d H:i', strtotime($mulai)) : '-';
                $selesaiTxt = $selesai ? date('Y-m-d H:i', strtotime($selesai)) : '-';

                $gambarUrl = !empty($a['gambar_agenda'])
                  ? BASE_URL . "/public/uploads/agenda/" . $a['gambar_agenda']
                  : BASE_URL . "/public/assets/images/default/nodata.png";
            ?>

            <tr>
              <td><?= $no++; ?></td>

              <td><?= htmlspecialchars($a['nama_agenda']); ?></td>

              <td><?= $mulaiTxt; ?></td>

              <td><?= $selesaiTxt; ?></td>

              <td>

                <!-- VIEW -->
                <button
                  type="button"
                  class="btn btn-sm btn-outline-info me-1 btn-view"
                  data-nama="<?= htmlspecialchars($a['nama_agenda']); ?>"
                  data-deskripsi="<?= htmlspecialchars($a['deskripsi_agenda'] ?? ''); ?>"
                  data-lokasi="<?= htmlspecialchars($a['lokasi'] ?? ''); ?>"
                  data-mulai="<?= $mulaiTxt; ?>"
                  data-selesai="<?= $selesaiTxt; ?>"
                  data-gambar="<?= $gambarUrl; ?>"
                >
                  <i class="bx bx-show-alt"></i>
                </button>

                <!-- EDIT -->
                <a href="<?= BASE_URL ?>/admin/agenda/edit/<?= $a['id_agenda']; ?>"
                   class="btn btn-sm btn-outline-primary me-1">
                  <i class="bx bx-edit-alt"></i>
                </a>

                <!-- DELETE -->
                <a href="<?= BASE_URL ?>/admin/agenda/delete/<?= $a['id_agenda']; ?>"
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
  <div class="modal fade" id="modalDetailAgenda" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header bg-warning text-dark">
          <div>
            <h5 class="modal-title mb-0 fw-bold" style="color: white;">Informasi Detail</h5>
            <small class="opacity-75">Informasi Lengkap Kegiatan</small>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <!-- Nama Agenda -->
          <div class="mb-4">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-bookmarks"></i> NAMA AGENDA
            </label>
            <div class="alert alert-warning mb-0">
              <h5 class="mb-0 fw-bold" id="detailNamaAgenda"></h5>
            </div>
          </div>

          <hr class="my-3">

          <!-- Gambar Preview -->
          <div class="mb-4 text-center">
            <label class="form-label fw-bold text-muted small mb-2">
              <i class="bx bx-image"></i> GAMBAR AGENDA
            </label>
            <div class="border rounded p-2 bg-light">
              <img id="detailGambar" src="" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
            </div>
          </div>

          <hr class="my-3">

          <!-- Tanggal -->
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="form-label fw-bold text-muted small mb-1">
                <i class="bx bx-calendar-event"></i> TANGGAL MULAI
              </label>
              <p class="fs-6 mb-0" id="detailMulai"></p>
            </div>
            <div class="col-md-6">
              <label class="form-label fw-bold text-muted small mb-1">
                <i class="bx bx-calendar-check"></i> TANGGAL SELESAI
              </label>
              <p class="fs-6 mb-0" id="detailSelesai"></p>
            </div>
          </div>

          <hr class="my-3">

          <!-- Lokasi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-map"></i> LOKASI
            </label>
            <div class="alert alert-warning mb-0">
              <i class="bx bx-map-pin"></i> <span id="detailLokasi"></span>
            </div>
          </div>

          <hr class="my-3">

          <!-- Deskripsi -->
          <div class="mb-3">
            <label class="form-label fw-bold text-muted small mb-1">
              <i class="bx bx-file-blank"></i> DESKRIPSI KEGIATAN
            </label>
            <div class="bg-light p-3 rounded" id="detailDeskripsi"></div>
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
$table_name = 'agenda';
include './app/views/components/page_scripts.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function () {

  $(".btn-view").click(function () {

    let nama = $(this).data("nama");
    let deskripsi = $(this).data("deskripsi");
    let lokasi = $(this).data("lokasi");
    let mulai = $(this).data("mulai");
    let selesai = $(this).data("selesai");
    let gambar = $(this).data("gambar");

    // Set judul
    $("#detailNamaAgenda").text(nama);

    // Set gambar
    $("#detailGambar").attr("src", gambar);

    // Set tanggal
    $("#detailMulai").html(`<strong>${mulai}</strong>`);
    $("#detailSelesai").html(`<strong>${selesai}</strong>`);

    // Set lokasi
    if (lokasi && lokasi.trim() !== "") {
        $("#detailLokasi").text(lokasi);
    } else {
        $("#detailLokasi").html(`<em>Belum ditentukan</em>`);
    }

    // Set deskripsi
    if (deskripsi && deskripsi.trim() !== "") {
        $("#detailDeskripsi").html(`<p class="mb-0">${deskripsi}</p>`);
    } else {
        $("#detailDeskripsi").html(`<p class="text-muted mb-0"><em>Tidak ada deskripsi</em></p>`);
    }

    // Show modal
    new bootstrap.Modal(document.getElementById("modalDetailAgenda")).show();
  });

});
</script>
