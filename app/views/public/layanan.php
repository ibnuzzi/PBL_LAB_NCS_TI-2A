<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Layanan</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="<?= BASE_URL ?>">Beranda</a></li>
            <li><span>Layanan</span></li>
            <li><span>Konsultasi</span></li>
        </ul>
    </div>
</section>

<section class="contact-one">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact-one__content">
                    <ul class="list-unstyled contact-one__info">
                        <li class="contact-one__info__item" style="display: flex; align-items: center;">
                            <div class="contact-one__info__icon" style="display: flex; align-items: center; justify-content: center;">
                                <i class="icon-telephone-call-1"></i>
                            </div>
                            <div class="contact-one__info__content" style="display: flex; flex-direction: column; justify-content: center;">
                                <p class="contact-one__info__text">Butuh bantuan cepat?</p>
                                <h4 class="contact-one__info__title"><a href="tel:+62341404424">(0341) 404-424</a></h4>
                            </div>
                        </li>
                        <li class="contact-one__info__item" style="display: flex; align-items: center;">
                            <div class="contact-one__info__icon" style="display: flex; align-items: center; justify-content: center;">
                                <i class="icon-email"></i>
                            </div>
                            <div class="contact-one__info__content" style="display: flex; flex-direction: column; justify-content: center;">
                                <p class="contact-one__info__text">Kirim email ke lab</p>
                                <h4 class="contact-one__info__title"><a href="mailto:ncs@polinema.ac.id">ncs@polinema.ac.id</a></h4>
                            </div>
                        </li>
                        <li class="contact-one__info__item" style="display: flex; align-items: center;">
                            <div class="contact-one__info__icon" style="display: flex; align-items: center; justify-content: center;">
                                <i class="icon-pin"></i>
                            </div>
                            <div class="contact-one__info__content" style="display: flex; flex-direction: column; justify-content: center;">
                                <p class="contact-one__info__text">Lokasi Lab</p>
                                <h4 class="contact-one__info__title"><a href="https://maps.app.goo.gl/5FQfTFnQqJ4Va5mKA" target="_blank">Gedung JTI, Polinema</a></h4>
                            </div>
                        </li>
                    </ul>

                    <div class="contact-one__content__thumb">
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-one__left">
                    <div class="contact-one__top">
                        <div class="sec-title wow fadeInUp animated" data-wow-duration="700ms">
                            <h6 class="sec-title__tagline">
                                <i class="icon-chat" style="margin-right: 8px; font-size: 18px; color: #0EBD66;"></i>
                                Konsultasi Online
                            </h6>
                            <h3 class="sec-title__title">Ajukan Pertanyaan Keamanan</h3>
                        </div>
                    </div>

                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div style="background-color: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #c3e6cb;">
                            <?php echo $_SESSION['flash_message'];
                            unset($_SESSION['flash_message']); ?>
                        </div>
                    <?php endif; ?>

                    <form class="contact-one__form contact-form-validated form-one background-base wow fadeInUp animated"
                        data-wow-duration="1500ms"
                        action="<?php echo BASE_URL; ?>/layanan/store"
                        method="POST">

                        <div class="form-one__group">
                            <div class="form-one__control">
                                <input type="text" name="nama_penanya" placeholder="Nama Lengkap Anda" required>
                            </div>
                            <div class="form-one__control">
                                <input type="email" name="email_penanya" placeholder="Alamat Email" required>
                            </div>
                            <div class="form-one__control form-one__control--full">
                                <textarea name="pertanyaan" placeholder="Tulis detail masalah atau pertanyaan keamanan Anda..." required></textarea>
                            </div>
                            <div class="form-one__control form-one__control--full">
                                <button type="submit" class="laboix-btn laboix-btn--submit">Kirim Pertanyaan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="blog-one" style="background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%); padding-top: 80px; padding-bottom: 80px;">
    <div class="container">
        <div class="sec-title text-center" style="margin-bottom: 60px;">
            <h6 class="sec-title__tagline" style="color: #0EBD66; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Arsip Konsultasi</h6>
            <h3 class="sec-title__title" style="font-size: 36px; font-weight: 700; color: #1a3a6b;">Diskusi & Solusi Terbaru</h3>
        </div>

        <div class="faq-page__accordion laboix-accrodion" data-grp-name="laboix-accrodion">
            <?php foreach ($daftar_konsultasi as $item): ?>
                <div class="col-lg-12" style="margin-bottom: 20px;">
                    <div class="accrodion" style="background: #fff; border-radius: 20px; box-shadow: 0 8px 30px rgba(0,0,0,0.08); overflow: hidden; transition: all 0.3s ease; border: 1px solid rgba(0,0,0,0.05);">

                        <div class="accrodion-title" style="padding: 25px 50px; cursor: pointer; transition: background 0.3s ease;">

                            <h4 class="accrodion-title__text" style="margin: 0; display: flex; align-items: center; gap: 8px;">

                                <!-- Button + di KIRI (SHIFTED MORE LEFT) -->
                                <span class="accrodion-title__icon" style="flex-shrink: 0; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 50%; transition: background 0.3s ease, color 0.3s ease; margin-left: -5px;">
                                    <i class="fas fa-plus" style="font-size: 14px; color: #495057;"></i>
                                </span>

                                <!-- Konten Question -->
                                <span style="display: flex; align-items: center; gap: 20px; text-align: left; flex: 1;">

                                    <span style="flex-shrink: 0; width: 55px; height: 55px; background: linear-gradient(135deg, #ffebee 0%, #ffcdd2 100%); color: #ff5722; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 22px; box-shadow: 0 4px 15px rgba(255, 87, 34, 0.2);">Q</span>

                                    <span style="display: block; flex: 1;">
                                        <span style="display: block; font-size: 18px; font-weight: 600; color: #1a3a6b; line-height: 1.5; margin-bottom: 8px;">
                                            <?php echo htmlspecialchars($item['pertanyaan']); ?>
                                        </span>
                                        <span style="display: flex; align-items: center; font-size: 13px; color: #6c757d; font-weight: 400; gap: 5px;">
                                            <span>Oleh: <strong style="color: #495057;"><?php echo htmlspecialchars($item['nama_penanya']); ?></strong></span>
                                            <span style="color: #adb5bd;">•</span>
                                            <span style="color: #6c757d;"><?php echo date('d M Y, H:i', strtotime($item['tanggal_tanya'])); ?> WIB</span>
                                        </span>
                                    </span>
                                </span>
                            </h4>

                        </div>

                        <div class="accrodion-content">
                            <div class="inner" style="padding: 0 30px 30px 30px;">
                                <hr style="border: none; border-top: 2px dashed #e9ecef; margin: 0 0 25px 0;">
                                <div style="display: flex; gap: 20px; align-items: flex-start;">
                                    <div style="flex-shrink: 0;">
                                        <div style="width: 55px; height: 55px; background: linear-gradient(135deg, #e8f5e9 0%, #c8e6c9 100%); color: #4caf50; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 22px; box-shadow: 0 4px 15px rgba(76, 175, 80, 0.2);">A</div>
                                    </div>
                                    <div style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); padding: 25px; border-radius: 15px; flex-grow: 1; border-left: 4px solid #4caf50;">
                                        <p style="color: #495057; line-height: 1.8; margin-bottom: 15px; font-size: 15px;">
                                            <?php echo nl2br(htmlspecialchars($item['jawaban'])); ?>
                                        </p>
                                        <div style="display: flex; align-items: center; gap: 8px; padding-top: 12px; border-top: 1px solid #dee2e6;">
                                            <i class="fas fa-user-shield" style="color: #1a3a6b; font-size: 14px;"></i>
                                            <span style="font-size: 13px; font-weight: 600; color: #1a3a6b;">
                                                Dijawab oleh Tim Lab NCS
                                            </span>
                                            <span style="color: #adb5bd;">•</span>
                                            <span style="font-size: 13px; font-weight: 500; color: #6c757d;">
                                                <?php echo date('d M Y, H:i', strtotime($item['tanggal_jawab'])); ?> WIB
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<style>
    /* Hover effects */
    .accrodion:hover {
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12) !important;
        transform: translateY(-3px);
    }

    .accrodion-title:hover {
        background: #f8f9fa;
    }

    /* Active state untuk accordion - NO TRANSFORM */
    .accrodion.active .accrodion-title__icon {
        background: #0EBD66 !important;
    }

    .accrodion.active .accrodion-title__icon i {
        color: #fff !important;
    }

    /* Content hidden by default - jQuery handles animation */
    .accrodion-content {
        display: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .accrodion-title h4 span:nth-child(2) {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px !important;
        }

        .sec-title__title {
            font-size: 28px !important;
        }

        .accrodion-title {
            padding: 20px 20px !important;
        }

        .accrodion-content .inner {
            padding: 0 20px 20px 20px !important;
        }

        .accrodion-content .inner>div {
            flex-direction: column;
        }
    }
</style>

<!-- Maps Section -->
<section class="contact-map-section">
    <div class="container">
        <div class="map-card-wrapper">
            <!-- Card Header -->
            <div class="map-card-header">
                <div class="map-card-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <div class="map-card-info">
                    <h3 class="map-card-title">Lokasi Konsultasi Offline</h3>
                    <p class="map-card-subtitle">Kunjungi Lab NCS untuk konsultasi langsung dengan tim kami</p>
                </div>
            </div>

            <!-- Map Body -->
            <div class="map-card-body">
                <div class="google-map google-map__contact">
                    <iframe
                        title="Lokasi Politeknik Negeri Malang - Lab NCS"
                        src="https://maps.google.com/maps?q=-7.943892710794645,112.61450188551729&hl=id&z=19&output=embed"
                        class="map__google-map"
                        allowfullscreen=""
                        loading="lazy">
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

<script src="<?= BASE_URL ?>/public/js/layanan-ajax.js"></script>