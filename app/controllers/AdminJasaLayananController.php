<?php
// File: /app/controllers/AdminJasaLayananController.php

class AdminJasaLayananController extends Controller
{
    public function __construct()
    {
        // Kalau mau pakai middleware login admin, samakan seperti Gallery:
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index()
    {
        $jasaModel = $this->model('JasaLayanan');

        $data = [
            'judul_halaman' => 'Jasa dan Layanan - Lab NCS',
            'layanan'       => $jasaModel->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/jasa_layanan/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function create()
    {
        $data = [
            'judul_halaman' => 'Tambah Jasa dan Layanan'
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/jasa_layanan/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/jasa-layanan');
            exit;
        }

        // Sesuaikan dengan name input di form
        $nama       = trim($_POST['nama_layanan'] ?? '');
        $deskripsi  = trim($_POST['deskripsi_layanan'] ?? '');
        $icon       = trim($_POST['icon_layanan'] ?? '');
        $id_admin   = $_SESSION['admin_id'] ?? 1;

        $jasaModel = $this->model('JasaLayanan');

        $payload = [
            'nama_layanan'      => $nama,
            'deskripsi_layanan' => $deskripsi,
            'icon_layanan'      => $icon,
            'id_admin_pencatat' => (int) $id_admin
        ];

        $ok = $jasaModel->insert($payload);

        if ($ok) {
            $_SESSION['success_message'] = 'Layanan berhasil ditambahkan.';
        } else {
            $_SESSION['error_message'] = 'Gagal menambahkan layanan.';
        }

        header('Location: ' . BASE_URL . '/admin/jasa-layanan');
        exit;
    }

    public function edit()
    {
        // Ambil ID dari argumen route
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/jasa-layanan');
            exit;
        }

        $jasaModel = $this->model('JasaLayanan');
        $row = $jasaModel->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = 'Layanan tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/jasa-layanan');
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Jasa dan Layanan',
            'layanan'       => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/jasa_layanan/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/jasa-layanan');
            exit;
        }

        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/jasa-layanan');
            exit;
        }

        $nama       = trim($_POST['nama_layanan'] ?? '');
        $deskripsi  = trim($_POST['deskripsi_layanan'] ?? '');
        $icon       = trim($_POST['icon_layanan'] ?? '');

        $jasaModel = $this->model('JasaLayanan');

        $payload = [
            'nama_layanan'      => $nama,
            'deskripsi_layanan' => $deskripsi,
            'icon_layanan'      => $icon
        ];

        $ok = $jasaModel->update($id, $payload);

        if ($ok) {
            $_SESSION['success_message'] = 'Layanan berhasil diupdate.';
        } else {
            $_SESSION['error_message'] = 'Gagal mengupdate layanan.';
        }

        header('Location: ' . BASE_URL . '/admin/jasa-layanan');
        exit;
    }

    public function delete()
    {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;

        if ($id <= 0) {
            header('Location: ' . BASE_URL . '/admin/jasa-layanan');
            exit;
        }

        $jasaModel = $this->model('JasaLayanan');
        $ok = $jasaModel->delete($id);

        if ($ok) {
            $_SESSION['success_message'] = 'Layanan berhasil dihapus.';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus layanan.';
        }

        header('Location: ' . BASE_URL . '/admin/jasa-layanan');
        exit;
    }
}
