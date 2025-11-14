<?php
// File: /app/controllers/AdminBeritaController.php

class AdminPenelitianController extends Controller {

    /**
     * Constructor "MIDDLEWARE"
     */
    public function __construct() {
        if (!isset($_SESSION['admin_logged_in'])) {
            $_SESSION['error_message'] = 'Anda harus login!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    public function index() {
    
        // Render viewsx    
        $this->view('templates/admin/header_admin');
        $this->view('public/admin/penelitian/index' );
        $this->view('templates/admin/footer_admin');
    }

    public function create() {
    
            $this->view('templates/admin/header_admin');
            $this->view('public/admin/penelitian/create');
            $this->view('templates/admin/footer_admin');
    }

    public function show() {
    
            $this->view('templates/admin/header_admin');
            $this->view('public/admin/penelitian/edit');
            $this->view('templates/admin/footer_admin');
    }
}
?>