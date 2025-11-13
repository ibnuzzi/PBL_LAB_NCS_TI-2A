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

// 6. JALANKAN ROUTER
Route::dispatch($routePath, $_SERVER['REQUEST_METHOD']);
?>