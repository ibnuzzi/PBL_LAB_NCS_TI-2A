<?php

class AdminProfileController extends Controller
{
    /**
     * Constructor - Middleware untuk memastikan admin sudah login
     */
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    /**
     * Halaman My Profile
     */
    public function index()
    {
        $admin_id = $_SESSION['admin_id'] ?? null;

        if (!$admin_id) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $adminModel = $this->model('Admin');
        $admin = $adminModel->getAdminById($admin_id);

        if (!$admin) {
            $_SESSION['error_message'] = "Data admin tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/dashboard");
            exit;
        }

        $data = [
            'judul_halaman' => 'My Profile',
            'admin' => $admin
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/profile/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * Update Profile
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/profile");
            exit;
        }

        $admin_id = $_SESSION['admin_id'] ?? null;

        if (!$admin_id) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
        $email = trim($_POST['email'] ?? '');

        // Validasi
        if (empty($nama_lengkap) || empty($email)) {
            $_SESSION['error_message'] = 'Nama dan email wajib diisi.';
            header("Location: " . BASE_URL . "/admin/profile");
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = 'Format email tidak valid.';
            header("Location: " . BASE_URL . "/admin/profile");
            exit;
        }

        $adminModel = $this->model('Admin');

        $payload = [
            'id_admin' => $admin_id,
            'nama_lengkap' => $nama_lengkap,
            'email' => $email
        ];

        $ok = $adminModel->updateProfile($payload);

        if ($ok) {
            // Update session
            $_SESSION['admin_nama'] = $nama_lengkap;
            $_SESSION['success_message'] = "Profile berhasil diperbarui.";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui profile.";
        }

        header("Location: " . BASE_URL . "/admin/profile");
        exit;
    }

    /**
     * Halaman Change Password
     */
    public function changePassword()
    {
        $data = ['judul_halaman' => 'Ganti Password'];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/profile/change_password', $data);
        $this->view('templates/admin/footer_admin');
    }

    /**
     * Update Password
     */
    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/change-password");
            exit;
        }

        $admin_id = $_SESSION['admin_id'] ?? null;

        if (!$admin_id) {
            header("Location: " . BASE_URL . "/login");
            exit;
        }

        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Validasi
        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $_SESSION['error_message'] = 'Semua field wajib diisi.';
            header("Location: " . BASE_URL . "/admin/change-password");
            exit;
        }

        if ($new_password !== $confirm_password) {
            $_SESSION['error_message'] = 'Password baru dan konfirmasi tidak cocok.';
            header("Location: " . BASE_URL . "/admin/change-password");
            exit;
        }

        if (strlen($new_password) < 6) {
            $_SESSION['error_message'] = 'Password baru minimal 6 karakter.';
            header("Location: " . BASE_URL . "/admin/change-password");
            exit;
        }

        $adminModel = $this->model('Admin');
        $admin = $adminModel->getAdminById($admin_id);

        if (!$admin) {
            $_SESSION['error_message'] = 'Data admin tidak ditemukan.';
            header("Location: " . BASE_URL . "/admin/change-password");
            exit;
        }

        // Verify current password
        if (!password_verify($current_password, $admin['password'])) {
            $_SESSION['error_message'] = 'Password lama tidak sesuai.';
            header("Location: " . BASE_URL . "/admin/change-password");
            exit;
        }

        // Hash new password
        $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

        $ok = $adminModel->updatePassword($admin_id, $new_password_hash);

        if ($ok) {
            $_SESSION['success_message'] = "Password berhasil diubah.";
        } else {
            $_SESSION['error_message'] = "Gagal mengubah password.";
        }

        header("Location: " . BASE_URL . "/admin/change-password");
        exit;
    }
}
