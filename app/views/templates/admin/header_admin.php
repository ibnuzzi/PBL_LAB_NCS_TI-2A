<?php if (!defined('BASE_URL')) {
    require_once __DIR__ . '../../../../../core/config.php';
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="<?= BASE_URL ?>/public/assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= htmlspecialchars($data['judul_halaman'] ?? 'Admin') ?> | Lab NCS</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/public/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/admin/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/admin/vendor/css/core.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/admin/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/admin/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/admin/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>/public/admin/vendor/libs/chartjs/chartjs.css" />

    <!-- Helpers -->
    <script src="<?= BASE_URL ?>/public/admin/vendor/js/helpers.js"></script>
    <script src="<?= BASE_URL ?>/public/admin/js/config.js"></script>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- SIDEBAR will be inserted by sidebar_admin -->

            <?php
            // header_admin.php end
            ?>