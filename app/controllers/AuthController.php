<?php
// File: /app/controllers/AuthController.php

class AuthController extends Controller
{

    /**
     * 1. MENAMPILKAN HALAMAN LOGIN (Method: GET)
     * Ini dipanggil oleh rute: Route::add('GET', '/login', ...)
     * Tugasnya adalah memuat header, konten form, dan footer.
     */
    public function index()
    {
        // Cek dulu, jika user SUDAH login, lempar ke dashboard
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        }

        // Siapkan data untuk dikirim ke view
        $data = [
            'judul_halaman' => 'Login Admin',
            'error' => $_SESSION['error_message'] ?? null // Ambil pesan error jika ada
        ];

        // Hapus pesan error dari session agar tidak muncul lagi
        unset($_SESSION['error_message']);

        $this->view('public/admin/login', $data);            // Panggil Konten (Form)
    }

    /**
     * 2. MEMPROSES DATA LOGIN (Method: POST)
     * Ini dipanggil oleh rute: Route::add('POST', '/login', ...)
     */
    public function processLogin() {
        // Pastikan ini adalah request POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Ambil data dari form
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Panggil model Admin
        $adminModel = $this->model('Admin');
        $admin = $adminModel->getAdminByEmail($email);

        // Cek apakah admin ditemukan DAN password cocok (versi aman)
        if ($password == $admin['password']) {
            
            // === LOGIN BERHASIL ===
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id_admin'];
            $_SESSION['admin_nama'] = $admin['nama_lengkap'];

            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        }
        
        // === LOGIN GAGAL ===
        $_SESSION['error_message'] = 'Email atau password salah!';
        header('Location: ' . BASE_URL . '/login');
        exit;
    }

    /**
     * 3. PROSES LOGOUT
     * Ini bisa Anda panggil dari rute: Route::add('GET', '/logout', ...)
     */
    public function logout()
    {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
