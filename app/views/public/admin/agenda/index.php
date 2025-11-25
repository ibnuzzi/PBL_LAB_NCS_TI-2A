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
                  data-deskripsi="<?= htmlspecialchars($a['deskripsi_agenda']); ?>"
                  data-lokasi="<?= htmlspecialchars($a['lokasi']); ?>"
                  data-mulai="<?= $mulaiTxt; ?>"
                  data-selesai="<?= $selesaiTxt; ?>"
                  data-gambar="<?= $gambarUrl; ?>"
                  data-bs-toggle="modal"
                  data-bs-target="#modalDetailAgenda"
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title fw-bold" id="detailNamaAgenda">Detail Agenda</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <div class="text-center mb-3">
            <img id="detailGambar" src="" class="rounded"
                 style="width:240px; height:160px; object-fit:cover;">
          </div>

          <p><strong>Nama Agenda:</strong> <span id="detailNama"></span></p>
          <p><strong>Deskripsi:</strong></p>
          <p id="detailDeskripsi"></p>

          <p><strong>Lokasi:</strong> <span id="detailLokasi"></span></p>

          <p><strong>Tanggal Mulai:</strong> <span id="detailMulai"></span></p>
          <p><strong>Tanggal Selesai:</strong> <span id="detailSelesai"></span></p>

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
$table_name = 'agenda';
include './app/views/components/page_scripts.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function () {

  $(".btn-view").click(function () {

    $("#detailNama").text($(this).data("nama"));
    $("#detailDeskripsi").text($(this).data("deskripsi"));
    $("#detailLokasi").text($(this).data("lokasi"));
    $("#detailMulai").text($(this).data("mulai"));
    $("#detailSelesai").text($(this).data("selesai"));
    $("#detailGambar").attr("src", $(this).data("gambar"));
  });

});
</script>
