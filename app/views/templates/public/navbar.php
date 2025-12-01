<header class="main-header sticky-header sticky-header--normal">
    <div class="container-fluid">
        <div class="main-header__inner" style="display: flex; justify-content: space-between; align-items: center;">

            <div class="main-header__logo logo-laboix" style="flex-shrink: 0;">
                <a href="<?php echo BASE_URL; ?>/">
                    <img src="<?php echo BASE_URL; ?>/public/assets/images/ClearLogoJTI.png" alt="Lab NCS JTI Polinema" width="60">
                </a>
            </div>

            <nav class="main-header__nav main-menu" style="margin: 0 auto;">
                <ul class="main-menu__list">

                    <li>
                        <a href="<?php echo BASE_URL; ?>/">Beranda</a>
                    </li>

                    <li class="dropdown">
                        <a href="<?php echo BASE_URL; ?>/tentang">Tentang Kami</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo BASE_URL; ?>/tentang" data-scroll="sejarah">Sejarah Lab</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/tentang" data-scroll="visi-misi">Visi & Misi</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/tentang" data-scroll="struktur">Struktur Pengelola</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" style="pointer-events: none; cursor: default;">Layanan</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo BASE_URL; ?>/fasilitas">Fasilitas Lab</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/layanan">Konsultasi Keamanan</a></li>
                        </ul>
                    </li>

                    <li class="dropdown">
                        <a href="#" style="pointer-events: none; cursor: default;">Aktivitas</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo BASE_URL; ?>/berita">Berita & Artikel</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/galeri">Galeri Foto</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/agenda">Agenda Kegiatan</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo BASE_URL; ?>/arsip">Arsip Digital</a>
                    </li>

                </ul>
            </nav>

            <div>
                <div>
                    <a href="<?php echo BASE_URL; ?>/login" class="laboix-btn main-header__btn">Login</a>
                </div>

                <div class="mobile-nav__btn mobile-nav__toggler">
                    <span></span><span></span><span></span>
                </div>
            </div>

        </div>
    </div>
</header>