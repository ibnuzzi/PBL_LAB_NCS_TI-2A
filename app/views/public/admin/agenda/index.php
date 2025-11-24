<?php
// Use admin templates (header, sidebar, footer)
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">Manajemen Konten /</span> Data Agenda
      </h4>

      <a href="<?php echo BASE_URL; ?>/admin/agenda/create" class="btn btn-primary">
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
              <th>Tanggal</th>
              <th>Lokasi</th>
              <th>Gambar</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">

            <?php
            // Memastikan variabel ada dan merupakan array
            $agenda_list = isset($agenda_list) ? $agenda_list : (isset($agenda_list) ? $agenda_list : []);
            if (empty($agenda_list) && isset($agendas)) $agenda_list = $agendas;
            if (empty($agenda_list) && isset($agenda)) $agenda_list = is_array($agenda) ? [$agenda] : [];

            if (!empty($agenda_list)):
              $counter = 1;

              foreach ($agenda_list as $a):

                // Format tanggal
                $mulai = $a['tanggal_mulai'] ?? '';
                $selesai = $a['tanggal_selesai'] ?? '';

                $s1 = $mulai ? date('Y-m-d H:i', strtotime($mulai)) : '';
                $s2 = $selesai ? date('Y-m-d H:i', strtotime($selesai)) : '';

                $rangeTanggal = ($s1 && $s2) ? "$s1 s/d $s2" : ($s1 ?: $s2 ?: '-');

            ?>

              <tr>
                <td><?php echo $counter++; ?></td>

                <td style="max-width:380px;">
                  <?php echo htmlspecialchars($a['nama_agenda'] ?? ''); ?>
                </td>

                <td><?php echo htmlspecialchars($rangeTanggal); ?></td>

                <td><?php echo htmlspecialchars($a['lokasi'] ?? '-'); ?></td>

                <td>
                  <?php if (!empty($a['gambar_agenda'])): ?>
                    <img
                      src="<?php echo BASE_URL; ?>/public/uploads/agenda/<?php echo htmlspecialchars($a['gambar_agenda']); ?>"
                      alt="gambar"
                      class="rounded-2"
                      style="height:80px; border-radius:4px;" />
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>

                <td>

                  <!-- Modal Preview -->
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-info me-1"
                    data-bs-toggle="modal"
                    data-bs-target="#modalDetail"

                    data-judul="<?php echo htmlspecialchars($a['nama_agenda']); ?>"
                    data-deskripsi="<?php echo htmlspecialchars($a['lokasi']); ?>"
                    data-gambar="<?php echo BASE_URL; ?>/public/uploads/agenda/<?php echo htmlspecialchars($a['gambar_agenda']); ?>"
                    data-tanggal="<?php echo htmlspecialchars($rangeTanggal); ?>"
                  >
                    <i class="bx bx-show-alt"></i>
                  </button>

                  <!-- Edit -->
                  <a
                    href="<?php echo BASE_URL; ?>/admin/agenda/edit/<?php echo htmlspecialchars($a['id_agenda']); ?>"
                    class="btn btn-sm btn-outline-primary me-1">
                    <i class="bx bx-edit-alt"></i>
                  </a>

                  <!-- Delete -->
                  <a
                    href="<?php echo BASE_URL; ?>/admin/agenda/delete/<?php echo htmlspecialchars($a['id_agenda']); ?>"
                    class="btn btn-sm btn-outline-danger btn-delete">
                    <i class="bx bx-trash"></i>
                  </a>

                </td>
              </tr>

            <?php
              endforeach;
            endif;
            ?>

          </tbody>
        </table>
      </div>
    </div>
  </div>

  <?php
  include './app/views/components/modal.php';
  include './app/views/components/toaster.php';
  ?>
</div>

<?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';

// Kirim nama table ke script dinamis
$table_name = 'agenda';

include './app/views/components/page_scripts.php';
?>
