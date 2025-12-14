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
                                id="arsip-search-input"
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
                    <p class="service-details__text mb-3">Silahkan melihat artikel dan unduh dokumen yang Anda butuhkan.</p>

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
                                $kategoriArsip = $arsip['kategori'] ?? 'default';
                                $iconData = isset($categoryIconMapping[$kategoriArsip]) ? $categoryIconMapping[$kategoriArsip] : $categoryIconMapping['default'];

                                // Data search untuk fitur pencarian JS
                                $searchableContent = strtolower(($arsip['judul'] ?? '') . ' ' . ($arsip['deskripsi'] ?? '') . ' ' . ($arsip['penulis_atau_tim'] ?? ''));
                        ?>
                                <div class="list-group-item list-group-item-action d-flex align-items-center p-4 mb-3 shadow-sm arsip-item"
                                    data-search="<?= htmlspecialchars($searchableContent) ?>"
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
                                            <i class="fa fa-calendar-alt"></i> <?= htmlspecialchars($arsip['tahun'] ?? '-') ?> &nbsp;|&nbsp;
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

                    <div class="col-12 mt-4 search-no-results" style="display:none; text-align:center;">
                        <div class="alert alert-warning">
                            <i class="fa fa-search me-2"></i> Tidak ada dokumen yang cocok dengan kata kunci pencarian Anda.
                        </div>
                    </div>

                    <div class="col-12 mt-4 arsip-pagination-wrapper" style="display:flex; justify-content:center;">
                        <ul id="arsip-pagination-container" class="pagination"></ul>
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

<!-- Custom CSS for Arsip Pagination Visibility -->
<style>
    #arsip-pagination-container {
        display: flex;
        gap: 8px;
        align-items: center;
        justify-content: center;
        padding: 0;
        margin: 0;
    }

    #arsip-pagination-container li {
        list-style: none;
    }

    #arsip-pagination-container li a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 45px;
        height: 45px;
        background-color: #f0f4f8;
        color: #6b7280;
        border: none;
        border-radius: 50%;
        text-decoration: none;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    }

    #arsip-pagination-container li.active a {
        background-color: #2563eb;
        color: #fff;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
    }

    #arsip-pagination-container li.disabled a {
        color: #d1d5db;
        pointer-events: none;
        background-color: #f9fafb;
        box-shadow: none;
    }

    #arsip-pagination-container li a:hover:not(.active) {
        background-color: #e5e7eb;
        color: #374151;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
    }

    /* CRITICAL: Hide all items by default, show only .arsip-visible */
    .arsip-item {
        display: none !important;
    }

    .arsip-item.arsip-visible {
        display: flex !important;
    }
</style>

<!-- ARSIP PAGE PAGINATION SCRIPT -->
<script>
    jQuery(document).ready(function($) {
        console.log("Arsip Pagination Local Script Running...");

        const itemsPerPage = 5;
        const $listItems = $('.arsip-item');
        const $paginationContainer = $('#arsip-pagination-container');
        const $wrapper = $('.arsip-pagination-wrapper');
        const $noResults = $('.search-no-results');
        const totalItems = $listItems.length;
        const totalPages = Math.ceil(totalItems / itemsPerPage);
        let currentPage = 1;

        console.log("Total Items:", totalItems);
        console.log("Total Pages:", totalPages);

        if (totalItems === 0) return;

        // 1. Function to Show Specific Page
        function showArsipPage(page) {
            currentPage = page;
            const start = (page - 1) * itemsPerPage;
            const end = start + itemsPerPage;

            // Remove visible class from all items
            $listItems.removeClass('arsip-visible');

            // Add visible class to the slice
            $listItems.slice(start, end).addClass('arsip-visible');

            renderArsipPagination();
        }

        // 2. Render Pagination Buttons
        function renderArsipPagination() {
            $paginationContainer.empty();

            if (totalPages <= 1) {
                $wrapper.hide();
                return;
            } else {
                $wrapper.css('display', 'flex');
            }

            // Button HTML Builder
            let html = '';

            // Prev
            const prevDisabled = currentPage === 1 ? 'disabled' : '';
            html += `<li class="${prevDisabled}"><a href="#" data-page="${currentPage - 1}">&laquo;</a></li>`;

            // Page Numbers
            for (let i = 1; i <= totalPages; i++) {
                const active = i === currentPage ? 'active' : '';
                html += `<li class="${active}"><a href="#" data-page="${i}">${i}</a></li>`;
            }

            // Next
            const nextDisabled = currentPage === totalPages ? 'disabled' : '';
            html += `<li class="${nextDisabled}"><a href="#" data-page="${currentPage + 1}">&raquo;</a></li>`;

            $paginationContainer.html(html);
        }

        // 3. Event Listener
        $paginationContainer.off('click').on('click', 'a', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page >= 1 && page <= totalPages) {
                $('html, body').animate({
                    scrollTop: $('.service-details').offset().top - 80
                }, 400);
                showArsipPage(page);
            }
        });

        // 4. Search Handler
        $('#arsip-search-input').off('keyup').on('keyup', function() {
            const query = $(this).val().toLowerCase().trim();

            if (query === '') {
                // Reset to pagination mode
                $wrapper.show();
                $noResults.hide();
                showArsipPage(1);
                return;
            }

            // Search Mode
            $wrapper.hide();
            let count = 0;

            // Remove all visible classes first
            $listItems.removeClass('arsip-visible');

            $listItems.each(function() {
                const text = $(this).data('search') || $(this).text().toLowerCase();
                if (text.includes(query)) {
                    $(this).addClass('arsip-visible');
                    count++;
                }
            });

            if (count === 0) {
                $noResults.show();
            } else {
                $noResults.hide();
            }
        });

        // Initial Run
        // setTimeout to ensure no other scripts override us
        setTimeout(function() {
            showArsipPage(1);
        }, 100);
    });
</script>