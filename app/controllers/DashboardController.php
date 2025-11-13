<?php
// File: /app/controllers/DashboardController.php

class DashboardController extends Controller {

    /**
     * Constructor ini berfungsi sebagai "MIDDLEWARE"
     */
    public function __construct() {
        // Cek apakah session 'admin_logged_in' TIDAK ada
        if (!isset($_SESSION['admin_logged_in'])) {
            // Jika tidak ada (belum login), tendang ke halaman login
            $_SESSION['error_message'] = 'Anda harus login untuk mengakses halaman ini!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
        // Jika session ada, biarkan lanjut ke method 'index'
    }

    /**
     * Menampilkan halaman dashboard
     */
    public function index() {
        $this->view('public/admin/dashboard'); 
    }
}
?>