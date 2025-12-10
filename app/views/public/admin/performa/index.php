<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">SPK /</span> Kinerja Peneliti
      </h4>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
      <div class="card-body">
        <form method="GET" action="<?= BASE_URL ?>/admin/performa" class="row align-items-end">
          <div class="col-md-4">
            <label for="filterTahun" class="form-label">Filter Berdasarkan Tahun</label>
            <select class="form-select" id="filterTahun" name="tahun">
              <option value="">Semua Tahun</option>
              <?php if (!empty($years)): ?>
                <?php foreach ($years as $year): ?>
                  <option value="<?= htmlspecialchars($year['tahun']) ?>" 
                    <?= ($selected_year == $year['tahun']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($year['tahun']) ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary">
              <i class="bx bx-filter-alt me-1"></i> Filter
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Info Card -->
    <div class="alert alert-info mb-4">
      <div class="d-flex align-items-center">
        <i class="bx bx-info-circle bx-md me-3"></i>
        <div>
          <strong>Sistem Penilaian Kinerja Peneliti</strong><br>
          <small>Menggunakan metode SAW (Simple Additive Weighting) dengan kriteria: 
            <strong>Penelitian (50%)</strong> dan <strong>Pengabdian (50%)</strong>
          </small>
        </div>
      </div>
    </div>

    <!-- Ranking Table -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
          <i class="bx bx-trophy text-warning me-2"></i> Peringkat Kinerja Peneliti
        </h5>
      </div>

      <div class="table-responsive text-nowrap p-3">
        <table id="table-performa" class="table table-striped table-hover align-middle">
          <thead class="table-primary">
            <tr>
              <th class="text-center" style="width: 60px;">Rank</th>
              <th>Nama Peneliti</th>
              <th>Jabatan</th>
              <th class="text-center">Penelitian</th>
              <th class="text-center">Pengabdian</th>
              <th class="text-center">Total Skor</th>
              <th class="text-center">Aksi</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">
            <?php if (!empty($ranking)): ?>
              <?php foreach ($ranking as $item): ?>
                <?php
                // Badge color based on rank
                $badgeClass = 'bg-secondary';
                if ($item['rank'] == 1) $badgeClass = 'bg-warning';
                elseif ($item['rank'] == 2) $badgeClass = 'bg-secondary';
                elseif ($item['rank'] == 3) $badgeClass = 'bg-label-warning';
                elseif ($item['rank'] <= 5) $badgeClass = 'bg-info';
                ?>
                <tr>
                  <td class="text-center">
                    <span class="badge <?= $badgeClass ?> badge-lg">
                      <?= $item['rank'] ?>
                    </span>
                  </td>
                  
                  <td>
                    <div class="d-flex align-items-center">
                      <?php if (!empty($item['foto_pengelola'])): ?>
                        <img src="<?= BASE_URL ?>/public/uploads/pengelola/<?= htmlspecialchars($item['foto_pengelola']) ?>" 
                             alt="Foto" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                      <?php else: ?>
                        <div class="avatar avatar-sm me-2">
                          <span class="avatar-initial rounded-circle bg-label-primary">
                            <i class="bx bx-user"></i>
                          </span>
                        </div>
                      <?php endif; ?>
                      <div>
                        <strong><?= htmlspecialchars($item['nama_pengelola']) ?></strong><br>
                        <small class="text-muted"><?= htmlspecialchars($item['nid_nip'] ?? '-') ?></small>
                      </div>
                    </div>
                  </td>

                  <td><?= htmlspecialchars($item['nama_jabatan']) ?></td>

                  <td class="text-center">
                    <span class="badge bg-label-primary"><?= $item['c1_penelitian'] ?></span>
                  </td>

                  <td class="text-center">
                    <span class="badge bg-label-success"><?= $item['c2_pengabdian'] ?></span>
                  </td>

                  <td class="text-center">
                    <strong class="text-primary"><?= number_format($item['total_score'], 2) ?></strong>
                  </td>

                  <td class="text-center">
                    <button type="button" 
                            class="btn btn-sm btn-outline-info btn-view-detail"
                            data-nama="<?= htmlspecialchars($item['nama_pengelola']) ?>"
                            data-jabatan="<?= htmlspecialchars($item['nama_jabatan']) ?>"
                            data-penelitian="<?= $item['c1_penelitian'] ?>"
                            data-pengabdian="<?= $item['c2_pengabdian'] ?>"
                            data-n-c1="<?= number_format($item['n_c1'], 4) ?>"
                            data-n-c2="<?= number_format($item['n_c2'], 4) ?>"
                            data-score="<?= number_format($item['total_score'], 4) ?>">
                      <i class="bx bx-show-alt"></i>
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center py-5">
                  <i class="bx bx-data bx-lg text-muted"></i><br>
                  <span class="text-muted">Belum ada data untuk ditampilkan</span>
                </td>
              </tr>
            <?php endif; ?>
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
?>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetailPerforma" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      <div class="modal-header bg-primary text-white">
        <div>
          <h5 class="modal-title mb-0" style="color: white;">Detail Penilaian</h5>
          <small class="opacity-75">Perhitungan Skor SAW</small>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        
        <!-- Nama & Jabatan -->
        <div class="mb-3">
          <label class="form-label fw-bold text-muted small mb-1">
            <i class="bx bx-user"></i> NAMA PENELITI
          </label>
          <h5 class="mb-0" id="modalNama"></h5>
          <small class="text-muted" id="modalJabatan"></small>
        </div>

        <hr class="my-3">

        <!-- Raw Values -->
        <div class="mb-3">
          <label class="form-label fw-bold text-muted small mb-2">DATA AKTUAL</label>
          <div class="row g-2">
            <div class="col-4">
              <div class="card bg-label-primary text-center p-2">
                <small>Penelitian</small>
                <h4 class="mb-0" id="modalPenelitian"></h4>
              </div>
            </div>
            <div class="col-4">
              <div class="card bg-label-success text-center p-2">
                <small>Pengabdian</small>
                <h4 class="mb-0" id="modalPengabdian"></h4>
              </div>
            </div>
          </div>
        </div>

        <hr class="my-3">

        <!-- Normalized Values -->
        <div class="mb-3">
          <label class="form-label fw-bold text-muted small mb-2">NILAI NORMALISASI</label>
          <ul class="list-unstyled">
            <li class="mb-2">
              <div class="d-flex justify-content-between">
                <span>C1 (Penelitian):</span>
                <strong id="modalNC1"></strong>
              </div>
            </li>
            <li class="mb-2">
              <div class="d-flex justify-content-between">
                <span>C2 (Pengabdian):</span>
                <strong id="modalNC2"></strong>
              </div>
            </li>
          </ul>
        </div>

        <hr class="my-3">

        <!-- Final Score -->
        <div class="alert alert-primary mb-0">
          <div class="d-flex justify-content-between align-items-center">
            <strong><i class="bx bx-trophy"></i> TOTAL SKOR AKHIR:</strong>
            <h4 class="mb-0 text-primary" id="modalScore"></h4>
          </div>
          <small class="text-muted d-block mt-2">
            Formula: (C1 × 0.50) + (C2 × 0.50)
          </small>
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

<script>
document.addEventListener("DOMContentLoaded", function () {
  
  // Initialize DataTable
  if (typeof $.fn.DataTable !== 'undefined') {
    $('#table-performa').DataTable({
      "responsive": true,
      "pageLength": 10,
      "ordering": false,
      "pagingType": "simple_numbers",
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
        "paginate": {
          "next": ">",
          "previous": "<"
        },
      }
    });
  }

  // Detail modal handler
  $(".btn-view-detail").on("click", function () {
    let nama = $(this).data("nama");
    let jabatan = $(this).data("jabatan");
    let penelitian = $(this).data("penelitian");
    let pengabdian = $(this).data("pengabdian");
    let nC1 = $(this).data("n-c1");
    let nC2 = $(this).data("n-c2");
    let score = $(this).data("score");

    $("#modalNama").text(nama);
    $("#modalJabatan").text(jabatan);
    $("#modalPenelitian").text(penelitian);
    $("#modalPengabdian").text(pengabdian);
    $("#modalNC1").text(nC1);
    $("#modalNC2").text(nC2);
    $("#modalScore").text(score);

    new bootstrap.Modal(document.getElementById("modalDetailPerforma")).show();
  });

});
</script>
