<?php
// Detect current page for active nav highlighting
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
$currentPath = parse_url($currentUri, PHP_URL_PATH);

function isNavActive($path, $patterns)
{
    foreach ($patterns as $pattern) {
        if (strpos($path, $pattern) !== false) {
            return 'current';
        }
    }
    return '';
}
?>
<header class="main-header sticky-header sticky-header--normal">
    <div class="container-fluid">
        <div class="main-header__inner navbar-inner-custom">

            <div class="main-header__logo logo-laboix navbar-logo-custom">
                <a href="<?php echo BASE_URL; ?>/">
                    <img src="<?php echo BASE_URL; ?>/public/assets/images/ClearLogoJTI.png" alt="Lab NCS JTI Polinema" width="60">
                </a>
            </div>

            <nav class="main-header__nav main-menu navbar-nav-custom">
                <ul class="main-menu__list">

                    <li class="<?= (rtrim($currentPath, '/') === '' || $currentPath === '/PBL_LAB_NCS_TI-2A' || $currentPath === '/PBL_LAB_NCS_TI-2A/') ? 'current' : '' ?>">
                        <a href="<?php echo BASE_URL; ?>/">Beranda</a>
                    </li>

                    <li class="<?= isNavActive($currentPath, ['/tentang']) ?>">
                        <a href="<?php echo BASE_URL; ?>/tentang">Tentang Kami</a>
                    </li>

                    <li class="dropdown <?= isNavActive($currentPath, ['/fasilitas', '/layanan']) ?>">
                        <a href="javascript:void(0);" class="nav-link-disabled">Layanan</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo BASE_URL; ?>/fasilitas">Fasilitas Lab</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/layanan">Konsultasi</a></li>
                        </ul>
                    </li>

                    <li class="dropdown <?= isNavActive($currentPath, ['/berita', '/galeri', '/agenda']) ?>">
                        <a href="javascript:void(0);" class="nav-link-disabled">Aktivitas</a>
                        <ul class="sub-menu">
                            <li><a href="<?php echo BASE_URL; ?>/berita">Berita & Artikel</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/galeri">Galeri Foto</a></li>
                            <li><a href="<?php echo BASE_URL; ?>/agenda">Agenda Kegiatan</a></li>
                        </ul>
                    </li>

                    <li class="<?= isNavActive($currentPath, ['/arsip']) ?>">
                        <a href="<?php echo BASE_URL; ?>/arsip">Arsip Digital</a>
                    </li>

                </ul>
            </nav>

            <div>
                <div class="mobile-nav__btn mobile-nav__toggler">
                    <span></span><span></span><span></span>
                </div>
            </div>

        </div>
    </div>
</header>