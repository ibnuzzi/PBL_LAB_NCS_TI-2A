<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Berita & Artikel</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="index.php">Beranda</a></li>
            <li><span>Berita</span></li>
        </ul>
    </div>
</section>

<section class="blog-one pt-120 pb-120">
    <div class="container">
        <div class="row gutter-y-30">
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

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>