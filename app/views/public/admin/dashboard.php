<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
require_once __DIR__ . '../../../templates/admin/header_admin.php';
require_once __DIR__ . '../../../templates/admin/sidebar_admin.php';
?>

  <!-- CONTENT -->
  <div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0"><span class="text-muted fw-light">Dashboard /</span> Overview</h4>
      </div>

      <!-- STATISTICS WIDGETS -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Total Berita</h5>
              <p class="fs-3">120</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Agenda Terjadwal</h5>
              <p class="fs-3">15</p>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Total Pengabdian</h5>
              <p class="fs-3">50</p>
            </div>
          </div>
        </div>
      </div>

      <!-- GRAPHICS / CHARTS -->
      <div class="row">
        <div class="col-md-12 mb-3">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">Statistik Kegiatan</h5>
              <canvas id="activitiesChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /CONTENT -->


<!-- Chart init (page-specific) -->
<script>
  if (typeof Chart !== 'undefined') {
    try {
      var ctx = document.getElementById('activitiesChart').getContext('2d');
      var activitiesChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Penelitian', 'Pengabdian', 'Agenda', 'Berita'],
          datasets: [{
            label: 'Jumlah Kegiatan',
            data: [50, 40, 15, 120],
            backgroundColor: ['#696cff', '#28a745', '#ff6f61', '#ffc107'],
            borderWidth: 1
          }]
        },
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
      });
    } catch (e) { console.error(e); }
  }
</script>

<?php
// Footer (includes scripts)
require_once __DIR__ . '../../../templates/admin/footer_admin.php';
?>
