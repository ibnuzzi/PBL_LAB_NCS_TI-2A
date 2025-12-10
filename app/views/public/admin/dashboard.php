<?php
// Use admin templates (header, sidebar, footer) to render this dashboard page
include './app/views/templates/admin/header_admin.php';
include './app/views/templates/admin/sidebar_admin.php';

// Set default values jika tidak ada data
$totalBerita = $totalBerita ?? 0;
$totalAgenda = $totalAgenda ?? 0;
$totalPengabdian = $totalPengabdian ?? 0;
$totalPenelitian = $totalPenelitian ?? 0;
$totalPertanyaan = $totalPertanyaan ?? 0;
$totalAnggota = $totalAnggota ?? 0;
$recentBerita = $recentBerita ?? [];
$recentAgenda = $recentAgenda ?? [];
$recentPertanyaan = $recentPertanyaan ?? [];
$workloadDistribution = $workloadDistribution ?? ['ringan' => 0, 'sedang' => 0, 'tinggi' => 0];
$topKeminatan = $topKeminatan ?? [];
?>

<!-- CONTENT -->
<div class="content-wrapper">
  <div class="container-xxl flex-grow-1 container-p-y">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h4 class="fw-bold mb-1">Dashboard Overview 📊</h4>
        <p class="text-muted mb-0">Selamat datang di sistem manajemen laboratorium</p>
      </div>
      <div class="text-muted">
        <i class="bx bx-calendar"></i> <?= date('d F Y') ?>
      </div>
    </div>

    <!-- STATISTICS CARDS -->
    <div class="d-flex gap-3 mb-4">
      <!-- Total Berita -->
      <div style="flex: 1 1 0; min-width: 0;">
        <div class="card border-0 shadow-sm" style="background: #667eea; aspect-ratio: 3 / 2;">
          <div class="card-body text-white d-flex flex-column justify-content-between h-100 p-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="mb-1 opacity-75 small">Total Berita</p>
                <h2 class="fw-bold mb-0" style="color: white;"><?= $totalBerita ?></h2>
              </div>
              <i class="bx bx-news" style="font-size: 35px; opacity: 0.9;"></i>
            </div>
            <div class="d-flex align-items-center">
              <i class="bx bx-trending-up me-1"></i>
              <small>Publikasi aktif</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Agenda -->
      <div style="flex: 1 1 0; min-width: 0;">
        <div class="card border-0 shadow-sm" style="background: #f5576c; aspect-ratio: 3 / 2;">
          <div class="card-body text-white d-flex flex-column justify-content-between h-100 p-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="mb-1 opacity-75 small">Total Agenda</p>
                <h2 class="fw-bold mb-0" style="color: white;"><?= $totalAgenda ?></h2>
              </div>
              <i class="bx bx-calendar-event" style="font-size: 35px; opacity: 0.9;"></i>
            </div>
            <div class="d-flex align-items-center">
              <i class="bx bx-time me-1"></i>
              <small>Kegiatan terjadwal</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Pengabdian -->
      <div style="flex: 1 1 0; min-width: 0;">
        <div class="card border-0 shadow-sm" style="background: #4facfe; aspect-ratio: 3 / 2;">
          <div class="card-body text-white d-flex flex-column justify-content-between h-100 p-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="mb-1 opacity-75 small">Total Pengabdian</p>
                <h2 class="fw-bold mb-0" style="color: white;"><?= $totalPengabdian ?></h2>
              </div>
              <i class="bx bx-donate-heart" style="font-size: 35px; opacity: 0.9;"></i>
            </div>
            <div class="d-flex align-items-center">
              <i class="bx bx-group me-1"></i>
              <small>Kegiatan pengabdian</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Penelitian -->
      <div style="flex: 1 1 0; min-width: 0;">
        <div class="card border-0 shadow-sm" style="background: #fa709a; aspect-ratio: 3 / 2;">
          <div class="card-body text-white d-flex flex-column justify-content-between h-100 p-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="mb-1 opacity-75 small">Total Penelitian</p>
                <h2 class="fw-bold mb-0" style="color: white;"><?= $totalPenelitian ?></h2>
              </div>
              <i class="bx bx-book-open" style="font-size: 35px; opacity: 0.9;"></i>
            </div>
            <div class="d-flex align-items-center">
              <i class="bx bx-search-alt me-1"></i>
              <small>Riset & publikasi</small>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Anggota Lab -->
      <div style="flex: 1 1 0; min-width: 0;">
        <div class="card border-0 shadow-sm" style="background: #43e97b; aspect-ratio: 3 / 2;">
          <div class="card-body text-white d-flex flex-column justify-content-between h-100 p-3">
            <div class="d-flex justify-content-between align-items-start">
              <div>
                <p class="mb-1 opacity-75 small">Total Anggota Lab</p>
                <h2 class="fw-bold mb-0" style="color: white;"><?= $totalAnggota ?></h2>
              </div>
              <i class="bx bx-group" style="font-size: 35px; opacity: 0.9;"></i>
            </div>
            <div class="d-flex align-items-center">
              <i class="bx bx-user-check me-1"></i>
              <small>Pengelola laboratorium</small>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ROW 2: ANALYTICS INSIGHTS (PRIORITY) -->
    <div class="row g-3 mb-4">
      <!-- DISTRIBUSI BEBAN KERJA -->
      <div class="col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-light">
            <h5 class="card-title mb-0">
              <i class="bx bx-pie-chart-alt-2 text-primary"></i> Distribusi Beban Kerja Peneliti
            </h5>
          </div>
          <div class="card-body">
            <canvas id="workloadChart" style="max-height: 300px;"></canvas>
            <div class="mt-3 text-center">
              <small class="text-muted">
                <i class="bx bx-info-circle"></i> Kategori Beban:
                <span class="badge bg-success ms-1">Ringan (0-3)</span>
                <span class="badge bg-warning ms-1">Sedang (4-5)</span>
                <span class="badge bg-danger ms-1">Tinggi (>5)</span>
              </small>
            </div>
          </div>
        </div>
      </div>

      <!-- TOP 5 KEMINATAN -->
      <div class="col-lg-6 col-md-6">
        <div class="card shadow-sm h-100">
          <div class="card-header bg-light">
            <h5 class="card-title mb-0">
              <i class="bx bx-bar-chart-alt text-success"></i> Top 5 Keminatan Riset Populer
            </h5>
          </div>
          <div class="card-body">
            <canvas id="keminatanChart" style="max-height: 300px;"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- ROW 3: OPERATIONAL DATA -->
    <div class="row g-3">

      <!-- LEFT: PERTANYAAN KONSULTASI -->
      <div class="col-lg-6">
        <div class="card shadow-sm h-100">
          <div class="card-header d-flex justify-content-between align-items-center bg-light">
            <h5 class="card-title mb-0">
              <i class="bx bx-help-circle text-primary"></i> Konsultasi Terbaru
            </h5>
            <span class="badge bg-label-primary"><?= $totalPertanyaan ?> Total</span>
          </div>
          <div class="card-body">
            <?php if (!empty($recentPertanyaan)): ?>
              <?php $count = 0;
              foreach ($recentPertanyaan as $p): $count++;
                if ($count > 3) break; ?>
                <div class="card mb-3 border">
                  <div class="card-body p-3">
                    <div class="d-flex align-items-start">
                      <div class="avatar avatar-md flex-shrink-0 me-3">
                        <span class="avatar-initial rounded-circle bg-label-info">
                          <i class="bx bx-user bx-sm"></i>
                        </span>
                      </div>
                      <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <h6 class="mb-1"><?= htmlspecialchars($p['nama_penanya'] ?? 'Penanya') ?></h6>
                            <p class="mb-0 text-muted small">
                              <i class="bx bx-envelope"></i> <?= htmlspecialchars($p['email_penanya'] ?? 'Email tidak tersedia') ?>
                            </p>
                          </div>
                          <span class="badge bg-label-primary"><?= date('d M', strtotime($p['tanggal_tanya'] ?? 'now')) ?></span>
                        </div>
                        <p class="mb-0 text-dark" style="font-size: 0.9rem;">
                          <?= htmlspecialchars(substr($p['pertanyaan'] ?? '', 0, 120)) ?>...
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="text-center">
                <a href="<?= BASE_URL ?>/admin/konsultasi" class="btn btn-sm btn-outline-primary">
                  Lihat Semua Konsultasi <i class="bx bx-right-arrow-alt"></i>
                </a>
              </div>
            <?php else: ?>
              <div class="text-center py-5">
                <i class="bx bx-inbox bx-lg text-muted mb-2"></i>
                <p class="text-muted">Belum ada pertanyaan</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- RIGHT: AGENDA & BERITA -->
      <div class="col-lg-6">

        <!-- AGENDA MENDATANG -->
        <div class="card shadow-sm mb-3">
          <div class="card-header bg-light">
            <h5 class="card-title mb-0">
              <i class="bx bx-calendar text-primary"></i> Agenda Mendatang
            </h5>
          </div>
          <div class="card-body">
            <?php if (!empty($recentAgenda)): ?>
              <?php $count = 0;
              foreach ($recentAgenda as $idx => $a): $count++;
                if ($count > 4) break; ?>
                <div class="d-flex mb-3 pb-3 border-bottom">
                  <?php if (!empty($a['gambar_agenda'])): ?>
                    <img src="<?= BASE_URL ?>/public/uploads/agenda/<?= $a['gambar_agenda'] ?>"
                      class="rounded me-3"
                      style="width: 60px; height: 60px; object-fit: cover;">
                  <?php else: ?>
                    <div class="avatar avatar-md me-3">
                      <span class="avatar-initial rounded bg-label-primary">
                        <i class="bx bx-calendar-event"></i>
                      </span>
                    </div>
                  <?php endif; ?>
                  <div class="flex-grow-1">
                    <h6 class="mb-1"><?= htmlspecialchars($a['nama_agenda'] ?? 'Agenda') ?></h6>
                    <div class="mb-1">
                      <small class="text-muted">
                        <i class="bx bx-calendar"></i>
                        <?= date('d M Y', strtotime($a['tanggal_mulai'] ?? 'now')) ?>
                        <?php if (!empty($a['tanggal_selesai']) && $a['tanggal_selesai'] != $a['tanggal_mulai']): ?>
                          - <?= date('d M Y', strtotime($a['tanggal_selesai'])) ?>
                        <?php endif; ?>
                      </small>
                    </div>
                    <?php if (!empty($a['lokasi'])): ?>
                      <small class="text-muted">
                        <i class="bx bx-map"></i> <?= htmlspecialchars($a['lokasi']) ?>
                      </small>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="text-center mt-2">
                <a href="<?= BASE_URL ?>/admin/agenda" class="btn btn-sm btn-outline-primary">
                  Lihat Semua Agenda <i class="bx bx-right-arrow-alt"></i>
                </a>
              </div>
            <?php else: ?>
              <div class="text-center py-4">
                <i class="bx bx-calendar-x text-muted mb-2"></i>
                <p class="text-muted small">Belum ada agenda</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- BERITA TERBARU -->
        <div class="card shadow-sm">
          <div class="card-header bg-light">
            <h5 class="card-title mb-0">
              <i class="bx bx-news text-primary"></i> Berita Terbaru
            </h5>
          </div>
          <div class="card-body">
            <?php if (!empty($recentBerita)): ?>
              <?php foreach ($recentBerita as $b): ?>
                <div class="d-flex mb-2 pb-2 border-bottom">
                  <?php if (!empty($b['gambar_berita'])): ?>
                    <img src="<?= BASE_URL ?>/public/uploads/berita/<?= $b['gambar_berita'] ?>"
                      class="rounded me-2"
                      style="width: 50px; height: 50px; object-fit: cover;">
                  <?php else: ?>
                    <div class="avatar avatar-md me-3">
                      <span class="avatar-initial rounded bg-label-secondary">
                        <i class="bx bx-image"></i>
                      </span>
                    </div>
                  <?php endif; ?>
                  <div class="flex-grow-1">
                    <h6 class="mb-1"><?= htmlspecialchars(substr($b['judul_berita'] ?? 'Berita', 0, 60)) ?></h6>
                    <small class="text-muted">
                      <i class="bx bx-time-five"></i> <?= date('d M Y', strtotime($b['tanggal_publish'] ?? 'now')) ?>
                    </small>
                  </div>
                </div>
              <?php endforeach; ?>
              <div class="text-center mt-2">
                <a href="<?= BASE_URL ?>/admin/berita" class="btn btn-sm btn-outline-primary">
                  Lihat Semua Berita <i class="bx bx-right-arrow-alt"></i>
                </a>
              </div>
            <?php else: ?>
              <div class="text-center py-4">
                <i class="bx bx-news text-muted mb-2"></i>
                <p class="text-muted small">Belum ada berita</p>
              </div>
            <?php endif; ?>
          </div>
        </div>

      </div>

    </div>

  </div>
</div>
<!-- /CONTENT -->


<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- Chart init (page-specific) -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof Chart !== 'undefined') {
      try {
        // WORKLOAD DISTRIBUTION CHART (Donut)
        var workloadCtx = document.getElementById('workloadChart').getContext('2d');
        var workloadChart = new Chart(workloadCtx, {
          type: 'doughnut',
          data: {
            labels: ['Ringan (0-3 proyek)', 'Sedang (4-5 proyek)', 'Tinggi (>5 proyek)'],
            datasets: [{
              data: [
                <?= $workloadDistribution['ringan'] ?? 0 ?>,
                <?= $workloadDistribution['sedang'] ?? 0 ?>,
                <?= $workloadDistribution['tinggi'] ?? 0 ?>
              ],
              backgroundColor: [
                'rgba(67, 233, 123, 0.8)', // Green for Light
                'rgba(255, 193, 7, 0.8)', // Yellow for Medium
                'rgba(245, 87, 108, 0.8)' // Red for Heavy
              ],
              borderColor: [
                'rgb(67, 233, 123)',
                'rgb(255, 193, 7)',
                'rgb(245, 87, 108)'
              ],
              borderWidth: 2
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                position: 'bottom',
                labels: {
                  padding: 15,
                  font: {
                    size: 12
                  }
                }
              },
              tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                callbacks: {
                  label: function(context) {
                    var label = context.label || '';
                    var value = context.parsed || 0;
                    var total = context.dataset.data.reduce((a, b) => a + b, 0);
                    var percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                    return label + ': ' + value + ' peneliti (' + percentage + '%)';
                  }
                }
              }
            }
          }
        });

        // TOP KEMINATAN CHART (Horizontal Bar)
        var keminatanCtx = document.getElementById('keminatanChart').getContext('2d');
        var keminatanLabels = [
          <?php
          if (!empty($topKeminatan)) {
            foreach ($topKeminatan as $k) {
              echo "'" . htmlspecialchars($k['nama_keminatan']) . "',";
            }
          }
          ?>
        ];
        var keminatanData = [
          <?php
          if (!empty($topKeminatan)) {
            foreach ($topKeminatan as $k) {
              echo $k['jumlah_peneliti'] . ",";
            }
          }
          ?>
        ];

        var keminatanChart = new Chart(keminatanCtx, {
          type: 'bar',
          data: {
            labels: keminatanLabels,
            datasets: [{
              label: 'Jumlah Peneliti',
              data: keminatanData,
              backgroundColor: [
                'rgba(102, 126, 234, 0.8)',
                'rgba(79, 172, 254, 0.8)',
                'rgba(250, 112, 154, 0.8)',
                'rgba(240, 147, 251, 0.8)',
                'rgba(67, 233, 123, 0.8)'
              ],
              borderColor: [
                'rgb(102, 126, 234)',
                'rgb(79, 172, 254)',
                'rgb(250, 112, 154)',
                'rgb(240, 147, 251)',
                'rgb(67, 233, 123)'
              ],
              borderWidth: 2,
              borderRadius: 6
            }]
          },
          options: {
            indexAxis: 'y', // Horizontal bars
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                callbacks: {
                  label: function(context) {
                    return 'Jumlah Peneliti: ' + context.parsed.x + ' orang';
                  }
                }
              }
            },
            scales: {
              x: {
                beginAtZero: true,
                ticks: {
                  stepSize: 1,
                  precision: 0
                },
                grid: {
                  color: 'rgba(0, 0, 0, 0.05)'
                }
              },
              y: {
                grid: {
                  display: false
                }
              }
            }
          }
        });

      } catch (e) {
        console.error('Chart initialization error:', e);
      }
    } else {
      console.error('Chart.js library not loaded!');
    }
  });
</script>

<?php
// Footer (includes scripts)
include './app/views/templates/admin/footer_admin.php';
?>