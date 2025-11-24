<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include  './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">

  <div class="container-xxl flex-grow-1 container-p-y">

    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0"><span class="text-muted fw-light">Manajemen Konten /</span> Data Berita</h4>
      <a href="<?php echo BASE_URL; ?>/admin/berita/create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Tambah Berita
      </a>
    </div>

    <div class="card">


      <div class="table-responsive text-nowrap p-3">
        <table id="table-berita" class="table table-striped align-middle">
          <thead>
            <tr>
              <th>No</th>
              <th>Judul Berita</th>
              <th>Gambar</th>
              <th>Tanggal Publish</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody class="table-border-bottom-0">
            <?php
            // Memastikan variabel ada dan merupakan array
            $berita_list = isset($berita_list) ? $berita_list : (isset($berita_list) ? $berita_list : []);
            if (empty($berita_list) && isset($beritas)) $berita_list = $beritas;
            if (empty($berita_list) && isset($berita)) $berita_list = is_array($berita) ? [$berita] : [];

            if (!empty($berita_list)) {
              $counter = 1;
              foreach ($berita_list as $b): ?>
                <tr>
                  <td><?php echo $counter++; ?></td>
                  <td style="max-width:380px;">
                    <?php echo htmlspecialchars($b['judul_berita'] ?? $b['judul'] ?? ''); ?>
                    <?php if (!empty($b['slug_berita'] ?? $b['slug'])): ?>
                      <div class="text-muted small">/<span><?php echo htmlspecialchars($b['slug_berita'] ?? $b['slug']); ?></span></div>
                    <?php endif; ?>
                  </td>
                  <td>
                    <?php if (!empty($b['gambar_berita'])): ?>
                      <img src="<?php echo BASE_URL; ?>/public/uploads/berita/<?php echo htmlspecialchars($b['gambar_berita']); ?>" alt="gambar" class="rounded-2" style="height:80px; border-radius:4px;" />
                    <?php else: ?>
                      -
                    <?php endif; ?>
                  </td>
                  <td><?php echo htmlspecialchars($b['tanggal_publish'] ?? ($b['tanggal'] ?? '')); ?></td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-sm btn-outline-info me-1"

                      data-bs-toggle="modal"
                      data-bs-target="#modalDetail"

                      data-judul="<?php echo htmlspecialchars($b['judul_berita'] ?? $b['judul'] ?? ''); ?>"
                      data-deskripsi="<?php echo htmlspecialchars($b['isi_berita'] ?? $b['isi'] ?? ''); ?>"
                      data-gambar="<?php echo BASE_URL; ?>/public/uploads/berita/<?php echo htmlspecialchars($b['gambar_berita']); ?>"
                      data-tanggal="<?php echo htmlspecialchars($b['tanggal_publish'] ?? ($b['tanggal'] ?? '')); ?>">

                      <i class="bx bx-show-alt"></i>
                    </button>

                    <a href="<?php echo BASE_URL; ?>/admin/berita/edit/<?php echo htmlspecialchars($b['id_berita'] ?? $b['id'] ?? ''); ?>" class="btn btn-sm btn-outline-primary me-1">
                      <i class="bx bx-edit-alt"></i>
                    </a>

                    <a href="<?php echo BASE_URL; ?>/admin/berita/delete/<?php echo htmlspecialchars($b['id_berita'] ?? $b['id'] ?? ''); ?>" class="btn btn-sm btn-outline-danger btn-delete">
                      <i class="bx bx-trash"></i>
                    </a>

                  </td>
                </tr>
            <?php endforeach;
            } 
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
$table_name = 'berita';
include './app/views/components/page_scripts.php';
?>
