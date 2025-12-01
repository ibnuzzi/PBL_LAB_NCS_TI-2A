<?php
// gallery.php - Full Implementation
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<?php $gc_path = __DIR__ . '/../../..' . '/public/css/gallery-custom.css'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/gallery-custom.css?v=<?= file_exists($gc_path) ? filemtime($gc_path) : time() ?>">

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(<?= BASE_URL ?>/public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Galeri</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Aktivitas</span></li>
            <li><span>Galeri Foto</span></li>
        </ul>
    </div>
</section>

<section class="pt-80 pb-40 text-center">
    <div class="container">
        <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
            <h6 class="sec-title__tagline">
                <img src="<?= BASE_URL ?>/public/assets/images/shapes/science.png" alt="Galeri" class="sec-title__img">Galeri
            </h6>
            <h3 class="sec-title__title">Dokumentasi Kegiatan Lab NCS</h3>
        </div>
        <p class="agenda-intro-text">Telusuri dokumentasi kegiatan, pelatihan, dan aktivitas seru di Laboratorium Network and Cyber Security.</p>

        <div style="max-width:100%; margin:18px 0 22px;">
            <div class="agenda-search">
                <input id="gallery-search-input" class="search-input" placeholder="Cari foto berdasarkan judul atau deskripsi..." aria-label="Cari galeri">
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

<section class="gallery-page pt-50 pb-90" id="galeri">
    <div class="container">

        <div class="row gallery-grid gutter-y-30" id="gallery-items">
            <?php if (!empty($galleries) && is_array($galleries)): ?>
                <?php foreach ($galleries as $g): ?>
                    <?php
                    // Persiapan Data Pencarian (Title + Desc + Lowercase)
                    $searchableTitle = strtolower(trim($g['judul_foto'] ?? ''));
                    $searchableDesc = strtolower(trim($g['deskripsi_foto'] ?? ''));
                    $searchableContent = $searchableTitle . ' ' . $searchableDesc;
                    ?>
                    <div class="col-md-6 col-lg-4 grid-item gallery-item" data-search="<?= htmlspecialchars($searchableContent) ?>">
                        <div class="gallery-card">
                            <?php $img = !empty($g['nama_file_foto']) ? BASE_URL . '/public/uploads/gallery/' . $g['nama_file_foto'] : BASE_URL . '/public/assets/images/empty/empty_data.jpg'; ?>

                            <img src="<?= $img ?>" alt="<?= htmlspecialchars($g['judul_foto'] ?? 'Galeri') ?>" class="gallery-card__image" loading="lazy" decoding="async">

                            <div class="gallery-card__hover">
                                <button class="gallery-open-btn"
                                    data-image="<?= htmlspecialchars($img) ?>"
                                    data-title="<?= htmlspecialchars($g['judul_foto'] ?? '') ?>"
                                    data-desc="<?= htmlspecialchars($g['deskripsi_foto'] ?? '') ?>"
                                    data-date="<?= htmlspecialchars($g['tanggal_upload'] ?? date('Y-m-d')) ?>"
                                    title="Lihat Detail">
                                    <i class="icon-search"></i> </button>
                                <h4 class="gallery-card__title"><?= htmlspecialchars($g['judul_foto'] ?? '') ?></h4>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Tidak ada foto galeri untuk ditampilkan.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="search-no-results text-center" style="display: none; margin-top:40px;">
            <div class="search-no-results__icon">
            </div>
            <h3 class="search-no-results__title">Hasil Tidak Ditemukan</h3>
            <p class="search-no-results__message">Maaf, tidak ada galeri yang cocok dengan kata kunci pencarian Anda.</p>
        </div>

        <div class="gallery-pagination-wrapper text-center" style="margin-top:40px; display:flex; justify-content:center;">
            <ul id="gallery-pagination-container" class="pagination"></ul>
        </div>

    </div>
</section>

<div id="gallery-modal" class="gallery-modal">
    <div class="gallery-modal__close">&times;</div>
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
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/agenda-custom.css?v=<?= filemtime(__DIR__ . '/../../../public/css/agenda-custom.css') ?>">

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {



        /**
         * -----------------------------------------------------
         * 2. LOGIKA MODAL (LIGHTBOX)
         * -----------------------------------------------------
         */
        const modal = document.getElementById('gallery-modal');
        const modalClose = document.querySelector('.gallery-modal__close');
        const modalImg = document.getElementById('gallery-modal-image');
        const modalTitle = document.getElementById('gallery-modal-title');
        const modalDesc = document.getElementById('gallery-modal-desc');
        const modalDate = document.getElementById('gallery-modal-date');

        // Buka Modal saat tombol 'Lihat Detail' diklik
        document.querySelectorAll('.gallery-open-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();

                // Ambil data dari atribut tombol
                const src = this.getAttribute('data-image');
                const title = this.getAttribute('data-title');
                const desc = this.getAttribute('data-desc');
                const date = this.getAttribute('data-date');

                // Isi konten modal
                modalImg.src = src;
                modalTitle.textContent = title;
                modalDesc.textContent = desc || '-';
                modalDate.textContent = date;

                // Tampilkan modal
                modal.classList.add('show');
                document.body.style.overflow = 'hidden'; // Matikan scroll body
            });
        });

        // Fungsi Tutup Modal
        function closeModal() {
            modal.classList.remove('show');
            document.body.style.overflow = ''; // Hidupkan scroll body
            setTimeout(() => {
                modalImg.src = '';
            }, 300); // Reset gambar setelah animasi
        }

        if (modalClose) {
            modalClose.addEventListener('click', closeModal);
        }

        // Tutup jika klik di luar area konten (overlay)
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });
        }

        // Tutup dengan tombol ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal.classList.contains('show')) {
                closeModal();
            }
        });

    });
</script>