<?php
// File: /app/views/public/berita/detail.php
?>

<article class="berita-detail">
    <?php if (!empty($data['berita'])) : ?>
        <header class="berita-header">
            <h1><?= $data['berita']['judul'] ?></h1>
            <p class="meta">
                <span class="tanggal"><?= date('d F Y', strtotime($data['berita']['tanggal'])) ?></span>
            </p>
        </header>

        <?php if (!empty($data['berita']['gambar'])) : ?>
            <div class="berita-image">
                <img src="<?= BASE_URL ?>/uploads/<?= $data['berita']['gambar'] ?>" alt="<?= $data['berita']['judul'] ?>">
            </div>
        <?php endif; ?>

        <div class="berita-content">
            <?= nl2br($data['berita']['isi']) ?>
        </div>

        <div class="berita-navigation">
            <a href="<?= BASE_URL ?>/berita" class="btn btn-back">&larr; Kembali ke Daftar Berita</a>
        </div>
    <?php endif; ?>
</article>