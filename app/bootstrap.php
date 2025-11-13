<?php
// File: /app/bootstrap.php

// 1. Load File Konfigurasi
require_once 'core/config.php';

// 2. Load File Inti (Core Libraries)
require_once 'core/controller.php'; // <-- Ini memperbaiki error 'Controller'
require_once 'core/database.php';

// INI YANG MEMPERBAIKI ERROR ANDA SEKARANG:
require_once 'core/app.php'; 

require_once 'app/config/routes.php';

?>