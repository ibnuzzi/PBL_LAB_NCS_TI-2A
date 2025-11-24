<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>
<?php
// File: /app/views/public/layanan.php
?>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Layanan</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="index.php">Beranda</a></li>
            <li><span>Fasilitas & Layanan</span></li>
            <li><span>Layanan</span></li>
        </ul>
    </div>
</section>

<section class="contact-one">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="contact-one__content">
                    <ul class="list-unstyled contact-one__info">
                        <li class="contact-one__info__item">
                            <div class="contact-one__info__icon">
                                <i class="icon-telephone-call-1"></i>
                            </div>
                            <div class="contact-one__info__content">
                                <p class="contact-one__info__text">Butuh bantuan cepat?</p>
                                <h4 class="contact-one__info__title"><a href="tel:+62341404424">(0341) 404-424</a></h4>
                            </div>
                        </li>
                        <li class="contact-one__info__item">
                            <div class="contact-one__info__icon">
                                <i class="icon-email"></i>
                            </div>
                            <div class="contact-one__info__content">
                                <p class="contact-one__info__text">Kirim email ke lab</p>
                                <h4 class="contact-one__info__title"><a href="mailto:ncs@polinema.ac.id">ncs@polinema.ac.id</a></h4>
                            </div>
                        </li>
                        <li class="contact-one__info__item">
                            <div class="contact-one__info__icon">
                                <i class="icon-pin"></i>
                            </div>
                            <div class="contact-one__info__content">
                                <p class="contact-one__info__text">Lokasi Lab</p>
                                <h4 class="contact-one__info__title"><a href="#">Gedung JTI, Polinema</a></h4>
                            </div>
                        </li>
                    </ul>

                    <div class="contact-one__content__thumb">
                        <img src="<?php echo BASE_URL; ?>/assets/images/resources/man-contact.png" alt="laboix">
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="contact-one__left">
                    <div class="contact-one__top">
                        <div class="sec-title wow fadeInUp animated" data-wow-duration="700ms">
                            <h6 class="sec-title__tagline">
                                <img src="<?php echo BASE_URL; ?>/assets/images/shapes/sec-title-s-1.png" alt="Contact" class="sec-title__img">
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


<section class="blog-one" style="background-color: #f4f6f9; padding-top: 80px; padding-bottom: 80px;">
    <div class="container">
        <div class="sec-title text-center">
            <h6 class="sec-title__tagline">Arsip Konsultasi</h6>
            <h3 class="sec-title__title">Diskusi & Solusi Terbaru</h3>
        </div>

        <div class="faq-page__accordion laboix-accrodion" data-grp-name="laboix-accrodion">
            <?php foreach ($daftar_konsultasi as $item): ?>
                <div class="col-lg-12">
                    <div class="accrodion" style="background: #fff; margin-bottom: 30px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden;">

                        <div class="accrodion-title" style="padding: 20px 30px; cursor: pointer;">

                            <h4 class="accrodion-title__text" style="margin: 0; display: flex; justify-content: space-between; align-items: center; width: 95%;">

                                <span style="display: flex; align-items: center; gap: 15px; text-align: left;">

                                    <span style="flex-shrink: 0; width: 50px; height: 50px; background: #ffebee; color: #ff5722; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">Q</span>

                                    <span style="display: block;">
                                        <span style="display: block; font-size: 18px; font-weight: 600; color: #333; line-height: 1.4; margin-bottom: 5px;">
                                            <?php echo htmlspecialchars($item['pertanyaan']); ?>
                                        </span>
                                        <span style="display: block; font-size: 14px; color: #777; font-weight: normal;">
                                            Oleh: <strong><?php echo htmlspecialchars($item['nama_penanya']); ?></strong>
                                            &bull; <?php echo date('d M Y', strtotime($item['tanggal_tanya'])); ?>
                                        </span>
                                    </span>
                                </span>

                                <span class="accrodion-title__icon"></span>
                            </h4>

                        </div>
                        <div class="accrodion-content">
                            <div class="inner" style="padding: 0 30px 30px 30px;">
                                <hr style="border-top: 1px dashed #ddd; margin-top: 0;">
                                <div style="display: flex; gap: 15px; margin-top: 20px; align-items: flex-start;">
                                    <div style="flex-shrink: 0;">
                                        <div style="width: 50px; height: 50px; background: #e8f5e9; color: #4caf50; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 20px;">A</div>
                                    </div>
                                    <div style="background: #f9f9f9; padding: 20px; border-radius: 10px; flex-grow: 1;">
                                        <p style="color: #444; line-height: 1.6; margin-bottom: 10px;">
                                            <?php echo nl2br(htmlspecialchars($item['jawaban'])); ?>
                                        </p>
                                        <span style="font-size: 13px; font-weight: 700; color: #1a237e;">
                                            <i class="fas fa-user-shield"></i> Dijawab oleh Tim Lab NCS
                                        </span>
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

<?php
include 'app/views/templates/public/footer.php';
include 'app/views/templates/public/scripts.php';
?>