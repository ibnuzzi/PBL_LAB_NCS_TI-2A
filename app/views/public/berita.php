<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Berita & Artikel</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="index.php">Beranda</a></li>
            <li><span>Aktivitas</span></li>
            <li><span>Berita</span></li>
        </ul>
    </div>
</section>

<section class="blog-one pt-120 pb-120">
    <div class="container">
        <div class="row gutter-y-30">
            <?php if (!empty($beritas) && is_array($beritas)): ?>
                <?php foreach ($beritas as $index => $b): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='<?= (400 + ($index * 200)) ?>ms'>
                            <div class="blog-card__image">
                                <div class="blog-card__image__item">
                                    <?php
                                        $img = 'public/uploads/berita/' . (!empty($b['gambar_berita']) ? $b['gambar_berita'] : 'default.png');
                                    ?>
                                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($b['judul_berita']) ?>">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $b['id_berita'] ?>" class="blog-card__image__link"></a>
                                </div>
                                <div class="blog-card__date">
                                    <span class="blog-card__date__day"><?= date('d', strtotime($b['tanggal_publish'])) ?></span><?= strtoupper(date('M', strtotime($b['tanggal_publish']))) ?>
                                </div>
                            </div>
                            <div class="blog-card__content">
                                <div class="blog-card__author">
                                </div>
                                <h3 class="blog-card__title">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $b['id_berita'] ?>"><?= htmlspecialchars($b['judul_berita']) ?></a>
                                </h3>
                                <div class="blog-card__content__btn">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $b['id_berita'] ?>" class="blog-card__content__btn__link">
                                        Baca Selengkapnya<i class="icon-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Tidak ada berita untuk ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($totalPages) && $totalPages > 1): ?>
            <div class="row" style="margin-top: 30px;">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <?php
                                $current = isset($currentPage) ? (int)$currentPage : 1;
                                $baseUrl = BASE_URL . '/berita';
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

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>