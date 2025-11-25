<?php
// Simple sidebar template for admin area
// Determine current page for active menu highlighting
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Check which menu should be active based on current path
$isDashboard = stripos($currentPath, '/admin/dashboard') !== false;
$isBerita = stripos($currentPath, '/admin/berita') !== false;
$isAgenda = stripos($currentPath, '/admin/agenda') !== false;
$isGaleri = stripos($currentPath, '/admin/gallery') !== false;
$isStruktur = stripos($currentPath, '/admin/struktur') !== false;
$isHalamanStatis = stripos($currentPath, '/admin/halaman-statis') !== false;
$isKonsultasi = stripos($currentPath, '/admin/konsultasi') !== false;
$isSaranaPrasarana = stripos($currentPath, '/admin/sarana') !== false;
$isPenelitian = stripos($currentPath, '/admin/penelitian') !== false;
$isPengabdian = stripos($currentPath, '/admin/pengabdian') !== false;
$isDokumenUmum = stripos($currentPath, '/admin/dokumen-umum') !== false;
$isManajemenAdmin = stripos($currentPath, '/admin/manajemen-admin') !== false;
?>
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
  <div class="app-brand demo">
    <a href="<?php echo BASE_URL; ?>/admin/dashboard" class="app-brand-link">
      <i class="bx bx-shield-quarter bx-md" style="color:#696cff;"></i>
      <span class="app-brand-text demo menu-text fw-bolder ms-2">Lab NCS</span>
    </a>
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
      <i class="bx bx-chevron-left bx-sm align-middle"></i>
    </a>
  </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item <?php echo $isDashboard ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/dashboard" class="menu-link">
        <i class="menu-icon bx bx-home-circle"></i>
        <div>Dashboard</div>
      </a>
    </li>

    <!-- Profil Lab -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Profil Lab</span>
    </li>
    <li class="menu-item <?php echo $isStruktur ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/pengelola" class="menu-link">
        <i class="menu-icon bx bx-group"></i>
        <div>Struktur Pengelola</div>
      </a>
    </li>

    <li class="menu-item <?php echo $isHalamanStatis ? 'active' : ''; ?>">
      <a href="halaman-statis.html" class="menu-link">
        <i class="menu-icon bx bx-lock-open"></i>
        <div>Halaman Statis</div>
      </a>
    </li>

    <!-- Manajemen Konten -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Manajemen Konten</span>
    </li>
    <li class="menu-item <?php echo $isBerita ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/berita" class="menu-link">
        <i class="menu-icon bx bx-news"></i>
        <div>Berita</div>
      </a>
    </li>
    <li class="menu-item <?php echo $isAgenda ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/agenda" class="menu-link">
        <i class="menu-icon bx bx-calendar"></i>
        <div>Agenda</div>
      </a>
    </li>
    <li class="menu-item <?php echo $isGaleri ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/gallery" class="menu-link">
        <i class="menu-icon bx bx-images"></i>
        <div>Galeri</div>
      </a>
    </li>

    <!-- Manajemen Layanan -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Manajemen Layanan</span>
    </li>
    <li class="menu-item <?php echo $isKonsultasi ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/konsultasi" class="menu-link">
        <i class="menu-icon bx bx-briefcase-alt"></i>
        <div>Konsultasi</div>
      </a>
    </li>
    <li class="menu-item <?php echo $isSaranaPrasarana ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/sarana" class="menu-link">
        <i class="menu-icon bx bx-building-house"></i>
        <div>Sarana dan Prasarana</div>
      </a>
    </li>

    <!-- Manajemen Arsip -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Manajemen Arsip</span>
    </li>
    <li class="menu-item <?php echo $isPenelitian ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/penelitian" class="menu-link">
        <i class="menu-icon bx bx-book-content"></i>
        <div>Penelitian</div>
      </a>
    </li>
    <li class="menu-item <?php echo $isPengabdian ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/pengabdian" class="menu-link">
        <i class="menu-icon bx bx-file-blank"></i>
        <div>Pengabdian</div>
      </a>
    </li>
    <li class="menu-item <?php echo $isDokumenUmum ? 'active' : ''; ?>">
      <a href="<?php echo BASE_URL; ?>/admin/dokumen_umum" class="menu-link">
        <i class="menu-icon bx bx-folder"></i>
        <div>Dokumen Umum</div>
      </a>
    </li>

    <!-- Sistem -->
    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Sistem</span>
    </li>
    <li class="menu-item <?php echo $isManajemenAdmin ? 'active' : ''; ?>">
      <a href="manajemen-admin.html" class="menu-link">
        <i class="menu-icon bx bx-user-circle"></i>
        <div>Manajemen Admin</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="<?php echo BASE_URL; ?>/" target="_blank" class="menu-link">
        <i class="menu-icon bx bx-globe"></i>
        <div>Lihat Website</div>
      </a>
    </li>
    <li class="menu-item">
      <a href="<?php echo BASE_URL; ?>/logout" class="menu-link">
        <i class="menu-icon bx bx-power-off"></i>
        <div>Logout</div>
      </a>
    </li>
  </ul>
</aside>
<!-- PAGE -->
<div class="layout-page">
  <!-- NAVBAR -->
  <nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  




  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0   d-xl-none ">
    <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
      <i class="icon-base bx bx-menu icon-md"></i>
    </a>
  </div>


<div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
  
  

  
    <!-- Search -->
    <div class="navbar-nav align-items-center me-auto">
      <div class="nav-item d-flex align-items-center">
        <span class="w-px-22 h-px-22"><i class="icon-base bx bx-search icon-md"></i></span>
        <input type="text" class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none" placeholder="Search..." aria-label="Search...">
      </div>
    </div>
    <!-- /Search -->
  
  <ul class="navbar-nav flex-row align-items-center ms-md-auto">
        <!-- Place this tag where you want the button to render. -->
        <li class="nav-item lh-1 me-4">
          <span></span>
        </li>
      
      <!-- User -->
      <li class="nav-item navbar-dropdown dropdown-user dropdown">
        <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
          <div class="avatar avatar-online">
            <img src="../assets/img/avatars/1.png" alt="" class="w-px-40 h-auto rounded-circle">
          </div>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#">
              <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                  <div class="avatar avatar-online">
                    <img src="../assets/img/avatars/1.png" alt="" class="w-px-40 h-auto rounded-circle">
                  </div>
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0">John Doe</h6>
                  <small class="text-body-secondary">Admin</small>
                </div>
              </div>
            </a>
          </li>
          <li>
            <div class="dropdown-divider my-1"></div>
          </li>
          <li>
            <a class="dropdown-item" href="#"> <i class="icon-base bx bx-user icon-md me-3"></i><span>My Profile</span> </a>
          </li>
          <li>
            <a class="dropdown-item" href="#"> <i class="icon-base bx bx-cog icon-md me-3"></i><span>Settings</span> </a>
          </li>
          <li>
            <a class="dropdown-item" href="#">
              <span class="d-flex align-items-center align-middle">
                <i class="flex-shrink-0 icon-base bx bx-credit-card icon-md me-3"></i><span class="flex-grow-1 align-middle">Billing Plan</span>
                <span class="flex-shrink-0 badge rounded-pill bg-danger">4</span>
              </span>
            </a>
          </li>
          <li>
            <div class="dropdown-divider my-1"></div>
          </li>
          <li>
            <a class="dropdown-item" href="javascript:void(0);"> <i class="icon-base bx bx-power-off icon-md me-3"></i><span>Log Out</span> </a>
          </li>
        </ul>
      </li>
      <!--/ User -->
    
  </ul>
</div>

</nav>
  <!-- /NAVBAR -->