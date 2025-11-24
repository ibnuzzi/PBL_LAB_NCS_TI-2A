<?php

class AdminDokumenController extends Controller
{
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    /** INDEX */
    public function index()
    {
        $model = $this->model('Dokumen');

        $data = [
            'judul_halaman' => 'Dokumen Umum - Lab NCS',
            'dokumen_list'  => $model->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/dokumen/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    /** CREATE */
    public function create()
    {
        $data = ['judul_halaman' => 'Tambah Dokumen'];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/dokumen/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    /** STORE */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/dokumen");
            exit;
        }

        $nama       = trim($_POST['nama_dokumen']);
        $deskripsi  = trim($_POST['deskripsi_dokumen']);

        if (empty($nama)) {
            $_SESSION['error_message'] = "Nama dokumen wajib diisi.";
            header("Location: " . BASE_URL . "/admin/dokumen/create");
            exit;
        }

        include_once __DIR__ . '/../services/FileService.php';

        $uploaded = FileService::uploadFile($_FILES['file_dokumen'], 'dokumen_umum', 'dokumen_');

        if ($uploaded === false) {
            $_SESSION['error_message'] = "Gagal upload file. Pastikan format benar & ukuran < 5MB.";
            header("Location: " . BASE_URL . "/admin/dokumen/create");
            exit;
        }

        $model = $this->model('Dokumen');

        $payload = [
            'nama_dokumen'       => $nama,
            'deskripsi_dokumen'  => $deskripsi,
            'nama_file_dokumen'  => $uploaded
        ];

        $model->insert($payload);

        $_SESSION['success_message'] = 'Dokumen berhasil ditambahkan.';
        header("Location: " . BASE_URL . "/admin/dokumen");
        exit;
    }

    /** EDIT */
    public function edit($id)
    {
        $model = $this->model('Dokumen');
        $row   = $model->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Data tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/dokumen");
            exit;
        }

        $data = [
            'judul_halaman' => 'Edit Dokumen',
            'dokumen'       => $row
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/dokumen/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    /** UPDATE */
    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: " . BASE_URL . "/admin/dokumen");
            exit;
        }

        $model     = $this->model('Dokumen');
        $existing  = $model->getById($id);

        if (!$existing) {
            $_SESSION['error_message'] = "Dokumen tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/dokumen");
            exit;
        }

        include_once __DIR__ . '/../services/FileService.php';

        $nama      = trim($_POST['nama_dokumen']);
        $deskripsi = trim($_POST['deskripsi_dokumen']);
        $file_name = $existing['nama_file_dokumen'];

        if (!empty($_FILES['file_dokumen']['name'])) {

            FileService::deleteFile($existing['nama_file_dokumen'], 'dokumen_umum');

            $uploaded = FileService::uploadFile($_FILES['file_dokumen'], 'dokumen_umum', 'dokumen_');

            if ($uploaded !== false) {
                $file_name = $uploaded;
            }
        }

        $payload = [
            'id_dokumen'        => $id,
            'nama_dokumen'      => $nama,
            'deskripsi_dokumen' => $deskripsi,
            'nama_file_dokumen' => $file_name
        ];

        $model->update($payload);

        $_SESSION['success_message'] = "Dokumen berhasil diperbarui.";
        header("Location: " . BASE_URL . "/admin/dokumen");
        exit;
    }

    /** DELETE */
    public function delete($id)
    {
        $model = $this->model('Dokumen');
        $row   = $model->getById($id);

        if (!$row) {
            $_SESSION['error_message'] = "Dokumen tidak ditemukan.";
            header("Location: " . BASE_URL . "/admin/dokumen");
            exit;
        }

        include_once __DIR__ . '/../services/FileService.php';
        FileService::deleteFile($row['nama_file_dokumen'], 'dokumen_umum');

        $model->delete($id);

        $_SESSION['success_message'] = "Dokumen berhasil dihapus.";
        header("Location: " . BASE_URL . "/admin/dokumen");
        exit;
    }
}
