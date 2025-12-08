<?php
// agenda.php - Full Implementation with Search (No Highlight)
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';

// Ensure agenda data is available
if (!isset($agendaList)) {
    $agendaModel = new Agenda();
    $agendaList = $agendaModel->getAllAgenda();
}
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/bg-gedung.jpg);background-position: center 40%;background-size: cover;"></div>
    <div class="container">
        <h2 class="page-header__title">Agenda</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Aktivitas</span></li>
            <li><span>Agenda Kegiatan</span></li>
        </ul>
    </div>
</section>

<section class="pt-80 pb-40 text-center">
    <div class="container">
        <h2 class="section-title__title agenda-main-title">Temukan Agenda Kegiatan Kami</h2>
        <p class="agenda-intro-text">Telusuri jadwal kegiatan, lokasi, serta waktu pelaksanaan agenda di Laboratorium Network and Cyber Security.</p>

        <div style="max-width:100%;margin:18px 0 22px;">
            <div class="agenda-search">
                <input id="agenda-search-input" class="search-input" placeholder="Cari agenda berdasarkan judul atau tanggal..." aria-label="Cari agenda" />
                <button id="agenda-search-btn" aria-label="Cari">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</section>

<section class="agenda-list" style="margin-bottom: 80px;">
    <div class="container">
        <div id="agenda-results">
            <?php if (empty($agendaList)): ?>
                <div class="empty-state">
                    <div class="empty-state__icon"></div>
                    <h3 class="empty-state__title">Belum Ada Agenda</h3>
                    <p class="empty-state__message">Saat ini belum ada kegiatan atau agenda yang dijadwalkan. Silakan periksa kembali nanti.</p>
                </div>
            <?php else: ?>

                <div class="agenda-list__items">
                    <?php foreach ($agendaList as $idx => $item): ?>
                        <?php
                        // Handle Thumbnail
                        $thumb = BASE_URL . '/public/assets/images/empty/empty_data.jpg';
                        if (!empty($item['gambar_agenda'])) {
                            $imageName = ltrim(trim($item['gambar_agenda']), '/');
                            $thumb = BASE_URL . '/public/uploads/agenda/' . $imageName;
                            $serverPath = __DIR__ . '/../../../public/uploads/agenda/' . $imageName;
                            if (!@file_exists($serverPath)) {
                                $thumb = BASE_URL . '/public/assets/images/empty/empty_data.jpg';
                            }
                        }

                        // Handle Status Badge
                        $rawStatus = trim($item['status'] ?? '');
                        $statusLabel = '';
                        $badgeClass = '';

                        if ($rawStatus !== '') {
                            $low = strtolower($rawStatus);
                            if (strpos($low, 'selesai') !== false || strpos($low, 'done') !== false) {
                                $statusLabel = 'Selesai';
                                $badgeClass = 'badge--success';
                            } elseif (strpos($low, 'progres') !== false || strpos($low, 'progress') !== false || strpos($low, 'berlangsung') !== false) {
                                $statusLabel = 'Dalam Progres';
                                $badgeClass = 'badge--warning';
                            } elseif (strpos($low, 'belum') !== false || strpos($low, 'pending') !== false) {
                                $statusLabel = 'Belum Terlaksana';
                                $badgeClass = 'badge--info';
                            } else {
                                $statusLabel = htmlspecialchars($item['status']);
                                $badgeClass = 'badge--info';
                            }
                        }

                        // Calculate Date Range & Search Content
                        $startTs = strtotime($item['tanggal_mulai'] ?? '');
                        $endTs = strtotime($item['tanggal_selesai'] ?? '');
                        $startPart = $startTs ? date('d M Y', $startTs) . (!empty($item['waktu_mulai']) ? ' • ' . $item['waktu_mulai'] : '') : '';
                        $endPart = $endTs ? date('d M Y', $endTs) . (!empty($item['waktu_selesai']) ? ' • ' . $item['waktu_selesai'] : '') : '';

                        if ($startPart && $endPart && $startPart !== $endPart) {
                            $dateRange = $startPart . ' — ' . $endPart;
                        } else {
                            $dateRange = $startPart ?: ($endPart ?: '-');
                        }

                        // Menyiapkan string pencarian (Judul + Tanggal)
                        $searchableContent = strtolower($item['nama_agenda'] . ' ' . $dateRange);
                        ?>

                        <article class="agenda-item fade-in-up" tabindex="0" data-search="<?= htmlspecialchars($searchableContent) ?>">
                            <div class="agenda-item__thumbnail">
                                <img src="<?= $thumb ?>" alt="<?= htmlspecialchars($item['nama_agenda']) ?>" loading="lazy" onerror="this.onerror=null;this.src='<?= BASE_URL ?>/public/assets/images/empty/empty_data.jpg';" />
                            </div>

                            <div class="agenda-item__content">
                                <div class="agenda-item__header">
                                    <h3><?= htmlspecialchars($item['nama_agenda']) ?></h3>
                                    <?php if (!empty($statusLabel)): ?>
                                        <span class="<?= $badgeClass ?>"><?= $statusLabel ?></span>
                                    <?php endif; ?>
                                </div>

                                <?php $excerpt = strip_tags($item['deskripsi_agenda'] ?? $item['deskripsi'] ?? $item['isi'] ?? ''); ?>
                                <?php if (!empty($excerpt)): ?>
                                    <p class="agenda-item__excerpt"><?= htmlspecialchars(mb_strimwidth($excerpt, 0, 280, '...')) ?></p>
                                <?php endif; ?>

                                <div class="agenda-item__meta">
                                    <svg class="agenda-item__icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                    <span><?= $dateRange ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="search-no-results" style="display: none;">
                    <div class="search-no-results__icon"></div>
                    <h3 class="search-no-results__title">Agenda Tidak Ditemukan</h3>
                    <p class="search-no-results__message">Kami tidak dapat menemukan agenda yang cocok dengan kata kunci pencarian Anda. Silakan coba kata kunci lain.</p>
                </div>

                <div class="pagination-wrapper text-center" style="display: none;">
                    <ul id="pagination-container" class="pagination"></ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/agenda-custom.css?v=<?= filemtime(__DIR__ . '/../../../public/css/agenda-custom.css') ?>">

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>