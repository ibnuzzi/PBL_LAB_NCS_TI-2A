<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/bg-gedung.jpg);background-position: center 40%;background-size: cover;"></div>
    <div class="container">
        <h2 class="page-header__title">Arsip & Dokumen</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Arsip Digital</span></li>
        </ul>
    </div>
</section>

<section class="service-details" style="padding: 80px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
                <div class="product__sidebar product__sidebar-right">

                    <div class="product__search wow fadeInUp animated" data-wow-delay="500ms">
    <form action="<?= BASE_URL ?>/arsip" method="GET" class="product__sidebar__search">
        
        <button type="submit" aria-label="search submit">
            <span><i class="icon-search"></i></span>
        </button>
        
        <input type="text" 
               name="search" 
               placeholder="Cari Judul atau Penulis..." 
               value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
               
        <?php if (!empty($_GET['kategori'])): ?>
            <input type="hidden" name="kategori" value="<?= htmlspecialchars($_GET['kategori']) ?>">
        <?php endif; ?>
        <?php if (!empty($_GET['tahun'])): ?>
            <input type="hidden" name="tahun" value="<?= htmlspecialchars($_GET['tahun']) ?>">
        <?php endif; ?>

    </form>
</div>

                    <div class="product__categories  wow fadeInUp animated" data-wow-delay="900ms" style="visibility: visible; animation-delay: 900ms; animation-name: fadeInUp;">
                        <h3 class="product__categories__title">Categories</h3>
                        <ul class="list-unstyled service-sidebar__category__list">
                            <?php 
                            $kategoriAktif = $data['kategori_aktif'] ?? 'semua'; 
                            $tahunParam = isset($_GET['tahun']) ? '&tahun=' . urlencode($_GET['tahun']) : '';
                            ?>
                            <li class="<?= $kategoriAktif === 'semua' ? 'active' : '' ?>">
                                <a href="?kategori=semua<?= $tahunParam ?>"> <i class="fa fa-folder-open"></i>Semua Dokumen</a>
                            </li>
                            <?php
                            // Mapping icon untuk setiap kategori
                            $iconMapping = [
                                'Penelitian' => 'fa-microscope',
                                'Pengabdian' => 'fa-hands-helping',
                                'Modul Praktikum' => 'fa-book',
                                'SOP Laboratorium' => 'fa-file-contract'
                            ];

                            // Loop melalui kategori yang diambil dari database
                            if (!empty($data['kategori_list'])):
                                foreach ($data['kategori_list'] as $kategori):
                                    $namaKategori = $kategori['nama_kategori'];
                                    // Tentukan icon berdasarkan nama kategori, default fa-file jika tidak ada mapping
                                    $icon = isset($iconMapping[$namaKategori]) ? $iconMapping[$namaKategori] : 'fa-file';
                                    $isActive = $kategoriAktif === $namaKategori ? 'active' : '';
                            ?>
                                    <li class="<?= $isActive ?>">
                                        <a href="?kategori=<?= urlencode($namaKategori) ?><?= $tahunParam ?>"> <i class="fa <?= $icon ?>"></i><?= htmlspecialchars($namaKategori) ?></a>
                                    </li>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div><!-- /.category-widget -->

                    <div class="product__categories  wow fadeInUp animated" data-wow-delay="1000ms" style="visibility: visible; animation-delay: 1000ms; animation-name: fadeInUp;">
                        <h3 class="product__categories__title">Filter Tahun</h3>
                        <ul class="list-unstyled service-sidebar__category__list">
                            <?php $tahunAktif = $data['tahun_aktif'] ?? 'semua'; ?>
                            <?php $kategoriParam = isset($_GET['kategori']) ? '&kategori=' . urlencode($_GET['kategori']) : ''; ?>
                            <li class="<?= $tahunAktif === 'semua' ? 'active' : '' ?>">
                                <a href="?tahun=semua<?= $kategoriParam ?>"> <i class="fa fa-calendar"></i>Semua Tahun</a>
                            </li>
                            <?php
                            // Loop melalui tahun yang diambil dari database
                            if (!empty($data['tahun_list'])):
                                foreach ($data['tahun_list'] as $tahunItem):
                                    $tahun = $tahunItem['tahun'];
                                    $isActive = $tahunAktif === $tahun ? 'active' : '';
                            ?>
                                    <li class="<?= $isActive ?>">
                                        <a href="?tahun=<?= urlencode($tahun) ?><?= $kategoriParam ?>"> <i class="fa fa-calendar-alt"></i><?= htmlspecialchars($tahun) ?></a>
                                    </li>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                    </div><!-- /.year-filter-widget -->

                </div>
            </div>

            <div class="col-lg-9">
                <div class="service-details__content">

                    <h3 class="service-details__title">Daftar Dokumen Publik</h3>
                    <p class="service-details__text mb-3">Silakan unduh dokumen yang Anda butuhkan. Pastikan Anda login jika dokumen bersifat terbatas.</p>

                    <div class="list-group" style="border: none;">

                        <?php
                        // Mapping icon dan warna untuk setiap kategori
                        $categoryIconMapping = [
                            'Penelitian' => ['icon' => 'fa-microscope', 'bg' => '#ffebee', 'color' => '#d32f2f'],
                            'Pengabdian' => ['icon' => 'fa-hands-helping', 'bg' => '#e8f5e9', 'color' => '#388e3c'],
                            'Modul Praktikum' => ['icon' => 'fa-book', 'bg' => '#e3f2fd', 'color' => '#1976d2'],
                            'SOP Laboratorium' => ['icon' => 'fa-file-contract', 'bg' => '#f3e5f5', 'color' => '#7b1fa2'],
                            'default' => ['icon' => 'fa-file', 'bg' => '#f5f5f5', 'color' => '#757575']
                        ];

                        // Loop melalui data arsip dari PostgreSQL view
                        if (!empty($data['arsip_list'])):
                            foreach ($data['arsip_list'] as $arsip):
                                // Dapatkan kategori
                                $kategoriArsip = $arsip['kategori'] ?? 'default';
                                $iconData = isset($categoryIconMapping[$kategoriArsip]) ? $categoryIconMapping[$kategoriArsip] : $categoryIconMapping['default'];
                        ?>
                                <div class="list-group-item list-group-item-action d-flex align-items-center p-4 mb-3 shadow-sm"
                                    style="border: none; border-radius: 10px; background: #fff; transition: transform 0.2s;">

                                    <div class="flex-shrink-0 me-4" style="margin-right: 20px;">
                                        <div style="width: 60px; height: 60px; background: <?= $iconData['bg'] ?>; color: <?= $iconData['color'] ?>; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                                            <i class="fa <?= $iconData['icon'] ?>"></i>
                                        </div>
                                    </div>

                                    <div class="flex-grow-1">
                                        <h5 class="mb-1" style="font-weight: bold; color: #333;">
                                            <?= htmlspecialchars($arsip['judul'] ?? 'Tanpa Judul') ?>
                                        </h5>
                                        <p class="mb-1 text-muted" style="font-size: 14px;">
                                            <?= htmlspecialchars(substr($arsip['deskripsi'] ?? '', 0, 100)) ?><?= strlen($arsip['deskripsi'] ?? '') > 100 ? '...' : '' ?>
                                        </p>
                                        <small class="text-muted">
                                            <i class="fa fa-calendar-alt"></i> <?= date('d M Y', strtotime($arsip['created_at'] ?? date('Y-m-d'))) ?> &nbsp;|&nbsp;
                                            <i class="fa fa-tag"></i> <?= htmlspecialchars($kategoriArsip) ?>
                                            <?php
                                            // Hanya tampilkan penulis_atau_tim jika BUKAN dari arsip_umum
                                            if (!empty($arsip['penulis_atau_tim']) && ($arsip['sumber_tabel'] ?? '') !== 'arsip_umum'):
                                                // Logika untuk menangani nama tim yang panjang
                                                $penulisTim = $arsip['penulis_atau_tim'];
                                                $maxLength = 50; // Batas karakter

                                                // Cek apakah ada koma (menandakan multiple authors)
                                                if (strpos($penulisTim, ',') !== false) {
                                                    $authors = explode(',', $penulisTim);
                                                    $firstAuthor = trim($authors[0]);
                                                    $otherCount = count($authors) - 1;
                                                    $displayText = $firstAuthor . ' dan ' . $otherCount . ' lainnya';
                                                    $fullText = $penulisTim;
                                                } elseif (strlen($penulisTim) > $maxLength) {
                                                    // Jika panjang tapi tidak ada koma, potong
                                                    $displayText = substr($penulisTim, 0, $maxLength) . '...';
                                                    $fullText = $penulisTim;
                                                } else {
                                                    $displayText = $penulisTim;
                                                    $fullText = $penulisTim;
                                                }
                                            ?>
                                                &nbsp;|&nbsp;
                                                <i class="fa fa-user"></i>
                                                <span title="<?= htmlspecialchars($fullText) ?>" style="cursor: help;">
                                                    <?= htmlspecialchars($displayText) ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (!empty($arsip['tahun'])): ?>
                                                &nbsp;(<?= htmlspecialchars($arsip['tahun']) ?>)
                                            <?php endif; ?>
                                        </small>
                                    </div>

                                    <div class="ms-3" style="margin-left: 15px; display: flex; flex-direction: column; gap: 5px;">
                                        <?php if (!empty($arsip['nama_file'])): ?>
                                            <a href="<?= htmlspecialchars($arsip['nama_file']) ?>" class="btn btn-outline-primary btn-sm" download>
                                                <i class="fa fa-download"></i> Unduh
                                            </a>
                                        <?php endif; ?>

                                        <?php if (!empty($arsip['link_eksternal'])): ?>
                                            <a href="<?= htmlspecialchars($arsip['link_eksternal']) ?>" target="_blank" class="btn btn-outline-success btn-sm">
                                                <i class="fa fa-external-link-alt"></i> Artikel
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php
                            endforeach;
                        else:
                            ?>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i> Tidak ada dokumen yang tersedia saat ini.
                            </div>
                        <?php endif; ?>

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