<?php
// File: /app/controllers/AdminDokumenUmumController.php

class AdminDokumenUmumController extends Controller
{
    /**
     * Constructor "MIDDLEWARE"
     */
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index()
    {
        $model = $this->model('DokumenUmum');

        $data = [
            'judul_halaman' => 'Dokumen Umum - Lab NCS',
            'dokumen_list'  => $model->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/dokumen_umum/index', $data); // Sesuaikan path view Anda
        $this->view('templates/admin/footer_admin');
    }

    public function create()
    {
        $kategoriModel = $this->model('KategoriArsip');
        $data['kategori_list'] = $kategoriModel->getAllKategori();
        $data['judul_halaman'] = 'Tambah Dokumen';

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/dokumen_umum/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/dokumen_umum");
            exit;
        }

        $nama       = trim($_POST['nama_dokumen'] ?? '');
        $deskripsi  = trim($_POST['deskripsi_dokumen'] ?? '');
        $id_kategori = (int)($_POST['id_kategori_arsip'] ?? 0); // AMBIL KATEGORI
        $id_admin   = $_SESSION['admin_id'] ?? 1;

        if (empty($nama) || empty($deskripsi) || empty($id_kategori)) {
            $_SESSION['error_message'] = "Semua field wajib diisi.";
            header("Location: " . BASE_URL . "/admin/dokumen_umum/create");
            exit;
        }

        include_once __DIR__ . '/../services/FileService.php';
        $file_name = null;

        if (!empty($_FILES['nama_file_dokumen']['name'])) {
            $upload = FileService::uploadFile($_FILES['nama_file_dokumen'], 'dokumen_umum', 'dokumen_');

            if ($upload === false) {
                $_SESSION['error_message'] = "Gagal upload file. Pastikan pdf/doc/docx/zip & max 5MB.";
                header("Location: " . BASE_URL . "/admin/dokumen_umum/create");
                exit;
            }
            $file_name = $upload;
        } else {
            $_SESSION['error_message'] = "File dokumen wajib diupload.";
            header("Location: " . BASE_URL . "/admin/dokumen_umum/create");
            exit;
        }

        $model = $this->model('DokumenUmum');
        $payload = [
            'nama_dokumen'        => $nama,
            'nama_file_dokumen'   => $file_name,
            'deskripsi_dokumen'   => $deskripsi,
            'id_admin_uploader'   => (int)$id_admin,
            'id_kategori_arsip'   => (int)$id_kategori // SIMPAN KATEGORI
        ];

        $ok = $model->insert($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Dokumen berhasil ditambahkan." : "Gagal menambahkan dokumen.";

        header("Location: " . BASE_URL . "/admin/dokumen_umum");
        exit;
    }

    public function edit($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/dokumen_umum");
            exit;
        }

        $model = $this->model('DokumenUmum');
        $row = $model->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Dokumen tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/dokumen_umum");
            exit;
        }

        // AMBIL DATA KATEGORI UNTUK FORM EDIT
        $kategoriModel = $this->model('KategoriArsip');

        $data = [
            'judul_halaman' => 'Edit Dokumen Umum',
            'dokumen' => $row,
            'kategori_list' => $kategoriModel->getAllKategori() // KIRIM KE VIEW
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/dokumen_umum/edit', $data); 
        $this->view('templates/admin/footer_admin');
    }

    public function update($id = null)
    {
        if (!$id || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/dokumen_umum");
            exit;
        }

        $model = $this->model('DokumenUmum');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Dokumen tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/dokumen_umum");
            exit;
        }

        $nama       = trim($_POST['nama_dokumen'] ?? '');
        $deskripsi  = trim($_POST['deskripsi_dokumen'] ?? '');
        $id_kategori = (int)($_POST['id_kategori_arsip'] ?? 0); // AMBIL KATEGORI

        include_once __DIR__ . '/../services/FileService.php';
        $file_name = $existing['nama_file_dokumen'];

        // kalau upload file baru, hapus lama lalu upload baru
        if (!empty($_FILES['nama_file_dokumen']['name'])) {
            FileService::deleteFile($existing['nama_file_dokumen'], 'dokumen_umum');

            $upload = FileService::uploadFile($_FILES['nama_file_dokumen'], 'dokumen_umum', 'dokumen_');
            if ($upload === false) {
                $_SESSION['error_message'] = "Gagal upload file baru.";
                header("Location: " . BASE_URL . "/admin/dokumen_umum/edit/" . $id);
                exit;
            }
            $file_name = $upload;
        }

        $payload = [
            'id_dokumen'         => $id,
            'nama_dokumen'       => $nama,
            'nama_file_dokumen'  => $file_name,
            'deskripsi_dokumen'  => $deskripsi,
            'id_kategori_arsip'  => (int)$id_kategori // UPDATE KATEGORI
        ];

        $ok = $model->update($payload);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Dokumen berhasil diupdate." : "Gagal update dokumen.";

        header("Location: " . BASE_URL . "/admin/dokumen_umum");
        exit;
    }

    public function delete($id = null)
    {
        if (!$id) {
            header("Location: " . BASE_URL . "/admin/dokumen_umum");
            exit;
        }

        $model = $this->model('DokumenUmum');
        $existing = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Dokumen tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/dokumen_umum");
            exit;
        }

        include_once __DIR__ . '/../services/FileService.php';
        if (!empty($existing['nama_file_dokumen'])) {
            FileService::deleteFile($existing['nama_file_dokumen'], 'dokumen_umum');
        }

        $ok = $model->delete($id);

        $_SESSION[$ok ? 'success_message' : 'error_message'] =
            $ok ? "Dokumen berhasil dihapus." : "Gagal menghapus dokumen.";

        header("Location: " . BASE_URL . "/admin/dokumen_umum");
        exit;
    }
}
