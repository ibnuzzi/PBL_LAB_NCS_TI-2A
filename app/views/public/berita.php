<?php
// berita.php - Full Implementation with Search
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/lab-ncs-berita.css?v=<?= filemtime(__DIR__ . '/../../../public/css/lab-ncs-berita.css') ?>">

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/bg-gedung.jpg);background-position: center 40%;background-size: cover;"></div>
    <div class="container">
        <h2 class="page-header__title">Berita & Artikel</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Aktivitas</span></li>
            <li><span>Berita & Artikel</span></li>
        </ul>
    </div>
</section>

<section class="pt-80 pb-40 text-center">
    <div class="container">
        <h2 class="section-title__title agenda-main-title">Berita & Artikel Terbaru</h2>
        <p class="agenda-intro-text">Dapatkan informasi terkini seputar teknologi, kegiatan laboratorium, dan artikel menarik lainnya.</p>

        <div style="max-width:100%; margin:18px 0 22px;">
            <div class="agenda-search">
                <input id="berita-search-input" class="search-input" placeholder="Cari berita berdasarkan judul atau tanggal..." aria-label="Cari berita">
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

<section class="blog-one pt-10 pb-120">
    <div class="container">

        <div class="row gutter-y-30" id="berita-items">
            <?php if (!empty($beritas) && is_array($beritas)): ?>
                <?php foreach ($beritas as $index => $b): ?>
                    <?php
                    // MENYIAPKAN DATA PENCARIAN
                    // Menggabungkan Judul dan Tanggal (Format: 25 Aug 2025) agar user bisa cari berdasarkan bulan/tahun
                    $dateFormatted = date('d M Y', strtotime($b['tanggal_publish']));
                    $searchableContent = strtolower($b['judul_berita'] . ' ' . $dateFormatted);
                    ?>
                    <div class="col-md-6 col-lg-4 berita-item" data-search="<?= htmlspecialchars($searchableContent) ?>">
                        <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='<?= (400 + ($index * 200)) ?>ms' style="
                            height: 100%;
                            display: flex;
                            flex-direction: column;
                        ">
                            <div class="blog-card__image">
                                <div class="blog-card__image__item" style="
                                    height: 250px;
                                    overflow: hidden;
                                    position: relative;
                                ">
                                    <?php
                                    // Handle gambar default jika kosong
                                    $imgName = !empty($b['gambar_berita']) ? $b['gambar_berita'] : 'default.png';
                                    $img = BASE_URL . '/public/uploads/berita/' . $imgName;
                                    // Add cache busting
                                    if (!empty($b['gambar_berita'])) {
                                        $imagePath = __DIR__ . '/../../../public/uploads/berita/' . $b['gambar_berita'];
                                        $cacheParam = file_exists($imagePath) ? '?v=' . filemtime($imagePath) : '?v=' . time();
                                        $img .= $cacheParam;
                                    }
                                    ?>
                                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($b['judul_berita']) ?>" loading="lazy" style="
                                        width: 100%;
                                        height: 100%;
                                        object-fit: cover;
                                        object-position: center;
                                    ">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $b['slug_berita'] ?>" class="blog-card__image__link"></a>
                                </div>
                                <div class="blog-card__date">
                                    <span class="blog-card__date__day"><?= date('d', strtotime($b['tanggal_publish'])) ?></span>
                                    <?= strtoupper(date('M', strtotime($b['tanggal_publish']))) ?>
                                </div>
                            </div>
                            <div class="blog-card__content" style="
                                flex: 1;
                                display: flex;
                                flex-direction: column;
                            ">
                                <div class="blog-card__author">
                                </div>
                                <h3 class="blog-card__title" style="
                                    display: -webkit-box;
                                    -webkit-line-clamp: 2;
                                    -webkit-box-orient: vertical;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    min-height: 60px;
                                    line-height: 1.4;
                                    margin-bottom: 20px;
                                ">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $b['slug_berita'] ?>"><?= htmlspecialchars($b['judul_berita']) ?></a>
                                </h3>
                                <div class="blog-card__content__btn" style="margin-top: auto;">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $b['slug_berita'] ?>" class="blog-card__content__btn__link">
                                        Baca Selengkapnya<i class="icon-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>Belum ada berita yang dipublikasikan.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="search-no-results" style="display:none; text-align:center; padding:40px 20px;">
            <div class="search-no-results__icon">
            </div>
            <h3 class="search-no-results__title">Hasil Tidak Ditemukan</h3>
            <p class="search-no-results__message">Maaf, tidak ada berita yang cocok dengan kata kunci pencarian Anda. Silakan coba kata kunci lain.</p>
        </div>

        <div class="berita-pagination-wrapper text-center" style="margin-top:80px;display:flex; justify-content:center;">
            <ul id="berita-pagination-container" class="pagination"></ul>
        </div>
    </div>
</section>

<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/agenda-custom.css?v=<?= filemtime(__DIR__ . '/../../../public/css/agenda-custom.css') ?>">

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>