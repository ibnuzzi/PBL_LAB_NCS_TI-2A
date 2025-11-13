<?php
// File: /app/core/Config.php

// URL ROOT (Sangat Penting: Sesuaikan dengan folder proyek Anda)
// Ini akan otomatis mendeteksi http atau https dan nama domain Anda
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https:" : "http:";
$host = $_SERVER['HTTP_HOST'];
// Cukup hapus /index.php saja
$script_name = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
define('BASE_URL', $protocol . '//' . $host . $script_name);

// --- DATABASE CONFIGURATION FOR POSTGRESQL ---

// Driver database (jangan diubah)
define('DB_DRIVER', 'pgsql'); 

// Host database Anda (biasanya 'localhost' atau '127.0.0.1')
define('DB_HOST', '127.0.0.1'); 

// Port default PostgreSQL (biasanya 5432)
define('DB_PORT', '5432'); 

// Nama database PostgreSQL Anda
define('DB_NAME', 'lab_ncs_db'); // Ganti ini

// Username database PostgreSQL (biasanya 'postgres')
define('DB_USER', 'postgres'); // Ganti ini

// Password database PostgreSQL Anda
define('DB_PASS', 'password123'); // Ganti ini