<?php
// Detail view for a single berita
if (!isset($berita) || !$berita) {
    echo "<h2>Berita tidak ditemukan</h2>";
    return;
}

include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/lab-ncs-berita-detail.css?v=<?= filemtime(__DIR__ . '/../../../../public/css/lab-ncs-berita-detail.css') ?>">

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(<?= BASE_URL ?>/public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title"><?= htmlspecialchars($berita['judul_berita']) ?></h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><a href="<?= BASE_URL ?>/berita">Berita</a></li>
            <li><span><?= htmlspecialchars($berita['judul_berita']) ?></span></li>
        </ul>
    </div>
</section>

<section class="blog-single pt-120 pb-120">
    <div class="container">
        <div class="row">
            <!-- Main Content: Left Column (8 cols) -->
            <div class="col-lg-8 mb-4 mb-lg-0">
                <!-- Featured Image -->
                <div class="blog-single__image mb-4">
                    <?php
                    $defaultImg = BASE_URL . '/public/assets/images/empty/empty_data.jpg';
                    $imgUrl = $defaultImg;
                    if (!empty($berita['gambar_berita'])) {
                        // server-side path detection to avoid broken images
                        $serverPath = realpath(__DIR__ . '/../../../../public/uploads/berita/') ?: (__DIR__ . '/../../../../public/uploads/berita/');
                        $candidate = rtrim($serverPath, '/') . '/' . $berita['gambar_berita'];
                        if (file_exists($candidate)) {
                            $imgUrl = BASE_URL . '/public/uploads/berita/' . $berita['gambar_berita'];
                        }
                    }
                    ?>
                    <img src="<?= $imgUrl ?>" alt="<?= htmlspecialchars($berita['judul_berita']) ?>" class="img-fluid rounded" style="width: 100%; max-height: 520px; object-fit: cover;">
                </div>

                <!-- Article Meta (author only; comments removed) -->
                <div class="blog-single__meta mb-3" style="display: flex; gap: 12px; align-items: center; color: #666; font-size: 14px;">
                    <span>
                        <i class="far fa-user-circle" style="margin-right: 6px;"></i>
                        <strong>By admin</strong>
                    </span>
<<<<<<< Updated upstream
=======
                </div>

                <!-- Article Title -->
                <h1 class="blog-single__title" style="font-size: 32px; font-weight: 700; color: #081d2f; margin-bottom: 24px; line-height: 1.3;">
                    <?= htmlspecialchars($berita['judul_berita']) ?>
                </h1>

                <!-- Article Body Content -->
                <div class="blog-single__body" style="font-size: 15px; line-height: 1.8; color: #555; margin-bottom: 40px;">
                    <?= $berita['isi_berita'] ?>
                </div>

                <!-- Back Button -->
                <div style="margin-top: 40px;">
                    <a href="<?= BASE_URL ?>/berita" class="btn btn-outline-secondary btn-sm">
                        ← Kembali ke Berita
                    </a>
                </div>
            </div>

            <!-- Sidebar: Right Column (4 cols) -->
            <div class="col-lg-4">
                <!-- Latest Post Widget -->
                <aside class="blog-sidebar" style="background: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 0 rgba(0,0,0,0.04);">
                    <h3 style="font-size: 24px; font-weight: 700; color: #081d2f; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid #e6e6e6;">
                        Latest post
                    </h3>

                    <?php
                        // Limit latest posts to maximum 5 items
                        $latestList = [];
                        if (!empty($latestPosts) && is_array($latestPosts)) {
                            $latestList = array_slice($latestPosts, 0, 5);
                        }
                    ?>
                    <?php if (!empty($latestList)): ?>
                        <div class="blog-widget__list">
                            <?php foreach ($latestList as $post): ?>
                                <article style="margin-bottom: 18px; padding-bottom: 14px; border-bottom: 1px solid #f0f0f0; display: flex; gap: 12px; align-items: flex-start;">
                                    <div style="flex: 0 0 36%;">
                                        <?php
                                            $postImgUrl = BASE_URL . '/public/assets/images/empty/empty_data.jpg';
                                            if (!empty($post['gambar_berita'])) {
                                                $candidate = realpath(__DIR__ . '/../../../../public/uploads/berita/') ?: (__DIR__ . '/../../../../public/uploads/berita/');
                                                $candidate = rtrim($candidate, '/') . '/' . $post['gambar_berita'];
                                                if (file_exists($candidate)) {
                                                    $postImgUrl = BASE_URL . '/public/uploads/berita/' . $post['gambar_berita'];
                                                }
                                            }
                                        ?>
                                        <a href="<?= BASE_URL ?>/berita/detail/<?= htmlspecialchars($post['id_berita']) ?>">
                                            <img src="<?= $postImgUrl ?>" alt="<?= htmlspecialchars($post['judul_berita']) ?>" style="width:100%; height:84px; object-fit:cover; border-radius:6px; display:block;" loading="lazy">
                                        </a>
                                    </div>
                                    <div style="flex: 1 1 64%;">
                                        <div style="font-size: 12px; color: #1ea37a; font-weight: 600; margin-bottom: 6px;">
                                            <?= date('d M Y', strtotime($post['tanggal_publish'])) ?>
                                        </div>
                                        <h4 style="font-size: 14px; font-weight: 600; margin: 0; line-height:1.25;">
                                            <a href="<?= BASE_URL ?>/berita/detail/<?= htmlspecialchars($post['id_berita']) ?>" style="text-decoration:none; color:#081d2f;">
                                                <?= htmlspecialchars(strlen($post['judul_berita']) > 60 ? substr($post['judul_berita'], 0, 60) . '...' : $post['judul_berita']) ?>
                                            </a>
                                        </h4>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color: #999; font-size: 14px;">Belum ada berita terbaru.</p>
                    <?php endif; ?>
>>>>>>> Stashed changes
                </div>

                <!-- Article Title -->
                <h1 class="blog-single__title" style="font-size: 32px; font-weight: 700; color: #081d2f; margin-bottom: 24px; line-height: 1.3;">
                    <?= htmlspecialchars($berita['judul_berita']) ?>
                </h1>

                <!-- Article Body Content -->
                <div class="blog-single__body" style="font-size: 15px; line-height: 1.8; color: #555; margin-bottom: 40px;">
                    <?= $berita['isi_berita'] ?>
                </div>

                <!-- Back Button -->
                <div style="margin-top: 40px;">
                    <a href="<?= BASE_URL ?>/berita" class="btn btn-outline-secondary btn-sm">
                        ← Kembali ke Berita
                    </a>
                </div>
            </div>

            <!-- Sidebar: Right Column (4 cols) -->
            <div class="col-lg-4">
                <!-- Latest Post Widget -->
                <aside class="blog-sidebar" style="background: #ffffff; padding: 25px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); border: 1px solid #eaeaea;">
                    <h3 style="font-size: 20px; font-weight: 700; color: #081d2f; margin-bottom: 25px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0; position: relative;">
                        Latest Post
                        <span style="position: absolute; bottom: -2px; left: 0; width: 50px; height: 2px; background: #1ea37a;"></span>
                    </h3>

                    <?php
                    // Filter out the current post and limit to 5 items
                    $latestList = [];
                    if (!empty($latestPosts) && is_array($latestPosts)) {
                        $currentId = $berita['id_berita'] ?? null;
                        foreach ($latestPosts as $p) {
                            if ($p['id_berita'] != $currentId) {
                                $latestList[] = $p;
                            }
                        }
                        // Slice to ensure max 5 items
                        $latestList = array_slice($latestList, 0, 5);
                    }
                    ?>

                    <?php if (!empty($latestList)): ?>
                        <div class="blog-widget__list">
                            <?php foreach ($latestList as $post): ?>
                                <?php
                                $postImgUrl = BASE_URL . '/public/assets/images/empty/empty_data.jpg';
                                if (!empty($post['gambar_berita'])) {
                                    $candidate = realpath(__DIR__ . '/../../../../public/uploads/berita/') ?: (__DIR__ . '/../../../../public/uploads/berita/');
                                    $candidate = rtrim($candidate, '/') . '/' . $post['gambar_berita'];
                                    if (file_exists($candidate)) {
                                        $postImgUrl = BASE_URL . '/public/uploads/berita/' . $post['gambar_berita'];
                                    }
                                }
                                ?>
                                <article class="latest-post-card" style="margin-bottom: 15px;">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $post['slug_berita'] ?>" style="text-decoration: none; color: inherit; display: flex; align-items: center; gap: 15px; padding: 10px; border-radius: 10px; transition: all 0.3s ease; background: #fff;">
                                        <div style="flex-shrink: 0; width: 80px; height: 80px; overflow: hidden; border-radius: 8px;">
                                            <img src="<?= $postImgUrl ?>" alt="<?= htmlspecialchars($post['judul_berita']) ?>" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;" loading="lazy">
                                        </div>
                                        <div style="flex-grow: 1;">
                                            <div style="font-size: 11px; color: #1ea37a; font-weight: 700; text-transform: uppercase; margin-bottom: 5px; letter-spacing: 0.5px;">
                                                <?= date('d M Y', strtotime($post['tanggal_publish'])) ?>
                                            </div>
                                            <h4 style="font-size: 14px; font-weight: 600; margin: 0; line-height: 1.4; color: #081d2f; transition: color 0.3s ease;">
                                                <?= htmlspecialchars(strlen($post['judul_berita']) > 55 ? substr($post['judul_berita'], 0, 55) . '...' : $post['judul_berita']) ?>
                                            </h4>
                                        </div>
                                    </a>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="color: #999; font-size: 14px; text-align: center; padding: 20px;">Belum ada berita terbaru.</p>
                    <?php endif; ?>
                </aside>
            </div>
        </div>
    </div>
</section>

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>