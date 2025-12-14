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
                            <img src="public/assets/images/about/about-2-1.png?v=<?= time() ?>" alt="Lab NCS" style="max-width: 550px; width: 100%; height: auto; object-fit: contain;">
                        </div>
                        <div class="about-two__thumb__item about-two__thumb__item--two" style="margin-top: -50px;">
                            <img src="public/assets/images/about/about-s-2-1.png?v=<?= time() ?>" alt="laboix" style="max-width: 350px; width: 100%; height: auto; object-fit: contain;">
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
                        <p class="about-two__top__text">Selain menjadi sarana pembelajaran mahasiswa, Laboratorium Jaringan & Keamanan Siber juga berperan sebagai wadah penelitian dan inovasi bagi dosen maupun mahasiswa dalam mengkaji solusi di bidang keamanan jaringan, pengujian sistem, serta perlindungan data dan infrastruktur digital. Peran laboratorium ini diharapkan mampu memperkuat kualitas pembelajaran, memperdalam riset di bidang jaringan komputer dan keamanan informasi, serta mendukung terciptanya lulusan yang kompeten di bidang administrasi jaringan dan keamanan siber.</p>
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
</section>
<!-- Tim Kami section End -->
<!-- CSS and JavaScript moved to: lab-ncs-home.css and lab-ncs-home-carousel.js -->

<!-- Galeri Lab Section -->
<section class="gallery-section section-scroll-offset" id="galeri" style="padding: 100px 0; background: #f8fafc;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/science.png" alt="Galeri" class="sec-title__img">Galeri Laboratorium</h6>
                    <h3 class="sec-title__title">Fasilitas & Kegiatan Lab NCS</h3>
                </div>
            </div>
        </div>

        <div class="row g-4 mt-4">
            <div class="col-lg-4 col-md-6">
                <div class="gallery-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="100ms" style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <img src="public/assets/images/gallery/galerilab-1.jpg" alt="Ruangan Lab NCS" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.4s ease;">
                    <div style="padding: 20px; background: #fff;">
                        <h5 style="color: #1e3a5f; font-weight: 600; margin-bottom: 8px;">Ruangan Laboratorium</h5>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">Area kerja dan praktikum mahasiswa</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="gallery-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="200ms" style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <img src="public/assets/images/gallery/galerilab-2.jpg" alt="Peralatan Lab" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.4s ease;" onerror="this.src='public/assets/images/blog/blog-1-1.png'">
                    <div style="padding: 20px; background: #fff;">
                        <h5 style="color: #1e3a5f; font-weight: 600; margin-bottom: 8px;">Peralatan Jaringan</h5>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">Router, switch, dan firewall untuk praktik</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="gallery-card wow fadeInUp" data-wow-duration="700ms" data-wow-delay="300ms" style="border-radius: 16px; overflow: hidden; box-shadow: 0 8px 24px rgba(0,0,0,0.1); transition: all 0.3s ease;">
                    <img src="public/assets/images/gallery/galerilab-3.jpg" alt="Server Room" style="width: 100%; height: 250px; object-fit: cover; transition: transform 0.4s ease;" onerror="this.src='public/assets/images/blog/blog-1-2.png'">
                    <div style="padding: 20px; background: #fff;">
                        <h5 style="color: #1e3a5f; font-weight: 600; margin-bottom: 8px;">Server & Workstation</h5>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">Infrastruktur komputasi untuk riset</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="<?= BASE_URL ?>/galeri" class="btn-publikasi">Lihat Semua Galeri <i class="icon-arrow"></i></a>
            </div>
        </div>
    </div>
    <style>
        .gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.15) !important;
        }

        .gallery-card:hover img {
            transform: scale(1.08);
        }
    </style>
</section>

<!-- Lokasi & Jam Operasional Section -->
<section class="contact-map-section section-scroll-offset" id="lokasi" style="padding: 80px 0;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline"><i class="fas fa-map-marker-alt" style="margin-right: 8px; color: #2563eb;"></i>Lokasi & Jam Operasional</h6>
                    <h3 class="sec-title__title">Kunjungi Laboratorium NCS</h3>
                </div>
            </div>
        </div>

        <div class="map-card-wrapper" style="margin-top: 50px;">
            <!-- Card Header -->
            <div class="map-card-header">
                <div class="map-card-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="map-card-info">
                    <h3 class="map-card-title">Lab Network & Cyber Security</h3>
                    <p class="map-card-subtitle">Kunjungi Lab NCS untuk konsultasi langsung dengan tim kami</p>
                </div>
            </div>

            <!-- Map Body -->
            <div class="map-card-body">
                <div class="google-map google-map__contact">
                    <iframe
                        title="Lokasi Politeknik Negeri Malang - Lab NCS"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d987.8349414618897!2d112.61420193680518!3d-7.943949139693553!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7882839b88a2a7%3A0xb7ebae5a9e8f8e70!2sGedung%20Teknik%20Sipil%2C%20Teknik%20Informatika%20%26...!5e0!3m2!1sid!2sid!4v1702656000000!5m2!1sid!2sid"
                        class="map__google-map"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    <!-- Overlay Info -->
                    <div class="map-overlay-info">
                        <p class="map-address-text">
                            <i class="fas fa-map-marked-alt" style="color: #1a3a6b; margin-right: 8px;"></i>
                            <strong>Lab Network & Cyber Security</strong><br>
                            Gedung JTI, Politeknik Negeri Malang<br>
                            Jl. Soekarno Hatta No.9, Mojolangu<br>
                            Kec. Lowokwaru, Jawa Timur 65141
                        </p>

                        <!-- Jam Operasional dalam Overlay -->
                        <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed #e0e0e0;">
                            <p style="margin: 0 0 8px 0; font-size: 14px; font-weight: 600; color: #1a3a6b;">
                                <i class="fas fa-clock" style="margin-right: 8px; color: #2563eb;"></i>Jam Operasional
                            </p>
                            <p style="margin: 0; font-size: 13px; color: #666;">
                                <span style="display: inline-block; width: 100px;">Senin - Jumat</span>
                                <span style="color: #10b981; font-weight: 600;">08.00 - 16.00 WIB</span><br>
                                <span style="display: inline-block; width: 100px;">Sabtu - Minggu</span>
                                <span style="color: #ef4444; font-weight: 600;">Tutup</span>
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