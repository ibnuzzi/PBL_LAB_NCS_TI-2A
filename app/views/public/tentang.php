<?php
// tentang.php - Tentang Kami Page
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';

// Ensure pengelola data is available
if (!isset($pengelolaList)) {
    $pengelolaList = [];
}
?>
<!-- Load extracted CSS for team carousel (sama dengan home.php) -->
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/lab-ncs-home.css?v=<?= filemtime(__DIR__ . '/../../../public/css/lab-ncs-home.css') ?>">

<!-- Page Header -->
<section class="page-header">
    <div class="page-header__bg page-header__bg-custom"></div>
    <div class="container">
        <h2 class="page-header__title">Tentang Kami</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Tentang Kami</span></li>
        </ul>
    </div>
</section>

<!-- Sejarah Lab Section -->
<section class="about-two section-scroll-offset" id="sejarah">
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

<!-- Visi & Misi Section -->
<section class="visi-misi-section section-scroll-offset" id="visi-misi">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/determined.png" alt="Visi & Misi" class="sec-title__img">Visi & Misi</h6>
                    <h3 class="sec-title__title">Arah dan Tujuan Laboratorium</h3>
                </div>
            </div>
        </div>

        <div class="row row--mt-40">
            <!-- Visi -->
            <div class="col-lg-12">
                <div class="visi-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                    <div class="visi-card__inner">
                        <div class="visi-card__icon">
                            <i class="fas fa-bullseye visi-misi-icon-large"></i>
                        </div>
                        <div class="visi-card__content">
                            <h4 class="visi-card__title">Visi</h4>
                            <p class="visi-card__text">Menjadi laboratorium unggulan dalam bidang jaringan dan keamanan siber yang inovatif, adaptif, dan berdaya saing global, serta mendukung pengembangan pendidikan, penelitian, dan pengabdian masyarakat di bidang Teknologi Informasi.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Misi -->
            <div class="col-lg-12">
                <div class="misi-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="400ms">
                    <div class="misi-card__inner">
                        <div class="misi-card__icon">
                            <i class="fas fa-rocket visi-misi-icon-large"></i>
                        </div>
                        <div class="misi-card__content">
                            <h4 class="misi-card__title">Misi</h4>
                            <ul class="misi-list">
                                <li>
                                    <div class="misi-list__icon">
                                        <i class="fas fa-check"></i>
                                    </div>
                                    <p class="misi-list__text">Menyelenggarakan kegiatan praktikum yang berkualitas untuk menghasilkan lulusan dengan kompetensi tinggi di bidang jaringan komputer dan keamanan siber.</p>
                                </li>
                                <li class="misi-list-item">
                                    <div class="misi-icon-container">
                                        <i class="fas fa-check misi-icon-check"></i>
                                    </div>
                                    <p class="misi-text">Mengembangkan penelitian terapan dalam bidang jaringan, keamanan sistem, Internet of Things (IoT), serta teknologi monitoring yang relevan dengan kebutuhan industri dan masyarakat.</p>
                                </li>
                                <li class="misi-list-item">
                                    <div class="misi-icon-container">
                                        <i class="fas fa-check misi-icon-check"></i>
                                    </div>
                                    <p class="misi-text">Menyediakan layanan uji keamanan, pendampingan, serta pelatihan bagi civitas akademika maupun mitra eksternal melalui kerja sama dengan industri, pemerintah, dan lembaga lainnya.</p>
                                </li>
                                <li class="misi-list-item">
                                    <div class="misi-icon-container">
                                        <i class="fas fa-check misi-icon-check"></i>
                                    </div>
                                    <p class="misi-text">Meningkatkan kapasitas dosen, teknisi, dan asisten laboratorium dalam menguasai teknologi terkini melalui pelatihan, sertifikasi, dan partisipasi aktif dalam komunitas profesional.</p>
                                </li>
                                <li class="misi-list-item" style="margin-bottom: 0;">
                                    <div class="misi-icon-container">
                                        <i class="fas fa-check misi-icon-check"></i>
                                    </div>
                                    <p class="misi-text">Mendukung peningkatan literasi keamanan digital masyarakat melalui workshop, seminar, dan program pengabdian berbasis teknologi informasi.</p>
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
<section class="team-one team-one--home struktur-section section-scroll-offset" id="struktur">
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

<!-- Jam Operasional Lab Section -->
<section class="jam-operasional-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline"><i class="icon-clock1 jam-operasional-icon-small"></i>JAM OPERASIONAL</h6>
                    <h3 class="sec-title__title">Waktu Operasional Laboratorium</h3>
                </div>
            </div>
        </div>

        <div class="row justify-content-center row--mt-40">
            <div class="col-lg-8">
                <div class="jam-operasional-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms">
                    <div class="schedule-container">
                        <!-- Hari Kerja -->
                        <div class="schedule-item--weekday">
                            <div class="schedule-icon">
                                <i class="icon-clock1 jam-operasional-icon-large"></i>
                            </div>
                            <div class="schedule-content">
                                <h5 class="schedule-day">Senin - Jumat</h5>
                                <p class="schedule-time">08.00 - 16.00 WIB</p>
                            </div>
                        </div>

                        <!-- Akhir Pekan -->
                        <div class="schedule-item--weekend">
                            <div class="schedule-icon">
                                <i class="icon-clock1 jam-operasional-icon-large"></i>
                            </div>
                            <div class="schedule-content">
                                <h5 class="schedule-day">Sabtu - Minggu</h5>
                                <p class="schedule-time">Tutup</p>
                            </div>
                        </div>
                    </div>

                    <!-- Info Tambahan -->
                    <div class="schedule-info">
                        <div class="schedule-info__inner">
                            <i class="fas fa-info-circle schedule-info__icon"></i>
                            <p class="schedule-info__text">
                                Untuk keperluan khusus di luar jam operasional, silakan hubungi kami terlebih dahulu melalui email atau telepon yang tertera pada kontak dibawah.
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