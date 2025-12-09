<?php
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';
?>

<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="fw-bold m-0">
        <span class="text-muted fw-light">SPK /</span> Rekomendasi Tim
      </h4>
    </div>

    <!-- Info Card -->
    <div class="alert alert-info mb-4">
      <div class="d-flex align-items-center">
        <i class="bx bx-info-circle bx-md me-3"></i>
        <div>
          <strong>Sistem Rekomendasi Tim Penelitian</strong><br>
          <small>Menggunakan metode Profile Matching untuk menemukan peneliti yang sesuai dengan keminatan yang dibutuhkan. 
            Sistem juga mempertimbangkan beban kerja peneliti saat ini.
          </small>
        </div>
      </div>
    </div>

    <!-- Form Card -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="mb-0">
          <i class="bx bx-search me-2"></i> Cari Kandidat Anggota Tim
        </h5>
      </div>
      <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/admin/rekomtim/recommend">
          
          <div class="mb-3">
            <label for="selectKeminatan" class="form-label">
              Pilih Keminatan yang Dibutuhkan <span class="text-danger">*</span>
            </label>
            <select class="form-select" id="selectKeminatan" name="keminatan[]" multiple required>
              <?php if (!empty($keminatan_list)): ?>
                <?php foreach ($keminatan_list as $kem): ?>
                  <option value="<?= $kem['id_keminatan'] ?>"
                    <?= (isset($selected_keminatan) && in_array($kem['id_keminatan'], $selected_keminatan)) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($kem['nama_keminatan']) ?>
                  </option>
                <?php endforeach; ?>
              <?php endif; ?>
            </select>
            <small class="text-muted">Pilih satu atau lebih keminatan untuk mencari kandidat yang sesuai</small>
          </div>

          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary">
              <i class="bx bx-search-alt me-1"></i> Cari Kandidat
            </button>
          </div>

        </form>
      </div>
    </div>

    <!-- Results Table (conditional display) -->
    <?php if (!empty($recommendations)): ?>
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
          <i class="bx bx-group text-success me-2"></i> Hasil Rekomendasi
        </h5>
        <span class="badge bg-success"><?= count($recommendations) ?> Kandidat Ditemukan</span>
      </div>

      <div class="table-responsive text-nowrap p-3">
        <table id="table-rekomendasi" class="table table-striped table-hover align-middle">
          <thead class="table-success">
            <tr>
              <th class="text-center" style="width: 60px;">Rank</th>
              <th>Nama Peneliti</th>
              <th>Jabatan</th>
              <th>Keminatan</th>
              <th class="text-center">Beban Kerja</th>
              <th class="text-center">Skor Kesesuaian</th>
              <th class="text-center">Skor Akhir</th>
            </tr>
          </thead>

          <tbody class="table-border-bottom-0">
            <?php foreach ($recommendations as $rec): ?>
              <?php
              // Badge color based on final score
              $scoreClass = 'bg-secondary';
              if ($rec['final_score'] >= 80) $scoreClass = 'bg-success';
              elseif ($rec['final_score'] >= 60) $scoreClass = 'bg-info';
              elseif ($rec['final_score'] >= 40) $scoreClass = 'bg-warning';

              // Rank badge
              $rankClass = 'bg-secondary';
              if ($rec['rank'] == 1) $rankClass = 'bg-success';
              elseif ($rec['rank'] <= 3) $rankClass = 'bg-info';
              ?>
              <tr>
                <td class="text-center">
                  <span class="badge <?= $rankClass ?> badge-lg">
                    <?= $rec['rank'] ?>
                  </span>
                </td>
                
                <td>
                  <div class="d-flex align-items-center">
                    <?php if (!empty($rec['foto_pengelola'])): ?>
                      <img src="<?= BASE_URL ?>/public/uploads/pengelola/<?= htmlspecialchars($rec['foto_pengelola']) ?>" 
                           alt="Foto" class="rounded-circle me-2" style="width: 35px; height: 35px; object-fit: cover;">
                    <?php else: ?>
                      <div class="avatar avatar-sm me-2">
                        <span class="avatar-initial rounded-circle bg-label-success">
                          <i class="bx bx-user"></i>
                        </span>
                      </div>
                    <?php endif; ?>
                    <div>
                      <strong><?= htmlspecialchars($rec['nama_pengelola']) ?></strong><br>
                      <small class="text-muted"><?= htmlspecialchars($rec['nid_nip'] ?? '-') ?></small>
                    </div>
                  </div>
                </td>

                <td><?= htmlspecialchars($rec['nama_jabatan']) ?></td>

                <td>
                  <small class="text-muted"><?= htmlspecialchars($rec['keminatan']) ?></small>
                  <br>
                  <span class="badge bg-label-primary">
                    <?= $rec['match_count'] ?> / <?= count($selected_keminatan ?? []) ?> Match
                  </span>
                </td>

                <td class="text-center">
                  <?php
                  $workloadClass = 'bg-label-success';
                  $workloadText = 'Ringan';
                  if ($rec['workload'] > 5) {
                    $workloadClass = 'bg-label-danger';
                    $workloadText = 'Tinggi';
                  } elseif ($rec['workload'] > 3) {
                    $workloadClass = 'bg-label-warning';
                    $workloadText = 'Sedang';
                  }
                  ?>
                  <span class="badge <?= $workloadClass ?>">
                    <?= $rec['workload'] ?> Proyek
                  </span>
                  <br><small class="text-muted"><?= $workloadText ?></small>
                </td>

                <td class="text-center">
                  <span class="badge bg-label-info">
                    <?= number_format($rec['match_score'], 1) ?>%
                  </span>
                </td>

                <td class="text-center">
                  <span class="badge <?= $scoreClass ?>">
                    <?= number_format($rec['final_score'], 1) ?>
                  </span>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <div class="card-footer bg-light">
        <small class="text-muted">
          <i class="bx bx-info-circle"></i> 
          <strong>Catatan:</strong> Skor akhir dihitung berdasarkan kesesuaian keminatan. 
          Peneliti dengan beban kerja tinggi (>5 proyek) mendapat pengurangan skor sebesar 20 poin.
        </small>
      </div>
    </div>
    <?php endif; ?>

  </div>

  <?php include './app/views/components/modal.php'; ?>
  <?php include './app/views/components/toaster.php'; ?>

</div>

<?php
include './app/views/templates/admin/footer_admin.php';
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
  
  // Initialize Select2 for multi-select (if available)
  if (typeof $.fn.select2 !== 'undefined') {
    $('#selectKeminatan').select2({
      placeholder: "Pilih keminatan yang dibutuhkan...",
      allowClear: true,
      width: '100%'
    });
  }

  // Initialize DataTable for results
  if (typeof $.fn.DataTable !== 'undefined' && $('#table-rekomendasi').length) {
    $('#table-rekomendasi').DataTable({
      "responsive": true,
      "pageLength": 10,
      "ordering": false,
      "pagingType": "full_numbers",
      "language": {
        "search": "Cari:",
        "lengthMenu": "Tampilkan _MENU_ data per halaman",
        "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ kandidat",
        "paginate": {
          "first": "<<",
          "last": ">>",
          "previous": "Sebelumnya",
          "next": "Selanjutnya"
        }
      }
    });
  }

});
</script>
