<?php
// tentang.php - Tentang Kami Page
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';

// Ensure pengelola data is available
if (!isset($pengelolaList)) {
    $pengelolaList = [];
}
?>

<!-- Page Header -->
<section class="page-header">
    <div class="page-header__bg" style="background-image: url(<?= BASE_URL ?>/public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Tentang Kami</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Tentang Kami</span></li>
        </ul>
    </div>
</section>

<!-- Sejarah Lab Section -->
<section class="about-two" id="sejarah" style="scroll-margin-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-two__left wow fadeInLeft" data-wow-duration="700ms" data-wow-delay="500ms">
                    <div class="about-two__thumb">
                        <div class="about-two__thumb__item">
                            <img src="public/assets/images/about/about-2-1.png" alt="Lab NCS">
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
                            <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/science.png" alt="Sejarah Lab" class="sec-title__img">Sejarah Lab</h6>
                            <h3 class="sec-title__title">PROFIL LABORATORIUM</h3>
                        </div>
                        <p class="about-two__top__text">Unit penunjang akademik di Jurusan Teknologi Informasi yang difokuskan pada pengembangan kompetensi di bidang jaringan komputer dan keamanan siber. Laboratorium ini mendukung kegiatan praktikum, penelitian, dan pengembangan yang berkaitan dengan administrasi jaringan, pengamanan infrastruktur, pemantauan lalu lintas data, hingga penerapan teknologi keamanan informasi dalam melindungi aset digital organisasi.</p>
                        <p class="about-two__top__text">Selain menjadi sarana pembelajaran mahasiswa, Laboratorium Jaringan & Keamanan Siber juga berperan sebagai wadah penelitian dan inovasi bagi dosen maupun mahasiswa dalam mengkaji solusi di bidang keamanan jaringan, pengujian sistem, serta perlindungan data dan infrastruktur digital. Peran laboratorium ini diharapkan mampu memperkuat kualitas pembelajaran, memperdalam riset di bidang jaringan komputer dan keamanan informasi, serta mendukung terciptanya lulusan yang kompeten di bidang administrasi jaringan dan keamanan siber.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="about-two__shape">
        <img src="public/assets/images/shapes/about-shape-2-1.png" alt>
    </div>
</section>

<!-- Visi & Misi Section -->
<section class="visi-misi-section" id="visi-misi" style="padding: 80px 0; background-color: #f8f9fa; scroll-margin-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/determined.png" alt="Visi & Misi" class="sec-title__img">Visi & Misi</h6>
                    <h3 class="sec-title__title">Arah dan Tujuan Laboratorium</h3>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 40px;">
            <!-- Visi -->
            <div class="col-lg-12">
                <div class="visi-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms" style="background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 35px;">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="flex-shrink: 0; width: 70px; height: 70px; background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(26, 58, 107, 0.25);">
                            <i class="fas fa-bullseye" style="font-size: 32px; color: white;"></i>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="color: #1a3a6b; font-size: 22px; font-weight: 700; margin-bottom: 15px;">Visi</h4>
                            <p style="color: #444; font-size: 15px; line-height: 1.8; margin: 0;">Menjadi laboratorium unggulan dalam bidang jaringan dan keamanan siber yang inovatif, adaptif, dan berdaya saing global, serta mendukung pengembangan pendidikan, penelitian, dan pengabdian masyarakat di bidang Teknologi Informasi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Misi -->
            <div class="col-lg-12">
                <div class="misi-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="400ms" style="background: white; padding: 35px; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div style="display: flex; align-items: flex-start; gap: 20px;">
                        <div style="flex-shrink: 0; width: 70px; height: 70px; background: linear-gradient(135deg, #2d5a9e 0%, #1a3a6b 100%); border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 20px rgba(45, 90, 158, 0.25);">
                            <i class="fas fa-rocket" style="font-size: 32px; color: white;"></i>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="color: #1a3a6b; font-size: 22px; font-weight: 700; margin-bottom: 20px;">Misi</h4>
                            <ul class="misi-list" style="list-style: none; padding: 0; margin: 0;">
                                <li style="display: flex; align-items: flex-start; margin-bottom: 18px; padding-left: 0;">
                                    <div style="flex-shrink: 0; width: 36px; height: 36px; background: linear-gradient(135deg, rgba(26, 58, 107, 0.15) 0%, rgba(45, 90, 158, 0.15) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; margin-top: 2px; box-shadow: 0 2px 8px rgba(26, 58, 107, 0.1);">
                                        <i class="fas fa-check" style="color: #1a3a6b; font-size: 16px; font-weight: 700;"></i>
                                    </div>
                                    <p style="margin: 0; color: #444; font-size: 15px; line-height: 1.8; flex: 1;">Menyelenggarakan kegiatan praktikum yang berkualitas untuk menghasilkan lulusan dengan kompetensi tinggi di bidang jaringan komputer dan keamanan siber.</p>
                                </li>
                                <li style="display: flex; align-items: flex-start; margin-bottom: 18px; padding-left: 0;">
                                    <div style="flex-shrink: 0; width: 36px; height: 36px; background: linear-gradient(135deg, rgba(26, 58, 107, 0.15) 0%, rgba(45, 90, 158, 0.15) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; margin-top: 2px; box-shadow: 0 2px 8px rgba(26, 58, 107, 0.1);">
                                        <i class="fas fa-check" style="color: #1a3a6b; font-size: 16px; font-weight: 700;"></i>
                                    </div>
                                    <p style="margin: 0; color: #444; font-size: 15px; line-height: 1.8; flex: 1;">Mengembangkan penelitian terapan dalam bidang jaringan, keamanan sistem, Internet of Things (IoT), serta teknologi monitoring yang relevan dengan kebutuhan industri dan masyarakat.</p>
                                </li>
                                <li style="display: flex; align-items: flex-start; margin-bottom: 18px; padding-left: 0;">
                                    <div style="flex-shrink: 0; width: 36px; height: 36px; background: linear-gradient(135deg, rgba(26, 58, 107, 0.15) 0%, rgba(45, 90, 158, 0.15) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; margin-top: 2px; box-shadow: 0 2px 8px rgba(26, 58, 107, 0.1);">
                                        <i class="fas fa-check" style="color: #1a3a6b; font-size: 16px; font-weight: 700;"></i>
                                    </div>
                                    <p style="margin: 0; color: #444; font-size: 15px; line-height: 1.8; flex: 1;">Menyediakan layanan uji keamanan, pendampingan, serta pelatihan bagi civitas akademika maupun mitra eksternal melalui kerja sama dengan industri, pemerintah, dan lembaga lainnya.</p>
                                </li>
                                <li style="display: flex; align-items: flex-start; margin-bottom: 18px; padding-left: 0;">
                                    <div style="flex-shrink: 0; width: 36px; height: 36px; background: linear-gradient(135deg, rgba(26, 58, 107, 0.15) 0%, rgba(45, 90, 158, 0.15) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; margin-top: 2px; box-shadow: 0 2px 8px rgba(26, 58, 107, 0.1);">
                                        <i class="fas fa-check" style="color: #1a3a6b; font-size: 16px; font-weight: 700;"></i>
                                    </div>
                                    <p style="margin: 0; color: #444; font-size: 15px; line-height: 1.8; flex: 1;">Meningkatkan kapasitas dosen, teknisi, dan asisten laboratorium dalam menguasai teknologi terkini melalui pelatihan, sertifikasi, dan partisipasi aktif dalam komunitas profesional.</p>
                                </li>
                                <li style="display: flex; align-items: flex-start; margin-bottom: 0; padding-left: 0;">
                                    <div style="flex-shrink: 0; width: 36px; height: 36px; background: linear-gradient(135deg, rgba(26, 58, 107, 0.15) 0%, rgba(45, 90, 158, 0.15) 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; margin-top: 2px; box-shadow: 0 2px 8px rgba(26, 58, 107, 0.1);">
                                        <i class="fas fa-check" style="color: #1a3a6b; font-size: 16px; font-weight: 700;"></i>
                                    </div>
                                    <p style="margin: 0; color: #444; font-size: 15px; line-height: 1.8; flex: 1;">Mendukung peningkatan literasi keamanan digital masyarakat melalui workshop, seminar, dan program pengabdian berbasis teknologi informasi.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
// Ensure pengelola data is available
if (!isset($pengelolaList)) {
    $pengelolaList = [];
}
?>

<!-- Tim Kami section start -->
<section class="team-one team-one--home" id="struktur" style="margin-bottom: 10%; scroll-margin-top: 100px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline">
                        <img src="public/assets/images/shapes/people.png" alt="Struktur Pengelola" class="sec-title__img">Struktur Pengelola
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

<style>
    /* Team Carousel Styles */
    .team-carousel-wrapper {
        position: relative;
        overflow: hidden;
        padding: 30px 70px 50px;
        margin-top: 20px;
    }

    .team-carousel {
        display: flex;
        transition: transform 0.8s ease-in-out;
        gap: 25px;
    }

    .team-slide {
        min-width: calc(25% - 19px);
        flex-shrink: 0;
    }

    /* Perkecil ukuran card */
    .team-slide .team-card__image {
        height: 280px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f8f9fa;
    }

    .team-slide .team-card__image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }

    .team-slide .team-card__content__title {
        font-size: 15px !important;
        line-height: 1.3 !important;
    }

    .team-slide .team-card__content__title a {
        color: inherit;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .team-slide .team-card__content__title a:hover {
        color: #1a3a6b;
    }

    .team-slide .team-card__content__designation {
        font-size: 13px !important;
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

    /* Navigation Arrows - Modern & Elegant */
    .team-carousel__nav {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        z-index: 10;
        box-shadow: 0 4px 15px rgba(26, 58, 107, 0.3);
        opacity: 0.9;
    }

    .team-carousel__nav:hover {
        background: linear-gradient(135deg, #2d5a9e 0%, #1a3a6b 100%);
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 25px rgba(26, 58, 107, 0.5);
        opacity: 1;
    }

    .team-carousel__nav:active {
        transform: translateY(-50%) scale(0.95);
    }

    .team-carousel__nav--prev {
        left: 15px;
    }

    .team-carousel__nav--next {
        right: 15px;
    }

    .team-carousel__nav svg {
        transition: transform 0.3s ease;
    }

    .team-carousel__nav:hover svg {
        transform: translateX(3px);
    }

    .team-carousel__nav--prev:hover svg {
        transform: translateX(-3px);
    }

    /* Dots Indicator - Modern Style */
    .team-carousel__dots {
        text-align: center;
        margin-top: 35px;
    }

    .dot {
        height: 10px;
        width: 10px;
        margin: 0 6px;
        background-color: #d1d5db;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        position: relative;
    }

    .dot::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: transparent;
        transition: all 0.3s ease;
    }

    .dot:hover::before {
        background: rgba(26, 58, 107, 0.1);
    }

    .dot:hover {
        background-color: #6b7280;
        transform: scale(1.15);
    }

    .dot.active {
        background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%);
        width: 28px;
        border-radius: 5px;
        transform: scale(1);
    }

    .dot.active::before {
        display: none;
    }

    /* Pause on hover */
    .team-carousel-wrapper:hover .team-carousel {
        animation-play-state: paused;
    }

    /* Smooth fade effect on edges */
    .team-carousel-wrapper::before,
    .team-carousel-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 50px;
        width: 60px;
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

    /* Animation improvement */
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .team-slide {
        animation: slideIn 0.6s ease-out;
    }
</style>


<script>
    // Smooth Scroll Handler with Clean URLs
    document.addEventListener('DOMContentLoaded', function() {
        // Handle clicks on navigation links with data-scroll attribute
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[data-scroll]');
            if (link) {
                e.preventDefault();
                const targetId = link.getAttribute('data-scroll');
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    // Smooth scroll to target
                    const headerOffset = 100; // Account for sticky header
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });

                    // Clean the URL (remove any hash)
                    history.pushState('', document.title, window.location.pathname);
                }
            }
        });

        // Handle URL hash on page load (if someone uses direct link with hash)
        function handleHashOnLoad() {
            const hash = window.location.hash;
            if (hash) {
                const targetId = hash.substring(1); // Remove the # symbol
                const targetElement = document.getElementById(targetId);

                if (targetElement) {
                    setTimeout(() => {
                        const headerOffset = 100;
                        const elementPosition = targetElement.getBoundingClientRect().top;
                        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        // Clean the URL after scrolling
                        setTimeout(() => {
                            history.pushState('', document.title, window.location.pathname);
                        }, 100);
                    }, 100);
        handleHashOnLoad();
    });
</script>

<!-- Jam Operasional Lab Section -->
<section class="jam-operasional-section" style="padding: 80px 0; background: linear-gradient(135deg, #f8f9fa 0%, #e8eef4 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/clock.png" alt="Jam Operasional" class="sec-title__img">Jam Operasional</h6>
                    <h3 class="sec-title__title">Waktu Operasional Laboratorium</h3>
                </div>
            </div>
        </div>
        
        <div class="row justify-content-center" style="margin-top: 40px;">
            <div class="col-lg-8">
                <div class="jam-operasional-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms" style="background: white; padding: 40px; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <div style="display: flex; flex-direction: column; gap: 25px;">
                        <!-- Hari Kerja -->
                        <div style="display: flex; align-items: center; gap: 25px; padding: 20px; background: linear-gradient(135deg, rgba(26, 58, 107, 0.05) 0%, rgba(45, 90, 158, 0.05) 100%); border-radius: 10px; border-left: 4px solid #1a3a6b;">
                            <div style="flex-shrink: 0; width: 60px; height: 60px; background: linear-gradient(135deg, #1a3a6b 0%, #2d5a9e 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(26, 58, 107, 0.2);">
                                <i class="icon-clock1" style="font-size: 28px; color: white;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h5 style="color: #1a3a6b; font-size: 18px; font-weight: 700; margin: 0 0 8px 0;">Senin - Jumat</h5>
                                <p style="color: #444; font-size: 16px; margin: 0; font-weight: 500;">08.00 - 16.00 WIB</p>
                            </div>
                        </div>
                        
                        <!-- Akhir Pekan -->
                        <div style="display: flex; align-items: center; gap: 25px; padding: 20px; background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(220, 53, 69, 0.05) 100%); border-radius: 10px; border-left: 4px solid #dc3545;">
                            <div style="flex-shrink: 0; width: 60px; height: 60px; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(220, 53, 69, 0.2);">
                                <i class="icon-clock1" style="font-size: 28px; color: white;"></i>
                            </div>
                            <div style="flex: 1;">
                                <h5 style="color: #dc3545; font-size: 18px; font-weight: 700; margin: 0 0 8px 0;">Sabtu - Minggu</h5>
                                <p style="color: #444; font-size: 16px; margin: 0; font-weight: 500;">Tutup</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Info Tambahan -->
                    <div style="margin-top: 30px; padding-top: 25px; border-top: 2px dashed #e0e0e0;">
                        <div style="display: flex; align-items: flex-start; gap: 15px;">
                            <i class="fas fa-info-circle" style="color: #1a3a6b; font-size: 20px; margin-top: 3px;"></i>
                            <p style="color: #666; font-size: 14px; line-height: 1.8; margin: 0;">
                                Untuk keperluan khusus di luar jam operasional, silakan hubungi kami terlebih dahulu melalui email atau telepon yang tertera pada halaman kontak.
                            </p>
                        </div>
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