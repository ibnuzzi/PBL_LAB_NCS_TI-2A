<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>
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

<style>
    /* Team Carousel Styles - Improved & Professional */
    .team-carousel-wrapper {
        position: relative;
        overflow: hidden;
        padding: 40px 70px 60px;
        margin-top: 30px;
    }

    .team-carousel {
        display: flex;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        gap: 25px;
    }

    .team-slide {
        min-width: calc(25% - 19px);
        flex-shrink: 0;
    }

    /* Enhanced Card Styling */
    .team-slide .team-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }

    .team-slide .team-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 32px rgba(26, 58, 107, 0.18);
    }

    .team-slide .team-card__image {
        height: 320px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #f5f7fa 0%, #e8eef4 100%);
        position: relative;
    }

    .team-slide .team-card__image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #1a3a6b 0%, #2d5a9e 50%, #1a3a6b 100%);
    }

    .team-slide .team-card__image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.5s ease;
    }

    .team-slide .team-card:hover .team-card__image img {
        transform: scale(1.08);
    }

    .team-slide .team-card__content {
        padding: 20px 18px;
    }

    .team-slide .team-card__content__title {
        font-size: 16px !important;
        line-height: 1.4 !important;
        margin-bottom: 6px !important;
        font-weight: 600 !important;
    }

    .team-slide .team-card__content__title a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .team-slide .team-card__content__title a:hover {
        color: #1a3a6b;
    }

    .team-slide .team-card__content__designation {
        font-size: 14px !important;
        color: #7f8c8d;
        font-weight: 500;
    }

    /* Responsive adjustments */
    @media (max-width: 1200px) {
        .team-slide {
            min-width: calc(33.333% - 17px);
        }
    }

    @media (max-width: 992px) {
        .team-slide {
            min-width: calc(50% - 13px);
        }
    }

    @media (max-width: 768px) {
        .team-slide {
            min-width: 100%;
        }

        .team-carousel-wrapper {
            padding: 30px 50px 50px;
        }
    }

    /* Navigation Arrows - Modern & Professional */
    .team-carousel__nav {
        position: absolute;
        top: 45%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
        color: white;
        border: none;
        width: 52px;
        height: 52px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        z-index: 10;
        box-shadow: 0 4px 16px rgba(26, 58, 107, 0.3);
        opacity: 0.95;
    }

    .team-carousel__nav:hover {
        background: linear-gradient(135deg, #2d5a9e 0%, #1a3a6b 100%);
        transform: translateY(-50%) scale(1.12);
        box-shadow: 0 6px 28px rgba(26, 58, 107, 0.5);
        opacity: 1;
    }

    .team-carousel__nav:active {
        transform: translateY(-50%) scale(0.98);
    }

    .team-carousel__nav--prev {
        left: 12px;
    }

    .team-carousel__nav--next {
        right: 12px;
    }

    .team-carousel__nav svg {
        transition: transform 0.3s ease;
    }

    .team-carousel__nav--next:hover svg {
        transform: translateX(4px);
    }

    .team-carousel__nav--prev:hover svg {
        transform: translateX(-4px);
    }

    /* Dots Indicator - Elegant & Modern */
    .team-carousel__dots {
        text-align: center;
        margin-top: 40px;
    }

    .dot {
        height: 10px;
        width: 10px;
        margin: 0 7px;
        background-color: #cbd5e0;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .dot::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: transparent;
        transition: all 0.3s ease;
    }

    .dot:hover::after {
        background: rgba(26, 58, 107, 0.12);
    }

    .dot:hover {
        background-color: #94a3b8;
        transform: scale(1.2);
    }

    .dot.active {
        background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
        width: 32px;
        border-radius: 6px;
    }

    .dot.active::after {
        display: none;
    }

    /* Smooth fade effect on edges */
    .team-carousel-wrapper::before,
    .team-carousel-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 60px;
        width: 65px;
        z-index: 5;
        pointer-events: none;
    }

    .team-carousel-wrapper::before {
        left: 0;
        background: linear-gradient(to right, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%);
    }

    .team-carousel-wrapper::after {
        right: 0;
        background: linear-gradient(to left, rgba(255, 255, 255, 1) 0%, rgba(255, 255, 255, 0) 100%);
    }
</style>

<script>
    // Improved Carousel Logic - No Duplicates, Smooth Experience
    let homeCurrentIndex = 0;
    let homeAutoSlideInterval;
    const homeTotalSlides = <?= !empty($pengelolaList) ? count($pengelolaList) : 0 ?>;
    const homeCarousel = document.getElementById('teamCarousel');
    const homeDots = document.querySelectorAll('.team-carousel__dots .dot');

    function updateCarouselHome() {
        if (!homeCarousel || homeTotalSlides === 0) return;

        const slideWidth = document.querySelector('.team-slide').offsetWidth + 25;
        homeCarousel.style.transform = `translateX(-${homeCurrentIndex * slideWidth}px)`;

        // Update dots
        homeDots.forEach((dot, index) => {
            dot.classList.toggle('active', index === homeCurrentIndex);
        });
    }

    function moveCarouselHome(direction) {
        if (homeTotalSlides === 0) return;

        homeCurrentIndex += direction;

        // Wrap around logic - smooth circular navigation
        if (homeCurrentIndex >= homeTotalSlides) {
            homeCurrentIndex = 0;
        } else if (homeCurrentIndex < 0) {
            homeCurrentIndex = homeTotalSlides - 1;
        }

        updateCarouselHome();
        resetAutoSlideHome();
    }

    function currentSlideHome(index) {
        if (homeTotalSlides === 0) return;

        homeCurrentIndex = index;
        updateCarouselHome();
        resetAutoSlideHome();
    }

    function autoSlideHome() {
        if (homeTotalSlides === 0) return;

        homeCurrentIndex++;
        if (homeCurrentIndex >= homeTotalSlides) {
            homeCurrentIndex = 0;
        }
        updateCarouselHome();
    }

    function startAutoSlideHome() {
        if (homeTotalSlides > 1) {
            homeAutoSlideInterval = setInterval(autoSlideHome, 5000);
        }
    }

    function resetAutoSlideHome() {
        clearInterval(homeAutoSlideInterval);
        startAutoSlideHome();
    }

    // Initialize carousel on DOM load
    document.addEventListener('DOMContentLoaded', function() {
        if (homeTotalSlides > 0) {
            updateCarouselHome();
            startAutoSlideHome();

            const wrapper = document.querySelector('.team-carousel-wrapper');
            if (wrapper) {
                wrapper.addEventListener('mouseenter', () => clearInterval(homeAutoSlideInterval));
                wrapper.addEventListener('mouseleave', startAutoSlideHome);
            }
        }
    });

    window.addEventListener('resize', updateCarouselHome);
</script>

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
                                    <a href="<?= BASE_URL; ?>/arsip"><?= htmlspecialchars($penelitian['nama_dokumen']) ?></a>
                                </h4>
                                <p class="case-studies__list__item__text"><?= htmlspecialchars(date('Y', strtotime($penelitian['created_at']))) ?></p>
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

<style>
    /* Penelitian Section Styling */
    .case-studies {
        padding: 120px 0 90px;
        position: relative;
    }

    .case-studies__list {
        display: flex;
        flex-wrap: wrap;
        margin: 0 -15px;
        justify-content: center;
    }

    .case-studies__list__item {
        width: 25%;
        padding: 0 15px;
        margin-bottom: 30px;
    }

    .case-studies__list__item__content {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.4s ease;
    }

    .case-studies__list__item__thumb {
        position: relative;
        overflow: hidden;
    }

    .case-studies__list__item__thumb img {
        width: 100%;
        height: auto;
        transition: transform 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        display: block;
    }

    .case-studies__list__item:hover .case-studies__list__item__thumb img {
        transform: scale(1.1);
    }

    .case-studies__list__item__hover {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 30px 20px;
        background: linear-gradient(to top, rgba(26, 58, 107, 0.95), rgba(26, 58, 107, 0.8), transparent);
        transform: translateY(100%);
        transition: transform 0.4s ease;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        height: 100%;
        opacity: 0;
    }

    .case-studies__list__item:hover .case-studies__list__item__hover {
        transform: translateY(0);
        opacity: 1;
    }

    .case-studies__list__item__title {
        margin-bottom: 10px;
    }

    .case-studies__list__item__title a {
        color: #fff;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .case-studies__list__item__text {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin: 0;
        font-weight: 500;
    }

    /* Button Styling */
    .btn-publikasi {
        display: inline-flex;
        align-items: center;
        padding: 14px 35px;
        font-size: 15px;
        font-weight: 600;
        text-decoration: none;
        color: #fff;
        background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
        border-radius: 50px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(26, 58, 107, 0.3);
    }

    .btn-publikasi:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(26, 58, 107, 0.4);
        color: #fff;
    }

    .btn-publikasi i {
        margin-left: 10px;
        transition: transform 0.3s ease;
    }

    .btn-publikasi:hover i {
        transform: translateX(5px);
    }

    /* Responsive */
    @media (max-width: 991px) {
        .case-studies__list__item {
            width: 50%;
        }
    }

    @media (max-width: 575px) {
        .case-studies__list__item {
            width: 100%;
        }
    }
</style>
<!-- Penelitian section End -->

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
                            <h3 class="service-card__title"><a>Workstation</a></h3>
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
                            <h3 class="service-card__title"><a>Perangkat Lunak</a></h3>
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
<style>
    /* Memastikan kedua card memiliki tinggi yang sama */
    .service-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .service-card__inner {
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    /* Membuat judul memiliki tinggi yang sama */
    .service-card__top {
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .service-card__title {
        text-align: center;
    }

    /* Memastikan gambar memiliki ukuran yang konsisten */
    .service-card__thumb__item img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    /* Membuat tinggi card seragam */
    .gutter-y-30>[class*="col-"] {
        display: flex;
    }
</style>
<!-- Fasilitas section End -->

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
<!-- Video section End -->

<style>
    /* Video Section Enhancements */
    .video-cta {
        position: relative;
        padding: 120px 0;
        background-color: #0b1c33;
        overflow: hidden;
        text-align: center;
    }

    .video-cta__bg {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url(public/assets/images/backgrounds/video-bg.png);
        background-size: cover;
        background-position: center;
        opacity: 0.3;
        z-index: 1;
    }

    .video-cta::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to bottom, rgba(11, 28, 51, 0.8) 0%, #0b1c33 100%);
        z-index: 2;
    }

    .video-cta__divider {
        position: absolute;
        top: 0;
        left: 0;    
        width: 100%;
        height: 60px;
        z-index: 3;
    }

    .video-cta__divider svg {
        width: 100%;
        height: 100%;
    }

    .video-cta__inner {
        position: relative;
        z-index: 4;
    }

    .video-popup {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 110px;
        background-color: #27613fff;
        color: #fff;
        font-size: 36px;
        clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
        transition: transform 0.3s ease, background-color 0.3s ease;
        text-decoration: none;
        box-shadow: 0 10px 30px rgba(0, 200, 83, 0.3);
    }

    .video-popup:hover {
        transform: scale(1.1);
        background-color: #00e676;
        color: #fff;
    }

    .video-popup i {
        margin-left: 5px;
    }

    .video-cta__title {
        color: #fff;
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 20px;
        letter-spacing: -0.5px;
    }

    .video-cta__text {
        color: rgba(255, 255, 255, 0.85);
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 40px;
        max-width: 650px;
        margin-left: auto;
        margin-right: auto;
        font-weight: 500;
    }

    .video-cta__video {
        margin-bottom: 0;
    }

    .btn-publikasi--green {
        background: linear-gradient(135deg, #00c853 0%, #00e676 100%);
        box-shadow: 0 4px 15px rgba(0, 200, 83, 0.3);
    }

    .btn-publikasi--green:hover {
        box-shadow: 0 8px 25px rgba(0, 200, 83, 0.4);
    }
</style>

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
<!-- Berita section End -->
<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>