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
                                    <a href="about.php" class="laboix-btn">Pelajari Lebih Lanjut</a>
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
                            <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/science.png" alt="Tentang Kami" class="sec-title__img">Tentang Kami</h6><h3 class="sec-title__title">PROFIL LABORATORIUM</h3></div><p class="about-two__top__text">Unit penunjang akademik di Jurusan Teknologi Informasi yang difokuskan pada pengembangan kompetensi di bidang jaringan komputer dan keamanan siber. Laboratorium ini mendukung kegiatan praktikum, penelitian, dan pengembangan yang berkaitan dengan administrasi jaringan, pengamanan infrastruktur, pemantauan lalu lintas data, hingga penerapan teknologi keamanan informasi dalam melindungi aset digital organisasi.</p>
                            Selain menjadi sarana pembelajaran mahasiswa, Laboratorium Jaringan & Keamanan Siber juga berperan sebagai wadah penelitian dan inovasi bagi dosen maupun mahasiswa dalam mengkaji solusi di bidang keamanan jaringan, pengujian sistem, serta perlindungan data dan infrastruktur digital. Peran laboratorium ini diharapkan mampu memperkuat kualitas pembelajaran, memperdalam riset di bidang jaringan komputer dan keamanan informasi, serta mendukung terciptanya lulusan yang kompeten di bidang administrasi jaringan dan keamanan siber.</p>
                    </div>

                    <div class="about-two__feature wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                        <div class="about-two__feature__item">
                            <div class="about-two__feature__icon">
                                <i class="icon-accuracy-1"></i>
                            </div>
                            <h4 class="about-two__feature__title"><a >Fokus Riset Laboratorium</a></h4>
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

        <!-- Team Carousel -->
        <div class="team-carousel-wrapper">
            <div class="team-carousel">
                <!-- Team Member 1 -->
                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/Erfan-Rohadi.jpg" alt="Erfan Rohadi">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/erfan-rohadi-st-m-eng-ph-d/" target="_blank">Erfan Rohadi, ST., M.Eng., Ph.D.</a></h3>
                                        <h6 class="team-card__content__designation">Kepala Lab</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/adeismail.jpg" alt="Ade Ismail">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/ade-ismail-s-kom-m-ti/" target="_blank">Ade Ismail, S.Kom., M.TI</a></h3>
                                        <h6 class="team-card__content__designation">Peneliti</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/Sofyan-Noor-Arief.jpg" alt="Sofyan Noor Arief">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/sofyan-noor-arief-s-st-m-kom/" target="_blank">Sofyan Noor Arief, S.ST., M.Kom.</a></h3>
                                        <h6 class="team-card__content__designation">Peneliti</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/Vipkas-Al-Hadid-Firdaus.jpg" alt="Vipkas Al Hadid Firdaus">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/vipkas-al-hadid-firdaus-st-mt/" target="_blank">Vipkas Al Hadid Firdaus, ST,. MT</a></h3>
                                        <h6 class="team-card__content__designation">Peneliti</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 5 -->
                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/MeytiEka.jpg" alt="Meyti Eka Apriyani">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/meyti-eka-apriyani-st-mt/" target="_blank">Meyti Eka Apriyani ST., MT.</a></h3>
                                        <h6 class="team-card__content__designation">Peneliti</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Duplicate slides for infinite loop -->
                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/Erfan-Rohadi.jpg" alt="Erfan Rohadi">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/erfan-rohadi-st-m-eng-ph-d/" target="_blank">Erfan Rohadi, ST., M.Eng., Ph.D.</a></h3>
                                        <h6 class="team-card__content__designation">Kepala Lab</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/adeismail.jpg" alt="Ade Ismail">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/ade-ismail-s-kom-m-ti/" target="_blank">Ade Ismail, S.Kom., M.TI</a></h3>
                                        <h6 class="team-card__content__designation">Peneliti</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="team-slide">
                    <div class="team-card">
                        <div class="team-card__inner">
                            <div class="team-card__image">
                                <img src="public/assets/images/team/Sofyan-Noor-Arief.jpg" alt="Sofyan Noor Arief">
                            </div>
                            <div class="team-card__content">
                                <div class="team-card__content__inner">
                                    <div class="team-card__content__item">
                                        <h3 class="team-card__content__title"><a href="https://jti.polinema.ac.id/sofyan-noor-arief-s-st-m-kom/" target="_blank">Sofyan Noor Arief, S.ST., M.Kom.</a></h3>
                                        <h6 class="team-card__content__designation">Peneliti</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation Arrows -->
            <button class="team-carousel__nav team-carousel__nav--prev" onclick="moveCarousel(-1)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
            </button>
            <button class="team-carousel__nav team-carousel__nav--next" onclick="moveCarousel(1)">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </button>

            <!-- Dots Indicator -->
            <div class="team-carousel__dots">
                <span class="dot active" onclick="currentSlide(0)"></span>
                <span class="dot" onclick="currentSlide(1)"></span>
                <span class="dot" onclick="currentSlide(2)"></span>
                <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
            </div>
        </div>
    </div>
</section>
<!-- Tim Kami section End -->

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
    background: linear-gradient(to right, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
}

.team-carousel-wrapper::after {
    right: 0;
    background: linear-gradient(to left, rgba(255,255,255,1) 0%, rgba(255,255,255,0) 100%);
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
let currentIndex = 0;
let autoSlideInterval;
const totalSlides = 5;
const carousel = document.querySelector('.team-carousel');
const dots = document.querySelectorAll('.dot');

function updateCarousel() {
    const slideWidth = document.querySelector('.team-slide').offsetWidth + 25;
    carousel.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex % totalSlides);
    });
}

function moveCarousel(direction) {
    currentIndex += direction;
    
    if (currentIndex >= totalSlides) {
        currentIndex = 0;
    } else if (currentIndex < 0) {
        currentIndex = totalSlides - 1;
    }
    
    updateCarousel();
    resetAutoSlide();
}

function currentSlide(index) {
    currentIndex = index;
    updateCarousel();
    resetAutoSlide();
}

function autoSlide() {
    currentIndex++;
    if (currentIndex >= totalSlides) {
        currentIndex = 0;
    }
    updateCarousel();
}

function startAutoSlide() {
    autoSlideInterval = setInterval(autoSlide, 5000);
}

function resetAutoSlide() {
    clearInterval(autoSlideInterval);
    startAutoSlide();
}

document.addEventListener('DOMContentLoaded', function() {
    updateCarousel();
    startAutoSlide();
    
    const wrapper = document.querySelector('.team-carousel-wrapper');
    wrapper.addEventListener('mouseenter', () => clearInterval(autoSlideInterval));
    wrapper.addEventListener('mouseleave', startAutoSlide);
});

window.addEventListener('resize', updateCarousel);
</script>

<!-- Roadmap section start -->
<section class="our-work">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='700ms'>
                    <h6 class="sec-title__tagline"><img src="public/assets/images/shapes/determined.png" alt="Roadmap Penelitian" class="sec-title__img">Roadmap Penelitian</h6><h3 class="sec-title__title">Alur Riset Mahasiswa di Lab NCS: <br> Empat Tahap Utama</h3></div></div>
                </div>
            <div class="row gutter-y-30">
                <div class="col-lg-3 col-md-6">
                    <div class="our-work__item">
                        <div class="our-work__item__step"></div>
                        <div class="our-work__item__content">
                            <h4 class="our-work__item__title"><a >Pengajuan Ide <br> dan Proposal Riset</a></h4>
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
                            <h4 class="our-work__item__title"><a >Validasi Dosen dan <br>Pembentukan Tim Bimbingan</a></h4>
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
                            <h4 class="our-work__item__title"><a >Pelaksanaan Eksperimen <br> dan Pengujian Lapangan</a></h4>
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
                            <h4 class="our-work__item__title"><a >Penyusunan Laporan <br>dan Diseminasi Hasil</a></h4>
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
                    <h3 class="sec-title__title">Sorotan Publikasi</h3>
                </div>
            </div>
        </div>
        <ul class="case-studies__list list-unstyled">
            <li class="case-studies__list__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="500ms">
                <div class="case-studies__list__item__content">
                    <div class="case-studies__list__item__thumb">
                        <img src="public/assets/images/resources/case-stady-1-1.png" alt="laboix">
                    </div>
                    <div class="case-studies__list__item__hover">
                        <h4 class="case-studies__list__item__title"><a>Variations in chlorophyll-a concentration and the impact on Sardinella lemuru catches in Bali Strait, Indonesia</a></h4>
                        <p class="case-studies__list__item__text">2010</p>
                    </div>
                </div>
            </li>
            <li class="case-studies__list__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="600ms">
                <div class="case-studies__list__item__content">
                    <div class="case-studies__list__item__thumb">
                        <img src="public/assets/images/resources/case-stady-1-2.png" alt="laboix">
                    </div>
                    <div class="case-studies__list__item__hover">
                        <h4 class="case-studies__list__item__title"><a>Implementation IoT in system monitoring hydroponic plant water circulation and control</a></h4>
                        <p class="case-studies__list__item__text">2018</p>
                    </div>
                </div>
            </li>
            <li class="case-studies__list__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="700ms">
                <div class="case-studies__list__item__content">
                    <div class="case-studies__list__item__thumb">
                        <img src="public/assets/images/resources/case-stady-1-3.png" alt="laboix">
                    </div>
                    <div class="case-studies__list__item__hover">
                        <h4 class="case-studies__list__item__title"><a>Sistem Monitoring Budidaya Ikan Lele Berbasis Internet Of Things Menggunakan Raspberry Pi</a></h4>
                        <p class="case-studies__list__item__text">2018</p>
                    </div>
                </div>
            </li>
            <li class="case-studies__list__item wow fadeInUp" data-wow-duration="700ms" data-wow-delay="800ms">
                <div class="case-studies__list__item__content">
                    <div class="case-studies__list__item__thumb">
                        <img src="public/assets/images/resources/case-stady-1-4.png" alt="laboix">
                    </div>
                    <div class="case-studies__list__item__hover">
                        <h4 class="case-studies__list__item__title"><a>Internet of Things integration in smart grid</a></h4>
                        <p class="case-studies__list__item__text">2018</p>
                    </div>
                </div>
            </li>
        </ul>
        <div class="text-center wow fadeInUp" data-wow-duration="1700ms" data-wow-delay="700ms" style="margin-top: 50px; margin-bottom: 30px;">
            <a href="blog-details.php" class="btn-publikasi">
                Baca Selengkapnya <i class="icon-arrow"></i>
            </a>
        </div>
    </div>
</section>

<style>
/* Styling untuk tombol */
.btn-publikasi {
    display: inline-block;
    padding: 12px 30px;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    color: #333;
    background-color: #e0e0e0;
    border: 2px solid #e0e0e0;
    border-radius: 5px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-publikasi:hover {
    background-color: #1a3a6b;
    border-color: #1a3a6b;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(26, 58, 107, 0.3);
}

.btn-publikasi i {
    margin-left: 8px;
    transition: transform 0.3s ease;
}

.btn-publikasi:hover i {
    transform: translateX(5px);
}

/* Styling untuk memperbaiki ukuran teks pada kotak publikasi */
.case-studies__list__item__hover .case-studies__list__item__title {
    font-size: 16px !important;
    line-height: 1.4 !important;
    margin-bottom: 8px !important;
    font-weight: 600 !important;
}

.case-studies__list__item__hover .case-studies__list__item__title a {
    font-size: 16px !important;
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.case-studies__list__item__hover .case-studies__list__item__text {
    font-size: 13px !important;
    color: #666 !important;
    margin-top: 5px !important;
}

/* Perbaikan padding pada hover area */
.case-studies__list__item__hover {
    padding: 15px !important;
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
                    <h3 class="sec-title__title">Mendukung Inovasi Mahasiswa <br> di Bidang Network & Cyber Security</h3>
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
.gutter-y-30 > [class*="col-"] {
    display: flex;
}
</style>
<!-- Fasilitas section End -->

<!-- Video section start -->
<section class="video-cta">
    <div class="video-cta__bg" style="background-image: url(public/assets/images/backgrounds/video-bg.png);"></div>
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
                    <a href="about.php" class="video-cta__link__btn laboix-btn">Gabunglah Menjadi Sang Juara</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Video section End -->

<!-- Berita section start -->
<section class="blog-one">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="sec-title text-center wow fadeInUp" data-wow-duration='1500ms'>
                    <h6 class="sec-title__tagline">
                        <img src="public/assets/images/shapes/science.png" alt="Berita" class="sec-title__img">Berita
                    </h6>
                    <h3 class="sec-title__title">Sorotan Penelitian Terpopuler</h3>
                </div>
            </div>
        </div>
        
        <div class="row gutter-y-30">
            <!-- Blog Card 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='400ms'>
                    <div class="blog-card__image">
                        <div class="blog-card__image__item">
                            <img src="public/assets/images/blog/blog-1-1.png" alt="Analisis Kerentanan Terbaru pada IoT Campus">
                            <a href="blog-details-left.html" class="blog-card__image__link"></a>
                        </div>
                        <div class="blog-card__date">
                            <span class="blog-card__date__day">02</span>NOV
                        </div>
                    </div>
                    <div class="blog-card__content">
                        <div class="blog-card__author">
                        </div>
                        <h3 class="blog-card__title">
                            <a >Analisis Kerentanan Terbaru pada IoT Campus</a>
                        </h3>
                        <div class="blog-card__content__btn">
                            <a href="blog-details-left.html" class="blog-card__content__btn__link">
                                Baca Selengkapnya<i class="icon-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Card 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='600ms'>
                    <div class="blog-card__image">
                        <div class="blog-card__image__item">
                            <img src="public/assets/images/blog/blog-1-2.png" alt="Tim Lab NCS Raih Juara 1 Kompetisi Capture The Flag">
                            <a href="blog-details-center.html" class="blog-card__image__link"></a>
                        </div>
                        <div class="blog-card__date">
                            <span class="blog-card__date__day">12</span>JUN
                        </div>
                    </div>
                    <div class="blog-card__content">
                        <div class="blog-card__author">
                        </div>
                        <h3 class="blog-card__title">
                            <a >Tim Lab NCS Raih Juara 1 Kompetisi Capture The Flag</a>
                        </h3>
                        <div class="blog-card__content__btn">
                            <a href="blog-details-center.html" class="blog-card__content__btn__link">
                                Baca Selengkapnya<i class="icon-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Card 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="blog-card wow fadeInUp" data-wow-duration='1500ms' data-wow-delay='800ms'>
                    <div class="blog-card__image">
                        <div class="blog-card__image__item">
                            <img src="public/assets/images/blog/blog-1-3.png" alt="Publikasi Jurnal: Implementasi Zero Trust di Lingkungan Kampus">
                            <a href="blog-details-right.html" class="blog-card__image__link"></a>
                        </div>
                        <div class="blog-card__date">
                            <span class="blog-card__date__day">03</span>AUG
                        </div>
                    </div>
                    <div class="blog-card__content">
                        <div class="blog-card__author">
                        </div>
                        <h3 class="blog-card__title">
                            <a >Publikasi Jurnal: Implementasi Zero Trust di Lingkungan Kampus</a>
                        </h3>
                        <div class="blog-card__content__btn">
                            <a href="blog-details-right.html" class="blog-card__content__btn__link">
                                Baca Selengkapnya<i class="icon-arrow"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Berita section End -->
<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>