<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<!-- gallery custom styles -->
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/gallery-custom.css">

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Galeri</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Aktivitas</span></li>
            <li><span>Galeri</span></li>
        </ul>
    </div>
</section>

<section class="gallery-page pt-120 pb-90" id="galeri">
    <div class="container">
        <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
            <h6 class="sec-title__tagline"><img src="<?= BASE_URL ?>/public/assets/images/shapes/science.png" alt="Galeri" class="sec-title__img">Galeri</h6>
            <h3 class="sec-title__title">Dokumentasi Kegiatan Lab NCS</h3>
        </div>

        <!-- Filter Buttons -->
        <div class="text-center mb-4">
            <div class="btn-group" role="group" aria-label="gallery filters">
                <?php if (!empty($categories) && is_array($categories)): ?>
                    <?php foreach ($categories as $i => $cat): $slug = strtolower(preg_replace('/[^a-z0-9]+/i','-',trim($cat))); ?>
                        <button class="btn btn-sm btn-outline-secondary gallery-filter <?= ($i===0)?'active':'' ?>" data-filter="<?= ($i===0)?'*':'.cat-'.$slug ?>"><?= htmlspecialchars($cat) ?></button>
                    <?php endforeach; ?>
                <?php else: ?>
                    <button class="btn btn-sm btn-outline-secondary active">All</button>
                <?php endif; ?>
            </div>
        </div>

        <div class="row gallery-grid gutter-y-30">
            <?php if (!empty($galleries) && is_array($galleries)): ?>
                <?php foreach ($galleries as $g): ?>
                        <?php $catSlug = 'uncategorized'; if (isset($g['kategori']) && trim($g['kategori'])!=='') { $catSlug = strtolower(preg_replace('/[^a-z0-9]+/i','-',trim($g['kategori']))); } ?>
                    <div class="col-md-6 col-lg-4 grid-item <?php echo 'cat-'.$catSlug; ?>">
                        <div class="gallery-card">
                            <?php $img = !empty($g['nama_file_foto']) ? BASE_URL . '/public/uploads/gallery/' . $g['nama_file_foto'] : BASE_URL . '/public/assets/images/empty/empty_data.jpg'; ?>
                            <img src="<?= $img ?>" alt="<?= htmlspecialchars($g['judul_foto'] ?? 'Galeri') ?>" class="gallery-card__image" loading="lazy" decoding="async">
                            <div class="gallery-card__hover">
                                <button class="gallery-open-btn" data-image="<?= htmlspecialchars($img) ?>" data-title="<?= htmlspecialchars($g['judul_foto'] ?? '') ?>" data-desc="<?= htmlspecialchars($g['deskripsi_foto'] ?? '') ?>" data-date="<?= htmlspecialchars($g['tanggal_upload'] ?? date('Y-m-d')) ?>" title="Lihat Detail">
                                    <i class="icon-search"></i>
                                </button>
                                <h4 class="gallery-card__title"><?= htmlspecialchars($g['judul_foto'] ?? '') ?></h4>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Tidak ada foto galeri untuk ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination for gallery -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="row" style="margin-top:30px;">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php
                                $current = isset($currentPage) ? (int)$currentPage : 1;
                                $baseUrl = BASE_URL . '/galeri';
                                $prev = $current - 1;
                                $next = $current + 1;
                            ?>
                            <li class="page-item <?= ($current <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($current > 1) ? $baseUrl . '?page=' . $prev : '#' ?>" aria-label="Previous">&laquo;</a>
                            </li>

                            <?php for ($p = 1; $p <= $totalPages; $p++): ?>
                                <li class="page-item <?= ($p === $current) ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= $baseUrl . '?page=' . $p ?>"><?= $p ?></a>
                                </li>
                            <?php endfor; ?>

                            <li class="page-item <?= ($current >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= ($current < $totalPages) ? $baseUrl . '?page=' . $next : '#' ?>" aria-label="Next">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- Custom Gallery Lightbox Modal -->
<div id="gallery-modal" class="gallery-modal">
    <div class="gallery-modal__close">&times;</div>
    <button class="gallery-modal__nav gallery-modal__prev">&lsaquo;</button>
    <button class="gallery-modal__nav gallery-modal__next">&rsaquo;</button>
    
    <div class="gallery-modal__content">
        <div class="gallery-modal__image-container">
            <img id="gallery-modal-image" src="" alt="" class="gallery-modal__image">
        </div>
        <div class="gallery-modal__detail-card">
            <div class="detail-card__header">
                <h2 id="gallery-modal-title" class="detail-card__title"></h2>
            </div>
            <div class="detail-card__body">
                <div class="detail-item">
                    <label class="detail-label">Tanggal Upload:</label>
                    <p id="gallery-modal-date" class="detail-value"></p>
                </div>
                <div class="detail-item">
                    <label class="detail-label">Deskripsi:</label>
                    <p id="gallery-modal-desc" class="detail-value"></p>
                </div>
            </div>
            <div class="detail-card__footer">
                <span id="gallery-modal-counter" class="gallery-counter"></span>
            </div>
        </div>
    </div>
</div>

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>