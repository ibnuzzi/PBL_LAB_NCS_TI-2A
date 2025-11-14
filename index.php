<?php
// File: /public/index.php

session_start();

// 1. Load semua file inti (bootstrap)
// PERBAIKAN 1: Path harus keluar satu folder
require_once './app/bootstrap.php';

// ----------------------------------------------------
// PENGATURAN ROUTING
// ----------------------------------------------------

// 2. DAPATKAN PATH YANG DIMINTA
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// 3. TENTUKAN BASE PATH secara dinamis dari SCRIPT_NAME
// Ini menangani perbedaan huruf besar/kecil dan lokasi folder project
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$basePath = rtrim(dirname($scriptName), '/');
if ($basePath === '') {
    $basePath = '/';
}

// 4. DAPATKAN ROUTE YANG BERSIH
// Hapus basePath dari requestUri (case-insensitive)
$routePath = $requestUri;
if ($basePath !== '/' ) {
    $pos = stripos($requestUri, $basePath);
    if ($pos === 0) {
        $routePath = substr($requestUri, strlen($basePath));
    }
}

// Jika hasilnya kosong (artinya mengakses root), set ke '/'
if ($routePath === '' || $routePath === false) {
    $routePath = '/';
}

// Pastikan leading slash
if ($routePath[0] !== '/') {
    $routePath = '/' . $routePath;
}

// Jika URL berisi '/index.php' (misal: /Lab_NCS/index.php/login), hilangkan segmen ini
if (strpos($routePath, '/index.php') === 0) {
    $routePath = substr($routePath, strlen('/index.php'));
    if ($routePath === '' || $routePath === false) {
        $routePath = '/';
    }
    if ($routePath[0] !== '/') {
        $routePath = '/' . $routePath;
    }
}

// 5. DEFINISIKAN RUTE ANDA
Route::add('GET', '/', 'HomeController', 'index');
Route::add('GET', '/berita', 'BeritaController', 'index');
Route::add('GET', '/berita/detail/{id}', 'BeritaController', 'detail');

// Rute Login (Ini sudah benar)
Route::add('GET', '/login', 'AuthController', 'index');
Route::add('POST', '/login', 'AuthController', 'processLogin');
Route::add('GET', '/logout', 'AuthController', 'logout');

// Rute yang Dilindungi (Anda perlu menambahkannya)
Route::add('GET', '/admin/dashboard', 'DashboardController', 'index');
Route::add('GET', '/admin/berita', 'AdminBeritaController', 'index');
Route::add('GET', '/admin/berita/create', 'AdminBeritaController', 'create');
// Admin berita actions
Route::add('POST', '/admin/berita/store', 'AdminBeritaController', 'store');
Route::add('GET', '/admin/berita/edit/{id}', 'AdminBeritaController', 'show');
Route::add('POST', '/admin/berita/update/{id}', 'AdminBeritaController', 'update');
Route::add('GET', '/admin/berita/delete/{id}', 'AdminBeritaController', 'delete');

// Admin agenda routes
Route::add('GET', '/admin/agenda', 'AdminAgendaController', 'index');
Route::add('GET', '/admin/agenda/create', 'AdminAgendaController', 'create');
Route::add('POST', '/admin/agenda/store', 'AdminAgendaController', 'store');
Route::add('GET', '/admin/agenda/edit/{id}', 'AdminAgendaController', 'show');
Route::add('POST', '/admin/agenda/update/{id}', 'AdminAgendaController', 'update');
Route::add('GET', '/admin/agenda/delete/{id}', 'AdminAgendaController', 'delete');

// Admin gallery routes
Route::add('GET', '/admin/gallery', 'AdminGalleryController', 'index');
Route::add('GET', '/admin/gallery/create', 'AdminGalleryController', 'create');
Route::add('POST', '/admin/gallery/store', 'AdminGalleryController', 'store');
Route::add('GET', '/admin/gallery/edit/{id}', 'AdminGalleryController', 'show');
Route::add('POST', '/admin/gallery/update/{id}', 'AdminGalleryController', 'update');
Route::add('GET', '/admin/gallery/delete/{id}', 'AdminGalleryController', 'delete');


// JASA & LAYANAN
Route::add('GET',  '/admin/jasa-layanan',            'AdminJasaLayananController', 'index');
Route::add('GET',  '/admin/jasa-layanan/create',     'AdminJasaLayananController', 'create');
Route::add('POST', '/admin/jasa-layanan/store',      'AdminJasaLayananController', 'store');
Route::add('GET',  '/admin/jasa-layanan/edit/{id}',  'AdminJasaLayananController', 'edit');
Route::add('POST', '/admin/jasa-layanan/update/{id}','AdminJasaLayananController', 'update');
Route::add('GET',  '/admin/jasa-layanan/delete/{id}','AdminJasaLayananController', 'delete');

// ================= SARANA PRASARANA =====================

Route::add('GET',  '/admin/sarana',               'AdminSaranaController', 'index');
Route::add('GET',  '/admin/sarana/create',        'AdminSaranaController', 'create');
Route::add('POST', '/admin/sarana/store',         'AdminSaranaController', 'store');

Route::add('GET',  '/admin/sarana/edit/{id}',     'AdminSaranaController', 'edit');
Route::add('POST', '/admin/sarana/update/{id}',   'AdminSaranaController', 'update');

Route::add('GET',  '/admin/sarana/delete/{id}',   'AdminSaranaController', 'delete');

//Admin penelitian
Route::add('GET', '/admin/penelitian', 'AdminPenelitianController', 'index');
Route::add('GET', '/admin/penelitian/create', 'AdminPenelitianController', 'create');
Route::add('GET', '/admin/penelitian/edit', 'AdminPenelitianController', 'show');

//Admin pengabdian
Route::add('GET', '/admin/pengabdian', 'AdminPengabdianController', 'index');
Route::add('GET', '/admin/pengabdian/create', 'AdminPengabdianController', 'create');
Route::add('GET', '/admin/pengabdian/edit', 'AdminPengabdianController', 'show');

//Admin dokumen Umum
Route::add('GET', '/admin/dokumen_umum', 'AdminDokumen_umumController', 'index');
Route::add('GET', '/admin/dokumen_umum/create', 'AdminDokumen_umumController', 'create');
Route::add('GET', '/admin/dokumen_umum/edit', 'AdminDokumen_umumController', 'show');

// 6. JALANKAN ROUTER
Route::dispatch($routePath, $_SERVER['REQUEST_METHOD']);
?>