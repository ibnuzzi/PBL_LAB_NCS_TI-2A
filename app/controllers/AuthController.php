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
            'error' => $_SESSION['error_message'] ?? null,
            'success' => $_SESSION['success_message'] ?? null
        ];

        // Hapus pesan dari session agar tidak muncul lagi
        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);

        $this->view('public/admin/login', $data);            // Panggil Konten (Form)
    }

    /**
     * 2. MEMPROSES DATA LOGIN (Method: POST)
     * Ini dipanggil oleh rute: Route::add('POST', '/login', ...)
     */
    public function processLogin()
    {
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

        // Cek apakah admin ditemukan DAN password cocok (menggunakan password_verify untuk hash)
        if ($admin && password_verify($password, $admin['password'])) {

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

    /**
     * 4. MENAMPILKAN HALAMAN LUPA PASSWORD (Method: GET)
     */
    public function forgotPassword()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        }

        $data = [
            'judul_halaman' => 'Lupa Password',
            'error' => $_SESSION['error_message'] ?? null,
            'success' => $_SESSION['success_message'] ?? null
        ];

        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);

        $this->view('public/admin/forgot-password', $data);
    }

    /**
     * 5. MEMPROSES PERMINTAAN LUPA PASSWORD (Method: POST)
     */
    public function processForgotPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/forgot-password');
            exit;
        }

        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['error_message'] = 'Email harus diisi!';
            header('Location: ' . BASE_URL . '/forgot-password');
            exit;
        }

        $adminModel = $this->model('Admin');
        $admin = $adminModel->getAdminByEmail($email);

        if (!$admin) {
            // Untuk keamanan, kita tetap menampilkan pesan sukses meskipun email tidak ditemukan
            // Ini mencegah attacker mengetahui email mana yang terdaftar
            $_SESSION['success_message'] = 'Jika email Anda terdaftar, link reset password telah dikirim. Silakan cek email Anda.';
            header('Location: ' . BASE_URL . '/forgot-password');
            exit;
        }

        // Generate token reset password
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token berlaku 1 jam

        // Simpan token ke database
        $adminModel->saveResetToken($admin['id_admin'], $token, $expires);

        // URL untuk reset password
        $resetUrl = BASE_URL . '/reset-password?token=' . $token . '&email=' . urlencode($email);

        // Kirim email dengan link reset menggunakan EmailService
        require_once './app/services/EmailService.php';
        $emailService = new EmailService();
        $emailSent = $emailService->sendPasswordResetEmail($email, $admin['nama_lengkap'], $resetUrl);

        if ($emailSent) {
            $_SESSION['success_message'] = 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam Anda.';
        } else {
            // Jika gagal kirim email, tampilkan link sebagai fallback
            $_SESSION['success_message'] = 'Gagal mengirim email. Silakan gunakan link berikut untuk reset password:<br><br><a href="' . $resetUrl . '" style="word-break: break-all; color: #2563eb;">' . $resetUrl . '</a>';
        }

        header('Location: ' . BASE_URL . '/forgot-password');
        exit;
    }

    /**
     * 6. MENAMPILKAN HALAMAN RESET PASSWORD (Method: GET)
     */
    public function resetPassword()
    {
        // Jika sudah login, redirect ke dashboard
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit;
        }

        $token = $_GET['token'] ?? '';
        $email = $_GET['email'] ?? '';

        $data = [
            'judul_halaman' => 'Reset Password',
            'error' => $_SESSION['error_message'] ?? null,
            'success' => $_SESSION['success_message'] ?? null,
            'token' => $token,
            'email' => $email,
            'tokenValid' => false
        ];

        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);

        // Validasi token
        if (!empty($token) && !empty($email)) {
            $adminModel = $this->model('Admin');
            $admin = $adminModel->getAdminByEmail($email);

            if ($admin) {
                $isValid = $adminModel->validateResetToken($admin['id_admin'], $token);
                $data['tokenValid'] = $isValid;
            }
        }

        $this->view('public/admin/reset-password', $data);
    }

    /**
     * 7. MEMPROSES RESET PASSWORD (Method: POST)
     */
    public function processResetPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $token = $_POST['token'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $passwordConfirm = $_POST['password_confirm'] ?? '';

        // Validasi input
        if (empty($password) || empty($passwordConfirm)) {
            $_SESSION['error_message'] = 'Semua field harus diisi!';
            header('Location: ' . BASE_URL . '/reset-password?token=' . $token . '&email=' . urlencode($email));
            exit;
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['error_message'] = 'Password dan konfirmasi password tidak cocok!';
            header('Location: ' . BASE_URL . '/reset-password?token=' . $token . '&email=' . urlencode($email));
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['error_message'] = 'Password minimal 6 karakter!';
            header('Location: ' . BASE_URL . '/reset-password?token=' . $token . '&email=' . urlencode($email));
            exit;
        }

        $adminModel = $this->model('Admin');
        $admin = $adminModel->getAdminByEmail($email);

        if (!$admin) {
            $_SESSION['error_message'] = 'Email tidak valid!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // Validasi token
        if (!$adminModel->validateResetToken($admin['id_admin'], $token)) {
            $_SESSION['error_message'] = 'Token tidak valid atau sudah kadaluarsa!';
            header('Location: ' . BASE_URL . '/forgot-password');
            exit;
        }

        // Update password dengan hash yang aman menggunakan password_hash()
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $adminModel->updatePassword($admin['id_admin'], $hashedPassword);

        // Hapus token
        $adminModel->deleteResetToken($admin['id_admin']);

        $_SESSION['success_message'] = 'Password berhasil direset! Silakan login dengan password baru.';
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
