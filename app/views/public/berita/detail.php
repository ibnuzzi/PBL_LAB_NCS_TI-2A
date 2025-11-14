<?php
// Detail view for a single berita
if (!isset($berita) || !$berita) {
    echo "<h2>Berita tidak ditemukan</h2>";
    return;
}

include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title"><?= htmlspecialchars($berita['judul_berita']) ?></h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="/index.php">Beranda</a></li>
            <li><a href="/index.php/berita">Berita</a></li>
            <li><span><?= htmlspecialchars($berita['judul_berita']) ?></span></li>
        </ul>
    </div>
</section>

<section class="blog-single pt-120 pb-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="blog-single__image mb-4">
                    <?php $img = 'public/uploads/berita/' . (!empty($berita['gambar_berita']) ? $berita['gambar_berita'] : 'default.png'); ?>
                    <img src="<?= $img ?>" alt="<?= htmlspecialchars($berita['judul_berita']) ?>" class="img-fluid">
                </div>

                <div class="blog-single__content">
                    <div class="blog-single__meta mb-2">
                        <span class="mr-3">Dipublikasikan: <?= date('d M Y', strtotime($berita['tanggal_publish'])) ?></span>
                    </div>

                    <div class="blog-single__body">
                        <?= $berita['isi_berita'] ?>
                    </div>

                    <div class="mt-4">
                        <a href="/index.php/berita" class="btn btn-secondary">Kembali ke Berita</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>