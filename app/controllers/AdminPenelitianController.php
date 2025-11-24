<?php
// File: /app/controllers/AdminPenelitianController.php

class AdminPenelitianController extends Controller
{
    public function __construct()
    {
        // Middleware for checking if the user is logged in as an admin
        if (!isset($_SESSION['admin_logged_in'])) {
            $_SESSION['error_message'] = 'You must be logged in!';
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }

    // Display the list of penelitian
    public function index()
    {
        $penelitianModel = $this->model('Penelitian');
        $penelitianList = $penelitianModel->getAll();

        $data = [
            'judul_halaman' => 'Manajemen Penelitian',
            'penelitian_list' => $penelitianList
        ];

        // Render the views
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/penelitian/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    // Show the form to add a new penelitian
    public function create()
    {
        $data = [
            'judul_halaman' => 'Tambah Penelitian'
        ];

        // Render the views
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/penelitian/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    // Store the new penelitian data
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/penelitian');
            exit;
        }

        // Get POST data
        $judul_penelitian = $_POST['judul_penelitian'] ?? null;
        $tahun_penelitian = $_POST['tahun_penelitian'] ?? null;
        $deskripsi_singkat = $_POST['deskripsi_singkat'] ?? null;
        $peneliti = $_POST['peneliti'] ?? null;
        $link_publikasi = $_POST['link_publikasi'] ?? null;

        // Validate required fields
        if (empty($judul_penelitian)) {
            $_SESSION['error_message'] = "Judul Penelitian tidak boleh kosong!";
            header('Location: ' . BASE_URL . '/admin/penelitian/create');
            exit;
        }

        // Prepare data
        $data = [
            'judul_penelitian' => $judul_penelitian,
            'tahun_penelitian' => $tahun_penelitian,
            'deskripsi_singkat' => $deskripsi_singkat,
            'peneliti' => $peneliti,
            'link_publikasi' => $link_publikasi
        ];

        // Pass data to the model
        $penelitianModel = $this->model('Penelitian');
        $inserted = $penelitianModel->insert($data);

        if ($inserted) {
            $_SESSION['success_message'] = 'Penelitian berhasil ditambahkan.';
        } else {
            $_SESSION['error_message'] = 'Gagal menambahkan penelitian.';
        }

        // Redirect to the list
        header('Location: ' . BASE_URL . '/admin/penelitian');
        exit;
    }

    // Show the form to edit an existing penelitian
    public function edit($id)
    {
        $penelitianModel = $this->model('Penelitian');
        $penelitian = $penelitianModel->getById($id);

        if (!$penelitian) {
            $_SESSION['error_message'] = 'Penelitian tidak ditemukan.';
            header('Location: ' . BASE_URL . '/admin/penelitian');
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Penelitian',
            'penelitian' => $penelitian
        ];

        // Render the views
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/penelitian/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    // Update the penelitian data
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/penelitian');
            exit;
        }

        // Get POST data
        $judul_penelitian = $_POST['judul_penelitian'] ?? null;
        $tahun_penelitian = $_POST['tahun_penelitian'] ?? null;
        $deskripsi_singkat = $_POST['deskripsi_singkat'] ?? null;
        $peneliti = $_POST['peneliti'] ?? null;
        $link_publikasi = $_POST['link_publikasi'] ?? null;

        // Prepare data
        $data = [
            'judul_penelitian' => $judul_penelitian,
            'tahun_penelitian' => $tahun_penelitian,
            'deskripsi_singkat' => $deskripsi_singkat,
            'peneliti' => $peneliti,
            'link_publikasi' => $link_publikasi
        ];

        // Pass data to the model
        $penelitianModel = $this->model('Penelitian');
        $updated = $penelitianModel->update($id, $data);

        if ($updated) {
            $_SESSION['success_message'] = 'Penelitian berhasil diperbarui.';
        } else {
            $_SESSION['error_message'] = 'Gagal memperbarui penelitian.';
        }

        // Redirect to the list
        header('Location: ' . BASE_URL . '/admin/penelitian');
        exit;
    }

    // Delete a penelitian
    public function delete($id)
    {
        $penelitianModel = $this->model('Penelitian');
        $deleted = $penelitianModel->delete($id);

        if ($deleted) {
            $_SESSION['success_message'] = 'Penelitian berhasil dihapus.';
        } else {
            $_SESSION['error_message'] = 'Gagal menghapus penelitian.';
        }

        // Redirect to the list
        header('Location: ' . BASE_URL . '/admin/penelitian');
        exit;
    }
}
