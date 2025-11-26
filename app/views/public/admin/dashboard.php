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
$recentBerita = $recentBerita ?? [];
$recentAgenda = $recentAgenda ?? [];
$recentPertanyaan = $recentPertanyaan ?? [];
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
      <div class="row g-3 mb-4">
        <!-- Total Berita -->
        <div class="col-xl-3 col-md-6">
          <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            <div class="card-body text-white">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="mb-1 opacity-75">Total Berita</p>
                  <h2 class="fw-bold mb-0"><?= $totalBerita ?></h2>
                </div>
                <i class="bx bx-news" style="font-size: 48px; opacity: 0.9;"></i>
              </div>
              <div class="mt-3 d-flex align-items-center">
                <i class="bx bx-trending-up me-1"></i>
                <small>Publikasi aktif</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Agenda -->
        <div class="col-xl-3 col-md-6">
          <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            <div class="card-body text-white">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="mb-1 opacity-75">Total Agenda</p>
                  <h2 class="fw-bold mb-0"><?= $totalAgenda ?></h2>
                </div>
                <i class="bx bx-calendar-event" style="font-size: 48px; opacity: 0.9;"></i>
              </div>
              <div class="mt-3 d-flex align-items-center">
                <i class="bx bx-time me-1"></i>
                <small>Kegiatan terjadwal</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Pengabdian -->
        <div class="col-xl-3 col-md-6">
          <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            <div class="card-body text-white">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="mb-1 opacity-75">Total Pengabdian</p>
                  <h2 class="fw-bold mb-0"><?= $totalPengabdian ?></h2>
                </div>
                <i class="bx bx-donate-heart" style="font-size: 48px; opacity: 0.9;"></i>
              </div>
              <div class="mt-3 d-flex align-items-center">
                <i class="bx bx-group me-1"></i>
                <small>Kegiatan pengabdian</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Total Penelitian -->
        <div class="col-xl-3 col-md-6">
          <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            <div class="card-body text-white">
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <p class="mb-1 opacity-75">Total Penelitian</p>
                  <h2 class="fw-bold mb-0"><?= $totalPenelitian ?></h2>
                </div>
                <i class="bx bx-book-open" style="font-size: 48px; opacity: 0.9;"></i>
              </div>
              <div class="mt-3 d-flex align-items-center">
                <i class="bx bx-search-alt me-1"></i>
                <small>Riset & publikasi</small>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- MAIN CONTENT ROW -->
      <div class="row g-3">
        
        <!-- LEFT COLUMN -->
        <div class="col-lg-8">
          
          <!-- PERTANYAAN TERBARU -->
          <div class="card shadow-sm mb-3">
            <div class="card-header d-flex justify-content-between align-items-center pb-0">
              <h5 class="card-title mb-0">
                <i class="bx bx-help-circle text-primary"></i> Pertanyaan Terbaru
              </h5>
              <span class="badge bg-label-primary"><?= $totalPertanyaan ?> Total</span>
            </div>
            <div class="card-body">
              <?php if (!empty($recentPertanyaan)): ?>
                <div class="list-group list-group-flush">
                  <?php foreach ($recentPertanyaan as $p): ?>
                    <div class="list-group-item px-0">
                      <div class="d-flex align-items-start">
                        <div class="avatar avatar-sm flex-shrink-0 me-3">
                          <span class="avatar-initial rounded-circle bg-label-info">
                            <i class="bx bx-user"></i>
                          </span>
                        </div>
                        <div class="flex-grow-1">
                          <div class="d-flex justify-content-between align-items-start">
                            <div>
                              <h6 class="mb-1"><?= htmlspecialchars($p['nama_penanya'] ?? 'Penanya') ?></h6>
                              <p class="mb-1 text-muted small"><?= htmlspecialchars($p['email_penanya'] ?? 'Email tidak tersedia') ?></p>
                            </div>
                            <small class="text-muted"><?= date('d M', strtotime($p['tanggal_tanya'] ?? 'now')) ?></small>
                          </div>
                          <p class="mb-0 mt-1"><?= htmlspecialchars(substr($p['pertanyaan'] ?? '', 0, 100)) ?>...</p>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                  <a href="<?= BASE_URL ?>/admin/konsultasi" class="btn btn-sm btn-outline-primary">
                    Lihat Semua Pertanyaan <i class="bx bx-right-arrow-alt"></i>
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

          <!-- CHART -->
          <div class="card shadow-sm">
            <div class="card-header">
              <h5 class="card-title mb-0">
                <i class="bx bx-bar-chart text-success"></i> Statistik Kegiatan
              </h5>
            </div>
            <div class="card-body">
              <canvas id="activitiesChart" style="max-height: 300px;"></canvas>
            </div>
          </div>

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-lg-4">
          
          <!-- AGENDA MENDATANG -->
          <div class="card shadow-sm mb-3">
            <div class="card-header pb-0">
              <h5 class="card-title mb-0">
                <i class="bx bx-calendar text-warning"></i> Agenda Mendatang
              </h5>
            </div>
            <div class="card-body">
              <?php if (!empty($recentAgenda)): ?>
                <div class="timeline timeline-sm">
                  <?php foreach ($recentAgenda as $idx => $a): ?>
                    <div class="timeline-item <?= $idx === count($recentAgenda) - 1 ? '' : 'mb-3' ?>">
                      <span class="timeline-point timeline-point-primary"></span>
                      <div class="timeline-event">
                        <div class="d-flex justify-content-between flex-wrap mb-1">
                          <h6 class="mb-0"><?= htmlspecialchars($a['nama_agenda'] ?? 'Agenda') ?></h6>
                        </div>
                        <small class="text-muted">
                          <i class="bx bx-time-five"></i> <?= date('d M Y', strtotime($a['tanggal_mulai'] ?? 'now')) ?>
                        </small>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
                <div class="text-center mt-3">
                  <a href="<?= BASE_URL ?>/admin/agenda" class="btn btn-sm btn-outline-warning">
                    Lihat Semua <i class="bx bx-right-arrow-alt"></i>
                  </a>
                </div>
              <?php else: ?>
                <div class="text-center py-4">
                  <i class="bx bx-calendar-x bx-lg text-muted mb-2"></i>
                  <p class="text-muted small">Belum ada agenda</p>
                </div>
              <?php endif; ?>
            </div>
          </div>

          <!-- BERITA TERBARU -->
          <div class="card shadow-sm">
            <div class="card-header pb-0">
              <h5 class="card-title mb-0">
                <i class="bx bx-news text-danger"></i> Berita Terbaru
              </h5>
            </div>
            <div class="card-body">
              <?php if (!empty($recentBerita)): ?>
                <?php foreach ($recentBerita as $b): ?>
                  <div class="d-flex mb-3">
                    <?php if (!empty($b['gambar_berita'])): ?>
                      <img src="<?= BASE_URL ?>/public/uploads/berita/<?= $b['gambar_berita'] ?>" 
                           class="rounded me-3" 
                           style="width: 60px; height: 60px; object-fit: cover;">
                    <?php else: ?>
                      <div class="avatar avatar-md me-3">
                        <span class="avatar-initial rounded bg-label-secondary">
                          <i class="bx bx-image"></i>
                        </span>
                      </div>
                    <?php endif; ?>
                    <div class="flex-grow-1">
                      <h6 class="mb-1"><?= htmlspecialchars(substr($b['judul_berita'] ?? 'Berita', 0, 50)) ?></h6>
                      <small class="text-muted">
                        <i class="bx bx-time-five"></i> <?= date('d M Y', strtotime($b['tanggal_publish'] ?? 'now')) ?>
                      </small>
                    </div>
                  </div>
                <?php endforeach; ?>
                <div class="text-center mt-3">
                  <a href="<?= BASE_URL ?>/admin/berita" class="btn btn-sm btn-outline-danger">
                    Lihat Semua <i class="bx bx-right-arrow-alt"></i>
                  </a>
                </div>
              <?php else: ?>
                <div class="text-center py-4">
                  <i class="bx bx-news bx-lg text-muted mb-2"></i>
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
        var ctx = document.getElementById('activitiesChart').getContext('2d');
        var activitiesChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: ['Penelitian', 'Pengabdian', 'Agenda', 'Berita'],
            datasets: [{
              label: 'Jumlah Kegiatan',
              data: [<?= $totalPenelitian ?>, <?= $totalPengabdian ?>, <?= $totalAgenda ?>, <?= $totalBerita ?>],
              backgroundColor: [
                'rgba(250, 112, 154, 0.8)',
                'rgba(79, 172, 254, 0.8)',
                'rgba(240, 147, 251, 0.8)',
                'rgba(102, 126, 234, 0.8)'
              ],
              borderColor: [
                'rgb(250, 112, 154)',
                'rgb(79, 172, 254)',
                'rgb(240, 147, 251)',
                'rgb(102, 126, 234)'
              ],
              borderWidth: 2,
              borderRadius: 8
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
              legend: {
                display: false
              },
              tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  stepSize: 10
                },
                grid: {
                  color: 'rgba(0, 0, 0, 0.05)'
                }
              },
              x: {
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
