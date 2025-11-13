<?php
// File: /app/controllers/AdminGalleryController.php

class AdminGalleryController extends Controller {
    
    /**
     * Constructor "MIDDLEWARE"
     */
    public function __construct()
    {
        include './app/middleware/AuthMiddleware.php';
        AuthMiddleware::requireAdmin();
    }

    public function index() {
        $galleryModel = $this->model('Gallery');
        $data = [
            'judul_halaman' => 'Gallery - Lab NCS',
            'gallery_list' => $galleryModel->getAll()
        ];

        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/gallery/index', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function create() {
        $data = ['judul_halaman' => 'Upload Foto'];
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/gallery/create', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/admin/gallery');
            exit;
        }

        $judul = trim($_POST['judul_foto'] ?? '');
        $deskripsi = trim($_POST['deskripsi_foto'] ?? '');
        $id_admin = $_SESSION['admin_id'] ?? 1;

        include_once __DIR__ . '/../services/ImageService.php';

        $fileName = null;
        if (!empty($_FILES['file_foto']['name'])) {
            $uploaded = ImageService::uploadImage($_FILES['file_foto'], 'gallery', 'foto_');
            if ($uploaded === false) {
                $_SESSION['error_message'] = 'Gagal mengunggah foto. Pastikan format JPG/PNG/GIF dan ukuran <= 5MB.';
                header('Location: ' . BASE_URL . '/admin/gallery/create');
                exit;
            }
            $fileName = $uploaded;
        }

        $galleryModel = $this->model('Gallery');
        $payload = [
            'nama_file_foto' => $fileName,
            'judul_foto' => $judul,
            'deskripsi_foto' => $deskripsi,
            'id_admin_uploader' => (int)$id_admin
        ];

        $ok = $galleryModel->tambahFoto($payload);
        if ($ok) $_SESSION['success_message'] = 'Foto berhasil diunggah.';
        else $_SESSION['error_message'] = 'Gagal menyimpan data foto.';

        header('Location: ' . BASE_URL . '/admin/gallery');
        exit;
    }

    public function show() {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) { header('Location: ' . BASE_URL . '/admin/gallery'); exit; }

        $galleryModel = $this->model('Gallery');
        $row = $galleryModel->getById($id);
        if (!$row) { $_SESSION['error_message'] = 'Foto tidak ditemukan.'; header('Location: ' . BASE_URL . '/admin/gallery'); exit; }

        $data = ['judul_halaman' => 'Edit Foto', 'foto' => $row];
        $this->view('templates/admin/header_admin', $data);
        $this->view('public/admin/gallery/edit', $data);
        $this->view('templates/admin/footer_admin');
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ' . BASE_URL . '/admin/gallery'); exit; }
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) { header('Location: ' . BASE_URL . '/admin/gallery'); exit; }

        $judul = trim($_POST['judul_foto'] ?? '');
        $deskripsi = trim($_POST['deskripsi_foto'] ?? '');

        include_once __DIR__ . '/../services/ImageService.php';
        $galleryModel = $this->model('Gallery');
        $existing = $galleryModel->getById($id);

        $fileName = $existing['nama_file_foto'] ?? null;
        if (!empty($_FILES['file_foto']['name'])) {
            $replaced = ImageService::replaceImage($existing['nama_file_foto'] ?? null, $_FILES['file_foto'], 'gallery', 'foto_');
            if ($replaced === false) {
                $_SESSION['error_message'] = 'Gagal mengunggah foto baru.';
                header('Location: ' . BASE_URL . '/admin/gallery/edit/' . $id);
                exit;
            }
            $fileName = $replaced;
        }

        $payload = [
            'id_foto' => $id,
            'nama_file_foto' => $fileName,
            'judul_foto' => $judul,
            'deskripsi_foto' => $deskripsi
        ];

        $ok = $galleryModel->updateFoto($payload);
        if ($ok) $_SESSION['success_message'] = 'Foto berhasil diupdate.';
        else $_SESSION['error_message'] = 'Gagal mengupdate foto.';

        header('Location: ' . BASE_URL . '/admin/gallery');
        exit;
    }

    public function delete() {
        $params = func_get_args();
        $id = isset($params[0]) ? (int)$params[0] : 0;
        if ($id <= 0) { header('Location: ' . BASE_URL . '/admin/gallery'); exit; }

        $galleryModel = $this->model('Gallery');
        $existing = $galleryModel->getById($id);
        if (!empty($existing['nama_file_foto'])) {
            include_once __DIR__ . '/../services/ImageService.php';
            ImageService::deleteImage($existing['nama_file_foto'], 'gallery');
        }

        $ok = $galleryModel->hapusFoto($id);
        if ($ok) $_SESSION['success_message'] = 'Foto dihapus.';
        else $_SESSION['error_message'] = 'Gagal menghapus foto.';

        header('Location: ' . BASE_URL . '/admin/gallery');
        exit;
    }
}

?>
