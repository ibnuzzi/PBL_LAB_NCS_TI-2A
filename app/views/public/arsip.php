<?php
include 'app/views/templates/public/header.php';
include 'app/views/templates/public/navbar.php';
?>
<style>
    /* 1. Mengubah warna Teks, Link, dan UKURAN FONT */
    .service-sidebar__category__list li a {
        color: #28a745 !important;
        /* Hijau */
        font-size: 18px !important;
        /* UKURAN FONT LEBIH BESAR (Standar biasanya 14-16px) */
        font-weight: 600 !important;
        /* Agak ditebalkan agar lebih terbaca */
        transition: all 0.3s ease;
        display: block;
        /* Agar area klik lebih luas */
        padding: 8px 0;
        /* Memberi jarak antar list agar tidak mepet */
    }

    /* 2. Mengubah warna Icon dan UKURAN ICON */
    .service-sidebar__category__list li a i {
        color: #28a745 !important;
        /* Hijau */
        font-size: 16px !important;
        /* Icon dibuat sedikit lebih besar dari teks */
        margin-right: 12px;
        /* Jarak antara icon dan teks */
        width: 25px;
        /* Menjaga kerapian jika lebar icon berbeda-beda */
        text-align: center;
    }

    /* 3. Efek saat Mouse diarahkan (Hover) */
    .service-sidebar__category__list li a:hover {
        color: #198754 !important;
        /* Hijau Tua */
        background-color: #f0fdf4;
        padding-left: 15px;
        /* Geser lebih jauh sedikit */
        border-radius: 5px;
        text-decoration: none;
        /* Menghilangkan garis bawah jika ada */
    }
</style>

<section class="page-header">
    <div class="page-header__bg" style="background-image: url(public/assets/images/backgrounds/page-header-bg-1-1.jpg);"></div>
    <div class="container">
        <h2 class="page-header__title">Arsip & Dokumen</h2>
        <ul class="nionx-breadcrumb list-unstyled">
            <li><a href="index.php">Beranda</a></li>
            <li><span>Aktivitas</span></li>
            <li><span>Berita</span></li>
        </ul>
    </div>
</section>

<section class="service-details" style="padding: 80px 0; background-color: #f8f9fa;">
    <div class="container">
        <div class="row">

            <div class="col-lg-3">
                <div class="product__sidebar product__sidebar-right">

                    <div class="product__search  wow fadeInUp animated" data-wow-delay="500ms" style="visibility: visible; animation-delay: 500ms; animation-name: fadeInUp;">
                        <form action="#" class="product__sidebar__search">
                            <button type="submit" aria-label="search submit">
                                <span><i class="icon-search"></i></span>
                            </button>
                            <input type="text" placeholder="Cari di sini" fdprocessedid="x2kh0b">
                        </form>
                    </div><!-- /.search-widget -->

                    <div class="product__categories  wow fadeInUp animated" data-wow-delay="900ms" style="visibility: visible; animation-delay: 900ms; animation-name: fadeInUp;">
                        <h3 class="product__categories__title">Categories</h3>
                        <ul class="list-unstyled service-sidebar__category__list">
                            <li><a href="products.html"> <i class="fa fa-folder-open"></i>Semua Dokumen</a></li>
                            <li><a href="products.html"> <i class="fa fa-microscope"></i>Penelitian</a></li>
                            <li><a href="products.html"> <i class="fa fa-hands-helping"></i>Pengabdian</a></li>
                            <li><a href="products.html"> <i class="fa fa-book"></i>Modul Pratikum</a></li>
                            <li><a href="products.html"> <i class="fa fa-file-contract"></i>SOP Laboratorium</a></li>
                        </ul>
                    </div><!-- /.category-widget -->

                </div>
            </div>

            <div class="col-lg-9">
                <div class="service-details__content">

                    <h3 class="service-details__title">Daftar Dokumen Publik</h3>
                    <p class="service-details__text mb-3">Silakan unduh dokumen yang Anda butuhkan. Pastikan Anda login jika dokumen bersifat terbatas.</p>

                    <div class="list-group" style="border: none;">

                        <div class="list-group-item list-group-item-action d-flex align-items-center p-4 mb-3 shadow-sm"
                            style="border: none; border-radius: 10px; background: #fff; transition: transform 0.2s;">

                            <div class="flex-shrink-0 me-4" style="margin-right: 20px;">
                                <div style="width: 60px; height: 60px; background: #ffebee; color: #d32f2f; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                                    <i class="fa fa-file-pdf"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <h5 class="mb-1" style="font-weight: bold; color: #333;">
                                    Analisis Malware Ransomware Varian Baru
                                </h5>
                                <p class="mb-1 text-muted" style="font-size: 14px;">
                                    Studi kasus serangan ransomware pada jaringan lokal dan metode mitigasinya.
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-calendar-alt"></i> 24 Nov 2025 &nbsp;|&nbsp;
                                    <i class="fa fa-tag"></i> Penelitian
                                </small>
                            </div>

                            <div class="ms-3" style="margin-left: 15px;">
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-download"></i> Unduh
                                </a>
                            </div>
                        </div>

                        <div class="list-group-item list-group-item-action d-flex align-items-center p-4 mb-3 shadow-sm"
                            style="border: none; border-radius: 10px; background: #fff; transition: transform 0.2s;">

                            <div class="flex-shrink-0 me-4" style="margin-right: 20px;">
                                <div style="width: 60px; height: 60px; background: #e3f2fd; color: #1976d2; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                                    <i class="fa fa-book"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <h5 class="mb-1" style="font-weight: bold; color: #333;">
                                    Modul Praktikum Keamanan Jaringan (Semester 3)
                                </h5>
                                <p class="mb-1 text-muted" style="font-size: 14px;">
                                    Panduan lengkap konfigurasi Firewall dan VPN untuk mahasiswa TI.
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-calendar-alt"></i> 10 Sep 2025 &nbsp;|&nbsp;
                                    <i class="fa fa-tag"></i> Modul Praktikum
                                </small>
                            </div>

                            <div class="ms-3" style="margin-left: 15px;">
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-download"></i> Unduh
                                </a>
                            </div>
                        </div>

                        <div class="list-group-item list-group-item-action d-flex align-items-center p-4 mb-3 shadow-sm"
                            style="border: none; border-radius: 10px; background: #fff; transition: transform 0.2s;">

                            <div class="flex-shrink-0 me-4" style="margin-right: 20px;">
                                <div style="width: 60px; height: 60px; background: #f3e5f5; color: #7b1fa2; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 28px;">
                                    <i class="fa fa-file-contract"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                <h5 class="mb-1" style="font-weight: bold; color: #333;">
                                    SOP Peminjaman Alat Laboratorium NCS
                                </h5>
                                <p class="mb-1 text-muted" style="font-size: 14px;">
                                    Prosedur standar operasional untuk peminjaman router dan server lab.
                                </p>
                                <small class="text-muted">
                                    <i class="fa fa-calendar-alt"></i> 01 Jan 2025 &nbsp;|&nbsp;
                                    <i class="fa fa-tag"></i> SOP Lab
                                </small>
                            </div>

                            <div class="ms-3" style="margin-left: 15px;">
                                <a href="#" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-download"></i> Unduh
                                </a>
                            </div>
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