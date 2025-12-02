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
		"nav": true,
		"navText": ["<span class=\"icon-left-arrow\"></span>","<span class=\"icon-arrow\"></span>"],
		"dots": false,
		"autoplay": true,
        "autoplayTimeout": 5000
		}'>

        <div class="item">
            <div class="main-slider-one__item">
                <div class="main-slider-one__bg" style="background-image: url(public/assets/images/backgrounds/slider-1-1.jpg);"></div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="main-slider-one__content">
                                <span class="main-slider-one__tagline">Selamat Datang di Lab NCS JTI Polinema</span>
                                <h2 class="main-slider-one__title">Pusat Riset<br>Keamanan Jaringan & Siber</h2>
                                <p class="main-slider-one__text">Mengembangkan inovasi dan talenta di bidang Network & Cyber Security untuk menghadapi tantangan digital masa depan.</p>
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
<section class="team-one team-one--home" style="margin-bottom: 10%;">
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
                        ?>
                        <!-- Team Member -->
                        <div class="team-slide">
                            <div class="team-card">
                                <div class="team-card__inner">
                                    <div class="team-card__image">
                                        <img src="<?= $photoPath ?>" alt="<?= htmlspecialchars($member['nama_pengelola'] ?? 'Team Member') ?>" onerror="this.onerror=null;this.src='<?= BASE_URL ?>/public/assets/images/team/default-avatar.jpg';">
                                    </div>
                                    <div class="team-card__content">
                                        <div class="team-card__content__inner">
                                            <div class="team-card__content__item">
                                                <h3 class="team-card__content__title">
                                                    <?php if (!empty($member['link_profil'])): ?>
                                                        <a href="<?= htmlspecialchars($member['link_profil']) ?>" target="_blank"><?= htmlspecialchars($member['nama_pengelola'] ?? 'Unknown') ?></a>
                                                    <?php else: ?>
                                                        <a><?= htmlspecialchars($member['nama_pengelola'] ?? 'Unknown') ?></a>
                                                    <?php endif; ?>
                                                </h3>
                                                <h6 class="team-card__content__designation"><?= htmlspecialchars($member['jabatan'] ?? 'Staff') ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Navigation Arrows -->
                <button class="team-carousel__nav team-carousel__nav--prev" onclick="moveCarouselHome(-1)" aria-label="Previous">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button class="team-carousel__nav team-carousel__nav--next" onclick="moveCarouselHome(1)" aria-label="Next">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>

                <!-- Dots Indicator -->
                <div class="team-carousel__dots">
                    <?php for ($i = 0; $i < count($pengelolaList); $i++): ?>
                        <span class="dot <?= $i === 0 ? 'active' : '' ?>" onclick="currentSlideHome(<?= $i ?>)" aria-label="Slide <?= $i + 1 ?>"></span>
                    <?php endfor; ?>
                </div>
            </div>
        <?php else: ?>
            <!-- Fallback message -->
            <div class="text-center" style="padding: 60px 0;">
                <p style="color: #666; font-size: 16px;">Data tim pengelola belum tersedia.</p>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- Tim Kami section End -->
<!-- CSS and JavaScript moved to: lab-ncs-home.css and lab-ncs-home-carousel.js -->

<!-- Roadmap section start -->
<section class="our-work">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/determined.png" alt="Roadmap Penelitian" class="sec-title__img">Roadmap Penelitian</h6>
                    <h3 class="sec-title__title">Alur Riset Mahasiswa di Lab NCS: <br> Empat Tahap Utama</h3>
                </div>
            </div>
            <div class="row gutter-y-30">
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item">
                        <div class="our-work__item__step"></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Pengajuan Ide <br> dan Proposal Riset</a></h4>
                            <p class="our-work__item__text">Mahasiswa mengidentifikasi masalah, menyusun latar belakang, dan mengajukan proposal penelitian, termasuk usulan implementasi Riset Keamanan Jaringan.</p>
                            <div class="our-work__item__shape">
                                <img src="public/assets/images/shapes/work-teps.png" alt>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item">
                        <div class="our-work__item__step"></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Validasi Dosen dan <br>Pembentukan Tim Bimbingan</a></h4>
                            <p class="our-work__item__text">Dosen profesional di bidang terkait (Jaringan dan Keamanan) mereview proposal. Setelah disetujui, dosen pembimbing ditetapkan untuk mendukung riset mahasiswa.</p>
                            <div class="our-work__item__shape">
                                <img src="public/assets/images/shapes/work-teps.png" alt>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item">
                        <div class="our-work__item__step"></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Pelaksanaan Eksperimen <br> dan Pengujian Lapangan</a></h4>
                            <p class="our-work__item__text">Mahasiswa menggunakan fasilitas lab untuk menjalankan metodologi riset, melakukan eksperimen, dan mengumpulkan data (misalnya, pengujian skenario Keamanan Jaringan).</p>
                            <div class="our-work__item__shape">
                                <img src="public/assets/images/shapes/work-teps.png" alt>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item our-work__item--two">
                        <div class="our-work__item__step"></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a>Penyusunan Laporan <br>dan Diseminasi Hasil</a></h4>
                            <p class="our-work__item__text">Mahasiswa menyelesaikan laporan akhir (Tugas Akhir/Skripsi), mempresentasikan hasil, dan didorong untuk mempublikasikan temuan riset mereka sebagai bentuk kontribusi akademik.</p>
                            <div class="our-work__item__shape">
                                <img src="public/assets/images/shapes/work-teps.png" alt>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Roadmap section End -->

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
                                <p class="case-studies__list__item__text"><?= htmlspecialchars(date('d M Y', strtotime($penelitian['created_at']))) ?></p>
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
                <p class="video-cta__text">Mencetak Inovator Keamanan Jaringan dan Talenta Cybersecurity Masa Depan.</p>
                <div class="video-cta__link">
                    <a href="<?= BASE_URL ?>/tentang" class="btn-publikasi btn-publikasi--green">Gabunglah Menjadi Sang Juara <i class="icon-arrow"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Video section End - CSS moved to lab-ncs-home.css -->

<!-- Berita section Start -->
<section class="blog-one blog-one--home" style="padding: 120px 0 90px;">
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
                                <div class="blog-card__image__item" style="
                            height: 250px;
                            overflow: hidden;
                            position: relative;
                        ">
                                    <?php
                                    $imgSrc = BASE_URL . '/public/assets/images/blog/blog-1-1.png'; // Default
                                    if (!empty($news['gambar_berita'])) {
                                        // Check if image exists
                                        $serverPath = __DIR__ . '/../../../public/uploads/berita/' . $news['gambar_berita'];
                                        if (file_exists($serverPath)) {
                                            $imgSrc = BASE_URL . '/public/uploads/berita/' . $news['gambar_berita'];
                                        }
                                    }
                                    ?>
                                    <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($news['judul_berita']) ?>" style="
                                width: 100%;
                                height: 100%;
                                object-fit: cover;
                                object-position: center;
                            ">
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $news['slug_berita'] ?>" class="blog-card__image__link"></a>
                                </div>
                                <div class="blog-card__date">
                                    <span class="blog-card__date__day"><?= date('d', strtotime($news['tanggal_publish'])) ?></span><?= strtoupper(date('M', strtotime($news['tanggal_publish']))) ?>
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
                                    <a href="<?= BASE_URL ?>/berita/detail/<?= $news['slug_berita'] ?>"><?= htmlspecialchars($news['judul_berita']) ?></a>
                                </h3>
                                <div class="blog-card__content__btn" style="margin-top: auto;">
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