<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>
<!-- Load extracted CSS for homepage -->
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/lab-ncs-home.css?v=<?= filemtime(__DIR__ . '/../../../public/css/lab-ncs-home.css') ?>">
<!-- main-slider-start -->
<section class="main-slider-one">
    <div class="main-slider-one__carousel laboix-owl__carousel owl-carousel" data-owl-options='{
		"items": 1,
		"margin": 0,
		"loop": true,
		"smartSpeed": 700,
		"nav": false,
		"navText": ["<span class=\"icon-left-arrow\"></span>","<span class=\"icon-arrow\"></span>"],
		"dots": false,
		"autoplay": true,
        "autoplayTimeout": 5000,
		"mouseDrag": false,
		"touchDrag": false,
		"pullDrag": false,
		"freeDrag": false,
		"autoplayHoverPause": false
		}'>

        <div class="item">
            <div class="main-slider-one__item">
                <div class="main-slider-one__bg" style="background-image: url(public/assets/images/bg-gedung.jpg);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-slider-one__content">
                                <span class="header-home-text">Selamat Datang di Lab NCS JTI Polinema</span>
                                <h2 class="main-slider-one__title">Pusat Riset<br>Jaringan Keamanan & Siber</h2>
                                <p class="header-home-text">Mengembangkan inovasi dan talenta di bidang Network & Cyber Security untuk menghadapi tantangan digital masa depan.</p>
                                <div class="main-slider-one__link">
                                    <a href="<?= BASE_URL ?>/tentang" class="laboix-btn">Pelajari Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="item">
            <div class="main-slider-one__item">
                <div class="main-slider-one__bg" style="background-image: url(public/assets/images/bg-gedung.jpg);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-slider-one__content">
                                <span class="header-home-text">Fokus Pada Keunggulan</span>
                                <h2 class="main-slider-one__title">Network Security Systems, <br>Data and Infrastructure</h2>
                                <p class="header-home-text">Membangun infrastruktur jaringan, data, dan infrastruktur yang handal dan aman untuk mendukung transformasi digital.</p>
                                <div class="main-slider-one__link">
                                    <a href="<?= BASE_URL ?>/tentang" class="laboix-btn">Pelajari Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="item">
            <div class="main-slider-one__item">
                <div class="main-slider-one__bg" style="background-image: url(public/assets/images/gallery/galerilab-1.jpg)"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-slider-one__content">
                                <span class="header-home-text">Keamanan Siber Terdepan</span>
                                <h2 class="main-slider-one__title">Cyber Defense<br>& Offensive Security</h2>
                                <p class="header-home-text">Melatih profesional keamanan siber yang kompeten dalam melindungi aset digital.</p>
                                <div class="main-slider-one__link">
                                    <a href="<?= BASE_URL ?>/tentang" class="laboix-btn">Pelajari Lebih Lanjut</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- main-slider-end -->

<!-- Tentang Kami section start -->
<section class="about-two">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-two__left wow fadeInLeft" data-wow-duration="700ms" data-wow-delay="500ms">
                    <div class="about-two__thumb">
                        <div class="about-two__thumb__item">
                            <img src="public/assets/images/about/about-2-1.png" alt="laboix">
                        </div>
                        <div class="about-two__thumb__item about-two__thumb__item--two">
                            <img src="public/assets/images/about/about-s-2-1.png" alt="laboix">
                            <div class="about-two__items">
                                <div class="about-two__box">
                                    <div class="about-two__box__icon">
                                        <i class="icon-chatting"></i>
                                    </div>
                                    <div class="about-two__box__content">
                                        <span class="about-two__box__subtitle">Nomor Telepon</span>
                                        <a href="tel:0341-404-424" class="about-two__box__text">(0341) 404-424</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-two__right">
                    <div class="about-two__top">
                        <div class="sec-title text-start wow fadeInUp" data-wow-duration='1500ms'>
                            <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/science.png" alt="Tentang Kami" class="sec-title__img">Tentang Kami</h6>
                            <h3 class="sec-title__title">PROFIL LABORATORIUM</h3>
                        </div>
                        <p class="about-two__top__text">Unit penunjang akademik di Jurusan Teknologi Informasi yang difokuskan pada pengembangan kompetensi di bidang jaringan komputer dan keamanan siber. Laboratorium ini mendukung kegiatan praktikum, penelitian, dan pengembangan yang berkaitan dengan administrasi jaringan, pengamanan infrastruktur, pemantauan lalu lintas data, hingga penerapan teknologi keamanan informasi dalam melindungi aset digital organisasi.</p>
                        Selain menjadi sarana pembelajaran mahasiswa, Laboratorium Jaringan & Keamanan Siber juga berperan sebagai wadah penelitian dan inovasi bagi dosen maupun mahasiswa dalam mengkaji solusi di bidang keamanan jaringan, pengujian sistem, serta perlindungan data dan infrastruktur digital. Peran laboratorium ini diharapkan mampu memperkuat kualitas pembelajaran, memperdalam riset di bidang jaringan komputer dan keamanan informasi, serta mendukung terciptanya lulusan yang kompeten di bidang administrasi jaringan dan keamanan siber.</p>
                    </div>

                    <div class="about-two__feature wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                        <div class="about-two__feature__item">
                            <div class="about-two__feature__icon">
                                <i class="icon-accuracy-1"></i>
                            </div>
                            <h4 class="about-two__feature__title"><a>Fokus Riset Laboratorium</a></h4>
                            <ul class="about-two__list list-unstyled wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                                <li class="about-two__list__item"><i class="fas fa-check-circle"></i> Network Administration & Engineering </li>
                                <li class="about-two__list__item"><i class="fas fa-check-circle"></i> Cyber Defense </li>
                                <li class="about-two__list__item"><i class="fas fa-check-circle"></i> Offense Security </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-two__shape">
        <img src="public/assets/images/shapes/about-shape-2-1.png" alt>
    </div>
</section>
<!-- Tentang Kami section End -->

<?php
// Ensure pengelola data is available
if (!isset($pengelolaList)) {
    $pengelolaList = [];
}
?>

<!-- Tim Kami section start -->
<section class="team-one team-one--home team-section-margin">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline">
                        <img src="public/assets/images/shapes/people.png" alt="Tim Kami" class="sec-title__img">Tim Kami
                    </h6>
                    <h3 class="sec-title__title">Tim Pengelola Lab <br> Network & Cyber Security</h3>
                </div>
            </div>
        </div>

        <?php if (!empty($pengelolaList)): ?>
            <!-- Set total slides for carousel JS -->
            <script>
                window.homeTotalSlides = <?= count($pengelolaList) ?>;
            </script>
            <!-- Team Carousel -->
            <div class="team-carousel-wrapper">
                <div class="team-carousel" id="teamCarousel">
                    <?php foreach ($pengelolaList as $member): ?>
                        <?php
                        // Handle photo path
                        $photoPath = BASE_URL . '/public/assets/images/team/default-avatar.jpg';
                        if (!empty($member['foto_pengelola'])) {
                            $imageName = ltrim(trim($member['foto_pengelola']), '/');
                            $photoPath = BASE_URL . '/public/uploads/pengelola/' . $imageName;
                            $serverPath = __DIR__ . '/../../../public/uploads/pengelola/' . $imageName;
                            if (!@file_exists($serverPath)) {
                                $photoPath = BASE_URL . '/public/assets/images/team/default-avatar.jpg';
                            }
                        }

                        // Determine badge color based on jabatan
                        $badgeClass = 'badge-researcher';
                        $jabatan = strtolower($member['nama_jabatan'] ?? '');
                        if (strpos($jabatan, 'kepala') !== false) {
                            $badgeClass = 'badge-head';
                        } elseif (strpos($jabatan, 'teknisi') !== false) {
                            $badgeClass = 'badge-technician';
                        }
                        ?>
                        <!-- Team Member Card - Enhanced -->
                        <div class="team-slide">
                            <div class="team-card team-card--enhanced">
                                <div class="team-card__inner">
                                    <div class="team-card__image">
                                        <img src="<?= $photoPath ?>" alt="<?= htmlspecialchars($member['nama_pengelola'] ?? 'Team Member') ?>" onerror="this.onerror=null;this.src='<?= BASE_URL ?>/public/assets/images/team/default-avatar.jpg';">
                                        <!-- Overlay on hover -->
                                        <div class="team-card__overlay">
                                            <div class="team-card__social">
                                                <a href="<?= !empty($member['linkedin_url']) ? htmlspecialchars($member['linkedin_url']) : 'https://linkedin.com' ?>" target="_blank" title="LinkedIn" class="team-card__social-link">
                                                    <i class="fab fa-linkedin-in"></i>
                                                </a>
                                                <a href="<?= BASE_URL ?>/pengelola/<?= $member['id_pengelola'] ?>" title="Profile" class="team-card__social-link">
                                                    <i class="fas fa-user"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <!-- Badge -->
                                        <span class="team-card__badge <?= $badgeClass ?>">
                                            <?= htmlspecialchars($member['nama_jabatan'] ?? 'Staff') ?>
                                        </span>
                                    </div>
                                    <div class="team-card__content">
                                        <div class="team-card__content__inner">
                                            <h3 class="team-card__content__title">
                                                <a href="<?= BASE_URL ?>/pengelola/<?= $member['id_pengelola'] ?>">
                                                    <?= htmlspecialchars($member['nama_pengelola'] ?? 'Unknown') ?>
                                                </a>
                                            </h3>
                                            <?php if (!empty($member['keminatan_list'])): ?>
                                                <p class="team-card__keminatan"><?= htmlspecialchars($member['keminatan_list']) ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation Arrows -->
                <button class="team-carousel__nav team-carousel__nav--prev" type="button" aria-label="Previous slide">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="team-carousel__nav team-carousel__nav--next" type="button" aria-label="Next slide">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="team-carousel__dots">
                    <?php for ($i = 0; $i < count($pengelolaList); $i++): ?>
                        <span class="dot <?= $i === 0 ? 'active' : '' ?>" role="button" tabindex="0" aria-label="Slide <?= $i + 1 ?>" aria-pressed="<?= $i === 0 ? 'true' : 'false' ?>"></span>
                    <?php endfor; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Fallback message -->
            <div class="text-center team-empty-state-container">
                <p class="team-empty-state-text">Data tim pengelola belum tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- Tim Kami section End -->
<!-- CSS and JavaScript moved to: lab-ncs-home.css and lab-ncs-home-carousel.js -->

<!-- Manfaat Bergabung section start -->
<section class="our-work">
    <style>
        /* Hide default step counter and show icon instead */
        .our-work__item__step--icon::before {
            display: none !important;
        }

        .our-work__item__step--icon {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .our-work__item__step--icon i {
            font-size: 1.5rem;
            color: #2563eb;
            transition: color 0.3s ease;
        }

        /* When hovered, change icon color to white */
        .our-work__item:hover .our-work__item__step--icon i {
            color: #fff;
        }

        /* Hide green arrow */
        .our-work__item__shape {
            display: none !important;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/determined.png" alt="Manfaat Bergabung" class="sec-title__img">Manfaat Bergabung</h6>
                    <h3 class="sec-title__title">Mengapa Bergabung dengan Lab NCS? <br> Empat Keuntungan Utama</h3>
                </div>
            </div>
            <div class="row gutter-y-30">
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item">
                        <div class="our-work__item__step our-work__item__step--icon"><i class="fas fa-flask"></i></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Pengalaman <br> Riset Nyata</a></h4>
                            <p class="our-work__item__text">Terlibat langsung dalam penelitian aktual bersama dosen dan praktisi. Mengerjakan proyek riil di bidang network security dan cyber defense.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item">
                        <div class="our-work__item__step our-work__item__step--icon"><i class="fas fa-users"></i></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Networking <br> Profesional</a></h4>
                            <p class="our-work__item__text">Membangun koneksi dengan praktisi keamanan siber, akademisi, dan sesama mahasiswa dalam proyek dan event nasional.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item">
                        <div class="our-work__item__step our-work__item__step--icon"><i class="fas fa-lightbulb"></i></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Pengembangan <br> Skill</a></h4>
                            <p class="our-work__item__text">Meningkatkan kemampuan teknis (penetration testing, network analysis) dan soft skill melalui mentoring intensif.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item our-work__item--two">
                        <div class="our-work__item__step our-work__item__step--icon"><i class="fas fa-file-alt"></i></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Publikasi <br> Ilmiah</a></h4>
                            <p class="our-work__item__text">Kesempatan menjadi co-author di jurnal nasional terakreditasi maupun konferensi internasional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Manfaat Bergabung section End -->

<!-- Statistics Counter section start -->
<section class="funfact-one" style="background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%); padding: 80px 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 text-center mb-5">
                <h6 class="sec-title__tagline" style="color: #fff;"><img src="public/assets/images/shapes/science.png" alt="Statistik" class="sec-title__img">Lab NCS dalam Angka</h6>
                <h3 class="sec-title__title" style="color: #fff;">Pencapaian Kami</h3>
            </div>
        </div>
        <div class="row gutter-y-20 justify-content-center">
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="funfact-one__item text-center wow fadeInUp" data-wow-duration="700ms" data-wow-delay="100ms">
                    <div class="funfact-one__icon" style="font-size: 3rem; color: #60a5fa; margin-bottom: 15px;">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h2 class="funfact-one__count" style="color: #fff; font-size: 3rem; font-weight: 700;">
                        <?= $totalPenelitian ?? 0 ?>+
                    </h2>
                    <p class="funfact-one__text" style="color: #94a3b8; font-size: 1.1rem; font-weight: 500;">Penelitian</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="funfact-one__item text-center wow fadeInUp" data-wow-duration="700ms" data-wow-delay="200ms">
                    <div class="funfact-one__icon" style="font-size: 3rem; color: #60a5fa; margin-bottom: 15px;">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h2 class="funfact-one__count" style="color: #fff; font-size: 3rem; font-weight: 700;">
                        <?= $totalPengabdian ?? 0 ?>+
                    </h2>
                    <p class="funfact-one__text" style="color: #94a3b8; font-size: 1.1rem; font-weight: 500;">Pengabdian</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="funfact-one__item text-center wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                    <div class="funfact-one__icon" style="font-size: 3rem; color: #60a5fa; margin-bottom: 15px;">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <h2 class="funfact-one__count" style="color: #fff; font-size: 3rem; font-weight: 700;">
                        <?= $totalPengelola ?? 0 ?>+
                    </h2>
                    <p class="funfact-one__text" style="color: #94a3b8; font-size: 1.1rem; font-weight: 500;">Tim Pengelola</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Statistics Counter section End -->

<!-- Penelitian section start -->
<section class="case-studies">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/science.png" alt="Penelitian" class="sec-title__img">Penelitian</h6>
                    <h3 class="sec-title__title">Sorotan Penelitian Terbaru</h3>
                </div>
            </div>
        </div>
        <ul class="case-studies__list list-unstyled">
            <?php if (!empty($latestPenelitian)): ?>
                <?php foreach ($latestPenelitian as $penelitian): ?>
                    <li class="case-studies__list__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                        <div class="case-studies__list__item__content">
                            <div class="case-studies__list__item__thumb">
                                <img src="public/assets/images/resources/case-stady-1-1.png" alt="laboix">
                            </div>
                            <div class="case-studies__list__item__hover">
                                <h4 class="case-studies__list__item__title">
                                    <?php
                                    $link = !empty($penelitian['link_publikasi']) ? $penelitian['link_publikasi'] : (BASE_URL . '/arsip?kategori=Penelitian');
                                    $target = !empty($penelitian['link_publikasi']) ? '_blank' : '_self';
                                    ?>
                                    <a href="<?= htmlspecialchars($link) ?>" target="<?= $target ?>"><?= htmlspecialchars($penelitian['judul_penelitian']) ?></a>
                                </h4>
                                <p class="case-studies__list__item__text"><?= DateHelper::toIndonesianDate($penelitian['created_at'], 'long') ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="col-12 text-center">
                    <p>Belum ada data penelitian.</p>
                </li>
            <?php endif; ?>
        </ul>

        <div class="row">
            <div class="col-12 text-center mt-5">
                <a href="<?= BASE_URL; ?>/arsip?kategori=Penelitian" class="btn-publikasi">Baca Selengkapnya <i class="icon-arrow"></i></a>
            </div>
        </div>
    </div>
</section>
<!-- Penelitian section End - CSS moved to lab-ncs-home.css -->

<!-- Pengabdian section start -->
<section class="case-studies" style="background: #f8fafc; padding: 100px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/science.png" alt="Pengabdian" class="sec-title__img">Pengabdian Masyarakat</h6>
                    <h3 class="sec-title__title">Kontribusi Kami untuk Masyarakat</h3>
                </div>
            </div>
        </div>
        <ul class="case-studies__list list-unstyled">
            <?php if (!empty($latestPengabdian)): ?>
                <?php foreach ($latestPengabdian as $pengabdian): ?>
                    <li class="case-studies__list__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                        <div class="case-studies__list__item__content">
                            <div class="case-studies__list__item__thumb">
                                <img src="public/assets/images/resources/case-stady-1-2.png" alt="pengabdian">
                            </div>
                            <div class="case-studies__list__item__hover">
                                <h4 class="case-studies__list__item__title">
                                    <a href="<?= BASE_URL ?>/arsip?kategori=Pengabdian"><?= htmlspecialchars($pengabdian['judul_kegiatan']) ?></a>
                                </h4>
                                <p class="case-studies__list__item__text"><?= htmlspecialchars($pengabdian['tahun_kegiatan']) ?> - <?= htmlspecialchars($pengabdian['first_author'] ?? 'Tim Lab NCS') ?></p>
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="col-12 text-center">
                    <p>Belum ada data pengabdian.</p>
                </li>
            <?php endif; ?>
        </ul>

        <div class="row">
            <div class="col-12 text-center mt-5">
                <a href="<?= BASE_URL; ?>/arsip?kategori=Pengabdian" class="btn-publikasi">Lihat Selengkapnya <i class="icon-arrow"></i></a>
            </div>
        </div>
    </div>
</section>
<!-- Pengabdian section End -->

<!-- Fasilitas section start -->
<section class="service-page service-page--one">
    <div class="service-page__bg" style="background-image: url(public/assets/images/shapes/service-shape-1-1.png);"></div>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/customer-review.png" alt="Fasilitas & Peralatan" class="sec-title__img">FASILITAS & PERALATAN</h6>
                    <h3 class="sec-title__title">Mendukung Inovasi Mahasiswa <br>di Bidang Network & Cyber Security</h3>
                </div>
            </div>
        </div>
        <div class="row gutter-y-30 justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="service-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='400ms'>
                    <div class="service-card__inner">
                        <div class="service-card__top">
                            <h3 class="service-card__title"><a href="<?= BASE_URL; ?>/fasilitas">Workstation</a></h3>
                        </div>
                        <div class="service-card__thumb">
                            <div class="service-card__thumb__item">
                                <img src="public/assets/images/service/service-1-1.png" alt="Workstation">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="service-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='600ms'>
                    <div class="service-card__inner">
                        <div class="service-card__top">
                            <h3 class="service-card__title"><a href="<?= BASE_URL; ?>/fasilitas">Perangkat Lunak</a></h3>
                        </div>
                        <div class="service-card__thumb">
                            <div class="service-card__thumb__item">
                                <img src="public/assets/images/service/service-1-2.png" alt="Perangkat Lunak">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Fasilitas section End - CSS moved to lab-ncs-home.css -->

<!-- Video section start -->
<section class="video-cta">
    <div class="video-cta__bg"></div>

    <!-- Shape Divider -->
    <div class="video-cta__divider">
        <svg viewBox="0 0 1200 60" preserveAspectRatio="none">
            <path d="M0,0 L1200,0 L1200,10 L600,60 L0,10 Z" fill="#ffffff"></path>
        </svg>
    </div>

    <div class="container">
        <div class="video-cta__inner">
            <div class="video-cta__video">
                <a href="https://www.youtube.com/watch?v=6FNJwbHwpuQ" class="video-cta__video__popup video-popup">
                    <i class="icon-play"></i>
                </a>
            </div>
            <div class="video-cta__content">
                <h3 class="video-cta__title">Lab NCS Tour</h3>
                <p class="video-cta__text">Mencetak Inovator Bertalenta di Bidang Network & Cybersecurity Masa Depan.</p>
                <div class="video-cta__link">
                    <a href="<?= BASE_URL ?>/tentang" class="btn-publikasi btn-publikasi--green">Jelajahi Laboratorium Kami <i class="icon-arrow"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Video section End - CSS moved to lab-ncs-home.css -->

<!-- Berita section Start -->
<section class="blog-one blog-one--home blog-section-padding">
    <div class="container">
        <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
            <h6 class="sec-title__tagline">
                <img src="public/assets/images/shapes/science.png" alt="Berita" class="sec-title__img">Berita
            </h6>
            <h3 class="sec-title__title">Sorotan Berita Terbaru</h3>
        </div>

        <div class="row gutter-y-30">
            <?php if (!empty($latestNews)): ?>
                <?php foreach ($latestNews as $news): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='400ms' style="
                    height: 100%;
                    display: flex;
                    flex-direction: column;
                ">
                            <div class="blog-card__image">
                                <div class="blog-card__image__item blog-card-image-item">
                                    <?php
                                    $imgSrc = BASE_URL . '/public/assets/images/blog/blog-1-1.png'; // Default
                                    if (!empty($news['gambar_berita'])) {
                                        // Check if image exists
                                        $serverPath = __DIR__ . '/../../../public/uploads/berita/' . $news['gambar_berita'];
                                        if (file_exists($serverPath)) {
                                            $imgSrc = BASE_URL . '/public/uploads/berita/' . $news['gambar_berita'];
                                            // Add cache busting
                                            $cacheParam = '?v=' . filemtime($serverPath);
                                            $imgSrc .= $cacheParam;
                                        }
                                    }
                                    ?>
                                    <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($news['judul_berita']) ?>" class="blog-card-img">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $news['slug_berita'] ?>" class="blog-card__image__link"></a>
                                </div>
                                <div class="blog-card__date">
                                    <span class="blog-card__date__day"><?= date('d', strtotime($news['tanggal_publish'])) ?></span><?= strtoupper(date('M', strtotime($news['tanggal_publish']))) ?>
                                </div>
                            </div>
                            <div class="blog-card__content blog-card-content-custom">
                                <div class="blog-card__author">
                                </div>
                                <h3 class="blog-card__title blog-card-title-custom">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $news['slug_berita'] ?>"><?= htmlspecialchars($news['judul_berita']) ?></a>
                                </h3>
                                <div class="blog-card__content__btn blog-card-btn-wrapper">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $news['slug_berita'] ?>" class="blog-card__content__btn__link">
                                        Baca Selengkapnya<i class="icon-arrow"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>Belum ada berita terbaru saat ini.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="<?= BASE_URL ?>/berita" class="btn-publikasi">Lihat Semua Berita <i class="icon-arrow"></i></a>
            </div>
        </div>
    </div>
</section>
<!-- Berita section End - CSS moved to lab-ncs-home.css -->
<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>