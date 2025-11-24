<header class="main-header sticky-header sticky-header--normal">
    <div class="container-fluid">
        <div class="main-header__inner">
            <div class="main-header__logo logo-laboix">
                <a href="index.php">
                    <img src="public/assets/images/ClearLogoJTI.png" alt="Lab NCS JTI Polinema" width="60">
                </a>
            </div>
            <nav class="main-header__nav main-menu">
                <ul class="main-menu__list">

                    <li>
                        <a href="index.php">Beranda</a>
                    </li>

                    <li class="dropdown">
                        <a href="about.php">Tentang Kami</a>
                        <ul class="sub-menu">
                            <li><a href="about.php#sejarah">Sejarah Lab</a></li>
                            <li><a href="about.php#visi-misi">Visi & Misi</a></li>
                            <li><a href="about.php#struktur-organisasi">Struktur Pengelola</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="riset.php">Akademik & Riset</a>
                        <ul class="sub-menu">
                            <li><a href="riset.php#roadmap">Roadmap Penelitian</a></li>
                            <li><a href="riset.php#penelitian">Penelitian (Publikasi & Proyek)</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="layanan.php">Fasilitas & Layanan</a>
                        <ul class="sub-menu">
                            <li><a href="riset.php#roadmap">Fasilitas</a></li>
                            <li><a href="<?= BASE_URL ?>/layanan">Layanan</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#">Aktivitas</a>
                        <ul class="sub-menu">
                            <li><a href="<?= BASE_URL ?>/galeri">Galeri</a></li>
                            <li><a href="galeri.php">Agenda</a></li>
                            <li><a href="<?= BASE_URL ?>/berita">Berita</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="arsip.php">Arsip</a>
                    </li>

                    <li class="dropdown">
                        <a href="#">Link Terkait</a>
                         <ul class="sub-menu">
                            <li><a href="https://www.polinema.ac.id/" target="_blank">Polinema</a></li>
                            <li><a href="https://jti.polinema.ac.id/" target="_blank">JTI Polinema</a></li>
                            <li><a href="https://sinta.kemdikbud.go.id/" target="_blank">SINTA</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </nav>
            <div class="main-header__right">
                <div class="main-header__link">
                    <a href="<?php echo BASE_URL; ?>/login" class="laboix-btn main-header__btn">Login</a>
                </div>

                <div class="mobile-nav__btn mobile-nav__toggler">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </div>
</header>